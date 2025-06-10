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
                            <a class="btn btn-warning" href="review.php" role="button">รีวิวถอน</a>
						<hr>
						<h5 class="text-dark">หัวรีวิวถอน

						<button class="btn btn-success" data-toggle="modal" data-target="#addhead_modal">เพิ่มหัวรีวิว</button></h5>
						<div class="row">
							
						
						<?php
									$query = "SELECT * FROM review WHERE fileupload_headreview != '' ORDER BY id desc limit 1" or die("Error:" . mysqli_error());
									$result = mysqli_query($con, $query);
									while($row = mysqli_fetch_array($result)) {

										// echo $row["name_review"];
										// echo "<img src='../slip/".$row['fileupload_review']."' width='100%'>";

									
						echo'<div class="col-md-3">
							<div class="card">
								<img src="../slip/'.$row["fileupload_headreview"].'" width="100%" class="card-img-top">
								<div class="card-body">
									<h5 class="card-title">';
									
									echo '<br><br>';
									//แก้ไขข้อมูล
									
									echo "<td align='center'><a href='deletereview_id.php?id=$row[0]' onclick=\"return confirm('ต้องการลบข้อมูลนี้ !!!')\"><button class='btn btn-light '><font color='red'>ลบ</font></a></td> ";

									
								echo'</div></div>
							
						</div></div>';} ?>
						<hr><br>
						<h5 class="text-dark">รีวิวถอน
							<button class="btn btn-success " data-toggle="modal" data-target="#add_modal">เพิ่มรีวิว</button>
						</h5>
					<div class="row">

						<?php
									$query = "SELECT * FROM review WHERE fileupload_review != '' ORDER BY id desc limit 8" or die("Error:" . mysqli_error());
									$result = mysqli_query($con, $query);
									while($row = mysqli_fetch_array($result)) {

										// echo $row["name_review"];
										// echo "<img src='../slip/".$row['fileupload_review']."' width='100%'>";

									
						echo'<div class="col-md-3">
							<div class="card">
								<img src="../slip/'.$row["fileupload_review"].'" width="100%" class="card-img-top">
								<div class="card-body">
									<h5 class="card-title">';
									
									echo '<br><br>';
									//แก้ไขข้อมูล
									
									echo "<td align='center'><a href='deletereview_id.php?id=$row[0]' onclick=\"return confirm('ต้องการลบข้อมูลนี้ !!!')\"><button class='btn btn-light '><font color='red'>ลบ</font></a></td> ";

									
								echo'</div></div>
							
						</div>';} ?>
					</div>
				</div>
			</div>
		</div>
			<style>
				.get {
					display: none;
				}

				.not {
					display: block;
				}
			</style>
			<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel">เพิ่มรีวิว</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<form method="post" action="review_chk.php" data-action="load" enctype="multipart/form-data">
							<input type="hidden" name="key_valid" value="ok">
							<input type="hidden" name="status" value="1">
							<div class="modal-body">
								
								
								
								<div class="mb-2">
									<span class="text-dark">รูปรีวิว</span>
									<input class="form-control" type="file" name="fileupload_review" enctype="multipart/form-data" placeholder="ขนาดรูปที่เหมาะสม ; 1040x1040">
								</div><br>
							</div>


							<div class="modal-footer">
								
								<button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;บันทึก</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal fade" id="addhead_modal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel">เพิ่มรีวิว</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<form method="post" action="reviewhead_chk.php" data-action="load" enctype="multipart/form-data">
							<input type="hidden" name="key_valid" value="ok">
							<input type="hidden" name="status" value="1">
							<div class="modal-body">
								
								<div class="mb-2">
									<span class="text-dark">รูปรีวิวรูปแรก</span>
									<input class="form-control" type="file" name="fileupload_headreview" enctype="multipart/form-data" placeholder="ขนาดรูปที่เหมาะสม ; 1040x1040">
								</div><br>
								
								
							</div>


							<div class="modal-footer">
								
								<button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;บันทึก</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			
			<script>
				function remove(id) {
					/*Swal.fire({
						title: "คุณต้องการจะลบมั้ย?",
						text: "หากยืนยันแล้วจะไม่สามารถยกเลิกได้!",
						icon: "warning",
						buttons: true,
						buttons: ["ยกเลิก", "ลบ"],
						dangerMode: true,
					}).then((willDelete) => {
						if (willDelete) {
							window.location = "?page=review&del=" + id;
						}
					});*/
					
					Swal.fire({
						title: "คุณต้องการจะลบมั้ย?",
						text: "หากยืนยันแล้วจะไม่สามารถยกเลิกได้!",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes!'
					}).then((result) => {
						if (result.value) {
							window.location = "?page=review&del=" + id;
						}
					})
				}
				
				
				$(document).ready(function () {
					$('.table').DataTable({
						"language": {
							"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Thai.json"
						}
					});
				});
			</script>
		</div>
	</div>
</section>