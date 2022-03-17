$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    on_load();

});

function on_load() {
    $.ajax({
        url: global_path + "/leaves/calendar/feed",
        method: 'post',
        dataType: 'json',
        success: function (response) {
            var Calendar = FullCalendar.Calendar;
            var calendarEl = document.getElementById('calendar');
            var calendar = new Calendar(calendarEl, {
                height: '100%',
                contentHeight: '6000',
                stickyHeaderDates: true,
                themeSystem: 'bootstrap',
                expandRows: true,
                events: response,
            });

            calendar.render();
        },
        cache: false,
        contentType: false,
        processData: false
    })
}