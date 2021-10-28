<?php
session_start();

function is_connected(){
if (session_status() === PHP_SESSION_NONE){
   session_start();
}
$user = $_SESSION['email'] ?? null;
if($user === null) {
   return null;
}
 include("connect.php");
 $sel=$conn->prepare("select * from account where email=?");
 $sel->execute(array($user));
 $tab=$sel->fetch();
 return $user ?: null;
}

  function valid_inputs($inputs){
        $inputs = trim($inputs);
        $inputs = stripslashes($inputs);
        $inputs = htmlspecialchars($inputs);
        $inputs = strip_tags($inputs);
        return $inputs;
  }

if (isset($_POST['email'])){
   include("connect.php");
   $email=valid_inputs($_POST["email"]);
   $password= valid_inputs($_POST['password']);
   $sel=$conn->prepare("select * from account where email=?");
   $sel->execute(array($email));
   $tab=$sel->fetch();
   
   $is_password_correct = password_verify($_POST['password'], $tab['password']);
   if($tab && $is_password_correct){
         $_SESSION['user_id'] = $tab['user_id'];
         $_SESSION['email']= $tab['email'];
         $_SESSION['role']=$tab['role'];
    
         header("location:home.php");
         exit();

   }else{
      $erreur = "Wrong email or password.";
      }
}

?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <link rel="stylesheet" href="./login.css" />
   </head>
   <body>

<form class="box" action="" method="post" name="login">
<h1 class="box-logo box-title">
      <img src="./logo.jpg" alt="hypertext markup language" height="80" width="300" />
   </a>
</h1>
<h1 class="box-title">M1 Informatique - Sécurité des systèmes d'informations</h1>
<input type="email" class="box-input" name="email" placeholder="Email" required>
<input type="password" class="box-input" name="password" placeholder="Password" required>
<input type="submit" value="Connexion" name="submit" class="box-button">
<?php if (! empty($erreur)) { ?>
    <p class="errorMessage"><?php echo $erreur; ?></p>
<?php } ?>

<?php
   if(!empty($_SESSION['message'])){
      echo '<p class="sucessMessage">'. $_SESSION['message'].' </p>';
          $_SESSION['message'] = "";
   }
?>
<p><button style="  border-radius: 5px;background: #0000FF;text-align: center; cursor: pointer; font-size: 19px; width: 100%; height: 51px; padding: 0; color: #fff; border: 0; outline:0;" onclick="window.location.href = 'inscription.php';"> Add account </button></p>

<input style="  border-radius: 5px;background: #FF4500;text-align: center; cursor: pointer; font-size: 19px; width: 100%; height: 51px; padding: 0; color: #fff; border: 0; outline:0;" type="reset" value="Reset">

</form>
</body>
</html>