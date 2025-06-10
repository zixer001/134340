

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
          <h5 class="text-dark">เพิ่ม-ย้ายเงิน<a href="withdraw.php" class="btn btn-success float-right">ย้อนกลับ</a>
          </h5>
          <hr>
          
          
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <center><h5 class="text-dark">ทรูวอเล็ต</h5></center>
              <br>
              <form action="transfer_true.php" class="form-horizontal ng-pristine ng-valid" method="POST">
                <div class="form-group" style="margin-right: 50px;">
                  <div class="row">
                    <label class="col-sm-2 control-label">เพิ่มเข้า</label>
                    <div class="col-sm-4">
                      <input type="number" name="transfer_in_true" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  value="">
                    </div>
                    <label class="col-sm-2 control-label">ย้ายออก</label>
                    <div class="col-sm-4">
                      <input type="number" name="transfer_out_true" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  value="" >
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-md-5"></label>
                    <div class="col-sm-4">
                      <button type="submit" class="btn btn-success" name="Update" id="Update" value="Update">คลิ๊กเพื่อบันทึก</button>
                    </div>
                  </div>
                </div>
              </form>
              </div>
              
              <div class="col-md-6">
                <center><h5 class="text-dark">ธนาคารกสิกรไทย</h5></center>
              <br>
              <form action="transfer_kbank.php" class="form-horizontal ng-pristine ng-valid" method="POST">
                <div class="form-group" style="margin-right: 50px;">
                  <div class="row">
                    <label class="col-sm-2 control-label">เพิ่มเข้า</label>
                    <div class="col-sm-4">
                      <input type="number" name="transfer_in_kbank" class="form-control ng-pristine ng-untouched ng-valid ng-empty" value="">
                    </div>
                    <label class="col-sm-2 control-label">ย้ายออก</label>
                    <div class="col-sm-4">
                      <input type="number" name="transfer_out_kbank" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  value="" >
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-md-5"></label>
                    <div class="col-sm-4">
                      <button type="submit" class="btn btn-success" name="Update" id="Update" value="Update">คลิ๊กเพื่อบันทึก</button>
                    </div>
                  </div>
                </div>
              </form>
              </div>
               <div class="col-md-6">
                <center><h5 class="text-dark">ธนาคารไทยพาณิชย์</h5></center>
              <br>
              <form action="transfer_scb.php" class="form-horizontal ng-pristine ng-valid" method="POST">
                <div class="form-group" style="margin-right: 50px;">
                  <div class="row">
                    <label class="col-sm-2 control-label">เพิ่มเข้า</label>
                    <div class="col-sm-4">
                      <input type="number" name="transfer_in_scb" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  value="">
                    </div>
                    <label class="col-sm-2 control-label">ย้ายออก</label>
                    <div class="col-sm-4">
                      <input type="number" name="transfer_out_scb" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  value="" >
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-md-5"></label>
                    <div class="col-sm-4">
                      <button type="submit" class="btn btn-success" name="Update" id="Update" value="Update">คลิ๊กเพื่อบันทึก</button>
                    </div>
                  </div>
                </div>
              </form>
              </div>
               <div class="col-md-6">
                <center><h5 class="text-dark">ธนาคารกรุงไทย</h5></center>
              <br>
              <form action="transfer_ktb.php" class="form-horizontal ng-pristine ng-valid" method="POST">
                <div class="form-group" style="margin-right: 50px;">
                  <div class="row">
                    <label class="col-sm-2 control-label">เพิ่มเข้า</label>
                    <div class="col-sm-4">
                      <input type="number" name="transfer_in_ktb" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  value="">
                    </div>
                    <label class="col-sm-2 control-label">ย้ายออก</label>
                    <div class="col-sm-4">
                      <input type="number" name="transfer_out_ktb" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  value="" >
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-md-5"></label>
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

      
    

<div class="table-responsive">
<?php
  $query = "SELECT * FROM transfer ORDER BY id desc" or die("Error:" . mysqli_error());
  $result = mysqli_query($con, $query);
    echo '<table class="table table-dark">';
    echo "<thead>";
  echo "<tr align='center'>
      <!--<th align='center' hide>ลำดับ</th>-->
      <th align='center' width='10%'>เพิ่มเข้าทรูวอเล็ต</th>
      <th align='center' width='10%'>ย้ายออกจากทรูวอเล็ต</th>
      
      <th align='center' width='10%'>เพิ่มเข้า Kbank</th>
      <th align='center' width='10%'>ย้ายออกจาก kbank</th>
      <th align='center' width='10%'>เพิ่มเข้า SCB</th>
      <th align='center' width='10%'>ย้ายออกจาก SCB</th>
      <th align='center' width='10%'>เพิ่มเข้า KTB</th>
      <th align='center' width='10%'>ย้ายออกจาก KTB</th>
      <th align='center'>วันที่ทำรายการ</th>
      
    </tr>";
    
  echo "</thead>";


  
  echo '<tbody>';
    while($row = mysqli_fetch_array($result)) {
    echo'<tr>';
      
      echo "<td align='center'>" .$row["transfer_in_true"] .  "</td> ";
      echo "<td align='center'>" .$row["transfer_out_true"] .  "</td> ";

      echo "<td align='center'>" .$row["transfer_in_kbank"] .  "</td> ";
      echo "<td align='center'>" .$row["transfer_out_kbank"] .  "</td> ";
      echo "<td align='center'>" .$row["transfer_in_scb"] .  "</td> ";
      echo "<td align='center'>" .$row["transfer_out_scb"] .  "</td> ";
      echo "<td align='center'>" .$row["transfer_in_ktb"] .  "</td> ";
      echo "<td align='center'>" .$row["transfer_out_ktb"] .  "</td> ";
      echo "<td align='center'>" .$row["date_transfer"] .  "</td> ";
      echo'</tr>';
    }
  echo '</tbody>';
  echo "</table>";      
  ?>


          </div><br><br><br><br>
                         
          </div>
        </div>
      </div>
    </div>
  </div>


        </section>
            <?php include 'inc/footer.php'; ?>

           