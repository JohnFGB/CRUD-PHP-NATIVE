<?php 

$conn = mysqli_connect("localhost","root","","baju");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data) {
    global $conn;

    $nama_barang = htmlspecialchars($data["nama"]);
    $harga_barang = htmlspecialchars($data["harga"]);

    $gambar = upload();

    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO baju 
                VALUES
            ('','$nama_barang','$harga_barang','$gambar')";
    mysqli_query($conn, $query);
}

function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM baju WHERE id_baju = $id");

    return mysqli_affected_rows($conn);
}

function upload () {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo"<script>
                alert('Masukan gambar!');
             </script>";
        return false;
    }

    $ekstensiGambarValid = ['jpg','jpeg','png'];
    $ekstensiGambar = explode('.',$namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo"<script>
                alert('Yang anda upload bukan gambar!');
            </script>";
        return false;
    }

    if ($ukuranFile > 2097152) {
        echo"<script>
                alert('Ukuran gambar terlalu besar!');
            </script>";
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar; 
    move_uploaded_file($tmpName,'gambar/'.$namaFileBaru);

    return $namaFileBaru;
}

function edit($data) {
    global $conn;

    $id = $data["id"];
    $nama_barang = htmlspecialchars($data["nama"]);
    $harga_barang = htmlspecialchars($data["harga"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    if($_FILES['gambar']['error'] === 4 ) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE baju SET
              nama = '$nama_barang',
              harga = '$harga_barang',
              gambar = '$gambar'
              WHERE id_baju = $id";

    mysqli_query($conn, $query);
}


function cari($keyword) {
        $query = "SELECT * FROM baju
                    WHERE
                nama LIKE '%$keyword%' OR 
                harga LIKE '%$keyword%'";
        return query($query);
}

function registrasi ($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result) ) {
        echo "<script>
                alert('Username sudah terdaftar!');
                alert('Silahkan masukan username lagi!');
             </script>";
        return false;
    }

    if ($password !== $password2) {
        echo "<script>
                alert('Password tidak sama!');
              </script";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password')");
    return mysqli_affected_rows($conn);
}
?>