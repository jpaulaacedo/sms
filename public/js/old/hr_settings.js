$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    load_sg();
});

function formatCurrency(total) {
    const formatter = new Intl.NumberFormat('tl-PH', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 2
    })
    return formatter.format(total);
}

// SG ============================= START
function load_sg() {
    empty_sg();
    $.ajax({
        url: global_path + "/hr/settings/sg",
        method: 'post',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            $('#sg_table').empty();
            $('#sg_table').append('<table class="table table-bordered table-sm sg_table" id="my_sg_table">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Tranche</th>' +
                '<th>Salary Grade</th>' +
                '<th>Step 1</th>' +
                '<th>Step 2</th>' +
                '<th>Step 3</th>' +
                '<th>Step 4</th>' +
                '<th>Step 5</th>' +
                '<th>Step 6</th>' +
                '<th>Step 7</th>' +
                '<th>Step 8</th>' +
                '<th></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="sg_body">' +
                '</tbody>' +
                '</table>'
            );

            $.each(response, function (key, value) {
                $('#sg_body').append(
                    '<tr>' +
                    '<td class="text-center">' + value.tranche + '</td>' +
                    '<td class="text-center">' + value.salary_grade + '</td>' +
                    '<td class="text-right">' + formatCurrency(value.step_1) + '</td>' +
                    '<td class="text-right">' + formatCurrency(value.step_2) + '</td>' +
                    '<td class="text-right">' + formatCurrency(value.step_3) + '</td>' +
                    '<td class="text-right">' + formatCurrency(value.step_4) + '</td>' +
                    '<td class="text-right">' + formatCurrency(value.step_5) + '</td>' +
                    '<td class="text-right">' + formatCurrency(value.step_6) + '</td>' +
                    '<td class="text-right">' + formatCurrency(value.step_7) + '</td>' +
                    '<td class="text-right">' + formatCurrency(value.step_8) + '</td>' +
                    '<td class="text-center">' +
                    '<button class="btn btn-primary btn-sm" onclick="sg_edit(' + value.id + ')"><span class="fa fa-edit"></span></button> | ' +
                    '<button class="btn btn-danger btn-sm" onclick="sg_delete(' + value.id + ')"><span class="fa fa-trash"></span></button>' +
                    '</td>' +
                    '</tr>'
                );
            });

            $('#my_sg_table').DataTable({ "sorting": false });
        }

    });
}

function empty_sg() {
    $('#salary_grade').val('');
    $('#step1').val('');
    $('#step2').val('');
    $('#step3').val('');
    $('#step4').val('');
    $('#step5').val('');
    $('#step6').val('');
    $('#step7').val('');
    $('#step8').val('');
}

function empty_pos() {
    $('#position_code').val('');
    $('#title').val('');
    $('#division_id').val('');
    $('#salary_grade').val('');
}

function sg_create() {
    $('#sg_modal').modal('toggle');
    $('#sg_modal').modal('show');
    $('#sg_id').val('');
    empty_sg();
}

function sg_edit(id) {
    $('#sg_modal').modal('toggle');
    $('#sg_modal').modal('show');
    $('#sg_id').val(id);
    var formData = new FormData();
    formData.append('sg_id', id);
    $.ajax({
        url: global_path + "/hr/settings/sg/get_sg",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            empty_sg();
            $('#tranche').val(response.tranche);
            $('#salary_grade').val(response.salary_grade);
            $('#step1').val(response.step_1);
            $('#step2').val(response.step_2);
            $('#step3').val(response.step_3);
            $('#step4').val(response.step_4);
            $('#step5').val(response.step_5);
            $('#step6').val(response.step_6);
            $('#step7').val(response.step_7);
            $('#step8').val(response.step_8);
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function sg_delete(id) {
    Swal.fire({
        title: "Delete this item?",
        text: "You will not be able to revert this. ",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Close',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#525252',
        confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
        if (result.value) {
            var formData = new FormData();
            formData.append('sg_id', id);
            $.ajax({
                url: global_path + "/hr/settings/sg/delete",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    Swal.fire(
                        response,
                        "Record deleted.",
                        'success'
                    ).then((result) => {
                        load_sg();
                    })
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    })
}

function sg_save() {
    if (validate_sg() == "1") {
        Swal.fire(
            "All fields are required",
            "Record not saved.",
            'warning'
        )
    } else {
        var formData = new FormData();
        if ($('#sg_id').val() != "") {
            formData.append('sg_id', $('#sg_id').val());
        } else {
            formData.append('sg_id', "0");
        }
        formData.append('tranche', $('#tranche').val());
        formData.append('salary_grade', $('#salary_grade').val());
        formData.append('step1', $('#step1').val());
        formData.append('step2', $('#step2').val());
        formData.append('step3', $('#step3').val());
        formData.append('step4', $('#step4').val());
        formData.append('step5', $('#step5').val());
        formData.append('step6', $('#step6').val());
        formData.append('step7', $('#step7').val());
        formData.append('step8', $('#step8').val());
        $.ajax({
            url: global_path + "/hr/settings/sg/save",
            method: 'post',
            data: formData,
            dataType: 'json',
            success: function (response) {
                Swal.fire(
                    response,
                    "Record Saved.",
                    'success'
                ).then((result) => {
                    load_sg();
                    $('#sg_id').val('');
                })
            },
            cache: false,
            contentType: false,
            processData: false
        })
    }
}

function validate_sg() {
    if ($('#salary_grade').val() == "" ||
        $('#step1').val() == "" ||
        $('#step2').val() == "" ||
        $('#step3').val() == "" ||
        $('#step4').val() == "" ||
        $('#step5').val() == "" ||
        $('#step6').val() == "" ||
        $('#step7').val() == "" ||
        $('#step8').val() == "") {
        return "1";
    } else {
        return "0";
    }
}
// SG ============================= END

function load_table1() {
    $.ajax({
        url: global_path + "/hr/settings/table1",
        method: 'post',
        dataType: 'json',
        success: function (response) {
            $('#table1').empty();
            $('#table1').append('<table class="table table-bordered table-sm table1" id="my_table1">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Number of Months</th>' +
                '<th>VL Earned</th>' +
                '<th>SL Earned</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="table1_body">' +
                '</tbody>' +
                '</table>'
            );

            $.each(response, function (key, value) {
                $('#table1_body').append(
                    '<tr>' +
                    '<td class="text-center">' + value.number_of_months + '</td>' +
                    '<td class="text-right">' + value.vl_earned + '</td>' +
                    '<td class="text-right">' + value.sl_earned + '</td>' +
                    '</tr>'
                );
            });
            $('#my_table1').DataTable({ "sorting": false });
        }

    });
}

function load_table2() {
    $.ajax({
        url: global_path + "/hr/settings/table2",
        method: 'post',
        dataType: 'json',
        success: function (response) {
            $('#table2').empty();
            $('#table2').append('<table class="table table-bordered table-sm table2" id="my_table2">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Number of Days</th>' +
                '<th>VL Earned</th>' +
                '<th>SL Earned</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="table2_body">' +
                '</tbody>' +
                '</table>'
            );

            $.each(response, function (key, value) {
                $('#table2_body').append(
                    '<tr>' +
                    '<td class="text-center">' + value.number_of_days + '</td>' +
                    '<td class="text-right">' + value.vl_earned + '</td>' +
                    '<td class="text-right">' + value.sl_earned + '</td>' +
                    '</tr>'
                );
            });
            $('#my_table2').DataTable({ "sorting": false });
        }

    });
}

function load_table3() {
    $.ajax({
        url: global_path + "/hr/settings/table3",
        method: 'post',
        dataType: 'json',
        success: function (response) {
            $('#table3').empty();
            $('#table3').append('<table class="table table-bordered table-sm table3" id="my_table3">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Number of Days Present</th>' +
                '<th>Days on Leave w/o Pay</th>' +
                '<th>Leave Credits Earned</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="table3_body">' +
                '</tbody>' +
                '</table>'
            );

            $.each(response, function (key, value) {
                $('#table3_body').append(
                    '<tr>' +
                    '<td class="text-center">' + value.days_present + '</td>' +
                    '<td class="text-right">' + value.days_on_leave_wo_pay + '</td>' +
                    '<td class="text-right">' + value.leave_credits_earned + '</td>' +
                    '</tr>'
                );
            });

            $('#my_table3').DataTable({ "sorting": false });
        }

    });
}

function load_table4() {
    $.ajax({
        url: global_path + "/hr/settings/table4",
        method: 'post',
        dataType: 'json',
        success: function (response) {
            $('#table4').empty();
            $('#table4').append('<table class="table table-bordered table-sm table4" id="my_table4">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Minutes</th>' +
                '<th>Equiv. Days</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="table4_body">' +
                '</tbody>' +
                '</table>'
            );

            $.each(response, function (key, value) {
                $('#table4_body').append(
                    '<tr>' +
                    '<td class="text-center">' + value.minutes + '</td>' +
                    '<td class="text-right">' + value.equiv_day + '</td>' +
                    '</tr>'
                );
            });

            $('#my_table4').DataTable({ "sorting": false });
        }

    });
}