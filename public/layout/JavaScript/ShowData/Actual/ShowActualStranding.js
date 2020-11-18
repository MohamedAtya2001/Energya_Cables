
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
let filterOfActualStranding = {
    'jopOrderNumber': '',
    'subJopOrderNumber': '',
    'shift': '',
    'added_by': '',
    'machine': '',
    'angel': '',
    'shape': '',
    'inputCard': '',
    'drumNumber': '',
    'outputCard': '',
    'length': '',
    'constructionActual': '',
    'conductorDimActual_HS': '',
    'conductorDimActual_FI': '',
    'conductorWeightActual': '',
    'resistanceAtLength': { 'resistance': '', 'length': '' },
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
    filterOfActualStranding[$("#FilterName").val()] = $(this).val();
    if ($(this).val() != '') {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).addClass('filtered');
    } else {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).removeClass('filtered');
    }

    if ($("#FilterName").val() == "conductorDimActual_HS") {
        if (filterOfActualStranding['conductorDimActual_HS'] != '') {
            filterOfActualStranding['conductorDimActual_FI'] = '+';
        } else {
            filterOfActualStranding['conductorDimActual_FI'] = '';
        }
    } else if ($("#FilterName").val() == "conductorDimActual_FI") {
        if (filterOfActualStranding['conductorDimActual_FI'] != '') {
            filterOfActualStranding['conductorDimActual_HS'] = '+';
        } else {
            filterOfActualStranding['conductorDimActual_HS'] = '';
        }
    }
});

// To Make Filter On Data By Period Of Date
$("#reportrange").on('apply.daterangepicker, hide.daterangepicker', function (ev, picker) {
    cb(picker.startDate, picker.endDate);
    filterOfActualStranding["periodOfTime"]['start'] = $("#reportrange span").attr('data-rangedatestart');
    filterOfActualStranding["periodOfTime"]['end'] = $("#reportrange span").attr('data-rangedateend');
    $('#FilterName').find(`option[value="periodOfTime"]`).addClass('filtered');
});

// To Get Back All Data After Click On Cancel
$("#reportrange").on('cancel.daterangepicker', function () {
    filterOfActualStranding["periodOfTime"]['start'] = "";
    filterOfActualStranding["periodOfTime"]['end'] = "";
    $("#reportrange span").text('');
    $("#reportrange span").attr('data-rangedatestart', '');
    $("#reportrange span").attr('data-rangedateend', '');
    $('#FilterName').find(`option[value="periodOfTime"]`).removeClass('filtered');
});

$("#FilterName").change(function () {
    if ($(this).val() == "periodOfTime") {
        $(this).attr('data-last-selected', $(this).val());
        $("#reportrange span").text(`${filterOfActualStranding["periodOfTime"]['start']} - ${filterOfActualStranding["periodOfTime"]['end']}`);
        $("#FilterValue").css('display', 'none');
        $('#reportrange').css('display', 'block');
        $("#ResistanceAtLength").css('display', 'none');
        $("#SubJopOrderNumber").css('display', 'none');
        $("#SheetsType").css('display', 'none');
        $("#Status").css('display', 'none');
    } else if ($(this).val() == "jopOrderNumber") {
        $(this).attr('data-last-selected', $(this).val());
        $("#FilterValue").css('display', 'none');
        $('#reportrange').css('display', 'none');
        $("#SubJopOrderNumber").css('display', 'flex');
        $("#SheetsType").css('display', 'none');
        $("#Status").css('display', 'none');
        $("#ResistanceAtLength").css('display', 'none');
    } else if ($(this).val() == "sheetsType") {
        $(this).attr('data-last-selected', $(this).val());
        $("#FilterValue").css('display', 'none');
        $('#reportrange').css('display', 'none');
        $("#SubJopOrderNumber").css('display', 'none');
        $("#SheetsType").css('display', 'flex');
        $("#Status").css('display', 'none');
        $("#ResistanceAtLength").css('display', 'none');
    } else if ($(this).val() == "status") {
        $(this).attr('data-last-selected', $(this).val());
        $("#FilterValue").css('display', 'none');
        $('#reportrange').css('display', 'none');
        $("#SubJopOrderNumber").css('display', 'none');
        $("#SheetsType").css('display', 'none');
        $("#Status").css('display', 'flex');
        $("#ResistanceAtLength").css('display', 'none');
    } else if ($(this).val() == "resistanceAtLength") {
        $(this).attr('data-last-selected', $(this).val());
        $("#FilterValue").css('display', 'none');
        $('#reportrange').css('display', 'none');
        $("#SubJopOrderNumber").css('display', 'none');
        $("#SheetsType").css('display', 'none');
        $("#Status").css('display', 'none');
        $("#ResistanceAtLength").css('display', 'block');
    } else if ($(this).val() == "notes") {
        $(this).val($(this).attr('data-last-selected'));
        if ($('#FilterName').find(`option[value="notes"]`).hasClass('filtered')) {
            filterOfActualStranding['notes'] = false;
            $('#FilterName').find(`option[value="notes"]`).removeClass('filtered');
        } else {
            filterOfActualStranding['notes'] = true;
            $('#FilterName').find(`option[value="notes"]`).addClass('filtered');
        }
    } else {

        if ($(this).val() == "conductorDimActual_HS") {
            if (filterOfActualStranding['conductorDimActual_FI'] != '' && filterOfActualStranding['conductorDimActual_FI'] != '+') {
                $("#FilterValue").prop('disabled', true);
                $("#FilterValue").val('');
            } else {
                $("#FilterValue").prop('disabled', false);
                $("#FilterValue").val(filterOfActualStranding[$(this).val()]);
            }
        } else if ($(this).val() == "conductorDimActual_FI") {
            if (filterOfActualStranding['conductorDimActual_HS'] != '' && filterOfActualStranding['conductorDimActual_HS'] != '+') {
                $("#FilterValue").prop('disabled', true);
                $("#FilterValue").val('');
            } else {
                $("#FilterValue").prop('disabled', false);
                $("#FilterValue").val(filterOfActualStranding[$(this).val()]);
            }
        } else {
            $("#FilterValue").prop('disabled', false);
            $("#FilterValue").val(filterOfActualStranding[$(this).val()]);
        }
        $(this).attr('data-last-selected', $(this).val());

        $("#FilterValue").css('display', 'block');
        $('#reportrange').css('display', 'none');
        $("#SubJopOrderNumber").css('display', 'none');
        $("#SheetsType").css('display', 'none');
        $("#Status").css('display', 'none');
        $("#ResistanceAtLength").css('display', 'none');
    }
});

//To Save Change That Happend On JopOrderNumber Selector
function jopOrderNumberFilter(that) {
    if (!$('input#jopOrderNumber').prop('checked') && !$('input#subJopOrderNumber').prop('checked')) {
        $(that).prop('checked', false);
        $('#SubJopOrderNumber input').not(that).prop('checked', true);
    }

    //To Open Print Report Button if He Filter on one JopOrderNumber
    if ($('input#jopOrderNumber').prop('checked') && $('input#subJopOrderNumber').prop('checked')) {
        $('#StartPrint').prop('disabled', true);
        $('#FilterName').find(`option[value="jopOrderNumber"]`).removeClass('filtered');

        if ($(that).attr('name') == 'jopOrderNumber') {
            filterOfActualStranding['jopOrderNumber'] = ($('input#jopOrderNumber').prop('checked')) ? filterOfActualStranding['subJopOrderNumber'].slice(0, -1) : '';
        } else if ($(that).attr('name') == 'subJopOrderNumber') {
            filterOfActualStranding['subJopOrderNumber'] = ($('input#subJopOrderNumber').prop('checked')) ? filterOfActualStranding['jopOrderNumber'] + '.' : '';
        }

    } else {
        $('#StartPrint').prop('disabled', false);
        $('#FilterName').find(`option[value="jopOrderNumber"]`).addClass('filtered');

        if ($(that).attr('name') == 'jopOrderNumber') {
            filterOfActualStranding['subJopOrderNumber'] = filterOfActualStranding['jopOrderNumber'] + '.';
            filterOfActualStranding['jopOrderNumber'] = ($('input#jopOrderNumber').prop('checked')) ? filterOfActualStranding['subJopOrderNumber'].slice(0, -1) : '';
        } else if ($(that).attr('name') == 'subJopOrderNumber') {
            filterOfActualStranding['jopOrderNumber'] = filterOfActualStranding['subJopOrderNumber'].slice(0, -1);
            filterOfActualStranding['subJopOrderNumber'] = ($('input#subJopOrderNumber').prop('checked')) ? filterOfActualStranding['jopOrderNumber'] + '.' : '';
        }

    }

}

//To Save Change That Happend On sheetsType Selector
function sheetsTypeFilter(that) {
    $('#SheetsType input').not(that).prop('checked', !$(that).prop('checked'));
    filterOfActualStranding['sheetsType'] = ($(that).prop('checked')) ? $(that).attr('name') : $('#SheetsType input').not(that).attr('name');

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

    filterOfActualStranding['status']['hold'] = $('input#Hold').prop('checked');
    filterOfActualStranding['status']['pass'] = $('input#Pass').prop('checked');

    if ($('input#Hold').prop('checked') && $('input#Pass').prop('checked')) {
        $('#FilterName').find(`option[value="status"]`).removeClass('filtered');
    } else {
        $('#FilterName').find(`option[value="status"]`).addClass('filtered');
    }

}

//To Save Change That Happend On ResistanceAtLength Selector
function resistanceAtLengthFilter(that) {
    filterOfActualStranding['resistanceAtLength'][$(that).attr('name')] = $(that).val();
}

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

//To Save Change That Happend On Notes Selector
$('#FilterName option[value="notes"]').click(function () {

});

//Function To add Time OF Every input insert
$('#Edit .input').blur(function () {
    let date = new Date().toLocaleString();
    $(this).attr('data-time', date);
});

// To Open angel_input if shape is Sector And Close it If Shape is Circular "For #Edir .Box"
function shapeIsChanged(element) {
    if (element.value == "Sector") {
        $(element).parent().children('.angel').prop('disabled', false).prop('required', true);
    } else if (element.value == "Circular") {
        $(element).parent().children('.angel').val('').prop('disabled', true).prop('required', false);
    }
}

// Function To Get Data Of Stranding By JopOrderNumber
function GetData(that, getStandard = false, moreData = false) {

    $(that).prop('disabled', true);
    $(that).find('button[type="submit"]').prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    filterOfActualStranding['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    if (filterOfActualStranding['sheetsType'] == "uncomplete") {
        $("#Limit").attr('data-count-rows', 25);
        filterOfActualStranding['limit'] = 25;
    }
    dataForm['filter'] = filterOfActualStranding;
    // console.log(filterOfActualStranding);

    $.ajax({
        'url': 'Actual',
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            $(that).prop('disabled', false);
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            console.log(data);

            let standardRow = data[0][0];
            let actualRows = data[1];
            let actualTimeRows = data[2];
            let countOfActualsRows = data[3];
            if (countOfActualsRows > filterOfActualStranding['limit']) {
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

            //To Print Standard Of SubJopOrderNumber If It Found
            if (getStandard) {
                if (data[0][1] == undefined) {

                    //To Hide Option JopOrderNumber From Filter If JopOrderNumber Does Not Have SubJopOrderNUmber
                    $('.filter select option[value="jopOrderNumber"]').addClass("d-none");
                    $('.filter select').val("shift");
                    $('.filter select').change();
                    $('#FilterValue, #FilterName, #Filter, #StartPrint').prop('disabled', false);

                    $('#Data .standard table').html(`<tr>
                    <th>Jop Order Number : </th>
                    <td id="JopOrderNumber">${standardRow.jopOrderNumber}</td>
                    <th>Volt : </th>
                    <td>${standardRow.volt}</td>
                    <th>Conductor Dim(H & S & φ) : </th>
                    <td>${standardRow.conductorDimStandard}</td>
                    <th>Size : </th>
                    <td>${standardRow.size} - ${standardRow.type}</td>
                    <th>Preforming Lay : </th>
                    <td>${standardRow.preformingLayStandard}</td>
                    </tr>
                    <tr>
                    <th>Water Blocking Tap : </th>
                    <td>${standardRow.waterBlockingTapStandard}</td>
                    <th>T.D.S No. : </th>
                    <td>${standardRow.TDS_number}</td>
                    <th>Conductor Weight :</th>
                    <td>${standardRow.conductorWeightStandard}</td>
                    <th>Resistance : </th>
                    <td>${standardRow.resistance}</td>
                    <th>Construction :</th>
                    <td>${standardRow.constructionStandard}</td>
                    </tr>
                    <tr>
                    <th>Lay Length : </th>
                    <td>${standardRow.layLengthStandard}</td>
                    <th>(Powder / Grease) Weight :</th>
                    <td>${standardRow.powder_grease_weightStandard}</td>
                    <th></th>
                    <td></td>
                    <th></th>
                    <td></td>
                    <th></th>
                    <td></td>
                    </tr>`);
                } else {
                    //To Show Option JopOrderNumber From Filter If JopOrderNumber Have SubJopOrderNUmber
                    $('.filter select option[value="jopOrderNumber"]').removeClass("d-none");
                    $('#FilterValue, #FilterName, #Filter, #StartPrint').prop('disabled', true);

                    let subStandardRow = data[0][1];
                    $('#Data .standard table').html(`<tr>
                    <th>Jop Order Number : </th>
                    <td id="JopOrderNumber">${standardRow.jopOrderNumber}</td>
                    <td id="JopOrderNumber">${subStandardRow.jopOrderNumber}</td>
                    <th>Volt : </th>
                    <td>${standardRow.volt}</td>
                    <td>${subStandardRow.volt + '.'}</td>
                    <th>Conductor Dim(H & S & φ) : </th>
                    <td>${standardRow.conductorDimStandard}</td>
                    <td>${subStandardRow.conductorDimStandard + '.'}</td>
                    <th>Size : </th>
                    <td>${standardRow.size} - ${standardRow.type}</td>
                    <td>${subStandardRow.size + '.'} - ${subStandardRow.type + '.'}</td>
                    <th>Preforming Lay : </th>
                    <td>${standardRow.preformingLayStandard}</td>
                    <td>${subStandardRow.preformingLayStandard + '.'}</td>
                    </tr>
                    <tr>
                    <th>Water Blocking Tap : </th>
                    <td>${standardRow.waterBlockingTapStandard}</td>
                    <td>${subStandardRow.waterBlockingTapStandard + '.'}</td>
                    <th>T.D.S No. : </th>
                    <td>${standardRow.TDS_number}</td>
                    <td>${subStandardRow.TDS_number + '.'}</td>
                    <th>Conductor Weight :</th>
                    <td>${standardRow.conductorWeightStandard}</td>
                    <td>${subStandardRow.conductorWeightStandard + '.'}</td>
                    <th>Resistance : </th>
                    <td>${standardRow.resistance}</td>
                    <td>${subStandardRow.resistance + '.'}</td>
                    <th>Construction :</th>
                    <td>${standardRow.constructionStandard}</td>
                    <td>${subStandardRow.constructionStandard + '.'}</td>
                    </tr>
                    <tr>
                    <th>Lay Length : </th>
                    <td>${standardRow.layLengthStandard}</td>
                    <td>${subStandardRow.layLengthStandard + '.'}</td>
                    <th>(Powder / Grease) Weight :</th>
                    <td>${standardRow.powder_grease_weightStandard}</td>
                    <td>${subStandardRow.powder_grease_weightStandard + '.'}</td>
                    <th></th>
                    <td></td>
                    <td></td>
                    <th></th>
                    <td></td>
                    <td></td>
                    <th></th>
                    <td></td>
                    <td></td>
                    </tr>`);
                }
            }

            if (actualRows.length == 0) {
                $('p.alert').removeClass('d-none');
                $('#Data .actual .table tbody').html('');
                return 0;
            } else {
                $('p.alert').addClass('d-none');
            }

            if (data[0][1] == undefined) {
                // To hide <th> of jopOrderNumber
                $('.thJopOrderNumber').addClass('d-none');
            } else {
                // To Show <th> of jopOrderNumber
                $('.thJopOrderNumber').removeClass('d-none');
            }

            /* ================================ */

            if (!moreData) {
                $('#Data .actual .table tbody').html('');
            }

            for (let i = 0; i < actualRows.length; i++) {

                $('#Data .actual .table tbody').append(`<tr data-id="${actualRows[i].id}">
                    <th>${(filterOfActualStranding['limit'] - 24) + i}</th>
                    <td>${actualRows[i].created_at.split(" ").join("<br>")}</td>
                    <td>${romanShift(actualRows[i].shift)}</td>
                    <td>${actualRows[i].added_by}</td>
                    ${(data[0][1] == undefined) ? '' : `<td>${actualRows[i].jopOrderNumber}</td>`}
                    <td>${(actualRows[i].machine == null) ? '' : actualRows[i].machine} <abbr title="${actualTimeRows[i].machine_time}"><i class="fas fa-stopwatch ${(actualRows[i].machine == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].angel == null) ? '' : actualRows[i].angel} <abbr title="${actualTimeRows[i].angel_time}"><i class="fas fa-stopwatch ${(actualRows[i].shape == 'Circular') ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].shape == null) ? '' : actualRows[i].shape} <abbr title="${actualTimeRows[i].shape_time}"><i class="fas fa-stopwatch ${(actualRows[i].shape == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].inputCard1 == null) ? '' : actualRows[i].inputCard1} <abbr title="${actualTimeRows[i].inputCard1_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputCard1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].inputCard2 == null) ? '' : actualRows[i].inputCard2} <abbr title="${actualTimeRows[i].inputCard2_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputCard2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].inputCard3 == null) ? '' : actualRows[i].inputCard3} <abbr title="${actualTimeRows[i].inputCard3_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputCard3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].inputCard4 == null) ? '' : actualRows[i].inputCard4} <abbr title="${actualTimeRows[i].inputCard4_time}"><i class="fas fa-stopwatch ${(actualRows[i].inputCard4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    </td>
                    <td class="prepareInput">
                    <span>${(actualRows[i].cage1 == null) ? '' : actualRows[i].cage1} <abbr title="${actualTimeRows[i].cage1_time}"><i class="fas fa-stopwatch ${(actualRows[i].cage1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].cage2 == null) ? '' : actualRows[i].cage2} <abbr title="${actualTimeRows[i].cage2_time}"><i class="fas fa-stopwatch ${(actualRows[i].cage2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].cage3 == null) ? '' : actualRows[i].cage3} <abbr title="${actualTimeRows[i].cage3_time}"><i class="fas fa-stopwatch ${(actualRows[i].cage3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].cage4 == null) ? '' : actualRows[i].cage4} <abbr title="${actualTimeRows[i].cage4_time}"><i class="fas fa-stopwatch ${(actualRows[i].cage4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    </td>
                    <td>${(actualRows[i].drumNumber == null) ? '' : actualRows[i].drumNumber} <abbr title="${actualTimeRows[i].drumNumber_time}"><i class="fas fa-stopwatch ${(actualRows[i].drumNumber == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].outputCard == null) ? '' : actualRows[i].outputCard} <abbr title="${actualTimeRows[i].outputCard_time}"><i class="fas fa-stopwatch ${(actualRows[i].outputCard == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].length == null) ? '' : actualRows[i].length} <abbr title="${actualTimeRows[i].length_time}"><i class="fas fa-stopwatch ${(actualRows[i].length == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].constructionActual == null) ? '' : actualRows[i].constructionActual} <abbr title="${actualTimeRows[i].constructionActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].constructionActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td  class="prepareInput">
                    <span>${(actualRows[i].conductorDimActual_HS1 == null) ? '' : actualRows[i].conductorDimActual_HS1.split('*')[0]} <abbr title="${actualTimeRows[i].conductorDimActual_HS1_time}"><i class="fas fa-stopwatch ${(actualRows[i].conductorDimActual_HS1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].conductorDimActual_HS2 == null) ? '' : actualRows[i].conductorDimActual_HS2.split('*')[0]} <abbr title="${actualTimeRows[i].conductorDimActual_HS2_time}"><i class="fas fa-stopwatch ${(actualRows[i].conductorDimActual_HS2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].conductorDimActual_HS3 == null) ? '' : actualRows[i].conductorDimActual_HS3.split('*')[0]} <abbr title="${actualTimeRows[i].conductorDimActual_HS3_time}"><i class="fas fa-stopwatch ${(actualRows[i].conductorDimActual_HS3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].conductorDimActual_HS4 == null) ? '' : actualRows[i].conductorDimActual_HS4.split('*')[0]} <abbr title="${actualTimeRows[i].conductorDimActual_HS4_time}"><i class="fas fa-stopwatch ${(actualRows[i].conductorDimActual_HS4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    </td>
                    <td  class="prepareInput">
                    <span>${(actualRows[i].conductorDimActual_HS1 == null) ? '' : actualRows[i].conductorDimActual_HS1.split('*')[1]} <abbr title="${actualTimeRows[i].conductorDimActual_HS1_time}"><i class="fas fa-stopwatch ${(actualRows[i].conductorDimActual_HS1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].conductorDimActual_HS2 == null) ? '' : actualRows[i].conductorDimActual_HS2.split('*')[1]} <abbr title="${actualTimeRows[i].conductorDimActual_HS2_time}"><i class="fas fa-stopwatch ${(actualRows[i].conductorDimActual_HS2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].conductorDimActual_HS3 == null) ? '' : actualRows[i].conductorDimActual_HS3.split('*')[1]} <abbr title="${actualTimeRows[i].conductorDimActual_HS3_time}"><i class="fas fa-stopwatch ${(actualRows[i].conductorDimActual_HS3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].conductorDimActual_HS4 == null) ? '' : actualRows[i].conductorDimActual_HS4.split('*')[1]} <abbr title="${actualTimeRows[i].conductorDimActual_HS4_time}"><i class="fas fa-stopwatch ${(actualRows[i].conductorDimActual_HS4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    </td>
                    <td  class="prepareInput">
                    <span>${(actualRows[i].conductorDimActual_FI1 == null) ? '' : actualRows[i].conductorDimActual_FI1} <abbr title="${actualTimeRows[i].conductorDimActual_FI1_time}"><i class="fas fa-stopwatch ${(actualRows[i].conductorDimActual_FI1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].conductorDimActual_FI2 == null) ? '' : actualRows[i].conductorDimActual_FI2} <abbr title="${actualTimeRows[i].conductorDimActual_FI2_time}"><i class="fas fa-stopwatch ${(actualRows[i].conductorDimActual_FI2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].conductorDimActual_FI3 == null) ? '' : actualRows[i].conductorDimActual_FI3} <abbr title="${actualTimeRows[i].conductorDimActual_FI3_time}"><i class="fas fa-stopwatch ${(actualRows[i].conductorDimActual_FI3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].conductorDimActual_FI4 == null) ? '' : actualRows[i].conductorDimActual_FI4} <abbr title="${actualTimeRows[i].conductorDimActual_FI4_time}"><i class="fas fa-stopwatch ${(actualRows[i].conductorDimActual_FI4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    </td>
                    <td>${(actualRows[i].ovality == null) ? '' : actualRows[i].ovality} <abbr title="${actualTimeRows[i].ovality_time}"><i class="fas fa-stopwatch ${(actualRows[i].ovality == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].preformingLayActual == null) ? '' : actualRows[i].preformingLayActual} <abbr title="${actualTimeRows[i].preformingLayActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].preformingLayActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].waterBlockingTapActual == null) ? '' : actualRows[i].waterBlockingTapActual} <abbr title="${actualTimeRows[i].waterBlockingTapActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].waterBlockingTapActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].layLengthDirection == null) ? '' : actualRows[i].layLengthDirection} <abbr title="${actualTimeRows[i].layLengthDirection_time}"><i class="fas fa-stopwatch ${(actualRows[i].layLengthDirection == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].conductorWeightActual == null) ? '' : actualRows[i].conductorWeightActual} <abbr title="${actualTimeRows[i].conductorWeightActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].conductorWeightActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td class="resistanceAtLength">
                    <span>${(actualRows[i].resistance1 == null) ? '' : actualRows[i].resistance1} <abbr title="${actualTimeRows[i].resistance1_time}"><i class="fas fa-stopwatch ${(actualRows[i].resistance1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].resistance2 == null) ? '' : actualRows[i].resistance2} <abbr title="${actualTimeRows[i].resistance2_time}"><i class="fas fa-stopwatch ${(actualRows[i].resistance2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].resistance3 == null) ? '' : actualRows[i].resistance3} <abbr title="${actualTimeRows[i].resistance3_time}"><i class="fas fa-stopwatch ${(actualRows[i].resistance3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].resistance4 == null) ? '' : actualRows[i].resistance4} <abbr title="${actualTimeRows[i].resistance4_time}"><i class="fas fa-stopwatch ${(actualRows[i].resistance4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    </td>
                    <td class="resistanceAtLength">
                    <span>${(actualRows[i].length1 == null) ? '' : actualRows[i].length1} <abbr title="${actualTimeRows[i].length1_time}"><i class="fas fa-stopwatch ${(actualRows[i].length1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].length2 == null) ? '' : actualRows[i].length2} <abbr title="${actualTimeRows[i].length2_time}"><i class="fas fa-stopwatch ${(actualRows[i].length2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].length3 == null) ? '' : actualRows[i].length3} <abbr title="${actualTimeRows[i].length3_time}"><i class="fas fa-stopwatch ${(actualRows[i].length3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    <span>${(actualRows[i].length4 == null) ? '' : actualRows[i].length4} <abbr title="${actualTimeRows[i].length4_time}"><i class="fas fa-stopwatch ${(actualRows[i].length4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                    </td>
                    <td>${(actualRows[i].layLengthActual == null) ? '' : actualRows[i].layLengthActual} <abbr title="${actualTimeRows[i].layLengthActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].layLengthActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].powder_grease_weightActual == null) ? '' : actualRows[i].powder_grease_weightActual} <abbr title="${actualTimeRows[i].powder_grease_weightActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].powder_grease_weightActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].visual == null) ? '' : actualRows[i].visual} <abbr title="${actualTimeRows[i].visual_time}"><i class="fas fa-stopwatch ${(actualRows[i].visual == null) ? 'd-none' : ''}"></i></abbr></td>
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

            if (filterOfActualStranding['sheetsType'] == 'complete' && data[0][1] == undefined) {
                $('#StartPrint').prop('disabled', false);
            } else {
                $('#StartPrint').prop('disabled', true);
            }

        },
        'error': function (data) {
            $(that).prop('disabled', true);
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
        },
    });
}

// To Get More Data Actuals
$("#Limit").click(function () {
    $(this).attr('data-count-rows', parseInt($(this).attr('data-count-rows')) + 25);
    GetData(this, false, true);
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
            if (data = "Error") {
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

            //To Make Inputs Of Edit Sheet required if sheetsType is Complete 
            $(inputs).not(`#Edit input[name="inputCard2"],
                            #Edit input[name="inputCard3"], 
                            #Edit input[name="inputCard4"],
                            #Edit input[name="cage2"],
                            #Edit input[name="cage3"],
                            #Edit input[name="cage4"],
                            #Edit input[name="conductorDimActual_HS2"],
                            #Edit input[name="conductorDimActual_HS3"],
                            #Edit input[name="conductorDimActual_HS4"],
                            #Edit input[name="conductorDimActual_FI2"],
                            #Edit input[name="conductorDimActual_FI3"],
                            #Edit input[name="conductorDimActual_FI4"],
                            #Edit input[name="resistance2"],
                            #Edit input[name="resistance3"],
                            #Edit input[name="resistance4"],
                            #Edit input[name="length2"],
                            #Edit input[name="length3"],
                            #Edit input[name="length4"],
                            #Edit textarea
                            `).prop('required', (filterOfActualStranding['sheetsType'] == 'complete'));

            if (actualRow['conductorDimActual_HS1'] != '') {
                $("#Edit input[name='conductorDimActual_FI1']").prop('required', false);
            } else {
                $("#Edit input[name='conductorDimActual_FI1']").prop('required', true);
            }

            if (actualRow['conductorDimActual_FI1'] != '') {
                $("#Edit input[name='conductorDimActual_HS1']").prop('required', false);
            } else {
                $("#Edit input[name='conductorDimActual_HS1']").prop('required', true);
            }
            // console.log(inputs);

            // To Preper Data Of StrandingActual
            let strandingActual_id = actualRow['id'];

            delete actualRow['id'];
            delete actualRow['jopOrderNumber_id'];
            delete actualRow['jopOrderNumber'];
            delete actualRow['added_by'];
            delete actualRow['shift'];
            delete actualRow['created_at'];
            delete actualRow['updated_at'];

            delete actualTimeRow['id'];
            delete actualTimeRow['strandingactuals_id'];
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
            $("#Edit form").attr('data-id', strandingActual_id);
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
    console.log(data);
    let actualRow = data[0];
    let actualRowTime = data[1];
    let i = $(`#Data .actual .table tbody tr[data-id="${actualRow.id}"]`).index() + 1;

    $(`#Data .actual .table tbody tr[data-id="${actualRow.id}"]`).html(`
                <th>${i}</th>
                <td>${actualRow.created_at}</td>
                <td>${romanShift(actualRow.shift)}</td>
                <td>${actualRow.added_by}</td>
                ${($(`.thJopOrderNumber`).hasClass('d-none')) ? '' : `<td>${actualRow.jopOrderNumber}</td>`}
                <td>${(actualRow.machine == null) ? '' : actualRow.machine} <abbr title="${actualRowTime.machine_time}"><i class="fas fa-stopwatch ${(actualRow.machine == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.angel == null) ? '' : actualRow.angel} <abbr title="${actualRowTime.angel_time}"><i class="fas fa-stopwatch ${(actualRow.shape == 'Circular') ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.shape == null) ? '' : actualRow.shape} <abbr title="${actualRowTime.shape_time}"><i class="fas fa-stopwatch ${(actualRow.shape == null) ? 'd-none' : ''}"></i></abbr></td>
                <td class="prepareInput">
                <span>${(actualRow.inputCard1 == null) ? '' : actualRow.inputCard1} <abbr title="${actualRowTime.inputCard1_time}"><i class="fas fa-stopwatch ${(actualRow.inputCard1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.inputCard2 == null) ? '' : actualRow.inputCard2} <abbr title="${actualRowTime.inputCard2_time}"><i class="fas fa-stopwatch ${(actualRow.inputCard2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.inputCard3 == null) ? '' : actualRow.inputCard3} <abbr title="${actualRowTime.inputCard3_time}"><i class="fas fa-stopwatch ${(actualRow.inputCard3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.inputCard4 == null) ? '' : actualRow.inputCard4} <abbr title="${actualRowTime.inputCard4_time}"><i class="fas fa-stopwatch ${(actualRow.inputCard4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                </td>
                <td class="prepareInput">
                <span>${(actualRow.cage1 == null) ? '' : actualRow.cage1} <abbr title="${actualRowTime.cage1_time}"><i class="fas fa-stopwatch ${(actualRow.cage1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.cage2 == null) ? '' : actualRow.cage2} <abbr title="${actualRowTime.cage2_time}"><i class="fas fa-stopwatch ${(actualRow.cage2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.cage3 == null) ? '' : actualRow.cage3} <abbr title="${actualRowTime.cage3_time}"><i class="fas fa-stopwatch ${(actualRow.cage3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.cage4 == null) ? '' : actualRow.cage4} <abbr title="${actualRowTime.cage4_time}"><i class="fas fa-stopwatch ${(actualRow.cage4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                </td>
                <td>${(actualRow.drumNumber == null) ? '' : actualRow.drumNumber} <abbr title="${actualRowTime.drumNumber_time}"><i class="fas fa-stopwatch ${(actualRow.drumNumber == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.outputCard == null) ? '' : actualRow.outputCard} <abbr title="${actualRowTime.outputCard_time}"><i class="fas fa-stopwatch ${(actualRow.outputCard == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.length == null) ? '' : actualRow.length} <abbr title="${actualRowTime.length_time}"><i class="fas fa-stopwatch ${(actualRow.length == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.constructionActual == null) ? '' : actualRow.constructionActual} <abbr title="${actualRowTime.constructionActual_time}"><i class="fas fa-stopwatch ${(actualRow.constructionActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td  class="prepareInput">
                <span>${(actualRow.conductorDimActual_HS1 == null) ? '' : actualRow.conductorDimActual_HS1.split('*')[0]} <abbr title="${actualRowTime.conductorDimActual_HS1_time}"><i class="fas fa-stopwatch ${(actualRow.conductorDimActual_HS1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.conductorDimActual_HS2 == null) ? '' : actualRow.conductorDimActual_HS2.split('*')[0]} <abbr title="${actualRowTime.conductorDimActual_HS2_time}"><i class="fas fa-stopwatch ${(actualRow.conductorDimActual_HS2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.conductorDimActual_HS3 == null) ? '' : actualRow.conductorDimActual_HS3.split('*')[0]} <abbr title="${actualRowTime.conductorDimActual_HS3_time}"><i class="fas fa-stopwatch ${(actualRow.conductorDimActual_HS3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.conductorDimActual_HS4 == null) ? '' : actualRow.conductorDimActual_HS4.split('*')[0]} <abbr title="${actualRowTime.conductorDimActual_HS4_time}"><i class="fas fa-stopwatch ${(actualRow.conductorDimActual_HS4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                </td>
                <td  class="prepareInput">
                <span>${(actualRow.conductorDimActual_HS1 == null) ? '' : actualRow.conductorDimActual_HS1.split('*')[1]} <abbr title="${actualRowTime.conductorDimActual_HS1_time}"><i class="fas fa-stopwatch ${(actualRow.conductorDimActual_HS1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.conductorDimActual_HS2 == null) ? '' : actualRow.conductorDimActual_HS2.split('*')[1]} <abbr title="${actualRowTime.conductorDimActual_HS2_time}"><i class="fas fa-stopwatch ${(actualRow.conductorDimActual_HS2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.conductorDimActual_HS3 == null) ? '' : actualRow.conductorDimActual_HS3.split('*')[1]} <abbr title="${actualRowTime.conductorDimActual_HS3_time}"><i class="fas fa-stopwatch ${(actualRow.conductorDimActual_HS3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.conductorDimActual_HS4 == null) ? '' : actualRow.conductorDimActual_HS4.split('*')[1]} <abbr title="${actualRowTime.conductorDimActual_HS4_time}"><i class="fas fa-stopwatch ${(actualRow.conductorDimActual_HS4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                </td>
                <td  class="prepareInput">
                <span>${(actualRow.conductorDimActual_FI1 == null) ? '' : actualRow.conductorDimActual_FI1} <abbr title="${actualRowTime.conductorDimActual_FI1_time}"><i class="fas fa-stopwatch ${(actualRow.conductorDimActual_FI1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.conductorDimActual_FI2 == null) ? '' : actualRow.conductorDimActual_FI2} <abbr title="${actualRowTime.conductorDimActual_FI2_time}"><i class="fas fa-stopwatch ${(actualRow.conductorDimActual_FI2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.conductorDimActual_FI3 == null) ? '' : actualRow.conductorDimActual_FI3} <abbr title="${actualRowTime.conductorDimActual_FI3_time}"><i class="fas fa-stopwatch ${(actualRow.conductorDimActual_FI3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.conductorDimActual_FI4 == null) ? '' : actualRow.conductorDimActual_FI4} <abbr title="${actualRowTime.conductorDimActual_FI4_time}"><i class="fas fa-stopwatch ${(actualRow.conductorDimActual_FI4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                </td>
                <td>${(actualRow.ovality == null) ? '' : actualRow.ovality} <abbr title="${actualRowTime.ovality_time}"><i class="fas fa-stopwatch ${(actualRow.ovality == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.preformingLayActual == null) ? '' : actualRow.preformingLayActual} <abbr title="${actualRowTime.preformingLayActual_time}"><i class="fas fa-stopwatch ${(actualRow.preformingLayActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.waterBlockingTapActual == null) ? '' : actualRow.waterBlockingTapActual} <abbr title="${actualRowTime.waterBlockingTapActual_time}"><i class="fas fa-stopwatch ${(actualRow.waterBlockingTapActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.layLengthDirection == null) ? '' : actualRow.layLengthDirection} <abbr title="${actualRowTime.layLengthDirection_time}"><i class="fas fa-stopwatch ${(actualRow.layLengthDirection == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.conductorWeightActual == null) ? '' : actualRow.conductorWeightActual} <abbr title="${actualRowTime.conductorWeightActual_time}"><i class="fas fa-stopwatch ${(actualRow.conductorWeightActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td class="resistanceAtLength">
                <span>${(actualRow.resistance1 == null) ? '' : actualRow.resistance1} <abbr title="${actualRowTime.resistance1_time}"><i class="fas fa-stopwatch ${(actualRow.resistance1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.resistance2 == null) ? '' : actualRow.resistance2} <abbr title="${actualRowTime.resistance2_time}"><i class="fas fa-stopwatch ${(actualRow.resistance2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.resistance3 == null) ? '' : actualRow.resistance3} <abbr title="${actualRowTime.resistance3_time}"><i class="fas fa-stopwatch ${(actualRow.resistance3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.resistance4 == null) ? '' : actualRow.resistance4} <abbr title="${actualRowTime.resistance4_time}"><i class="fas fa-stopwatch ${(actualRow.resistance4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                </td>
                <td class="resistanceAtLength">
                <span>${(actualRow.length1 == null) ? '' : actualRow.length1} <abbr title="${actualRowTime.length1_time}"><i class="fas fa-stopwatch ${(actualRow.length1 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.length2 == null) ? '' : actualRow.length2} <abbr title="${actualRowTime.length2_time}"><i class="fas fa-stopwatch ${(actualRow.length2 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.length3 == null) ? '' : actualRow.length3} <abbr title="${actualRowTime.length3_time}"><i class="fas fa-stopwatch ${(actualRow.length3 == null) ? 'd-none' : ''}"></i></abbr> </span>
                <span>${(actualRow.length4 == null) ? '' : actualRow.length4} <abbr title="${actualRowTime.length4_time}"><i class="fas fa-stopwatch ${(actualRow.length4 == null) ? 'd-none' : ''}"></i></abbr> </span>
                </td>
                <td>${(actualRow.layLengthActual == null) ? '' : actualRow.layLengthActual} <abbr title="${actualRowTime.layLengthActual_time}"><i class="fas fa-stopwatch ${(actualRow.layLengthActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.powder_grease_weightActual == null) ? '' : actualRow.powder_grease_weightActual} <abbr title="${actualRowTime.powder_grease_weightActual_time}"><i class="fas fa-stopwatch ${(actualRow.powder_grease_weightActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.visual == null) ? '' : actualRow.visual} <abbr title="${actualRowTime.visual_time}"><i class="fas fa-stopwatch ${(actualRow.visual == null) ? 'd-none' : ''}"></i></abbr></td>
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
                </td>`);
}

// To FadeOut Edit Form After make Click on Close Button
$("#Edit i").click(function () {
    $('body').css('overflow', 'auto');
    $("#Edit").fadeOut(500);
    $('#Edit .box').css('top', '-600px');
});

function clearFilter() {
    filterOfActualStranding = {
        'jopOrderNumber': '',
        'subJopOrderNumber': '',
        'shift': '',
        'added_by': '',
        'machine': '',
        'angel': '',
        'shape': '',
        'inputCard': '',
        'drumNumber': '',
        'outputCard': '',
        'length': '',
        'constructionActual': '',
        'conductorDimActual_HS': '',
        'conductorDimActual_FI': '',
        'conductorWeightActual': '',
        'resistanceAtLength': { 'resistance': '', 'length': '' },
        'status': { 'hold': true, 'pass': true },
        'productionOperator': '',
        'periodOfTime': { 'start': '', 'end': '' },
        'notes': false,
        'updated_by': '',
        'sheetsType': 'complete',
        'limit': 25
    };
    $("#FilterName option").removeClass('filtered');
    $("#SubJopOrderNumber input").prop('checked', true);
    $("#Status input").prop('checked', true);
    $("#ResistanceAtLength input").val('');
    $("#SheetsType input#Complete").prop('checked', true);
    $("#SheetsType input#Uncomplete").prop('checked', false);
    $("#reportrange span").text('');
    $("#FilterValue").val('');
}

// To Get Data Of Stranding By JopOrderNumber
$('.jopOrderNumber form').submit(function (e) {
    e.preventDefault();
    clearFilter();
    $("#Limit").attr('data-count-rows', 25);
    let regex = /^[A-z0-9]+\.$/;
    if (regex.test($('.jopOrderNumber .input').val())) {
        filterOfActualStranding['jopOrderNumber'] = $('.jopOrderNumber .input').val().slice(0, -1);
        filterOfActualStranding['subJopOrderNumber'] = $('.jopOrderNumber .input').val();
    } else {
        filterOfActualStranding['jopOrderNumber'] = $('.jopOrderNumber .input').val();
        filterOfActualStranding['subJopOrderNumber'] = $('.jopOrderNumber .input').val() + '.';
    }
    GetData(this, true);
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
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').removeClass('error');
                $(that).find('input[name="resistance1"], input[name="length1"]').removeClass('error');
                $(that).find('input[name="resistance2"], input[name="length2"]').removeClass('error');
                $(that).find('input[name="resistance3"], input[name="length3"]').removeClass('error');
                $(that).find('input[name="resistance4"], input[name="length4"]').removeClass('error');
                $(that).find('textarea[name="notes"]').removeClass('error');
            } else if (data == "Error-angel") {
                $(that).find('input[name="angel"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="angel"]')).offset().top - 20;
            } else if (data == "Error-inputCard1") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="inputCard1"]')).offset().top - 20;
            } else if (data == "Error-cage1") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="cage1"]')).offset().top - 20;
            } else if (data == "Error-conductorDimActual_HS1") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="conductorDimActual_HS1"]')).offset().top - 20;
            } else if (data == "Error-conductorDimActual_HS2") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="conductorDimActual_HS2"]')).offset().top - 20;
            } else if (data == "Error-conductorDimActual_HS3") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="conductorDimActual_HS3"]')).offset().top - 20;
            } else if (data == "Error-conductorDimActual_HS4") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="conductorDimActual_HS4"]')).offset().top - 20;
            } else if (data == "Error-conductorDimActual_FI1") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="conductorDimActual_FI1"]')).offset().top - 20;
            } else if (data == "Error-resistanceAtLength1") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').removeClass('error');
                $(that).find('input[name="resistance1"], input[name="length1"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="resistance1"], input[name="length1"]')).offset().top - 20;
            } else if (data == "Error-resistanceAtLength2") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').removeClass('error');
                $(that).find('input[name="resistance1"], input[name="length1"]').removeClass('error');
                $(that).find('input[name="resistance2"], input[name="length2"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="resistance1"], input[name="length1"]')).offset().top - 20;
            } else if (data == "Error-resistanceAtLength3") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').removeClass('error');
                $(that).find('input[name="resistance1"], input[name="length1"]').removeClass('error');
                $(that).find('input[name="resistance2"], input[name="length2"]').removeClass('error');
                $(that).find('input[name="resistance3"], input[name="length3"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="resistance1"], input[name="length1"]')).offset().top - 20;
            } else if (data == "Error-resistanceAtLength4") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').removeClass('error');
                $(that).find('input[name="resistance1"], input[name="length1"]').removeClass('error');
                $(that).find('input[name="resistance2"], input[name="length2"]').removeClass('error');
                $(that).find('input[name="resistance3"], input[name="length3"]').removeClass('error');
                $(that).find('input[name="resistance4"], input[name="length4"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="resistance1"], input[name="length1"]')).offset().top - 20;
            } else if (data == 'Error-notes') {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').removeClass('error');
                $(that).find('input[name="resistance1"], input[name="length1"]').removeClass('error');
                $(that).find('input[name="resistance2"], input[name="length2"]').removeClass('error');
                $(that).find('input[name="resistance3"], input[name="length3"]').removeClass('error');
                $(that).find('input[name="resistance4"], input[name="length4"]').removeClass('error');
                $(that).find('textarea[name="notes"]').addClass('error');
                $('.drowing').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
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
        'sheet': 'Stranding'
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
    filterOfActualStranding['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    dataForm['filter'] = filterOfActualStranding;

    // console.log(dataForm);

    $.ajax({
        'url': $(this).attr('action'),
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            $("#ISO").fadeOut(500);
            $('#ISO .box').css('top', '-600px');

            let standardRow = data[0][0];
            let actualRows = data[1];
            let iso = data[2][0];
            let standardTable = `<div class="standard my-3">
                                            <table class="table w-75 mx-auto my-3 table2">
                                            <tr>
                                            <th>Jop Order Number : </th>
                                            <td id="JopOrderNumber">${standardRow.jopOrderNumber}</td>
                                            <th>Volt : </th>
                                            <td>${standardRow.volt}</td>
                                            <th>Conductor Dim(H & S & φ) : </th>
                                            <td>${standardRow.conductorDimStandard}</td>
                                            <th>Size : </th>
                                            <td>${standardRow.size} - ${standardRow.type}</td>
                                            <th>Preforming Lay : </th>
                                            <td>${standardRow.preformingLayStandard}</td>
                                            </tr>
                                            <tr>
                                            <th>Water Blocking Tap : </th>
                                            <td>${standardRow.waterBlockingTapStandard}</td>
                                            <th>T.D.S No. : </th>
                                            <td>${standardRow.TDS_number}</td>
                                            <th>Conductor Weight :</th>
                                            <td>${standardRow.conductorWeightStandard}</td>
                                            <th>Resistance : </th>
                                            <td>${standardRow.resistance}</td>
                                            <th>Construction :</th>
                                            <td>${standardRow.constructionStandard}</td>
                                            </tr>
                                            <tr>
                                            <th>Lay Length : </th>
                                            <td>${standardRow.layLengthStandard}</td>
                                            <th>(Powder / Grease) Weight :</th>
                                            <td>${standardRow.powder_grease_weightStandard}</td>
                                            <th></th>
                                            <td></td>
                                            <th></th>
                                            <td></td>
                                            <th></th>
                                            <td></td>
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
                                    <td colspan="29" class="text-center">يعتمد ؛</td>
                                    </tr>
                                    <tr>
                                    <td colspan="6">${iso.material}</td>
                                    <td colspan="6">Duration Of Preservation : ${iso.durationOfPreservation}</td>
                                    <td colspan="5">Modified Date : ${iso.modifiedDate}</td>
                                    <td colspan="6">Issue Date : ${iso.issueDate}</td>
                                    <td colspan="6">Issue Number : ${iso.issueNumber}</td>
                                    </tr>`;

            let tableHeadOfActual = `<thead>
                                                        <tr>
                                                        <th>SN</th>
                                                        <th>Date / Time</th>
                                                        <th>Shift</th>
                                                        <th>Machine</th>
                                                        <th>Angel</th>
                                                        <th>Shape</th>
                                                        <th>Input Card</th>
                                                        <th>Cage</th>
                                                        <th>Drum Number</th>
                                                        <th>Output Card</th>
                                                        <th>Length</th>
                                                        <th>Construction</th>
                                                        <th class="p-0 text-center threeColumns" colspan="3">
                                                        Conductor Dim
                                                        <div class="conductorDim row m-0">
                                                        <span class="col-4 p-0 m-0 text-center">H</span>
                                                        <span class="col-4 p-0 m-0 text-center">S</span>
                                                        <span class="col-4 p-0 m-0 text-center">φ</span>
                                                        </div>
                                                        </th>
                                                        <th>Ovality</th>
                                                        <th>Preforming Lay</th>
                                                        <th>Water Blocking Tap</th>
                                                        <th>Lay Length Direction</th>
                                                        <th>Conductor Weight</th>
                                                        <th class="p-0 text-center twoColumns" colspan="2">
                                                        Resistance At Length
                                                        <div class="row m-0">
                                                        <span class="col-6 p-0 m-0 text-center">Ω</span>
                                                        <span class="col-6 p-0 m-0 text-center">M</span>
                                                        </div>
                                                        </th>
                                                        <th>Lay Length</th>
                                                        <th>Powder Weight</th>
                                                        <th>Visual</th>
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
                ${(data[0][1] == undefined) ? '' : `<td>${actualRows[i].jopOrderNumber}</td>`}
                <td>${(actualRows[i].machine == null) ? '' : actualRows[i].machine}</td>
                <td>${(actualRows[i].angel == null) ? '' : actualRows[i].angel}</td>
                <td>${(actualRows[i].shape == null) ? '' : actualRows[i].shape}</td>
                <td class="prepareInput">
                <span>${(actualRows[i].inputCard1 == null) ? '' : actualRows[i].inputCard1}</span>
                <span>${(actualRows[i].inputCard2 == null) ? '' : actualRows[i].inputCard2}</span>
                <span>${(actualRows[i].inputCard3 == null) ? '' : actualRows[i].inputCard3}</span>
                <span>${(actualRows[i].inputCard4 == null) ? '' : actualRows[i].inputCard4}</span>
                </td>
                <td class="prepareInput">
                <span>${(actualRows[i].cage1 == null) ? '' : actualRows[i].cage1}</span>
                <span>${(actualRows[i].cage2 == null) ? '' : actualRows[i].cage2}</span>
                <span>${(actualRows[i].cage3 == null) ? '' : actualRows[i].cage3}</span>
                <span>${(actualRows[i].cage4 == null) ? '' : actualRows[i].cage4}</span>
                </td>
                <td>${(actualRows[i].drumNumber == null) ? '' : actualRows[i].drumNumber}</td>
                <td>${(actualRows[i].outputCard == null) ? '' : actualRows[i].outputCard}</td>
                <td>${(actualRows[i].length == null) ? '' : actualRows[i].length}</td>
                <td>${(actualRows[i].constructionActual == null) ? '' : actualRows[i].constructionActual}</td>
                <td  class="prepareInput">
                <span>${(actualRows[i].conductorDimActual_HS1 == null) ? '' : actualRows[i].conductorDimActual_HS1.split('*')[0]}</span>
                <span>${(actualRows[i].conductorDimActual_HS2 == null) ? '' : actualRows[i].conductorDimActual_HS2.split('*')[0]}</span>
                <span>${(actualRows[i].conductorDimActual_HS3 == null) ? '' : actualRows[i].conductorDimActual_HS3.split('*')[0]}</span>
                <span>${(actualRows[i].conductorDimActual_HS4 == null) ? '' : actualRows[i].conductorDimActual_HS4.split('*')[0]}</span>
                </td>
                <td  class="prepareInput">
                <span>${(actualRows[i].conductorDimActual_HS1 == null) ? '' : actualRows[i].conductorDimActual_HS1.split('*')[1]}</span>
                <span>${(actualRows[i].conductorDimActual_HS2 == null) ? '' : actualRows[i].conductorDimActual_HS2.split('*')[1]}</span>
                <span>${(actualRows[i].conductorDimActual_HS3 == null) ? '' : actualRows[i].conductorDimActual_HS3.split('*')[1]}</span>
                <span>${(actualRows[i].conductorDimActual_HS4 == null) ? '' : actualRows[i].conductorDimActual_HS4.split('*')[1]}</span>
                </td>
                <td  class="prepareInput">
                <span>${(actualRows[i].conductorDimActual_FI1 == null) ? '' : actualRows[i].conductorDimActual_FI1}</span>
                <span>${(actualRows[i].conductorDimActual_FI2 == null) ? '' : actualRows[i].conductorDimActual_FI2}</span>
                <span>${(actualRows[i].conductorDimActual_FI3 == null) ? '' : actualRows[i].conductorDimActual_FI3}</span>
                <span>${(actualRows[i].conductorDimActual_FI4 == null) ? '' : actualRows[i].conductorDimActual_FI4}</span>
                </td>
                <td>${(actualRows[i].ovality == null) ? '' : actualRows[i].ovality}</td>
                <td>${(actualRows[i].preformingLayActual == null) ? '' : actualRows[i].preformingLayActual}</td>
                <td>${(actualRows[i].waterBlockingTapActual == null) ? '' : actualRows[i].waterBlockingTapActual}</td>
                <td>${(actualRows[i].layLengthDirection == null) ? '' : actualRows[i].layLengthDirection}</td>
                <td>${(actualRows[i].conductorWeightActual == null) ? '' : actualRows[i].conductorWeightActual}</td>
                <td class="resistanceAtLength">
                <span>${(actualRows[i].resistance1 == null) ? '' : actualRows[i].resistance1}</span>
                <span>${(actualRows[i].resistance2 == null) ? '' : actualRows[i].resistance2}</span>
                <span>${(actualRows[i].resistance3 == null) ? '' : actualRows[i].resistance3}</span>
                <span>${(actualRows[i].resistance4 == null) ? '' : actualRows[i].resistance4}</span>
                </td>
                <td class="resistanceAtLength">
                <span>${(actualRows[i].length1 == null) ? '' : actualRows[i].length1}</span>
                <span>${(actualRows[i].length2 == null) ? '' : actualRows[i].length2}</span>
                <span>${(actualRows[i].length3 == null) ? '' : actualRows[i].length3}</span>
                <span>${(actualRows[i].length4 == null) ? '' : actualRows[i].length4}</span>
                </td>
                <td>${(actualRows[i].layLengthActual == null) ? '' : actualRows[i].layLengthActual}</td>
                <td>${(actualRows[i].powder_grease_weightActual == null) ? '' : actualRows[i].powder_grease_weightActual}</td>
                <td>${(actualRows[i].visual == null) ? '' : actualRows[i].visual}</td>
                <td>${(actualRows[i].status == null) ? '' : actualRows[i].status}</td>
                <td>${(actualRows[i].productionOperator == null) ? '' : actualRows[i].productionOperator}</td>
                <td>${(actualRows[i].notes == null) ? '' : actualRows[i].notes}</td>
                <td>${actualRows[i].added_by}</td>
                </tr>`;

            }


            // Prepare Pages To Print it
            for (let i = 0, j = 1; i < actualRows.length; i++, j++) {
                let actualRow = createActualRow(i);
                if (j % 3 != 0 && j != actualRows.length) {
                    actuals += actualRow;
                } else if (j % 3 == 0) {
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




