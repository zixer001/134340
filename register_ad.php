<?php
include('../connectdb.php');
session_start();

// ตรวจสอบ method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

// ตรวจสอบ CSRF token (ถ้ามี)
if (isset($_POST['csrf_token']) && isset($_SESSION['csrf_token'])) {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Security error: Invalid CSRF token');
    }
}

// ฟังก์ชันทำความสะอาดข้อมูล
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// ฟังก์ชันตรวจสอบรูปแบบข้อมูล
function validate_username($username) {
    return preg_match('/^[a-zA-Z0-9_]{4,20}$/', $username);
}

function validate_phone($phone) {
    return preg_match('/^[0-9]{10}$/', $phone);
}

function validate_password($password) {
    return strlen($password) >= 6;
}

// รับและทำความสะอาดข้อมูล
$username_ad = isset($_POST["username_ad"]) ? sanitize_input($_POST["username_ad"]) : '';
$password_ad = isset($_POST["password_ad"]) ? $_POST["password_ad"] : '';
$phone_ad = isset($_POST["phone_ad"]) ? sanitize_input($_POST["phone_ad"]) : '';
$status_ad = isset($_POST["status_ad"]) ? sanitize_input($_POST["status_ad"]) : '';
$name_ad = isset($_POST["name_ad"]) ? sanitize_input($_POST["name_ad"]) : '';

// ตรวจสอบข้อมูลที่จำเป็น
$errors = [];

if (empty($username_ad) || !validate_username($username_ad)) {
    $errors[] = 'กรุณากรอก Username (4-20 ตัวอักษร, a-z, 0-9, _ เท่านั้น)';
}

if (empty($password_ad) || !validate_password($password_ad)) {
    $errors[] = 'กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัวอักษร';
}

if (empty($phone_ad) || !validate_phone($phone_ad)) {
    $errors[] = 'กรุณากรอกเบอร์โทรศัพท์ 10 หลัก';
}

if (empty($name_ad) || strlen($name_ad) < 2) {
    $errors[] = 'กรุณากรอกชื่อ-นามสกุล';
}

if (empty($status_ad)) {
    $errors[] = 'กรุณาเลือกสถานะ';
}

// ถ้ามี error แสดงและหยุดการทำงาน
if (!empty($errors)) {
    echo "<script>";
    echo "alert('" . implode('\\n', $errors) . "');";
    echo "window.location = 'login.php';";
    echo "</script>";
    exit();
}

try {
    // เริ่ม transaction
    $con->begin_transaction();
    
    // ตรวจสอบ username ซ้ำ
    $stmt = $con->prepare("SELECT username_ad FROM admin WHERE username_ad = ?");
    $stmt->bind_param("s", $username_ad);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        throw new Exception('ยูสเซอร์เนมนี้ซ้ำ กรุณาเพิ่มใหม่อีกครั้ง');
    }
    
    // ตรวจสอบเบอร์โทรซ้ำ
    $stmt = $con->prepare("SELECT phone_ad FROM admin WHERE phone_ad = ?");
    $stmt->bind_param("s", $phone_ad);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        throw new Exception('เบอร์โทรศัพท์นี้ซ้ำ กรุณาเพิ่มใหม่อีกครั้ง');
    }
    
    // ตรวจสอบชื่อซ้ำ
    $stmt = $con->prepare("SELECT name_ad FROM admin WHERE name_ad = ?");
    $stmt->bind_param("s", $name_ad);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        throw new Exception('ชื่อ-นามสกุลนี้ซ้ำ กรุณาเพิ่มใหม่อีกครั้ง');
    }
    
    // เข้ารหัสรหัสผ่านด้วย password_hash แทน md5
    $hashed_password = password_hash($password_ad, PASSWORD_DEFAULT);
    
    // สร้างวันที่สร้าง
    $created_at = date('Y-m-d H:i:s');
    
    // เพิ่มข้อมูลแอดมินใหม่
    $stmt = $con->prepare("INSERT INTO admin (username_ad, password_ad, phone_ad, status_ad, name_ad, created_at, last_login) VALUES (?, ?, ?, ?, ?, ?, NULL)");
    $stmt->bind_param("ssssss", $username_ad, $hashed_password, $phone_ad, $status_ad, $name_ad, $created_at);
    
    if (!$stmt->execute()) {
        throw new Exception('ไม่สามารถเพิ่มแอดมินได้');
    }
    
    // commit transaction
    $con->commit();
    
    // บันทึก log การสร้างแอดมิน (ถ้ามีระบบ log)
    error_log("New admin created: $username_ad by " . ($_SESSION['username_ad'] ?? 'system'));
    
    echo "<script>";
    echo "alert('เพิ่มแอดมินสำเร็จ');";
    echo "window.location = 'staff.php';";
    echo "</script>";
    
} catch (Exception $e) {
    // rollback transaction
    $con->rollback();
    
    error_log("Admin registration error: " . $e->getMessage());
    
    echo "<script>";
    echo "alert('" . $e->getMessage() . "');";
    echo "window.location = 'login.php';";
    echo "</script>";
    
} finally {
    // ปิด prepared statements
    if (isset($stmt)) $stmt->close();
    $con->close();
}
?>