<?php
session_start();

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once '../src/db.php';
require_once '../src/function.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// ดึงข้อมูลธนาคาร
$banks = [];
try {
    if ($use_mysql && isset($con)) {
        $result = $con->query("SELECT * FROM bank_accounts WHERE is_active = 1 ORDER BY bank_name");
        while ($row = $result->fetch_assoc()) {
            $banks[] = $row;
        }
    } elseif ($use_sqlite && isset($pdo)) {
        $stmt = $pdo->query("SELECT * FROM bank_accounts WHERE is_active = 1 ORDER BY bank_name");
        $banks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    error_log("Error fetching banks: " . $e->getMessage());
}

// ดึงประวัติการฝากล่าสุด
$recent_deposits = [];
try {
    if ($use_mysql && isset($con)) {
        $stmt = $con->prepare("SELECT d.*, b.bank_name FROM deposits d LEFT JOIN bank_accounts b ON d.bank_id = b.id WHERE d.user_id = ? ORDER BY d.created_at DESC LIMIT 5");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $recent_deposits[] = $row;
        }
        $stmt->close();
    } elseif ($use_sqlite && isset($pdo)) {
        $stmt = $pdo->prepare("SELECT d.*, b.bank_name FROM deposits d LEFT JOIN bank_accounts b ON d.bank_id = b.id WHERE d.user_id = ? ORDER BY d.created_at DESC LIMIT 5");
        $stmt->execute([$user_id]);
        $recent_deposits = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    error_log("Error fetching deposits: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ฝากเงิน - Casino</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 100%);
            color: white;
            min-height: 100vh;
        }
        
        .header {
            background: linear-gradient(135deg, #d22f2e 0%, #ff6b35 100%);
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        
        .back-btn {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .deposit-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }
        
        .method-card {
            background: #2d2d2d;
            border: 2px solid #444;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .method-card:hover {
            border-color: #d22f2e;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(210, 47, 46, 0.2);
        }
        
        .method-card.active {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.1);
        }
        
        .method-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }
        
        .auto-icon {
            background: linear-gradient(135deg, #d22f2e, #ff6b35);
        }
        
        .slip-icon {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        
        .method-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .method-desc {
            color: #b0b0b0;
            margin-bottom: 1.5rem;
        }
        
        .method-features {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .method-features li {
            padding: 0.5rem 0;
            color: #10b981;
        }
        
        .method-features li i {
            margin-right: 0.5rem;
        }
        
        .deposit-form {
            background: #2d2d2d;
            border: 2px solid #444;
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
            display: none;
        }
        
        .deposit-form.active {
            display: block;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: white;
        }
        
        .form-control {
            background: #333;
            border: 2px solid #555;
            color: white;
            border-radius: 10px;
            padding: 0.75rem;
        }
        
        .form-control:focus {
            background: #333;
            border-color: #d22f2e;
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(210, 47, 46, 0.25);
        }
        
        .btn-deposit {
            background: linear-gradient(135deg, #d22f2e, #ff6b35);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-deposit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(210, 47, 46, 0.4);
        }
        
        .bank-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .bank-card {
            background: #333;
            border: 2px solid #555;
            border-radius: 15px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .bank-card:hover {
            border-color: #d22f2e;
        }
        
        .bank-card.selected {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.1);
        }
        
        .bank-logo {
            width: 60px;
            height: 60px;
            background: #666;
            border-radius: 10px;
            margin: 0 auto 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .recent-deposits {
            background: #2d2d2d;
            border: 2px solid #444;
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
        }
        
        .deposit-item {
            background: #333;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-pending { background: #f59e0b; color: #000; }
        .status-processing { background: #3b82f6; }
        .status-completed { background: #10b981; }
        .status-failed { background: #ef4444; }
        
        .upload-area {
            border: 2px dashed #555;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .upload-area:hover {
            border-color: #d22f2e;
            background: rgba(210, 47, 46, 0.1);
        }
        
        .upload-area.dragover {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.1);
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-plus-circle me-2"></i>ฝากเงิน</h1>
                <a href="../dashboard.php" class="back-btn">
                    <i class="fas fa-arrow-left me-2"></i>กลับหน้าหลัก
                </a>
            </div>
        </div>
    </div>

    <div class="container my-4">
        <!-- เลือกวิธีฝาก -->
        <div class="deposit-methods">
            <div class="method-card" id="autoMethod" onclick="selectMethod('auto')">
                <div class="method-icon auto-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="method-title">ระบบ Auto</div>
                <div class="method-desc">ฝากเงินอัตโนมัติ เข้าทันที</div>
                <ul class="method-features">
                    <li><i class="fas fa-check"></i>เข้าทันที ภายใน 1 นาที</li>
                    <li><i class="fas fa-check"></i>ตรวจสอบอัตโนมัติ 24/7</li>
                    <li><i class="fas fa-check"></i>ไม่ต้องส่งสลิป</li>
                    <li><i class="fas fa-check"></i>ขั้นต่ำ 100 บาท</li>
                </ul>
            </div>

            <div class="method-card" id="slipMethod" onclick="selectMethod('slip')">
                <div class="method-icon slip-icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="method-title">ส่งสลิป</div>
                <div class="method-desc">อัพโหลดสลิปโอนเงิน</div>
                <ul class="method-features">
                    <li><i class="fas fa-check"></i>รองรับทุกธนาคาร</li>
                    <li><i class="fas fa-check"></i>ตรวจสอบภายใน 5 นาที</li>
                    <li><i class="fas fa-check"></i>อัพโหลดภาพสลิป</li>
                    <li><i class="fas fa-check"></i>ขั้นต่ำ 50 บาท</li>
                </ul>
            </div>
        </div>

        <!-- ฟอร์มฝาก Auto -->
        <div class="deposit-form" id="autoForm">
            <h3><i class="fas fa-robot me-2"></i>ฝากเงินระบบ Auto</h3>
            <form id="autoDepositForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">จำนวนเงิน (บาท)</label>
                        <input type="number" class="form-control" id="autoAmount" min="100" max="50000" required>
                        <div class="form-text text-muted">ขั้นต่ำ 100 บาท - สูงสุด 50,000 บาท</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">เลือกธนาคาร</label>
                        <div class="bank-grid">
                            <?php foreach ($banks as $bank): ?>
                                <div class="bank-card" onclick="selectBank(<?php echo $bank['id']; ?>, 'auto')" data-bank-id="<?php echo $bank['id']; ?>">
                                    <div class="bank-logo">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <div class="bank-name"><?php echo escape_html($bank['bank_name']); ?></div>
                                    <div class="text-muted small"><?php echo escape_html($bank['account_number']); ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <div id="autoInstructions" style="display: none;">
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i>วิธีการฝากเงิน</h5>
                        <ol>
                            <li>โอนเงินไปยังบัญชีที่แสดงด้านล่าง</li>
                            <li>โอนตามจำนวนที่กรอกเป็นไฟถ้วน</li>
                            <li>ระบบจะตรวจสอบและเพิ่มเครดิตอัตโนมัติ</li>
                            <li>รอรับเครดิตภายใน 1-3 นาที</li>
                        </ol>
                    </div>
                    
                    <div class="bank-details bg-dark p-3 rounded mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>ธนาคาร:</strong> <span id="selectedBankName"></span><br>
                                <strong>เลขบัญชี:</strong> <span id="selectedAccountNumber"></span><br>
                                <strong>ชื่อบัญชี:</strong> <span id="selectedAccountName"></span>
                            </div>
                            <div class="col-md-6 text-end">
                                <strong>จำนวนที่ต้องโอน:</strong><br>
                                <span class="h4 text-warning" id="exactAmount">0.00</span> บาท
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn-deposit">
                    <i class="fas fa-paper-plane me-2"></i>ยืนยันการฝาก
                </button>
            </form>
        </div>

        <!-- ฟอร์มฝาก Slip -->
        <div class="deposit-form" id="slipForm">
            <h3><i class="fas fa-receipt me-2"></i>ฝากเงินส่งสลิป</h3>
            <form id="slipDepositForm" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">จำนวนเงิน (บาท)</label>
                        <input type="number" class="form-control" id="slipAmount" min="50" max="50000" required>
                        <div class="form-text text-muted">ขั้นต่ำ 50 บาท - สูงสุด 50,000 บาท</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">เวลาโอน</label>
                        <input type="datetime-local" class="form-control" id="transferTime" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">เลือกธนาคารปลายทาง</label>
                    <div class="bank-grid">
                        <?php foreach ($banks as $bank): ?>
                            <div class="bank-card" onclick="selectBank(<?php echo $bank['id']; ?>, 'slip')" data-bank-id="<?php echo $bank['id']; ?>">
                                <div class="bank-logo">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="bank-name"><?php echo escape_html($bank['bank_name']); ?></div>
                                <div class="text-muted small"><?php echo escape_html($bank['account_number']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">อัพโหลดสลิปโอนเงิน</label>
                    <div class="upload-area" id="uploadArea">
                        <div class="upload-content">
                            <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-muted"></i>
                            <p>คลิกเพื่ือเลือกไฟล์ หรือลากไฟล์มาวางที่นี่</p>
                            <p class="text-muted small">รองรับไฟล์ JPG, PNG ขนาดไม่เกิน 5MB</p>
                        </div>
                        <input type="file" id="slipFile" accept="image/*" style="display: none;" required>
                    </div>
                    <div id="previewArea" style="display: none;">
                        <img id="imagePreview" style="max-width: 200px; border-radius: 10px; margin-top: 1rem;">
                    </div>
                </div>
                
                <button type="submit" class="btn-deposit">
                    <i class="fas fa-upload me-2"></i>ส่งสลิปเพื่อตรวจสอบ
                </button>
            </form>
        </div>

        <!-- ประวัติการฝาก -->
        <div class="recent-deposits">
            <h3><i class="fas fa-history me-2"></i>ประวัติการฝากล่าสุด</h3>
            <?php if (empty($recent_deposits)): ?>
                <div class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>ยังไม่มีประวัติการฝากเงิน</p>
                </div>
            <?php else: ?>
                <?php foreach ($recent_deposits as $deposit): ?>
                    <div class="deposit-item">
                        <div>
                            <div><strong>฿<?php echo number_format($deposit['amount'], 2); ?></strong></div>
                            <div class="text-muted small">
                                <?php echo $deposit['bank_name'] ?? 'ไม่ระบุธนาคาร'; ?> • 
                                <?php echo date('d/m/Y H:i', strtotime($deposit['created_at'])); ?>
                            </div>
                        </div>
                        <div>
                            <span class="status-badge status-<?php echo $deposit['status']; ?>">
                                <?php
                                $status_text = [
                                    'pending' => 'รอดำเนินการ',
                                    'processing' => 'กำลังตรวจสอบ',
                                    'completed' => 'สำเร็จ',
                                    'failed' => 'ไม่สำเร็จ',
                                    'cancelled' => 'ยกเลิก'
                                ];
                                echo $status_text[$deposit['status']] ?? $deposit['status'];
                                ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedMethod = '';
        let selectedBankId = null;
        
        function selectMethod(method) {
            selectedMethod = method;
            
            // รีเซ็ตการเลือก
            document.querySelectorAll('.method-card').forEach(card => {
                card.classList.remove('active');
            });
            document.querySelectorAll('.deposit-form').forEach(form => {
                form.classList.remove('active');
            });
            
            // เลือกใหม่
            document.getElementById(method + 'Method').classList.add('active');
            document.getElementById(method + 'Form').classList.add('active');
        }
        
        function selectBank(bankId, method) {
            selectedBankId = bankId;
            
            // รีเซ็ตการเลือกธนาคาร
            document.querySelectorAll(`#${method}Form .bank-card`).forEach(card => {
                card.classList.remove('selected');
            });
            
            // เลือกธนาคารใหม่
            document.querySelector(`#${method}Form .bank-card[data-bank-id="${bankId}"]`).classList.add('selected');
            
            if (method === 'auto') {
                updateAutoInstructions(bankId);
            }
        }
        
        function updateAutoInstructions(bankId) {
            // ดึงข้อมูลธนาคารจาก PHP
            const banks = <?php echo json_encode($banks); ?>;
            const selectedBank = banks.find(bank => bank.id == bankId);
            
            if (selectedBank) {
                document.getElementById('selectedBankName').textContent = selectedBank.bank_name;
                document.getElementById('selectedAccountNumber').textContent = selectedBank.account_number;
                document.getElementById('selectedAccountName').textContent = selectedBank.account_name;
                document.getElementById('autoInstructions').style.display = 'block';
                
                updateExactAmount();
            }
        }
        
        function updateExactAmount() {
            const amount = document.getElementById('autoAmount').value;
            if (amount) {
                document.getElementById('exactAmount').textContent = parseFloat(amount).toFixed(2);
            }
        }
        
        // Event Listeners
        document.getElementById('autoAmount').addEventListener('input', updateExactAmount);
        
        // Upload area handlers
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('slipFile');
        
        uploadArea.addEventListener('click', () => {
            fileInput.click();
        });
        
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });
        
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });
        
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileSelect(files[0]);
            }
        });
        
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });
        
        function handleFileSelect(file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('previewArea').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
        
        // Form submissions
        document.getElementById('autoDepositForm').addEventListener('submit', function(e) {
            e.preventDefault();
            submitAutoDeposit();
        });
        
        document.getElementById('slipDepositForm').addEventListener('submit', function(e) {
            e.preventDefault();
            submitSlipDeposit();
        });
        
        function submitAutoDeposit() {
            const amount = document.getElementById('autoAmount').value;
            
            if (!selectedBankId) {
                alert('กรุณาเลือกธนาคาร');
                return;
            }
            
            if (!amount || amount < 100) {
                alert('กรุณากรอกจำนวนเงินขั้นต่ำ 100 บาท');
                return;
            }
            
            const formData = {
                type: 'auto',
                bank_id: selectedBankId,
                amount: amount
            };
            
            fetch('process_deposit.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('บันทึกการฝากเงินเรียบร้อย\nรหัสอ้างอิง: ' + data.transaction_id + '\nกรุณาโอนเงินตามจำนวนที่แสดง');
                    location.reload();
                } else {
                    alert('เกิดข้อผิดพลาด: ' + data.message);
                }
            })
            .catch(error => {
                alert('เกิดข้อผิดพลาดในการเชื่อมต่อ');
                console.error(error);
            });
        }
        
        function submitSlipDeposit() {
            const amount = document.getElementById('slipAmount').value;
            const transferTime = document.getElementById('transferTime').value;
            const slipFile = document.getElementById('slipFile').files[0];
            
            if (!selectedBankId) {
                alert('กรุณาเลือกธนาคาร');
                return;
            }
            
            if (!amount || amount < 50) {
                alert('กรุณากรอกจำนวนเงินขั้นต่ำ 50 บาท');
                return;
            }
            
            if (!transferTime) {
                alert('กรุณาระบุเวลาโอน');
                return;
            }
            
            if (!slipFile) {
                alert('กรุณาอัพโหลดสลิปโอนเงิน');
                return;
            }
            
            const formData = new FormData();
            formData.append('type', 'slip');
            formData.append('bank_id', selectedBankId);
            formData.append('amount', amount);
            formData.append('transfer_time', transferTime);
            formData.append('slip_file', slipFile);
            
            fetch('process_deposit.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('ส่งสลิปเรียบร้อย\nรหัสอ้างอิง: ' + data.transaction_id + '\nรอการตรวจสอบภายใน 5 นาที');
                    location.reload();
                } else {
                    alert('เกิดข้อผิดพลาด: ' + data.message);
                }
            })
            .catch(error => {
                alert('เกิดข้อผิดพลาดในการเชื่อมต่อ');
                console.error(error);
            });
        }
        
        // เซ็ตเวลาโอนเป็นปัจจุบัน
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('transferTime').value = now.toISOString().slice(0, 16);
        });
    </script>
</body>
</html>