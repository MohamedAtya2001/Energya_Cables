
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
let filterOfRewindReport = {
    'shift': '',
    'added_by': '',
    'inputDrum': '',
    'inputCard': '',
    'inputLength': '',
    'outputDrum': '',
    'outputCard': '',
    'outputLength': '',
    'periodOfTime': { 'start': '', 'end': '' },
    'limit': 25
};

//To Get Data From Filter And Save It At FilterArray
$("#FilterValue").blur(function () {
    filterOfRewindReport[$("#FilterName").val()] = $(this).val();
    if ($(this).val() != '') {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).addClass('filtered');
    } else {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).removeClass('filtered');
    }
});

// To Make Filter On Data By Period Of Date
$("#reportrange").on('apply.daterangepicker, hide.daterangepicker', function (ev, picker) {
    cb(picker.startDate, picker.endDate);
    filterOfRewindReport["periodOfTime"]['start'] = $("#reportrange span").attr('data-rangedatestart');
    filterOfRewindReport["periodOfTime"]['end'] = $("#reportrange span").attr('data-rangedateend');
    $('#FilterName').find(`option[value="periodOfTime"]`).addClass('filtered');
});

// To Get Back All Data After Click On Cancel
$("#reportrange").on('cancel.daterangepicker', function () {
    filterOfRewindReport["periodOfTime"]['start'] = "";
    filterOfRewindReport["periodOfTime"]['end'] = "";
    $("#reportrange span").text('');
    $("#reportrange span").attr('data-rangedatestart', '');
    $("#reportrange span").attr('data-rangedateend', '');
});

$("#FilterName").change(function () {
    if ($(this).val() == "periodOfTime") {
        $("#reportrange span").text(`${filterOfRewindReport["periodOfTime"]['start']} - ${filterOfRewindReport["periodOfTime"]['end']}`);
        $('#reportrange').css('display', 'block');
        $("#FilterValue").css('display', 'none');
    } else {
        $("#FilterValue").val(filterOfRewindReport[$(this).val()]);
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


// Function To Get Data Of Rewind By JopOrderNumber
function GetData(Url, that = null, moreData = false) {
    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    filterOfRewindReport['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    dataForm['filter'] = filterOfRewindReport;
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

            let rewind = data[0];
            let rewindTime = data[1];
            let countOfStandardsRows = data[2];
            if (countOfStandardsRows > filterOfRewindReport['limit']) {
                $("#Limit").removeClass('d-none');
            } else {
                $("#Limit").addClass('d-none');
            }

            if (rewind.length == 0) {
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

            for (let i = 0; i < rewind.length; i++) {

                $('#Data .report .table tbody').append(`<tr data-id="${rewind[i].id}">
                    <th>${(filterOfRewindReport['limit'] - 24) + i}</th>
                    <td>${rewind[i].created_at.split(" ").join("<br>")}</td>
                    <td>${romanShift(rewind[i].shift)}</td>
                    <td>${rewind[i].added_by}</td>
                    <td>${rewind[i].inputDrum} <abbr title="${rewindTime[i].inputDrum_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${rewind[i].inputCard} <abbr title="${rewindTime[i].inputCard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${rewind[i].inputLength} <abbr title="${rewindTime[i].inputLength_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${rewind[i].outputDrum} <abbr title="${rewindTime[i].outputDrum_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${rewind[i].outputCard} <abbr title="${rewindTime[i].outputCard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${rewind[i].outputLength} <abbr title="${rewindTime[i].outputLength_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${rewind[i].reasonOfRewind} <abbr title="${rewindTime[i].reasonOfRewind_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${rewind[i].updated_by} <abbr title="${rewind[i].updated_at}"><i class="fas fa-stopwatch ${(rewind[i].updated_by == '') ? 'd-none' : ''}"></i></abbr></td>
                    <td class="option">
                    <button class="btn btn-primary mr-3" onclick="editRow(${rewind[i].id}, this)">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Edit</span>
                    </button>
                    <button class="btn btn-danger" onclick="deleteRow(${rewind[i].id}, this)">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Delete</span>
                    </button>
                    </td>
                    </tr>`);

            }

            if (rewind.length != 0) {
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
    GetData('Rewind', this, true);
});

$("#Filter").click(function () {
    $("#Limit").attr('data-count-rows', 25);
    GetData('Rewind', this);
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
        url: 'Rewind/deleteRow',
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
        url: `Rewind/getRow`,
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            let rewind = data[0];
            let rewindTime = data[1];
            let inputs = $('#Edit form').find('.input');
            // console.log(inputs);
            // console.log(data);
            // return 0;
            // To Preper Data Of RewindReport

            let rewind_id = rewind['id'];

            delete rewind['id'];
            delete rewind['added_by'];
            delete rewind['shift'];
            delete rewind['created_at'];
            delete rewind['updated_at'];
            delete rewind['updated_by'];
            delete rewind['fromSheet'];

            delete rewindTime['id'];
            delete rewindTime['rewind_id'];
            delete rewindTime['added_by'];
            delete rewindTime['shift'];
            delete rewindTime['created_at'];
            delete rewindTime['updated_at'];
            delete rewindTime['updated_by'];
            delete rewindTime['fromSheet'];

            for (let key in rewind) {
                let currentInput = $(inputs).filter(`[name="${key}"]`);
                currentInput.val(rewind[key]);
                currentInput.attr('data-time', rewindTime[key + '_time']);
            }

            $('body').css('overflow', 'hidden');
            $("#Edit form").attr('data-id', rewind_id);
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
                <td>${reportRow.inputDrum} <abbr title="${reportRowTime.inputDrum_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${reportRow.inputCard} <abbr title="${reportRowTime.inputCard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${reportRow.inputLength} <abbr title="${reportRowTime.inputLength_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${reportRow.outputDrum} <abbr title="${reportRowTime.outputDrum_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${reportRow.outputCard} <abbr title="${reportRowTime.outputCard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${reportRow.outputLength} <abbr title="${reportRowTime.outputLength_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${reportRow.reasonOfRewind} <abbr title="${reportRowTime.reasonOfRewind_time}"><i class="fas fa-stopwatch"></i></abbr></td>
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
    dataForm['reasonOfRewind'] = [$(this).find('textarea').eq(0).val(), $(this).find('textarea').eq(0).attr('data-time')];
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
    dataForm['filter'] = filterOfRewindReport;

    // console.log(dataForm);

    $.ajax({
        'url': 'Rewind/printData',
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data);

            let dataOfRewind = data[0];
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

            let tableHeadOfRewind = `<thead>
                                     <tr>
                                     <th>SN</th>
                                     <th>Date / Time</th>
                                     <th>Shift</th>
                                     <th class="text-center pb-0" colspan="3">
                                     Input
                                     <div class="row m-0 mt-2">
                                     <span class="col-4 p-0 m-0 px-2 text-center">Drum</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Card</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Length</span>
                                     </div>
                                     </th>
                                     <th class="text-center pb-0" colspan="3">
                                     Output
                                     <div class="row m-0 mt-2">
                                     <span class="col-4 p-0 m-0 px-2 text-center">Drum</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Card</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Length</span>
                                     </div>
                                     </th>
                                     <th class="notes">Reason Of Rewind</th>
                                     <th>Add By</th>
                                     </tr>
                                     </thead>`;

            let rewind = ``;
            let printContent = '';

            function createRewindRow(i) {
                return `<tr data-id="${dataOfRewind[i].id}">
                <th>${i + 1}</th>
                <td>${dataOfRewind[i].created_at.split(" ").join("<br>")}</td>
                <td>${romanShift(dataOfRewind[i].shift)}</td>
                <td>${dataOfRewind[i].inputDrum}</td>
                <td>${dataOfRewind[i].inputCard}</td>
                <td>${dataOfRewind[i].inputLength}</td>
                <td>${dataOfRewind[i].outputDrum}</td>
                <td>${dataOfRewind[i].outputCard}</td>
                <td>${dataOfRewind[i].outputLength}</td>
                <td>${dataOfRewind[i].reasonOfRewind}</td>
                <td>${dataOfRewind[i].added_by}</td>
                </td>
                </tr>`;
            }


            // Prepare Pages To Print it
            for (let i = 0, j = 1; i < dataOfRewind.length; i++, j++) {
                let rewindRow = createRewindRow(i);
                if (j % 15 != 0 && j != dataOfRewind.length) {
                    rewind += rewindRow;
                } else if (j % 15 == 0) {
                    rewind += rewindRow;

                    let rewindTable = `<div class="report mt-5 Taps">
                                                <table class="table table-hover">
                                                ${tableHeadOfRewind}
                                                <tbody>
                                                ${rewind}
                                                </tbody>
                                                </table>
                                                </div>`;

                    let page = '<div class="page">' + pageNav + rewindTable + '</div>';
                    printContent += page;
                    rewind = ``;
                } else {
                    rewind += rewindRow;

                    let rewindTable = `<div class="report mt-5 Taps">
                                                <table class="table table-hover">
                                                ${tableHeadOfRewind}
                                                <tbody>
                                                ${rewind}
                                                </tbody>
                                                </table>
                                                </div>`;

                    let page = '<div class="page">' + pageNav + rewindTable + '</div>';
                    printContent += page;
                    rewind = ``;
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




