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
                            <a class="btn btn-info" href="setting.php" role="button">ตั้งค่าเว็ปไซด์</a>
                            <a class="btn btn-primary" href="bank.php" role="button">ธนาคาร</a>
                            <a class="btn btn-secondary" href="staff.php" role="button">พนักงาน</a>
                            <a class="btn btn-success" href="promotion.php" role="button">โปรโมชั่น</a>
                            <a class="btn btn-danger" href="activity.php" role="button">กิจกรรม</a>
                          
					    	<button class="btn btn-success float-right" data-toggle="modal" data-target="#add_modal">เพิ่มโปรโมชั่น</button>
						</h5>
						<hr>
					<div class="row">
						<?php
									$query = "SELECT * FROM promotion ORDER BY id desc" or die("Error:" . mysqli_error());
									$result = mysqli_query($con, $query);
									while($row = mysqli_fetch_array($result)) {

										

									
						echo'<div class="col-md-3">
							<div class="card">
								<img src="../slip/'.$row["fileupload_pro"].'" width="100%" class="card-img-top">
								<div class="card-body">
									<h5 class="card-title">';
									echo $row["name_pro"];
									echo '</h5>';
									echo 'ลักษณะโบนัส '. ': ' .$row["time_pro"];
									echo '<br>';
									echo 'ยอดฝากขั้นต่ำ '. ': ' .$row["dp_pro"];
									echo '<br>';
									if ($row["bonus_pro"]=='0') {
										echo 'โบนัส '. ': ' .$row["bonusper_pro"].' เปอร์เซ็นต์';
									}
									elseif ($row["bonus_pro"]!='0') {
										echo 'โบนัส '. ': ' .$row["bonus_pro"];
									}
									echo '<br>';
									echo 'รับโบนัสสูงสุด '. ': ' .$row["max_pro"];
									echo '<br>';
									echo 'เกมส์ที่เล่นได้ '. ': ' .$row["games_pro"];
									echo '<br>';
									echo 'เทิร์นโอเวอร์ '. ': ' .$row["turn_pro"];
									echo '<br>';
									echo 'ข้อห้าม '. ': ' .$row["rules_pro"];
									echo '<br>';
									echo 'ถอนได้ '. ': ' .$row["wd_pro"];
									echo '<br>';
									
									echo '<br>';
									//แก้ไขข้อมูล
									echo "<td align='center'><a href='promotionupdateform.php?id=$row[0]'><button class='btn btn-primary '><font color='white'>แก้ไข</font></button></a></td> ";
									echo "<td align='center'><a href='delete_id.php?id=$row[0]' onclick=\"return confirm('ต้องการลบข้อมูลนี้ !!!')\"><button class='btn btn-light '><font color='red'>ลบ</font></a></td> ";

									
								echo'</div>
							</div>
						</div>';} ?>
					</div>
				</div>
			</div>
		</div>
			<style>
				.get {
					display: none;
				}

				.not {
					display: block;
				}
			</style>
			<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel">เพิ่มโปรโมชั่น</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<form method="post" action="promotion_chk.php" data-action="load" enctype="multipart/form-data">
							<input type="hidden" name="key_valid" value="ok">
							<input type="hidden" name="status" value="1">
							<div class="modal-body">
								
								<div class="mb-2">
									<span class="text-dark">รูปโปรโมชั่น</span>
									<input class="form-control" type="file" name="fileupload_pro" required="required" enctype="multipart/form-data" placeholder="ขนาดรูปที่เหมาะสม ; 1600 x 900">
								</div><br>
								<div class="mb-2">
									<span class="text-dark">ชื่อโปรโมชั่น</span>
									<input class="form-control" name="name_pro" value="" >
								</div>
								<div class="mb-2">	
									<span class="text-dark">ลักษณะโบนัส</span>					
								  <select required="required" class="custom-select custom-select-md" name="time_pro">
								  	<option value="สมาชิกใหม่">สมาชิกใหม่</option>
			                        <option value="รับได้ครั้งเดียว">รับได้ครั้งเดียว</option>
			                        <option value="รับได้วันละ 1 ครั้ง">รับได้วันละ 1 ครั้ง</option>
			                        <option value="รับได้ทุกครั้ง">รับได้ทุกครั้ง</option>
			                      </select>
								</div>			
								<div class="mb-2">
									<span class="text-dark">ยอดฝากขั้นต่ำ</span>
									<input type="number" class="form-control" name="dp_pro" value="" >
								</div>
								<div class="mb-2">
									<span class="text-dark">โบนัส (แบบกำหนดจำนวนเงิน)</span>
									<input type="number" class="form-control" name="bonus_pro" value="" placeholder="ถ้าไม่มีให้ใส่ 0" required="required">
								</div>
								<div class="mb-2">
									<span class="text-dark">โบนัส (แบบเปอร์เซ็นต์)</span>
									<input type="number" class="form-control" name="bonusper_pro" value="" placeholder="ถ้าไม่มีให้ใส่ 0" required="required">
								</div>
								<div class="mb-2">
									<span class="text-dark">รับได้สูงสุด</span>
									<input type="number" class="form-control" name="max_pro" value="" placeholder="ใส่จำนวนโบนัสสูงสุด" required="required">
								</div>
								<div class="mb-2">
									<span class="text-dark">เกมส์ที่เล่นได้</span>
									<input class="form-control" name="games_pro" value="" >
								</div>
								<div class="mb-2">
									<span class="text-dark">เทิร์นโอเวอร์</span>
									<input type="text" class="form-control" name="turn_pro" value="" >
								</div>
								<div class="mb-2">
									<span class="text-dark">กติกา</span>
									<input class="form-control" name="rules_pro" value="" >
								</div>
								<div class="mb-2">
									<span class="text-dark">ถอนได้สูงสุด</span>
									<input class="form-control" name="wd_pro" value="" >
								</div>
								
							</div>


							<div class="modal-footer">
								
								<button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;บันทึก</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel">แก้ไขโปรโมชั่น</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<form method="post" action="promotion_chk.php" data-action="load" enctype="multipart/form-data">
							<input type="hidden" name="key_valid" value="ok">
							<input type="hidden" name="status" value="1">
							<div class="modal-body">
								
								<div class="mb-2">
									<span class="text-dark">รูปโปรโมชั่น</span>
									<input class="form-control" type="file" name="fileupload_pro" required="required" enctype="multipart/form-data" placeholder="ขนาดรูปที่เหมาะสม ; 1600 x 900">
								</div><br>
								<div class="mb-2">
									<span class="text-dark">ชื่อโปรโมชั่น</span>
									<input class="form-control" name="name_pro" value="<?php  echo $row["name_pro"]; ?>" >
								</div>
								<div class="mb-2">
									<span class="text-dark">ยอดฝากขั้นต่ำ</span>
									<input class="form-control" name="dp_pro" value="<?php  echo $row["dp_pro"]; ?>" >
								</div>
								<div class="mb-2">
									<span class="text-dark">โบนัส (แบบกำหนดจำนวนเงิน)</span>
									<input class="form-control" name="bonus_pro" value="<?php  echo $row["bonus_pro"]; ?>" >
								</div>
								<div class="mb-2">
									<span class="text-dark">โบนัส (แบบเปอร์เซ็นต์)</span>
									<input class="form-control" name="bonusper_pro" value="<?php  echo $row["bonusper_pro"]; ?>" >
								</div>
								<div class="mb-2">
									<span class="text-dark">เกมส์ที่เล่นได้</span>
									<input class="form-control" name="games_pro" value="<?php  echo $row["games_pro"]; ?>" >
								</div>
								<div class="mb-2">
									<span class="text-dark">เทิร์นโอเวอร์</span>
									<input class="form-control" name="turn_pro" value="<?php  echo $row["turn_pro"]; ?>" >
								</div>
								<div class="mb-2">
									<span class="text-dark">กติกา</span>
									<input class="form-control" name="rules_pro" value="<?php  echo $row["rules_pro"]; ?>" >
								</div>
								<div class="mb-2">
									<span class="text-dark">ถอนได้สูงสุด</span>
									<input class="form-control" name="wd_pro" value="<?php  echo $row["wd_pro"]; ?>" >
								</div>

								
							</div>


							<div class="modal-footer">
								
								<button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;บันทึก</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<script>
				function remove(id) {
					/*Swal.fire({
						title: "คุณต้องการจะลบมั้ย?",
						text: "หากยืนยันแล้วจะไม่สามารถยกเลิกได้!",
						icon: "warning",
						buttons: true,
						buttons: ["ยกเลิก", "ลบ"],
						dangerMode: true,
					}).then((willDelete) => {
						if (willDelete) {
							window.location = "?page=promotion&del=" + id;
						}
					});*/
					
					Swal.fire({
						title: "คุณต้องการจะลบมั้ย?",
						text: "หากยืนยันแล้วจะไม่สามารถยกเลิกได้!",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes!'
					}).then((result) => {
						if (result.value) {
							window.location = "?page=promotion&del=" + id;
						}
					})
				}
				
				
				$(document).ready(function () {
					$('.table').DataTable({
						"language": {
							"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Thai.json"
						}
					});
				});
			</script>
		</div>
	</div>
</section>