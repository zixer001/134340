<?php 
session_start();
        if(isset($_POST['username_ad'])){
				//connection
                  include("../connectdb.php");
				//รับค่า user & password_ad
                  $username_ad = $_POST['username_ad'];
                  $password_ad = md5($_POST['password_ad']);
				//query 
                  $sql="SELECT * FROM admin Where username_ad='".$username_ad."' and password_ad='".$password_ad."' ";

                  $result = mysqli_query($con,$sql);
				
                  if(mysqli_num_rows($result)==1){

                      $row = mysqli_fetch_array($result);

                      $_SESSION["id_ad"] = $row["id_ad"];
                      $_SESSION["name_ad"] = $row["name_ad"];
                      $_SESSION["username_ad"] = $row["username_ad"];
                      $_SESSION["status_ad"] = $row["status_ad"];

                      if($_SESSION["status_ad"]=="Administrator"){ 


                        Header("Location: index.php");

                      }

                      if ($_SESSION["status_ad"]=="Staff"){  

                        Header("Location: index.php");

                      }

                  }else{
                    echo "<script>";
                        echo "alert(\" user หรือ  password_ad ไม่ถูกต้อง\");"; 
                        echo "window.history.back()";
                        
                    echo "</script>";

                  }

        }else{


             Header("Location: form.php"); //user & password_ad incorrect back to login again

        }
?>