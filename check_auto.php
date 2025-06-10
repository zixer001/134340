<?php
// ไฟล์นี้จะทำงานเป็น cron job เพื่อตรวจสอบการโอนเงินอัตโนมัติ
require_once '../src/db.php';
require_once '../src/function.php';

function checkAutoDeposits() {
    global $use_mysql, $con, $pdo;
    
    try {
        // ดึงรายการการฝากที่รอตรวจสอบ
        $pending_deposits = [];
        
        if ($use_mysql && isset($con)) {
            $result = $con->query("SELECT d.*, b.* FROM deposits d JOIN bank_accounts b ON d.bank_id = b.id WHERE d.deposit_type = 'auto' AND d.status = 'pending' AND d.created_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)");
            while ($row = $result->fetch_assoc()) {
                $pending_deposits[] = $row;
            }
        } elseif ($use_sqlite && isset($pdo)) {
            $stmt = $pdo->query("SELECT d.*, b.* FROM deposits d JOIN bank_accounts b ON d.bank_id = b.id WHERE d.deposit_type = 'auto' AND d.status = 'pending' AND d.created_at > datetime('now', '-30 minutes')");
            $pending_deposits = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        foreach ($pending_deposits as $deposit) {
            // ตรวจสอบกับ API ธนาคาร
            $bank_transactions = checkBankTransactions($deposit);
            
            if ($bank_transactions) {
                processSuccessfulDeposit($deposit['id'], $deposit['amount'], $deposit['user_id']);
            }
        }
        
    } catch (Exception $e) {
        error_log("Auto deposit check error: " . $e->getMessage());
    }
}

function checkBankTransactions($deposit) {
    // ในการใช้งานจริงจะเชื่อมต่อกับ API ธนาคาร
    // สำหรับ demo จะ return true เสมอ
    
    // ตัวอย่างการเชื่อมต่อ API ธนาคาร
    /*
    $api_url = "https://api.bank.com/transactions";
    $headers = [
        'Authorization: Bearer ' . $deposit['api_token'],
        'Content-Type: application/json'
    ];
    
    $data = [
        'account_number' => $deposit['account_number'],
        'amount' => $deposit['amount'],
        'date_from' => date('Y-m-d H:i:s', strtotime($deposit['created_at'])),
        'date_to' => date('Y-m-d H:i:s')
    ];
    
    $response = makeApiRequest($api_url, $data, $headers);
    return $response && isset($response['transactions']);
    */
    
    return true; // Demo: ให้สำเร็จเสมอ
}

function processSuccessfulDeposit($deposit_id, $amount, $user_id) {
    global $use_mysql, $con, $pdo;
    
    try {
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
        
        echo "Processed deposit ID: $deposit_id, Amount: $amount\n";
        
    } catch (Exception $e) {
        if ($use_mysql && isset($con)) {
            $con->rollback();
        } elseif ($use_sqlite && isset($pdo)) {
            $pdo->rollback();
        }
        error_log("Process deposit error: " . $e->getMessage());
    }
}

// เรียกใช้ฟังก์ชันตรวจสอบ
if (php_sapi_name() === 'cli') {
    checkAutoDeposits();
}
?>