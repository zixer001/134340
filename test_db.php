<?php
// ไฟล์ทดสอบการเชื่อมต่อฐานข้อมูล
require_once './src/db.php';
require_once './src/function.php';

echo "<h1>ทดสอบระบบฐานข้อมูล</h1>";

// แสดงสถานะการเชื่อมต่อ
$db_status = getDatabaseStatus();
echo "<h2>สถานะการเชื่อมต่อ:</h2>";
echo "<p>ประเภท: " . $db_status['type'] . "</p>";
echo "<p>สถานะ: " . $db_status['status'] . "</p>";
if (!empty($db_status['error'])) {
    echo "<p style='color: red;'>ข้อผิดพลาด: " . $db_status['error'] . "</p>";
}

// แสดงสถานะ debug
echo "<h2>Debug Information:</h2>";
$debug = debugDatabaseStatus();
echo "<pre>" . print_r($debug, true) . "</pre>";

// ทดสอบการสร้างผู้ใช้
echo "<h2>ทดสอบการสร้างผู้ใช้:</h2>";
$test_username = "testuser_" . time();
$test_result = createUser(
    $test_username,
    "testpassword123",
    $test_username . "@test.com",
    "0123456789",
    "Test",
    "User",
    "SCB",
    "1234567890"
);

if ($test_result) {
    echo "<p style='color: green;'>✓ สร้างผู้ใช้ทดสอบสำเร็จ: " . $test_username . "</p>";
    
    // ทดสอบการดึงข้อมูลผู้ใช้
    $user_data = getUserByUsername($test_username);
    if ($user_data) {
        echo "<p style='color: green;'>✓ ดึงข้อมูลผู้ใช้สำเร็จ</p>";
        echo "<pre>" . print_r($user_data, true) . "</pre>";
    } else {
        echo "<p style='color: red;'>✗ ไม่สามารถดึงข้อมูลผู้ใช้ได้</p>";
    }
} else {
    echo "<p style='color: red;'>✗ ไม่สามารถสร้างผู้ใช้ทดสอบได้</p>";
}

// ทดสอบการตรวจสอบผู้ใช้ซ้ำ
echo "<h2>ทดสอบการตรวจสอบข้อมูลซ้ำ:</h2>";
$username_exists = checkUsernameExists("admin");
$email_exists = checkEmailExists("admin@ufacv9.com");

echo "<p>Username 'admin' มีอยู่แล้ว: " . ($username_exists ? "ใช่" : "ไม่") . "</p>";
echo "<p>Email 'admin@ufacv9.com' มีอยู่แล้ว: " . ($email_exists ? "ใช่" : "ไม่") . "</p>";

?>