<?php
session_start();

function code($value)
{
	$value = trim($value);
	if ($value == "ธ.ไทยพาณิชย์") {
		return '014';
	}

	if ($value == "ธ.กรุงเทพ") {
		return '002';
	}

	if ($value == "ธ.กสิกรไทย") {
		return '004';
	}

	if ($value == "ธ.กรุงไทย") {
		return '006';
	}

	if ($value == "ธ.ทหารไทยธนชาติ") {
		return '011';
	}

	if ($value == "ธ.กรุงศรีอยุธยา") {
		return '025';
	}
	if ($value == "ธ.ออมสิน") {
		return '030';
	}

	if ($value == "ธ.ก.ส.") {
		return '034';
	}

	if ($value == "ธ.ซีไอเอ็มบี") {
		return '033';
	}

	if ($value == "ธ.เกียรตินาคินภัทร") {
		return '033';
	}

	if ($value == "ธ.ทิสโก้") {
		return '067';
	}

	if ($value == "ธ.ยูโอบี") {
		return '024';
	}

	if ($value == "ธ.อิสลาม") {
		return '066';
	}

	if ($value == "ธ.ไอซีบีซี") {
		return '070';
	}
}

if (isset($_SESSION['name_ad'])) {
	require $_SERVER["DOCUMENT_ROOT"] . '/connectdb.php';
	include $_SERVER["DOCUMENT_ROOT"] . '/class/betflix.php';
	include $_SERVER["DOCUMENT_ROOT"] . '/class/scb.php';
	$sql = "SELECT * FROM `bank` WHERE `name_bank` LIKE 'ธนาคารไทยพาณิชย์' AND `status_bank` LIKE 'เปิด' ORDER BY id DESC LIMIT 1";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	extract($row);
	$sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1 ";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	extract($row);
	if (isset($_GET['tranfer-m'])) {
		extract($_POST);
		// 		Array
		// (
		//     [phone] => 0961658189
		//     [accountTo] => 0882715396
		//     [accountToBankCode] => ธ.กสิกรไทย
		//     [add_wd] => -
		//     [amount] => 10
		//     [key_input] => 111111
		// )
		$pass_tran = 111111;
		if ($key_input != $pass_tran) {
			header("Content-Type: text/html; charset=utf-8");
			echo "<script>";
			echo "alert('รหัสลับไม่ถูกต้อง');";
			echo "window.location.href='javascript:history.back(1)'; ";
			echo "</script>";
			exit;
		}

		if ($add_wd == '') {
			header("Content-Type: text/html; charset=utf-8");
			echo "<script>";
			echo "alert('ไม่มีสิทธิ์ทำรายการ');";
			echo "window.location.href='javascript:history.back(1)'; ";
			echo "</script>";
			exit;
		}
		if ($amount <= 0) {
			header("Content-Type: text/html; charset=utf-8");
			echo "<script>";
			echo "alert('จำนวนเงินไม่ถูกต้อง');";
			echo "window.location.href='javascript:history.back(1)'; ";
			echo "</script>";
			exit;
		}
		$scb = new Scb();
		$res = json_decode($scb->Transfer($accountTo, code($accountToBankCode), $amount));
		if ($res->status->code == 7001) {
			header("Content-Type: text/html; charset=utf-8");
			echo "<script>";
			echo "alert('" . $res->status->description . "');";
			echo "window.location.href='javascript:history.back(1)'; ";
			echo "</script>";
			exit;
		}
		if ($res->status->code == 1000) {
			$id_withdraw;
			$note_wd = $res->data->transactionId;
			$bankout_wd = $name_bank . "-" . $bankacc_bank;
			$sql7 = "UPDATE withdraw SET confirm_wd='อนุมัติ',note_wd='$note_wd',bankout_wd='$bankout_wd' WHERE id=$id_withdraw";
			// echo "Update sql7" . $sql7 . "<br>";
			$result7 = mysqli_query($con, $sql7) or die("Error in query: $sql ");
			$key = $linewithdraw;

			$sMessage = "ถอนมือ อนุมัติถอน\nจำนวนเงิน " . $amount . " บาท \nเบอร์ " . $phone . " \nผู้ทำรายการ  " . $add_wd;
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
			echo "<script>";
			echo "alert('โอนเงินสำเร็จ');";
			echo "window.location.href='javascript:history.back(1)'";
			echo "</script>";
			exit;
		}
	}
} else {
	header("Content-Type: text/html; charset=utf-8");
	echo "<script>";
	echo "alert('ไม่มีสิทธิ์ทำรายการ');";
	echo "window.location.href='javascript:history.back(1)'; ";
	echo "</script>";
	exit;
}
