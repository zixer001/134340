<?php 
    if ($status_ad=='Call center') {
        header("Content-Type: text/html; charset=utf-8");
        echo "<script type='text/javascript'>";
        echo "alert('คุณไม่มีสิทธิ์เข้าใช้หน้านี้');";
        echo "window.location = 'member.php'; ";
        echo "</script>";
    }

?>
<section class="pcoded-main-container">
	<div class="pcoded-content">
		<link rel="stylesheet" type="text/css" href="datetimepicker/jquery.datetimepicker.css">
    <script type="text/javascript" src="datetimepicker/jquery.js"></script>
    <script type="text/javascript" src="datetimepicker/jquery.datetimepicker.js"></script>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
					    <h5 class="text-dark">ค้นหาประวัติหมุนวงล้อ
					    	<!--<button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">เพิ่มรายการถอนเงิน</button>-->
						</h5>
						<hr>
<div class="container">	
		

			<div class="col-md-12">

<form action="" method="GET" class="form-horizontal">
	<div class="form-group">
	<div class="row">
			<div class="col-sm-3">
				<input type="text" name="phone_dp" required class="form-control" placeholder="กรอกยูสเซอร์เนม">
			<br>
				<button type="submit" class="btn btn-success" name="act" value="search"  style="margin-bottom:-100px;">ค้นหา</button>

			
			</div></div>
	</div></form><br><br>
	<form action="" method="GET" class="form-horizontal">
		<div class="row">
		<div class="col-md-2">
                                    <label for="start">จากวันที่ :</label>
                                    <input class="form-control" type="text" name="From" value="" id="startdate" style="width:100%; border:none; border-bottom:1px solid #d2d2e4; color:#71748d;">
                                </div>
                                <div class="col-md-2">
                                    <label for="start">ถึงวันที่ :</label>
                                    <input class="form-control" type="text" name="To" value="" id="startdate2" style="width:100%; border:none; border-bottom:1px solid #d2d2e4; color:#71748d;">
                                </div>
                                <div class="col-md-1" style="margin-top:30px;">
                                    <button type="submit" class="btn btn-warning btn-block" name="act" value="400">ค้นหา</button>
                                </div>
		<div class="col-md-12">
			<button class="btn btn-danger" name="act" value="100" style="margin-top:30px;">ค้นหา 100 รายการล่าสุด</button>
			<button class="btn btn-primary" name="act" value="500" style="margin-top:30px;">ค้นหา 500 รายการล่าสุด</button>
			<button class="btn btn-danger" name="act" value="1000" style="margin-top:30px;">ค้นหา 1,000 รายการล่าสุด</button>
			<button class="btn btn-primary" name="act" value="all" style="margin-top:30px;">ค้นหาทุกรายการทั้งหมด</button>
		</div></div>
	</form><br>
<script type="text/javascript">
jQuery('#startdate').datetimepicker({
    lang:'th',
timepicker:false,
format:'Y-m-d'
});
</script>
<script type="text/javascript">
jQuery('#startdate2').datetimepicker({
    lang:'th',
timepicker:false,
format:'Y-m-d'
});
</script>

<div class="table-responsive">
<?php
	$act = (isset($_GET['act']) ? $_GET['act'] : '');
	$phone = $_GET['phone_dp'];
	

	$vowels = array($agent);
	$str = $phone;
	$test = str_replace($vowels, "", $str);

	if ($act=='search') {
		include('../connectdb.php');
	$query = "SELECT * FROM history_spin WHERE username LIKE '%$test%' ORDER BY id DESC" or die("Error:" . mysqli_error());
	}elseif ($act==100){
	$query = "SELECT * FROM history_spin ORDER BY id DESC LIMIT 100" or die("Error:" . mysqli_error());
	}elseif ($act==500){
	$query = "SELECT * FROM history_spin ORDER BY id DESC LIMIT 500" or die("Error:" . mysqli_error());
	}elseif ($act==1000){
	$query = "SELECT * FROM history_spin ORDER BY id DESC LIMIT 1000" or die("Error:" . mysqli_error());
	}elseif ($act==all){
	$query = "SELECT * FROM history_spin ORDER BY id DESC" or die("Error:" . mysqli_error());
	}elseif ($act==400){
	$act = (isset($_GET['act']) ? $_GET['act'] : '');
    $from = $_GET['From'];
    $to = $_GET['To'];
    $to2= date('Y-m-d', strtotime($to . '+1 day'));
	$query = "SELECT * FROM history_spin WHERE date_dp BETWEEN '$from' AND '$to2' ORDER BY id DESC" or die("Error:" . mysqli_error());
	}

?>
<h5><?php echo $from; ?>  &nbsp; ถึง &nbsp; <?php echo $to; ?></h5>
<?php

	$result = mysqli_query($con, $query);
    echo '<table class="table table-dark">';
    echo "<thead>";
	echo "<tr align='center'>
			<th align='center'>ลำดับ</th>
			
			<th align='center'>ยูสเซอร์เนม</th>
			<th align='center'>รางวัล</th>
			<th align='center'>วันเวลา</th>
			
			
		</tr>";
		
	echo "</thead>";


	
	echo '<tbody>';
		while($row = mysqli_fetch_array($result)) {
		echo'<tr>';
			echo "<td align='center'>" .$row["id"] .  "</td> ";?>
			
				<?php
			
			echo "<td align='center'>".$agent.$row["username"] .  "</td> ";
			echo "<td align='center'>" .$row["reward"] .  "</td> ";
			echo "<td align='center'>" .$row["time"] .  "</td> ";
			
		
	
	


	
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
				<h5 class="modal-title text-dark" id="exampleModalLabel">เพิ่มรายการถอนเงิน</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal ng-pristine ng-valid" method="POST" action="history_spin_dp.php">
					<div class="form-group">
						<div class="row">
							<label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
							<div class="col-sm-4">
								<input type="text" name="username_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" required="required">
							</div>
							<label class="col-sm-2 control-label">ยอดเงินถอน</label>
							<div class="col-sm-4">
								<input type="text" name="amount_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty" type="number" required="required">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-sm-2 control-label">เลขบัญชีธนาคาร</label>
							<div class="col-sm-4">
								<input type="number" name="bankacc_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty" required="required">
							</div>
							<label class="col-sm-2 control-label">ธนาคาร</label>
							<div class="col-sm-4">
								<select required="required" class="custom-select custom-select-md" name="bank_dp">
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
								<input type="number" name="phone_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
							</div>
							<label class="col-sm-2 control-label">ชื่อ-นามสกุล</label>
							<div class="col-sm-4">
								<input type="text" name="name_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty" required="required">
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="row">
							<label class="col-sm-2 control-label">สถานะ***</label>
							<div class="col-sm-4">
								<select required="required" class="custom-select custom-select-md" name="confirm_dp">
									<option value="รอดำเนิการ">รอดำเนินการ</option>
									<option value="อนุมัติ">อนุมัติ</option>
									<option value="ปฏิเสธ">ปฏิเสธ</option>
								</select>
							</div>
							<label class="col-sm-2 control-label">หมายเหตุ***</label>
							<div class="col-sm-4">
								<input type="text" name="note_dp" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 control-label">ธนาคารที่ใช้ถอน***</label>
						<div class="col-sm-4">
							<select required="required" class="custom-select custom-select-md" name="bankout_dp">
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