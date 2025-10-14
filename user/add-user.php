<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-user.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$title  = "Tambah User - MyMoro Baby Store";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

if (isset($_POST['simpan'])) {
    if (insert($_POST) > 0) {
        echo "<script>
                alert('User Berhasil diregistrasi ');
            </script>";
    }
}

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= $main_url ?>user/data-user.php">Users</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="" method="post" enctype="multipart/form-data">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-plus"></i> Add User</h3>
                    <button type="submit" name="simpan" class="btn btn-primary btn-sm float-right"><i class="fas fa-save"></i> save</button>
                    <button type="reset" name="reset" class="btn btn-danger btn-sm float-right mr-1"><i class="fas fa-times-circle"></i> cancel</button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 mb-3">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="masukkan username" autofocus autocomplate="off" required>
                            </div>
                            <div class="form-group">
                                <label for="fullname">Fullname</label>
                                <input type="text" name="fullname" class="form-control" id="fullname" placeholder="masukkan nama lengkap" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="masukkan password" required>
                            </div>
                            <div class="form-group">
                                <label for="password2">Confirm Your Password</label>
                                <input type="password" name="password2" class="form-control" id="password2" placeholder="konfirmasi password" required>
                            </div>
                            <div class="form-group">
                                <label for="level">Level User</label>
                                <select name="level" id="level" class="form-control">
                                    <option value="">-- User Level --</option>
                                    <option value="1">Administrator</option>
                                    <option value="2">Operator</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" cols="" rows="3" class="form-control" placeholder="masukkan alamat" required></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            <img src="<?= $main_url ?>asset/image/pp.jpg" class="profile-user-img img-circle mb-3" alt="">
                            <input type="file" class="form-control" name="image">
                            <span class="text-sm">Choose Format Type JPG | PNG | GIF | Jpeg</span><br>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>


<?php

require "../template/footer.php";

?>