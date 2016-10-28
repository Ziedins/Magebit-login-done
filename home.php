<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';

if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }
 //


if (isset($_POST['atrBtn'])) {



    $atribute = trim($_POST['new-info']);
    $atribute = strip_tags($atribute);
    $atribute = htmlspecialchars($atribute);

    $info = trim($_POST['info']);
    $info = strip_tags($info);
    $info = htmlspecialchars($info);



                $query = "CREATE TABLE IF NOT EXISTS `$atribute` (
                          atributeId int(11)  NOT NULL ,
                          information varchar(50) NOT NULL, 
                          PRIMARY KEY  (atributeId)
                          )";
                          
                $res = mysql_query($query);
              


$Id=$_SESSION['user'];

$query = "INSERT INTO $atribute(atributeId,information) VALUES('$Id','$info')";
$res = mysql_query($query);


if ($res) {
            unset($atribute);
            unset($info) ;
}
}
//


 $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysql_fetch_array($res);
$res=mysql_query("SHOW ALL TABLES");
$thetables=mysql_query($res);


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['userEmail']; ?></title>


</head>
<body>


     &nbsp;Hi <?php echo $userRow['userEmail']; ?>&nbsp;        
      <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" autocomplete="off">
     <input type="text" name="new-info" placeholder="additional attribute" maxlength="20">
    <input type="text" name="info" placeholder="additional attribute info" maxlength="50">

    <button type="post"  name="atrBtn">submit additional atribute</button>
    </form>
    &nbsp;All tables <?php echo $thetables;  ?>&nbsp;    


                <a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a>
              
    
</body>
</html>
<?php ob_end_flush(); ?>