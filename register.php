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

// ลบการประกาศฟังก์ชัน escape_html ออก (ใช้จาก function.php แทน)

// ดึงข้อมูลการตั้งค่าเว็บไซต์
$site_name = 'UFACV9.COM';
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

// ประมวลผลการสมัครสมาชิก
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // ตรวจสอบ CSRF Token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error_message = "Invalid security token. Please try again.";
    } else {
        // รับข้อมูลจากฟอร์ม
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $bank_name = trim($_POST['bank_name'] ?? '');
        $bank_account = trim($_POST['bank_account'] ?? '');
        $accept_terms = isset($_POST['accept_terms']);

        // Validation
        $errors = [];

        if (empty($username)) {
            $errors[] = "กรุณากรอกชื่อผู้ใช้";
        } elseif (strlen($username) < 4) {
            $errors[] = "ชื่อผู้ใช้ต้องมีอย่างน้อย 4 ตัวอักษร";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $errors[] = "ชื่อผู้ใช้ใช้ได้เฉพาะตัวอักษร ตัวเลข และ _";
        }

        if (empty($password)) {
            $errors[] = "กรุณากรอกรหัสผ่าน";
        } elseif (strlen($password) < 6) {
            $errors[] = "รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร";
        }

        if ($password !== $confirm_password) {
            $errors[] = "รหัสผ่านไม่ตรงกัน";
        }

        if (empty($email)) {
            $errors[] = "กรุณากรอกอีเมล";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "รูปแบบอีเมลไม่ถูกต้อง";
        }

        if (empty($phone)) {
            $errors[] = "กรุณากรอกเบอร์โทรศัพท์";
        } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
            $errors[] = "เบอร์โทรศัพท์ต้องเป็นตัวเลข 10 หลัก";
        }

        if (empty($first_name)) {
            $errors[] = "กรุณากรอกชื่อจริง";
        }

        if (empty($last_name)) {
            $errors[] = "กรุณากรอกนามสกุล";
        }

        if (empty($bank_name)) {
            $errors[] = "กรุณาเลือกธนาคาร";
        }

        if (empty($bank_account)) {
            $errors[] = "กรุณากรอกเลขบัญชีธนาคาร";
        } elseif (!preg_match('/^[0-9]{10,12}$/', $bank_account)) {
            $errors[] = "เลขบัญชีธนาคารต้องเป็นตัวเลข 10-12 หลัก";
        }

        if (!$accept_terms) {
            $errors[] = "กรุณายอมรับข้อตกลงและเงื่อนไข";
        }

        // ตรวจสอบข้อมูลซ้ำในฐานข้อมูล
        if (empty($errors) && $db_connected) {
            try {
                if (function_exists('checkUsernameExists') && checkUsernameExists($username)) {
                    $errors[] = "ชื่อผู้ใช้นี้ถูกใช้แล้ว";
                }

                if (function_exists('checkEmailExists') && checkEmailExists($email)) {
                    $errors[] = "อีเมลนี้ถูกใช้แล้ว";
                }

                if (function_exists('checkPhoneExists') && checkPhoneExists($phone)) {
                    $errors[] = "เบอร์โทรศัพท์นี้ถูกใช้แล้ว";
                }
                
            } catch (Exception $e) {
                error_log("Database check error: " . $e->getMessage());
                $errors[] = "เกิดข้อผิดพลาดในระบบ กรุณาลองใหม่";
            }
        }

        // บันทึกข้อมูลหากไม่มีข้อผิดพลาด
        if (empty($errors) && $db_connected && function_exists('createUser')) {
            try {
                if (createUser($username, $password, $email, $phone, $first_name, $last_name, $bank_name, $bank_account)) {
                    $success_message = "สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ";
                    
                    // Redirect ไปหน้า login หลังจาก 3 วินาที
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = 'login.php?registered=1';
                        }, 3000);
                    </script>";
                } else {
                    $error_message = "เกิดข้อผิดพลาดในการสมัครสมาชิก กรุณาลองใหม่";
                }
            } catch (Exception $e) {
                error_log("Registration error: " . $e->getMessage());
                $error_message = "เกิดข้อผิดพลาดในระบบ กรุณาลองใหม่ในภายหลัง";
            }
        } else {
            $error_message = implode("<br>", $errors);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <title>สมัครสมาชิก - <?php echo $site_name; ?></title>
    <meta name="description" content="สมัครสมาชิกฟรี กับ <?php echo $site_name; ?> เว็บคาสิโนออนไลน์ชั้นนำ">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Icons -->
    <link rel="icon" type="image/png" href="<?php echo $site_logo; ?>">
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* สไตล์เดียวกับเดิม */
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
        }
        
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .register-card {
            background: rgba(45, 45, 45, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            max-width: 500px;
            width: 100%;
        }
        
        .register-header {
            background: var(--gradient-bg);
            padding: 2rem;
            text-align: center;
            border-radius: 20px 20px 0 0;
        }
        
        .register-body {
            padding: 2rem;
        }
        
        .form-control {
            background: rgba(255,255,255,0.1);
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            color: white;
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus {
            background: rgba(255,255,255,0.15);
            border-color: var(--primary-color);
            color: white;
        }
        
        .btn-register {
            background: var(--gradient-bg);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            width: 100%;
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
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <h1>สมัครสมาชิก</h1>
                <p>เข้าร่วมกับเราวันนี้</p>
            </div>
            
            <div class="register-body">
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
                        <br><small>กำลังนำไปหน้าเข้าสู่ระบบ...</small>
                    </div>
                <?php endif; ?>
                
                <form method="POST" id="registerForm">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">ชื่อผู้ใช้</label>
                        <input type="text" name="username" class="form-control" 
                               value="<?php echo escape_html($_POST['username'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">รหัสผ่าน</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ยืนยันรหัสผ่าน</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ชื่อจริง</label>
                            <input type="text" name="first_name" class="form-control" 
                                   value="<?php echo escape_html($_POST['first_name'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">นามสกุล</label>
                            <input type="text" name="last_name" class="form-control" 
                                   value="<?php echo escape_html($_POST['last_name'] ?? ''); ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">อีเมล</label>
                        <input type="email" name="email" class="form-control" 
                               value="<?php echo escape_html($_POST['email'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">เบอร์โทรศัพท์</label>
                        <input type="tel" name="phone" class="form-control" 
                               value="<?php echo escape_html($_POST['phone'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ธนาคาร</label>
                        <select name="bank_name" class="form-control" required>
                            <option value="">เลือกธนาคาร</option>
                            <option value="SCB">ไทยพาณิชย์ (SCB)</option>
                            <option value="BBL">กรุงเทพ (BBL)</option>
                            <option value="KTB">กรุงไทย (KTB)</option>
                            <option value="BAY">กรุงศรีอยุธยา (BAY)</option>
                            <option value="KBank">กสิกรไทย (KBank)</option>
                            <option value="TMB">ทหารไทย (TMB)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">เลขบัญชีธนาคาร</label>
                        <input type="text" name="bank_account" class="form-control" 
                               value="<?php echo escape_html($_POST['bank_account'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input type="checkbox" name="accept_terms" class="form-check-input" required>
                        <label class="form-check-label">
                            ยอมรับ <a href="#" style="color: var(--secondary-color);">ข้อตกลงและเงื่อนไข</a>
                        </label>
                    </div>
                    
                    <button type="submit" name="register" class="btn-register">
                        สมัครสมาชิก
                    </button>
                </form>
                
                <div class="text-center mt-3 pt-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
                    มีบัญชีแล้ว? <a href="login.php" style="color: var(--secondary-color);">เข้าสู่ระบบ</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>