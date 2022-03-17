$(document).ready(function () {
    var cat_id = $('#q_cat_id').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    load_positions();

    $("#img_question").change(function () {
        readURL(this);
    });

    $("#question_form").submit(function (e) {
        var cat_id = $("#q_cat_id").val();
        e.preventDefault();
        if (validate_question() == "1") {
            Swal.fire(
                "All fields are required",
                "Record not saved.",
                'warning'
            )
        } else {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            Swal.fire('Loading...')
            Swal.showLoading();
            $.ajax({
                url: global_path + '/hr/save_question',
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                success: function (response) {
                    load_categories();
                    load_questions(cat_id);
                    clear_question_field();
                    setTimeout(function () {
                        Swal.close();
                        Swal.fire('Saved!', response, 'success')
                    }, 500);
                }
            });
        }
    });

    $("#choice_form").submit(function (e) {
        var cat_id = $("#c_cat_id").val();
        var question_id = $("#c_q_id").val();
        e.preventDefault();
        if ($('#choice').val() == "") {
            Swal.fire(
                "Input choice on text box.",
                "Record not saved.",
                'warning'
            )
        } else {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            Swal.fire('Loading...')
            Swal.showLoading();
            $.ajax({
                url: global_path + '/hr/save_choice',
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                success: function (response) {
                    load_choices(question_id, $('#choice_title').html(), cat_id)
                    load_questions(cat_id);
                    clear_choice_field();
                    setTimeout(function () {
                        Swal.close();
                        Swal.fire('Saved!', response, 'success')
                    }, 500);
                }
            });
        }
    });

    $("#profile_form").submit(function (e) {
        e.preventDefault();
        if ($('#firstname').val() == "" || $('#lastname').val() == "" || $('#email').val() == "" || $('#contact').val() == "") {
            Swal.fire(
                "Required fields missing.",
                "Record not saved.",
                'warning'
            )
        } else {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            Swal.fire('Loading...')
            Swal.showLoading();
            $.ajax({
                url: global_path + '/hr/save_profile',
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                success: function (response) {
                    empty_profile();
                    load_profile();
                    setTimeout(function () {
                        Swal.close();
                        Swal.fire('Saved!', response, 'success')
                    }, 500);
                }
            });
        }
    });

    $('#file').on('change', function () {
        var fileName = $(this).val().replace('C:\\fakepath\\', "");
        $(this).next('.custom-file-label').html(fileName);
    });

    $('#file2').on('change', function () {
        var fileName = $(this).val().replace('C:\\fakepath\\', "");
        $(this).next('.custom-file-label').html(fileName);
    });

    $('#eval_file').on('change', function () {
        var fileName = $(this).val().replace('C:\\fakepath\\', "");
        $(this).next('.custom-file-label').html(fileName);
    });

    $("#attachments_form").submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Proceed?',
            text: "Upload attachments?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $('#overlay').fadeIn();
                var formData = new FormData();
                formData.append('file_type', $('#file_type').val());
                formData.append('applicant_id', $('#applicant_id').val());
                formData.append('filename', $('#file').val());
                formData.append('file', $('#file')[0].files[0]);
                $.ajax({
                    url: global_path + '/hr/upload_requirements',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    async: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    success: function (response) {
                        if (response == 1) {
                            $('#overlay').delay(100).fadeOut('fast', function () {
                                Swal.fire(
                                    'Success!',
                                    'Attached file have been successfully uploaded!',
                                    'success'
                                ).then((result) => {
                                    application_upload($('#docs_application_id').val());
                                })
                            });
                        }
                        else {
                            $('#overlay').delay(100).fadeOut('fast', function () {
                                Swal.fire(
                                    'Note!',
                                    'Attached file must be in PDF!',
                                    'warning'
                                )
                            });
                        }
                    }
                });
            }
        });


    });

    $("#attachments2_form").submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Proceed?',
            text: "Upload attachments?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $('#overlay').fadeIn();
                var formData = new FormData();
                formData.append('file_type', $('#file2_type').val());
                formData.append('applicant_id', $('#applicant2_id').val());
                formData.append('filename', $('#file2').val());
                formData.append('file', $('#file2')[0].files[0]);
                $.ajax({
                    url: global_path + '/hr/upload_requirements',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    async: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    success: function (response) {
                        if (response == 1) {
                            $('#overlay').delay(100).fadeOut('fast', function () {
                                Swal.fire(
                                    'Success!',
                                    'Attached file have been successfully uploaded!',
                                    'success'
                                ).then((result) => {
                                    profile_upload($('#docs2_application_id').val());
                                })
                            });
                        }
                        else {
                            $('#overlay').delay(100).fadeOut('fast', function () {
                                Swal.fire(
                                    'Note!',
                                    'Attached file must be in PDF!',
                                    'warning'
                                )
                            });
                        }
                    }
                });
            }
        });


    });

    $("#eval_docs_form").submit(function (e) {
        e.preventDefault();
        // alert($('#applicant_id').val());
        Swal.fire({
            title: 'Proceed?',
            text: "Upload evaluation attachments?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $('#overlay').fadeIn();
                var formData = new FormData();
                formData.append('file_type', $('#eval_file_type').val());
                formData.append('application_id', $('#eval_application_id').val());
                formData.append('filename', $('#eval_file').val());
                formData.append('file', $('#eval_file')[0].files[0]);
                $.ajax({
                    url: global_path + '/hr/upload_eval_docs',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    async: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    success: function (response) {
                        if (response == 1) {
                            $('#overlay').delay(100).fadeOut('fast', function () {
                                Swal.fire(
                                    'Success!',
                                    'File successfully uploaded',
                                    'success'
                                ).then((result) => {
                                    $('#eval_file').val('');
                                    $('#eval_file').next('.custom-file-label').html('');
                                    $('#eval_file_type').val('');
                                    application_eval_upload($('#eval_application_id').val());
                                })
                            });
                        }
                        else {
                            $('#overlay').delay(100).fadeOut('fast', function () {
                                Swal.fire(
                                    'Note!',
                                    'Error uploading file',
                                    'warning'
                                )
                            });
                        }
                    }
                });
            }
        });


    });

    $("#application_form").submit(function (e) {
        e.preventDefault();
        if ($('#applicant_id').val() == null || $('#position_id').val() == null || $('#app_status').val() == null) {
            Swal.fire(
                "Required fields missing.",
                "Record not saved.",
                'warning'
            )
        } else {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            Swal.fire('Loading...')
            Swal.showLoading();
            $.ajax({
                url: global_path + '/hr/save_application',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                success: function (response) {
                    empty_application();
                    load_applications();
                    setTimeout(function () {
                        Swal.close();
                        Swal.fire('Saved!', response, 'success')
                    }, 500);
                }
            });
        }
    });

    $("#questionnaire_form").submit(function (e) {
        e.preventDefault();
        if ($("#q_category_id").val() == null) {
            Swal.fire(
                "Please select category from dropdown",
                "Record not saved.",
                'warning'
            )
        } else {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            Swal.fire('Loading...')
            Swal.showLoading();
            $.ajax({
                url: global_path + "/hr/recruitment/save_questionnaire",
                method: 'post',
                data: formData,
                dataType: 'json',
                async: false,
                success: function (response) {
                    if (response != "failed") {
                        load_questionnaire(response);
                        setTimeout(function () {
                            Swal.close();
                            Swal.fire('Saved!', 'added', 'success')
                        }, 500);
                    } else {
                        setTimeout(function () {
                            Swal.close();
                            Swal.fire('Failed.', 'already in list', 'error')
                        }, 500);
                    }
                },
                cache: false,
                contentType: false,
                processData: false

            });
        }
    });

    $("#evaluators_form").submit(function (e) {
        e.preventDefault();
        if ($("#user_id").val() == null) {
            Swal.fire(
                "Please select staff from dropdown",
                "Record not saved.",
                'warning'
            )
        } else {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            Swal.fire('Loading...')
            Swal.showLoading();
            $.ajax({
                url: global_path + "/hr/recruitment/save_evaluator",
                method: 'post',
                data: formData,
                dataType: 'json',
                async: false,
                success: function (response) {
                    if (response != "failed") {
                        load_evaluators(response);
                        setTimeout(function () {
                            Swal.close();
                            Swal.fire('Saved!', 'added', 'success')
                        }, 500);
                    } else {
                        setTimeout(function () {
                            Swal.close();
                            Swal.fire('Failed.', 'already in list', 'error')
                        }, 500);
                    }
                },
                cache: false,
                contentType: false,
                processData: false

            });
        }
    });
});

// ============== POSITIONS ===============

function load_positions() {
    empty_positions();
    $.ajax({
        url: global_path + "/hr/recruitment/positions",
        method: 'post',
        dataType: 'json',
        success: function (response) {
            $('#pos_table').empty();
            $('#pos_table').append('<table class="table table-bordered table-sm position_table" id="my_positions_table">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Position Code</th>' +
                '<th>Title</th>' +
                '<th>Division</th>' +
                '<th>Salary Grade</th>' +
                '<th>Recruitment Status</th>' +
                '<th></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="pos_body">' +
                '</tbody>' +
                '</table>'
            );
            var status_open = 0;
            var status_ongoing = 0;
            $.each(response, function (key, value) {
                if (value.status == "Filled Up") {
                    var color = "success";
                } else if (value.status == "Open for Application") {
                    var color = "warning";
                    status_open++;
                } else {
                    var color = "secondary";
                    status_ongoing++;
                }
                $('#pos_body').append(
                    '<tr class="text-center">' +
                    '<td>' + value.position_code + '</td>' +
                    '<td class="text-left">' + value.title + '</td>' +
                    '<td>' + get_division_accronym(value.division_id) + '</td>' +
                    '<td>' + value.salary_grade + '</td>' +
                    '<td><span class="badge badge-' + color + '">' + value.status + '</span></td>' +
                    '<td>' +
                    '<button class="btn btn-success btn-sm" onclick="questionnaire(' + '\'' + escape_quotes(value.position_code) + '\'' + ',' + '\'' + escape_quotes(value.title) + '\'' + ',' + value.id + ')">questionnaire</button> | ' +
                    // '<button class="btn btn-warning btn-sm" onclick="evaluators(' + '\'' + escape_quotes(value.position_code) + '\'' + ',' + '\'' + escape_quotes(value.title) + '\'' + ',' + value.id + ')"><span class="fa fa-users"></span> evaluators</button> | ' +
                    '<button class="btn btn-primary btn-sm" onclick="position_edit(' + value.id + ')"><span class="fa fa-edit"></span></button> | ' +
                    '<button class="btn btn-danger btn-sm" onclick="position_delete(' + value.id + ')"><span class="fa fa-trash"></span></button>' +
                    '</td>' +
                    '</tr>'
                );
            });

            $('#my_positions_table').DataTable({
                "sorting": false, "targets": 'no-sort',
                "bSort": false,
                "order": []
            });
            $('#open_notif').html(status_open);
            $('#ongoing_notif').html(status_ongoing);
        },
        cache: false,
        contentType: false,
        processData: false

    });
}

function empty_positions() {
    $('#position_code').val('');
    $('#title').val('');
    $('#division_id').val('');
    $('#salary_grade1').val('');
    category_dropdown();
    user_dropdown();
}

function position_create() {
    $('#pos_modal').modal('toggle');
    $('#pos_modal').modal('show');
    $('#pos_id').val('');
    empty_positions();
}

function position_edit(id) {
    $('#pos_modal').modal('toggle');
    $('#pos_modal').modal('show');
    $('#pos_id').val(id);
    var formData = new FormData();
    formData.append('pos_id', id);
    $.ajax({
        url: global_path + "/hr/recruitment/positions/get_positions",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            empty_positions();
            $('#position_code').val(response.position_code);
            $('#title').val(response.title);
            $('#division_id').val(response.division_id);
            $('#salary_grade1').val(response.salary_grade);
            $('#status').val(response.status);
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function position_delete(id) {
    Swal.fire({
        title: "Delete this item?",
        text: "You will not be able to revert this. ",
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Close',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#525252',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            var formData = new FormData();
            formData.append('pos_id', id);
            $.ajax({
                url: global_path + "/hr/recruitment/positions/delete",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    Swal.fire(
                        response,
                        "Record deleted.",
                        'success'
                    ).then((result) => {
                        load_positions();
                    })
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    })
}

function positions_save() {
    if (validate_position() == "1") {
        Swal.fire(
            "All fields are required",
            "Record not saved.",
            'warning'
        )
    } else {
        var formData = new FormData();
        if ($('#pos_id').val() != "") {
            formData.append('pos_id', $('#pos_id').val());
        } else {
            formData.append('pos_id', "0");
        }
        formData.append('position_code', $('#position_code').val());
        formData.append('title', $('#title').val());
        formData.append('division_id', $('#division_id').val());
        formData.append('salary_grade', $('#salary_grade1').val());
        formData.append('status', $('#status').val());
        $.ajax({
            url: global_path + "/hr/recruitment/positions/save",
            method: 'post',
            data: formData,
            dataType: 'json',
            success: function (response) {
                Swal.fire(
                    response,
                    "Record Saved.",
                    'success'
                ).then((result) => {
                    load_positions();
                    $('#pos_id').val('')
                })
            },
            cache: false,
            contentType: false,
            processData: false
        })
    }
}

function validate_position() {
    var selectedDivision = $($('#division_id').val()).children("option:selected").val();
    var selectedSg = $($('#salary_grade1').val()).children("option:selected").val();
    if ($('#position_code').val() == "" ||
        $('#title').val() == "" ||
        selectedDivision == "" ||
        selectedSg == "") {
        return "1";
    } else {
        return "0";
    }
}

function get_division_accronym(division_id) {
    var my_string;

    if (division_id == 1) {
        my_string = '<span class="badge badge-success">OED</span>';
    } else if (division_id == 5) {
        my_string = '<span class="badge badge-danger">TD</span>';
    } else if (division_id == 4) {
        my_string = '<span class="badge badge-info">RD</span>';
    } else if (division_id == 3) {
        my_string = '<span class="badge badge-warning">KMD</span>';
    } else if (division_id == 2) {
        my_string = '<span class="badge badge-primary">FAD</span>';
    }

    return my_string;
}

function questionnaire(position_code, title, id) {
    $('#questionnaire_modal').modal('toggle');
    $('#questionnaire_modal').modal('show');
    $('#q_position_id').val(id);
    $('#q_title').html(title);
    $('#q_code').html(position_code);
    load_questionnaire(id);
}

function category_dropdown() {
    $.ajax({
        url: global_path + "/hr/recruitment/categories",
        method: 'post',
        dataType: 'json',
        async: false,
        success: function (response) {
            $('#q_category_id').empty();
            $('#q_category_id').append('<option value="" selected disabled>-- select category--</option>');
            $.each(response, function (key, value) {
                $('#q_category_id').append('<option value="' + value.id + '">' + value.category + '</option>');
            });
        },
        cache: false,
        contentType: false,
        processData: false

    });
}

function load_questionnaire(id) {
    var formData = new FormData();
    formData.append('position_id', id);
    $.ajax({
        url: global_path + "/hr/recruitment/load_questionnaire",
        method: 'post',
        data: formData,
        dataType: 'json',
        async: false,
        success: function (response) {
            $('#questionnaire_table').empty();
            $('#questionnaire_table').append('<table class="table table-bordered table-striped table-sm" id="my_questionnaire_table">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Category</th>' +
                '<th width="15%"></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="questionnaire_body">' +
                '</tbody>' +
                '</table>'
            );
            $.each(response, function (key, value) {
                $('#questionnaire_body').append(
                    '<tr class="text-center">' +
                    '<td class="text-left">' + value.category + '</td>' +
                    '<td>' +
                    '<a class="btn btn-danger btn-sm text-white btn-circle" onclick="delete_questionnaire(' + value.category_id + ',' + id + ')"><span class="fa fa-minus"></span></a>' +
                    '</td>' +
                    '</tr>'
                );
            });

            $('#my_questionnaire_table').DataTable({
                "searching": false,
                "bPaginate": false,
                "ordering": false,
            });
        },
        cache: false,
        contentType: false,
        processData: false

    });
}


function load_evaluators(id) {
    var formData = new FormData();
    formData.append('position_id', id);
    $.ajax({
        url: global_path + "/hr/recruitment/load_evaluators",
        method: 'post',
        data: formData,
        dataType: 'json',
        async: false,
        success: function (response) {
            $('#evaluators_table').empty();
            $('#evaluators_table').append('<table class="table table-bordered table-striped table-sm" id="my_evaluators_table">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Name</th>' +
                '<th>Role</th>' +
                '<th width="15%"></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="evaluators_body">' +
                '</tbody>' +
                '</table>'
            );
            $.each(response, function (key, value) {
                $('#evaluators_body').append(
                    '<tr class="text-center">' +
                    '<td class="text-left">' + value.firstname + ' ' + value.lastname + '</td>' +
                    '<td class="text-left">' + value.role + '</td>' +
                    '<td>' +
                    '<a class="btn btn-danger btn-sm text-white btn-circle" onclick="delete_evaluator(' + value.user_id + ',' + id + ')"><span class="fa fa-minus"></span></a>' +
                    '</td>' +
                    '</tr>'
                );
            });

            $('#my_evaluators_table').DataTable({
                "searching": false,
                "bPaginate": false,
                "ordering": false,
            });
        },
        cache: false,
        contentType: false,
        processData: false

    });
}

function user_dropdown() {
    $.ajax({
        url: global_path + "/hr/recruitment/get_evaluators",
        method: 'post',
        dataType: 'json',
        async: false,
        success: function (response) {
            $('#user_id').empty();
            $('#user_id').append('<option value="" selected disabled>-- select name --</option>');
            $.each(response, function (key, value) {
                $('#user_id').append('<option value="' + value.user_id + '">' + value.firstname + ' ' + value.lastname + '</option>');
            });
        },
        cache: false,
        contentType: false,
        processData: false

    });
}

function evaluators(position_code, title, id) {
    $('#evaluators_modal').modal('toggle');
    $('#evaluators_modal').modal('show');
    $('#e_position_id').val(id);
    $('#e_title').html(title);
    $('#e_code').html(position_code);
    load_evaluators(id);
}

function delete_evaluator(user_id, position_id) {
    var formData = new FormData();
    formData.append('user_id', user_id);
    formData.append('position_id', position_id);
    $.ajax({
        url: global_path + "/hr/recruitment/delete_evaluator",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            load_evaluators(response);
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function delete_questionnaire(category_id, position_id) {
    var formData = new FormData();
    formData.append('category_id', category_id);
    formData.append('position_id', position_id);
    $.ajax({
        url: global_path + "/hr/recruitment/delete_questionnaire",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            load_questionnaire(position_id);
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

// ============== END POSITIONS ===============


//=============== CATEGORIES =================


function load_categories() {
    empty_categories();
    $.ajax({
        url: global_path + "/hr/recruitment/categories",
        method: 'post',
        dataType: 'json',
        success: function (response) {
            $('#category_table').empty();
            $('#category_table').append('<table class="table table-bordered table-sm " id="my_category_table">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Exam Category Name</th>' +
                '<th>Time Limit (Minutes)</th>' +
                '<th>Question Count</th>' +
                '<th>Exam Type</th>' +
                '<th></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="category_body">' +
                '</tbody>' +
                '</table>'
            );
            $.each(response, function (key, value) {
                var btn;
                if (value.exam_type == "Mathematical Ability") {
                    btn = "success";
                } else if (value.exam_type == "Verbal Ability") {
                    btn = "info";
                } else if (value.exam_type == "Technical Ability") {
                    btn = "secondary";
                }
                $('#category_body').append(
                    '<tr class="text-center">' +
                    '<td>' + value.category + '</td>' +
                    '<td>' + value.time_limit + '</td>' +
                    '<td>' + value.question_count + '</td>' +
                    '<td><span class="badge badge-' + btn + '">' + value.exam_type + '</span></td>' +
                    '<td>' +
                    '<button class="btn btn-default btn-sm" onclick="insert_question_index(' + '\'' + escape_quotes(value.category) + '\'' + ',' + value.id + ')"><span class="fa fa-plus"></span> <b>insert questions</b></button> | ' +
                    '<button class="btn btn-primary btn-sm" onclick="category_edit(' + value.id + ')"><span class="fa fa-edit"></span></button> | ' +
                    '<button class="btn btn-danger btn-sm" onclick="category_delete(' + value.id + ')"><span class="fa fa-trash"></span></button>' +
                    '</td>' +
                    '</tr>'
                );
            });

            $('#my_category_table').DataTable({
                "sorting": false, "targets": 'no-sort',
                "bSort": false,
                "order": []
            });
        },
        cache: false,
        contentType: false,
        processData: false

    });
}


function empty_categories() {
    $('#category').val('');
    $('#time_limit').val('');
    $('#exam_type').val('');
}

function categories_create() {
    $('#cat_modal').modal('toggle');
    $('#cat_modal').modal('show');
    $('#cat_id').val('');
    empty_categories();
}


function category_edit(id) {
    $('#cat_modal').modal('toggle');
    $('#cat_modal').modal('show');
    $('#cat_id').val(id);
    var formData = new FormData();
    formData.append('cat_id', id);
    $.ajax({
        url: global_path + "/hr/recruitment/categories/get_category",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            empty_positions();
            $('#category').val(response.category);
            $('#time_limit').val(response.time_limit);
            $('#exam_type').val(response.exam_type);
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function category_delete(id) {
    Swal.fire({
        title: "Delete this Category?",
        text: "You will not be able to revert this. ",
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Close',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#525252',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            var formData = new FormData();
            formData.append('cat_id', id);
            $.ajax({
                url: global_path + "/hr/recruitment/categories/delete",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    Swal.fire(
                        response,
                        "Record deleted.",
                        'success'
                    ).then((result) => {
                        load_categories();
                    })
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    })
}

function category_save() {
    if (validate_category() == "1") {
        Swal.fire(
            "All fields are required",
            "Record not saved.",
            'warning'
        )
    } else {
        var formData = new FormData();
        if ($('#cat_id').val() != "") {
            formData.append('cat_id', $('#cat_id').val());
        } else {
            formData.append('cat_id', "0");
        }
        formData.append('category', $('#category').val());
        formData.append('time_limit', $('#time_limit').val());
        formData.append('exam_type', $('#exam_type').val());
        $.ajax({
            url: global_path + "/hr/recruitment/categories/save",
            method: 'post',
            data: formData,
            dataType: 'json',
            success: function (response) {
                Swal.fire(
                    response,
                    "Record Saved.",
                    'success'
                ).then((result) => {
                    load_categories();
                    $('#cat_id').val('');
                    $('#cat_modal').modal('toggle');
                })
            },
            cache: false,
            contentType: false,
            processData: false
        })
    }
}

function validate_category() {
    if ($('#category').val() == "" || $('#time_limit').val() == "" || $('#exam_type').val() == "") {
        return "1";
    } else {
        return "0";
    }
}

function insert_question_index(category_name, category_id) {
    $('#question_modal').modal({
        backdrop: 'static',
        keyboard: false
    })
    $('#question_modal').modal('show');
    $('#title_category').html(category_name);
    $('#q_cat_id').val(category_id);
    $('#c_cat_id').val(category_id);
    clear_question_field();
    load_questions(category_id);
}

function escape_quotes(word) {
    let text = word.replace("'", "");
    return text;
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#pic_preview_question').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function clear_question_field() {
    $('#q_type').val('');
    $('#question').val('');
    $('#img_question').val('');
    $('#pic_preview_question').attr('src', global_path + '/images/no-esign.png');
}

function load_questions(category_id) {
    var formData = new FormData();
    formData.append('category_id', category_id);
    $.ajax({
        url: global_path + "/hr/recruitment/load_questions",
        method: 'post',
        dataType: 'json',
        data: formData,
        success: function (response) {
            $('#question_table').empty();
            $('#question_table').append('<table class="table table-bordered table-striped table-sm" id="my_question_table">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Q Type</th>' +
                '<th>Question</th>' +
                '<th>Choices</th>' +
                '<th></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="question_body">' +
                '</tbody>' +
                '</table>'
            );
            $.each(response, function (key, value) {
                var my_image;
                if (value.img.length > 0) {
                    my_image = '<br><img alt="2.5x4 ratio" height="150" width="300" style="opacity: 1;object-fit: contain;" id="pic_preview_question" src="' + global_path + '/images/questions/' + value.img + '">';
                } else {
                    my_image = "";
                }
                if (value.question_type == 1) {
                    $('#question_body').append(
                        '<tr class="text-center">' +
                        '<td>' + question_type(value.question_type) + '</td>' +
                        '<td class="text-left">' + value.question + my_image + '</td>' +
                        '<td>' + value.choices_count + ' | <a class="btn btn-success btn-sm text-white" onclick="load_choices(' + value.q_id + ',\'' + value.question + '\',' + category_id + ')"><span class="fa fa-plus"></span> &nbsp; add</a></td>' +
                        '<td>' +
                        '<a class="btn btn-danger btn-sm text-white" onclick="question_delete(' + value.q_id + ',' + category_id + ')"><span class="fa fa-trash"></span></a>' +
                        '</td>' +
                        '</tr>'
                    );
                } else {
                    $('#question_body').append(
                        '<tr class="text-center">' +
                        '<td>' + question_type(value.question_type) + '</td>' +
                        '<td class="text-left">' + value.question + my_image + '</td>' +
                        '<td></td>' +
                        '<td>' +
                        '<a class="btn btn-danger btn-sm text-white" onclick="question_delete(' + value.q_id + ',' + category_id + ')"><span class="fa fa-trash"></span></a>' +
                        '</td>' +
                        '</tr>'
                    );
                }
            });

            $('#my_question_table').DataTable({
                "sorting": false, "targets": 'no-sort',
                "bSort": false,
                "order": []
            });
        },
        cache: false,
        contentType: false,
        processData: false

    });
}


function question_delete(question_id, category_id) {
    Swal.fire({
        title: "Delete this Question?",
        text: "You will not be able to revert this. ",
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Close',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#525252',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            var formData = new FormData();
            formData.append('question_id', question_id);
            $.ajax({
                url: global_path + "/hr/recruitment/questions/delete",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    Swal.fire(
                        response,
                        "Item deleted.",
                        'success'
                    ).then((result) => {
                        load_questions(category_id);
                        load_categories();
                    })
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    })
}

function question_type(value) {
    if (value == 1) {
        return "Multiple Choice";
    } else if (value == 2) {
        return "True or False";
    } else if (value == 3) {
        return "Essay";
    } else if (value == 4) {
        return "Identification";
    } else if (value == 5) {
        return "File Attachment";
    }
}

function validate_question() {
    if ($("#q_type").val() == "" || $("#question").val() == "") {
        return "1";
    } else {
        return "0";
    }
}

// =====CHOICES=============

function load_choices(question_id, choice_title, category_id) {
    $('#choice_modal').modal({
        backdrop: 'static',
        keyboard: false
    })
    $('#choice_modal').modal('show');
    $('#c_q_id').val(question_id);
    $('#c_cat_id').val(category_id);
    $("#choice_title").html(choice_title);
    var formData = new FormData();
    formData.append('question_id', question_id);
    $.ajax({
        url: global_path + "/hr/recruitment/load_choices",
        method: 'post',
        dataType: 'json',
        data: formData,
        success: function (response) {
            $('#choices_table').empty();
            $('#choices_table').append('<table class="table table-bordered table-striped table-sm" id="my_choices_table">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Answer</th>' +
                '<th width="15%"></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="choices_body">' +
                '</tbody>' +
                '</table>'
            );
            $.each(response, function (key, value) {
                var my_image;
                if (value.img.length > 0) {
                    my_image = '<br><img alt="2.5x4 ratio" height="150" width="300" style="opacity: 1;object-fit: contain;" id="pic_preview_choices" src="' + global_path + '/images/questions/' + value.img + '">';
                } else {
                    my_image = "";
                }
                $('#choices_body').append(
                    '<tr class="text-center">' +
                    '<td class="text-left">' + value.answer + my_image + '</td>' +
                    '<td>' +
                    '<a class="btn btn-danger btn-sm text-white btn-circle" onclick="delete_choice(' + value.id + ',' + question_id + ',\'' + value.question + '\',' + category_id + ')"><span class="fa fa-minus"></span></a>' +
                    '</td>' +
                    '</tr>'
                );
            });

            $('#my_choices_table').DataTable({
                "searching": false,
                "bPaginate": false,
                "ordering": false,
            });
        },
        cache: false,
        contentType: false,
        processData: false

    });
}

function delete_choice(choice_id, question_id, choice_title, category_id) {
    var formData = new FormData();
    formData.append('choice_id', choice_id);
    $.ajax({
        url: global_path + "/hr/recruitment/delete_choice",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            load_choices(question_id, choice_title, category_id)
            load_questions(category_id);
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function clear_choice_field() {
    $('#choice').val('');
    $('#choice_img').val('');
    $('#choice_preview').attr('src', global_path + '/images/no-esign.png');
}

function empty_profile() {
    $('#profile_form')[0].reset();
    $('#profile_id').val('0');
}

function profile_create() {
    $('#profile_modal').modal('toggle');
    $('#profile_modal').modal('show');
    empty_profile();
}


function load_profile() {
    $.ajax({
        url: global_path + "/hr/recruitment/load_profile",
        method: 'post',
        dataType: 'json',
        success: function (response) {
            $('#profile_table').empty();
            $('#profile_table').append('<table class="table table-bordered table-striped table-sm" id="my_profile_table">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Name</th>' +
                '<th>Email</th>' +
                '<th>Contact #</th>' +
                '<th></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="profile_body">' +
                '</tbody>' +
                '</table>'
            );
            $.each(response, function (key, value) {
                $('#profile_body').append(
                    '<tr class="text-center">' +
                    '<td class="text-left">' + value.firstname + ' ' + value.middlename + ' ' + value.lastname + '</td>' +
                    '<td>' + value.email + '</td>' +
                    '<td>' + value.contact_no + '</td>' +
                    '<td>' +
                    '<a class="btn btn-secondary btn-sm text-white" onclick="profile_upload(' + value.id + ')"><span class="fa fa-paperclip"></span></a> | ' +
                    '<a class="btn btn-primary btn-sm text-white" onclick="profile_edit(' + value.id + ')"><span class="fa fa-edit"></span></a> | ' +
                    '<a class="btn btn-danger btn-sm text-white" onclick="profile_delete(' + value.id + ')"><span class="fa fa-trash"></span></a>' +
                    '</td>' +
                    '</tr>'
                );
            });

            $('#my_profile_table').DataTable({
                "ordering": false,
            });
        },
        cache: false,
        contentType: false,
        processData: false

    });
}

function profile_upload(id) {
    // alert(id);
    $('#docs2_table').empty();
    $('#attachments2_modal').modal('show');
    $('#attachments2_id').val();
    var formData = new FormData();
    formData.append('id', id);
    formData.append('function', 'profile_upload');
    $.ajax({
        url: global_path + "/hr/recruitment/requirements",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function ([response, response2]) {
            // alert(response.id);
            $('#header2_title').text("Documents of " + response.firstname + " " + response.lastname);
            $('#applicant2_id').val(response.id);
            $('#docs2_application_id').val(id);
            $('#docs2_table').append(
                '<table class="table table-striped table-bordered table-sm">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th width="10%">File Type</th>' +
                '<th width="50%">File</th>' +
                '<th width="20%">Upload Date</th>' +
                '<th width="20%">Action</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '<tbody id="docs2_table_contents"></tbody>' +
                '</table>'
            );
            $.each(response2, function (key, value) {
                $('#docs2_table_contents').append(
                    '<tr>' +
                    '<td>' + value.type + '</td>' +
                    '<td><a href="' + global_path + '/images/uploads/' + value.id + '" target="_blank">' + value.file + '</a></td>' +
                    '<td>' + value.created_date + '</td>' +
                    '<td><button name="cancel" id="cancel" value="'+ value.id +'" class="btn btn-sm btn-outline-danger cancel_pro_up"><span class="far fa-trash-alt">' +
                    '</span>&nbspDelete</button></td>' +
                    '</tr>')
            });
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function profile_edit(id) {
    $('#profile_modal').modal('toggle');
    $('#profile_modal').modal('show');
    $('#profile_id').val(id);
    var formData = new FormData();
    formData.append('user_id', id);
    $.ajax({
        url: global_path + "/hr/staff/edit",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            empty_positions();
            $('#firstname').val(response.firstname);
            $('#lastname').val(response.lastname);
            $('#middlename').val(response.middlename);
            $('#email').val(response.email);
            $('#contact_no').val(response.contact_no);
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function profile_delete(id) {
    Swal.fire({
        title: "Delete this item?",
        text: "You will not be able to revert this. ",
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Close',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#525252',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            var formData = new FormData();
            formData.append('profile_id', id);
            $.ajax({
                url: global_path + "/hr/recruitment/delete_profile",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    Swal.fire(
                        response,
                        "Record deleted.",
                        'success'
                    ).then((result) => {
                        load_profile();
                    })
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    })
}


function load_applications() {
    application_dropdown();
    $.ajax({
        url: global_path + "/hr/recruitment/load_applications",
        method: 'post',
        dataType: 'json',
        success: function (response) {
            $('#applications_table').empty();
            $('#applications_table').append('<table class="table table-bordered table-striped table-sm" id="my_applications_table">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th>Applicant</th>' +
                '<th>Position Applying for</th>' +
                '<th>Status</th>' +
                '<th>Date Created</th>' +
                '<th></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="applications_body">' +
                '</tbody>' +
                '</table>'
            );
            $.each(response, function (key, value) {
                if (value.allow_test == 0) {
                    var btn = 'success';
                    var txt = 'start exam';
                } else {
                    var btn = 'danger';
                    var txt = 'stop exam';
                }
                $('#applications_body').append(
                    '<tr class="text-center" id="myTR' + value.application_id + '">' +
                    '<td class="text-left">' + value.firstname + ' ' + value.middlename + ' ' + value.lastname + '</td>' +
                    '<td>' + value.title + '</td>' +
                    '<td>' + value.application_status + '</td>' +
                    '<td>' + value.application_date + '</td>' +
                    '<td>' +
                    '<a class="btn btn-' + btn + ' btn-sm text-white btnToggle' + value.application_id + '" onclick="toggle(\'' + '#myTR' + value.application_id + '\',\'' + '.btnToggle' + value.application_id + '\',' + value.application_id + ')"><b>' + txt + '</b></a> | ' +
                    '<a class="btn btn-info btn-sm text-white" target="_blank" href="' + global_path + "/recruitment/exam_answers/" + value.application_id + '"><b>exam answer</b></a> | ' +
                    '<a class="btn btn-warning btn-sm" onclick="application_eval_upload(' + value.application_id + ')"><b>evaluation</b></a> | ' +
                    '<a class="btn btn-secondary btn-sm text-white" onclick="application_upload(' + value.application_id + ')"><span class="fa fa-paperclip"></span></a> | ' +
                    '<a class="btn btn-primary btn-sm text-white" onclick="application_edit(' + value.application_id + ')"><span class="fa fa-edit"></span></a> | ' +
                    '<a class="btn btn-danger btn-sm text-white" onclick="application_delete(' + value.application_id + ')"><span class="fa fa-trash"></span></a>' +
                    '</td>' +
                    '</tr>'
                );
            });

            $('#my_applications_table').DataTable({
                "ordering": false,
            });
        },
        cache: false,
        contentType: false,
        processData: false

    });
}

function application_dropdown() {
    $.ajax({
        url: global_path + "/hr/recruitment/application_dropdown",
        method: 'post',
        dataType: 'json',
        success: function (response) {
            $('.applicant_id').empty();
            $('.applicant_id').append('<option value="" selected disabled>-- Select Applicant -- </option>');
            $.each(response.applicants, function (key, value) {
                $('.applicant_id').append('<option value="' + value.id + '">' + value.firstname + ' ' + value.middlename + ' ' + value.lastname + '</option>');
            });

            $('#position_id').empty();
            $('#position_id').append('<option value="" selected disabled>-- Select Position -- </option>');
            $.each(response.positions, function (key, value) {
                $('#position_id').append('<option value="' + value.id + '">' + value.position_code + ' | ' + value.title + '</option>');
            });

        },
        cache: false,
        contentType: false,
        processData: false

    });
}


function empty_application() {
    application_dropdown();
    $('#app_status').val('');
    $('#remark').val('');
    $('#application_id').val('0');
}

function application_create() {
    $('#applications_modal').modal('toggle');
    $('#applications_modal').modal('show');
    empty_application();
    application_dropdown();
}

function application_upload(id) {
    // alert(id);
    $('#docs_table').empty();
    $('#attachments_modal').modal('show');
    $('#attachments_id').val();
    var formData = new FormData();
    formData.append('function', 'application_upload');
    formData.append('id', id);
    $.ajax({
        url: global_path + "/hr/recruitment/requirements",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function ([response, response2]) {
            // alert(response.id);
            $('#header_title').text("Documents of " + response.firstname + " " + response.lastname);
            $('#applicant_id').val(response.id);
            $('#docs_application_id').val(id);
            $('#docs_table').append(
                '<table class="table table-striped table-bordered table-sm">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th width="10%">File Type</th>' +
                '<th width="50%">File</th>' +
                '<th width="20%">Upload Date</th>' +
                '<th width="20%">Action</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '<tbody id="docs_table_contents"></tbody>' +
                '</table>'
            );
            $.each(response2, function (key, value) {
                $('#docs_table_contents').append(
                    '<tr>' +
                    '<td>' + value.type + '</td>' +
                    '<td><a href="' + global_path + '/images/uploads/' + value.id + '" target="_blank">' + value.file + '</a></td>' +
                    '<td>' + value.created_date + '</td>' +
                    '<td><button name="cancel" id="cancel" value="'+ value.id +'" class="btn btn-sm btn-outline-danger cancel_app_up"><span class="far fa-trash-alt">' +
                    '</span>&nbspDelete</button></td>' +
                    '</tr>')
            });
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

$(document).on('click', '.cancel_app_up', function () {
    Swal.fire({
        title: 'Warning!',
        text: "Delete attachment?",
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
            $.ajax({
                url: "/hr/recruitment/delete_uploads",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    $('#overlay').delay(100).fadeOut('fast', function () {
                        Swal.fire(
                            "Success!",
                            response + ' has been deleted!',
                            'success'
                        ).then((result) => {
                            application_upload($('#docs_application_id').val());
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

$(document).on('click', '.cancel_pro_up', function () {
    Swal.fire({
        title: 'Warning!',
        text: "Delete attachment?",
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
            $.ajax({
                url: "/hr/recruitment/delete_uploads",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    $('#overlay').delay(100).fadeOut('fast', function () {
                        Swal.fire(
                            "Success!",
                            response + ' has been deleted!',
                            'success'
                        ).then((result) => {
                            profile_upload($('#docs2_application_id').val());
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


function application_eval_upload(id) {
    $('#eval_docs_table').empty();
    $('#eval_docs_modal').modal('show');
    var formData = new FormData();
    formData.append('application_id', id);
    $.ajax({
        url: global_path + "/hr/recruitment/eval_docs",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function ([response, response2, response3]) {
            // alert(response.id);
            $('#applicant_name').html(response.firstname + " " + response.lastname);
            $('#eval_position').html(response3.title);
            $('#eval_application_id').val(id);
            $('#eval_docs_table').append(
                '<table class="table table-striped table-bordered table-sm">' +
                '<thead>' +
                '<tr class="text-center">' +
                '<th width="10%">File Type</th>' +
                '<th width="50%">File</th>' +
                '<th width="20%">Upload Date</th>' +
                '<th width="20%">Action</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '<tbody id="eval_docs_table_contents"></tbody>' +
                '</table>'
            );
            $.each(response2, function (key, value,) {
                $('#eval_docs_table_contents').append(
                    '<tr>' +
                    '<td>' + value.type + '</td>' +
                    '<td><a href="' + global_path + '/images/applicants/tor/' + value.file + '">' + value.file + '</a></td>' +
                    '<td>' + value.created_date + '</td>' +
                    '<td><button class="btn btn-sm btn-circle btn-danger"><span class="fa fa-trash">' +
                    '</span></button></td>' +
                    '</tr>')
            });

        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function application_edit(id) {
    $('#applications_modal').modal('toggle');
    $('#applications_modal').modal('show');
    $('#application_id').val(id);
    var formData = new FormData();
    formData.append('application_id', id);
    $.ajax({
        url: global_path + "/hr/recruitment/get_application",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            $('#applicant_id').val(response.user_id);
            $('#position_id').val(response.position_id);
            $('#app_status').val(response.status);
            $('#remark').val(response.remark);
        },
        cache: false,
        contentType: false,
        processData: false
    })
}

function application_delete(id) {
    Swal.fire({
        title: "Delete this item?",
        text: "You will not be able to revert this. ",
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Close',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#525252',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            var formData = new FormData();
            formData.append('application_id', id);
            $.ajax({
                url: global_path + "/hr/recruitment/delete_application",
                method: 'post',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    Swal.fire(
                        response,
                        "Record deleted.",
                        'success'
                    ).then((result) => {
                        load_applications();
                    })
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    })
}

function toggle(myTR, button, application_id) {
    var formData = new FormData;
    formData.append('application_id', application_id);
    $.ajax({
        url: global_path + '/toggle',
        type: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response == 0) {
                $(button).removeClass('btn-danger');
                $(button).addClass('btn-success');
                $(button).empty();
                $(button).html('start exam');
            } else {
                $(button).removeClass('btn-success');
                $(button).addClass('btn-danger');
                $(button).empty();
                $(button).html('stop exam');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });

}

function apply_modal(position_id, pos_code, pos_title, pos_division, pos_sg) {
    $('#apply_modal').modal('toggle');
    $('#apply_modal').modal('show');
    $('#position_id').val(position_id);
    $("#pos_code").html(pos_code);
    $("#pos_title").html(pos_title);
    $("#pos_division").html(pos_division);
    $("#pos_sg").html(pos_sg);
}

function load_eval_docs() {

}
