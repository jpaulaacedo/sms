$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

function _edit(user_id,name,type,division,vl,sl,spl,fl,pl) {
    $('#curr_vl').val(vl);
    $('#curr_sl').val(sl);
    $('#curr_spl').val(spl);
    $('#curr_fl').val(fl);
    $('#curr_pl').val(pl);
    $('#my_vl').val(vl);
    $('#my_sl').val(sl);
    $('#my_spl').val(spl);
    $('#my_fl').val(fl);
    $('#my_pl').val(pl);
    $('#_name').val(name);
    $('#_type').val(type);
    $('#_division').html(division);
    $('#user_id').val(user_id);
    $('#current_leave_modal').modal('show');
}