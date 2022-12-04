<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = 'user';

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'pengguna sudah terdaftar!';
   }else{
      if($pass != $cpass){
         $message[] = 'konfirmasi password tidak cocok!';
      }else{
<<<<<<< HEAD
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'berhasil daftar!';
         header('location:login.php');
=======
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type') ") or die('query failed');
         
         $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'");
         
         if(mysqli_num_rows($select_users) > 0){
            $fetch_users = mysqli_fetch_assoc($select_users);
            $user_id = $fetch_users['id'];

            mysqli_query($conn, "INSERT INTO `profile` (user_id) VALUES('$user_id')");
            header('location:login.php');
         }
>>>>>>> a80b40117b69f74f04a8ae561ca0f40fadac66a1
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
<<<<<<< HEAD
      <h3>daftar sekarang</h3>
      <input type="text" name="name" placeholder="masukkan nama anda" required class="box">
      <input type="email" name="email" placeholder="masukkan email anda" required class="box">
      <input type="password" name="password" placeholder="masukan kata sandi" required class="box">
      <input type="password" name="cpassword" placeholder="konfirmasi kata sandi" required class="box">
=======
      <h3>register now</h3>
      <input type="text" name="name" placeholder="enter your name" required class="box">
      <input type="email" name="email" placeholder="enter your email" required class="box">
      <input type="password" name="password" placeholder="enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="confirm your password" required class="box">
>>>>>>> a80b40117b69f74f04a8ae561ca0f40fadac66a1
      <!-- <select name="user_type" class="box">
         <option value="user">user</option>
         <option value="admin">admin</option>
      </select> -->
<<<<<<< HEAD
      <input type="submit" name="submit" value="daftar" class="btn">
      <p>sudah punya akun? <a href="login.php">masuk</a></p>
=======
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
>>>>>>> a80b40117b69f74f04a8ae561ca0f40fadac66a1
   </form>

</div>

</body>
</html>