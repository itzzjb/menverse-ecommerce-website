<?php 
     include 'config.php';
     session_start();
      
     if(isset($_SESSION['user_id'])){
      $id=$_SESSION['user_id'];
   } else {
      $id = 0;
   }
   
     if(isset($_POST['submit'])){

        
        $lemail = mysqli_real_escape_string($conn, $_POST['lemail']);
        $lpass = mysqli_real_escape_string($conn, md5($_POST['lpass']));
        
     
        $choose=mysqli_query($conn,"SELECT *FROM user_info WHERE email='$lemail' and epassword ='$lpass'");
     
        if(mysqli_num_rows($choose)>0){
            
         $row=mysqli_fetch_assoc($choose);
         $_SESSION['user_id'] = $row['uId'];
         header('Location:index.php');
        }
        else{
            $message[]='user input not match';
            // header('Location:login.php');
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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

<div class="sign-form-container">
        

        <?php
          if(isset($_SESSION['user_id'])){
            $id=$_SESSION['user_id'];
            $choose=mysqli_query($conn,"SELECT *FROM user_info WHERE uId='$id'");
            $row=mysqli_fetch_assoc($choose);
            echo'<div class="logbox">
            <h style="font-size: 25px; font-weight: 1000;">Profile</h>  
            <span style="text-transform: none" >'.$row['name'].'</span>
            <span style="text-transform: none" >'.$row['email'].'</span>
            <span style="text-transform: none" >0'.$row['number'].'</span>
            <a href="index.php?logout" class="btn">logout</a>
            </div>
            ';
          }
          else{
            echo ' <form action=""  method="POST" enctype="multipart/form-data">
                                         
                   <h3>Login</h3>;';

                   
                   if(isset($message)){
                    foreach($message as $message){
                       echo '<div class="message">'.$message.'</div>';
                    }
                 }
                 
                 echo '
                      <span>Email</span>
                      <input type="email" name="lemail" class="box" style="text-transform: none"placeholder="Enter your email"  required>
                      <span>Password</span>
                      <input type="password" name="lpass" class="box" style="text-transform: none" placeholder="Enter your password" required>
                      <input type="submit" name="submit" value="login" class="btn" >   
                      <p>Do not have an account? <a href="signup.php">Create</a></p>
                    </form>';

                

              }
        ?>
               
    </div>

<!-- -----------------------------footer---------------------- -->
 <?php  include 'footer.php'; ?>
<!-- footer section ends -->


    
</body>
</html>