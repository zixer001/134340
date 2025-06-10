<?php
session_start();

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// เชื่อมต่อฐานข้อมูล
require_once './src/db.php';
require_once './src/function.php';

// ดึงข้อมูลผู้ใช้
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$first_name = $_SESSION['user_first_name'] ?? '';
$last_name = $_SESSION['user_last_name'] ?? '';
$full_name = trim($first_name . ' ' . $last_name);

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$user_data = [
    'username' => $username,
    'first_name' => $first_name,
    'last_name' => $last_name,
    'phone' => '098-xxx-xxxx',
    'bank_name' => 'กรุงไทย',
    'bank_account' => '123-4-56789-0',
    'balance' => 15750.50,
    'level' => 'Gold',
    'level_progress' => 75
];

try {
    if ($use_mysql && isset($con)) {
        $stmt = $con->prepare("SELECT first_name, last_name, phone, bank_name, bank_account, balance FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $user_data = array_merge($user_data, $row);
        }
        $stmt->close();
    } elseif ($use_sqlite && isset($pdo)) {
        $stmt = $pdo->prepare("SELECT first_name, last_name, phone, bank_name, bank_account, balance FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user_data = array_merge($user_data, $row);
        }
    }
} catch (Exception $e) {
    error_log("Error fetching user data: " . $e->getMessage());
}

// ดึงการตั้งค่าเว็บไซต์
$site_name = 'QBABET';
if (function_exists('getSiteSettings')) {
    try {
        $settings = getSiteSettings();
        if ($settings) {
            $site_name = $settings['name_web'] ?? $site_name;
        }
    } catch (Exception $e) {
        error_log("Settings error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <title>Dashboard - <?php echo escape_html($site_name); ?></title>
    <meta name="description" content="แดชบอร์ด <?php echo escape_html($site_name); ?>">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #d22f2e;
            --secondary-color: #ff6b35;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --dark-color: #1a1a1a;
            --darker-color: #0f0f0f;
            --card-bg: #2d2d2d;
            --border-color: #444;
            --text-muted: #b0b0b0;
            --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            --shadow: 0 8px 32px rgba(0,0,0,0.3);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Kanit', sans-serif;
            background: linear-gradient(135deg, var(--darker-color) 0%, var(--dark-color) 100%);
            min-height: 100vh;
            color: #ffffff;
            line-height: 1.6;
        }
        
        /* Header */
        .header {
            background: var(--gradient-primary);
            padding: 1rem 0;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .site-logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
        }
        
        .logout-btn {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Main Container */
        .main-container {
            padding: 2rem 0;
            min-height: calc(100vh - 80px);
        }
        
        /* Profile Card */
        .profile-card {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }
        
        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-primary);
        }
        
        /* Profile Image */
        .profile-image-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 3rem;
            color: white;
            border: 4px solid var(--border-color);
            box-shadow: var(--shadow);
            position: relative;
        }
        
        .profile-image::after {
            content: '';
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 20px;
            height: 20px;
            background: var(--success-color);
            border-radius: 50%;
            border: 3px solid var(--card-bg);
        }
        
        /* User Info */
        .user-info {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .username {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }
        
        .user-level {
            display: inline-block;
            background: var(--gradient-primary);
            color: white;
            padding: 0.25rem 1rem;
            border-radius: 15px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        /* User Details */
        .user-details {
            background: rgba(255,255,255,0.05);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            color: var(--text-muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .detail-value {
            color: white;
            font-weight: 600;
        }
        
        .balance-value {
            color: var(--success-color);
            font-size: 1.2rem;
            font-weight: 700;
        }
        
        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .menu-item {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .menu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.6s ease;
        }
        
        .menu-item:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
            box-shadow: var(--shadow);
            color: white;
        }
        
        .menu-item:hover::before {
            left: 100%;
        }
        
        .menu-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
            transition: all 0.3s ease;
        }
        
        .menu-item:hover .menu-icon {
            transform: scale(1.1);
        }
        
        /* Menu Colors */
        .menu-games .menu-icon { background: linear-gradient(135deg, #ff6b35, #f59e0b); }
        .menu-deposit .menu-icon { background: linear-gradient(135deg, #10b981, #059669); }
        .menu-withdraw .menu-icon { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .menu-promotion .menu-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .menu-coupon .menu-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .menu-history .menu-icon { background: linear-gradient(135deg, #6b7280, #4b5563); }
        .menu-cashback .menu-icon { background: linear-gradient(135deg, #ec4899, #db2777); }
        .menu-contact .menu-icon { background: linear-gradient(135deg, #06b6d4, #0891b2); }
        .menu-verify .menu-icon { background: linear-gradient(135deg, #d22f2e, #b91c1c); }
        .menu-settings .menu-icon { background: linear-gradient(135deg, #64748b, #475569); }
        
        .menu-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        
        .menu-desc {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        /* Deposit Modal Specific */
        .deposit-type {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .deposit-type:hover {
            border-color: var(--primary-color);
            background: rgba(210, 47, 46, 0.1);
        }
        
        .deposit-type.active {
            border-color: var(--success-color);
            background: rgba(16, 185, 129, 0.1);
        }
        
        /* Settings specific styles */
        .settings-option {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
        }
        
        .settings-option:hover {
            border-color: var(--primary-color);
            background: rgba(210, 47, 46, 0.1);
            color: white;
        }
        
        .settings-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.25rem;
            color: white;
        }
        
        .settings-content {
            flex: 1;
        }
        
        .settings-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .settings-desc {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .settings-arrow {
            color: var(--text-muted);
            font-size: 1.2rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem 0;
            }
            
            .profile-card {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .profile-image {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
            }
            
            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }
            
            .menu-item {
                padding: 1rem;
            }
            
            .menu-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .slide-up {
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Progress Bar */
        .level-progress {
            background: rgba(255,255,255,0.1);
            height: 6px;
            border-radius: 3px;
            overflow: hidden;
            margin: 0.5rem 0;
        }
        
        .level-progress-bar {
            height: 100%;
            background: var(--gradient-primary);
            border-radius: 3px;
            transition: width 0.6s ease;
        }
        
        .level-text {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="site-logo">
                    <i class="fas fa-gem me-2"></i><?php echo escape_html($site_name); ?>
                </a>
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt me-2"></i>ออกจากระบบ
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <div class="container">
            <!-- Profile Card -->
            <div class="profile-card fade-in">
                <!-- Profile Image -->
                <div class="profile-image-container">
                    <div class="profile-image">
                        <i class="fas fa-user"></i>
                    </div>
                </div>

                <!-- User Info -->
                <div class="user-info">
                    <div class="username"><?php echo escape_html($user_data['username']); ?></div>
                    <div class="user-level">
                        <i class="fas fa-crown me-1"></i>Level <?php echo escape_html($user_data['level']); ?>
                    </div>
                    <div class="level-progress">
                        <div class="level-progress-bar" style="width: <?php echo $user_data['level_progress']; ?>%"></div>
                    </div>
                    <div class="level-text"><?php echo $user_data['level_progress']; ?>% ถึงระดับถัดไป</div>
                </div>

                <!-- User Details -->
                <div class="user-details">
                    <div class="detail-row">
                        <div class="detail-label">
                            <i class="fas fa-user"></i>
                            ชื่อ-นามสกุล
                        </div>
                        <div class="detail-value">
                            <?php echo escape_html(trim($user_data['first_name'] . ' ' . $user_data['last_name']) ?: 'ไม่ระบุ'); ?>
                        </div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-label">
                            <i class="fas fa-phone"></i>
                            เบอร์มือถือ
                        </div>
                        <div class="detail-value">
                            <?php echo escape_html($user_data['phone'] ?: 'ไม่ระบุ'); ?>
                        </div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-label">
                            <i class="fas fa-university"></i>
                            ธนาคาร
                        </div>
                        <div class="detail-value">
                            <?php echo escape_html($user_data['bank_name'] ?: 'ไม่ระบุ'); ?>
                        </div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-label">
                            <i class="fas fa-credit-card"></i>
                            เลขบัญชี
                        </div>
                        <div class="detail-value">
                            <?php echo escape_html($user_data['bank_account'] ?: 'ไม่ระบุ'); ?>
                        </div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-label">
                            <i class="fas fa-wallet"></i>
                            ยอดเครดิตคงเหลือ
                        </div>
                        <div class="detail-value balance-value">
                            ฿<?php echo number_format($user_data['balance'], 2); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Grid -->
            <div class="menu-grid slide-up">
                <!-- เกม -->
                <a href="#" class="menu-item menu-games" onclick="showGames()">
                    <div class="menu-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <div class="menu-title">เกม</div>
                    <div class="menu-desc">สล็อต คาสิโน เกมส์ทั้งหมด</div>
                </a>

                <!-- ฝาก -->
                <a href="deposit.php" class="menu-item menu-deposit" onclick="showDepositModal()">
                    <div class="menu-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div class="menu-title">ฝาก</div>
                    <div class="menu-desc">ระบบ Auto & ส่งสลิป</div>
                </a>

                <!-- ถอน -->
                <a href="#" class="menu-item menu-withdraw" onclick="showWithdraw()">
                    <div class="menu-icon">
                        <i class="fas fa-minus-circle"></i>
                    </div>
                    <div class="menu-title">ถอน</div>
                    <div class="menu-desc">ถอนเงินรางวัล</div>
                </a>

                <!-- โปรโมชั่น -->
                <a href="promotion.php" class="menu-item menu-promotion" onclick="showPromotions()">
                    <div class="menu-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="menu-title">โปรโมชั่น</div>
                    <div class="menu-desc">โบนัสและข้อเสนอพิเศษ</div>
                </a>

                <!-- คูปอง -->
                <a href="#" class="menu-item menu-coupon" onclick="showCouponModal()">
                    <div class="menu-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="menu-title">คูปอง</div>
                    <div class="menu-desc">กรอกรหัสโค้ด</div>
                </a>

                <!-- ประวัติ -->
                <a href="#" class="menu-item menu-history" onclick="showHistory()">
                    <div class="menu-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="menu-title">ประวัติ</div>
                    <div class="menu-desc">ประวัติการเล่นและธุรกรรม</div>
                </a>

                <!-- Cashback -->
                <a href="#" class="menu-item menu-cashback" onclick="showCashback()">
                    <div class="menu-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="menu-title">Cashback</div>
                    <div class="menu-desc">คืนยอดเสีย</div>
                </a>

                <!-- ติดต่อ -->
                <a href="#" class="menu-item menu-contact" onclick="showContact()">
                    <div class="menu-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="menu-title">ติดต่อ</div>
                    <div class="menu-desc">สนับสนุน 24/7</div>
                </a>

                <!-- ยืนยันตัวตน -->
                <a href="#" class="menu-item menu-verify" onclick="showVerification()">
                    <div class="menu-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div class="menu-title">ยืนยันตัวตน</div>
                    <div class="menu-desc">อัพโหลดเอกสาร</div>
                </a>

                <!-- ตั้งค่า (เพิ่มใหม่) -->
                <a href="#" class="menu-item menu-settings" onclick="showSettingsModal()">
                    <div class="menu-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="menu-title">ตั้งค่า</div>
                    <div class="menu-desc">จัดการบัญชีและความปลอดภัย</div>
                </a>
            </div>
        </div>
    </div>

    <!-- Deposit Modal -->
    <div class="modal fade" id="depositModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle text-success me-2"></i>ฝากเงิน
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="deposit-type" onclick="selectDepositType('auto')">
                                <div class="text-center">
                                    <div class="menu-icon mx-auto mb-3" style="background: var(--gradient-primary);">
                                        <i class="fas fa-robot"></i>
                                    </div>
                                    <h6>ระบบ Auto</h6>
                                    <p class="text-muted small mb-0">ฝากอัตโนมัติ เข้าทันที</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="deposit-type" onclick="selectDepositType('slip')">
                                <div class="text-center">
                                    <div class="menu-icon mx-auto mb-3" style="background: linear-gradient(135deg, #10b981, #059669);">
                                        <i class="fas fa-receipt"></i>
                                    </div>
                                    <h6>ส่งสลิป</h6>
                                    <p class="text-muted small mb-0">อัพโหลดสลิปโอนเงิน</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <div class="form-group mb-3">
                            <label class="form-label">จำนวนเงิน (บาท)</label>
                            <input type="number" class="form-control bg-secondary border-0 text-white" placeholder="กรอกจำนวนเงิน" min="100">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">เลือกธนาคาร</label>
                            <select class="form-control bg-secondary border-0 text-white">
                                <option>กรุงไทย (KTB)</option>
                                <option>กสิกรไทย (KBANK)</option>
                                <option>ไทยพาณิชย์ (SCB)</option>
                                <option>กรุงเทพ (BBL)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-check me-2"></i>ยืนยันฝาก
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Coupon Modal -->
    <div class="modal fade" id="couponModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">
                        <i class="fas fa-ticket-alt text-warning me-2"></i>กรอกรหัสคูปอง
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label">รหัสคูปอง</label>
                        <input type="text" class="form-control bg-secondary border-0 text-white" placeholder="กรอกรหัสโค้ด" style="text-transform: uppercase;">
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        กรอกรหัสคูปองที่ได้รับเพื่อรับสิทธิประโยชน์พิเศษ
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-warning">
                        <i class="fas fa-check me-2"></i>ใช้คูปอง
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Modal (เพิ่มใหม่) -->
    <div class="modal fade" id="settingsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">
                        <i class="fas fa-cog text-secondary me-2"></i>ตั้งค่าบัญชี
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <!-- แก้ไขข้อมูลส่วนตัว -->
                            <a href="#" class="settings-option" onclick="editProfile()">
                                <div class="settings-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <div class="settings-content">
                                    <div class="settings-title">แก้ไขข้อมูลส่วนตัว</div>
                                    <div class="settings-desc">เปลี่ยนชื่อ, นามสกุล, เบอร์โทรศัพท์</div>
                                </div>
                                <div class="settings-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>

                            <!-- เปลี่ยนรหัสผ่าน -->
                            <a href="#" class="settings-option" onclick="changePassword()">
                                <div class="settings-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                    <i class="fas fa-key"></i>
                                </div>
                                <div class="settings-content">
                                    <div class="settings-title">เปลี่ยนรหัสผ่าน</div>
                                    <div class="settings-desc">อัพเดตรหัสผ่านเพื่อความปลอดภัย</div>
                                </div>
                                <div class="settings-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>

                            <!-- จัดการธนาคาร -->
                            <a href="#" class="settings-option" onclick="manageBanks()">
                                <div class="settings-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="settings-content">
                                    <div class="settings-title">จัดการบัญชีธนาคาร</div>
                                    <div class="settings-desc">เพิ่ม, แก้ไข, ลบบัญชีธนาคาร</div>
                                </div>
                                <div class="settings-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>

                            <!-- การแจ้งเตือน -->
                            <a href="#" class="settings-option" onclick="notificationSettings()">
                                <div class="settings-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div class="settings-content">
                                    <div class="settings-title">การแจ้งเตือน</div>
                                    <div class="settings-desc">ตั้งค่าการรับแจ้งเตือนต่างๆ</div>
                                </div>
                                <div class="settings-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>

                            <!-- ความปลอดภัย -->
                            <a href="#" class="settings-option" onclick="securitySettings()">
                                <div class="settings-icon" style="background: linear-gradient(135deg, #d22f2e, #b91c1c);">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="settings-content">
                                    <div class="settings-title">ความปลอดภัย</div>
                                    <div class="settings-desc">ตั้งค่า PIN, 2FA และการเข้าสู่ระบบ</div>
                                </div>
                                <div class="settings-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>

                            <!-- ขีดจำกัดการเล่น -->
                            <a href="#" class="settings-option" onclick="playLimits()">
                                <div class="settings-icon" style="background: linear-gradient(135deg, #ec4899, #db2777);">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                                <div class="settings-content">
                                    <div class="settings-title">ขีดจำกัดการเล่น</div>
                                    <div class="settings-desc">ตั้งค่าวงเงินและเวลาการเล่น</div>
                                </div>
                                <div class="settings-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>

                            <!-- เงื่อนไขและข้อตกลง -->
                            <a href="#" class="settings-option" onclick="termsAndConditions()">
                                <div class="settings-icon" style="background: linear-gradient(135deg, #6b7280, #4b5563);">
                                    <i class="fas fa-file-contract"></i>
                                </div>
                                <div class="settings-content">
                                    <div class="settings-title">เงื่อนไขและข้อตกลง</div>
                                    <div class="settings-desc">อ่านเงื่อนไขการใช้งาน</div>
                                </div>
                                <div class="settings-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>

                            <!-- นโยบายความเป็นส่วนตัว -->
                            <a href="#" class="settings-option" onclick="privacyPolicy()">
                                <div class="settings-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="settings-content">
                                    <div class="settings-title">นโยบายความเป็นส่วนตัว</div>
                                    <div class="settings-desc">ข้อมูลการปกป้องข้อมูลส่วนบุคคล</div>
                                </div>
                                <div class="settings-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Deposit Modal Functions
        function showDepositModal() {
            new bootstrap.Modal(document.getElementById('depositModal')).show();
        }
        
        function selectDepositType(type) {
            document.querySelectorAll('.deposit-type').forEach(el => {
                el.classList.remove('active');
            });
            event.target.closest('.deposit-type').classList.add('active');
        }

        // Coupon Modal Functions
        function showCouponModal() {
            new bootstrap.Modal(document.getElementById('couponModal')).show();
        }

        // Settings Modal Functions (เพิ่มใหม่)
        function showSettingsModal() {
            new bootstrap.Modal(document.getElementById('settingsModal')).show();
        }

        function editProfile() {
            alert('เปิดหน้าแก้ไขข้อมูลส่วนตัว');
        }

        function changePassword() {
            alert('เปิดหน้าเปลี่ยนรหัสผ่าน');
        }

        function manageBanks() {
            alert('เปิดหน้าจัดการบัญชีธนาคาร');
        }

        function notificationSettings() {
            alert('เปิดหน้าตั้งค่าการแจ้งเตือน');
        }

        function securitySettings() {
            alert('เปิดหน้าตั้งค่าความปลอดภัย');
        }

        function playLimits() {
            alert('เปิดหน้าตั้งค่าขีดจำกัดการเล่น');
        }

        function termsAndConditions() {
            alert('เปิดหน้าเงื่อนไขและข้อตกลง');
        }

        function privacyPolicy() {
            alert('เปิดหน้านโยบายความเป็นส่วนตัว');
        }

        // Other Menu Functions
        function showGames() {
            alert('เปิดหน้าเกม');
        }

        function showWithdraw() {
            alert('เปิดหน้าถอนเงิน');
        }

        function showPromotions() {
            alert('เปิดหน้าโปรโมชั่น');
        }

        function showHistory() {
            alert('เปิดหน้าประวัติ');
        }

        function showCashback() {
            alert('เปิดหน้า Cashback');
        }

        function showContact() {
            alert('เปิดหน้าติดต่อ');
        }

        function showVerification() {
            alert('เปิดหน้ายืนยันตัวตน');
        }
    </script>
</body>
</html>