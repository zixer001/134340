<?php
// ไฟล์สำหรับติดตั้งฐานข้อมูล MySQL
header('Content-Type: text/html; charset=utf-8');

// Database configuration
$mysql_config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'ufa888co_pgsoft'
];

echo "<h1>ติดตั้งฐานข้อมูล MySQL - Casino System</h1>";

try {
    // เชื่อมต่อ MySQL (ไม่ระบุ database ก่อน)
    $con = new mysqli($mysql_config['host'], $mysql_config['username'], $mysql_config['password']);
    
    if ($con->connect_error) {
        throw new Exception("Connection failed: " . $con->connect_error);
    }
    
    echo "<p style='color: green;'>✓ เชื่อมต่อ MySQL สำเร็จ</p>";
    
    // สร้างฐานข้อมูล
    $sql = "CREATE DATABASE IF NOT EXISTS `{$mysql_config['database']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if ($con->query($sql)) {
        echo "<p style='color: green;'>✓ สร้างฐานข้อมูล '{$mysql_config['database']}' สำเร็จ</p>";
    } else {
        throw new Exception("Error creating database: " . $con->error);
    }
    
    // เลือกฐานข้อมูล
    $con->select_db($mysql_config['database']);
    echo "<p style='color: green;'>✓ เลือกฐานข้อมูลสำเร็จ</p>";
    
    // สร้างตาราง users
    $sql = "
    CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(50) NOT NULL UNIQUE,
        `password` varchar(255) NOT NULL,
        `email` varchar(100) NOT NULL UNIQUE,
        `phone` varchar(20) NOT NULL UNIQUE,
        `first_name` varchar(50) NOT NULL,
        `last_name` varchar(50) NOT NULL,
        `bank_name` varchar(50) NOT NULL,
        `bank_account` varchar(20) NOT NULL,
        `balance` decimal(10,2) DEFAULT 0.00,
        `status` enum('active','inactive','banned') DEFAULT 'active',
        `failed_attempts` int(11) DEFAULT 0,
        `locked_until` datetime NULL,
        `last_login` datetime NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `idx_username` (`username`),
        KEY `idx_email` (`email`),
        KEY `idx_phone` (`phone`),
        KEY `idx_status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    if ($con->query($sql)) {
        echo "<p style='color: green;'>✓ สร้างตาราง 'users' สำเร็จ</p>";
    } else {
        throw new Exception("Error creating users table: " . $con->error);
    }
    
    // สร้างตาราง settings
    $sql = "
    CREATE TABLE IF NOT EXISTS `settings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name_web` varchar(100) DEFAULT 'UFACV9.COM',
        `logo_web` varchar(255) DEFAULT 'img/logo.png',
        `site_url` varchar(255) DEFAULT 'https://ufacv9.com',
        `description` text,
        `keywords` text,
        `contact_line` varchar(100),
        `contact_phone` varchar(20),
        `contact_email` varchar(100),
        `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    if ($con->query($sql)) {
        echo "<p style='color: green;'>✓ สร้างตาราง 'settings' สำเร็จ</p>";
    } else {
        throw new Exception("Error creating settings table: " . $con->error);
    }
    
    // สร้างตาราง login_logs
    $sql = "
    CREATE TABLE IF NOT EXISTS `login_logs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NULL,
        `ip_address` varchar(45) NOT NULL,
        `user_agent` text,
        `login_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `status` enum('success','failed') NOT NULL,
        `notes` text NULL,
        PRIMARY KEY (`id`),
        KEY `idx_user_id` (`user_id`),
        KEY `idx_login_time` (`login_time`),
        KEY `idx_status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    if ($con->query($sql)) {
        echo "<p style='color: green;'>✓ สร้างตาราง 'login_logs' สำเร็จ</p>";
    } else {
        throw new Exception("Error creating login_logs table: " . $con->error);
    }
    
    // สร้างตาราง remember_tokens
    $sql = "
    CREATE TABLE IF NOT EXISTS `remember_tokens` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `token` varchar(255) NOT NULL,
        `expires_at` datetime NOT NULL,
        `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `idx_user_id` (`user_id`),
        KEY `idx_token` (`token`),
        KEY `idx_expires` (`expires_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    if ($con->query($sql)) {
        echo "<p style='color: green;'>✓ สร้างตาราง 'remember_tokens' สำเร็จ</p>";
    } else {
        throw new Exception("Error creating remember_tokens table: " . $con->error);
    }
    
    // สร้างตาราง promotions
    $sql = "
    CREATE TABLE IF NOT EXISTS `promotions` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `description` text,
        `image` varchar(255),
        `bonus_percent` int(11) DEFAULT 0,
        `min_deposit` decimal(10,2) DEFAULT 0.00,
        `max_bonus` decimal(10,2) DEFAULT 0.00,
        `start_date` date NOT NULL,
        `end_date` date NOT NULL,
        `terms` text,
        `status` enum('active','inactive') DEFAULT 'active',
        `category` enum('welcome','daily','cashback','special') DEFAULT 'special',
        `sort_order` int(11) DEFAULT 0,
        `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `idx_status` (`status`),
        KEY `idx_category` (`category`),
        KEY `idx_dates` (`start_date`, `end_date`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    if ($con->query($sql)) {
        echo "<p style='color: green;'>✓ สร้างตาราง 'promotions' สำเร็จ</p>";
    } else {
        throw new Exception("Error creating promotions table: " . $con->error);
    }

-- เพิ่มใน install_mysql.php
CREATE TABLE IF NOT EXISTS bank_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bank_name VARCHAR(50) NOT NULL,
    bank_code VARCHAR(10) NOT NULL,
    account_number VARCHAR(20) NOT NULL,
    account_name VARCHAR(100) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    daily_limit DECIMAL(10,2) DEFAULT 100000.00,
    current_amount DECIMAL(10,2) DEFAULT 0.00,
    qr_code_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS deposits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    transaction_id VARCHAR(50) UNIQUE NOT NULL,
    deposit_type ENUM('auto', 'slip') NOT NULL,
    bank_id INT,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    slip_image VARCHAR(255),
    reference_code VARCHAR(50),
    auto_response JSON,
    admin_note TEXT,
    processed_by INT,
    processed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (bank_id) REFERENCES bank_accounts(id),
    FOREIGN KEY (processed_by) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS auto_deposit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bank_id INT NOT NULL,
    check_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    transactions_found INT DEFAULT 0,
    api_response JSON,
    status ENUM('success', 'error') DEFAULT 'success',
    error_message TEXT,
    FOREIGN KEY (bank_id) REFERENCES bank_accounts(id)
);

-- Insert ข้อมูลธนาคารเริ่มต้น
INSERT INTO bank_accounts (bank_name, bank_code, account_number, account_name) VALUES
('ธนาคารกรุงไทย', 'KTB', '1234567890', 'บริษัท เกมส์ จำกัด'),
('ธนาคารกสิกรไทย', 'KBANK', '0987654321', 'บริษัท เกมส์ จำกัด'),
('ธนาคารไทยพาณิชย์', 'SCB', '5555666677', 'บริษัท เกมส์ จำกัด'),
('ธนาคารกรุงเทพ', 'BBL', '1111222233', 'บริษัท เกมส์ จำกัด');

-- เพิ่มใน install_mysql.php
CREATE TABLE IF NOT EXISTS games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    game_code VARCHAR(50) NOT NULL UNIQUE,
    game_name VARCHAR(100) NOT NULL,
    game_type ENUM('slot', 'card', 'roulette', 'dice') NOT NULL,
    provider VARCHAR(50) DEFAULT 'internal',
    min_bet DECIMAL(10,2) DEFAULT 1.00,
    max_bet DECIMAL(10,2) DEFAULT 10000.00,
    rtp DECIMAL(5,2) DEFAULT 96.50,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS game_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    game_code VARCHAR(50) NOT NULL,
    session_token VARCHAR(255) NOT NULL UNIQUE,
    balance_start DECIMAL(10,2) NOT NULL,
    balance_current DECIMAL(10,2) NOT NULL,
    total_bet DECIMAL(10,2) DEFAULT 0.00,
    total_win DECIMAL(10,2) DEFAULT 0.00,
    spin_count INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS game_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id INT NOT NULL,
    user_id INT NOT NULL,
    game_code VARCHAR(50) NOT NULL,
    bet_amount DECIMAL(10,2) NOT NULL,
    win_amount DECIMAL(10,2) DEFAULT 0.00,
    result_data JSON,
    balance_before DECIMAL(10,2) NOT NULL,
    balance_after DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (session_id) REFERENCES game_sessions(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert ข้อมูลเกมเริ่มต้น
INSERT INTO games (game_code, game_name, game_type, min_bet, max_bet, rtp) VALUES
('fortune-tiger', 'Fortune Tiger', 'slot', 1.00, 1000.00, 96.81),
('fortune-ox', 'Fortune Ox', 'slot', 1.00, 1000.00, 96.75),
('fortune-dragon', 'Fortune Dragon', 'slot', 1.00, 1000.00, 96.52),
('baccarat-classic', 'Baccarat Classic', 'card', 10.00, 5000.00, 98.94),
('roulette-european', 'European Roulette', 'roulette', 1.00, 500.00, 97.30),
('blackjack-classic', 'Blackjack Classic', 'card', 5.00, 1000.00, 99.41);
    
    // เพิ่มข้อมูลเริ่มต้น settings
    $sql = "
    INSERT IGNORE INTO `settings` (id, name_web, description, keywords, contact_line, contact_phone, contact_email) 
    VALUES (1, 'UFACV9.COM', 'ศูนย์รวมสล็อต คาสิโนออนไลน์ที่ดีที่สุด ฝาก-ถอนไวที่สุดในไทย', 
            'สล็อต, คาสิโน, ออนไลน์, ฝาก-ถอน, เร็ว, ปลอดภัย', '@ufacv9', '02-xxx-xxxx', 'support@ufacv9.com')
    ";
    
    if ($con->query($sql)) {
        echo "<p style='color: green;'>✓ เพิ่มข้อมูลเริ่มต้น 'settings' สำเร็จ</p>";
    } else {
        echo "<p style='color: orange;'>⚠ การเพิ่มข้อมูล settings: " . $con->error . "</p>";
    }
    
    // เพิ่มข้อมูลโปรโมชั่นตัวอย่าง
    $sql = "
    INSERT IGNORE INTO `promotions` (id, title, description, image, bonus_percent, min_deposit, max_bonus, start_date, end_date, terms, category) 
    VALUES 
    (1, 'โบนัสสมาชิกใหม่ 100%', 'สมัครใหม่วันนี้ รับโบนัสทันที 100% สูงสุด 10,000 บาท', 'img/promo1.jpg', 100, 100, 10000, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'เงื่อนไขการถอน: ต้องเทิร์น 15 เท่า', 'welcome'),
    (2, 'โบนัสฝากรายวัน 50%', 'ฝากทุกวันรับโบนัส 50% สูงสุด 5,000 บาท', 'img/promo2.jpg', 50, 200, 5000, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 60 DAY), 'เงื่อนไขการถอน: ต้องเทิร์น 10 เท่า', 'daily'),
    (3, 'คืนยอดเสีย 10%', 'เสียเท่าไหร่ เราคืนให้ 10% ทุกสัปดาห์', 'img/promo3.jpg', 10, 1000, 50000, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 90 DAY), 'คืนยอดเสียทุกวันจันทร์', 'cashback')
    ";
    
    if ($con->query($sql)) {
        echo "<p style='color: green;'>✓ เพิ่มข้อมูลโปรโมชั่นตัวอย่างสำเร็จ</p>";
    } else {
        echo "<p style='color: orange;'>⚠ การเพิ่มข้อมูลโปรโมชั่น: " . $con->error . "</p>";
    }
    
    // สร้าง admin user แบบใหม่ (แก้ไข bind_param)
    $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
    $current_time = date('Y-m-d H:i:s');
    
    $sql = "
    INSERT IGNORE INTO `users` (id, username, password, email, phone, first_name, last_name, bank_name, bank_account, status, created_at) 
    VALUES (1, 'admin', '$admin_password', 'admin@ufacv9.com', '0800000000', 'Admin', 'System', 'SCB', '1234567890', 'active', '$current_time')
    ";
    
    if ($con->query($sql)) {
        echo "<p style='color: green;'>✓ สร้างบัญชี Admin สำเร็จ (username: admin, password: admin123)</p>";
    } else {
        echo "<p style='color: orange;'>⚠ การสร้างบัญชี Admin: " . $con->error . "</p>";
    }
    
    // ทดสอบการสร้างผู้ใช้แบบใหม่
    echo "<br><h2>ทดสอบการสร้างผู้ใช้:</h2>";
    $test_password = password_hash('testpass123', PASSWORD_DEFAULT);
    $test_username = 'testuser_' . time();
    $test_email = $test_username . '@test.com';
    $test_phone = '098' . rand(1000000, 9999999);
    
    $test_sql = "INSERT INTO users (username, password, email, phone, first_name, last_name, bank_name, bank_account, status, created_at) VALUES ('$test_username', '$test_password', '$test_email', '$test_phone', 'Test', 'User', 'BBL', '9876543210', 'active', '$current_time')";
    
    if ($con->query($test_sql)) {
        echo "<p style='color: green;'>✓ สร้างผู้ใช้ทดสอบสำเร็จ: $test_username</p>";
    } else {
        echo "<p style='color: red;'>✗ ไม่สามารถสร้างผู้ใช้ทดสอบได้: " . $con->error . "</p>";
    }
    
    // แสดงจำนวนข้อมูลในแต่ละตาราง
    echo "<br><h2>สรุปข้อมูลในฐานข้อมูล:</h2>";
    
    $tables = ['users', 'settings', 'promotions', 'login_logs', 'remember_tokens'];
    foreach ($tables as $table) {
        $result = $con->query("SELECT COUNT(*) as count FROM $table");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "<p>ตาราง '$table': {$row['count']} รายการ</p>";
        }
    }
    
    // ทดสอบการดึงข้อมูลผู้ใช้
    echo "<br><h2>ทดสอบการดึงข้อมูล:</h2>";
    $result = $con->query("SELECT username, email, first_name, last_name FROM users ORDER BY id LIMIT 5");
    if ($result && $result->num_rows > 0) {
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>Username</th><th>Email</th><th>ชื่อ</th><th>นามสกุล</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<br><h2 style='color: green;'>✓ ติดตั้งฐานข้อมูลเสร็จสมบูรณ์!</h2>";
    echo "<p><a href='test_db.php'>ทดสอบระบบ</a> | <a href='login.php'>ไปหน้าเข้าสู่ระบบ</a> | <a href='register.php'>ไปหน้าสมัครสมาชิก</a></p>";
    
    // สร้างโฟลเดอร์ logs หากยังไม่มี
    if (!is_dir('./logs')) {
        mkdir('./logs', 0755, true);
        echo "<p style='color: green;'>✓ สร้างโฟลเดอร์ logs สำเร็จ</p>";
    }
    
    // สร้างโฟลเดอร์ src หากยังไม่มี
    if (!is_dir('./src')) {
        mkdir('./src', 0755, true);
        echo "<p style='color: green;'>✓ สร้างโฟลเดอร์ src สำเร็จ</p>";
    }
    
    $con->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    if (isset($con)) {
        echo "<p style='color: red;'>MySQL Error Code: " . $con->errno . "</p>";
    }
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background: #f5f5f5;
}
h1, h2 {
    color: #333;
}
p {
    background: white;
    padding: 10px;
    margin: 5px 0;
    border-left: 4px solid #007bff;
    border-radius: 4px;
}
table {
    background: white;
    margin: 10px 0;
    border-collapse: collapse;
}
th, td {
    padding: 8px 12px;
    border: 1px solid #ddd;
}
th {
    background: #f8f9fa;
    font-weight: bold;
}
a {
    color: #007bff;
    text-decoration: none;
    margin-right: 15px;
    padding: 8px 16px;
    background: white;
    border: 1px solid #007bff;
    border-radius: 4px;
    display: inline-block;
}
a:hover {
    background: #007bff;
    color: white;
}
</style>