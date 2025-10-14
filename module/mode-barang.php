<?php

if (userLogin()['level'] == 2){
    header("location:" . $main_url . "error-page.php");
    exit();
}

function generateId(){
    global $koneksi;

    $queryId    = mysqli_query($koneksi, "SELECT max(id_barang) as maxid FROM tbl_barang");
    $data       = mysqli_fetch_array($queryId);
    $maxid      = $data['maxid'];

    if ($maxid){
    $noUrut     = (int) substr($maxid, 4, 3);
    $noUrut++;
    } else {
        $noUrut = 1;
    }
    return "BRG-" . sprintf("%03s", $noUrut);
    
}

function insert($data){
    global $koneksi;

    $id            = mysqli_real_escape_string($koneksi, $data['kode']);
    $barcode       = mysqli_real_escape_string($koneksi, $data['barcode']);
    $nama_barang   = mysqli_real_escape_string($koneksi, $data['name']);
    $satuan        = mysqli_real_escape_string($koneksi, $data['satuan']);
    $harga_beli    = mysqli_real_escape_string($koneksi, $data['harga_beli']);
    $harga_jual    = mysqli_real_escape_string($koneksi, $data['harga_jual']);
    $stock_minimal = mysqli_real_escape_string($koneksi, $data['stock_minimal']);

    // pastikan ambil stock kalau ada, kalau nggak ada set default 0
    $stock = isset($data['stock']) ? mysqli_real_escape_string($koneksi, $data['stock']) : '0';

    // gambar awal (nama file jika ada), nanti akan diganti oleh uploadimg()
    $gambar = (isset($_FILES['image']['name']) ? mysqli_real_escape_string($koneksi, $_FILES['image']['name']) : '');

    // cek barcode duplikat
    $cekBarcode = mysqli_query($koneksi, "SELECT * FROM tbl_barang WHERE barcode = '$barcode'");
    if (!$cekBarcode) {
        die("Query cekBarcode gagal: " . mysqli_error($koneksi));
    }
    if (mysqli_num_rows($cekBarcode) > 0) {
        echo '<script>alert("kode barang sudah ada, barang gagal ditambahkan")</script>';
        return false;
    }

    // upload gambar barang
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
        $gambar = uploadimg(null, $id);
    } else {
        $gambar = 'barang default.jpg';
    }

    // gambar tidak sesuai validasi
    if ($gambar == '') {
        return false;
    }

    // INSERT dengan menyebutkan nama kolom agar aman
    $sqlBrg = "INSERT INTO tbl_barang
    (id_barang, barcode, nama_barang, harga_beli, harga_jual, satuan, stock_minimal, gambar, stock)
    VALUES
    ('$id', '$barcode', '$nama_barang', '$harga_beli', '$harga_jual', '$satuan', '$stock_minimal', '$gambar', '$stock')";

    if (!mysqli_query($koneksi, $sqlBrg)) {
        die("Insert gagal: " . mysqli_error($koneksi) . "<br>Query: " . $sqlBrg);
    }

    return mysqli_affected_rows($koneksi);
}

function delete($id, $gbr){
    global $koneksi;

    $sqlDel = "DELETE FROM tbl_barang WHERE id_barang = '$id'";
    mysqli_query($koneksi, $sqlDel);
    if ($gbr != 'barang default.jpg') {
        unlink('../asset/image/' . $gbr);
    }

    return mysqli_affected_rows($koneksi);
}

function update($data){
    global $koneksi;

    $id         = mysqli_real_escape_string($koneksi, $data['kode']);
    $barcode    = mysqli_real_escape_string($koneksi, $data['barcode']);
    $name       = mysqli_real_escape_string($koneksi, $data['name']);
    $satuan     = mysqli_real_escape_string($koneksi, $data['satuan']);
    $harga_beli = mysqli_real_escape_string($koneksi, $data['harga_beli']);
    $harga_jual = mysqli_real_escape_string($koneksi, $data['harga_jual']);
    $stockmin   = mysqli_real_escape_string($koneksi, $data['stock_minimal']);
    $gbrLama    = mysqli_real_escape_string($koneksi, $data['oldImg']);
    $gambar     = mysqli_real_escape_string($koneksi, $_FILES['image']['name']);

    // cek barcode lama
    $queryBarcode = mysqli_query($koneksi, "SELECT * FROM tbl_barang WHERE id_barang = '$id'");
    $dataBrg      = mysqli_fetch_assoc($queryBarcode);
    $curBarcode   = $dataBrg['barcode'];

    // barcode baru
    $cekBarcode = mysqli_query($koneksi, "SELECT * FROM tbl_barang WHERE barcode = '$barcode'");

    // jika barcode diganti
    if ($barcode !== $curBarcode) {
        // jika barcode sudah ada
        if (mysqli_num_rows($cekBarcode)) {
            echo '<script>alert("kode barang sudah ada, barang gagal diperbarui")</script>';
            return false;
        }
    }
     // cek  gambar
     if ($_FILES['image']['name'] != '') {
        $url = "index.php";
        if ($gbrLama == 'barang default.jpg'){
            $nmgbr = $id;
        } else {
            $nmgbr =$id . '-' . rand(10, 10000);
        }
        $imgBrg = uploadimg($url, $nmgbr);
        if ($gbrLama!= 'barang default.jpg') {
            @unlink('../asset/image/'.$gbrLama);
        }
    } else {
        $imgBrg = $gbrLama;
    }

    mysqli_query($koneksi, "UPDATE tbl_barang SET
                            barcode     = '$barcode',                        
                            nama_barang = '$name',                        
                            harga_beli  = $harga_beli,                        
                            harga_jual  = $harga_jual,                        
                            satuan      = '$satuan',                        
                            stock_minimal = $stockmin,                        
                            gambar      = '$imgBrg'            
                            WHERE id_barang = '$id'    
                            ");

    return mysqli_affected_rows($koneksi);
}