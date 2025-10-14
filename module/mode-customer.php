<?php

if (userLogin()['level'] == 2){
    header("location:" . $main_url . "error-page.php");
    exit();
}

function insert($data){
    global $koneksi;

    $nama   = mysqli_real_escape_string($koneksi, $data['nama']);
    $telpon = mysqli_real_escape_string($koneksi, $data['telpon']);
    $alamat = mysqli_real_escape_string($koneksi, $data['alamat']);
    $ketr   = mysqli_real_escape_string($koneksi, $data['ketr']);

    $sqlCustomer  = "INSERT INTO tbl_customer VALUES (null, '$nama', '$telpon', '$ketr', '$alamat')";
    mysqli_query($koneksi, $sqlCustomer);

    return mysqli_affected_rows($koneksi);
}

function delete($id){
    global $koneksi;

    $sqlDelete = "DELETE FROM tbl_customer WHERE id_customer = $id";
    mysqli_query($koneksi, $sqlDelete);

    return mysqli_affected_rows($koneksi);
}

function update($data){
    global $koneksi;

    $id     = isset($data['id']) ? (int) $data['id'] : 0;
    $nama   = mysqli_real_escape_string($koneksi, $data['nama']);
    $telpon = mysqli_real_escape_string($koneksi, $data['telpon']);
    $alamat = mysqli_real_escape_string($koneksi, $data['alamat']);
    $ketr   = mysqli_real_escape_string($koneksi, $data['ketr']);

    $sqlCustomer  = "UPDATE tbl_customer SET
                        nama      = '$nama',
                        telpon    = '$telpon',
                        deskripsi = '$ketr',
                        alamat    = '$alamat'
                    WHERE id_customer = $id
                    ";
    mysqli_query($koneksi, $sqlCustomer);

    return mysqli_affected_rows($koneksi);
}

?>