<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/mode-jual.php";

$title  = "Transaksi - MyMoro Baby Store";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";


if (isset($_GET['msg'])) {
  $msg = $_GET['msg'];
} else {
  $msg = '';
}

// jika barang dihapus
if($msg == 'deleted'){
  $barcode = $_GET['barcode'];
  $idjual = $_GET['idjual'];
  $qty = $_GET['qty'];
  $tgl = $_GET['tgl'];

  delete($barcode, $idjual, $qty);
  echo "<script>
              document.location = '?tgl=$tgl';   
        </script>";
}

// jika ada barcode yg dikirim
$kode   = @$_GET['barcode'] ? @$_GET['barcode'] : '';
if ($kode) {
  $tgl = $_GET['tgl'];
  $dataBrg = mysqli_query($koneksi, "SELECT * FROM tbl_barang WHERE barcode = '$kode'");
  $selectBrg = mysqli_fetch_assoc($dataBrg);
  if (!mysqli_num_rows($dataBrg)) {
    echo "<script>
                alert('barang dengan barcode tersebut tidak ada');
                document.location = '?tgl=$tgl';   
        </script>";
  }

}

// jika tombol tambah barang ditekan
if (isset($_POST['addbrg'])) {
  $tgl = $_POST['tglNota'];
  if (insert($_POST)) {
        echo "<script>
                document.location = '?tgl=$tgl';   
        </script>";
    }
}

// jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
  $nota = $_POST['nojual'];
  if (simpan($_POST)) {
      echo "<script>
              var win = window.open(
                '../report/r-struk.php?nota=$nota',
                'StrukBelanja',
                'width=260,height=400,left=10,top=10'
              );
              if (win) {
                win.focus();
              }
            </script>";
  }
}

$nojual = generateNoJual();

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sale</h1>
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

  <section>
  <div class="container-fluid">
    <form action="" method="post">
      <div class="row">
        <div class="col-lg-6">
          <div class="card card-outline card-warning p-3">
            <!-- No Nota & Date -->
            <div class="form-group row mb-2">
              <label for="noNota" class="col-sm-2 col-form-label">No Nota</label>
              <div class="col-sm-4">
                <input type="text" name="nojual" class="form-control" id="noNota" value="<?= $nojual ?>">
              </div>

              <label for="tglNota" class="col-sm-2 col-form-label">Date</label>
              <div class="col-sm-4">
                <input type="date" name="tglNota" class="form-control" id="tglNota" 
                  value="<?= @$_GET['tgl'] ? $_GET['tgl'] : date('Y-m-d') ?>" required>
              </div>
            </div>

            <!-- Barcode + Scan -->
            <div class="form-group row mb-2">
              <label for="barcode" class="col-sm-2 col-form-label">Barcode</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <input type="text" name="barcode" id="barcode" value="<?= @$_GET['barcode'] ? $_GET['barcode'] : '' ?>" class="form-control" placeholder="Scan atau ketik kode barang">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-warning" id="btnScan"><i class="fas fa-camera"></i> Scan</button>
                  </div>
                </div>

                <span id="scan-status" class="text-muted small" style="display:none;">📸 Camera Active, Point the Item Barcode at the Camera</span>
                <div id="reader" style="width:100%; max-width:350px; margin-top:10px; display:none; border-radius:8px; overflow:hidden;"></div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-lg-6">
          <div class="card card-outline card-danger pt-3 px-3 pb-2">
            <h6 class="font-weight-bold text-right">Total</h6>
            <h1 class="font-weight-bold text-right" style="font-size: 40pt;">
              <input type="hidden" name="total" id="total" value="<?= totalJual($nojual) ?>">
              <?= number_format(totalJual($nojual), 0, ',', '.') ?>
            </h1>
          </div>
        </div>
      </div>
      
      <div class="card pt-1 pb-2 px-3">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="hidden" value="<?= @$_GET['barcode'] ? $selectBrg['barcode'] : '' ?>" name="barcode">
                                <label for="namaBrg">Item Name</label>
                                <input type="text" name="namaBrg" class="form-control form-control-sm" id="namaBrg" value="<?= @$_GET['barcode'] ? $selectBrg['nama_barang'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" name="stock" class="form-control form-control-sm" id="stock" value="<?= @$_GET['barcode'] ? $selectBrg['stock'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="satuan">Unit</label>
                                <input type="text" name="satuan" class="form-control form-control-sm" id="satuan" value="<?= @$_GET['barcode'] ? $selectBrg['satuan'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="harga">Price</label>
                                <input type="number" name="harga" class="form-control form-control-sm" id="harga" value="<?= @$_GET['barcode'] ? $selectBrg['harga_jual'] : '' ?>" readonly>

                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="qty">Qty</label>
                                <input type="number" name="qty" class="form-control form-control-sm" id="qty" value="<?= @$_GET['barcode'] ? 1 : '' ?>">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="jmlHarga">Total Price</label>
                                <input type="number" name="jmlHarga" class="form-control form-control-sm" id="jmlHarga" value="<?= @$_GET['barcode'] ? $selectBrg['harga_jual'] : '' ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-info btn-block" name="addbrg"><i class="fas fa-cart-plus fa-sm"></i> Add</button>
                </div>
                <div class="card card-outline card-success table-responsive px-2">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barcode</th>
                                <th>Item Name</th>
                                <th class="text-right">Price</th>
                                <th class="text-right">Qty</th>
                                <th class="text-right">Total Price</th>
                                <th class="text-center" width="10%">Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $brgDetail = getData("SELECT * FROM tbl_jual_detail WHERE no_jual = '$nojual'");
                            foreach ($brgDetail as $detail){ ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $detail['barcode'] ?></td>
                                    <td><?= $detail['nama_brg'] ?></td>
                                    <td class="text-right"><?= number_format($detail['harga_jual'],0,',','.') ?></td>
                                    <td class="text-right"><?= $detail['qty'] ?></td>
                                    <td class="text-right"><?= number_format($detail['jml_harga'],0,',','.') ?></td>
                                    <td class="text-center">
                                        <a href="?barcode=<?= $detail['barcode'] ?>&idjual=<?= $detail['no_jual'] ?>&qty=<?= $detail['qty'] ?>&tgl=<?= $detail['tgl_jual'] ?>&msg=deleted" class="btn btn-sm btn-danger" title="hapus barang" onclick="return confirm('Hapus Barang Ini?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 p-2">
                        <div class="form-group row mb-2">
                            <label for="customer" class="col-sm-3 col-form-label col-form-label">Customer</label>
                            <div class="col-sm-9">
                                <select name="customer" id="customer" class="form-control form-control-sm">
                                    <?php
                                    $customers = getData("SELECT * FROM tbl_customer");
                                    foreach($customers as $customer) { ?>
                                    <option value="<?= $customer['nama'] ?>"><?= $customer['nama'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                            <div class="form-group row mb-2">
                            <label for="ketr" class="col-sm-3 col-form-label">Information/Note</label>
                            <div class="col-sm-9">
                                <textarea name="ketr" id="ketr" class="form-control form-control-sm"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 py-2 px-3">
                      <div class="form-group row mb-2">
                        <label for="bayar" class="col-sm-3 col-form-label">Pay</label>
                        <div class="col-sm-9">
                          <input type="number" name="bayar" class="form-control form-control-sm text-right" id="bayar">
                        </div>
                      </div>
                      <div class="form-group row mb-2">
                        <label for="kembalian" class="col-sm-3 col-form-label">Change</label>
                        <div class="col-sm-9">
                          <input type="number" name="kembalian" class="form-control form-control-sm text-right" id="kembalian" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4 p-2">
                        <button type="submit" name="simpan" id="simpan" class="btn btn-primary btn-sm btn-block"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <div id="reader" style="width: 300px;"></div>
    <div id="result"></div>
    <script>
      let barcode   = document.getElementById('barcode');
      let tgl       = document.getElementById('tglNota');
      let qty       = document.getElementById('qty');
      let harga     = document.getElementById('harga');
      let jmlHarga  = document.getElementById('jmlHarga');
      let bayar     = document.getElementById('bayar');
      let kembalian = document.getElementById('kembalian');
      let total     = document.getElementById('total');

      barcode.addEventListener('change', function(){
        document.location.href = '?barcode=' + barcode.value + '&tgl=' + tgl.value;
      })

      qty.addEventListener('input', function (){
        jmlHarga.value = qty.value * harga.value;
      })

      bayar.addEventListener('input', function (){
        kembalian.value = bayar.value - total.value;
      })

    </script>
<?php

    require "../template/footer.php";

?>
