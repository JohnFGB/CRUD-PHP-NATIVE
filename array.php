<?php 

session_start();

if(!isset($_SESSION["login"])){
  header("Location: log/register.php");
  exit;
}

require 'functions.php';

$barang = query("SELECT * FROM baju");

if ( isset($_POST["cari"]) ) {
  $barang = cari( $_POST ["keyword"] );
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- LINK CSS -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="shortcut icon" href="../favicon.png" />
    <!-- LINK UNTUK ICON TAMBAHAN -->
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />

    <!-- LINK GOOGLE FONTS (MENAMBAHKAN FONT BARU) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <title>ShopeeFy | Shopping Cart</title>
  </head>
  <body>
    <!-- HEADER -->
    <header>
      <!-- NAVBAR -->
      <div class="nav container">
        <a href="#" class="logo">ShopeeFy</a>
        <!-- NAVBAR -->
        <ul class="navbar">
          <form action="" method="post">
           <input type="text" name="keyword" placeholder="Search..." size="10px" autofocus autocomplete="off">
           <button type="submit" name="cari" class="btnb">Cari</button>
          </form>
          <a href="tambah.php" class="login nav-link">Tambah Barang</a>
          <i class="bx bx-log-out nav-link"><a href="log/logout.php" class="login"> Logout</a></i>
        </ul>
        <!-- MENU ICON -->
        <div class="menu-icon">
          <div class="line1"></div>
          <div class="line2"></div>
          <div class="line3"></div>
        </div>
      </div>
    </header>
    <!-- SECTION BARANG-->
    <section class="shop container">
      <h2 class="section-title">Products</h2>
      <div class="shop-content">
      <?php foreach( $barang as $row ) : ?>
        <div class="product-box">
            <img src="gambar/<?php echo $row["gambar"];?>" alt="" class="product-img" />
            <h2 class="product-title"><?php echo $row["nama"]; ?></h2>
            <span class="price">Rp <?php echo $row["harga"];?></span>
            <i class='bx bx-edit add-cart'><a href="hapus.php?id=<?= $row["id_baju"]; ?>" >Delete</a></i>
            <i class='bx bx-edit edit-cart'><a href="edit.php?id=<?= $row["id_baju"]; ?>" >Edit</a></i>
        </div>
        <?php endforeach;?>
      </div>
    </section>

    <!-- JAVASCRIPT LINK UNTUK SWEETALERT-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- JAVASCRIPT LINK -->
    <script src="js/index.js"></script>
  </body>
</html>

