$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

// ENABLE SUBMIT REQUEST ONLY IF RECIPIENT IS NOT EMPTY
$(function () {
    var rowCount = $('#tickets_table tbody tr').length;
    if (rowCount < 1) {
        $('#submit_button').attr('disabled', 'disabled');
    } else {
        $('#submit_button').removeAttr('disabled');
    }
});
$(function () {
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
});

//   Messengerial Recipient Button DELETE
// function _delete(messengerial_item_id, messengerial_id, recipient) {
//     Swal.fire({
//         title: 'Delete recipient "' + recipient + '" from records?',
//         text: 'NOTE: This will permanently delete the record.',
//         input: 'text',
//         inputPlaceholder: 'Type "CONFIRM" to proceed',
//         inputAttributes: {
//             autocapitalize: 'off'
//         },
//         showCancelButton: true,
//         confirmButtonColor: '#d33',
//         confirmButtonText: 'Delete',
//         showLoaderOnConfirm: true,
//         preConfirm: (confirm) => {
//             if (confirm != "CONFIRM") {
//                 Swal.showValidationMessage(
//                     'Type CONFIRM to proceed'
//                 )
//             }
//         },
//         allowOutsideClick: () => !Swal.isLoading()
//     }).then((result) => {
//         if (result.value) {
//             var formData = new FormData();
//             formData.append('data_id', messengerial_item_id);
//             $.ajax({
//                 url: "/messengerial/recipient/delete",
//                 method: 'post',
//                 data: formData,
//                 dataType: 'json',
//                 success: function () {
//                     console.log('deleted');
//                     let timerInterval
//                     Swal.fire({
//                         title: 'Record successfully deleted',
//                         html: 'refreshing page..',
//                         timer: 1000,
//                         onOpen: () => {
//                             Swal.showLoading()
//                             timerInterval = setInterval(() => {
//                                 const content = Swal.getContent()
//                                 if (content) {
//                                     const b = content.querySelector('b')
//                                     if (b) {
//                                         b.textContent = Swal.getTimerLeft()
//                                     }
//                                 }
//                             }, 100)
//                         },
//                         onClose: () => {
//                             clearInterval(timerInterval)
//                             window.location.href = global_path + "/messengerial/recipient/" + messengerial_id;
//                         }
//                     })
//                 },
//                 cache: false,
//                 contentType: false,
//                 processData: false
//             })
//         }
//     })
// }

//   edit Recipient Button
function _editMessengerial(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: "/messengerial/edit",
        method: 'post',
        data: formData,
        dataType: 'json',

        success: function (response) {
            $('#recipient_modal').modal('show');
            $('#agency').val(response.agency);
            $('#recipient').val(response.recipient);
            $('#contact').val(response.contact);
            $('#destination').val(response.destination);
            $('#delivery_item').val(response.delivery_item);
            $('#instruction').val(response.instruction);
            $('#due_date').val(response.date_needed);
            $('#msg_id').val(response.id);

            $('#btn_add').removeClass('btn-info');
            $('#btn_add').addClass('btn-success');

            $('#icon_submit').removeClass('fa-plus');
            $('#icon_submit').addClass('fa-check');

            $('#btn_submit').html("Save Changes");
            $('#recipient_title').html("Edit Messengerial Request");
            console.log(response);
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function _viewMessengerial(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: "/messengerial/view",
        method: 'post',
        data: formData,
        dataType: 'json',

        success: function (response) {
            $('#view_msg_modal').modal('show');
            $('#view_agency').val(response.agency);
            $('#view_recipient').val(response.recipient);
            $('#view_contact').val(response.contact);
            $('#view_destination').val(response.destination);
            $('#view_delivery_item').val(response.delivery_item);
            $('#view_instruction').val(response.instruction);
            $('#view_due_date').val(response.date_needed);
            $('#view_messengerial_id').val(response.id);
            console.log(response);

        },
        cache: false,
        contentType: false,
        processData: false
    })
}

//ADD RECIPIENT
function _add() {
    $('#recipient_modal').modal('show');
    $('#messengerial_id').val("");
    $('#recipient').val('');
    $('#agency').val('');
    $('#contact').val('');
    $('#destination').val('');
    $('#delivery_item').val('');
    $('#instruction').val('');
    $('#due_date').val('');
    $('#btn_submit').html("Create");
    $('#icon_submit').removeClass('fa-check');
    $('#icon_submit').addClass('fa-plus');
    $('#recipient_title').html("Create Messengerial Request");

}

// //SAVE MESSENGERIAL : CREATE NEW MESSSENGERIAL REQ
// function _addRequest() {
//     $('#request_modal').modal('show');
//     $('#messengerial_id').val("");
//     $('#icon_submit').removeClass('fa-check');
//     $('#icon_submit').addClass('fa-plus');
//     $('#btn_submit').html("Create");
// }

//edit messengerial: EDIT SUBJECT MESSENGERIAL
// function _editMessengerial(data) {
//     var formData = new FormData();
//     formData.append('data_id', data); 
//     $.ajax({
//         url: "/messengerial/edit",
//         method: 'post',
//         data: formData,
//         dataType: 'json',
//         success: function (response) {
//             $('#request_modal').modal('show');
//             $('#subject').val(response.subject);
//             $('#messengerial_id').val(response.id);
//             $('#request_header').html("Edit Subject");
//             $('#icon_submit').removeClass('fa-plus');
//             $('#icon_submit').addClass('fa-check');
//             $('#btn_submit').html("Save Changes");
//         },
//         cache: false,
//         contentType: false,
//         processData: false
//     })
// }

// CANCEL MESSENGERIAL
function _cancelMessengerial(data) {
    $('#cancel_modal').modal('show');
    $('#cancel_reason').val("");
    $('#cancel_header').html("Cancel Request");
    $('#btn_cancelRequest').show();
    $('#msg_cancel_id').val(data);
}

//  CANCEL REASON MESSENGERIAL
function _cancelReasonMessengerial(data) {
    var formData = new FormData();
    formData.append('msg_cancel_id', data);
    $.ajax({
        url: "/messengerial/cancel_reason",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#cancel_modal').modal('show');
            $('#msg_cancel_id').val(response.id);
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

//   Messengerial Button DELETE
function _deleteMessengerial(messengerial_id, recipient) {
    Swal.fire({
        title: 'Delete ' + recipient + ' from records?',
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
            formData.append('data_id', messengerial_id);
            $.ajax({
                url: "/messengerial/delete",
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
                            window.location.href = global_path + "/messengerial";
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

//   Messengerial Button SUBMIT
function _submitMessengerial(data, control_num) {
    Swal.fire({
        title: 'Submit ' + control_num + ' Messengerial Request?',
        text: "You won't be able to revert this.",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, submit.'
    }).then((result) => {
        if (result.value) {
            var formData = new FormData();
            formData.append('data_id', data);
            $.ajax({
                url: global_path + "/messengerial/submit",
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
                            window.location.href = global_path + "/messengerial";
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


function _attachmentAgent(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: global_path + "/messengerial/attachment",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#recipient').empty();
            $('#recipient').html(response.recipient);
            $('#accomplish_modal').modal('show');
            _loadFileAgent(data);
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


function _attachment(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: global_path + "/messengerial/attachment",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#recipient').empty();
            $('#recipient').html(response.recipient);
            $('#accomplish_modal').modal('show');
            // _loadRecipient(data);
            _loadFile(data);
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
                url: global_path + "/messengerial/dc/approve",
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
                            window.location.href = global_path + "/messengerial/dc/approval";
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
                url: global_path + "/messengerial/cao/approve",
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
                            window.location.href = global_path + "/messengerial/cao/approval";
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
function _assign_modal(data) {
    $('#driver').val('');
    $('#assigned_pickupdate').val('');
    $('#assign_modal').modal('show');
    $('#submit_msg_id').val(data);
}

function _outfordel_modal(data) {
    $('#outfordel_pickupdate').val('');
    $('#outfordel_modal').modal('show');
    $('#sub_msg_id').val(data);
}

// function mark_accomplish_modal(data, outfordel_pickupdate) {
//     $('#mark_accomplish_modal').modal('show');
//     $('#markacc_msg_id').val(data); 
//     $('#outfordel_pickupdate').val(outfordel_pickupdate);
//     $('#accomplished_date').val('');
// }

function mark_accomplish_modal(data) {
    $('#accomplished_date').val('');
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: "/messengerial/mark_accomplish_modal",
        method: 'post',
        data: formData,
        dataType: 'json',

        success: function (response) {
            $('#mark_accomplish_modal').modal('show');
            $('#outfordel_pickup_date').val(response.outfordel_pickupdate);
            $('#cntrl_num').val(response.control_num);
            $('#mark_msg_id').val(response.id);
            $('#markacc_msg_id').val(response.id);
        },
        cache: false,
        contentType: false,
        processData: false
    })
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
                formData.append('data_id', $('#submit_msg_id').val()); // formData.append('<var to be use in controller (eg.in controller = $request-><my_var_name>)>',  $('#<my_element_id>').val());
                formData.append('driver', $('#driver').val());
                formData.append('assigned_pickupdate', $('#assigned_pickupdate').val());
                $.ajax({
                    url: global_path + "/messengerial/accomplish/assign",
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
                                window.location.href = global_path + "/messengerial/accomplish";
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

function _outfordel() {
    var outfordel_pickupdate = $('#outfordel_pickupdate').val();

    if (outfordel_pickupdate != "") {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this.",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, out for delivery.'
        }).then((result) => {
            if (result.value) {
                var formData = new FormData();
                //AJAX to Controller
                formData.append('data_id', $('#sub_msg_id').val()); // formData.append('<var to be use in controller (eg.in controller = $request-><my_var_name>)>',  $('#<my_element_id>').val());
                formData.append('outfordel_pickupdate', $('#outfordel_pickupdate').val());
                $.ajax({
                    url: global_path + "/messengerial/accomplish/outfordel",
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response == "success") {
                            Swal.fire(
                                'Out For Delivery.',
                                response,
                                'success'
                            ).then((result2) => {
                                window.location.href = global_path + "/messengerial/accomplish";
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

// mark Accomplish modal  
function _markAccomplish() {
    var accomplished_date = $('#accomplished_date').val();
    if (accomplished_date != "") {
        Swal.fire({
            title: 'Mark ' + $('#cntrl_num').val() + ' as Accomplished?',
            text: "You won't be able to revert this.",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed.'
        }).then((result) => {
            if (result.value) {
                var formData = new FormData();
                formData.append('data_id', $('#markacc_msg_id').val());
                formData.append('accomplished_date', $('#accomplished_date').val());
                $.ajax({
                    url: global_path + "/messengerial/mark_accomplish",
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
                                window.location.href = global_path + "/messengerial/accomplish";
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
// function _loadRecipient(data) {
//     var formData = new FormData();
//     formData.append('messengerial_id', data);
//     $.ajax({
//         url: global_path + "/load_recipient",
//         method: 'post',
//         data: formData,
//         dataType: 'json',
//         success: function (response) {
//             $('#recipient').empty();

//             $('#recipient').append(

//                 '<option value = "">Select option</option>'
//             );
//             $.each(response, function (key, value,) {

//                 $('#recipient').append(
//                     '<option>' + value.recipient + '</option>'
//                 )
//             });
//         },
//         cache: false,
//         contentType: false,
//         processData: false
//     });
// }

function _loadFileAgent(data) {
    var formData = new FormData();
    formData.append('messengerial_id', data);
    $.ajax({
        url: global_path + "/load_file",
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
                    '<td width="30%"><a href="' + global_path + '/images/messengerial/' + value.attachment + '" target="_blank">' + value.attachment + '</a></td>' +
                    '<td width="50%">' + value.remarks + '</td>' +
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
    formData.append('messengerial_id', data);
    $.ajax({
        url: global_path + "/load_file",
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
                    '<td width="30%"><a href="' + global_path + '/images/messengerial/' + value.attachment + '" target="_blank">' + value.attachment + '</a></td>' +
                    '<td width="50%">' + value.remarks + '</td>' +
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
    formData.append('recipient', $('#recipient').val());
    formData.append('remarks', $('#remarks').val());
    formData.append('messengerial_id', $('#messengerial_id').val());
    formData.append('attachment', $('#attachment')[0].files[0]);
    $.ajax({
        url: "/submit_file",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#attachment').val("");
            $('.custom-file-label').html("");
            _loadFileAgent(
                $("#messengerial_id").val()
            );
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
    formData.append('messengerialfile_id', data_id);
    $.ajax({
        url: "/delete_file",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#recipient').val("");
            $('#remarks').val("");
            $('#attachment').val("");
            $('.custom-file-label').html("");
            _loadFileAgent(
                $("#messengerial_id").val()
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

//     if (!month || !year) {
//         Swal.fire({
//             title: 'Please select month and year to generate report.',
//             type: 'warning',
//         })
//     } else {
//         if ($('#month_emp').val() > 0) {
//             window.open('/report/' + year + '/' + month.val(), '_blank');
//         } else {
//             window.open('/messengerial/report/monthly/' + month.text() + '/' + year, '_blank');
//         }
//         // var win = window.open('/dtr/report/monthly/' + month, '_blank');
//     }

// })

function print_report(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: global_path + "/messengerial/report",
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
            url: global_path + "/messengerial/check_monthly_report",
            method: 'post',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response >= 1) {
                    window.open(global_path + "/messengerial/monthly_report/" + my_month + '/' + my_year, '_blank');
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