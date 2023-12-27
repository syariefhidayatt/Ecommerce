<?php
    session_start();
    include 'db.php';
    if($_SESSION['status_login'] != true){
        echo '<script>window.location=login.php"</script>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Oxygen&display=swap" rel="stylesheet">
</head>
<body>
    <!--header-->
    <header>
        <div class="container">
        <h1><a href="dashboard.php">Future Tech</a></h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="data-kategori.php">Data Kategori</a></li>
            <li><a href="data-produk.php">Data Produk</a></li>
            <li><a href="keluar.php">Keluar</a></li>
        </ul>
        </div>
    </header>

    <!--content-->
    <div class="section">
        <div class="container">
        <div class="box">
            <h3>Tambah Produk</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <select class="input-control" name="kategori" required>
                    <option value="">--Pilih--</option>
                    <?php
                        $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                        while($r = mysqli_fetch_array($kategori)){
                            ?>
                            <option value="<?php echo $r['category_id'] ?>"><?php echo $r['category_name'] ?></option>
                        <?php } 
                    ?>
                </select>
                <input type="text" name="nama" class="input-control" placeholder="Nama Produk" required>
                <input type="number" name="harga" class="input-control" placeholder="Harga" required>
                <input type="number" name="stock" class="input-control" placeholder="Stock" required>
                <input type="file" name="gambar" class="input-control" required>
                <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"></textarea>
                <select class="input-control" name="status">
                    <option value="">--Pilih--</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
                <input type="submit" name="submit" value="Submit" class="btn btn-tambah">
            </form>
            <?php
                if (isset($_POST['submit'])){
                    // menampung input dari from
                    $kategori = $_POST['kategori'];
                    $nama = ucwords($_POST['nama']);
                    $harga = $_POST['harga'];
                    $stock = $_POST['stock'];
                    $deskripsi = $_POST['deskripsi'];
                    $status = $_POST['status'];  

                    // menampung data file yang diupload
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];
                    $type1 = explode('.', $filename);
                    $type2 = $type1[1];
                    $newname = 'produk'.time().'.'.$type2;

                    // menampung data format file yang diizinkan
                    $type_izin = array('jpg', 'jpeg', 'png', 'gif');

                    // validasi format file
                    if(!in_array($type2, $type_izin)){
                        echo '<script>alert("format file tidak diizinkan")</script>';
                    }else{
                        // proses upload file dan insert database
                        move_uploaded_file($tmp_name, './produk/'.$newname); 

                        $insert = mysqli_query($conn, "INSERT INTO tb_product VALUES (
                            null,
                            '".$kategori."',
                            '".$nama."',
                            '".$harga."',
                            null,
                            null,
                            null,
                            '".$deskripsi."',
                            '".$status."',
                            '".$newname."',
                            null
                            ) ");

                        if($insert){
                            echo '<script>alert("Tambah data berhasil")</script>';
                            echo '<script>window.location="data-produk.php"</script>';
                        }else{
                            echo'gagal'.mysqli_error($conn);
                        }
                    }
                }
            ?>
            </div>
        </div>
    </div>
    
        <!--footer-->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2023 - Toko.</small>
        </div>
        </footer>
</body>
</html>