<?php
// สร้างโฟลเดอร์ src หากยังไม่มี
if (!is_dir('./src')) {
    mkdir('./src', 0755, true);
    echo "<p>✓ สร้างโฟลเดอร์ src สำเร็จ</p>";
}

// สร้างไฟล์ db.php
$db_content = file_get_contents('https://raw.githubusercontent.com/user/repo/main/src/db.php'); // ใส่ content ของไฟล์ db.php
file_put_contents('./src/db.php', $db_content);

// สร้างไฟล์ function.php
$function_content = file_get_contents('https://raw.githubusercontent.com/user/repo/main/src/function.php'); // ใส่ content ของไฟล์ function.php
file_put_contents('./src/function.php', $function_content);

echo "<h1>ติดตั้งระบบสำเร็จ!</h1>";
echo "<p><a href='login.php'>ไปหน้าเข้าสู่ระบบ</a></p>";
?>