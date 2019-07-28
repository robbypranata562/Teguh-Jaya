<?php
  include "koneksi.php";
    $user=$_POST['username'];
    $pass=md5($_POST['password']);
    $res="select * from admin, karyawan where admin.id_karyawan=karyawan.id and uname='$user' and pass='$pass'";
    $exe=mysqli_query($koneksi,$res);
    $data=mysqli_fetch_array($exe);
    $id_admin=$data['id_karyawan'];
    $nm=$data['nama'];
    $name=$data['uname'];
    $word=$data['pass'];
    $jabatan=$data['level'];
    $result = "";
    if($user==$name && $pass==$word)
    {
        if($jabatan=='Super Super Admin')
        {
            $result = "OK";
        }
        else
        {
            $result = "Maaf Jabatan Anda Bukan Super Super Admin Silahkan Hubungi Super Super Admin";
        }
    }
    else
    {
        $result = "Username Dan Atau Password Salah";
    }
    echo json_encode($result);
?>