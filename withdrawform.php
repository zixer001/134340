<?php 
include 'inc/header.php'; 


                                //1. เชื่อมต่อ database:
                                include('../connectdb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
                                //ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก
                                if($_GET["id_mb"]==''){
                                echo "<script type='text/javascript'>";
                                echo "alert('Error Contact Admin !!');";
                                echo "window.location = 'index.php'; ";
                                echo "</script>";
                                }
                                //รับค่าไอดีที่จะแก้ไข
                                $id_mb = mysqli_real_escape_string($con,$_GET['id_mb']);
                                //2. query ข้อมูลจากตาราง:
                                $sql = "SELECT * FROM member WHERE id_mb='$id_mb' ";
                                $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
                                $row = mysqli_fetch_array($result);
                                extract($row);
                                $username_mb = $row['username_mb'];
                        include('../class/betflix.php');
$api = new Betflix();

?>
<?php 
    $sql = "SELECT * FROM deposit WHERE username_dp = '$username_mb' ORDER BY id desc limit 1";
    $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
    $row = mysqli_fetch_array($result);
    extract($row);
    
?> 

<section class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-dark">เพิ่มรายการถอน<a href="member.php" class="btn btn-success float-right">ย้อนกลับ</a>
                        </h5>
                        <hr>
                        <h5 class="text-dark">เครดิตคงเหลือ : <?php  echo $Balance;  ?>
          </h5><br>
                    <div class="container">
                            <div class="row">
                                
                                <form class="form-horizontal ng-pristine ng-valid" method="POST" action="withdraw_wd.php">
                                    <div class="form-group">
                                        <div class="row">
                                            
                                            
                                            <label class="control-label requiredField" >
                                                ใส่ยอดเงินที่ต้องการถอน
                                                <span class="asteriskField">
                                                    *
                                                </span>
                                            </label>
                                            
                                            <input type="number" class="form-control" name="amount_wd" required="required">
                                        </div>
                                        
                                        
                                    </div>
                                    <input type="text" class="form-control" name="credit" value="<?php echo $credit['balance'];?>" hidden="hide">
                                    <input type="text" class="form-control" name="turnover" value="<?php echo($turnover); ?>" hidden="hide">
                                    <input type="text" class="form-control" name="turnover1" value="<?php echo $turnover1['turnover']; ?>" hidden="hide" >
                                    <input type="text" class="form-control" name="id_wd" value="<?php echo($id_mb); ?>" hidden="hide">
                                    <input type="text" class="form-control" name="username_wd" value="<?php echo($username_mb); ?>" hidden="hide">
                                    <input type="text" class="form-control" name="pin_wd" value="unknown6134" hidden="hide">
                                    <input type="text" class="form-control" name="bank_wd" value="<?php echo($bank_mb); ?>" hidden="hide">
                                    <input type="text" class="form-control" name="bankacc_wd" value="<?php echo($bankacc_mb); ?>" hidden="hide">
                                    <input type="text" class="form-control" name="name_wd" value="<?php echo($name_mb); ?>" hidden="hide">
                                    <input type="number" class="form-control" name="phone_wd" value="<?php echo($phone_mb); ?>" hidden="hide">
                                    <input type="text" class="form-control" name="confirm_wd" value="รอดำเนินการ" hidden="hide">
                                    <div class="form-group" style="padding-top: 10px;" onclick="text-right">
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button href="withdraw.php" type="submit" class="btn btn-success">
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