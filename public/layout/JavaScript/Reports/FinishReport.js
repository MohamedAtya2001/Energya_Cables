
//Function To Get Range Date
$(function () {
    let start = moment().subtract(29, 'days');
    let end = moment();

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        locale: {
            cancelLabel: 'Clear'
        }
    }, cb);

    cb(start, end);

});

//Function For Apply DateRangePicker
function cb(start, end) {
    $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));

    let start_prepare = start.format('YYYY-MM-DD');
    let end_prepare = end.format('YYYY-MM-DD');
    start_result = ``;
    end_result = ``;
    /* 
        To Minus Day From Sart And Plus Day To End
        10 is Length Of Start And End 
        I Need To Make Process on MM
    */
    for (let i = 0; i < 10; i++) {
        if (i == 7) {
            let dayOfStart = parseInt((start_prepare[i + 1] + start_prepare[i + 2]));
            let dayOfEnd = parseInt((end_prepare[i + 1] + end_prepare[i + 2])) + 1;
            start_result += (dayOfStart < 10) ? `-0${dayOfStart}` : `-${dayOfStart}`;
            end_result += (dayOfEnd < 10) ? `-0${dayOfEnd}` : `-${dayOfEnd}`;
            break;
        } else {
            start_result += start_prepare[i];
            end_result += end_prepare[i];
        }
    }

    $('#reportrange span').attr("data-rangeDateStart", start_result);
    $('#reportrange span').attr("data-rangeDateEnd", end_result);
}

// Create FilterArray
let filterOfFinishReport = {
    'shift': '',
    'added_by': '',
    'jopOrderNumber': '',
    'drumNumber': '',
    'length': '',
    'periodOfTime': { 'start': '', 'end': '' },
    'notes': false,
    'limit': 25
};

//To Get Data From Filter And Save It At FilterArray
$("#FilterValue").blur(function () {
    filterOfFinishReport[$("#FilterName").val()] = $(this).val();
    if ($(this).val() != '') {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).addClass('filtered');
    } else {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).removeClass('filtered');
    }
});

// To Make Filter On Data By Period Of Date
$("#reportrange").on('apply.daterangepicker, hide.daterangepicker', function (ev, picker) {
    cb(picker.startDate, picker.endDate);
    filterOfFinishReport["periodOfTime"]['start'] = $("#reportrange span").attr('data-rangedatestart');
    filterOfFinishReport["periodOfTime"]['end'] = $("#reportrange span").attr('data-rangedateend');
    $('#FilterName').find(`option[value="periodOfTime"]`).addClass('filtered');
});

// To Get Back All Data After Click On Cancel
$("#reportrange").on('cancel.daterangepicker', function () {
    filterOfFinishReport["periodOfTime"]['start'] = "";
    filterOfFinishReport["periodOfTime"]['end'] = "";
    $("#reportrange span").text('');
    $("#reportrange span").attr('data-rangedatestart', '');
    $("#reportrange span").attr('data-rangedateend', '');
});

$("#FilterName").change(function () {
    if ($(this).val() == "periodOfTime") {
        $(this).attr('data-last-selected', $(this).val());
        $("#reportrange span").text(`${filterOfFinishReport["periodOfTime"]['start']} - ${filterOfFinishReport["periodOfTime"]['end']}`);
        $('#reportrange').css('display', 'block');
        $("#FilterValue").css('display', 'none');
    } else if ($(this).val() == "notes") {
        $(this).val($(this).attr('data-last-selected'));
        if ($('#FilterName').find(`option[value="notes"]`).hasClass('filtered')) {
            filterOfFinishReport['notes'] = false;
            $('#FilterName').find(`option[value="notes"]`).removeClass('filtered');
        } else {
            filterOfFinishReport['notes'] = true;
            $('#FilterName').find(`option[value="notes"]`).addClass('filtered');
        }
    } else {
        $(this).attr('data-last-selected', $(this).val());
        $("#FilterValue").val(filterOfFinishReport[$(this).val()]);
        $('#reportrange').css('display', 'none');
        $("#FilterValue").css('display', 'block');
    }
});

//Function To add Time OF Every input insert
$('#Edit .input').blur(function () {
    let date = new Date().toLocaleString();
    $(this).attr('data-time', date);
});

// To Print III Instead Of Shift 3
function romanShift(shifts) {
    let romanShift = {
        'shift 1': '&#8544;',
        'shift 2': '&#8545;',
        'shift 3': '&#8546;'
    };

    let arrayOfShifts = shifts.split(' / ');
    let result = '';

    for (let i = 0; i < arrayOfShifts.length; i++) {
        if (i == 0) {
            result += romanShift[arrayOfShifts[i]];
        } else {
            result += ' / ' + romanShift[arrayOfShifts[i]];
        }
    }

    return result;

}

// Function To Get Data Of Finish By JopOrderNumber
function GetData(Url, that = null, moreData = false) {
    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    filterOfFinishReport['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    dataForm['filter'] = filterOfFinishReport;
    $.ajax({
        'url': Url,
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data);
            // return 0;
            let finish = data[0];
            let finishTime = data[1];
            let countOfStandardsRows = data[2];
            if (countOfStandardsRows > filterOfFinishReport['limit']) {
                $("#Limit").removeClass('d-none');
            } else {
                $("#Limit").addClass('d-none');
            }

            if (finish.length == 0) {
                $('p.alert').removeClass('d-none');
                $('#Data .report .table tbody').html('');
                return 0;
            } else {
                $('p.alert').addClass('d-none');
            }

            /* ================================ */

            if (!moreData) {
                $('#Data .report .table tbody').html('');
            }

            for (let i = 0; i < finish.length; i++) {

                $('#Data .report .table tbody').append(`<tr data-id="${finish[i].id}">
                    <th>${(filterOfFinishReport['limit'] - 24) + i}</th>
                    <td>${finish[i].created_at.split(" ").join("<br>")}</td>
                    <td>${romanShift(finish[i].shift)}</td>
                    <td>${finish[i].added_by}</td>
                    <td>${finish[i].jopOrderNumber} <abbr title="${finishTime[i].jopOrderNumber_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${finish[i].drumNumber} <abbr title="${finishTime[i].drumNumber_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${finish[i].length} <abbr title="${finishTime[i].length_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${(finish[i].notes == null) ? '' : finish[i].notes} <abbr title="${finishTime[i].notes_time}"><i class="fas fa-stopwatch ${(finish[i].notes == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${finish[i].updated_by} <abbr title="${finish[i].updated_at}"><i class="fas fa-stopwatch ${(finish[i].updated_by == '') ? 'd-none' : ''}"></i></abbr></td>
                    <td class="option">
                    <button class="btn btn-primary mr-3" onclick="editRow(${finish[i].id}, this)">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Edit</span>
                    </button>
                    <button class="btn btn-danger" onclick="deleteRow(${finish[i].id}, this)">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Delete</span>
                    </button>
                    </td>
                    </tr>`);

            }

            if (finish.length != 0) {
                $('#StartPrint').prop('disabled', false);
            } else {
                $('#StartPrint').prop('disabled', true);
            }


        },
        'error': function (data) {
            $(that).prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        },
    });
}

// To Get More Data Reports
$("#Limit").click(function () {
    $(this).attr('data-count-rows', parseInt($(this).attr('data-count-rows')) + 25);
    GetData('Finish', this, true);
});

// Function To Delete Row By Id 
function deleteRow(rowId, that) {
    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    dataForm = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'rowId': rowId
    };

    $.ajax({
        url: 'Finish/deleteRow',
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            $(`.sheets .report tbody tr[data-id="${rowId}"]`).remove();

        },
        error: function (data) {
            $(that).prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data);
        }
    });

}

// Function To Get Row To Make Edit On It 
function editRow(rowId, that) {
    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    dataForm = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'rowId': rowId
    };

    $.ajax({
        url: `Finish/getRow`,
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            let finish = data[0];
            let finishTime = data[1];
            let inputs = $('#Edit form').find('.input');

            // To Preper Data Of FinishReport

            let finish_id = finish['id'];

            delete finish['id'];
            delete finish['added_by'];
            delete finish['shift'];
            delete finish['created_at'];
            delete finish['updated_at'];

            delete finishTime['id'];
            delete finishTime['finish_id'];
            delete finishTime['added_by'];
            delete finishTime['shift'];
            delete finishTime['created_at'];
            delete finishTime['updated_at'];

            for (let key in finish) {
                let currentInput = $(inputs).filter(`[name="${key}"]`);
                currentInput.val(finish[key]);
                currentInput.attr('data-time', finishTime[key + '_time']);
            }

            $('body').css('overflow', 'hidden');
            $("#Edit form").attr('data-id', finish_id);
            $('#Edit').fadeIn(500);
            $('#Edit .box').animate({ top: 0 }, 1000);
        },
        error: function (data) {
            $(that).prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data);
        }
    });

}

//Function To Update Data Report Of That Row Who Edited
function updateReport(data) {
    let reportRow = data[0];
    let reportRowTime = data[1];
    let i = $(`#Data .report .table tbody tr[data-id="${reportRow.id}"]`).index() + 1;

    $(`#Data .report .table tbody tr[data-id="${reportRow.id}"]`).html(`
                <th>${i}</th>
                <td>${reportRow.created_at.split(" ").join("<br>")}</td>
                <td>${romanShift(reportRow.shift)}</td>
                <td>${reportRow.added_by}</td>
                <td>${reportRow.jopOrderNumber} <abbr title="${reportRowTime.jopOrderNumber_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${reportRow.drumNumber} <abbr title="${reportRowTime.drumNumber_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${reportRow.length} <abbr title="${reportRowTime.length_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${reportRow.notes} <abbr title="${reportRowTime.notes_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${reportRow.updated_by} <abbr title="${reportRow.updated_at}"><i class="fas fa-stopwatch ${(reportRow.updated_by == '') ? 'd-none' : ''}"></i></abbr></td>
                <td class="option">
                <button class="btn btn-primary mr-3" onclick="editRow(${reportRow.id}, this)">
                <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span>Edit</span>
                </button>
                <button class="btn btn-danger" onclick="deleteRow(${reportRow.id}, this)">
                <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span>Delete</span>
                </button>
                </td>
                `);
}

$("#Filter").click(function () {
    $("#Limit").attr('data-count-rows', 25);
    GetData('Finish', this);
});

// To FadeOut Edit Form After make Click on Close Button
$("#Edit i").click(function () {
    $('body').css('overflow', 'auto');
    $("#Edit").fadeOut(500);
    $('#Edit .box').css('top', '-600px');
});

// To Edit Row
$('#Edit form').submit(function (e) {
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    e.preventDefault();
    let that = this;
    let dataForm = {};
    let token = $(this).find('input').eq(0).attr('value');
    dataForm['_token'] = token;
    for (let i = 0; i < $(this).find('.input').length; i++) {
        let key = $(this).find('.input').eq(i).attr('name');
        // Becuse if didn't  send some of data that mean he didn't make blur for input so he didn't Know the time 
        let value = [$(this).find('.input').eq(i).val(), $(this).find('.input').eq(i).attr('data-time')];
        dataForm[key] = value;
    }
    dataForm['notes'] = [$(this).find('textarea').eq(0).val(), $(this).find('textarea').eq(0).attr('data-time')];
    dataForm['id'] = $(this).attr('data-id');
    // console.log(dataForm);
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            if (Array.isArray(data)) {
                // Update Report That Edited
                updateReport(data);

                $('body').css('overflow', 'auto');
                $("#Edit").fadeOut(500);
                $('#Edit .box').css('top', '-600px');
            }



        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
        },
    });

});

// To Prepare Data And Print It
$("#StartPrint").click(function () {
    let that = this;
    $(this).prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    dataForm['filter'] = filterOfFinishReport;

    $.ajax({
        'url': 'Finish/printData',
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data);

            let dataOfFinish = data[0];
            let pageNav = `<div class="nav-print clearfix mt-4">
                                     <div class="container">
                                     <div class="float-left part1">
                                     <img src="${$('#Data').attr('data-logoSrc')}" alt="" class="img-fluid" />
                                     </div>
                                     <div class="float-right text-center part2">
                                     <p class="m-0">energya cables –elsewedy Helal</p>
                                     <h5 class="m-0">Quality Department</h5>
                                     </div>
                                     </div>
                                     </div>`;

            let tableHeadOfFinish = `<thead>
                                     <tr>
                                     <th>SN</th>
                                     <th>Date / Time</th>
                                     <th>Shift</th>
                                     <th>Jop Order Number</th>
                                     <th>Drum Number</th>
                                     <th>Length</th>
                                     <th class="notes">Notes</th>
                                     <th>Add By</th>
                                     </tr>
                                     </thead>`;

            let finish = ``;
            let printContent = '';

            function createFinishRow(i) {
                return `<tr data-id="${dataOfFinish[i].id}">
                <th>${i + 1}</th>
                <td>${dataOfFinish[i].created_at.split(" ").join("<br>")}</td>
                <td>${romanShift(dataOfFinish[i].shift)}</td>
                <td>${dataOfFinish[i].jopOrderNumber}</td>
                <td>${dataOfFinish[i].drumNumber}</td>
                <td>${dataOfFinish[i].length}</td>
                <td>${(dataOfFinish[i].notes == null) ? '' : dataOfFinish[i].notes}</td>
                <td>${dataOfFinish[i].added_by}</td>
                </tr>`;
            }


            // Prepare Pages To Print it
            for (let i = 0, j = 1; i < dataOfFinish.length; i++, j++) {
                let finishRow = createFinishRow(i);
                if (j % 15 != 0 && j != dataOfFinish.length) {
                    finish += finishRow;
                } else if (j % 15 == 0) {
                    finish += finishRow;

                    let finishTable = `<div class="report mt-5 Taps">
                                                <table class="table table-hover">
                                                ${tableHeadOfFinish}
                                                <tbody>
                                                ${finish}
                                                </tbody>
                                                </table>
                                                </div>`;

                    let page = '<div class="page">' + pageNav + finishTable + '</div>';
                    printContent += page;
                    finish = ``;
                } else {
                    finish += finishRow;

                    let finishTable = `<div class="report mt-5 Taps">
                                                <table class="table table-hover">
                                                ${tableHeadOfFinish}
                                                <tbody>
                                                ${finish}
                                                </tbody>
                                                </table>
                                                </div>`;

                    let page = '<div class="page">' + pageNav + finishTable + '</div>';
                    printContent += page;
                    finish = ``;
                }

            }

            $('.printContent').html(printContent);
            $('.printContent').printThis();

        },
        'error': function (data) {
            $(that).prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        },
    });
});










