
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
let filterOfActualCCVInsulation = {
    'jopOrderNumber': '',
    'shift': '',
    'added_by': '',
    'machine': '',
    'inputDrum': '',
    'inputCard': '',
    'inputLength': '',
    'outputDrum': '',
    'outputCard': '',
    'outputLength': '',
    'status': { 'hold': true, 'pass': true },
    'productionOperator': '',
    'periodOfTime': { 'start': '', 'end': '' },
    'notes': false,
    'updated_by': '',
    'sheetsType': 'complete',
    'limit': 25
};

//To Get Data From Filter And Save It At FilterArray
$("#FilterValue").blur(function () {
    filterOfActualCCVInsulation[$("#FilterName").val()] = $(this).val();
    if ($(this).val() != '') {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).addClass('filtered');
    } else {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).removeClass('filtered');
    }
});

// To Make Filter On Data By Period Of Date
$("#reportrange").on('apply.daterangepicker, hide.daterangepicker', function (ev, picker) {
    cb(picker.startDate, picker.endDate);
    filterOfActualCCVInsulation["periodOfTime"]['start'] = $("#reportrange span").attr('data-rangedatestart');
    filterOfActualCCVInsulation["periodOfTime"]['end'] = $("#reportrange span").attr('data-rangedateend');
    $('#FilterName').find(`option[value="periodOfTime"]`).addClass('filtered');
});

// To Get Back All Data After Click On Cancel
$("#reportrange").on('cancel.daterangepicker', function () {
    filterOfActualCCVInsulation["periodOfTime"]['start'] = "";
    filterOfActualCCVInsulation["periodOfTime"]['end'] = "";
    $("#reportrange span").text('');
    $("#reportrange span").attr('data-rangedatestart', '');
    $("#reportrange span").attr('data-rangedateend', '');
    $('#FilterName').find(`option[value="periodOfTime"]`).removeClass('filtered');
});

$("#FilterName").change(function () {
    if ($(this).val() == "periodOfTime") {
        $(this).attr('data-last-selected', $(this).val());
        $("#reportrange span").text(`${filterOfActualCCVInsulation["periodOfTime"]['start']} - ${filterOfActualCCVInsulation["periodOfTime"]['end']}`);
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
            filterOfActualCCVInsulation['notes'] = false;
            $('#FilterName').find(`option[value="notes"]`).removeClass('filtered');
        } else {
            filterOfActualCCVInsulation['notes'] = true;
            $('#FilterName').find(`option[value="notes"]`).addClass('filtered');
        }
    } else {
        $(this).attr('data-last-selected', $(this).val());
        $("#FilterValue").val(filterOfActualCCVInsulation[$(this).val()]);
        $('#reportrange').css('display', 'none');
        $("#FilterValue").css('display', 'block');
        $("#SheetsType").css('display', 'none');
        $("#Status").css('display', 'none');
    }
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
    filterOfActualCCVInsulation['sheetsType'] = ($(that).prop('checked')) ? $(that).attr('name') : $('#SheetsType input').not(that).attr('name');

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

    filterOfActualCCVInsulation['status']['hold'] = $('input#Hold').prop('checked');
    filterOfActualCCVInsulation['status']['pass'] = $('input#Pass').prop('checked');

    if ($('input#Hold').prop('checked') && $('input#Pass').prop('checked')) {
        $('#FilterName').find(`option[value="status"]`).removeClass('filtered');
    } else {
        $('#FilterName').find(`option[value="status"]`).addClass('filtered');
    }

}

//Function To add Time OF Every input insert
$('#Edit .input').blur(function () {
    let date = new Date().toLocaleString();
    $(this).attr('data-time', date);
});

// Function To Get Data Of Insulation By JopOrderNumber
function GetData(that, moreData = false) {
    $(that).prop('disabled', true);
    $(that).find('button[type="submit"]').prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    filterOfActualCCVInsulation['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    if (filterOfActualCCVInsulation['sheetsType'] == "uncomplete") {
        $("#Limit").attr('data-count-rows', 25);
        filterOfActualCCVInsulation['limit'] = 25;
    }
    dataForm['filter'] = filterOfActualCCVInsulation;
    // console.log(dataForm);
    $.ajax({
        'url': 'Actual',
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            $(that).prop('disabled', false);
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            let standardRow = data[0][0];
            let actualRows = data[1];
            let actualTimeRows = data[2];
            let countOfActualsRows = data[3];
            if (countOfActualsRows > filterOfActualCCVInsulation['limit']) {
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

            // console.log(data);
            // return 0;


            $('#Data .standard table').html(`<tr>
                                             <th>Jop Order Number : </th>
                                             <td id="JopOrderNumber">${standardRow.jopOrderNumber}</td>
                                             <th>Size : </th>
                                             <td>${standardRow.size}</td>
                                             <th>Description : </th>
                                             <td>${standardRow.description}</td>
                                             <th>Dim After : </th>
                                             <td>${standardRow.dimAfter}</td>
                                             <th>Thickness Min ISC : </th>
                                             <td>${standardRow.thicknessMinISC}</td>
                                             </tr>
                                             <tr>
                                             <th>Thickness Min INS : </th>
                                             <td>${standardRow.thicknessMinINS}</td>
                                             <th>Thickness Min OSC : </th>
                                             <td>${standardRow.thicknessMinOSC}</td>
                                             <th>Thickness Nom ISC : </th>
                                             <td>${standardRow.thicknessNomISC}</td>
                                             <th>Thickness Nom INS : </th>
                                             <td>${standardRow.thicknessNomINS}</td>
                                             <th>Thickness Nom OSC : </th>
                                             <td>${standardRow.thicknessNomOSC}</td>
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
                    <th>${(filterOfActualCCVInsulation['limit'] - 24) + i}</th>
                    <td>${actualRows[i].created_at.split(" ").join("<br>")}</td>
                    <td>${romanShift(actualRows[i].shift)}</td>
                    <td>${actualRows[i].added_by}</td>
                    <td>${(actualRows[i].machine == null) ? '' : actualRows[i].machine} <abbr title="${actualTimeRows[i].machine_time}"><i class="fas fa-stopwatch ${(actualRows[i].machine == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].inputDrum == null) ? '' : actualRows[i].inputDrum} <abbr title="${actualTimeRows[i].inputDrum_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputDrum == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].inputCard == null) ? '' : actualRows[i].inputCard} <abbr title="${actualTimeRows[i].inputCard_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputCard == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].inputLength == null) ? '' : actualRows[i].inputLength} <abbr title="${actualTimeRows[i].inputLength_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputLength == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].outputDrum == null) ? '' : actualRows[i].outputDrum} <abbr title="${actualTimeRows[i].outputDrum_time}"><i class="fas fa-stopwatch ${(actualRows[i].outputDrum == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].outputCard == null) ? '' : actualRows[i].outputCard} <abbr title="${actualTimeRows[i].outputCard_time}"><i class="fas fa-stopwatch ${(actualRows[i].outputCard == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].outputLength == null) ? '' : actualRows[i].outputLength} <abbr title="${actualTimeRows[i].outputLength_time}"><i class="fas fa-stopwatch ${(actualRows[i].outputLength == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].thicknessISCStartMin == null) ? '' : actualRows[i].thicknessISCStartMin} <abbr title="${actualTimeRows[i].thicknessISCStartMin_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessISCStartMin == null) ? 'd-none' : ''}"></i></abbr></span> 
                    <span style="border-bottom : none;">${(actualRows[i].thicknessISCEndMin == null) ? '' : actualRows[i].thicknessISCEndMin} <abbr title="${actualTimeRows[i].thicknessISCEndMin_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessISCEndMin == null) ? 'd-none' : ''}"></i></abbr> </span> 
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].thicknessISCStartNom == null) ? '' : actualRows[i].thicknessISCStartNom} <abbr title="${actualTimeRows[i].thicknessISCStartNom_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessISCStartNom == null) ? 'd-none' : ''}"></i></abbr></span> 
                    <span style="border-bottom : none;">${(actualRows[i].thicknessISCEndNom == null) ? '' : actualRows[i].thicknessISCEndNom} <abbr title="${actualTimeRows[i].thicknessISCEndNom_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessISCEndNom == null) ? 'd-none' : ''}"></i></abbr> </span> 
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].thicknessISCStartMax == null) ? '' : actualRows[i].thicknessISCStartMax} <abbr title="${actualTimeRows[i].thicknessISCStartMax_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessISCStartMax == null) ? 'd-none' : ''}"></i></abbr></span> 
                    <span style="border-bottom : none;">${(actualRows[i].thicknessISCEndMax == null) ? '' : actualRows[i].thicknessISCEndMax} <abbr title="${actualTimeRows[i].thicknessISCEndMax_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessISCEndMax == null) ? 'd-none' : ''}"></i></abbr> </span> 
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].thicknessINSStartMin == null) ? '' : actualRows[i].thicknessINSStartMin} <abbr title="${actualTimeRows[i].thicknessINSStartMin_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessINSStartMin == null) ? 'd-none' : ''}"></i></abbr></span> 
                    <span style="border-bottom : none;">${(actualRows[i].thicknessINSEndMin == null) ? '' : actualRows[i].thicknessINSEndMin} <abbr title="${actualTimeRows[i].thicknessINSEndMin_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessINSEndMin == null) ? 'd-none' : ''}"></i></abbr> </span> 
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].thicknessINSStartNom == null) ? '' : actualRows[i].thicknessINSStartNom} <abbr title="${actualTimeRows[i].thicknessINSStartNom_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessINSStartNom == null) ? 'd-none' : ''}"></i></abbr></span> 
                    <span style="border-bottom : none;">${(actualRows[i].thicknessINSEndNom == null) ? '' : actualRows[i].thicknessINSEndNom} <abbr title="${actualTimeRows[i].thicknessINSEndNom_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessINSEndNom == null) ? 'd-none' : ''}"></i></abbr> </span> 
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].thicknessINSStartMax == null) ? '' : actualRows[i].thicknessINSStartMax} <abbr title="${actualTimeRows[i].thicknessINSStartMax_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessINSStartMax == null) ? 'd-none' : ''}"></i></abbr></span> 
                    <span style="border-bottom : none;">${(actualRows[i].thicknessINSEndMax == null) ? '' : actualRows[i].thicknessINSEndMax} <abbr title="${actualTimeRows[i].thicknessINSEndMax_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessINSEndMax == null) ? 'd-none' : ''}"></i></abbr> </span> 
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].thicknessOSCStartMin == null) ? '' : actualRows[i].thicknessOSCStartMin} <abbr title="${actualTimeRows[i].thicknessOSCStartMin_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessOSCStartMin == null) ? 'd-none' : ''}"></i></abbr></span> 
                    <span style="border-bottom : none;">${(actualRows[i].thicknessOSCEndMin == null) ? '' : actualRows[i].thicknessOSCEndMin} <abbr title="${actualTimeRows[i].thicknessOSCEndMin_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessOSCEndMin == null) ? 'd-none' : ''}"></i></abbr> </span> 
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].thicknessOSCStartNom == null) ? '' : actualRows[i].thicknessOSCStartNom} <abbr title="${actualTimeRows[i].thicknessOSCStartNom_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessOSCStartNom == null) ? 'd-none' : ''}"></i></abbr></span> 
                    <span style="border-bottom : none;">${(actualRows[i].thicknessOSCEndNom == null) ? '' : actualRows[i].thicknessOSCEndNom} <abbr title="${actualTimeRows[i].thicknessOSCEndNom_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessOSCEndNom == null) ? 'd-none' : ''}"></i></abbr> </span> 
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].thicknessOSCStartMax == null) ? '' : actualRows[i].thicknessOSCStartMax} <abbr title="${actualTimeRows[i].thicknessOSCStartMax_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessOSCStartMax == null) ? 'd-none' : ''}"></i></abbr></span> 
                    <span style="border-bottom : none;">${(actualRows[i].thicknessOSCEndMax == null) ? '' : actualRows[i].thicknessOSCEndMax} <abbr title="${actualTimeRows[i].thicknessOSCEndMax_time}"><i class="fas fa-stopwatch ${(actualRows[i].thicknessOSCEndMax == null) ? 'd-none' : ''}"></i></abbr> </span> 
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].dimBefore1 == null) ? '' : actualRows[i].dimBefore1}  <abbr title="${actualTimeRows[i].dimBefore1_time}"><i class="fas fa-stopwatch ${(actualRows[i].dimBefore1 == null) ? 'd-none' : ''}"></i></abbr></span> 
                    <span style="border-bottom : none;">${(actualRows[i].dimBefore2 == null) ? '' : actualRows[i].dimBefore2}  <abbr title="${actualTimeRows[i].dimBefore2_time}"><i class="fas fa-stopwatch ${(actualRows[i].dimBefore2 == null) ? 'd-none' : ''}"></i></abbr></span>
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].dimAfterStartMin == null) ? '' : actualRows[i].dimAfterStartMin} <abbr title="${actualTimeRows[i].dimAfterStartMinActua}"><i class="fas fa-stopwatch ${(actualRows[i].dimAfterStartMin == null) ? 'd-none' : ''}"></i></abbr></span> 
                    <span style="border-bottom : none;">${(actualRows[i].dimAfterEndMin == null) ? '' : actualRows[i].dimAfterEndMin} <abbr title="${actualTimeRows[i].dimAfterEndMinActua}"><i class="fas fa-stopwatch ${(actualRows[i].dimAfterEndMin == null) ? 'd-none' : ''}"></i></abbr> </span> 
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].dimAfterStartNom == null) ? '' : actualRows[i].dimAfterStartNom} <abbr title="${actualTimeRows[i].dimAfterStartNomActua}"><i class="fas fa-stopwatch ${(actualRows[i].dimAfterStartNom == null) ? 'd-none' : ''}"></i></abbr></span> 
                    <span style="border-bottom : none;">${(actualRows[i].dimAfterEndNom == null) ? '' : actualRows[i].dimAfterEndNom} <abbr title="${actualTimeRows[i].dimAfterEndNomActua}"><i class="fas fa-stopwatch ${(actualRows[i].dimAfterEndNom == null) ? 'd-none' : ''}"></i></abbr> </span> 
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].dimAfterStartMax == null) ? '' : actualRows[i].dimAfterStartMax} <abbr title="${actualTimeRows[i].dimAfterStartMaxActua}"><i class="fas fa-stopwatch ${(actualRows[i].dimAfterStartMax == null) ? 'd-none' : ''}"></i></abbr></span> 
                    <span style="border-bottom : none;">${(actualRows[i].dimAfterEndMax == null) ? '' : actualRows[i].dimAfterEndMax} <abbr title="${actualTimeRows[i].dimAfterEndMaxActua}"><i class="fas fa-stopwatch ${(actualRows[i].dimAfterEndMax == null) ? 'd-none' : ''}"></i></abbr> </span> 
                    </td>
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
                $('#FilterValue, #FilterName, #Filter').prop('disabled', false);
            } else {
                $('#FilterValue, #FilterName, #Filter').prop('disabled', true);
            }

            if (filterOfActualCCVInsulation['sheetsType'] == 'complete') {
                $('#StartPrint').prop('disabled', false);
            } else {
                $('#StartPrint').prop('disabled', true);
            }

            $('.jopOrderNumber .input').val('');

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
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            $(`.sheets .actual tbody tr[data-id="${rowId}"]`).remove();

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
            $(inputs).not('#Edit input[name="dimBefore2"], #Edit textarea').prop('required', (filterOfActualCCVInsulation['sheetsType'] == 'complete'));

            // To Preper Data Of CCVInsulationActual

            let CCVInsulationActual_id = actualRow['id'];

            delete actualRow['id'];
            delete actualRow['jopOrderNumber_id'];
            delete actualRow['jopOrderNumber'];
            delete actualRow['added_by'];
            delete actualRow['shift'];
            delete actualRow['updated_by'];
            delete actualRow['created_at'];
            delete actualRow['updated_at'];

            delete actualTimeRow['id'];
            delete actualTimeRow['CCVInsulationactuals_id'];
            delete actualTimeRow['added_by'];
            delete actualTimeRow['shift'];
            delete actualTimeRow['updated_by'];
            delete actualTimeRow['created_at'];
            delete actualTimeRow['updated_at'];

            for (let key in actualRow) {
                let currentInput = $(inputs).filter(`[name="${key}"]`);
                currentInput.val(actualRow[key]);
                currentInput.attr('data-time', actualTimeRow[key + '_time']);
            }

            $('body').css('overflow', 'hidden');
            $("#Edit form").attr('data-id', CCVInsulationActual_id);
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
    let actualRow = data[0];
    let actualRowTime = data[1];
    let i = $(`#Data .actual .table tbody tr[data-id="${actualRow.id}"]`).index() + 1;

    $(`#Data .actual .table tbody tr[data-id="${actualRow.id}"]`).html(`
                <th>${i}</th>
                <td>${actualRow.created_at}</td>
                <td>${actualRow.created_at.split(" ").join("<br>")}</td>
                <td>${romanShift(actualRow.shift)}</td>
                <td>${(actualRow.machine == null) ? '' : actualRow.machine} <abbr title="${actualRowTime.machine_time}"><i class="fas fa-stopwatch ${(actualRow.machine == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.inputDrum == null) ? '' : actualRow.inputDrum} <abbr title="${actualRowTime.inputDrum_time}"><i class="fas fa-stopwatch ${(actualRow.inputDrum == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.inputCard == null) ? '' : actualRow.inputCard} <abbr title="${actualRowTime.inputCard_time}"><i class="fas fa-stopwatch ${(actualRow.inputCard == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.inputLength == null) ? '' : actualRow.inputLength} <abbr title="${actualRowTime.inputLength_time}"><i class="fas fa-stopwatch ${(actualRow.inputLength == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.outputDrum == null) ? '' : actualRow.outputDrum} <abbr title="${actualRowTime.outputDrum_time}"><i class="fas fa-stopwatch ${(actualRow.outputDrum == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.outputCard == null) ? '' : actualRow.outputCard} <abbr title="${actualRowTime.outputCard_time}"><i class="fas fa-stopwatch ${(actualRow.outputCard == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.outputLength == null) ? '' : actualRow.outputLength} <abbr title="${actualRowTime.outputLength_time}"><i class="fas fa-stopwatch ${(actualRow.outputLength == null) ? 'd-none' : ''}"></i></abbr></td>
                <td class="prepareInput">
                <span>${(actualRow.thicknessISCStartMin == null) ? '' : actualRow.thicknessISCStartMin} <abbr title="${actualRowTime.thicknessISCStartMin_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessISCStartMin == null) ? 'd-none' : ''}"></i></abbr></span> 
                <span style="border-bottom : none;">${(actualRow.thicknessISCEndMin == null) ? '' : actualRow.thicknessISCEndMin} <abbr title="${actualRowTime.thicknessISCEndMin_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessISCEndMin == null) ? 'd-none' : ''}"></i></abbr> </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRow.thicknessISCStartNom == null) ? '' : actualRow.thicknessISCStartNom} <abbr title="${actualRowTime.thicknessISCStartNom_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessISCStartNom == null) ? 'd-none' : ''}"></i></abbr></span> 
                <span style="border-bottom : none;">${(actualRow.thicknessISCEndNom == null) ? '' : actualRow.thicknessISCEndNom} <abbr title="${actualRowTime.thicknessISCEndNom_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessISCEndNom == null) ? 'd-none' : ''}"></i></abbr> </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRow.thicknessISCStartMax == null) ? '' : actualRow.thicknessISCStartMax} <abbr title="${actualRowTime.thicknessISCStartMax_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessISCStartMax == null) ? 'd-none' : ''}"></i></abbr></span> 
                <span style="border-bottom : none;">${(actualRow.thicknessISCEndMax == null) ? '' : actualRow.thicknessISCEndMax} <abbr title="${actualRowTime.thicknessISCEndMax_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessISCEndMax == null) ? 'd-none' : ''}"></i></abbr> </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRow.thicknessINSStartMin == null) ? '' : actualRow.thicknessINSStartMin} <abbr title="${actualRowTime.thicknessINSStartMin_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessINSStartMin == null) ? 'd-none' : ''}"></i></abbr></span> 
                <span style="border-bottom : none;">${(actualRow.thicknessINSEndMin == null) ? '' : actualRow.thicknessINSEndMin} <abbr title="${actualRowTime.thicknessINSEndMin_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessINSEndMin == null) ? 'd-none' : ''}"></i></abbr> </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRow.thicknessINSStartNom == null) ? '' : actualRow.thicknessINSStartNom} <abbr title="${actualRowTime.thicknessINSStartNom_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessINSStartNom == null) ? 'd-none' : ''}"></i></abbr></span> 
                <span style="border-bottom : none;">${(actualRow.thicknessINSEndNom == null) ? '' : actualRow.thicknessINSEndNom} <abbr title="${actualRowTime.thicknessINSEndNom_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessINSEndNom == null) ? 'd-none' : ''}"></i></abbr> </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRow.thicknessINSStartMax == null) ? '' : actualRow.thicknessINSStartMax} <abbr title="${actualRowTime.thicknessINSStartMax_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessINSStartMax == null) ? 'd-none' : ''}"></i></abbr></span> 
                <span style="border-bottom : none;">${(actualRow.thicknessINSEndMax == null) ? '' : actualRow.thicknessINSEndMax} <abbr title="${actualRowTime.thicknessINSEndMax_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessINSEndMax == null) ? 'd-none' : ''}"></i></abbr> </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRow.thicknessOSCStartMin == null) ? '' : actualRow.thicknessOSCStartMin} <abbr title="${actualRowTime.thicknessOSCStartMin_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessOSCStartMin == null) ? 'd-none' : ''}"></i></abbr></span> 
                <span style="border-bottom : none;">${(actualRow.thicknessOSCEndMin == null) ? '' : actualRow.thicknessOSCEndMin} <abbr title="${actualRowTime.thicknessOSCEndMin_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessOSCEndMin == null) ? 'd-none' : ''}"></i></abbr> </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRow.thicknessOSCStartNom == null) ? '' : actualRow.thicknessOSCStartNom} <abbr title="${actualRowTime.thicknessOSCStartNom_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessOSCStartNom == null) ? 'd-none' : ''}"></i></abbr></span> 
                <span style="border-bottom : none;">${(actualRow.thicknessOSCEndNom == null) ? '' : actualRow.thicknessOSCEndNom} <abbr title="${actualRowTime.thicknessOSCEndNom_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessOSCEndNom == null) ? 'd-none' : ''}"></i></abbr> </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRow.thicknessOSCStartMax == null) ? '' : actualRow.thicknessOSCStartMax} <abbr title="${actualRowTime.thicknessOSCStartMax_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessOSCStartMax == null) ? 'd-none' : ''}"></i></abbr></span> 
                <span style="border-bottom : none;">${(actualRow.thicknessOSCEndMax == null) ? '' : actualRow.thicknessOSCEndMax} <abbr title="${actualRowTime.thicknessOSCEndMax_time}"><i class="fas fa-stopwatch ${(actualRow.thicknessOSCEndMax == null) ? 'd-none' : ''}"></i></abbr> </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRow.dimBefore1 == null) ? '' : actualRow.dimBefore1}  <abbr title="${actualRowTime.dimBefore1_time}"><i class="fas fa-stopwatch ${(actualRow.dimBefore1 == null) ? 'd-none' : ''}"></i></abbr></span> 
                <span style="border-bottom : none;">${(actualRow.dimBefore2 == null) ? '' : actualRow.dimBefore2}  <abbr title="${actualRowTime.dimBefore2_time}"><i class="fas fa-stopwatch ${(actualRow.dimBefore2 == null) ? 'd-none' : ''}"></i></abbr></span>
                </td>
                <td class="prepareInput">
                <span>${(actualRow.dimAfterStartMin == null) ? '' : actualRow.dimAfterStartMin} <abbr title="${actualRowTime.dimAfterStartMinActua}"><i class="fas fa-stopwatch ${(actualRow.dimAfterStartMin == null) ? 'd-none' : ''}"></i></abbr></span> 
                <span style="border-bottom : none;">${(actualRow.dimAfterEndMin == null) ? '' : actualRow.dimAfterEndMin} <abbr title="${actualRowTime.dimAfterEndMinActua}"><i class="fas fa-stopwatch ${(actualRow.dimAfterEndMin == null) ? 'd-none' : ''}"></i></abbr> </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRow.dimAfterStartNom == null) ? '' : actualRow.dimAfterStartNom} <abbr title="${actualRowTime.dimAfterStartNomActua}"><i class="fas fa-stopwatch ${(actualRow.dimAfterStartNom == null) ? 'd-none' : ''}"></i></abbr></span> 
                <span style="border-bottom : none;">${(actualRow.dimAfterEndNom == null) ? '' : actualRow.dimAfterEndNom} <abbr title="${actualRowTime.dimAfterEndNomActua}"><i class="fas fa-stopwatch ${(actualRow.dimAfterEndNom == null) ? 'd-none' : ''}"></i></abbr> </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRow.dimAfterStartMax == null) ? '' : actualRow.dimAfterStartMax} <abbr title="${actualRowTime.dimAfterStartMaxActua}"><i class="fas fa-stopwatch ${(actualRow.dimAfterStartMax == null) ? 'd-none' : ''}"></i></abbr></span> 
                <span style="border-bottom : none;">${(actualRow.dimAfterEndMax == null) ? '' : actualRow.dimAfterEndMax} <abbr title="${actualRowTime.dimAfterEndMaxActua}"><i class="fas fa-stopwatch ${(actualRow.dimAfterEndMax == null) ? 'd-none' : ''}"></i></abbr> </span> 
                </td>
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
    filterOfActualCCVInsulation = {
        'jopOrderNumber': '',
        'shift': '',
        'added_by': '',
        'machine': '',
        'inputDrum': '',
        'inputCard': '',
        'inputLength': '',
        'outputDrum': '',
        'outputCard': '',
        'outputLength': '',
        'status': { 'hold': true, 'pass': true },
        'productionOperator': '',
        'periodOfTime': { 'start': '', 'end': '' },
        'notes': false,
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
    $("#Limit").attr('data-count-rows', 25);
    filterOfActualCCVInsulation['jopOrderNumber'] = $('.jopOrderNumber .input').val();
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
    console.log(dataForm);
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: dataForm,
        success: function (data) {
            // console.log(data);
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
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSEndMin"] , input[name="thicknessINSEndNom"], input[name="thicknessINSEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCEndMin"] , input[name="thicknessOSCEndNom"], input[name="thicknessOSCEndMax"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
                $(that).find('textarea[name="notes"]').removeClass('error');
            } else if (data == 'Error-thicknessISCStart') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="thicknessISCStartMin"]')).offset().top - 20;
            } else if (data == 'Error-thicknessINSStart') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="thicknessINSStartMin"]')).offset().top - 20;
            } else if (data == 'Error-thicknessOSCStart') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="thicknessOSCStartMin"]')).offset().top - 20;
            } else if (data == 'Error-thicknessISCEnd') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="thicknessISCEndMin"]')).offset().top - 20;
            } else if (data == 'Error-thicknessINSEnd') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSEndMin"] , input[name="thicknessINSEndNom"], input[name="thicknessINSEndMax"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="thicknessINSEndMin"]')).offset().top - 20;
            } else if (data == 'Error-thicknessOSCEnd') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSEndMin"] , input[name="thicknessINSEndNom"], input[name="thicknessINSEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCEndMin"] , input[name="thicknessOSCEndNom"], input[name="thicknessOSCEndMax"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="thicknessOSCEndMin"]')).offset().top - 20;
            } else if (data == 'Error-dimAfterStart') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSEndMin"] , input[name="thicknessINSEndNom"], input[name="thicknessINSEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCEndMin"] , input[name="thicknessOSCEndNom"], input[name="thicknessOSCEndMax"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="dimAfterStartMin"]')).offset().top - 20;
            } else if (data == 'Error-dimAfterEnd') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSEndMin"] , input[name="thicknessINSEndNom"], input[name="thicknessINSEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCEndMin"] , input[name="thicknessOSCEndNom"], input[name="thicknessOSCEndMax"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="dimAfterEndMin"]')).offset().top - 20;
            } else if (data == 'Error-notes') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSEndMin"] , input[name="thicknessINSEndNom"], input[name="thicknessINSEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCEndMin"] , input[name="thicknessOSCEndNom"], input[name="thicknessOSCEndMax"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
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
    let that = this;
    $(this).prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    dataForm = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'sheet': 'Insulation'
    };

    $.ajax({
        url: 'Actual/getISO',
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).prop('disabled', false);
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
            $(that).prop('disabled', true);
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
    filterOfActualCCVInsulation['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    dataForm['filter'] = filterOfActualCCVInsulation;

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
            let standardTable = ` <div class="standard my-3">
                                  <table class="table w-75 mx-auto my-3 table2">
                                  <tr>
                                  <th>Jop Order Number : </th>
                                  <td id="JopOrderNumber">${standardRow.jopOrderNumber}</td>
                                  <th>Size : </th>
                                  <td>${standardRow.size}</td>
                                  <th>Description : </th>
                                  <td>${standardRow.description}</td>
                                  <th>Dim After : </th>
                                  <td>${standardRow.dimAfter}</td>
                                  <th>Thickness Min ISC : </th>
                                  <td>${standardRow.thicknessMinISC}</td>
                                  </tr>
                                  <tr>
                                  <th>Thickness Min INS : </th>
                                  <td>${standardRow.thicknessMinINS}</td>
                                  <th>Thickness Min OSC : </th>
                                  <td>${standardRow.thicknessMinOSC}</td>
                                  <th>Thickness Nom ISC : </th>
                                  <td>${standardRow.thicknessNomISC}</td>
                                  <th>Thickness Nom INS : </th>
                                  <td>${standardRow.thicknessNomINS}</td>
                                  <th>Thickness Nom OSC : </th>
                                  <td>${standardRow.thicknessNomOSC}</td>
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
                                    <td colspan="5">${iso.material}</td>
                                    <td colspan="6">Duration Of Preservation : ${iso.durationOfPreservation}</td>
                                    <td colspan="5">Modified Date : ${iso.modifiedDate}</td>
                                    <td colspan="6">Issue Date : ${iso.issueDate}</td>
                                    <td colspan="5">Issue Number : ${iso.issueNumber}</td>
                                    </tr>`;

            let tableHeadOfActual = `<thead>
                                     <tr>
                                     <th>SN</th>
                                     <th>Date / Time</th>
                                     <th>Shift</th>
                                     <th>Machine</th>
                                     <th class="text-center pb-0 threeColumns" colspan="3">
                                     Input
                                     <div class="row m-0 mt-2">
                                     <span class="col-4 p-0 m-0 px-2 text-center">Drum</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Card</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Length</span>
                                     </div>
                                     </th>
                                     <th class="text-center pb-0 threeColumns" colspan="3">
                                     Output
                                     <div class="row m-0 mt-2">
                                     <span class="col-4 p-0 m-0 px-2 text-center">Drum</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Card</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Length</span>
                                     </div>
                                     </th>
                                     <th class="text-center pb-0 threeColumns" colspan="3">
                                     Thickness ISC
                                     <div class="row m-0 mt-2">
                                     <span class="col-4 p-0 m-0 px-2 text-center">Min</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Nom</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Max</span>
                                     </div>
                                     </th>
                                     <th class="text-center pb-0 threeColumns" colspan="3">
                                     Thickness INS
                                     <div class="row m-0 mt-2">
                                     <span class="col-4 p-0 m-0 px-2 text-center">Min</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Nom</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Max</span>
                                     </div>
                                     </th>
                                     <th class="text-center pb-0 threeColumns" colspan="3">
                                     Thickness OSC
                                     <div class="row m-0 mt-2">
                                     <span class="col-4 p-0 m-0 px-2 text-center">Min</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Nom</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Max</span>
                                     </div>
                                     </th>
                                     <th>Dim Before</th>
                                     <th class="text-center pb-0 threeColumns" colspan="3">
                                     Dim After
                                     <div class="row m-0 mt-2">
                                     <span class="col-4 p-0 m-0 px-2 text-center">Min</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Nom</span>
                                     <span class="col-4 p-0 m-0 px-2 text-center">Min</span>
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
                <td>${(actualRows[i].inputDrum == null) ? '' : actualRows[i].inputDrum}</td>
                <td>${(actualRows[i].inputCard == null) ? '' : actualRows[i].inputCard}</td>
                <td>${(actualRows[i].inputLength == null) ? '' : actualRows[i].inputLength}</td>
                <td>${(actualRows[i].outputDrum == null) ? '' : actualRows[i].outputDrum}</td>
                <td>${(actualRows[i].outputCard == null) ? '' : actualRows[i].outputCard}</td>
                <td>${(actualRows[i].outputLength == null) ? '' : actualRows[i].outputLength}</td>
                <td class="prepareInput">
                <span>${(actualRows[i].thicknessISCStartMin == null) ? '' : actualRows[i].thicknessISCStartMin}</span> 
                <span style="border-bottom : none;">${(actualRows[i].thicknessISCEndMin == null) ? '' : actualRows[i].thicknessISCEndMin} </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].thicknessISCStartNom == null) ? '' : actualRows[i].thicknessISCStartNom}</span> 
                <span style="border-bottom : none;">${(actualRows[i].thicknessISCEndNom == null) ? '' : actualRows[i].thicknessISCEndNom} </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].thicknessISCStartMax == null) ? '' : actualRows[i].thicknessISCStartMax}</span> 
                <span style="border-bottom : none;">${(actualRows[i].thicknessISCEndMax == null) ? '' : actualRows[i].thicknessISCEndMax} </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].thicknessINSStartMin == null) ? '' : actualRows[i].thicknessINSStartMin}</span> 
                <span style="border-bottom : none;">${(actualRows[i].thicknessINSEndMin == null) ? '' : actualRows[i].thicknessINSEndMin} </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].thicknessINSStartNom == null) ? '' : actualRows[i].thicknessINSStartNom}</span> 
                <span style="border-bottom : none;">${(actualRows[i].thicknessINSEndNom == null) ? '' : actualRows[i].thicknessINSEndNom} </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].thicknessINSStartMax == null) ? '' : actualRows[i].thicknessINSStartMax}</span> 
                <span style="border-bottom : none;">${(actualRows[i].thicknessINSEndMax == null) ? '' : actualRows[i].thicknessINSEndMax} </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].thicknessOSCStartMin == null) ? '' : actualRows[i].thicknessOSCStartMin}</span> 
                <span style="border-bottom : none;">${(actualRows[i].thicknessOSCEndMin == null) ? '' : actualRows[i].thicknessOSCEndMin} </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].thicknessOSCStartNom == null) ? '' : actualRows[i].thicknessOSCStartNom}</span> 
                <span style="border-bottom : none;">${(actualRows[i].thicknessOSCEndNom == null) ? '' : actualRows[i].thicknessOSCEndNom} </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].thicknessOSCStartMax == null) ? '' : actualRows[i].thicknessOSCStartMax}</span> 
                <span style="border-bottom : none;">${(actualRows[i].thicknessOSCEndMax == null) ? '' : actualRows[i].thicknessOSCEndMax} </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].dimBefore1 == null) ? '' : actualRows[i].dimBefore1} </span> 
                <span style="border-bottom : none;">${(actualRows[i].dimBefore2 == null) ? '' : actualRows[i].dimBefore2} </span>
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].dimAfterStartMin == null) ? '' : actualRows[i].dimAfterStartMin}</span> 
                <span style="border-bottom : none;">${(actualRows[i].dimAfterEndMin == null) ? '' : actualRows[i].dimAfterEndMin} </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].dimAfterStartNom == null) ? '' : actualRows[i].dimAfterStartNom}</span> 
                <span style="border-bottom : none;">${(actualRows[i].dimAfterEndNom == null) ? '' : actualRows[i].dimAfterEndNom} </span> 
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].dimAfterStartMax == null) ? '' : actualRows[i].dimAfterStartMax}</span> 
                <span style="border-bottom : none;">${(actualRows[i].dimAfterEndMax == null) ? '' : actualRows[i].dimAfterEndMax} </span> 
                </td>
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

                    let actualTable = `<div class="actual my-3 insulation">
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

                    let actualTable = `<div class="actual my-3 insulation">
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





