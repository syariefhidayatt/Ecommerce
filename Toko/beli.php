<!DOCTYPE html>
<html>
<head>
    <title>Online Shop</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        button {
            padding: 6px 10px;
        }
    </style>
</head>
<body>
<?php
// Koneksi ke database
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname   = 'db_toko';

$conn = new mysqli($hostname, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil daftar produk dari database
$sql = "SELECT * FROM tb_product ORDER BY product_id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<form action='process_purchase.php' method='POST'>";
    echo "<tr><th>ID</th><th>Nama Produk</th><th>Harga</th><th>Stok</th><th>Jumlah Beli</th><th>Aksi</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["product_id"] . "</td>";
        echo "<td>" . $row["product_name"] . "</td>";
        echo "<td>" . number_format($row["product_price"]) . "</td>";
        echo "<td>" . $row["stock"] . "</td>";
        echo "<td><input type='number' min='1' max='" . $row["stock"] . "' name='quantity_" . $row["product_id"] . "'></td>";
        echo "<td><button name='beli_barang' onclick='buyProduct(" . $row["product_id"] . ")'>Beli</button></td>";
        echo "</tr>";
    }
    echo "</form>";
    echo "</table>";
} else {
    echo "Tidak ada produk yang tersedia.";
}

$conn->close();
?>


<script>
function buyProduct(product_id) {
    var quantity = document.getElementsByName("quantity_" + product_id)[0].value;
    if (quantity < 1) {
        alert("Jumlah beli harus lebih dari 0.");
        return;
    }

    // Kirim data pembelian ke file "process_purchase.php"
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                alert("Pembelian berhasil.");
                location.reload();
            } else {
                alert("Pembelian gagal: " + xhr.responseText);
            }
        }
    };

    xhr.open("POST", "process_purchase.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("product_id=" + encodeURIComponent(product_id) + "&quantity=" + encodeURIComponent(quantity));
}
</script>
</body>
</html>