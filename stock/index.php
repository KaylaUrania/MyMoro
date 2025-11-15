<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";
// require "../module/mode-barang.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$title  = "Laporan - MyMoro Baby Store";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

$stockBrg = getData("SELECT * FROM  tbl_barang");

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Stock Items</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Stock</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars"></i></h3>
                        <a href="<?= $main_url ?>report/r-stock.php" class="btn btn-sm btn-outline-primary float-right" target="_blank"><i class="fas fa-print"></i> Print</a>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap" id="tblData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>Unit</th>
                                <th>Total Stock</th>
                                <th>Minimum Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach($stockBrg as $stock){ ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $stock['id_barang'] ?></td>
                                <td><?= $stock['nama_barang'] ?></td>
                                <td><?= $stock['satuan'] ?></td>
                                <td class="text-center"><?= $stock['stock'] ?></td>
                                <td class="text-center"><?= $stock['stock_minimal'] ?></td>
                                <td>
                                  <?php
                                    if ($stock['stock'] < $stock['stock_minimal'] ) {
                                      echo '<span class="text-danger">not enough</span>';
                                    } else {
                                      echo'enough';
                                    }

                                  ?>
                                </td>
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