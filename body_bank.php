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
                            
                            
                            <button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">เพิ่มธนาคาร</button>
                       
                        <hr>
<div class="table-responsive">
		<?php
			$query = "SELECT * FROM bank WHERE name_bank!='' ORDER BY id DESC" or die("Error:" . mysqli_error());
			$result = mysqli_query($con, $query);
			echo '<table id="example1" class="table">';
				echo "<thead >";
							echo '<tr align="center">
									<th class="text-center align-middle" width="15%">โลโก้ธนาคาร</th>
									<th class="text-center align-middle" width="25%">ธนาคาร/ทรูวอเล็ต</th>
									<th class="text-center align-middle" width="20%">เลขบัญชี</th>
									<th class="text-center align-middle" width="10%">ประเภท</th>
									<th class="text-center align-middle" width="10%">สถานะ</th>
									<th class="text-center align-middle" width="10%">โอนเงิน</th>
									<th class="text-center align-middle" width="10%">แก้ไข</th>
									<th class="text-center align-middle" width="10%">ลบ</th>
															</tr>';
												echo"</thead>";
												echo '<tbody>';
								while($row = mysqli_fetch_array($result)) {
								echo'<tr>';
											echo "<td align='center'>" ."<img src='../slip/".$row['fileupload_bank']  ."' width='30%'>"."</td>";
											echo "<td align='center'>" .$row["name_bank"] .  "</td> ";
											echo "<td align='center'>" .$row["bankacc_bank"] .  "</td> ";
											echo "<td align='center'>";
											if ($row["bankfor"]=="ฝาก") {
                                    echo"<button class='btn btn-info '>ฝาก</button>";
                                }
                                    elseif ($row["bankfor"]=="ถอน") {
                                        echo"<button class='btn btn-warning '>ถอน</button>";
                                    }
                                    elseif ($row["bankfor"]=="ฝากและถอน") {
                                        echo"<button class='btn btn-dark '>ฝากและถอน</button>";
                                    }
                                    echo"</td> ";
											echo "<td align='center'>";
											if ($row["status_bank"]=="เปิด") {
                                    echo"<button class='btn btn-success '>เปิด</button>";
                                }
                                    elseif ($row["status_bank"]=="ปิด") {
                                        echo"<button class='btn btn-danger '>ปิด</button>";
                                    }
                                    echo"</td> ";
                                    	if ($row["name_bank"]=='ธนาคารไทยพาณิชย์') {
                                    		echo "<td align='center'><button class='btn btn-danger' data-toggle='modal' data-target='#tfmoney1'>โอนเงิน</button></td> ";
                                    	}elseif($row["name_bank"]=='ธนาคารกสิกรไทย') {
                                    		echo "<td align='center'><button class='btn btn-danger' data-toggle='modal' data-target='#tfmoney'>โอนเงิน</button></td> ";
                                    	}else{
                                    		echo "<td align='center'><button class='btn btn-warning' data-toggle='modal' data-target='#'>โอนไม่ได้</button></td> ";
                                    	}
                                    		//แก้ไขข้อมูล
											echo "<td align='center'><a href='bankupdateform.php?id=$row[0]'><button class='btn btn-primary'><font color='white'>แก้ไข</font></button></a></td> ";
											
											//ลบข้อมูล
											echo "<td align='center'><a href='delete_bank.php?id=$row[0]' onclick=\"return confirm('ต้องการลบข้อมูลนี้ !!!')\"><button class='btn btn-light'><font color='red'>ลบ</font></a></td> ";
								echo'</tr>';
								}
					echo '</tbody>';
					
					
		echo "</table>";
		?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
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
	</script>
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-dark" id="exampleModalLabel">เพิ่มธนาคาร/ทรูวอเล็ต</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
						</button>
					</div>
					<form method="post" action="bank_chk.php" enctype="multipart/form-data">
						<input type="hidden" name="am_status" value="1">
						<div class="modal-body">
							<div class="mb-2">
								<span class="text-dark">ธนาคาร/ทรูวอเล็ต</span>
								<select required="required" class="custom-select custom-select-md" name="name_bank">
									<option selected="selected" value="">-- เลือก --</option>
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
							<div class="mb-2">
								<span class="text-dark">เลขบัญชี</span>
								<input class="form-control" name="bankacc_bank">
							</div>
							<div class="mb-2">
								<span class="text-dark">ชื่อบัญชี</span>
								<input class="form-control" name="nameacc_bank">
							</div>
							<div class="mb-2">
								<span class="text-dark">ประเภท</span>
								<select required="required" class="custom-select custom-select-md" name="bankfor">
									<option selected="selected" value="">-- เลือก --</option>
									<option value="ฝาก">ฝาก</option>
									<option value="ถอน">ถอน</option>
									<option value="ฝากและถอน">ฝากและถอน</option>
								</select>
							</div>
							<div class="mb-2">
								<span class="text-dark">สถานะ</span>
								<select required="required" class="custom-select custom-select-md" name="status_bank">
									<option selected="selected" value="">-- เลือก --</option>
									<option value="ปิด">ปิด</option>
									<option value="เปิด">เปิด</option>
									
								</select>
							</div>
							<div class="mb-2">
								<span class="text-dark">รูปธนาคาร</span>
								<input type="file" name="fileupload_bank" required="required" enctype="multipart/form-data">
							</div>
							
						</div>
						<div class="modal-footer">
							
							<button type="submit" class="btn btn-success" name="save">คลิ๊กเพื่อบันทึก</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="tfmoney" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-dark" id="exampleModalLabel">โอนเงิน</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
						</button>
					</div>
					<form method="post" action="../kbank525698/wd_kbank2.php">
					
						<div class="modal-body">
							<div class="mb-3">
								<span class="text-dark">ยอดเงิน</span>
								<input class="form-control" name="amount" required>
							</div>
							<input type="text" name="add_wd" value="<?php echo $name_ad;?>" hidden>
							<div class="mb-3">
								<span class="text-dark">เลขบัญชี</span>
								<input class="form-control" name="accountTo" required>
							</div>
							<div class="mb-3">
								<span class="text-dark mb-1">ธนาคาร</span>
								<select name="accountToBankCode" class="form-control m-b ng-pristine ng-untouched ng-valid ng-empty" required>
									<option value="">เลือก</option>
									
                                   
                                    <option value="ธ.กสิกรไทย">ธ.กสิกรไทย</option>
                                    <option value="ธ.กรุงไทย">ธ.กรุงไทย</option>
                                    <option value="ธ.กรุงศรีอยุธยา">ธ.กรุงศรีอยุธยา</option>
                                    <option value="ธ.กรุงเทพ">ธ.กรุงเทพ</option>
                                    <option value="ธ.ไทยพาณิชย์">ธ.ไทยพาณิชย์</option>
                                    <option value="ธ.ทหารไทยธนชาติ">ธ.ทหารไทยธนชาติ</option>
                                    <option value="ธ.ออมสิน">ธ.ออมสิน</option>
                                    <option value="ธ.ก.ส.">ธ.ก.ส.</option>
                                    <option value="ธ.ซีไอเอ็มบีไทย">ธ.ซีไอเอ็มบีไทย</option>
                                    <option value="ธ.เกียรตินาคิณภัทร">ธ.เกียรตินาคิณภัทร</option>
                                    <option value="ธ.ทิสโก้">ธ.ทิสโก้</option>
                                    <option value="ธ.ยูโอบี">ธ.ยูโอบี</option>
                                    <option value="ธ.อิสลาม">ธ.อิสลาม</option>
                                    <option value="ธ.ไอซีบีซี">ธ.ไอซีบีซี</option>
								</select>
							</div>
							<div class="mb-3">
								<span class="text-dark">รหัสถอนเงิน</span>
								<input type="password" class="form-control" name="key_input" required>
							</div>
						</div>
						<div class="modal-footer">
							
							<button type="submit" class="btn btn-success" name="save">คลิ๊กเพื่อบันทึก</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="tfmoney1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-dark" id="exampleModalLabel">โอนเงิน</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
						</button>
					</div>
					<form method="post" action="../cronjob-betflix/api_scb_trans.php?vsgersg456498">
					
						<div class="modal-body">
							<div class="mb-3">
								<span class="text-dark">ยอดเงิน</span>
								<input class="form-control" name="amount" required>
							</div>
							<input type="text" name="add_wd" value="<?php echo $name_ad;?>" hidden>
							<div class="mb-3">
								<span class="text-dark">เลขบัญชี</span>
								<input class="form-control" name="accountTo" required>
							</div>
							<div class="mb-3">
								<span class="text-dark mb-1">ธนาคาร</span>
								<select name="accountToBankCode" class="form-control m-b ng-pristine ng-untouched ng-valid ng-empty" required>
									<option value="">เลือก</option>
									
                                   
                                    <option value="ธ.กสิกรไทย">ธ.กสิกรไทย</option>
                                    <option value="ธ.กรุงไทย">ธ.กรุงไทย</option>
                                    <option value="ธ.กรุงศรีอยุธยา">ธ.กรุงศรีอยุธยา</option>
                                    <option value="ธ.กรุงเทพ">ธ.กรุงเทพ</option>
                                    <option value="ธ.ไทยพาณิชย์">ธ.ไทยพาณิชย์</option>
                                    <option value="ธ.ทหารไทยธนชาติ">ธ.ทหารไทยธนชาติ</option>
                                    <option value="ธ.ออมสิน">ธ.ออมสิน</option>
                                    <option value="ธ.ก.ส.">ธ.ก.ส.</option>
                                    <option value="ธ.ซีไอเอ็มบีไทย">ธ.ซีไอเอ็มบีไทย</option>
                                    <option value="ธ.เกียรตินาคิณภัทร">ธ.เกียรตินาคิณภัทร</option>
                                    <option value="ธ.ทิสโก้">ธ.ทิสโก้</option>
                                    <option value="ธ.ยูโอบี">ธ.ยูโอบี</option>
                                    <option value="ธ.อิสลาม">ธ.อิสลาม</option>
                                    <option value="ธ.ไอซีบีซี">ธ.ไอซีบีซี</option>
								</select>
							</div>
							<div class="mb-3">
								<span class="text-dark">รหัสถอนเงิน</span>
								<input type="password" class="form-control" name="key_input" required>
							</div>
						</div>
						<div class="modal-footer">
							
							<button type="submit" class="btn btn-success" name="save">คลิ๊กเพื่อบันทึก</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>						