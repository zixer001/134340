<?php include 'inc/header.php'; ?>
<section class="pcoded-main-container">
	<div class="pcoded-content">
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						<h5 class="text-dark">เพิ่มเครดิต<a href="member.php" class="btn btn-success float-right btn-sm">ย้อนกลับ</a>
						</h5>
						<hr>
						<?php
						//1. เชื่อมต่อ database:
						include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
						//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก

						//รับค่าไอดีที่จะแก้ไข
						$id2 = mysqli_real_escape_string($con, $_GET['id']);
						//2. query ข้อมูลจากตาราง:
						$sql = "SELECT * FROM deposit WHERE id='$id2'";
						$result = mysqli_query($con, $sql) or die("Error in query: $sql " . mysqli_error());
						$row = mysqli_fetch_array($result);
						extract($row);
						$username_mb =  $username_dp;

						include('../class/betflix.php');
						$api = new Betflix();          ?>
						<form method="POST" action="api/tran_betflix.php?deposit">
							<div class="form-group">
								<div class="row">
									<input type="text" name="admin" value="0" hidden>
									<label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
									<div class="col-sm-4">
										<input type="text" name="username" style="color: #fff200;" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?php echo $agent . $username_dp; ?>" readonly="readonly">
										<input type="text" name="admin" value="<?php echo $name_ad; ?>" hidden>
									</div>
									<label class="col-sm-2 control-label">จำนวนที่ต้องเติมเครดิต</label>
									<div class="col-sm-4">
										<input type="text" name="amount" style="color: #fff200;" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?php

																																																				$query = "SELECT * FROM promotion  ORDER BY id desc" or die("Error:" . mysqli_error());
																																																				$result = mysqli_query($con, $query);


																																																				if ($promotion_dp == 'ไม่รับโบนัส') {
																																																					echo $amount_dp + 0;
																																																				}

																																																				while ($row = mysqli_fetch_array($result)) {
																																																					$namepro = $row['name_pro'];
																																																					$bonuspro = $row['bonus_pro'];
																																																					$bonusperpro = $row['bonusper_pro'];

																																																					if ($promotion_dp == $namepro) {

																																																						echo ($amount_dp + $bonuspro) + ($amount_dp * $bonusperpro / 100);
																																																					}
																																																				}
																																																				if ($amount_dp == 'กิจกรรม') {

																																																					echo $bonus_dp;
																																																				}
																																																				?>">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" name="id" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?= $_GET['id']; ?>" readonly="readonly" hidden>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="col-sm-2 control-label"></label>
									<div class="col-sm-4">
										<button type="submit" class="btn btn-warning">เพิ่มเครดิต</button>
									</div>
								</div>
							</div>
						</form>
						<iframe src="<?php echo $agent_link; ?>" width="100%" height="500"></iframe>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						<h5 class="text-dark">ตรวจสอบรายการฝากเงิน<a href="deposit.php" class="btn btn-success float-right">ย้อนกลับ</a>
						</h5>
						<hr>


						<h5 class="text-dark">
							<font color="#fff200"></font> เครดิตคงเหลือ : <font color="#fff200"><?php echo $Balance;  ?></font>
							<font color="#fff200"></font>&nbsp;&nbsp;&nbsp;&nbsp;ยอดเติมเงิน : <font color="#fff200"><?= $amount_dp; ?></font>&nbsp;&nbsp;&nbsp;&nbsp;โปรโมชั่นที่รับ : <font color="#fff200"><?= $promotion_dp; ?></font>
						</h5><br>
						<div class="container">
							<div class="row">
								<form action="api_amb.php?deposit" class="form-horizontal ng-pristine ng-valid" method="POST">
									<div class="form-group" style="margin-right: 50px;">
										<div class="row">

											<!--<label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
                    <div class="col-sm-4">
                      <input type="text" name="username" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?php echo $agent; ?><?= $username_dp; ?>" readonly="readonly">
                    </div>
                    <label class="col-sm-2 control-label">ยอดเงินฝาก</label>
                    <div class="col-sm-4">
                      <input type="number" name="" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  value="<?= $amount_dp; ?>" readonly="readonly">
                    </div>
                  </div><br>-->

											<label class="col-sm-2 control-label">โบนัส</label>
											<div class="col-sm-4">
												<input type="text" name="bonus_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" readonly="readonly" value="<?php

																																																					$query = "SELECT * FROM promotion  ORDER BY id desc" or die("Error:" . mysqli_error());
																																																					$result = mysqli_query($con, $query);


																																																					if ($promotion_dp == 'ไม่รับโบนัส') {
																																																						echo 0;
																																																					}
																																																					while ($row = mysqli_fetch_array($result)) {
																																																						$namepro = $row['name_pro'];
																																																						$bonuspro = $row['bonus_pro'];
																																																						$bonusperpro = $row['bonusper_pro'];
																																																						if ($promotion_dp == $namepro) {

																																																							echo $bonuspro + ($amount_dp * $bonusperpro / 100);
																																																						}
																																																					}
																																																					if ($amount_dp == 'กิจกรรม') {

																																																						echo $bonus_dp;
																																																					}
																																																					?>">
											</div>



											<label class="col-sm-2 control-label">เทิร์นโอเวอร์</label>
											<div class="col-sm-4">
												<input type="text" name="turnover" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?php

																																							$query = "SELECT * FROM promotion  ORDER BY id desc" or die("Error:" . mysqli_error());
																																							$result = mysqli_query($con, $query);


																																							if ($promotion_dp == 'ไม่รับโบนัส') {
																																								echo 0;
																																							}
																																							while ($row = mysqli_fetch_array($result)) {
																																								$namepro = $row['name_pro'];
																																								$bonuspro = $row['bonus_pro'];
																																								$bonusperpro = $row['bonusper_pro'];
																																								$turnpro = $row['turn_pro'];
																																								if ($promotion_dp == $namepro) {
																																									if ($bonuspro == 0) {
																																										echo (($amount_dp + $bonuspro) + ($amount_dp * $bonusperpro / 100)) * $turnpro;
																																									} else {
																																										echo $turnpro;
																																									}
																																								}
																																							}

																																							if ($amount_dp == 'กิจกรรม') {

																																								echo $turnover;
																																							}
																																							?>">
											</div>
											<!--<label class="col-sm-2 control-label"></label>
                      <div class="col-sm-4">
                      <button type="submit" class="btn btn-warning" name="Update" id="Update" value="Update">เติมเครดิต</button>
                    </div>-->

										</div>



								</form>
								<br>
								<form class="form-horizontal ng-pristine ng-valid" method="POST" action="depositupdate_db.php">
									<div class="form-group">
										<div class="row">
											<input type="" name="id" value="<?php echo $id2; ?>" hidden />
											<label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
											<div class="col-sm-4">
												<input type="text" name="" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" value="<?php echo $agent; ?><?= $username_dp; ?>" readonly="readonly">
											</div>
											<label class="col-sm-2 control-label">ยอดเงินฝาก</label>
											<div class="col-sm-4">
												<input type="text" name="amount_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?php if ($amount_dp == '') {
																																								echo 'รอฝาก';
																																							} else {
																																								echo $amount_dp;
																																							}; ?>" readonly="readonly">
											</div>
										</div>
									</div>

									<input type="text" name="turnover" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?php

																																				$query = "SELECT * FROM promotion  ORDER BY id desc" or die("Error:" . mysqli_error());
																																				$result = mysqli_query($con, $query);


																																				if ($promotion_dp == 'ไม่รับโบนัส') {
																																					echo 0;
																																				}
																																				while ($row = mysqli_fetch_array($result)) {
																																					$namepro = $row['name_pro'];
																																					$bonuspro = $row['bonus_pro'];
																																					$turnpro = $row['turn_pro'];
																																					$bonusperpro = $row['bonusper_pro'];
																																					if ($promotion_dp == $namepro) {

																																						if ($bonuspro == 0) {
																																							echo (($amount_dp + $bonuspro) + ($amount_dp * $bonusperpro / 100)) * $turnpro;
																																						} else {
																																							echo $turnpro;
																																						}
																																					}
																																				}
																																				if ($amount_dp == 'กิจกรรม') {

																																					echo $turnover;
																																				}
																																				?>" readonly="readonly" hidden='hide'>
									<input type="text" name="bonus_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" readonly="readonly" value="<?php

																																																		$query = "SELECT * FROM promotion  ORDER BY id desc" or die("Error:" . mysqli_error());
																																																		$result = mysqli_query($con, $query);


																																																		if ($promotion_dp == 'ไม่รับโบนัส') {
																																																			echo 0;
																																																		}
																																																		while ($row = mysqli_fetch_array($result)) {
																																																			$namepro = $row['name_pro'];
																																																			$bonuspro = $row['bonus_pro'];
																																																			$bonusperpro = $row['bonusper_pro'];
																																																			if ($promotion_dp == $namepro) {

																																																				echo $bonuspro + ($amount_dp * $bonusperpro / 100);
																																																			}
																																																		}
																																																		if ($amount_dp == 'กิจกรรม') {

																																																			echo $bonus_dp;
																																																		}
																																																		?>" readonly="readonly" hidden='hide'>
									<div class="form-group">
										<div class="row">
											<label class="col-sm-2 control-label">เลขบัญชีธนาคาร</label>
											<div class="col-sm-4">
												<input type="number" name="bankacc_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?= $bankacc_dp; ?>" readonly="readonly">
											</div>
											<label class="col-sm-2 control-label">ธนาคาร</label>
											<div class="col-sm-4">
												<input type="text" name="bank_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?= $bank_dp; ?>" readonly="readonly">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<label class="col-sm-2 control-label">เบอร์โทรศัพท์</label>
											<div class="col-sm-4">
												<input type="number" name="phone_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?= $phone_dp; ?>" readonly="readonly">
											</div>
											<label class="col-sm-2 control-label">ชื่อ-นามสกุล</label>
											<div class="col-sm-4">
												<input type="text" name="name_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?= $name_dp; ?>" readonly="readonly">
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<label class="col-sm-2 control-label">ธนาคารที่โอนเข้า</label>
											<div class="col-sm-4">
												<select required="required" class="custom-select custom-select-md" name="bankin_dp">
													<option selected="selected" value="<?= $bankin_dp; ?>"><?= $bankin_dp; ?></option>
													<option value="ไม่ถูกต้อง">ไม่ถูกต้อง/เครดิตฟรี</option>

													<?php
													$querybank1 = "SELECT * FROM bank WHERE bankfor LIKE '%ฝาก%' AND status_bank ='เปิด' ";
													$resultbank1 = mysqli_query($con, $querybank1);

													while ($bank1 = mysqli_fetch_array($resultbank1)) { ?>
														<option value="<?php echo $bank1['name_bank']; ?> <?php echo $bank1['bankacc_bank']; ?>"><?php echo $bank1['name_bank']; ?> <?php echo $bank1['bankacc_bank'];
																																												} ?></option>


														<!-- <option value="กิจกรรม">กิจกรรม</option> -->

												</select>
											</div>

											<label class="col-sm-2 control-label">หมายเหตุ***</label>
											<div class="col-sm-4">
												<input type="text" name="note_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?= $note_dp; ?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<label class="col-sm-2 control-label">สถานะ***</label>
											<div class="col-sm-4">
												<select required="required" class="custom-select custom-select-md" name="confirm_dp">
													<option value="<?= $confirm_dp; ?>"><?= $confirm_dp; ?></option>
													<option value="อนุมัติ">อนุมัติ</option>
													<option value="ปฏิเสธ">ปฏิเสธ</option>
												</select>
											</div>
											<label class="col-sm-2 control-label">โปรโมชั่น</label>
											<div class="col-sm-4">
												<input type="text" name="promotion_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?= $promotion_dp; ?>" readonly="readonly">
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<label class="col-sm-2 control-label"></label>
											<div class="col-sm-4">
												<button type="submit" class="btn btn-danger" name="Update" id="Update" value="Update">คลิ๊กเพื่อบันทึก</button>
											</div>
										</div>
									</div>
								</form>
								<div class="row">
									<div class="col-md-12">
										<?php
										//1. เชื่อมต่อ database:
										include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
										//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก

										//รับค่าไอดีที่จะแก้ไข
										$id2 = mysqli_real_escape_string($con, $_GET['id']);
										//2. query ข้อมูลจากตาราง:
										$sql = "SELECT * FROM deposit WHERE id='$id2'";
										$result = mysqli_query($con, $sql) or die("Error in query: $sql " . mysqli_error());
										$row = mysqli_fetch_array($result);
										extract($row);
										?>
										<?php
										//หัวข้อตาราง
										echo "<td>" . "<img src='../slip/" . $row['fileupload']  . "' width='100%'>" . "</td>";
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
	</div>
</section>
<?php include 'inc/footer.php'; ?>