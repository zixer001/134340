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
$action = $input['action'] ?? '';
$user_id = $_SESSION['user_id'];

try {
    if ($action === 'create') {
        $game_code = $input['game_code'] ?? '';
        $balance_start = floatval($input['balance_start'] ?? 0);
        
        if (empty($game_code)) {
            throw new Exception('Game code is required');
        }
        
        // สร้าง session token
        $session_token = bin2hex(random_bytes(32));
        
        if ($use_mysql && isset($con)) {
            $stmt = $con->prepare("INSERT INTO game_sessions (user_id, game_code, session_token, balance_start, balance_current) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issdd", $user_id, $game_code, $session_token, $balance_start, $balance_start);
            $stmt->execute();
            $session_id = $con->insert_id;
            $stmt->close();
        } elseif ($use_sqlite && isset($pdo)) {
            $stmt = $pdo->prepare("INSERT INTO game_sessions (user_id, game_code, session_token, balance_start, balance_current) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $game_code, $session_token, $balance_start, $balance_start]);
            $session_id = $pdo->lastInsertId();
        }
        
        echo json_encode([
            'status' => 'success',
            'session_id' => $session_id,
            'session_token' => $session_token
        ]);
        
    } elseif ($action === 'end') {
        $session_token = $input['session_token'] ?? '';
        
        if ($use_mysql && isset($con)) {
            $stmt = $con->prepare("UPDATE game_sessions SET is_active = 0 WHERE session_token = ? AND user_id = ?");
            $stmt->bind_param("si", $session_token, $user_id);
            $stmt->execute();
            $stmt->close();
        } elseif ($use_sqlite && isset($pdo)) {
            $stmt = $pdo->prepare("UPDATE game_sessions SET is_active = 0 WHERE session_token = ? AND user_id = ?");
            $stmt->execute([$session_token, $user_id]);
        }
        
        echo json_encode(['status' => 'success']);
    }
    
} catch (Exception $e) {
    error_log("Game session error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>