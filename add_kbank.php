 
<?php
 //error_reporting(0);

require '../connectdb.php';
require 'apiufa1062.php';
require '../kbank525698/index.php';
echo $balanceKbank;
if ($credit!='') {
$sql8 = "UPDATE credit SET  
            credit_ufa='$credit' ,
            credit_kbank='$balanceKbank'
            WHERE id=1";
$result9 = mysqli_query($con, $sql8) or die ("Error in query: $sql " . mysqli_error());
}
$sql_kbank = "SELECT * FROM bank WHERE name_bank='ธนาคารกสิกรไทย' ORDER BY id DESC LIMIT 1";
$result_kbank = mysqli_query($con, $sql_kbank);
$row_kbank = mysqli_fetch_assoc($result_kbank);
$status_kbank=$row_kbank['status_bank'];

if($status_kbank=='ปิด'){
echo 'ระบบปิด';
exit;
}

$timenow = date('Y-m-d H:i:s');

$sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$agent_user=$row['agent'];
$key = $row['linedeposit'];
$dpspin=$row['dp_creditspin'];
echo $dpspin;
$status_auto2 = $row['status_auto2'];



if ($status_auto2=='เปิด') {
  
echo 'ระบบออโต้เปิดทำงานปกติ';

$checkdp = "SELECT * FROM reportkbank WHERE fromacc!='' ORDER BY id DESC LIMIT 100";
$query12 = mysqli_query($con, $checkdp);
foreach ($query12 as $v) {//แตกรายการ kbank

$code_dp = $v['code'];
$deposit = $v['amount'];
$transactionDescription2 = $v['type'];
$fromAccountName = $v['frombank'];
$fromacc2 = $v['fromacc'];
$fromname1 = $v['fromname'];

$vowels3 = array("นาย ", "น.ส. ", "นาง ", "MR ", "MR.", "MR. ", "MISS", "MISS ", "MRS. ", "MRS.", "MRS", "MRS ");
$fromname2 = str_replace($vowels3, "", $fromname1);

$fromname = mb_substr($fromname2, 0, -2);

$vowels2 = array("-", "x");
$fromAccount = str_replace($vowels2, "", $fromacc2);


$turn2=$deposit*2;
if ($transactionDescription2=='รับโอนเงิน') {


 $sql_checkdp = "SELECT * FROM deposit WHERE date_check_kbank='$code_dp'";
  $query2 = mysqli_query($con, $sql_checkdp);
  $check2 = $query2->num_rows;


  if ($check2==0) {


echo '<br>';
echo $fromAccount;
echo '<br>';
echo $fromname;
echo '<br>';

$search = "SELECT * FROM member WHERE bankacc_mb LIKE '%$fromAccount%' AND bank_mb = '$fromAccountName' AND name_mb LIKE '%$fromname%' OR name_eng LIKE '%$fromname%'";
$result = mysqli_query($con, $search);
$check22 = $result->num_rows;
//echo $check22;

//echo '<br>';
while($rowsearch = mysqli_fetch_array($result)) {
$phone = $rowsearch['phone_mb'];
$name_mb = $rowsearch['name_mb'];
$username1 = $rowsearch['username_mb'];
$id_mb = $rowsearch['id_mb'];
$aff = $rowsearch['aff'];
$creditspin888 = $rowsearch['creditspin']+1;


$bank_mb = $rowsearch['bank_mb'];



  
if ($bank_mb=='ธ.ออมสิน') {
    $bankacc_mb = substr($rowsearch['bankacc_mb'], 5, -3);
}elseif($bank_mb=='ธ.ก.ส.'){
    $bankacc_mb = substr($rowsearch['bankacc_mb'], 5, -3);
}else{
    $bankacc_mb = substr($rowsearch['bankacc_mb'], 5, -1);
}

if ($fromAccount==$bankacc_mb AND $phone!='') {
// echo '<br>';
// echo $phone;
// echo '<br>';
// echo $check2;
// echo '<br>';
// echo $deposit;
// echo '<br>';
// echo $fromAccount;
// echo '<br>';
// echo $transactionDescription2;
// echo '<br>';
// echo $transactionDescription;
// echo '<br>';
// echo '<br>';
// echo '<br>';



  $sql_check3 = "SELECT * FROM deposit WHERE confirm_dp='รอดำเนินการ' AND phone_dp='$phone'";
  $query3 = mysqli_query($con, $sql_check3);

  $check3 = $query3->num_rows;

  $row_pro3 = mysqli_fetch_assoc($query3);
  $get_pro = $row_pro3['promotion_dp'];
  $name = $row_pro3['name_dp'];
  $phone_dp = $row_pro3['phone_dp'];
//echo $get_pro;
  $username = $row_pro3['username_dp'];

  if ($check3==1) {
    
    $sql_promotion="SELECT * FROM promotion WHERE name_pro='$get_pro'";
    $result7 = mysqli_query($con, $sql_promotion);
    $row7 = mysqli_fetch_assoc($result7);
    $money = $row7['dp_pro'];
    $namepro= $row7['name_pro'];
    $bonusper_pro = $row7['bonusper_pro'];
    $dp_pro = $row7['dp_pro'];
    $turn = $row7['turn_pro'];
    $max_pro = $row7['max_pro'];
    //echo $max_pro;
function extract_int($str){
     preg_match('/[^0-9]*([0-9]+)[^0-9]*/', $str, $regs);
     return (intval($regs[1]));
}
$a=$turn;
$turnover1 = extract_int($a);

    $bonus_pro1 = $row7['bonus_pro'] + ($deposit * $bonusper_pro / 100);

    if ($bonus_pro1>$max_pro) {
      $bonus_pro=$max_pro;
    }else{
      $bonus_pro = $row7['bonus_pro'] + ($deposit * $bonusper_pro / 100);
    }


 
//echo $bonus_pro;
    if ($bonusper_pro!=0) {
      $turn_pro = ($deposit + $bonus_pro) * $turnover1;
    }else{
      $turn_pro = $turnover1;
    } 
//echo $turn_pro;
  
if ($get_pro==$namepro and $deposit>=$money) {
      $sum = $deposit + $bonus_pro;
    }else{
      $sum = $deposit;
    }

//echo $sum;


    $usernameufa = $agent_user.$username;
                $data22 = $api->GetBalance($usernameufa);
                $Balance21=json_decode($data22);
                $Balance222=$Balance21->Balance;


                
                $data7 = $api->GetBalanceGame($usernameufa);
                $Balance77=json_decode($data7);
                $Balance7=$Balance77->Balance;
                $ttbalance = $Balance222+$Balance7;
                
//echo $usernameufa;
    $status= $api->add_credit($usernameufa,$sum); 
    $status = json_decode($status);
    $status = $status->status;

    $sql_dp88="SELECT * FROM member WHERE username_mb='$username'";
        $result88 = mysqli_query($con, $sql_dp88);
        $row88 = mysqli_fetch_assoc($result88);
        $creditspin88 = $row88['creditspin']+1;


  //echo $status;
    if ($status==200 and $get_pro==$namepro and $deposit==$money) {
       if ($deposit>=$dpspin) {
            

            $sql87 = "UPDATE member SET  
            creditspin='$creditspin88'
            WHERE username_mb='$username' ORDER BY id_mb DESC LIMIT 1 ";
            $result87 = mysqli_query($con, $sql87) or die ("Error in query: $sql " . mysqli_error());
        }
     
  $sql = "UPDATE deposit SET  
            confirm_dp='อนุมัติ' , 
            amount_dp='$deposit' ,
            bonus_dp='$bonus_pro' ,
            bankin_dp = 'ธนาคารกสิกรไทย' ,
            date_check_kbank='$code_dp' ,
            turnover = '$turn_pro' ,
            creditbefore = '$ttbalance',
            add_dp = 'AUTO' ,
            date_dp = '$timenow' ,
            fromAccount = '$fromAccount'
            WHERE username_dp='$username' ORDER BY id DESC LIMIT 1 ";
            $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());

            
      $sql5 = "SELECT * FROM setting ORDER BY id DESC LIMIT 1";
      $result5 = mysqli_query($con, $sql5);
      $row5 = mysqli_fetch_assoc($result5);
      $key = $row5['linedeposit'];



            $sMessage = "ฝากเครดิตออโต้ KBank\nจำนวนเงิน ".$deposit." บาท\nเบอร์ ".$phone_dp."\nโปรโมชั่น ".$get_pro."\nชื่อ ".$name;
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
           
  }elseif($status==200){
    if ($deposit>=$dpspin) {
            

            $sql87 = "UPDATE member SET  
            creditspin='$creditspin88'
            WHERE username_mb='$username' ORDER BY id_mb DESC LIMIT 1 ";
            $result87 = mysqli_query($con, $sql87) or die ("Error in query: $sql " . mysqli_error());
        }
  
    $sql = "UPDATE deposit SET  
            confirm_dp ='อนุมัติ' , 
            amount_dp ='$deposit' ,
            bonus_dp = 0 ,
            bankin_dp = 'ธนาคารกสิกรไทย' ,
            date_check_kbank='$code_dp' ,
            promotion_dp = 'ไม่รับโบนัส' ,
            turnover = 0 ,
            creditbefore = '$ttbalance',
            add_dp = 'AUTO' ,
            date_dp = '$timenow' ,
            fromAccount = '$fromAccount'
            WHERE username_dp='$username' ORDER BY id DESC LIMIT 1 ";
            $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
            
            $sql5 = "SELECT * FROM setting ORDER BY id DESC LIMIT 1";
      $result5 = mysqli_query($con, $sql5);
      $row5 = mysqli_fetch_assoc($result5);
      $key = $row5['linedeposit'];



            $sMessage = "ฝากเครดิตออโต้ KBank\nจำนวนเงิน ".$deposit." บาท\nเบอร์ ".$phone_dp."\n"."ไม่รับโบนัส\nชื่อ ".$name;
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
  }




  }//$check3==1
  else{
    $usernameufa = $agent_user.$username1;
// echo $usernameufa;
// echo '<br>';
// echo $deposit;
// echo '<br>';

                $data22 = $api->GetBalance($usernameufa);
                $Balance21=json_decode($data22);
                $Balance222=$Balance21->Balance;

                $data7 = $api->GetBalanceGame($usernameufa);
                $Balance77=json_decode($data7);
                $Balance7=$Balance77->Balance;
                $ttbalance = $Balance222+$Balance7;


    $status= $api->add_credit($usernameufa,$deposit); 
    $status = json_decode($status);
    $status = $status->status;
    // echo $status;
    if($status==200){
        if ($deposit>=$dpspin) {
            

            $sql87 = "UPDATE member SET  
            creditspin='$creditspin888'
            WHERE username_mb='$username1' ORDER BY id_mb DESC LIMIT 1 ";
            $result87 = mysqli_query($con, $sql87) or die ("Error in query: $sql " . mysqli_error());
        }
    $sql = "INSERT INTO deposit (id_dp, username_dp, phone_dp, bank_dp, bankacc_dp, name_dp, confirm_dp, amount_dp, promotion_dp, aff_dp, note_dp, bonus_dp, fromTrue, date_check_kbank, bankin_dp, fromAccount, turnover, add_dp, creditbefore)
             VALUES('$id_mb', '$username1', '$phone', '$bank_mb', '$bankacc_mb','$name_mb', 'อนุมัติ', '$deposit', 'ไม่รับโบนัส', '$aff', '', '0', '$fromTrue', '$code_dp', 'ธนาคารกสิกรไทย', '$fromAccount', 0, 'AUTO', '$ttbalance')";

    $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
            
            $sql5 = "SELECT * FROM setting ORDER BY id DESC LIMIT 1";
      $result5 = mysqli_query($con, $sql5);
      $row5 = mysqli_fetch_assoc($result5);
      $key = $row5['linedeposit'];



            $sMessage = "ฝากเครดิตออโต้ KBank\nจำนวนเงิน ".$deposit." บาท\nเบอร์ ".$phone."\n"."ไม่รับโบนัส\nชื่อ ".$name_mb;
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
  }

  }

}


}







}

}

}//แตกรายการ kbank

}else{
  echo 'ระบบออโต้ปิด';
  }
