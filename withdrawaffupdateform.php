

<?php include 'inc/header.php'; ?>
<section class="pcoded-main-container">
  <div class="pcoded-content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="text-dark">ตรวจสอบรายการถอนเงิน<a href="withdraw.php" class="btn btn-success float-right">ย้อนกลับ</a>
            </h5>
            <hr>
            
            <?php
            //1. เชื่อมต่อ database:
            include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
            //ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก
            if($_GET["id"]==''){
            echo "<script type='text/javascript'>";
            echo "alert('Error Contact Admin !!');";
            echo "window.location = 'index.php'; ";
            echo "</script>";
            }
            //รับค่าไอดีที่จะแก้ไข
            $id1 = mysqli_real_escape_string($con,$_GET['id']);
            //2. query ข้อมูลจากตาราง:
            $sql = "SELECT * FROM withdrawaff WHERE id='$id1' ";
            $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
            $row = mysqli_fetch_array($result);
            extract($row);
            ?>
            <div class="container">
              <div class="row">
                <form class="form-horizontal ng-pristine ng-valid" method="POST" action="withdrawaffupdate_db.php">
                  <div class="form-group">
                    <div class="row">
                      <input type="" name="id" value="<?php echo $id1; ?>" hidden/>
                      <label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
                      <div class="col-sm-4">
                        <input type="text" name="" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="25up7788<?=$username_aff;?>" readonly="readonly">
                      </div>
                      <label class="col-sm-2 control-label">ยอดเงินถอน</label>
                      <div class="col-sm-4">
                        <input type="number" name="amount_aff" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  value="<?=$amount_aff;?>" readonly="readonly">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 control-label">เลขบัญชีธนาคาร</label>
                      <div class="col-sm-4">
                        <input type="number" name="bankacc_aff" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$bankacc_aff;?>" readonly="readonly">
                      </div>
                      <label class="col-sm-2 control-label">ธนาคาร</label>
                      <div class="col-sm-4">
                        <input type="text" name="bank_aff" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$bank_aff;?>" readonly="readonly">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 control-label">เบอร์โทรศัพท์</label>
                      <div class="col-sm-4">
                        <input type="number" name="phone_aff" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$phone_aff;?>" readonly="readonly">
                      </div>
                      <label class="col-sm-2 control-label">ชื่อ-นามสกุล</label>
                      <div class="col-sm-4">
                        <input type="text" name="name_aff" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$name_aff;?>" readonly="readonly">
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 control-label">สถานะ***</label>
                      <div class="col-sm-4">
                        <select required="required" class="custom-select custom-select-md" name="confirm_aff">
                          <option value="<?=$confirm_aff;?>"><?=$confirm_aff;?></option>
                          <option value="อนุมัติ">อนุมัติ</option>
                          <option value="ปฏิเสธ">ปฏิเสธ</option>
                        </select>
                      </div>
                      <label class="col-sm-2 control-label">หมายเหตุ***</label>
                      <div class="col-sm-4">
                        <input type="text" name="note_aff" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-sm-2 control-label">ธนาคารที่ใช้ถอน***</label>
                    <div class="col-sm-4">
                      <select required="required" class="custom-select custom-select-md" name="bankout_aff">
                        
                        <option value="ไม่ถูกต้อง">ไม่ถูกต้อง</option>
                        <option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                        <option value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                        <option value="ทรูวอเล็ต">ทรูวอเล็ต</option>
                        
                      </select>
                    </div>
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


        </section>
            <?php include 'inc/footer.php'; ?>