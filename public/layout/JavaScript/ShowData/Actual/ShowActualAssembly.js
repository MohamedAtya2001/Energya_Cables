
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
let filterOfActualAssembly = {
    'jopOrderNumber': '',
    'shift': '',
    'added_by': '',
    'machine': '',
    'inputDrum': '',
    'inputCard': '',
    'inputLength': '',
    'color': '',
    'outputDrum': '',
    'outputCard': '',
    'outputLength': '',
    'status': { 'hold': true, 'pass': true },
    'productionOperator': '',
    'notes': false,
    'periodOfTime': { 'start': '', 'end': '' },
    'updated_by': '',
    'sheetsType': 'complete',
    'limit': 25
};

//To Get Data From Filter And Save It At FilterArray
$("#FilterValue").blur(function () {
    filterOfActualAssembly[$("#FilterName").val()] = $(this).val();
    if ($(this).val() != '') {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).addClass('filtered');
    } else {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).removeClass('filtered');
    }
});

// To Make Filter On Data By Period Of Date
$("#reportrange").on('apply.daterangepicker, hide.daterangepicker', function (ev, picker) {
    cb(picker.startDate, picker.endDate);
    filterOfActualAssembly["periodOfTime"]['start'] = $("#reportrange span").attr('data-rangedatestart');
    filterOfActualAssembly["periodOfTime"]['end'] = $("#reportrange span").attr('data-rangedateend');
    $('#FilterName').find(`option[value="periodOfTime"]`).addClass('filtered');
});

// To Get Back All Data After Click On Cancel
$("#reportrange").on('cancel.daterangepicker', function () {
    filterOfActualAssembly["periodOfTime"]['start'] = "";
    filterOfActualAssembly["periodOfTime"]['end'] = "";
    $("#reportrange span").text('');
    $("#reportrange span").attr('data-rangedatestart', '');
    $("#reportrange span").attr('data-rangedateend', '');
    $('#FilterName').find(`option[value="periodOfTime"]`).removeClass('filtered');
});

$("#FilterName").change(function () {
    if ($(this).val() == "periodOfTime") {
        $(this).attr('data-last-selected', $(this).val());
        $("#reportrange span").text(`${filterOfActualAssembly["periodOfTime"]['start']} - ${filterOfActualAssembly["periodOfTime"]['end']}`);
        $('#reportrange').css('display', 'block');
        $("#FilterValue").css('display', 'none');
        $("#SheetsType").css('display', 'none');
        $("#Status").css('display', 'none');
    } else if ($(this).val() == "sheetsType") {
        $(this).attr('data-last-selected', $(this).val());
        $('#reportrange').css('display', 'none');
        $("#FilterValue").css('display', 'none');
        $("#SheetsType").css('display', 'flex');
        $("#Status").css('display', 'none');
    } else if ($(this).val() == "status") {
        $(this).attr('data-last-selected', $(this).val());
        $('#reportrange').css('display', 'none');
        $("#FilterValue").css('display', 'none');
        $("#SheetsType").css('display', 'none');
        $("#Status").css('display', 'flex');
    } else if ($(this).val() == "notes") {
        $(this).val($(this).attr('data-last-selected'));
        if ($('#FilterName').find(`option[value="notes"]`).hasClass('filtered')) {
            filterOfActualAssembly['notes'] = false;
            $('#FilterName').find(`option[value="notes"]`).removeClass('filtered');
        } else {
            filterOfActualAssembly['notes'] = true;
            $('#FilterName').find(`option[value="notes"]`).addClass('filtered');
        }
    } else {
        $(this).attr('data-last-selected', $(this).val());
        $("#FilterValue").val(filterOfActualAssembly[$(this).val()]);
        $('#reportrange').css('display', 'none');
        $("#FilterValue").css('display', 'block');
        $("#SheetsType").css('display', 'none');
        $("#Status").css('display', 'none');
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

//To Save Change That Happend On sheetsType Selector
function sheetsTypeFilter(that) {
    $('#SheetsType input').not(that).prop('checked', !$(that).prop('checked'));
    filterOfActualAssembly['sheetsType'] = ($(that).prop('checked')) ? $(that).attr('name') : $('#SheetsType input').not(that).attr('name');

    if ($('#Complete').prop('checked')) {
        $('#FilterName').find(`option[value="sheetsType"]`).removeClass('filtered');
        $('#StartPrint').prop('disabled', false);
    } else {
        $('#FilterName').find(`option[value="sheetsType"]`).addClass('filtered');
        $('#StartPrint').prop('disabled', true);
    }
}

//To Save Change That Happend On Status Selector
function statusFilter(that) {
    if (!$('input#Hold').prop('checked') && !$('input#Pass').prop('checked')) {
        $(that).prop('checked', false);
        $('#Status input').not(that).prop('checked', true);
    }

    filterOfActualAssembly['status']['hold'] = $('input#Hold').prop('checked');
    filterOfActualAssembly['status']['pass'] = $('input#Pass').prop('checked');

    if ($('input#Hold').prop('checked') && $('input#Pass').prop('checked')) {
        $('#FilterName').find(`option[value="status"]`).removeClass('filtered');
    } else {
        $('#FilterName').find(`option[value="status"]`).addClass('filtered');
    }

}

// Function To Get Data Of Assembly By JopOrderNumber
function GetData(that, moreData = false) {
    $(that).prop('disabled', true);
    $(that).find('button[type="submit"]').prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    filterOfActualAssembly['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    if (filterOfActualAssembly['sheetsType'] == "uncomplete") {
        $("#Limit").attr('data-count-rows', 25);
        filterOfActualAssembly['limit'] = 25;
    }
    dataForm['filter'] = filterOfActualAssembly;
    $.ajax({
        'url': 'Actual',
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            // console.log(data);
            $(that).prop('disabled', false);
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            let standardRow = data[0][0];
            let actualRows = data[1];
            let actualTimeRows = data[2];
            let countOfActualsRows = data[3];
            if (countOfActualsRows > filterOfActualAssembly['limit']) {
                $("#Limit").removeClass('d-none');
            } else {
                $("#Limit").addClass('d-none');
            }

            if (data == "Not Found") {
                alert('Jop Order Number Not Found');
                return 0;
            } else {
                $('.jopOrderNumber .input').val('');
            }

            $('#Data .standard table').html(`<tr>
                    <th>Jop Order Number : </th>
                    <td id="JopOrderNumber">${standardRow.jopOrderNumber}</td>
                    <th>Cable Size : </th>
                    <td>${standardRow.cableSize}</td>
                    <th>Cable Description : </th>
                    <td>${standardRow.cableDescription}</td>
                    <th>Filler / p.p Tape : </th>
                    <td>${standardRow.fillerStandard + " " + standardRow.twistedStandard}</td>
                    <th>Over Lap : </th>
                    <td>${standardRow.overLap}</td>
                    </tr>
                    <tr>
                    <th>Outer Min Dim : </th>
                    <td>${standardRow.outerDimMinStandard}</td>
                    <th>Outer Nom Dim : </th>
                    <td>${standardRow.outerDimNomStandard}</td>
                    <th>Outer Max Dim : </th>
                    <td>${standardRow.outerDimMaxStandard}</td>
                    <th>Lay Length : </th>
                    <td>${standardRow.layLengthStandard}</td>
                    <th>Ovality : </th>
                    <td>${standardRow.ovalityStandard}</td>
                    </tr>`);

            if (actualRows.length == 0) {
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

            for (let i = 0; i < actualRows.length; i++) {

                $('#Data .actual .table tbody').append(`<tr data-id="${actualRows[i].id}">
                    <th>${(filterOfActualAssembly['limit'] - 24) + i}</th>
                    <td>${actualRows[i].created_at.split(" ").join("<br>")}</td>
                    <td>${romanShift(actualRows[i].shift)}</td>
                    <td>${actualRows[i].added_by}</td>
                    <td>${(actualRows[i].machine == null) ? '' : actualRows[i].machine} <abbr title="${actualTimeRows[i].machine_time}"><i class="fas fa-stopwatch ${(actualRows[i].machine == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td class="prepareInput">
                    <span class="th position-relative">Drum</span>
                    <span class="th position-relative">Card</span>
                    <span class="th position-relative">Length</span>
                    <span class="th position-relative">Color</span>
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].inputDrum1 == null) ? '' : actualRows[i].inputDrum1}  <abbr title="${actualTimeRows[i].inputDrum1_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputDrum1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].inputCard1 == null) ? '' : actualRows[i].inputCard1}  <abbr title="${actualTimeRows[i].inputCard1_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputCard1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].inputLength1 == null) ? '' : actualRows[i].inputLength1}  <abbr title="${actualTimeRows[i].inputLength1_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputLength1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].color1 == null) ? '' : actualRows[i].color1}  <abbr title="${actualTimeRows[i].color1_time}"><i class="fas fa-stopwatch ${(actualRows[i].color1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].inputDrum2 == null) ? '' : actualRows[i].inputDrum2}  <abbr title="${actualTimeRows[i].inputDrum2_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputDrum2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].inputCard2 == null) ? '' : actualRows[i].inputCard2}  <abbr title="${actualTimeRows[i].inputCard2_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputCard2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].inputLength2 == null) ? '' : actualRows[i].inputLength2}  <abbr title="${actualTimeRows[i].inputLength2_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputLength2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].color2 == null) ? '' : actualRows[i].color2}  <abbr title="${actualTimeRows[i].color2_time}"><i class="fas fa-stopwatch ${(actualRows[i].color2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].inputDrum3 == null) ? '' : actualRows[i].inputDrum3}  <abbr title="${actualTimeRows[i].inputDrum3_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputDrum3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].inputCard3 == null) ? '' : actualRows[i].inputCard3}  <abbr title="${actualTimeRows[i].inputCard3_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputCard3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].inputLength3 == null) ? '' : actualRows[i].inputLength3}  <abbr title="${actualTimeRows[i].inputLength3_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputLength3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].color3 == null) ? '' : actualRows[i].color3}  <abbr title="${actualTimeRows[i].color3_time}"><i class="fas fa-stopwatch ${(actualRows[i].color3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].inputDrum4 == null) ? '' : actualRows[i].inputDrum4}  <abbr title="${actualTimeRows[i].inputDrum4_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputDrum4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].inputCard4 == null) ? '' : actualRows[i].inputCard4}  <abbr title="${actualTimeRows[i].inputCard4_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputCard4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].inputLength4 == null) ? '' : actualRows[i].inputLength4}  <abbr title="${actualTimeRows[i].inputLength4_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputLength4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].color4 == null) ? '' : actualRows[i].color4}  <abbr title="${actualTimeRows[i].color4_time}"><i class="fas fa-stopwatch ${(actualRows[i].color4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].inputDrum5 == null) ? '' : actualRows[i].inputDrum5}  <abbr title="${actualTimeRows[i].inputDrum5_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputDrum5 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].inputCard5 == null) ? '' : actualRows[i].inputCard5}  <abbr title="${actualTimeRows[i].inputCard5_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputCard5 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].inputLength5 == null) ? '' : actualRows[i].inputLength5}  <abbr title="${actualTimeRows[i].inputLength5_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputLength5 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].color5 == null) ? '' : actualRows[i].color5}  <abbr title="${actualTimeRows[i].color5_time}"><i class="fas fa-stopwatch ${(actualRows[i].color5 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    </td>
                    <td>${(actualRows[i].outputDrum == null) ? '' : actualRows[i].outputDrum} <abbr title="${actualTimeRows[i].outputDrum_time}"><i class="fas fa-stopwatch ${(actualRows[i].outputDrum == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].outputCard == null) ? '' : actualRows[i].outputCard} <abbr title="${actualTimeRows[i].outputCard_time}"><i class="fas fa-stopwatch ${(actualRows[i].outputCard == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].outputLength == null) ? '' : actualRows[i].outputLength} <abbr title="${actualTimeRows[i].outputLength_time}"><i class="fas fa-stopwatch ${(actualRows[i].outputLength == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].outerDimMinActual == null) ? '' : actualRows[i].outerDimMinActual} <abbr title="${actualTimeRows[i].outerDimMinActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].outerDimMinActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].outerDimNomActual == null) ? '' : actualRows[i].outerDimNomActual} <abbr title="${actualTimeRows[i].outerDimNomActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].outerDimNomActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].outerDimMaxActual == null) ? '' : actualRows[i].outerDimMaxActual} <abbr title="${actualTimeRows[i].outerDimMaxActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].outerDimMaxActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].ovalityActual == null) ? '' : actualRows[i].ovalityActual} <abbr title="${actualTimeRows[i].ovalityActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].ovalityActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td  style="min-width: 100px;">${(actualRows[i].layLengthActual == null) ? '' : actualRows[i].layLengthActual} <abbr title="${actualTimeRows[i].layLengthActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].layLengthActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td  style="min-width: 100px;">${(actualRows[i].direction == null) ? '' : actualRows[i].direction} <abbr title="${actualTimeRows[i].direction_time}"><i class="fas fa-stopwatch ${(actualRows[i].direction == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].fillerActual == null) ? '' : actualRows[i].fillerActual + " " + actualRows[i].twistedActual} <abbr title="${actualTimeRows[i].fillerActual_time + " | " + actualTimeRows[i].twistedActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].fillerActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td class="assembly" style="min-width: 100px;">${(actualRows[i].ppTapeSize == null) ? '' : actualRows[i].ppTapeSize} <abbr title="${actualTimeRows[i].ppTapeSize_time}"><i class="fas fa-stopwatch ${(actualRows[i].ppTapeSize == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td class="assembly" style="min-width: 100px;">${(actualRows[i].ppTapeOverLap == null) ? '' : actualRows[i].ppTapeOverLap} <abbr title="${actualTimeRows[i].ppTapeOverLap_time}"><i class="fas fa-stopwatch ${(actualRows[i].ppTapeOverLap == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].status == null) ? '' : actualRows[i].status} <abbr title="${actualTimeRows[i].status_time}"><i class="fas fa-stopwatch ${(actualRows[i].status == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].productionOperator == null) ? '' : actualRows[i].productionOperator} <abbr title="${actualTimeRows[i].productionOperator_time}"><i class="fas fa-stopwatch ${(actualRows[i].productionOperator == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].notes == null) ? '' : actualRows[i].notes} <abbr title="${actualTimeRows[i].notes_time}"><i class="fas fa-stopwatch ${(actualRows[i].notes == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${actualRows[i].updated_by} <abbr title="${actualRows[i].updated_at}"><i class="fas fa-stopwatch ${(actualRows[i].updated_by == '') ? 'd-none' : ''}"></i></abbr></td>
                    <td class="option">
                    <button class="btn btn-primary mr-3" onclick="editRow(${actualRows[i].id}, this)">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Edit</span>
                    </button>
                    <button class="btn btn-danger" onclick="deleteRow(${actualRows[i].id}, this)">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Delete</span>
                    </button>
                    </td>
                    </tr>`);

            }

            if (actualRows.length != 0) {
                $('#FilterValue, #FilterName, #Filter, #StartPrint').prop('disabled', false);
            } else {
                $('#FilterValue, #FilterName, #Filter, #StartPrint').prop('disabled', true);
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

// To Get More Data Actuals
$("#Limit").click(function () {
    $(this).attr('data-count-rows', parseInt($(this).attr('data-count-rows')) + 25);
    GetData(this, true);
});

// Function To Delete Row By Id 
function deleteRow(rowId, that) {

    if (!confirm("Are You Sure ?")) {
        return 0;
    }

    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    dataForm = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'rowId': rowId
    };

    $.ajax({
        url: 'Actual/deleteRow',
        type: 'POST',
        data: dataForm,
        success: function (data) {
            if (data == "Error") {
                $(that).find('.spinner').addClass('d-none');
                $(that).find('.bug').addClass('d-none');
                alert("Sorry, It's Not The Last Process Of Traceability");
            } else {
                $(that).prop('disabled', false);
                $(that).find('.spinner').addClass('d-none');
                $(that).find('.bug').addClass('d-none');
                $(`.sheets .actual tbody tr[data-id="${rowId}"]`).remove();
            }

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
        url: `Actual/getRow`,
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            let actualRow = data[0];
            let actualTimeRow = data[1];
            let inputs = $('#Edit form').find('.input, textarea');
            // console.log(inputs);

            //To Make Inputs Of Edit Sheet required if sheetsType is Complete 
            $(inputs).not(` #Edit input[name="inputDrum2"], 
                            #Edit input[name="inputDrum3"],
                            #Edit input[name="inputDrum4"],
                            #Edit input[name="inputDrum5"],
                            #Edit input[name="inputCard2"], 
                            #Edit input[name="inputCard3"],
                            #Edit input[name="inputCard4"],
                            #Edit input[name="inputCard5"],
                            #Edit input[name="inputLength2"], 
                            #Edit input[name="inputLength3"],
                            #Edit input[name="inputLength4"],
                            #Edit input[name="inputLength5"],
                            #Edit input[name="color2"], 
                            #Edit input[name="color3"],
                            #Edit input[name="color4"],
                            #Edit input[name="color5"],
                            #Edit textarea`).prop('required', (filterOfActualAssembly['sheetsType'] == 'complete'));

            // To Preper Data Of AssemblyActual
            let assemblyActual_id = actualRow['id'];

            delete actualRow['id'];
            delete actualRow['jopOrderNumber_id'];
            delete actualRow['jopOrderNumber'];
            delete actualRow['added_by'];
            delete actualRow['shift'];
            delete actualRow['created_at'];
            delete actualRow['updated_at'];

            delete actualTimeRow['id'];
            delete actualTimeRow['assemblyactuals_id'];
            delete actualTimeRow['added_by'];
            delete actualTimeRow['shift'];
            delete actualTimeRow['created_at'];
            delete actualTimeRow['updated_at'];

            for (let key in actualRow) {
                let currentInput = $(inputs).filter(`[name="${key}"]`);
                currentInput.val(actualRow[key]);
                currentInput.attr('data-time', actualTimeRow[key + '_time']);
            }

            $('body').css('overflow', 'hidden');
            $("#Edit form").attr('data-id', assemblyActual_id);
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

//Function To Update Data Actual Of That Row Who Edited
function updateActual(data) {
    // console.log(data);
    let actualRow = data[0];
    let actualRowTime = data[1];
    let i = $(`#Data .actual .table tbody tr[data-id="${actualRow.id}"]`).index() + 1;

    $(`#Data .actual .table tbody tr[data-id="${actualRow.id}"]`).html(`
                <th>${i}</th>
                <td>${actualRow.created_at.split(" ").join("<br>")}</td>
                <td>${romanShift(actualRow.shift)}</td>
                <td>${actualRow.added_by}</td>
                <td>${(actualRow.machine == null) ? '' : actualRow.machine} <abbr title="${actualRowTime.machine_time}"><i class="fas fa-stopwatch ${(actualRow.machine == null) ? 'd-none' : ''}"></i></abbr></td>
                <td class="prepareInput">
                <span class="th position-relative">Drum</span>
                <span class="th position-relative">Card</span>
                <span class="th position-relative">Length</span>
                <span class="th position-relative">Color</span>
                </td>
                <td class="prepareInput">
                <span>${(actualRow.inputDrum1 == null) ? '' : actualRow.inputDrum1}  <abbr title="${actualRowTime.inputDrum1_time}"><i class="fas fa-stopwatch ${(actualRow.inputDrum1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.inputCard1 == null) ? '' : actualRow.inputCard1}  <abbr title="${actualRowTime.inputCard1_time}"><i class="fas fa-stopwatch ${(actualRow.inputCard1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.inputLength1 == null) ? '' : actualRow.inputLength1}  <abbr title="${actualRowTime.inputLength1_time}"><i class="fas fa-stopwatch ${(actualRow.inputLength1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.color1 == null) ? '' : actualRow.color1}  <abbr title="${actualRowTime.color1_time}"><i class="fas fa-stopwatch ${(actualRow.color1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                </td>
                <td class="prepareInput">
                <span>${(actualRow.inputDrum2 == null) ? '' : actualRow.inputDrum2}  <abbr title="${actualRowTime.inputDrum2_time}"><i class="fas fa-stopwatch ${(actualRow.inputDrum2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.inputCard2 == null) ? '' : actualRow.inputCard2}  <abbr title="${actualRowTime.inputCard2_time}"><i class="fas fa-stopwatch ${(actualRow.inputCard2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.inputLength2 == null) ? '' : actualRow.inputLength2}  <abbr title="${actualRowTime.inputLength2_time}"><i class="fas fa-stopwatch ${(actualRow.inputLength2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.color2 == null) ? '' : actualRow.color2}  <abbr title="${actualRowTime.color2_time}"><i class="fas fa-stopwatch ${(actualRow.color2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                </td>
                <td class="prepareInput">
                <span>${(actualRow.inputDrum3 == null) ? '' : actualRow.inputDrum3}  <abbr title="${actualRowTime.inputDrum3_time}"><i class="fas fa-stopwatch ${(actualRow.inputDrum3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.inputCard3 == null) ? '' : actualRow.inputCard3}  <abbr title="${actualRowTime.inputCard3_time}"><i class="fas fa-stopwatch ${(actualRow.inputCard3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.inputLength3 == null) ? '' : actualRow.inputLength3}  <abbr title="${actualRowTime.inputLength3_time}"><i class="fas fa-stopwatch ${(actualRow.inputLength3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.color3 == null) ? '' : actualRow.color3}  <abbr title="${actualRowTime.color3_time}"><i class="fas fa-stopwatch ${(actualRow.color3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                </td>
                <td class="prepareInput">
                <span>${(actualRow.inputDrum4 == null) ? '' : actualRow.inputDrum4}  <abbr title="${actualRowTime.inputDrum4_time}"><i class="fas fa-stopwatch ${(actualRow.inputDrum4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.inputCard4 == null) ? '' : actualRow.inputCard4}  <abbr title="${actualRowTime.inputCard4_time}"><i class="fas fa-stopwatch ${(actualRow.inputCard4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.inputLength4 == null) ? '' : actualRow.inputLength4}  <abbr title="${actualRowTime.inputLength4_time}"><i class="fas fa-stopwatch ${(actualRow.inputLength4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.color4 == null) ? '' : actualRow.color4}  <abbr title="${actualRowTime.color4_time}"><i class="fas fa-stopwatch ${(actualRow.color4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                </td>
                <td class="prepareInput">
                <span>${(actualRow.inputDrum5 == null) ? '' : actualRow.inputDrum5}  <abbr title="${actualRowTime.inputDrum5_time}"><i class="fas fa-stopwatch ${(actualRow.inputDrum5 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.inputCard5 == null) ? '' : actualRow.inputCard5}  <abbr title="${actualRowTime.inputCard5_time}"><i class="fas fa-stopwatch ${(actualRow.inputCard5 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.inputLength5 == null) ? '' : actualRow.inputLength5}  <abbr title="${actualRowTime.inputLength5_time}"><i class="fas fa-stopwatch ${(actualRow.inputLength5 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.color5 == null) ? '' : actualRow.color5}  <abbr title="${actualRowTime.color5_time}"><i class="fas fa-stopwatch ${(actualRow.color5 == null) ? 'd-none' : ''}"></i></abbr> </span>
                </td>
                <td>${(actualRow.outputDrum == null) ? '' : actualRow.outputDrum} <abbr title="${actualRowTime.outputDrum_time}"><i class="fas fa-stopwatch ${(actualRow.outputDrum == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.outputCard == null) ? '' : actualRow.outputCard} <abbr title="${actualRowTime.outputCard_time}"><i class="fas fa-stopwatch ${(actualRow.outputCard == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.outputLength == null) ? '' : actualRow.outputLength} <abbr title="${actualRowTime.outputLength_time}"><i class="fas fa-stopwatch ${(actualRow.outputLength == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.outerDimMinActual == null) ? '' : actualRow.outerDimMinActual} <abbr title="${actualRowTime.outerDimMinActual_time}"><i class="fas fa-stopwatch ${(actualRow.outerDimMinActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.outerDimNomActual == null) ? '' : actualRow.outerDimNomActual} <abbr title="${actualRowTime.outerDimNomActual_time}"><i class="fas fa-stopwatch ${(actualRow.outerDimNomActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.outerDimMaxActual == null) ? '' : actualRow.outerDimMaxActual} <abbr title="${actualRowTime.outerDimMaxActual_time}"><i class="fas fa-stopwatch ${(actualRow.outerDimMaxActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.ovalityActual == null) ? '' : actualRow.ovalityActual} <abbr title="${actualRowTime.ovalityActual_time}"><i class="fas fa-stopwatch ${(actualRow.ovalityActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td  style="min-width: 100px;">${(actualRow.layLengthActual == null) ? '' : actualRow.layLengthActual} <abbr title="${actualRowTime.layLengthActual_time}"><i class="fas fa-stopwatch ${(actualRow.layLengthActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td  style="min-width: 100px;">${(actualRow.direction == null) ? '' : actualRow.direction} <abbr title="${actualRowTime.direction_time}"><i class="fas fa-stopwatch ${(actualRow.direction == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.fillerActual == null) ? '' : actualRow.fillerActual + " " + actualRow.twistedActual} <abbr title="${actualRowTime.fillerActual_time + " | " + actualRowTime.twistedActual_time}"><i class="fas fa-stopwatch ${(actualRow.fillerActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td class="assembly" style="min-width: 100px;">${(actualRow.ppTapeSize == null) ? '' : actualRow.ppTapeSize} <abbr title="${actualRowTime.ppTapeSize_time}"><i class="fas fa-stopwatch ${(actualRow.ppTapeSize == null) ? 'd-none' : ''}"></i></abbr></td>
                <td class="assembly" style="min-width: 100px;">${(actualRow.ppTapeOverLap == null) ? '' : actualRow.ppTapeOverLap} <abbr title="${actualRowTime.ppTapeOverLap_time}"><i class="fas fa-stopwatch ${(actualRow.ppTapeOverLap == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.status == null) ? '' : actualRow.status} <abbr title="${actualRowTime.status_time}"><i class="fas fa-stopwatch ${(actualRow.status == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.productionOperator == null) ? '' : actualRow.productionOperator} <abbr title="${actualRowTime.productionOperator_time}"><i class="fas fa-stopwatch ${(actualRow.productionOperator == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.notes == null) ? '' : actualRow.notes} <abbr title="${actualRowTime.notes_time}"><i class="fas fa-stopwatch ${(actualRow.notes == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${actualRow.updated_by} <abbr title="${actualRow.updated_at}"><i class="fas fa-stopwatch ${(actualRow.updated_by == '') ? 'd-none' : ''}"></i></abbr></td>
                <td class="option">
                <button class="btn btn-primary mr-3" onclick="editRow(${actualRow.id}, this)">
                <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span>Edit</span>
                </button>
                <button class="btn btn-danger" onclick="deleteRow(${actualRow.id}, this)">
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

function clearFilter() {
    filterOfActualAssembly = {
        'jopOrderNumber': '',
        'shift': '',
        'added_by': '',
        'machine': '',
        'inputDrum': '',
        'inputCard': '',
        'inputLength': '',
        'color': '',
        'outputDrum': '',
        'outputCard': '',
        'outputLength': '',
        'status': { 'hold': true, 'pass': true },
        'productionOperator': '',
        'notes': false,
        'periodOfTime': { 'start': '', 'end': '' },
        'updated_by': '',
        'sheetsType': 'complete',
        'limit': 25
    };
    $("#FilterName option").removeClass('filtered');
    $("#Status input").prop('checked', true);
    $("#SheetsType input#Complete").prop('checked', true);
    $("#SheetsType input#Uncomplete").prop('checked', false);
    $("#reportrange span").text('');
    $("#FilterValue").val('');
}

// To Get Data Of Drowing By JopOrderNumber
$('.jopOrderNumber form').submit(function (e) {
    e.preventDefault();
    clearFilter();
    filterOfActualAssembly['jopOrderNumber'] = $('.jopOrderNumber .input').val();
    $("#Limit").attr('data-count-rows', 25);
    GetData(this);
});

// To Make Filter On Data
$('#Filter').click(function () {
    $("#Limit").attr('data-count-rows', 25);
    GetData(this);
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
        let value = [$(this).find('.input').eq(i).val(), ($(this).find('.input').eq(i).attr('data-time') != "" && $(this).find('.input').eq(i).val() != "") ? $(this).find('.input').eq(i).attr('data-time') : ""];
        dataForm[key] = value;
    }
    dataForm['notes'] = [$(this).find('textarea').eq(0).val(), ($(this).find('textarea').eq(0).attr('data-time') != "" && $(this).find('textarea').eq(0).val() != "") ? $(this).find('textarea').eq(0).attr('data-time') : ""];
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
                // Update Actual That Edited
                updateActual(data);

                $('body').css('overflow', 'auto');
                $("#Edit").fadeOut(500);
                $('#Edit .box').css('top', '-600px');
                let dataForm2 = {};
                dataForm2['_token'] = $(that).find('input').eq(0).attr('value');
                dataForm2['jopOrderNumber'] = $('#JopOrderNumber').text();
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').removeClass('error');
                $(that).find('input[name="color2"]').removeClass('error');
                $(that).find('input[name="color3"]').removeClass('error');
                $(that).find('input[name="color4"]').removeClass('error');
                $(that).find('input[name="color5"]').removeClass('error');
                $(that).find('input[name="outerDimMinActual"], input[name="outerDimNomActual"], input[name="outerDimMaxActual"]').removeClass('error');
                $(that).find('input[name="ppTapeSize"], input[name="ppTapeOverLap"]').removeClass('error');
                $(that).find('textarea[name="notes"]').removeClass('error');
            } else if (data == "Error-inputDrum1") {
                $(that).find('input[name="inputDrum1"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="inputDrum1"]')).offset().top - 20;
            } else if (data == "Error-inputCard1") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="inputCard1"]')).offset().top - 20;
            } else if (data == "Error-inputLength1") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="inputLength1"]')).offset().top - 20;
            } else if (data == "Error-color1") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="color1"]')).offset().top - 20;
            } else if (data == "Error-color2") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').removeClass('error');
                $(that).find('input[name="color2"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="color2"]')).offset().top - 20;
            } else if (data == "Error-color3") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').removeClass('error');
                $(that).find('input[name="color2"]').removeClass('error');
                $(that).find('input[name="color3"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="color3"]')).offset().top - 20;
            } else if (data == "Error-color4") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').removeClass('error');
                $(that).find('input[name="color2"]').removeClass('error');
                $(that).find('input[name="color3"]').removeClass('error');
                $(that).find('input[name="color4"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="color4"]')).offset().top - 20;
            } else if (data == "Error-color5") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').removeClass('error');
                $(that).find('input[name="color2"]').removeClass('error');
                $(that).find('input[name="color3"]').removeClass('error');
                $(that).find('input[name="color4"]').removeClass('error');
                $(that).find('input[name="color5"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="color5"]')).offset().top - 20;
            } else if (data == "Error-outerDimActual") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').removeClass('error');
                $(that).find('input[name="color2"]').removeClass('error');
                $(that).find('input[name="color3"]').removeClass('error');
                $(that).find('input[name="color4"]').removeClass('error');
                $(that).find('input[name="color5"]').removeClass('error');
                $(that).find('input[name="outerDimMinActual"], input[name="outerDimNomActual"], input[name="outerDimMaxActual"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="outerDimMinActual"]')).offset().top - 20;
            } else if (data == "Error-ppTape") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').removeClass('error');
                $(that).find('input[name="color2"]').removeClass('error');
                $(that).find('input[name="color3"]').removeClass('error');
                $(that).find('input[name="color4"]').removeClass('error');
                $(that).find('input[name="color5"]').removeClass('error');
                $(that).find('input[name="outerDimMinActual"], input[name="outerDimNomActual"], input[name="outerDimMaxActual"]').removeClass('error');
                $(that).find('input[name="ppTapeSize"], input[name="ppTapeOverLap"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="ppTapeSize"]')).offset().top - 20;
            } else if (data == 'Error-notes') {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').removeClass('error');
                $(that).find('input[name="color2"]').removeClass('error');
                $(that).find('input[name="color3"]').removeClass('error');
                $(that).find('input[name="color4"]').removeClass('error');
                $(that).find('input[name="color5"]').removeClass('error');
                $(that).find('input[name="outerDimMinActual"], input[name="outerDimNomActual"], input[name="outerDimMaxActual"]').removeClass('error');
                $(that).find('input[name="ppTapeSize"], input[name="ppTapeOverLap"]').removeClass('error');
                $(that).find('textarea[name="notes"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
            }



        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
        },
    });

});

// To FadeOut ISO Form After make Click on Close Button
$("#ISO i").click(function () {
    $("#ISO").fadeOut(500);
    $('#ISO .box').css('top', '-600px');
});

// To FadeIn ISO Form 
$("#StartPrint").click(function () {
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    let that = this;
    dataForm = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'sheet': 'Assembly'
    };

    $.ajax({
        url: 'Actual/getISO',
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data[0]);
            let inputs = $('#ISO form').find('.input');
            // console.log(inputs);
            for (let i = 0; i <= inputs.length; i++) {
                $(inputs[i]).val(data[0][$(inputs[i]).attr('name')]);
            }
            $('#ISO').fadeIn(500);
            $('#ISO .box').animate({ top: 0 }, 1000);

        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data);
        }
    });

});

// To Prepare Data And Print It
$("#ISO form").submit(function (e) {
    let that = this;
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    e.preventDefault();

    let dataForm = {};
    let token = $(this).find('input').eq(0).attr('value');
    dataForm['_token'] = token;
    for (let i = 0; i < $(this).find('.input').length; i++) {
        let key = $(this).find('.input').eq(i).attr('name');
        let value = $(this).find('.input').eq(i).val();
        dataForm[key] = value;
    }
    $("#Limit").attr('data-count-rows', 25);
    filterOfActualAssembly['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    dataForm['filter'] = filterOfActualAssembly;

    // console.log(dataForm);

    $.ajax({
        'url': $(this).attr('action'),
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data);

            $("#ISO").fadeOut(500);
            $('#ISO .box').css('top', '-600px');

            let standardRow = data[0][0];
            let actualRows = data[1];
            let iso = data[2][0];
            console.log(data);
            let standardTable = `<div class="standard my-3">
                                             <table class="table w-75 mx-auto my-5 table2">
                                             <tr>
                                             <th>Jop Order Number : </th>
                                             <td id="JopOrderNumber">${standardRow.jopOrderNumber}</td>
                                             <th>Cable Size : </th>
                                             <td>${standardRow.cableSize}</td>
                                             <th>Cable Description : </th>
                                             <td>${standardRow.cableDescription}</td>
                                             <th>Filler / p.p Tape : </th>
                                             <td>${standardRow.fillerStandard + " " + standardRow.twistedStandard}</td>
                                             <th>Over Lap : </th>
                                             <td>${standardRow.overLap}</td>
                                             </tr>
                                             <tr>
                                             <th>Outer Min Dim : </th>
                                             <td>${standardRow.outerDimMinStandard}</td>
                                             <th>Outer Nom Dim : </th>
                                             <td>${standardRow.outerDimNomStandard}</td>
                                             <th>Outer Max Dim : </th>
                                             <td>${standardRow.outerDimMaxStandard}</td>
                                             <th>Lay Length : </th>
                                             <td>${standardRow.layLengthStandard}</td>
                                             <th>Ovality : </th>
                                             <td>${standardRow.ovalityStandard}</td>
                                             </tr>
                                             </table>
                                             </div>`;
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

            let ISORow = `<tr>
                                    <td colspan="27" class="text-center">يعتمد ؛</td>
                                    </tr>
                                    <tr>
                                    <td colspan="6">${iso.material}</td>
                                    <td colspan="5">Duration Of Preservation : ${iso.durationOfPreservation}</td>
                                    <td colspan="5">Modified Date : ${iso.modifiedDate}</td>
                                    <td colspan="5">Issue Date : ${iso.issueDate}</td>
                                    <td colspan="6">Issue Number : ${iso.issueNumber}</td>
                                    </tr>`;

            let tableHeadOfActual = `<thead>
                                                     <tr>
                                                     <th>SN</th>
                                                     <th>Date / Time</th>
                                                     <th>Shift</th>
                                                     <th>Machine</th>
                                                     <th class="text-center" colspan="6">
                                                     Input
                                                     </th>
                                                     <th class="text-center pb-0" colspan="3">
                                                     Output
                                                     <div class="row m-0 mt-2">
                                                     <span class="col-4 p-0 m-0 px-2 text-center">Drum</span>
                                                     <span class="col-4 p-0 m-0 px-2 text-center">Card</span>
                                                     <span class="col-4 p-0 m-0 px-2 text-center">Length</span>
                                                     </div>
                                                     </th>
                                                     <th class="text-center pb-0" colspan="3">
                                                     Outer Dim
                                                     <div class="row m-0 mt-2">
                                                     <span class="col-4 p-0 m-0 px-2 text-center">Min</span>
                                                     <span class="col-4 p-0 m-0 px-2 text-center">Nom</span>
                                                     <span class="col-4 p-0 m-0 px-2 text-center">Min</span>
                                                     </div>
                                                     </th>
                                                     <th>Ovality</th>
                                                     <th class="text-center pb-0" colspan="2">
                                                     Lay Length
                                                     <div class="row m-0 mt-2">
                                                     <span class="col-6 p-0 m-0 px-2 text-center">Length</span>
                                                     <span class="col-6 p-0 m-0 px-2 text-center">Direction</span>
                                                     </div>
                                                     </th>
                                                     <th>Filler</th>
                                                     <th class="text-center pb-0" colspan="2">
                                                     P.P Tape
                                                     <div class="row m-0 mt-2">
                                                     <span class="col-6 p-0 m-0 px-2 text-center">Size</span>
                                                     <span class="col-6 p-0 m-0 px-2 text-center">Over Lab</span>
                                                     </div>
                                                     </th>
                                                     <th>Status</th>
                                                     <th>Production Operator</th>
                                                     <th class="notes">Notes</th>
                                                     <th>Add By</th>
                                                     </tr>
                                                     </thead>`;

            let actuals = ``;
            let printContent = '';



            function createActualRow(i) {

                return `<tr data-id="${actualRows[i].id}">
                <th>${i + 1}</th>
                <td>${actualRows[i].created_at.split(" ").join("<br>")}</td>
                <td>${romanShift(actualRows[i].shift)}</td>
                <td>${(actualRows[i].machine == null) ? '' : actualRows[i].machine}</td>
                <td class="prepareInput">
                <span class="th position-relative">Drum</span>
                <span class="th position-relative">Card</span>
                <span class="th position-relative">Length</span>
                <span class="th position-relative">Color</span>
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].inputDrum1 == null) ? '' : actualRows[i].inputDrum1} </span>
                <span>${(actualRows[i].inputCard1 == null) ? '' : actualRows[i].inputCard1} </span>
                <span>${(actualRows[i].inputLength1 == null) ? '' : actualRows[i].inputLength1} </span>
                <span>${(actualRows[i].color1 == null) ? '' : actualRows[i].color1} </span>
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].inputDrum2 == null) ? '' : actualRows[i].inputDrum2} </span>
                <span>${(actualRows[i].inputCard2 == null) ? '' : actualRows[i].inputCard2} </span>
                <span>${(actualRows[i].inputLength2 == null) ? '' : actualRows[i].inputLength2} </span>
                <span>${(actualRows[i].color2 == null) ? '' : actualRows[i].color2} </span>
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].inputDrum3 == null) ? '' : actualRows[i].inputDrum3} </span>
                <span>${(actualRows[i].inputCard3 == null) ? '' : actualRows[i].inputCard3} </span>
                <span>${(actualRows[i].inputLength3 == null) ? '' : actualRows[i].inputLength3} </span>
                <span>${(actualRows[i].color3 == null) ? '' : actualRows[i].color3} </span>
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].inputDrum4 == null) ? '' : actualRows[i].inputDrum4} </span>
                <span>${(actualRows[i].inputCard4 == null) ? '' : actualRows[i].inputCard4} </span>
                <span>${(actualRows[i].inputLength4 == null) ? '' : actualRows[i].inputLength4} </span>
                <span>${(actualRows[i].color4 == null) ? '' : actualRows[i].color4} </span>
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].inputDrum5 == null) ? '' : actualRows[i].inputDrum5} </span>
                <span>${(actualRows[i].inputCard5 == null) ? '' : actualRows[i].inputCard5} </span>
                <span>${(actualRows[i].inputLength5 == null) ? '' : actualRows[i].inputLength5} </span>
                <span>${(actualRows[i].color5 == null) ? '' : actualRows[i].color5} </span>
                </td>
                <td>${(actualRows[i].outputDrum == null) ? '' : actualRows[i].outputDrum}</td>
                <td>${(actualRows[i].outputCard == null) ? '' : actualRows[i].outputCard}</td>
                <td>${(actualRows[i].outputLength == null) ? '' : actualRows[i].outputLength}</td>
                <td>${(actualRows[i].outerDimMinActual == null) ? '' : actualRows[i].outerDimMinActual}</td>
                <td>${(actualRows[i].outerDimNomActual == null) ? '' : actualRows[i].outerDimNomActual}</td>
                <td>${(actualRows[i].outerDimMaxActual == null) ? '' : actualRows[i].outerDimMaxActual}</td>
                <td>${(actualRows[i].ovalityActual == null) ? '' : actualRows[i].ovalityActual}</td>
                <td  style="min-width: 100px;">${(actualRows[i].layLengthActual == null) ? '' : actualRows[i].layLengthActual}</td>
                <td  style="min-width: 100px;">${(actualRows[i].direction == null) ? '' : actualRows[i].direction}</td>
                <td>${(actualRows[i].fillerActual == null) ? '' : actualRows[i].fillerActual + " " + actualRows[i].twistedActual}</td>
                <td class="assembly" style="min-width: 100px;">${(actualRows[i].ppTapeSize == null) ? '' : actualRows[i].ppTapeSize}</td>
                <td class="assembly" style="min-width: 100px;">${(actualRows[i].ppTapeOverLap == null) ? '' : actualRows[i].ppTapeOverLap}</td>
                <td>${(actualRows[i].status == null) ? '' : actualRows[i].status}</td>
                <td>${(actualRows[i].productionOperator == null) ? '' : actualRows[i].productionOperator}</td>
                <td>${(actualRows[i].notes == null) ? '' : actualRows[i].notes}</td>
                <td>${actualRows[i].added_by}</td>
                </tr>`;
            }


            // Prepare Pages To Print it
            for (let i = 0, j = 1; i < actualRows.length; i++, j++) {
                let actualRow = createActualRow(i);
                if (j % 2 != 0 && j != actualRows.length) {
                    actuals += actualRow;
                } else if (j % 2 == 0) {
                    actuals += actualRow + ISORow;

                    let actualTable = `<div class="actual my-3 stranding">
                                                <table class="table table-hover">
                                                ${tableHeadOfActual}
                                                <tbody>
                                                ${actuals}
                                                </tbody>
                                                </table>
                                                </div>`;

                    let page = '<div class="page">' + pageNav + standardTable + actualTable + '</div>';
                    printContent += page;
                    actuals = ``;
                } else {
                    actuals += actualRow + ISORow;

                    let actualTable = `<div class="actual my-3 stranding">
                                                <table class="table table-hover">
                                                ${tableHeadOfActual}
                                                <tbody>
                                                ${actuals}
                                                </tbody>
                                                </table>
                                                </div>`;

                    let page = '<div class="page">' + pageNav + standardTable + actualTable + '</div>';
                    printContent += page;
                    actuals = ``;
                }

            }

            $('.printContent').html(printContent);
            $('.printContent').printThis();

        },
        'error': function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        },
    });
});





