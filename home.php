<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){
   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE book_title = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'produk sudah ada di keranjang!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, book_title, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');

      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE book_title = '$product_name' AND user_id = '$user_id'");

      $fetch_cart = mysqli_fetch_assoc($select_cart);
      $cart_id = $fetch_cart['cart_id'];
      mysqli_query($conn, "INSERT INTO `cart_has_books`(cart_id, user_id) VALUES ('$cart_id', '$user_id')");
      $message[] = 'produk berhasil ditambahkan ke keranjang!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>temukan buku favoritmu disini</h3>
      <p>Cari dan pesan buku favoritmu dengan harga miring hanya di Bukululu</p>
      <a href="about.php" class="white-btn">Selengkapnya</a>
   </div>

</section>

<section class="products">

   <h1 class="title">Rekomendasi Buku</h1>

   <div class="box-container">

      <?php  
         $select_users = mysqli_query($conn, "SELECT * FROM `profile` WHERE user_id = '$user_id'");
         $fetch_users = mysqli_fetch_assoc($select_users);
         $genre = $fetch_users['favorite_genre'];

         $select_products = mysqli_query($conn, "SELECT * FROM `books` WHERE genre LIKE '%{$genre}%' limit 3") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['book_title']; ?></div>
      <div class="name">Penulis : <?php echo $fetch_products['author']; ?></div>
      <div class="name">Genre : <?php echo $fetch_products['genre']; ?></div>
      <div class="price">Rp <?php echo $fetch_products['price']; ?></div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_id" value="<?php echo $fetch_products['book_id']; ?>">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['book_title']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="Tambah ke keranjang" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">tidak ada rekomendasi!</p>';
      }
      ?>
   </div>

   

</section>

<section class="products">

   <h1 class="title">daftar produk</h1>

   <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `books` ") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['book_title']; ?></div>
      <div class="name">Penulis : <?php echo $fetch_products['author']; ?></div>
      <div class="name">Genre : <?php echo $fetch_products['genre']; ?></div>
      <div class="price">Rp <?php echo $fetch_products['price']; ?></div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_id" value="<?php echo $fetch_products['book_id']; ?>">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['book_title']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="Tambah ke keranjang" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">tidak ada produk!</p>';
      }
      ?>
   </div>

   

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>Tentang kami</h3>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
         <a href="about.php" class="btn">baca selengkapnya</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>ada pertanyaan?</h3>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque cumque exercitationem repellendus, amet ullam voluptatibus?</p>
      <a href="contact.php" class="white-btn">Hubungi kami</a>
   </div>

</section>





<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>