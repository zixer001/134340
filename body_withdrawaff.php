<section class="pcoded-main-container">
	<div class="pcoded-content">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
					    <h5 class="text-dark">เช็คข้อมูลการถอน AFF
					    	<!--<button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">เพิ่มรายการถอนเงิน</button>-->
						</h5>
						<hr>
						<h5 class="text-dark" ><font color="#fff200">ยังไม่ได้ทำรายการ</font>
					    	<!--<button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">เพิ่มรายการถอนเงิน</button>-->
						</h5>
<div class="table-responsive">
<?php
	$query = "SELECT * FROM withdrawaff WHERE confirm_aff = 'รอดำเนินการ' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$result = mysqli_query($con, $query);
    echo '<table class="table table-dark">';
    echo "<thead>";
	echo "<tr align='center'>
		
			<th align='center'>สถานะ</th>
			<th align='center'>ยูสเซอร์เนม</th>
			<th align='center'>ยอดเงินถอน</th>
			<th align='center'>ธนาคารที่ใช้ถอน</th>
			<th align='center'>เบอร์โทรศัพท์</th>
			<th align='center'>ชื่อ-นามสกุล</th>
			<th align='center'>เวลา</th>
		
			
			
		</tr>";
		
	echo "</thead>";


	
	echo '<tbody>';
		while($row = mysqli_fetch_array($result)) {
		echo'<tr>';
			?>
			<td align='center'><?php 
			if ($row["confirm_aff"]=="รอดำเนินการ") {
				echo"<a href='withdrawaffupdateform.php?id=$row[0]'><button class='btn btn-primary'>กำลังดำเนินการ</button>";
			}
				elseif ($row["confirm_aff"]=="อนุมัติ") {
					echo"<button class='btn btn-success' disabled>อนุมัติ</button>";
				}
				elseif ($row["confirm_aff"]=="ปฏิเสธ") {
					echo"<button class='btn btn-danger' disabled>ปฏิเสธ</button>";
				}
			?>
				<?php
			
			echo "<td align='center'>".$agent.$row["username_aff"] .  "</td> ";
			echo "<td align='center'>" .$row["amount_aff"] .  "</td> ";
			echo "<td align='center'>" .$row["bankout_aff"] .  "</td> ";
			echo "<td align='center'>" .$row["phone_aff"] .  "</td> ";
			echo "<td align='center'>" .$row["name_aff"] .  "</td> ";
			echo "<td align='center'>" .$row["date_aff"] .  "</td> ";
			

		

			echo'</tr>';
		}
	echo '</tbody>';
	echo "</table>";			
	?>


					</div>
				
	<br><br><br><br>
					<h5 class="text-dark">ทำรายการแล้ว
					    	<!--<button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">เพิ่มรายการถอนเงิน</button>-->
						</h5>
<div class="table-responsive">
<?php
	$query = "SELECT * FROM withdrawaff WHERE confirm_aff != 'รอดำเนินการ' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$result = mysqli_query($con, $query);
    echo '<table id="example1" class="table">';
    echo "<thead>";
	echo "<tr align='center'>
		
			<th align='center'>สถานะ</th>
			<th align='center'>ยูสเซอร์เนม</th>
			<th align='center'>ยอดเงินถอน</th>
			<th align='center'>ธนาคารที่ใช้ถอน</th>
			<th align='center'>เบอร์โทรศัพท์</th>
			<th align='center'>ชื่อ-นามสกุล</th>
			<th align='center'>เวลา</th>
			<th align='center'>แก้ไข</th>
			
			
		</tr>";
		
	echo "</thead>";


	
	echo '<tbody>';
		while($row = mysqli_fetch_array($result)) {
		echo'<tr>';
			?>
			<td align='center'><?php 
			if ($row["confirm_aff"]=="รอดำเนินการ") {
				echo"<a href='withdrawaffupdateform.php?id=$row[0]'><button class='btn btn-primary'>กำลังดำเนินการ</button>";
			}
				elseif ($row["confirm_aff"]=="อนุมัติ") {
					echo"<button class='btn btn-success' disabled>อนุมัติ</button>";
				}
				elseif ($row["confirm_aff"]=="ปฏิเสธ") {
					echo"<button class='btn btn-danger' disabled>ปฏิเสธ</button>";
				}
			?>
				<?php
			
			echo "<td align='center'>".$agent.$row["username_aff"] .  "</td> ";
			echo "<td align='center'>" .$row["amount_aff"] .  "</td> ";
			echo "<td align='center'>" .$row["bankout_aff"] .  "</td> ";
			echo "<td align='center'>" .$row["phone_aff"] .  "</td> ";
			echo "<td align='center'>" .$row["name_aff"] .  "</td> ";
			echo "<td align='center'>" .$row["date_aff"] .  "</td> ";
			

			//แก้ไขข้อมูล
			echo "<td align='center'><a href='withdrawaffupdateform.php?id=$row[0]'><button class='btn btn-primary '><font color='white'>แก้ไข</font></button></a></td> ";

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
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-dark" id="exampleModalLabel">เพิ่มรายการถอนเงิน</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal ng-pristine ng-valid" method="POST" action="withdraw_aff.php">
					<div class="form-group">
						<div class="row">
							<label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
							<div class="col-sm-4">
								<input type="text" name="username_aff" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" required="required">
							</div>
							<label class="col-sm-2 control-label">ยอดเงินถอน</label>
							<div class="col-sm-4">
								<input type="text" name="amount_aff" class="form-control ng-pristine ng-untouched ng-valid ng-empty" type="number" required="required">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-sm-2 control-label">เลขบัญชีธนาคาร</label>
							<div class="col-sm-4">
								<input type="number" name="bankacc_aff" class="form-control ng-pristine ng-untouched ng-valid ng-empty" required="required">
							</div>
							<label class="col-sm-2 control-label">ธนาคาร</label>
							<div class="col-sm-4">
								<select required="required" class="custom-select custom-select-md" name="bank_aff">
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
								<input type="number" name="phone_aff" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
							</div>
							<label class="col-sm-2 control-label">ชื่อ-นามสกุล</label>
							<div class="col-sm-4">
								<input type="text" name="name_aff" class="form-control ng-pristine ng-untouched ng-valid ng-empty" required="required">
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="row">
							<label class="col-sm-2 control-label">สถานะ***</label>
							<div class="col-sm-4">
								<select required="required" class="custom-select custom-select-md" name="confirm_aff">
									<option value="รอดำเนิการ">รอดำเนินการ</option>
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
function bannedKey(evt)
{
var allowedEng = true; //อนุญาตให้คีย์อังกฤษ
var allowedThai = false; //อนุญาตให้คีย์ไทย
var allowedNum = true; //อนุญาตให้คีย์ตัวเลข
var k = event.keyCode;/* เช็คตัวเลข 0-9 */
if (k>=48 && k<=57) { return allowedNum; }
/* เช็คคีย์อังกฤษ a-z, A-Z */
if ((k>=65 && k<=90) || (k>=97 && k<=122)) { return allowedEng; }
/* เช็คคีย์ไทย ทั้งแบบ non-unicode และ unicode */
if ((k>=161 && k<=255) || (k>=3585 && k<=3675)) { return allowedThai; }
}
</script>
</section>