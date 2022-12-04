<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update'])){

    $upt_name = mysqli_real_escape_string($conn, $_POST['name']);
    $upt_email = mysqli_real_escape_string($conn, $_POST['email']);
    $upt_address = mysqli_real_escape_string($conn, $_POST['address']);
    $upt_number = mysqli_real_escape_string($conn, $_POST['number']);
    $upt_dateOfBirth = mysqli_real_escape_string($conn, $_POST['dateOfBirth']);
    $upt_favGenre = mysqli_real_escape_string($conn, $_POST['favoriteGenre']);
 
    mysqli_query($conn, "UPDATE `users` SET name = '$upt_name', email = '$upt_email' WHERE user_id = '$user_id'") or die('query failed');

    mysqli_query($conn, "UPDATE `profile` SET address = '$upt_address', number = '$upt_number', date_of_birth = '$upt_dateOfBirth', favorite_genre = '$upt_favGenre' WHERE user_id = '$user_id'") or die('query failed');
    
    //update session
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){

        $row = mysqli_fetch_assoc($select_users);

        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];
    } else {
        $message[] = 'gagal';
    }

    $message[] = 'update successfully!';
    header('location:profile.php');
}

if(isset($_POST['updatepass'])){

   $oldpass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $newpass = mysqli_real_escape_string($conn, md5($_POST['newpassword']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_id = '$user_id' AND password = '$oldpass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
        mysqli_query($conn, "UPDATE `users` SET password = '$newpass' WHERE user_id = '$user_id' ");
        $message[] = 'update successfully!';
        header('location:profile.php'); 

   }else{
        $message[] = 'incorrect email or password!';
   }
 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>

    <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>halo, <?php echo $_SESSION['user_name']; ?></h3>
        <p> <a href="home.php">home</a> / profil </p>
    </div>

    <section class="profile">

        <?php  
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_id = '$user_id' ") or die('query failed');
            $select_profile = mysqli_query($conn, "SELECT * FROM `profile` WHERE user_id = '$user_id' ") or die('query failed');
            if(mysqli_num_rows($select_users) > 0){
                $fetch_users = mysqli_fetch_assoc($select_users);
                $fetch_profile = mysqli_fetch_assoc($select_profile);
        ?>
        <form action="" method="post">
            <h3>Profil</h3>
            <div class="flex">
                <div class="inputBox">
                    <span>Nama :</span>
                    <input type="text" name="name" value="<?php echo $_SESSION['user_name']; ?>">
                </div>
                <div class="inputBox">
                    <span>Email :</span>
                    <input type="text" name="email" value="<?php echo $_SESSION['user_email']; ?>">
                </div>
                <div class="inputBox">
                    <span>Alamat :</span>
                    <input type="text" name="address" value="<?php echo $fetch_profile['address']; ?>" placeholder="masukkan alamat Anda">
                </div>
                <div class="inputBox">
                    <span>Nomor Telepon :</span>
                    <input type="text" name="number" value="<?php echo $fetch_profile['number']; ?>" placeholder="masukkan nomor telepon Anda">
                </div>
                <div class="inputBox">
                    <span>Tanggal Lahir :</span>
                    <input type="date" name="dateOfBirth" value="<?php echo $fetch_profile['date_of_birth']; ?>" placeholder="masukkan tanggal lahir Anda">
                </div>
                <div class="inputBox">
                    <span>Genre Kesukaan :</span>
                    <input type="text" name="favoriteGenre" value="<?php echo $fetch_profile['favorite_genre']; ?>" placeholder="masukkan genre kesukaan Anda">
                </div>
            </div>
            <input type="submit" value="update" class="btn" name="update">
        </form>
        <?php } ?>
    </section>

    <section class="profile">
        <form action="" method="post">
            <h3>Ganti Kata Sandi</h3>
            <div class="flex">
                <div class="inputBox">
                    <span>Password Lama :</span>
                    <input type="password" name="password" placeholder="masukkan password lama Anda" required class="box">
                </div>
                <div class="inputBox">
                    <span>Password Baru :</span>
                    <input type="password" name="newpassword" placeholder="masukkan password baru Anda" required class="box">
                </div>
            </div>
            <input type="submit" name="updatepass" value="ganti kata sandi" class="btn">
        </form>
    </section>

    <section class="logout">
        <a href="logout.php" class="delete-btn">logout</a>
    </section>

    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
        
</body>
</html>