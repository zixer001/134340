<?php
include('../connectdb.php'); 
 $sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1 ";
          $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
          $row = mysqli_fetch_array($result);
          
          extract($row);
          $key = $lineregister;
          $date = date("Y-m-d  H:i:s");
         

	
	$password_mb = $_POST["password_mb"];
  

	$phone_mb = $_POST["phone_mb"];
  	$phone_true = $_POST["phone_true"];
	$bank_mb = $_POST["bank_mb"];
	$bankacc_mb = $_POST["bankacc_mb"];
	$name_mb = $_POST["name_mb"];
	$status_mb = $_POST["status_mb"];
	//$aff = $_POST["aff"];
	//$ip = $_POST["ip"];
  	$date_mb = $date;

  //echo $phone_mb;
    
  

   
    //เช็คซ้ำ
	$check = "
	SELECT  phone_mb 
	FROM member  
	WHERE phone_mb = '$phone_mb' 
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
	SELECT  bankacc_mb 
	FROM member  
	WHERE bankacc_mb = '$bankacc_mb' 
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
	SELECT  name_mb 
	FROM member  
	WHERE name_mb = '$name_mb' 
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

  $check = "
  SELECT  phone_true 
  FROM member  
  WHERE phone_true = '$phone_true' 
  ";
    $result1 = mysqli_query($con, $check) or die(mysqli_error());
    $num=mysqli_num_rows($result1);
 
    if($num > 0)
    {
    echo "<script>";
    echo "alert(' ไอดีทรูวอเล็ตนี้ซ้ำ กรุณาเพิ่มใหม่อีกครั้ง !');";
    //echo "window.location = 'register.php?do=12'; ";
    echo "</script>";
    }else{
 


    $sql = "UPDATE member SET  
            password_mb='$password_mb' , 
            phone_mb='$phone_mb' ,
            phone_true='$phone_true' ,
            bank_mb='$bank_mb' ,
            bankacc_mb='$bankacc_mb' ,
            name_mb='$name_mb' ,
            status_mb = '$status_mb' ,
            confirm_mb = 1,
            date_mb = '$date_mb' 
            WHERE phone_mb='' ORDER BY id_mb ASC LIMIT 1 ";

	$result9 = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
}}}}

if ($result9 == TRUE) {


$sMessage = "สมาชิกใหม่ \nเบอร์ ".$phone_mb."\nชื่อ ".$name_mb;
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
	echo "window.location = 'member.php'; ";
	echo "</script>";

}else{
  header("Content-Type: text/html; charset=utf-8");
  echo "<script type='text/javascript'>";
  echo "alert('Error back to register again');";
  echo "</script>";

}

	//ปิดการเชื่อมต่อ database
	
?>