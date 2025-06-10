<?php include 'header.php'; ?>
<section class="pcoded-main-container">
<div class="pcoded-content">
  <div class="row">
     <?php
          //1. เชื่อมต่อ database:
          include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
          //ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก
          
          //รับค่าไอดีที่จะแก้ไข
          $id = mysqli_real_escape_string($con,$_GET['id']);
          //2. query ข้อมูลจากตาราง:
          $sql = "SELECT * FROM affiliate WHERE id='$id' ";
          $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
          $row = mysqli_fetch_array($result);
          extract($row);
 
      //include('../apiufa1062.php');
          ?>
            

    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="text-dark">แก้ไขพันธมิตร<a href="affiliate.php" class="btn btn-success float-right">ย้อนกลับ</a>
          </h5><hr>
         

          
          
          <div class="container">
            <div class="row">
              <form class="form-horizontal ng-pristine ng-valid" method="POST" action="affiliateupdate_db.php">
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
                    <div class="col-sm-4">
                      <input type="text"  placeholder="ยูสเซอร์เนม" name="username" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?=$username;?>">
                    </div>
                    <label class="col-sm-2 control-label">รหัสผ่าน</label>
                    <div class="col-sm-4">
                      <input type="text" placeholder="รหัสผ่าน" name="password" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?=$password;?>" required>
                    </div>
                  </div>
                </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>" >
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">เลขบัญชีธนาคาร</label>
                    <div class="col-sm-4">
                      <input type="number" placeholder="เลขบัญชีธนาคาร" name="bankacc" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$bankacc;?>">
                    </div>
                    <label class="col-sm-2 control-label">ธนาคาร</label>
                    <div class="col-sm-4">
                      <select required="required" class="custom-select custom-select-md" name="bank">
                        <option value="<?=$bank;?>"><?=$bank;?></option>
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
                      <input type="number" placeholder="เบอร์โทรศัพท์" name="phone" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$phone;?>">
                    </div>
                    <label class="col-sm-2 control-label">ชื่อ-นามสกุล</label>
                    <div class="col-sm-4">
                      <input type="text" placeholder="ชื่อ-นามสกุล" name="name" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$name;?>">
                    </div>
                  </div>
                </div>
                
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 control-label">สถานะ</label>
                      <div class="col-sm-4">
                        <select required="required" class="custom-select custom-select-md" name="status">
                          <option value="<?=$status;?>"><?=$status;?></option>
                          <option value="อนุมัติ">อนุมัติ</option>
                          <option value="ระงับ">ระงับ</option>
                          
                        </select>
                      </div>
                      <label class="col-sm-2 control-label">เปอร์เซ็นต์</label>
                    <div class="col-sm-4">
                      <input type="number" name="percent" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$percent;?>" >
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
<?php include 'footer.php'; ?>


