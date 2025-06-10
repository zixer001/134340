<?php include 'inc/header.php'; ?>
<section class="pcoded-main-container">
  <div class="pcoded-content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="text-dark">แก้ไขธนาคาร<a href="bank.php" class="btn btn-success float-right">ย้อนกลับ</a>
            </h5>
            <hr>
            
            <?php
            //1. เชื่อมต่อ database:
            include('../connectdb.php'); 
            //ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก
            if($_GET["id"]==''){
            echo "<script type='text/javascript'>";
            echo "alert('Error Contact Admin !!');";
            echo "window.location = 'bank.php'; ";
            echo "</script>";
            }
            //รับค่าไอดีที่จะแก้ไข
            $id = mysqli_real_escape_string($con,$_GET['id']);
            //2. query ข้อมูลจากตาราง:
            $sql = "SELECT * FROM bank WHERE id ='$id' ";
            $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
            $row = mysqli_fetch_array($result);
            extract($row);
            ?>
            <div class="container">
              <div class="row">
                <form class="form-horizontal ng-pristine ng-valid" method="POST" action="bankupdate_db.php" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="row">
                      <input type="" name="id" value="<?php echo $id; ?>" hidden/>
                      
                      <label class="col-sm-2 control-label">ธนาคาร/ทรูวอเล็ต</label>
                        <div class="col-sm-4">
                          <select required="required" class="custom-select custom-select-md" name="name_bank">
                            <option selected="selected" value="<?=$name_bank;?>"><?=$name_bank;?></option>
                            
                  <option value="ทรูวอเล็ต">ทรูวอเล็ต</option>
                  <option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                  <option value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                  <option value="ธนาคารกรุงไทย">ธนาคารกรุงไทย</option>
                  <option value="ธนาคารกรุงเทพ">ธนาคารกรุงเทพ</option>
                  <option value="ธนาคารกรุงศรีอยุธยา">ธนาคารกรุงศรีอยุธยา</option>
                  <option value="ธนาคารทหารไทยธนชาติ">ธนาคารทหารไทยธนชาติ</option>
                  <option value="ธนาคารเกียรตินาคินภัทร">ธนาคารเกียรตินาคินภัทร</option>
                          </select>
                        </div>
                        <label class="col-sm-2 control-label">เลขบัญชี</label>
                      <div class="col-sm-4">
                        <input type="number" name="bankacc_bank" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$bankacc_bank;?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 control-label">ชื่อบัญชี</label>
                      <div class="col-sm-4">
                        <input type="text" name="nameacc_bank" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$nameacc_bank;?>">
                      </div>
                      <label class="col-sm-2 control-label">ประเภท</label>
                      <div class="col-sm-4">
                        <select required="required" class="custom-select custom-select-md" name="bankfor">
                          <option selected="selected" ><?=$bankfor;?></option>
                          <option value="ฝาก">ฝาก</option>
                          <option value="ถอน">ถอน</option>
                          <option value="ฝากและถอน">ฝากและถอน</option>
                        </select>
                      </div>
                      
                      </div>
                    </div><br>
                    <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 control-label">สถานะ</label>
                      <div class="col-sm-4">
                        <select required="required" class="custom-select custom-select-md" name="status_bank">
                          <option selected="selected" ><?=$status_bank;?></option>
                          <option value="เปิด">เปิด</option>
                          <option value="ปิด">ปิด</option>
                        </select>
                      </div>
                      <label class="col-sm-2 control-label">DEVICE ID</label>
                      <div class="col-sm-4">
                        <input type="text" name="device" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$device;?>">
                      </div>
                      
                    </div>
                    </div>
                    <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 control-label">PIN SCB/ทรูวอเล็ต</label>
                      <div class="col-sm-4">
                        <input type="text" name="pin_bank" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$pin_bank;?>">
                      </div>
                      <label class="col-sm-2 control-label">รหัสผ่านทรูวอเล็ต</label>
                      <div class="col-sm-4">
                        <input type="text" name="password_true" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$password_true;?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 control-label">เลขอ้างอิงทรูวอเล็ต</label>
                      <div class="col-sm-4">
                        <input type="text" name="no_true" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$no_true;?>">
                      </div>
                      <label class="col-sm-2 control-label">OTP ทรูวอเล็ต</label>
                      <div class="col-sm-4">
                        <input type="text" name="otp_true" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$otp_true;?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                  <div class="row">
                      <label class="col-sm-2 control-label">User KBank</label>
                      <div class="col-sm-4">
                        <input type="text" name="user_kbank" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$user_kbank;?>">
                      </div>
                      <label class="col-sm-2 control-label">Pass KBank</label>
                      <div class="col-sm-4">
                        <input type="text" name="pass_kbank" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$pass_kbank;?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 control-label">ID KBank</label>
                      <div class="col-sm-4">
                        <input type="text" name="id_kbank" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$id_kbank;?>">
                      </div>
                      <label class="col-sm-2 control-label">Token KBank</label>
                      <div class="col-sm-4">
                        <input type="text" name="token_kbank" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?=$token_kbank;?>">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">

                    <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-4">
                        <button type="submit" class="btn btn-success" name="Update" id="Update" value="Update">คลิ๊กเพื่อบันทึก</button>
                      </div></form>
                    </div>
                  </div><br>
                 <div class="form-group">
                    <div class="row">
                      <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-4">
                        <button type="button" class="btn btn-danger" onclick="window.open('../cronjob-run/tw4.php', '_blank')">รับ OTP ทรูวอเล็ต</button>
                      </div>
                      <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-4">
                        <button type="button" class="btn btn-primary" onclick="window.open('../cronjob-run/tw5.php', '_blank')">LOGIN ทรูวอเล็ต</button>
                      </div>
                    </div>
                  </div>
           
                  
              <!-- <div class="row">
                <form class="form-horizontal ng-pristine ng-valid" method="POST" action="money.php" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="row">
                      <input type="" name="id_bank" value="<?php echo $id; ?>" hidden/>
                      
                      <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                          <input type="number" name="money_bank" class="form-control ng-pristine ng-untouched ng-valid ng-empty" placeholder="เพิ่มเงิน">
                        </div>
                        <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-4">
                        <input type="number" name="money_bank2" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="ลดเงิน">
                      </div>
                     
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <input type="" name="id" value="<?php echo $id; ?>" hidden/>
                      
                      <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                          <input type="text" name="" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  hidden="hide" placeholder="เพิ่มเงิน" >
                        </div>
                       <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-4">
                        <button type="submit" class="btn btn-success" name="Update" id="Update" value="Update">คลิ๊กเพื่อบันทึก</button>
                      </div>
                     
                    </div>
                  </div>
                </div>
              </form> -->
              </div> 
                
          </section>
          <?php include 'inc/footer.php'; ?>
          </div>
              
                 
                      
        

            </div>
          </div>
          
        </div>



      </div>
    </div>
  </div>
</div>
          