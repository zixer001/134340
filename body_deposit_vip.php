<section class="pcoded-main-container">
	<div class="pcoded-content">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
					    <h5 class="text-dark">เช็คข้อมูลการรับโบนัส VIP
					    	<!--<button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">เพิ่มรายการถอนเงิน</button>-->
					    
						</h5>
						<hr>


						<h5 class="text-dark" ><font color="#fff200">ยังไม่ได้ทำรายการ</font>
					    	<!--<button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">เพิ่มรายการถอนเงิน</button>-->
						</h5>
						<div class="table-responsive">
<?php
	$query = "SELECT * FROM withdrawvip WHERE confirm_vip = 'รอดำเนินการ' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$result = mysqli_query($con, $query);
    echo '<table class="table table-dark">';
    echo "<thead>";
	echo "<tr align='center'>
			
			<th align='center'>สถานะ</th>
			<th align='center'>ระดับ VIP</th>
			<th align='center'>ยอดเงิน VIP</th>
			<th align='center'>เบอร์โทรศัพท์</th>
			<th align='center'>ชื่อ-นามสกุล</th>
			<th align='center'>เวลา</th>
			
			
		</tr>";
		
	echo "</thead>";


	
	echo '<tbody>';
		while($row = mysqli_fetch_array($result)) {
		echo'<tr>';
			?>
			<td align='center'>
				<?php 
			if ($row["confirm_vip"]=="รอดำเนินการ") {
				echo"<a href='depositvipupdateform.php?id=$row[0]'><button class='btn btn-primary'>กำลังดำเนินการ</button>";
			}
				elseif ($row["confirm_vip"]=="อนุมัติ") {
					echo"<button class='btn btn-success' disabled>อนุมัติ</button>";
				}
				elseif ($row["confirm_vip"]=="ปฏิเสธ") {
					echo"<button class='btn btn-danger' disabled>ปฏิเสธ</button>";
				}
			echo "</td>";
		
			echo "<td align='center'>" .$row["note_vip"] .  "</td> ";
			echo "<td align='center'>" .$row["amount_vip"] .  "</td> ";
			
			echo "<td align='center'>" .$row["phone_vip"] .  "</td> ";
			echo "<td align='center'>" .$row["name_vip"] .  "</td> ";
			echo "<td align='center'>" .$row["date_vip"] .  "</td> ";
			
			echo'</tr>';
		}
	echo '</tbody>';
	echo "</table>";			
	?>
</td>

					</div>

					
				</div>
			</div>
		</div>
	</div>
</div>
	<div class="pcoded-content">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
					    <h5 class="text-dark">เช็คข้อมูลการรับโบนัส VIP
					    	<!--<button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">เพิ่มรายการถอนเงิน</button>-->
					    
						</h5>
						<hr>


						<h5 class="text-dark" ><font color="#fff200">ทำรายการเรียบร้อย</font>
					    	<!--<button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">เพิ่มรายการถอนเงิน</button>-->
						</h5>
						<div class="table-responsive">
<?php
	$query = "SELECT * FROM withdrawvip WHERE confirm_vip != 'รอดำเนินการ' ORDER BY id DESC" or die("Error:" . mysqli_error());
	$result = mysqli_query($con, $query);
    echo '<table class="table table-dark">';
    echo "<thead>";
	echo "<tr align='center'>
			
			<th align='center'>สถานะ</th>
			<th align='center'>ระดับ VIP</th>
			<th align='center'>ยอดเงิน VIP</th>
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
			<td align='center'>
				<?php 
			if ($row["confirm_vip"]=="รอดำเนินการ") {
				echo"<a href='depositupdateform.php?id=$row[0]'><button class='btn btn-primary'>กำลังดำเนินการ</button>";
			}
				elseif ($row["confirm_vip"]=="อนุมัติ") {
					echo"<button class='btn btn-success' disabled>อนุมัติ</button>";
				}
				elseif ($row["confirm_vip"]=="ปฏิเสธ") {
					echo"<button class='btn btn-danger' disabled>ปฏิเสธ</button>";
				}
			
			echo "</td>";
		
			echo "<td align='center'>" .$row["note_vip"] .  "</td> ";
			echo "<td align='center'>" .$row["amount_vip"] .  "</td> ";
			
			echo "<td align='center'>" .$row["phone_vip"] .  "</td> ";
			echo "<td align='center'>" .$row["name_vip"] .  "</td> ";
			echo "<td align='center'>" .$row["date_vip"] .  "</td> ";
			echo "<td align='center'><a href='depositvipupdateform.php?id=$row[0]'><button class='btn btn-primary '><font color='white'>แก้ไข</font></button></a></td> ";
			echo'</tr>';
		}
	echo '</tbody>';
	echo "</table>";			
	?>
</td>

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