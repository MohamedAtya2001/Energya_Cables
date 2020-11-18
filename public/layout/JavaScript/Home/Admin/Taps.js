

//To Insert Taps
$('form.tapsActual').submit(function (e) {
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    e.preventDefault();

    let that = this;
    let dataForm = {};
    let token = $(this).find('input').eq(0).attr('value');
    dataForm['_token'] = token;

    for (let i = 0; i < $(this).find('.input').length; i++) {
        let key = $(this).find('.input').eq(i).attr('name');
        // Becuse if didn't  send some of data that mean he didn't make blur for input so he didn't now the time 
        let value = [$(this).find('.input').eq(i).val(), ($(this).find('.input').eq(i).attr('data-time') != "" && $(this).find('.input').eq(i).val() != "") ? $(this).find('.input').eq(i).attr('data-time') : ""];
        dataForm[key] = value;
    }
    dataForm['notes'] = [$(this).find('textarea').eq(0).val(), ($(this).find('textarea').eq(0).attr('data-time') != "" && $(this).find('textarea').eq(0).val() != "") ? $(this).find('textarea').eq(0).attr('data-time') : ""];
    dataForm['update'] = $(this).attr('data-update');
    if ($(this).attr('data-id-for-update') != undefined) {
        dataForm['id_update'] = $(this).attr('data-id-for-update');
    }

    // console.log(dataForm);

    $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: dataForm,
        success: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data);
            if (data == "Updated") {
                // console.log('ok');
                $('.dataNotComplete').find('.updated').css('display', 'none');
                $('.searchJopOrderNumberOfTaps').find('.input');
                $('.searchJopOrderNumberOfTaps').find('button');
                $($(that).find('.input')).prop('required', false);
                $($(that).find('textarea')).prop("required", false);
                $($(that).find('.input')).val('');
                $($(that).find('textarea')).val('');
                $(that).removeAttr('data-id-for-update');
                $(that).attr('data-update', false);
                $(`.dropdownalert-menu .dropdownalert-item[data-sheet-item="${$(that).parents('.popUp').attr('data-item')}"]`).attr('updated', true);
                //To Open Every Sheet If All of Alert is Done
                if ($(that).parents('.popUp').find(`.dropdownalert-menu .dropdownalert-item:not(.dropdownalert-menu .dropdownalert-item[updated="true"])`).length == 0) {
                    $('.taps').find('.input, textarea, button:not(button.text-warning)').prop('disabled', false).removeClass('error');
                    $('.taps .searchJopOrderNumberOfTaps').find('.input').prop('disabled', false);
                    $('.taps .searchJopOrderNumberOfTaps').find('button').prop('disabled', false);
                }
                // To Check after Update alert if There Another Alert,  if it true it will appeared Button Alerts Again
                else {
                    $(that).parents('.popUp').find('.dropdownalert').fadeIn(300);
                    $($(that).find('.input')).val('').prop("disabled", true);
                    $($(that).find('textarea')).val('').prop("disabled", true);
                    $($(that).find('button:not(button.text-warning)')).prop("disabled", true);
                }
                //To Hide Icon Of Clear Sheet
                $(that).parents('.box').find('.fa-trash-restore').addClass('d-none');
            } else if (data == 'Error-notes') {
                $(that).find('textarea[name="notes"]').addClass('error');
                $('.taps').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
            } else {
                $(that).find('textarea[name="notes"]').removeClass('error');
                $($(that).find('.input')).val('').prop("disabled", false);
                $($(that).find('textarea')).val('').prop("disabled", false);
            }

            // To Save Data in LocalStorage
            let inputs = $(that).find('.input');
            inputs.push($(that).find('textarea'));
            SaveDataOfTapsLocalStorage(that, inputs);

        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        },


    });

});

//To  Search jopOrderNumber Taps
$('form.searchJopOrderNumberOfTaps').submit(function (e) {
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    e.preventDefault();
    let that = this;

    $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: $(this).serialize(),
        success: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            if (typeof data === 'object') {
                delete data.id;
                delete data.created_at;
                delete data.updated_at;
                delete data.added_by;
                delete data.shift;
                let mydata = {};
                for (let key in data) {
                    mydata[`${key}`] = data[`${key}`];
                }
                // console.log(mydata);
                let inputs = $(that).siblings('form').find('.standard input');
                // console.log(inputs);
                inputPropertyName = [];
                for (let i = 0; i < inputs.length; i++) {
                    inputPropertyName[i] = $(inputs[i]).attr('name');
                }
                // console.log(inputPropertyName);

                for (let i = 0; i <= inputs.length; i++) {
                    $(inputs[i]).val(mydata[inputPropertyName[i]]).prop("disabled", true);
                    let date = new Date().toLocaleString();
                    $(inputs[i]).attr('data-time', date);
                }

                // To Save Data in LocalStorage
                SaveDataOfTapsLocalStorage(that, inputs);


            } else {
                let inputs = $(that).siblings('form').find('.standard input');
                for (let i = 0; i <= inputs.length; i++) {
                    if (i == 0) {
                        $(inputs[i]).val(data).prop("disabled", true);
                        let date = new Date().toLocaleString();
                        $(inputs[i]).attr('data-time', date);
                    } else {
                        $(inputs[i]).val('').prop("disabled", false);
                    }
                }

                // To Save Data in LocalStorage
                SaveDataOfTapsLocalStorage(that, inputs);
            }

            $(that).find('input[name="jopOrderNumber"]').eq(0).val('');

        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log("Error");

        }
    });

});

//To Get Date For User To Complete It
$('.taps .dataNotComplete form').click(function (e) {
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    e.preventDefault();
    $(this).addClass('updated');
    $(`.dropdownalert-item[data-id="${$(this).attr('data-id')}"]`).fadeOut(300).attr('data-sheet-item', $(this).parents('.popUp').attr('data-item'));
    $(this).parents('.dropdownalert').fadeOut(300);

    let that = this;
    let dataForm = {};
    dataForm['_token'] = $(this).find('input').eq(0).attr('value');
    dataForm['id'] = $(this).attr('data-id');

    $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: dataForm,
        success: function (data) {

            if (typeof data === 'object') {


                $(that).find('button[type="submit"]').prop('disabled', false);
                $(that).find('.spinner').addClass('d-none');
                $(that).find('.bug').addClass('d-none');
                let rowDataTapsStandard = data[0];
                let rowDataTapsActual = data[1];
                let rowDataTapsActualTime = data[2];
                let rowDataTapsStandardTime = data[3];
                // console.log(data);

                // To Preper Data Of TapsStandard
                delete rowDataTapsStandard['id'];
                delete rowDataTapsStandard['added_by'];
                delete rowDataTapsStandard['shift'];
                delete rowDataTapsStandard['updated_by'];
                delete rowDataTapsStandard['created_at'];
                delete rowDataTapsStandard['updated_at'];

                // To Preper Data Of TapsStandardTime
                delete rowDataTapsStandardTime['id'];
                delete rowDataTapsStandardTime['tapsstandards_id'];
                delete rowDataTapsStandardTime['added_by'];
                delete rowDataTapsStandardTime['shift'];
                delete rowDataTapsStandardTime['updated_by'];
                delete rowDataTapsStandardTime['created_at'];
                delete rowDataTapsStandardTime['updated_at'];

                // To Preper Data Of StrindingActual
                let tapsActual_id = rowDataTapsActual['id'];

                delete rowDataTapsActual['id'];
                delete rowDataTapsActual['jopOrderNumber_id'];
                delete rowDataTapsActual['jopOrderNumber'];
                delete rowDataTapsActual['added_by'];
                delete rowDataTapsActual['shift'];
                delete rowDataTapsActual['updated_by'];
                delete rowDataTapsActual['created_at'];
                delete rowDataTapsActual['updated_at'];

                // To Preper Data Of TapsActualTime
                delete rowDataTapsActualTime['id'];
                delete rowDataTapsActualTime['tapsactuals_id'];
                delete rowDataTapsActualTime['added_by'];
                delete rowDataTapsActualTime['shift'];
                delete rowDataTapsActualTime['updated_by'];
                delete rowDataTapsActualTime['created_at'];
                delete rowDataTapsActualTime['updated_at'];


                tapsRowData = { ...rowDataTapsStandard, ...rowDataTapsActual };
                tapsRowDataTime = { ...rowDataTapsStandardTime, ...rowDataTapsActualTime };

                //    console.log(tapsRowData);
                //    console.log(tapsRowDataTime);

                let form = $(that).parents('.box').children('.content').children('.tapsActual');
                let inputs = form.find('.input, textarea');
                //  console.log(inputs);
                let count = 0;

                for (let key in tapsRowData) {
                    let currentInput = $(inputs).filter(`[name="${key}"]`);
                    if (count < 6 || (tapsRowData[key] != null && key != "notes")) {
                        currentInput.prop('disabled', true);
                    } else {
                        //    console.log(key);
                        currentInput.prop('disabled', false);
                        if (key != "notes") {
                            currentInput.prop('required', true);
                        }
                    }
                    currentInput.val(tapsRowData[currentInput.attr('name')]).prop('title', tapsRowData[currentInput.attr('name')]);
                    currentInput.attr('data-time', tapsRowDataTime[currentInput.attr('name') + '_time']);
                    count++;
                }

                form.find('button').prop('disabled', false);

                // To Save Data in LocalStorage
                SaveDataOfTapsLocalStorage(that, inputs, true, tapsActual_id);

                //To Hide the DropDown-Alert if you use All of alerts 
                for (let i = 0; i < $('.taps .dropdownalert').length; i++) {
                    let counter = 0;
                    let counterOfdropdownalert_item = $('.taps .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
                    for (let j = 0; j <= counterOfdropdownalert_item; j++) {
                        if ($('.taps .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                            counter++;
                        }

                    }

                    // console.log(counterOfdropdownalert_item, counter);
                    if (counter == counterOfdropdownalert_item) {
                        $('.taps .dropdownalert').eq(i).addClass('d-none');
                    }

                }



                //To Close searchJopOrderNumber form
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfTaps').find('.input').eq(1).prop('disabled', 'true');
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfTaps').find('button').eq(0).prop('disabled', 'true');
                //To make Attantion For form to Know this data for update not create
                form.attr('data-update', true);
                form.attr('data-id-for-update', tapsActual_id);

                //To Show Icon Of Clear Sheet
                $(that).parents('.box').find('.fa-trash-restore').removeClass('d-none');

            } else {
                window.location.reload(true);
            }

        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        },


    });

});

// To Clear Sheat From Data That Not Completed
function clearTapsSheet(sheetItem) {
    let dataOfTaps = JSON.parse(localStorage.getItem('dataOfTaps'));
    let inputs = $(`#Taps_${sheetItem + 1} .tapsActual`).find('.input, textarea');
    for (let i = 0; i < inputs.length; i++) {
        let key = $(inputs[i]).attr('name');
        dataOfTaps[sheetItem][key] = ["", "", (i <= 6) ? true : false, false];
    }
    //To Know if user called data from alerts or not
    dataOfTaps[sheetItem]['isAlert'] = [false, null];
    localStorage.setItem('dataOfTaps', JSON.stringify(dataOfTaps));
    window.location.reload(true);
}

//To Save Data Of Taps Sheets in LocalStorage for Refreash
let dataOfTaps = [];

if (localStorage.getItem('dataOfTaps') == null) {


    for (let i = 0; i <= 1; i++) {

        let dataOfTaps_1 = {};
        let inputs_1 = $(`#Taps_${i + 1} .tapsActual`).find('.input');
        let textarea_1 = $(`#Taps_${i + 1} .tapsActual`).find('textarea')[0];
        inputs_1.push(textarea_1);
        // console.log(inputs_1);

        for (let j = 0; j < inputs_1.length; j++) {
            let key = $(inputs_1[j]).attr('name');
            /* 
            dataOfTaps_1[0] => value of input
            dataOfTaps_1[1] => data-time of input
            dataOfTaps_1[2] => required
            dataOfTaps_1[3] => disabled

            so We Have to make inputs Of Standard is Required
            (j <= 6 || j == 7)
            j <= 6 => For Standard Inputs
            j == 7 => For label
            */
            dataOfTaps_1[key] = ["", "", (j <= 6 || j == 7) ? true : false, false];
        }
        //To Know if user called data from alerts or not
        dataOfTaps_1['isAlert'] = [false, null];

        // console.log(dataOfTaps_1);

        dataOfTaps.push(dataOfTaps_1);
    }
    // console.log(dataOfTaps);
    localStorage.setItem('dataOfTaps', JSON.stringify(dataOfTaps));

    deliverDataFromTapsLocalStorage();

} else {

    deliverDataFromTapsLocalStorage();
    //To Hide the DropDown-Alert if you use All of alerts 
    for (let i = 0; i < $('.taps .dropdownalert').length; i++) {
        let counter = 0;
        let counterOfdropdownalert_item = $('.taps .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
        for (let j = 0; j <= counterOfdropdownalert_item; j++) {
            if ($('.taps .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                counter++;
            }

        }

        // console.log(counterOfdropdownalert_item, counter);
        if (counter == counterOfdropdownalert_item) {
            $('.taps .dropdownalert').eq(i).addClass('d-none');
        }

    }

}

function deliverDataFromTapsLocalStorage() {
    dataOfTaps = JSON.parse(localStorage.getItem('dataOfTaps'));

    for (let i = 0; i <= 1; i++) {

        let inputs = $(`#Taps_${i + 1} .tapsActual`).find('.input');
        let textarea = $(`#Taps_${i + 1} .tapsActual`).find('textarea')[0];
        inputs.push(textarea);



        for (let j = 0; j < inputs.length; j++) {
            let inputFromLocalStorage = dataOfTaps[i][$(inputs[j]).attr('name')];
            $(inputs[j]).val(inputFromLocalStorage[0]);
            $(inputs[j]).attr('data-time', inputFromLocalStorage[1]);
            $(inputs[j]).prop('required', inputFromLocalStorage[2]);
            $(inputs[j]).prop('disabled', inputFromLocalStorage[3]);
        }

        if (dataOfTaps[i]['isAlert'][0]) {
            $('.taps .popUp').eq(i).find('.dataNotComplete').addClass('d-none');
            $('.taps .popUp').eq(i).find('.searchJopOrderNumberOfTaps input[name="jopOrderNumber"]').prop('disabled', true);
            $('.taps .popUp').eq(i).find('.searchJopOrderNumberOfTaps button').prop('disabled', true);
            /* 
            this Line To
            hide dropdownalert-item if it is called at one of sheet to complete it 
            And add attrebute data-sheet-item to dropdownalert-item after Refresh
            */
            $('.taps .popUp').find(`.dataNotComplete .dropdownalert-item[data-id=${dataOfTaps[i]['isAlert'][1]}]`).addClass('d-none').attr('data-sheet-item', i);
            $('.taps .popUp').eq(i).find('.tapsActual').attr('data-update', dataOfTaps[i]['isAlert'][0]);
            $('.taps .popUp').eq(i).find('.tapsActual').attr('data-id-for-update', dataOfTaps[i]['isAlert'][1]);
            $('.taps .popUp').eq(i).attr('data-isAlert', true);
            $('.taps .popUp').eq(i).attr('update-data-sheet-of-id', dataOfTaps[i]['isAlert'][1]);
            //To Show Icon Of Clear Sheet
            $('.taps .popUp').eq(i).find('.fa-trash-restore').removeClass('d-none');
        }

    }
}

function SaveDataOfTapsLocalStorage(element, inputs, isAlert = false, itemOfAlert = null) {
    let dataOfTaps = JSON.parse(localStorage.getItem('dataOfTaps'));
    let item = $(element).parents('.popUp').attr('data-item');
    for (let j = 0; j < inputs.length; j++) {
        dataOfTaps[item][$(inputs[j]).attr('name')] = [$(inputs[j]).val(), $(inputs[j]).attr('data-time'), $(inputs[j]).prop('required'), $(inputs[j]).prop('disabled')];
    }
    dataOfTaps[item]['isAlert'] = [isAlert, itemOfAlert];
    localStorage.setItem('dataOfTaps', JSON.stringify(dataOfTaps));
}






