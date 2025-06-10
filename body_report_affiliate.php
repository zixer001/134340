
<section class="pcoded-main-container">
	<div class="pcoded-content">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
					    <h5 class="text-dark">รายการสมาชิก
					    	<!--<button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">เพิ่มรายการถอนเงิน</button>-->
						</h5>
						<hr>
				<?php 
				include('../connectdb.php'); 
				$code = $_GET['code'];
         $sql11 = "SELECT * FROM affiliate WHERE code='$code'";
          $result11 = mysqli_query($con, $sql11) or die ("Error in query: $sql " . mysqli_error());
          $row11 = mysqli_fetch_array($result11);
          extract($row11);
          $percent = $row11['percent'];
//echo $percent;
          $sql = "SELECT * FROM deposit WHERE aff_dp='$code'";
          $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
          $row = mysqli_fetch_array($result);
          extract($row);
          $username_mb =  $username_dp;
         	
          if ($code!='') {
      			$sql75 = "UPDATE code_update SET code = '$code', percent = '$percent' WHERE id = 1 ";
						$result9 = mysqli_query($con, $sql75) or die ("Error in query: $sql " . mysqli_error());
					}
				?>
<div class="container">	
		<div class="row">

			<div class="col-md-12">

<form action="" method="GET" class="form-horizontal">
	<div class="form-group">
		
			<div class="col-sm-12">
				<button type="submit" class="btn btn-success" name="act" value="01"  style="margin-bottom:-100px;">ม.ค.</button>
				<button type="submit" class="btn btn-danger" name="act" value="02"  style="margin-bottom:-100px;">ก.พ.</button>
				<button type="submit" class="btn btn-primary" name="act" value="03"  style="margin-bottom:-100px;">มี.ค.</button>
				<button type="submit" class="btn btn-info" name="act" value="04"  style="margin-bottom:-100px;">เม.ย.</button>
				<button type="submit" class="btn btn-warning" name="act" value="05"  style="margin-bottom:-100px;">พ.ค.</button>
				<button type="submit" class="btn btn-dark" name="act" value="06"  style="margin-bottom:-100px;">มิ.ย.</button>
				<button type="submit" class="btn btn-success" name="act" value="07"  style="margin-bottom:-100px;">ก.ค.</button>
				<button type="submit" class="btn btn-danger" name="act" value="08"  style="margin-bottom:-100px;">ส.ค.</button>
				<button type="submit" class="btn btn-primary" name="act" value="09"  style="margin-bottom:-100px;">ก.ย.</button>
				<button type="submit" class="btn btn-info" name="act" value="10"  style="margin-bottom:-100px;">ต.ค.</button>
				<button type="submit" class="btn btn-warning" name="act" value="11"  style="margin-bottom:-100px;">พ.ย.</button>
				<button type="submit" class="btn btn-dark" name="act" value="12"  style="margin-bottom:-100px;">ธ.ค.</button>

			
			</div>
	</div></form><br><br><br><br>
<!-- 	<form action="" method="GET" class="form-horizontal">
		<div class="col-md-12">
			<button class="btn btn-danger" name="act" value="100" style="margin-top:30px;">ค้นหา 100 รายการล่าสุด</button>
			<button class="btn btn-primary" name="act" value="500" style="margin-top:30px;">ค้นหา 500 รายการล่าสุด</button>
			<button class="btn btn-danger" name="act" value="1000" style="margin-top:30px;">ค้นหา 1,000 รายการล่าสุด</button>
			<button class="btn btn-primary" name="act" value="all" style="margin-top:30px;">ค้นหาทุกรายการทั้งหมด</button>
		</div>
	</form><br> -->


<div class="table-responsive">
<?php
include('../connectdb.php');
$act = (isset($_GET['act']) ? $_GET['act'] : '');
	$phone = $_GET['phone_mb'];

	$vowels = array($agent);
	$str = $phone;
	$test = str_replace($vowels, "", $str);
 
$sql44 = "SELECT * FROM code_update WHERE id=1";
          $result44 = mysqli_query($con, $sql44) or die ("Error in query: $sql " . mysqli_error());
          $row44 = mysqli_fetch_array($result44);
          extract($row44);
			$code = $row44['code'];
		$percent = $row44['percent'];


	if ($act=='01') {		 
	$query = "SELECT * FROM member WHERE aff = '$code' AND aff!='' ORDER BY id_mb DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'01'.'-'.null;
	}elseif ($act=='02'){
	$query = "SELECT * FROM member WHERE aff = '$code' AND aff!='' ORDER BY id_mb DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'02'.'-'.null;
	}elseif ($act=='03'){
	$query = "SELECT * FROM member WHERE aff = '$code' AND aff!='' ORDER BY id_mb DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'03'.'-'.null;
	}elseif ($act=='04'){
	$query = "SELECT * FROM member WHERE aff = '$code' AND aff!='' ORDER BY id_mb DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'04'.'-'.null;
	}elseif ($act=='05'){
	$query = "SELECT * FROM member WHERE aff = '$code' AND aff!='' ORDER BY id_mb DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'05'.'-'.null;
	}elseif ($act=='06'){
	$query = "SELECT * FROM member WHERE aff = '$code'  AND aff!='' ORDER BY id_mb DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'06'.'-'.null;
	}elseif ($act=='07'){
	$query = "SELECT * FROM member WHERE aff = '$code' AND aff!='' ORDER BY id_mb DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'07'.'-'.null;
	}elseif ($act=='08'){
	$query = "SELECT * FROM member WHERE aff = '$code' AND aff!='' ORDER BY id_mb DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'08'.'-'.null;
	}elseif ($act=='09'){
	$query = "SELECT * FROM member WHERE aff = '$code' AND aff!='' ORDER BY id_mb DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'09'.'-'.null;
	}elseif ($act=='10'){
	$query = "SELECT * FROM member WHERE aff = '$code' AND aff!='' ORDER BY id_mb DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'10'.'-'.null;
	}elseif ($act=='11'){
	$query = "SELECT * FROM member WHERE aff = '$code' AND aff!='' ORDER BY id_mb DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'11'.'-'.null;
	}elseif ($act=='12'){
	$query = "SELECT * FROM member WHERE aff = '$code' AND aff!='' ORDER BY id_mb DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'12'.'-'.null;
	}else{
	$query = "SELECT * FROM member WHERE aff = '$code' AND aff!='' ORDER BY id_mb DESC" or die("Error:" . mysqli_error());
	}
	
	$result = mysqli_query($con, $query);


	$query88 = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp = 'อนุมัติ' AND aff_dp = '$code' AND aff_dp != '' AND promotion_dp NOT LIKE '%เครดิตฟรี%' AND date_dp LIKE '%$datedp%'";
                    $result88 = mysqli_query($con, $query88);
                 $row88 = mysqli_fetch_array($result88);
                   $sumdp88 = $row88['SUM(amount_dp)'] * 1 / 1;
//echo $code;
                 $query98 = "SELECT SUM(amount_wd) FROM withdraw WHERE confirm_wd = 'อนุมัติ' AND aff_wd = '$code' AND date_wd LIKE '%$datedp%'";
                    $result98 = mysqli_query($con, $query98);
                   $row98 = mysqli_fetch_array($result98);
                    $sumwd98 = $row98['SUM(amount_wd)'] * 1 / 1;
                    
                   // echo $sumwd98;
              
   // echo  $datedp;    
   // echo $code;           
	echo '<table class="table table-dark">';
    echo "<thead>";
	echo "<tr align='center'>
			
			<th align='center' width='25%'>ยอดได้เสียของสมาชิกทั้งหมด</th>
			<th align='center' width='25%'>รายได้เดือนนี้</th>
			
		</tr>";
		
	echo "</thead>";


	
	echo '<tbody>';
			echo "<td align='center'>".($sumdp88-$sumwd98).  "</td> ";
			echo "<td align='center'>".($sumdp88-$sumwd98)*$percent/100 .  "</td> ";
	echo'</tr>';
		
	echo '</tbody>';
	echo "</table>";	

echo'<h5 class="text-dark">สมาชิกภายใต้</h5>';
	$result = mysqli_query($con, $query);
    echo '<table class="table table-dark">';
    echo "<thead>";
	echo "<tr align='center'>
			
			<th align='center'>ยูสเซอร์เนม</th>
			<th align='center'>ชื่อ-นามสกุล</th>
			<th align='center'>เบอร์โทรศัพท์</th>
			<th align='center'>ยอดเงินฝากทั้งหมด</th>
			<th align='center'>ยอดเงินถอนทั้งหมด</th>
			<th align='center'>กำไร-ขาดทุน</th>
			
		</tr>";
		
	echo "</thead>";


	
	echo '<tbody>';
		while($row = mysqli_fetch_array($result)) {
		$code_dp = $row["phone_mb"];
		$username = $row["username_mb"];
			
			echo "<td align='center'>".$agent.$row["username_mb"] .  "</td> ";
			echo "<td align='center'>" .$row["name_mb"] .  "</td> ";
			echo "<td align='center'>" .$row["phone_mb"] .  "</td> ";


			$query8 = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp = 'อนุมัติ' AND aff_dp = '$code' AND username_dp = '$username'  AND promotion_dp NOT LIKE '%เครดิตฟรี%' AND date_dp LIKE '%$datedp%'";
                    $result8 = mysqli_query($con, $query8);
                   	while($row77 = mysqli_fetch_array($result8)){
                    $sumdp = $row77['SUM(amount_dp)'] * 1 / 1;
                    
                    }

			echo "<td align='center'>" .$sumdp .  "</td> ";


			$query9 = "SELECT SUM(amount_wd) FROM withdraw WHERE confirm_wd = 'อนุมัติ' AND username_wd = '$username' AND date_wd LIKE '%$datedp%'";
                    $result9 = mysqli_query($con, $query9);
                    while($row9 = mysqli_fetch_array($result9)){
                    $sumwd = $row9['SUM(amount_wd)'] * 1 / 1;
                    
                    }


			echo "<td align='center'>" .$sumwd .  "</td> ";
			echo "<td align='center'>" .($sumdp-$sumwd) .  "</td> ";
			
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
				<form class="form-horizontal ng-pristine ng-valid" method="POST" action="deposit_dp.php">
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