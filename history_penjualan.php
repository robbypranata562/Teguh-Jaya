<?php include "header.php";?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        History Penjualan
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-body">
          <div class="col-md-6">
            <div class="row">
              <div class="form-group">
              <label for="exampleInputDate">Tanggal Awal</label>
              <div class="input-group date">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input type="text" autocomplete="off" class="form-control pull-right" id="StartDate" name="StartDate" data-error="Tanggal Tidak Boleh Kosong" required>
              <div class="help-block with-errors"></div>
              </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="form-group">
              <label for="exampleInputDate">Tanggal Akhir</label>
              <div class="input-group date">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input type="text" autocomplete="off" class="form-control pull-right" id="EndDate" name="EndDate" data-error="Tanggal Tidak Boleh Kosong" required>
              <div class="help-block with-errors"></div>
              </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
          <div class="form-group">
            <button type="button" class="btn btn-primary" id="btnSearchHistory" name="btnSearchHistory"> Search </button>
          </div>
          </div>
          <table id="THistory" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No Faktur</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga Modal</th>
                <th>Harga Jual</th>
                <th>Total Modal</th>
                <th>Total Pendapatan</th>
                <th>Bersih</th>
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
    var currDate = new Date();
    $('#StartDate').datepicker({
     autoclose: true,
     defaultDate: currDate
   });

   $('#EndDate').datepicker({
    defaultDate: currDate,
     autoclose: true
   });

		$('#THistory').dataTable( {
      "dom": "Bfrtip",
			"bProcessing": true,
      "serverSide": true,
      "scrollX": true,
      "buttons": [
            "excel"
        ],
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        console.log(aData)
        return nRow;
      },
      "ajax": {
                "url": "search_total_transaction_by_date.php",
                "type": "POST",
                "data": function (d) {
                    d.StartDate = $("#StartDate").val(),
                    d.EndDate = $("#EndDate").val()
                }
            },
    });
    
    $("#btnSearchHistory").on("click",function(){
      $("#THistory").DataTable().draw();
    });
});
</script>
 
 