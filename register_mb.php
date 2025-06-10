<?php
include('./connectdb.php');
session_start();

// ตรวจสอบ CSRF token
if (!isset($_POST['csrf_token']) || empty($_POST['csrf_token'])) {
    die('Security error: Invalid CSRF token');
}

// ดึงการตั้งค่าระบบ
$stmt = $con->prepare("SELECT * FROM setting ORDER BY id DESC LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$key = $row['lineregister'];

// ทำความสะอาดและตรวจสอบข้อมูลที่รับมา
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function validate_phone($phone) {
    return preg_match('/^[0-9]{10}$/', $phone);
}

function validate_bank_account($account) {
    return preg_match('/^[0-9-]{10,15}$/', $account);
}

$password_mb = sanitize_input($_POST["password_mb"]);
$phone_mb = sanitize_input($_POST["phone_mb"]);
$phone_true = sanitize_input($_POST["phone_true"]);
$bank_mb = sanitize_input($_POST["bank_mb"]);
$bankacc_mb = sanitize_input($_POST["bankacc_mb"]);
$name_mb = sanitize_input($_POST["name_mb"]);
$status_mb = sanitize_input($_POST["status_mb"]);
$aff = sanitize_input($_POST["aff"]);
$ip = sanitize_input($_POST["ip"]);
$date_mb = sanitize_input($_POST["date_mb"]);

// ตรวจสอบข้อมูลที่จำเป็น
$errors = [];

if (empty($phone_mb) || !validate_phone($phone_mb)) {
    $errors[] = 'login.php?do=1';
}

if (empty($bank_mb)) {
    $errors[] = 'login.php?do=2';
}

if (empty($bankacc_mb) || !validate_bank_account($bankacc_mb)) {
    $errors[] = 'login.php?do=3';
}

if (empty($phone_true) || !validate_phone($phone_true)) {
    $errors[] = 'login.php?do=4';
}

if (empty($name_mb) || strlen($name_mb) < 2) {
    $errors[] = 'login.php?do=5';
}

if (empty($password_mb) || strlen($password_mb) < 6) {
    $errors[] = 'login.php?do=6';
}

// ถ้ามี error ให้ redirect
if (!empty($errors)) {
    echo "<script>window.location = '{$errors[0]}';</script>";
    exit();
}

// เข้ารหัสรหัสผ่าน
$hashed_password = password_hash($password_mb, PASSWORD_DEFAULT);

try {
    // เริ่ม transaction
    $con->begin_transaction();

    // ตรวจสอบเบอร์ซ้ำ
    $stmt = $con->prepare("SELECT phone_mb FROM member WHERE phone_mb = ?");
    $stmt->bind_param("s", $phone_mb);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        throw new Exception('login.php?do=9');
    }

    // ตรวจสอบบัญชีธนาคารซ้ำ
    $stmt = $con->prepare("SELECT bankacc_mb FROM member WHERE bankacc_mb = ?");
    $stmt->bind_param("s", $bankacc_mb);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        throw new Exception('login.php?do=10');
    }

    // ตรวจสอบชื่อซ้ำ
    $stmt = $con->prepare("SELECT name_mb FROM member WHERE name_mb = ?");
    $stmt->bind_param("s", $name_mb);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        throw new Exception('login.php?do=11');
    }

    // ตรวจสอบ TrueWallet ซ้ำ
    $stmt = $con->prepare("SELECT phone_true FROM member WHERE phone_true = ?");
    $stmt->bind_param("s", $phone_true);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        throw new Exception('login.php?do=12');
    }

    // สร้างสมาชิกใหม่
    $stmt = $con->prepare("
        UPDATE member SET  
            password_mb = ?, 
            phone_mb = ?,
            phone_true = ?,
            bank_mb = ?,
            bankacc_mb = ?,
            name_mb = ?,
            status_mb = ?,
            aff = ?,
            add_mb = 'MEMBER',
            date_mb = ?,
            ip = ?,
            status = 1
        WHERE status = 2 
        ORDER BY id_mb ASC 
        LIMIT 1
    ");

    $stmt->bind_param("sssssssssss", 
        $hashed_password, $phone_mb, $phone_true, $bank_mb, 
        $bankacc_mb, $name_mb, $status_mb, $aff, $date_mb, $ip
    );

    if (!$stmt->execute()) {
        throw new Exception('Database error');
    }

    // ส่งแจ้งเตือน LINE
    if (!empty($key)) {
        $sMessage = "สมาชิกใหม่ \nเบอร์ " . $phone_mb . "\nชื่อ " . $name_mb;
        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . urlencode($sMessage));
        curl_setopt($chOne, CURLOPT_HTTPHEADER, [
            'Content-type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $key
        ]);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($chOne, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($chOne);
        curl_close($chOne);
    }

    // ล็อกอินอัตโนมัติ
    $stmt = $con->prepare("SELECT * FROM member WHERE phone_mb = ?");
    $stmt->bind_param("s", $phone_mb);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // ตรวจสอบรหัสผ่าน
        if (password_verify($password_mb, $row['password_mb'])) {
            // สร้าง session
            session_regenerate_id(true);
            $_SESSION["id_mb"] = $row["id_mb"];
            $_SESSION["username_mb"] = $row["username_mb"];
            $_SESSION["password_mb"] = $row["password_mb"];
            $_SESSION["name_mb"] = $row["name_mb"];
            $_SESSION["bank_mb"] = $row["bank_mb"];
            $_SESSION["bankacc_mb"] = $row["bankacc_mb"];
            $_SESSION["phone_mb"] = $row["phone_mb"];
            $_SESSION["status_mb"] = $row["status_mb"];
            $_SESSION["confirm_mb"] = $row["confirm_mb"];
            $_SESSION["aff"] = $row["aff"];
            $_SESSION["status"] = $row["status"];
            $_SESSION["password_ufa"] = $row["password_ufa"];
            $_SESSION["ip"] = $row["ip"];
            $_SESSION["phone_true"] = $row["phone_true"];
            $_SESSION["login_time"] = time();

            // commit transaction
            $con->commit();

            // เปลี่ยนเส้นทาง
            if ($_SESSION["status_mb"] == "2") {
                header("Location: dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        }
    }

    throw new Exception('Login failed after registration');

} catch (Exception $e) {
    // rollback transaction
    $con->rollback();
    
    if (strpos($e->getMessage(), 'login.php') !== false) {
        echo "<script>window.location = '{$e->getMessage()}';</script>";
    } else {
        echo "<script>
            alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            window.history.back();
        </script>";
    }
    exit();
}
?>