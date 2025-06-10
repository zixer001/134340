<?php include 'inc/header.php'; ?>
<section class="pcoded-main-container">
	<div class="pcoded-content">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<h5 class="text-dark">เพิ่มรายการฝาก<a href="member.php" class="btn btn-success float-right">ย้อนกลับ</a>
						</h5>
						<hr>
						<div class="container">
							<div class="row">
								<?php
								//1. เชื่อมต่อ database:
								include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
								//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก
								if ($_GET["id_mb"] == '') {
									echo "<script type='text/javascript'>";
									echo "alert('Error Contact Admin !!');";
									echo "window.location = 'index.php'; ";
									echo "</script>";
								}
								//รับค่าไอดีที่จะแก้ไข
								$id_pd = mysqli_real_escape_string($con, $_GET['id_mb']);
								//2. query ข้อมูลจากตาราง:
								$sql = "SELECT * FROM member WHERE id_mb='$id_pd' ";
								$result = mysqli_query($con, $sql) or die("Error in query: $sql ");
								$row = mysqli_fetch_array($result);
								extract($row);
								?>
								<form class="form-horizontal ng-pristine ng-valid" method="POST" action="deposit_dp.php" enctype="multipart/form-data">
									<div class="form-group">
										<div class="row">
											<label class="col-sm-2 control-label requiredField">
												ใส่ยอดเงินที่ต้องการฝาก
												<span class="asteriskField">
													*
												</span>
											</label>
											<div class="col-sm-4">
												<input type="number" class="form-control" name="amount_dp" required="required">
											</div>
											<label class="col-sm-2  control-label requiredField" for="pro">
												เลือกรับโปรโมชั่นที่ท่านต้องการ
												<span class="asteriskField">
													*
												</span>
											</label>
											<div class="col-sm-4">
												<select name="promotion_dp" class="form-control" required="required">
													<option></option>
													<option value="ไม่รับโบนัส">ไม่รับโบนัส ไม่ต้องทำเทิร์น</option>
													<option value="เครดิตฟรี">เครดิตฟรี</option>
													<?php
													$query = "SELECT * FROM promotion  ORDER BY id desc" or die("Error:");
													$result = mysqli_query($con, $query);
													while ($row = mysqli_fetch_array($result)) {
														echo '<option value="' . $row["name_pro"] . '">' . $row["name_pro"] . '</option>';
													} ?>
												</select>
											</div>
										</div>
									</div>
									<input type="text" name="id_dp" hidden="hide" value="<?php echo ($id_mb); ?>">
									<input type="text" name="aff_dp" hidden="hide" value="<?php echo ($aff); ?>">
									<input type="text" name="confirm_dp" hidden="hide" value="รอดำเนินการ">
									<input type="text" name="username_dp" hidden="hide" value="<?php echo ($username_mb); ?>">
									<input type="text" name="phone_dp" hidden="hide" value="<?php echo ($phone_mb); ?>">
									<input type="text" name="bank_dp" hidden="hide" value="<?php echo ($bank_mb); ?>">
									<input type="text" name="bankacc_dp" hidden="hide" value="<?php echo ($bankacc_mb); ?>">
									<input type="text" name="name_dp" hidden="hide" value="<?php echo ($name_mb); ?>">
									<input type="text" name="fromTrue" hidden="hide" value="<?php echo ($phone_true); ?>">
									<div class="form-group" style="padding-top: 10px;" onclick="text-right">


										<label class="col-sm-2  control-label requiredField" for="pro"></label>
										<div class="col-sm-4">
											<button type="submit" class="btn btn-success">
												ทำรายการ
											</button>
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