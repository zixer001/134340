<?php include 'inc/header.php'; ?>
<section class="pcoded-main-container">
<div class="pcoded-content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="text-dark">แก้ไขข้อมูลพนักงาน<a href="staff.php" class="btn btn-success float-right btn-sm">ย้อนกลับ</a>
          </h5>
          <hr>
          
          <?php
          //1. เชื่อมต่อ database:
          include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
          //ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก
          if($_GET["id_ad"]==''){
          echo "<script type='text/javascript'>";
          echo "alert('Error Contact Admin !!');";
          echo "window.location = 'staff.php'; ";
          echo "</script>";
          }
          //รับค่าไอดีที่จะแก้ไข
          $id_ad = mysqli_real_escape_string($con,$_GET['id_ad']);
          //2. query ข้อมูลจากตาราง:
          $sql = "SELECT * FROM admin WHERE id_ad='$id_ad' ";
          $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
          $row = mysqli_fetch_array($result);
          extract($row);
          ?>
          <div class="container">
            <div class="row">
              <form class="form-horizontal ng-pristine ng-valid" method="POST" action="adminupdate_db.php">
                <div class="form-group">
                  <div class="row">
                    
                    <input type="hidden" name="id_ad" value="<?php echo $id_ad; ?>" >
                    <label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
                    <div class="col-sm-4">
                      <input type="text"  placeholder="ยูสเซอร์เนม" name="username_ad" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?=$username_ad;?>" >
                    </div>
                    <label class="col-sm-2 control-label">รหัสผ่าน</label>
                    <div class="col-sm-4">
                      <input type="text" placeholder="รหัสผ่าน" name="password_ad" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="" required>
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">เบอร์โทรศัพท์</label>
                    <div class="col-sm-4">
                      <input type="number" placeholder="เบอร์โทรศัพท์" name="phone_ad" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$phone_ad;?>">
                    </div>
                    <label class="col-sm-2 control-label">ชื่อ-นามสกุล</label>
                    <div class="col-sm-4">
                      <input type="text" placeholder="ชื่อ-นามสกุล" name="name_ad" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$name_ad;?>">
                    </div>
                  </div>
                </div>
                <!--<div class="form-group">
                  <div class="row">
                    <label class="col-sm-2 control-label">ไลน์ไอดี</label>
                    <div class="col-sm-4">
                      <input type="number" placeholder="ไลน์ไอดี" ng-model="bank.no" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty " style="">
                    </div>
                    <label class="col-sm-2 control-label">เครดิตคงเหลือ</label>
                    <div class="col-sm-4">
                      <input type="number" disabled="" placeholder="เครดิตคงเหลือ" ng-model="bank.accountSet" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty" style="">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row mt-3">
                      <label class="col-sm-2 control-label mt-2">สถานะ</label>
                      <div class="col-sm-4">
                        <label class="switch">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>
                      </div>
                    </div>
                  </div>-->
                  
                  <div class="form-group">
                    <div class="row">
                     <label class="col-sm-2"></label>
                      <div class="col-sm-4">
                        <button type="submit" class="btn btn-success" name="Update" id="Update" value="Update">คลิ๊กเพื่อบันทึก</button>
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


