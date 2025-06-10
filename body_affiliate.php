<section class="pcoded-main-container">
	<div class="pcoded-content">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
					    <h5 class="text-dark">ค้นหารายการพันธมิตร
					    	<button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">เพิ่มพันธมิตร</button>
						</h5>
						<hr>
<div class="container">	
		<div class="row">

			<div class="col-md-12">

<form action="" method="GET" class="form-horizontal">
	<div class="form-group">
	
			<div class="col-sm-3">
				<input type="text" name="phone" required class="form-control" placeholder="กรอกเบอร์โทรศัพท์พันธมิตร">
			</div>
		<br>
			<div class="col-sm-12">
				<button type="submit" class="btn btn-success" name="act" value="01"  style="margin-bottom:-100px;">ค้นหา</button>
				<!-- <button type="submit" class="btn btn-success" name="act" value="01"  style="margin-bottom:-100px;">ม.ค.</button>
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
				<button type="submit" class="btn btn-dark" name="act" value="12"  style="margin-bottom:-100px;">ธ.ค.</button> -->

			
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
	$act = (isset($_GET['act']) ? $_GET['act'] : '');
	$phone = $_GET['phone'];
	

	$vowels = array($agent);
	$str = $phone;
	$test = str_replace($vowels, "", $str);

	if ($act=='01') {
		include('../connectdb.php');
	$query = "SELECT * FROM affiliate WHERE phone = '$phone' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'01'.'-'.null;

	
	}elseif ($act=='02'){
	$query = "SELECT * FROM member WHERE aff = '$phone' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'02'.'-'.null;
	}elseif ($act=='03'){
	$query = "SELECT * FROM member WHERE aff = '$phone' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'03'.'-'.null;
	}elseif ($act=='04'){
	$query = "SELECT * FROM member WHERE aff = '$phone' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'04'.'-'.null;
	}elseif ($act=='05'){
	$query = "SELECT * FROM member WHERE aff = '$phone' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'05'.'-'.null;
	}elseif ($act=='06'){
	$query = "SELECT * FROM member WHERE aff = '$phone' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'06'.'-'.null;
	}elseif ($act=='07'){
	$query = "SELECT * FROM member WHERE aff = '$phone' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'07'.'-'.null;
	}elseif ($act=='08'){
	$query = "SELECT * FROM member WHERE aff = '$phone' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'08'.'-'.null;
	}elseif ($act=='09'){
	$query = "SELECT * FROM member WHERE aff = '$phone' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'09'.'-'.null;
	}elseif ($act=='10'){
	$query = "SELECT * FROM member WHERE aff = '$phone' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'10'.'-'.null;
	}elseif ($act=='11'){
	$query = "SELECT * FROM member WHERE aff = '$phone' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'11'.'-'.null;
	}elseif ($act=='12'){
	$query = "SELECT * FROM member WHERE aff = '$phone' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$datedp = date('Y').'-'.'12'.'-'.null;
	}else{
		$query = "SELECT * FROM affiliate ORDER BY id DESC" or die("Error:" . mysqli_error());
	}

	$query88 = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp = 'อนุมัติ' AND aff_dp = '$phone' AND aff_dp != '' AND promotion_dp NOT LIKE '%เครดิตฟรี%' AND date_dp LIKE '%$datedp%'";
                    $result88 = mysqli_query($con, $query88);
                 $row88 = mysqli_fetch_array($result88);
                   //echo $row88['SUM(amount_dp)'] * 1 / 1;
              
 //   echo'<h5 class="text-dark">รายได้พันธมิตร</h5>';                 
	// echo '<table class="table table-dark">';
 //    echo "<thead>";
	// echo "<tr align='center'>
			
	// 		<th align='center' width='25%'>ยอดได้-เสียของสมาชิกทั้งหมด</th>
	// 		<th align='center' width='25%'>รายได้เดือนนี้</th>
			
	// 	</tr>";
		
	// echo "</thead>";


	
	// echo '<tbody>';
	// 		echo "<td align='center'>".$row88['SUM(amount_dp)'] * 1 / 1 .  "</td> ";
	// 		echo "<td align='center'>".($row88['SUM(amount_dp)'] * 1 / 1)*$affcashback/100 .  "</td> ";
	// echo'</tr>';

	// echo '</tbody>';
	// echo "</table>";	
	// 	echo'<h5 class="text-dark">รายชื่อพันธมิตร</h5>';

	$result = mysqli_query($con, $query);
    echo '<table class="table table-dark">';
    echo "<thead>";
	echo "<tr align='center'>
			
			<th align='center'>ยูสเซอร์เนม</th>
			<th align='center'>รหัสพันธมิตร</th>
			<th align='center'>ชื่อ-นามสกุล</th>
			<th align='center'>เบอร์โทรศัพท์</th>
			
			
			<th align='center'>เปอร์เซ็นต์ที่ได้รับ</th>
			<th align='center'>แก้ไข</th>
			<th align='center'>ดูรายละเอียด</th>
		</tr>";
		
	echo "</thead>";


	
	echo '<tbody>';
		while($row = mysqli_fetch_array($result)) {
		$code2 = $row["code"];

			
			echo "<td align='center'>" .$row["username"] .  "</td> ";
			echo "<td align='center'>" .$row["code"] .  "</td> ";
			echo "<td align='center'>" .$row["name"] .  "</td> ";
			echo "<td align='center'>" .$row["phone"] .  "</td> ";


			// $query8 = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp = 'อนุมัติ' AND phone_dp = '$code2' AND promotion_dp NOT LIKE '%เครดิตฟรี%' AND date_dp LIKE '%$datedp%'";
   //                  $result8 = mysqli_query($con, $query8);
   //                 	while($row77 = mysqli_fetch_array($result8)){
   //                  $sumdp = $row77['SUM(amount_dp)'] * 1 / 1;
                    
   //                  }

			// echo "<td align='center'>" .$sumdp .  "</td> ";


			// $query9 = "SELECT SUM(amount_wd) FROM withdraw WHERE confirm_wd = 'อนุมัติ' AND phone_wd = '$code2' AND date_wd LIKE '%$datedp%'";
   //                  $result9 = mysqli_query($con, $query9);
   //                  while($row9 = mysqli_fetch_array($result9)){
   //                  $sumwd = $row9['SUM(amount_wd)'] * 1 / 1;
                    
   //                  }


			// echo "<td align='center'>" .$sumwd .  "</td> ";
			// echo "<td align='center'>" .($sumdp-$sumwd).  "</td> ";
			echo "<td align='center'>" .$row["percent"] .  '%' . "</td> ";
			//echo "<td align='center'>" .($sumdp-$sumwd) * ($row["percent"] / 100).  "</td> ";
				echo "<td align='center'><a href='affiliate_update.php?id=$row[0]'><button class='btn btn-primary '><font color='white'>แก้ไข</font></button></a></td> ";
			echo "<td align='center'><a href='report_affiliate.php?code=$code2'><button class='btn btn-success '><font color='white'>ดู</font></button></a></td> ";
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
				<form class="form-horizontal ng-pristine ng-valid" method="POST" action="affiliate_register.php">
					<div class="form-group">
						<div class="row">
							<label class="col-sm-2 control-label">ยูสเซอร์เนม</label>
							<div class="col-sm-4">
								<input type="text" name="username" class="form-control ng-pristine ng-untouched ng-valid ng-empty" onkeypress="return bannedKey(event)" required="required">
							</div>
							<label class="col-sm-2 control-label">รหัสผ่าน</label>
							<div class="col-sm-4">
								<input type="text" name="password" class="form-control ng-pristine ng-untouched ng-valid ng-empty" type="number" required="required">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-sm-2 control-label">เลขบัญชีธนาคาร</label>
							<div class="col-sm-4">
								<input type="number" name="bankacc" class="form-control ng-pristine ng-untouched ng-valid ng-empty" required="required">
							</div>
							<label class="col-sm-2 control-label">ธนาคาร</label>
							<div class="col-sm-4">
								<select required="required" class="custom-select custom-select-md" name="bank">
									<option selected="selected" value="">-- เลือก --</option>
									<option value="ทรูวอเล็ต">ทรูวอเล็ต</option>
									<option value="ธ.กสิกรไทย">ธ.กสิกรไทย</option>
                                    <option value="ธ.กรุงไทย">ธ.กรุงไทย</option>
                                    <option value="ธ.กรุงศรีอยุธยา">ธ.กรุงศรีอยุธยา</option>
                                    <option value="ธ.กรุงเทพ">ธ.กรุงเทพ</option>
                                    <option value="ธ.ไทยพาณิชย์">ธ.ไทยพาณิชย์</option>
                                    <option value="ธ.ทหารไทยธนชาติ">ธ.ทหารไทยธนชาติ</option>
                                    <option value="ธ.ออมสิน">ธ.ออมสิน</option>
                                    <option value="ธ.ก.ส.">ธ.ก.ส.</option>
                                    <option value="ธ.ซีไอเอ็มบี">ธ.ซีไอเอ็มบี</option>
                                    <option value="ธ.เกียรตินาคินภัทร">ธ.เกียรตินาคินภัทร</option>
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
								<input type="number" name="phone" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
							</div>
							<label class="col-sm-2 control-label">ชื่อ-นามสกุล</label>
							<div class="col-sm-4">
								<input type="text" name="name" class="form-control ng-pristine ng-untouched ng-valid ng-empty" required="required">
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="row">
							<label class="col-sm-2 control-label">สถานะ***</label>
							<div class="col-sm-4">
								<select required="required" class="custom-select custom-select-md" name="status">
									<option value="รอดำเนิการ">รอดำเนินการ</option>
									<option value="อนุมัติ">อนุมัติ</option>
									<option value="ระงับ">ระงับ</option>
								</select>
							</div>
							<label class="col-sm-2 control-label">เปอร์เซ็นต์</label>
							<div class="col-sm-4">
								<input type="number" name="percent" class="form-control ng-pristine ng-untouched ng-valid ng-empty">
							</div>
						</div>
					</div>
					<?php 
						function random($length = 5) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
$code2=random();
					?>
					<div class="row">
						<label class="col-sm-2 control-label">รหัสพันธมิตร</label>
						<div class="col-sm-4">
							<input type="text" name="code" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="<?php echo $code2; ?>" required="required" readonly>
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