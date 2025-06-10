<head>
  <meta http-equiv="refresh" content="10">
</head>
<?php
header("Content-Type: text/html; charset=utf-8");
require '../connectdb.php';
require 'tmn_new.php';

$sql = "SELECT * FROM bank WHERE name_bank='ทรูวอเล็ต'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$number = $row['bankacc_bank'];
$password = $row['password_true'];
$pin = $row['pin_bank'];
//echo $number;
// $no_true = $row['no_true'];
// $otp_true = $row['otp_true'];


$sql2 = "SELECT * FROM withdraw WHERE confirm_wd='รอดำเนินการ' AND bank_wd='ทรูวอเล็ต' ORDER BY id ASC limit 1 ";//ถ้าไม่ต้องการเช็คคนที่รับโปร ก่อนถอน เอา lastpro="ไม่รับโบนัส" ออก


$result2 = mysqli_query($con, $sql2);
$check = $result2->num_rows;
$row2 = mysqli_fetch_assoc($result2);
$phone = $row2['phone_wd'];
$bank_number = $row2['bankacc_wd'];
$amount = $row2['amount_wd'];
$bankout = $row['name_bank'].$row['bankacc_bank'];
//echo $check; 

$sql_scb = "SELECT * FROM setting";
$result_scb = mysqli_query($con, $sql_scb);
$row_scb = mysqli_fetch_assoc($result_scb);
$limit_scb=$row_scb['max_autowd'];
//echo 	$limit_scb;	
$status_transfer=$row_scb['status_auto'];
$status_auto2 = $row_scb['status_auto2'];

if ($status_auto2=='เปิด') {
	
if($status_transfer!='เปิด'){
	echo 'ฟังชั่นปิดอยู่';
exit();
}


$tw = new iWallet($number,$password,$pin);



print_r($tw->GetBalance());


if ($check!=0) {
	if ($amount<$limit_scb){



$withdraw = $tw->P2p($bank_number, $amount);
print_r($withdraw);

// 	if ($status=='SUCCESS') {
	
	
// 	$sql="UPDATE `withdraw` SET `confirm_wd`='อนุมัติ' , `bankout_wd`='".$bankout."' WHERE phone_wd='".$phone."'";
// 		if (mysqli_query($con, $sql) === TRUE) {
			

// 			$sql5 = "SELECT * FROM setting ORDER BY id DESC LIMIT 1";
// 			$result5 = mysqli_query($con, $sql5);
// 			$row5 = mysqli_fetch_assoc($result5);
// 			$key = $row5['linewithdraw'];

// 			$sMessage = "BOT true อนุมัติถอน \nจำนวนเงิน ".$amount." บาท\nเบอร์ ".$phone;
// 			$chOne = curl_init(); 
// 				curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
// 				curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
// 				curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
// 				curl_setopt( $chOne, CURLOPT_POST, 1); 
// 				curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
// 				$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$key.'', );
// 				curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
// 				curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
// 				$result = curl_exec( $chOne ); 
// 				if(curl_error($chOne)) {echo 'error:' . curl_error($chOne); }else { 
// 					$result_ = json_decode($result, true); } 
// 					curl_close( $chOne );

// }
// }




}
}
}else{ echo 'ระบบออโต้ปิด';}
?>