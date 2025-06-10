<?php
session_start();

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once '../src/db.php';
require_once '../src/function.php';

$game_code = $_GET['game'] ?? '';
if (empty($game_code)) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ดึงข้อมูลเกม
$game = null;
try {
    if ($use_mysql && isset($con)) {
        $stmt = $con->prepare("SELECT * FROM games WHERE game_code = ? AND is_active = 1");
        $stmt->bind_param("s", $game_code);
        $stmt->execute();
        $result = $stmt->get_result();
        $game = $result->fetch_assoc();
        $stmt->close();
    } elseif ($use_sqlite && isset($pdo)) {
        $stmt = $pdo->prepare("SELECT * FROM games WHERE game_code = ? AND is_active = 1");
        $stmt->execute([$game_code]);
        $game = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    error_log("Error fetching game: " . $e->getMessage());
}

if (!$game) {
    header("Location: index.php");
    exit();
}

// ดึงยอดเงินผู้ใช้
$user_balance = 0;
try {
    if ($use_mysql && isset($con)) {
        $stmt = $con->prepare("SELECT balance FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $user_balance = $user['balance'] ?? 0;
        $stmt->close();
    } elseif ($use_sqlite && isset($pdo)) {
        $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_balance = $user['balance'] ?? 0;
    }
} catch (Exception $e) {
    error_log("Error fetching user balance: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo escape_html($game['game_name']); ?> - Casino</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 100%);
            color: white;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        
        .game-header {
            background: linear-gradient(135deg, #d22f2e 0%, #ff6b35 100%);
            padding: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .game-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
        }
        
        .game-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .balance-display {
            background: rgba(255,255,255,0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .close-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .game-container {
            height: calc(100vh - 60px);
            position: relative;
            overflow: hidden;
        }
        
        #gameCanvas {
            width: 100%;
            height: 100%;
            display: block;
            background: #1a1a1a;
        }
        
        .game-overlay {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.8);
            padding: 1rem 2rem;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .bet-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .bet-btn {
            background: #d22f2e;
            border: none;
            color: white;
            padding: 0.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        
        .bet-input {
            background: #333;
            border: 1px solid #555;
            color: white;
            padding: 0.5rem;
            border-radius: 5px;
            width: 100px;
            text-align: center;
        }
        
        .spin-btn {
            background: linear-gradient(135deg, #d22f2e, #ff6b35);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .spin-btn:hover {
            transform: scale(1.05);
        }
        
        .spin-btn:disabled {
            background: #666;
            cursor: not-allowed;
            transform: none;
        }
        
        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        
        .spinner {
            border: 4px solid #333;
            border-top: 4px solid #d22f2e;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <div class="game-header">
        <h1 class="game-title">
            <i class="fas fa-dice me-2"></i><?php echo escape_html($game['game_name']); ?>
        </h1>
        <div class="game-controls">
            <div class="balance-display">
                <i class="fas fa-wallet me-1"></i>฿<span id="userBalance"><?php echo number_format($user_balance, 2); ?></span>
            </div>
            <button class="close-btn" onclick="window.close()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <div class="game-container">
        <canvas id="gameCanvas"></canvas>
        
        <div class="loading" id="loadingScreen">
            <div class="spinner"></div>
            <p>กำลังโหลดเกม...</p>
        </div>
        
        <div class="game-overlay" id="gameOverlay" style="display: none;">
            <div class="bet-controls">
                <span>เดิมพัน:</span>
                <button class="bet-btn" onclick="adjustBet(-1)">-</button>
                <input type="number" class="bet-input" id="betAmount" value="<?php echo $game['min_bet']; ?>" 
                       min="<?php echo $game['min_bet']; ?>" max="<?php echo $game['max_bet']; ?>">
                <button class="bet-btn" onclick="adjustBet(1)">+</button>
            </div>
            
            <button class="spin-btn" id="spinBtn" onclick="startGame()">
                <i class="fas fa-play me-2"></i>เริ่มเล่น
            </button>
            
            <div id="lastWin" style="display: none;">
                <span class="text-success">ชนะ: ฿<span id="winAmount">0</span></span>
            </div>
        </div>
    </div>

    <script>
        // ตัวแปรเกม
        let gameData = <?php echo json_encode($game); ?>;
        let userBalance = <?php echo $user_balance; ?>;
        let gameSession = null;
        let isPlaying = false;
        
        // เริ่มต้นเกม
        window.onload = function() {
            initializeGame();
        };
        
        function initializeGame() {
            setTimeout(() => {
                document.getElementById('loadingScreen').style.display = 'none';
                document.getElementById('gameOverlay').style.display = 'flex';
                
                // สร้าง session เกม
                createGameSession();
                
                // เริ่มต้น canvas ตามประเภทเกม
                if (gameData.game_type === 'slot') {
                    initSlotGame();
                } else if (gameData.game_type === 'card') {
                    initCardGame();
                } else if (gameData.game_type === 'roulette') {
                    initRouletteGame();
                }
            }, 2000);
        }
        
        function createGameSession() {
            fetch('../api/game_session.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'create',
                    game_code: gameData.game_code,
                    balance_start: userBalance
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    gameSession = data.session_token;
                }
            });
        }
        
        function adjustBet(direction) {
            const betInput = document.getElementById('betAmount');
            let currentBet = parseFloat(betInput.value);
            const minBet = parseFloat(gameData.min_bet);
            const maxBet = parseFloat(gameData.max_bet);
            
            if (direction === 1) {
                currentBet = Math.min(currentBet + minBet, maxBet);
            } else {
                currentBet = Math.max(currentBet - minBet, minBet);
            }
            
            betInput.value = currentBet;
        }
        
        function startGame() {
            if (isPlaying) return;
            
            const betAmount = parseFloat(document.getElementById('betAmount').value);
            
            if (betAmount > userBalance) {
                alert('ยอดเงินไม่เพียงพอ');
                return;
            }
            
            isPlaying = true;
            document.getElementById('spinBtn').disabled = true;
            document.getElementById('spinBtn').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>กำลังเล่น...';
            document.getElementById('lastWin').style.display = 'none';
            
            // เล่นเกมตามประเภท
            if (gameData.game_type === 'slot') {
                playSlot(betAmount);
            } else if (gameData.game_type === 'card') {
                playCard(betAmount);
            } else if (gameData.game_type === 'roulette') {
                playRoulette(betAmount);
            }
        }
        
        function updateBalance(newBalance) {
            userBalance = newBalance;
            document.getElementById('userBalance').textContent = new Intl.NumberFormat('th-TH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(newBalance);
        }
        
        function gameComplete(result) {
            isPlaying = false;
            document.getElementById('spinBtn').disabled = false;
            document.getElementById('spinBtn').innerHTML = '<i class="fas fa-play me-2"></i>เริ่มเล่น';
            
            if (result.win_amount > 0) {
                document.getElementById('winAmount').textContent = new Intl.NumberFormat('th-TH', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(result.win_amount);
                document.getElementById('lastWin').style.display = 'block';
            }
            
            updateBalance(result.balance_after);
        }
        
        // โหลดไฟล์เกมตามประเภท
        function initSlotGame() {
            const script = document.createElement('script');
            script.src = 'slot.js';
            document.head.appendChild(script);
        }
        
        function initCardGame() {
            const script = document.createElement('script');
            script.src = 'card.js';
            document.head.appendChild(script);
        }
        
        function initRouletteGame() {
            const script = document.createElement('script');
            script.src = 'roulette.js';
            document.head.appendChild(script);
        }
    </script>
</body>
</html>