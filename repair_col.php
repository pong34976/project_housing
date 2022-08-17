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
  
 function tbdamaged($limit = 0,$max=10){
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
  
    $sql = " SELECT *,tb_damaged.dam_id as damid   FROM `tb_damaged` left join `tb_housing`  on  tb_damaged .id_housing =  tb_housing .id left join `tb_repair` on `tb_repair`.dam_id=`tb_damaged`.dam_id WHERE repair_id IS   NULL";
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
      
 
      <button type="button" name="id" value="'.$row["damid"].'"  data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="$(\'#myid\').val(\''.$row["damid"].'\'); $(\'#list\').val(\''.$row["list"].'\');"  class="btn  btn-warning ">ส่งซ่อม</button>
      </form> </div>
      </td>
    </tr>'.$tables;
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
 
    require_once("config.php");
    $connectdb = connectdb();
    if ($connectdb->connect_error) {
        die("Connection failed: " . $connectdb->connect_error);
      }
      $tables = "";
      $sql = "SELECT *  FROM tb_damaged";
  
      $result = $connectdb->query($sql);
      if ($result->num_rows > 0) {
      
          // $numrows = $result->fetch_assoc();
        // output data of each row <button type="button" class="col-1 btn btn-success bi-house-fill"></button>
      //    <td>'.ckdate($row["birthdate"],true).'</td>
        while($row = $result->fetch_assoc()) {
            // $tables  = $tables . ' <option value="'.$row["id"].'">'.$row["noroom"].' </option>';
            //   <button type="button" class="col-1 btn btn-success btn-lg m-1"><span class=" p-0 m-0 bi-house-fill  btn-lg" ></span>sss </button> 
  $tables  = $tables . ' <button  type="button" value="'.$row["id_housing"].' </button>';
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
    $sql = "SELECT *  FROM tb_repair ";
    $result = $connectdb->query($sql);
       define("NOMROW",($result->num_rows/10)+1);
       define("NOMROWS",$result->num_rows );
  
    $sql = "SELECT  repair_id,tb_repair.dam_id as dam_id,tb_repair.date_re as date,tb_damaged.list as lists,tb_damaged.id_housing as id_housing,repair_date, noroom,housingrow,price  FROM `tb_repair`left join tb_damaged on tb_repair.dam_id = tb_damaged.dam_id  left join `tb_housing` on `tb_damaged`.id_housing = `tb_housing`.id";
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
          <td> '.$row["repair_id"].'</td>
      <td>'.$row["date"].'</td>
      <td>'.$row["noroom"].':'.$row["lists"].'</td>
     
      <td>'.$row["price"].'</td>
      <td>    
      
    <a  href="?view=edit&vals='.$row["repair_id"].'&page=repair" class=" btn btn-warning   ">แก้ไข</a>
      <button type="button" name="id" value="'.$row["repair_id"].'"  data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="$(\'#myid\').val(\''.$row["repair_id"].'\'); "  class="btn  btn-danger  ">ลบ</button>
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
                // endpage();
                return $err;
            }
          
           return $texts;
        }

        switch ($_GET['view']) {
          case 'repairout':
            if(isset($_POST["id_repair"]) && !empty($_POST["id_repair"])){
       $id_housing = $_POST["id_housing"];
       $id_repair = $_POST["id_repair"];
       $connectdb = connectdb();
       $sql = "UPDATE `tb_repair` SET  `repairout` = '1', `repairout_date` = '".date("Y-m-d")."' WHERE `tb_repair`.`id_repair` = $id_repair;";
        
       $result = $connectdb->query($sql);

              $connectdb = connectdb();
              $sql = "UPDATE `tb_housing` SET   `status` = '1', `idcard` = NULL     WHERE `tb_housing`.`id` = $id_housing;";
            
              $result = $connectdb->query($sql);
              $pins[1]="active";
              $tables  = tables();
              
              require_once("list_repair.html");
            }
            break;
            case 'list':
     if(isset($_POST["pni"]) && !empty($_POST["pni"])){
        $pni = ($_POST["pni"]-1)*10;
       
      $tables  = tables($pni);
     
       $pins[$_POST["pni"]]="active";
      require_once("list_repair.html");
     }else{
        echo ERR4;
     }
            break;
        
           
            case 'add':
           
            //   print_r($_POST);
            //     endpage();
             
             
            $dam_id=ckstring("dam_id",'dam_id ไม่ควรเว้นว่าง' );
            $date_re=ckstring("date_re",'date_re ไม่ควรเว้นว่าง' );
        
            $price=ckstring("price",'lists ไม่ควรเว้นว่าง' );
            $list = $_POST["list"];
         if(   $dam_id==false     || $price==false  ){
         
            $err['dam_id']= @ID_HOUSING;
         
              $err['price']= @PRICE; 
           

            require_once("add_repair.html");
            endpage();
         }   
      

                $connectdb = connectdb();
                $sql = "INSERT INTO `tb_repair` (`repair_id`,`dam_id`,`date_re`,`status` ,`price`  ) VALUES (NULL,  '$dam_id','$date_re',0, '$price' );";
                //  echo $sql;
                //  endpage();
                // require("quotation.html"); die();
    if ($connectdb->query($sql) === TRUE) {
      $last_id = $connectdb->insert_id;
      $pad_number = str_pad($last_id, 3, "0", STR_PAD_LEFT);
                    echo "<h3 class='alert alert-success'>เพิ่มข้อมูล  เรียบร้อย คลิ๊ก!! รายการ   </h3>";
                    $connectdb = connectdb();
                    
                   
                  //  header("Location: auth_page.php?view=list&page=repair");
                  // ob_start();
                  // ob_clean();
                  // ob_end_flush();
                  
                  // header( "refresh: 2; url=auth_page.php?view=list&page=repair");
                
                    require("quotation.html");
                } else {
                    
                    //  $mession=  "<br> <h5>Error: " . $sql . "<br>" . $conn->error . '</h5>';
                     echo  ERR4;
                     echo  "<h5 class='alert alert-danger'>ไม่สามารถเพิ่มข้อมูลได้</h5>";
                     require_once("add_repair.html");
}
     
     
           
            break;
            case 'edit':
                 $repair_id=ckstring("repair_id" ,'repair_id ไม่ควรเว้นว่าง' );
                $dam_id=ckstring("dam_id" ,'dam_id ไม่ควรเว้นว่าง' );
            
                $date_re=ckstring("date_re",'date_re ไม่ควรเว้นว่าง' );
            
                $price=ckstring("price",'price ไม่ควรเว้นว่าง' );
          
                // $repairImage=ckstring("repairImage",'รูปภาพไม่สมบูรณ์ กรุณา เลือกภาพอีกครัง' );
                if($repair_id==false  ||   $dam_id==false || $date_re==false || $price==false  ){
                  
                  $err['$repair_id']= @REPAIR_ID;
                      $err['$dam_id']= @DAM_ID; 
                    // $err['id_housing']= @ID_HOUSING;
                    $err['date_re']= @DATE_RE;
                        $err['price']= @PRICE;
                    
                    
      
                require_once("edit_repair.html");
                endpage();
             }   
           
 
                 
                    $connectdb = connectdb();
  $sql = "UPDATE `tb_repair` SET  `dam_id` = '$dam_id', `date_re` = '$date_re', `price` = '$price' WHERE `tb_repair`.`repair_id` = $repair_id;";
                     
        if ($connectdb->query($sql) === TRUE) {
           
                        echo "<h3 class='alert alert-success'>แก้ข้อมูล  เรียบร้อย  </h3>";
                        ob_start();
                        ob_clean();
                        ob_end_flush();
                        
                        header( "refresh: 1; url=auth_page.php?view=list&page=repair");
                    } else {
                       echo  $sql;
                       endpage();
                         $mession=  "<br> <h5>Error: " . $sql . "<br>" . $conn->error . '</h5>';
                         echo  ERR4;
                         require_once("edit_repair.html");
    }  
                require_once("edit_repair.html");
            break;
                 case 'del':
                
            
                $id=ckstring("id" ,'รหัส ไม่ควรเว้นว่าง' );
                 
             
             
               
                    $connectdb = connectdb();
                    $sql = "DELETE FROM tb_repair where repair_id='$id' ";
                     
        if ($connectdb->query($sql) === TRUE) {
            // $repairs ="";
            // $showname="";
                        echo "<h3 class='alert alert-success'>ลบ สิทธิ์ เรียบร้อย  </h3>";
                        $pins[1]="active";
        $tables  = tables();
       
     
        
        
        require_once("list_repair.html");
                        endpage();
                        // require_once("list_repair.html");
                    } else {
                        
                         $mession=  "<br> <h5>Error: " . $sql . "<br>" . $conn->error . '</h5>';
                         echo  ERR4;
                         require_once("lise_repair.html");
    }  
                require_once("list_repair.html");
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
        
        require_once("list_repair.html");
    break;
    case 'view':
       
            if(isset($_GET["id"]) && !empty($_GET["id"])){
                $vals=$_GET["id"];
                $connectdb = connectdb();
             $sql = "SELECT * FROM tb_repair where id_repair = $vals";
             $result = $connectdb->query($sql);
             if ($result->num_rows > 0) {
                 $row = $result->fetch_assoc();
                 $id_repair = $row["id_repair"];
                
                 $idcard = $row["idcard"];  
                 $id_housing = $row["id_housing"];
                 $date = $row["date"];
                 $id_log = $row["id_log"];
               
                  
 
               
             }
            require_once("view_repair.html");
        }else{
          echo  ERR4;
        }
       
        break;
   
    case 'add':
      $pins[1]="active";
      $tables  = tbdamaged();
    require_once("add_repair.html");
    break;
    case 'edit':
      $housingrow[1]="ประทวน";
      $housingrow[2]="สัญญาบัตร";
        if(isset($_GET["vals"]) && !empty($_GET["vals"])){
               $vals=$_GET["vals"];
               $connectdb = connectdb();
            $sql = "SELECT *  FROM tb_repair   where repair_id = $vals";
            $result = $connectdb->query($sql);
          // echo $sql;
          //   endpage();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $repair_id = $row["repair_id"];
                
       
                $dam_id = $row["dam_id"];
                // $noroom = $row["noroom"];
              $date_re = $row["date_re"];
              $status = $row["status"];
                $price = $row["price"];
               
              
            }
            require_once("edit_repair.html");
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