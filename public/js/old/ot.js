
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    hide_range();
    $("#dates_table").on('click', '.btnDelete', function () {
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
    var table = $('#ot_table').DataTable({
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
        table_dates.push(moment(new Date($tds.eq(0).text())).format('YYYY-MM-DD'))
    });
    return table_dates;
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
    if (my_date != "") {
        var i;
        var ctr = 0;
        for (i = 0; i < getTableData().length; ++i) {
            if (my_date == getTableData()[i]) {
                ctr++;
            }
        }
        if (ctr <= 0) {
            var formData = new FormData();
            formData.append('my_date', my_date);
            $.ajax({
                url: global_path + "/employee/ot/check_dates",
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
                                        '<td class="text-center"><button class="btn btn-circle btn-sm btn-danger btnDelete"><span class="fa fa-trash"></span></button></td>' +
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
        }
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

$('#searchCourse').keyup(function () {
    oTable.search($(this).val()).draw();
});

$(document).on('click', '.file_ot', function () {
    $('#button-div').empty();
    $("#my_tbody").empty();
    $('#date_filed').val(moment().format('YYYY-MM-DD'));
    $('#day_type').val("");
    $('#num_hours').val("");
    $('#ot_type').val("");
    $('#start_time').val("");
    $('#purpose').val("");
    $('#ot_id').val("");
    $('#emp_id').val("");
    $('#modal_title').text('File Overtime');
    $('#button-div').append(
        '<button type="submit" class="btn btn-primary file-ot"><span class="fas fa-check"></span> Submit</button>'
    );
    $('#file_overtime_modal').modal('show');
});

$('#formRequest').submit(function (e) {
    e.preventDefault();
    // alert($('#ot_id').val());
    if (getTableData() == "") {
        Swal.fire(
            'Required field(s) missing.',
            'Please indicate Overtime date/s.',
            'warning'
        )
    }
    else {
        if ($('.file-ot').text() == ' Submit') {
            Swal.fire({
                title: 'Proceed?',
                text: "File Overtime?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {
                    $('#overlay').fadeIn();
                    var formData = new FormData();
                    formData.append('my_dates', getTableData());
                    formData.append('day_type', $('#day_type').val());
                    formData.append('date_filed', $('#date_filed').val());
                    formData.append('num_hours', $('#num_hours').val());
                    formData.append('ot_type', $('#ot_type').val());
                    formData.append('start_time', $('#start_time').val());
                    formData.append('purpose', $('#purpose').val());
                    formData.append('ot_id', $('#ot_id').val());
                    formData.append('emp_id', $('#user_id').val());
                    formData.append('filed_by', 'emp');
                    $.ajax({
                        url: "/employee/ot/file_ot",
                        method: 'post',
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                            $('#overlay').delay(100).fadeOut('fast', function () {
                                Swal.fire(
                                    response,
                                    'Your Overtime has been filed!',
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
        else if ($('.file-ot').text() == ' Update') {
            Swal.fire({
                title: 'Update?',
                text: "Update Filed Overtime?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {
                    $('#overlay').fadeIn();
                    var formData = new FormData();
                    formData.append('my_dates', getTableData());
                    formData.append('day_type', $('#day_type').val());
                    formData.append('date_filed', $('#date_filed').val());
                    formData.append('num_hours', $('#num_hours').val());
                    formData.append('ot_type', $('#ot_type').val());
                    formData.append('start_time', $('#start_time').val());
                    formData.append('purpose', $('#purpose').val());
                    formData.append('ot_id', $('#ot_id').val());
                    formData.append('emp_id', $('#user_id').val());
                    $.ajax({
                        url: "/employee/ot/file_ot",
                        method: 'post',
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                            $('#overlay').delay(100).fadeOut('fast', function () {
                                Swal.fire(
                                    response,
                                    'OT has been updated!',
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
    }
});

$(document).on('click', '.view', function () {
    var formData = new FormData();
    formData.append('ot_id', $(this).data('ot_id'));
    formData.append('id', $(this).val());
    $.ajax({
        url: '/employee/ot/edit',
        type: 'post',
        data: formData,
        dataType: 'json',
        success: function ([response, response2]) {
            $('.modal-footer').empty();
            $("#my_tbody2").empty();
            $('#modal_title2').text('Edit Overtime');
            $('#view_overtime_modal').modal('show');
            $('#date_filed2').val(response.date_filed);
            $('#day_type2').val(response.day_type);
            $('#num_hours2').val(response.ot_hours);
            $('#ot_type2').val(response.ot_type);
            $('#start_time2').val(response.start_time);
            $('#purpose2').val(response.purpose);
            $('#ot_status').val(response.status);
            $('#view_type').val('Pending');
            $.each(response2, function (key, value,) {
                $('#my_tbody2').append(
                    '<tr>' +
                    '<td>' + value.inclusive_date + '</td>' +
                    '</tr>'
                )
            });
            if ((response.status == 'For DC Approval' && $('#user_type').val() == 2) || (response.status == 'For DC Approval' && $('#user_type').val() == 4) || (response.status == 'For ED Approval' && $('#user_type2').val() == 4)) {
                $('.modal-footer').append(
                    '<button type="submit" class="btn btn-primary approve"><span class="fas fa-check"></span>&nbspApprove</button>' +
                    ' <button class="btn btn-danger disapprove"><span class="fas fa-times"></span>&nbspDisapprove</button>'
                );
            }
            else {
                $('.modal-footer').append(
                    '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'
                );
            }
            $('#ot_id').val(response.id);
        },
        cache: false,
        contentType: false,
        processData: false
    })
});

$(document).on('click', '.cancel', function () {
    Swal.fire({
        title: 'Warning!',
        text: "Cancel Overtime?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.value) {
            $('#overlay').fadeIn();
            var formData = new FormData();
            formData.append('ot_id', $(this).val());
            formData.append('user_id', $('#user_id').val());
            $.ajax({
                url: "/employee/ot/cancel",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    $('#overlay').delay(100).fadeOut('fast', function () {
                        Swal.fire(
                            response,
                            'Overtime has been cancelled!',
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

$(document).on('click', '.approve', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Approve?',
        text: "Approve Overtime request?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.value) {
            $('#overlay').fadeIn();
            var formData = new FormData();
            formData.append('id', $('#ot_id').val());
            formData.append('emp_id', $('#user_id').val());
            formData.append('view_type', $('#view_type').val());
            formData.append('status', 'app');
            formData.append('reason_disapproval', "");
            $.ajax({
                url: "/employee/ot/approvedisapprove",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    $('#overlay').delay(100).fadeOut('fast', function () {
                        Swal.fire(
                            response,
                            'Overtime has been approved!',
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
            formData.append('id', $('#ot_id').val());
            formData.append('emp_id', $('#user_id').val());
            formData.append('view_type', $('#view_type').val());
            formData.append('status', 'disapp');
            $.ajax({
                url: "/employee/ot/approvedisapprove",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    $('#overlay').delay(100).fadeOut('fast', function () {
                        Swal.fire(
                            response,
                            'Overtime has been disapproved!',
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


