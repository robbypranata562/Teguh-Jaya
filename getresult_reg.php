<?php
include 'koneksi.php';
	session_start();
				if(!isset($_SESSION['uname'])){
					echo"<script>window.location.assign('index.php')</script>";
				}
?>
<!DOCTYPE html>

<html>
<head>
 
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$q = intval($_GET['q']);

$sql="SELECT * FROM karyawan WHERE id = '".$q."'";
$result = mysqli_query($koneksi,$sql);

while($row = mysqli_fetch_array($result)) {
?>

<div class="form-group">
                  <label for="exampleInputEmail1">Username</label>
                  <input type="text" name="user" class="form-control" id="exampleInputEmail1">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Password</label>
                  <input type="text" name="password" class="form-control" id="exampleInputEmail1">
                </div>
				
				<div class="form-group">
		
                <label>Level</label>
                <select class="form-control select2"   style="width: 100%;" name="level">
				<option value="">Pilih Level:</option>
                  
					<?php $jabatan=$_SESSION['level']?>
					<?php if ($jabatan=='Super Super Admin'){
		?>
                  <option name="level" value="Super Admin"   >Super Admin</option>
					<?php } ?>
				  <option name="level" value="Stok Admin"   >Stok Admin</option>
				  <option name="level" value="Admin"   >Admin</option>
                 
                </select>
              </div>
				

<?php
 }

?>



</body>
</html>