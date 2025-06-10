<section class="pcoded-main-container">
	<div class="pcoded-content">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
					    <h5 class="text-dark">โปรโมชั่นป๊อปอัพหน้าเว็ป<button class="btn btn-success float-right" data-toggle="modal" data-target="#add_modal">เพิ่มโปรโมชั่น</button>
						</h5>
						<hr>
					<div class="row">
						<?php
									$query = "SELECT * FROM popup ORDER BY id_popup desc" or die("Error:" . mysqli_error());
									$result = mysqli_query($con, $query);
									while($row = mysqli_fetch_array($result)) {

										// echo $row["name_popup"];
										// echo "<img src='../slip/".$row['fileupload_popup']."' width='100%'>";

									
						echo'<div class="col-md-3">
							<div class="card">
								<img src="../slip/'.$row["fileupload_popup"].'" width="100%" class="card-img-top">
								<div class="card-body">
									<h5 class="card-title">';
									echo $row["name_popup"];
									echo '</h5>';
									echo "<td align='center'><a href='delete_popup.php?id_popup=$row[0]' onclick=\"return confirm('ต้องการลบข้อมูลนี้ !!!')\"><button class='btn btn-light '><font color='red'>ลบ</font></a></td> ";
									
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
							<h5 class="modal-title text-dark" id="exampleModalLabel">เพิ่มโปรโมชั่นป๊อปอัพ</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<form method="post" action="promotionpopup_chk.php" data-action="load" enctype="multipart/form-data">
							<input type="hidden" name="key_valid" value="ok">
							<input type="hidden" name="status" value="1">
							<div class="modal-body">
								
								<div class="mb-2">
									<span class="text-dark">รูปโปรโมชั่น</span>
									<input class="form-control" type="file" name="fileupload_popup" required="required" enctype="multipart/form-data" placeholder="ขนาดรูปที่เหมาะสม ; 1040 x 1040">
								</div><br>
								<div class="mb-2">
									<span class="text-dark">ชื่อโปรโมชั่น</span>
									<input class="form-control" name="name_popup" value="" >
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