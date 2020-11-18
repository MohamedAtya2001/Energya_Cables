

//To Insert Bedding
$('form.beddingActual').submit(function (e) {
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
    dataForm['data_form_item'] = $(this).attr('data-form-item');
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

            if (data == "Logout") {
                window.location.reload(true);
            } else if (data == "Updated") {
                $('.dataNotComplete').find('.updated').css('display', 'none');
                $('.searchJopOrderNumberOfBedding').find('.input');
                $('.searchJopOrderNumberOfBedding').find('button');
                $($(that).find('.input')).prop('required', false);
                $($(that).find('textarea')).prop("required", false);
                $($(that).find('.input')).val('');
                $($(that).find('textarea')).val('');
                $(that).removeAttr('data-id-for-update');
                $(that).attr('data-update', false);
                $(`.dropdownalert-menu .dropdownalert-item[data-sheet-item="${$(that).parents('.popUp').attr('data-item')}"]`).attr('updated', true);
                //To Open Every Sheet If All of Alert is Done
                if ($(that).parents('.popUp').find(`.dropdownalert-menu .dropdownalert-item:not(.dropdownalert-menu .dropdownalert-item[updated="true"])`).length == 0) {
                    $('.bedding').find('.input, textarea, button:not(button.text-warning)').prop('disabled', false).removeClass('error');
                    $('.bedding .searchJopOrderNumberOfDrowing').find('.input').prop('disabled', false);
                    $('.bedding .searchJopOrderNumberOfDrowing').find('button').prop('disabled', false);
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
            }  else if (data == 'Error-thicknessStartActual') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').addClass('error');
                $('.bedding').get('0').scrollTop += $($(that).find('input[name="thicknessStartMinActual"]')).offset().top - 20;
            } else if (data == 'Error-thicknessEndActual') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').addClass('error');
                $('.bedding').get('0').scrollTop += $($(that).find('input[name="thicknessEndMinActual"]')).offset().top - 20;
            } else if (data == 'Error-dimBefore1') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').addClass('error');
                $('.bedding').get('0').scrollTop += $($(that).find('input[name="dimBefore1"]')).offset().top - 20;
            } else if (data == 'Error-dimAfterStart') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').addClass('error');
                $('.bedding').get('0').scrollTop += $($(that).find('input[name="dimAfterStartMin"]')).offset().top - 20;
            } else if (data == 'Error-dimAfterEnd') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').addClass('error');
                $('.bedding').get('0').scrollTop += $($(that).find('input[name="dimAfterEndMin"]')).offset().top - 20;
            } else if (data == 'Error-ovalityActual1') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
                $(that).find('input[name="ovalityActual1"]').addClass('error');
                $('.bedding').get('0').scrollTop += $($(that).find('textarea[name="ovalityActual1"]')).offset().top - 20;
            } else if (data == 'Error-notes') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
                $(that).find('input[name="ovalityActual1"]').removeClass('error');
                $(that).find('textarea[name="notes"]').addClass('error');
                $('.bedding').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
            } else {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
                $(that).find('input[name="ovalityActual1"]').removeClass('error');
                $(that).find('textarea[name="notes"]').removeClass('error');
                $($(that).find('.input')).val('').prop("disabled", false);
                $($(that).find('textarea')).val('').prop("disabled", false);
            }

            // To Save Data in LocalStorage
            let inputs = $(that).find('.input');
            inputs.push($(that).find('textarea'));
            SaveDataOfBeddingLocalStorage(that, inputs);


        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.message);
        },

    });

});

//To  Search jopOrderNumber Bedding
$('form.searchJopOrderNumberOfBedding').submit(function (e) {
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    e.preventDefault();
    let that = this;
    let dataForm = {
        '_token': $(this).find('input').eq(0).attr('value'),
        'jopOrderNumber': $(this).find('input[name="jopOrderNumber"]').val(),
        'data_form_item': $(this).parents('.box').find('form[data-form-item]').attr('data-form-item')
    }
    $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: dataForm,
        success: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data);


            if (data == "Logout") {
                window.location.reload(true);
            } else if (typeof data === 'object') {
                delete data.id;
                delete data.created_at;
                delete data.updated_at;
                delete data.added_by;
                delete data.shift;

                // console.log(data);
                let inputs = $(that).siblings('form').find('.standard input');
                for (let i = 0; i <= inputs.length; i++) {
                    $(inputs[i]).val(data[$(inputs[i]).attr('name')]).prop("disabled", true);
                    let date = new Date().toLocaleString();
                    $(inputs[i]).attr('data-time', date);
                }


                // To Save Data in LocalStorage
                SaveDataOfBeddingLocalStorage(that, inputs);

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
                SaveDataOfBeddingLocalStorage(that, inputs);

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
$('.bedding .dataNotComplete form').click(function (e) {
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
    dataForm['data_form_item'] = $(this).parents('.box').find('form[data-form-item]').attr('data-form-item');
    $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: dataForm,
        success: function (data) {

            if (data == "Logout") {
                window.location.reload(true);
            } else if (typeof data === 'object') {
                $(that).find('button[type="submit"]').prop('disabled', false);
                $(that).find('.spinner').addClass('d-none');
                $(that).find('.bug').addClass('d-none');

                // console.log(data);
                let rowDataBeddingStandard = data[0];
                let rowDataBeddingActual = data[1];
                let rowDataBeddingActualTime = data[2];
                let rowDataBeddingStandardTime = data[3];

                // To Preper Data Of BeddingStandard
                delete rowDataBeddingStandard['id'];
                delete rowDataBeddingStandard['added_by'];
                delete rowDataBeddingStandard['shift'];
                delete rowDataBeddingStandard['updated_by'];
                delete rowDataBeddingStandard['created_at'];
                delete rowDataBeddingStandard['updated_at'];

                delete rowDataBeddingStandardTime['id'];
                delete rowDataBeddingStandardTime['beddingstandards_id'];
                delete rowDataBeddingStandardTime['added_by'];
                delete rowDataBeddingStandardTime['shift'];
                delete rowDataBeddingStandardTime['updated_by'];
                delete rowDataBeddingStandardTime['created_at'];
                delete rowDataBeddingStandardTime['updated_at'];

                // To Preper Data Of BeddingActual

                let beddingActual_id = rowDataBeddingActual['id'];

                delete rowDataBeddingActual['id'];
                delete rowDataBeddingActual['jopOrderNumber_id'];
                delete rowDataBeddingActual['jopOrderNumber'];
                delete rowDataBeddingActual['added_by'];
                delete rowDataBeddingActual['shift'];
                delete rowDataBeddingActual['updated_by'];
                delete rowDataBeddingActual['created_at'];
                delete rowDataBeddingActual['updated_at'];

                delete rowDataBeddingActualTime['id'];
                delete rowDataBeddingActualTime['beddingactuals_id'];
                delete rowDataBeddingActualTime['added_by'];
                delete rowDataBeddingActualTime['shift'];
                delete rowDataBeddingActualTime['updated_by'];
                delete rowDataBeddingActualTime['created_at'];
                delete rowDataBeddingActualTime['updated_at'];

                // To Preper Data Of Bedding Row

                beddingRowData = { ...rowDataBeddingStandard, ...rowDataBeddingActual };
                beddingRowDataTime = { ...rowDataBeddingStandardTime, ...rowDataBeddingActualTime };

                // console.log(beddingRowData);
                // console.log(beddingRowDataTime);


                let form = $(that).parents('.box').children('.content').children('.beddingActual');
                let inputs = form.find('.input, textarea');
                // console.log(inputs);

                let count = 0;

                for (let key in beddingRowData) {
                    let currentInput = $(inputs).filter(`[name="${key}"]`);
                    if (count < 14 || (beddingRowData[key] != null && key != "notes" && beddingRowData[key] != '')) {
                        currentInput.prop('disabled', true);
                    } else {
                        // console.log(key);
                        currentInput.prop('disabled', false);
                        if (key != "ovalityActual2" &&
                            key != "dimBefore2" &&
                            key != "notes") {
                            currentInput.prop('required', true);
                        }
                    }
                    currentInput.val(beddingRowData[currentInput.attr('name')]).prop('title', beddingRowData[currentInput.attr('name')]);
                    currentInput.attr('data-time', beddingRowData[currentInput.attr('name') + '_time']);
                    count++;
                }

                form.find('button').prop('disabled', false);

                //To Close searchJopOrderNumber form
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfBedding').find('.input').eq(1).prop('disabled', 'true');
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfBedding').find('button').eq(0).prop('disabled', 'true');
                //To make Attantion For form to Know this data for update not create
                form.attr('data-update', true);
                form.attr('data-id-for-update', beddingActual_id);


                // To Save Data in LocalStorage
                SaveDataOfBeddingLocalStorage(that, inputs, true, beddingActual_id);


                //To Hide the DropDown-Alert if you use All of alerts 
                for (let i = 0; i < $('.bedding .dropdownalert').length; i++) {
                    let counter = 0;
                    let counterOfdropdownalert_item = $('.bedding .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
                    for (let j = 0; j <= counterOfdropdownalert_item; j++) {
                        if ($('.bedding .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                            counter++;
                        }

                    }

                    // console.log(counterOfdropdownalert_item, counter);
                    if (counter == counterOfdropdownalert_item) {
                        $('.bedding .dropdownalert').eq(i).addClass('d-none');
                    }

                }

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
            // console.log(data.responseJSON.message);
        },


    });

});

//To Check Row
$('.bedding .input, .bedding textarea').blur(function () {
    let date = new Date().toLocaleString();
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    dataForm['data_form_item'] = $(this).parents('form').attr('data-form-item');
    dataForm['input'] = { 'name': $(this).attr('name'), 'value': $(this).val(), 'time': date };

    // console.log(dataForm);

    $.ajax({
        url: 'bedding/checkRow',
        type: "POST",
        data: dataForm,
        success: function (data) {
            // console.log(data);


            if (data == "Logout") {
                window.location.reload(true);
            } else if (data == "Close Sheet") {

            }

        },
        error: function (data) {
            // console.log(data.responseJSON.message);
        },
    });

});

// To Clear Sheat From Data That Not Completed
function clearBeddingSheet(sheetItem) {
    let dataOfBedding = JSON.parse(localStorage.getItem('dataOfBedding'));
    let inputs = $(`#Bedding_${sheetItem + 1} .beddingActual`).find('.input, textarea');
    for (let i = 0; i < inputs.length; i++) {
        let key = $(inputs[i]).attr('name');
        dataOfBedding[sheetItem][key] = ["", "", (i <= 13) ? true : false, false];
    }
    //To Know if user called data from alerts or not
    dataOfBedding[sheetItem]['isAlert'] = [false, null];
    localStorage.setItem('dataOfBedding', JSON.stringify(dataOfBedding));
    window.location.reload(true);
}

//To Save Data Of Bedding Sheets in LocalStorage for Refreash
let dataOfBedding = [];

if (localStorage.getItem('dataOfBedding') == null) {


    for (let i = 0; i <= 1; i++) {

        let dataOfBedding_1 = {};
        let inputs_1 = $(`#Bedding_${i + 1} .beddingActual`).find('.input');
        let textarea_1 = $(`#Bedding_${i + 1} .beddingActual`).find('textarea')[0];
        inputs_1.push(textarea_1);
        // console.log(inputs_1);

        for (let j = 0; j < inputs_1.length; j++) {
            let key = $(inputs_1[j]).attr('name');
            /* 
            dataOfBedding_1[0] => value of input
            dataOfBedding_1[1] => data-time of input
            dataOfBedding_1[2] => required
            dataOfBedding_1[3] => disabled

            so We Have to make inputs Of Standard is Required

            */
            dataOfBedding_1[key] = ["", "", (j <= 13) ? true : false, false];
        }
        //To Know if user called data from alerts or not
        dataOfBedding_1['isAlert'] = [false, null];

        // console.log(dataOfBedding_1);

        dataOfBedding.push(dataOfBedding_1);
    }
    // console.log(dataOfBedding);
    localStorage.setItem('dataOfBedding', JSON.stringify(dataOfBedding));

    deliverDataFromBeddingLocalStorage();

} else {

    deliverDataFromBeddingLocalStorage();
    //To Hide the DropDown-Alert if you use All of alerts 
    for (let i = 0; i < $('.bedding .dropdownalert').length; i++) {
        let counter = 0;
        let counterOfdropdownalert_item = $('.bedding .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
        for (let j = 0; j <= counterOfdropdownalert_item; j++) {
            if ($('.bedding .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                counter++;
            }

        }

        // console.log(counterOfdropdownalert_item, counter);
        if (counter == counterOfdropdownalert_item) {
            $('.bedding .dropdownalert').eq(i).addClass('d-none');
        }

    }

}

function deliverDataFromBeddingLocalStorage() {
    dataOfBedding = JSON.parse(localStorage.getItem('dataOfBedding'));

    for (let i = 0; i <= 1; i++) {

        let inputs = $(`#Bedding_${i + 1} .beddingActual`).find('.input');
        let textarea = $(`#Bedding_${i + 1} .beddingActual`).find('textarea')[0];
        inputs.push(textarea);



        for (let j = 0; j < inputs.length; j++) {
            let inputFromLocalStorage = dataOfBedding[i][$(inputs[j]).attr('name')];
            $(inputs[j]).val(inputFromLocalStorage[0]);
            $(inputs[j]).attr('data-time', inputFromLocalStorage[1]);
            $(inputs[j]).prop('required', inputFromLocalStorage[2]);
            $(inputs[j]).prop('disabled', inputFromLocalStorage[3]);
        }

        if (dataOfBedding[i]['isAlert'][0]) {
            $('.bedding .popUp').eq(i).find('.dataNotComplete').addClass('d-none');
            $('.bedding .popUp').eq(i).find('.searchJopOrderNumberOfBedding input[name="jopOrderNumber"]').prop('disabled', true);
            $('.bedding .popUp').eq(i).find('.searchJopOrderNumberOfBedding button').prop('disabled', true);
            /* 
            this Line To
            hide dropdownalert-item if it is called at one of sheet to complete it 
            And add attrebute data-sheet-item to dropdownalert-item after Refresh
            */
            $('.bedding .popUp').find(`.dataNotComplete .dropdownalert-item[data-id=${dataOfBedding[i]['isAlert'][1]}]`).addClass('d-none').attr('data-sheet-item', i);
            $('.bedding .popUp').eq(i).find('.beddingActual').attr('data-update', dataOfBedding[i]['isAlert'][0]);
            $('.bedding .popUp').eq(i).find('.beddingActual').attr('data-id-for-update', dataOfBedding[i]['isAlert'][1]);
            $('.bedding .popUp').eq(i).attr('data-isAlert', true);
            $('.bedding .popUp').eq(i).attr('update-data-sheet-of-id', dataOfDrowing[i]['isAlert'][1]);
            //To Show Icon Of Clear Sheet
            $('.bedding .popUp').eq(i).find('.fa-trash-restore').removeClass('d-none');
        }

    }
}

function SaveDataOfBeddingLocalStorage(element, inputs, isAlert = false, itemOfAlert = null) {
    let dataOfBedding = JSON.parse(localStorage.getItem('dataOfBedding'));
    let item = $(element).parents('.popUp').attr('data-item');
    for (let j = 0; j < inputs.length; j++) {
        dataOfBedding[item][$(inputs[j]).attr('name')] = [$(inputs[j]).val(), $(inputs[j]).attr('data-time'), $(inputs[j]).prop('required'), $(inputs[j]).prop('disabled')];
    }
    dataOfBedding[item]['isAlert'] = [isAlert, itemOfAlert];
    localStorage.setItem('dataOfBedding', JSON.stringify(dataOfBedding));
}









