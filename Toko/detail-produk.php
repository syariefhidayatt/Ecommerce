<?php
    error_reporting(0);
    include 'db.php';
    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '".$_GET['id']."'");
    $p = mysqli_fetch_object($produk);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    input[type=number] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: none;
  border-bottom: 2px solid grey;
}
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Oxygen&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"-->

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

    <!-- detail produk -->
    <div class="section">
        <div class="container">
            <div class="box">
                <div class="col-2">
                    <img src="produk/<?php echo $p->product_image ?>" width="100%">
                </div>
                <div class="col-2">
                    <form action="code.php" method="POST">           
                        <input type="hidden" id="product_id" name="product_id" value="<?=$p->product_id ?>">
                        <h3><?php echo $p->product_name ?></h3>
                        <h4>Rp. <?php echo number_format($p->product_price ) ?></h4>
                        <input type="hidden" id="product_price" name="product_price" value="<?=$p->product_price ?>">
                        <p>Deskripsi :<br>
                        <?php echo $p->product_description ?>
                        </p>
                        <label for="name">stock</label>                       
                        <input readonly type="number" name="stock" value="<?=$p->stock;?>" class="form-control">
                        <label for="name">Jumlah Pembelian</label>                       
                        <input type="number" name="quantity" value="" class="form-control">
                        <label for="name">total</label>     
                        <input readonly type="number" name="total" value="<?=$p->total;?>" class="form-control">
                        <button type="submit" name="beli_barang" class="btn btn-a">Beli Langsung</button> 
                    </form>         
                </div>
            </div>
        </div>
    </div>


    <!-- footer -->
    <div class="footer">
        <div class="container">
        <small>Copyright &copy; 2023 - Toko.</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>