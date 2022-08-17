<?php
 function tables($limit = 0,$max=10){
  require_once("config.php");
  $connectdb = connectdb();
  if ($connectdb->connect_error) {
      die("Connection failed: " . $connectdb->connect_error);
    }
    $tables = "";
    $sql = "SELECT *  FROM tb_permission";
    $result = $connectdb->query($sql);
    define("NOMROW",($result->num_rows/10)+1);
       define("NOMROWS",$result->num_rows);
    
 
    $limit  = " LIMIT $limit ";
    $max = ",$max";
    
 

   $limitsql = "$limit $max";

    $sql = "SELECT * FROM `tb_permission` $limitsql";
    // echo  $sql ;
    $result = $connectdb->query($sql);
    if ($result->num_rows > 0) {
        // $numrows = $result->fetch_assoc();
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $tables  = '<tr>
      <td>'.$row["pmiss"].'</td>
      <td>'.$row["showname"].'</td>
      <td>
    <a  href="?view=edit&vals='.$row["id"].'&page=pmis" class=" btn btn-warning col-10 m-1 m-sm-0 col-sm-4 ">แก้ไข</a>
      <button name="id" value="'.$row["id"].'"  data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="$(\'#myid\').val(\''.$row["id"].'\');$(\'#myname\').val(\''.$row["pmiss"].'\');$(\'#showname\').val(\''.$row["showname"].'\')"  class="btn  btn-danger col-10  m-1 m-sm-0 col-sm-4 ">ลบ</button>
     <form class="row align-content-center d-block"  action="?view=del&page=pmis" method="post">
      </form>
      </td>
    </tr>'.$tables;
      }
    } else {
      $tables  ="";
     
    }
    return $tables;
}
     
           // ----------------------------เมื่อมีเรียกหน้าเว็บ แต่ไม่มีค่าPOST vvvvvv -------------------------------
switch ($_GET['view']) {
    case 'list':
 
          require("menureport.html");
    break;
    case 'r_login':
      require_once("config.php");
      $connectdb = connectdb();
      if ($connectdb->connect_error) {
        die("Connection failed: " . $connectdb->connect_error);
      }
      $tables = "";
      $sql = "SELECT *  FROM tb_login";
      $result = $connectdb->query($sql);
         define("NOMROW",($result->num_rows/10)+1);
         define("NOMROWS",$result->num_rows );
 
      $sql = "SELECT * FROM `tb_login` ";
      // echo  $sql ;
      $result = $connectdb->query($sql);
      $countrow = $result->num_rows;
      if ($result->num_rows > 0) {
        $level[1]="ผู้ดูแลระบบ";
        $level[2]="หัวหน้างาน";
        $level[3]="พนักงาน";
        while($row = $result->fetch_assoc()) {
          $tables  = '<tr>
      <td>'.$row["username"].'</td>
      <td>'.$row["prefix"].' '.$row["rname"].' '.$row["lname"].'</td>
      <td>'.$level[$row["log_level"]].'</td>
      
    </tr>'.$tables;
      }
      }
      require("r_login.html");
break;

case 'r_user':
  require_once("config.php");
  $connectdb = connectdb();
  if ($connectdb->connect_error) {
    die("Connection failed: " . $connectdb->connect_error);
  }
  $tables = "";
  $sql = "SELECT *  FROM tb_user";
  $result = $connectdb->query($sql);
     define("NOMROW",($result->num_rows/10)+1);
     define("NOMROWS",$result->num_rows );

  $sql = "SELECT * FROM `tb_user` ";
  // echo  $sql ;
  $result = $connectdb->query($sql);
  $countrow = $result->num_rows;
  if ($result->num_rows > 0) {
 
    while($row = $result->fetch_assoc()) {
      $tables  = '<tr>
      <td>'.$row["idcard"].'</td> 
 
  <td>'.$row["prefix"].' '.$row["rname"].' '.$row["lname"].'</td>
  <td>'. $row["sex"] .'</td>
  <td>'. $row["birthdate"] .'</td>
  <td>'. $row["email"] .'</td>
  <td>'. $row["phones"] .'</td>
</tr>'.$tables;
  }
  }
  require("r_user.html");
break;

case 'r_housing':
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

  $sql = "SELECT * FROM `tb_housing` ";
  // echo  $sql ;
  $result = $connectdb->query($sql);
  $countrow = $result->num_rows;
  if ($result->num_rows > 0) {
 
    while($row = $result->fetch_assoc()) {
      $tables  = '<tr>
      <td>'.$row["noroom"].'</td> 
 
  <td>'.$row["housingrow"].'</td>
  <td>'. $row["building"] .'</td>
  <td>'. $row["status"] .'</td>
   
</tr>'.$tables;
  }
  }
  require("r_housing.html");
break;


case 'r_check':
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
  $countrow = $result->num_rows;
  if ($result->num_rows > 0) {
 
    while($row = $result->fetch_assoc()) {
      $tables  = '<tr>
      <td> '. $row["id_check"] .'</td>
      <td> '. $row["datecheck"] .'</td>
      <td> '. $row["dateout"] .'</td>
  <td>'.$row["prefix"].' '.$row["rname"].' '.$row["lname"].'</td>
<td>'.$row["noroom"].'</td>
   
</tr>'.$tables;
  }
  }
  require("r_check.html");
break;
case 'r_damaged':
  require_once("config.php");
  $connectdb = connectdb();
  if ($connectdb->connect_error) {
    die("Connection failed: " . $connectdb->connect_error);
  }
  $tables = "";
  $sql = "SELECT *  FROM tb_damaged";
  $result = $connectdb->query($sql);
     define("NOMROW",($result->num_rows/10)+1);
     define("NOMROWS",$result->num_rows );

  $sql = "SELECT * FROM `tb_damaged` ";
  // echo  $sql ;
  $result = $connectdb->query($sql);
  $countrow = $result->num_rows;
  if ($result->num_rows > 0) {
 
    while($row = $result->fetch_assoc()) {
      $tables  = '<tr>
      <td>'.$row["dam_id"].'</td> 
   <td>'.$row["id_housing"].'</td>
     <td>'.$row["list"].'</td>
  <td>'.$row["date"].'</td>
  <td>'. $row["repair_status"] .'</td>
  <td>'. $row["repair_date"] .'</td>
   
</tr>'.$tables;
  }
  }
  require("r_damaged.html");
break;

case 'r_repair':
  require_once("config.php");
  $connectdb = connectdb();
  if ($connectdb->connect_error) {
    die("Connection failed: " . $connectdb->connect_error);
  }
  $tables = "";
  

  $sql = "SELECT  repair_id,tb_repair.dam_id as dam_id,DATE_FORMAT(tb_repair.date_re,'%Y/%m/%d')  as date,tb_damaged.list as lists,tb_damaged.id_housing as id_housing,repair_date, noroom,housingrow,price  FROM `tb_repair`left join tb_damaged on tb_repair.dam_id = tb_damaged.dam_id  left join `tb_housing` on `tb_damaged`.id_housing = `tb_housing`.id";
  // echo  $sql ;
  $result = $connectdb->query($sql);
  $countrow = $result->num_rows;
  if ($result->num_rows > 0) {
 
    while($row = $result->fetch_assoc()) {
      $tables  = '<tr>
      <td> '.$row["repair_id"].'</td>
      <td>'.$row["date"].'</td>
      <td>'.$row["noroom"].':'.$row["lists"].'</td>
     
      <td>'.$row["price"].'</td>
 
   
</tr>'.$tables;
  }
  }
  require("r_repair.html");
break;
    default:
    echo  ERR4; 
        break;
}
 
 
?>