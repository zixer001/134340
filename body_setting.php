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
                    <form method="post" action="setting_chk.php" data-action="load" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ชื่อเว็ปไซด์</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="name_web" class="form-control" value="<?php echo $name_web; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ลิ้งค์เว็ปไซด์</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="link_web" class="form-control" value="<?php echo $link_web; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ลิ้งค์แนะนำเพื่อน</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="link_aff" class="form-control" value="<?php echo $link_aff; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ยูสเซอร์เอเย่นต์</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="agent" class="form-control" value="<?php echo $agent; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">x-api-betflix</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="pass_agent" class="form-control" value="<?php echo $pass_agent; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">x-api-key</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="txtTotal" class="form-control" value="<?php echo $txtTotal; ?>">
                                    </div>
                            </div>
                            <!-- <div class="row mt-3">
                                <label class="col-sm-2 control-label">ลิ้งค์เอเย่นต์</label>
                                    <div class="col-sm-5"> -->
                                        <input type="text"  name="agent_link" class="form-control" value="" hidden>
                                    <!-- </div>
                            </div> -->
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">โลโก้เว็ปไซด์</label>
                                <div class="col-sm-5">
                                <input class="form-control" type="text" name="logo_web" required="required" placeholder="ลิ้งค์ที่อยู่ของรูป" value="<?php echo $logo_web; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">รูปหน้าปกเว็ปไซด์</label>
                                    <div class="col-sm-5">
                                    <input class="form-control" type="text" name="pic_web" required="required" placeholder="ลิ้งค์ที่อยู่ของรูป" value="<?php echo $pic_web; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">รูปหน้า User</label>
                                    <div class="col-sm-5">
                                    <input class="form-control" type="text" name="pic_user" required="required" placeholder="ลิ้งค์ที่อยู่ของรูป" value="<?php echo $pic_user; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ข้อความสไลด์ 1</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="slide_1" class="form-control" value="<?php echo $slide_1; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ข้อความสไลด์ 2</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="slide_2" class="form-control" value="<?php echo $slide_2; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ไลน์ OA</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="lineoa" class="form-control" value="<?php echo $lineoa; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ไลน์แจ้งเตือนสมัครสมาชิก</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="lineregister" class="form-control" value="<?php echo $lineregister; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ไลน์แจ้งเตือนฝากเงิน</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="linedeposit" class="form-control" value="<?php echo $linedeposit; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ไลน์แจ้งเตือนถอนเงิน</label>
                                    <div class="col-sm-5">
                                        <input type="text"  name="linewithdraw" class="form-control" value="<?php echo $linewithdraw; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">คืนยอดเสีย %</label>
                                    <div class="col-sm-5">
                                        <input type="number"  name="cashback" class="form-control" value="<?php echo $cashback; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">แนะนำเพื่อน %</label>
                                    <div class="col-sm-5">
                                        <input type="number"  name="affcashback" class="form-control" value="<?php echo $affcashback; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ฝากเงินขั้นต่ำ</label>
                                    <div class="col-sm-5">
                                        <input type="number"  name="set_dp" class="form-control" value="<?php echo $set_dp; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ถอนเงินขั้นต่ำ</label>
                                    <div class="col-sm-5">
                                        <input type="number"  name="set_wd" class="form-control" value="<?php echo $set_wd; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">สถานะถอนออโต้</label>
                                    <div class="col-sm-5">
                                        <select required="required" class="custom-select custom-select-md" name="status_auto">
                                        <option selected="selected" value="<?php echo $status_auto; ?>"><?php echo $status_auto; ?></option>
                                        <option value="ปิด">ปิด</option>
                                        <option value="เปิด">เปิด</option>
                                    </select>
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">ถอนออโต้สูงสุด</label>
                                    <div class="col-sm-5">
                                        <input type="number"  name="max_autowd" class="form-control" value="<?php echo $max_autowd; ?>">
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">สถานะระบบออโต้</label>
                                    <div class="col-sm-5">
                                        <select required="required" class="custom-select custom-select-md" name="status_auto2">
                                        <option selected="selected" value="<?php echo $status_auto2; ?>"><?php echo $status_auto2; ?></option>
                                        <option value="ปิด">ปิด</option>
                                        <option value="เปิด">เปิด</option>
                                    </select>
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <label class="col-sm-2 control-label">กติกาทั่วไป</label>
                                    <div class="col-sm-5">
                                        <textarea name="rules" id="editor" cols="100" rows="20"><?php echo $rules; ?></textarea>
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