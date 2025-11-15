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

$penjualan = getData("SELECT * FROM  tbl_jual_head");

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sales Report</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Sale</li>
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
                        <button type="button" class="btn btn-sm btn-outline-primary float-right" data-toggle="modal" data-target="#mdlPriodejual"><i class="fas fa-print"></i> Print</button>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap" id="tblData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sales ID</th>
                                <th>Sales Date</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th style="width: 10%;" class="text-center">Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach($penjualan as $jual){ ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $jual['no_jual'] ?></td>
                                <td><?= in_date($jual['tgl_jual']) ?></td>
                                <td><?= $jual['customer'] ?></td>
                                <td class="text-center"><?= number_format($jual['total'],0,",",".") ?></td>
                                <td class="text-center"><a href="detail-penjualan.php?id=<?= $jual['no_jual'] ?>&tgl=<?= $jual['tgl_jual'] ?>" class="btn btn-sm btn-info" title="rincian barang">Detail</a></td>
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

    <div class="modal fade" id="mdlPriodejual">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Sales Priode</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="nmBrg" class="col-sm-3 col-form-label">Start Date</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="tgl1">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nmBrg" class="col-sm-3 col-form-label">End Date</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="tgl2">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="printDoc()"><i class="fas fa-print"></i> Print</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <script>
        let tgl1 = document.getElementById('tgl1');
        let tgl2 = document.getElementById('tgl2');

        function printDoc(){
          if (tgl1.value != "" && tgl2.value != "") {
            window.open("../report/r-jual.php?tgl1=" + tgl1.value + "&tgl2=" + tgl2.value, "", "width=999, height=600, left=100");
          }
        }
      </script>



<?php

require "../template/footer.php";

?>