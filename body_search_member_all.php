<section class="pcoded-main-container">
	<div class="pcoded-content">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<h5 class="text-dark">เช็คข้อมูลสมาชิก
						</h5>
						<hr>

						<div class="container">
							<div class="row">

								<div class="col-md-12">

									<form action="" method="GET" class="form-horizontal">
										<div class="form-group">

											<div class="col-sm-3">
												<input type="text" name="phone_mb" required class="form-control" placeholder="กรอกเบอร์โทรศัพท์ หรือ ยูสเซอร์เนม">
												<br>

												<button type="submit" class="btn btn-success" name="act" value="search" style="margin-bottom:-100px;">ค้นหา</button>


											</div>
										</div>
									</form><br>
									<form action="" method="GET" class="form-horizontal">
										<div class="col-md-12">
											<button class="btn btn-danger" name="act" value="100" style="margin-top:30px;">ค้นหา 100 รายการล่าสุด</button>
											<button class="btn btn-primary" name="act" value="500" style="margin-top:30px;">ค้นหา 500 รายการล่าสุด</button>
											<button class="btn btn-danger" name="act" value="1000" style="margin-top:30px;">ค้นหา 1,000 รายการล่าสุด</button>
											<button class="btn btn-primary" name="act" value="all" style="margin-top:30px;">ค้นหาทุกรายการทั้งหมด</button>
										</div>
									</form><br>


									<div class="table-responsive">
										<?php
										$act = (isset($_GET['act']) ? $_GET['act'] : '');
										$phone = $_GET['phone_mb'];

										$vowels = array($agent);
										$str = $phone;
										$test = str_replace($vowels, "", $str);
										//echo $test;
										$query = "";

										if ($act == 'search') {
											$query = "SELECT * FROM member WHERE phone_mb != '' AND phone_mb LIKE '%$phone%' OR username_mb LIKE '%$test%'" or die("Error: $con");
										} elseif ($act == '100') {
											$query = "SELECT * FROM member WHERE phone_mb != '' ORDER BY id_mb DESC LIMIT 100" or die("Error: $con");
										} elseif ($act == '500') {
											$query = "SELECT * FROM member WHERE phone_mb != '' ORDER BY id_mb DESC LIMIT 500" or die("Error: $con");
										} elseif ($act == '1000') {
											$query = "SELECT * FROM member WHERE phone_mb != '' ORDER BY id_mb DESC LIMIT 1000" or die("Error: $con");
										} else {
											$query = "SELECT * FROM member WHERE phone_mb != '' ORDER BY id_mb DESC" or die("Error: $con");
										}

										$result = mysqli_query($con, $query);
										echo "<table class='table table-dark'>";
										echo "<thead>";
										echo "<tr align='center'>
											<!--<th align='center' hide>ลำดับ</th>-->
											<th align='center'>สถานะ</th>
											<th align='center'>ยูสเซอร์เนม</th>
											<th align='center'>เบอร์โทรศัพท์</th>
											<th align='center'>ไอดีทรูวอเล็ต</th>
											<th align='center'>ชื่อ-นามสกุล</th>
											<th align='center'>วันลงทะเบียน</th>
											<th align='center'>เติมเครดิต</th>
											<th align='center'>ตัดเครดิต</th>
											<th align='center'>ฝาก</th>
											<th align='center'>ถอน</th>
											<th align='center'>แก้ไข</th>
											<th align='center'>ลบ</th>
										</tr>";

										echo "</thead>";



										echo "<tbody>";
										while ($row = mysqli_fetch_array($result)) {
											echo '<tr>'; ?>

											<td align='center'><?php
																if ($row["confirm_mb"] == "") {
																	echo "<a href='userupdateform.php?id_mb=$row[0]'><button class='btn btn-primary'>รอยืนยัน</button>";
																} elseif ($row["confirm_mb"] == "1") {
																	echo "<button class='btn btn-success' disabled>เรียบร้อย</button>";
																}

																?>
											<?php

											echo "<td align='center'>" . $agent . $row["username_mb"] .  "</td> ";
											echo "<td align='center'>" . $row["phone_mb"] .  "</td> ";
											echo "<td align='center'>" . $row["phone_true"] .  "</td> ";
											echo "<td align='center'>" . $row["name_mb"] .  "</td> ";
											echo "<td align='center'>" . $row["date_mb"] .  "</td> ";
											echo "<td align='center'><a href='addcredit.php?id_mb=$row[0]'><button class='btn btn-danger '><font color='white'>เติมเครดิต</font></button></a></td> ";

											echo "<td align='center'><a href='cutcredit.php?id_mb=$row[0]'><button class='btn btn-dark '><font color='white'>ตัดเครดิต</font></button></a></td> ";
											echo "<td align='center'><a href='depositform.php?id_mb=$row[0]'><button class='btn btn-success '><font color='white'>ฝาก</font></button></a></td> ";

											echo "<td align='center'><a href='withdrawform.php?id_mb=$row[0]'><button class='btn btn-warning '><font color='white'>ถอน</font></button></a></td> ";

											//แก้ไขข้อมูล
											echo "<td align='center'><a href='userupdateform.php?id_mb=$row[0]'><button class='btn btn-primary '><font color='white'>แก้ไข</font></button></a></td> ";

											//ลบข้อมูล
											echo "<td align='center'><a href='delete_mb.php?id_mb=$row[0]' onclick=\"return confirm('ต้องการลบข้อมูลนี้ !!!')\"><button class='btn btn-light '><font color='red'>ลบ</font></a></td> ";






											echo '</tr>';
										}
										echo '</tbody>';
										echo "</table>";
											?>




									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- <script>
		$(document).ready(function () {
			$('.table').not(".table-not").DataTable({
				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Thai.json"
				},
				dom: 'Bfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				]
			});
		});
	</script> -->
				</div>
			</div>
		</div>
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-dark" id="exampleModalLabel">เพิ่มสมาชิก</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<form class="form-horizontal ng-pristine ng-valid" method="POST" action="register_mb.php">
							<div class="form-group">
								<div class="row">
									<label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
									<div class="col-sm-4">
										<input type="text" placeholder="ยูสเซอร์เนม" name="" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" required="required" value="ไม่ต้องใส่" readonly>
									</div>
									<label class="col-sm-2 control-label">รหัสผ่าน</label>
									<div class="col-sm-4">
										<input type="text" placeholder="รหัสผ่าน" name="password_mb" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" required="required">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="col-sm-2 control-label">เลขบัญชีธนาคาร</label>
									<div class="col-sm-4">
										<input type="number" placeholder="เลขบัญชีธนาคาร" name="bankacc_mb" class="form-control ng-pristine ng-untouched ng-valid ng-empty" required="required">
									</div>
									<label class="col-sm-2 control-label">ธนาคาร</label>
									<div class="col-sm-4">
										<select required="required" class="custom-select custom-select-md" name="bank_mb">
											<option selected="selected" value="">-- เลือก --</option>
											<option value="ทรูวอเล็ต">ทรูวอเล็ต</option>
											<option value="ธ.กสิกรไทย">ธ.กสิกรไทย</option>
											<option value="ธ.กรุงไทย">ธ.กรุงไทย</option>
											<option value="ธ.กรุงศรีอยุธยา">ธ.กรุงศรีอยุธยา</option>
											<option value="ธ.กรุงเทพ">ธ.กรุงเทพ</option>
											<option value="ธ.ไทยพาณิชย์">ธ.ไทยพาณิชย์</option>
											<option value="ธ.ทหารทหารไทยธนชาติ">ธ.ทหารทหารไทยธนชาติ</option>
											<option value="ธ.เกียรตินาคินภัทร">ธ.เกียรตินาคินภัทร</option>
											<option value="ธ.ออมสิน">ธ.ออมสิน</option>
											<option value="ธ.ก.ส.">ธ.ก.ส.</option>
											<option value="ธ.ซีไอเอ็มบีไทย">ธ.ซีไอเอ็มบีไทย</option>
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
										<input type="number" placeholder="เบอร์โทรศัพท์" name="phone_mb" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
									</div>
									<label class="col-sm-2 control-label">ชื่อ-นามสกุล</label>
									<div class="col-sm-4">
										<input type="text" placeholder="ชื่อ-นามสกุล" name="name_mb" class="form-control ng-pristine ng-untouched ng-valid ng-empty" required="required">
									</div>
								</div>
							</div>


							<div class="form-group">
								<div class="row">
									<label class="col-sm-2 control-label">สถานะ</label>
									<div class="col-sm-4">
										<select required="required" class="custom-select custom-select-md" name="confirm_mb">
											<option value="">ยังไม่ยืนยัน</option>
											<option value="1">ยืนยัน</option>

										</select>
									</div>
									<input type="text" name="status_mb" value="2" hidden="hide">
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
	</div>
	</div>
	<script>
		function bannedKey(evt) {
			var allowedEng = true; //อนุญาตให้คีย์อังกฤษ
			var allowedThai = false; //อนุญาตให้คีย์ไทย
			var allowedNum = true; //อนุญาตให้คีย์ตัวเลข
			var k = event.keyCode; /* เช็คตัวเลข 0-9 */
			if (k >= 48 && k <= 57) {
				return allowedNum;
			}
			/* เช็คคีย์อังกฤษ a-z, A-Z */
			if ((k >= 65 && k <= 90) || (k >= 97 && k <= 122)) {
				return allowedEng;
			}
			/* เช็คคีย์ไทย ทั้งแบบ non-unicode และ unicode */
			if ((k >= 161 && k <= 255) || (k >= 3585 && k <= 3675)) {
				return allowedThai;
			}
		}
	</script>
</section>