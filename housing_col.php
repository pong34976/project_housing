<div class="b"></div>
<?php
  function tb_user( ){
    require_once("config.php");
    $connectdb = connectdb();
    if ($connectdb->connect_error) {
        die("Connection failed: " . $connectdb->connect_error);
      }
      $tables = "";
      $sql = "SELECT *  FROM tb_user";
  
      $result = $connectdb->query($sql);
      if ($result->num_rows > 0) {
      
          // $numrows = $result->fetch_assoc();
        // output data of each row 
      //    <td>'.ckdate($row["birthdate"],true).'</td>
        while($row = $result->fetch_assoc()) {
            $tables  = $tables . ' <option value="'.$row["idcard"].'">'.$row["prefix"].' '.$row["rname"].' '.$row["lname"].'</option>';
        }
      } else {
        $tables  ="";
       
      }
      return $tables;
  }
  function  status($id="0"){
    $status[0] = "-";
    $status[1] = "<div class=' badge  bg-success'>ว่าง</div>";
    $status[2] = "<div class='  badge  bg-primary'>มีผู้พักอาศัย</div>";
    $status[3] = "<div class=' badge  bg-warning'>ซ่อมบำรุง</div>";
    $status[4] = "<div class=' badge  bg-danger'>ปิด</div>";
    return $status[$id];
}
 
echo '<meta http-equiv="Cache-Control" content="no-store"/>';
 function cknoroom( ){
    require_once("config.php");
    $connectdb = connectdb();
 
    $sql = "SELECT noroom  FROM tb_housing  ";
    if ($result = $connectdb->query($sql)) {

        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $myArray[] = $row;
        }
        echo json_encode($myArray);
    }
   
 } 
 function tables($limit = 0,$max=10){
  require_once("config.php");
  $connectdb = connectdb();
  if ($connectdb->connect_error) {
      die("Connection failed: " . $connectdb->connect_error);
    }
    $tables = "";
    $sql = "SELECT *  FROM tb_housing";
    $result = $connectdb->query($sql);
       define("NOMROW",($result->num_rows/10)+1);
       define("NOMROWS",$result->num_rows );
    
 
//  
 
//    $status[1][1]="ss";
    $sql = "SELECT * ,IF(tb_housing.housingrow=1,'ประทวน','สัญญาบัตร') as hou FROM `tb_housing` ";
    // echo  $sql ;
    $result = $connectdb->query($sql);
    if ($result->num_rows > 0) {
    
        // $numrows = $result->fetch_assoc();
      // output data of each row 
    //    <td>'.ckdate($row["birthdate"],true).'</td>'.status($row["status"]).'
      while($row = $result->fetch_assoc()) {
          $tables  = '<tr>
          <td>'.$row["id"]. '</td>
      <td>'.$row["noroom"]. '</td>
      <td>'.$row["hou"].' </td>
      <td class=" h5 w-25">   
      <font class="d-none">'.status($row["status"]).'</font> 
      <div class="btn-group">
        <button class=" btn btn-dark p-1 text-success bi-house" data-bs-toggle="tooltip" data-bs-placement="top" title="ว่าง" '.($row["status"]==1 ? "" : "disabled").'></button>
      <button class=" btn btn-dark p-1 text-primary bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="top" title="มีผู้พักอาศัย" '.($row["status"]==2 ? "" : "disabled").'></button>
      <button class=" btn btn-dark p-1 text-warning bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="top" title="ซ่อมบำรุง"  '.($row["status"]==3 ? "" : "disabled").'></button>
      <button class=" btn btn-dark p-1 text-danger bi-house-fill" data-bs-toggle="tooltip" data-bs-placement="top" title="ปิด" '.($row["status"]==4 ? "" : "disabled").'></button></td>
      </div> 
      
      <td>  <div class="btn-group">
   <a  href="?view=view&id='.$row["id"].'&page=housing" class=" btn btn-primary col-10 m-1 m-sm-0 col-sm-4 ">ดู</a>  
    <a  href="?view=edit&vals='.$row["id"].'&page=housing" class=" btn btn-warning col-10 m-1 m-sm-0 col-sm-4 ">แก้ไข</a>
      <button name="id" value="'.$row["id"].'"  data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="$(\'#myid\').val(\''.$row["id"].'\'); "  class="btn  btn-danger col-10  m-1 m-sm-0 col-sm-4 ">ลบ</button>
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
            case 'list':
     if(isset($_POST["pni"]) && !empty($_POST["pni"])){
        $pni = ($_POST["pni"]-1)*10;
       
      $tables  = tables($pni);
     
       $pins[$_POST["pni"]]="active";
      require_once("list_housing.html");
     }else{
        echo ERR4;
     }
            break;
        
           
            case 'add':
              
            //   print_r($_POST);
            //     die();
             
            $noroom=ckstring("noroom",'noroom ไม่ควรเว้นว่าง' );
            $housingrow=ckstring("housingrow",'housingrow ไม่ควรเว้นว่าง' );
            $status=ckstring("status",'status ไม่ควรเว้นว่าง' );
            $idcard = true;
if($status==2){
    $idcard=ckstring("idcard",'idcard ไม่ควรเว้นว่าง' );
}
            
            // $housingImage=ckstring("housingImage",'รูปภาพไม่สมบูรณ์ กรุณา เลือกภาพอีกครัง' );
         
         if(    $noroom ==false || $housingrow ==false  || $status ==false  || $idcard ==false ){
           
            $err['noroom']= @NOROOM;
            $err['housingrow']= @HOUSINGROW;
            $err['status']= @STATUS;
            $err['idcard']= @IDCARD;
             
            //  $err['housingImage']= @housingIMAGE;
            require_once("add_housing.html");
            die();
         } 
         
 
        
             
                // $birthdate  =date("Y-m-d",strtotime($birthdate));
                // $birthdate = ckdate($birthdate);
                    $connectdb = connectdb();
                    $sql = "INSERT INTO `tb_housing` (`id`, `noroom`, `housingrow`, `idcard`, `status`) VALUES (null, '$noroom', '$housingrow', '$idcard', '$status');";
           
                    //  echo $sql;
                    //  die();
        if ($connectdb->query($sql) === TRUE) {
            $id_housing = mysqli_insert_id($connectdb);
            $date = date("Y-m-d");
            $id_log=$_SESSION["id"];
            // print_r($last_id);
            // die();
            $connectdb->close();
            $connectdb = connectdb();
            if($status==2){
            $sql = "INSERT INTO `tb_check` (`id_check`, `idcard`, `id_housing`, `date`, `id_log`) VALUES (null, '$idcard', '$id_housing', '$date', '$id_log');";
            // echo $sql;   
            // die();
                        echo ($connectdb->query($sql) === TRUE ? "<h3 class='alert alert-success'>เพิ่มข้อมูล เรียบร้อย คลิ๊ก!! รายการ  เพื่อเรียกดู</h3>"."<h3 class='alert alert-success'>เพิ่มไปยัง checkin</h3>" : "<h3 class='alert alert-warning'>เพิ่มข้อมูล เรียบร้อย ! ขอมูล checkinมีปัณหา</h3>" );
                    }else{
echo "<h3 class='alert alert-success'>เพิ่มข้อมูลสิทธิ์ เรียบร้อย คลิ๊ก!! รายการสิทธิ์ เพื่อเรียกดูหรือ รอ2วินาที</h3>";
// require_once("add_login.html"); 
ob_start();
ob_clean();
ob_end_flush();

header( "refresh: 0; url=auth_page.php?view=list&page=housing");
              
                    }         
                        require_once("add_housing.html"); 
                    
                        // require_once("list_housing.html");
                    } else {
                        
                        //  $mession=  "<br> <h5>Error: " . $sql . "<br>" . $conn->error . '</h5>';
                         echo  ERR4;
                         echo  "<h5 class='alert alert-danger'>ไม่สามารถเพิ่มข้อมูลได้</h5>";
                         require_once("add_housing.html");
    }
         
         
            break;
            case 'edit':
               
                $id=ckstring("id" ,'id ไม่ควรเว้นว่าง' );
                $noroom=ckstring("noroom",'noroom ไม่ควรเว้นว่าง' );
                $housingrow=ckstring("housingrow",'housingrow ไม่ควรเว้นว่าง' );
                $status=ckstring("status",'status ไม่ควรเว้นว่าง' );
                $idcard = true;
                if($status==2){
                    $idcard=ckstring("idcard",'idcard ไม่ควรเว้นว่าง' );
                }
                // $housingImage=ckstring("housingImage",'รูปภาพไม่สมบูรณ์ กรุณา เลือกภาพอีกครัง' );
             
                if(   $id ==false ||  $noroom ==false || $housingrow ==false  || $status ==false  || $idcard ==false ){
                $err['id']= @ID;
                $err['noroom']= @NOROOM;
                $err['housingrow']= @HOUSINGROW;
                $err['status']= @STATUS;
                $err['idcard']= @IDCARD;
                 
                //  $err['housingImage']= @housingIMAGE;
                require_once("edit_housing.html");
                die();
             }   
        
                 
                    $connectdb = connectdb();
  $sql = "UPDATE `tb_housing` SET `id` = '$id', `noroom` = '$noroom', `housingrow` = '$housingrow', `status` = '$status', `idcard` = '$idcard'   WHERE `tb_housing`.`id` = $id;";
                     
        if ($connectdb->query($sql) === TRUE) {
           
                        echo "<h3 class='alert alert-success'>แก้ข้อมูลสิทธิ์ เรียบร้อย คลิ๊ก!! รายการสิทธิ์ เพื่อเรียกดูหรือ รอ2วินาที</h3>";
                        // require_once("add_login.html"); 
                        ob_start();
                        ob_clean();
                        ob_end_flush();
                        
                        header( "refresh: 0; url=auth_page.php?view=list&page=housing");
                    } else {
                       echo  $sql;
                        die();
                         $mession=  "<br> <h5>Error: " . $sql . "<br>" . $conn->error . '</h5>';
                         echo  ERR4;
                         require_once("edit_housing.html");
    }  
                require_once("edit_housing.html");
            break;
                 case 'del':
                
            
                $id=ckstring("id" ,'รหัส ไม่ควรเว้นว่าง' );
                 
             
             
               
                    $connectdb = connectdb();
                    $sql = "DELETE FROM tb_housing where id='$id' ";
                     
        if ($connectdb->query($sql) === TRUE) {
            // $housings ="";
            // $showname="";
                        echo "<h3 class='alert alert-success'>ลบ  เรียบร้อย  </h3>";
                        $pins[1]="active";
        $tables  = tables();
       
     
        
        
        require_once("list_housing.html");
                        die();
                        // require_once("list_housing.html");
                    } else {
                        
                         $mession=  "<br> <h5>Error: " . $sql . "<br>" . $conn->error . '</h5>';
                         echo  ERR4;
                         require_once("lise_housing.html");
    }  
                require_once("list_housing.html");
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
        
        require_once("list_housing.html");
    break;
    case 'view':
      if(isset($_GET["id"]) && !empty($_GET["id"])){
        $id=$_GET["id"];
        $connectdb = connectdb();
     $sql = "SELECT * FROM tb_housing where id = $id";
     $result = $connectdb->query($sql);
     if ($result->num_rows > 0) {
         $row = $result->fetch_assoc();
         $id = $row["id"];
        
         $noroom = $row["noroom"];  
         $housingrow = $row["housingrow"];
         $status = $row["status"];
         $idcard = $row["idcard"];
          if($idcard!=1){
            
            $sql2 = "SELECT * FROM tb_user where idcard = '$idcard'";
            $result2 =   $connectdb->query($sql2);
          

            $row2 = $result2->fetch_assoc();
             
            $id_user = $row2["id_user"];
               
            $idcard = $row2["idcard"];  
            $prefix = $row2["prefix"];
            $rname = $row2["rname"];
            $lname = $row2["lname"];
            $sex = $row2["sex"];
            $birthdate = $row2["birthdate"];
            $affiliation = $row2["affiliation"];
            $address = $row2["address"];
            $email = $row2["email"];
            $phones = $row2["phones"];
            $img = $row2["img"];
             

         
            if($sex=="ชาย"){
                $sexs["m"]="checked";
                $sexs["key"]="m";
            }else{
                $sexs["s"]="checked";
                $sexs["key"]="s";
            }
           
          }

     
     }
     require_once("view_housing.html");
 }else{
  echo ERR4;
 }
      
  break;
    case 'add':
      
        
        require_once("add_housing.html");
    break;
        
    case 'edit':
        if(isset($_GET["vals"]) && !empty($_GET["vals"])){
               $vals=$_GET["vals"];
               $connectdb = connectdb();
            $sql = "SELECT * FROM tb_housing where id = $vals";
            $result = $connectdb->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id = $row["id"];
               
                $noroom = $row["noroom"];  
                $housingrow = $row["housingrow"];
                $status = $row["status"];
                $idcard = $row["idcard"];
                 

            
            }
            require_once("edit_housing.html");
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