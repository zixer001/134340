<?php 
session_start();
        if(isset($_POST['phone_mb'])){
				//connection
                  include("connectdb.php");
				//รับค่า user & password_mb
                  $phone_mb = $_POST['phone_mb'];
                  $password_mb = ($_POST['password_mb']);
				//query 
                  $sql="SELECT * FROM member Where phone_mb='".$phone_mb."' and password_mb='".$password_mb."' ";

                  $result = mysqli_query($con,$sql);
				
                  if(mysqli_num_rows($result)==1){

                      $row = mysqli_fetch_array($result);

                      $_SESSION["id_mb"] = $row["id_mb"];
                      $_SESSION["username_mb"] = $row["username_mb"];
                      $_SESSION["password_mb"] = $row["password_mb"];
                      $_SESSION["name_mb"] = $row["name_mb"];
                      $_SESSION["bank_mb"] = $row["bank_mb"];
                      $_SESSION["bankacc_mb"] = $row["bankacc_mb"];
                      $_SESSION["phone_mb"] = $row["phone_mb"];
                      $_SESSION["status_mb"] = $row["status_mb"];
                      $_SESSION["confirm_mb"] = $row["confirm_mb"];
                      $_SESSION["aff"] = $row["aff"];
                      $_SESSION["status"] = $row["status"];
                      $_SESSION["password_ufa"] = $row["password_ufa"];
                      $_SESSION["ip"] = $row["ip"];
                      $_SESSION["phone_true"] = $row["phone_true"];

                      if($_SESSION["status_mb"]=="2"){ 


                        Header("Location: user/index.php?do=1");

                      }

                      if ($_SESSION["status_mb"]!="2"){  

                        Header("Location: index.php");

                      }

                  }else{
                    header("Content-Type: text/html; charset=utf-8");
                    echo "<script>";
                        //echo "alert(\" เบอร์โทรศัพท์ หรือ รหัสผ่านไม่ถูกต้อง ไม่ถูกต้อง\");"; 
                        Header("Location: login.php?do=33");
                        
                    echo "</script>";

                  }

        }else{


             Header("Location: form.php"); //user & password_mb incorrect back to login again

        }
?>