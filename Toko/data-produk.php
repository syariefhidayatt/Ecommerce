<?php
    session_start();
    include 'db.php';
    if($_SESSION['status_login'] = true){
        echo '<script>window.location=login.php"</script>';
    }
    $query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id = '".$_SESSION['id']."'");
    $d = mysqli_fetch_object($query);
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
            <h3>Data Produk</h3>
            <div class="box">
                <p><a href="tambah-produk.php" class="btn btn-tambah">Tambah Data</a></p>
                <table border="1" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <th width="60px">No</th>
                        <th>Kategori</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stock</th>
                        <th>Gambar</th>
                        <th>Status</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                        $produk = mysqli_query($conn, "SELECT * FROM tb_product LEFT JOIN tb_category USING (category_id) ORDER BY product_id DESC");
                        if(mysqli_num_rows($produk) > 0){
                        while($row = mysqli_fetch_array($produk)){
                    ?>
                    <tr>
                        <td><?php echo $no++?></td>
                        <td><?php echo $row['category_name']?></td>
                        <td><?php echo $row['product_name']?></td>
                        <td>Rp.<?php echo number_format($row['product_price'])?></td>
                        <td><?php echo $row['stock']?></td>
                        <td><a href="produk/<?php echo $row['product_image']?>" target="_blank"><img src="produk/<?php echo $row['product_image']?>" width="60px"></a></td>
                        <td><?php echo ($row['product_status'] == 0)? 'Tidak tersedia':'Tersedia'; ?></td>
                        <td>
                            <a href="edit-produk.php?id=<?php echo $row['product_id']?>"class="btn btn-edit">Edit</a> <a href="hapus-kategori.php?idp=<?php echo $row['product_id']?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-delete">Delete</a>
                        </td>
                    </tr>
                    <?php }}else{ ?>
                        <tr>
                            <td colspan="7">Tidak ada data</td>
                        </tr>
                        <?php } ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--footer-->
    <div class="footer">
        <div class="container">
            <small>Copyright &copy; 2023 - Toko.</small>
        </div>
    </div>
</body>
</html>