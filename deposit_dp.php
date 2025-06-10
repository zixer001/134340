<?php
require $_SERVER["DOCUMENT_ROOT"] . '/connectdb.php';

$sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1 ";
$result = mysqli_query($con, $sql) or die("Error in query: $sql ");
$row = mysqli_fetch_array($result);

extract($row);
$key = $linedeposit;

$sql2 = "SELECT * FROM setting ORDER BY id DESC LIMIT 1 ";
$result = mysqli_query($con, $sql2) or die("Error in query2: $sql2 ");
$row = mysqli_fetch_array($result);
extract($row);
$setdp = $row['set_dp'];

$id_dp = $_POST["id_dp"];
$username_dp = $_POST["username_dp"];
$amount_dp = $_POST["amount_dp"];
$phone_dp = $_POST["phone_dp"];
$bank_dp = $_POST["bank_dp"];
$bankacc_dp = $_POST["bankacc_dp"];
$name_dp = $_POST["name_dp"];
$confirm_dp = $_POST["confirm_dp"];
$promotion_dp = $_POST["promotion_dp"];
$aff_dp = $_POST["aff_dp"];
$note_dp = $_POST["note_dp"];
$bonus_dp = $_POST["bonus_dp"];
$fromTrue = $_POST["fromTrue"];

//     echo '<pre>';
// print_r($_POST);
// echo '</pre>';




//เช็คซ้ำ

$check = "SELECT  username_dp FROM deposit  WHERE confirm_dp = 'รอดำเนินการ' AND id_dp = $id_dp AND username_dp = '$username_dp'";
$result1 = mysqli_query($con, $check) or die("Error in query check: $con ");
$num = mysqli_num_rows($result1);

if ($num > 0) {
	echo "<script>";
	echo "alert(' ท่านมีรายการฝากอยู่ 1 รายการ !');";
	echo "window.location = 'index.php'; ";
	echo "</script>";
} else {

	//เช็คซ้ำ




	//เช็คซ้ำ

	$check2 = "SELECT username_dp FROM deposit , promotion WHERE username_dp = '$username_dp' AND time_pro = 'รับได้ครั้งเดียว' AND promotion_dp = '$promotion_dp' AND confirm_dp = 'อนุมัติ' AND name_pro = '$promotion_dp'";
	$result2 = mysqli_query($con, $check2) or die("Error in query check2: $con ");
	$num2 = mysqli_num_rows($result2);

	if ($num2 > 0) {
		echo "<script>";
		echo "alert(' ท่านรับโปรโมชั่นนี้ไปแล้ว ! กรุณาเลือกโปรโมชั่นอื่น');";
		echo "window.location = 'index.php'; ";
		echo "</script>";
	} else {

		//เช็คซ้ำ
		$date3 = date("Y-m-d");
		$check3 = "SELECT username_dp FROM deposit , promotion WHERE username_dp = '$username_dp' AND promotion_dp = '$promotion_dp' AND time_pro = 'รับได้วันละ 1 ครั้ง' AND confirm_dp = 'อนุมัติ' AND name_pro = '$promotion_dp' AND date_dp LIKE '%$date3%'";
		$result3 = mysqli_query($con, $check3) or die("Error in query check3: $con ");
		$num3 = mysqli_num_rows($result3);
		if ($num3 > 0) {
			echo "<script>";
			echo "alert(' วันนี้ท่านรับโปรโมชั่นรายวันนี้ไปแล้ว ! กรุณาเลือกโปรโมชั่นอื่น');";
			echo "window.location = 'index.php'; ";
			echo "</script>";
		} else {

			//เช็คซ้ำ






			$sql9 = "INSERT INTO deposit (id_dp, username_dp, phone_dp, bank_dp, bankacc_dp, name_dp, confirm_dp, amount_dp, promotion_dp, aff_dp, note_dp, bonus_dp, game_dp, fromTrue)
             VALUES('$id_dp', '$username_dp', '$phone_dp', '$bank_dp', '$bankacc_dp','$name_dp', '$confirm_dp', '$amount_dp', '$promotion_dp', '$aff_dp', '$note_dp', '$bonus_dp', '$game_dp', '$fromTrue')";

			$result9 = mysqli_query($con, $sql9) or die("Error in query sql9: $sql9 ");
		}
	}
}
if ($result9 == TRUE) {

	$sMessage = "แอดมินฝาก \nจำนวนเงิน " . $amount_dp . " บาท\nเบอร์ " . $phone_dp . "\nโปรโมชั่น " . $promotion_dp;
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
}


//ปิดการเชื่อมต่อ database
mysqli_close($con);
//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม

if ($result) {
	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('อยู่ระหว่างดำเนินการ กรุณารอสักครู่');";
	echo "window.location = 'deposit.php'; ";
	echo "</script>";
} else {
	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('Error back to deposit again');";
	echo "</script>";
}
?>
