<head>
  <meta http-equiv="refresh" content="20">
</head>
<?php
require '../connectdb.php';
require 'apiufa1062.php';
$sql="SELECT * FROM member WHERE phone_mb =''" or die("Error:" . mysqli_error());
$result = mysqli_query($con, $sql);
$num=mysqli_num_rows($result);



$agent_username = $GLOBALS['user_ag'];
$total = $GLOBALS['txtTotalLimit'];
$GLOBALS["url"]="https://ocean.isme99.com/";
$ASPXAUTH=$api->get_created_cookie_login('cookie_login')['aspx'];
$proxy = '';

function generateRandomString($length = 5) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

$username=generateRandomString();

if ($num<30) {

$password_ufa=urlencode('aa123456');
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $GLOBALS["url"].'/_SubAg1/MemberSet.aspx');
 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
  $header = array(
					"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
					"cache-control: no-cache",
					"sec-fetch-dest: document",
					"Content-Type: application/x-www-form-urlencoded",
					"sec-fetch-site: same-origin",
					"sec-fetch-user: ?1",
					"upgrade-insecure-requests: 1",
					'Cookie: .ASPXAUTH=' . $ASPXAUTH,
					"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
				);
  curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
  $result = curl_exec($ch) or die(curl_error($ch));
  curl_close($ch);
 




  preg_match_all('/(?<=id\=\"__VIEWSTATE\" value\=\").(.*?)(?=\")/', $result, $output_array);
  $__VIEWSTATE=$output_array[0][0];
  preg_match_all('/(?<=id\=\"__VIEWSTATEGENERATOR\" value\=\").(.*?)(?=\")/', $result, $output_array);
  $__VIEWSTATEGENERATOR=$output_array[0][0];
  preg_match_all('/(?<=id\=\"__EVENTVALIDATION\" value\=\").(.*?)(?=\")/', $result, $output_array);
  $__EVENTVALIDATION=$output_array[0][0];

  preg_match_all('/(?<=lblTotalLimit\"\>Max \= \<SPAN class=\'Positive\'\>)/', $result, $output_array);
  $txtTotalLimit=$output_array[0][0];



  $ch = curl_init();
 
  curl_setopt($ch, CURLOPT_URL, $GLOBALS["url"].'/_SubAg1/MemberSet.aspx');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "__EVENTTARGET=btnSave2&__EVENTARGUMENT=&__LASTFOCUS=&__VIEWSTATE=".urlencode($__VIEWSTATE)."&__VIEWSTATEGENERATOR=".urlencode($__VIEWSTATEGENERATOR)."&__EVENTVALIDATION=".urlencode($__EVENTVALIDATION)."&txtUserName=".$username."&txtPassword=".$password_ufa."&".$total);
  $header = array(
					"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
					"cache-control: no-cache",
					"sec-fetch-dest: document",
					"Content-Type: application/x-www-form-urlencoded",
					"sec-fetch-site: same-origin",
					"sec-fetch-user: ?1",
					"upgrade-insecure-requests: 1",
					'Cookie: .ASPXAUTH=' . $ASPXAUTH,
					"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36"
				);
  curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
  $result = curl_exec($ch) or die(curl_error($ch));
  curl_close($ch);

 


  preg_match_all('/(?<=lblStatus\").+/', $result, $output_array);
  preg_match_all('/(?<=ENG\'\>).(.*?)(?=\<)/', $output_array[0][0], $output_array);
  $msg=$output_array[0][0];


  if ($msg=="รหัสผู้ใช้ต้องไม่เกิน 16 ตัวอักษร!") {
    return $status="ชื่อผู้ใช้ต้องไม่เกิน 16 ตัวอักษร!";
    exit();
  }


  if ($msg=='Profile updated successfully.' or $msg=="อัพเดตข้อมูลเรียบร้อย") {

  $sql = "INSERT INTO member (username_mb, password_ufa)
       VALUES('$username', '$password_ufa2')";
	if (mysqli_query($con, $sql) === TRUE) {

	   require 'Changpass.php';
     $uwuchange = new Changpass();
    $uwuchange->Ekkapon($agent_username.$username, 'aa123456');


	  echo "สร้างยูสสำเร็จ";
 exit();
  
	}

		
  }else{
    if ($msg=="User Name already exists." or $msg== "รหัสผู้ใช้มีผู้ใช้แล้ว.") {
      return $status="รหัสผู้ใช้มีผู้ใช้แล้ว.";
      exit();
    }
  }

  if ($msg=="Password must be contain 8-15 characters with a combination of alphabetic characters and numbers and must not contain your login name.") {
    return $status="รหัสผ่านต้องมีอักขระ 8-15 ตัวโดยมีอักขระตามตัวอักษรและตัวเลขผสมกันและต้องไม่มีชื่อล็อกอินของคุณ.";
    exit();
  }
}else{
	echo "สต็อกยูสเต็มเเล้ว";
   
   exit();
  }
?>
