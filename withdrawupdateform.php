

<?php 
include 'inc/header.php'; 
require $_SERVER["DOCUMENT_ROOT"] . '/connectdb.php';
?>

<section class="pcoded-main-container">
<div class="pcoded-content">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="text-dark">ตัดเครดิต<a href="member.php" class="btn btn-success float-right btn-sm">ย้อนกลับ</a>
          </h5>
          <hr>
          <?php
          //รับค่าไอดีที่จะแก้ไข
          $id1 = mysqli_real_escape_string($con,$_GET['id']);
          //2. query ข้อมูลจากตาราง:
          $sql = "SELECT * FROM withdraw WHERE id='$id1'";
          $result = mysqli_query($con, $sql) or die ("Error in query: $sql ");
          $row = mysqli_fetch_array($result);
          extract($row);
          ?>
          
   
         <?php
          $username =  $username_wd;
          $sql2 = "SELECT * FROM deposit WHERE username_dp = '$username'  AND confirm_dp = 'อนุมัติ'  ORDER BY id DESC limit 1";
          $result2 = mysqli_query($con, $sql2)  or die ("Error in query: $sql2 ");
          $row2 = mysqli_fetch_array($result2);
          extract($row2);
          $username_mb =  $username_wd;
         include('../class/betflix.php');
$api = new Betflix();?>
        <form method="POST" action="api/tran_betflix.php?withdraw">
          <div class="form-group">
            <div class="row">

              <label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
              <div class="col-sm-4">
                 <input type="text" name="admin" value="<?php echo $name_ad; ?>" hidden>
                <input type="text"  name="username" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?php echo $agent.$username_dp;?>" readonly="readonly">
              </div>
              <label class="col-sm-2 control-label">ยอดถอน</label>
              <div class="col-sm-4">
                <input type="text" name="amount"  class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?=$amount_wd;?>" >
              </div>
              <div class="col-sm-4">
                <input type="text" name="id"  class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?=$_GET['id'];?>" readonly="readonly" hidden>
              </div>
            </div><br>
            <div class="form-group">
            <div class="row">
              <label class="col-sm-2 control-label"></label>
              <div class="col-sm-4">
                <button type="submit" class="btn btn-warning">ตัดเครดิต</button>
              </div>
              </div>
            </div> </form>
          </div>
       
          <iframe src="<?php echo $agent_link; ?>" width="100%" height="500"></iframe>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="text-dark">ตรวจสอบรายการถอนเงิน<a href="withdraw.php" class="btn btn-success float-right">ย้อนกลับ</a>
          </h5>
          <hr>
          
          
           
          <h5 class="text-dark"><font color="#fff200"></font> เครดิตคงเหลือ : <font color="#fff200"><?php  echo $Balance;  ?></font><font color="#fff200"></font> ยอดเทิร์นที่ต้องทำ : <font color="#fff200"><?php  echo $row2['turnover'];  ?></font>
            <font color="#fff200"></font> โปรโมชั่นล่าสุด : <font color="#fff200"><?php  echo $row2['promotion_dp'];  ?></font>
            <!-- <font color="#fff200"></font> เครดิตคงเหลือ : <font color="#fff200"><?php echo $Balance; ?></font> --></h5><br>
          <div class="container">
            <div class="row">
              <!--<form action="api_amb.php?withdraw" class="form-horizontal ng-pristine ng-valid" method="POST">
                <div class="form-group" style="margin-right: 50px;">
                  <div class="row">
                    
                    <label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
                    <div class="col-sm-4">
                      <input type="text" name="username" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?php echo $agent; ?><?=$username_wd;?>" readonly="readonly">
                    </div>
                    <label class="col-sm-2 control-label">ยอดเงินถอน</label>
                    <div class="col-sm-4">
                      <input type="number" name="amount" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  value="<?=$amount_wd;?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-4">
                      <button type="submit" class="btn btn-warning" name="Update" id="Update" value="Update">ตัดเครดิต</button>
                    </div>
                  </div>
                </div>
              </form>-->
              <form class="form-horizontal ng-pristine ng-valid" method="POST" action="withdrawupdate_db.php">
                <div class="form-group">
                  <div class="row">
                    <input type="" name="id" value="<?php echo $id1; ?>" hidden/>
                    <label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
                    <div class="col-sm-4">
                      <input type="text" name="username" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?php echo $agent; ?><?=$username_wd;?>" readonly="readonly">
                    </div>

                    <label class="col-sm-2 control-label">ยอดเงินถอน</label>
                    <div class="col-sm-4">
                      <input type="number" name="amount_wd" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  value="<?=$amount_wd;?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">เลขบัญชีธนาคาร</label>
                    <div class="col-sm-4">
                      <input type="number" name="bankacc_wd" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$bankacc_wd;?>" readonly="readonly">
                    </div>
                    <label class="col-sm-2 control-label">ธนาคาร</label>
                    <div class="col-sm-4">
                      <input type="text" name="bank_wd" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$bank_wd;?>" readonly="readonly">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">เบอร์โทรศัพท์</label>
                    <div class="col-sm-4">
                      <input type="number" name="phone_wd" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$phone_wd;?>" readonly="readonly">
                    </div>
                    <label class="col-sm-2 control-label">ชื่อ-นามสกุล</label>
                    <div class="col-sm-4">
                      <input type="text" name="name_wd" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$name_wd;?>" readonly="readonly">
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="row">
                    
                    <label class="col-sm-2 control-label">ธนาคารที่ใช้ถอน***</label>
                  <div class="col-sm-4">
                    <select required="required" class="custom-select custom-select-md" name="bankout_wd">
                      <option selected="selected" value="<?=$bankout_wd;?>"><?=$bankout_wd;?></option>
                      <option value="ไม่ถูกต้อง">ไม่ถูกต้อง</option>
                      <?php 
                            $querybank1 = "SELECT * FROM bank WHERE bankfor LIKE '%ถอน%' AND status_bank ='เปิด' ";
                            $resultbank1 = mysqli_query($con, $querybank1);
                           
                            while($bank1 = mysqli_fetch_array($resultbank1)) { ?>
                        <option value="<?php echo $bank1['name_bank']; ?> <?php echo $bank1['bankacc_bank']; ?>"><?php echo $bank1['name_bank']; ?> <?php echo $bank1['bankacc_bank']; }?></option>
                        <option value="เงินคืน">เงินคืน</option>
                    </select>
                  </div>


                    <label class="col-sm-2 control-label">หมายเหตุ***</label>
                    <div class="col-sm-4">
                      <input type="text" name="note_wd" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$note_wd;?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 control-label">สถานะ***</label>
                    <div class="col-sm-4">
                      <select required="required" class="custom-select custom-select-md" name="confirm_wd">
                        <option value="<?=$confirm_wd;?>"><?=$confirm_wd;?></option>
                        <option value="อนุมัติ">อนุมัติ</option>
                        <option value="ปฏิเสธ">ปฏิเสธ</option>
                      </select>
                    </div>
                   
                  
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-danger" name="Update" id="Update" value="Update">คลิ๊กเพื่อบันทึก</button>
                  </div>
                  
                </div></form>
                <br>

                <!-- <form action="../cronjob-run/api_scb_trans.php?trans_x2" class="form-horizontal ng-pristine ng-valid" method="POST">
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-4">
                      <button type="submit" class="btn btn-danger" name="Update" id="Update" value="Update">คลิ๊กเพื่อบันทึก</button>
                    </div> -->
                  

                  <!-- <label class="col-sm-2"></label>
                  <div class="col-sm-4">
                    <form action="../apiufa1062.php?cashback" class="form-horizontal ng-pristine ng-valid" method="POST">
                    <input type="text" name="username" value="<?php echo $agent; ?><?=$username_wd;?>" hidden="hide">
                    <input type="text" name="amount" value="<?=$amount_cashback;?>" hidden="hide">
                    <input type="text" name="id" value="<?=$_GET['id'];?>" hidden>
                    <button type="submit" class="btn btn-primary">คลิ๊กเงินคืน</button>
                  </div></form> -->
                  <!-- <label class="col-sm-2"></label>
                  <div class="col-sm-4">
                    
                    

                    <button type="submit" class="btn btn-primary">โอนเงิน</button>
                  </div></form> -->
                
                </div>
              </div>
            </div>
          </div>

      <div class="card">
        <div class="card-body">
          <h5 class="text-dark">โอนเงิน
          </h5>
          <hr>

      



          
<div class="container">
            <div class="row">
          <form class="form-horizontal ng-pristine ng-valid" method="POST" action="api/withdarw_scb.php?tranfer-m">
                <div class="form-group">
                  <div class="row">
                   <input type="text" name="phone" value="<?php echo $phone_wd;?>" hidden="hide">
                    <input type="text" name="accountTo" value="<?php echo $bankacc_wd;?>" hidden="hide">
                    <input type="text" name="accountToBankCode" value="<?php echo $bank_wd;?>" hidden>
                    <input type="text" name="add_wd" value="<?php echo $name_ad;?>" hidden>
                    <input type="hidden" name="id_withdraw" value="<?php echo $_GET['id'];?>">
                    <label class="col-sm-2 control-label">ยอดเงิน</label>
                    <div class="col-sm-4">
                      
                    <input type="text" name="amount" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="" required>
                    </div>
                    <label class="col-sm-2 control-label">รหัสลับ</label>
                    <div class="col-sm-4">
                      
                    <input type="text" name="key_input" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="" required>
                    </div>
                    
                  </div>
                </div>
                  <div class="form-group">
                  <div class="row">
                  <label class="col-sm-2"></label>
                    <div class="col-sm-4">
                      <button type="submit" class="btn btn-primary">โอนเงิน</button>
                
                    </div>
                </div>  
              </div>

              </form>
      </div>
    </div>
<!-- <div class="container">
            <div class="row">
          <form class="form-horizontal ng-pristine ng-valid" method="POST" action="../kbank525698/wd_kbank.php">
                <div class="form-group">
                  <div class="row">
                  <input type="text" name="phone" value="<?php echo $phone_wd;?>" hidden="hide">
                    <input type="text" name="accountTo" value="<?php echo $bankacc_wd;?>" hidden="hide">
                    <input type="text" name="accountToBankCode" value="<?php echo $bank_wd;?>" hidden>
                    <input type="text" name="add_wd" value="<?php echo $name_ad;?>" hidden>
                    <label class="col-sm-2 control-label">ยอดเงิน</label>
                    <div class="col-sm-4">
                       
                    <input type="text" name="amount" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="" required>
                    </div>
                    <label class="col-sm-2 control-label">รหัสลับ</label>
                    <div class="col-sm-4">
                      
                    <input type="text" name="key_input" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="" required>
                    </div>
                    
                  </div>
                </div>
                  <div class="form-group">
                  <div class="row">
                  <label class="col-sm-2"></label>
                    <div class="col-sm-4">
                      <button type="submit" class="btn btn-primary">โอนเงิน</button>
                
                    </div>
                </div>  
              </div>

              </form>
      </div>
    </div> -->

  </div>
</div>



        </section>
            <?php include 'inc/footer.php'; ?>

           
          