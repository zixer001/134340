<?php
include('../connectdb.php'); 
 $sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1 ";
          $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
          $row = mysqli_fetch_array($result);
          
          extract($row);
          $key = $lineregister;
          $date = date("Y-m-d  H:i:s");
         

	$username = $_POST["username"];
	$password = $_POST["password"];
  $phone = $_POST["phone"];
  $bank = $_POST["bank"];
	$bankacc = $_POST["bankacc"];
	$name = $_POST["name"];
	$status = $_POST["status"];
	$code = $_POST["code"];
  $dateup = $date;
  $percent = $_POST["percent"];
    
  

   
    //เช็คซ้ำ
	$check = "
	SELECT  phone 
	FROM affiliate  
	WHERE phone = '$phone' 
	";
    $result1 = mysqli_query($con, $check) or die(mysqli_error());
    $num=mysqli_num_rows($result1);
 
    if($num > 0)
    {
    echo "<script>";
  	echo "alert(' เบอร์โทรศัพท์นี้ซ้ำ กรุณาเพิ่มใหม่อีกครั้ง !');";
    //echo "window.location = 'register.php?do=9'; ";
    echo "</script>";
    }else{

    //เช็คซ้ำ
	$check = "
	SELECT  bankacc 
	FROM affiliate  
	WHERE bankacc = '$bankacc' 
	";
    $result1 = mysqli_query($con, $check) or die(mysqli_error());
    $num=mysqli_num_rows($result1);
 
    if($num > 0)
    {
    echo "<script>";
    echo "alert(' บัญชีธนาคารนี้ซ้ำ กรุณาเพิ่มใหม่อีกครั้ง !');";
    //echo "window.location = 'register.php?do=10'; ";
    echo "</script>";
    }else{

    //เช็คซ้ำ
	$check = "
	SELECT  name 
	FROM affiliate  
	WHERE name = '$name' 
	";
    $result1 = mysqli_query($con, $check) or die(mysqli_error());
    $num=mysqli_num_rows($result1);
 
    if($num > 0)
    {
    echo "<script>";
    echo "alert(' ชื่อ-นามสกุลนี้ซ้ำ กรุณาเพิ่มใหม่อีกครั้ง !');";
    //echo "window.location = 'register.php?do=11'; ";
    echo "</script>";
    }else{

 


$sql = "INSERT INTO affiliate (username, password, phone, bank, bankacc, name, status, code, percent, dateup)
             VALUES('$username', '$password', '$phone', '$bank', '$bankacc','$name','$status','$code','$percent','$dateup')";

    

	$result9 = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
}}}

if ($result9 == TRUE) {


$sMessage = "สมาชิกพันธมิตรใหม่ \nเบอร์ ".$phone."\nชื่อ ".$name;
  $chOne = curl_init(); 
  curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
  curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
  curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
  curl_setopt( $chOne, CURLOPT_POST, 1); 
  curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
  $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$key.'', );
  curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
  curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
  $result = curl_exec( $chOne ); 
  if(curl_error($chOne)) {echo 'error:' . curl_error($chOne); }else { 
  $result_ = json_decode($result, true); } 
  curl_close( $chOne );

	header("Content-Type: text/html; charset=utf-8");
	echo "<script type='text/javascript'>";
	echo "alert('สมัครสมาชิกสำเร็จ');";
	echo "window.location = 'affiliate.php'; ";
	echo "</script>";

}else{
  header("Content-Type: text/html; charset=utf-8");
  echo "<script type='text/javascript'>";
  echo "alert('Error back to register again');";
  echo "</script>";

}

	//ปิดการเชื่อมต่อ database
	
?>