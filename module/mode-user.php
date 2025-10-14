<?php

if (userLogin()['level'] != 1) {
    header("location:" . $main_url . "error-page.php");
    exit();
}

function insert($data){
    global $koneksi;

    $username   = trim(strtolower(mysqli_real_escape_string($koneksi, $data['username'])));
    $fullname   = mysqli_real_escape_string($koneksi, $data['fullname']);
    $password   = mysqli_real_escape_string($koneksi, $data['password']);
    $password2  = mysqli_real_escape_string($koneksi, $data['password2']);
    $level      = mysqli_real_escape_string($koneksi, $data['level']);
    $address    = mysqli_real_escape_string($koneksi, $data['address']);
    $gambar     = mysqli_real_escape_string($koneksi, $_FILES['image']['name']);
    
    if ($password !== $password2) {
        echo "<script>
                alert('Konfirmasi Password Tidak Sesuai.');
             </script>";
        return false;     
    }

    $pass   = password_hash($password, PASSWORD_DEFAULT);

    $cekUsername    = mysqli_query($koneksi, "SELECT username FROM tbl_user WHERE username = '$username'");
    if (mysqli_num_rows($cekUsername) > 0) {
        echo "<script>
                alert('Username Sudah Terpakai.');
            </script>";
        return false;
    }
    
    if ($_FILES['image']['name'] != '') {
        $gambar = uploadimg();
    } else {
        $gambar = 'pp.jpg';
    }

    // gambar tidak sesuai validasi
    if ($gambar == '') {
        return false;
    }

    $sqlUser = "INSERT INTO tbl_user 
            (username, fullname, password, address, level, foto) 
            VALUES 
            ('$username', '$fullname', '$pass', '$address', '$level', '$gambar')";

    mysqli_query($koneksi, $sqlUser);
    return mysqli_affected_rows($koneksi);
}

function delete($id, $foto){
    global $koneksi;

    $id = (int)$id;
    $sqlDel = "DELETE FROM tbl_user WHERE userid = $id";
    mysqli_query($koneksi, $sqlDel);
    if ($foto != 'pp.jpg'){
        unlink('../asset/image/' . $foto);
    }

    return mysqli_affected_rows($koneksi);
}

function selectUser1($level){
    $result = null;
    if ($level == 1) {
        $result = "selected";
    }
    return $result;
}

function selectUser2($level){
    $result = null;
    if ($level == 2) {
        $result = "selected";
    }
    return $result;
}

function update($data)
{
    global $koneksi;

    $iduser     = mysqli_real_escape_string($koneksi, $data['id']);
    $username   = trim(strtolower(mysqli_real_escape_string($koneksi, $data['username'])));
    $fullname   = mysqli_real_escape_string($koneksi, $data['fullname']);
    $level      = mysqli_real_escape_string($koneksi, $data['level']);
    $address    = mysqli_real_escape_string($koneksi, $data['address']);
    $gambar     = mysqli_real_escape_string($koneksi, $_FILES['image']['name']);
    $fotoLama   = mysqli_real_escape_string($koneksi, $data['oldImg']);

    // cek username sekarang
    $queryUsername = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE userid = $iduser");
    $dataUsername  = mysqli_fetch_assoc($queryUsername);
    $curlUssername = $dataUsername['username'];

    // cek username baru
    $newUsername    = mysqli_query($koneksi, "SELECT username FROM tbl_user WHERE username = '$username'");

    if($username !== $curlUssername) {
        if (mysqli_num_rows($newUsername)) {
            echo "<script>
                alert('Username Sudah Terpakai.');
                document.location.href = 'data-user.php';
                </script>";
        return false;
        }
    }

    // cek gambar
    if ($gambar != null) {
        $url     = "data-user.php";
        $imgUser = uploadimg($url);
        if ($fotoLama != 'pp.jpg') {
            @unlink('../asset/image'. $fotoLama);
        }
    } else {
        $imgUser = $fotoLama;
    }

    $result = mysqli_query($koneksi, "UPDATE tbl_user SET
                            username   = '$username',
                            fullname   = '$fullname',
                            address    = '$address',
                            level      = '$level',
                            foto       = '$imgUser'
                            WHERE userid = '$iduser'
                            ");

    return mysqli_affected_rows($koneksi);
}
