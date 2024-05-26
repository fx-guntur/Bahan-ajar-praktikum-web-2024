<?php
define('host', 'localhost');
define('user', 'root');
define('pass', '');
define('db', 'manajemen_keuangan');

$conn = mysqli_connect(host, user, pass, db);

if (!$conn) {
    die("Tidak bisa terkoneksi ke database");
}

if(!@$_SESSION) {
    session_start();
}

$kategori = "";
$keterangan = "";
$jumlah = "";
$tipe = "";
$pemasukan = "";
$pengeluaran = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id_transaksi = $_GET['id'];
    $sql1 = "DELETE FROM tabel_keuangan where id = '$id_transaksi'";
    $q1 = mysqli_query($conn, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = "Gagal melakukan delete data";
    }
}

if ($op == 'edit') {
    $id_transaksi = $_GET['id'];
    // TODO: Ubah menjadi prepared statement
    $sql1 = "SELECT * FROM tabel_keuangan where id = '$id_transaksi'";
    $q1 = mysqli_query($conn, $sql1); // Mejalankan query
    $r1 = mysqli_fetch_array($q1); // Memasukkan hasil query ke array r1
    $kategori = $r1['kategori'];
    $keterangan = $r1['keterangan'];

    // $jumlah = $r1['pemasukan'] + $r1['pengeluaran'];
    // if ($r1['pemasukan'] > 0) {
    //     $tipe = "pemasukan";
    // } else {
    //     $tipe = "pengeluaran";
    // }

    if ('kategori' == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) {
    $kategori = $_POST['kategori'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];
    $tipe = $_POST['tipe'];

    if ($kategori && $keterangan && $tipe && $jumlah) {
        if ($op == 'edit') {
            // TODO: Ubah menjadi prepared statement
            $sql1 = "SELECT * FROM tabel_keuangan where id = '$id_transaksi'";
            $q1 = mysqli_query($conn, $sql1);
            $r1 = mysqli_fetch_array($q1);
            if ($tipe == "pemasukan") {
                $pemasukan = $jumlah;
                $pengeluaran = $r1['pengeluaran'];
            } else {
                $pengeluaran = $jumlah;
                $pemasukan = $r1['pemasukan'];
            }
            $sql2 = "UPDATE tabel_keuangan SET kategori = '$kategori', keterangan = '$keterangan', pemasukan = '$pemasukan',  pengeluaran = '$pengeluaran' WHERE id = '$id_transaksi'";
            $q2 = mysqli_query($conn, $sql2);
            if ($q2) {
                $sukses = "Data berhasil di Update";
            } else {
                $error = "Data gagal diupdate";
            }
        } else {
            if ($tipe == "pemasukan") {
                $pemasukan = $jumlah;
                $pengeluaran = 0;
            } else {
                $pengeluaran = $jumlah;
                $pemasukan = 0;
            }
            $stmt = mysqli_prepare($conn, "INSERT INTO tabel_keuangan(kategori, pemasukan, pengeluaran, keterangan, id_akun) VALUES (?, ?, ?, ?, ?)");
            if ($stmt === false) {
                die("Persiapan pernyataan gagal: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "siisi", $kategori, $pemasukan, $pengeluaran, $keterangan, $_SESSION['id']);
            $sql_result = mysqli_stmt_execute($stmt);

            if ($sql_result) {
                $sukses = "Berhasil memasukkan data baru";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silahkan masukkan semua data!";
    }
}

// Buat kondisi ketika tombol register ditekan
if (isset($_POST["register"])) {
    // Simpan data dari post register ke variabel lokal
    $username = stripslashes($_POST['name']); // membuat username menjadi lowercase sebelum di simpan ke database
    $pass = $_POST['password']; // mencegah un-authorized login
    $conf_pass = $_POST['password-confirmation'];
    $email = $_POST['email'];

    if ($username && $pass && $conf_pass) {
        // mengecek apakah ada user dengan username yang sama
        $stmt = mysqli_prepare($conn, "SELECT username FROM user WHERE username = ?");
        if ($stmt === false) {
            die("Persiapan pernyataan gagal: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>
                alert('username sudah terdaftar!')
            </script>";
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_close($stmt);

        // cek konfirmasi password
        if ($pass !== $conf_pass) {
            echo "<script>
                alert('konfirmasi password tidak sesuai!');
            </script>";
            return false;
        }

        // hashing password
        $pass = password_hash($pass, PASSWORD_DEFAULT);

        // tambahkan userbaru ke database
        $stmt = mysqli_prepare($conn, "INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Persiapan pernyataan gagal: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $pass);
        $sql_result = mysqli_stmt_execute($stmt);

        if ($sql_result) {
            header("refresh:0;url=signin.php");
            echo "<script>
                alert('Registrasi berhasil')
            </script>";
        } else {
            echo "<script>
                alert('Registrasi gagal!')
            </script>";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo "<script>
                alert('Input semua data!')
            </script>";
    }
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if ($email && $password) {
        $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE email = ?");
        if ($stmt === false) {
            die("Persiapan pernyataan gagal: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // menyimpan array data yang di dapatkan dari query $sql ke variabel $row
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["password"])) {
                // set session
                $_SESSION["login"] = True;
                $_SESSION["id"] = $row["id"];
                echo "<script>
                    alert('Login berhasil')
                </script>";

                header("Location: index.php");
            } else {
                header("refresh:0;url=signin.php");
                echo "<script>
                    alert('Login gagal! Periksa email dan password kembali')
                </script>";
            }
        } else {
            echo "<script>
                alert('Input semua data!')
            </script>";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
