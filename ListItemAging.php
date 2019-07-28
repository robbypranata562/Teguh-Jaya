<?php include "header.php";?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Umur Barang
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-body">
          <table id="THistory" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Nama Pelanggan</th>
                <th>Umur Barang Normal</th>
                <th>Umur Barang Maksimal</th>
                <th>Umur Barang</th>
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
    "bProcessing": true,
    "serverSide": true,
    "scrollX": true,
    "order": [[ 1, "desc" ]],
    "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        var category = "";
        if (aData[3] > aData[1])
        {
            $(nRow).addClass("yellow-row-class");
        }
        else if (aData[3] > aData[2] )
        {
            $(nRow).addClass("red-row-class");
        }
        return nRow;
    },
    "ajax":
            {
                "url": "search_item_aging.php",
                "type": "POST",
                "data": function (d) {
                }
            },
    });

    $("#btnSearchHistory").on("click",function(){
      $("#THistory").DataTable().draw();
    });
});
</script>
