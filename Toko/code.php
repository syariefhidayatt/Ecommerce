<?php
session_start();
require 'db.php';

if(isset($_POST['beli_barang']))
{
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']); 
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $qty = mysqli_real_escape_string($conn, $_POST['quantity']);
    

    $qry = "SELECT * FROM tb_product";
    $qry_run = mysqli_query($conn, $qry);
    if (mysqli_num_rows($qry_run) > 0) {
        foreach ($qry_run as $p) {
            if ($qty <= 0) {
                echo "minimal pembelian adalah 1";
            }
            if ((int)$qty > (int)$stock){
                echo '<script>alert("Stock tidak mencukupi")</script>';
                echo '<script>window.location="index.php"</script>';
                exit(0);
            } else {
                $total = (int)$qty * (int)$product_price;
                $stock_akhir = (int)$stock - (int)$qty; 
            }

            $query = "UPDATE tb_product SET product_price='$product_price', stock='$stock_akhir', quantity='$qty', total='$total' WHERE product_id='$product_id' ";
            $query_run = mysqli_query($conn, $query);

        
            if($query_run)
            {
                echo '<script>alert("Pembelian berhasil")</script>';
                echo '<script>window.location="index.php"</script>';
                
            }
            else
            {
                echo "GAGAL";            
            }
        }
    }
}

