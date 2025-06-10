<?php
/**
 * ไฟล์เชื่อมต่อฐานข้อมูล
 * รองรับทั้ง MySQL และ SQLite
 */

// ตั้งค่าการแสดงข้อผิดพลาด
error_reporting(E_ALL);
ini_set('display_errors', 0); // ปิดการแสดงข้อผิดพลาดใน production

// การตั้งค่าฐานข้อมูล MySQL
$mysql_config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'test_db',
    'port' => 3306,
    'charset' => 'utf8mb4'
];

// ตัวแปรสำหรับติดตามสถานะการเชื่อมต่อ
$con = null;
$pdo = null;
$use_mysql = false;
$use_sqlite = false;
$db_error = '';

// ลองเชื่อมต่อ MySQL ก่อน
try {
    // สร้างการเชื่อมต่อ MySQL
    $con = new mysqli(
        $mysql_config['host'],
        $mysql_config['username'],
        $mysql_config['password'],
        $mysql_config['database'],
        $mysql_config['port']
    );

    // ตรวจสอบการเชื่อมต่อ
    if ($con->connect_error) {
        throw new Exception("MySQL Connection failed: " . $con->connect_error);
    }

    // ตั้งค่า charset
    if (!$con->set_charset($mysql_config['charset'])) {
        throw new Exception("Error loading character set " . $mysql_config['charset']);
    }

    // ตั้งค่า timezone
    $con->query("SET time_zone = '+07:00'");
    $con->query("SET sql_mode = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");

    $use_mysql = true;
    $db_error = '';

} catch (Exception $e) {
    // หากเชื่อมต่อ MySQL ไม่ได้ ให้ลอง SQLite
    $con = null;
    $db_error = $e->getMessage();
    
    try {
        // สร้างโฟลเดอร์ database หากยังไม่มี
        $db_dir = dirname(__FILE__) . '/../database';
        if (!is_dir($db_dir)) {
            mkdir($db_dir, 0755, true);
        }
        
        // เชื่อมต่อ SQLite
        $sqlite_path = $db_dir . '/casino.sqlite';
        $pdo = new PDO('sqlite:' . $sqlite_path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        // เปิดใช้งาน Foreign Keys
        $pdo->exec('PRAGMA foreign_keys = ON');
        
        // สร้างตารางหากยังไม่มี
        createSQLiteTables($pdo);
        
        $use_sqlite = true;
        $db_error = '';
        
    } catch (PDOException $e) {
        $pdo = null;
        $db_error = "SQLite Error: " . $e->getMessage();
        error_log("Database connection failed: " . $e->getMessage());
    }
}

/**
 * ฟังก์ชันสร้างตารางใน SQLite
 */
function createSQLiteTables($pdo) {
    try {
        // ตาราง users
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
                status TEXT DEFAULT 'active' CHECK(status IN ('active', 'inactive', 'banned')),
                failed_attempts INTEGER DEFAULT 0,
                locked_until TEXT NULL,
                last_login TEXT NULL,
                created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TEXT DEFAULT CURRENT_TIMESTAMP
            )
        ");

        // ตาราง settings
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS settings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name_web TEXT DEFAULT 'UFACV9.COM',
                logo_web TEXT DEFAULT 'img/logo.png',
                site_url TEXT DEFAULT 'https://ufacv9.com',
                description TEXT,
                keywords TEXT,
                contact_line TEXT,
                contact_phone TEXT,
                contact_email TEXT,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                updated_at TEXT DEFAULT CURRENT_TIMESTAMP
            )
        ");

        // ตาราง login_logs
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS login_logs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NULL,
                ip_address TEXT NOT NULL,
                user_agent TEXT,
                login_time TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
                status TEXT NOT NULL CHECK(status IN ('success', 'failed')),
                notes TEXT NULL,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
            )
        ");

        // ตาราง remember_tokens
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS remember_tokens (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                token TEXT NOT NULL,
                expires_at TEXT NOT NULL,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                UNIQUE(user_id),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ");

        // ตาราง promotions
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS promotions (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                description TEXT,
                image TEXT,
                bonus_percent INTEGER DEFAULT 0,
                min_deposit REAL DEFAULT 0.00,
                max_bonus REAL DEFAULT 0.00,
                start_date TEXT NOT NULL,
                end_date TEXT NOT NULL,
                terms TEXT,
                status TEXT DEFAULT 'active' CHECK(status IN ('active', 'inactive')),
                category TEXT DEFAULT 'special' CHECK(category IN ('welcome', 'daily', 'cashback', 'special')),
                sort_order INTEGER DEFAULT 0,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                updated_at TEXT DEFAULT CURRENT_TIMESTAMP
            )
        ");

        // เพิ่มข้อมูลเริ่มต้น settings
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM settings");
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result['count'] == 0) {
            $pdo->exec("
                INSERT INTO settings (name_web, description, keywords, contact_line, contact_phone, contact_email) 
                VALUES (
                    'UFACV9.COM', 
                    'ศูนย์รวมสล็อต คาสิโนออนไลน์ที่ดีที่สุด ฝาก-ถอนไวที่สุดในไทย', 
                    'สล็อต, คาสิโน, ออนไลน์, ฝาก-ถอน, เร็ว, ปลอดภัย', 
                    '@ufacv9', 
                    '02-xxx-xxxx', 
                    'support@ufacv9.com'
                )
            ");
        }

        // เพิ่มข้อมูลโปรโมชั่นตัวอย่าง
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM promotions");
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result['count'] == 0) {
            $current_date = date('Y-m-d');
            $end_date_30 = date('Y-m-d', strtotime('+30 days'));
            $end_date_60 = date('Y-m-d', strtotime('+60 days'));
            $end_date_90 = date('Y-m-d', strtotime('+90 days'));
            
            $pdo->exec("
                INSERT INTO promotions (title, description, image, bonus_percent, min_deposit, max_bonus, start_date, end_date, terms, category) 
                VALUES 
                ('โบนัสสมาชิกใหม่ 100%', 'สมัครใหม่วันนี้ รับโบนัสทันที 100% สูงสุด 10,000 บาท', 'img/promo1.jpg', 100, 100, 10000, '$current_date', '$end_date_30', 'เงื่อนไขการถอน: ต้องเทิร์น 15 เท่า', 'welcome'),
                ('โบนัสฝากรายวัน 50%', 'ฝากทุกวันรับโบนัส 50% สูงสุด 5,000 บาท', 'img/promo2.jpg', 50, 200, 5000, '$current_date', '$end_date_60', 'เงื่อนไขการถอน: ต้องเทิร์น 10 เท่า', 'daily'),
                ('คืนยอดเสีย 10%', 'เสียเท่าไหร่ เราคืนให้ 10% ทุกสัปดาห์', 'img/promo3.jpg', 10, 1000, 50000, '$current_date', '$end_date_90', 'คืนยอดเสียทุกวันจันทร์', 'cashback')
            ");
        }

        // สร้าง admin user หากยังไม่มี
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE username = 'admin'");
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result['count'] == 0) {
            $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
            $current_time = date('Y-m-d H:i:s');
            
            $stmt = $pdo->prepare("
                INSERT INTO users (username, password, email, phone, first_name, last_name, bank_name, bank_account, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active', ?)
            ");
            $stmt->execute([
                'admin', 
                $admin_password, 
                'admin@ufacv9.com', 
                '0800000000', 
                'Admin', 
                'System', 
                'SCB', 
                '1234567890', 
                $current_time
            ]);
        }

    } catch (PDOException $e) {
        error_log("SQLite table creation error: " . $e->getMessage());
        throw $e;
    }
}

/**
 * ฟังก์ชันตรวจสอบสถานะการเชื่อมต่อฐานข้อมูล
 */
function getDatabaseStatus() {
    global $use_mysql, $use_sqlite, $db_error;
    
    if ($use_mysql) {
        return ['status' => 'connected', 'type' => 'MySQL', 'error' => ''];
    } elseif ($use_sqlite) {
        return ['status' => 'connected', 'type' => 'SQLite', 'error' => ''];
    } else {
        return ['status' => 'error', 'type' => 'none', 'error' => $db_error];
    }
}

/**
 * ฟังก์ชันปิดการเชื่อมต่อฐานข้อมูล
 */
function closeDatabaseConnection() {
    global $con, $pdo;
    
    if (isset($con) && $con instanceof mysqli) {
        $con->close();
        $con = null;
    }
    
    if (isset($pdo) && $pdo instanceof PDO) {
        $pdo = null;
    }
}

/**
 * ฟังก์ชันสำหรับ execute query แบบ safe
 */
function executeQuery($query, $params = [], $fetch_type = 'all') {
    global $con, $pdo, $use_mysql, $use_sqlite;
    
    try {
        if ($use_mysql && isset($con)) {
            $stmt = $con->prepare($query);
            if ($stmt === false) {
                throw new Exception("Prepare failed: " . $con->error);
            }
            
            if (!empty($params)) {
                $types = str_repeat('s', count($params)); // ใช้ string สำหรับทุก parameter
                $stmt->bind_param($types, ...$params);
            }
            
            $stmt->execute();
            
            if ($fetch_type === 'all') {
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            } elseif ($fetch_type === 'one') {
                $result = $stmt->get_result();
                return $result->fetch_assoc();
            } else {
                return $stmt->affected_rows;
            }
            
        } elseif ($use_sqlite && isset($pdo)) {
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            
            if ($fetch_type === 'all') {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } elseif ($fetch_type === 'one') {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return $stmt->rowCount();
            }
        }
        
    } catch (Exception $e) {
        error_log("Database query error: " . $e->getMessage());
        error_log("Query: " . $query);
        throw $e;
    }
    
    return false;
}

// ลงทะเบียนฟังก์ชันปิดการเชื่อมต่อเมื่อสคริปต์จบ
register_shutdown_function('closeDatabaseConnection');

// สร้างโฟลเดอร์ logs หากยังไม่มี
$logs_dir = dirname(__FILE__) . '/../logs';
if (!is_dir($logs_dir)) {
    mkdir($logs_dir, 0755, true);
}

?>