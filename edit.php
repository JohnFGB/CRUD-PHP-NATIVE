<?php 

session_start();

if(!isset($_SESSION["login"])){
  header("Location: log/register.php");
  exit;
}

require 'functions.php';

$id = $_GET["id"];


$barang = query("SELECT * FROM baju WHERE id_baju = $id")[0];


if (isset($_POST["submit"]) ) {

  if (edit($_POST) > 0) {
      echo "
      <script>
        alert('data gagal diubah!');
        document.location.href = 'edit.php';
      </script>";
  } else {
    echo "
        <script>
           alert('data berhasil diubah!');
           document.location.href = 'array.php';
        </script>";
  }
};
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

h1 {
    text-align: center;
}
input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

button:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
</style>
</head>
<body>
<h1>Edit Barang</h1>

<div class="container">
  <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $barang["id_baju"]; ?>">
        <input type="hidden" name="gambarLama" value="<?= $barang["gambar"]; ?>">
    <div class="row">
      <div class="col-25">
        <label for="nmbarang">Nama Barang</label>
      </div>
      <div class="col-75">
        <input type="text" id="nmbarang" name="nama" placeholder="Nama Barang" required value="<?= $barang['nama'];?>">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="harga">Harga Barang</label>
      </div>
      <div class="col-75">
        <input type="text" id="harga" name="harga" placeholder="Harga Barang" required value="<?= $barang['harga'];?>">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="gambar">Gambar</label>
      </div>
      <div class="col-75">
      <input type="file" id="gambar" name="gambar">Max 2Mb 
      <img src="gambar/<?= $barang['gambar']; ?>" alt="" width="50px">
      </div>
    </div>
    <div class="row">
        <br>
      <button type="submit" name="submit">Edit</button>
    </div>
  </form>
</div>

</body>
</html>
