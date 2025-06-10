<section class="pcoded-main-container">
    <div class="pcoded-content">
     
  		<link rel="stylesheet" type="text/css" href="datetimepicker/jquery.datetimepicker.css">
    <script type="text/javascript" src="datetimepicker/jquery.js"></script>
    <script type="text/javascript" src="datetimepicker/jquery.datetimepicker.js"></script>
  
		




		<div class="row">
			<div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>รายการฝากล่าสุด
                        </h5>
                        <hr>
            <div class="table-responsive">

<?php
    
    $query = "SELECT * FROM deposit WHERE confirm_dp ='อนุมัติ' AND bankin_dp!='ไม่ถูกต้อง' ORDER BY id desc LIMIT 5" or die("Error:" . mysqli_error());
    $result = mysqli_query($con, $query);
    echo '<table class="table table-dark">';
    echo "<thead>";
    echo "<tr align='center'>
            <!--<th align='center' hide>ลำดับ</th>-->
            
          
            <th align='center'>เบอร์โทรศัพท์</th>
            <th align='center'>ชื่อ-นามสกุล</th>
            <th align='center'>ยอดฝาก</th>
            <th align='center'>โปรโมชั่น</th>
            <th align='center'>วันเวลาที่ฝาก</th>
            
        </tr>";
        
    echo "</thead>";


    
    echo '<tbody>';
        while($row = mysqli_fetch_array($result)) {
        echo'<tr>';?>
            
                <?php
            

            echo "<td align='center'>" .$row["phone_dp"] .  "</td> ";
            echo "<td align='center'>" .$row["name_dp"] .  "</td> ";
            echo "<td align='center'>" .$row["amount_dp"] .  "</td> ";
            echo "<td align='center'>" .$row["promotion_dp"] .  "</td> ";
            echo "<td align='center'>" .$row["date_dp"] .  "</td> ";
            echo'</tr>';
        }
    echo '</tbody>';
    echo "</table>";            
    ?>


        </div></div></div></div>

        <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>รายการถอนล่าสุด
                                                </h5>
                        <hr>
            <div class="table-responsive">

<?php

    $query = "SELECT * FROM withdraw WHERE confirm_wd ='อนุมัติ' AND amount_wd!='' ORDER BY id desc LIMIT 5" or die("Error:" . mysqli_error());
    $result = mysqli_query($con, $query);
    echo '<table class="table table-dark">';
    echo "<thead>";
    echo "<tr align='center'>
            <!--<th align='center' hide>ลำดับ</th>-->
            
        
            <th align='center'>เบอร์โทรศัพท์</th>
            <th align='center'>ชื่อ-นามสกุล</th>
            <th align='center'>ยอดถอน</th>
            <th align='center'>วันเวลาที่ถอน</th>
            
        </tr>";
        
    echo "</thead>";


    
    echo '<tbody>';
        while($row = mysqli_fetch_array($result)) {
        echo'<tr>';?>
            
                <?php
            
            
            echo "<td align='center'>" .$row["phone_wd"] .  "</td> ";
            echo "<td align='center'>" .$row["name_wd"] .  "</td> ";
            echo "<td align='center'>" .$row["amount_wd"] .  "</td> ";
            echo "<td align='center'>" .$row["date_wd"] .  "</td> ";
            echo'</tr>';
        }
    echo '</tbody>';
    echo "</table>";            
    ?>


        </div></div></div></div>
			            <div class="col-md-12">
                <div class="card">
					<div class="card-body">
						<h5>รายงานสรุปกำไร - ขาดทุน
						</h5>
						<hr>
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
								<div class="col-md-2" style="margin-top:30px;">
									<button type="submit" class="btn btn-success btn-block" name="act" value="search">ค้นหา</button>
								</div>
								<div class="col-md-2" style="margin-top:30px;">
									<button type="submit" class="btn btn-danger btn-block" name="act" value="100">เมื่อวาน</button>
								</div>
								<div class="col-md-2" style="margin-top:30px;">
									<button type="submit" class="btn btn-info btn-block" name="act" value="200">วันนี้</button>
								</div>
								
								<div class="col-md-2" style="margin-top:30px;">
									<button type="submit" class="btn btn-warning btn-block" name="act" value="300">เดือนนี้</button>
								</div>
								
							</div>
						</form>
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
						<hr>
						<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
	<?php
	$act = (isset($_GET['act']) ? $_GET['act'] : '');
	$from = $_GET['From'];
	$to = $_GET['To'];
	$to2= date('Y-m-d', strtotime($to . '+1 day'));
//echo $from;




	if ($act=='search') {
		include('../connectdb.php');
	$query = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp='อนุมัติ' AND bankin_dp!='ไม่ถูกต้อง' AND date_dp BETWEEN '$from' AND '$to2' ";
    $result = mysqli_query($con, $query);
    while($row1 = mysqli_fetch_array($result)){ 
    $totaldpall = $row1['SUM(amount_dp)'] * 1 / 1; 
	}
	$querywd3 = "SELECT SUM(amount_wd) FROM withdraw WHERE confirm_wd='อนุมัติ' AND bankout_wd!='เงินคืน' AND date_wd BETWEEN '$from' AND '$to2'";
    $resultwd3 = mysqli_query($con, $querywd3);
    while($row3 = mysqli_fetch_array($resultwd3)){ 
    $totalwdall = $row3['SUM(amount_wd)'] * 1 / 1; 
    }
    $total = $totaldpall-$totalwdall;

	}elseif ($act==100){
	$yesterday_dp = date('Y-m-d',strtotime('-1 day'));
    $querydp12 = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp ='อนุมัติ' AND date_dp LIKE '%$yesterday_dp%' AND bankin_dp!='ไม่ถูกต้อง'";
    $resultdp12 = mysqli_query($con, $querydp12);
    while($row12 = mysqli_fetch_array($resultdp12)){ 
    $totaldpall = $row12['SUM(amount_dp)'] * 1 / 1; 
	}

    $yesterday_wd = date('Y-m-d',strtotime('-1 day'));
    $querywd22 = "SELECT SUM(amount_wd) FROM withdraw WHERE confirm_wd='อนุมัติ' AND date_wd LIKE '%$yesterday_wd%' AND bankout_wd !='เงินคืน'";
    $resultwd22 = mysqli_query($con, $querywd22);

    while($row22 = mysqli_fetch_array($resultwd22)){ 
    $totalwdall = $row22['SUM(amount_wd)'] * 1 / 1; 
	}
	$total = $totaldpall-$totalwdall;
	$from = date('Y-m-d',strtotime('-1 day'));
	$to = date('Y-m-d',strtotime('-1 day'));

	}elseif ($act==200){
	$today_dp = date('Y-m-d');
    $querydp12 = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp ='อนุมัติ' AND date_dp LIKE '%$today_dp%' AND bankin_dp!='ไม่ถูกต้อง'";
    $resultdp12 = mysqli_query($con, $querydp12);
    while($row12 = mysqli_fetch_array($resultdp12)){ 
    $totaldpall = $row12['SUM(amount_dp)'] * 1 / 1; 
	}

    $today_wd = date('Y-m-d');
    $querywd22 = "SELECT SUM(amount_wd) FROM withdraw WHERE confirm_wd='อนุมัติ' AND date_wd LIKE '%$today_wd%' AND bankout_wd !='เงินคืน'";
    $resultwd22 = mysqli_query($con, $querywd22);

    while($row22 = mysqli_fetch_array($resultwd22)){ 
    $totalwdall = $row22['SUM(amount_wd)'] * 1 / 1; 
	}
	$total = $totaldpall-$totalwdall;
	$from = date('Y-m-d');
	$to = date('Y-m-d');

	}elseif ($act==300){
	$from = date("Y-m-d", strtotime("first day of this month"));
	$to = date("Y-m-d", strtotime("last day of this month"));
	//echo $to;
		
	$query = "SELECT SUM(amount_dp) FROM deposit WHERE confirm_dp='อนุมัติ' AND bankin_dp!='ไม่ถูกต้อง' AND date_dp BETWEEN '$from' AND '$to'";
    $result = mysqli_query($con, $query);
    while($row1 = mysqli_fetch_array($result)){ 
    $totaldpall = $row1['SUM(amount_dp)'] * 1 / 1; 
    //echo $totaldpall;
	}
	$querywd3 = "SELECT SUM(amount_wd) FROM withdraw WHERE confirm_wd='อนุมัติ' AND bankout_wd!='เงินคืน' AND date_wd BETWEEN '$from' AND '$to'";
    $resultwd3 = mysqli_query($con, $querywd3);
    while($row3 = mysqli_fetch_array($resultwd3)){ 
    $totalwdall = $row3['SUM(amount_wd)'] * 1 / 1; 
    }
    $total = $totaldpall-$totalwdall;
    
	}
	?>
	
		
		<h5>รายงานประจำวันที่</h5><br>
		<h5><?php echo $from; ?>  &nbsp; ถึง &nbsp; <?php echo $to; ?></h5>
	
	
		<table class="table table-dark">
    <thead>
	<tr align='center'>
			<th align='center'>ยอดฝาก</th>
			<th align='center'>ยอดถอน</th>
			<th align='center'>กำไร-ขาดทุน</th>
			
			
		</tr>
		
	</thead>


	
	<tbody>
		
			
			
			<td align='center'><?php echo $totaldpall; ?></td>
			<td align='center'><?php echo $totalwdall; ?></td>
			<td align='center'><?php echo $total; ?></td>
			
		


			
	</tbody>
	</table>			
	
					</div>
				</div>    
            </div>
		</div>
	</div>
</section>
