<?php
    error_reporting(0);
    include 'db.php';
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
        <h1><a href="index.php">Toko</a></h1>
        <ul>
            <li><a href="produk.php">Produk</a></li>
        </ul>
        </div>
    </header>

    <!-- search -->
    <div class="search">
        <div class="container">
            <form action="produk.php">
                <input type="text" name="search" placeholder="Cari Produk" value="<?php echo $_GET['search'] ?>"
                <input type="hidden" name="kat" value="<?php echo $_GET['kat'] ?>"
                <input type="submit" name="cari" value="Cari Produk">
            </form>
        </div>
    </div>

    <!-- New produk -->
    <div class="section">
        <div class="container">
            <h3>Produk</h3>
            <div class="box">
            <?php
                if($_GET['search'] != '' || $_GET['kat'] != ''){
                    $where = "AND product_name LIKE '%".$_GET['search']."%' AND category_id LIKE '%".$_GET['kat']."%'  ";
                }

                $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 $where ORDER BY product_id DESC");
                if(mysqli_num_rows($produk) > 0){
                    while($p = mysqli_fetch_array($produk)){
            ?>
                <a href="detail-produk.php?id=<?php echo $p['product_id'] ?>">
                <div class="col-4">
                    <img src="produk/<?php echo $p['product_image'] ?>">
                    <p class="nama"><?php echo $p['product_name'] ?></p>
                    <p class="harga">Rp. <?php echo number_format($p['product_price']) ?></p>
                </div>
                </a>
                <?php }}else{ ?>
                    <p>Produk tidak ada</p>
                    <?php } ?>
            </div>
        </div>
    </div>

    <!-- footer -->
    <div class="footer">
        <div class="container">
        <small>Copyright &copy; 2023 - Toko.</small>
        </div>
    </div>
</body>
</html>