$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#btn_add').click(function () {
        $('#payroll_staff_modal').modal('show');
        $('#payroll_staff_id').val('');
        $('#employee_type').val('');
        $('#user_id').val('');

        $('#position').val('');
        $('#division').val('');
        $('#gross').val('');
        $('#total_deduction').val('');
        $('#net').val('');
        $('.compensation').val('');
        $('.deductions').val('');
    });

    $('#bonuses').keyup(function () {
        var total = parseFloat($(this).val().replace("₱", "").replace(",", ""));
        $("#net").val(total);
        $("#net").keyup();
    });

    $('#user_id').change(function () {
        load_user($(this).val(),1);
    });

    // $('#payrollModal').modal('show');
    // test();
});

function load_user(user_id,with_basic) {
    $('#position').val('');
    $('#division').val('');
    $('#salary').val('');
    $('#rata').val('');
    $('#pera').val('');
    $('#employee_type').val('');
    var formData = new FormData();
    formData.append('user_id', user_id);
    $.ajax({
        url: global_path + "/hr/payroll/staff/get_user_details",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#position').val(response.position);
            $('#division').val(response.division);
            if (with_basic == 1) {
                $('#salary').val(response.basic_salary);
            }
            $('#employee_type').val(response.employee_type);
            if (response.employee_type == "Permanent" || response.employee_type == "Contractual Regular") {
                if (response.user_type == 2) {
                    $("#rata").val(10000);
                } else if (response.user_type == 4) {
                    $("#rata").val(18000);
                }
                $("#pera").val(2000);
            }
            $("input[data-type='currency']").keyup();
            $(".compensation").keyup();
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

$(".compensation").keyup(function () {
    var sum = 0;
    $(".compensation").each(function () {
        if ($(this).val() != "") {
            sum += +parseFloat($(this).val().replace("₱", "").replace(",", ""));
        }
    });

    $("#gross").val(sum.toFixed(2));
    $("#gross").keyup();
    get_net();
});

$(".deductions").keyup(function () {
    var sum = 0;
    $(".deductions").each(function () {
        if ($(this).val() != "") {
            sum += +parseFloat($(this).val().replace("₱", "").replace(",", ""));
        }
    });

    $("#total_deduction").val(sum.toFixed(2));
    $("#total_deduction").keyup();
    $("#total_contribution").val(sum.toFixed(2));
    $("#total_contribution").keyup();
    get_net();
});

function get_net() {
    var total = 0;
    if ($("#payroll_type").val() == "Regular Payroll") {
        total = parseFloat($("#gross").val().replace("₱", "").replace(",", "")) - parseFloat($("#total_deduction").val().replace("₱", "").replace(",", ""));
    } else if ($("#payroll_type").val() == "CSW / Probationary Payroll") {
        total = parseFloat($("#periodic_salary").val().replace("₱", "").replace(",", "")) - parseFloat($("#total_contribution").val().replace("₱", "").replace(",", ""));
    }
    $("#net").val(total.toFixed(2));
    $("#net").keyup();
}

function _edit(payroll_staff_id) {
    var formData = new FormData();
    formData.append('payroll_staff_id', payroll_staff_id);
    $.ajax({
        url: global_path + "/hr/payroll/staff/edit",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#payroll_staff_modal').modal('show');
            $('#payroll_staff_id').val(payroll_staff_id);
            $('#user_id').val(response.user_id);
            load_user(response.user_id,0);
            $('#pera').val(response.pera);
            $('#salary').val(response.salary_regular + response.salary_contractual + response.periodic_salary);
            $('#rata').val(response.rata);
            $('#tax').val(response.tax);
            $('#rlip').val(response.rlip);
            $('#periodic_salary').val(response.periodic_salary);
            $('#phic').val(response.phic);
            $('#philhealth').val(response.philhealth);
            $('#hdmf').val(response.hdmf);
            $('#hdmf_mp2').val(response.hdmf_mp2);
            $('#gsis_opt_policy').val(response.gsis_opt_policy);
            $('#assert').val(response.assert);
            $('#conso_loan').val(response.conso_loan);
            $('#regular_pol_loan').val(response.regular_pol_loan);
            $('#opt_pol_loan').val(response.opt_pol_loan);
            $('#gfal').val(response.gfal);
            $('#emergency_loan').val(response.emergency_loan);
            $('#gsis_educ_loan').val(response.gsis_educ_loan);
            $('#lowcos_house_loan').val(response.lowcos_house_loan);
            $('#cpl').val(response.cpl);
            $('#mpl').val(response.mpl);
            $('#mult_purp_loan').val(response.mult_purp_loan);
            $('#calamity_loan').val(response.calamity_loan);
            $('#live_program').val(response.live_program);
            $('#disallowance').val(response.disallowance);
            $('#bonuses').val(response.bonuses);
            $("input[data-type='currency']").keyup();
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function test() {
    var pathname = window.location.pathname;
    $.ajax({
        url: pathname,
        method: 'get',
        dataType: 'json',
        success: function (response) {


        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function _delete(payroll_staff_id, staff) {
    Swal.fire({
        title: 'Remove ' + staff + ' from this payroll?',
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
            formData.append('payroll_staff_id', payroll_staff_id);
            $.ajax({
                url: global_path + "/hr/payroll/staff/delete",
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
                            location.reload();
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

$("input[data-type='currency']").on({
    keyup: function () {
        formatCurrency($(this));
    },
    blur: function () {
        formatCurrency($(this), "blur");
    }
});


function formatNumber(n) {
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}


function formatCurrency(input, blur) {
    var input_val = input.val();
    if (input_val === "") { return; }
    var original_len = input_val.length;
    var caret_pos = input.prop("selectionStart");
    if (input_val.indexOf(".") >= 0) {
        var decimal_pos = input_val.indexOf(".");
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);
        left_side = formatNumber(left_side);
        right_side = formatNumber(right_side);
        if (blur === "blur") {
            right_side += "00";
        }
        right_side = right_side.substring(0, 2);
        input_val = "₱" + left_side + "." + right_side;
    } else {
        input_val = formatNumber(input_val);
        input_val = "₱" + input_val;
        if (blur === "blur") {
            input_val += ".00";
        }
    }
    input.val(input_val);
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}

$('#payrollModal').on('shown.bs.modal', function () {
    reportTbl();
})


// function reportTbl() {
//     $('#payrollTblReport').DataTable({
//         "bDestroy": true,
//         "scrollX": true,
//         scrollResize: true,
//         scrollY: 550,
//         scrollCollapse: true,
//         "paging": false,
//         "lengthChange": false,
//         "searching": false,
//         "ordering": false,
//         "info": true,
//         "autoWidth": false,
//         "responsive": false,
//         "buttons": [{
//             extend: 'copyHtml5',
//             footer: true
//         },
//         {
//             extend: 'excelHtml5',
//             footer: true
//         },
//         {
//             extend: 'csvHtml5',
//             footer: true
//         },
//         {
//             extend: 'pdfHtml5',
//             footer: true
//         },
//             "colvis"
//         ],
//     }).buttons().container().appendTo('#transactionTbl_wrapper .col-md-6:eq(0)');
// }

function reportTbl() {
    var pathname = window.location.pathname;
    $('#payrollTblReport').DataTable({
        // "pageLength": 20,
        "dom": 'Bfrtip',
        "bDestroy": true,
        "scrollX": true,
        "lengthChange": true,
        // "autoWidth": true,]
        "paging": false,
        "scrollY": "600px",
        "scrollCollapse": true,
        "buttons": [{ extend: 'copyHtml5', footer: true },
        { extend: 'excelHtml5', header: true },
        { extend: 'csvHtml5', header: true },
        { extend: 'pdfHtml5', header: true },
        { extend: 'print', header: true },
        ],
        "ajax": {
            "url": pathname,
            "dataSrc": ""
        },
        "columns": [
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    return '<td>' + full.id + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    // $(nTd).css('min-width', '100px !important');
                },
                "mRender": function (data, type, full, meta) {
                    return '<td>' + full.employee_info.firstname + ' ' + full.employee_info.lastname + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    return '<td>' + full.employee_info.position.title + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let employee_no = '';
                    if (full.employee_info.id_no) {
                        employee_no = full.employee_info.id_no;
                    }
                    return '<td>' + employee_no + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).css('width', '350px');
                },
                "mRender": function (data, type, full, meta) {
                    let salary_regular = full.salary_regular ? addCommas(full.salary_regular.toFixed(2)) : "-";
                    return '<td>' + salary_regular + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let salaryWageContractual = 0;
                    return '<td>-</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let pera = full.pera ? addCommas(full.pera.toFixed(2)) : "-";
                    return '<td>' + pera + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let rata = full.rata ? addCommas(full.rata.toFixed(2)) : "-";
                    return '<td>' + rata + '</td>';
                }
            },


            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let gross = full.gross ? addCommas(full.gross.toFixed(2)) : "-";
                    return '<td>' + gross + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let tax = full.tax ? addCommas(full.tax.toFixed(2)) : "-";
                    return '<td>' + tax + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let rlip = full.rlip ? addCommas(full.rlip.toFixed(2)) : "-";
                    return '<td>' + rlip + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let philhealth = full.philhealth ? addCommas(full.philhealth.toFixed(2)) : "-";
                    return '<td>' + philhealth + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let hdmf = full.hdmf ? addCommas(full.hdmf.toFixed(2)) : "-";
                    return '<td>' + hdmf + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let hdmf_mp2 = full.hdmf_mp2 ? addCommas(full.hdmf_mp2.toFixed(2)) : "-";
                    return '<td>' + hdmf_mp2 + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let gsis_opt_policy = full.gsis_opt_policy ? addCommas(full.gsis_opt_policy.toFixed(2)) : "-";
                    return '<td>' + gsis_opt_policy + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let assert = full.assert ? addCommas(full.assert.toFixed(2)) : "-";
                    return '<td>' + assert + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let conso_loan = full.conso_loan ? addCommas(full.conso_loan.toFixed(2)) : "-";
                    return '<td>' + conso_loan + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let regular_pol_loan = full.regular_pol_loan ? addCommas(full.regular_pol_loan.toFixed(2)) : "-";
                    return '<td>' + regular_pol_loan + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let opt_pol_loan = full.opt_pol_loan ? addCommas(full.opt_pol_loan.toFixed(2)) : "-";
                    return '<td>' + opt_pol_loan + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let gfal = full.gfal ? addCommas(full.gfal.toFixed(2)) : "-";
                    return '<td>' + gfal + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let emergency_loan = full.emergency_loan ? addCommas(full.emergency_loan.toFixed(2)) : "-";
                    return '<td>' + emergency_loan + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                },
                "mRender": function (data, type, full, meta) {
                    let gsis_educ_loan = full.gsis_educ_loan ? addCommas(full.gsis_educ_loan.toFixed(2)) : "-";
                    return '<td>' + gsis_educ_loan + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).css('width', '350px !important');
                },
                "mRender": function (data, type, full, meta) {
                    let lowcos_house_loan = full.lowcos_house_loan ? addCommas(full.lowcos_house_loan.toFixed(2)) : "-";
                    return '<td>' + lowcos_house_loan + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).css('width', '350px !important');
                },
                "mRender": function (data, type, full, meta) {
                    let cpl = full.cpl ? addCommas(full.cpl.toFixed(2)) : "-";
                    return '<td>' + cpl + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).css('width', '350px !important');
                },
                "mRender": function (data, type, full, meta) {
                    let mpl = full.mpl ? addCommas(full.mpl.toFixed(2)) : "-";
                    return '<td>' + mpl + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).css('width', '350px !important');
                },
                "mRender": function (data, type, full, meta) {
                    let mult_purp_loan = full.mult_purp_loan ? addCommas(full.mult_purp_loan.toFixed(2)) : "-";
                    return '<td>' + mult_purp_loan + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).css('width', '350px !important');
                },
                "mRender": function (data, type, full, meta) {
                    let calamity_loan = full.calamity_loan ? addCommas(full.calamity_loan.toFixed(2)) : "-";
                    return '<td>' + calamity_loan + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).css('width', '350px !important');
                },
                "mRender": function (data, type, full, meta) {
                    let live_program = full.live_program ? addCommas(full.live_program.toFixed(2)) : "-";
                    return '<td>' + live_program + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).css('width', '350px !important');
                },
                "mRender": function (data, type, full, meta) {
                    let disallowance = full.disallowance ? addCommas(full.disallowance.toFixed(2)) : "-";
                    return '<td>' + disallowance + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).css('width', '350px !important');
                },
                "mRender": function (data, type, full, meta) {
                    let total_deduction = full.total_deduction ? addCommas(full.total_deduction.toFixed(2)) : "-";
                    return '<td>' + total_deduction + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).css('width', '350px !important');
                },
                "mRender": function (data, type, full, meta) {
                    let net = full.net ? addCommas(full.net.toFixed(2)) : "-";
                    return '<td>' + net + '</td>';
                }
            },
            {
                "data": "id",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).css('width', '350px !important');
                },
                "mRender": function (data, type, full, meta) {
                    return '<td> </td>';
                }
            },

        ], "columnDefs": [
        ],
        // "footerCallback": function (row, data, start, end, display) {
        //     var api = this.api(), data;

        //     // Remove the formatting to get integer data for summation
        //     var intVal = function (i) {
        //         return typeof i === 'string' ?
        //             i.replace(/[\$,]/g, '') * 1 :
        //             typeof i === 'number' ?
        //                 i : 0.00;
        //     };

        //     // Total over all pages
        //     total = api
        //         .column(23)
        //         .data()
        //         .reduce(function (a, b) {
        //             return intVal(a) + intVal(b);
        //         }, 0);

        //     // Total over this page
        //     pageTotal = api
        //         .column(23, { page: 'current' })
        //         .data()
        //         .reduce(function (a, b) {
        //             return intVal(a) + intVal(b);
        //         }, 0);

        //     // Update footer





        //     $(api.column(23).footer()).html(
        //         addCommas(parseFloat((pageTotal)).toFixed(2))
        //         // parseFloat((pageTotal)).toFixed(2) + ' ( ' + parseFloat(total).toFixed(2) + ' total)'
        //     );

        // }




    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)')
}

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    total = x1 + x2
    return total;
}