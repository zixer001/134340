<?php
session_start();

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

require_once '../src/db.php';
require_once '../src/function.php';

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        
        // ตรวจสอบว่าเป็น JSON หรือ FormData
        if ($input === null) {
            $input = $_POST;
        }
        
        $deposit_type = $input['type'] ?? '';
        $bank_id = intval($input['bank_id'] ?? 0);
        $amount = floatval($input['amount'] ?? 0);
        
        // Validation
        if (empty($deposit_type) || !in_array($deposit_type, ['auto', 'slip'])) {
            throw new Exception('ประเภทการฝากไม่ถูกต้อง');
        }
        
        if ($bank_id <= 0) {
            throw new Exception('กรุณาเลือกธนาคาร');
        }
        
        if ($amount <= 0) {
            throw new Exception('จำนวนเงินไม่ถูกต้อง');
        }
        
        // ตรวจสอบจำนวนเงินขั้นต่ำ
        $min_amount = ($deposit_type === 'auto') ? 100 : 50;
        if ($amount < $min_amount) {
            throw new Exception("จำนวนเงินขั้นต่ำ {$min_amount} บาท");
        }
        
        if ($amount > 50000) {
            throw new Exception('จำนวนเงินสูงสุด 50,000 บาท');
        }
        
        // ตรวจสอบธนาคาร
        $bank = null;
        if ($use_mysql && isset($con)) {
            $stmt = $con->prepare("SELECT * FROM bank_accounts WHERE id = ? AND is_active = 1");
            $stmt->bind_param("i", $bank_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $bank = $result->fetch_assoc();
            $stmt->close();
        } elseif ($use_sqlite && isset($pdo)) {
            $stmt = $pdo->prepare("SELECT * FROM bank_accounts WHERE id = ? AND is_active = 1");
            $stmt->execute([$bank_id]);
            $bank = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        if (!$bank) {
            throw new Exception('ธนาคารที่เลือกไม่ถูกต้อง');
        }
        
        // สร้าง transaction ID
        $transaction_id = 'DEP' . date('YmdHis') . str_pad($user_id, 4, '0', STR_PAD_LEFT);
        
        $slip_image = null;
        
        // จัดการไฟล์สลิป (สำหรับระบบส่งสลิป)
        if ($deposit_type === 'slip') {
            if (!isset($_FILES['slip_file']) || $_FILES['slip_file']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('กรุณาอัพโหลดสลิปโอนเงิน');
            }
            
            $file = $_FILES['slip_file'];
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
            
            if (!in_array($file['type'], $allowed_types)) {
                throw new Exception('รองรับเฉพาะไฟล์ JPG และ PNG');
            }
            
            if ($file['size'] > 5 * 1024 * 1024) { // 5MB
                throw new Exception('ขนาดไฟล์ไม่เกิน 5MB');
            }
            
            // สร้างโฟลเดอร์อัพโหลด
            $upload_dir = '../uploads/slips/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = $transaction_id . '.' . $file_extension;
            $file_path = $upload_dir . $filename;
            
            if (!move_uploaded_file($file['tmp_name'], $file_path)) {
                throw new Exception('ไม่สามารถอัพโหลดไฟล์ได้');
            }
            
            $slip_image = 'uploads/slips/' . $filename;
        }
        
        // บันทึกข้อมูลการฝาก
        if ($use_mysql && isset($con)) {
            $stmt = $con->prepare("INSERT INTO deposits (user_id, transaction_id, deposit_type, bank_id, amount, slip_image, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $status = ($deposit_type === 'auto') ? 'pending' : 'processing';
            $stmt->bind_param("ississs", $user_id, $transaction_id, $deposit_type, $bank_id, $amount, $slip_image, $status);
            $stmt->execute();
            $deposit_id = $con->insert_id;
            $stmt->close();
        } elseif ($use_sqlite && isset($pdo)) {
            $stmt = $pdo->prepare("INSERT INTO deposits (user_id, transaction_id, deposit_type, bank_id, amount, slip_image, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $status = ($deposit_type === 'auto') ? 'pending' : 'processing';
            $stmt->execute([$user_id, $transaction_id, $deposit_type, $bank_id, $amount, $slip_image, $status]);
            $deposit_id = $pdo->lastInsertId();
        }
        
        // หากเป็นระบบ Auto ให้เริ่มตรวจสอบทันที
        if ($deposit_type === 'auto') {
            // สำหรับ demo จะให้สำเร็จทันที
            // ในการใช้งานจริงจะต้องเชื่อมต่อกับ API ธนาคาร
            processAutoDeposit($deposit_id, $amount, $user_id);
        }
        
        echo json_encode([
            'status' => 'success',
            'message' => 'บันทึกข้อมูลเรียบร้อย',
            'transaction_id' => $transaction_id,
            'deposit_id' => $deposit_id
        ]);
        
    } else {
        throw new Exception('Method not allowed');
    }
    
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

function processAutoDeposit($deposit_id, $amount, $user_id) {
    global $use_mysql, $con, $pdo;
    
    try {
        // สำหรับ demo จะให้สำเร็จทันที
        // ในการใช้งานจริงจะต้องเชื่อมต่อกับ API ธนาคารเพื่อตรวจสอบการโอนเงิน
        
        // อัพเดทสถานะเป็นสำเร็จ
        if ($use_mysql && isset($con)) {
            $con->begin_transaction();
            
            // อัพเดทสถานะการฝาก
            $stmt = $con->prepare("UPDATE deposits SET status = 'completed', processed_at = NOW() WHERE id = ?");
            $stmt->bind_param("i", $deposit_id);
            $stmt->execute();
            $stmt->close();
            
            // เพิ่มเครดิตให้ผู้ใช้
            $stmt = $con->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
            $stmt->bind_param("di", $amount, $user_id);
            $stmt->execute();
            $stmt->close();
            
            $con->commit();
            
        } elseif ($use_sqlite && isset($pdo)) {
            $pdo->beginTransaction();
            
            // อัพเดทสถานะการฝาก
            $stmt = $pdo->prepare("UPDATE deposits SET status = 'completed', processed_at = datetime('now') WHERE id = ?");
            $stmt->execute([$deposit_id]);
            
            // เพิ่มเครดิตให้ผู้ใช้
            $stmt = $pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
            $stmt->execute([$amount, $user_id]);
            
            $pdo->commit();
        }
        
    } catch (Exception $e) {
        if ($use_mysql && isset($con)) {
            $con->rollback();
        } elseif ($use_sqlite && isset($pdo)) {
            $pdo->rollback();
        }
        error_log("Auto deposit processing error: " . $e->getMessage());
    }
}
?>