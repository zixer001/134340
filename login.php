<?php
session_start();

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// ตรวจสอบและเชื่อมต่อฐานข้อมูล
$db_connected = false;
$error_message = '';
$success_message = '';

// สร้างโฟลเดอร์ src หากยังไม่มี
if (!is_dir('./src')) {
    mkdir('./src', 0755, true);
}

// ตรวจสอบและโหลดไฟล์ฐานข้อมูล
if (file_exists('./src/db.php')) {
    try {
        require_once './src/db.php';
        $db_connected = true;
    } catch (Exception $e) {
        error_log("Database connection error: " . $e->getMessage());
        $error_message = "ระบบฐานข้อมูลไม่พร้อมใช้งาน: " . $e->getMessage();
    }
} else {
    $error_message = "ไม่พบไฟล์ฐานข้อมูล กรุณาติดตั้งระบบก่อน";
}

// ตรวจสอบและโหลดไฟล์ functions
if (file_exists('./src/function.php')) {
    try {
        require_once './src/function.php';
    } catch (Exception $e) {
        error_log("Functions file error: " . $e->getMessage());
        $error_message = "ไม่สามารถโหลดไฟล์ functions ได้: " . $e->getMessage();
    }
} else {
    $error_message = "ไม่พบไฟล์ functions กรุณาติดตั้งระบบก่อน";
}

// ฟังก์ชันสำหรับ escape HTML (สำรอง)
if (!function_exists('escape_html')) {
    function escape_html($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

// ตรวจสอบผู้ใช้ที่ล็อกอินแล้ว
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

// ดึงข้อมูลการตั้งค่าเว็บไซต์
$site_name = 'QBABET';
$site_logo = 'img/logo.png';
$site_url = 'https://ufacv9.com';

if ($db_connected && function_exists('getSiteSettings')) {
    try {
        $settings = getSiteSettings();
        if ($settings) {
            $site_name = escape_html($settings['name_web'] ?? $site_name);
            $site_logo = escape_html($settings['logo_web'] ?? $site_logo);
            $site_url = escape_html($settings['site_url'] ?? $site_url);
        }
    } catch (Exception $e) {
        error_log("Settings error: " . $e->getMessage());
    }
}

// สร้าง CSRF Token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// ประมวลผลการเข้าสู่ระบบ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // ตรวจสอบ CSRF Token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error_message = "Invalid security token. Please try again.";
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember_me = isset($_POST['remember_me']);

        // Validation
        if (empty($username)) {
            $error_message = "กรุณากรอกชื่อผู้ใช้";
        } elseif (empty($password)) {
            $error_message = "กรุณากรอกรหัสผ่าน";
        } elseif (!$db_connected) {
            $error_message = "ระบบฐานข้อมูลไม่พร้อมใช้งาน";
        } elseif (!function_exists('getUserByUsername')) {
            $error_message = "ระบบยังไม่พร้อมใช้งาน กรุณาติดตั้งระบบก่อน";
        } else {
            try {
                // ตรวจสอบผู้ใช้ในฐานข้อมูล
                $user = getUserByUsername($username);
                
                if ($user) {
                    // ตรวจสอบการล็อคบัญชี
                    if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
                        $error_message = "บัญชีถูกล็อค กรุณาลองใหม่ในภายหลัง";
                    } elseif ($user['status'] !== 'active') {
                        $error_message = "บัญชีไม่ได้รับการอนุมัติ กรุณาติดต่อแอดมิน";
                    } elseif (password_verify($password, $user['password'])) {
                        // เข้าสู่ระบบสำเร็จ
                        $_SESSION['user_logged_in'] = true;
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['user_email'] = $user['email'];
                        $_SESSION['user_first_name'] = $user['first_name'];
                        $_SESSION['user_last_name'] = $user['last_name'];
                        $_SESSION['login_time'] = time();
                        
                        // รีเซ็ต failed attempts
                        if (function_exists('resetFailedLogin')) {
                            resetFailedLogin($user['id']);
                        }
                        
                        // บันทึก log การเข้าสู่ระบบ
                        if (function_exists('logLogin')) {
                            $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
                            $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
                            logLogin($user['id'], $ip_address, $user_agent, 'success');
                        }
                        
                        // Redirect
                        $redirect_url = $_SESSION['redirect_after_login'] ?? 'dashboard.php';
                        unset($_SESSION['redirect_after_login']);
                        
                        header("Location: " . $redirect_url);
                        exit();
                        
                    } else {
                        // รหัสผ่านผิด
                        $failed_attempts = $user['failed_attempts'] + 1;
                        
                        if ($failed_attempts >= 5) {
                            $error_message = "พยายามเข้าสู่ระบบผิดเกินกำหนด บัญชีถูกล็อค 15 นาที";
                        } else {
                            $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง (เหลือ " . (5 - $failed_attempts) . " ครั้ง)";
                        }
                        
                        // อัปเดต failed attempts
                        if (function_exists('updateFailedLogin')) {
                            updateFailedLogin($user['id'], $failed_attempts);
                        }
                        
                        // บันทึก log การเข้าสู่ระบบล้มเหลว
                        if (function_exists('logLogin')) {
                            $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
                            $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
                            logLogin($user['id'], $ip_address, $user_agent, 'failed');
                        }
                    }
                } else {
                    $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
                    
                    // บันทึก log การพยายามเข้าสู่ระบบที่ไม่พบผู้ใช้
                    if (function_exists('logLogin')) {
                        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
                        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
                        logLogin(null, $ip_address, $user_agent, 'failed', 'User not found');
                    }
                }
                
            } catch (Exception $e) {
                error_log("Login error: " . $e->getMessage());
                $error_message = "เกิดข้อผิดพลาดในระบบ กรุณาลองใหม่";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <title>เข้าสู่ระบบ - <?php echo $site_name; ?></title>
    <meta name="description" content="เข้าสู่ระบบ <?php echo $site_name; ?> เว็บคาสิโนออนไลน์ชั้นนำ">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Icons -->
    <link rel="icon" type="image/png" href="<?php echo $site_logo; ?>">
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #d22f2e;
            --secondary-color: #ff6b35;
            --dark-color: #1a1a1a;
            --gradient-bg: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background: var(--dark-color);
            color: #ffffff;
            min-height: 100vh;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient-bg);
            opacity: 0.1;
            z-index: -1;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .login-card {
            background: rgba(45, 45, 45, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            max-width: 400px;
            width: 100%;
            overflow: hidden;
        }
        
        .login-header {
            background: var(--gradient-bg);
            padding: 2rem;
            text-align: center;
        }
        
        .logo {
            height: 60px;
            margin-bottom: 1rem;
        }
        
        .login-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: white;
        }
        
        .login-subtitle {
            color: rgba(255,255,255,0.8);
            margin-bottom: 0;
        }
        
        .login-body {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            color: #e0e0e0;
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-control {
            background: rgba(255,255,255,0.1);
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            color: white;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            background: rgba(255,255,255,0.15);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(210, 47, 46, 0.25);
            color: white;
        }
        
        .form-control::placeholder {
            color: rgba(255,255,255,0.5);
        }
        
        .input-group-text {
            background: rgba(255,255,255,0.1);
            border: 2px solid rgba(255,255,255,0.2);
            border-right: none;
            color: #e0e0e0;
            border-radius: 10px 0 0 10px;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #e0e0e0;
            z-index: 10;
        }
        
        .btn-login {
            background: var(--gradient-bg);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(210, 47, 46, 0.3);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 1.5rem;
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #ff6b6b;
            border-left: 4px solid #dc3545;
        }
        
        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: #51cf66;
            border-left: 4px solid #28a745;
        }
        
        .form-check-input {
            background: rgba(255,255,255,0.1);
            border: 2px solid rgba(255,255,255,0.2);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-check-label {
            color: #e0e0e0;
            font-size: 0.9rem;
        }
        
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .register-link a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .db-status {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            z-index: 1000;
        }
        
        .db-status.connected {
            background: rgba(40, 167, 69, 0.9);
            color: white;
        }
        
        .db-status.disconnected {
            background: rgba(220, 53, 69, 0.9);
            color: white;
        }
        
        .install-notice {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.3);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .install-notice a {
            color: #ffc107;
            text-decoration: none;
            font-weight: 600;
        }
        
        .install-notice a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Database Status Indicator -->
    <div class="db-status <?php echo $db_connected ? 'connected' : 'disconnected'; ?>">
        <i class="fas fa-database"></i>
        <?php echo $db_connected ? 'DB Connected' : 'DB Disconnected'; ?>
    </div>
    
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="<?php echo $site_logo; ?>" alt="<?php echo $site_name; ?>" class="logo">
                <h1 class="login-title">เข้าสู่ระบบ</h1>
                <p class="login-subtitle">ยินดีต้อนรับกลับ</p>
            </div>
            
            <div class="login-body">
                <?php if (!$db_connected): ?>
                    <div class="install-notice">
                        <i class="fas fa-exclamation-triangle"></i>
                        ระบบยังไม่พร้อมใช้งาน<br>
                        <a href="install.php">คลิกที่นี่เพื่อติดตั้งระบบ</a>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['registered'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ
                    </div>
                <?php endif; ?>
                
                <form method="POST" id="loginForm">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user"></i> ชื่อผู้ใช้หรืออีเมล
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" name="username" class="form-control" 
                                   placeholder="กรอกชื่อผู้ใช้หรืออีเมล" 
                                   value="<?php echo escape_html($_POST['username'] ?? ''); ?>"
                                   required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock"></i> รหัสผ่าน
                        </label>
                        <div class="input-group position-relative">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" id="password" class="form-control" 
                                   placeholder="กรอกรหัสผ่าน" required>
                            <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                        </div>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">
                            จดจำการเข้าสู่ระบบ
                        </label>
                    </div>
                    
                    <button type="submit" name="login" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ
                    </button>
                </form>
                
                <div class="register-link">
                    ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a><br>
                    <a href="index.php">กลับหน้าแรก</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>