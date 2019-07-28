<?php
session_start();
if($_SESSION){
	header("Location: home.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Teguh Jaya Administrator</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Teguh</b>Jaya</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
  <?php
  include "koneksi.php";
if(isset($_POST['login'])){
    $user=$_POST['username'];
    $pass=md5($_POST['password']);
    $res="select * from admin, karyawan where admin.id_karyawan=karyawan.id and uname='$user' and pass='$pass'";
    $exe=mysqli_query($koneksi,$res);
    $data=mysqli_fetch_array($exe);
    $id_admin=$data['id_karyawan'];
    $nm=$data['nama'];
    $name=$data['uname'];
    $word=$data['pass'];
    $foto=$data['foto'];
    $jabatan=$data['level'];
    $id=$data['id_admin'];
     
     if($user==$name && $pass==$word){
          if($jabatan=='Super Super Admin'){
               //session_start();
			   $adm_id= $_SESSION['id_admin']=$id;
			   $id_adm = $_SESSION['id_karyawan']=$id_admin;
               $nama= $_SESSION['nama']=$nm;
               $uname= $_SESSION['uname']=$name;
			   $_SESSION['foto']=$foto;
			   $jab= $_SESSION['level']=$jabatan;
				$sql_his="INSERT INTO his_login VALUES(NULL,'$id_adm','$uname','$jab',NOW())";
				$exe_his=mysqli_query($koneksi,$sql_his);
               echo '<script>window.location.assign("home.php")</script>';
	 }else if($jabatan=='Super Admin'){
               //session_start();
			   $adm_id= $_SESSION['id_admin']=$id;
                $id_adm = $_SESSION['id_karyawan']=$id_admin;
               $nama= $_SESSION['nama']=$nm;
               $uname= $_SESSION['uname']=$name;
			   $_SESSION['foto']=$foto;
			   $jab= $_SESSION['level']=$jabatan;
				$sql_his="INSERT INTO his_login VALUES(NULL,'$id_adm','$uname','$jab',NOW())";
				$exe_his=mysqli_query($koneksi,$sql_his);
               
               echo '<script>window.location.assign("home.php")</script>';
	 }else if($jabatan=='Stok Admin'){
               //session_start();
			   $adm_id= $_SESSION['id_admin']=$id;
                $id_adm = $_SESSION['id_karyawan']=$id_admin;
               $nama= $_SESSION['nama']=$nm;
               $uname= $_SESSION['uname']=$name;
			   $_SESSION['foto']=$foto;
			   $jab= $_SESSION['level']=$jabatan;
				$sql_his="INSERT INTO his_login VALUES(NULL,'$id_adm','$uname','$jab',NOW())";
				$exe_his=mysqli_query($koneksi,$sql_his);
               
               echo '<script>window.location.assign("home.php")</script>';
	 }else if($jabatan=='Admin'){
               //session_start();
			   $adm_id= $_SESSION['id_admin']=$id;
                $id_adm = $_SESSION['id_karyawan']=$id_admin;
               $nama= $_SESSION['nama']=$nm;
               $uname= $_SESSION['uname']=$name;
			   $_SESSION['foto']=$foto;
			   $jab= $_SESSION['level']=$jabatan;
				$sql_his="INSERT INTO his_login VALUES(NULL,'$id_adm','$uname','$jab',NOW())";
				$exe_his=mysqli_query($koneksi,$sql_his);
               
               echo '<script>window.location.assign("home.php")</script>';
	 }
}
else{
	echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        Username dan Password salah !
                                    </div>";
}
}
			   ?>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Masuk</button>
        </div>
      </div>
    </form>

    
    <!-- /.social-auth-links -->

    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>

</body>
</html>
