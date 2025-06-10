<?php
require $_SERVER["DOCUMENT_ROOT"] . '/connectdb.php';
$sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1 ";
$result = mysqli_query($con, $sql) or die("Error in query: $sql " . mysqli_error());
$row = mysqli_fetch_array($result);

extract($row);
$key = $linewithdraw;
?>
        

<?php
include $_SERVER["DOCUMENT_ROOT"].'/func.php';

//สร้างตัวแปรเก็บค่าที่รับมาจากฟอร์ม

$id_wd = $_POST["id_wd"];
$username_wd = $_POST["username_wd"];
$amount_wd = $_POST["amount_wd"];
$phone_wd = $_POST["phone_wd"];
$bank_wd = $_POST["bank_wd"];
$bankacc_wd = $_POST["bankacc_wd"];
$name_wd = $_POST["name_wd"];
$confirm_wd = $_POST["confirm_wd"];







$check = "SELECT  username_wd FROM withdraw  WHERE confirm_wd = 'รอดำเนินการ' AND id_wd = '$id_wd' ";
$result1 = mysqli_query($con, $check) or die("Error in query check: $con ");
$num = mysqli_num_rows($result1);

if ($num > 0) {
	echo "<script>";
	echo "alert(' ท่านมีรายการถอนอยู่ 1 รายการ !');";
	//echo "window.location = 'index.php?do=7'; ";
	echo "</script>";
} else {


	$sql9 = "INSERT INTO withdraw (id_wd, username_wd, phone_wd, bank_wd, bankacc_wd, name_wd, confirm_wd, pin_wd, amount_wd)
			 VALUES('$id_wd', '$username_wd', '$phone_wd', '$bank_wd', '$bankacc_wd','$name_wd', '$confirm_wd', 'unknown6134', '$amount_wd')";

	$result9 = mysqli_query($con, $sql9) or die("Error in query: $sql9");
}
if ($result9 == TRUE) {
	include ROOTPATH . 'class/betflix.php';
	$api = new Betflix();
	$usernameufa = $agent . $username_wd;
	$data = $api->withdraw($usernameufa, $amount_wd);
	//echo $status;
	if (!$data->error_code) {

		header("Content-Type: text/html; charset=utf-8");
		echo "<script type='text/javascript'>";
		echo "alert('แจ้งถอนสำเร็จ');";
		echo "window.location = 'withdraw.php'; ";
		echo "</script>";

		$sMessage = "แอดมินแจ้งถอนเงิน \nจำนวนเงิน " . $amount_wd . " บาท\nเบอร์ " . $phone_wd . " \nเลขบัญชี " . $bankacc_wd . " \nธนาคาร " . $bank_wd;
		$chOne = curl_init();
		curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
		curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($chOne, CURLOPT_POST, 1);
		curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
		$headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $key . '',);
		curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($chOne);
		if (curl_error($chOne)) {
			echo 'error:' . curl_error($chOne);
		} else {
			$result_ = json_decode($result, true);
		}
		curl_close($chOne);
	} else {
		header("Content-Type: text/html; charset=utf-8");
		echo "<script type='text/javascript'>";
		echo "alert('Error back to withdraw again');";
		echo "</script>";
	}
	//ปิดการเชื่อมต่อ database
	mysqli_close($con);
	//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม

} else {
	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('Error back to withdraw again');";
	echo "</script>";
}
?>