<?php 
    if ($status_ad!='Administrator') {
        header("Content-Type: text/html; charset=utf-8");
        echo "<script type='text/javascript'>";
        echo "alert('คุณไม่มีสิทธิ์เข้าใช้หน้านี้');";
        echo "window.location = 'index.php'; ";
        echo "</script>";
    }

?>
<section class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                            <a class="btn btn-info" href="setting.php?id=1" role="button">ตั้งค่าเว็ปไซด์</a>
                            <a class="btn btn-dark" href="settingwheel.php?id=1" role="button">ตั้งค่าวงล้อ</a>
                            <a class="btn btn-primary" href="bank.php" role="button">ธนาคาร</a>
                            <a class="btn btn-secondary" href="staff.php" role="button">พนักงาน</a>
                            <a class="btn btn-success" href="promotion.php" role="button">โปรโมชั่น</a>
                            <a class="btn btn-danger" href="activity.php" role="button">กิจกรรม</a>
                        
                            
                         <!--   <button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">แก้ไขเว็ปไซด์</button> -->
                       
                        <hr>
        <?php
          //1. เชื่อมต่อ database:
          include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
          //ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก
          
          //รับค่าไอดีที่จะแก้ไข
          
          $sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1 ";
          $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
          $row = mysqli_fetch_array($result);
          extract($row);
          
        ?>

                     <div class="modal-body">
                    <form method="post" action="settingwheel_chk.php" data-action="load" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="row mt-3">
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รางวัลที่ 1</label>
                                        <input type="text"  name="reward1" class="form-control" value="<?php echo $reward1; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">เปอร์เซ็นต์</label>
                                        <input type="number"  name="Change1" class="form-control" value="<?php echo $Change1; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รูปรางวัล</label>
                                        <input type="text"  name="Image1" class="form-control" value="<?php echo $Image1; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รางวัลที่ 2</label>
                                        <input type="text"  name="reward2" class="form-control" value="<?php echo $reward2; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">เปอร์เซ็นต์</label>
                                        <input type="number"  name="Change2" class="form-control" value="<?php echo $Change2; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รูปรางวัล</label>
                                        <input type="text"  name="Image2" class="form-control" value="<?php echo $Image2; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รางวัลที่ 3</label>
                                        <input type="text"  name="reward3" class="form-control" value="<?php echo $reward3; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">เปอร์เซ็นต์</label>
                                        <input type="number"  name="Change3" class="form-control" value="<?php echo $Change3; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รูปรางวัล</label>
                                        <input type="text"  name="Image3" class="form-control" value="<?php echo $Image3; ?>">
                                    </div>
                            </div>
                            
                            <div class="row mt-3">
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รางวัลที่ 4</label>
                                        <input type="text"  name="reward4" class="form-control" value="<?php echo $reward4; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">เปอร์เซ็นต์</label>
                                        <input type="number"  name="Change4" class="form-control" value="<?php echo $Change4; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รูปรางวัล</label>
                                        <input type="text"  name="Image4" class="form-control" value="<?php echo $Image4; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รางวัลที่ 5</label>
                                        <input type="text"  name="reward5" class="form-control" value="<?php echo $reward5; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">เปอร์เซ็นต์</label>
                                        <input type="number"  name="Change5" class="form-control" value="<?php echo $Change5; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รูปรางวัล</label>
                                        <input type="text"  name="Image5" class="form-control" value="<?php echo $Image5; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-12 control-label">รางวัลที่ 6</label>
                                        <input type="text"  name="reward6" class="form-control" value="<?php echo $reward6; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">เปอร์เซ็นต์</label>
                                        <input type="number"  name="Change6" class="form-control" value="<?php echo $Change6; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รูปรางวัล</label>
                                        <input type="text"  name="Image6" class="form-control" value="<?php echo $Image6; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-12 control-label">รางวัลที่ 7 [ใส่รางวัลพิเศษ]</label>
                                        <input type="text"  name="reward7" class="form-control" value="<?php echo $reward7; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">เปอร์เซ็นต์</label>
                                        <input type="number"  name="Change7" class="form-control" value="<?php echo $Change7; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รูปรางวัล</label>
                                        <input type="text"  name="Image7" class="form-control" value="<?php echo $Image7; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-12 control-label">รางวัลที่ 8 [ใส่รางวัลพิเศษ]</label>
                                        <input type="text"  name="reward8" class="form-control" value="<?php echo $reward8; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">เปอร์เซ็นต์</label>
                                        <input type="number"  name="Change8" class="form-control" value="<?php echo $Change8; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รูปรางวัล</label>
                                        <input type="text"  name="Image8" class="form-control" value="<?php echo $Image8; ?>">
                                    </div>
                            </div>
                            
                            <div class="row mt-3">
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-12 control-label">ยอดฝากต่อ 1 สิทธิ์</label>
                                        <input type="number"  name="dp_creditspin" class="form-control" value="<?php echo $dp_creditspin; ?>">
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <label class="col-sm-12 control-label">แลกพ้อยด์ [1 พ้อยด์ = เครดิต]</label>
                                        <input type="number"  name="change_point" class="form-control" value="<?php echo $change_point; ?>">
                                    </div>
                                
                                    <!-- <div class="col-sm-4">
                                        <label class="col-sm-4 control-label">รูปรางวัล</label>
                                        <input type="text"  name="Image8" class="form-control" value="<?php echo $Image8; ?>">
                                    </div> -->
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                                
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;บันทึก</button>
                            </div></form>
            </div>
                </div>
            </div>
		</div>
	</div>
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="exampleModalLabel">รายละเอียดทรูมันนี่</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="setting_chk.php" data-action="load" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ชื่อเว็ปไซด์</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="name_web" class="form-control">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">โลโก้เว็ปไซด์</label>
                                    <div class="col-sm-5">
                                        <input class="form-control" type="file" name="logo_web" required="required" enctype="multipart/form-data" placeholder="ขนาดรูปที่เหมาะสม ; 1600 x 900">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">รูปหน้าปกเว็ปไซด์</label>
                                    <div class="col-sm-5">
                                        <input class="form-control" type="file" name="pic_web" required="required" enctype="multipart/form-data" placeholder="ขนาดรูปที่เหมาะสม ; 1600 x 900">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ข้อความสไลด์ 1</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="slide_1" class="form-control">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ข้อความสไลด์ 2</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="slide_2" class="form-control">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ไลน์ OA</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="lineoa" class="form-control">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ไลน์แจ้งเตือนสมัครสมาชิก</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="lineregister" class="form-control">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ไลน์แจ้งเตือนฝากเงิน</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="linedeposit" class="form-control">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ไลน์แจ้งเตือนถอนเงิน</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="linewithdraw" class="form-control">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">คืนยอดเสีย %</label>
                                    <div class="col-sm-5">
                                        <input type="number"  name="cashback" class="form-control" >
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">แนะนำเพื่อน %</label>
                                    <div class="col-sm-5">
                                        <input type="number"  name="affcashback" class="form-control">
                                    </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                                
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;บันทึก</button>
                            </div></form>
            </div>
        </div>
    </div>
</section>