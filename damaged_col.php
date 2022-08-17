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
      $sql = "SELECT *  FROM tb_user";
  
      $result = $connectdb->query($sql);
      if ($result->num_rows > 0) {
      
          // $numrows = $result->fetch_assoc();
        // output data of each row 
      //    <td>'.ckdate($row["birthdate"],true).'</td>
        while($row = $result->fetch_assoc()) {
            $tables  = $tables . ' <option class="text-decoration-line-through" value="'.$row["idcard"].'"> '.$row["prefix"].' '.$row["rname"].' '.$row["lname"].' </option>';
        }
      } else {
        $tables  ="";
       
      }
      return $tables;
  }
  function tb_housing( ){
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
      $tables = "";
      $sql = "SELECT *  FROM tb_housing";
  
      $result = $connectdb->query($sql);
      if ($result->num_rows > 0) {
      
          // $numrows = $result->fetch_assoc();
        // output data of each row <button type="button" class="col-1 btn btn-success bi-house-fill"></button>
      //    <td>'.ckdate($row["birthdate"],true).'</td>
        while($row = $result->fetch_assoc()) {
            // $tables  = $tables . ' <option value="'.$row["id"].'">'.$row["noroom"].' </option>';
            //   <button type="button" class="col-1 btn btn-success btn-lg m-1"><span class=" p-0 m-0 bi-house-fill  btn-lg" ></span>sss </button> 
  $tables  = $tables . ' <button  type="button" value="'.$row["id"].'" onclick="tb_housing('.$row["id"].',\''.$row["noroom"].'\',\''.$housingrow[$row["housingrow"]].'\',\''.$status[$row["status"]].'\')" class="col-lg-1 col-5 col-sm-3 btn '.$status[$row["status"]].' btn-lg m-1 col-3"  style="font-size: 15px !important;"><div class=" p-0 m-0 bi-house-fill  btn-lg" ></div>หลังที่'.$row["id"].' </button>';
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
    $sql = "SELECT *  FROM tb_damaged ";
    $result = $connectdb->query($sql);
       define("NOMROW",($result->num_rows/10)+1);
       define("NOMROWS",$result->num_rows );
  
    $sql = "SELECT *    FROM `tb_damaged` left join `tb_housing` on `tb_damaged`.id_housing = `tb_housing`.id";
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
          <td> '.$row["date"].'</td>
      <td>'.$row["noroom"].'</td>
      <td>'.$row["list"].'</td>
 
      <td>    
      
    <a  href="?view=edit&vals='.$row["dam_id"].'&page=damaged" class=" btn btn-warning   ">แก้ไข</a>
      <button type="button" name="id" value="'.$row["dam_id"].'"  data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="$(\'#myid\').val(\''.$row["dam_id"].'\'); "  class="btn  btn-danger  ">ลบ</button>
      </form> </div>
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
          case 'damagedout':
            if(isset($_POST["id_damaged"]) && !empty($_POST["id_damaged"])){
       $id_housing = $_POST["id_housing"];
       $id_damaged = $_POST["id_damaged"];
       $connectdb = connectdb();
       $sql = "UPDATE `tb_damaged` SET  `damagedout` = '1', `damagedout_date` = '".date("Y-m-d")."' WHERE `tb_damaged`.`id_damaged` = $id_damaged;";
        
       $result = $connectdb->query($sql);

              // $connectdb = connectdb();
              // $sql = "UPDATE `tb_housing` SET   `status` = '1', `idcard` = NULL     WHERE `tb_housing`.`id` = $id_housing;";
            
              // $result = $connectdb->query($sql);
              $pins[1]="active";
              $tables  = tables();
              
              require_once("list_damaged.html");
            }
            break;
            case 'list':
     if(isset($_POST["pni"]) && !empty($_POST["pni"])){
        $pni = ($_POST["pni"]-1)*10;
       
      $tables  = tables($pni);
     
       $pins[$_POST["pni"]]="active";
      require_once("list_damaged.html");
     }else{
        echo ERR4;
     }
            break;
        
           
            case 'add':
              
            //   print_r($_POST);
            //     die();
             
             
                $id_housing=ckstring("id_housing",'id_housing ไม่ควรเว้นว่าง' );
                $date=ckstring("date",'date ไม่ควรเว้นว่าง' );
            
                $lists=ckstring("lists",'lists ไม่ควรเว้นว่าง' );
          
             if(   $id_housing==false || $date==false || $lists==false  ){
             
                $err['id_housing']= @ID_HOUSING;
                $err['date']= @DATE;
                  $err['lists']= @LISTS;
               
 
                require_once("add_damaged.html");
                die();
             }   
          
 
                    $connectdb = connectdb();
                    $sql = "INSERT INTO `tb_damaged` (`dam_id`,`list`, `id_housing`, `date` ) VALUES (NULL,  '$lists', '$id_housing', '$date' );";
                    //  echo $sql;
                    //  die();
        if ($connectdb->query($sql) === TRUE) {
     
                        // echo "<h3 class='alert alert-success'>เพิ่มข้อมูลสิทธิ์ เรียบร้อย คลิ๊ก!! รายการสิทธิ์ เพื่อเรียกดู</h3>";
                        // $connectdb = connectdb();
                        
                        // $sql = "UPDATE `tb_housing` SET   `status` = '3'  , `idcard` = '$idcard'   WHERE `tb_housing`.`id` = $id_housing;";
                        // echo ($connectdb->query($sql) === TRUE ? "<h3 class='alert alert-success'>เพิ่มข้อมูล เรียบร้อย คลิ๊ก!! รายการ  เพื่อเรียกดู</h3>"."<h3 class='alert alert-success'>เพิ่มไปยัง damagedin</h3>" : "<h3 class='alert alert-warning'>เพิ่มข้อมูล เรียบร้อย ! ขอมูล damagedinมีปัณหา</h3>" );
                     
                        require_once("add_damaged.html"); 
                    
                        // require_once("list_damaged.html");
                    } else {
                        
                        //  $mession=  "<br> <h5>Error: " . $sql . "<br>" . $conn->error . '</h5>';
                         echo  ERR4;
                         echo  "<h5 class='alert alert-danger'>ไม่สามารถเพิ่มข้อมูลได้</h5>";
                         require_once("add_damaged.html");
    }
         
         
            break;
            case 'edit':
                $dam_id=ckstring("dam_id" ,'dam_id ไม่ควรเว้นว่าง' );
                $id_housing=ckstring("id_housing",'id_housing ไม่ควรเว้นว่าง' );
                $date=ckstring("date",'date ไม่ควรเว้นว่าง' );
            
                $lists=ckstring("lists",'lists ไม่ควรเว้นว่าง' );
      
          
                // $damagedImage=ckstring("damagedImage",'รูปภาพไม่สมบูรณ์ กรุณา เลือกภาพอีกครัง' );
                if($dam_id==false ||   $id_housing==false || $date==false || $lists==false  ){
                    $err['$dam_id']= @ID_damaged;
                    $err['id_housing']= @ID_HOUSING;
                    $err['date']= @DATE;
                      $err['lists']= @LISTS;
                    
     
                //  $err['damagedImage']= @damagedIMAGE;
                require_once("edit_damaged.html");
                die();
             }   
           
 
                 
                    $connectdb = connectdb();
  $sql = "UPDATE `tb_damaged` SET  `id_housing` = '$id_housing', `date` = '$date', `list` = '$lists' WHERE `tb_damaged`.`dam_id` = $dam_id;";
                     
        if ($connectdb->query($sql) === TRUE) {
           
                        echo "<h3 class='alert alert-success'>แก้ข้อมูลสิทธิ์ เรียบร้อย คลิ๊ก!! รายการสิทธิ์ เพื่อเรียกดู</h3>";
                        require_once("edit_damaged.html"); 
                    
                    } else {
                       echo  $sql;
                        die();
                         $mession=  "<br> <h5>Error: " . $sql . "<br>" . $conn->error . '</h5>';
                         echo  ERR4;
                         require_once("edit_damaged.html");
    }  
                require_once("edit_damaged.html");
            break;
                 case 'del':
                
            
                $id=ckstring("id" ,'รหัส ไม่ควรเว้นว่าง' );
                 
             
             
               
                    $connectdb = connectdb();
                    $sql = "DELETE FROM tb_damaged where dam_id='$id' ";
                     
        if ($connectdb->query($sql) === TRUE) {
            // $damageds ="";
            // $showname="";
                        echo "<h3 class='alert alert-success'>ลบ สิทธิ์ เรียบร้อย  </h3>";
                        $pins[1]="active";
        $tables  = tables();
       
     
        
        
        require_once("list_damaged.html");
                        die();
                        // require_once("list_damaged.html");
                    } else {
                        
                         $mession=  "<br> <h5>Error: " . $sql . "<br>" . $conn->error . '</h5>';
                         echo  ERR4;
                         require_once("lise_damaged.html");
    }  
                require_once("list_damaged.html");
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
        
        require_once("list_damaged.html");
    break;
    case 'view':
       
            if(isset($_GET["id"]) && !empty($_GET["id"])){
                $vals=$_GET["id"];
                $connectdb = connectdb();
             $sql = "SELECT * FROM tb_damaged where id_damaged = $vals";
             $result = $connectdb->query($sql);
             if ($result->num_rows > 0) {
                 $row = $result->fetch_assoc();
                 $id_damaged = $row["id_damaged"];
                
                 $idcard = $row["idcard"];  
                 $id_housing = $row["id_housing"];
                 $date = $row["date"];
                 $id_log = $row["id_log"];
               
                  
 
               
             }
            require_once("view_damaged.html");
        }else{
          echo  ERR4;
        }
       
        break;
    case 'add':
  
    require_once("add_damaged.html");
    break;
    case 'edit':
      $housingrow[1]="ประทวน";
      $housingrow[2]="สัญญาบัตร";
        if(isset($_GET["vals"]) && !empty($_GET["vals"])){
               $vals=$_GET["vals"];
               $connectdb = connectdb();
            $sql = "SELECT *  FROM tb_damaged inner join tb_housing on tb_housing.id = tb_damaged.id_housing where dam_id = $vals";
            $result = $connectdb->query($sql);
          // echo $sql;
          //   die();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id_damaged = $row["dam_id"];
                
       
                $id_housing = $row["id_housing"];
                $noroom = $row["noroom"];
              $dhousingrow = $row["housingrow"];
              $lists = $row["list"];
                $date = $row["date"];
                $lists = $row["list"];
                $status = $row["status"];
              
            }
            require_once("edit_damaged.html");
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