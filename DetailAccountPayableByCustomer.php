<?php include "header.php";
$customer_id = $_GET['customer_id'];
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Detail Piutang By Pelanggan
      </h1>
    </section>
    
    <section class="content">
      <div class="box">
        <div class="box-body">
          <table id="TAPCustomerDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No Faktur</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Total Transaksi</th>
                <th>Hutang</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </section>
  </div>
<?php include "footer.php";?>
<script type="text/javascript">
  $(document).ready(function() {
		$('#TAPCustomerDetail').dataTable( {
			"bProcessing": true,
            "serverSide": true,
            "scrollX": true,
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                return nRow;
            },
            "ajax": {
                        "url": "searh_detail_ap_by_customer.php",
                        "type": "POST",
                        "data": function (d) 
                        {
                          d.id=<?php echo $customer_id; ?>
                        }
                    },
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            var monTotal = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 0 ).footer() ).html('Total');
            $( api.column( 4 ).footer() ).html(monTotal);
        }
    } );
});
</script>
 
 