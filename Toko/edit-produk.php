<?php
    session_start();
    include 'db.php';
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
    }

    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '".$_GET['id']."' ");
    if(mysqli_num_rows($produk) == 0){
        echo '<script>window.location="data-produk.php"</script>';
    }
    $p = mysqli_fetch_object($produk);
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
        <h1><a href="dashboard.php">Toko</a></h1>
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
            <h3>Edit Produk</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <select class="input-control" name="kategori" required>
                    <option value="">--Pilih--</option>
                    <?php
                        $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                        while($r = mysqli_fetch_array($kategori)){
                            ?>
<option value="<?php echo $r['category_id'] ?>" <?php echo ($r['category_id'] == $p->category_id)? 'selected':''; ?>><?php echo $r['category_name'] ?></option>
                        <?php } ?>
                </select>
                <input type="text" name="nama" class="input-control" placeholder="Nama Produk" value="<?php echo $p->product_name ?>" required>
                <input type="text" name="harga" class="input-control" placeholder="Harga" value="<?php echo $p->product_price ?>" required>
                <input type="text" name="stock" class="input-control" placeholder="Stock" value="<?php echo $p->stock?>" required>
                <img src="produk/<?php echo $p->product_image ?>" width="100px">
                <input type="hidden" name="foto" value="<?php echo $p->product_image?>">
                <input type="file" name="gambar" class="input-control">
                <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"><?php echo $p->product_description ?></textarea>
                <select class="input-control" name="status">
                    <option value="">--Pilih--</option>
                    <option value="1" <?php echo ($p->product_status == 1)? 'selected':''; ?>>Aktif</option>
                    <option value="0" <?php echo ($p->product_status == 0)? 'selected':''; ?>>Tidak Aktif</option>
                </select>
                <input type="submit" name="submit" value="Submit" class="btn btn-tambah">
            </form>
            <?php
            if(isset($_POST['submit'])){
                // data inputan dari form 
                $kategori = $_POST['kategori'];
                $nama = ucwords($_POST['nama']);
                $harga = $_POST['harga'];
                $stock = $_POST['stock'];
                $deskripsi = $_POST['deskripsi'];
                $status = $_POST['status'];
                $foto = $_POST['foto']; 

                // data gambar yang baru
                $filename = $_FILES['gambar']['name'];
                $tmp_name = $_FILES['gambar']['tmp_name'];
                
                // jika admin ganti gambar
                if($filename != ''){
                    $type1 = explode('.', $filename);
                $type2 = $type1[1];
                $newname = 'produk'.time().'.'.$type2;

                // menampung data format file yang diizinkan
                $type_izin = array('jpg', 'jpeg', 'png', 'gif');

                    // validasi format file
                if(!in_array($type2, $type_izin)){
                    echo '<script>alert("format file tidak diizinkan")</script>';

                }else{
                    unlink('./produk/'.$foto);
                    move_uploaded_file($tmp_name, './produk/'.$newname); 
                    $namagambar = $newname;
                    }

                }else{
                    // jika admin tidak ganti gambar
                    $namagambar = $foto;
                }
                // query update data produk
                $update = mysqli_query($conn, "UPDATE tb_product SET
                                    category_id = '".$kategori."',
                                    product_name = '".$nama."',
                                    product_price = '".$harga."',
                                    stock = '".$stock."',
                                    product_description = '".$deskripsi."',
                                    product_image = '".$namagambar."',
                                    product_status = '".$status."'
                                    WHERE product_id = '".$p->product_id."' ");

                if($update){
                    echo '<script>alert("Ubah data berhasil")</script>';
                    echo '<script>window.location="data-produk.php"</script>';
                }else{
                    echo'gagal'.mysqli_error($conn);
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