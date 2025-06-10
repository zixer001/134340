<?php
include('connectdb.php');
session_start();

// ตรวจสอบ method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

// ฟังก์ชันทำความสะอาดข้อมูล
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// ตรวจสอบและทำความสะอาดข้อมูลที่รับมา
$phone_mb = isset($_POST["phone_mb"]) ? sanitize_input($_POST["phone_mb"]) : '';
$bank_mb = isset($_POST["bank_mb"]) ? sanitize_input($_POST["bank_mb"]) : '';
$bankacc_mb = isset($_POST["bankacc_mb"]) ? sanitize_input($_POST["bankacc_mb"]) : '';
$password_mb = isset($_POST["password_mb"]) ? sanitize_input($_POST["password_mb"]) : '';
$password_mb1 = isset($_POST["password_mb1"]) ? sanitize_input($_POST["password_mb1"]) : '';

// ตรวจสอบข้อมูลที่จำเป็น
$errors = [];

if (empty($phone_mb) || !preg_match('/^[0-9]{10}$/', $phone_mb)) {
    $errors[] = 'กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง (10 หลัก)';
}

if (empty($bank_mb)) {
    $errors[] = 'กรุณาเลือกธนาคาร';
}

if (empty($bankacc_mb) || !preg_match('/^[0-9-]{8,15}$/', $bankacc_mb)) {
    $errors[] = 'กรุณากรอกเลขบัญชีธนาคารให้ถูกต้อง';
}

if (empty($password_mb) || strlen($password_mb) < 6) {
    $errors[] = 'กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัวอักษร';
}

if (empty($password_mb1)) {
    $errors[] = 'กรุณากรอกยืนยันรหัสผ่าน';
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
    // ใช้ prepared statement เพื่อป้องกัน SQL injection
    $stmt = $con->prepare("SELECT id_mb, password_mb FROM member WHERE phone_mb = ? AND bank_mb = ? AND bankacc_mb = ?");
    $stmt->bind_param("sss", $phone_mb, $bank_mb, $bankacc_mb);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows != 1) {
        echo "<script>";
        echo "alert('ไม่พบข้อมูลสมาชิก กรุณาตรวจสอบข้อมูลอีกครั้ง');";
        echo "window.location = 'login.php';";
        echo "</script>";
        exit();
    }
    
    // ตรวจสอบรหัสผ่านใหม่ตรงกันหรือไม่
    if ($password_mb !== $password_mb1) {
        echo "<script>";
        echo "alert('รหัสผ่านใหม่และยืนยันรหัสผ่านไม่ตรงกัน');";
        echo "window.location = 'login.php';";
        echo "</script>";
        exit();
    }
    
    // เข้ารหัสรหัสผ่านใหม่
    $hashed_password = password_hash($password_mb, PASSWORD_DEFAULT);
    
    // อัปเดตรหัสผ่าน
    $update_stmt = $con->prepare("UPDATE member SET password_mb = ? WHERE phone_mb = ?");
    $update_stmt->bind_param("ss", $hashed_password, $phone_mb);
    $result9 = $update_stmt->execute();
    
    if ($result9) {
        echo "<script>";
        echo "alert('เปลี่ยนรหัสผ่านสำเร็จ');";
        echo "window.location = 'login.php';";
        echo "</script>";
    } else {
        throw new Exception('ไม่สามารถอัปเดตรหัสผ่านได้');
    }
    
} catch (Exception $e) {
    error_log("Password reset error: " . $e->getMessage());
    echo "<script>";
    echo "alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');";
    echo "window.location = 'login.php';";
    echo "</script>";
} finally {
    // ปิดการเชื่อมต่อ
    if (isset($stmt)) $stmt->close();
    if (isset($update_stmt)) $update_stmt->close();
    $con->close();
}
?>