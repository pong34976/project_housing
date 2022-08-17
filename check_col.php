<div class="b"></div>
<?php
echo '<meta http-equiv="Cache-Control" content="no-store"/>';
function tb_user( ){
    require_once("config.php");
    $connectdb = connectdb();
    if ($connectdb->connect_error) {
        die("Connection failed: " . $connectdb->connect_error);
      }
      $tables = "";
      $sql = "SELECT A.idcard as `idcard`,prefix,rname,lname FROM `tb_user` A LEFT OUTER JOIN tb_housing B on A.idcard = B.idcard WHERE B.idcard IS NULL;";
  
      $result = $connectdb->query($sql);
      if ($result->num_rows > 0) {
      
          // $numrows = $result->fetch_assoc();
        // output data of each row 
      //    <td>'.ckdate($row["birthdate"],true).'</td>
        while($row = $result->fetch_assoc()) {
            $tables  = $tables . ' <option    value="'.$row["idcard"].'"> '.$row["prefix"].' '.$row["rname"].' '.$row["lname"].' </option>';
        }
      } else {
        $tables  ="";
       
      }
      return $tables;
  }
  function tb_housing($singrow="all"){
    $status[0] = "-";
    $status[1] = " btn-success ";
    $status[2] = " btn-primary ";
    $status[3] = " btn-warning ";
    $status[4] = " btn-danger ";
    $housingrow[1]="ประทวน";
    $housingrow[2]="สัญญาบัตร";
    require_once("config.php");
    $connectdb = connectdb();
    if ($connectdb->connect_error) {
        die("Connection failed: " . $connectdb->connect_error);
      }
      if( $singrow!="all"){
        $wheres = "where housingrow='$singrow'";
      }else{
        $wheres = " ";
      }
      $tables ="";
      $sql = "SELECT *  FROM tb_housing $wheres";
  
      $result = $connectdb->query($sql);
      if ($result->num_rows > 0) {
      
          // $numrows = $result->fetch_assoc();
        // output data of each row <button type="button" class="col-1 btn btn-success bi-house-fill"></button>
      //    <td>'.ckdate($row["birthdate"],true).'</td>
        while($row = $result->fetch_assoc()) {
            // $tables  = $tables . ' <option value="'.$row["id"].'">'.$row["noroom"].' </option>';
            //   <button type="button" class="col-1 btn btn-success btn-lg m-1"><span class=" p-0 m-0 bi-house-fill  btn-lg" ></span>sss </button> 
            $tables  = $tables . ' <button  type="button" value="'.$row["id"].'" id="'.$row["id"].'" onclick="tb_housing('.$row["id"].',\''.$row["noroom"].'\',\''.$housingrow[$row["housingrow"]].'\')" class=" listhome col-3   btn '.$status[$row["status"]].' btn-lg m-1" '.($row["status"]!=1 ? "disabled" : "").'><div class=" p-0 m-0 bi-house-fill  btn-lg" ></div>'.$row["noroom"].' </button>';
        }
      } else {
        $tables  ="";
       
      }
      return $tables;
  }
 function tables($limit = 0,$max=10){
  require_once("config.php");
  $connectdb = connectdb();
  if ($connectdb->connect_error) {
      die("Connection failed: " . $connectdb->connect_error);
    }
    $tables = "";
     
  
    $sql =  'SELECT *,tb_check.id_check as idcheck,tb_check.date as datecheck ,IF(checkout_date<>"0000-00-00",checkout_date,  "-") as dateout FROM `tb_check` left join  `tb_user` on `tb_user`.idcard = `tb_check`.idcard  left join tb_housing on tb_housing.id = `tb_check`.id_housing  
    ORDER BY `id_check`  ASC';
    // echo  $sql ;
    $result = $connectdb->query($sql);
    if ($result->num_rows > 0) {
      
        // $numrows = $result->fetch_assoc();
      // output data of each row 
    //    <td>'.ckdate($row["birthdate"],true).'</td>
    $i = 0;
  
      while($row = $result->fetch_assoc()) {
          $i=$i+1;
          $tables  = '<tr>
          <td> '. $row["id_check"] .'</td>
          <td> '.ckdate($row["datecheck"],true).'</td>
          <td> '.ckdate($row["dateout"],true).'</td>
      <td>'.$row["prefix"].' '.$row["rname"].' '.$row["lname"].'</td>
 <td>'.$row["noroom"].'</td>
 <td>'. ($row["checkout"]=="0" ? "เข้า." : "ออก.").'</td>
 
      <td>    '.($row["checkout"]=="0" ? '  <input type="hidden"  name="id_housing" value="'.$row["id_housing"].'"><button  onclick="$(\'#id_housing\').val(\''.$row["id_housing"].'\');$(\'#idcheck\').val(\''.$row["idcheck"].'\');  "  data-bs-toggle="modal" data-bs-target="#outModal" type="submit" class=" btn btn-dark  text-warning col-12  m-1 " name="id_check" value="'.$row["idcheck"].'"> ออกบ้านพัก</button>' : " ").' <br><div class="btn-group">
 
    <a  href="?view=edit&vals='.$row["idcheck"].'&page=check" class=" btn btn-warning col-10  col-sm-4 ">แก้ไข</a>
      <button type="button" name="id" value="'.$row["idcheck"].'"  data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="$(\'#myid\').val(\''.$row["idcheck"].'\'); "  class="btn  btn-danger col-10  m-1 m-sm-0 col-sm-4 ">ลบ</button>
       </div>
      </td>
    </tr>'.$tables;
      }
    } else {
      $tables  ="";
     
    }
    return $tables;
}
    // ----------------------------เมื่อมีการรับค่าPOST vvvvvv -------------------------------
    if($_SERVER['REQUEST_METHOD']=="POST"){
      
        function ckstring($text,$alerts ){
            if(isset($_POST[$text]) && !empty($_POST[$text]) && trim($_POST[$text])){
                      
                $texts=htmlentities($_POST[$text]);
            }else{
                echo  "<h5 class='alert alert-danger'>".$alerts."</h5>";
               
                define(strtoupper($text),"alert-danger");
                  $err =false;
                // die();
                return $err;
            }
          
           return $texts;
        }

        switch ($_GET['view']) {
          case 'checkout':
            if(isset($_POST["id_check"]) && !empty($_POST["id_check"])){
       $id_housing = $_POST["id_housing"];
       $id_check = $_POST["id_check"];
       $checkout_date = $_POST["checkout_date"];
       $connectdb = connectdb();
       $sql = "UPDATE `tb_check` SET  `checkout` = '1', `checkout_date` = '". $checkout_date."' WHERE `tb_check`.`id_check` = $id_check;";
        
       $result = $connectdb->query($sql);

              $connectdb = connectdb();
              $sql = "UPDATE `tb_housing` SET   `status` = '1', `idcard` = '1'     WHERE `tb_housing`.`id` = $id_housing;";
            
              $result = $connectdb->query($sql);
              $pins[1]="active";
              $tables  = tables();
              
              require_once("list_check.html");
            }
            break;
            case 'list':
     if(isset($_POST["pni"]) && !empty($_POST["pni"])){
        $pni = ($_POST["pni"]-1)*10;
       
      $tables  = tables($pni);
     
       $pins[$_POST["pni"]]="active";
      require_once("list_check.html");
     }else{
        echo ERR4;
     }
            break;
        
           
            case 'add':
              
            //   print_r($_POST);
            //     die();
                $idcard=ckstring("idcard" ,'รหัสบัตรประชาชน ไม่ควรเว้นว่าง' );
             
                $id_housing=ckstring("id_housing",'id_housing ไม่ควรเว้นว่าง' );
                $date=ckstring("date",'date ไม่ควรเว้นว่าง' );
                $id_log=ckstring("id_log",'id_log ไม่ควรเว้นว่าง' );
            
          
             if(  $idcard ==false || $id_housing==false || $date==false || $id_log==false  ){
                $err['idcard']= @IDCARD;
                $err['id_housing']= @ID_HOUSING;
                $err['date']= @DATE;
                $err['id_log']= @ID_LOG;
                
 
                require_once("add_check.html");
                die();
             }   
          
 
                    $connectdb = connectdb();
                    $sql = "INSERT INTO `tb_check` (`id_check`,`idcard`, `id_housing`, `date`, `id_log`) VALUES (NULL,  '$idcard', '$id_housing', '$date','$id_log');";
                    //  echo $sql;
                    //  die();
        if ($connectdb->query($sql) === TRUE) {
     
                        // echo "<h3 class='alert alert-success'>เพิ่มข้อมูล  เรียบร้อย คลิ๊ก!! รายการสิทธิ์ เพื่อเรียกดู</h3>";
                        $connectdb = connectdb();
                        
                        $sql = "UPDATE `tb_housing` SET   `status` = '2'  , `idcard` = '$idcard'   WHERE `tb_housing`.`id` = $id_housing;";
                        echo ($connectdb->query($sql) === TRUE ? "<h3 class='alert alert-success'>เพิ่มข้อมูล เรียบร้อย </h3>"."<h3 class='alert alert-success'>เพิ่มไปยัง checkin</h3>" : "<h3 class='alert alert-warning'> ! ขอมูล checkinมีปัณหา</h3>" );
                     
                        ob_start();
                        ob_clean();
                        ob_end_flush();
                        
                        header( "refresh: 0; url=auth_page.php?view=list&page=check");
                        // require_once("list_check.html");
                    } else {
                        
                        //  $mession=  "<br> <h5>Error: " . $sql . "<br>" . $conn->error . '</h5>';
                         echo  ERR4;
                         echo  "<h5 class='alert alert-danger'>ไม่สามารถเพิ่มข้อมูลได้</h5>";
                         require_once("add_check.html");
    }
         
         
            break;
            case 'edit':
                $id_check=ckstring("id_check" ,'id_check ไม่ควรเว้นว่าง' );
                $idcard=ckstring("idcard" ,'รหัสบัตรประชาชน ไม่ควรเว้นว่าง' );
             
                $id_housing=ckstring("id_housing",'id_housing ไม่ควรเว้นว่าง' );
                $date=ckstring("date",'date ไม่ควรเว้นว่าง' );
                $id_log= ckstring("id_log",'id_log ไม่ควรเว้นว่าง') ;
      
          
                // $checkImage=ckstring("checkImage",'รูปภาพไม่สมบูรณ์ กรุณา เลือกภาพอีกครัง' );
                if(  $idcard ==false || $id_housing==false || $date==false || $id_log==false  ){
                    $err['id_check']= @ID_CHECK;
                    $err['idcard']= @IDCARD;
                    $err['id_housing']= @ID_HOUSING;
                    $err['date']= @DATE;
                    $err['id_log']= @ID_LOG;
                    
     
                //  $err['checkImage']= @checkIMAGE;
                require_once("edit_check.html");
                die();
             }   
           
 
                 
                    $connectdb = connectdb();
  $sql = "UPDATE `tb_check` SET `idcard` = '$idcard', `id_housing` = '$id_housing', `date` = '$date', `id_log` = '$id_log' WHERE `tb_check`.`id_check` = $id_check;";
                     
        if ($connectdb->query($sql) === TRUE) {
           
                        echo "<h3 class='alert alert-success'>แก้ข้อมูลสิทธิ์ เรียบร้อย คลิ๊ก!! รายการสิทธิ์ เพื่อเรียกดู</h3>";
                        ob_start();
                        ob_clean();
                        ob_end_flush();
                        
                        header( "refresh: 0; url=auth_page.php?view=list&page=check");
                    
                    } else {
                       echo  $sql;
                        die();
                         $mession=  "<br> <h5>Error: " . $sql . "<br>" . $conn->error . '</h5>';
                         echo  ERR4;
                         require_once("edit_check.html");
    }  
                // require_once("edit_check.html");
            break;
                 case 'del':
                
            
                $id=ckstring("id" ,'รหัส ไม่ควรเว้นว่าง' );
                 
             
             
               
                    $connectdb = connectdb();
                    $sql = "DELETE FROM tb_check where id_check='$id' ";
                     
        if ($connectdb->query($sql) === TRUE) {
            // $checks ="";
            // $showname="";
                        echo "<h3 class='alert alert-success'>ลบ สิทธิ์ เรียบร้อย  </h3>";
                        $pins[1]="active";
        $tables  = tables();
       
     
        
        
        require_once("list_check.html");
                        die();
                        // require_once("list_check.html");
                    } else {
                        
                         $mession=  "<br> <h5>Error: " . $sql . "<br>" . $conn->error . '</h5>';
                         echo  ERR4;
                         require_once("lise_check.html");
    }  
                require_once("list_check.html");
            break;
            default:
            echo  ERR4; 
                break;
        }
    }else{
           // ----------------------------เมื่อมีเรียกหน้าเว็บ แต่ไม่มีค่าPOST vvvvvv -------------------------------
switch ($_GET['view']) {
    case 'list':
        $pins[1]="active";
        $tables  = tables();
        
        require_once("list_check.html");
    break;
    case 'view':
       
            if(isset($_GET["id"]) && !empty($_GET["id"])){
                $vals=$_GET["id"];
                $connectdb = connectdb();
             $sql = "SELECT * FROM tb_check where id_check = $vals";
             $result = $connectdb->query($sql);
             if ($result->num_rows > 0) {
                 $row = $result->fetch_assoc();
                 $id_check = $row["id_check"];
                
                 $idcard = $row["idcard"];  
                 $id_housing = $row["id_housing"];
                 $date = $row["date"];
                 $id_log = $row["id_log"];
               
                  
 
               
             }
            require_once("view_check.html");
        }else{
          echo  ERR4;
        }
       
        break;
    case 'add':
  
    require_once("add_check.html");
    break;
    case 'edit':
      $housingrow[1]="ประทวน";
      $housingrow[2]="สัญญาบัตร";
        if(isset($_GET["vals"]) && !empty($_GET["vals"])){
               $vals=$_GET["vals"];
               $connectdb = connectdb();
            $sql = "SELECT *,tb_check.idcard as idc FROM tb_check inner join tb_housing on tb_housing.id = tb_check.id_housing where id_check = $vals";
            $result = $connectdb->query($sql);
          // echo $sql;
          //   die();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id_check = $row["id_check"];
                
                $idcard = $row["idc"];  
                $id_housing = $row["id_housing"];
                $noroom = $row["noroom"];
           
                $date = $row["date"];
                $status = $row["status"];
              
            }
            require_once("edit_check.html");
        }else{
         echo ERR4;
        }
 
    break;
    default:
    echo  ERR4; 
        break;
}
}
 
?>