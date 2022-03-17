$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#btn_add').click(function () {
        $('#payroll_modal').modal('show');
        $('#payroll_id').val('');
    });

});

$(document).on('click', '.addHoliday', function () {
    $('#button-div').empty();
    $('#holidayName').val("");
    $('#holidayDate').val("");
    $('#holidayType').val("");
    $('#holidayModalLabel').text('Add Holiday');
    $('#button-div').append(
        '<button type="submit" class="btn btn-primary add-holiday"><span class="fas fa-check"></span> Submit</button>'
    );
    $('#holidayModal').modal('show');
});

$(document).on('click', '.edit', function () {
    var formData = new FormData();
    formData.append('holiday_id', $(this).val());
    $.ajax({
        url: "/system-param/holidays/edit",
        type: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
        $('#holidayModalLabel').text('Edit Holiday');
            $('#button-div').empty();
            $('#holidayID').val(response.id);
            $('#holidayName').val(response.holiday);
            $('#holidayDate').val(response.holiday_date);
            $('#holidayType').val(response.type_of_holiday);
            $('#button-div').append(
                '<button type="submit" class="btn btn-primary add-holiday"><span class="fas fa-check"></span> Update</button>'
            );
            $('#holidayModal').modal('show');
        },
        cache: false,
        contentType: false,
        processData: false
    })
});

$('#formAddHoliday').submit(function (e) {
    e.preventDefault();
    if ($('.add-holiday').text() == ' Submit') {
        Swal.fire({
            title: 'Proceed?',
            text: "Add New Holiday?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                var formData = new FormData();
                formData.append('holidayName', $('#holidayName').val());
                formData.append('holidayDate', $('#holidayDate').val());
                formData.append('holidayType', $('#holidayType').val());
                formData.append('action', 'add');
                $.ajax({
                    url: "/system-param/holidays/add",
                    type: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        Swal.fire(
                            response,
                            'New holiday added!',
                            'success'
                        ).then((result) => {
                            location.reload();
                        })
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                })
            }
        });
    }
    else{
        Swal.fire({
            title: 'Proceed?',
            text: "Update Holiday?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                var formData = new FormData();
                formData.append('id', $('#holidayID').val());
                formData.append('holidayName', $('#holidayName').val());
                formData.append('holidayDate', $('#holidayDate').val());
                formData.append('holidayType', $('#holidayType').val());
                formData.append('action', 'update');
                $.ajax({
                    url: "/system-param/holidays/add",
                    type: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        Swal.fire(
                            response,
                            'New holiday added!',
                            'success'
                        ).then((result) => {
                            location.reload();
                        })
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                })
            }
        });
    }
});

$(document).on('click', '.delete-holiday', function(){
    Swal.fire({
        title: 'Delete?',
        text: "Delete Holiday?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.value) {
            var formData = new FormData(); 
            formData.append('holiday_id', $(this).val());
            $.ajax({
                url: "/system-param/holidays/delete",
                type: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    Swal.fire(
                        response,
                        'Holiday deleted!',
                        'success'
                    ).then((result) => {
                        location.reload();
                    })
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    });
  });

function _edit(payroll_id) {
    var formData = new FormData();
    formData.append('payroll_id', payroll_id);
    $.ajax({
        url: global_path + "/hr/payroll/edit",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#payroll_modal').modal('show');
            $('#payroll_id').val(response.id);
            $('#payroll_type').val(response.payroll_type);
            $('#payroll_no').val(response.payroll_no);
            $('#fund_cluster').val(response.fund_cluster);
            $('#date_from').val(response.date_from);
            $('#date_to').val(response.date_to);
        },
        cache: false,
        contentType: false,
        processData: false
    })
}


function _delete(payroll_id, period) {
    Swal.fire({
        title: 'Delete payroll for the period of ' + period + ' from records?',
        text: 'NOTE: this will permanently delete the record',
        input: 'text',
        inputPlaceholder: 'Type "CONFIRM" to proceed',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Delete',
        showLoaderOnConfirm: true,
        preConfirm: (confirm) => {
            if (confirm != "CONFIRM") {
                Swal.showValidationMessage(
                    'Type CONFIRM to proceed'
                )
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.value) {
            var formData = new FormData();
            formData.append('payroll_id', payroll_id);
            $.ajax({
                url: global_path + "/hr/payroll/delete",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function () {
                    let timerInterval
                    Swal.fire({
                        title: 'Record successfully deleted',
                        html: 'refreshing page..',
                        timer: 1000,
                        onOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                                const content = Swal.getContent()
                                if (content) {
                                    const b = content.querySelector('b')
                                    if (b) {
                                        b.textContent = Swal.getTimerLeft()
                                    }
                                }
                            }, 100)
                        },
                        onClose: () => {
                            clearInterval(timerInterval)
                            window.location.href = global_path + "/hr/payroll";
                        }
                    })
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    })
}