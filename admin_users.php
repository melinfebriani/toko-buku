<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE user_id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `profile` WHERE user_id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="users">

   <h1 class="title"> pengguna </h1>

   <div class="box-container">
      <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
         $select_profile = mysqli_query($conn, "SELECT * FROM `profile`") or die('query failed');

         // $fetch_profile = mysqli_fetch_assoc($select_profile);
         while($fetch_users = mysqli_fetch_assoc($select_users) AND $fetch_profile = mysqli_fetch_assoc($select_profile)){
      ?>
      <div class="box">
         <p> user id : <span><?php echo $fetch_users['user_id']; ?></span> </p>
         <p> username : <span><?php echo $fetch_users['name']; ?></span> </p>
         <p> email : <span><?php echo $fetch_users['email']; ?></span> </p>
         <p> alamat : <span><?php echo $fetch_profile['address']; ?></span> </p>
         <p> nomor telepon : <span><?php echo $fetch_profile['number']; ?></span> </p>
         <p> tanggal lahir : <span><?php echo $fetch_profile['date_of_birth']; ?></span> </p>
         <p> genre kesukaan : <span><?php echo $fetch_profile['favorite_genre']; ?></span> </p>
         <p> tipe : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
         <a href="admin_users.php?delete=<?php echo $fetch_users['user_id']; ?>" onclick="return confirm('hapus pengguna ini?');" class="delete-btn">hapus</a>
      </div>
      <?php
         };
      ?>
   </div>

</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>