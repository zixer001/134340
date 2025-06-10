<?php
// เริ่ม session และตั้งค่าความปลอดภัย
session_start();

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// ตรวจสอบและเชื่อมต่อฐานข้อมูลอย่างปลอดภัย
try {
    require_once './src/db.php';
    require_once './src/function.php';
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    http_response_code(500);
    echo "<!DOCTYPE html><html><head><title>Service Unavailable</title></head><body><h1>Service Temporarily Unavailable</h1></body></html>";
    exit();
}

// ฟังก์ชันสำหรับ escape HTML
function escape_html($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// ดึงข้อมูลการตั้งค่าเว็บไซต์
try {
    if (isset($con)) {
        $stmt = $con->prepare("SELECT * FROM setting ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $site_settings = $result->fetch_assoc();
    } else {
        $site_settings = [];
    }
    
    $site_name = escape_html($site_settings['name_web'] ?? 'UFACV9.COM');
    $site_description = escape_html($site_settings['description'] ?? 'ศูนย์รวมสล็อต คาสิโนออนไลน์ที่ดีที่สุด');
    $site_logo = escape_html($site_settings['logo_web'] ?? 'img/logo.png');
    $site_url = escape_html($site_settings['site_url'] ?? 'https://ufacv9.com');
    
} catch (Exception $e) {
    error_log("Settings error: " . $e->getMessage());
    $site_name = 'UFACV9.COM';
    $site_description = 'ศูนย์รวมสล็อต คาสิโนออนไลน์ที่ดีที่สุด';
    $site_logo = 'img/logo.png';
    $site_url = 'https://ufacv9.com';
}

// ดึงข้อมูลโปรโมชั่น
$promotions = [];
try {
    if (isset($con)) {
        $stmt = $con->prepare("
            SELECT id, title, description, image, bonus_percent, min_deposit, 
                   max_bonus, start_date, end_date, terms, status, category 
            FROM promotions 
            WHERE status = 'active' AND start_date <= NOW() AND end_date >= NOW() 
            ORDER BY sort_order ASC, created_at DESC
        ");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $promotions[] = $row;
        }
    }
} catch (Exception $e) {
    error_log("Promotions error: " . $e->getMessage());
    // ใช้ข้อมูลตัวอย่าง
    $promotions = [
        [
            'id' => 1,
            'title' => 'โบนัสสมาชิกใหม่ 100%',
            'description' => 'สมัครใหม่วันนี้ รับโบนัสทันที 100% สูงสุด 10,000 บาท',
            'image' => 'img/promo1.jpg',
            'bonus_percent' => 100,
            'min_deposit' => 100,
            'max_bonus' => 10000,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime('+30 days')),
            'terms' => 'เงื่อนไขการถอน: ต้องเทิร์น 15 เท่า',
            'status' => 'active',
            'category' => 'welcome'
        ],
        [
            'id' => 2,
            'title' => 'โบนัสฝากรายวัน 50%',
            'description' => 'ฝากทุกวันรับโบนัส 50% สูงสุด 5,000 บาท',
            'image' => 'img/promo2.jpg',
            'bonus_percent' => 50,
            'min_deposit' => 200,
            'max_bonus' => 5000,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime('+60 days')),
            'terms' => 'เงื่อนไขการถอน: ต้องเทิร์น 10 เท่า',
            'status' => 'active',
            'category' => 'daily'
        ],
        [
            'id' => 3,
            'title' => 'คืนยอดเสีย 10%',
            'description' => 'เสียเท่าไหร่ เราคืนให้ 10% ทุกสัปดาห์',
            'image' => 'img/promo3.jpg',
            'bonus_percent' => 10,
            'min_deposit' => 1000,
            'max_bonus' => 50000,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime('+90 days')),
            'terms' => 'คืนยอดเสียทุกวันจันทร์',
            'status' => 'active',
            'category' => 'cashback'
        ]
    ];
}

// CSRF Token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <!-- Basic SEO -->
    <title>โปรโมชั่นพิเศษ - <?php echo $site_name; ?> | โบนัสและข้อเสนอพิเศษ</title>
    <meta name="description" content="ดูโปรโมชั่นและโบนัสพิเศษทั้งหมดจาก <?php echo $site_name; ?> โบนัสสมาชิกใหม่ โบนัสฝากรายวัน คืนยอดเสีย และอีกมากมาย">
    <meta name="keywords" content="โปรโมชั่น, โบนัส, สมาชิกใหม่, ฝากรายวัน, คืนยอดเสีย, <?php echo $site_name; ?>">
    
    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="โปรโมชั่นพิเศษ - <?php echo $site_name; ?>">
    <meta property="og:description" content="ดูโปรโมชั่นและโบนัสพิเศษทั้งหมดจาก <?php echo $site_name; ?>">
    <meta property="og:image" content="<?php echo $site_url; ?>/img/promotions-og.jpg">
    <meta property="og:url" content="<?php echo $site_url; ?>/promotions.php">
    
    <!-- Icons -->
    <link rel="icon" type="image/png" href="<?php echo $site_logo; ?>">
    <link rel="canonical" href="<?php echo $site_url; ?>/promotions.php">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #d22f2e;
            --secondary-color: #ff6b35;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --dark-color: #1a1a1a;
            --light-color: #f8f9fa;
            --gradient-bg: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background: var(--dark-color);
            color: #ffffff;
            margin: 0;
            padding: 0;
        }
        
        /* Header */
        .header {
            background: var(--gradient-bg);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .nav-brand img {
            height: 50px;
            width: auto;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 2rem;
        }
        
        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .nav-menu a:hover {
            color: #ffd700;
        }
        
        /* Page Header */
        .page-header {
            background: var(--gradient-bg);
            padding: 4rem 0 2rem;
            text-align: center;
            position: relative;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('img/pattern.png') repeat;
            opacity: 0.1;
        }
        
        .page-header h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .page-header p {
            font-size: 1.2rem;
            margin-bottom: 0;
            opacity: 0.9;
        }
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        /* Promotions Filter */
        .promotions-filter {
            background: #2d2d2d;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .filter-tabs {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .filter-tab {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .filter-tab:hover,
        .filter-tab.active {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Promotions Grid */
        .promotions-section {
            padding: 2rem 0 4rem;
        }
        
        .promotions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        /* Promotion Card */
        .promotion-card {
            background: linear-gradient(145deg, #2d2d2d, #1a1a1a);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }
        
        .promotion-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(210, 47, 46, 0.2);
        }
        
        .promotion-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-bg);
        }
        
        .card-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }
        
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .promotion-card:hover .card-image img {
            transform: scale(1.1);
        }
        
        .bonus-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--gradient-bg);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        
        .card-content {
            padding: 2rem;
        }
        
        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #ffffff;
        }
        
        .card-description {
            color: #b0b0b0;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        .card-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .detail-item {
            text-align: center;
            padding: 1rem;
            background: rgba(255,255,255,0.05);
            border-radius: 10px;
        }
        
        .detail-label {
            font-size: 0.9rem;
            color: #888;
            margin-bottom: 0.5rem;
        }
        
        .detail-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .card-terms {
            background: rgba(255,193,7,0.1);
            border-left: 4px solid #ffc107;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0 10px 10px 0;
        }
        
        .card-terms .terms-title {
            font-weight: 600;
            color: #ffc107;
            margin-bottom: 0.5rem;
        }
        
        .card-terms .terms-text {
            font-size: 0.9rem;
            color: #e0e0e0;
        }
        
        .card-actions {
            display: flex;
            gap: 1rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
        }
        
        .btn-primary {
            background: var(--gradient-bg);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(210, 47, 46, 0.3);
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }
        
        /* Category Badges */
        .category-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .category-welcome {
            background: #28a745;
            color: white;
        }
        
        .category-daily {
            background: #007bff;
            color: white;
        }
        
        .category-cashback {
            background: #ffc107;
            color: #000;
        }
        
        /* Loading States */
        .loading-card {
            background: #2d2d2d;
            border-radius: 20px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 1.5s ease-in-out infinite alternate;
        }
        
        @keyframes pulse {
            from { opacity: 0.6; }
            to { opacity: 1; }
        }
        
        /* No Promotions */
        .no-promotions {
            text-align: center;
            padding: 4rem 2rem;
            color: #888;
        }
        
        .no-promotions i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #555;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }
            
            .promotions-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .filter-tabs {
                gap: 0.5rem;
            }
            
            .filter-tab {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            
            .card-details {
                grid-template-columns: 1fr;
            }
            
            .card-actions {
                flex-direction: column;
            }
            
            .nav-menu {
                display: none;
            }
        }
        
        @media (max-width: 480px) {
            .navbar {
                padding: 0 0.5rem;
            }
            
            .container {
                padding: 0 0.5rem;
            }
            
            .card-content {
                padding: 1.5rem;
            }
        }
        
        /* Animation */
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
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="nav-brand">
                <a href="index.php">
                    <img src="<?php echo $site_logo; ?>" alt="<?php echo $site_name; ?>">
                </a>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php">หน้าแรก</a></li>
                <li><a href="games.php">เกมส์</a></li>
                <li><a href="promotions.php" class="active">โปรโมชั่น</a></li>
                <li><a href="contact.php">ติดต่อ</a></li>
            </ul>
            <div class="nav-actions">
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                    <a href="dashboard.php" class="btn btn-primary">แดชบอร์ด</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline">เข้าสู่ระบบ</a>
                    <a href="register.php" class="btn btn-primary">สมัครสมาชิก</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><i class="fas fa-gift"></i> โปรโมชั่นพิเศษ</h1>
            <p>รับโบนัสและข้อเสนอพิเศษที่ดีที่สุดจาก <?php echo $site_name; ?></p>
        </div>
    </section>

    <!-- Promotions Filter -->
    <section class="promotions-filter">
        <div class="container">
            <div class="filter-tabs">
                <button class="filter-tab active" data-category="all">
                    <i class="fas fa-star"></i> ทั้งหมด
                </button>
                <button class="filter-tab" data-category="welcome">
                    <i class="fas fa-user-plus"></i> สมาชิกใหม่
                </button>
                <button class="filter-tab" data-category="daily">
                    <i class="fas fa-calendar-day"></i> รายวัน
                </button>
                <button class="filter-tab" data-category="cashback">
                    <i class="fas fa-undo"></i> คืนยอดเสีย
                </button>
            </div>
        </div>
    </section>

    <!-- Promotions Section -->
    <section class="promotions-section">
        <div class="container">
            <div class="promotions-grid" id="promotionsGrid">
                <?php if (empty($promotions)): ?>
                    <div class="no-promotions">
                        <i class="fas fa-exclamation-circle"></i>
                        <h3>ไม่มีโปรโมชั่นในขณะนี้</h3>
                        <p>กรุณาติดตาม โปรโมชั่นใหม่ๆ ที่จะมาในเร็วๆ นี้</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($promotions as $promo): ?>
                        <div class="promotion-card fade-in" data-category="<?php echo escape_html($promo['category']); ?>">
                            <div class="card-image">
                                <img src="<?php echo escape_html($promo['image']); ?>" 
                                     alt="<?php echo escape_html($promo['title']); ?>" 
                                     loading="lazy">
                                <div class="bonus-badge">
                                    +<?php echo escape_html($promo['bonus_percent']); ?>%
                                </div>
                                <div class="category-badge category-<?php echo escape_html($promo['category']); ?>">
                                    <?php 
                                    switch($promo['category']) {
                                        case 'welcome': echo 'สมาชิกใหม่'; break;
                                        case 'daily': echo 'รายวัน'; break;
                                        case 'cashback': echo 'คืนยอดเสีย'; break;
                                        default: echo 'พิเศษ'; break;
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="card-content">
                                <h3 class="card-title"><?php echo escape_html($promo['title']); ?></h3>
                                <p class="card-description"><?php echo escape_html($promo['description']); ?></p>
                                
                                <div class="card-details">
                                    <div class="detail-item">
                                        <div class="detail-label">ฝากขั้นต่ำ</div>
                                        <div class="detail-value"><?php echo number_format($promo['min_deposit']); ?> บาท</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">โบนัสสูงสุด</div>
                                        <div class="detail-value"><?php echo number_format($promo['max_bonus']); ?> บาท</div>
                                    </div>
                                </div>
                                
                                <div class="card-terms">
                                    <div class="terms-title">
                                        <i class="fas fa-info-circle"></i> เงื่อนไข
                                    </div>
                                    <div class="terms-text"><?php echo escape_html($promo['terms']); ?></div>
                                </div>
                                
                                <div class="card-actions">
                                    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                                        <button class="btn btn-primary claim-btn" data-promo-id="<?php echo $promo['id']; ?>">
                                            <i class="fas fa-gift"></i> รับโปรโมชั่น
                                        </button>
                                        <a href="#" class="btn btn-outline details-btn" data-promo-id="<?php echo $promo['id']; ?>">
                                            <i class="fas fa-info"></i> รายละเอียด
                                        </a>
                                    <?php else: ?>
                                        <a href="register.php" class="btn btn-primary">
                                            <i class="fas fa-user-plus"></i> สมัครสมาชิก
                                        </a>
                                        <a href="login.php" class="btn btn-outline">
                                            <i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Promotion Details Modal -->
    <div id="promotionModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modalContent">
                <!-- Modal content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // CSRF Token
        window.csrfToken = '<?php echo $csrf_token; ?>';
        
        document.addEventListener('DOMContentLoaded', function() {
            initializePromotions();
        });
        
        function initializePromotions() {
            // Filter functionality
            const filterTabs = document.querySelectorAll('.filter-tab');
            const promotionCards = document.querySelectorAll('.promotion-card');
            
            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Update active tab
                    filterTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Filter cards
                    const category = this.dataset.category;
                    promotionCards.forEach(card => {
                        if (category === 'all' || card.dataset.category === category) {
                            card.style.display = 'block';
                            card.style.animation = 'fadeIn 0.6s ease-out';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
            
            // Claim promotion functionality
            const claimButtons = document.querySelectorAll('.claim-btn');
            claimButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const promoId = this.dataset.promoId;
                    claimPromotion(promoId);
                });
            });
            
            // Details modal functionality
            const detailsButtons = document.querySelectorAll('.details-btn');
            detailsButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const promoId = this.dataset.promoId;
                    showPromotionDetails(promoId);
                });
            });
        }
        
        function claimPromotion(promoId) {
            // Show loading state
            const btn = document.querySelector(`[data-promo-id="${promoId}"].claim-btn`);
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังประมวลผล...';
            btn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                alert('รับโปรโมชั่นสำเร็จ! โบนัสจะเข้าสู่บัญชีของคุณภายใน 5 นาที');
                btn.innerHTML = '<i class="fas fa-check"></i> รับแล้ว';
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-success');
            }, 2000);
            
            // Real implementation would make AJAX call to server
            /*
            fetch('api/claim-promotion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': window.csrfToken
                },
                body: JSON.stringify({ promotion_id: promoId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('รับโปรโมชั่นสำเร็จ!');
                    btn.innerHTML = '<i class="fas fa-check"></i> รับแล้ว';
                } else {
                    alert('เกิดข้อผิดพลาด: ' + data.message);
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('เกิดข้อผิดพลาดในการเชื่อมต่อ');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
            */
        }
        
        function showPromotionDetails(promoId) {
            // Show modal with promotion details
            const modal = document.getElementById('promotionModal');
            const modalContent = document.getElementById('modalContent');
            
            modalContent.innerHTML = `
                <h2>รายละเอียดโปรโมชั่น</h2>
                <div class="loading">กำลังโหลด...</div>
            `;
            
            modal.style.display = 'block';
            
            // Simulate loading details
            setTimeout(() => {
                modalContent.innerHTML = `
                    <h2>รายละเอียดโปรโมชั่น</h2>
                    <p>รายละเอียดเต็มของโปรโมชั่น ID: ${promoId}</p>
                    <ul>
                        <li>เงื่อนไขการรับโปรโมชั่น</li>
                        <li>วิธีการถอนเงิน</li>
                        <li>เกมที่สามารถใช้โปรโมชั่นได้</li>
                        <li>ระยะเวลาการใช้งาน</li>
                    </ul>
                `;
            }, 1000);
        }
        
        // Modal close functionality
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('promotionModal');
            if (e.target === modal || e.target.classList.contains('close')) {
                modal.style.display = 'none';
            }
        });
        
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>