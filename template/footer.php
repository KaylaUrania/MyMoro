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
</body>

</html>