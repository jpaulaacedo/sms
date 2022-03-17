
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    hide_range();
    $("#dates_table").on('click', '.btnDelete', function () {
        let tr = $(this).closest('tr');
        let a = parseFloat(tr.find('option:selected').val());
        var coc_hours = parseFloat($('#coc_hours').val());
        $('#coc_hours').val(coc_hours + a);

        $(this).closest('tr').remove();
    });



    var minDate, maxDate;

    // Custom filtering function which will search data in column four between two values
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var min = minDate.val();
            var max = maxDate.val();
            var date = new Date(data[0]);

            if (
                (min === null && max === null) ||
                (min === null && date <= max) ||
                (min <= date && max === null) ||
                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        }
    );

    // Create date inputs
    minDate = new DateTime($('#min'), {
        format: 'MMMM Do YYYY'
    });
    maxDate = new DateTime($('#max'), {
        format: 'MMMM Do YYYY'
    });

    // DataTables initialisation
    var table = $('#cto_table').DataTable({
        processing: true,
        serverSide: false,
        searching: true,
        "ordering": false,
        "pageLength": 5,
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        autoWidth: false,
        order: [
            [0, "desc"],
        ],
    });

    // Refilter the table
    $('#min, #max').on('change', function () {
        table.draw();
    });
});

function getTableData() {
    var table_dates = [];
    $("#dates_table").find('tr').each(function (i, el) {
        var $tds = $(this).find('td');
        var $hours = $(this).find('option:selected');
        table_dates.push({
            my_dates: moment(new Date($tds.eq(0).text())).format('YYYY-MM-DD'),
            my_hours: $hours.eq(0).text(),
        });

    });
    return table_dates;
}

function getTotalHours() {
    var table = $('#dates_table').DataTable();
    table.column(1).data().sum()

}


function btnClear() {
    $("#my_tbody").empty();
}

function add_date_range(date_start, date_end) {
    var end = new Date(date_end);
    var my_dates = [];
    for (var d = new Date(date_start); d <= end; d.setDate(d.getDate() + 1)) {
        my_dates.push(moment(new Date(d)).format('YYYY-MM-DD'));
    }

    if (my_dates.length != 0) {
        for (i = 0; i < my_dates.length; i++) {
            add_date(my_dates[i]);
        }
    }
}

function add_date(my_date) {

    if ($('#coc_hours').val() < 4) {
        Swal.fire(
            "Warning!",
            'Remaining COCs are less than 4 hours.',
            'warning'
        )
    }
    else {
        if (my_date != "") {

            var ctr = 0;

            $.each(getTableData(), function (key, value,) {
                if (my_date == value.my_dates) {
                    Swal.fire(
                        value.my_dates + " is already filed.",
                        'Cannot add to list.',
                        'info'
                    )
                    ctr++;
                }
            });

            if (ctr <= 0) {
                var formData = new FormData();
                formData.append('my_date', my_date);
                $.ajax({
                    url: global_path + "/cto/check_dates",
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response != 'clear') {
                            Swal.fire(
                                response,
                                'Cannot add to list.',
                                'info'
                            )
                        } else {
                            $.ajax({
                                url: global_path + "/leaves/check_holiday",
                                method: 'post',
                                data: formData,
                                dataType: 'json',
                                success: function (response2) {
                                    if (response2 != 'clear') {
                                        Swal.fire(
                                            response2,
                                            'Cannot add to list.',
                                            'info'
                                        )
                                    } else {
                                        $("#my_tbody").append(
                                            '<tr>' +
                                            '<td>' + moment(new Date(my_date)).format('MMM D, YYYY (ddd)') + '</td>' +
                                            '<td width="30%" class="text-center">' +
                                            '<select name="cto_type" class="custom-select mb-3" id="cto_type">' +
                                            '<option value="4" selected>4 hours</option>' +
                                            '<option value="8">8 hours</option>' +
                                            '</select></td>' +
                                            '<td><button data-valdate="4" class="btn btn-circle btn-sm btn-danger btnDelete"><span class="fa fa-trash"></span></button></td>' +
                                            '</tr>'
                                        );
                                    }
                                },
                                cache: false,
                                contentType: false,
                                processData: false
                            })
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                })
                var coc_hours = $('#coc_hours').val();
                $('#coc_hours').val(coc_hours - 4);
            }
        }
        else {
            Swal.fire(
                "Warning!",
                'Please select COC.',
                'warning'
            )
        }
    }

}

var is_weekend = function (date1) {
    var dt = new Date(date1);

    if (dt.getDay() == 6 || dt.getDay() == 0) {
        return "weekend";
    }
}

function hide_range() {
    $("#div_range").hide();
    $("#div_range2").hide();
    $("#div_range3").hide();
    $("#div_range4").hide();
    $("#div_single").show();
    $("#div_single2").show();
}

function show_range() {
    $("#div_range").show();
    $("#div_range2").show();
    $("#div_range3").show();
    $("#div_range4").show();
    $("#div_single").hide();
    $("#div_single2").hide();
}

$(document).on('click', '.file_cto', function () {
    $('#button-div').empty();
    $("#my_tbody").empty();
    $('#cto_id').val("");
    $('#emp_id').val("");
    $('#modal_title').text('File CTO');
    $('#button-div').append(
        '<button type="submit" class="btn btn-primary file-ot"><span class="fas fa-check"></span> Submit</button>'
    );
    $('#file_cto_modal').modal('show');
});

$('#formRequest').submit(function (e) {
    e.preventDefault();
    if (getTableData() == "" || $('#coc_hours').val() == 0) {
        Swal.fire(
            "Warning!",
            'Required field(s) missing.',
            'warning'
        )
    }
    else {
        form_submit();
    }
});

var coc_table = $('#coc_table').DataTable(
    {
        'order': [[1, 'asc']],
        "ordering": false,
        "pageLength": 10,
        searching: false,
        paging: false,
        info: false
    }
);

// $('#example-select-all').on('click', function () {
//     var rows = coc_table.rows({ 'search': 'applied' }).nodes();
//     $('input[type="checkbox"]', rows).prop('checked', this.checked);
// });

$(document).on('click', '.select_coc', function () {
    $('#button-div').empty();
    $("#my_tbody").empty();
    $('#cto_id').val("");
    $('#emp_id').val("");
    $('#modal_title').text('File CTO');
    $('#button-div').append(
        '<button type="submit" class="btn btn-primary file-ot"><span class="fas fa-check"></span> Submit</button>'
    );
    $('#file_cto_modal').modal('show');
});

function form_submit() {
    Swal.fire({
        title: 'Proceed?',
        text: "File CTO?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.value) {
            // $('#overlay').fadeIn();
            var formData = new FormData();
            formData.append('my_dates', JSON.stringify(getTableData()));
            formData.append('date_filed', $('#date_filed').val());
            formData.append('remaining_coc', parseFloat($('#coc_hours').val()));
            formData.append('coc_total', parseFloat($('#coc_diff').val()));
            $.ajax({
                url: "/cto/file_cto",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    // console.log(response);
                    $('#overlay').delay(100).fadeOut('fast', function () {
                        Swal.fire(
                            response,
                            'CTO has been filed!',
                            'success'
                        ).then((result) => {
                            location.reload();
                        })
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    });
}

$(document).on('click', '.view', function () {
    var formData = new FormData();
    formData.append('cto_id', $(this).val());
    $.ajax({
        url: "/cto/edit_cto",
        type: 'post',
        data: formData,
        dataType: 'json',
        success: function ([response, response2]) {
            $('#button-div2').empty();
            $("#my_tbody2").empty();
            $('#modal_title2').text('View CTO');
            $('#view_cto_modal').modal('show');
            $('#view_type').val('For DC Approval');
            $.each(response2, function (key, value,) {
                $('#my_tbody2').append(
                    '<tr>' +
                    '<td>' + value.cto_date + '</td><td>' + value.hours + ' hours</td>' +
                    '</tr>'
                )
            });
            if ((response.status == 'For DC Approval' && $('#user_type').val() == 2) || (response.status == 'For ED Approval' && $('#user_type').val() == 4)) {
                $('#button-div2').append(
                    '<button type="submit" class="btn btn-primary approve"><span class="fas fa-check"></span>&nbspApprove</button>' +
                    ' <button class="btn btn-danger disapprove"><span class="fas fa-times"></span>&nbspDisapprove</button>'
                );
            }
            else {
                $('#button-div2').append(
                    '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'
                );
            }
            $('#cto_id').val(response.id);
        },
        cache: false,
        contentType: false,
        processData: false
    })
});

$(document).on('click', '.approve', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Approve?',
        text: "Approve CTO request?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.value) {
            $('#overlay').fadeIn();
            var formData = new FormData();
            formData.append('id', $('#cto_id').val());
            formData.append('emp_id', $('#user_id').val());
            formData.append('status', 'app');
            formData.append('reason_disapproval', "");
            $.ajax({
                url: "/cto/approvedisapprove",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    $('#overlay').delay(100).fadeOut('fast', function () {
                        Swal.fire(
                            response,
                            'CTO has been approved!',
                            'success'
                        ).then((result) => {
                            location.reload();
                        })
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    });
});

$(document).on('click', '.disapprove', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Reason for Disapproval',
        html: '<textarea class="form-control" id="reason_disapproval" rows="5"></textarea>',
        text: "Disapprove Overtime request?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed',
        preConfirm: () => {
            const reason_disapproval = Swal.getPopup().querySelector('#reason_disapproval').value
            if (!reason_disapproval) {
                Swal.showValidationMessage(`Please provide your reason`)
            }
        }
    }).then((result) => {
        if (result.value) {
            $('#overlay').fadeIn();
            var formData = new FormData();
            var reason_disapproval = $('#reason_disapproval').val();
            formData.append('reason_disapproval', reason_disapproval);
            formData.append('id', $('#cto_id').val());
            formData.append('emp_id', $('#user_id').val());
            formData.append('status', 'disapp');
            $.ajax({
                url: "/cto/approvedisapprove",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    $('#overlay').delay(100).fadeOut('fast', function () {
                        Swal.fire(
                            response,
                            'CTO has been disapproved!',
                            'success'
                        ).then((result) => {
                            location.reload();
                        })
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    });
});

$(document).on('click', '.cancel', function () {
    // alert($(this).val());
    Swal.fire({
        title: 'Warning!',
        text: "Cancel CTO?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.value) {
            $('#overlay').fadeIn();
            var formData = new FormData();
            formData.append('id', $(this).val());
            formData.append('emp_id', $('#user_id').val());
            $.ajax({
                url: "/cto/cancel",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    $('#overlay').delay(100).fadeOut('fast', function () {
                        Swal.fire(
                            response,
                            'CTO has been cancelled!',
                            'success'
                        ).then((result) => {
                            location.reload();
                        })
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    });
});


// function get_coc_hours() {
//     var searchIDs = $("input[name='no_id']:checked").map(function () {
//         return $(this).val();
//     });

//     var formData = new FormData();
//     formData.append('coc_id', searchIDs.get());
//     $.ajax({
//         url: "/cto/view_coc",
//         type: 'post',
//         data: formData,
//         dataType: 'json',
//         success: function (response) {
//             $('#coc_hours').val(response);
//             $('#coc_ids').val(searchIDs.get());
//         },
//         cache: false,
//         contentType: false,
//         processData: false
//     })
// }

// $("input[name='select_all']").click(function () {
//     get_coc_hours();
// });

// $("input[name='no_id']").click(function () {
//     get_coc_hours();
// });


$("#dates_table").on('change', '#cto_type', function () {
    var cto_type = parseFloat($(this).val());
    var coc_hours = parseFloat($('#coc_hours').val());

    if (coc_hours < 4) {
        Swal.fire(
            "Warning!",
            'Remaining hours are less than 4.',
            'warning'
        )
        $(this).val(4);
    }
    else {
        if (cto_type == 4) {
            var prev = 8;
        }
        else {
            var prev = 4;
        }
        $('#coc_hours').val(coc_hours - cto_type + prev);

    }

});


