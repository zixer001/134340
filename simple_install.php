<?php
// ไฟล์ติดตั้งแบบง่าย
echo "<h1>ติดตั้งระบบ</h1>";

// สร้างโฟลเดอร์ src
if (!is_dir('./src')) {
    mkdir('./src', 0755, true);
    echo "<p>✓ สร้างโฟลเดอร์ src</p>";
}

// สร้างไฟล์ database.sqlite
try {
    $pdo = new PDO('sqlite:./database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // สร้างตารางผู้ใช้
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            phone TEXT UNIQUE NOT NULL,
            first_name TEXT NOT NULL,
            last_name TEXT NOT NULL,
            bank_name TEXT NOT NULL,
            bank_account TEXT NOT NULL,
            balance REAL DEFAULT 0.00,
            status TEXT DEFAULT 'active',
            failed_attempts INTEGER DEFAULT 0,
            locked_until TEXT NULL,
            last_login TEXT NULL,
            created_at TEXT NOT NULL
        )
    ");
    
    echo "<p>✓ สร้างตาราง users สำเร็จ</p>";
    
    // สร้างตารางการตั้งค่า
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS settings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name_web TEXT DEFAULT 'UFACV9.COM',
            logo_web TEXT DEFAULT 'img/logo.png',
            site_url TEXT DEFAULT 'https://ufacv9.com',
            description TEXT,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    echo "<p>✓ สร้างตาราง settings สำเร็จ</p>";
    
    // เพิ่มข้อมูลเริ่มต้น
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM settings");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("
            INSERT INTO settings (name_web, description) 
            VALUES ('UFACV9.COM', 'ศูนย์รวมสล็อต คาสิโนออนไลน์ที่ดีที่สุด')
        ");
        echo "<p>✓ เพิ่มข้อมูลเริ่มต้นสำเร็จ</p>";
    }
    
    echo "<h2>✓ ติดตั้งสำเร็จ!</h2>";
    echo "<p><a href='register.php'>ทดสอบสมัครสมาชิก</a> | <a href='login.php'>ทดสอบเข้าสู่ระบบ</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>