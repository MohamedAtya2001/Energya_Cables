
//To Insert Drowing
$('.drowing form.drowingActual').submit(function (e) {
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
    // return 0;
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
                $($(that).find('.input')).prop('required', false);
                $($(that).find('textarea')).prop("required", false);
                $(that).find('input[name="wireDimStandard"]').removeClass('error');
                $(that).find('input[name="wireDimActual"]').removeClass('error');
                $($(that).find('.input')).val('');
                $($(that).find('textarea')).val('');
                $(that).removeAttr('data-id-for-update');
                $(that).attr('data-update', false);
                $(`.dropdownalert-menu .dropdownalert-item[data-sheet-item="${$(that).parents('.popUp').attr('data-item')}"]`).attr('updated', true);
                //To Open Every Sheet If All of Alert is Done
                if ($(that).parents('.popUp').find(`.dropdownalert-menu .dropdownalert-item:not(.dropdownalert-menu .dropdownalert-item[updated="true"])`).length == 0) {
                    $('.drowing').find('.input, textarea, button:not(button.text-warning)').prop('disabled', false).removeClass('error');
                    $('.drowing .searchJopOrderNumberOfDrowing').find('.input').prop('disabled', false);
                    $('.drowing .searchJopOrderNumberOfDrowing').find('button').prop('disabled', false);
                }
                // To Check after Update alert if There Another Alert,  if it true it will appeared Button Alerts Again
                else {
                    $(that).parents('.popUp').find('.dropdownalert').fadeIn(300);
                    $($(that).find('.input')).val('').prop("disabled", true);
                    $($(that).find('textarea')).val('').prop("disabled", true);
                    $('.stranding .searchJopOrderNumberOfDrowing').find('button').prop('disabled', false);
                }
                //To Hide Icon Of Clear Sheet
                $(that).parents('.box').find('.fa-trash-restore').addClass('d-none');
            } else if (data == 'Error-wireDimActual') {
                $(that).find('input[name="wireDimMinActual"], input[name="wireDimNomActual"], input[name="wireDimMaxActual"]').addClass('error');
                $('.drowing').get('0').scrollTop += $($(that).find('input[name="wireDimMinActual"]')).offset().top - 20;
            } else if (data == 'Error-notes') {
                $(that).find('input[name="wireDimMinActual"], input[name="wireDimNomActual"], input[name="wireDimMaxActual"]').removeClass('error');
                $(that).find('textarea[name="notes"]').addClass('error');
                $('.drowing').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
            } else {
                $(that).find('input[name="wireDimMinActual"], input[name="wireDimNomActual"], input[name="wireDimMaxActual"]').removeClass('error');
                $(that).find('textarea[name="notes"]').removeClass('error');
                $($(that).find('.input')).val('').prop("disabled", false);
                $($(that).find('textarea')).val('').prop("disabled", false);
            }
            // To Save Data in LocalStorage
            let inputs = $(that).find('.input');
            inputs.push($(that).find('textarea'));
            SaveDataOfDrowingLocalStorage(that, inputs);
        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            console.log(data.responseJSON);
            /* console.log(data.responseJSON.message);
            let errors = "Error"s;
            let index = 1;
            $.each(errors, function (key, value) {
                $($(that).find('.input')[index]).siblings('p.error').html(value).css('display', 'block');
                index++;
            }); */

        }
    });
});

//To Search jopOrderNumber Drowing
$('.drowing form.searchJopOrderNumberOfDrowing').submit(function (e) {
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    e.preventDefault();
    let that = this;
    let dataForm = {
        '_token': $(this).find('input').eq(0).attr('value'),
        'jopOrderNumber': $(this).find('input[name="jopOrderNumber"]').val(),
        'data_form_item': $(this).parents('.box').find('form[data-form-item]').attr('data-form-item')
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
                SaveDataOfDrowingLocalStorage(that, inputs);

            } else {
                // console.log(data);
                let inputs = $(that).siblings('form').find('.standard input');

                //To Print jopOrderNumber inside Input
                $(inputs[0]).val(data).prop("disabled", true);
                let date = new Date().toLocaleString();
                $(inputs[0]).attr('data-time', date);

                for (let i = 1; i <= inputs.length; i++) {
                    $(inputs[i]).val('').prop("disabled", false);
                }

                // To Save Data in LocalStorage
                SaveDataOfDrowingLocalStorage(that, inputs);


            }

            $(that).find('input[name="jopOrderNumber"]').eq(0).val('');

        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            console.log(data.responseJSON);

        }
    });
});

//To Get Date For User To Complete It
$('.drowing .dataNotComplete form').click(function (e) {
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    e.preventDefault();
    $(this).addClass('updated');
    $(`.dropdownalert-item[data-id="${$(this).attr('data-id')}"]`).fadeOut(300).attr('data-sheet-item', $(this).parents('.popUp').attr('data-item'));
    $(this).parents('.dropdownalert').fadeOut(300);
    $(this).parents('.popUp').attr('update-data-sheet-of-id', $(this).attr('data-id'));

    let dataForm = {};
    dataForm['_token'] = $(this).find('input').eq(0).attr('value');
    dataForm['id'] = $(this).attr('data-id');
    dataForm['data_form_item'] = $(this).parents('.box').find('form[data-form-item]').attr('data-form-item');
    // console.log(dataForm);
    let that = this;
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

                let rowDataDrowingStandard = data[0];
                let rowDataDrowingActual = data[1];
                let rowDataDrowingActualTime = data[2];
                let rowDataDrowingStandardTime = data[3];

                // To Preper Data Of DrowingStandard
                delete rowDataDrowingStandard['id'];
                delete rowDataDrowingStandard['added_by'];
                delete rowDataDrowingStandard['shift'];
                delete rowDataDrowingStandard['updated_by'];
                delete rowDataDrowingStandard['created_at'];
                delete rowDataDrowingStandard['updated_at'];

                delete rowDataDrowingStandardTime['id'];
                delete rowDataDrowingStandardTime['drowingstandards_id'];
                delete rowDataDrowingStandardTime['added_by'];
                delete rowDataDrowingStandardTime['shift'];
                delete rowDataDrowingStandardTime['updated_by'];
                delete rowDataDrowingStandardTime['created_at'];
                delete rowDataDrowingStandardTime['updated_at'];

                // To Preper Data Of DrowingActual

                let drowingActual_id = rowDataDrowingActual['id'];

                delete rowDataDrowingActual['id'];
                delete rowDataDrowingActual['jopOrderNumber_id'];
                delete rowDataDrowingActual['jopOrderNumber'];
                delete rowDataDrowingActual['added_by'];
                delete rowDataDrowingActual['shift'];
                delete rowDataDrowingActual['updated_by'];
                delete rowDataDrowingActual['created_at'];
                delete rowDataDrowingActual['updated_at'];

                delete rowDataDrowingActualTime['id'];
                delete rowDataDrowingActualTime['drowingactuals_id'];
                delete rowDataDrowingActualTime['added_by'];
                delete rowDataDrowingActualTime['shift'];
                delete rowDataDrowingActualTime['updated_by'];
                delete rowDataDrowingActualTime['created_at'];
                delete rowDataDrowingActualTime['updated_at'];

                // To Preper Data Of Drowing Row

                drowingRowData = { ...rowDataDrowingStandard, ...rowDataDrowingActual };
                drowingRowDataTime = { ...rowDataDrowingStandardTime, ...rowDataDrowingActualTime };

                // console.log(drowingRowData);
                // console.log(drowingRowDataTime);


                let form = $(that).parents('.box').children('.content').children('.drowingActual');
                let inputs = form.find('.input, textarea');
                // console.log(inputs);

                let count = 0;

                for (let key in drowingRowData) {
                    let currentInput = $(inputs).filter(`[name="${key}"]`);
                    if (count < 8 || (drowingRowData[key] != null && key != "notes" && drowingRowData[key] != '')) {
                        currentInput.prop('disabled', true);
                    } else {
                        // console.log(key);
                        currentInput.prop('disabled', false);
                        if (key != "notes") {
                            currentInput.prop('required', true);
                        }
                    }
                    currentInput.val(drowingRowData[currentInput.attr('name')]).prop('title', drowingRowData[currentInput.attr('name')]);
                    currentInput.attr('data-time', drowingRowDataTime[currentInput.attr('name') + '_time']);
                    count++;
                }

                form.find('button').prop('disabled', false);

                // To Save Data in LocalStorage
                SaveDataOfDrowingLocalStorage(that, inputs, true, drowingActual_id);

                //To Hide the DropDown-Alert if you use All of alerts 
                for (let i = 0; i < $('.drowing .dropdownalert').length; i++) {
                    let counter = 0;
                    let counterOfdropdownalert_item = $('.drowing .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
                    for (let j = 0; j <= counterOfdropdownalert_item; j++) {
                        if ($('.drowing .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                            counter++;
                        }

                    }

                    // console.log(counterOfdropdownalert_item, counter);
                    if (counter == counterOfdropdownalert_item) {
                        $('.drowing .dropdownalert').eq(i).addClass('d-none');
                    }

                }


                //To Close searchJopOrderNumber form
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfDrowing').find('.input').eq(1).prop('disabled', 'true');
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfDrowing').find('button').eq(0).prop('disabled', 'true');
                //To make Attantion For form to Know this data for update not create
                form.attr('data-update', true);
                form.attr('data-id-for-update', drowingActual_id);

                //To Show Icon Of Clear Sheet
                $(that).parents('.box').find('.fa-trash-restore').removeClass('d-none');

                return 0;

            } else {
                window.location.reload(true);
            }

        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log("Error");
        },
    });
});

//To Check Row
$('.drowing .input, .drowing textarea').blur(function () {
    let date = new Date().toLocaleString();
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    dataForm['data_form_item'] = $(this).parents('form').attr('data-form-item');
    dataForm['input'] = { 'name': $(this).attr('name'), 'value': $(this).val(), 'time': date };

    // console.log(dataForm);

    $.ajax({
        url: 'drowing/checkRow',
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
            // console.log(data.responseJSON);
        },
    });

});


// To Clear Sheat From Data That Not Completed
function clearDrowingSheet(sheetItem) {
    let dataOfDrowing = JSON.parse(localStorage.getItem('dataOfDrowing'));
    let inputs = $(`#Drowing_${sheetItem + 1} .drowingActual`).find('.input, textarea');
    for (let i = 0; i < inputs.length; i++) {
        let key = $(inputs[i]).attr('name');
        dataOfDrowing[sheetItem][key] = ["", "", (i <= 7) ? true : false, false];
    }
    //To Know if user called data from alerts or not
    dataOfDrowing[sheetItem]['isAlert'] = [false, null];
    localStorage.setItem('dataOfDrowing', JSON.stringify(dataOfDrowing));
    window.location.reload(true);
}

//To Save Data Of Drowing Sheets in LocalStorage for Refreash
let dataOfDrowing = [];

if (localStorage.getItem('dataOfDrowing') == null) {


    for (let i = 0; i <= 3; i++) {

        let dataOfDrowing_1 = {};
        let inputs_1 = $(`#Drowing_${i + 1} .drowingActual`).find('.input');
        let textarea_1 = $(`#Drowing_${i + 1} .drowingActual`).find('textarea')[0];
        inputs_1.push(textarea_1);
        // console.log(inputs_1);

        for (let j = 0; j < inputs_1.length; j++) {
            let key = $(inputs_1[j]).attr('name');
            /* 
            dataOfDrowing_1[0] => value of input
            dataOfDrowing_1[1] => data-time of input
            dataOfDrowing_1[2] => required
            dataOfDrowing_1[3] => disabled

            so We Have to make inputs Of Standard is Required

            */
            dataOfDrowing_1[key] = ["", "", (j <= 7) ? true : false, false];
        }
        //To Know if user called data from alerts or not
        dataOfDrowing_1['isAlert'] = [false, null];

        // console.log(dataOfDrowing_1);

        dataOfDrowing.push(dataOfDrowing_1);
    }
    // console.log(dataOfDrowing);
    localStorage.setItem('dataOfDrowing', JSON.stringify(dataOfDrowing));

    deliverDataFromDrowingLocalStorage();

} else {

    deliverDataFromDrowingLocalStorage();
    //To Hide the DropDown-Alert if you use All of alerts 
    for (let i = 0; i < $('.drowing .dropdownalert').length; i++) {
        let counter = 0;
        let counterOfdropdownalert_item = $('.drowing .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
        for (let j = 0; j <= counterOfdropdownalert_item; j++) {
            if ($('.drowing .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                counter++;
            }

        }

        // console.log(counterOfdropdownalert_item, counter);
        if (counter == counterOfdropdownalert_item) {
            $('.drowing .dropdownalert').eq(i).addClass('d-none');
        }

    }

}

function deliverDataFromDrowingLocalStorage() {
    dataOfDrowing = JSON.parse(localStorage.getItem('dataOfDrowing'));

    for (let i = 0; i <= 3; i++) {

        let inputs = $(`#Drowing_${i + 1} .drowingActual`).find('.input');
        let textarea = $(`#Drowing_${i + 1} .drowingActual`).find('textarea')[0];
        inputs.push(textarea);

        for (let j = 0; j < inputs.length; j++) {
            let inputFromLocalStorage = dataOfDrowing[i][$(inputs[j]).attr('name')];
            $(inputs[j]).val(inputFromLocalStorage[0]);
            $(inputs[j]).attr('data-time', inputFromLocalStorage[1]);
            $(inputs[j]).prop('required', inputFromLocalStorage[2]);
            $(inputs[j]).prop('disabled', inputFromLocalStorage[3]);
        }

        if (dataOfDrowing[i]['isAlert'][0]) {
            $('.drowing .popUp').eq(i).find('.dataNotComplete').addClass('d-none');
            $('.drowing .popUp').eq(i).find('.searchJopOrderNumberOfDrowing input[name="jopOrderNumber"]').prop('disabled', true);
            $('.drowing .popUp').eq(i).find('.searchJopOrderNumberOfDrowing button').prop('disabled', true);
            /* 
            this Line To
            hide dropdownalert-item if it is called at one of sheet to complete it 
            And add attrebute data-sheet-item to dropdownalert-item after Refresh
            */
            $('.drowing .popUp').find(`.dataNotComplete .dropdownalert-item[data-id=${dataOfDrowing[i]['isAlert'][1]}]`).addClass('d-none').attr('data-sheet-item', i);
            $('.drowing .popUp').eq(i).find('.drowingActual').attr('data-update', dataOfDrowing[i]['isAlert'][0]);
            $('.drowing .popUp').eq(i).find('.drowingActual').attr('data-id-for-update', dataOfDrowing[i]['isAlert'][1]);
            $('.drowing .popUp').eq(i).attr('data-isAlert', true);
            $('.drowing .popUp').eq(i).attr('update-data-sheet-of-id', dataOfDrowing[i]['isAlert'][1]);
            //To Show Icon Of Clear Sheet
            $('.drowing .popUp').eq(i).find('.fa-trash-restore').removeClass('d-none');
        }

    }
}

function SaveDataOfDrowingLocalStorage(element, inputs, isAlert = false, itemOfAlert = null) {
    let dataOfDrowing = JSON.parse(localStorage.getItem('dataOfDrowing'));
    let item = $(element).parents('.popUp').attr('data-item');
    for (let j = 0; j < inputs.length; j++) {
        dataOfDrowing[item][$(inputs[j]).attr('name')] = [$(inputs[j]).val(), $(inputs[j]).attr('data-time'), $(inputs[j]).prop('required'), $(inputs[j]).prop('disabled')];
    }
    dataOfDrowing[item]['isAlert'] = [isAlert, itemOfAlert];
    localStorage.setItem('dataOfDrowing', JSON.stringify(dataOfDrowing));
}









