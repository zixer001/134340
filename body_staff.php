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
                         
					    	<button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">เพิ่มพนักงาน</button>
						</h5>
						<hr>
<div class="table-responsive">
		<?php
			$query = "SELECT * FROM admin ORDER BY id_ad DESC" or die("Error:" . mysqli_error());
			$result = mysqli_query($con, $query);
			echo '<table id="example1" class="table">';
				echo "<thead >";
							echo '<tr align="center">
									<th class="text-center align-middle" style="width: 5%;">ลำดับ</th>
									<th class="text-center align-middle" style="width: 15%;">ชื่อ-นามสกุล</th>
									<th class="text-center align-middle" style="width: 15%;">ยูสเซอร์เนม</th>
									<th class="text-center align-middle" style="width: 15%px;">เบอร์โทรศัพท์</th>
									<th class="text-center align-middle" style="width: 15%px;">ตำแหน่ง</th>
									<th class="text-center align-middle" style="width: 10%;">วันที่เริ่มทำงาน</th>
									<th class="text-center align-middle" style="width: 5%;">แก้ไข</th>
									<th class="text-center align-middle" style="width: 5%;">ลบ</th>
															</tr>';
												echo"</thead>";
												echo '<tbody>';
								while($row = mysqli_fetch_array($result)) {
								echo'<tr>';
											echo "<td align='center'>" .$row["id_ad"] .  "</td> ";
											echo "<td align='center'>" .$row["name_ad"] .  "</td> ";
											echo "<td align='center'>" .$row["username_ad"] .  "</td> ";
											echo "<td align='center'>" .$row["phone_ad"] .  "</td> ";
											echo "<td align='center'>" .$row["status_ad"] .  "</td> ";
											echo "<td align='center'>" .$row["date_ad"] .  "</td> ";
											//แก้ไขข้อมูล
											echo "<td align='center'><a href='adminupdateform.php?id_ad=$row[0]'><button class='btn btn-primary'><font color='white'>แก้ไข</font></button></a></td> ";
											
											//ลบข้อมูล
											echo "<td align='center'><a href='delete_ad.php?id_ad=$row[0]' onclick=\"return confirm('ต้องการลบข้อมูลนี้ !!!')\"><button class='btn btn-light'><font color='red'>ลบ</font></a></td> ";
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
						<h5 class="modal-title text-dark" id="exampleModalLabel">จัดการพนักงาน</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
						</button>
					</div>
					<form method="post" action="register_ad.php">
						<input type="hidden" name="am_status" value="1">
						<div class="modal-body">
							<div class="mb-2">
								<span class="text-dark">ชื่อ นามสกุล</span>
								<input class="form-control" name="name_ad">
							</div>
							<div class="mb-2">
								<span class="text-dark">ยูสเซอร์เนม</span>
								<input class="form-control" name="username_ad">
							</div>
							<div class="mb-2">
								<span class="text-dark">พาสเวิร์ด</span>
								<input class="form-control" name="password_ad">
							</div>
							<div class="mb-3">
								<span class="text-dark">เบอร์โทรศัพท์</span>
								<input class="form-control" name="phone_ad">
							</div>
							<div class="mb-3">
								<span class="text-dark mb-1">ตำเเหน่ง</span>
								<select name="status_ad" class="form-control m-b ng-pristine ng-untouched ng-valid ng-empty">
									<option value="">เลือก</option>
									<option value="Administrator">Administrator</option>
									<option value="Staff">Staff</option>
								</select>
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