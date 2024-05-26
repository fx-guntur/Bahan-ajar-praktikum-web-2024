# Bahan Ajar Praktikum Web 2024

## Latihan
Ubah query mysql yang awalnya menggunakan fungsi `mysqli_query` menjadi `mysqli_prepare`.
```php
$sql1 = "SELECT * FROM tabel_keuangan where id = '$id_transaksi'";
$q1 = mysqli_query($conn, $sql1);
```
Penjelasan prepared statement di [sini](https://nizarfadlan.notion.site/PHP-mysqli-prepare-function-41b4a392ae12424bad5ddcb482de0d15?pvs=4).
