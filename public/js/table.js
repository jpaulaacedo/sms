$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  $('.dataTable').DataTable({
    "ordering": false,
    "scrollX": false,
  });


  $('.printTable').DataTable({
    "ordering": false,
    "lengthChange": false,
    'fixedHeader': true,
    "searching": true,
    dom: 'Bfrtip',
    buttons: ['pdf', 'excel', 'print'],
  });

  $('.staffTable').DataTable({
    "ordering": false,
    "lengthChange": false,
    'fixedHeader': true,
    "searching": true,
    "scrollX": true,
    dom: 'Bfrtip',
    buttons: ['pdf', 'excel', 'print'],
  });

  oTable = $('.dtrTable').DataTable({
    "ordering": false,
    "scrollX": false,
    "searching": true,
    "sDom": "Blrtip",
    "pageLength": 31,
    buttons: [{
      extend: 'excelHtml5',
      text: '<i class="fa fa-file-excel"></i> Export to Excel',
      titleAttr: 'Copy to Excel'
    }],
  });

  oTable2 = $('.searchTable').DataTable({
    "ordering": false,
    "scrollX": false,
    "searching": true,
    "sDom": "Blrtip",
  });

  $('.text_search').keyup(function () {
    oTable.search($(this).val()).draw();
    oTable2.search($(this).val()).draw();
  })

  // DTR Filter

  $("#month_search").change(function () {
    var string = $("#month_search option:selected").text();
    oTable.columns(2).search(string).draw();
  })

  $("#year_search").change(function () {
    var string = $(this).val();
    oTable.columns(2).search(string).draw();
  })

  $("#division_search").change(function () {
    var string = $("#division_search option:selected").text();
    oTable.search(string).draw();
  })


  $("#month_emp").change(function () {
    var string = $("#month_emp option:selected").text();
    console.log(string);
    // oTable.columns(0).search(string).draw();
    oTable.search(string).draw();
  })


  // DTR Filter end

});


