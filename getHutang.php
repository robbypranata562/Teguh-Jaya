
<?php
include "koneksi.php";
$q = intval($_GET['q']);

  
$sql="SELECT * FROM suplier WHERE id_suplier = '".$q."'";
$exe=mysqli_query($koneksi,$sql);
        
while($data=mysqli_fetch_array($exe)){
    echo " <p>". $data['hutang'] ."</p>";
  
}

?>