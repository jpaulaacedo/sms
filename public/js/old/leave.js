$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    clear();

    $('#type_of_leave').change(function () {
        clear_radios();
        if ($(this).val() == "VL") {
            $(".vl_div").show();
            $(".sl_div").hide();
            $(".fl_div").hide();
            $(".spl_div").hide();
        } else if ($(this).val() == "SL") {
            $(".vl_div").hide();
            $(".sl_div").show();
            $(".fl_div").show();
            $(".spl_div").hide();
        } else if ($(this).val() == "SPL") {
            $(".vl_div").hide();
            $(".sl_div").show();
            $(".fl_div").hide();
            $(".spl_div").show();
        } else if ($(this).val() == "FL") {
            $(".vl_div").hide();
            $(".sl_div").hide();
            $(".fl_div").show();
            $(".spl_div").hide();
        } else {
            $(".vl_div").hide();
            $(".sl_div").hide();
            $(".spl_div").hide();
            $(".fl_div").hide();
        }
    });

    $("#dates_table").on('click', '.btnDelete', function () {
        $(this).closest('tr').remove();
        $("#my_days").empty();
        var rowCount = $('#dates_table tr').length;
        $("#my_days").html(rowCount + " Day(s)");
    });

    $("#recommendation").change(function () {
        if ($(this).val() == "Approved") {
            $(".div_reason").hide();
            $("#reason").val('');
        } else {
            $(".div_reason").show();
        }
    })

});

function clear() {
    hide_range();
    $("#for_disapproval").prop('checked', false);
    $(".vl_div").hide();
    $(".sl_div").hide();
    $(".spl_div").hide();
    $(".fl_div").hide();
    $("#btn_disabled").hide();
    $(".div_reason").hide();
}

function getTableData() {
    var table_dates = [];
    $("#dates_table").find('tr').each(function (i, el) {
        var $tds = $(this).find('td');
        table_dates.push(moment(new Date($tds.eq(0).text())).format('YYYY-MM-DD'))
    });
    return table_dates;

}

function showmodal(id) {
    var formData = new FormData();
    formData.append('leave_id', id);
    $.ajax({
        url: global_path + "/leaves/leave_details",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#approve_modal').modal('toggle');
            $('#approve_modal').modal('show');
            $('#approve_name').html(toTitleCase(response.leave['firstname'] + " " + response.leave['lastname']))
            get_credits(response.leave['user_id'], response.leave['type_of_leave'], response.leave_dates.length);
            less_this_leave(response.leave['type_of_leave'], response.leave_dates.length);
            var approve_type;
            var specs;
            if (response.leave['type_of_leave'] == "VL") {
                approve_type = "Vacation Leave (VL)";
                if (response.leave['vl_type'] == 1) {
                    specs = "• to seek employment";
                } else {
                    specs = "• " + response.leave['vl_type_remark'];
                }
                if (response.leave['vl_spent'] == 1) {
                    specs = specs + " <br> " + "• Within the Philippines";
                } else {
                    specs = specs + "<br>" + "• Abroad (" + response.leave['vl_spent_remark'] + ")";
                }
            } else if (response.leave['type_of_leave'] == "SL") {
                approve_type = "Sick Leave (SL)";
                if (response.leave['sl_type'] == 1) {
                    specs = "• Hospital Confinement <br> • " + response.leave['sl_type_remark'];
                } else if (response.leave['sl_type'] == 2) {
                    specs = "• Medical Check-up <br> • " + response.leave['sl_type_remark'];
                } else if (response.leave['sl_type'] == 3) {
                    specs = "• Others <br> • " + response.leave['sl_type_remark'];
                }
            } else if (response.leave['type_of_leave'] == "SPL") {
                approve_type = "Special Privilege Leave (SPL)";
                specs = response.leave['spl_remark'];
            } else if (response.leave['type_of_leave'] == "FL") {
                approve_type = "Forced Leave (FL)";
                $("#recommendation").empty();
                $("#recommendation").append("<option value='Approved'>Proceed</option>");
                if (response.leave['for_disapproval']) {
                    specs = "For Disapproval <span class='fa fa-exclamation-circle text-primary'></span>";
                } else {
                    specs = "";
                }

            } else if (response.leave['type_of_leave'] == "PL") {
                approve_type = "Paternity Leave (PL)";
            } else if (response.leave['type_of_leave'] == "ML") {
                approve_type = "Maternity Leave (SL)";
            }
            $("#approve_type").html(approve_type);
            $("#approve_specs").html(specs);
            $("#approve_commutation").html((response.leave["commutation"] == 1) ? "Requested" : "Not Requested");
            for (i = 0; i < response.leave_dates.length; i++) {
                $("#inclusive_dates").append(moment(new Date(response.leave_dates[i])).format('MMM D, YYYY (ddd)') + "<br>");
            }
            $("#time_off").html(response.leave_dates.length + " Day(s)");
            $("#my_leave_id").val(response.leave["leave_id"]);


            console.log(response.is_ED);
            if (response.is_ED === true) {
                $("#details_tbl tr:eq(6)").remove();
                $("#details_tbl").append(
                    '<tr><th>Recommendation by DC:</th><td>' + response.leave["recommendation"] + '</td></tr>'
                );
            } else {
                console.log("not ED");
            }
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function less_this_leave(leave_type, days) {
    if(leave_type == "FL"){
        $("#days_pay").hide();
    }else{
        $("#days_pay").show();
    }
    if (leave_type == "VL") {
        $('#vl_credits_less').html(days);
        $('#sl_credits_less').empty();
        $('#spl_credits_less').empty();
        $('#fl_credits_less').empty();
        $('#pl_credits_less').empty();
    } else if (leave_type == "SL") {
        $('#vl_credits_less').empty();
        $('#sl_credits_less').html(days);
        $('#spl_credits_less').empty();
        $('#fl_credits_less').empty();
        $('#pl_credits_less').empty();
    } else if (leave_type == "SPL") {
        $('#vl_credits_less').empty();
        $('#sl_credits_less').empty();
        $('#spl_credits_less').html(days);
        $('#fl_credits_less').empty();
        $('#pl_credits_less').empty();
    } else if (leave_type == "FL") {
        $('#vl_credits_less').empty();
        $('#sl_credits_less').empty();
        $('#spl_credits_less').empty();
        $('#fl_credits_less').html(days);
        $('#pl_credits_less').empty();
    } else if (leave_type == "PL" || leave_type == "ML") {
        $('#vl_credits_less').empty();
        $('#sl_credits_less').empty();
        $('#spl_credits_less').empty();
        $('#fl_credits_less').empty();
        $('#pl_credits_less').html(days);
    }
}

function get_credits(user_id, leave_type, leave_length) {
    var formData = new FormData();
    formData.append('user_id', user_id);
    $.ajax({
        url: global_path + "/leaves/get_credits",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $("#vl_credits").html(response.VL);
            $("#sl_credits").html(response.SL);
            $("#fl_credits").html(response.FL);
            $("#spl_credits").html(response.SPL);
            $("#pl_credits").html(response.PL);

            if (leave_type == "VL") {
                $("#input_id").val(response.VL);
            } else if (leave_type == "SL") {
                $("#input_id").val(response.SL);
            } else if (leave_type == "SPL") {
                $("#input_id").val(response.SPL);
            } else if (leave_type == "FL") {
                $("#input_id").val(response.FL);
            } else if (leave_type == "PL" || leave_type == "ML") {
                $("#input_id").val(response.PL);
            }

            var my_total = parseFloat($("#input_id").val()).toFixed(3) - parseFloat(leave_length).toFixed(3);
            if (my_total >= 0) {
                $("#days_w_pay").val(leave_length);
            } else {
                $("#days_w_pay").val($("#input_id").val());
                $("#days_wo_pay").val(parseFloat(leave_length).toFixed(3) - parseFloat($("#input_id").val()).toFixed(3));
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function approve() {
    if ($("#recommendation").val() == "Disapproved" && $("#reason").val() == "") {
        Swal.fire(
            "'Disapprove due to:' is empty.",
            'Please provide reason for disapproval.',
            'warning'
        )
    } else {
        var formData = new FormData();
        formData.append('leave_id', $("#my_leave_id").val());
        formData.append('recommendation', $("#recommendation").val());
        formData.append('reason', $("#reason").val());
        formData.append('w_pay', $("#days_w_pay").val());
        formData.append('wo_pay', $("#days_wo_pay").val());
        $.ajax({
            url: global_path + "/leaves/approve",
            method: 'post',
            data: formData,
            dataType: 'json',
            success: function (response) {
                Swal.fire(
                    response,
                    'Success!',
                    'success'
                ).then((result) => {
                    window.location.href = global_path + "/leaves/index";
                })
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
}

function toTitleCase(str) {
    return str.replace(/(?:^|\s)\w/g, function (match) {
        return match.toUpperCase();
    });
}

function btnClear() {
    $("#my_tbody").empty();
}

function clear_radios() {
    $('input[name="sl_type"]').prop('checked', false);
    $('input[name="vl_type"]').prop('checked', false);
    $('input[name="vl_spent"]').prop('checked', false);
    $('#vl_type_remark').val('');
    $('#vl_spent_remark').val('');
    $('#sl_type_remark').val('');
    $('#spl_remark').val('');
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

        if (is_weekend(my_date) == "weekend") {
            ctr++;
        }

        for (i = 0; i < getTableData().length; ++i) {
            if (my_date == getTableData()[i]) {
                ctr++;
            }
        }
        if (ctr <= 0) {
            var formData = new FormData();
            formData.append('my_date', my_date);
            $.ajax({
                url: global_path + "/leaves/check_dates",
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
                                    $("#my_days").empty();
                                    var rowCount = $('#dates_table tr').length
                                    $("#my_days").html(rowCount + " Day(s)");
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


function btnSubmit() {
    if ($("#type_of_leave").val() == null) {
        Swal.fire(
            'Please select Type of Leave',
            'NOTE: What type of "Leave" do you want to file?',
            'warning'
        )
    } else {
        if ($("#type_of_leave").val() == "VL") {
            if ($('input[name="vl_type"]').is(':checked')) {
                if ($("input[name='vl_type']:checked").val() == "2" && $("#vl_type_remark").val() == "") {
                    Swal.fire(
                        'Required field(s) missing.',
                        'NOTE: Please specify why do you want to file a vacation leave.',
                        'warning'
                    )
                } else {
                    submit_ajax();
                }
            } else {
                Swal.fire(
                    'Required field(s) missing.',
                    'NOTE: Why do you want to file a vacation leave.',
                    'warning'
                )
            }
            if ($('input[name="vl_spent"]').is(':checked')) {
                if ($("input[name='vl_spent']:checked").val() == "2" && $("#vl_spent_remark").val() == "") {
                    Swal.fire(
                        'Required field(s) missing.',
                        'NOTE: Please specify where do you want to spend your vacation.',
                        'warning'
                    )
                } else {
                    submit_ajax();
                }
            } else {
                Swal.fire(
                    'Required field(s) missing.',
                    'NOTE: Where do you want to spend your vacation leave.',
                    'warning'
                )
            }
        } else if ($("#type_of_leave").val() == "SL") {
           
            if ($('input[name="sl_type"]').is(':checked')) {
                if ($("#sl_type_remark").val() == null) {
                    Swal.fire(
                        'Required field(s) missing.',
                        'NOTE: Please specify details of Sick Leave',
                        'warning'
                    )
                } else {
                    submit_ajax();
                }
            } else {
                Swal.fire(
                    'Required field(s) missing.',
                    'NOTE: Let us know why do you want to file a Sick Leave.',
                    'warning'
                )
            }
        } else if ($("#type_of_leave").val() == "SPL") {
            if ($("#spl_remark").val() == null) {
                Swal.fire(
                    'Required field(s) missing.',
                    'NOTE: Please specify details of Special Privilege Leave',
                    'warning'
                )
            } else {
                submit_ajax();
            }
        } else {
            submit_ajax();
        }
    }
}

function submit_ajax() {
    if (getTableData().length == 0) {
        Swal.fire(
            'Required field(s) missing.',
            'NOTE: Please include Date',
            'warning'
        )
    } else {
        Swal.fire({
            title: 'Submit?',
            text: "Submit Application for Leave",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Submit'
        }).then((result) => {
            for_disapproval;
            if ($('#for_disapproval').prop('checked')) {
                for_disapproval = 1;
            } else {
                for_disapproval = 0;
            }
            if (result.value) {
                $('#overlay').fadeIn();
                var formData = new FormData();
                formData.append('my_dates', getTableData());
                formData.append('type_of_leave', $('#type_of_leave').val());
                formData.append('vl_type', $('input[name="vl_type"]:checked').val());
                formData.append('vl_type_remark', $('#vl_type_remark').val());
                formData.append('vl_spent', $('input[name="vl_spent"]:checked').val());
                formData.append('vl_spent_remark', $('#vl_spent_remark').val());
                formData.append('sl_type', $('input[name="sl_type"]:checked').val());
                formData.append('sl_type_remark', $('#sl_type_remark').val());
                formData.append('spl_remark', $('#spl_remark').val());
                formData.append('commutation', $('#commutation').val());
                formData.append('for_disapproval', for_disapproval);
                $.ajax({
                    url: global_path + "/leaves/submit",
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        $('#overlay').delay(100).fadeOut('fast', function () {
                            Swal.fire(
                                response + " Day(s) of Leave filed.",
                                'Application for Leave submitted!',
                                'success'
                            ).then((result) => {
                                window.location.href = global_path + "/leaves/index";
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


function for_cancellation(leave_id, type) {
    var title = "";
    var text = "";
    if (type == 1) {
        title = "Cancel your leave application?";
        text = "This request will be sent to HR.";
    } else {
        title = "Cancel this leave application?";
        text = "This will update the status as 'Cancelled'";
    }
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Close',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#525252',
        confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
        if (result.value) {
            var formData = new FormData();
            formData.append('leave_id', leave_id);
            $.ajax({
                url: global_path + "/leaves/cancel_leave",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    var big_message = "";
                    var small_message = "";
                    if (response == "For Cancellation") {
                        big_message = "Request Sent!";
                        small_message = "Your cancellation request is sent to HR.";
                    } else {
                        big_message = "Status Updated!";
                        small_message = "Application cancelled.";
                    }
                    Swal.fire(
                        big_message,
                        small_message,
                        'success'
                    ).then((result) => {
                        window.location.href = global_path + "/leaves/index";
                    })
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    })
}

function credit_history(user_id, leave_type) {
    if (leave_type == "VL") {
        $('#history_modal_title').html('Vacation');
    } else if (leave_type == "SL") {
        $('#history_modal_title').html('Sick');
    } else if (leave_type == "SPL") {
        $('#history_modal_title').html('Special Privilege');
    } else if (leave_type == "FL") {
        $('#history_modal_title').html('Forced');
    } else if (leave_type == "PL") {
        $('#history_modal_title').html('Parental');
    }
    var formData = new FormData();
    formData.append('user_id', user_id);
    formData.append('leave_type', leave_type);
    $.ajax({
        url: global_path + "/leaves/staff_credits/history",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#history_modal').modal('toggle');
            $('#history_modal').modal('show');
            $('#history_table_div').empty();
            $('#history_table_div').append('<table class="table table-bordered table-sm history_table_div" id="my_history_table_div">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Activity</th>' +
                '<th>Credit Amount</th>' +
                '<th>Total</th>' +
                '<th>Status</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="history_body">' +
                '</tbody>' +
                '</table>'
            );

            $.each(response, function (key, value) {
                $('#history_body').append(
                    '<tr style="background-color:' + status_color(value.status) + '" class="text-center">' +
                    '<td>' + value.activity + '</td>' +
                    '<td>' + value.credit_amount + '</td>' +
                    '<td>' + value.total_credits + '</td>' +
                    '<td >' + value.status + '</td>' +
                    '</tr>'
                );
            });

            $('#my_history_table_div').DataTable({ "sorting": false });
        },
        cache: false,
        contentType: false,
        processData: false
    })

    function status_color(status) {
        if (status == "IN") {
            return "#dcfce6";
        } else {
            return "#fcdedc";
        }
    }
}