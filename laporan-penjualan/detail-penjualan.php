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

$title  = "Laporan - MyMoro Baby Store";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

$id        = $_GET['id'];
$tgl       = $_GET['tgl'];
$penjualan = getData("SELECT * FROM  tbl_jual_detail WHERE no_jual = '$id'");
$jualHeader = getData("SELECT * FROM tbl_jual_head WHERE no_jual ='$id'");
$jualHeader = $jualHeader[0];

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sales Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= $main_url ?>laporan-penjualan/index.php">Sale</a></li>
              <li class="breadcrumb-item active">Detail</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
              <h3 class="card-title"><i class="fas fa-bars"></i> Item Details</h3>
              <button type="button" class="btn btn-sm btn-success float-right mr-1"><?= $tgl ?></button>
              <button type="button" class="btn btn-sm btn-warning float-right mr-1"><?= $id ?></button>
          </div>
          <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barcode</th>
                                <th>Item Name</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Selling Purchase</th>
                                <th class="text-center">Total Payment</th>
                                <th class="text-right">Cash</th>
                                <th class="text-right">Change</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($penjualan as $jual){ ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $jual['barcode'] ?></td>
                                <td><?= $jual['nama_brg'] ?></td>
                                <td class="text-center"><?= $jual['qty'] ?></td>
                                <td class="text-center"><?= number_format($jual['harga_jual'],0,",",".") ?></td>
                                <td class="text-center"><?= number_format($jual['jml_harga'],0,",",".") ?></td>
                              <td class="text-right"><?= number_format($jualHeader['jml_bayar'],0,",",".") ?></td>
                              <td class="text-right"><?= number_format($jualHeader['kembalian'],0,",",".") ?></td>
                            </tr>
                            <?php    
                            }
                            ?>
                        </tbody>
                   </table>
              </div>
        </div>
      </div>
    </section>

<?php

require "../template/footer.php";

?>