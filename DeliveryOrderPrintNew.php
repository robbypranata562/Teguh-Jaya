<?php include "header.php";?>
<?php
    $id = $_GET['id'];
     $sql_trans="
     SELECT
        a.`Code`,
        date(a.Date) as Date,
        format(a.Total,2) as TotalBelanja,
        format(a.Amount,2) as Amount,
        format(a.Balance,2) as PenggunaanSaldo,
        format(a.ChangeDue,2) as Kembalian,
        b.nama_pelanggan,
        b.hutang,
        b.alamat,
        b.nohp,
        b.id_pelanggan,
        format(b.saldo,2) as saldo
    FROM
        deliveryorder AS a
        LEFT JOIN pelanggan AS b ON a.Customer = b.id_pelanggan
    WHERE
        a.id = ".$id."";
     $exe_trans=mysqli_query($koneksi,$sql_trans);
     while($data=mysqli_fetch_array($exe_trans))
     {
        $noFaktur = $data['Code'];
        $Date = $data['Date'];
        $TotalBelanja = $data['TotalBelanja'];
        $Amount = $data['Amount'];
        $PenggunaanSaldo = $data['PenggunaanSaldo'];
        $Kembalian = $data['Kembalian'];
        $nama_pelanggan = $data['nama_pelanggan'];
        $IdPelanggan = $data['id_pelanggan'];
        $alamat = $data['alamat'];
        $nohp = $data['nohp'];
        $saldo = $data['saldo'];
     }

     $cek="SELECT
     aa.nama_pelanggan,
     aa.id_pelanggan,
     format(sum(aa.Hutang) - sum(aa.pembayaran),2) as Hutang
     from
     (
     SELECT
         a.nama_pelanggan,
         a.id_pelanggan,
         IFNULL(b.total, 0) AS Hutang,
         0 as pembayaran
     FROM
         pelanggan AS a
     LEFT JOIN ap AS b ON a.id_pelanggan = b.customer_id
     union ALL
     SELECT
         a.nama_pelanggan,
         a.id_pelanggan,
         0 as Hutang,
         IFNULL(b.total, 0) AS pembayaran
     FROM
         pelanggan AS a
     LEFT JOIN appayment AS b ON a.id_pelanggan = b.customer_id
     ) aa
     where aa.id_pelanggan = ".$IdPelanggan."
     group by aa.id_pelanggan";
     
     $k=mysqli_query($koneksi,$cek);
     while($data=mysqli_fetch_array($k))
     {
        $hutang = $data['Hutang'];
     }
?>
<div class="content-wrapper" id="printableArea">
<style type="text/css">
    @page 
    {
        size: auto;  
        margin: 2mm;
    }
    html 
    {

    }
    body 
    {

    }

    table 
    {
            border-collapse: collapse;
    }

        table, th, td {
        border: 1px solid black;
        }
</style>
  <section class="invoice">
    <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
            <img src="dist/img/TeguhJaya.png" class="img-circle" alt="User Image" width="100" height="100"><br>
            <address>
                Jln. Guntur no. 209 Garut<br>
                Tlp: (0262) 234395<br>
            </address>
        </div>
        <div class="col-sm-6 invoice-col">
        <address>
                No Faktur   : <?php echo $noFaktur ?> <br>
                No Hp       : <?php echo $nohp ?><br>
                Nama        : <?php echo $nama_pelanggan ?><br>
                Tanggal     : <?php echo $Date ?><br>
            </address>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            $no=1;
                            $sql_trans="
                            SELECT 
                                b.NamaBarang,
                                a.DeliveryQty,
                                format(a.UnitPrice,2) as UnitPrice,
                                format(a.TotalPrice,2) as TotalPrice
                            FROM
                                deliveryorderdetail AS a
                                LEFT JOIN item AS b ON a.ItemId = b.id
                            WHERE
                                a.DeliveryId = ".$id."";
                            $exe_trans=mysqli_query($koneksi,$sql_trans);
                            while($data=mysqli_fetch_array($exe_trans))
                            { ?>
                                <td><?php echo $no++;?></td>
                                <td><?php echo $data['NamaBarang'];?></td>
                                <td><?php echo $data['DeliveryQty'];?></td>
                                <td><?php echo $data['UnitPrice'];?></td>
                                <td><?php echo $data['TotalPrice'];?></td>
                    </tr>
                    <?php  } ?>
                    <tr>
                                <td colspan=4> Total </td>
                                <td> <?php echo $TotalBelanja ?> </td>
                    </tr>

                    <tr>
                                <td colspan=4> Tunai </td>
                                <td> <?php echo $Amount ?> </td>
                    </tr>
                    <tr>
                                <td colspan=4> Saldo </td>
                                <td> <?php echo $PenggunaanSaldo ?> </td>
                    </tr>
                    <tr>
                                <td colspan=4> Kembalian </td>
                                <td> <?php echo $Kembalian ?> </td>
                    </tr>
                    <tr>
                                <td colspan=4> Sisa Saldo </td>
                                <td> <b> <?php echo $saldo ?> </b>  </td>
                    </tr>
                    <tr>
                                <td colspan=4> Hutang </td>
                                <td> <b> <?php echo $hutang ?> </b>  </td>
                    </tr>


                </tbody>
            </table>
        </div>
    </div>
    <div class="row no-print">
        <div class="col-xs-12">
            <a href="javascript:print()"  class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>
  </section>
  <div class="clearfix"></div>
</div>
<script type="text/javascript"></script>
<?php include "footer.php";?>
<script type=application/javascript>document.links[0].href="data:text/html;charset=utf-8,"+encodeURIComponent('<!doctype html>'+document.documentElement.outerHTML)</script>