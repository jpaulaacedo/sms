$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


});

function _edit(id) {
    $('#recipient_modal').modal('toggle');
    $('#r_date').html();

    var formData = new FormData();
    formData.append('messengerial_id',  id);
    $.ajax({
        url: global_path + "/messe",
        method: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {

        },
        cache: false,
        contentType: false,
        processData: false
    });

}