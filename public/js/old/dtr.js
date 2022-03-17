$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#btnclock').click(function () {
        var now = moment().format("h:mm A");
        var date_time = moment().format("YYYY-MM-DD HH:mm:ss");
        if (($("#my_button").text() == "TIME IN (afternoon)") && (moment().format("Hmm") < 1200)) {
            Swal.fire(
                'warning',
                'Cannot time in until 12:00 PM',
                'warning'
            )
        }
        else {
            if ($("#my_button").text() == "TIME IN") {
                var title = "TIME IN - ";
                var text = "Confirm Time in";
                var message = "Have a great day!";
                var my_request = 1;
            } else if ($("#my_button").text() == "TIME OUT (morning)") {
                var title = "TIME OUT (morning) - ";
                var text = "Confirm Time out for lunch break";
                var message = "Enjoy your break!";
                var my_request = 2;
            } else if ($("#my_button").text() == "TIME IN (afternoon)") {
                var title = "TIME IN (afternoon) - ";
                var text = "Confirm Afternoon Time-in";
                var message = "Thank you!";
                var my_request = 3;
            } else if ($("#my_button").text() == "TIME OUT") {
                var title = "TIME OUT - ";
                var text = "Confirm Time out";
                var message = "Thank you!";
                var my_request = 4;
            }
            Swal.fire({
                title: title + now,
                text: text,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.value) {
                    var formData = new FormData();
                    formData.append('time', date_time);
                    formData.append('my_request', my_request);
                    formData.append('is_morning', $("#is_morning").val());
                    $.ajax({
                        url: global_path + '/dtr/clock/save',
                        type: 'post',
                        data: formData,
                        dataType: 'json',
                        success: function () {
                            let timerInterval
                            Swal.fire({
                                title: message,
                                html: 'processing',
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
                                }
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    location.reload();
                                }
                            })
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            })
        }

    })


    $('.getMonthlyReport').click(function (e) {
        e.preventDefault();

        let month = $('#month_search option:selected');
        let year = $('#year_search').val();

        if (!month || !year) {
            Swal.fire({
                title: 'Please Select a month and year to generate report',
                type: 'warning',
            })
        } else {
            if ($('#month_emp').val() > 0) {
                window.open('/dtr/report/individual/' + year + '/' + month.val() + '/' + $('#month_emp').val(), '_blank');
            } else {
                window.open('/dtr/report/monthly/' + month.text() + '/' +  year, '_blank');
            }
            // var win = window.open('/dtr/report/monthly/' + month, '_blank');
        }
    })

});
