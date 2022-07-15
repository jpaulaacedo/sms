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
            $("input[name=urgency][value=" + response.urgency + "]").attr('checked', 'checked');
            $(':radio:not(:checked)').attr('disabled', false);
            $('#btn_add').removeClass('btn-info');
            $('#btn_add').addClass('btn-success');

            $('#icon_submit').removeClass('fa-plus');
            $('#icon_submit').addClass('fa-check');

            $('#btn_submit').html("Save Changes");
            $('#recipient_title').html("Edit Messengerial Request");
            console.log(response.urgency);
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
            var urgency = response.urgency;
            $("input[name=view_urgency][value=" + urgency + "]").attr('checked', 'checked');
            $(':radio:not(:checked)').attr('disabled', true);
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
    $(':radio:not(:checked)').attr('disabled', false);
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
function _submitMessengerial(data) {
    Swal.fire({
        title: 'Submit Messengerial Request?',
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

//   Messengerial Button SUBMIT
function submitResched() {
    var pref_date = $('#pref_date').val();
    var data = $('#resched_msg_id').val();
    
    var missing = "";
    if ($('#pref_sched :selected').val() == "none") {
        missing = "from dropdown";
    } else {
        missing = "Preferred Date";
    }
    if (($('#pref_sched :selected').val() == "by_requestor" && pref_date != "")) {
        Swal.fire({
            title: 'Submit Reschedule?',
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
                formData.append('pref_date', pref_date);
                formData.append('pref_sched', $('#pref_sched :selected').val());
                $.ajax({
                    url: global_path + "/messengerial/submitResched",
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
    else if ($('#pref_sched :selected').val() == "by_agent") {

        Swal.fire({
            title: 'Submit Reschedule?',
            text: "You won't be able to revert this.",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit.'
        }).then((result) => {
            if (result.value) {
                console.log(data, $('#pref_sched :selected').val())
                var formData = new FormData();
                formData.append('data_id', data);
                formData.append('pref_sched', $('#pref_sched :selected').val());
                $.ajax({
                    url: global_path + "/messengerial/submitResched",
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
    else {
        Swal.fire(
            'Required field missing',
            'Select ' + missing + '.',
            'warning'
        )
    }
}

function accomplish_modal(data, outfordel_date) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: global_path + "/messengerial/mark_accomplish_modal",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#recipient').empty();
            $('#accomplished_date').empty();
            $('#recipient').html(response.recipient);
            $('#outfordel_date').val(outfordel_date);
            $('#accomplish_modal').modal('show');
            _loadFileAgent(data);
            $('#attachment').val("");
            $('.custom-file-label').html("");
            $('#remarks').val(response.remarks);
            $('#accomplished_date').val(response.accomplished_date);
            $('#messengerial_id').val(data);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function acc_accomplish_modal(data, outfordel_date) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: global_path + "/messengerial/acc_accomplish_modal",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#acc_recipient').empty();
            $('#acc_accomplished_date').val('');
            $('#acc_recipient').html(response.recipient);
            $('#acc_outfordel_date').val(outfordel_date);
            $('#acc_remarks').val(response.remarks);
            $('#acc_accomplished_date').val(response.accomplished_date);
            $('#acc_accomplish_modal').modal('show');
            _loadFile(data);
            $('#acc_attachment').val("");
            $('.custom-file-label').html("");
            $('#acc_messengerial_id').val(data);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

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
                if (value.attachment != "") {
                    $('#file_body').append(
                        '<tr class="text-center">' +
                        '<td width="30%"><a href="' + global_path + '/images/messengerial/' + value.attachment + '" target="_blank">' + value.attachment + '</a></td>' +
                        '<td width="5%"><button onclick="_deleteFile(' + value.id + ')" class="btn btn-danger btn-circle"><span class="fa fa-trash"></span></button></td>' +
                        '</tr>'
                    )
                }

            });
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
    $('#assign_modal').modal('show');
    $('#submit_msg_id').val(data);
}

function reschedAgent_modal() {
    var data = $('#reschedAbyR_msg_id').val();
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: "/messengerial/accomplish/reschedAgent_modal",
        method: 'post',
        data: formData,
        dataType: 'json',

        success: function (response) {
            console.log(response)
            $('#reschedAgent_modal').modal('show');
            $('#reschedAgentbyR_modal').modal('hide');
            $('#reschedA_due_date').val(response.date_needed);
            $('#reschedA_msg_id').val(response.id);
            $('#reschedA_reason').val("");
            $('#prefA_sched').val("");
            $('#prefA_date').val("");
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function reschedAgentbyR_modal(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: "/messengerial/accomplish/reschedAgentbyR_modal",
        method: 'post',
        data: formData,
        dataType: 'json',

        success: function (response) {
            console.log(response)
            $('#reschedAgentbyR_modal').modal('show');
            $('#reschedAbyR_due_date').val(response.old_date_needed);
            $('#suggestAbyR_due_date').val(response.date_needed);
            $('#reschedAbyR_msg_id').val(response.id);
            $('#reschedAbyR_reason').val(response.resched_reason);
            $('#prefAbyR_sched').val(response.pref_sched);
            $('#prefAbyR_date').val(response.pref_date);
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function resched_modal(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: "/messengerial/resched_modal",
        method: 'post',
        data: formData,
        dataType: 'json',

        success: function (response) {
            console.log(response)
            $('#resched_modal').modal('show');
            $('#resched_due_date').val(response.old_date_needed);
            $('#suggest_due_date').val(response.date_needed);
            $('#resched_msg_id').val(response.id);
            $('#resched_reason').val(response.resched_reason);

        },
        cache: false,
        contentType: false,
        processData: false
    })
}

//view reschedAgent_modal
function view_reschedAgent_modal(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: "/messengerial/accomplish/view_reschedAgent",
        method: 'post',
        data: formData,
        dataType: 'json',

        success: function (response) {
            console.log(response)
            $('#view_reschedAgent_modal').modal('show');
            $('#view_reschedA_due_date').val(response.old_date_needed);
            $('#view_suggestA_due_date').val(response.date_needed);
            $('#view_reschedA_msg_id').val(response.id);
            $('#view_reschedA_reason').val(response.resched_reason);
            $('#view_prefA_sched').val(response.pref_sched);
            if($('#view_pref_sched').val() == "by_requestor"){
                $('#view_pref_date').val(response.pref_date);
            }
            else{
                $('#view_pref_date').disabled = true;
            }
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function view_resched_modal(data) {
    var formData = new FormData();
    formData.append('data_id', data);
    $.ajax({
        url: "/messengerial/view_resched_modal",
        method: 'post',
        data: formData,
        dataType: 'json',

        success: function (response) {
            console.log(response)
            $('#view_resched_modal').modal('show');
            $('#view_resched_due_date').val(response.old_date_needed);
            $('#view_suggest_due_date').val(response.date_needed);
            $('#view_resched_msg_id').val(response.id);
            $('#view_resched_reason').val(response.resched_reason);
            $('#view_pref_sched').val(response.pref_sched);
            if($('#view_pref_sched').val() == "by_requestor"){
                $('#view_pref_date').val(response.pref_date);
            }
            else{
                $('#view_pref_date').disabled = true;
            }
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

$('select').on('change', function () {

    var selected = $('#pref_sched :selected').val();
    console.log(selected);
    if (selected == 'by_requestor') {
        console.log(selected)
        document.getElementById("pref_date").disabled = false;
    }
    else {
        document.getElementById("pref_date").value = "";
        document.getElementById("pref_date").disabled = true;
    }
});

function acceptResched(data) {
    var data = $('#reschedAbyR_msg_id').val();
    var pref_date = $('#prefAbyR_date').val();
    console.log(data, pref_date)
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this.",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Accept Reschedule Date.'
    }).then((result) => {
        if (result.value) {
            var formData = new FormData();
            formData.append('data_id', data);
            formData.append('pref_date', pref_date);
            $.ajax({
                url: global_path + "/messengerial/accomplish/acceptResched",
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

}
function reschedAgent() {
    var suggest_due_date = $('#suggestA_due_date').val();
    var data = $('#reschedA_msg_id').val();
    var resched_reason = $('#reschedA_reason').val();
    var missing = "";

    console.log(suggest_due_date, data, resched_reason);
    if (suggest_due_date == "") {
        missing = "Suggest Due Date";
    } else {
        missing = "Reason for Rescheduling";
    }
    if (suggest_due_date != "" && resched_reason != "") {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this.",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Reschedule.'
        }).then((result) => {
            if (result.value) {
                var formData = new FormData();
                formData.append('data_id', data); // formData.append('<var to be use in controller (eg.in controller = $request-><my_var_name>)>',  $('#<my_element_id>').val());
                formData.append('resched_reason', resched_reason);
                formData.append('suggest_due_date', suggest_due_date);
                $.ajax({
                    url: global_path + "/messengerial/accomplish/reschedAgent",
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
            'Required missing field.',
            'Add ' + missing + '.',
            'warning'
        )
    }
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

// function mark_accomplish_modal(data) {
//     $('#accomplished_date').val('');
//     var formData = new FormData();
//     formData.append('data_id', data);
//     $.ajax({
//         url: "/messengerial/mark_accomplish_modal",
//         method: 'post',
//         data: formData,
//         dataType: 'json',

//         success: function (response) {
//             $('#mark_accomplish_modal').modal('show');
//             $('#outfordel_date').val(response.outfordel_date);
//             $('#cntrl_num').val(response.control_num);
//             $('#mark_msg_id').val(response.id);
//             $('#markacc_msg_id').val(response.id);
//         },
//         cache: false,
//         contentType: false,
//         processData: false
//     })
// }

function _assign() {
    var driver = $('#driver').val();

    if (driver != null) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this.",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, assign driver.'
        }).then((result) => {
            if (result.value) {
                var formData = new FormData();
                //AJAX to Controller
                formData.append('data_id', $('#submit_msg_id').val()); // formData.append('<var to be use in controller (eg.in controller = $request-><my_var_name>)>',  $('#<my_element_id>').val());
                formData.append('driver', $('#driver').val());
                $.ajax({
                    url: global_path + "/messengerial/accomplish/assign",
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response == "success") {
                            Swal.fire(
                                'Driver Assigned.',
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
            'Please select driver from dropdown.',
            'warning'
        )
    }
}

function _outfordel(data) {

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
            formData.append('data_id', data); // formData.append('<var to be use in controller (eg.in controller = $request-><my_var_name>)>',  $('#<my_element_id>').val());
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
}
// mark Accomplish modal  
function _markAccomplish(data, control_num) {
    var accomplished_date = $('#accomplished_date').val();
    if (accomplished_date != "") {
        Swal.fire({
            title: 'Mark ' + control_num + ' as accomplished?',
            text: "You won't be able to revert this.",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed.'
        }).then((result) => {
            if (result.value) {
                var formData = new FormData();
                formData.append('data_id', data);
                formData.append('accomplished_date', $('#accomplished_date').val());
                formData.append('remarks', $('#remarks').val());
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


function _loadFile(data) {
    var formData = new FormData();
    formData.append('messengerial_id', data);
    $.ajax({
        url: global_path + "/load_file",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#acc_file_body').empty();

            $.each(response, function (key, value,) {
                $('#acc_file_body').append(
                    '<tr class="text-center">' +
                    '<td width="30%"><a href="' + global_path + '/images/messengerial/' + value.attachment + '" target="_blank">' + value.attachment + '</a></td>' +
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
    formData.append('messengerial_id', $('#messengerial_id').val());
    formData.append('attachment', $('#attachment')[0].files[0]);
    $.ajax({
        url: "/submit_file",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if ($('#attachment')[0].files[0] == null) {
                Swal.fire(
                    'No file chosen.',
                    'Please browse file to upload.',
                    'warning'
                )
            }
            else {
                $('#attachment').val("");
                $('.custom-file-label').html("");
                _loadFileAgent(
                    $("#messengerial_id").val()
                );
            }
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