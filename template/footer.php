</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2025 <span class="text-info">MyMoro Baby Store </span></strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- Bootstrap -->
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/jszip/jszip.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE -->
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/chart.js/Chart.min.js"></script>

<script>
  $(function(){ 
      let tema = sessionStorage.getItem('tema');
      let navbar = document.querySelector('.main-header');
      if (tema == 'dark-mode') {
      $('body').addClass('dark-mode');
      $('#cekDark').prop('checked', true);

      $(navbar).removeClass('navbar-light bg-white').addClass('navbar-dark bg-dark');
      }

      $(document).on('click', "#cekDark", function(){
        if ($('#cekDark').is(':checked')) {
          $('body').addClass('dark-mode');
          $(navbar).removeClass('navbar-light bg-white').addClass('navbar-dark bg-dark');
          sessionStorage.setItem('tema', 'dark-mode');
        } else {
          $('body').removeClass('dark-mode');
          $(navbar).removeClass('navbar-light bg-white').addClass('navbar-dark bg-dark');
          sessionStorage.removeItem('tema');
        }
      })

      $('#tblData').DataTable();
  });
</script>

<?php if (strpos($_SERVER['PHP_SELF'], '/penjualan/index.php') !== false) : ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

  <style>
    #reader {
      position: relative;
      width: 350px;
      height: 220px;
      margin-top: 10px;
      border: 3px solid #0d6efd;
      border-radius: 10px;
      overflow: hidden;
      display: none;
    }

    #reader video {
      width: 100% !important;
      height: 100% !important;
      object-fit: cover;
    }

    #reader::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 70%;
      height: 2px;
      background: red;
      transform: translate(-50%, -50%);
      opacity: 0.8;
    }
  </style>

  <script>
  document.addEventListener("DOMContentLoaded", function () {
    console.log("%c[scanner] ready...", "color: #0d6efd; font-weight: bold;");

    const btnScan = document.getElementById("btnScan");
    const readerDiv = document.getElementById("reader");
    const barcodeInput = document.getElementById("barcode");
    const tglInput = document.getElementById("tglNota");
    const statusText = document.getElementById("scan-status");
    let isScanning = false;

    if (!btnScan || !readerDiv) {
      console.warn("[scanner] tombol atau div reader tidak ditemukan");
      return;
    }

    function startScanner() {
      if (isScanning) return;
      isScanning = true;
      readerDiv.style.display = "block";
      statusText && (statusText.style.display = "block");
      btnScan.innerHTML = '<i class="fas fa-times"></i> Stop';

      console.log("[scanner] inisialisasi Quagga...");

      Quagga.init({
        inputStream: {
          name: "Live",
          type: "LiveStream",
          target: readerDiv,
          constraints: {
            facingMode: "environment"
          }
        },
        decoder: {
          readers: [
            "code_128_reader",
            "ean_reader",
            "ean_8_reader",
            "upc_reader",
            "upc_e_reader",
            "code_39_reader",
            "code_93_reader",
            "i2of5_reader",      
            "2of5_reader",       
            "codabar_reader"     
          ]
        },
        locator: {
          halfSample: true,
          patchSize: "medium",
          debug: {
            showCanvas: true,
            showPatches: true,
            showFoundPatches: true,
            showSkeleton: false,
            showLabels: true,
            showPatchLabels: true,
            showRemainingPatchLabels: true,
            boxFromPatches: {
            showTransformed: true,
            showTransformedBox: true,
            showBB: true
            }
          }
        }
      }, function (err) {
        if (err) {
          console.error("[scanner] gagal init:", err);
          alert("Kamera gagal dimulai: " + err);
          stopScanner();
          return;
        }
        Quagga.start();
        console.log("%c[scanner] started", "color: green; font-weight: bold;");
      });

      Quagga.onProcessed(function (result) {
        if (result && result.boxes) {
          console.log("[scanner] frame diproses, kandidat ditemukan:", result.boxes.length);
        }
      });

      Quagga.onDetected(function (data) {
        const code = data.codeResult.code;
        console.log("%c[scanner] barcode terdeteksi:", "color: lime;", code);

        if (code) {
          barcodeInput.value = code;
          stopScanner();
          alert("Barcode terbaca: " + code);
          window.location.href = '?barcode=' + encodeURIComponent(code) + '&tgl=' + encodeURIComponent(tglInput?.value || '');
        }
      });
    }

    function stopScanner() {
      if (!isScanning) return;
      Quagga.stop();
      isScanning = false;
      readerDiv.style.display = "none";
      statusText && (statusText.style.display = "none");
      btnScan.innerHTML = '<i class="fas fa-camera"></i> Scan';
      console.log("%c[scanner] stopped", "color: orange; font-weight: bold;");
    }

    btnScan.addEventListener("click", function () {
      if (isScanning) {
        stopScanner();
      } else {
        startScanner();
      }
    });

    window.addEventListener("beforeunload", stopScanner);
  });
  </script>
<?php endif; ?>

</body>

</html>