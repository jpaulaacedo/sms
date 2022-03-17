$(document).ready(function () {
    // $('#dataSheetModal').modal('show');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#email').keyup(function () {
        var formData = new FormData();
        formData.append('email', $(this).val());
        formData.append('user_id', $('#user_id').val());
        $.ajax({
            url: global_path + "/hr/staff/check_email",
            method: 'post',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response == "exists") {
                    $('#error_msg').attr("hidden", false);
                    $('#btn_submit').attr("disabled", "disabled");
                } else {
                    $('#error_msg').attr("hidden", "hidden");
                    $('#btn_submit').removeAttr("disabled");
                }
            },
            cache: false,
            contentType: false,
            processData: false
        })
    });

    $("#img").change(function () {
        readURL(this);
    });

    $("#img_signature").change(function () {
        readURL_signature(this);
    });

    $('#btn_add').click(function () {
        $('#staff_modal').modal('show');
        $(".user_input").val('');
        $('#user_id').val('');
    });

});

function _file(user_id) {
    var formData = new FormData();
    formData.append('user_id', user_id);
    $.ajax({
        url: global_path + "/hr/staff/uploads",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function ([response, response2]) {
            // alert(response.length);
            $('#file_modal').modal('show');
            $('#uploads_table_div').empty();
            $('#header_title').text("Files & Attachments of " + response2.firstname + " " + response2.lastname);
            $('#uploads_table_div').append(
                '<table class="table table-bordered table-sm table-striped" id="uploads_table">' +
                '<thead>' +
                '<tr bgcolor="#084596" class="text-white">' +
                '<th width="20%">DOCUMENT</th>' +
                '<th width="10%">YEAR</th>' +
                '<th width="70%">FILE</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="uploads_table"></tbody>' +
                '</table>'
            );
            $.each(response, function (key, value,) {
                $('#uploads_table').append(
                    '<tr>' +
                    '<td>' + value.type + '</td>' +
                    '<td>' + value.year + '</td>' +
                    '<td><a href="' + global_path + '/images/uploads/' + value.file + '" target="_blank">' + value.file + '</a></td>' +
                    '</tr>')
            });

            $('#uploads_table').DataTable({
                "sorting": false, "targets": 'no-sort',
                "bSort": false,
                "order": []
            });
        },
        cache: false,
        contentType: false,
        processData: false
    })
}



function _edit(user_id) {
    $(".user_input").val('');
    var formData = new FormData();
    formData.append('user_id', user_id);
    $.ajax({
        url: global_path + "/hr/staff/edit",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#staff_modal').modal('show');
            $('#user_id').val(response.id);
            $('#firstname').val(response.firstname);
            $('#lastname').val(response.lastname);
            $('#middlename').val(response.middlename);
            $('#nickname').val(response.nickname);
            $('#email').val(response.email);
            $('#contact_no').val(response.contact_no);
            $('#birthday').val(response.birthday);
            $('#blood_type').val(response.blood_type);
            $('#home_address').val(response.home_address);
            $('#sex').val(response.sex);
            $('#division_id').val(response.division_id);
            $('#position_id').val(response.position_id);
            $('#employee_type').val(response.employee_type);
            $('#user_type').val(response.user_type);
            $('#date_hired').val(response.date_hired);
            $('#step_increment').val(response.step_increment);
            $('#id_no').val(response.id_no);
            $('#bp_no').val(response.bp_no);
            $('#pag_ibig').val(response.pag_ibig);
            $('#tin_no').val(response.tin_no);
            $('#philhealth').val(response.philhealth);
            $('#contact_person').val(response.contact_person);
            $('#contact_person_no').val(response.contact_person_no);
            $('#emergency_address').val(response.emergency_address);
            $('#password').removeAttr('required');

            if (response.img != null) {
                $('#pic_preview').attr("src", global_path + "/images/profile_pic/" + response.img);
            } else {
                $('#pic_preview').attr("src", global_path + '/images/empty-profile.jpg');
            }

            if (response.signature != null) {
                $('#pic_preview_signature').attr("src", global_path + "/images/esign/" + response.signature);
            } else {
                $('#pic_preview_signature').attr("src", global_path + '/images/no-esign.png');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    })
}


function _delete(user_id, user_name) {
    Swal.fire({
        title: 'Archive ' + user_name + ' from records?',
        text: 'this will put ' + user_name + 'to archived records as well as all records involving him/her',
        input: 'text',
        inputPlaceholder: 'Type "CONFIRM" to proceed',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Archive',
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
            formData.append('user_id', user_id);
            $.ajax({
                url: global_path + "/hr/staff/archive",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    let timerInterval
                    Swal.fire({
                        title: response + ' successfully archived',
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
                            window.location.href = global_path + "/hr/staff";
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

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#pic_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function readURL_signature(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#pic_preview_signature').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$('.data-sheet').click(function () {
    var docs_user_id = $(this).data('id');
    $('#dataSheetModal').modal('show');
    $('#dataSheetModal').on('shown.bs.modal', function () {
        $('#docs_user_id').val(docs_user_id);
        dataSheet(docs_user_id);
    })
})

$('#dataSheetForm').submit(function (e) {
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    Swal.fire('File uploading!, please wait!')
    Swal.showLoading();
    $.ajax({
        url: global_path + '/staff/personnel-file',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function (response) {
            setTimeout(function () {
                Swal.close();
                Swal.fire('Saved!', 'File Uploaded', 'success')
            }, 500);
        }
    });
});

function dataSheet(data_user_id) {
    // alert('asd')
    oTable = $('#dataSheetTbl').DataTable({
        "pageLength": 20,
        "aProcessing": true,
        "aServerSide": true,
        "orderCellsTop": true,
        "bDeferRender": true,
        "dom": 'Bfrtip',
        "bDestroy": true,
        "scrollX": true,
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        // "paging":         false,

        //         "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]

        "ajax": {
            "url": global_path + "/staff/datasheet/" + data_user_id,
            "dataSrc": ""
        },
        "columns": [{
            "data": "name",
            "mRender": function (data, type, full, meta) {
                return '<td><a href="/' + full.attachment + '">' + full.name + '</a></td>';
            }
        },
            // {
            //     "data": "id",
            //     "mRender": function (data, type, full, meta) {
            //         return '<td>' + full.id + '</td>';
            //     }
            // },
        ],
    });

}