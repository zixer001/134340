<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

require_once '../src/db.php';
require_once '../src/function.php';

$input = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user_id'];

try {
    $session_token = $input['session_token'] ?? '';
    $game_code = $input['game_code'] ?? '';
    $bet_amount = floatval($input['bet_amount'] ?? 0);
    $win_amount = floatval($input['win_amount'] ?? 0);
    $result_data = json_encode($input['result_data'] ?? []);
    
    if (empty($session_token) || empty($game_code) || $bet_amount <= 0) {
        throw new Exception('Invalid input data');
    }
    
    // ดึงข้อมูล session
    $session = null;
    if ($use_mysql && isset($con)) {
        $stmt = $con->prepare("SELECT * FROM game_sessions WHERE session_token = ? AND user_id = ? AND is_active = 1");
        $stmt->bind_param("si", $session_token, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $session = $result->fetch_assoc();
        $stmt->close();
    } elseif ($use_sqlite && isset($pdo)) {
        $stmt = $pdo->prepare("SELECT * FROM game_sessions WHERE session_token = ? AND user_id = ? AND is_active = 1");
        $stmt->execute([$session_token, $user_id]);
        $session = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if (!$session) {
        throw new Exception('Invalid session');
    }
    
    // ดึงยอดเงินปัจจุบัน
    $current_balance = 0;
    if ($use_mysql && isset($con)) {
        $stmt = $con->prepare("SELECT balance FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $current_balance = floatval($user['balance'] ?? 0);
        $stmt->close();
    } elseif ($use_sqlite && isset($pdo)) {
        $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $current_balance = floatval($user['balance'] ?? 0);
    }
    
    // ตรวจสอบยอดเงิน
    if ($current_balance < $bet_amount) {
        throw new Exception('Insufficient balance');
    }
    
    // คำนวณยอดเงินใหม่
    $balance_after = $current_balance - $bet_amount + $win_amount;
    
    // เริ่ม transaction
    if ($use_mysql && isset($con)) {
        $con->begin_transaction();
        
        try {
            // อัพเดทยอดเงินผู้ใช้
            $stmt = $con->prepare("UPDATE users SET balance = ? WHERE id = ?");
            $stmt->bind_param("di", $balance_after, $user_id);
            $stmt->execute();
            $stmt->close();
            
            // บันทึกผลเกม
            $stmt = $con->prepare("INSERT INTO game_results (session_id, user_id, game_code, bet_amount, win_amount, result_data, balance_before, balance_after) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissdsdd", $session['id'], $user_id, $game_code, $bet_amount, $win_amount, $result_data, $current_balance, $balance_after);
            $stmt->execute();
            $stmt->close();
            
            // อัพเดท session
            $stmt = $con->prepare("UPDATE game_sessions SET balance_current = ?, total_bet = total_bet + ?, total_win = total_win + ?, spin_count = spin_count + 1 WHERE id = ?");
            $stmt->bind_param("dddi", $balance_after, $bet_amount, $win_amount, $session['id']);
            $stmt->execute();
            $stmt->close();
            
            $con->commit();
            
        } catch (Exception $e) {
            $con->rollback();
            throw $e;
        }
        
    } elseif ($use_sqlite && isset($pdo)) {
        $pdo->beginTransaction();
        
        try {
            // อัพเดทยอดเงินผู้ใช้
            $stmt = $pdo->prepare("UPDATE users SET balance = ? WHERE id = ?");
            $stmt->execute([$balance_after, $user_id]);
            
            // บันทึกผลเกม
            $stmt = $pdo->prepare("INSERT INTO game_results (session_id, user_id, game_code, bet_amount, win_amount, result_data, balance_before, balance_after) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$session['id'], $user_id, $game_code, $bet_amount, $win_amount, $result_data, $current_balance, $balance_after]);
            
            // อัพเดท session
            $stmt = $pdo->prepare("UPDATE game_sessions SET balance_current = ?, total_bet = total_bet + ?, total_win = total_win + ?, spin_count = spin_count + 1 WHERE id = ?");
            $stmt->execute([$balance_after, $bet_amount, $win_amount, $session['id']]);
            
            $pdo->commit();
            
        } catch (Exception $e) {
            $pdo->rollback();
            throw $e;
        }
    }
    
    echo json_encode([
        'status' => 'success',
        'balance_after' => $balance_after,
        'win_amount' => $win_amount,
        'bet_amount' => $bet_amount
    ]);
    
} catch (Exception $e) {
    error_log("Game result error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>