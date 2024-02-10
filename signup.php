<?php

include 'config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $id=$_SESSION['user_id'];
 } else {
    $id = 0;
 }

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $num = mysqli_real_escape_string($conn, $_POST['num']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

   $select=mysqli_query($conn,"SELECT *FROM user_info WHERE email='$email' and epassword='$pass'");

   if(mysqli_num_rows($select)>0){
    $message[]='user already exist';
   }
   else{
    if($pass!=$cpass){
        $message[]='confirm password not match';
    }
    else{
        $insert=mysqli_query($conn,"INSERT INTO user_info(name,email,number,epassword) VALUES('$name','$email','$num','$pass')")or die('query failed');

        if($insert){
            $ses=mysqli_query($conn,"SELECT *FROM user_info WHERE email='$email' and epassword='$pass'");
            if(mysqli_num_rows($ses)>0){
                $row=mysqli_fetch_assoc($ses);
                $_SESSION['user_id'] = $row['uId'];
                header('Location:index.php');
               }
               
           

        }
        else{
            $message[]='error';
        }
    }
   }
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign</title>
       <!-- linking fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
     <!-- linking style sheets -->
    <link rel="stylesheet" href="style.css">
    <!-- linking style sheets -->
     <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- ------------------HEADER----------------------- -->
<?php  include 'header.php'; ?>
      
    <!-- sign form -->
    <div class="sign-form-container">
        <div id="" class="signdiv"></div>
        <form action="" method="POST" enctype="multipart/form-data">

            <h3>Sign Up</h3>

            <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
            <span>Name</span>
            <input type="text" name="name" class="box" style="text-transform: none" placeholder="User name" id="" required>
            <span>Email</span>
            <input type="email" name="email" class="box" style="text-transform: none" placeholder="Enter your email" id="" required>
            <span>Mobile Number</span>
            <input type="number" name="num" class="box" style="text-transform: none" placeholder="Phone number" id="" required>
            <span>Password</span>
            <input type="password" name="password" class="box" style="text-transform: none" placeholder="Enter your password" id="" required>
            <span>Confirm Password</span>
            <input type="password" name="cpassword" class="box"  style="text-transform: none" placeholder="Enter your password" id="" required>
             
            <input type="submit" name="submit" value="sign in" class="btn" >
            <p>home page? <a href="index.php">Click here</a></p>
             
        </form>
    </div>

<!-- -----------------------------footer---------------------- -->
<?php  include 'footer.php'; ?>
<!-- footer section ends -->   
    
</body>
</html>