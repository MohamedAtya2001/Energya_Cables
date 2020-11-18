
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
};

// Create FilterArray
let filterOfActualDrowing = {
    'shift': '',
    'added_by': '',
    'jopOrderNumber': '',
    'subJopOrderNumber': '',
    'machine': '',
    'coilNumber': '',
    'cage': '',
    'outputCard': '',
    'productionOperator': '',
    'notes': false,
    'periodOfTime': { 'start': '', 'end': '' },
    'updated_by': '',
    'sheetsType': 'complete',
    'limit': 25
};

//To Get Data From Filter And Save It At FilterArray
$("#FilterValue").blur(function () {
    filterOfActualDrowing[$("#FilterName").val()] = $(this).val();
    if ($(this).val() != '') {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).addClass('filtered');
    } else {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).removeClass('filtered');
    }
});

// To Make Filter On Data By Period Of Date
$("#reportrange").on('apply.daterangepicker, hide.daterangepicker', function (ev, picker) {
    cb(picker.startDate, picker.endDate);
    filterOfActualDrowing["periodOfTime"]['start'] = $("#reportrange span").attr('data-rangedatestart');
    filterOfActualDrowing["periodOfTime"]['end'] = $("#reportrange span").attr('data-rangedateend');
    $('#FilterName').find(`option[value="periodOfTime"]`).addClass('filtered');
});

// To Get Back All Data After Click On Cancel
$("#reportrange").on('cancel.daterangepicker', function () {
    filterOfActualDrowing["periodOfTime"]['start'] = "";
    filterOfActualDrowing["periodOfTime"]['end'] = "";
    $("#reportrange span").text('');
    $("#reportrange span").attr('data-rangedatestart', '');
    $("#reportrange span").attr('data-rangedateend', '');
    $('#FilterName').find(`option[value="periodOfTime"]`).removeClass('filtered');
});

$("#FilterName").change(function () {
    if ($(this).val() == "periodOfTime") {
        $(this).attr('data-last-selected', $(this).val());
        $("#reportrange span").text(`${filterOfActualDrowing["periodOfTime"]['start']} - ${filterOfActualDrowing["periodOfTime"]['end']}`);
        $('#reportrange').css('display', 'block');
        $("#FilterValue").css('display', 'none');
        $("#SubJopOrderNumber").css('display', 'none');
        $("#SheetsType").css('display', 'none');
    } else if ($(this).val() == "jopOrderNumber") {
        $(this).attr('data-last-selected', $(this).val());
        $('#reportrange').css('display', 'none');
        $("#FilterValue").css('display', 'none');
        $("#SubJopOrderNumber").css('display', 'flex');
        $("#SheetsType").css('display', 'none');
    } else if ($(this).val() == "sheetsType") {
        $(this).attr('data-last-selected', $(this).val());
        $('#reportrange').css('display', 'none');
        $("#FilterValue").css('display', 'none');
        $("#SubJopOrderNumber").css('display', 'none');
        $("#SheetsType").css('display', 'flex');
    } else if ($(this).val() == "notes") {
        $(this).val($(this).attr('data-last-selected'));
        if ($('#FilterName').find(`option[value="notes"]`).hasClass('filtered')) {
            filterOfActualDrowing['notes'] = false;
            $('#FilterName').find(`option[value="notes"]`).removeClass('filtered');
        } else {
            filterOfActualDrowing['notes'] = true;
            $('#FilterName').find(`option[value="notes"]`).addClass('filtered');
        }
    } else {
        $(this).attr('data-last-selected', $(this).val());
        $("#FilterValue").val(filterOfActualDrowing[$(this).val()]);
        $("#FilterValue").css('display', 'block');
        $('#reportrange').css('display', 'none');
        $("#SubJopOrderNumber").css('display', 'none');
        $("#SheetsType").css('display', 'none');
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
            filterOfActualDrowing['jopOrderNumber'] = ($('input#jopOrderNumber').prop('checked')) ? filterOfActualDrowing['subJopOrderNumber'].slice(0, -1) : '';
        } else if ($(that).attr('name') == 'subJopOrderNumber') {
            filterOfActualDrowing['subJopOrderNumber'] = ($('input#subJopOrderNumber').prop('checked')) ? filterOfActualDrowing['jopOrderNumber'] + '.' : '';
        }

    } else {
        $('#StartPrint').prop('disabled', false);
        $('#FilterName').find(`option[value="jopOrderNumber"]`).addClass('filtered');

        if ($(that).attr('name') == 'jopOrderNumber') {
            filterOfActualDrowing['subJopOrderNumber'] = filterOfActualDrowing['jopOrderNumber'] + '.';
            filterOfActualDrowing['jopOrderNumber'] = ($('input#jopOrderNumber').prop('checked')) ? filterOfActualDrowing['subJopOrderNumber'].slice(0, -1) : '';
        } else if ($(that).attr('name') == 'subJopOrderNumber') {
            filterOfActualDrowing['jopOrderNumber'] = filterOfActualDrowing['subJopOrderNumber'].slice(0, -1);
            filterOfActualDrowing['subJopOrderNumber'] = ($('input#subJopOrderNumber').prop('checked')) ? filterOfActualDrowing['jopOrderNumber'] + '.' : '';
        }

    }

}

//To Save Change That Happend On sheetsType Selector
function sheetsTypeFilter(that) {
    $('#SheetsType input').not(that).prop('checked', !$(that).prop('checked'));
    filterOfActualDrowing['sheetsType'] = ($(that).prop('checked')) ? $(that).attr('name') : $('#SheetsType input').not(that).attr('name');

    if ($('#Complete').prop('checked')) {
        $('#FilterName').find(`option[value="sheetsType"]`).removeClass('filtered');
        $('#StartPrint').prop('disabled', false);
    } else {
        $('#FilterName').find(`option[value="sheetsType"]`).addClass('filtered');
        $('#StartPrint').prop('disabled', true);
    }
}

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

            //To Make Inputs Of Edit Sheet required if sheetsType is Complete 
            $(inputs).not('#Edit textarea').prop('required', (filterOfActualDrowing['sheetsType'] == 'complete'));

            // To Preper Data Of DrowingActual
            let drowingActual_id = actualRow['id'];

            delete actualRow['id'];
            delete actualRow['jopOrderNumber_id'];
            delete actualRow['jopOrderNumber'];
            delete actualRow['added_by'];
            delete actualRow['shift'];
            delete actualRow['created_at'];
            delete actualRow['updated_at'];

            delete actualTimeRow['id'];
            delete actualTimeRow['drowingactuals_id'];
            delete actualTimeRow['added_by'];
            delete actualTimeRow['shift'];
            delete actualTimeRow['created_at'];
            delete actualTimeRow['updated_at'];

            // console.log(actualRow, actualTimeRow);

            for (let key in actualRow) {
                let currentInput = $(inputs).filter(`[name="${key}"]`);
                currentInput.val(actualRow[key]);
                currentInput.attr('data-time', actualTimeRow[key + '_time']);
            }

            $("#Edit form").attr('data-id', drowingActual_id);
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
                <td>${actualRow.created_at.split(" ").join("<br>")}</td>
                <td>${romanShift(actualRow.shift)}</td>
                <td>${actualRow.added_by}</td>
                ${($(`.thJopOrderNumber`).hasClass('d-none')) ? '' : `<td>${actualRow.jopOrderNumber}</td>`}
                <td>${(actualRow.machine == null) ? '' : actualRow.machine} <abbr title="${actualRowTime.machine_time}"><i class="fas fa-stopwatch ${(actualRow.machine == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.coilNumber == null) ? '' : actualRow.coilNumber} <abbr title="${actualRowTime.coilNumber_time}"><i class="fas fa-stopwatch ${(actualRow.coilNumber == null) ? 'd-none' : ''}"></i></abbr></td>
                <td class="wireDim">${(actualRow.wireDimMinActual == null) ? '' : actualRow.wireDimMinActual} <abbr title="${actualRowTime.wireDimMinActual_time}"><i class="fas fa-stopwatch ${(actualRow.wireDimMinActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td class="wireDim">${(actualRow.wireDimNomActual == null) ? '' : actualRow.wireDimNomActual} <abbr title="${actualRowTime.wireDimNomActual_time}"><i class="fas fa-stopwatch ${(actualRow.wireDimNomActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td class="wireDim">${(actualRow.wireDimMaxActual == null) ? '' : actualRow.wireDimMaxActual} <abbr title="${actualRowTime.wireDimMaxActual_time}"><i class="fas fa-stopwatch ${(actualRow.wireDimMaxActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.elongationActual == null) ? '' : actualRow.elongationActual} <abbr title="${actualRowTime.elongationActual_time}"><i class="fas fa-stopwatch ${(actualRow.elongationActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.tensileActual == null) ? '' : actualRow.tensileActual} <abbr title="${actualRowTime.tensileActual_time}"><i class="fas fa-stopwatch ${(actualRow.tensileActual == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.cage == null) ? '' : actualRow.cage} <abbr title="${actualRowTime.cage_time}"><i class="fas fa-stopwatch ${(actualRow.cage == null) ? 'd-none' : ''}"></i></abbr></td>
                <td>${(actualRow.outputCard == null) ? '' : actualRow.outputCard} <abbr title="${actualRowTime.outputCard_time}"><i class="fas fa-stopwatch ${(actualRow.outputCard == null) ? 'd-none' : ''}"></i></abbr></td>
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
                </td>
                `);
}

// Function To Get Data Of Drowing By JopOrderNumber
function GetData(that, getStandard = false, moreData = false) {
    $(that).prop('disabled', true);
    $(that).find('button[type="submit"]').prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    filterOfActualDrowing['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    if (filterOfActualDrowing['sheetsType'] == "uncomplete") {
        $("#Limit").attr('data-count-rows', 25);
        filterOfActualDrowing['limit'] = 25;
    }
    dataForm['filter'] = filterOfActualDrowing;
    // console.log(filterOfActualDrowing);
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
            //Get JopOrderData
            let standardRow = data[0][0];
            let actualRows = data[1];
            let actualTimeRows = data[2];
            let countOfActualsRows = data[3];
            if (countOfActualsRows > filterOfActualDrowing['limit']) {
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
                    <th>Elongation : </th>
                    <td>${standardRow.elongationStandard}</td>
                    <th>Size : </th>
                    <td>${standardRow.size}</td>
                    <th>Tensile : </th>
                    <td>${standardRow.tensileStandard}</td>
                    </tr>
                    <tr>
                    <th>Wire Dim Min : </th>
                    <td>${standardRow.wireDimMinStandard}</td>
                    <th>Wire Dim Nom : </th>
                    <td>${standardRow.wireDimNomStandard}</td>
                    <th>Wire Dim Max : </th>
                    <td>${standardRow.wireDimMaxStandard}</td>
                    <th></th>
                    <td></td>
                    <th></th>
                    <td></td>
                    </tr>
                    `);
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
                    <th>Elongation : </th>
                    <td>${standardRow.elongationStandard}</td>
                    <td>${subStandardRow.elongationStandard + '.'}</td>
                    <th>Size : </th>
                    <td>${standardRow.size}</td>
                    <td>${subStandardRow.size + '.'}</td>
                    <th>Tensile : </th>
                    <td>${standardRow.tensileStandard}</td>
                    <td>${subStandardRow.tensileStandard + '.'}</td>
                    </tr>
                    <tr>
                    <th>Wire Dim Min : </th>
                    <td>${standardRow.wireDimMinStandard}</td>
                    <td>${subStandardRow.wireDimMinStandard + '.'}</td>
                    <th>Wire Dim Nom : </th>
                    <td>${standardRow.wireDimNomStandard}</td>
                    <td>${subStandardRow.wireDimNomStandard + '.'}</td>
                    <th>Wire Dim Max : </th>
                    <td>${standardRow.wireDimMaxStandard}</td>
                    <td>${subStandardRow.wireDimMaxStandard + '.'}</td>
                    <th></th>
                    <td></td>
                    <td></td>
                    <th></th>
                    <td></td>
                    <td></td>
                    </tr`);
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
                    <th>${(filterOfActualDrowing['limit'] - 24) + i}</th>
                    <td>${actualRows[i].created_at.split(" ").join("<br>")}</td>
                    <td>${romanShift(actualRows[i].shift)}</td>
                    <td>${actualRows[i].added_by}</td>
                    ${(data[0][1] == undefined) ? '' : `<td>${actualRows[i].jopOrderNumber}</td>`}
                    <td>${(actualRows[i].machine == null) ? '' : actualRows[i].machine} <abbr title="${actualTimeRows[i].machine_time}"><i class="fas fa-stopwatch ${(actualRows[i].machine == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].coilNumber == null) ? '' : actualRows[i].coilNumber} <abbr title="${actualTimeRows[i].coilNumber_time}"><i class="fas fa-stopwatch ${(actualRows[i].coilNumber == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].wireDimMinActual == null) ? '' : actualRows[i].wireDimMinActual} <abbr title="${actualTimeRows[i].wireDimMinActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].wireDimMinActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].wireDimNomActual == null) ? '' : actualRows[i].wireDimNomActual} <abbr title="${actualTimeRows[i].wireDimNomActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].wireDimNomActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].wireDimMaxActual == null) ? '' : actualRows[i].wireDimMaxActual} <abbr title="${actualTimeRows[i].wireDimMaxActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].wireDimMaxActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].elongationActual == null) ? '' : actualRows[i].elongationActual} <abbr title="${actualTimeRows[i].elongationActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].elongationActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].tensileActual == null) ? '' : actualRows[i].tensileActual} <abbr title="${actualTimeRows[i].tensileActual_time}"><i class="fas fa-stopwatch ${(actualRows[i].tensileActual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].cage == null) ? '' : actualRows[i].cage} <abbr title="${actualTimeRows[i].cage_time}"><i class="fas fa-stopwatch ${(actualRows[i].cage == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].outputCard == null) ? '' : actualRows[i].outputCard} <abbr title="${actualTimeRows[i].outputCard_time}"><i class="fas fa-stopwatch ${(actualRows[i].outputCard == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].visual == null) ? '' : actualRows[i].visual} <abbr title="${actualTimeRows[i].visual_time}"><i class="fas fa-stopwatch ${(actualRows[i].visual == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].status == null) ? '' : actualRows[i].status} <abbr title="${actualTimeRows[i].status_time}"><i class="fas fa-stopwatch ${(actualRows[i].status == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].productionOperator == null) ? '' : actualRows[i].productionOperator} <abbr title="${actualTimeRows[i].productionOperator_time}"><i class="fas fa-stopwatch ${(actualRows[i].productionOperator == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${(actualRows[i].notes == null) ? '' : actualRows[i].notes} <abbr title="${actualTimeRows[i].notes_time}"><i class="fas fa-stopwatch ${(actualRows[i].notes == null) ? 'd-none' : ''}"></i></abbr></td>
                    <td>${actualRows[i].updated_by} <abbr title="${actualRows[i].updated_at}"><i class="fas fa-stopwatch ${(actualRows[i].updated_by == '') ? 'd-none' : ''}"></i></abbr></td>
                    <td class="option">
                    <button class="btn btn-primary mr-3" onclick="editRow(${actualRows[i].id}, this)" sheet-type="${filterOfActualDrowing['sheetsType']}">
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

            if (filterOfActualDrowing['sheetsType'] == 'complete' && data[0][1] == undefined) {
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
            // console.log(data.responseJSON.error);
        },
    });
}

// To Get More Data Actuals
$("#Limit").click(function () {
    $(this).attr('data-count-rows', parseInt($(this).attr('data-count-rows')) + 25);
    GetData(this, false, true);
});

// To FadeIn ISO Form 
$("#StartPrint").click(function () {
    let that = this;
    $(this).prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    dataForm = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'sheet': 'Drowing'
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

// To FadeOut ISO Form After make Click on Close Button
$("#ISO i").click(function () {
    $("#ISO").fadeOut(500);
    $('#ISO .box').css('top', '-600px');
});

// To FadeOut Edit Form After make Click on Close Button
$("#Edit i").click(function () {
    $("#Edit").fadeOut(500);
    $('#Edit .box').css('top', '-600px');
});

//Function To add Time OF Every input insert
$('#Edit .input').blur(function () {
    let date = new Date().toLocaleString();
    $(this).attr('data-time', date);
});

function clearFilter() {
    filterOfActualDrowing = {
        'shift': '',
        'added_by': '',
        'jopOrderNumber': '',
        'subJopOrderNumber': '',
        'machine': '',
        'coilNumber': '',
        'cage': '',
        'outputCard': '',
        'productionOperator': '',
        'notes': false,
        'periodOfTime': { 'start': '', 'end': '' },
        'updated_by': '',
        'sheetsType': 'complete',
        'limit': 25
    };
    $("#FilterName option").removeClass('filtered');
    $("#SubJopOrderNumber input").prop('checked', true);
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
    let regex = /^[A-z0-9]+\.$/;
    if (regex.test($('.jopOrderNumber .input').val())) {
        filterOfActualDrowing['jopOrderNumber'] = $('.jopOrderNumber .input').val().slice(0, -1);
        filterOfActualDrowing['subJopOrderNumber'] = $('.jopOrderNumber .input').val();
    } else {
        filterOfActualDrowing['jopOrderNumber'] = $('.jopOrderNumber .input').val();
        filterOfActualDrowing['subJopOrderNumber'] = $('.jopOrderNumber .input').val() + '.';
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

                $("#Edit").fadeOut(500);
                $('#Edit .box').css('top', '-600px');
                let dataForm2 = {};
                dataForm2['_token'] = $(that).find('input').eq(0).attr('value');
                dataForm2['jopOrderNumber'] = $('#JopOrderNumber').text();
                $(that).find('textarea[name="notes"]').removeClass('error');
            } else if (data == 'Error-wireDimActual') {
                $(that).find('input[name="wireDimMinActual"], input[name="wireDimNomActual"], input[name="wireDimMaxActual"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('input[name="wireDimMinActual"]')).offset().top - 20;
            } else if (data == 'Error-notes') {
                $(that).find('input[name="wireDimMinActual"], input[name="wireDimNomActual"], input[name="wireDimMaxActual"]').removeClass('error');
                $(that).find('textarea[name="notes"]').addClass('error');
                $('#Edit').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
            } else {
                $(that).find('input[name="wireDimMinActual"], input[name="wireDimNomActual"], input[name="wireDimMaxActual"]').removeClass('error');
                $(that).find('textarea[name="notes"]').removeClass('error');
                $($(that).find('.input')).val('').prop("disabled", false);
                $($(that).find('textarea')).val('').prop("disabled", false);
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
    filterOfActualDrowing['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    dataForm['filter'] = filterOfActualDrowing;

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
            // console.log(data);
            let standardTable = `<div class="standard my-3">
                                            <table class="table w-75 mx-auto my-3 table2">
                                            <tr>
                                            <th>Jop Order Number : </th>
                                            <td id="JopOrderNumber">${standardRow.jopOrderNumber}</td>
                                            <th>Volt : </th>
                                            <td>${standardRow.volt}</td>
                                            <th>Elongation : </th>
                                            <td>${standardRow.elongationStandard}</td>
                                            <th>Size : </th>
                                            <td>${standardRow.size}</td>
                                            <th>Tensile : </th>
                                            <td>${standardRow.tensileStandard}</td>
                                            </tr>
                                            <tr>
                                            <th>Wire Dim Min : </th>
                                            <td>${standardRow.wireDimMinStandard}</td>
                                            <th>Wire Dim Nom : </th>
                                            <td>${standardRow.wireDimNomStandard}</td>
                                            <th>Wire Dim Max : </th>
                                            <td>${standardRow.wireDimMaxStandard}</td>
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
                                    <td colspan="17" class="text-center">يعتمد ؛</td>
                                    </tr>
                                    <tr>
                                    <td colspan="3">${iso.material}</td>
                                    <td colspan="4">Duration Of Preservation : ${iso.durationOfPreservation}</td>
                                    <td colspan="3">Modified Date : ${iso.modifiedDate}</td>
                                    <td colspan="4">Issue Date : ${iso.issueDate}</td>
                                    <td colspan="3">Issue Number : ${iso.issueNumber}</td>
                                    </tr>`;

            let tableHeadOfActual = `<thead>
                                                        <tr>
                                                        <th>SN</th>
                                                        <th>Date / Time</th>
                                                        <th>Shift</th>
                                                        <th>Machine</th>
                                                        <th>Coil Number</th>
                                                        <th class="text-center pb-0 threeColumns" colspan="3">
                                                        Wire Dim
                                                        <div class="row m-0 mt-2">
                                                        <span class="col-4 p-0 m-0 text-center">Min</span>
                                                        <span class="col-4 p-0 m-0 text-center">Nom</span>
                                                        <span class="col-4 p-0 m-0 text-center">Max</span>
                                                        </div>
                                                        </th>
                                                        <th>Elongation</th>
                                                        <th>Tensile</th>
                                                        <th>Cage</th>
                                                        <th>Output Card</th>
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
                return `<tr>
                <th>${i + 1}</th>
                <td>${ (actualRows[i].created_at != null) ? actualRows[i].created_at.split(" ").join("<br>") : ""}</td>
                <td>${ (actualRows[i].shift != null) ? romanShift(actualRows[i].shift) : ""}</td>
                <td>${ (actualRows[i].machine != null) ? actualRows[i].machine : ""}</td>
                <td>${ (actualRows[i].coilNumber != null) ? actualRows[i].coilNumber : ""}</td>
                <td>${ (actualRows[i].wireDimMinActual != null) ? actualRows[i].wireDimMinActual : ""}</td>
                <td>${ (actualRows[i].wireDimNomActual != null) ? actualRows[i].wireDimNomActual : ""}</td>
                <td>${ (actualRows[i].wireDimMaxActual != null) ? actualRows[i].wireDimMaxActual : ""}</td>
                <td>${ (actualRows[i].elongationActual != null) ? actualRows[i].elongationActual : ""}</td>
                <td>${ (actualRows[i].tensileActual != null) ? actualRows[i].tensileActual : ""}</td>
                <td>${ (actualRows[i].cage != null) ? actualRows[i].cage : ""}</td>
                <td>${ (actualRows[i].outputCard != null) ? actualRows[i].outputCard : ""}</td>
                <td>${ (actualRows[i].visual != null) ? actualRows[i].visual : ""}</td>
                <td>${ (actualRows[i].status != null) ? actualRows[i].status : ""}</td>
                <td>${ (actualRows[i].productionOperator != null) ? actualRows[i].productionOperator : ""}</td>
                <td>${ (actualRows[i].notes != null) ? actualRows[i].notes : ""}</td>
                <td>${ (actualRows[i].added_by != null) ? actualRows[i].added_by : ""}</td>
                </tr>`;
            }

            // Prepare Page To Print it
            for (let i = 0, j = 1; i < actualRows.length; i++, j++) {
                let actualRow = createActualRow(i);
                if (j % 5 != 0 && j != actualRows.length) {
                    actuals += actualRow;
                } else if (j % 5 == 0) {
                    actuals += actualRow + ISORow;

                    let actualTable = `<div class="actual my-3 drowing">
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

                    let actualTable = `<div class="actual my-3 drowing">
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



