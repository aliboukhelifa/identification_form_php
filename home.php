<?php 

session_start();
if(!isset($_SESSION["email"])){
  header("Location: login.php");
  exit(); 
}

?>

<!DOCTYPE html>
<html>
   <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
         <title>Welcome</title>
  </head>
  <body>
        <header><button onclick="window.location.href='logout.php';">Log Out</button></header>
        <h1>Congratulation ! You are connected </h1>
  </body>
</html>
