<?php

session_start();

if (isset($_SESSION["ssLoginPOS"])) {
    header("location: ../dashboard.php");
    exit();
}

require "../config/config.php";

if (isset($_POST['login'])){
    $username   = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password   = mysqli_real_escape_string($koneksi, $_POST['password']);

    $queryLogin = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username = '$username'");

    if (mysqli_num_rows($queryLogin) === 1) {
        $row = mysqli_fetch_assoc($queryLogin);
        if (password_verify($password, $row['password'])) {
          // set session
          $_SESSION["ssLoginPOS"] = true;
          $_SESSION["ssUserPOS"] = $username;

            header("location: ../dashboard.php");
            exit();
        } else {
            echo "<script>alert('Password Salah');</script>";
        }
    } else {
            echo "<script>alert('Username Tidak Terdaftar');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | MyMoro Baby Store</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= $main_url ?>/asset/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= $main_url ?>/asset/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $main_url ?>/asset/AdminLTE-3.2.0/dist/css/adminlte.min.css">
  <!-- favicon -->
  <link rel="shortcut icon" href="<?= $main_url ?>/asset/image/logomymoro.jpeg" type="image/x-icon">
  <link rel="stylesheet" href="<?= $main_url ?>asset/css/style.css">
</head>

<body class="hold-transition login-page" id="bg-login">
<div class="login-box bounce-in" style="margin-top: -70px;">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>MyMoro</b>Baby Store</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg font-bold"></p>

      <form action="#" method="post">
        <div class="input-group mb-4">
          <input type="text" name="username" class="form-control" placeholder="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-4">
            <input type="password" name="password" class="form-control" placeholder="Password" id="passwordInput">
            <div class="input-group-append">
                <div class="input-group-text" id="togglePassword" style="cursor: pointer;">
                    <i class="fas fa-eye"></i>
                </div>
            </div>
        </div>


        
        <div class="mb-4">
            <button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
      </form>

      <p class="my-3 text-center">
        <strong>Copyright &copy; 2025 <span class="text-info">MyMoro Baby Store</span></strong>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= $main_url ?>/asset/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= $main_url ?>/asset/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= $main_url ?>/asset/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('passwordInput');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.type === "password" ? "text" : "password";
        passwordInput.type = type;

        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>
