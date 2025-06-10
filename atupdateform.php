<?php include 'inc/header.php'; ?>
<section class="pcoded-main-container">
<div class="pcoded-content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="text-dark">แก้ไขกิจกรรม<a href="activity.php" class="btn btn-success float-right">ย้อนกลับ</a>
          </h5>
          <hr>
          
          <?php
          //1. เชื่อมต่อ database:
          include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
          //ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก
          if($_GET["id"]==''){
          echo "<script type='text/javascript'>";
          echo "alert('Error Contact Admin !!');";
          echo "window.location = 'index.php'; ";
          echo "</script>";
          }
          //รับค่าไอดีที่จะแก้ไข
          $id2 = mysqli_real_escape_string($con,$_GET['id']);
          //2. query ข้อมูลจากตาราง:
          $sql = "SELECT * FROM activity WHERE id='$id2' ";
          $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
          $row = mysqli_fetch_array($result);
          extract($row);
          ?>
        
          <div class="container">
            <div class="row">
              <form class="form-horizontal ng-pristine ng-valid" method="POST" action="atupdate_db.php">
                <div class="mb-2">
                  <input class="form-control" name="id" value="<?=$id;?>" hidden="hide">
                  <span class="text-dark">รูปกิจกรรม</span>
                  <div class="col-sm-4">
                  <?php
                  
                  //หัวข้อตาราง
                  echo "<td>" ."<img src='../slip/".$row['fileupload_at']  ."' width='100%'>"."</td>";
                  ?>
                
                  </div>
                </div><br>
                <div class="mb-2">
                  <span class="text-dark">ชื่อกิจกรรม</span>
                  <div class="col-sm-4">
                  <input class="form-control" name="name_at" value="<?=$name_at;?>" >
                  </div>
                </div>
               
                <div class="mb-2">
                  <span class="text-dark">รายละเอียดกิจกรรม</span>
                  <div class="col-sm-4">
                  <textarea name="detail_at" id="editor" cols= "300" rows= "30" value=""><?php echo $detail_at; ?>"</textarea>
                </div>
                
                <div class="mb-2">
                  <span class="text-dark">เครดิตที่แจก</span>
                  <div class="col-sm-4">
                  <input class="form-control" name="credit_at" value="<?=$credit_at;?>" >
                  </div>
                </div>
                </div>
                <div class="mb-2">
                  <span class="text-dark">จำนวนที่แจก</span>
                  <div class="col-sm-4">
                  <input class="form-control" name="amount_at" value="<?=$amount_at;?>" >
                  </div>
                </div>
                <div class="mb-2">
                  <span class="text-dark">เทิร์นโอเวอร์</span>
                  <div class="col-sm-4">
                  <input class="form-control" name="turnover_at" value="<?=$turnover_at;?>" >
                  </div>
                </div>
                <div class="mb-2">
                  <span class="text-dark">สถานะ</span>
                  <div class="col-sm-4">
                  <select required="required" class="custom-select custom-select-md" name="status_at">
                        <option value="เปิด">เปิด</option>
                        <option value="ปิด">ปิด</option>
                  </select>
                  </div>
                </div>
                <br>
                <div class="mb-2">
                  <span class="text-dark"></span>
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

            </section>
            <?php include 'inc/footer.php'; ?>
          



          </section>