<?php include "header.php";?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Piutang
      </h1>
    </section>
    
    <section class="content">
      <div class="box">
        <div class="box-body">
          <table id="TAPCustomer" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Nama Pelanggan</th>
                <th>Details</th>
                <th>Total Piutang</th>
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
		$('#TAPCustomer').dataTable( {
			"bProcessing": true,
            "serverSide": true,
            "scrollX": true,
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                var details = "<a class='btn btn-success' href='DetailAccountPayableByCustomer.php?customer_id="+aData[1]+"'> <span class='glyphicon glyphicon-eye'></span> Details</a>";
                $('td:eq(0)', nRow).html(aData[0]);
                $('td:eq(1)', nRow).html(details);
                $('td:eq(2)', nRow).html(aData[2]);
              return nRow;
            },
            "ajax": {
                        "url": "search_AP_ALL_Customer.php",
                        "type": "POST",
                        "data": function (d) 
                        {
                        }
                    },
        });
});
</script>
 
 