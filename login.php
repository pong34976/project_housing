 <?php 
 session_start();
if(!empty( $_SESSION["level"] )){
  header("Location: auth_page.php");
die();
}
 if($_SERVER["REQUEST_METHOD"]=="POST"){
 
    
          require_once("config.php");
          $connectdb =connectdb();
          if(isset($_POST["username"]) && !empty($_POST["username"]) && isset($_POST["password"]) && !empty($_POST["password"])){
      //  echo "isset empty";
      $username = $_POST["username"];
      $password = $_POST["password"];
          } else{
            $errmsg ="ไม่ได้กรอก username หรือ password ";
            require_once("login.php"); 
             die();
          }
           
           

        $sql = "SELECT  *,concat(prefix,' ',rname,' ',lname) as  fullname    FROM  tb_login  where username='$username' AND password='$password' ";
        $result=  $connectdb->query($sql);
       if($result->num_rows > 0){
          $row = $result->fetch_assoc();
 
     $_SESSION["fullname"]=  $row["fullname"];
    $_SESSION["id"]=  $row["log_id"];
   $_SESSION["level"]=  $row["log_level"];
 
    
      header("Location: auth_page.php");
   
       }else{
       $errmsg ="username หรือ password ไม่ถูกต้อง";

       }
  

 } 
 require_once("login.html");
   // 