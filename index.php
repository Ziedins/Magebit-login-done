<?php
ob_start();
session_start();
require_once 'dbconnect.php';


if (isset($_SESSION['user']) != "") {
    header("Location: home.php");
    exit;
}

$error = false;

if (isset($_POST['btn-signup'])) {
    

    $name = trim($_POST['name']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);
    
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    
    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    

    if (empty($name)) {
        $error     = true;
        $nameError = "Please enter your full name.";
    }
    

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error      = true;
        $emailError = "Please enter valid email address.";
    } else {
  
        $query  = "SELECT userEmail FROM users WHERE userEmail='$email'";
        $result = mysql_query($query);
        $count  = mysql_num_rows($result);
        if ($count != 0) {
            $error      = true;
            $emailError = "Provided Email is already in use.";
        }
    }

    if (empty($pass)) {
        $error     = true;
        $passError = "Please enter password.";
    } else if (strlen($pass) < 6) {
        $error     = true;
        $passError = "Password must have atleast 6 characters.";
    }
    

    $password = hash('sha256', $pass);
    

    if (!$error) {
        
        $query = "INSERT INTO users(userName,userEmail,userPass) VALUES('$name','$email','$password')";
        $res   = mysql_query($query);
        
        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            unset($name);
            unset($email);
            unset($pass);
        }
        
    }
    
    
}


if (isset($_POST['btn-login'])) {
    

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    
    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    
    if (empty($email)) {
        $error      = true;
        $emailError = "Please enter your email address.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error      = true;
        $emailError = "Please enter valid email address.";
    }
    
    if (empty($pass)) {
        $error     = true;
        $passError = "Please enter your password.";
    }
    

    if (!$error) {
        
        $password = hash('sha256', $pass); 
        
        $res   = mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
        $row   = mysql_fetch_array($res);
        $count = mysql_num_rows($res); 
        
        if ($count == 1 && $row['userPass'] == $password) {
            $_SESSION['user'] = $row['userId'];
            header("Location: home.php");
        } else {
            $errMSG = "Incorrect Credentials, Try again...";
        }
        
    }
    
}
?>

<!DOCTYPE html>
<html>
   <head>
      <link rel="stylesheet" href="css/reset.css">
      <link rel="stylesheet" href="css/base.css">
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
   </head>
   <body id="body">


      <div id="container">
         <div id='blue-banner'>
            <div id="register-left">
               <h1 class="blue-head">Don't have an account?</h1>
               <div class="blue-line"></div>
               <p>Lorem iposum dolor sit amet, consectetur adisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
               </p>
            </div>
            <div id="register-right">
               <h1 class="blue-head"> Have an account? </h1>
               <div class="blue-line"></div>
               <p>Lorem ipusum dolor sit amet consectetur  adipisicing elit.</p>
               <button id="login-active-button" class="blue-button" onclick="loginActive()" type="button"><b>LOGIN</b></button>
            </div>
            <button id="register-active-button" class="blue-button" onclick="registerActive()" type="button"><b>SIGN UP</b></button>
            <div id="active">
               <div id="fold-top"></div>
               <div id="fold-middle"></div>
               <div id="fold-bottom"></div>
               <div id="white-banner">
                  <div id="login">
                     <div class="white-head" id="login-head">
                        <h1 id="login-header"> Login </h1>
                        <div class ="magebit-picture" id="picture-login"></div>
                        <div class="blue-line" id="login-line"></div>
                     </div>
                     <form method="post" id="form-login" action="" autocomplete="off">
                        <div class="col-md-12">
               
                           <div class="form-input" id="login-form">
                              <span class="input-name">Email</span><span class="star">*</span>
                              <div class="active-image-mail" id="login-email-img"></div>
                              <input type="text" name="email" class="form-control" placeholder="" maxlength="40" />
                           </div>
                       
                           <div class="form-input-below">
                              <span class="input-name">Password</span><span class="star">*</span>
                              <div class="active-image-lock" id="login-pass-img"></div>
                              <input type="password" name="pass" class="form-control" placeholder="" maxlength="15" />
                           </div>
                          
                          
                           <button id="orange-login-button" type="submit" class="orange-button" name="btn-login"><b>LOGIN</b></button>
                           <button type="" class="" id="forgot-button" name="">Forgot?</button>
                           <button type="button" onclick="mobileActive()" class="orange-button-mobile" ><b>Register</b></button>
                        </div>
                     </form>
                  </div>
                  <div id="sign-up">
                     <div class="white-head" id="register-head">
                        <h1 id="signup_header">Sign Up</h1>
                        <div class="magebit-picture" id ="picture-register"></div>
                        <div class="blue-line" id="register-line"></div>
                     </div>
                     <form method="post" id="form-login" action="" autocomplete="off">
         
                        <div class="form-input" >
                           <span class="input-name">Name</span><span class="star">*</span>
                           <div class="active-image-user" id="register-name-img"></div>
                           <input type="text" name="name" class="form-control" placeholder="" maxlength="50" value="<?php echo $name ?>" />
                        </div>
                       
                        <div class="form-input-below">
                           <span class="input-name">Email</span><span class="star">*</span>
                           <div class="active-image-mail" id="register-email-img"></div>
                           <input type="text" name="email" class="form-control" placeholder="" maxlength="40" value="<?php echo $email ?>" />
                        </div>
                      
                        <div class="form-input-below">
                           <span class="input-name">Password</span><span class="star">*</span>
                           <div class="active-image-lock" id="register-pass-img"></div>
                           <input type="password" name="pass" class="form-control" placeholder="" maxlength="15" />
                        </div>
                       
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <button type="submit"  class="orange-button" name="btn-signup"><b>SIGN UP</b></button>
                        <button type="button" onclick="mobileLoginActive()" class="orange-button-mobile" ><b>LOGIN</b></button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <footer>
            <h2><b>ALL RIGHTS RESERVED "MEGEBIT" 2016.<b></h2>
         </footer>
      </div>
   </body>
   <script type='text/javascript' src='script.js'></script>
</html>
<?php ob_end_flush(); ?>
