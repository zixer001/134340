
<!DOCTYPE html>
<?php
session_start();
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';
include('../connectdb.php');


 


$id_mb = $_SESSION['id_mb'];
$name_mb = $_SESSION['name_mb'];
$username_mb = $_SESSION['username_mb'];
$password_mb = $_SESSION['password_mb'];
$bank_mb = $_SESSION['bank_mb'];
$bankacc_mb = $_SESSION['bankacc_mb'];
$phone_mb = $_SESSION['phone_mb'];
$status_mb = $_SESSION['status_mb'];
$confirm_mb = $_SESSION['confirm_mb'];
$aff = $_SESSION['aff'];
$status = $_SESSION['status'];
$password_ufa = $_SESSION['password_ufa'];
$ip = $_SESSION['ip'];
$phone_true = $_SESSION['phone_true'];


// echo 'id_mb =' .$id_mb;
// echo 'name_mb =' .$name_mb;
// echo 'username_mb =' .$username_mb;
// echo 'status_mb =' .$status_mb;
// echo 'status_mb =' .$status_mb;
if ($status_mb!='2') {
Header("Location: ../login.php");
}
?>
<?php
         
         $sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1 ";
         $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
         $row = mysqli_fetch_array($result);
         extract($row);




         $line_id=$row['lineoa'];
         $logo = $logo_web;
   include('../apiufa1062.php');
   $usernameufa = $agent.$username_mb;
    date_default_timezone_set('asia/bangkok');
       ?>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php echo($name_web); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="spinner/css/superwheel.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"  crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <link href="https://kit-pro.fontawesome.com/releases/v5.15.3/css/pro.min.css" rel="stylesheet">

    <!-- AOS JS -->
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
        <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Swiper -->
     <link
      rel="stylesheet"
      href="https://unpkg.com/swiper/swiper-bundle.min.css"
    />

    <!-- AOS JS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/stylegreen7.css">

    <link rel="manifest" href="css/manifest.json">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- Facebook shared -->
    <meta property="og:url"                content="http://www..com/" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="" />
    <meta property="og:description"        content="&#3649;&#3588;&#3656;&#3648;&#3623;&#3655;&#3610;&#3648;&#3623;&#3636;&#3619;&#3660;&#3604;&#3648;&#3614;&#3619;&#3626;&#3648;&#3623;&#3655;&#3610;&#3627;&#3609;&#3638;&#3656;&#3591;" />
    <meta property="og:image"              content="img" />
    <meta name='robots' content='max-image-preview:large' />

</head>

<body>

 <?php
if(@$_GET['do']==1){
echo "<script>";
echo "Swal.fire({
  icon: 'success',
  title: 'เข้าสู่ระบบเรียบร้อย',
  text: 'ขอให้ท่านโชคดี'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==2){
echo "<script>";
echo "Swal.fire({
  icon: 'success',
  title: 'สมัครสมาชิกสำเร็จ',
  text: 'ขอให้ท่านโชคดี'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==3){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'ท่านมีรายการฝากอยู่ 1 รายการ !'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==4){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'ท่านรับโปรโมชั่นนี้ไปแล้ว ! กรุณาเลือกโปรโมชั่นอื่น'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==5){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'วันนี้ท่านรับโปรโมชั่นรายวันนี้ไปแล้ว ! กรุณาเลือกโปรโมชั่นอื่น'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==6){
echo "<script>";
echo "Swal.fire({
  icon: 'success',
  title: 'เลือกโปรโมชั่นสำเร็จ',
  text: 'กรุณาฝากเงินตามโปรโมชั่น'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==7){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'ถอนเงินผิดพลาด กรุณาติดต่อแอดมิน !!'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==8){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'ถอนเงินผิดพลาด กรุณาติดต่อแอดมิน !'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==9){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'ยอดเทิร์นยังไม่ครบ !'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==10){
echo "<script>";
echo "Swal.fire({
 icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'เครดิตไม่เพียงพอ !'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==11){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'ถอนเงินขั้นต่ำ $set_wd บาท !'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==12){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'ท่านมีรายการถอนอยู่ 1 รายการ !'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==13){
echo "<script>";
echo "Swal.fire({
  icon: 'success',
  title: 'แจ้งถอนสำเร็จ',
  text: 'กรุณารอทำรายการใน 3 นาที'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==14){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'กิจกรรมปิดอยู่ ไม่สามารถรับได้ !'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==15){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'ท่านรับเครดิตฟรีไปแล้ว !'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==16){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'ไอพีนี้รับเครดิตฟรีไปแล้ว ! รับอีกไม่ได้'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==17){
echo "<script>";
echo "Swal.fire({
   icon: 'success',
  title: 'รับเครดิตฟรี',
  text: 'สำเร็จ !'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==18){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'ยอดเงินไม่เพียงพอ !'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==19){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'ท่านทำรายการนี้ไปแล้ว !'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==20){
echo "<script>";
echo "Swal.fire({
   icon: 'success',
  title: 'รับยอดแนะนำเพื่อน',
  text: 'เรียบร้อย !!'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==21){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'ยอดเงินไม่เพียงพอ !'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==22){
echo "<script>";
echo "Swal.fire({
  icon: 'error',
  title: 'ไม่สำเร็จ',
  text: 'ท่านทำรายการนี้ไปแล้ว !'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>
<?php
if(@$_GET['do']==23){
echo "<script>";
echo "Swal.fire({
   icon: 'success',
  title: 'รับยอดเสียรายวัน',
  text: 'สำเร็จ !!'

  
});";
                                    
echo "</script>";

    echo '<meta http-equiv="refresh" content="1;url=index.php" />';
}
?>




<div class=" loginbg paddinglogin">
   <div id="layers">
    <div class="layer" style="background-image: url('https://ideabet.org/wp-content/themes/ideabet/css/stars-1.png')"></div>
    <div class="layer" style="background-image: url('https://ideabet.org/wp-content/themes/ideabet/css/stars-2.png')"></div>
    <div class="layer" style="background-image: url('https://ideabet.org/wp-content/themes/ideabet/css/stars-3.png')"></div>
    <div class="layer" style="background-image: url('https://ideabet.org/wp-content/themes/ideabet/css/stars-4.png')"></div>
    <div class="layer" style="background-image: url('https://ideabet.org/wp-content/themes/ideabet/css/stars-5.png')"></div>
    <div class="-falling-star"></div>
    <div class="-falling-star"></div>
    <div class="-falling-star"></div>
    <div class="-falling-star"></div>
    <div class="-falling-star"></div>
    <div class="-falling-star"></div>
    <div class="-falling-star"></div>
    <div class="-falling-star"></div>
    <div class="-falling-star"></div>
    <div class="-falling-star"></div>
</div>
   <div class="incontainerlg">
      <div class="p-0 px-1 px-md-2 px-lg-4 flexcn">
         <div class="bgcententmain">
            <div class="cthome">




            <div class="circlecredit animate__animated animate__pulse">
               <div class="logocrcd">
                  <img src="<?php echo($logo); ?>">
               </div>
               <div class="incrcd">
                  <div class="row m-0">
                     <div class="col-8 p-0 leftheadmoney">
                       <div>
                           <b>ขอต้อนรับ! <?php echo($phone_mb); ?> <i class="fas fa-check-circle"></i></b>
                           กระเป๋าเงิน
                           <span><?php echo($Balance); ?> (คืนยอดเสีย <?php
                                $today_dp = date('Y-m-d',strtotime('-1 day'));
                                $querydp2 = "SELECT SUM(amount_dp) AS total FROM deposit WHERE confirm_dp ='อนุมัติ' AND promotion_dp='ไม่รับโบนัส' AND phone_dp = '$phone_mb' AND date_dp LIKE '%$today_dp%'";
                                $resultdp2 = mysqli_query($con, $querydp2);
                                $row = mysqli_fetch_assoc($resultdp2);
                                //echo $row['total'];


                                $today_wd = date('Y-m-d',strtotime('-1 day'));
                                $querywd2 = "SELECT SUM(amount_wd) AS total FROM withdraw WHERE confirm_wd='อนุมัติ' AND phone_wd = '$phone_mb' AND date_wd LIKE '%$today_wd%'";
                                $resultwd2 = mysqli_query($con, $querywd2);

                                $row2 = mysqli_fetch_assoc($resultwd2);
                                //echo $row2['total'];

                                $total = $row['total'] - $row2['total'];
                              
                                $total1 = $total * $cashback / 100;

                                if ($total1<=0) {
                                    echo "<font color='#fff200'>0</font>";
                                   
                                }
                                elseif ($total1>0) {
                                    echo "<font color='#fff200'>$total1</font>";

                                }?> )</span>


<?php 
                $sql669 = "SELECT * FROM member WHERE username_mb='$username_mb'";
          $result669 = mysqli_query($con, $sql669) or die ("Error in query: $sql " . mysqli_error());
          $row669 = mysqli_fetch_array($result669);
          extract($row669);


                if ($creditspin=='') {
                   echo 0;
                }else{
                echo $creditspin;
            }?>
                       </div>
                     </div>
                     <div class="col-4 p-0 rightheadmoney" onclick="window.open('https://braga988.com/togame4.php?username=<?php echo $usernameufa; ?>', '_blank')">
                        <div class="cursorp">
                           <img src="css/buttonbg.png">
                           <i class="fad fa-play"></i>
                           <div class="playgametext" >เข้าเล่นเกม</div>
                        </div>
                     </div>
                  </div>
               </div>

              <i class="fas fa-sign-out-alt logouticon" onclick="logout1()"></i>
            </div>

<!-- HOME SECTION -->
<div id="hometab" class="menucontent" style="display: block;">

            <div class="gamegrid">
               <div class="ingamegrid">
                  <div class="iningamegrid" onclick="OpenMenu(event, 'deposittab')">
                     <img src="css/deposit-1.png">
                     <span>ฝากเงิน</span>
                  </div>
               </div>
				
               <div class="ingamegrid">
                  <div class="iningamegrid" onclick="OpenMenu(event, 'withdrawtab')">
                     <img src="css/withdraw-1.png">
                     <span>ถอนเงิน</span>
                  </div>
               </div>
				
				<div class="ingamegrid">
                  <div class="iningamegrid" onclick="OpenMenu(event, 'spiner')">
                     <img src="css/spin.png">
                     <span>สูตรสล็อต</span>
                  </div>
               </div>
				
               <div class="ingamegrid">
                  <div class="iningamegrid" onclick="OpenMenu(event, 'promotiontab')">
                     <img src="css/present.svg">
                     <span>โปรโมชั่น</span>
                  </div>
               </div>
               <div class="ingamegrid">
                  <div class="iningamegrid" onclick="OpenMenu(event, 'historytab')">
                     <img src="css/profits.svg">
                     <span>ประวัติธุรกรรม</span>
                  </div>
               </div>
               <div class="ingamegrid">
                  <div class="iningamegrid" onclick="OpenMenu(event, 'eventtab')">
                     <img src="css/trophy.svg">
                     <span>สิทธิพิเศษ</span>
                  </div>
               </div>
               <div class="ingamegrid">
                  <div class="iningamegrid" onclick="OpenMenu(event, 'hisplaytab')">
                     <img src="css/to-do-list.svg">
                     <span>ประวัติการเล่น</span>
                  </div>
               </div>
               <div class="ingamegrid">
                  <div class="iningamegrid" onclick="OpenMenu(event, 'friendtab')">
                     <img src="css/returncd-1.png">
                     <span>แนะนำเพื่อน</span>
                  </div>
               </div>
               <div class="ingamegrid">
                  <div class="iningamegrid" onclick="OpenMenu(event, 'settingtab')">
                     <img src="css/setting.png">
                     <span>เครื่องมือ</span>
                  </div>
               </div>
                
               <div class="ingamegrid">
                  <div class="iningamegrid" onclick="logout1()">
                     <img src="css/arrow.svg" >
                     <span>ออกจากระบบ</span>
                  </div>
               </div>
            </div>
	

              <div class="swiper-container-2">
                  <div class="swiper-wrapper">
                     <div class="swiper-slide">
                        <img src="css/6.jpg?v=1">
                     </div>
                     <div class="swiper-slide">
                        <img src="css/5.jpg?v=1">
                     </div>
                     <div class="swiper-slide">
                        <img src="css/6.jpg?v=1">
                     </div>
                  </div>
                  <!-- Add Pagination -->
                  <div class="swiper-pagination"></div>
                  <div class="swiper-button-prev swiper-button-white"></div>
                  <div class="swiper-button-next swiper-button-white"></div>
               </div>
</div>
<!-- HOME SECTION -->


<!-- Game SECTION -->
<div id="gametab" class="menucontent">
   <div class="backtohome" onclick="OpenMenu(event, 'hometab')">
         <button><i class="fas fa-angle-left"></i> ย้อนกลับ</button>
   </div>
<div class="inmenucontent">
   <div class="menuhead"><i class="fas fa-gamepad"></i> เล่นเกม</div>
   <div class="listgridgame">
      <div class="inlistgame">
         <div class="ininlistgame">
            <img src="cssufabet.gif">
            <div class="text-center py-2">
                <span class="badge rounded-pill bg-primary">กีฬา</span>
                <span class="badge rounded-pill bg-secondary">คาสิโน</span>
                <span class="badge rounded-pill bg-success">เกม</span>
                <span class="badge rounded-pill bg-danger">เกมยิงปลา</span>
                <span class="badge rounded-pill bg-warning text-dark">Esport</span>
                <span class="badge rounded-pill bg-info text-dark">หวย</span>
            </div>
            <div class="pgamebtn">
               <button data-toggle="modal" data-target="#playgamepopup">เข้าสู่เกม</button>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<!-- Game SECTION -->

<!-- Deposit SECTION -->
<div id="deposittab" class="menucontent">
   <div class="backtohome" onclick="OpenMenu(event, 'hometab')">
      <button><i class="fas fa-angle-left"></i> ย้อนกลับ</button>
   </div>
<div class="inmenucontent">
         <div class="ininmnct">
         <div class="menuhead"><i class="fas fa-donate"></i> ฝากเงิน</div>

         <div class="headerbankdt">
            เลือกช่องทางการเติม ขั้นต่ำ <?php echo $set_dp;  ?> บาท
         </div>
         <div class="headerbankdt">หากต้องการรับโปรโมชั่น ต้องเลือกโปรโมชั่นก่อนโอนเงินนะคะ</div>
         <hr class="x-hr-border-glow mb-3">
         <div class="row m-0">
            <div class="col-3 p-0 leftdps">
               <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><img class="banktabicon" src="css/bankicon.png?v=2"> ธนาคาร</a>
                  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><img class="banktabicon" src="css/truewallet.svg?v=1"> TrueWallet</a>
                  <a class="nav-link" id="s-pills-profile-tab" data-toggle="pill" href="#s-pills-profile" role="tab" aria-controls="s-pills-profile" aria-selected="false"><img class="banktabicon" src="css/sticker.png"> เลือกโปรโมชั่น</a>
                  <!-- <a class="nav-link" id="v-pills-promptpay-tab" data-toggle="pill" href="#v-pills-promptpay" role="tab" aria-controls="v-pills-promptpay" aria-selected="true"><i class="fas fa-qrcode"></i> QR CODE</a> -->
               </div>
            </div>
            <div class="col-9 p-0">
               <div class="tab-content" id="v-pills-tabContent">
                  <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                     <div class="px-3">
                        <div class="rulewd">
                           ***ยอดจะปรับอัตโนมัติใน 30 วินาที - 3 นาที<br>
                           ***หลังโอนเงินแล้วยอดฝากยังไม่เข้าใน 5 นาที สามารถแจ้งแอดมิน เพื่อให้ทีมงานช่วยตรวจสอบเพิ่มเติมได้
                          
                        </div>
                     </div>
                     <div class="griddps">
                           
                           <?php 
                                  $querybank1 = "SELECT * FROM bank WHERE bankfor LIKE '%ฝาก%' AND status_bank ='เปิด' AND name_bank!='ทรูวอเล็ต' ";
                                  $resultbank1 = mysqli_query($con, $querybank1);
               
                                 ?>
                                 <?php
                                 while($bank1 = mysqli_fetch_array($resultbank1)) { ?>



                           <div class="ingriddps">
                              <div class="iningriddps copybtn">
                                 <?php echo "<img src='../slip/".$bank1['fileupload_bank']."'style='margin-bottom: 5px;'" ."width='70px'>"; ?>
                                 <br>
                                 <?php echo $bank1['name_bank']; ?>
                                 <br>
                                 <span><?php echo $bank1['bankacc_bank']; ?></span><br>
                                 <?php echo $bank1['nameacc_bank']; ?> <br>

                                 <button onclick="copylink()"><i class="fad fa-copy"></i> คัดลอก</button>
                              </div>
                           </div><?php } ?>
                        </div>
                  </div>
                  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"> <div class="px-3">
                        <div class="rulewd">
                             ***ยอดจะปรับอัตโนมัติใน 30 วินาที - 3 นาที<br>
                           ***หลังโอนเงินแล้วยอดฝากยังไม่เข้าใน 5 นาที สามารถแจ้งแอดมิน เพื่อให้ทีมงานช่วยตรวจสอบเพิ่มเติมได้
                        </div>
                     </div>
                     <div class="griddps">
                           <?php 
                                  $querybank1 = "SELECT * FROM bank WHERE bankfor LIKE '%ฝาก%' AND status_bank ='เปิด' AND name_bank='ทรูวอเล็ต' ";
                                  $resultbank1 = mysqli_query($con, $querybank1);
               
                                 ?>
                                 <?php
                                 while($bank1 = mysqli_fetch_array($resultbank1)) { ?>
                           <div class="ingriddps">
                              <div class="iningriddps copybtn">
                                 <?php echo "<img src='../slip/".$bank1['fileupload_bank']."'style='margin-bottom: 5px;'" ."width='70px'>"; ?>
                                 <br>
                                 <?php echo $bank1['name_bank']; ?>
                                 <br>
                                 <span><?php echo $bank1['bankacc_bank']; ?></span><br>
                                 <?php echo $bank1['nameacc_bank']; ?> <br>
                                 <button onclick="copylink()"><i class="fad fa-copy"></i> คัดลอก</button>
                              </div>
                           </div><?php } ?>
                           
                        </div>
                  </div>
                  <div class="tab-pane fade text-center" id="v-pills-promptpay" role="tabpanel" aria-labelledby="v-pills-promptpay-tab">
                      <div class="px-3">
                        <div class="rulewd text-center">
                           กรุณาฝากเงินตามยอดที่ระบุภายในเวลาที่กำหนด
                        </div>
                        เลือกแอปที่ใช้ฝาก
                        <div class="selectqrcode">
                           <label>
                             <input type="radio" name="test" value="small" checked>
                             <div class="inlabel">
                                <img src="css/bankicon.png?v=2">
                                <span>ฝากด้วย<div class="d-block d-sm-none"></div>แอปธนาคาร</span>
                             </div>
                           </label>

                           <label>
                             <input type="radio" name="test" value="big">
                             <div class="inlabel">
                                <img src="css/truewallet.svg?v=1">
                                <span>ฝากด้วย<div class="d-block d-sm-none"></div>ทรูมันนี่วอลเลต</span>
                              </div>
                           </label>
                        </div>
                        ระบุจำนวนเงินที่ต้องการฝาก
                        <div class="el-input my-1">
                                 <i class="fad fa-coins"></i>
                                 <input type="text" placeholder="ระบุจำนวนเงิน" class="inputstyle text-center">
                        </div>
                        <div class="rulewd bg-warning text-dark text-center">
                           กรุณาระบุยอดการฝากเป็นจำนวนต็มเท่านั้น ระบบจะทำการสุ่มทศนิยมให้อัตโนมัติ
                        </div>
                        <button type="button" class="loginbtn regisbtn my-2" data-toggle="modal" data-target="#qrcodepopup">
                        <span>
                        ตกลง
                        </span>
                        </button>

                    <!--  <div class="ctqrcode">
                        <img src="images/qrcode/qrcode.png">
                     </div> -->
                  </div>
                  </div>

                  <div class="tab-pane fade" id="s-pills-profile" role="tabpanel" aria-labelledby="s-pills-profile-tab">
                        <div class="griddps">
                           
                           <div class="ingriddps">
                              <div class="iningriddps">
                                 <form class="form-horizontal" action="deposit_dp.php" method="post" enctype="multipart/form-data">
                      <input type="text" name="id_dp" hidden="hide" value="<?php echo($id_mb); ?>">
                      <input type="text" name="aff_dp" hidden="hide" value="<?php echo($aff); ?>">
                      <input type="text" name="confirm_dp" hidden="hide" value="รอดำเนินการ">
                      <input type="text" name="username_dp" hidden="hide" value="<?php echo($username_mb); ?>">
                      <input type="text" name="phone_dp" hidden="hide" value="<?php echo($phone_mb); ?>">
                      <input type="text" name="bank_dp" hidden="hide" value="<?php echo($bank_mb); ?>">
                      <input type="text" name="bankacc_dp" hidden="hide" value="<?php echo($bankacc_mb); ?>">
                      <input type="text" name="name_dp" hidden="hide" value="<?php echo($name_mb); ?>">
                      <input type="text" name="fromTrue" hidden="hide" value="<?php echo($phone_true); ?>">
                      <input type="text" name="amount_dp" hidden="hide" value="รอฝาก">
                      <input type="text" name="note_dp" hidden="hide" value="">
                      <input type="text" name="bonus_dp" hidden="hide" value="">


    <!-- <div class="form-group " >
        <label class="control-label requiredField">
            ใส่จำนวนเงินที่ต้องการฝาก
           
            <span class="asteriskField">
                *
            </span>
        </label>
        <input class="form-control" name="amount_dp" type="number"  required="required">
    </div>
    <script type='text/javascript'>
        function preview_image(event) 
        {
             var reader = new FileReader();
             reader.onload = function()
             {
                  var output = document.getElementById('showimg');
                  output.src = reader.result;
             }
             reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <div class="form-group">
        <div class="col-md-3"></div>
            <div class="col-md-12">

            <img  id="showimg" alt="" width="150" height="150">
        </div>
    </div>
    <div class="form-group" enctype="multipart/form-data">
        <label class="control-label requiredField">
            อัพรูปสลิปโอนเงิน
            <span class="asteriskField">
                *
            </span>
        </label><br>
        <input type="file" name="fileupload" id="showimg" required="required" onchange="preview_image(event)">
    </div> -->

    <div class="form-group ">
        
       <!-- <label class="control-label requiredField" for="pro">
            หากฝากเข้าทรูวอเล็ต อาจใช้เวลา 1-10 นาทีในการปรับยอดนะคะ
            <span class="asteriskField">
                *
            </span>
        </label> -->
        <label class="control-label requiredField" for="pro">
            เลือกรับโปรโมชั่นที่ท่านต้องการ
            <span class="asteriskField">
                *
            </span>
        </label>
        <select name="promotion_dp" class="form-control" style=" font-family: 'Mitr', sans-serif; font-size: 0.8em" required="required">
            <option></option>
            <!-- <option value="ไม่รับโบนัส">ไม่รับโบนัส ไม่ต้องทำเทิร์น</option> -->
            
            <?php
            $sql_checkpro = "SELECT * FROM deposit WHERE phone_dp='$phone_mb' AND confirm_dp='อนุมัติ' AND promotion_dp!='แจกฟรีเพียงแค่สมัคร'";
   $query2 = mysqli_query($con,$sql_checkpro);
   $check2 = $query2->num_rows;
     echo $check2;

     if ($check2>0) {
        
            $query4 = "SELECT * FROM promotion WHERE time_pro!='สมาชิกใหม่' ORDER BY id desc" or die("Error:" . mysqli_error());
                $result4 = mysqli_query($con, $query4);
        while($row = mysqli_fetch_array($result4)) {
            echo '<option value="'.$row["name_pro"].'">'.$row["name_pro"].' '.$row["time_pro"].'</option>';
            }
         }else{
            $query4 = "SELECT * FROM promotion ORDER BY id desc" or die("Error:" . mysqli_error());
                $result4 = mysqli_query($con, $query4);
        while($row = mysqli_fetch_array($result4)) {
            echo '<option value="'.$row["name_pro"].'">'.$row["name_pro"].' '.$row["time_pro"].'</option>';
            }

         } 

         ?>

        </select>
    </div>
    
    <button type="submit" class="btn btn-primary" name="submit">ยืนยันฝากเงิน</button><br><br>

</form>
                              </div>
                           </div>
                           
                        </div>
                     </div>
               </div>
            </div>
         </div>


         <div class="tabdepisitimg">
            <img src="css/4.png">
         </div>
         <!-- <div class="headerbankdt">
            ช่องทางการโอน
         </div>
         <hr class="x-hr-border-glow mb-3">
         <div class="row m-0 transfermoney">
            <div class="col-6 col-sm-4 p-1">
               <div class="p-2" data-toggle="modal" data-target="#angpaomodal">
                  <img src="css/angpal.png">
                  <div class="text-center">
                     ซองอั่งเปาทรูมันนี่
                  </div>
               </div>
            </div>
            <div class="col-6 col-sm-4 p-1">
               <div class="p-2" data-toggle="modal" data-target="#senddeposit">
                  <img src="css/bank01.svg">
                  <div class="text-center">
                     แจ้งฝากเงิน
                  </div>
               </div>
            </div>
            <div class="col-4 p-1">
               <div class="p-2"></div>
            </div>
         </div> -->

      </div>
</div>
</div>







<!-- Deposit SECTION -->

<!-- Withdraw SECTION -->
<?php 
               $sql77 = "SELECT * FROM deposit WHERE confirm_dp = 'อนุมัติ' AND phone_dp = '$phone_mb' ORDER BY id DESC limit 1";
          $result77 = mysqli_query($con, $sql77) or die ("Error in query: $sql " . mysqli_error());
          $row77 = mysqli_fetch_array($result77);
          extract($row77);
            ?>
<div id="withdrawtab" class="menucontent">
   <div class="backtohome" onclick="OpenMenu(event, 'hometab')">
      <button><i class="fas fa-angle-left"></i> ย้อนกลับ</button>
   </div>
<div class="inmenucontent">
          <div class="containdeposit animate__animated animate__flipInX">
            <div class="nmwdcontain">
               <div class="headerbankdt mt-2 mb-0">
                  <img src="css/cd.png"> ถอนเงิน
               </div>
               <div class="rulewd">
                  ***หากมีการรับโปรโมชั่นต้องทำตามเงื่อนไขที่กำหนดถึงจะสามารถถอนได้ <br>
                  ***หากไม่รับโปรโมชั่นสามารถถอนได้ทันที
               </div>
               <hr class="x-hr-border-glow mb-2 mt-2">
               <div class="headerbankdt mt-2 mb-0">
                  เลขบัญชีของท่าน
               </div>
               <div class="row m-0">
                  <div class="col-12 col-md-6 p-1">
                     <div class="bank-tf">
                        <input type="radio" id="control_412108028801" name="your_accounds" value="<?php echo $bankacc_mb;  ?>" checked>
                        <label class="m-0" for="control_412108028801">
                           <i class="fas fa-check-circle"></i>
                           <img src="css/<?php echo $bank_mb;  ?>.png" class="m-0" alt="">
                           <h2><?php echo $bankacc_mb;  ?></h2>
                           <p><?php echo $bank_mb;  ?></p>
                        </label>
                     </div>
                  </div>

                  <!-- <div class="col-12 col-md-6 p-1">
                     <div class="bank-tf">
                        <input type="radio" id="control_084034313502" name="your_accounds" value="TRUE-0840343135">
                        <label class="m-0" for="control_084034313502">
                           <i class="fas fa-check-circle"></i>
                           <img src="css/truewallet.svg" class="m-0" alt="">
                           <h2><?php echo $phone_true; ?></h2>
                           <p>ทรูมันนี่วอลเลท</p>
                        </label>
                     </div>
                  </div> -->
                  
                  <!-- <div class="col-12 col-md-6 p-1">
                        <div class="boxaddbank" data-toggle="modal" data-target="#bankmodal">
                           <i class="fas fa-plus-circle"></i>
                           เพิ่มบัญชี
                        </div>
                  </div> -->
               </div>
                
                  
                  
               <div class="headerbankdt mt-3 mb-1">
                  ยอดเทิร์นโอเวอร์ <?php echo $Balance;  ?> / <?php if ($row77['turnover']=='') {
                                                            echo 0;
                                                         }else{     
                                                         echo $row77['turnover'];}?>
               </div>
              <form action="withdraw_wd.php" method="POST">
               <div class=" form-group mb-4">
                  <div class="el-input">

                     <input type="text" class="form-control" name="lastpro" value="<?php echo $row77['promotion_dp'];?>" hidden="hide">
                    <input type="text" class="form-control" name="id_wd" value="<?php echo($id_mb); ?>" hidden="hide">
                    <input type="text" class="form-control" name="username_wd" value="<?php echo($username_mb); ?>" hidden="hide">
                    <input type="text" class="form-control" name="bank_wd" value="<?php echo($bank_mb); ?>" hidden="hide">
                    <input type="text" class="form-control" name="bankacc_wd" value="<?php echo($bankacc_mb); ?>" hidden="hide">
                    <input type="text" class="form-control" name="name_wd" value="<?php echo($name_mb); ?>" hidden="hide">
                    <input type="number" class="form-control" name="phone_wd" value="<?php echo($phone_mb); ?>" hidden="hide">
                    <input type="text" class="form-control" name="confirm_wd" value="รอดำเนินการ" hidden="hide">
                    <input type="text" class="form-control" name="creditufa" value="<?php echo($Balance); ?>" hidden="hide">
                     <input type="text" name="amount_wd"  placeholder="ถอนขั้นต่ำ <?php echo $set_wd; ?> บาท" class="inputstyle text-center p-0 py-2">
                  </div>
               </div>
               <button type="submit" class="loginbtn mt-0 mb-3" >
               <span>
               ถอนเงิน
               </span>
               </button></form>
            </div>

         </div>
         
      </div>
</div>
</div>
<!-- Withdraw SECTION -->



<!-- Promotion SECTION -->
<div id="promotiontab" class="menucontent">
   <div class="backtohome" onclick="OpenMenu(event, 'hometab')">
      <button><i class="fas fa-angle-left"></i> ย้อนกลับ</button>
   </div>
<div class="inmenucontent">
   <div class="menuhead"><i class="fad fa-gifts"></i> โปรโมชั่น</div>
         <div class="containslide">
            <div class="swiper prosw">
               <div class="swiper-wrapper">

                        <?php
                         $querypro = "SELECT * FROM promotion  ORDER BY id desc" or die("Error:" . mysqli_error());
                         $resultpro = mysqli_query($con, $querypro);
                        ?>
                        <?php foreach ($resultpro as $rowpro){ ?>


                  <div class="swiper-slide">
                     <img src="../slip/<?php echo $rowpro['fileupload_pro']; ?>">
                    
                     <button data-toggle="modal" data-target="#promodaldetail">รายละเอียดโปร</button>
                  </div>
                  <?php } ?>
               </div>
            </div>
            <div class="btnslide">
               <button class="btnleftslide"><i class="fad fa-caret-left"></i></button>
               <button class="btnrightslide"><i class="fad fa-caret-right"></i></button>
            </div>
         </div>
</div>
</div>
<!-- Promotion SECTION -->

<!-- history SECTION -->
<div id="historytab" class="menucontent">
   <div class="backtohome" onclick="OpenMenu(event, 'hometab')">
      <button><i class="fas fa-angle-left"></i> ย้อนกลับ</button>
   </div>
<div class="inmenucontent">
         <div class="ininmnct">
         <div class="menuhead"><i class="fas fa-history"></i> ประวัติ</div>
         <div class="row m-0 mt-3">
               <div class="col-2 p-0 leftdps">
                  <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                     <a class="nav-link green active" id="v-pills-dps-tab" data-toggle="pill" href="#v-pills-dps" role="tab" aria-controls="v-pills-dps" aria-selected="true">ฝาก</a>
                     <a class="nav-link red" id="v-pills-wd-tab" data-toggle="pill" href="#v-pills-wd" role="tab" aria-controls="v-pills-wd" aria-selected="false">ถอน</a>
                     <a class="nav-link red" id="s-pills-wd-tab" data-toggle="pill" href="#s-pills-wd" role="tab" aria-controls="s-pills-wd" aria-selected="false">โบนัส</a>
                  </div>
               </div>
               <div class="col-10 p-0 containhislist">
                  <div class="tab-content" id="v-pills-tabContent">
                     <div class="tab-pane fade show active" id="v-pills-dps" role="tabpanel" aria-labelledby="v-pills-dps-tab">
                        <div class="containerhis">

                           <?php
                        $querywd = "SELECT * FROM deposit WHERE id_dp=$id_mb ORDER BY id DESC limit 20";
                        $wdwdwd = mysqli_query($con, $querywd);
                        // echo $querywd;
                     ?>
                    <?php foreach ($wdwdwd as $rowwd){ ?>


                           <!--  Loop list DPS -->
                           <div class="listht">
                              <table>
                                 <tr>
                                    <td>
                                       <?php
                             
                                if ($rowwd["confirm_dp"]=="รอดำเนินการ") {
                                    echo"<span style='background: #c98e15;'>รอดำเนินการ</span>";
                                }
                                    elseif ($rowwd["confirm_dp"]=="อนุมัติ") {
                                        echo"<span style='background: #017a13;'>สำเร็จ</span>";
                                    }
                                    elseif ($rowwd["confirm_dp"]=="ปฏิเสธ") {
                                        echo"<span style='background: #db1b1b;'>ไม่สำเร็จ</span>";
                                    }
                                ?><br>
                                       <span class="timehis"><?php echo $rowwd['promotion_dp']; ?></span>
                                    </td>
                                    <td>
                                        <i class="fal fa-plus-circle plushis"></i> <?php echo $rowwd['amount_dp']; ?> บาท <br>
                                       <span class="timehis"><?php echo $rowwd['date_dp']; ?></span>
                                    </td>
                                 </tr>
                              </table>
                           </div><?php } ?>
                           
                           <!--  END Loop list DPS -->





                        </div>
                     </div>
                     <div class="tab-pane fade" id="v-pills-wd" role="tabpanel" aria-labelledby="v-pills-wd-tab">
                        <div class="containerhis">




                          <?php
        $querywd = "SELECT * FROM withdraw WHERE username_wd = '$username_mb' AND amount_wd != '' ORDER BY id DESC limit 20";
        $wdwdwd = mysqli_query($con, $querywd);
        // echo $querywd;
        ?>
        <?php foreach ($wdwdwd as $rowwd){ ?>


                           <!--  Loop list DPS -->
                           <div class="listht">
                              <table>
                                 <tr>
                                    <td>
                                       <?php
                             
                                if ($rowwd["confirm_wd"]=="รอดำเนินการ") {
                                    echo"<span style='background: #c98e15;'>รอดำเนินการ</span>";
                                }
                                    elseif ($rowwd["confirm_wd"]=="อนุมัติ") {
                                        echo"<span style='background: #017a13;'>สำเร็จ</span>";
                                    }
                                    elseif ($rowwd["confirm_wd"]=="ปฏิเสธ") {
                                        echo"<span style='background: #db1b1b;'>ไม่สำเร็จ</span>";
                                    }
                                ?><br>
                                       <span class="timehis"><?php echo $rowwd['note_wd']; ?></span>
                                    </td>
                                    <td>
                                       <i class="fal fa-minus-circle minushis"></i> <?php echo $rowwd['amount_wd']; ?> บาท <br>
                                       <span class="timehis"><?php echo $rowwd['date_wd']; ?></span>
                                    </td>
                                 </tr>
                              </table>
                           </div><?php } ?>




                        </div>
                     </div>
                      <div class="tab-pane fade" id="s-pills-wd" role="tabpanel" aria-labelledby="s-pills-wd-tab">
                        <div class="containerhis">




                         <?php
                        $querywd = "SELECT * FROM deposit WHERE id_dp=$id_mb AND promotion_dp!='ไม่รับโบนัส' ORDER BY id DESC";
                        $wdwdwd = mysqli_query($con, $querywd);
                        // echo $querywd;
                     ?>
                    <?php foreach ($wdwdwd as $rowwd){ ?>

                           <!--  Loop list DPS -->
                           <div class="listht">
                              <table>
                                 <tr>
                                    <td>
                                       <?php
                             
                                if ($rowwd["confirm_dp"]=="รอดำเนินการ") {
                                    echo"<span style='background: #c98e15;'>รอดำเนินการ</span>";
                                }
                                    elseif ($rowwd["confirm_dp"]=="อนุมัติ") {
                                        echo"<span style='background: #017a13;'>สำเร็จ</span>";
                                    }
                                    elseif ($rowwd["confirm_dp"]=="ปฏิเสธ") {
                                        echo"<span style='background: #db1b1b;'>ไม่สำเร็จ</span>";
                                    }
                                ?><br>
                                       <span class="timehis"><?php echo $rowwd['note_dp']; ?></span>
                                    </td>
                                    <td>
                                       <?php echo $rowwd['promotion_dp']; ?> <br>
                                       <span class="timehis"><?php echo $rowwd['date_dp']; ?></span>
                                    </td>
                                 </tr>
                              </table>
                           </div><?php } ?>




                        </div>
                     </div>
                  </div>
               </div></div>
      </div>
</div>
</div>
<!-- history SECTION -->

<!-- event SECTION -->
<div id="eventtab" class="menucontent">
   <div class="backtohome" onclick="OpenMenu(event, 'hometab')">
      <button><i class="fas fa-angle-left"></i> ย้อนกลับ</button>
   </div>
<div class="inmenucontent">
    <div class="menuhead"><i class="fad fa-trophy-alt"></i> สิทธิพิเศษ</div>
    <div class="eventbox">
       <div class="row m-0">
          <div class="col-6 col-sm-4 col-md-3">
            <form action="withdraw_cashback.php" method="POST">
                                       <input type="text" class="form-control" name="" required="required" value="<?php
                                $today_dp = date('Y-m-d',strtotime('-1 day'));
                                $querydp2 = "SELECT SUM(amount_dp) AS total FROM deposit WHERE confirm_dp ='อนุมัติ' AND phone_dp = '$phone_mb' AND promotion_dp='ไม่รับโบนัส' AND date_dp LIKE '%$today_dp%'";
                                $resultdp2 = mysqli_query($con, $querydp2);
                                $row = mysqli_fetch_assoc($resultdp2);
                                //echo $row['total'];


                                $today_wd = date('Y-m-d',strtotime('-1 day'));
                                $querywd2 = "SELECT SUM(amount_wd) AS total FROM withdraw WHERE confirm_wd='อนุมัติ' AND phone_wd = '$phone_mb' AND date_wd LIKE '%$today_wd%'";
                                $resultwd2 = mysqli_query($con, $querywd2);

                                $row2 = mysqli_fetch_assoc($resultwd2);
                                //echo $row['total'];

                                $total = $row['total'] - $row2['total'];
                              
                                $total2 = $total * $cashback / 100;

                                if ($total2<=0) {
                                    echo 0;
                                   
                                }
                                elseif ($total2>0) {
                                    echo "$total2";

                                }?>" readonly hidden>
                        <input type="text" class="form-control" name="id_wd" value="<?php echo($id_mb); ?>" hidden="hide" >
                        <input type="text" class="form-control" name="username_wd" value="<?php echo($username_mb); ?>" hidden="hide">
                        <input type="text" class="form-control" name="bank_wd" value="<?php echo($bank_mb); ?>" hidden="hide">
                        <input type="text" class="form-control" name="bankacc_wd" value="<?php echo($bankacc_mb); ?>" hidden="hide">
                        <input type="text" class="form-control" name="name_wd" value="<?php echo($name_mb); ?>" hidden="hide">
                        <input type="number" class="form-control" name="phone_wd" value="<?php echo($phone_mb); ?>" hidden="hide">
                        <input type="text" class="form-control" name="confirm_wd" value="อนุมัติ" hidden="hide">
             <div class="box">
                <img src="css/crown.svg">
                <div class="detail">
                  <span>รับเครดิตเงินคืน <?php echo $cashback; ?>%</span>
                  <button type="submit" class="btn btn-success btn-sm">กดรับยอดเสีย</button>
                </div>
             </div></form>
          </div>
          <div class="col-6 col-sm-4 col-md-3">
            <div class="box">
                <img src="css/exchange.svg">
                <div class="detail">
                  <span>แลกรางวัล</span>
                  <button type="button" class="btn btn-danger btn-sm">พบกันเร็ว ๆ นี้!</button>
                  
                </div>
            </div>
          </div>
          <div class="col-6 col-sm-4 col-md-3">
            <div class="box">
                <img src="css/money-bag.svg">
                <div class="detail">
                  <span>หมุนกงล้อเสี่ยงโชค</span>
                  <button type="button" class="btn btn-danger btn-sm">พบกันเร็ว ๆ นี้!</button>
                </div>
            </div>
          </div>
          <div class="col-6 col-sm-4 col-md-3">
            <div class="box">
             <img src="css/shield.svg">
             <div class="detail">
               <span>รางวัลประจำเดือน</span>
               <button type="button" class="btn btn-danger btn-sm">พบกันเร็ว ๆ นี้!</button>
             </div>
            </div>
          </div>
       </div>
    </div>
</div>
</div>
<!-- event SECTION -->

<!-- hisplay SECTION -->
<div id="hisplaytab" class="menucontent">
   <div class="backtohome" onclick="OpenMenu(event, 'hometab')">
      <button><i class="fas fa-angle-left"></i> ย้อนกลับ</button>
   </div>
<div class="inmenucontent">
   <div class="menuhead"><i class="fad fa-trophy-alt"></i> ประวัติการเล่น</div>
</div>
</div>
<!-- hisplay SECTION -->

<div id="spiner" class="menucontent">
   <div class="backtohome" onclick="OpenMenu(event, 'hometab')">
      <button><i class="fas fa-angle-left"></i> &#3618;&#3657;&#3629;&#3609;&#3585;&#3621;&#3633;&#3610;</button>
   </div>
<div class="inmenucontent">
   <div class="menuhead"><i class="fad fa-trophy-alt"></i> &#3623;&#3591;&#3621;&#3657;&#3629;&#3614;&#3634;&#3650;&#3594;&#3588;</div><br>
   <center><h5>&#3614;&#3657;&#3629;&#3618;&#3604;&#3660;&#3586;&#3629;&#3591;&#3607;&#3656;&#3634;&#3609; : <font color="#fff200" id="spinpoint">
                            
                            <?php 
                                if ($point=='') {
                                   echo 0;
                                }else{
                                echo $point;
                            }?> 
                            
                            </font></h5></center>
                            <form action="change_credit.php" method="POST" onsubmit="return confirm('&#3605;&#3657;&#3629;&#3591;&#3585;&#3634;&#3619;&#3649;&#3621;&#3585;&#3614;&#3657;&#3629;&#3618;&#3604;&#3660;!')">
                                <input type="text" class="form-control" name="id" value="<?php echo($id_mb); ?>" hidden="hide" >
                        <input type="text" class="form-control" name="username" value="<?php echo($username_mb); ?>" hidden="hide">
                        <input type="text" class="form-control" name="phone" value="<?php echo($phone_mb); ?>" hidden="hide">


                            <center><button type="submit" class="btn btn-success">&#3649;&#3621;&#3585;&#3619;&#3634;&#3591;&#3623;&#3633;&#3621;</button></form></center><br>
                             <center><h5>&#3618;&#3629;&#3604;&#3613;&#3634;&#3585;  : <font color="#fff200" id="spinpoint">
                            <?php echo $dp_creditspin;?> &#3610;&#3634;&#3607;&#3586;&#3638;&#3657;&#3609;&#3652;&#3611;
                            </font> &#3605;&#3656;&#3629; 1 &#3610;&#3636;&#3621; &#3652;&#3604;&#3657; 1 &#3626;&#3636;&#3607;&#3608;&#3636;&#3660;&#3585;&#3634;&#3619;&#3627;&#3617;&#3640;&#3609;</h5></center>
                            <center><h5>1 &#3614;&#3657;&#3629;&#3618;&#3604;&#3660; &#3649;&#3621;&#3585;&#3652;&#3604;&#3657;  : <font color="#fff200" id="spinpoint">
                            
                            <?php echo $change_point;?> &#3648;&#3588;&#3619;&#3604;&#3636;&#3605;
                            </font></h5></center>


                            <?php
if(!isset($_SESSION['id_mb'])){
    //echo "<script>window.location = './login'</script>";
    //exit;
}else{
include('spinner/Class.php');


?>

<style>
.sWheel-wrapper{
    margin: auto;
    border-radius:100%;
    color: #CDA33A;
    box-shadow: 0px 0px 20px 1px;
}
.effect-color{
    animation: colours 1s infinite;
}
@-webkit-keyframes colours {
      0% {color: #39f;}
     15% {color: #8bc5d1;}
     30% {color: #f8cb4a;}
     45% {color: #95b850;}
     60% {color: #944893;}
     75% {color: #c71f00;}
     90% {color: #bdb280;}
    100% {color: #39f;}
}
</style>
<div class="text-center">
    <div class="wheel-with-image superWheel _0"></div>
    <h3 class="spinner-start text-center text-white mt-3">&nbsp;</h3>
    <h3 class="spinner-show-message text-center mt-3"></h3>
    <div class="d-grid gap-2 col-lg-5 col-10 mx-auto mt-3">
        <button class="btn btn-success wheel-with-image-spin-button" type="button">&#3627;&#3617;&#3640;&#3609;&#3623;&#3591;&#3621;&#3657;&#3629;</button>
    </div>
</div>

<script type="text/javascript">
var Image1 = "<?php echo $s_Image1; ?>";
var Image2 = "<?php echo $s_Image2; ?>";
var Image3 = "<?php echo $s_Image3; ?>";
var Image4 = "<?php echo $s_Image4; ?>";
var Image5 = "<?php echo $s_Image5; ?>";
var Image6 = "<?php echo $s_Image6; ?>";
var Image7 = "<?php echo $s_Image7; ?>";
var Image8 = "<?php echo $s_Image8; ?>";
var ImageCenter = "<?php echo $s_ImageCenter; ?>";
var LICENSE = "<?php echo $LICENSE; ?>";
var updatepoint = "";
</script>

<?php } ?>

<div class="containerhis">


    <div class="menuhead">&#3611;&#3619;&#3632;&#3623;&#3633;&#3605;&#3636;&#3627;&#3617;&#3640;&#3609;&#3623;&#3591;&#3621;&#3657;&#3629;</div>

                         <?php
                    
                        $querywd499 = "SELECT * FROM history_spin WHERE username='$username_mb' ORDER BY id DESC LIMIT 5";
                        $wdwdwd499 = mysqli_query($con, $querywd499);
                       
                     ?>
                    <?php foreach ($wdwdwd499 as $rowwd499){ ?>

                           <!--  Loop list DPS -->
                           <div class="listht">
                              <table>
                                 <tr>
                                    <td>
                                       <?php
                             
                                
                                        echo"<span style='background: #017a13;'>&#3626;&#3635;&#3648;&#3619;&#3655;&#3592;</span>";
                                    
                                ?><br>
                                       
                                    </td>
                                    <td>
                                       <i class="fal fa-minus-circle minushis"></i>&#3619;&#3634;&#3591;&#3623;&#3633;&#3621; : <?php echo $rowwd499['reward']; ?>  <br>
                                       <span class="timehis"><?php echo $rowwd499['time']; ?></span>
                                    </td>
                                 </tr>
                              </table>
                           </div><?php } ?>




                        </div>


</div>
</div>                            


<!-- Friend SECTION -->
<div id="friendtab" class="menucontent">
   <div class="backtohome" onclick="OpenMenu(event, 'hometab')">
      <button><i class="fas fa-angle-left"></i> ย้อนกลับ</button>
   </div>
<div class="inmenucontent">
   <div class="menuhead"><i class="fad fa-users-crown"></i>  แนะนำเพื่อนรับ <?php echo $affcashback; ?>% <br>จากยอดฝากของเพื่อนทุกคน</div>

   <div class="ininmnct">

         <div class="friendsimg">
            <img src="css/friends.png">
         </div><br>
         <div class="detailwd frienddetail">
                     <div class="headerinput text-center m-0 mb-1"><span>รายได้ปัจจุบันที่รับได้</span></div>
                     <table align="center">
                        <tr>
                         
                           <td class="tbfriendleft">
                             <br>
                              <h4><?php
                        $month_dp = date('Y-m',strtotime('-1 month')) ;
                        $aff5 = $phone_mb;
                        $query = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp = 'อนุมัติ' AND aff_dp = $aff5 AND date_dp LIKE '%$month_dp%'";
                        $result = mysqli_query($con, $query);
                        while($row = mysqli_fetch_array($result)){
                        echo $row['SUM(amount_dp)'] * $affcashback / 100;
                        
                        } ?> บาท</h4>
                           </td>
                        </tr>
                     </table>
                     <form action="withdraw_aff.php" method="POST">
                     <input type="number" class="form-control" name="" required="required" value="<?php
                        $month_dp = date('Y-m',strtotime('-1 month')) ;
                        $aff5 = $phone_mb;
                        $query = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp = 'อนุมัติ' AND aff_dp = $aff5 AND date_dp LIKE '%$month_dp%'";
                        $result = mysqli_query($con, $query);
                        while($row = mysqli_fetch_array($result)){
                        echo $row['SUM(amount_dp)'] * $affcashback / 100;
                        
                        } ?>" readonly hidden>
                        
                        <input type="text" class="form-control" name="id_aff" value="<?php echo($id_mb); ?>" hidden="hide" >
                        <input type="text" class="form-control" name="username_aff" value="<?php echo($username_mb); ?>" hidden="hide">
                        <input type="text" class="form-control" name="bank_aff" value="<?php echo($bank_mb); ?>" hidden="hide">
                        <input type="text" class="form-control" name="bankacc_aff" value="<?php echo($bankacc_mb); ?>" hidden="hide">
                        <input type="text" class="form-control" name="name_aff" value="<?php echo($name_mb); ?>" hidden="hide">
                        <input type="number" class="form-control" name="phone_aff" value="<?php echo($phone_mb); ?>" hidden="hide">
                        <input type="text" class="form-control" name="confirm_aff" value="รอดำเนินการ" hidden="hide">
                     <div class="btnwd mt-1 text-center"><button type="submit" class="colorbtn01 p-2 mcolor">แจ้งถอนรายได้</button></div></form>
                  </div>
         <div class="headerbankdt mt-2 mb-0">
            <img src="css/cd.png"> บัญชีรับรายได้
         </div>
         <hr class="x-hr-border-glow mb-1 mt-1">
         <div class="row m-0">
                  <div class="col-12 col-md-6 p-1">
                     <div class="bank-tf">
                        <input type="radio" id="control_412108028801" name="your_accounds" value="<?php echo $bankacc_mb;  ?>" checked>
                        <label class="m-0" for="control_412108028801">
                           <i class="fas fa-check-circle"></i>
                           <img src="css/<?php echo $bank_mb;  ?>.png" class="m-0" alt="">
                           <h2><?php echo $bankacc_mb;  ?></h2>
                           <p><?php echo $bank_mb;  ?></p>
                        </label>
                     </div>
                  </div>
                  
                 
               </div>
         <div class="text-center friendtext">
            คัดลอกลิงค์
            <div class=" form-group mb-0">
               <div class="el-input">
                  <i class="fad fa-users-medical"></i>
                
                  <input type="text" onclick="copylink()" id="friendlink" class="inputstyle copylink" readonly value="https://<?php echo $link_aff; ?>?aff=<?php echo($phone_mb);?>">
               </div>
            </div>
         </div>
         <div class="containinputwd mt-3 mb-1" id="allfriend">
            <table class="mt-0 levelfriend">
               <tbody>
                  <tr>
                     <td class="text-left">
                        <i class="fad fa-coins"></i> <span>ส่วนแบ่งรายได้จากยอดฝากเพื่อน </span>
                     </td>
                     <td class="text-right">
                        <span><?php echo $affcashback; ?>%</span>
                     </td>
                  </tr>
                 
               </tbody>
            </table>
            <div>
               <div class="headdtf">
                  <span class="detailaf">รายละเอียด</span>
               </div>
               <div role="alert" class="frienddetail">
                  <div class="row m-0" style="padding-top: 5px;">
                           <div class="col-6 p-0 text-left">
                              <span>เพื่อนทั้งหมด</span>
                           </div>
                           <div class="col-6 p-0 text-right"><?php
                                                                   $aff5 = $phone_mb;
                                                                   $query3 = "SELECT * FROM member WHERE aff = $aff5 ";
                                                                   $result3 = mysqli_query($con, $query3);
                                                                   $nrow = mysqli_num_rows($result3);
                                                                   echo $nrow;
                                                                   ?> คน</div>
             
                        </div>
                        <div class="row m-0" style="padding-top: 5px;">
                           <div class="col-6 p-0 text-left">
                              <span>ยอดฝากเดือนนี้</span>
                           </div>
                           <div class="col-6 p-0 text-right"><?php
                                                                $month_dp = date('Y-m') ;
                                                                $aff5 = $phone_mb;
                                                                $query = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp = 'อนุมัติ' AND aff_dp = $aff5 AND date_dp LIKE '%$month_dp%'";
                                                                $result = mysqli_query($con, $query);
                                                                while($row = mysqli_fetch_array($result)){
                                                                echo $row['SUM(amount_dp)'] * 1 / 1;
                                                                
                                                                } ?> บาท</div>
                    
                        </div>
                        <div class="row m-0" style="padding-top: 5px;">
                           <div class="col-6 p-0 text-left">
                              <span>ยอดฝากเดือนที่แล้ว</span>
                           </div>
                           <div class="col-6 p-0 text-right"><?php
                                                                $month_dp = date('Y-m',strtotime('-1 month')) ;
                                                                $aff5 = $phone_mb;
                                                                $query = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp = 'อนุมัติ' AND aff_dp = $aff5 AND date_dp LIKE '%$month_dp%'";
                                                                $result = mysqli_query($con, $query);
                                                                while($row = mysqli_fetch_array($result)){
                                                                echo $row['SUM(amount_dp)'] * 1 / 1;
                                                                
                                                                } ?> บาท</div>
                       
                        </div>
                        <div class="row m-0" style="padding-top: 5px;">
                           <div class="col-6 p-0 text-left">
                              <span>ยอดฝากทั้งหมด</span>
                           </div>
                           <div class="col-6 p-0 text-right"><?php
                                                                $aff5 = $phone_mb;
                                                                $query = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp = 'อนุมัติ' AND aff_dp = $aff5";
                                                                $result = mysqli_query($con, $query);
                                                                while($row = mysqli_fetch_array($result)){
                                                                echo $row['SUM(amount_dp)'] * 1 / 1;
                                                                
                                                                } ?> บาท</div>
                          
                        </div>
                        <div class="row m-0" style="padding-top: 5px;">
                           <div class="col-6 p-0 text-left">
                              <span>รายได้เดือนนี้</span>
                           </div>
                           <div class="col-6 p-0 text-right"><?php
                        $month_dp5 = date('Y-m') ;
                        $aff = $phone_mb;
                        $query5 = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp = 'อนุมัติ' AND aff_dp = $aff5 AND date_dp LIKE '%$month_dp5%'";
                        $result5 = mysqli_query($con, $query5);
                        while($row5 = mysqli_fetch_array($result5)){
                        echo $row5['SUM(amount_dp)'] * $affcashback / 100;
                        
                        } ?> บาท</div>
                           
                        </div>
               </div>
            </div>
         </div>
      </div>
</div>
</div>
<!-- Friend SECTION -->

       











<!-- setting SECTION -->
<div id="settingtab" class="menucontent">
   <div class="backtohome" onclick="OpenMenu(event, 'hometab')">
      <button><i class="fas fa-angle-left"></i> ย้อนกลับ</button>
   </div>
<div class="inmenucontent">
    <div class="menuhead"><i class="fad fa-wrench"></i> เครื่องมือ</div>
    <div class="eventbox">
       <div class="row m-0">
          <div class="col-6 col-sm-4 col-md-3">
             <div class="box" data-toggle="modal" data-target="#bankmodal">
                <img src="css/bankicon.png?v=2">
                <div class="detail">
                  <span>ธนาคารของฉัน</span>
                </div>
             </div>
          </div>
          <div class="col-6 col-sm-4 col-md-3">
            <div class="box" onclick="location.href='<?php echo($line_id); ?>'">
                <img src="css/qa.svg">
                <div class="detail">
                  <span>ติดต่อทีมงาน</span>
                </div>
            </div>
          </div>
          <!-- <div class="col-6 col-sm-4 col-md-3">
            <div class="box" data-toggle="modal" data-target="#changepwdmodal">
                <img src="css/padlock.svg">
                <div class="detail">
                  <span>เปลี่ยนรหัสผ่าน</span>
                </div>
            </div>
          </div> -->
       </div>
    </div>
</div>
</div>
<!-- setting SECTION -->













               </div>
            </div>
         </div>
      </div>
















<!-- Play Game POPUP -->

<!-- Modal -->


<div class="modal fade" id="playgamepopup"  data-backdrop="static" tabindex="-1" aria-labelledby="playgamepopupLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modalcontent">
      <div class="modal-header headmodalcontent">
        <h5 class="modal-title" id="playgamepopupLabel">เข้าเล่น UFABET</h5>
        <i class="fas fa-times" data-dismiss="modal" aria-label="Close"></i>
      </div>
      <div class="modal-body">
         จำนวนเงินที่ต้องการโยก
         <div class="form-group my-2">
                              <div class="el-input my-1">
                                 <i class="fas fa-coin"></i>
                                 <input type="number" value="100" placeholder="กรอกจำนวนเงิน" class="inputstyle text-center">
                              </div>
         </div>
      </div>
      <div class="text-center my-2">
        <button type="button" class="btn btn-dark" data-dismiss="modal">ปิด</button> 
        <button type="button" class="btn btn-danger" >เข้าเล่นเดิมพัน</button> 
      </div>
    </div>
  </div>
</div>

<!-- Play Game POPUP -->















<!-- QR CODE POPUP -->

<!-- Modal -->


<div class="modal fade" id="qrcodepopup"  data-backdrop="static" tabindex="-1" aria-labelledby="qrcodepopupLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modalcontent">
      <div class="modal-header headmodalcontent">
        <h5 class="modal-title" id="qrcodepopupLabel">กรุณาฝากเงินตามยอดที่ระบุในเวลาที่กำหนด</h5>
      </div>
      <div class="modal-body">
         <div class="thaiqrct">
            <img src="css/thaiqrcode.png">
         </div>
          <div class="ctqrcode">
             <img class="d-block mx-auto mb-2" src="css/pp.png">
              <img src="images/qrcode/qrcode.png">
          </div>
          <div class="moneyqrcode">
             ยอดโอน <span>100.49</span> บาท
          </div>
          <div class="rulewd bg-warning text-dark text-center">
               ต้องโอนยอดที่ตรงกับระบบกำหนดเท่านั้น สามารถสแกนโอนด้วยแอพลิเคชั่นได้ทุกธนาคาร สามารถโอนผ่านระบบพร้อมเพย์ได้เช่น Truemoney, ShopeePay, DolfinWallet **ยอดฝาก จะเข้าอัตโนมัติ ภายใน 30 วินาทีถึง 3 นาที
               <div class="rulewd">
               QR CODE นี้ใช้ฝากได้ครั้งเดียว ห้ามสแกนฝากซ้ำด้วย QR เดิม
               </div>
          </div>
      </div>
      <div class="text-center my-2">
        <button type="button" class="btn btn-dark" data-dismiss="modal">ยกเลิก/สร้าง QR CODE ใหม่</button> 
      </div>
    </div>
  </div>
</div>

<!-- QR CODE POPUP -->








<!-- changepassword Deposit -->

<!-- Modal -->


<div class="modal fade" id="changepwdmodal" tabindex="-1" aria-labelledby="changepwdmodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modalcontent">
      <div class="modal-header headmodalcontent">
        <h5 class="modal-title" id="changepwdmodalLabel">เปลี่ยนรหัสผ่าน</h5>
        <i class="fas fa-times" data-dismiss="modal" aria-label="Close"></i>
      </div>
      <div class="modal-body">
                <div class="row m-0">
                  <form method="post" action="chk_pass">
                        <div class="col-6 form-group p-0 pr-1">
                           <div>
                              <label>เบอร์โทรศัพท์ที่ใช้สมัคร</label> 
                              <div class="el-input my-1">
                                 <i class="fas fa-user"></i>
                                 <input type="text" name="phone_mb" placeholder="เบอร์โทรศัพท์ที่ใช้สมัคร" class="inputstyle">
                              </div>
                           </div>
                           </div>
                           
                               <div class="col-6 form-group p-0 pl-1">
                           <div>
                              <label>รหัสผ่านเก่า</label> 
                              <div class="el-input my-1">
                                 <i class="fas fa-user"></i>
                                 <input type="text" name="password_mb" placeholder="รหัสผ่านเก่า" class="inputstyle">
                              </div>
                           </div>
                           </div>
                           <div class="col-6 form-group p-0 pr-1">
                           <div>
                              <label>รหัสผ่านใหม่</label> 
                              <div class="el-input my-1">
                                 <i class="fas fa-user"></i>
                                 <input type="text" name="newpass" placeholder="รหัสผ่านใหม่" class="inputstyle">
                              </div>
                           </div>
                           </div>
                           <div class="col-6 form-group p-0 pl-1">
                           <div>
                              <label>ยืนยันรหัสผ่านใหม่</label> 
                              <div class="el-input my-1">
                                 <i class="fas fa-user"></i>
                                 <input type="text" name="newpass2" placeholder="ยืนยันรหัสผ่าน" class="inputstyle">
                              </div>
                           </div>
                           </div>
                  </div>     

      </div>

      <div class="modal-footer footermodalcontent">
         
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button> 
      </div>
    </div>
  </div>
</div>

<!-- changepassword Deposit -->





























<!-- Bank WD -->

<!-- Modal -->


<div class="modal fade" id="bankmodal" tabindex="-1" aria-labelledby="bankmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content modalcontent">
      <div class="modal-header headmodalcontent">
        <h5 class="modal-title" id="bankmodalLabel">ธนาคาร</h5>
        <i class="fas fa-times" data-dismiss="modal" aria-label="Close"></i>
      </div>
      <div class="modal-body bankwd">
         <div class="row m-0">
            <div class="col-6 col-md-6 col-lg-4 p-1">
               <div class="box">
                  <table>
                     <tr>
                        <td>
                           <img src="../logobank/<?php echo($bank_mb); ?>.png">
                        </td>
                        <td>
                           สถานะ <span class="badge rounded-pill bg-success"><i class="fas fa-check-circle"></i> อนุมัติ</span>
                           <br><?php echo($bankacc_mb); ?>
                           <br><?php echo($bank_mb); ?>
                        </td>
                     </tr>
                  </table>
               </div>
            </div>

            
<!-- 
            <div class="col-6 col-md-6 col-lg-4 p-1">
               <div class="box">
                  <div class="addnewbankbtn"  data-toggle="modal" data-target="#addnewbank">
                     <i class="fas fa-plus-circle"></i> เพิ่มบัญชี
                  </div>
               </div>
            </div> -->
         </div>
      </div>
      <div class="modal-footer footermodalcontent">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button> 
      </div>
    </div>
  </div>
</div>

<!-- Bank WD -->






<!-- Add New Bank -->

<!-- Modal -->


<div class="modal fade" id="addnewbank" tabindex="-1" aria-labelledby="addnewbankLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modalcontent bgaddnewbank">
      <div class="modal-header headmodalcontent">
        <h5 class="modal-title" id="addnewbankLabel"><i class="fas fa-plus-circle"></i> เพิ่มบัญชี</h5>
        <i class="fas fa-times" data-dismiss="modal" aria-label="Close"></i>
      </div>
      <div class="modal-body ">
         <div class="row m-0">
            <div class="col-6 form-group p-0 pr-2">
                              <div class=" form-group">
                                 <div>
                                    <label> เลือกธนาคาร</label> 
                                    <div class="el-input my-1">
                                       <i class="fas fa-university"></i>
                                       <select name="" class="inputstyle" id="">
                                          <option value="">เลือกธนาคาร</option>
                                          <option value="bbl">ธนาคารกรุงเทพ</option>
                                      <option value="kbank">ธนาคารกสิกรไทย</option>
                                      <option value="ktb">ธนาคารกรุงไทย</option>
                                      <option value="scb">ธนาคารไทยพาณิชย์</option>
                                      <option value="bay">ธนาคารกรุงศรีอยุธยา</option>
                                      <option value="cimb">ธนาคารซีไอเอ็มบี</option>
                                      <option value="ibank">ธนาคารอิสลามแห่งประเทศไทย</option>
                                      <option value="kk">ธนาคารเกียรตินาคิน</option>
                                      <option value="lhb">ธนาคารแลนด์ แอนด์ เฮ้าส์</option>
                                      <option value="sc">ธนาคารสแตนดาร์ดชาร์เตอร์ด (ไทย)</option>
                                      <option value="tbnk">ธนาคารธนชาต</option>
                                      <option value="tisco">ธนาคารทิสโก้</option>
                                      <option value="ttb">ธนาคารทหารไทยธนชาต</option>
                                      <option value="uob">ธนาคารยูโอบี</option>
                                      <option value="gsb">ธนาคารออมสิน</option>
                                      <option value="baac">ธ.เพื่อการเกษตรและสหกรณ์การเกษตร</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                               </div>
                               <div class="col-6 form-group p-0 pl-2">
                           <div>
                              <label>เลขบัญชีธนาคาร</label> 
                              <div class="el-input my-1">
                                 <i class="fas fa-user"></i>
                                 <input type="text" placeholder="เลขบัญชีธนาคาร" class="inputstyle">
                              </div>
                           </div>
                           </div>
         </div>
         
         <!-- <div class="col-md-6 col-12 mb-2">
            <input type="text" class="form-control" id="" placeholder="รหัส OTP..." required>
            </div> -->
      </div>
      <div class="modal-footer footermodalcontent">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button> 
        <button type="button" class="btn btn-success">บันทึก</button>
      </div>
    </div>
  </div>
</div>

<!-- Add New Bank -->















<!-- AngPao Deposit -->

<!-- Modal -->


<div class="modal fade" id="angpaomodal" tabindex="-1" aria-labelledby="angpaomodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modalcontent">
      <div class="modal-header headmodalcontent">
        <h5 class="modal-title" id="angpaomodalLabel">กฎกติกาและข้อบังคับการใช้งาน</h5>
        <i class="fas fa-times" data-dismiss="modal" aria-label="Close"></i>
      </div>
      <div class="modal-body angpaocontent">
         <div class="learnangpao">
            <img src="css/01.jpg">
            <img src="css/02.jpg">
            <img src="css/03.jpg">
         </div>
         <div class=" form-group my-2">
                           <div>
                              <label>ใส่ลิงค์ซองอั่งเปา (คลิกเพื่อดูวิธีใช้งาน)</label> 
                              <div class="el-input my-1">
                                 <i class="fas fa-user"></i>
                                 <input type="text" placeholder="ตัวอย่าง: https://gift.truemoney.com/campaign/?v=xxxxxxxxxxxxxxxxxx" class="inputstyle">
                              </div>
                           </div>
                        </div>
                          <button type="button" class="loginbtn active mt-3" onclick="gotoregister()">
                        <span>
                        ยืนยัน
                        </span>
                        </button>
      </div>
      <div class="modal-footer footermodalcontent">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button> 
      </div>
    </div>
  </div>
</div>

<!-- AngPao Deposit -->





<!-- Send Deposit -->
<div class="modal fade" id="senddeposit" tabindex="-1" aria-labelledby="senddepositLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modalcontent">
      <div class="modal-header headmodalcontent">
        <h5 class="modal-title" id="senddepositLabel">แจ้งฝากเงิน</h5>
        <i class="fas fa-times" data-dismiss="modal" aria-label="Close"></i>
      </div>
      <div class="modal-body">
         <div class="modal-body text-left" style="font-size: 0.8em;">
   <h6 class="title-tf">บัญชีธนาคารที่โอนเข้า *</h6>
   <div class="bank-tf">
      <input type="radio" id="control_412108028803" name="dest_account" value="SCB-4121080288" checked>
      <label for="control_412108028803">
         <i class="fas fa-check-circle"></i>
         <img src="css/scb.svg" class="m-0" alt="">
         <h2>4121080288</h2>
         <p>ธนาคารไทยพาณิชย์ จำกัด (มหาชน)</p>
      </label>
   </div>
   <div class="bank-tf">
      <input type="radio" id="control_084034313503" name="dest_account" value="TRUE-0840343135">
      <label for="control_084034313503">
         <i class="fas fa-check-circle"></i>
         <img src="css/truewallet.svg" class="m-0" alt="">
         <h2>0840343135</h2>
         <p>ทรูมันนี่วอลเลท</p>
      </label>
   </div>
   <div class="bank-tf">
      <input type="radio" id="control_838266287703" name="dest_account" value="scb-8382662877">
      <label for="control_838266287703">
         <i class="fas fa-check-circle"></i>
         <img src="css/scb.svg" class="m-0" alt="">
         <h2>8382662877</h2>
         <p>ธนาคารไทยพาณิชย์ จำกัด (มหาชน)</p>
      </label>
   </div>

   <h6 class="title-tf">"ระบุจำนวนเงิน *</h6>
   <div class="input-group mb-1 mt-2">
      <span class="input-group-text">฿</span>
      <input type="number" min="0.01" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control" name="amount" placeholder="ระบุจำนวนเงิน" required="">
      
   </div>
   <div class="row">
      <div class="form-group col-12 col-sm-6">
         <label for="">โอนจากบัญชี</label>
         <div tabindex="-1" role="group" class="select-group">
            <select class="form-control" name="src_account" id="account-select" required="">
               <option value="">เลือกบัญชีธนาคาร</option>
               <option value="SCB-4095477101">SCB-4095477101</option>
            </select>
            <i class="bi bi-chevron-down"></i>
         </div>
      </div>
      <div class="form-group col-12 col-sm-6">
         <label for="">รูปแบบการโอน</label>
         <div tabindex="-1" role="group" class="select-group">
            <select class="form-control" name="method" id="method-select" required="">
               <option value="">เลือกรูปแบบ</option>
               <option value="ebank">โอนผ่านแอพ หรือเว็บไซต์ธนาคาร</option>
               <option value="atm">ATM</option>
               <option value="cdm">CDM (เครื่องฝากเงิน)</option>
            </select>
            <i class="bi bi-chevron-down"></i>
         </div>
      </div>
   </div>
   <div class="row">
      <!-- <div class="col"> -->
      <div class="form-group col-4">
         <label for="">วัน</label>
         <div tabindex="-1" role="group" class="select-group">
            <select class="form-control" name="day" id="" required="">
               <option value="">เลือก</option>
               <option value="00">00</option>
               <option value="01">01</option>
               <option value="02">02</option>
               <option value="03">03</option>
               <option value="04">04</option>
               <option value="05">05</option>
               <option value="06">06</option>
               <option value="07">07</option>
               <option value="08">08</option>
               <option value="09">09</option>
               <option value="10">10</option>
               <option value="11">11</option>
               <option value="12">12</option>
               <option value="13">13</option>
               <option value="14" selected="">14</option>
               <option value="15">15</option>
               <option value="16">16</option>
               <option value="17">17</option>
               <option value="18">18</option>
               <option value="19">19</option>
               <option value="20">20</option>
               <option value="21">21</option>
               <option value="22">22</option>
               <option value="23">23</option>
               <option value="24">24</option>
               <option value="25">25</option>
               <option value="26">26</option>
               <option value="27">27</option>
               <option value="28">28</option>
               <option value="29">29</option>
               <option value="30">30</option>
               <option value="31">31</option>
            </select>
            <i class="bi bi-chevron-down"></i>
         </div>
      </div>
      <div class="form-group col-4">
         <label for="">เดือน</label>
         <div tabindex="-1" role="group" class="select-group">
            <select class="form-control" name="month" id="" required="">
               <option value="">เลือก</option>
               <option value="01">มกราคม</option>
               <option value="02">กุมภาพันธ์</option>
               <option value="03">มีนาคม</option>
               <option value="04">เมษายน</option>
               <option value="05">พฤษภาคม</option>
               <option value="06">มิถุนายน</option>
               <option value="07">กรกฎาคม</option>
               <option value="08">สิงหาคม</option>
               <option value="09">กันยายน</option>
               <option value="10">ตุลาคม</option>
               <option value="11">พฤศจิกายน</option>
               <option value="12" selected="">ธันวาคม</option>
            </select>
            <i class="bi bi-chevron-down"></i>
         </div>
      </div>
      <div class="form-group col-4">
         <label for="">ปี ค.ศ.</label>
         <div tabindex="-1" role="group" class="select-group">
            <select class="form-control" name="year" id="" required="">
               <option value="">เลือก</option>
               <option value="2021" selected="">2021</option>
               <option value="2020">2020</option>
            </select>
            <i class="bi bi-chevron-down"></i>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="form-group col-4 col-sm-4">
         <label for="">ชั่วโมง</label>
         <div tabindex="-1" role="group" class="select-group">
            <select class="form-control" name="hour" id="" required="">
               <option value="">เลือก</option>
               <option value="00">00</option>
               <option value="01">01</option>
               <option value="02">02</option>
               <option value="03">03</option>
               <option value="04">04</option>
               <option value="05">05</option>
               <option value="06">06</option>
               <option value="07">07</option>
               <option value="08">08</option>
               <option value="09">09</option>
               <option value="10">10</option>
               <option value="11" selected="">11</option>
               <option value="12">12</option>
               <option value="13">13</option>
               <option value="14">14</option>
               <option value="15">15</option>
               <option value="16">16</option>
               <option value="17">17</option>
               <option value="18">18</option>
               <option value="19">19</option>
               <option value="20">20</option>
               <option value="21">21</option>
               <option value="22">22</option>
               <option value="23">23</option>
            </select>
            <i class="bi bi-chevron-down"></i>
         </div>
      </div>
      <div class="form-group col-4 col-sm-4">
         <label for="">นาที</label>
         <div tabindex="-1" role="group" class="select-group">
            <select class="form-control" name="minute" id="" required="">
               <option value="">เลือก</option>
               <option value="00">00</option>
               <option value="01">01</option>
               <option value="02">02</option>
               <option value="03">03</option>
               <option value="04">04</option>
               <option value="05">05</option>
               <option value="06">06</option>
               <option value="07">07</option>
               <option value="08">08</option>
               <option value="09">09</option>
               <option value="10">10</option>
               <option value="11">11</option>
               <option value="12">12</option>
               <option value="13">13</option>
               <option value="14">14</option>
               <option value="15">15</option>
               <option value="16">16</option>
               <option value="17">17</option>
               <option value="18">18</option>
               <option value="19">19</option>
               <option value="20">20</option>
               <option value="21">21</option>
               <option value="22">22</option>
               <option value="23">23</option>
               <option value="24">24</option>
               <option value="25">25</option>
               <option value="26">26</option>
               <option value="27">27</option>
               <option value="28">28</option>
               <option value="29">29</option>
               <option value="30">30</option>
               <option value="31">31</option>
               <option value="32">32</option>
               <option value="33">33</option>
               <option value="34">34</option>
               <option value="35">35</option>
               <option value="36">36</option>
               <option value="37">37</option>
               <option value="38">38</option>
               <option value="39">39</option>
               <option value="40">40</option>
               <option value="41">41</option>
               <option value="42">42</option>
               <option value="43">43</option>
               <option value="44">44</option>
               <option value="45">45</option>
               <option value="46">46</option>
               <option value="47">47</option>
               <option value="48">48</option>
               <option value="49">49</option>
               <option value="50">50</option>
               <option value="51">51</option>
               <option value="52">52</option>
               <option value="53">53</option>
               <option value="54">54</option>
               <option value="55">55</option>
               <option value="56">56</option>
               <option value="57">57</option>
               <option value="58">58</option>
               <option value="59">59</option>
            </select>
            <i class="bi bi-chevron-down"></i>
         </div>
      </div>
   </div>
   <h6 class="title-tf">แนบสลิปโอนเงิน (ไม่จำเป็น)</h6>
   <div class="input-group mb-3">
      <input id="slip-upload" type="file" class="form-control" accept=".jpg,.jpeg,.png">
   </div>
   <div class="row">
      <div class="col text-center" id="slip-preview">
      </div>
   </div>
   <button type="submit" class="btn btn-success w-100 mt-2">ยืนยัน</button>
</div>
      </div>
      <div class="modal-footer footermodalcontent">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button> 
      </div>
    </div>
  </div>
</div>
<!-- Send Deposit -->














<!-- Promotions Detail-->

<!-- Modal -->


<div class="modal fade" id="promodaldetail" tabindex="-1" aria-labelledby="promodaldetailLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modalcontent">
      <div class="modal-header headmodalcontent">

        <center><font color="#ffffff"><h5 class="modal-title" id="promodaldetailLabel">โปรโมชั่นทั้งหมด</h5></center>
        <i class="fas fa-times" data-dismiss="modal" aria-label="Close"></i>
      </div>
                        <?php
                         $querypro = "SELECT * FROM promotion  ORDER BY id desc" or die("Error:" . mysqli_error());
                         $resultpro = mysqli_query($con, $querypro);
                        ?>
                        <?php foreach ($resultpro as $rowpro){ ?>
      <div class="modal-body angpaocontent">
         <b><?php echo $rowpro['name_pro']; ?></b><br>
         - ลักษณะโบนัส : <?php echo $rowpro['time_pro']; ?><br>
         - ยอดฝากขั้นต่ำ : <?php echo $rowpro['dp_pro']; ?><br>
         - โบนัสที่ได้รับ : <?php 
if ($rowpro['bonus_pro']!=0) {
   echo $rowpro['bonus_pro']; 
}else{
   echo $rowpro['bonusper_pro'].'%'; }?><br>
         - เกมส์ที่เล่นได้ : <?php echo $rowpro['games_pro']; ?><br>
         - ข้อห้าม : <?php echo $rowpro['rules_pro']; ?><br>
         - เทิร์นโอเวอร์ : <?php echo $rowpro['turn_pro']; ?><br>
         - ถอนได้ : <?php echo $rowpro['wd_pro']; ?>

         
      </div>
      <hr width="100%"><?php } ?>
      <div class="modal-body angpaocontent">
      *หากพบเห็นการตั้งใจสร้างหลาย USER เพื่อมาแทงสวนทีมงานจะระงับการจ่ายเงิน ทุกกรณี*
   </div>
      <div class="modal-footer footermodalcontent">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button></font>
      </div>
    </div>
  </div>
</div>
<!-- Promotions Detail-->


















































    <footer class="footer mt-auto py-3">
  <div class="container">
    Place sticky footer content here.
  </div>
</footer>

    <div class="sideline" onclick="location.href='<?php echo($line_id); ?>'"> 
        <i class="fab fa-line"></i> 
        <br>ติดต่อเรา
    </div>



<!-- คัดลอกลิงค์ -->
<div class="myAlert-top alertcopy">
<i class="fal fa-check-circle"></i>
  <br>
  <strong>
    คัดลอกเรียบร้อยแล้ว  </strong>
</div>
<!-- คัดลอกลิงค์ -->
<script>
   function logout1() {
      Swal.fire({
  title: 'ต้องการออกระบบ',
  text: "แน่ใจหรือไม่",
  icon: 'question',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'ตกลง',
  cancelButtonText: 'ยกเลิก'
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire(
      'ออกระบบสำเร็จ!!',
      'กลับมาร่วมสนุกกับเราอีกนะคะ',
      'success',
   
   setTimeout("window.location='logout.php';",2000)
    
    )
  }
})


    }


</script>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- AOSJS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Swiper -->
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="spinner/js/jquery.superwheel.min.js"></script>
    <script src="spinner/js/main.js"></script>
    <script src="spinner/js/cryptojs-aes.min.js"></script>
    <script src="spinner/js/cryptojs-aes-format.js"></script>

    <script>
    AOS.init({once:true});
    
    </script>
    <script src="css/js.js"></script>
    
</body>

</html>