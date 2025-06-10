<?php include 'inc/header.php'; ?>
<section class="pcoded-main-container">
<div class="pcoded-content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="text-dark">แก้ไขโปรโมชั่น<a href="promotion.php" class="btn btn-success float-right">ย้อนกลับ</a>
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
          $sql = "SELECT * FROM promotion WHERE id='$id2' ";
          $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
          $row = mysqli_fetch_array($result);
          extract($row);
          ?>
        
          <div class="container">
            <div class="row">
              <form class="form-horizontal ng-pristine ng-valid" method="POST" action="promotionupdate_db.php">
                <div class="mb-2">
                  <input class="form-control" name="id" value="<?=$id;?>" hidden="hide">
                  <span class="text-dark">รูปโปรโมชั่น</span>
                  <div class="col-sm-4">
                  <?php
                  
                  //หัวข้อตาราง
                  echo "<td>" ."<img src='../slip/".$row['fileupload_pro']  ."' width='100%'>"."</td>";
                  ?>
                
                  </div>
                </div><br>
                <div class="mb-2">
                  <span class="text-dark">ชื่อโปรโมชั่น</span>
                  <input class="form-control" name="name_pro" value="<?php  echo $row["name_pro"]; ?>" >
                </div>
                <div class="mb-2">  
                  <span class="text-dark">ลักษณะโบนัส</span>          
                  <select required="required" class="custom-select custom-select-md" name="time_pro">
                              
                              <option value="<?php  echo $row["time_pro"]; ?>"><?php  echo $row["time_pro"]; ?></option>
                              <option value="สมาชิกใหม่">สมาชิกใหม่</option>
                              <option value="รับได้ครั้งเดียว">รับได้ครั้งเดียว</option>
                              <option value="รับได้วันละ 1 ครั้ง">รับได้วันละ 1 ครั้ง</option>
                              <option value="รับได้ทุกครั้ง">รับได้ทุกครั้ง</option>
                            </select>
                </div> 
                <div class="mb-2">
                  <span class="text-dark">ยอดฝากขั้นต่ำ</span>
                  <input type="number" class="form-control" name="dp_pro" value="<?php  echo $row["dp_pro"]; ?>" >
                </div>
                <div class="mb-2">
                  <span class="text-dark">โบนัส (แบบกำหนดจำนวนเงิน)</span>
                  <input type="number" class="form-control" name="bonus_pro" value="<?php  echo $row["bonus_pro"]; ?>" placeholder="ถ้าไม่มีให้ใส่ 0" required="required">
                </div>
                <div class="mb-2">
                  <span class="text-dark">โบนัส (แบบเปอร์เซ็นต์)</span>
                  <input type="number" class="form-control" name="bonusper_pro" value="<?php  echo $row["bonusper_pro"]; ?>" placeholder="ถ้าไม่มีให้ใส่ 0" required="required">
                </div>
                <div class="mb-2">
                  <span class="text-dark">รับได้สูงสุด</span>
                  <input type="number" class="form-control" name="max_pro" value="<?php  echo $row["max_pro"]; ?>" placeholder="ใส่จำนวนโบนัสสูงสุด" required="required">
                </div>
                <div class="mb-2">
                  <span class="text-dark">เกมส์ที่เล่นได้</span>
                  <input type="text" class="form-control" name="games_pro" value="<?php  echo $row["games_pro"]; ?>" >
                </div>
                <div class="mb-2">
                  <span class="text-dark">เทิร์นโอเวอร์</span>
                  <input class="form-control" name="turn_pro" value="<?php  echo $row["turn_pro"]; ?>" >
                </div>
                <div class="mb-2">
                  <span class="text-dark">กติกา</span>
                  <input class="form-control" name="rules_pro" value="<?php  echo $row["rules_pro"]; ?>" >
                </div>
                <div class="mb-2">
                  <span class="text-dark">ถอนได้สูงสุด</span>
                  <input class="form-control" name="wd_pro" value="<?php  echo $row["wd_pro"]; ?>" >
                </div>
                </div>
                <div class="form-group">
                  <div class="row">
                   
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