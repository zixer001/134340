<?php
include('./connectdb.php');
session_start();

// ตรวจสอบ method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register.php");
    exit();
}

// ตรวจสอบ CSRF token
if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Security error: Invalid CSRF token');
}

// ดึงการตั้งค่าระบบ
$stmt = $con->prepare("SELECT * FROM setting ORDER BY id DESC LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$key = $row['lineregister'];

// ฟังก์ชันทำความสะอาดข้อมูล
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// ฟังก์ชันตรวจสอบข้อมูล
function validate_phone($phone) {
    return preg_match('/^[0-9]{10}$/', $phone);
}

function validate_bank_account($account) {
    return preg_match('/^[0-9-]{8,15}$/', $account);
}

function validate_password($password) {
    return strlen($password) >= 6;
}

// รับและทำความสะอาดข้อมูล
$endpoint = 'https://wh1439188.ispot.cc'; // แก้ไข: ใช้ = แทน ==
$password_mb = isset($_POST["password_mb"]) ? sanitize_input($_POST["password_mb"]) : '';
$phone_mb = isset($_POST["phone_mb"]) ? sanitize_input($_POST["phone_mb"]) : '';
$phone_true = isset($_POST["phone_true"]) ? sanitize_input($_POST["phone_true"]) : '';
$bank_mb = isset($_POST["bank_mb"]) ? sanitize_input($_POST["bank_mb"]) : '';
$bankacc_mb = isset($_POST["bankacc_mb"]) ? sanitize_input($_POST["bankacc_mb"]) : '';
$status_mb = isset($_POST["status_mb"]) ? sanitize_input($_POST["status_mb"]) : '';
$aff = isset($_POST["aff"]) ? sanitize_input($_POST["aff"]) : '';
$ip = isset($_POST["ip"]) ? sanitize_input($_POST["ip"]) : '';
$date_mb = isset($_POST["date_mb"]) ? sanitize_input($_POST["date_mb"]) : '';

// ตรวจสอบข้อมูลที่จำเป็น
$errors = [];

if (empty($phone_mb) || !validate_phone($phone_mb)) {
    $errors[] = 'register.php?do=1';
}

if (empty($bank_mb)) {
    $errors[] = 'register.php?do=2';
}

if (empty($bankacc_mb) || !validate_bank_account($bankacc_mb)) {
    $errors[] = 'register.php?do=3';
}

if (empty($phone_true) || !validate_phone($phone_true)) {
    $errors[] = 'register.php?do=4';
}

if (empty($password_mb) || !validate_password($password_mb)) {
    $errors[] = 'register.php?do=6';
}

// ถ้ามี error ให้ redirect
if (!empty($errors)) {
    echo "<script>window.location = '{$errors[0]}';</script>";
    exit();
}

// ฟังก์ชันแปลงชื่อธนาคารเป็นรหัส
function getBankCode($bankName) {
    $bankCodes = [
        'ธ.ไทยพาณิชย์' => '010',
        'ธ.กรุงเทพ' => '003',
        'ธ.กสิกรไทย' => '001',
        'ธ.กรุงไทย' => '004',
        'ธ.ทหารไทยธนชาติ' => '007',
        'ธ.กรุงศรีอยุธยา' => '017',
        'ธ.ออมสิน' => '022',
        'ธ.ก.ส.' => '026',
        'ธ.ซีไอเอ็มบีไทย' => '018',
        'ธ.เกียรตินาคินภัทร' => '023',
        'ธ.ทิสโก้' => '029',
        'ธ.ยูโอบี' => '016',
        'ธ.อิสลาม' => '028',
        'ธ.ไอซีบีซี' => '030'
    ];
    
    return isset($bankCodes[trim($bankName)]) ? $bankCodes[trim($bankName)] : null;
}

try {
    // เริ่ม transaction
    $con->begin_transaction();
    
    $name_mb = ''; // ตัวแปรสำหรับเก็บชื่อจากการตรวจสอบบัญชี
    
    // ตรวจสอบบัญชีธนาคาร (ถ้ามี API)
    if (class_exists('Kplus') && file_exists('kbank525698/kplus.Class.php')) {
        require_once 'kbank525698/kplus.Class.php';
        
        $bankCode = getBankCode($bank_mb);
        if ($bankCode) {
            try {
                $api2 = new Kplus($endpoint);
                $json = json_encode($api2->transferVerify($bankCode, $bankacc_mb, '1'));
                $name2 = json_decode($json);
                
                if (isset($name2->error) && strpos($name2->error, 'เลขที่บัญชีปลายทางไม่ถูกต้อง') !== false) {
                    throw new Exception('register.php?do=61');
                }
                
                if (isset($name2->toAccountName)) {
                    $name_mb = sanitize_input($name2->toAccountName);
                }
            } catch (Exception $api_error) {
                // ถ้า API ไม่ตอบสนอง ให้ใช้ชื่อที่ user กรอกเอง
                error_log("Bank API Error: " . $api_error->getMessage());
                $name_mb = isset($_POST["name_mb"]) ? sanitize_input($_POST["name_mb"]) : '';
            }
        }
    }
    
    // ถ้าไม่ได้ชื่อจาก API ให้ใช้ค่าว่าง (อาจต้องให้ user กรอกเอง)
    if (empty($name_mb)) {
        $name_mb = isset($_POST["name_mb"]) ? sanitize_input($_POST["name_mb"]) : '';
        if (empty($name_mb)) {
            throw new Exception('register.php?do=5');
        }
    }
    
    // ตรวจสอบข้อมูลซ้ำ
    
    // ตรวจสอบเบอร์ซ้ำ
    $stmt = $con->prepare("SELECT phone_mb FROM member WHERE phone_mb = ?");
    $stmt->bind_param("s", $phone_mb);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        throw new Exception('register.php?do=9');
    }
    
    // ตรวจสอบบัญชีธนาคารซ้ำ
    $stmt = $con->prepare("SELECT bankacc_mb FROM member WHERE bankacc_mb = ?");
    $stmt->bind_param("s", $bankacc_mb);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        throw new Exception('register.php?do=10');
    }
    
    // ตรวจสอบชื่อซ้ำ
    $stmt = $con->prepare("SELECT name_mb FROM member WHERE name_mb = ?");
    $stmt->bind_param("s", $name_mb);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        throw new Exception('register.php?do=11');
    }
    
    // ตรวจสอบ TrueWallet ซ้ำ
    $stmt = $con->prepare("SELECT phone_true FROM member WHERE phone_true = ?");
    $stmt->bind_param("s", $phone_true);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        throw new Exception('register.php?do=12');
    }
    
    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($password_mb, PASSWORD_DEFAULT);
    
    // อัปเดตข้อมูลสมาชิก (ใช้ slot ว่าง)
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
            creditspin = 0,
            point = 0,
            ip = ?,
            status = 1,
            updated_at = NOW()
        WHERE (phone_mb = '' OR phone_mb IS NULL) 
        ORDER BY id_mb ASC 
        LIMIT 1
    ");
    
    $stmt->bind_param("ssssssssss", 
        $hashed_password, $phone_mb, $phone_true, $bank_mb, 
        $bankacc_mb, $name_mb, $status_mb, $aff, $date_mb, $ip
    );
    
    if (!$stmt->execute() || $stmt->affected_rows == 0) {
        throw new Exception('ไม่สามารถสร้างบัญชีได้ กรุณาลองใหม่อีกครั้ง');
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
        $result_line = curl_exec($chOne);
        
        if (curl_error($chOne)) {
            error_log('LINE Notify Error: ' . curl_error($chOne));
        }
        curl_close($chOne);
    }
    
    // ล็อกอินอัตโนมัติ (สำหรับรหัสผ่านที่เข้ารหัสแล้ว)
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
            $_SESSION["password_mb"] = $row["password_mb"]; // เก็บ hashed password
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
            
            // อัปเดตเวลาล็อกอินล่าสุด
            $update_stmt = $con->prepare("UPDATE member SET last_login = NOW() WHERE id_mb = ?");
            $update_stmt->bind_param("i", $row["id_mb"]);
            $update_stmt->execute();
            
            // commit transaction
            $con->commit();
            
            // เปลี่ยนเส้นทาง
            if ($_SESSION["status_mb"] == "2") {
                header("Location: user/index.php?do=2");
            } else {
                header("Location: index.php");
            }
            exit();
        }
    }
    
    throw new Exception('เกิดข้อผิดพลาดในการล็อกอิน');
    
} catch (Exception $e) {
    // rollback transaction
    $con->rollback();
    
    error_log("Registration error: " . $e->getMessage());
    
    if (strpos($e->getMessage(), 'register.php') !== false) {
        echo "<script>window.location = '{$e->getMessage()}';</script>";
    } else {
        echo "<script>
            alert('เกิดข้อผิดพลาด: {$e->getMessage()}');
            window.history.back();
        </script>";
    }
    exit();
    
} finally {
    // ปิด prepared statements
    if (isset($stmt)) $stmt->close();
    if (isset($update_stmt)) $update_stmt->close();
    $con->close();
}
?>