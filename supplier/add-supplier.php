<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-supplier.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$title  = "Tambah Supplier - MyMoro Baby Store";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

$alert  = '';

if (isset($_POST['simpan'])){
    if (insert($_POST)){
        echo "
            <script>document.location.href = 'data-supplier.php?msg=simpan';</script>
            ";
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
            <h1 class="m-0">Supplier</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= $main_url ?>supplier/data-supplier.php">Supplier</a></li>
              <li class="breadcrumb-item active">Add Supplier</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="" method="post">
                  <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-plus"></i>  Add Supplier</h3>
                    <button type="submit" name="simpan" class="btn btn-primary btn-sm float-right d-block mb-2"><i class="fas fa-save"></i>  save</button>
                    <button type="reset" class="btn btn-danger btn-sm float-right mr-1 d-block mb-2"><i class="fas fa-times"></i>  cancel</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 mb-3">
                              <?php if ($alert != ''){
                                echo $alert;
                              } ?>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="nama supplier" autofocus autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="telpon">Telephone</label>
                                    <input type="text" name="telpon" class="form-control" id="telpon" placeholder="nomor telpon supplier" pattern="[0-9]{5,}" title="minimal 5 angka" required>
                                </div>
                                <div class="form-group">
                                    <label for="ketr">Description</label>
                                    <textarea name="ketr" id="ketr" rows="2" class="form-control" placeholder="keterangan supplier" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Address</label>
                                    <textarea name="alamat" id="alamat" rows="3" class="form-control" placeholder="alamat supplier" required></textarea>
                                </div>
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