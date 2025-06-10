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
                          
					    	<button class="btn btn-success float-right" data-toggle="modal" data-target="#add_modal">เพิ่มกิจกรรม</button  >
						</h5>
						<hr>
					<div class="row">
							


						<?php
									$query = "SELECT * FROM activity ORDER BY id desc " or die("Error:" . mysqli_error());
									$result = mysqli_query($con, $query);

									
									while($row = mysqli_fetch_array($result)) {
										$name = $row["name_at"];
										$amount = $row["amount_at"];


									$query2 = "SELECT * FROM deposit WHERE confirm_dp = 'อนุมัติ' AND promotion_dp = '$name' ";
                                    $result2 = mysqli_query($con, $query2);
                                    $num_rows = mysqli_num_rows($result2);
                                   
                                    $totalfree = $amount - $num_rows;
								
									

										// echo $row["name_promotion"];
										// echo "<img src='../slip/".$row['fileupload_promotion']."' width='100%'>";

									
						echo'<div class="col-md-3">
							<div class="card">
								<img src="../slip/'.$row["fileupload_at"].'" width="100%" class="card-img-top">
								<div class="card-body">
									<h5 class="card-title" style="color: #ffffff;">';
									echo $row["name_at"].' จำนวน '.'<font color="#fff200">'.$row["credit_at"].'</font>'.' เครดิต';
									echo '</h5>';

									echo $row["detail_at"];
									echo '<br><br>';
									echo '<h5 class="card-title" style="color: #ffffff;">สถานะกิจกรรม : ';
									if ($row["status_at"]=="เปิด") {
										echo '<button class="btn btn-success"><font color="#ffffff">เปิด</font></button>';
									}
									elseif ($row["status_at"]=="ปิด") {
										echo"<button class='btn btn-danger'><font color='#ffffff'>ปิด</font></button>";
									}
									echo '<br>จำนวนที่แจก : '.$row["amount_at"].' ยูสเซอร์';
									echo '<br>คงเหลือที่รับได้ : '.$totalfree.' ยูสเซอร์';
									echo '</h5>';
									echo '<br><br>';
									//แก้ไขข้อมูล
									echo "<td align='center'><a href='atupdateform.php?id=$row[0]'><button class='btn btn-primary '><font color='white'>แก้ไข</font></button></a></td> ";
									echo "<td align='center'><a href='delete_at.php?id=$row[0]' onclick=\"return confirm('ต้องการลบข้อมูลนี้ !!!')\"><button class='btn btn-light '><font color='red'>ลบ</font></a></td> ";

									
								echo'</div>
							</div>
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
							<h5 class="modal-title text-dark" id="exampleModalLabel">เพิ่มกิจกรรม</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<form method="post" action="activity_chk.php" data-action="load" enctype="multipart/form-data">
							
							<div class="modal-body">
								
								<div class="mb-2">
									<span class="text-dark">รูปกิจกรรม</span>
									<input class="form-control" type="file" name="fileupload_at" enctype="multipart/form-data" placeholder="ขนาดรูปที่เหมาะสม ; 1600 x 900">
								</div><br>
								<div class="mb-2">
									<span class="text-dark">ชื่อกิจกรรม</span>
									<input type="text" class="form-control" name="name_at" value="" >
								</div>
								<div class="mb-2">
									<span class="text-dark">รายละเอียดกิจกรรม</span>
									<textarea name= "detail_at" class="form-control" id="editor" cols= "100" rows= "10"></textarea>
								</div>
								<div class="mb-2">
									<span class="text-dark">เครดิตที่แจก</span>
									<input type="text" class="form-control" name="credit_at" value="" >
								</div>
								<div class="mb-2">
									<span class="text-dark">จำนวนที่แจก</span>
									<input type="text" class="form-control" name="amount_at" value="" >
								</div>
								<div class="mb-2">
									<span class="text-dark">สถานะ</span>
									<select required="required" class="custom-select custom-select-md" name="status_at">
				                        
				                        <option value="เปิด">เปิด</option>
				                        <option value="ปิด">ปิด</option>
				                      </select>
                      			</div>
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
							window.location = "?page=promotion&del=" + id;
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
							window.location = "?page=promotion&del=" + id;
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