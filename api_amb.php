<?php
$GLOBALS['username']='25up77'; //รหัสเอเย่น
$GLOBALS['passagent']='Aa039531286'; // พาสเอเยน่

$GLOBALS['url']='uf01447841cx1s7wd47ew'; // URL ลิ้ง api

function getbalance($user){
	$curl = curl_init();
	curl_setopt_array($curl, array(
		  CURLOPT_URL => $GLOBALS['url'].'/curl_amb.php?useragent='.$GLOBALS['username'].'&passagent='.$GLOBALS['passagent'].'&getbalance&username='.$user,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
			'Connection: keep-alive',
			'Cache-Control: max-age=0',
			'sec-ch-ua: "Google Chrome";v="93", " Not;A Brand";v="99", "Chromium";v="93"',
			'sec-ch-ua-mobile: ?0',
			'sec-ch-ua-platform: "Windows"',
			'Upgrade-Insecure-Requests: 1',
			'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.63 Safari/537.36',
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
			'Sec-Fetch-Site: none',
			'Sec-Fetch-Mode: navigate',
			'Sec-Fetch-User: ?1',
			'Sec-Fetch-Dest: document',
			'Accept-Language: en-US,en;q=0.9,th;q=0.8,zh-CN;q=0.7,zh;q=0.6',
	  ),
	));

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;	
}

function turnover($user){
	$curl = curl_init();
	curl_setopt_array($curl, array(
		  CURLOPT_URL => $GLOBALS['url'].'/curl_amb.php?useragent='.$GLOBALS['username'].'&passagent='.$GLOBALS['passagent'].'&turnover&username='.$user,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
			'Connection: keep-alive',
			'Cache-Control: max-age=0',
			'sec-ch-ua: "Google Chrome";v="93", " Not;A Brand";v="99", "Chromium";v="93"',
			'sec-ch-ua-mobile: ?0',
			'sec-ch-ua-platform: "Windows"',
			'Upgrade-Insecure-Requests: 1',
			'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.63 Safari/537.36',
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
			'Sec-Fetch-Site: none',
			'Sec-Fetch-Mode: navigate',
			'Sec-Fetch-User: ?1',
			'Sec-Fetch-Dest: document',
			'Accept-Language: en-US,en;q=0.9,th;q=0.8,zh-CN;q=0.7,zh;q=0.6',
	  ),
	));

	$response = curl_exec($curl);
	curl_close($curl);
	return  $response;	
}

function agent_info(){

	$curl = curl_init();
	curl_setopt_array($curl, array(
		  CURLOPT_URL => $GLOBALS['url'].'/curl_amb.php?useragent='.$GLOBALS['username'].'&passagent='.$GLOBALS['passagent'].'&agent_info',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
			'Connection: keep-alive',
			'Cache-Control: max-age=0',
			'sec-ch-ua: "Google Chrome";v="93", " Not;A Brand";v="99", "Chromium";v="93"',
			'sec-ch-ua-mobile: ?0',
			'sec-ch-ua-platform: "Windows"',
			'Upgrade-Insecure-Requests: 1',
			'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.63 Safari/537.36',
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
			'Sec-Fetch-Site: none',
			'Sec-Fetch-Mode: navigate',
			'Sec-Fetch-User: ?1',
			'Sec-Fetch-Dest: document',
			'Accept-Language: en-US,en;q=0.9,th;q=0.8,zh-CN;q=0.7,zh;q=0.6',
	  ),
	));

$response = curl_exec($curl);
curl_close($curl);
return $response;	
}
 
 function deposit($username,$credit){
	 
		 $curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => $GLOBALS['url'].'/curl_amb.php?useragent='.$GLOBALS['username'].'&passagent='.$GLOBALS['passagent'].'&add_credit',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array('username' => $username,'amount' => $credit),
	  CURLOPT_HTTPHEADER => array(
		'Connection: keep-alive',
		'Cache-Control: max-age=0',
		'sec-ch-ua: "Google Chrome";v="93", " Not;A Brand";v="99", "Chromium";v="93"',
		'sec-ch-ua-mobile: ?0',
		'sec-ch-ua-platform: "Windows"',
		'Upgrade-Insecure-Requests: 1',
		'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.63 Safari/537.36',
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
		'Sec-Fetch-Site: none',
		'Sec-Fetch-Mode: navigate',
		'Sec-Fetch-User: ?1',
		'Sec-Fetch-Dest: document',
		'Accept-Language: en-US,en;q=0.9,th;q=0.8,zh-CN;q=0.7,zh;q=0.6',
		 
	  ),
	));

	$response = curl_exec($curl);
	curl_close($curl);
	//return $response;
	$send=json_decode($response,true);
	if($send['status']==200){
		return json_encode(["status"=>200]);
	}else{
		return json_encode(["status"=>500]);
	}
 }
	
 function withdraw($username,$credit){
	 
		 $curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => $GLOBALS['url'].'/curl_amb.php?useragent='.$GLOBALS['username'].'&passagent='.$GLOBALS['passagent'].'&withdraw',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array('username' => $username,'amount' => $credit),
	  CURLOPT_HTTPHEADER => array(
		'Connection: keep-alive',
		'Cache-Control: max-age=0',
		'sec-ch-ua: "Google Chrome";v="93", " Not;A Brand";v="99", "Chromium";v="93"',
		'sec-ch-ua-mobile: ?0',
		'sec-ch-ua-platform: "Windows"',
		'Upgrade-Insecure-Requests: 1',
		'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.63 Safari/537.36',
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
		'Sec-Fetch-Site: none',
		'Sec-Fetch-Mode: navigate',
		'Sec-Fetch-User: ?1',
		'Sec-Fetch-Dest: document',
		'Accept-Language: en-US,en;q=0.9,th;q=0.8,zh-CN;q=0.7,zh;q=0.6',
		 
	  ),
	));

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
 }
 
 
 if(isset($_GET['deposit'])) {
 $user_deposit=$_POST['username'];
	 $amount_deposit=$_POST['amount'];
	 $data= deposit($user_deposit,$amount_deposit);
	 $status=json_decode($data,true);
	 $check=$status['status'];
	 if( $check==200){
		  echo '<script>  alert("OK OK");  window.location.href="deposit.php"; </script>';
	 }else{
		 echo '<script>  alert("NO NO NO NO NO NO");  window.location.href="deposit.php";  </script>';
	 } 
 }
 
 
 
 
 
  if(isset($_GET['withdraw'])) {
	 $user_withdraw=$_POST['username'];
	 $amount_withdraw=$_POST['amount'];
	 
	 $data= withdraw($user_withdraw,$amount_withdraw);
	 $status=json_decode($data,true);
	 $check=$status['status'];
	 if($check==200){
		 echo '<script>  alert("OK OK"); window.location.href="withdraw.php"; </script>';
		  
	 }else{
		 echo '<script>  alert("NO NO NO NO NO NO"); window.location.href="withdraw.php" </script>';
		  
	 }
	 
 }
 
 
 
 
 
 
 
 
 
 /* ---------------  วิํธีเทส ลบ // หน้า echo เพื่อเทสดูทีละฟังชั่น --------------------------*/
 
echo getbalance('25up770899797558'); /* ฟังชั่นเชคเครดิต เช่น  getbalance('ใส่ยูสที่จะเชค');  */
  
//echo agent_info(); //เชคเอเย่น

//echo deposit("25up770899797558","1"); /* เติมเครดิต  เช่น  deposit('ใส่ยูสที่จะเชค ' , ' ใส่จำนวนที่จะเติม '); */
 
//echo withdraw("25up770899797558","6"); /* ถอนเครดิต  เช่น  deposit('ใส่ยูสที่จะเชค ' , ' ใส่จำนวนที่จะเติม '); */

//echo turnover("25up770625295211"); /* เชคเทริน  */
?>
