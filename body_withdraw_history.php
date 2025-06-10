<section class="pcoded-main-container">
	<div class="pcoded-content">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<h5 class="text-dark">เช็คข้อมูลการถอน
							<!--<button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">เพิ่มรายการถอนเงิน</button>-->
						</h5>
						<hr>
						<div class="container">
							<div class="row">

								<div class="col-md-12">

									<form action="" method="GET" class="form-horizontal">
										<div class="form-group">

											<div class="col-sm-3">
												<input type="text" name="phone_wd" required class="form-control" placeholder="กรอกเบอร์โทรศัพท์ หรือ ยูสเซอร์เนม">
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
										$phone = $_GET['phone_wd'];

										$vowels = array($agent);
										$str = $phone;
										$test = str_replace($vowels, "", $str);
										//echo $test;


										if ($act == 'search') {
											include('../connectdb.php');
											$query = "SELECT * FROM withdraw WHERE confirm_wd != 'รอดำเนินการ' AND confirm_wd!='' AND phone_wd LIKE '%$phone%' OR username_wd LIKE '%$test%' ORDER BY id DESC";
										} elseif ($act == 100) {
											$query = "SELECT * FROM withdraw WHERE confirm_wd != 'รอดำเนินการ' AND confirm_wd!='' ORDER BY id DESC LIMIT 100";
										} elseif ($act == 500) {
											$query = "SELECT * FROM withdraw WHERE confirm_wd != 'รอดำเนินการ' AND confirm_wd!='' ORDER BY id DESC LIMIT 500";
										} elseif ($act == 1000) {
											$query = "SELECT * FROM withdraw WHERE confirm_wd != 'รอดำเนินการ' AND confirm_wd!='' ORDER BY id DESC LIMIT 1000";
										} else {
											$query = "SELECT * FROM withdraw WHERE confirm_wd != 'รอดำเนินการ' AND confirm_wd!='' ORDER BY id DESC";
										}

										$result = mysqli_query($con, $query);
										echo '<table class="table table-dark">';
										echo "<thead>";
										echo "<tr align='center'>
			<th align='center'>ลำดับ</th>
			<th align='center'>สถานะ</th>
			<th align='center'>ยูสเซอร์เนม</th>
			<th align='center'>ยอดเงินถอน</th>
			<th align='center'>ยอดเงินคืน</th>
			<th align='center'>ธนาคารที่ใช้ถอน</th>
			<th align='center'>เบอร์โทรศัพท์</th>
			<th align='center'>ชื่อ-นามสกุล</th>
			<th align='center'>เวลา</th>
			<th align='center'>แก้ไข</th>
			
			
		</tr>";

										echo "</thead>";



										echo '<tbody>';
										while ($row = mysqli_fetch_array($result)) {
											echo '<tr>';
											echo "<td align='center'>" . $row["id"] .  "</td> "; ?>

											<td align='center'><?php
																if ($row["confirm_wd"] == "รอดำเนินการ") {
																	echo "<a href='withdrawupdateform.php?id=$row[0]'><button class='btn btn-primary'>กำลังดำเนินการ</button>";
																} elseif ($row["confirm_wd"] == "อนุมัติ") {
																	echo "<button class='btn btn-success' disabled>อนุมัติ</button>";
																} elseif ($row["confirm_wd"] == "ปฏิเสธ") {
																	echo "<button class='btn btn-danger' disabled>ปฏิเสธ</button>";
																}
																?>
											<?php

											echo "<td align='center'>" . $agent . $row["username_wd"] .  "</td> ";
											echo "<td align='center'>" . $row["amount_wd"] .  "</td> ";
											echo "<td align='center'>" . $row["amount_cashback"] .  "</td> ";
											echo "<td align='center'>" . $row["bankout_wd"] .  "</td> ";
											echo "<td align='center'>" . $row["phone_wd"] .  "</td> ";
											echo "<td align='center'>" . $row["name_wd"] .  "</td> ";
											echo "<td align='center'>" . $row["date_wd"] .  "</td> ";



											//แก้ไขข้อมูล
											echo "<td align='center'><a href='withdrawupdateform.php?id=$row[0]'><button class='btn btn-primary '><font color='white'>แก้ไข</font></button></a></td> ";

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

	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-dark" id="exampleModalLabel">เพิ่มรายการถอนเงิน</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="form-horizontal ng-pristine ng-valid" method="POST" action="withdraw_wd.php">
						<div class="form-group">
							<div class="row">
								<label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
								<div class="col-sm-4">
									<input type="text" name="username_wd" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" required="required">
								</div>
								<label class="col-sm-2 control-label">ยอดเงินถอน</label>
								<div class="col-sm-4">
									<input type="text" name="amount_wd" class="form-control ng-pristine ng-untouched ng-valid ng-empty" type="number" required="required">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label class="col-sm-2 control-label">เลขบัญชีธนาคาร</label>
								<div class="col-sm-4">
									<input type="number" name="bankacc_wd" class="form-control ng-pristine ng-untouched ng-valid ng-empty" required="required">
								</div>
								<label class="col-sm-2 control-label">ธนาคาร</label>
								<div class="col-sm-4">
									<select required="required" class="custom-select custom-select-md" name="bank_wd">
										<option selected="selected" value="">-- เลือก --</option>
										<option value="ทรูวอเล็ต">ทรูวอเล็ต</option>
										<option value="ธ.กสิกร">ธ.กสิกร</option>
										<option value="ธ.กรุงไทย">ธ.กรุงไทย</option>
										<option value="ธ.กรุงศรีอยุธยา">ธ.กรุงศรีอยุธยา</option>
										<option value="ธ.กรุงเทพ">ธ.กรุงเทพ</option>
										<option value="ธ.ไทยพาณิชย์">ธ.ไทยพาณิชย์</option>
										<option value="ธ.ทหารทหารไทยธนชาติ">ธ.ทหารทหารไทยธนชาติ</option>
										<option value="ธ.ทหารไทย">ธ.ทหารไทย</option>
										<option value="ธ.ธนชาติ">ธ.ธนชาติ</option>
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
									<input type="number" name="phone_wd" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
								</div>
								<label class="col-sm-2 control-label">ชื่อ-นามสกุล</label>
								<div class="col-sm-4">
									<input type="text" name="name_wd" class="form-control ng-pristine ng-untouched ng-valid ng-empty" required="required">
								</div>
							</div>
						</div>


						<div class="form-group">
							<div class="row">
								<label class="col-sm-2 control-label">สถานะ***</label>
								<div class="col-sm-4">
									<select required="required" class="custom-select custom-select-md" name="confirm_wd">
										<option value="รอดำเนิการ">รอดำเนินการ</option>
										<option value="อนุมัติ">อนุมัติ</option>
										<option value="ปฏิเสธ">ปฏิเสธ</option>
									</select>
								</div>
								<label class="col-sm-2 control-label">หมายเหตุ***</label>
								<div class="col-sm-4">
									<input type="text" name="note_wd" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 control-label">ธนาคารที่ใช้ถอน***</label>
							<div class="col-sm-4">
								<select required="required" class="custom-select custom-select-md" name="bankout_wd">
									<option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
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