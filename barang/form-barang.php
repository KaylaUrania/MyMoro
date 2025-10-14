<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-barang.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$title  = "Form Barang - MyMoro Baby Store";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

if (isset($_GET['msg'])){
  $msg = $_GET['msg'];
  $id = $_GET['id'];
  $sqlEdit = "SELECT * FROM tbl_barang WHERE id_barang = '$id'";
  $barang = getData($sqlEdit)[0];
} else {
  $msg = "";
}

$alert = '';

if (isset($_POST['simpan'])){
  if ($msg != '') {
      if (update($_POST)) {
          echo "
              <script>document.location.href = 'index.php?msg=updated';</script>
          ";
      } else {
        echo "
              <script>document.location.href = 'index.php';</script>
          ";
      }
  } else {
    if (insert($_POST)) {
      $user = userLogin()['username'];
      $gbrUser = userLogin()['foto'];
      $alert = "<script>
                    $(document).ready(function(){
                        $(document).Toasts('create',{
                            title : '$user',
                            body  : 'Successfully Added',
                            class : 'bg-success',
                            image : '../asset/image/$gbrUser',
                            position: 'bottomRight',
                            autohide: true,
                            delay : 5000,
                        })
                    });
              </script>";
    }
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
            <h1 class="m-0">Item</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= $main_url ?>barang">Item</a></li>
              <li class="breadcrumb-item active"><?= $msg != '' ? 'Edit Item' : 'Add Item' ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <form action="" method="post" enctype="multipart/form-data">
                      <?php if($alert != '') {
                        echo $alert;
                      }  ?>
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-pencil-alt"></i> <?= $msg != '' ? 'Edit Item' : 'Input Item' ?></h3>
                        <button type="submit" name="simpan" class="btn btn-primary btn-sm float-right d-block mb-2"><i class="fas fa-save"></i> save</button>
                        <button type="reset" class="btn btn-danger btn-sm float-right mr-1 d-block mb-2"><i class="fas fa-times"></i> cancel</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 mb-3 pr-3">
                                <div class="form-group">
                                        <label for="kode">Item Code</label>
                                        <input type="text" name="kode" class="form-control" id="kode" value="<?= $msg != '' ? $barang['id_barang'] : generateId() ?>" readonly>
                                </div>
                                <div class="form-group">
                                        <label for="barcode">Barcode *</label>
                                        <input type="text" name="barcode" class="form-control" id="barcode" value="<?= $msg != '' ? $barang['barcode'] : null ?>" placeholder="barcode" autocomplete="off">
                                </div>
                                <div class="form-group">
                                        <label for="name">Name *</label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="nama barang" value="<?= $msg != '' ? $barang['nama_barang'] : null ?>" autocomplete="off" autofocus required>
                                </div>
                                <div class="form-group">
                                        <label for="satuan">Unit *</label>
                                        <select name="satuan" id="satuan" class="form-control" required>
                                          <?php
                                            if ($msg != "") {
                                                $satuan = ["pcs", "pack", "box", "botol", "tube", "sachet", "set"];
                                                foreach ($satuan as $sat) {
                                                  if ($barang['satuan'] == $sat) { ?>
                                                      <option value="<?= $sat ?>" selected><?= $sat ?></option>
                                                  <?php } else { ?>
                                                      <option value="<?= $sat ?>"><?= $sat ?></option>
                                                  <?php
                                                  }
                                                }
                                            } else { ?>
                                                <option value="">-- Unit --</option>
                                                <option value="pcs">pcs</option>
                                                <option value="pack">pack</option>
                                                <option value="box">box</option>
                                                <option value="botol">botol</option>
                                                <option value="tube">tube</option>
                                                <option value="sachet">sachet</option>
                                                <option value="set">set</optio>
                                          <?php
                                              }
                                          ?>
                                        </select>
                                </div>
                                <div class="form-group">
                                        <label for="harga_beli">Purchase Price *</label>
                                        <input type="number" name="harga_beli" class="form-control" id="harga_beli" value="<?= $msg != '' ? $barang['harga_beli'] : null ?>" placeholder="Rp 0" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                        <label for="harga_jual">Selling Price *</label>
                                        <input type="number" name="harga_jual" class="form-control" id="harga_jual" value="<?= $msg != '' ? $barang['harga_jual'] : null ?>" placeholder="Rp 0" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                        <label for="stock_minimal">Minimum Stock *</label>
                                        <input type="number" name="stock_minimal" class="form-control" id="stock_minimal" value="<?= $msg != '' ? $barang['stock_minimal'] : null ?>" placeholder="0" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center px-3">
                                <input type="hidden" name="oldImg" value="<?= $msg != '' ? $barang['gambar'] : null ?>">
                                <img src="<?= $main_url ?>asset/image/<?= $msg != '' ? $barang['gambar'] : 'barang default.jpg' ?>" class="profile-user-img mb-3 mt-4" alt="">
                                <input type="file" class="form-control" name="image">
                                <span class="text-sm">Select Format JPG | PNG | GIF</span>
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