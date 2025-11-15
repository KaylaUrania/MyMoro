<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-customer.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$title  = "Data Customer - MyMoro Baby Store";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

if (isset($_GET['msg'])){
    $msg = $_GET['msg'];
} else {
    $msg = '';
}

$alert = '';

if ($msg == 'deleted'){
    $alert = '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i></h5>
                  CUSTOMER DATA SUCCESSFULLY DELETED!
                </div>';
}

if ($msg == 'aborted'){
    $alert = '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-exclamation-triangle"></i></h5>
                  CUSTOMER DATA FAILED TO BE DELETE.
                </div>';
}

if ($msg == 'updated'){
    $alert = '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i></h5>
                  CUSTOMER DATA SUCCESSFULLY UPDATED!
                </div>';
}

if ($msg == 'simpan'){
    $alert = '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i></h5>
                  CUSTOMER DATA ADDED SUCCESSFULLY!
                </div>';
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Customer</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Customer Data</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section>
      <div class="container-fluid">
        <div class="card">
          <?php if ($alert !== '') {
              echo $alert;
          }?>
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-bars"></i></h3>
            <a href="<?= $main_url ?>customer/add-customer.php" class="btn btn-sm btn-primary float-right"><i class="fas fa-user-plus"></i>  Add Customer</a>
          </div>
          <div class="card-body table-responsive p-3">
            <table class="table table-hover text-nowrap" id="tblData">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Telephone</th>
                  <th>Address</th>
                  <th>Description</th>
                  <th style="width: 10%;">Option</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $customers = getData("SELECT * FROM tbl_customer");
                foreach ($customers as $customer) :
                ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $customer['nama'] ?></td>
                    <td><?= $customer['telpon'] ?></td>
                    <td><?= $customer['alamat'] ?></td>
                    <td><?= $customer['deskripsi'] ?></td>
                    <td>
                      <a href="edit-customer.php?id=<?= $customer['id_customer'] ?>" class="btn btn-sm btn-warning" title="edit customer"><i class="fas fa-pencil-alt"></i></a>
                      <a href="del-customer.php?id=<?= $customer['id_customer'] ?>" class="btn btn-sm btn-danger" title="delete customer" onclick="return confirm('Are You Sure ?')"><i class="fas fa-trash-alt"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>


<?php

require "../template/footer.php";

?>
