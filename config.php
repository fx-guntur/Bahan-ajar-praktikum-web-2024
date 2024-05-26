<?php
define('host', 'localhost');
define('user', 'root');
define('pass', '');
define('db', 'manajemen_keuangan');

$conn = mysqli_connect(host, user, pass, db);

if (!$conn) {
    die("Tidak bisa terkoneksi ke database");
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
    $sql1 = "SELECT * FROM tabel_keuangan where id = '$id_transaksi'";
    $q1 = mysqli_query($conn, $sql1); // Mejalankan query
    $r1 = mysqli_fetch_array($q1); // Memasukkan hasil query ke array r1
    $kategori = $r1['kategori'];
    $keterangan = $r1['keterangan'];

    // if($r1['pemasukan']==0){
    //     $jumlah = $r1['pengeluaran'];
    //     $tipe = "pengeluaran";
    // }

    // else{
    //     $jumlah = $r1['pemasukan'];
    //     $tipe = "pemasukan";
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
            $sqli = "INSERT INTO tabel_keuangan(kategori, pemasukan, pengeluaran, keterangan) VALUES('$kategori','$pemasukan','$pengeluaran', '$keterangan')";
            $q1 = mysqli_query($conn, $sqli);
            if ($q1) {
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
    $sanitized_pass = mysqli_real_escape_string($conn, $_POST['password']); // mencegah un-authorized login
    $sanitized_conf_pass = mysqli_real_escape_string($conn, $_POST['password-confirmation']);
    $email = $_POST['email'];

    if ($username && $sanitized_pass && $sanitized_conf_pass) {
        // mengecek apakah ada user dengan username yang sama
        $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

        if (mysqli_fetch_assoc($result)) {
            echo "<script>
                alert('username sudah terdaftar!')
            </script>";
            return false;
        }


        // cek konfirmasi password
        if ($sanitized_pass !== $sanitized_conf_pass) {
            echo "<script>
                alert('konfirmasi password tidak sesuai!');
            </script>";
            return false;
        }

        // hashing password
        $sanitized_pass = password_hash($sanitized_pass, PASSWORD_DEFAULT);

        // tambahkan userbaru ke database

        $sql = "INSERT INTO user (username, email, password) 
                VALUES ('" . $username . "', 
                '" . $email . "', 
                '" . $sanitized_pass . "')";

        $sql_result = mysqli_query($conn, $sql) or die(mysqli_error($db));

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
    } else {
        echo "<script>
                alert('Input semua data!')
            </script>";
    }
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sanitized_pass = mysqli_real_escape_string($conn, $password); // mencegah un-authorized login

    if ($email && $sanitized_pass) {

        $sql = mysqli_query($conn, "SELECT * FROM user WHERE email = '"
            . $email . "'");

        if (mysqli_num_rows($sql) === 1) {
            // menyimpan array data yang di dapatkan dari query $sql ke variabel $row
            $row = mysqli_fetch_assoc($sql);
            if (password_verify($sanitized_pass, $row["password"])) {
                // set session
                $_SESSION["login"] = true;
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
    }
}
