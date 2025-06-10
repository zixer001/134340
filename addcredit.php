<?php include 'inc/header.php'; ?>
<?php
//1. เชื่อมต่อ database:
include('../connectdb.php');
//ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
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

$sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1 ";
$res = $con->query($sql);
$row = $res->fetch_assoc();
extract($row);

include('../class/betflix.php');
$api = new Betflix();
$checkbb = $api->Balance($agent . $username_mb);
$Balance = (!$checkbb->error_code) ? $checkbb->data->balance : 'ไม่พบยอดเงิน';
?>
<section class="pcoded-main-container">
	<div class="pcoded-content">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<h5 class="text-dark">เพิ่มเครดิต เครดิตปัจจุบัน <?php echo $Balance; ?> <a href="member.php" class="btn btn-success float-right">ย้อนกลับ</a>
						</h5>
						<hr>
						<div class="container">
							<div class="row">

								<form class="form-horizontal ng-pristine ng-valid" method="POST" action="api/tran_betflix.php?deposit" enctype="multipart/form-data">
									<input type="hidden" name="admin" value="<?php echo $name_ad; ?>">
									<input type="hidden" name="username" value="<?php echo $agent . $username_mb; ?>">
									<div class="form-group">
										<div class="row">
											<label class="col-sm-4 control-label requiredField">
												ใส่จำนวนเครดิตที่ต้องการเติม
												<span class="asteriskField">
													*
												</span>
											</label>
											<div class="col-sm-4">
												<input type="number" class="form-control" name="amount" required="required">
											</div>

										</div>
									</div>

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