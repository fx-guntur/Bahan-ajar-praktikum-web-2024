<?php
include 'config.php';

if(isset($_SESSION['login'])) {
  header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossOrigin="anonymous" referrerPolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="style/variables.style.css" rel="stylesheet">
  <link href="style/auth.style.css" rel="stylesheet">
  <link href="style/components.style.css" rel="stylesheet">
  <title>Sign Up - Pertemuan 2</title>
</head>
<body>
  <main>
    <section id="auth-hero">
      <img src="assets/sign-up-image.png" alt="Image Sign Up" class="background">
      <div class="content">
        <h2 class="title">Selangkah Lebih Dekat Dengan Impianmu</h2>
        <p class="description">Sebuah layanan Manajemen Keuangan gratis yang siap membantumu mengelola pengeluaran dan pemasuukan sehari-hari</p>
      </div>
    </section>
    <section id="auth-form">
      <a class="btn-back" href="#">
        <i class="fa-solid fa-arrow-left"></i>
        <p>Homepage</p>
      </a>
      <div class="header">
        <h1>Sign Up</h1>
        <p>Persiapkan diri untuk masa depan yang penuh dengan bintang</p>
      </div>
      <form action="" method="post">
        <div class="input-group border-primary">
          <label for="name">Name</label>
          <input type="text" class="placeholder-primary" id="name" name="name" placeholder="Your name">
        </div>
        <div class="input-group border-primary">
          <label for="email">Email</label>
          <input type="email" class="placeholder-primary" id="email" name="email" placeholder="Your email">
        </div>
        <div class="input-group border-primary">
          <label for="password">Password</label>
          <input type="password" class="placeholder-primary" id="password" name="password" placeholder="Your password">
        </div>
        <div class="input-group border-primary">
          <label for="password-confirmation">Password Confirmation</label>
          <input type="password" class="placeholder-primary" id="password-confirmation" name="password-confirmation" placeholder="Your password confirmation">
        </div>
        <button type="submit" name="register" class="btn-secondary btn-submit">Sign Up</button>
        <p class="text-center">Already have an account? <a href="signin.php" class="link">Sign In</a></p>
      </form>
    </section>
  </main>
</body>
</html>
