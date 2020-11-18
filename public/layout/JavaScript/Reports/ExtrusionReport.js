
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
let filterOfExtrusionReport = {
    'jopOrderNumber': '',
    'cableSize': '',
    'machine': '',
    'process': { 'insulation': true, 'bedding': true, 'sheathing': true },
    'inputDrum': '',
    'outputDrum': '',
    'weightDeviation': { 'red': true, 'green': true },
    'periodOfTime': { 'start': '', 'end': '' },
    'insulationLimit': 10,
    'beddingLimit': 10,
    'sheathingLimit': 10,
    'SN': 1
};

//To Get Data From Filter And Save It At FilterArray
$("#FilterValue").blur(function () {
    filterOfExtrusionReport[$("#FilterName").val()] = $(this).val();
    if ($(this).val() != '') {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).addClass('filtered');
    } else {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).removeClass('filtered');
    }
});

// To Make Filter On Data By Period Of Date
$("#reportrange").on('apply.daterangepicker, hide.daterangepicker', function (ev, picker) {
    cb(picker.startDate, picker.endDate);
    filterOfExtrusionReport["periodOfTime"]['start'] = $("#reportrange span").attr('data-rangedatestart');
    filterOfExtrusionReport["periodOfTime"]['end'] = $("#reportrange span").attr('data-rangedateend');
    $('#FilterName').find(`option[value="periodOfTime"]`).addClass('filtered');
});

// To Get Back All Data After Click On Cancel
$("#reportrange").on('cancel.daterangepicker', function () {
    filterOfExtrusionReport["periodOfTime"]['start'] = "";
    filterOfExtrusionReport["periodOfTime"]['end'] = "";
    $("#reportrange span").text('');
    $("#reportrange span").attr('data-rangedatestart', '');
    $("#reportrange span").attr('data-rangedateend', '');
    $('#FilterName').find(`option[value="periodOfTime"]`).removeClass('filtered');
});

$("#FilterName").change(function () {
    if ($(this).val() == "periodOfTime") {
        $("#reportrange span").text(`${filterOfExtrusionReport["periodOfTime"]['start']} - ${filterOfExtrusionReport["periodOfTime"]['end']}`);
        $('#reportrange').css('display', 'block');
        $("#FilterValue").css('display', 'none');
        $("#Process").css('display', 'none');
        $("#WeightDeviation").css('display', 'none');
    } else if ($(this).val() == "process") {
        $('#reportrange').css('display', 'none');
        $("#FilterValue").css('display', 'none');
        $("#Process").css('display', 'flex');
        $("#WeightDeviation").css('display', 'none');
    } else if ($(this).val() == "weightDeviation") {
        $('#reportrange').css('display', 'none');
        $("#FilterValue").css('display', 'none');
        $("#Process").css('display', 'none');
        $("#WeightDeviation").css('display', 'flex');
    } else {
        $("#FilterValue").val(filterOfExtrusionReport[$(this).val()]);
        $('#reportrange').css('display', 'none');
        $("#Process").css('display', 'none');
        $("#WeightDeviation").css('display', 'none');
        $("#FilterValue").css('display', 'block');
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

//To Save Data That he Want To
function processFilter(that) {
    if (!$('input#Insulation').prop('checked') && !$('input#Bedding').prop('checked') && !$('input#Sheathing').prop('checked')) {
        $(that).prop('checked', true);
    }

    filterOfExtrusionReport['process']['insulation'] = $('input#Insulation').prop('checked');
    filterOfExtrusionReport['process']['bedding'] = $('input#Bedding').prop('checked');
    filterOfExtrusionReport['process']['sheathing'] = $('input#Sheathing').prop('checked');
    if ($('input#Insulation').prop('checked') && $('input#Bedding').prop('checked') && $('input#Sheathing').prop('checked')) {
        $('#FilterName').find(`option[value="process"]`).removeClass('filtered');
    } else {
        $('#FilterName').find(`option[value="process"]`).addClass('filtered');
    }
}

//To Save Data That he Want To
function weightDeviationFilter(that) {
    if (!$('input#Red').prop('checked') && !$('input#Green').prop('checked')) {
        $(that).prop('checked', false);
        $('#WeightDeviation input').not(that).prop('checked', true);
    }

    filterOfExtrusionReport['weightDeviation']['red'] = $('input#Red').prop('checked');
    filterOfExtrusionReport['weightDeviation']['green'] = $('input#Green').prop('checked');

    if ($('input#Red').prop('checked') && $('input#Green').prop('checked')) {
        $('#FilterName').find(`option[value="weightDeviation"]`).removeClass('filtered');
    } else {
        $('#FilterName').find(`option[value="weightDeviation"]`).addClass('filtered');
    }
}

// Function To Get Data Of Extrusion By JopOrderNumber
function GetData(Url, that = null, moreData = false) {
    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    filterOfExtrusionReport['insulationLimit'] = parseInt($("#Limit").attr('data-insulation-count-rows'));
    filterOfExtrusionReport['beddingLimit'] = parseInt($("#Limit").attr('data-bedding-count-rows'));
    filterOfExtrusionReport['sheathingLimit'] = parseInt($("#Limit").attr('data-sheathing-count-rows'));
    dataForm['filter'] = filterOfExtrusionReport;
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

            let insulation = data['insulation'][0];
            let insulationRemarks = data['insulation'][1];

            let bedding = data['bedding'][0];
            let beddingRemarks = data['bedding'][1];

            let sheathing = data['sheathing'][0];
            let sheathingRemarks = data['sheathing'][1];

            let countOfExtrusionRows = data['insulation'][2] + data['bedding'][2] + data['sheathing'][2];
            let filterLimit = filterOfExtrusionReport['insulationLimit'] + filterOfExtrusionReport['beddingLimit'] + filterOfExtrusionReport['sheathingLimit'];


            if (countOfExtrusionRows > filterLimit) {
                $("#Limit").removeClass('d-none');
            } else {
                $("#Limit").addClass('d-none');
            }

            if (insulation.length == 0 && bedding.length == 0 && sheathing.length == 0) {
                $('p.alert').removeClass('d-none');
                $('#Data .report .table tbody').html('');
                return 0;
            } else {
                $('p.alert').addClass('d-none');
            }

            if (insulation.length == 0 && bedding.length == 0 && sheathing.length == 0) {
                $('#StartPrint').prop('disabled', true);
            } else {
                $('#StartPrint').prop('disabled', false);
            }

            /* ================================ */

            if (!moreData) {
                $('#Data .report .table tbody').html('');
                filterOfExtrusionReport['SN'] = 1;
            }

            for (let i = 0; i < insulation.length; i++) {
                let remarkOfCurentActual = insulationRemarks.find(object => object.report_id == insulation[i].id);

                $('#Data .report .table tbody').append(`<tr data-id="${insulation[i].id}, insulation">
                                                        <td>${filterOfExtrusionReport['SN']}</td>
                                                        <td>${insulation[i].created_at.split(" ").join("<br>")}</td>
                                                        <td>${romanShift(insulation[i].shift)}</td>
                                                        <td>${insulation[i].machine}</td>
                                                        <td>${insulation[i].jopOrderNumber}</td>
                                                        <td>${insulation[i].cableSize}</td>
                                                        <td>Insulation</td>
                                                        <td class="fix">${insulation[i].inputDrum}</td>
                                                        <td class="fix">${insulation[i].inputLength}</td>
                                                        <td class="fix">${insulation[i].outputDrum}</td>
                                                        <td class="fix">${insulation[i].outputLength}</td>

                                                        <td class="prepareInput">
                                                        <span>${insulation[i].thicknessMinStandard}</span> 
                                                        <span style="border-bottom : 1px solid #000;">${insulation[i].thicknessNomStandard}</span> 
                                                        <span style="border-bottom : none;">${insulation[i].thicknessMaxStandard}</span> 
                                                        </td>

                                                        <td class="prepareInput">
                                                        <span>${insulation[i].thicknessStartMinActual}</span> 
                                                        <span style="border-bottom : none;">${insulation[i].thicknessEndMinActual}</span> 
                                                        </td>
                                                        <td class="prepareInput">
                                                        <span>${insulation[i].thicknessStartNomActual}</span> 
                                                        <span style="border-bottom : none;">${insulation[i].thicknessEndNomActual}</span> 
                                                        </td>
                                                        <td class="prepareInput">
                                                        <span>${insulation[i].thicknessStartMaxActual}</span> 
                                                        <span style="border-bottom : none;">${insulation[i].thicknessEndMaxActual}</span> 
                                                        </td>

                                                        <td class="prepareInput">
                                                        <span>${insulation[i].dimBefore1}</span> 
                                                        <span style="border-bottom : none;">${(insulation[i].dimBefore2 == null) ? '' : insulation[i].dimBefore2}</span>
                                                        </td>
                                                        
                                                        <td>${insulation[i].outerDim}</td>
                                                        
                                                        <td class="prepareInput">
                                                        <span>${insulation[i].dimAfterStartNom}</span> 
                                                        <span style="border-bottom : none;">${insulation[i].dimAfterEndNom}</span>
                                                        </td>

                                                        <td>${insulation[i].weightStandard}</td>
                                                        <td>${insulation[i].weightActual}</td>
                                                        <td class="text-light ${(insulation[i].weightDeviation > 0) ? 'bg-danger' : 'bg-success'}">${(insulation[i].weightDeviation).toFixed(2) + '%'}</td>
                                                        <td class="remark">
                                                        <i class="fas fa-edit text-info" onclick="remark('insulation', ${insulation[i].id})"></i>
                                                        ${(remarkOfCurentActual == undefined) ? '' : remarkOfCurentActual.remark}
                                                        </td>
                                                        </tr>`);

                filterOfExtrusionReport['SN']++;

            }

            for (let i = 0; i < bedding.length; i++) {
                let remarkOfCurentActual = beddingRemarks.find(object => object.report_id == bedding[i].id);

                $('#Data .report .table tbody').append(`<tr data-id="${bedding[i].id}, bedding">
                                                        <td>${filterOfExtrusionReport['SN']}</td>
                                                        <td>${bedding[i].created_at.split(" ").join("<br>")}</td>
                                                        <td>${romanShift(bedding[i].shift)}</td>
                                                        <td>${bedding[i].machine}</td>
                                                        <td>${bedding[i].jopOrderNumber}</td>
                                                        <td>${bedding[i].cableSize}</td>
                                                        <td>Bedding</td>
                                                        <td class="fix">${bedding[i].inputDrum}</td>
                                                        <td class="fix">${bedding[i].inputLength}</td>
                                                        <td class="fix">${bedding[i].outputDrum}</td>
                                                        <td class="fix">${bedding[i].outputLength}</td>

                                                        <td class="prepareInput">
                                                        <span>${bedding[i].thicknessMinStandard}</span> 
                                                        <span style="border-bottom : 1px solid #000;">${bedding[i].thicknessNomStandard}</span> 
                                                        <span style="border-bottom : none;">${bedding[i].thicknessMaxStandard}</span> 
                                                        </td>

                                                        <td class="prepareInput">
                                                        <span>${bedding[i].thicknessStartMinActual}</span> 
                                                        <span style="border-bottom : none;">${bedding[i].thicknessEndMinActual}</span> 
                                                        </td>
                                                        <td class="prepareInput">
                                                        <span>${bedding[i].thicknessStartNomActual}</span> 
                                                        <span style="border-bottom : none;">${bedding[i].thicknessEndNomActual}</span> 
                                                        </td>
                                                        <td class="prepareInput">
                                                        <span>${bedding[i].thicknessStartMaxActual}</span> 
                                                        <span style="border-bottom : none;">${bedding[i].thicknessEndMaxActual}</span> 
                                                        </td>

                                                        <td class="prepareInput">
                                                        <span>${bedding[i].dimBefore1}</span> 
                                                        <span style="border-bottom : none;">${(bedding[i].dimBefore2 == null) ? '' : bedding[i].dimBefore2}</span>
                                                        </td>
                                                        
                                                        <td>${bedding[i].outerDim}</td>
                                                        
                                                        <td class="prepareInput">
                                                        <span>${bedding[i].dimAfterStartNom}</span> 
                                                        <span style="border-bottom : none;">${bedding[i].dimAfterEndNom}</span>
                                                        </td>

                                                        <td>${bedding[i].weightStandard}</td>
                                                        <td>${bedding[i].weightActual}</td>
                                                        <td class="text-light ${(bedding[i].weightDeviation > 0) ? 'bg-danger' : 'bg-success'}">${(bedding[i].weightDeviation).toFixed(2) + '%'}</td>
                                                        <td class="remark">
                                                        <i class="fas fa-edit text-info" onclick="remark('bedding', ${bedding[i].id})"></i>
                                                        ${(remarkOfCurentActual == undefined) ? '' : remarkOfCurentActual.remark}
                                                        </td>
                                                        </tr>`);

                filterOfExtrusionReport['SN']++;

            }

            for (let i = 0; i < sheathing.length; i++) {
                let remarkOfCurentActual = sheathingRemarks.find(object => object.report_id == sheathing[i].id);

                $('#Data .report .table tbody').append(`<tr data-id="${sheathing[i].id}, sheathing">
                                                        <td>${filterOfExtrusionReport['SN']}</td>
                                                        <td>${sheathing[i].created_at.split(" ").join("<br>")}</td>
                                                        <td>${romanShift(sheathing[i].shift)}</td>
                                                        <td>${sheathing[i].machine}</td>
                                                        <td>${sheathing[i].jopOrderNumber}</td>
                                                        <td>${sheathing[i].cableSize}</td>
                                                        <td>Sheathing</td>
                                                        <td class="fix">${sheathing[i].inputDrum}</td>
                                                        <td class="fix">${sheathing[i].inputLength}</td>
                                                        <td class="fix">${sheathing[i].outputDrum}</td>
                                                        <td class="fix">${sheathing[i].outputLength}</td>

                                                        <td class="prepareInput">
                                                        <span>${sheathing[i].thicknessMinStandard}</span> 
                                                        <span style="border-bottom : 1px solid #000;">${sheathing[i].thicknessNomStandard}</span> 
                                                        <span style="border-bottom : none;">${sheathing[i].thicknessMaxStandard}</span> 
                                                        </td>

                                                        <td class="prepareInput">
                                                        <span>${sheathing[i].thicknessStartMinActual}</span> 
                                                        <span style="border-bottom : none;">${sheathing[i].thicknessEndMinActual}</span> 
                                                        </td>
                                                        <td class="prepareInput">
                                                        <span>${sheathing[i].thicknessStartNomActual}</span> 
                                                        <span style="border-bottom : none;">${sheathing[i].thicknessEndNomActual}</span> 
                                                        </td>
                                                        <td class="prepareInput">
                                                        <span>${sheathing[i].thicknessStartMaxActual}</span> 
                                                        <span style="border-bottom : none;">${sheathing[i].thicknessEndMaxActual}</span> 
                                                        </td>

                                                        <td class="prepareInput">
                                                        <span>${sheathing[i].dimBefore1}</span> 
                                                        <span style="border-bottom : none;">${(sheathing[i].dimBefore2 == null) ? '' : sheathing[i].dimBefore2}</span>
                                                        </td>
                                                        
                                                        <td>${sheathing[i].outerDim}</td>
                                                        
                                                        <td class="prepareInput">
                                                        <span>${sheathing[i].dimAfterStartNom}</span> 
                                                        <span style="border-bottom : none;">${sheathing[i].dimAfterEndNom}</span>
                                                        </td>

                                                        <td>${sheathing[i].weightStandard}</td>
                                                        <td>${sheathing[i].weightActual}</td>
                                                        <td class="text-light ${(sheathing[i].weightDeviation > 0) ? 'bg-danger' : 'bg-success'}">${(sheathing[i].weightDeviation).toFixed(2) + '%'}</td>
                                                        <td class="remark">
                                                        <i class="fas fa-edit text-info" onclick="remark('sheathing', ${sheathing[i].id})"></i>
                                                        ${(remarkOfCurentActual == undefined) ? '' : remarkOfCurentActual.remark}
                                                        </td>
                                                        </tr>`);

                filterOfExtrusionReport['SN']++;

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
    $(this).attr('data-insulation-count-rows', parseInt($(this).attr('data-insulation-count-rows')) + 10);
    $(this).attr('data-bedding-count-rows', parseInt($(this).attr('data-bedding-count-rows')) + 10);
    $(this).attr('data-sheathing-count-rows', parseInt($(this).attr('data-sheathing-count-rows')) + 10);
    GetData('Extrusion', this, true);
});

$("#Filter").click(function () {
    $("#Limit").attr('data-insulation-count-rows', 10);
    $("#Limit").attr('data-bedding-count-rows', 10);
    $("#Limit").attr('data-sheathing-count-rows', 10);
    GetData('Extrusion', this);
});

//Function To Add Remark
function remark(sheet_name, id) {
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    dataForm['report_id'] = id;
    dataForm['report_name'] = sheet_name;
    // console.log(dataForm);
    $.ajax({
        'url': "Extrusion/getRemark",
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            // console.log(data);
            // return 0;
            $('#Remark').find('textarea').eq(0).val(data);
            $('body').css('overflow', 'hidden');
            $("#Remark form").attr('data-id', id);
            $("#Remark form").attr('data-name', sheet_name);
            $('#Remark').fadeIn(500);
            $('#Remark .box').animate({ top: 0 }, 1000);


        },
        'error': function (data) {
        },
    });
}

//Function To Update Remark Of That Row Who Remarked
function updateRemark(id, sheetName, remark) {

    $(`#Data .report .table tbody tr[data-id="${id}, ${sheetName}"] td.remark`).html(`
        <i class="fas fa-edit text-info" onclick="remark('${sheetName}' ,${id})"></i>
        ${remark}
    `);

}

// To FadeOut Remark Form After make Click on Close Button
$("#Remark i").click(function () {
    $('body').css('overflow', 'auto');
    $("#Remark").fadeOut(500);
    $('#Remark .box').css('top', '-600px');
});

$("#Remark form").submit(function (e) {
    e.preventDefault();
    let that = this;
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    dataForm['remark'] = {
        'report_name': $(this).attr('data-name'),
        'report_id': $(this).attr('data-id'),
        'remark': $(this).find('textarea').eq(0).val()
    };
    $.ajax({
        'url': $(this).attr('action'),
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data);
            // return 0;
            $('body').css('overflow', 'auto');
            $("#Remark").fadeOut(500);
            $('#Remark .box').css('top', '-600px');
            updateRemark($(that).attr('data-id'), $(that).attr('data-name'), $(that).find('textarea').eq(0).val());
        },
        'error': function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
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
    dataForm['filter'] = filterOfExtrusionReport;

    // console.log(dataForm);

    $.ajax({
        'url': 'Extrusion/printData',
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            console.log(data);

            let insulation = data['insulation'][0];
            let insulationRemarks = data['insulation'][1];
            let countOfExtrusionRows_insulation = data['insulation'][2];

            let bedding = data['bedding'][0];
            let beddingRemarks = data['bedding'][1];
            let countOfExtrusionRows_bedding = data['bedding'][2];

            let sheathing = data['sheathing'][0];
            let sheathingRemarks = data['sheathing'][1];
            let countOfExtrusionRows_sheathing = data['sheathing'][2];


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

            let tableHeadOfExtrusion = `<thead>
                                        <tr>
                                        <th>SN</th>
                                        <th>Date / Time</th>
                                        <th>Shift</th>
                                        <th>Machine</th>
                                        <th>jop Order Number</th>
                                        <th>Size</th>
                                        <th>Process</th>
                                        <th class="text-center pb-0 px-0 twoColumns" colspan="2">
                                        Input
                                        <div class="row m-0 mt-2">
                                        <span class="col-6 p-0 m-0 text-center">Drum</span>
                                        <span class="col-6 p-0 m-0 text-center">Length</span>
                                        </div>
                                        </th>
                                        <th class="text-center pb-0 px-0 twoColumns" colspan="2">
                                        Output
                                        <div class="row m-0 mt-2">
                                        <span class="col-6 p-0 m-0 text-center">Drum</span>
                                        <span class="col-6 p-0 m-0 text-center">Length</span>
                                        </div>
                                        </th>
                                        <th class="text-center pb-0 px-0 fourColumns" colspan="4">
                                        Thickness
                                        <div class="row m-0 mt-2">
                                        <span class="col-3 p-0 m-0 text-center">TDS</span>
                                        <span class="col-3 p-0 m-0 text-center">Min</span>
                                        <span class="col-3 p-0 m-0 text-center">Nom</span>
                                        <span class="col-3 p-0 m-0 text-center">Max</span>
                                        </div>
                                        </th>
                                        <th class="text-center pb-0 px-0 threeColumns" colspan="3">
                                        Diameter
                                        <div class="row m-0 mt-2">
                                        <span class="col-4 p-0 m-0 text-center">Before</span>
                                        <span class="col-4 p-0 m-0 text-center">TDS</span>
                                        <span class="col-4 p-0 m-0 text-center">After</span>
                                        </div>
                                        </th>
                                        <th class="text-center pb-0 px-0 threeColumns" colspan="3">
                                        Weight
                                        <div class="row m-0 mt-2">
                                        <span class="col-4 p-0 m-0 text-center">TDS</span>
                                        <span class="col-4 p-0 m-0 text-center">Actual</span>
                                        <span class="col-4 p-0 m-0 text-center">Deviation</span>
                                        </div>
                                        </th>
                                        <th class="remark">Remarks</th>
                                        </tr>
                                        </thead>`;

            let extrusionReport = ``;
            let printContent = '';

            function createInsulationRow(i) {
                let remarkOfCurentActual = insulationRemarks.find(object => object.report_id == insulation[i].id);

                return `<tr>
                        <td>${i + 1}</td>
                        <td>${insulation[i].created_at.split(" ").join("<br>")}</td>
                        <td>${romanShift(insulation[i].shift)}</td>
                        <td>${insulation[i].machine}</td>
                        <td>${insulation[i].jopOrderNumber}</td>
                        <td>${insulation[i].cableSize}</td>
                        <td>Insulation</td>
                        <td class="fix">${insulation[i].inputDrum}</td>
                        <td class="fix">${insulation[i].inputLength}</td>
                        <td class="fix">${insulation[i].outputDrum}</td>
                        <td class="fix">${insulation[i].outputLength}</td>
                        <td class="prepareInput">
                        <span>${insulation[i].thicknessMinStandard}</span> 
                        <span style="border-bottom : 1px solid #000;">${insulation[i].thicknessNomStandard}</span> 
                        <span style="border-bottom : none;">${insulation[i].thicknessMaxStandard}</span> 
                        </td>
                        <td class="prepareInput">
                        <span>${insulation[i].thicknessStartMinActual}</span> 
                        <span style="border-bottom : none;">${insulation[i].thicknessEndMinActual}</span> 
                        </td>
                        <td class="prepareInput">
                        <span>${insulation[i].thicknessStartNomActual}</span> 
                        <span style="border-bottom : none;">${insulation[i].thicknessEndNomActual}</span> 
                        </td>
                        <td class="prepareInput">
                        <span>${insulation[i].thicknessStartMaxActual}</span> 
                        <span style="border-bottom : none;">${insulation[i].thicknessEndMaxActual}</span> 
                        </td>
                        <td class="prepareInput">
                        <span>${insulation[i].dimBefore1}</span> 
                        <span style="border-bottom : none;">${(insulation[i].dimBefore2 == null) ? '' : insulation[i].dimBefore2}</span>
                        </td>
                        <td>${insulation[i].outerDim}</td>
                        <td class="prepareInput">
                        <span>${insulation[i].dimAfterStartNom}</span> 
                        <span style="border-bottom : none;">${insulation[i].dimAfterEndNom}</span>
                        </td>
                        <td>${insulation[i].weightStandard}</td>
                        <td>${insulation[i].weightActual}</td>
                        <td>${(insulation[i].weightDeviation).toFixed(2) + '%'}</td>
                        <td class="remark">
                        ${(remarkOfCurentActual == undefined) ? '' : remarkOfCurentActual.remark}
                        </td>
                        </tr>`;
            }

            function createBeddingRow(i) {
                let remarkOfCurentActual = beddingRemarks.find(object => object.report_id == bedding[i].id);

                return `<tr>
                        <td>${i + 1}</td>
                        <td>${bedding[i].created_at.split(" ").join("<br>")}</td>
                        <td>${romanShift(bedding[i].shift)}</td>
                        <td>${bedding[i].machine}</td>
                        <td>${bedding[i].jopOrderNumber}</td>
                        <td>${bedding[i].cableSize}</td>
                        <td>Bedding</td>
                        <td class="fix">${bedding[i].inputDrum}</td>
                        <td class="fix">${bedding[i].inputLength}</td>
                        <td class="fix">${bedding[i].outputDrum}</td>
                        <td class="fix">${bedding[i].outputLength}</td>
                        <td class="prepareInput">
                        <span>${bedding[i].thicknessMinStandard}</span> 
                        <span style="border-bottom : 1px solid #000;">${bedding[i].thicknessNomStandard}</span> 
                        <span style="border-bottom : none;">${bedding[i].thicknessMaxStandard}</span> 
                        </td>
                        <td class="prepareInput">
                        <span>${bedding[i].thicknessStartMinActual}</span> 
                        <span style="border-bottom : none;">${bedding[i].thicknessEndMinActual}</span> 
                        </td>
                        <td class="prepareInput">
                        <span>${bedding[i].thicknessStartNomActual}</span> 
                        <span style="border-bottom : none;">${bedding[i].thicknessEndNomActual}</span> 
                        </td>
                        <td class="prepareInput">
                        <span>${bedding[i].thicknessStartMaxActual}</span> 
                        <span style="border-bottom : none;">${bedding[i].thicknessEndMaxActual}</span> 
                        </td>
                        <td class="prepareInput">
                        <span>${bedding[i].dimBefore1}</span> 
                        <span style="border-bottom : none;">${(bedding[i].dimBefore2 == null) ? '' : bedding[i].dimBefore2}</span>
                        </td>
                        <td>${bedding[i].outerDim}</td>
                        <td class="prepareInput">
                        <span>${bedding[i].dimAfterStartNom}</span> 
                        <span style="border-bottom : none;">${bedding[i].dimAfterEndNom}</span>
                        </td>
                        <td>${bedding[i].weightStandard}</td>
                        <td>${bedding[i].weightActual}</td>
                        <td class="text-light ${(bedding[i].weightDeviation > 0) ? 'bg-danger' : 'bg-success'}">${(bedding[i].weightDeviation).toFixed(2) + '%'}</td>
                        <td class="remark">
                        ${(remarkOfCurentActual == undefined) ? '' : remarkOfCurentActual.remark}
                        </td>
                        </tr>`;
            }

            function createSheathingRow(i) {
                let remarkOfCurentActual = sheathingRemarks.find(object => object.report_id == sheathing[i].id);

                return `<tr>
                        <td>${i + 1}</td>
                        <td>${sheathing[i].created_at.split(" ").join("<br>")}</td>
                        <td>${romanShift(sheathing[i].shift)}</td>
                        <td>${sheathing[i].machine}</td>
                        <td>${sheathing[i].jopOrderNumber}</td>
                        <td>${sheathing[i].cableSize}</td>
                        <td>Sheathing</td>
                        <td class="fix">${sheathing[i].inputDrum}</td>
                        <td class="fix">${sheathing[i].inputLength}</td>
                        <td class="fix">${sheathing[i].outputDrum}</td>
                        <td class="fix">${sheathing[i].outputLength}</td>
                        <td class="prepareInput">
                        <span>${sheathing[i].thicknessMinStandard}</span> 
                        <span style="border-bottom : 1px solid #000;">${sheathing[i].thicknessNomStandard}</span> 
                        <span style="border-bottom : none;">${sheathing[i].thicknessMaxStandard}</span> 
                        </td>
                        <td class="prepareInput">
                        <span>${sheathing[i].thicknessStartMinActual}</span> 
                        <span style="border-bottom : none;">${sheathing[i].thicknessEndMinActual}</span> 
                        </td>
                        <td class="prepareInput">
                        <span>${sheathing[i].thicknessStartNomActual}</span> 
                        <span style="border-bottom : none;">${sheathing[i].thicknessEndNomActual}</span> 
                        </td>
                        <td class="prepareInput">
                        <span>${sheathing[i].thicknessStartMaxActual}</span> 
                        <span style="border-bottom : none;">${sheathing[i].thicknessEndMaxActual}</span> 
                        </td>
                        <td class="prepareInput">
                        <span>${sheathing[i].dimBefore1}</span> 
                        <span style="border-bottom : none;">${(sheathing[i].dimBefore2 == null) ? '' : sheathing[i].dimBefore2}</span>
                        </td>
                        <td>${sheathing[i].outerDim}</td>
                        <td class="prepareInput">
                        <span>${sheathing[i].dimAfterStartNom}</span> 
                        <span style="border-bottom : none;">${sheathing[i].dimAfterEndNom}</span>
                        </td>
                        <td>${sheathing[i].weightStandard}</td>
                        <td>${sheathing[i].weightActual}</td>
                        <td class="text-light ${(sheathing[i].weightDeviation > 0) ? 'bg-danger' : 'bg-success'}">${(sheathing[i].weightDeviation).toFixed(2) + '%'}</td>
                        <td class="remark">
                        ${(remarkOfCurentActual == undefined) ? '' : remarkOfCurentActual.remark}
                        </td>
                        </tr>`;
            }

            let insulationRound = 0;
            let beddingRound = 0;
            let sheathingRound = 0;
            // Prepare Pages To Print it
            for (let i = 0, j = 1; i < (insulation.length + bedding.length + sheathing.length); i++, j++) {
                let extrusionReportRow;
                if (i < insulation.length) {
                    extrusionReportRow = createInsulationRow(insulationRound);
                    insulationRound++;
                } else if (i < (insulation.length + bedding.length)) {
                    extrusionReportRow = createBeddingRow(beddingRound);
                    beddingRound++;
                } else if (i < (insulation.length + bedding.length + sheathing.length)) {
                    extrusionReportRow = createSheathingRow(sheathingRound);
                    sheathingRound++;
                }

                if (j % 4 != 0 && j != (insulation.length + bedding.length + sheathing.length)) {
                    extrusionReport += extrusionReportRow;
                } else if (j % 4 == 0) {
                    extrusionReport += extrusionReportRow;

                    let extrusionTable = `<div class="report mt-5 Taps">
                                                <table class="table table-hover">
                                                ${tableHeadOfExtrusion}
                                                <tbody>
                                                ${extrusionReport}
                                                </tbody>
                                                </table>
                                                </div>`;

                    let page = '<div class="page">' + pageNav + extrusionTable + '</div>';
                    printContent += page;
                    extrusionReport = ``;
                } else {
                    extrusionReport += extrusionReportRow;

                    let extrusionTable = `<div class="report mt-5 Taps">
                                                <table class="table table-hover">
                                                ${tableHeadOfExtrusion}
                                                <tbody>
                                                ${extrusionReport}
                                                </tbody>
                                                </table>
                                                </div>`;

                    let page = '<div class="page">' + pageNav + extrusionTable + '</div>';
                    printContent += page;
                    extrusionReport = ``;
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


