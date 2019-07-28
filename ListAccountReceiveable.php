<?php include "header.php";?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Hutang
      </h1>
    </section>
    
    <section class="content">
      <div class="box">
        <div class="box-body">
          <table id="TARSupplier" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Nama Supplier</th>
                <th>Total Hutang</th>
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
		$('#TARSupplier').dataTable( {
			"bProcessing": true,
            "serverSide": true,
            "scrollX": true,
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                console.log(aData)
                return nRow;
            },
            "ajax": {
                        "url": "search_AR_ALL_Supplier.php",
                        "type": "POST",
                        "data": function (d) 
                        {
                        }
                    },
        });
});
</script>
 
 