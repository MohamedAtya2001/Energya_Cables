
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
let filterOfHoldReport = {
    'shift': '',
    'added_by': '',
    'jopOrderNumber': '',
    'machine': '',
    'drumNumber': '',
    'periodOfTime': { 'start': '', 'end': '' },
    'released': 'unreleased',
    'limit': 25
};

//To Get Data From Filter And Save It At FilterArray
$("#FilterValue").blur(function () {
    filterOfHoldReport[$("#FilterName").val()] = $(this).val();
    if ($(this).val() != '') {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).addClass('filtered');
    } else {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).removeClass('filtered');
    }
});

// To Make Filter On Data By Period Of Date
$("#reportrange").on('apply.daterangepicker, hide.daterangepicker', function (ev, picker) {
    cb(picker.startDate, picker.endDate);
    filterOfHoldReport["periodOfTime"]['start'] = $("#reportrange span").attr('data-rangedatestart');
    filterOfHoldReport["periodOfTime"]['end'] = $("#reportrange span").attr('data-rangedateend');
    $('#FilterName').find(`option[value="periodOfTime"]`).addClass('filtered');
});

// To Get Back All Data After Click On Cancel
$("#reportrange").on('cancel.daterangepicker', function () {
    filterOfHoldReport["periodOfTime"]['start'] = "";
    filterOfHoldReport["periodOfTime"]['end'] = "";
    $("#reportrange span").text('');
    $("#reportrange span").attr('data-rangedatestart', '');
    $("#reportrange span").attr('data-rangedateend', '');
});

// To Update Change That made In Filter in filterOfHoldReport
$("#FilterName").change(function () {
    if ($(this).val() == "periodOfTime") {
        $("#reportrange span").text(`${filterOfHoldReport["periodOfTime"]['start']} - ${filterOfHoldReport["periodOfTime"]['end']}`);
        $('#reportrange').css('display', 'block');
        $("#FilterReleased").css('display', 'none');
        $("#FilterValue").css('display', 'none');
    } else if ($(this).val() == "released") {
        $('#reportrange').css('display', 'none');
        $("#FilterValue").css('display', 'none');
        $("#FilterReleased").css('display', 'block').val(filterOfHoldReport['released']);
    } else {
        $("#FilterValue").val(filterOfHoldReport[$(this).val()]);
        $('#reportrange').css('display', 'none');
        $("#FilterReleased").css('display', 'none');
        $("#FilterValue").css('display', 'block');
    }
});

// To Update Change That made In FilterReleased in filterOfHoldReport
$('#FilterReleased').change(function () {
    filterOfHoldReport['released'] = $(this).val();
    if ($(this).val() == 'released') {
        $('#FilterName').find(`option[value="released"]`).addClass('filtered');
    }
});

//Function To add Time OF Every input insert
$('#Edit .input').blur(function () {
    let date = new Date().toLocaleString();
    $(this).attr('data-time', date);
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

// Function To Get Data Of Hold By JopOrderNumber
function GetData(Url, that = null, moreData = false) {
    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    filterOfHoldReport['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    dataForm['filter'] = filterOfHoldReport;
    dataForm['released'] = ($("#Released .request").text() == "Show Unreleased") ? true : false;
    // console.log(filterOfHoldReport);
    $.ajax({
        'url': Url,
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            // console.log(data);
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            let hold = data[0];
            let holdTime = data[1];
            let countOfStandardsRows = data[2];
            if (countOfStandardsRows > filterOfHoldReport['limit']) {
                $("#Limit").removeClass('d-none');
            } else {
                $("#Limit").addClass('d-none');
            }

            if (hold.length == 0) {
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

            for (let i = 0; i < hold.length; i++) {

                $('#Data .report .table tbody').append(`<tr data-id="${hold[i].id}">
                    <th>${(filterOfHoldReport['limit'] - 24) + i}</th>
                    <td>${hold[i].created_at.split(" ").join("<br>")}</td>
                    <td>${romanShift(hold[i].shift)}</td>
                    <td>${hold[i].added_by}</td>
                    <td>${hold[i].jopOrderNumber} <abbr title="${holdTime[i].jopOrderNumber_time}"><i class="fas fa-stopwatch ${(hold[i].jopOrderNumber == '') ? 'd-none' : ''}"></i></abbr></td>
                    <td>${hold[i].machine} <abbr title="${holdTime[i].machine_time}"><i class="fas fa-stopwatch ${(hold[i].machine == '') ? 'd-none' : ''}"></i></abbr></td>
                    <td>${hold[i].drumNumber} <abbr title="${holdTime[i].drumNumber_time}"><i class="fas fa-stopwatch ${(hold[i].drumNumber == '') ? 'd-none' : ''}"></i></abbr></td>
                    <td>${hold[i].cableSize} <abbr title="${holdTime[i].cableSize_time}"><i class="fas fa-stopwatch ${(hold[i].cableSize == '') ? 'd-none' : ''}"></i></abbr></td>
                    <td>${hold[i].length} <abbr title="${holdTime[i].length_time}"><i class="fas fa-stopwatch ${(hold[i].length == '') ? 'd-none' : ''}"></i></abbr></td>
                    <td>${hold[i].description} <abbr title="${holdTime[i].description_time}"><i class="fas fa-stopwatch ${(hold[i].description == '') ? 'd-none' : ''}"></i></abbr></td>
                    <td>${hold[i].fromSheet}</td>
                    <td>${hold[i].reasonOfHold} <abbr title="${holdTime[i].reasonOfHold_time}"><i class="fas fa-stopwatch ${(hold[i].reasonOfHold == '') ? 'd-none' : ''}"></i></abbr></td>
                    <td>${hold[i].updated_by} <abbr title="${hold[i].updated_at}"><i class="fas fa-stopwatch ${(hold[i].updated_by == '') ? 'd-none' : ''}"></i></abbr></td>
                    <td class="option">
                    ${(filterOfHoldReport['released'] == 'unreleased') ? `<button class="btn btn-success mr-3" onclick="releasedRow(${hold[i].id}, this)">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Released</span>
                    </button>` : ''}
                    <button class="btn btn-primary mr-3" onclick="editRow(${hold[i].id}, this)">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Edit</span>
                    </button>
                    <button class="btn btn-danger" onclick="deleteRow(${hold[i].id}, this)">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Delete</span>
                    </button>
                    </td>
                    </tr>`);

            }

            if (hold.length != 0) {
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
    GetData('Hold', this, true);
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
        url: 'Hold/deleteRow',
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
        url: `Hold/getRow`,
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            let hold = data[0];
            let holdTime = data[1];
            let inputs = $('#Edit form').find('.input');

            // To Preper Data Of HoldReport

            let hold_id = hold['id'];

            delete hold['id'];
            delete hold['added_by'];
            delete hold['shift'];
            delete hold['created_at'];
            delete hold['updated_at'];
            delete hold['updated_by'];
            delete hold['fromSheet'];

            delete holdTime['id'];
            delete holdTime['hold_id'];
            delete holdTime['added_by'];
            delete holdTime['shift'];
            delete holdTime['created_at'];
            delete holdTime['updated_at'];
            delete holdTime['updated_by'];
            delete holdTime['fromSheet'];

            for (let key in hold) {
                let currentInput = $(inputs).filter(`[name="${key}"]`);
                currentInput.val(hold[key]);
                currentInput.attr('data-time', holdTime[key + '_time']);
            }

            $('body').css('overflow', 'hidden');
            $("#Edit form").attr('data-id', hold_id);
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
                <td>${reportRow.jopOrderNumber} <abbr title="${reportRowTime.jopOrderNumber_time}"><i class="fas fa-stopwatch ${(reportRow.jopOrderNumber == '') ? 'd-none' : ''}"></i></abbr></td>
                <td>${reportRow.machine} <abbr title="${reportRowTime.machine_time}"><i class="fas fa-stopwatch ${(reportRow.machine == '') ? 'd-none' : ''}"></i></abbr></td>
                <td>${reportRow.drumNumber} <abbr title="${reportRowTime.drumNumber_time}"><i class="fas fa-stopwatch ${(reportRow.drumNumber == '') ? 'd-none' : ''}"></i></abbr></td>
                <td>${reportRow.cableSize} <abbr title="${reportRowTime.cableSize_time}"><i class="fas fa-stopwatch ${(reportRow.cableSize == '') ? 'd-none' : ''}"></i></abbr></td>
                <td>${reportRow.length} <abbr title="${reportRowTime.length_time}"><i class="fas fa-stopwatch ${(reportRow.length == '') ? 'd-none' : ''}"></i></abbr></td>
                <td>${reportRow.description} <abbr title="${reportRowTime.description_time}"><i class="fas fa-stopwatch ${(reportRow.description == '') ? 'd-none' : ''}"></i></abbr></td>
                <td>${reportRow.fromSheet}</td>
                <td>${reportRow.reasonOfHold} <abbr title="${reportRowTime.reasonOfHold_time}"><i class="fas fa-stopwatch ${(reportRow.reasonOfHold == '') ? 'd-none' : ''}"></i></abbr></td>
                <td>${reportRow.updated_by} <abbr title="${reportRow.updated_at}"><i class="fas fa-stopwatch ${(reportRow.updated_by == '') ? 'd-none' : ''}"></i></abbr></td>
                <td class="option">
                ${(filterOfHoldReport['released'] == 'unreleased') ? `<button class="btn btn-success mr-3" onclick="releasedRow(${reportRow.id}, this)">
                <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span>Released</span>
                </button>` : ''}
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

function releasedRow(rowId, that) {
    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    dataForm = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'rowId': rowId
    };

    // console.log(dataForm);

    $.ajax({
        url: `Hold/releaseHold`,
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data);
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
    dataForm['reasonOfHold'] = [$(this).find('textarea').eq(0).val(), $(this).find('textarea').eq(0).attr('data-time')];
    dataForm['id'] = $(this).attr('data-id');
    console.log(dataForm);
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

// To Make Filter On Data
$('#Filter').click(function () {
    $("#Limit").attr('data-count-rows', 25);
    GetData('Hold', this);
});

// To Prepare Data And Print It
$("#StartPrint").click(function () {
    let that = this;
    $(this).prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    dataForm['filter'] = filterOfHoldReport;
    dataForm['released'] = ($("#Released .request").text() == "Show Unreleased") ? true : false;

    $.ajax({
        'url': 'Hold/printData',
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data);

            let dataOfHold = data[0];
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

            let tableHeadOfHold = `<thead>
                                   <tr>
                                   <th>SN</th>
                                   <th>Date / Time</th>
                                   <th>Shift</th>
                                   <th>Jop Order Number</th>
                                   <th>Machine</th>
                                   <th>Drum Number</th>
                                   <th>Cable Size</th>
                                   <th>Length</th>
                                   <th>Description</th>
                                   <th>Process</th>
                                   <th class="notes">Reason Of Hold</th>
                                   <th>Add By</th>
                                   </tr>
                                   </thead>`;

            let hold = ``;
            let printContent = '';

            function createHoldRow(i) {
                return `<tr data-id="${dataOfHold[i].id}">
                <th>${i + 1}</th>
                <td>${dataOfHold[i].created_at.split(" ").join("<br>")}</td>
                <td>${romanShift(dataOfHold[i].shift)}</td>
                <td>${dataOfHold[i].jopOrderNumber}</td>
                <td>${dataOfHold[i].machine}</td>
                <td>${dataOfHold[i].drumNumber}</td>
                <td>${dataOfHold[i].cableSize}</td>
                <td>${dataOfHold[i].length}</td>
                <td>${dataOfHold[i].description}</td>
                <td>${dataOfHold[i].fromSheet}</td>
                <td>${dataOfHold[i].reasonOfHold}</td>
                <td>${dataOfHold[i].added_by}</td>
                </tr>`;
            }


            // Prepare Pages To Print it
            for (let i = 0, j = 1; i < dataOfHold.length; i++, j++) {
                let holdRow = createHoldRow(i);
                if (j % 10 != 0 && j != dataOfHold.length) {
                    hold += holdRow;
                } else if (j % 10 == 0) {
                    hold += holdRow;

                    let holdTable = `<div class="report mt-5 Taps">
                                                <table class="table table-hover">
                                                ${tableHeadOfHold}
                                                <tbody>
                                                ${hold}
                                                </tbody>
                                                </table>
                                                </div>`;

                    let page = '<div class="page">' + pageNav + holdTable + '</div>';
                    printContent += page;
                    hold = ``;
                } else {
                    hold += holdRow;

                    let holdTable = `<div class="report mt-5 Taps">
                                                <table class="table table-hover">
                                                ${tableHeadOfHold}
                                                <tbody>
                                                ${hold}
                                                </tbody>
                                                </table>
                                                </div>`;

                    let page = '<div class="page">' + pageNav + holdTable + '</div>';
                    printContent += page;
                    hold = ``;
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






