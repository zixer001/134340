<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="row">
            <!-- order-card start -->
 <?php
                    //ทำตัวเลขแจ้งเตือน
   date_default_timezone_set('asia/bangkok');
                    $today_register = date('Y-m-d');
                        $sql="SELECT * FROM member WHERE date_mb LIKE '%$today_register%' AND phone_mb !=''" or die("Error:" . $con);
                        $result1 = mysqli_query($con, $sql);
                    // echo('$result1');
                    // print_r($result1);
                    $rowcount1=mysqli_num_rows($result1);
                    // printf(" %d \n",$rowcount);
                    //echo($rowcount1);
                    $todayac  = date('Y-m-d');
                    $today_active = "SELECT DISTINCT id_dp FROM deposit WHERE date_dp LIKE '%$todayac%' AND promotion_dp!= 'กิจกรรม' AND amount_dp!= 'กิจกรรม' AND confirm_dp = 'อนุมัติ' AND bankin_dp!='ไม่ถูกต้อง'";
                    $result2 = mysqli_query($con, $today_active);
                    $rowcountactive=mysqli_num_rows($result2);



                    $today_dpbill = date('Y-m-d');
                        $sql_dpbill="SELECT * FROM deposit WHERE date_dp LIKE '%$today_dpbill%' AND promotion_dp!='แจกฟรีเพียงแค่สมัคร' AND confirm_dp='อนุมัติ'"  or die("Error:" . $con);
                        $result_dpbill = mysqli_query($con, $sql_dpbill);
                    // echo('$result1');
                    // print_r($result1);
                    $rowcount_dpbill=mysqli_num_rows($result_dpbill);
                    // printf(" %d \n",$rowcount);
                    //echo($rowcount_dpbill);


                    $today_wdbill = date('Y-m-d');
                        $sql_wdbill="SELECT * FROM withdraw WHERE date_wd LIKE '%$today_wdbill%' AND bankout_wd!='คืนยอดเสีย' AND confirm_wd='อนุมัติ'"  or die("Error:" . $con);
                        $result_wdbill = mysqli_query($con, $sql_wdbill);
                    // echo('$result1');
                    // print_r($result1);
                    $rowcount_wdbill=mysqli_num_rows($result_wdbill);
                    // printf(" %d \n",$rowcount);
                    //echo($rowcount_wdbill);

                    
                    $rrt = "SELECT * FROM member WHERE phone_mb !='' ORDER BY username_mb"  or die("Error:" . $con);
                    $result = mysqli_query($con, $rrt);
                    // echo('$result');
                    // print_r($result);
                    $rowcount=mysqli_num_rows($result);
                    // printf(" %d \n",$rowcount);
                    // echo($rowcount);
                   
                    //include('../cronjob-run/apiufa1062.php');
                    
                    $sql55 = "SELECT * FROM credit ORDER BY id DESC LIMIT 1";
                    $result55 = mysqli_query($con, $sql55);
                    $row55 = mysqli_fetch_assoc($result55);
                    
                    
                    ?>
                    <?php 
                        $sql15="SELECT * FROM member WHERE `status` =2" or die("Error:" . $con);
                      $result15 = mysqli_query($con, $sql15);
                      $num15=mysqli_num_rows($result15);
                      ?>        

<link rel="stylesheet" href="csswin/all.min.css">

<link rel="stylesheet" href="csswin/ionicons.min.css">
<div class="col-lg-3 col-6">

<div class="small-box bg-info">
<div class="inner">
<h3><?php echo($rowcount); ?></h3>
<p>สมาชิกทั้งหมด</p>
</div>
<div class="icon">
<span class="iconify" data-icon="ion:person-add"></span>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-secondary">
<div class="inner">
<h3><?php echo $row55['credit_ufa']; ?></h3>
<p>เครดิตคงเหลือ</p>
</div>
<div class="icon">
<span class="iconify" data-icon="ion:server"></span>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-pink">
<div class="inner">
<h3><?php echo $num15; ?></h3>
<p>สต็อกที่สมัครได้</p>
</div>
<div class="icon">
<span class="iconify" data-icon="ion:people-sharp"></span>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>


<div class="col-lg-3 col-6">

<div class="small-box bg-blue">
<div class="inner">
<h3><?php echo($rowcountactive); ?></h3>
<p>จำนวนสมาชิกฝากเงินวันนี้</p>
</div>
<div class="icon">
<span class="iconify" data-icon="ion:rocket"></span>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>


<div class="col-lg-3 col-6">

<div class="small-box bg-success">
<div class="inner">
<h3><?php 
                                 date_default_timezone_set('asia/bangkok');
                                $today_dp = date('Y-m-d');
                                $query = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp='อนุมัติ' AND date_dp LIKE '%$today_dp%' AND bankin_dp!='ไม่ถูกต้อง'";
                                $result = mysqli_query($con, $query);
                                while($row2 = mysqli_fetch_array($result)){ 
                                    $totaldptoday = $row2['SUM(amount_dp)'] * 1 / 1; 
                                    echo $totaldptoday;
                                    echo "<br />";  
                            } ?></h3>
<p>ยอดฝากวันนี้</p>
</div>
<div class="icon">
<span class="iconify" data-icon="ion:bag-add"></span>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-warning">
<div class="inner">
<h3><?php 
                                  date_default_timezone_set('asia/bangkok');
                                $today_wd = date('Y-m-d');
                                $querywd3 = "SELECT SUM(amount_wd) FROM withdraw WHERE confirm_wd='อนุมัติ' AND bankout_wd!='เงินคืน' AND date_wd LIKE '%$today_wd%'";
                                $resultwd3 = mysqli_query($con, $querywd3);
                                while($row3 = mysqli_fetch_array($resultwd3)){ 
                                    $totalwdtoday = $row3['SUM(amount_wd)'] * 1 / 1; 
                                    echo $totalwdtoday;
                                    echo "<br />";  
                            } ?></h3>
<p>ยอดถอนวันนี้</p>
</div>
<div class="icon">
<span class="iconify" data-icon="ion:bag-remove"></span>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-danger">
<div class="inner">
<h3><?php 
                                
                                
                                $queryaff2 = "SELECT SUM(amount_aff) FROM withdrawaff WHERE confirm_aff='อนุมัติ'";
                                $resultaff2 = mysqli_query($con, $queryaff2);

                                while($row = mysqli_fetch_array($resultaff2)){ 
                                    echo $row['SUM(amount_aff)'] * 1 / 1; 
                                    $year_aff = $row['SUM(amount_aff)'] * 1 / 1;
                                    echo "<br />"; 
                            } ?></h3>
<p>ยอดถอนแนะนำเพื่อน</p>
</div>
<div class="icon">
<span class="iconify" data-icon="ion:ribbon"></span>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-black">
<div class="inner">
<h3><?php 
$total = $totaldptoday - $totalwdtoday;
echo $total * 1 / 1;
?></h3>
<p>รายได้วันนี้</p>
</div>
<div class="icon">
<span class="iconify" data-icon="ion:duplicate"></span>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-purple">
<div class="inner">
<h3><?php echo($rowcount_dpbill); ?></h3>
<p>จำนวนบิลฝากวันนี้</p>
</div>
<div class="icon">
<span class="iconify" data-icon="ion:receipt"></span>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-yellow">
<div class="inner">
<h3><?php echo($rowcount_wdbill); ?></h3>
<p>จำนวนบิลถอนวันนี้</p>
</div>
<div class="icon">
<span class="iconify" data-icon="ion:reader"></span>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>


            <?php 
                $querybank = "SELECT * FROM bank WHERE status_bank ='เปิด' ";
                $resultbank = mysqli_query($con, $querybank);
                
            ?>
            <?php
            while($bank = mysqli_fetch_array($resultbank)) { 
                $acc = $bank['bankacc_bank']; 
                $idny = $bank['id'];
                ?>
<div class="col-lg-3 col-6">
<?php 
                if ($bank['bankfor']=='ถอน') {
                    echo '<div class="small-box" style="background-color: #ff7e21">';
                }
                elseif ($bank['bankfor']=='ฝากและถอน') {
                    echo '<div class="small-box" style="background-color: #9c0345">';
                }
                else{
                    echo '<div class="small-box" style="background-color: #05bae3">';
                }

                ?>



<div class="inner">
<h3><?php 

                              if ($bank['name_bank']=='ธนาคารไทยพาณิชย์') {
                                
                                  echo $row55['credit_scb'];
                               }elseif ($bank['name_bank']=='ทรูวอเล็ต') {

                                echo $row55['credit_true'];
                               }elseif ($bank['name_bank']=='ธนาคารกสิกรไทย') {
                            
                                echo $row55['credit_kbank'];
                               }
                                ?></h3>
<p><?php echo $bank['name_bank']; ?> <?php echo $bank['bankacc_bank']; ?></p>
</div>
<div class="icon">
<span class="iconify" data-icon="ion:magnet"></span>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div><?php } ?>







   


        </div></div></div>
<script src="csswin/iconify.min.js"></script> 