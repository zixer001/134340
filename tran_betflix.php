<?php
session_start();
if (isset($_SESSION['name_ad'])) {
	include '../../func.php';
	require ROOTPATH . 'connectdb.php';
	include ROOTPATH . 'class/betflix.php';
	$sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1 ";
	$res = $con->query($sql);
	$row = $res->fetch_assoc();
	extract($row);
	$api = new Betflix();

	$admin = $_POST['admin'];

	if ($admin == '1') {
		header("Content-Type: text/html; charset=utf-8");
		echo "<script>";
		echo "alert('ท่านไม่สามารถเพิ่มเครดิตได้');";
		echo "window.location.href='javascript:history.back(1)'; ";
		echo "</script>";
		exit;
	}

	if (isset($_GET['deposit'])) {

		$username = $_POST['username'];
		$amount = $_POST['amount'];
		$data = $api->deposit($username, $amount);
		if (!$data->error_code) {
			header("Content-Type: text/html; charset=utf-8");
			echo "<script>";
			echo "alert('เติมเครดิตสำเร็จ');";
			echo "window.location.href='javascript:history.back(1)'; ";
			echo "</script>";
			$key = $linedeposit;
			$sMessage = "เติมเครดิตโดยแอดมิน \nจำนวนเงิน " . $amount . " บาท\nเข้ายูสเซอร์ " . $username . " \nผู้ทำรายการ " . $admin;
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
		} else {
			header("Content-Type: text/html; charset=utf-8");
			echo "<script>";
			echo "alert('" . json_encode($data) . "');";
			echo "window.location.href='javascript:history.back(1)'; ";
			echo "</script>";
		}
	}

	if (isset($_GET['withdraw'])) {

		$username = $_POST['username'];
		$amount = $_POST['amount'];
		$data = $api->withdraw($username, $amount);
		if (!$data->error_code) {
			header("Content-Type: text/html; charset=utf-8");
			echo "<script>";
			echo "alert('ตัดเครดิตสำเร็จ');";
			echo "window.location.href='javascript:history.back(1)'; ";
			echo "</script>";
			$key = $linewithdraw;
			$sMessage = "ตัดเครดิตโดยแอดมิน \nจำนวนเงิน " . $amount . " บาท\nยูสเซอร์ " . $username . " \nผู้ทำรายการ " . $admin;
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
		} else {
			header("Content-Type: text/html; charset=utf-8");
			echo "<script>";
			echo "alert('ตัดเครดิตไม่สำเร็จ !!!!');";
			echo "window.location.href='javascript:history.back(1)'; ";
			echo "</script>";
		}
	}
} else {
	header("Content-Type: text/html; charset=utf-8");
	echo "<script>";
	echo "alert('ท่านไม่สามารถเพิ่มเครดิตได้');";
	echo "window.location.href='javascript:history.back(1)'; ";
	echo "</script>";
}
