<?php include 'inc/header.php'; ?>
<section class="pcoded-main-container">
<div class="pcoded-content">
  <div class="row">
     <?php
          //1. เชื่อมต่อ database:
          include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
          //ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก
          
          //รับค่าไอดีที่จะแก้ไข
          $id_mb = mysqli_real_escape_string($con,$_GET['id_mb']);
          //2. query ข้อมูลจากตาราง:
          $sql = "SELECT * FROM member WHERE id_mb='$id_mb' ";
          $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
          $row = mysqli_fetch_array($result);
          extract($row);
        $username_mb = $row['username_mb'];
        //echo $username_mb;
      include('../class/betflix.php');
$api = new Betflix();          ?>
            
            
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="text-dark">สมัครเข้าเอเย่นต์<a href="member.php" class="btn btn-success float-right btn-sm">ย้อนกลับ</a>
          </h5>
          <hr>
          <div class="form-group">
            <div class="row">
              <label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
              <div class="col-sm-4">
                <input type="text"  placeholder="ยูสเซอร์เนม"  class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?=$username_mb;?>" readonly="readonly">
              </div>
              <label class="col-sm-2 control-label">รหัสผ่าน</label>
              <div class="col-sm-4">
                <input type="text" placeholder="รหัสผ่าน"  class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?=$password_mb;?>">
              </div>
            </div>
          </div>
          <iframe src="<?php echo $agent_link; ?>" width="100%" height="500"></iframe>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="text-dark">ตรวจสอบสมาชิก<a href="member.php" class="btn btn-success float-right">ย้อนกลับ</a>
          </h5><hr>
         <?php
          $id_dp =  $id_mb;
          $sql2 = "SELECT * FROM deposit WHERE id_dp ='$id_dp' AND confirm_dp = 'อนุมัติ' ORDER BY id DESC limit 1";
          $result2 = mysqli_query($con, $sql2) or die ("Error in query: $sql " . mysqli_error());
          $row2 = mysqli_fetch_array($result2);
          extract($row2);

            ?>
          <h5 class="text-dark"><font color="#fff200"></font> เครดิตคงเหลือ : <font color="#fff200"><?php  echo $Balance;?></font><font color="#fff200"></font> ยอดเทิร์นที่ต้องทำ : <font color="#fff200"><?php 
          if ($row2['turnover']=='') {
             echo 0;

          }else { 
             echo $row2['turnover'];
          } ?></font> <font color="#fff200"></font> โปรโมชั่นล่าสุด : <font color="#fff200"><?php echo $row2['promotion_dp']; ?></font></h5><br>
          <h5 class="text-dark">ยอดฝากทั้งหมด : <font color="#fff200"><?php 
                                $query = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp = 'อนุมัติ' AND phone_dp = '$phone_mb'";
                                $result = mysqli_query($con, $query);
                                while($row = mysqli_fetch_array($result)){ 
                                    echo $row['SUM(amount_dp)'] * 1; 
                                    
                            } ?> บาท</font> ยอดถอนทั้งหมด : <font color="#fff200"><?php 
                                $query = "SELECT SUM(amount_wd) FROM withdraw WHERE confirm_wd = 'อนุมัติ' AND phone_wd = '$phone_mb'";
                                $result = mysqli_query($con, $query);
                                while($row = mysqli_fetch_array($result)){ 
                                    echo $row['SUM(amount_wd)'] * 1; 
                                    
                            } ?> บาท</font> ระดับ VIP  : <font color="#fff200"><?php 
                                $query = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp = 'อนุมัติ' AND phone_dp = '$phone_mb'";
                                $result = mysqli_query($con, $query);
                                while($row = mysqli_fetch_array($result)){ 
                                    //echo $row['SUM(amount_dp)']; 
                                    
                                    if ($row['SUM(amount_dp)']<1) {
                                        echo 0;
                                    }
                                    elseif ($row['SUM(amount_dp)']>=1 && $row['SUM(amount_dp)']<=999) {
                                        echo 1;
                                    }
                                    elseif ($row['SUM(amount_dp)']>=1000 && $row['SUM(amount_dp)']<=9999) {
                                        echo 2;
                                    }
                                    elseif ($row['SUM(amount_dp)']>=10000 && $row['SUM(amount_dp)']<=99999) {
                                        echo 3;
                                    }
                                    elseif ($row['SUM(amount_dp)']>=100000 && $row['SUM(amount_dp)']<=999999) {
                                        echo 4;
                                    }
                                    elseif ($row['SUM(amount_dp)']>=1000000 ) {
                                        echo 5;
                                    }
                            } ?> 
</font> </h5><br>
          
          
          <div class="container">
            <div class="row">
              <form class="form-horizontal ng-pristine ng-valid" method="POST" action="userupdate_db.php">
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">ยูสเซอร์เนม UFABET</label>
                    <div class="col-sm-4">
                      <input type="text"  placeholder="ยูสเซอร์เนม" name="" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?php echo $agent; ?><?=$username_mb;?>" readonly>
                    </div>
                    <label class="col-sm-2 control-label">ไอดีทรูวอเล็ต</label>
                    <div class="col-sm-4">
                      <input type="text" placeholder="รหัสผ่าน" name="phone_true" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?=$phone_true;?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    
                    <input type="hidden" name="id_mb" value="<?php echo $id_mb; ?>" >
                    

                    <label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
                    <div class="col-sm-4">
                      <input type="text"  placeholder="ยูสเซอร์เนม" name="username_mb" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?=$username_mb;?>">
                    </div>
                    <label class="col-sm-2 control-label">รหัสผ่าน</label>
                    <div class="col-sm-4">
                      <input type="text" placeholder="รหัสผ่าน" name="password_mb" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?=$password_mb;?>">
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">เลขบัญชีธนาคาร</label>
                    <div class="col-sm-4">
                      <input type="number" placeholder="เลขบัญชีธนาคาร" name="bankacc_mb" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$bankacc_mb;?>">
                    </div>
                    <label class="col-sm-2 control-label">ธนาคาร</label>
                    <div class="col-sm-4">
                      <select required="required" class="custom-select custom-select-md" name="bank_mb">
                        <option value="<?=$bank_mb;?>"><?=$bank_mb;?></option>
                        <option value="ทรูวอเล็ต">ทรูวอเล็ต</option>
                        <option value="ธ.กสิกรไทย">ธ.กสิกรไทย</option>
                        <option value="ธ.กรุงไทย">ธ.กรุงไทย</option>
                        <option value="ธ.กรุงศรีอยุธยา">ธ.กรุงศรีอยุธยา</option>
                        <option value="ธ.กรุงเทพ">ธ.กรุงเทพ</option>
                        <option value="ธ.ไทยพาณิชย์">ธ.ไทยพาณิชย์</option>
                        <option value="ธ.ทหารไทยธนชาติ">ธ.ทหารไทยธนชาติ</option>
                        <option value="ธ.ออมสิน">ธ.ออมสิน</option>
                        <option value="ธ.ก.ส.">ธ.ก.ส.</option>
                        <option value="ธ.ซีไอเอ็มบี">ธ.ซีไอเอ็มบี</option>
                        <option value="ธ.ทิสโก้">ธ.ทิสโก้</option>
                        <option value="ธ.ยูโอบี">ธ.ยูโอบี</option>
                        <option value="ธ.อิสลาม">ธ.อิสลาม</option>
                        <option value="ธ.ไอซีบีซี">ธ.ไอซีบีซี</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">เบอร์โทรศัพท์</label>
                    <div class="col-sm-4">
                      <input type="number" placeholder="เบอร์โทรศัพท์" name="phone_mb" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$phone_mb;?>">
                    </div>
                    <label class="col-sm-2 control-label">ชื่อ-นามสกุล</label>
                    <div class="col-sm-4">
                      <input type="text" placeholder="ชื่อ-นามสกุล" name="name_mb" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$name_mb;?>">
                    </div>
                  </div>
                </div>
                
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 control-label">สถานะ</label>
                      <div class="col-sm-4">
                        <select required="required" class="custom-select custom-select-md" name="confirm_mb">
                          <option value="<?=$confirm_mb;?>">ยังไม่ยืนยัน</option>
                          <option value="1">ยืนยัน</option>
                          
                        </select>
                      </div>
                      <label class="col-sm-2 control-label">ผู้แนะนำ</label>
                    <div class="col-sm-4">
                      <input type="text" name="" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$aff;?>" readonly="readonly">
                    </div>
                      
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 control-label">สถานะ</label>
                      <div class="col-sm-4">
                        <label class="col-sm-2"></label>
                      <div class="col-sm-4">
                        <button type="submit" class="btn btn-success" name="Update" id="Update" value="Update">คลิ๊กเพื่อบันทึก</button>
                      </div>

                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  


</section>
<?php include 'inc/footer.php'; ?>


