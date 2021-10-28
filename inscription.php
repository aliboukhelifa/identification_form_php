<?php

session_start();

date_default_timezone_set('Europe/Paris');

  function valid_inputs($inputs){
        $inputs = trim($inputs);
        $inputs = stripslashes($inputs);
        $inputs = htmlspecialchars($inputs);
        $inputs = strip_tags($inputs);
        return $inputs;
  }

if($_POST){
     if(isset($_POST['email']) && !empty($_POST['email']) &&
     isset($_POST['password']) && !empty($_POST['password'])){

    require_once('./connect.php');

    $email = valid_inputs($_POST['email']);
    $password = valid_inputs($_POST['password']);
    $created_on = date('Y-m-d H:i:s');
    $pass_hache = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM account WHERE email=?");
    $stmt->execute([$email]); 
    $user = $stmt->fetch();
    if ($user || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['erreur'] = 'User already exist. Try with another email';
    } else {

    $query = $conn->prepare('INSERT INTO account(email, password, created_on) VALUES(:email, :password, :created_on);');
    
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':password', $pass_hache, PDO::PARAM_STR);
    $query->bindValue(':created_on', $created_on, PDO::PARAM_STR);
    $query->execute();

    $_SESSION['message'] = "User added";
    header('Location: login.php');

  }
  }else{
    $_SESSION['erreur'] = 'Incomplete form';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<link rel="shortcut icon" href="icon.ico" type="image/vnd.microsoft.icon" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="title" content="Ali's Identification">
<title>Ali's Identification</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>       
<main role="main">
<div id="main" class="layout-main clearfix">
  <div id= "content" class="column main-content" role= "main">
      <section class="container">

        <?php
          if(!empty($_SESSION['erreur'])){
            echo '<div class="alert alert-danger" role="alert">'. $_SESSION['erreur'].' </div>';
            $_SESSION['erreur'] = "";
          }
        ?>

        <h1>Add Account</h1>
        <form method="post">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" 
            title="Invalid email address, must be lowercase" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>                               
            <input type="password" name="password" id="password"class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
          </div>
          <button class="btn btn-primary">Submit</button>
        </form>
        
      </section>
    </div>
  </main>
<footer>
</footer>
</body>
</html>
