
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

function prepareResistanceAtLength(input, resistanceStandard, returnOhmAndMetter = false) {

    let ohm = [];
    let meter = [];
    let counter = 4;

    for (let i = 0; i < 4; i++) {
        let element = '';

        if (input[i] == '') {
            ohm.push(0);
            meter.push(0);
            counter--;
        } else {
            for (let j = 0; j < input[i].length; j++) {

                if (input[i][j] != '-') {
                    element += input[i][j];
                    if (j == input[i].length - 1) {
                        meter.push(parseInt(element));
                        element = '';
                    }
                } else {
                    ohm.push(parseInt(element));
                    element = '';
                }


            }
        }


    }


    let average = (parseInt(ohm[0]) + parseInt(ohm[1]) + parseInt(ohm[2]) + parseInt(ohm[3])) / counter;

    let resistanceAtLength = `<td class="prepareInput">
                              <span class="th">START</span>
                              <span>${(ohm[0] == 0) ? '' : ohm[0]}</span>
                              </td>
                              <td class="prepareInput">
                              <span>${(meter[1] == 0) ? '' : meter[1]}</span>
                              <span>${(ohm[1] == 0) ? '' : ohm[1]}</span>
                              </td>
                              <td class="prepareInput">
                              <span>${(meter[2] == 0) ? '' : meter[2]}</span>
                              <span>${(ohm[2] == 0) ? '' : ohm[2]}</span>
                              </td>
                              <td class="prepareInput">
                              <span>${(meter[3] == 0) ? '' : meter[3]}</span>
                              <span>${(ohm[3] == 0) ? '' : ohm[3]}</span>
                              </td>
                              <td class="prepareInput">
                              <span class="th">Average</span>
                              <span>${average}</span>
                              </td>
                              <td class="prepareInput">
                              <span class="th">Deviation%</span>
                              <span class="text-light ${((average - resistanceStandard) / resistanceStandard > 0) ? 'bg-danger' : 'bg-success'}">${((average - resistanceStandard) / resistanceStandard).toFixed(2)}%</span>
                              </td>`;

    if (returnOhmAndMetter) {
        ohm.push(average, (average - resistanceStandard) / resistanceStandard);
        return ohm;
    } else {
        return resistanceAtLength;
    }

}

// Create FilterArray
let filterOfStrandingReport = {
    'jopOrderNumber': '',
    'size': '',
    'type': '',
    'shape': '',
    'angel': '',
    'weightDeviation': { 'red': true, 'green': true },
    'periodOfTime': { 'start': '', 'end': '' },
    'limit': 25
};

//To Get Data From Filter And Save It At FilterArray
$("#FilterValue").blur(function () {
    filterOfStrandingReport[$("#FilterName").val()] = $(this).val();
    if ($(this).val() != '') {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).addClass('filtered');
    } else {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).removeClass('filtered');
    }
});

// To Make Filter On Data By Period Of Date
$("#reportrange").on('apply.daterangepicker, hide.daterangepicker', function (ev, picker) {
    cb(picker.startDate, picker.endDate);
    filterOfStrandingReport["periodOfTime"]['start'] = $("#reportrange span").attr('data-rangedatestart');
    filterOfStrandingReport["periodOfTime"]['end'] = $("#reportrange span").attr('data-rangedateend');
    $('#FilterName').find(`option[value="periodOfTime"]`).addClass('filtered');
});

// To Get Back All Data After Click On Cancel
$("#reportrange").on('cancel.daterangepicker', function () {
    filterOfStrandingReport["periodOfTime"]['start'] = "";
    filterOfStrandingReport["periodOfTime"]['end'] = "";
    $("#reportrange span").text('');
    $("#reportrange span").attr('data-rangedatestart', '');
    $("#reportrange span").attr('data-rangedateend', '');
    $('#FilterName').find(`option[value="periodOfTime"]`).removeClass('filtered');
});

$("#FilterName").change(function () {
    if ($(this).val() == "periodOfTime") {
        $("#reportrange span").text(`${filterOfStrandingReport["periodOfTime"]['start']} - ${filterOfStrandingReport["periodOfTime"]['end']}`);
        $('#reportrange').css('display', 'block');
        $("#WeightDeviation").css('display', 'none');
        $("#FilterValue").css('display', 'none');
    } else if ($(this).val() == "weightDeviation") {
        $('#reportrange').css('display', 'none');
        $("#FilterValue").css('display', 'none');
        $("#WeightDeviation").css('display', 'flex');
    } else {
        $("#FilterValue").val(filterOfStrandingReport[$(this).val()]);
        $('#reportrange').css('display', 'none');
        $("#WeightDeviation").css('display', 'none');
        $("#FilterValue").css('display', 'block');
    }
});

//To Save Data That he Want To
function weightDeviationFilter(that) {
    if (!$('input#Red').prop('checked') && !$('input#Green').prop('checked')) {
        $(that).prop('checked', false);
        $('#WeightDeviation input').not(that).prop('checked', true);
    }

    filterOfStrandingReport['weightDeviation']['red'] = $('input#Red').prop('checked');
    filterOfStrandingReport['weightDeviation']['green'] = $('input#Green').prop('checked');
    if ($('input#Red').prop('checked') && $('input#Green').prop('checked')) {
        $('#FilterName').find(`option[value="weightDeviation"]`).removeClass('filtered');
    } else {
        $('#FilterName').find(`option[value="weightDeviation"]`).addClass('filtered');
    }
}

// This variable to Store Values Of All of Average That Create by Button Get More
let valuesOfAverageRows = {
    'sumStandardWeight': { 'sum': 0, 'count': 0 },
    'sumActualWeight': { 'sum': 0, 'count': 0 },
    'sumDeviationWeight': { 'sum': 0, 'count': 0 },
    'sumStandardResistance': { 'sum': 0, 'count': 0 },
    'sumActualResistance1': { 'sum': 0, 'count': 0 },
    'sumActualResistance2': { 'sum': 0, 'count': 0 },
    'sumActualResistance3': { 'sum': 0, 'count': 0 },
    'sumActualResistance4': { 'sum': 0, 'count': 0 },
    'sumOfAvarageResistance': { 'sum': 0, 'count': 0 },
    'sumDeviationResistance': { 'sum': 0, 'count': 0 }
};

// Function To Get Data Of Stranding By JopOrderNumber
function GetData(Url, that = null, moreData = false) {
    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    filterOfStrandingReport['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    dataForm['filter'] = filterOfStrandingReport;
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

            let stranding = data[0];
            let remarks = data[1];
            let countOfStandardsRows = data[2];

            if (countOfStandardsRows > filterOfStrandingReport['limit']) {
                $("#Limit").removeClass('d-none');
            } else {
                $("#Limit").addClass('d-none');
            }

            if (stranding.length == 0) {
                $('p.alert').removeClass('d-none');
                $('#Data .report .table tbody').html('');
                return 0;
            } else {
                $('p.alert').addClass('d-none');
            }

            /* ================================ */

            if (!moreData) {
                $('#Data .report .table tbody').html('');
                valuesOfAverageRows = {
                    'sumStandardWeight': { 'sum': 0, 'count': 0 },
                    'sumActualWeight': { 'sum': 0, 'count': 0 },
                    'sumDeviationWeight': { 'sum': 0, 'count': 0 },
                    'sumStandardResistance': { 'sum': 0, 'count': 0 },
                    'sumActualResistance1': { 'sum': 0, 'count': 0 },
                    'sumActualResistance2': { 'sum': 0, 'count': 0 },
                    'sumActualResistance3': { 'sum': 0, 'count': 0 },
                    'sumActualResistance4': { 'sum': 0, 'count': 0 },
                    'sumOfAvarageResistance': { 'sum': 0, 'count': 0 },
                    'sumDeviationResistance': { 'sum': 0, 'count': 0 }
                };
            } else {
                $('#Data .report .table tbody tr').last().remove();
            }


            for (let i = 0; i < stranding.length; i++) {
                let remarkOfCurentStranding = remarks.find(object => object.report_id == stranding[i].id);
                $('#Data .report .table tbody').append(`<tr data-id="${stranding[i].id}">
                                                        <td>${(filterOfStrandingReport['limit'] - 24) + i}</td>
                                                        <td>${stranding[i].jopOrderNumber}</td>
                                                        <td>${stranding[i].created_at.split(" ").join("<br>")}</td>
                                                        <td>${stranding[i].size}</td>
                                                        <td>${stranding[i].type}</td>
                                                        <td>${stranding[i].angel + " " + stranding[i].shape}</td>
                                                        <td>${stranding[i].constructionActual}</td>
                                                        <td>${stranding[i].drumNumber}</td>
                                                        <td>${stranding[i].conductorWeightStandard}</td>
                                                        <td>${stranding[i].conductorWeightActual}</td>
                                                        <td class="text-light ${(stranding[i].weightDeviation > 0) ? 'bg-danger' : 'bg-success'}">${(stranding[i].weightDeviation).toFixed(2)}%</td>
                                                        <td class="prepareInput">
                                                        <span class="th">Standard</span>
                                                        <span>${stranding[i].resistance}</span>
                                                        </td>
                                                        <td class="prepareInput">
                                                        <span class="th">START</span>
                                                        <span>${(stranding[i].resistance1 == null) ? '' : stranding[i].resistance1}</span>
                                                        </td>
                                                        <td class="prepareInput">
                                                        <span>${(stranding[i].length2 == null) ? '' : stranding[i].length2}</span>
                                                        <span>${(stranding[i].resistance2 == null) ? '' : stranding[i].resistance2}</span>
                                                        </td>
                                                        <td class="prepareInput">
                                                        <span>${(stranding[i].length3 == null) ? '' : stranding[i].length3}</span>
                                                        <span>${(stranding[i].resistance3 == null) ? '' : stranding[i].resistance3}</span>
                                                        </td>
                                                        <td class="prepareInput">
                                                        <span>${(stranding[i].length4 == null) ? '' : stranding[i].length4}</span>
                                                        <span>${(stranding[i].resistance4 == null) ? '' : stranding[i].resistance4}</span>
                                                        </td>
                                                        <td class="prepareInput">
                                                        <span class="th">Average</span>
                                                        <span>${(stranding[i].avgResistance).toFixed(2)}</span>
                                                        </td>
                                                        <td class="prepareInput">
                                                        <span class="th">Deviation%</span>
                                                        <span class="text-light ${(stranding[i].resistanceDeviation > 0) ? 'bg-danger' : 'bg-success'}">${(stranding[i].resistanceDeviation).toFixed(2)}%</span>
                                                        </td>
                                                        <td class="remark">
                                                        <i class="fas fa-edit text-info" onclick="remark(${stranding[i].id})"></i>
                                                        ${(remarkOfCurentStranding == undefined) ? '' : remarkOfCurentStranding.remark}
                                                        </td>
                                                        </tr>`);

                //To Calculate Sum Of Avarage Of Table
                valuesOfAverageRows['sumStandardWeight']['sum'] += parseFloat(stranding[i].conductorWeightStandard);
                valuesOfAverageRows['sumActualWeight']['sum'] += parseFloat(stranding[i].conductorWeightActual);
                valuesOfAverageRows['sumDeviationWeight']['sum'] += parseFloat(stranding[i].weightDeviation);
                valuesOfAverageRows['sumStandardResistance']['sum'] += parseFloat(stranding[i].resistance);
                valuesOfAverageRows['sumActualResistance1']['sum'] += parseFloat(stranding[i].resistance1);
                valuesOfAverageRows['sumActualResistance2']['sum'] += parseFloat((stranding[i].resistance2 == null) ? 0 : stranding[i].resistance2);
                valuesOfAverageRows['sumActualResistance3']['sum'] += parseFloat((stranding[i].resistance3 == null) ? 0 : stranding[i].resistance3);
                valuesOfAverageRows['sumActualResistance4']['sum'] += parseFloat((stranding[i].resistance4 == null) ? 0 : stranding[i].resistance4);
                valuesOfAverageRows['sumOfAvarageResistance']['sum'] += parseFloat(stranding[i].avgResistance);
                valuesOfAverageRows['sumDeviationResistance']['sum'] += parseFloat(stranding[i].resistanceDeviation);

                //To Calculate Count Of Avarage Of Table
                valuesOfAverageRows['sumStandardWeight']['count'] += (stranding[i].conductorWeightStandard == null) ? 0 : 1;
                valuesOfAverageRows['sumActualWeight']['count'] += (stranding[i].conductorWeightActual == null) ? 0 : 1;
                valuesOfAverageRows['sumDeviationWeight']['count'] += (stranding[i].weightDeviation == null) ? 0 : 1;
                valuesOfAverageRows['sumStandardResistance']['count'] += (stranding[i].resistance == null) ? 0 : 1;
                valuesOfAverageRows['sumActualResistance1']['count'] += (stranding[i].resistance1 == null) ? 0 : 1;
                valuesOfAverageRows['sumActualResistance2']['count'] += (stranding[i].resistance2 == null) ? 0 : 1;
                valuesOfAverageRows['sumActualResistance3']['count'] += (stranding[i].resistance3 == null) ? 0 : 1;
                valuesOfAverageRows['sumActualResistance4']['count'] += (stranding[i].resistance4 == null) ? 0 : 1;
                valuesOfAverageRows['sumOfAvarageResistance']['count'] += (stranding[i].avgResistance == null) ? 0 : 1;
                valuesOfAverageRows['sumDeviationResistance']['count'] += (stranding[i].resistanceDeviation == null) ? 0 : 1;

            }


            //To Add Avarage Row
            if (stranding.length > 0) {
                $('#StartPrint').prop('disabled', false);
                $('#Data .report .table tbody').append(`<tr>
                <td class="th" colspan="8">Average</td>
                <td>${(valuesOfAverageRows['sumStandardWeight']['sum'] / valuesOfAverageRows['sumStandardWeight']['count']).toFixed(2)}</td>
                <td>${(valuesOfAverageRows['sumActualWeight']['sum'] / valuesOfAverageRows['sumActualWeight']['count']).toFixed(2)}</td>
                <td>${(valuesOfAverageRows['sumDeviationWeight']['sum'] / valuesOfAverageRows['sumDeviationWeight']['count']).toFixed(2)}</td>
                <td>${(valuesOfAverageRows['sumStandardResistance']['sum'] / valuesOfAverageRows['sumStandardResistance']['count']).toFixed(2)}</td>
                <td>${(valuesOfAverageRows['sumActualResistance1']['sum'] / valuesOfAverageRows['sumActualResistance1']['count']).toFixed(2)}</td>
                <td>${(valuesOfAverageRows['sumActualResistance2']['sum'] / valuesOfAverageRows['sumActualResistance2']['count']).toFixed(2)}</td>
                <td>${(valuesOfAverageRows['sumActualResistance3']['sum'] / valuesOfAverageRows['sumActualResistance3']['count']).toFixed(2)}</td>
                <td>${(valuesOfAverageRows['sumActualResistance4']['sum'] / valuesOfAverageRows['sumActualResistance4']['count']).toFixed(2)}</td>
                <td>${(valuesOfAverageRows['sumOfAvarageResistance']['sum'] / valuesOfAverageRows['sumOfAvarageResistance']['count']).toFixed(2)}</td>
                <td>${(valuesOfAverageRows['sumDeviationResistance']['sum'] / valuesOfAverageRows['sumDeviationResistance']['count']).toFixed(2)}</td>
                <td></td>
                </tr>`);
            } else {
                $('#StartPrint').prop('disabled', true);
                $('p.alert').removeClass('d-none');
                $('#Data .report .table tbody').html('');
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
    GetData('Stranding', this, true);
});

$("#Filter").click(function () {
    $("#Limit").attr('data-count-rows', 25);
    GetData('Stranding', this);
});

//Function To Add Remark
function remark(id) {
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    dataForm['report_id'] = id;
    // console.log(dataForm);
    $.ajax({
        'url': "Stranding/getRemark",
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            // console.log(data);
            // return 0;
            $('#Remark').find('textarea').eq(0).val(data);
            $('body').css('overflow', 'hidden');
            $("#Remark form").attr('data-id', id);
            $('#Remark').fadeIn(500);
            $('#Remark .box').animate({ top: 0 }, 1000);


        },
        'error': function (data) {
        },
    });
}

//Function To Update Remark Of That Row Who Remarked
function updateRemark(id, remark) {

    $(`#Data .report .table tbody tr[data-id="${id}"] td.remark`).html(`
        <i class="fas fa-edit text-info" onclick="remark(${id})"></i>
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
        'report_name': 'stranding',
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
            updateRemark($(that).attr('data-id'), $(that).find('textarea').eq(0).val());
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
    dataForm['filter'] = filterOfStrandingReport;

    // console.log(dataForm);

    $.ajax({
        'url': 'Stranding/printData',
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data);


            let stranding = data[0];
            let remarks = data[1];

            let valuesOfAverageRows_Printer = {
                'sumStandardWeight': { 'sum': 0, 'count': 0 },
                'sumActualWeight': { 'sum': 0, 'count': 0 },
                'sumDeviationWeight': { 'sum': 0, 'count': 0 },
                'sumStandardResistance': { 'sum': 0, 'count': 0 },
                'sumActualResistance1': { 'sum': 0, 'count': 0 },
                'sumActualResistance2': { 'sum': 0, 'count': 0 },
                'sumActualResistance3': { 'sum': 0, 'count': 0 },
                'sumActualResistance4': { 'sum': 0, 'count': 0 },
                'sumOfAvarageResistance': { 'sum': 0, 'count': 0 },
                'sumDeviationResistance': { 'sum': 0, 'count': 0 }
            };

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

            let tableHeadOfStranding = `<thead>
                                        <tr>
                                        <th>SN</th>
                                        <th>Jop Order Number</th>
                                        <th>Date / Time</th>
                                        <th>Size</th>
                                        <th>Type</th>
                                        <th>Shape</th>
                                        <th>Construction</th>
                                        <th class="text-center pb-0 px-0 fourColumns" colspan="4">
                                        Weight (kg/km)
                                        <div class="row m-0 mt-2">
                                        <span class="col-3 p-0 m-0 text-center">Drum No</span>
                                        <span class="col-3 p-0 m-0 text-center">Standard</span>
                                        <span class="col-3 p-0 m-0 text-center">Actual</span>
                                        <span class="col-3 p-0 m-0 text-center">Deviation%</span>
                                        </div>
                                        </th>
                                        <th colspan="7">Resistance</th>
                                        <th>Remarks</th>
                                        </tr>
                                        </thead>`;

            let strandingReport = ``;
            let printContent = '';

            function createStrandingReportRow(i, remarkOfCurentStranding) {
                return `<tr>
                        <td>${i + 1}</td>
                        <td>${stranding[i].jopOrderNumber}</td>
                        <td>${stranding[i].created_at.split(" ").join("<br>")}</td>
                        <td>${stranding[i].size}</td>
                        <td>${stranding[i].type}</td>
                        <td>${stranding[i].angel + " " + stranding[i].shape}</td>
                        <td>${stranding[i].constructionActual}</td>
                        <td>${stranding[i].drumNumber}</td>
                        <td>${stranding[i].conductorWeightStandard}</td>
                        <td>${stranding[i].conductorWeightActual}</td>
                        <td>${(stranding[i].weightDeviation).toFixed(2)}%</td>
                        <td class="prepareInput">
                        <span class="th">Standard</span>
                        <span>${stranding[i].resistance}</span>
                        </td>
                        <td class="prepareInput">
                        <span class="th">START</span>
                        <span>${(stranding[i].resistance1 == null) ? '' : stranding[i].resistance1}</span>
                        </td>
                        <td class="prepareInput">
                        <span>${(stranding[i].length2 == null) ? '' : stranding[i].length2}</span>
                        <span>${(stranding[i].resistance2 == null) ? '' : stranding[i].resistance2}</span>
                        </td>
                        <td class="prepareInput">
                        <span>${(stranding[i].length3 == null) ? '' : stranding[i].length3}</span>
                        <span>${(stranding[i].resistance3 == null) ? '' : stranding[i].resistance3}</span>
                        </td>
                        <td class="prepareInput">
                        <span>${(stranding[i].length4 == null) ? '' : stranding[i].length4}</span>
                        <span>${(stranding[i].resistance4 == null) ? '' : stranding[i].resistance4}</span>
                        </td>
                        <td class="prepareInput">
                        <span class="th">Average</span>
                        <span>${stranding[i].avgResistance}</span>
                        </td>
                        <td class="prepareInput">
                        <span class="th">Deviation%</span>
                        <span>${(stranding[i].resistanceDeviation).toFixed(2)}%</span>
                        </td>
                        <td class="remark">
                        ${(remarkOfCurentStranding == undefined) ? '' : remarkOfCurentStranding.remark}
                        </td>
                        </tr>`;
            }

            // Prepare Pages To Print it
            for (let i = 0, j = 1; i < stranding.length; i++, j++) {
                let remarkOfCurentStranding = remarks.find(object => object.report_id == stranding[i].id);
                let strandingReportRow = createStrandingReportRow(i, remarkOfCurentStranding);

                //To Calculate Sum Of Avarage Of Table
                valuesOfAverageRows_Printer['sumStandardWeight']['sum'] += parseFloat(stranding[i].conductorWeightStandard);
                valuesOfAverageRows_Printer['sumActualWeight']['sum'] += parseFloat(stranding[i].conductorWeightActual);
                valuesOfAverageRows_Printer['sumDeviationWeight']['sum'] += parseFloat(stranding[i].weightDeviation);
                valuesOfAverageRows_Printer['sumStandardResistance']['sum'] += parseFloat(stranding[i].resistance);
                valuesOfAverageRows_Printer['sumActualResistance1']['sum'] += parseFloat(stranding[i].resistance1);
                valuesOfAverageRows_Printer['sumActualResistance2']['sum'] += parseFloat((stranding[i].resistance2 == null) ? 0 : stranding[i].resistance2);
                valuesOfAverageRows_Printer['sumActualResistance3']['sum'] += parseFloat((stranding[i].resistance3 == null) ? 0 : stranding[i].resistance3);
                valuesOfAverageRows_Printer['sumActualResistance4']['sum'] += parseFloat((stranding[i].resistance4 == null) ? 0 : stranding[i].resistance4);
                valuesOfAverageRows_Printer['sumOfAvarageResistance']['sum'] += parseFloat(stranding[i].avgResistance);
                valuesOfAverageRows_Printer['sumDeviationResistance']['sum'] += parseFloat(stranding[i].resistanceDeviation);

                //To Calculate Count Of Avarage Of Table
                valuesOfAverageRows_Printer['sumStandardWeight']['count'] += (stranding[i].conductorWeightStandard == null) ? 0 : 1;
                valuesOfAverageRows_Printer['sumActualWeight']['count'] += (stranding[i].conductorWeightActual == null) ? 0 : 1;
                valuesOfAverageRows_Printer['sumDeviationWeight']['count'] += (stranding[i].weightDeviation == null) ? 0 : 1;
                valuesOfAverageRows_Printer['sumStandardResistance']['count'] += (stranding[i].resistance == null) ? 0 : 1;
                valuesOfAverageRows_Printer['sumActualResistance1']['count'] += (stranding[i].resistance1 == null) ? 0 : 1;
                valuesOfAverageRows_Printer['sumActualResistance2']['count'] += (stranding[i].resistance2 == null) ? 0 : 1;
                valuesOfAverageRows_Printer['sumActualResistance3']['count'] += (stranding[i].resistance3 == null) ? 0 : 1;
                valuesOfAverageRows_Printer['sumActualResistance4']['count'] += (stranding[i].resistance4 == null) ? 0 : 1;
                valuesOfAverageRows_Printer['sumOfAvarageResistance']['count'] += (stranding[i].avgResistance == null) ? 0 : 1;
                valuesOfAverageRows_Printer['sumDeviationResistance']['count'] += (stranding[i].resistanceDeviation == null) ? 0 : 1;

                if (j % 4 != 0 && j != stranding.length) {
                    strandingReport += strandingReportRow;
                } else if (j % 4 == 0) {
                    strandingReport += strandingReportRow;
                    let avarageRow = `<tr>
                    <td class="th" colspan="8">Average</td>
                    <td>${(valuesOfAverageRows_Printer['sumStandardWeight']['sum'] / valuesOfAverageRows_Printer['sumStandardWeight']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumActualWeight']['sum'] / valuesOfAverageRows_Printer['sumActualWeight']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumDeviationWeight']['sum'] / valuesOfAverageRows_Printer['sumDeviationWeight']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumStandardResistance']['sum'] / valuesOfAverageRows_Printer['sumStandardResistance']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumActualResistance1']['sum'] / valuesOfAverageRows_Printer['sumActualResistance1']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumActualResistance2']['sum'] / valuesOfAverageRows_Printer['sumActualResistance2']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumActualResistance3']['sum'] / valuesOfAverageRows_Printer['sumActualResistance3']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumActualResistance4']['sum'] / valuesOfAverageRows_Printer['sumActualResistance4']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumOfAvarageResistance']['sum'] / valuesOfAverageRows_Printer['sumOfAvarageResistance']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumDeviationResistance']['sum'] / valuesOfAverageRows_Printer['sumDeviationResistance']['count']).toFixed(2)}</td>
                    <td></td>
                    </tr>`;

                    let strandingTable = `<div class="report mt-5 Taps">
                                                <table class="table table-hover">
                                                ${tableHeadOfStranding}
                                                <tbody>
                                                ${strandingReport + avarageRow}
                                                </tbody>
                                                </table>
                                                </div>`;

                    let page = '<div class="page">' + pageNav + strandingTable + '</div>';
                    printContent += page;
                    strandingReport = ``;
                    //To Prepare Avarage Of Table To Next Page
                    valuesOfAverageRows_Printer = {
                        'sumStandardWeight': { 'sum': 0, 'count': 0 },
                        'sumActualWeight': { 'sum': 0, 'count': 0 },
                        'sumDeviationWeight': { 'sum': 0, 'count': 0 },
                        'sumStandardResistance': { 'sum': 0, 'count': 0 },
                        'sumActualResistance1': { 'sum': 0, 'count': 0 },
                        'sumActualResistance2': { 'sum': 0, 'count': 0 },
                        'sumActualResistance3': { 'sum': 0, 'count': 0 },
                        'sumActualResistance4': { 'sum': 0, 'count': 0 },
                        'sumOfAvarageResistance': { 'sum': 0, 'count': 0 },
                        'sumDeviationResistance': { 'sum': 0, 'count': 0 }
                    };
                } else {
                    strandingReport += strandingReportRow;
                    let avarageRow = `<tr>
                    <td class="th" colspan="8">Average</td>
                    <td>${(valuesOfAverageRows_Printer['sumStandardWeight']['sum'] / valuesOfAverageRows_Printer['sumStandardWeight']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumActualWeight']['sum'] / valuesOfAverageRows_Printer['sumActualWeight']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumDeviationWeight']['sum'] / valuesOfAverageRows_Printer['sumDeviationWeight']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumStandardResistance']['sum'] / valuesOfAverageRows_Printer['sumStandardResistance']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumActualResistance1']['sum'] / valuesOfAverageRows_Printer['sumActualResistance1']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumActualResistance2']['sum'] / valuesOfAverageRows_Printer['sumActualResistance2']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumActualResistance3']['sum'] / valuesOfAverageRows_Printer['sumActualResistance3']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumActualResistance4']['sum'] / valuesOfAverageRows_Printer['sumActualResistance4']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumOfAvarageResistance']['sum'] / valuesOfAverageRows_Printer['sumOfAvarageResistance']['count']).toFixed(2)}</td>
                    <td>${(valuesOfAverageRows_Printer['sumDeviationResistance']['sum'] / valuesOfAverageRows_Printer['sumDeviationResistance']['count']).toFixed(2)}</td>
                    <td></td>
                    </tr>`;
                    let strandingTable = `<div class="report mt-5 Taps">
                                                <table class="table table-hover">
                                                ${tableHeadOfStranding}
                                                <tbody>
                                                ${strandingReport + avarageRow}
                                                </tbody>
                                                </table>
                                                </div>`;

                    let page = '<div class="page">' + pageNav + strandingTable + '</div>';
                    printContent += page;
                    strandingReport = ``;
                    //To Prepare Avarage Of Table To Next Page
                    valuesOfAverageRows_Printer = {
                        'sumStandardWeight': { 'sum': 0, 'count': 0 },
                        'sumActualWeight': { 'sum': 0, 'count': 0 },
                        'sumDeviationWeight': { 'sum': 0, 'count': 0 },
                        'sumStandardResistance': { 'sum': 0, 'count': 0 },
                        'sumActualResistance1': { 'sum': 0, 'count': 0 },
                        'sumActualResistance2': { 'sum': 0, 'count': 0 },
                        'sumActualResistance3': { 'sum': 0, 'count': 0 },
                        'sumActualResistance4': { 'sum': 0, 'count': 0 },
                        'sumOfAvarageResistance': { 'sum': 0, 'count': 0 },
                        'sumDeviationResistance': { 'sum': 0, 'count': 0 }
                    };
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


