<?php
include 'config.php';

if(!$_SESSION["login"]) {
    header("refresh:0;url=signin.php");
    echo "<script>
        alert('Harus login terlebih dahulu')
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:3;url=index.php"); // 5 adalah melakukan redirect setelah 5 detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:3;url=index.php");
                }
                ?>

                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kategori" name="kategori" value="<?php echo $kategori ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="keterangan" class="col-sm-2 col-form-label">keterangan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $keterangan ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah" class="col-sm-2 col-form-label">jumlah uang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo $jumlah ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tipe" class="col-sm-2 col-form-label">tipe transaksi</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="tipe" name="tipe">
                                <option value=""> - Pilih tipe - </option>
                                <option value="pemasukan" <?php if ($tipe == "pemasukan")
                                                                echo "selected" ?>>Pemasukan</option>
                                <option value="pengeluaran" <?php if ($tipe == "pengeluaran")
                                                                echo "selected" ?>>Pengeluaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk menampilkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Keuangan Bulan ini
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nomor</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Pemasukan</th>
                            <th scope="col">Pengeluaran</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $stmt = mysqli_prepare($conn, "SELECT * FROM tabel_keuangan WHERE id_akun = ? ORDER BY id ASC");
                            if ($stmt === false) {
                                die("Persiapan pernyataan gagal: " . mysqli_error($conn));
                            }

                            mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            if (mysqli_num_rows($result) > 0) {
                                $index = 0;
                                while ($r = mysqli_fetch_array($result)) {
                                    $index++;
                                    $id_transaksi = $r['id'];
                                    $kategori = $r['kategori'];
                                    $keterangan = $r['keterangan'];
                                    $pemasukan = $r['pemasukan'];
                                    $pengeluaran = $r['pengeluaran'];
                        ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $index ?>
                                        </th>
                                        <td scope="row">
                                            <?php echo $kategori ?>
                                        </td>
                                        <td scope="row">
                                            <?php echo $keterangan ?>
                                        </td>
                                        <td scope="row">
                                            <?php echo $pemasukan ?>
                                        </td>
                                        <td scope="row">
                                            <?php echo $pengeluaran ?>
                                        </td>
                                        <td scope="row">
                                            <a href="index.php?op=edit&id=<?php echo $id_transaksi ?>">
                                                <button type="button" class="btn btn-warning">Edit</button>
                                            </a>
                                            <a href="index.php?op=delete&id=<?php echo $id_transaksi ?>" onclick="return confirm('Apakah anda yakin untuk menghapus item ini?')">
                                                <button type="button" class="btn btn-danger">Delete</button>
                                            </a>
                                        </td>
                                    </tr>
                        <?php
                                }
                            } else {
                        ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                        <?php
                            }
                            mysqli_stmt_close($stmt);
                        ?>
                    </tbody>
                </table>
                <a href="logout.php" onclick="return confirm('Apakah anda ingin logout?')">
                    <button type="button" class="btn btn-danger">Log out</button>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
