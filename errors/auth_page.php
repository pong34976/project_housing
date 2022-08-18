<?php 
ob_start();

?>
<style>
@font-face {
    font-family: home;
    src: url("css/font/FC Home Thin ver 1.01.otf") format("opentype");
}

@font-face {
    font-family: homebold;
   
    src: url("css/font/FC Home Black ver 1.01.otf") format("opentype");
}

*{
    font-family: 'home';
    font-size: 22px;
}
h1,h2,h3,h4{
    font-family: 'homebold' !important;
    /* font-size: 30px !important; */
    
}
 </style>
<?php 
session_start();
define('ERR4','<h1 class="alert alert-danger">! Error404  </h1>');
 function endpage()
 {
     echo "<style>
     #homepage{
         background-image: none !important;
     }
                 </style>";
    die();
 }
 if(isset($_SESSION["level"])){
  
 }else{
    echo "คุณไม่มีสิทธิ์เข้าใช้งานในหน้านี้ กรุณาติดต่อผู้ดูแลระบบ หรือกลับไปที่หน้า  >><a href='login.php'>LOGIN</a><<<";
    endpage();
 }
if(isset($_GET['page']) && !empty($_GET['page'])){
   
    define(strtoupper($_GET["page"])," text-dark fw-bold bg-light pt-1 pb-1 w-100 ");
  
}
if(!empty($_SESSION["level"]) && $_SESSION["level"]!=""){
switch ($_SESSION["level"]) {
    case 1:
        require_once("temadmin.html");
        break;
    case 2:
        require_once("temuser.html");
    case 3:
        require_once("temboss.html");
    default:
    // header("Location: login.php");
    echo ERR4;
    echo "คุณไม่มีสิทธิ์เข้าใช้งานในหน้านี้ กรุณาติดต่อผู้ดูแลระบบ หรือกลับไปที่หน้า  >><a href='login.php'>LOGIN</a><<<";
        break;
}
 }else{
     header("Locaction: logout.php");
     endpage();
 }
 exit();