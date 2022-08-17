
<?php
// define('ERR4','<h1 class="alert alert-danger">Error404</h1>');

  
require_once("config.php");


if(isset($_GET['page']) && !empty($_GET['page'])  && isset($_GET['view']) && !empty($_GET['view'])){
    function ckdate($strDate,$th=false){
          if($strDate=="-"){
              return "-";
          }

         
        $strYear = date("Y",strtotime($strDate));
       $strMonth= date("m",strtotime($strDate));
         $strDay= date("d",strtotime($strDate));
       
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
      
        if($th==true){
            
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
            // $strYear = date("Y",strtotime($strDate));
              $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear ";    
    }else{
        //  echo "$strYear-$strMonth-$strDay";
        
        return "$strYear-$strMonth-$strDay";  
    }
    //    return $texts;
    }
 
 
switch ($_GET["page"]) {
    case 'user':
        require_once("user_col.php");
    break;
    case 'pmis':
        require_once("pmis_col.php");
    break;
    case 'login':
        require_once("login_col.php");
    break;
    case 'user':
        require_once("user_col.php");
    break;
       case 'housing':
       require_once("housing_col.php");
    break;
        case 'check':
       require_once("check_col.php");
    break;
    case 'repair':
        require_once("repair_col.php");
     break;
     case 'damaged':
        require_once("damaged_col.php");
     break;
     case 'report':
        require_once("report_col.php");
     break;
    default:
    ob_start();
    ob_clean();
    ob_end_flush();
    ob_end_clean();
    header( "refresh: 1; url=auth_page.php?view=list&page=report");
    // header("Location: auth_page.php?view=list&page=report");
   echo ERR4."xxx";
        break;
}
}else{
    echo ERR4; 
    ob_start();
    ob_clean();
    ob_end_flush();
    ob_end_clean();
    header( "refresh: 1; url=auth_page.php?view=list&page=report");
    // header("Location: auth_page.php?view=list&page=report");
}