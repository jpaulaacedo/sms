$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

//SAVE VEHICLE : CREATE NEW VEHICLE REQ
function _addRequest() {
    $('#trip_modal').modal('show');
    $('#subject').val("");
    $('#vehicle_id').val("");
    $('#icon_submit').removeClass('fa-check');
    $('#icon_submit').addClass('fa-plus');
    $('#btn_submit').html("Create");
}

// ENABLE SUBMIT REQUEST ONLY IF RECIPIENT IS NOT EMPTY
$(function () {
    var rowCount = $('#tickets_table tbody tr').length;
    if (rowCount < 1) {
        $('#submit_button').attr('disabled', 'disabled');
    } else {
        $('#submit_button').removeAttr('disabled');
    }
});

function getTableData() {
    var table_dates = [];
    $("#dates_table").find('tr').each(function (i, el) {
        var $tds = $(this).find('td');
        table_dates.push(moment(new Date($tds.eq(0).text())).format('YYYY-MM-DD'))
    });
    return table_dates;
}
function _addPassenger(vehicle_id, date_req, date_needed) {
    $("#passenger").val("");
    $("#psg_vehicle_id").val(vehicle_id);
    _loadPassenger(vehicle_id);
    _loadVehicle(vehicle_id);
    $("#submit_button").show();
    $("#passenger").show();
    $("#asterisk").html("");
    $("#psg_count").html("");
    $("#lbl_passenger").html("Add Passenger:");
    $("#btn_passenger").show();
    $("#td_date_needed").html(date_needed);
    $("#td_date_req").html(date_req);
    $("#submit_psg_id").val(vehicle_id);
}

function _viewPassenger(vehicle_id, date_req, date_needed) {
    $("#passenger").val("");
    $("#psg_vehicle_id").val(vehicle_id);
    _viewloadPassenger(vehicle_id);
    _loadVehicle(vehicle_id);
    $("#lbl_passenger").html("Passenger(s):");
    $("#passenger").hide();
    $("#psg_count").html("");
    $("#asterisk").html("");
    $("#btn_passenger").hide();
    $("#submit_button").hide();
    $("#td_date_needed").html(date_needed);
    $("#td_date_req").html(date_req);
    $("#submit_psg_id").val("");
}


function _loadVehicle(vehicle_id) {
    var formData = new FormData();
    formData.append('vehicle_id', vehicle_id);
    $.ajax({
        url: global_path + "/vehicle/view/vehicle",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $("#td_purpose").html(response.purpose);
            $("#td_destination").html(response.destination);
            $("#td_status").html(response.status);

        },
        cache: false,
        contentType: false,
        processData: false
    })
}
function _loadPassenger(vehicle_id) {
    var formData = new FormData();
    formData.append('vehicle_id', vehicle_id);
    $.ajax({
        url: global_path + "/vehicle/add/passenger",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#passenger_modal').modal('show');
            $("#psg_count").html(response.length);
            $("#my_tbody").empty();
            $("#passenger").val("");

            if (response != "null") {

                $.each(response, function (key, value) {
                    $("#my_tbody").append(
                        '<tr>' +
                        '<td width="75%">' + value.passenger + '</td>' +
                        '<td width="15%"class="text-center"><button class="btn btn-circle btn-sm btn-danger" onclick="del_psg_list(' + value.id + ')"><span class="fa fa-trash"></span></button></td>' +
                        '</tr>'
                    );
                });
            }
            else {
                $("#psg_count").html("0");
            }
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function _viewloadPassenger(vehicle_id) {
    var formData = new FormData();
    formData.append('vehicle_id', vehicle_id);
    $.ajax({
        url: global_path + "/vehicle/view/passenger",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#passenger_modal').modal('show');
            $("#my_tbody").empty();
            $("#psg_count").html(response.length);


            if (response != "null") {
                $.each(response, function (key, value) {
                    $("#my_tbody").append(
                        '<tr>' +
                        '<td width="75%">' + value.passenger + '</td>' +
                        '</tr>'
                    );
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function _viewPassengerCalendar(vehicle_id, date_req, date_needed) {
    $("#passenger").val("");
    $("#psg_vehicle_id").val(vehicle_id);
    _viewloadPassenger1(vehicle_id);
    _loadVehicle1(vehicle_id);
    $("#lbl_passenger").html("Passenger(s):");
    $("#passenger").hide();
    $("#psg_count").html("");
    $("#asterisk").html("");
    $("#btn_passenger").hide();
    $("#submit_button").hide();
    $("#td_date_needed").html(date_needed);
    $("#td_date_req").html(date_req);
    $("#submit_psg_id").val("");
}


function _loadVehicle1(vehicle_id) {
    var formData = new FormData();
    formData.append('vehicle_id', vehicle_id);
    $.ajax({
        url: global_path + "/vehicle/view/vehicle/calendar",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $("#td_purpose").html(response.purpose);
            $("#td_destination").html(response.destination);
            $("#td_status").html(response.status);

        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function _viewloadPassenger1(vehicle_id) {
    var formData = new FormData();
    formData.append('vehicle_id', vehicle_id);
    $.ajax({
        url: global_path + "/vehicle/view/passenger/calendar",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#passenger_modal').modal('show');
            $("#my_tbody").empty();
            $("#psg_count").html(response.length);


            if (response != "null") {
                $.each(response, function (key, value) {
                    $("#my_tbody").append(
                        '<tr>' +
                        '<td width="75%">' + value.passenger + '</td>' +
                        '</tr>'
                    );
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function del_psg_list(vehicle_id) {
    var formData = new FormData();
    formData.append('passenger_id', vehicle_id);
    $.ajax({
        url: global_path + "/vehicle/delete/passengertolist",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response == "success") {
                _loadPassenger($('#psg_vehicle_id').val());
            } else {
                Swal.fire(
                    'DB Error.',
                    response,
                    'error'
                )
            }
        },
        cache: false,
        contentType: false,
        processData: false
    })

}

function _assign_modal(data) {
    $('#driver').val('');
    $('#assigned_pickupdate').val('');
    $('#assign_modal').modal('show');
    $('#submit_vhl_id').val(data);
}

function _assign() {
    var missing = "";
    var driver = $('#driver').val();
    var assigned_pickupdate = $('#assigned_pickupdate').val();
    if (driver == null) {
        missing = "Driver";
    } else {
        missing = "Pickup Date";
    }
    if (driver != null && assigned_pickupdate != "") {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this.",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, assign.'
        }).then((result) => {
            if (result.value) {
                var formData = new FormData();
                //AJAX to Controller
                formData.append('data_id', $('#submit_vhl_id').val()); // formData.append('<var to be use in controller (eg.in controller = $request-><my_var_name>)>',  $('#<my_element_id>').val());
                formData.append('driver', $('#driver').val());
                formData.append('assigned_pickupdate', $('#assigned_pickupdate').val());
                $.ajax({
                    url: global_path + "/vehicle/accomplish/assign",
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response == "success") {
                            Swal.fire(
                                'Driver and Pickup Date Assigned.',
                                response,
                                'success'
                            ).then((result2) => {
                                window.location.href = global_path + "/vehicle/accomplish";
                            })

                        } else {
                            Swal.fire(
                                'DB Error.',
                                response,
                                'error'
                            )
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            }
        })
    } else {
        Swal.fire(
            'Required field missing.',
            'Please select ' + missing + ' from dropdown.',
            'warning'
        )
    }
}


function add_psg_list(passenger) {
    if (passenger != "") {
        var formData = new FormData();
        formData.append('vehicle_id', $('#psg_vehicle_id').val());
        formData.append('passenger', passenger);
        $.ajax({
            url: global_path + "/vehicle/add/passengertolist",
            method: 'post',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response == "success") {
                    _loadPassenger($('#psg_vehicle_id').val());
                } else {
                    Swal.fire(
                        'DB Error.',
                        response,
                        'error'
                    )
                }
            },
            cache: false,
            contentType: false,
            processData: false
        })
    }
}

//   Vehicle trip Button DELETE
function _delete(vehicle_item_id, vehicle_id, destination) {
    Swal.fire({
        title: 'Delete trip ticket to "' + destination + '" from records?',
        text: 'NOTE: This will permanently delete the record.',
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
            formData.append('data_id', vehicle_item_id);
            $.ajax({
                url: "/vehicle/trip/delete",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function () {
                    console.log('deleted');
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
                            window.location.href = global_path + "/vehicle/trip/" + vehicle_id;
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

//   edit TRIP TICKET Button
function _edit(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: "/vehicle/trip/edit",
        method: 'post',
        data: formData,
        dataType: 'json',

        success: function (response) {
            $('#trip_modal').modal('show');
            $('#date_needed').val(response.date_needed);
            $('#purpose').val(response.purpose);
            $('#destination').val(response.destination);
            $('#vehicle_item_id').val(response.id);

            $('#btn_add').removeClass('btn-info');
            $('#btn_add').addClass('btn-success');

            $('#icon_submit').removeClass('fa-plus');
            $('#icon_submit').addClass('fa-check');

            $('#btn_submit').html("Save Changes");

        },
        cache: false,
        contentType: false,
        processData: false
    })
}

//ADD VEHICLE REQ/TRIP TICKET
function _addRequest() {
    $('#trip_modal').modal('show');
    $('#date_needed').val('');
    $('#purpose').val('');
    $('#destination').val('');
    $('#vehicle_id').val('');
    var dateControl = document.querySelector('input[type="datetime-local"]');
    // dateControl.value = '2017-06-01T08:30'; format of date should be the same on the datepicker
    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var hr = d.getHours();
    var min = d.getMinutes();
    var year = d.getFullYear();
    var output = year + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day + 'T' + (hr < 10 ? '0' : '') + hr + ':' + (min < 10 ? '0' : '') + min;
    dateControl.value = output;
    dateControl.min = output;
    // alert(output);
    // alert(dateControl.value)

    $('#btn_submit').html("Save");
}



//edit VEHICLE: EDIT SUBJECT MESSENGERIAL
function _editVehicle(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: "/vehicle/edit",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#trip_modal').modal('show');
            $('#purpose').val(response.purpose);
            $('#destination').val(response.destination);
            $('#date_needed').val(response.date_needed);
            $('#vehicle_id').val(response.id);
            $('#trip_header').html("Edit Trip Ticket");
            $('#btn_submit').html("Save Changes");
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function _submitVehicle() {
    if ($("#psg_count").html() != 0) {

        Swal.fire({
            title: 'Submit Vehicle Request?',
            text: "You won't be able to revert this.",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit.'
        }).then((result) => {
            if (result.value) {
                var formData = new FormData();
                formData.append('data_id', $("#psg_vehicle_id").val());
                $.ajax({
                    url: global_path + "/vehicle/submit",
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response == "success") {
                            Swal.fire(
                                'Submitted.',
                                response,
                                'success'
                            ).then((result2) => {
                                window.location.href = global_path + "/vehicle";
                            })

                        } else {
                            Swal.fire(
                                'DB Error.',
                                response,
                                'error'
                            )
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            }
        })
    }
    else {
        Swal.fire(
            'Passenger is required.',
            'Please add passenger to proceed.',
            'warning'
        )
        
    }
}


// CANCEL VEHICLE
function _cancelVehicle(data) {
    $('#cancel_modal').modal('show');
    $('#cancel_reason').val("");
    $('#cancel_header').html("Cancel Request");
    $('#btn_cancelRequest').show();
    $('#vcl_cancel_id').val(data);
}

//  CANCEL REASON vehicle
function _cancelReasonVehicle(data) {
    var formData = new FormData();
    formData.append('vcl_cancel_id', data);
    $.ajax({
        url: "/vehicle/cancel_reason",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#cancel_modal').modal('show');
            $('#vcl_cancel_id').val(response.id);
            $('#cancel_note').html("");
            $('#cancel_header').html("Cancelled Request");
            $('#cancel_reason').val("");
            $('#btn_cancelRequest').hide();
            $('#cancel_reason').val(response.cancel_reason);
            document.getElementById('cancel_reason').readOnly = true;

        },
        cache: false,
        contentType: false,
        processData: false
    })
}

//   VEHICLE Button DELETE
function _deleteVehicle(vehicle_id, purpose) {
    Swal.fire({
        title: 'Delete ' + purpose + ' from records?',
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
            formData.append('data_id', vehicle_id);
            $.ajax({
                url: "/vehicle/delete",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function () {
                    console.log('deleted');
                    let timerInterval
                    Swal.fire({
                        title: 'Record successfully deleted.',
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
                            window.location.href = global_path + "/vehicle";
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

// Accomplish modal  
function _markAccomplish() {
    var accomplished_date = $('#accomplished_date').val();
    if (accomplished_date != "") {
        Swal.fire({
            title: 'Mark ' + $('#destination').val() + ' as Accomplished?',
            text: "You won't be able to revert this.",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed.'
        }).then((result) => {
            if (result.value) {
                var formData = new FormData();
                formData.append('data_id', $('#markacc_vhl_id').val());
                formData.append('accomplished_date', $('#accomplished_date').val());
                $.ajax({
                    url: global_path + "/vehicle/mark_accomplish",
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response == "success") {
                            Swal.fire(
                                'Accomplished.',
                                response,
                                'success'
                            ).then((result2) => {
                                window.location.href = global_path + "/vehicle/accomplish";
                            })

                        } else {
                            Swal.fire(
                                'DB Error.',
                                response,
                                'error'
                            )
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        })
    } else {

        Swal.fire(
            'Required field missing.',
            'Please add Accomplished Date.',
            'warning'
        )
    }
}


function mark_accomplish_modal(data) {
    $('#accomplished_date').val('');
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: "/vehicle/mark_accomplish_modal",
        method: 'post',
        data: formData,
        dataType: 'json',

        success: function (response) {
            $('#mark_accomplish_modal').modal('show');
            $('#otw_pickup_date').val(response.otw_pickupdate);
            $('#destination').val(response.destination);
            $('#mark_vhl_id').val(response.id);
            $('#markacc_vhl_id').val(response.id);
        },
        cache: false,
        contentType: false,
        processData: false
    })
}



$('#attachment').on('change', function () {
    //get the file name
    var fileName = $(this).val().replace('C:\\fakepath\\', "");
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
});

function _approveDC(data) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this.",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve.'
    }).then((result) => {
        if (result.value) {
            var formData = new FormData();
            formData.append('data_id', data);
            $.ajax({
                url: global_path + "/vehicle/dc/approve",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response == "success") {
                        Swal.fire(
                            'Approved.',
                            response,
                            'success'
                        ).then((result2) => {
                            window.location.href = global_path + "/vehicle/dc/approval";
                        })

                    } else {
                        Swal.fire(
                            'DB Error.',
                            response,
                            'error'
                        )
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

        }
    })
}


function _approveCAO(data) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this.",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve.'
    }).then((result) => {
        if (result.value) {
            var formData = new FormData();
            formData.append('data_id', data);
            $.ajax({
                url: global_path + "/vehicle/cao/approve",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response == "success") {
                        Swal.fire(
                            'Approved.',
                            response,
                            'success'
                        ).then((result2) => {
                            window.location.href = global_path + "/vehicle/cao/approval";
                        })

                    } else {
                        Swal.fire(
                            'DB Error.',
                            response,
                            'error'
                        )
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

        }
    })
}
function _otw_modal(data) {
    $('#otw_pickupdate').val('');
    $('#otw_modal').modal('show');
    $('#sub_vhl_id').val(data);
}
function _otw() {
    var otw_pickupdate = $('#otw_pickupdate').val();

    if (otw_pickupdate != "") {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this.",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, on the way.'
        }).then((result) => {
            if (result.value) {
                var formData = new FormData();
                //AJAX to Controller
                formData.append('data_id', $('#sub_vhl_id').val()); // formData.append('<var to be use in controller (eg.in controller = $request-><my_var_name>)>',  $('#<my_element_id>').val());
                formData.append('otw_pickupdate', $('#otw_pickupdate').val());
                $.ajax({
                    url: global_path + "/vehicle/accomplish/otw",
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response == "success") {
                            Swal.fire(
                                'On The Way.',
                                response,
                                'success'
                            ).then((result2) => {
                                window.location.href = global_path + "/vehicle/accomplish";
                            })

                        } else {
                            Swal.fire(
                                'DB Error.',
                                response,
                                'error'
                            )
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            }
        })
    } else {
        Swal.fire(
            'Required field missing.',
            'Please select pickup date from dropdown.',
            'warning'
        )
    }
}

function _attachment(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: global_path + "/vehicle/attachment",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#dest').html(response.destination);
            $('#accomplish_modal').modal('show');
            $('#attachment').val("");
            $('.custom-file-label').html("");
            $('#remarks').val("");
            $('#vehicle_id').val(data);
            _loadFile(data);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function _attachmentAgent(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: global_path + "/vehicle/attachment",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#header_destination').html(response.destination);
            $('#accomplish_modal').modal('show');
            $('#attachment').val("");
            $('.custom-file-label').html("");
            $('#remarks').val("");
            $('#vehicle_id').val(data);
            _loadFileAgent(data);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function _loadFileAgent(data) {
    var formData = new FormData();
    formData.append('vehicle_id', data);
    $.ajax({
        url: global_path + "/vehicle/load_file",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#file_body').empty();

            $.each(response, function (key, value,) {
                if (value.remarks == null) {
                    value.remarks = "--";
                } else {
                    value.remarks;
                }

                $('#file_body').append(
                    '<tr class="text-center">' +
                    '<td width="30%"><a href="' + global_path + '/images/vehicle/' + value.attachment + '" target="_blank">' + value.attachment + '</a></td>' +
                    '<td width="40%">' + value.remarks + '</td>' +
                    '<td width="5%"><button onclick="_deleteFile(' + value.id + ')" class="btn btn-danger btn-circle"><span class="fa fa-trash"></span></button></td>' +
                    '</tr>'
                )
            });
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function _loadFile(data) {
    var formData = new FormData();
    formData.append('vehicle_id', data);
    $.ajax({
        url: global_path + "/vehicle/load_file",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#file_body').empty();

            $.each(response, function (key, value,) {
                if (value.remarks == null) {
                    value.remarks = "--";
                } else {
                    value.remarks;
                }

                $('#file_body').append(
                    '<tr class="text-center">' +
                    '<td width="30%"><a href="' + global_path + '/images/vehicle/' + value.attachment + '" target="_blank">' + value.attachment + '</a></td>' +
                    '<td width="40%">' + value.remarks + '</td>' +
                    '</tr>'
                )
            });
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function _submitFile() {
    var formData = new FormData();
    formData.append('remarks', $('#remarks').val());
    formData.append('vehicle_id', $('#vehicle_id').val());
    formData.append('attachment', $('#attachment')[0].files[0]);
    $.ajax({
        url: "/vehicle/submit_file",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#attachment').val("");
            $('.custom-file-label').html("");
            _loadFileAgent($("#vehicle_id").val());
            $('#remarks').val("");
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

//   delete file
function _deleteFile(data_id) {
    var formData = new FormData();
    formData.append('vehiclefile_id', data_id);
    $.ajax({
        url: "/vehicle/delete_file",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#destination').val("");
            $('#remarks').val("");
            $('#attachment').val("");
            $('.custom-file-label').html("");
            _loadFileAgent(
                $("#vehicle_id").val()
            );
        },
        cache: false,
        contentType: false,
        processData: false
    })

}

// $('.getMonthlyReport').click(function (e) {
//     e.preventDefault();

//     let month = $('#month_search option:selected');
//     let year = $('#year_search').val();

//     if (!month) {
//         Swal.fire({
//             title: 'Please select month to generate report.',
//             type: 'warning',
//         })
//     } 
//     if(!year){
//         Swal.fire({
//             title: 'Please select year to generate report.',
//             type: 'warning',
//         })
//     }
//     if(!month && !year){
//         Swal.fire({
//             title: 'Please select month and year to generate report.',
//             type: 'warning',
//         })
//     }
//     if(month && year)
//     {
//         if ($('#month_emp').val() > 0) {
//             window.open('/report/' + year + '/' + month.val(), '_blank');
//         } else {
//             window.open('/vehicle/report/monthly/' + month.text() + '/' + year, '_blank');
//         }
//         // var win = window.open('/dtr/report/monthly/' + month, '_blank');
//     }

// })

function print_report(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: global_path + "/vehicle/report",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#accomplish_modal').modal('show');
            $('#recipient').empty();
            _loadRecipient(data);
            _loadFile(data);
            $('#ctrl_num').html(response.control_num);
            $('#attachment').val("");
            $('.custom-file-label').html("");
            $('#remarks').val(response.remarks);
            $('#messengerial_id').val(data);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function generate_report() {
    var my_month = $('#month_search').val();
    var my_year = $('#year_search').val();

    if (my_month == null) {
        Swal.fire(
            'Required fields missing.',
            'Please select month from dropdown.',
            'warning'
        )
    }
    if (my_year == null) {
        Swal.fire(
            'Required fields missing.',
            'Please select year from dropdown.',
            'warning'
        )
    }
    if (my_month == null && my_year == null) {
        Swal.fire(
            'Required fields missing.',
            'Please select moth and year from dropdown.',
            'warning'
        )
    }
    if (my_month != null && my_year != null) {

        var formData = new FormData();
        formData.append('month', my_month);
        formData.append('year', my_year);
        $.ajax({
            url: global_path + "/vehicle/check_monthly_report",
            method: 'post',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response >= 1) {
                    window.open(global_path + "/vehicle/monthly_report/" + my_month + '/' + my_year, '_blank');
                } else {
                    Swal.fire(
                        'Record not found.',
                        'No records found for the month of ' + $('#month_search option:selected').text() + " " + $('#year_search option:selected').text(),
                        'info'
                    )
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
}

function _resched_modal(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: "/vehicle/accomplish/resched",
        method: 'post',
        data: formData,
        dataType: 'json',

        success: function (response) {
            $('#resched_modal').modal('show');
            $('#due_date').val(response.date_needed);
            $('#resched_vhl_id').val(response.id);
            $('#resched_reason').val("");
        },
        cache: false,
        contentType: false,
        processData: false
    })
}