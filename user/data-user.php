<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-user.php";

$title = "Users - MyMoro Baby Store";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

if (isset($_GET['msg'])){
    $msg = $_GET['msg'];
} else {
    $msg = '';
}

echo 'msg dari URL = ' . $msg;

$alert = '';

if ($msg == 'delete'){
    $alert = '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i></h5>
                  SUCCESFULLY DELETED!
                </div>';
}

if ($msg == 'aborte'){
    $alert = '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-exclamation-triangle"></i></h5>
                  FAILED TO DELETE.
                </div>';
}

if ($msg == 'update'){
    $alert = '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i></h5>
                  SUCCESFULLY UPDATED!
                </div>';
}

if ($msg == 'add'){
    $alert = '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i></h5>
                  SUCCESSFULLY ADDED!
                </div>';
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
              <li class="breadcrumb-item active">User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <?php if ($alert !== '') {
                echo $alert;
                }?>
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bars"></i> User Data</h3>
                    <div class="card-tools">
                        <a href="<?= $main_url ?>user/add-user.php" class="btn btn-sm btn-primary"><i class="fas fa-user-plus"></i> Add User</a>
                    </div>
                    <div class="card-body table-responsive p-3">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Photo</th>
                                    <th>Username</th>
                                    <th>Fullname</th>
                                    <th>Address</th>
                                    <th>User Level</th>
                                    <th style="width: 10%;">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $users = getData("SELECT * FROM tbl_user");
                                foreach($users as $user) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><img src="../asset/image/<?= $user['foto'] ?>" class="rounded-circle" alt="" width="60px"></td>
                                        <td><?= $user['username'] ?></td>
                                        <td><?= $user['fullname'] ?></td>
                                        <td><?= $user['address'] ?></td>
                                        <td>
                                            <?php
                                            if ($user ['level'] == 1) {
                                                echo "Administrator";
                                            } else if ($user ['level'] == 2) {
                                                echo "Operator";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="edit-user.php?id=<?= $user['userid'] ?>" class="btn btn-sm btn-warning" title="edit user"><i class="fas fa-user-edit"></i></a>
                                            <a href="del-user.php?id=<?= $user['userid'] ?>&foto=<?= $user['foto'] ?>" class="btn btn-sm btn-danger" title="delete user" onclick="return confirm('Delete User ?')"><i class="fas fa-user-times"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php

require "../template/footer.php";

?>




