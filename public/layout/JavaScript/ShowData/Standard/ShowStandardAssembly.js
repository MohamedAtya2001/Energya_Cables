
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
let filterOfStandardAssembly = {
    'shift': '',
    'added_by': '',
    'jopOrderNumber': '',
    'cableSize': '',
    'updated_by': '',
    'periodOfTime': { 'start': '', 'end': '' },
    'limit': 25
};

//To Get Data From Filter And Save It At FilterArray
$("#FilterValue").blur(function () {
    filterOfStandardAssembly[$("#FilterName").val()] = $(this).val();
    if ($(this).val() != '') {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).addClass('filtered');
    } else {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).removeClass('filtered');
    }
});

// To Make Filter On Data By Period Of Date
$("#reportrange").on('apply.daterangepicker, hide.daterangepicker', function (ev, picker) {
    cb(picker.startDate, picker.endDate);
    filterOfStandardAssembly["periodOfTime"]['start'] = $("#reportrange span").attr('data-rangedatestart');
    filterOfStandardAssembly["periodOfTime"]['end'] = $("#reportrange span").attr('data-rangedateend');
    $('#FilterName').find(`option[value="periodOfTime"]`).addClass('filtered');
});

// To Get Back All Data After Click On Cancel
$("#reportrange").on('cancel.daterangepicker', function () {
    filterOfStandardAssembly["periodOfTime"]['start'] = "";
    filterOfStandardAssembly["periodOfTime"]['end'] = "";
    $("#reportrange span").text('');
    $("#reportrange span").attr('data-rangedatestart', '');
    $("#reportrange span").attr('data-rangedateend', '');
    $('#FilterName').find(`option[value="periodOfTime"]`).removeClass('filtered');
});

$("#FilterName").change(function () {
    if ($(this).val() == "periodOfTime") {
        $("#reportrange span").text(`${filterOfStandardAssembly["periodOfTime"]['start']} - ${filterOfStandardAssembly["periodOfTime"]['end']}`);
        $('#reportrange').css('display', 'block');
        $("#FilterValue").css('display', 'none');
    } else {
        $("#FilterValue").val(filterOfStandardAssembly[$(this).val()]);
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

// Function To Get Data Of Assembly By JopOrderNumber
function GetData(that = null, moreData = false) {
    $(that).prop('disabled', true);
    $(that).find('button[type="submit"]').prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    filterOfStandardAssembly['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    dataForm['filter'] = filterOfStandardAssembly;
    // console.log(dataForm);
    $.ajax({
        'url': 'Standard',
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            $(that).prop('disabled', false);
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            let assembly = data[0];
            let assemblyTime = data[1];
            let countOfStandardsRows = data[2];
            if (countOfStandardsRows > filterOfStandardAssembly['limit']) {
                $("#Limit").removeClass('d-none');
            } else {
                $("#Limit").addClass('d-none');
            }

            // console.log(data);
            if (data == "Not Found") {
                alert('Jop Order Number Not Found');
                return 0;
            }

            if (assembly.length == 0) {
                $('p.alert').removeClass('d-none');
                $('#Data .actual .table tbody').html('');
                return 0;
            } else {
                $('p.alert').addClass('d-none');
            }

            /* ================================ */

            if (!moreData) {
                $('#Data .actual .table tbody').html('');
            }

            for (let i = 0; i < assembly.length; i++) {

                $('#Data .actual .table tbody').append(`<tr data-id="${assembly[i].id}">
                    <th>${(filterOfStandardAssembly['limit'] - 24) + i}</th>
                    <td>${assembly[i].created_at.split(" ").join("<br>")}</td>
                    <td>${romanShift(assembly[i].shift)}</td>
                    <td>${assembly[i].added_by}</td>
                    <td>${assembly[i].jopOrderNumber} <abbr title="${assemblyTime[i].jopOrderNumber_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${assembly[i].cableSize} <abbr title="${assemblyTime[i].cableSize_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${assembly[i].cableDescription} <abbr title="${assemblyTime[i].cableDescription_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${assembly[i].outerDimMinStandard} <abbr title="${assemblyTime[i].outerDimMinStandard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${assembly[i].outerDimNomStandard} <abbr title="${assemblyTime[i].outerDimNomStandard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${assembly[i].outerDimMaxStandard} <abbr title="${assemblyTime[i].outerDimMaxStandard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${assembly[i].fillerStandard + ' ' + assembly[i].twistedStandard} <abbr title="${assemblyTime[i].fillerStandard_time + ' | ' + assemblyTime[i].twistedStandard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${assembly[i].overLap} <abbr title="${assemblyTime[i].overLap_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${assembly[i].ovalityStandard} <abbr title="${assemblyTime[i].ovalityStandard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${assembly[i].layLengthStandard} <abbr title="${assemblyTime[i].layLengthStandard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                    <td>${assembly[i].updated_by} <abbr title="${assembly[i].updated_at}"><i class="fas fa-stopwatch ${(assembly[i].updated_by == '') ? 'd-none' : ''}"></i></abbr></td>
                    <td class="option">
                    <button class="btn btn-primary" onclick="editRow(${assembly[i].id}, this)">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Edit</span>
                    </button>
                    </td>
                    </tr>`);

            }

        },
        'error': function (data) {
            $(that).prop('disabled', true);
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        },
    });
}

// To Get More Data Standards
$("#Limit").click(function () {
    $(this).attr('data-count-rows', parseInt($(this).attr('data-count-rows')) + 25);
    GetData(this, true);
});

// To Make Filter On Data
$('#Filter').click(function () {
    $("#Limit").attr('data-count-rows', 25);
    GetData(this);
});

// Function To Get Row To Make Edit On It 
function editRow(rowId, that) {
    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    dataForm = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'rowId': rowId
    };

    $.ajax({
        url: `Standard/getRow`,
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            let assemblyStandard = data[0];
            let assemblyStandardTime = data[1];
            let inputs = $('#Edit form').find('.input');

            // To Preper Data Of AssemblyStandard
            let assemblyStandard_id = assemblyStandard['id'];

            delete assemblyStandard['id'];
            delete assemblyStandard['added_by'];
            delete assemblyStandard['shift'];
            delete assemblyStandard['created_at'];
            delete assemblyStandard['updated_at'];

            delete assemblyStandardTime['id'];
            delete assemblyStandardTime['assemblystandards_id'];
            delete assemblyStandardTime['added_by'];
            delete assemblyStandardTime['shift'];
            delete assemblyStandardTime['created_at'];
            delete assemblyStandardTime['updated_at'];

            for (let key in assemblyStandard) {
                let currentInput = $(inputs).filter(`[name="${key}"]`);
                currentInput.val(assemblyStandard[key]);
                currentInput.attr('data-time', assemblyStandardTime[key + '_time']);
            }

            $('body').css('overflow', 'hidden');
            $("#Edit form").attr('data-id', assemblyStandard_id);
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

//Function To Update Data Standard Of That Row Who Edited
function updateStandard(data) {
    let standardRow = data[0];
    let standardRowTime = data[1];
    let i = $(`#Data .actual .table tbody tr[data-id="${standardRow.id}"]`).index() + 1;

    $(`#Data .actual .table tbody tr[data-id="${standardRow.id}"]`).html(`
                <th>${i}</th>
                <td>${standardRow[i].created_at.split(" ").join("<br>")}</td>
                <td>${romanShift(standardRow[i].shift)}</td>
                <td>${standardRow.added_by}</td>
                <td>${standardRow.jopOrderNumber} <abbr title="${standardRowTime.jopOrderNumber_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${standardRow.cableSize} <abbr title="${standardRowTime.cableSize_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${standardRow.cableDescription} <abbr title="${standardRowTime.cableDescription_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${standardRow.outerDimMinStandard} <abbr title="${standardRowTime.outerDimMinStandard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${standardRow.outerDimNomStandard} <abbr title="${standardRowTime.outerDimNomStandard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${standardRow.outerDimMaxStandard} <abbr title="${standardRowTime.outerDimMaxStandard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${standardRow.fillerStandard + ' ' + standardRow.twistedStandard} <abbr title="${standardRowTime.fillerStandard_time + ' | ' + standardRowTime.twistedStandard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${standardRow.overLap} <abbr title="${standardRowTime.overLap_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${standardRow.ovalityStandard} <abbr title="${standardRowTime.ovalityStandard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${standardRow.layLengthStandard} <abbr title="${standardRowTime.layLengthStandard_time}"><i class="fas fa-stopwatch"></i></abbr></td>
                <td>${standardRow.updated_by} <abbr title="${standardRow.updated_at}"><i class="fas fa-stopwatch ${(standardRow.updated_by == '') ? 'd-none' : ''}"></i></abbr></td>
                <td class="option">
                <button class="btn btn-primary" onclick="editRow(${standardRow.id}, this)">
                <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span>Edit</span>
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
                // Update Standard That Edited
                updateStandard(data);

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
