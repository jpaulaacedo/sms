$(document).ready(function () {
    var cat_id = $('#q_cat_id').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $("#exam_form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        Swal.fire('Submitting Exam...')
        Swal.showLoading();
        $.ajax({
            url: global_path + '/careers/submit_exam',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function () {
                Swal.close();
                location.href = global_path + "/careers/my_applications";
            }
        });
    });

});



function start_modal(category_id, time_limit, title) {
    $('#start_exam_modal').modal('show');
    $('#category_id').val(category_id);
    $('#exam_time').html(time_limit);
    $('#exam_title').html(title);
}

function start_exam(user_id, category_id, time_limit) {
    var formData = new FormData();
    formData.append('user_id', user_id);
    formData.append('category_id', category_id);
    formData.append('time_limit', time_limit);
    Swal.fire('Loading...')
    Swal.showLoading();
    $.ajax({
        url: global_path + '/careers/start_timer',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        success: function () {
            Swal.close();
            location.href = global_path + "/careers/exam/" + category_id;
        }
    });
}