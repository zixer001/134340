<?php
// เริ่ม session และตั้งค่าความปลอดภัย
session_start();

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// ตรวจสอบและเชื่อมต่อฐานข้อมูลอย่างปลอดภัย
try {
    require_once './src/db.php';
    require_once './src/function.php';
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    http_response_code(500);
    echo "<!DOCTYPE html><html><head><title>Service Unavailable</title></head><body><h1>Service Temporarily Unavailable</h1></body></html>";
    exit();
}

// ฟังก์ชันสำหรับ escape HTML
function escape_html($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// ดึงข้อมูลการตั้งค่าเว็บไซต์
try {
    // สมมติว่ามี connection object $con หรือ $pdo
    if (isset($con)) {
        $stmt = $con->prepare("SELECT * FROM setting ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $site_settings = $result->fetch_assoc();
    } else {
        // ใช้ค่าเริ่มต้น
        $site_settings = [];
    }
    
    // กำหนดค่าเริ่มต้นสำหรับ SEO
    $site_name = escape_html($site_settings['name_web'] ?? 'UFACV9.COM');
    $site_description = escape_html($site_settings['description'] ?? 'เว็บไซต์เล่นเกมคาสิโนชั้นนำ ufacv9.com ให้บริการ สล็อตออนไลน์ มากมายจากทุกค่ายทั่วโลก');
    $site_logo = escape_html($site_settings['logo_web'] ?? 'img/logo.png');
    $site_url = escape_html($site_settings['site_url'] ?? 'https://ufacv9.com');
    
} catch (Exception $e) {
    error_log("Settings error: " . $e->getMessage());
    // ใช้ค่าเริ่มต้น
    $site_name = 'UFACV9.COM';
    $site_description = 'ศูนย์รวมสล็อต คาสิโนออนไลน์ที่ดีที่สุด ฝาก-ถอนไวที่สุดในไทย';
    $site_logo = 'img/logo.png';
    $site_url = 'https://ufacv9.com';
}

// CSRF Token สำหรับฟอร์ม
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>
<?php
session_start();
// สมมติว่ามี token อยู่ใน session
$loggedIn = isset($_SESSION['token']);
?>
<?php
session_start();
// สมมติว่ามี token อยู่ใน session
$loggedIn = isset($_SESSION['token']);
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>UFACV9 - คาสิโนออนไลน์</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

<!-- Navbar -->
    <button id="menuBtn" class="md:hidden text-gray-700 focus:outline-none">
      <i class="fas fa-bars fa-lg"></i>
    </button>
    <nav id="navMenu" class="hidden md:flex space-x-6">
      <a href="games.php" class="hover:text-red-500">เกมส์</a>
      <a href="#promotion.php" class="hover:text-red-500">โปรโมชั่น</a>
      <?php if($loggedIn): ?>
        <a href="dashboard.php" class="hover:text-red-500">แดชบอร์ด</a>
        <button id="logoutBtn" class="hover:text-red-500">ออกระบบ</button>
      <?php else: ?>
        <button id="loginBtn" class="hover:text-red-500">เข้าสู่ระบบ</button>
        <button id="registerBtn" class="hover:text-red-500">สมัครสมาชิก</button>
      <?php endif; ?>
    </nav>
  </div>
  <!-- Mobile nav -->
  <nav id="mobileMenu" class="hidden bg-white md:hidden px-4 py-2 space-y-2">
    <a href="#games.php" class="block hover:text-red-500">เกมส์</a>
    <a href="#promotion.php" class="block hover:text-red-500">โปรโมชั่น</a>
    <?php if($loggedIn): ?>
      <a href="dashboard.php" class="block hover:text-red-500">แดชบอร์ด</a>
      <button id="logoutBtn2" class="block hover:text-red-500">ออกระบบ</button>
    <?php else: ?>
      <button id="loginBtn2" class="block hover:text-red-500">เข้าสู่ระบบ</button>
      <button id="registerBtn2" class="block hover:text-red-500">สมัครสมาชิก</button>
    <?php endif; ?>
  </nav>
</header>

<!-- Hero -->
<section class="bg-red-600 text-white py-16 text-center">
  <h1 class="text-4xl md:text-5xl font-bold">ยินดีต้อนรับสู่ QBABET</h1>
  <p class="mt-4 text-lg md:text-xl max-w-2xl mx-auto">ศูนย์รวมสล็อต คาสิโนออนไลน์ ทุกค่ายในที่เดียว</p>
  <div class="mt-8 space-x-4">
    <button id="loginHeroBtn" class="px-8 py-3 bg-white text-red-600 font-semibold rounded-lg">เข้าสู่ระบบ</button>
    <button id="registerHeroBtn" class="px-8 py-3 border-2 border-white text-white font-semibold rounded-lg">สมัครสมาชิก</button>
  </div>
</section>

<!-- Games -->
<section id="games" class="py-16 container mx-auto px-4">
  <h2 class="text-3xl font-semibold text-center mb-8">เกมส์ยอดนิยม</h2>
  <div id="gamesContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
    <!-- Loader placeholder -->
    <div class="col-span-full text-center">กำลังโหลดเกมส์...</div>
  </div>
</section>

<!-- Promotions -->
<section id="promotions" class="py-16 bg-gray-50 container mx-auto px-4">
  <h2 class="text-3xl font-semibold text-center mb-8">โปรโมชั่นพิเศษ</h2>
  <div id="promotionsContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <div class="col-span-full text-center">กำลังโหลดโปรโมชั่น...</div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 text-gray-400 py-8">
  <div class="container mx-auto px-4 grid grid-cols-1 sm:grid-cols-3 gap-8">
    <div><h3 class="text-white font-semibold mb-3">เกี่ยวกับเรา</h3><p>UFACV9 ศูนย์รวมคาสิโนออนไลน์ที่ดีที่สุด</p></div>
    <div><h3 class="text-white font-semibold mb-3">ลิงก์สำคัญ</h3><ul class="space-y-2"><a href="terms.php" class="block hover:text-white">ข้อกำหนด</a><a href="privacy.php" class="block hover:text-white">นโยบาย</a></ul></div>
    <div><h3 class="text-white font-semibold mb-3">ติดต่อ</h3><p><i class="fab fa-line"></i> @ufacv9</p><p><i class="fas fa-envelope"></i> support@ufacv9.com</p></div>
  </div>
  <div class="text-center text-sm mt-6">&copy; <?= date('Y') ?> UFACV9. สงวนลิขสิทธิ์.</div>
</footer>

<!-- Login/Register Modals -->
<div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div id="modalContent" class="bg-white rounded-lg overflow-hidden w-11/12 max-w-md">
    <div class="px-6 py-4 border-b">
      <h3 id="modalTitle" class="text-xl font-semibold">Modal Title</h3>
    </div>
    <div class="p-6">
      <form id="modalForm">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div id="formFields"></div>
        <div class="mt-6 flex justify-end space-x-2">
          <button type="button" id="cancelBtn" class="px-4 py-2 border rounded">ยกเลิก</button>
          <button type="submit" id="submitBtn" class="px-4 py-2 bg-red-600 text-white rounded">ส่ง</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Toggle mobile nav
document.getElementById('menuBtn').onclick = () => {
  document.getElementById('mobileMenu').classList.toggle('hidden');
};

// Modal logic
const overlay = document.getElementById('modalOverlay');
const modalTitle = document.getElementById('modalTitle');
const formFields = document.getElementById('formFields');
let currentModal = '';

function openModal(type) {
  currentModal = type;
  overlay.classList.remove('hidden');
  modalTitle.textContent = type === 'login' ? 'เข้าสู่ระบบ' : 'สมัครสมาชิก';
  formFields.innerHTML = type === 'login' ? `
    <label class="block mb-2">ชื่อผู้ใช้</label><input name="username" required class="w-full px-4 py-2 mb-4 border rounded">
    <label class="block mb-2">รหัสผ่าน</label><input type="password" name="password" required class="w-full px-4 py-2 border rounded">
  ` : `
    <label class="block mb-2">เบอร์โทรศัพท์</label><input name="phone" required class="w-full px-4 py-2 mb-4 border rounded">
    <label class="block mb-2">รหัสผ่าน</label><input type="password" name="password" required class="w-full px-4 py-2 mb-4 border rounded">
    <label class="block mb-2">ชื่อบัญชีธนาคาร</label><input name="account_name" required class="w-full px-4 py-2 mb-4 border rounded">
    <label class="block mb-2">เลขที่บัญชี</label><input name="account_number" required class="w-full px-4 py-2 border rounded">
  `;
}

['loginBtn','loginBtn2','loginHeroBtn'].forEach(id=>document.getElementById(id).onclick=()=>openModal('login'));
['registerBtn','registerBtn2','registerHeroBtn'].forEach(id=>document.getElementById(id).onclick=()=>openModal('register'));
document.getElementById('cancelBtn').onclick = ()=>overlay.classList.add('hidden');

// Form submit handler
document.getElementById('modalForm').onsubmit = async e => {
  e.preventDefault();
  const data = new FormData(e.target);
  const url = currentModal === 'login' ? '/api/login' : '/api/register';
  const res = await fetch(url, { method: 'POST', body: data });
  const result = await res.json();
  alert(result.message || (result.success?'สำเร็จ':'เกิดข้อผิดพลาด'));
  if(result.success) window.location.reload();
};

// Fetch games & promotions
window.addEventListener('DOMContentLoaded', async () => {
  const g = await fetch('/api/games').then(r=>r.json());
  const gamesContainer = document.getElementById('gamesContainer');
  gamesContainer.innerHTML = g.map(game=>`
    <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
      <img src="${game.image_url}" alt="${game.name}" class="w-full h-24 object-cover">
      <div class="p-4 text-center font-medium">${game.name}</div>
    </div>
  `).join('');

  const p = await fetch('/api/promotions').then(r=>r.json());
  const promoContainer = document.getElementById('promotionsContainer');
  promoContainer.innerHTML = p.map(ps=>`
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <img src="${ps.image_url}" alt="${ps.title}" class="w-full h-32 object-cover">
      <div class="p-4"><h4 class="font-semibold mb-2">${ps.title}</h4><p>${ps.desc}</p></div>
    </div>
  `).join('');
});

// Logout
['logoutBtn','logoutBtn2'].forEach(id=>document.getElementById(id)?.onclick = async ()=>{
  await fetch('/api/logout',{ method:'POST' });
  window.location.reload();
});
</script>
</body>
</html>
