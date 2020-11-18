

//To Insert Screen
$('form.screenActual').submit(function (e) {
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
                $('.dataNotComplete').find('.updated').css('display', 'none');
                $('.searchJopOrderNumberOfScreen').find('.input');
                $('.searchJopOrderNumberOfScreen').find('button');
                $($(that).find('.input')).prop('required', false);
                $($(that).find('textarea')).prop("required", false);
                $($(that).find('.input')).val('');
                $($(that).find('textarea')).val('');
                $(that).removeAttr('data-id-for-update');
                $(that).attr('data-update', false);
                $(`.dropdownalert-menu .dropdownalert-item[data-sheet-item="${$(that).parents('.popUp').attr('data-item')}"]`).attr('updated', true);
                //To Open Every Sheet If All of Alert is Done
                if ($(that).parents('.popUp').find(`.dropdownalert-menu .dropdownalert-item:not(.dropdownalert-menu .dropdownalert-item[updated="true"])`).length == 0) {
                    $('.screen').find('.input, textarea, button:not(button.text-warning)').prop('disabled', false).removeClass('error');
                    $('.screen .searchJopOrderNumberOfScreen').find('.input').prop('disabled', false);
                    $('.screen .searchJopOrderNumberOfScreen').find('button').prop('disabled', false);
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
            } else if (data == 'Error-overLapActual1') {
                $(that).find('input[name="overLapActual1"]').addClass('error');
                $('.screen').get('0').scrollTop += $($(that).find('input[name="overLapActual1"]')).offset().top - 20;
            } else if (data == 'Error-dimAfter1') {
                $(that).find('input[name="overLapActual1"]').removeClass('error');
                $(that).find('input[name="dimAfter1"]').addClass('error');
                $('.screen').get('0').scrollTop += $($(that).find('input[name="dimAfter1"]')).offset().top - 20;
            } else if (data == 'Error-notes') {
                $(that).find('input[name="overLapActual1"]').removeClass('error');
                $(that).find('input[name="dimAfter1"]').removeClass('error');
                $(that).find('textarea[name="notes"]').addClass('error');
                $('.screen').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
            } else {
                $(that).find('input[name="overLapActual1"]').removeClass('error');
                $(that).find('input[name="dimAfter1"]').removeClass('error');
                $(that).find('textarea[name="notes"]').removeClass('error');
                $($(that).find('.input')).val('').prop("disabled", false);
                $($(that).find('textarea')).val('').prop("disabled", false);
            }

            // To Save Data in LocalStorage
            let inputs = $(that).find('.input');
            inputs.push($(that).find('textarea'));
            SaveDataOfScreenLocalStorage(that, inputs);

        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        },


    });

});

//To  Search jopOrderNumber Screen
$('form.searchJopOrderNumberOfScreen').submit(function (e) {
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
            // console.log(data);
            if (typeof data === 'object') {
                delete data.id;
                delete data.created_at;
                delete data.updated_at;
                delete data.added_by;
                delete data.shift;
                let inputs = $(that).siblings('form').find('.standard input');

                // console.log(data);
                for (let i = 0; i <= inputs.length; i++) {
                    $(inputs[i]).val(data[$(inputs[i]).attr('name')]).prop("disabled", true);
                    let date = new Date().toLocaleString();
                    $(inputs[i]).attr('data-time', date);
                }

                // To Save Data in LocalStorage
                SaveDataOfScreenLocalStorage(that, inputs);


            } else {
                let inputs = $(that).siblings('form').find('.standard input');

                //To Print jopOrderNumber inside Input
                $(inputs[0]).val(data).prop("disabled", true);
                let date = new Date().toLocaleString();
                $(inputs[0]).attr('data-time', date);

                for (let i = 1; i <= inputs.length; i++) {
                    $(inputs[i]).val('').prop("disabled", false);
                }

                // To Save Data in LocalStorage
                SaveDataOfScreenLocalStorage(that, inputs);
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
$('.screen .dataNotComplete form').click(function (e) {
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    e.preventDefault();
    $(this).addClass('updated');
    $(`.dropdownalert-item[data-id="${$(this).attr('data-id')}"]`).fadeOut(300).attr('data-sheet-item', $(this).parents('.popUp').attr('data-item'));
    $(this).parents('.dropdownalert').fadeOut(300);
    $(this).parents('.popUp').attr('update-data-sheet-of-id', $(this).attr('data-id'));

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
                let rowDataScreenStandard = data[0];
                let rowDataScreenActual = data[1];
                let rowDataScreenActualTime = data[2];
                let rowDataScreenStandardTime = data[3];
                // console.log(data);

                // To Preper Data Of ScreenStandard
                delete rowDataScreenStandard['id'];
                delete rowDataScreenStandard['added_by'];
                delete rowDataScreenStandard['shift'];
                delete rowDataScreenStandard['updated_by'];
                delete rowDataScreenStandard['created_at'];
                delete rowDataScreenStandard['updated_at'];

                // To Preper Data Of ScreenStandardTime
                delete rowDataScreenStandardTime['id'];
                delete rowDataScreenStandardTime['screenstandards_id'];
                delete rowDataScreenStandardTime['added_by'];
                delete rowDataScreenStandardTime['shift'];
                delete rowDataScreenStandardTime['updated_by'];
                delete rowDataScreenStandardTime['created_at'];
                delete rowDataScreenStandardTime['updated_at'];

                // To Preper Data Of ScreenActual
                let screenActual_id = rowDataScreenActual['id'];

                delete rowDataScreenActual['id'];
                delete rowDataScreenActual['jopOrderNumber_id'];
                delete rowDataScreenActual['jopOrderNumber'];
                delete rowDataScreenActual['added_by'];
                delete rowDataScreenActual['shift'];
                delete rowDataScreenActual['updated_by'];
                delete rowDataScreenActual['created_at'];
                delete rowDataScreenActual['updated_at'];

                // To Preper Data Of ScreenActualTime
                delete rowDataScreenActualTime['id'];
                delete rowDataScreenActualTime['screenactuals_id'];
                delete rowDataScreenActualTime['added_by'];
                delete rowDataScreenActualTime['shift'];
                delete rowDataScreenActualTime['updated_by'];
                delete rowDataScreenActualTime['created_at'];
                delete rowDataScreenActualTime['updated_at'];

                screenRowData = { ...rowDataScreenStandard, ...rowDataScreenActual };
                screenRowDataTime = { ...rowDataScreenStandardTime, ...rowDataScreenActualTime };

                // console.log(screenRowData);
                // console.log(screenRowDataTime);

                let form = $(that).parents('.box').children('.content').children('.screenActual');
                let inputs = form.find('.input, textarea');
                //  console.log(inputs);
                let count = 0;

                for (let key in screenRowData) {
                    let currentInput = $(inputs).filter(`[name="${key}"]`);
                    if (count < 7 || (screenRowData[key] != null && key != "notes" && screenRowData[key] != '')) {
                        currentInput.prop('disabled', true);
                    } else {
                        // console.log(key);
                        currentInput.prop('disabled', false);
                        if (key != 'overLapActual2' &&
                            key != 'overLapActual3' &&
                            key != 'overLapActual4' &&
                            key != "dimAfter2" &&
                            key != "dimAfter3" &&
                            key != "dimAfter4" &&
                            key != "notes") {
                            currentInput.prop('required', true);
                        }
                    }
                    currentInput.val(screenRowData[currentInput.attr('name')]).prop('title', screenRowData[currentInput.attr('name')]);
                    currentInput.attr('data-time', screenRowDataTime[currentInput.attr('name') + '_time']);
                    count++;
                }

                form.find('button').prop('disabled', false);

                // To Save Data in LocalStorage
                SaveDataOfScreenLocalStorage(that, inputs, true, screenActual_id);

                //To Hide the DropDown-Alert if you use All of alerts 
                for (let i = 0; i < $('.screen .dropdownalert').length; i++) {
                    let counter = 0;
                    let counterOfdropdownalert_item = $('.screen .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
                    for (let j = 0; j <= counterOfdropdownalert_item; j++) {
                        if ($('.screen .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                            counter++;
                        }

                    }

                    // console.log(counterOfdropdownalert_item, counter);
                    if (counter == counterOfdropdownalert_item) {
                        $('.screen .dropdownalert').eq(i).addClass('d-none');
                    }

                }



                //To Close searchJopOrderNumber form
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfScreen').find('.input').eq(1).prop('disabled', 'true');
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfScreen').find('button').eq(0).prop('disabled', 'true');
                //To make Attantion For form to Know this data for update not create
                form.attr('data-update', true);
                form.attr('data-id-for-update', screenActual_id);

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
function clearScreenSheet(sheetItem) {
    let dataOfScreen = JSON.parse(localStorage.getItem('dataOfScreen'));
    let inputs = $(`#Screen_${sheetItem + 1} .screenActual`).find('.input, textarea');
    for (let i = 0; i < inputs.length; i++) {
        let key = $(inputs[i]).attr('name');
        dataOfScreen[sheetItem][key] = ["", "", (i <= 6) ? true : false, false];
    }
    //To Know if user called data from alerts or not
    dataOfScreen[sheetItem]['isAlert'] = [false, null];
    localStorage.setItem('dataOfScreen', JSON.stringify(dataOfScreen));
    window.location.reload(true);
}

//To Save Data Of Screen Sheets in LocalStorage for Refreash
let dataOfScreen = [];

if (localStorage.getItem('dataOfScreen') == null) {


    for (let i = 0; i <= 2; i++) {

        let dataOfScreen_1 = {};
        let inputs_1 = $(`#Screen_${i + 1} .screenActual`).find('.input');
        let textarea_1 = $(`#Screen_${i + 1} .screenActual`).find('textarea')[0];
        inputs_1.push(textarea_1);
        // console.log(inputs_1);

        for (let j = 0; j < inputs_1.length; j++) {
            let key = $(inputs_1[j]).attr('name');
            /* 
            dataOfScreen_1[0] => value of input
            dataOfScreen_1[1] => data-time of input
            dataOfScreen_1[2] => required
            dataOfScreen_1[3] => disabled

            so We Have to make inputs Of Standard is Required
            (j <= 6 || j == 7)
            j <= 6 => For Standard Inputs
            j == 7 => For label
            */
            dataOfScreen_1[key] = ["", "", (j <= 6 || j == 7) ? true : false, false];
        }
        //To Know if user called data from alerts or not
        dataOfScreen_1['isAlert'] = [false, null];

        // console.log(dataOfScreen_1);

        dataOfScreen.push(dataOfScreen_1);
    }
    // console.log(dataOfScreen);
    localStorage.setItem('dataOfScreen', JSON.stringify(dataOfScreen));

    deliverDataFromScreenLocalStorage();

} else {

    deliverDataFromScreenLocalStorage();
    //To Hide the DropDown-Alert if you use All of alerts 
    for (let i = 0; i < $('.screen .dropdownalert').length; i++) {
        let counter = 0;
        let counterOfdropdownalert_item = $('.screen .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
        for (let j = 0; j <= counterOfdropdownalert_item; j++) {
            if ($('.screen .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                counter++;
            }

        }

        // console.log(counterOfdropdownalert_item, counter);
        if (counter == counterOfdropdownalert_item) {
            $('.screen .dropdownalert').eq(i).addClass('d-none');
        }

    }

}

function deliverDataFromScreenLocalStorage() {
    dataOfScreen = JSON.parse(localStorage.getItem('dataOfScreen'));

    for (let i = 0; i <= 2; i++) {

        let inputs = $(`#Screen_${i + 1} .screenActual`).find('.input');
        let textarea = $(`#Screen_${i + 1} .screenActual`).find('textarea')[0];
        inputs.push(textarea);



        for (let j = 0; j < inputs.length; j++) {
            let inputFromLocalStorage = dataOfScreen[i][$(inputs[j]).attr('name')];
            $(inputs[j]).val(inputFromLocalStorage[0]);
            $(inputs[j]).attr('data-time', inputFromLocalStorage[1]);
            $(inputs[j]).prop('required', inputFromLocalStorage[2]);
            $(inputs[j]).prop('disabled', inputFromLocalStorage[3]);
        }

        if (dataOfScreen[i]['isAlert'][0]) {
            $('.screen .popUp').eq(i).find('.dataNotComplete').addClass('d-none');
            $('.screen .popUp').eq(i).find('.searchJopOrderNumberOfScreen input[name="jopOrderNumber"]').prop('disabled', true);
            $('.screen .popUp').eq(i).find('.searchJopOrderNumberOfScreen button').prop('disabled', true);
            /* 
            this Line To
            hide dropdownalert-item if it is called at one of sheet to complete it 
            And add attrebute data-sheet-item to dropdownalert-item after Refresh
            */
            $('.screen .popUp').find(`.dataNotComplete .dropdownalert-item[data-id=${dataOfScreen[i]['isAlert'][1]}]`).addClass('d-none').attr('data-sheet-item', i);
            $('.screen .popUp').eq(i).find('.screenActual').attr('data-update', dataOfScreen[i]['isAlert'][0]);
            $('.screen .popUp').eq(i).find('.screenActual').attr('data-id-for-update', dataOfScreen[i]['isAlert'][1]);
            $('.screen .popUp').eq(i).attr('data-isAlert', true);
            $('.screen .popUp').eq(i).attr('update-data-sheet-of-id', dataOfScreen[i]['isAlert'][1]);
            //To Show Icon Of Clear Sheet
            $('.screen .popUp').eq(i).find('.fa-trash-restore').removeClass('d-none');
        }

    }
}

function SaveDataOfScreenLocalStorage(element, inputs, isAlert = false, itemOfAlert = null) {
    let dataOfScreen = JSON.parse(localStorage.getItem('dataOfScreen'));
    let item = $(element).parents('.popUp').attr('data-item');
    for (let j = 0; j < inputs.length; j++) {
        dataOfScreen[item][$(inputs[j]).attr('name')] = [$(inputs[j]).val(), $(inputs[j]).attr('data-time'), $(inputs[j]).prop('required'), $(inputs[j]).prop('disabled')];
    }
    dataOfScreen[item]['isAlert'] = [isAlert, itemOfAlert];
    localStorage.setItem('dataOfScreen', JSON.stringify(dataOfScreen));
}






