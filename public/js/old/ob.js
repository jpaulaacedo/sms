$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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
    var table = $('#ob_table').DataTable({
        processing: true,
        serverSide: false,
        searching: true,
        "ordering": false,
        "pageLength": 5,
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        autoWidth: false,
    });

    // Refilter the table
    $('#min, #max').on('change', function () {
        table.draw();
    });

    $('#searchCourse').keyup(function () {
        oTable.search($(this).val()).draw();
    });

    $(document).on('click', '.add', function () {
        $('#date_filed').val(moment().format('YYYY-MM-DD'));
        $('#ob_date').val("");
        $('#departure_time').val("");
        $('#return_time').val("");
        $('#from').val("PSRTI");
        $('#destination').val("");
        $('#purpose').val("");
        $('#ob_id').val("");
        $('#modal_title').text('Create OB');
        $('#button_name').text('Submit');
        $('#OfficialBusinessModal').modal('show');
    });

    $(document).on('click', '.edit', function () {    //EDIT BUTTON CLICKED
        var id = $(this).val();
        $('#modal_title').text('Edit OB');
        $('#button_name').text('Update');
        var formData = new FormData();
        formData.append('ob_id', id);
        $.ajax({
            url: '/employee/ob/edit',
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function (response) {
                // $('#requestModal').get(0).reset();
                $('#OfficialBusinessModal').modal('show');
                $('#date_filed').val(response.date_filed);
                $('#ob_date').val(response.ob_date);
                $('#departure_time').val(response.departure_time);
                $('#return_time').val(response.return_time);
                $('#from').val(response.from);
                $('#destination').val(response.destination);
                $("#" + response.departure_option + "").prop("checked", true);
                $("#" + response.return_option + "").prop("checked", true);
                $('#ob_id').val(response.id);
                $('#purpose').val(response.purpose);
            },
            cache: false,
            contentType: false,
            processData: false
        })
    });

    $(document).on('click', '.amend', function () {   //AMEND BUTTON CLICKED
        Swal.fire({
            title: 'Reason for Amendment',
            html: `<textarea class="form-control" id="reason" rows="5" required></textarea>`,
            text: "Disapprove Overtime request?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Proceed',
            preConfirm: () => {
                const reason = Swal.getPopup().querySelector('#reason').value
                if (!reason) {
                  Swal.showValidationMessage(`Please provide your reason`)
                }
              }
        }).then((result) => {
            if (result.value) {
                var reason = $('#reason').val();
                var id = $(this).val();
                $('#modal_title').text('Amend OB');
                $('#button_name').text('Amend');
                $('#OfficialBusinessModal').modal('show');
                var formData = new FormData();
                formData.append('ob_id', id);
                $.ajax({
                    url: '/employee/ob/edit',
                    type: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        // $('#requestModal').get(0).reset();
                        $('#reason_amend').val(reason);
                        $('#date_filed').val(response.date_filed);
                        $('#ob_date').val(response.ob_date);
                        $('#departure_time').val(response.departure_time);
                        $('#return_time').val(response.return_time);
                        $('#from').val(response.from);
                        $('#destination').val(response.destination);
                        $("#" + response.departure_option + "").prop("checked", true);
                        $("#" + response.return_option + "").prop("checked", true);
                        $('#ob_id').val(response.id);
                        $('#purpose').val(response.purpose);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                })
            }
        });
    });

    $('#formRequest').submit(function (e) {
        e.preventDefault();
        if ($('#button_name').text() == 'Submit') {
            Swal.fire({
                title: 'Create?',
                text: "Create OB request?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {
                    $('#overlay').fadeIn();
                    var formData = new FormData();
                    formData.append('date_filed', $('#date_filed').val());
                    formData.append('ob_date', $('#ob_date').val());
                    formData.append('departure_time', $('#departure_time').val());
                    formData.append('return_time', $('#return_time').val());
                    formData.append('from', $('#from').val());
                    formData.append('destination', $('#destination').val());
                    formData.append('departure_option', $('input[name="departure_radio"]:checked').val());
                    formData.append('return_option', $('input[name="return_radio"]:checked').val());
                    formData.append('purpose', $('#purpose').val());
                    formData.append('ob_id', $('#ob_id').val());
                    formData.append('emp_id', $('#user_id').val());
                    $.ajax({
                        url: "/employee/ob/create",
                        method: 'post',
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                            $('#overlay').delay(100).fadeOut('fast', function () {
                                Swal.fire(
                                    response,
                                    'OB has been created!',
                                    'success'
                                ).then((response) => {
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
        else if ($('#button_name').text() == 'Update') {
            Swal.fire({
                title: 'Update?',
                text: "Update OB request?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {
                    $('#overlay').fadeIn();
                    var formData = new FormData();
                    formData.append('date_filed', $('#date_filed').val());
                    formData.append('ob_date', $('#ob_date').val());
                    formData.append('departure_time', $('#departure_time').val());
                    formData.append('return_time', $('#return_time').val());
                    formData.append('from', $('#from').val());
                    formData.append('destination', $('#destination').val());
                    formData.append('departure_option', $('input[name="departure_radio"]:checked').val());
                    formData.append('return_option', $('input[name="return_radio"]:checked').val());
                    formData.append('purpose', $('#purpose').val());
                    formData.append('ob_id', $('#ob_id').val());
                    formData.append('emp_id', $('#user_id').val());
                    formData.append('ob_action', 'update');
                    $.ajax({
                        url: "/employee/ob/create",
                        method: 'post',
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                            $('#overlay').delay(100).fadeOut('fast', function () {
                                Swal.fire(
                                    response,
                                    'OB has been updated!',
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
        else if ($('#button_name').text() == 'Amend') {
            Swal.fire({
                title: 'Amend?',
                text: "Amend OB request?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {
                    $('#overlay').fadeIn();
                    var formData = new FormData();
                    formData.append('date_filed', $('#date_filed').val());
                    formData.append('ob_date', $('#ob_date').val());
                    formData.append('departure_time', $('#departure_time').val());
                    formData.append('return_time', $('#return_time').val());
                    formData.append('from', $('#from').val());
                    formData.append('destination', $('#destination').val());
                    formData.append('departure_option', $('input[name="departure_radio"]:checked').val());
                    formData.append('return_option', $('input[name="return_radio"]:checked').val());
                    formData.append('purpose', $('#purpose').val());
                    formData.append('ob_id', $('#ob_id').val());
                    formData.append('emp_id', $('#user_id').val());
                    formData.append('reason', $('#reason_amend').val());
                    formData.append('ob_action', 'amend');
                    $.ajax({
                        url: "/employee/ob/create",
                        method: 'post',
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                            $('#overlay').delay(100).fadeOut('fast', function () {
                                Swal.fire(
                                    response,
                                    'OB has been Amended!',
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
    });
    //test comment

    $(document).on('click', '.view', function () {     //VIEW BUTTON CLICKED (PENDING)
        var id = $(this).val();
        var formData = new FormData();
        formData.append('ob_id', id);
        $.ajax({
            url: '/employee/ob/edit',
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function (response) {
                // $('#requestModal').get(0).reset();
                $('#modal_title').text('View OB');
                $('.modal-buttons').empty();
                $('#OfficialBusinessModal').modal('show');    
                $('#date_filed').val(response.date_filed);
                $('#ob_date').val(response.ob_date).prop('readonly', true);
                $('#departure_time').val(response.departure_time).prop('readonly', true);
                $('#return_time').val(response.return_time).prop('readonly', true);
                $('#from').val(response.from).prop('readonly', true).prop('readonly', true);
                $('#destination').val(response.destination).prop('readonly', true).prop('readonly', true);
                $('#status').val(response.status);
                if ((response.status) == 'For DC Approval' || (response.return_option) == 'Amended'){
                    $('.modal-buttons').append(
                        '<button type="submit" class="btn btn-primary approve"><span class="fas fa-check"></span>&nbspApprove</button>' +
                        ' <button class="btn btn-danger disapprove"><span class="fas fa-times"></span>&nbspDisapprove</button>'
                    );
                }
                if ((response.status) == 'For ED Approval' && $('#user_type').val() == 4){
                    $('.modal-buttons').append(
                        '<button type="submit" class="btn btn-primary approve"><span class="fas fa-check"></span>&nbspApprove</button>' +
                        ' <button class="btn btn-danger disapprove"><span class="fas fa-times"></span>&nbspDisapprove</button>'
                    );
                }
                $('#view_type').val('pending');
                $("#" + response.departure_option + "").prop("checked", true);
                $("#" + response.return_option + "").prop("checked", true);
                $('#ob_id').val(response.id);
                $('#purpose').val(response.purpose).prop('readonly', true);
            },
            cache: false,
            contentType: false,
            processData: false
        })
    });

    $(document).on('click', '.cancel', function () {
        Swal.fire({
            title: 'Warning!',
            text: "Cancel OB request?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $('#overlay').fadeIn();
                var formData = new FormData();
                formData.append('ob_id', $(this).val());
                formData.append('user_id', $('#user_id').val());
                $.ajax({
                    url: "/employee/ob/cancel",
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        $('#overlay').delay(100).fadeOut('fast', function () {
                            Swal.fire(
                                response,
                                'OB has been cancelled!',
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

    $(document).on('click', '.view_amend', function () {    //VIEW BUTTON CLICKED (AMENDED)
        var id = $(this).val();
        var formData = new FormData();
        formData.append('ob_id', id);
        $.ajax({
            url: '/employee/ob/edit',
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function (response) {
                $('#OfficialBusinessModal').modal('show');
                $('.modal-buttons').empty();
                $('#date_filed').val(response.date_filed);
                $('#ob_date').val(response.ob_date);
                $('#departure_time').val(response.departure_time);
                $('#return_time').val(response.return_time);
                $('#from').val(response.from);
                $('#destination').val(response.destination);
                $('#view_type').val('amended');
                $('.modal-buttons').append(
                    '<button type="submit" class="btn btn-primary approve"><span class="fas fa-check"></span>&nbspApprove</button>' +
                    ' <button class="btn btn-danger disapprove"><span class="fas fa-times"></span>&nbspDisapprove</button>'
                );
                $("#" + response.departure_option + "").prop("checked", true);
                $("#" + response.return_option + "").prop("checked", true);
                $('#modal_title').text('Approve Amended OB');
                $('#ob_id').val(response.id);
                $('#purpose').val(response.purpose);
            },
            cache: false,
            contentType: false,
            processData: false
        })
    });

    $(document).on('click', '.approve', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Approve?',
            text: "Approve OB request?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $('#overlay').fadeIn();
                var formData = new FormData();
                formData.append('id', $('#ob_id').val());
                formData.append('emp_id', $('#user_id').val());
                formData.append('view_type', $('#view_type').val());
                formData.append('status', 'app');
                formData.append('reason_disapproval', "");
                $.ajax({
                    url: "/employee/ob/approvedisapprove",
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        $('#overlay').delay(100).fadeOut('fast', function () {
                            Swal.fire(
                                response,
                                'OB has been approved!',
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
                formData.append('id', $('#ob_id').val());
                formData.append('emp_id', $('#user_id').val());
                formData.append('view_type', $('#view_type').val());
                formData.append('status', 'disapp');
                $.ajax({
                    url: "/employee/ob/approvedisapprove",
                    method: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        $('#overlay').delay(100).fadeOut('fast', function () {
                            Swal.fire(
                                response,
                                'OB has been disapproved!',
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

    $(document).on('click', '#btnPrint', function () {
        var formData = new FormData();
        formData.append('ob_id', $(this).val());
        $.ajax({
            url: "/employee/ob/print",
            method: 'post',
            data: formData,
            dataType: 'json',
            success: function () {
                location.reload();
            },
            cache: false,
            contentType: false,
            processData: false
        })
    });

    $(document).on('click', '#report_first', function () {
        $('#from').val('PSRTI');
    });
    
    $(document).on('click', '#go_directly', function () {
        $('#from').val('RESIDENCE');
    });

    $(document).on('click', '#with_vehicle', function () {
        $('#from').val('PSRTI');
    });

});
