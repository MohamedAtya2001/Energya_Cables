
//To Insert Assembly
$('.assembly form.assemblyActual').submit(function (e) {
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
    dataForm['data_form_item'] = $(this).attr('data-form-item');
    if ($(this).attr('data-id-for-update') != undefined) {
        dataForm['id_update'] = $(this).attr('data-id-for-update');
    }
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
            if (data == "Updated") {
                $('.dataNotComplete').find('.updated').css('display', 'none');
                $('.searchJopOrderNumberOfAssembly').find('.input');
                $('.searchJopOrderNumberOfAssembly').find('button');
                $($(that).find('.input')).prop('required', false);
                $($(that).find('textarea')).prop("required", false);
                $($(that).find('.input')).val('');
                $($(that).find('textarea')).val('');
                $(that).removeAttr('data-id-for-update');
                $(that).attr('data-update', false);
                $(`.dropdownalert-menu .dropdownalert-item[data-sheet-item="${$(that).parents('.popUp').attr('data-item')}"]`).attr('updated', true);
                //To Open Every Sheet If All of Alert is Done
                if ($(that).parents('.popUp').find(`.dropdownalert-menu .dropdownalert-item:not(.dropdownalert-menu .dropdownalert-item[updated="true"])`).length == 0) {
                    $('.assembly').find('.input, textarea, button:not(button.text-warning)').prop('disabled', false).removeClass('error');
                    $('.assembly .searchJopOrderNumberOfAssdataOfAssembly').find('.input').prop('disabled', false);
                    $('.assembly .searchJopOrderNumberOfAssdataOfAssembly').find('button').prop('disabled', false);
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
            } else if (data == "Error-inputDrum1") {
                $(that).find('input[name="inputDrum1"]').addClass('error');
                $('.assembly').get('0').scrollTop += $($(that).find('input[name="inputDrum1"]')).offset().top - 20;
            } else if (data == "Error-inputCard1") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').addClass('error');
                $('.assembly').get('0').scrollTop += $($(that).find('input[name="inputCard1"]')).offset().top - 20;
            } else if (data == "Error-inputLength1") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').addClass('error');
                $('.assembly').get('0').scrollTop += $($(that).find('input[name="inputLength1"]')).offset().top - 20;
            } else if (data == "Error-color1") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').addClass('error');
                $('.assembly').get('0').scrollTop += $($(that).find('input[name="color1"]')).offset().top - 20;
            } else if (data == "Error-color2") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').removeClass('error');
                $(that).find('input[name="color2"]').addClass('error');
                $('.assembly').get('0').scrollTop += $($(that).find('input[name="color2"]')).offset().top - 20;
            } else if (data == "Error-color3") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').removeClass('error');
                $(that).find('input[name="color2"]').removeClass('error');
                $(that).find('input[name="color3"]').addClass('error');
                $('.assembly').get('0').scrollTop += $($(that).find('input[name="color3"]')).offset().top - 20;
            } else if (data == "Error-color4") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').removeClass('error');
                $(that).find('input[name="color2"]').removeClass('error');
                $(that).find('input[name="color3"]').removeClass('error');
                $(that).find('input[name="color4"]').addClass('error');
                $('.assembly').get('0').scrollTop += $($(that).find('input[name="color4"]')).offset().top - 20;
            } else if (data == "Error-color5") {
                $(that).find('input[name="inputDrum1"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="inputLength1"]').removeClass('error');
                $(that).find('input[name="color1"]').removeClass('error');
                $(that).find('input[name="color2"]').removeClass('error');
                $(that).find('input[name="color3"]').removeClass('error');
                $(that).find('input[name="color4"]').removeClass('error');
                $(that).find('input[name="color5"]').addClass('error');
                $('.assembly').get('0').scrollTop += $($(that).find('input[name="color5"]')).offset().top - 20;
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
                $('.assembly').get('0').scrollTop += $($(that).find('input[name="outerDimMinActual"]')).offset().top - 20;
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
                $('.assembly').get('0').scrollTop += $($(that).find('input[name="ppTapeSize"]')).offset().top - 20;
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
                $('.assembly').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
            } else {
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
                $($(that).find('.input')).val('').prop("disabled", false);
                $($(that).find('textarea')).val('').prop("disabled", false);
            }
            // To Save Data in LocalStorage
            let inputs = $(that).find('.input');
            inputs.push($(that).find('textarea'));
            SaveDataOfAssemblyLocalStorage(that, inputs);
        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            //console.log('error');
            /* console.log(data.responseJSON.message);
            let errors = data.responseJSON.errors;
            let index = 1;
            $.each(errors, function (key, value) {
                $($(that).find('.input')[index]).siblings('p.error').html(value).css('display', 'block');
                index++;
            }); */

        }
    });
});

//To  Search jopOrderNumber Assembly
$('.assembly form.searchJopOrderNumberOfAssembly').submit(function (e) {
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

                let inputs = $(that).siblings('form').find('.standard .input');

                for (let i = 0; i <= inputs.length; i++) {
                    $(inputs[i]).val(data[$(inputs[i]).attr('name')]).prop("disabled", true);
                    let date = new Date().toLocaleString();
                    $(inputs[i]).attr('data-time', date);
                }

                // To Save Data in LocalStorage
                SaveDataOfAssemblyLocalStorage(that, inputs);

            } else {
                let inputs = $(that).siblings('form').find('.standard .input');

                //To Print jopOrderNumber inside Input
                $(inputs[0]).val(data).prop("disabled", true);
                let date = new Date().toLocaleString();
                $(inputs[0]).attr('data-time', date);

                for (let i = 1; i <= inputs.length; i++) {
                    $(inputs[i]).val('').prop("disabled", false);
                }

                // To Save Data in LocalStorage
                SaveDataOfAssemblyLocalStorage(that, inputs);


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
$('.assembly .dataNotComplete form').click(function (e) {
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
                // console.log(data);
                let rowDataAssemblyStandard = data[0];
                let rowDataAssemblyActual = data[1];
                let rowDataAssemblyActualTime = data[2];
                let rowDataAssemblyStandardTime = data[3];

                // To Preper Data Of AssemblyStandard
                delete rowDataAssemblyStandard['id'];
                delete rowDataAssemblyStandard['added_by'];
                delete rowDataAssemblyStandard['shift'];
                delete rowDataAssemblyStandard['updated_by'];
                delete rowDataAssemblyStandard['created_at'];
                delete rowDataAssemblyStandard['updated_at'];

                delete rowDataAssemblyStandardTime['id'];
                delete rowDataAssemblyStandardTime['assemblystandards_id'];
                delete rowDataAssemblyStandardTime['added_by'];
                delete rowDataAssemblyStandardTime['shift'];
                delete rowDataAssemblyStandardTime['updated_by'];
                delete rowDataAssemblyStandardTime['created_at'];
                delete rowDataAssemblyStandardTime['updated_at'];

                // To Preper Data Of AssemblyActual

                let assemblyActual_id = rowDataAssemblyActual['id'];

                delete rowDataAssemblyActual['id'];
                delete rowDataAssemblyActual['jopOrderNumber_id'];
                delete rowDataAssemblyActual['jopOrderNumber'];
                delete rowDataAssemblyActual['added_by'];
                delete rowDataAssemblyActual['shift'];
                delete rowDataAssemblyActual['updated_by'];
                delete rowDataAssemblyActual['created_at'];
                delete rowDataAssemblyActual['updated_at'];

                delete rowDataAssemblyActualTime['id'];
                delete rowDataAssemblyActualTime['assemblyactuals_id'];
                delete rowDataAssemblyActualTime['added_by'];
                delete rowDataAssemblyActualTime['shift'];
                delete rowDataAssemblyActualTime['updated_by'];
                delete rowDataAssemblyActualTime['created_at'];
                delete rowDataAssemblyActualTime['updated_at'];

                // To Preper Data Of Assembly Row

                assemblyRowData = { ...rowDataAssemblyStandard, ...rowDataAssemblyActual };
                assemblyRowDataTime = { ...rowDataAssemblyStandardTime, ...rowDataAssemblyActualTime };

                // console.log(assemblyRowData);
                // console.log(assemblyRowDataTime);

                let form = $(that).parents('.box').children('.content').children('.assemblyActual');
                let inputs = form.find('.input, textarea');
                //  console.log(inputs);
                let count = 0;

                for (let key in assemblyRowData) {
                    let currentInput = $(inputs).filter(`[name="${key}"]`);
                    if (count < 11 || (assemblyRowData[key] != null && key != "notes" && assemblyRowData[key] != '')) {
                        $(inputs[count]).prop('disabled', true);
                    } else {
                        // console.log(key);
                        $(inputs[count]).prop('disabled', false);
                        if (key != 'inputDrum2' &&
                            key != 'inputDrum3' &&
                            key != 'inputDrum4' &&
                            key != 'inputDrum5' &&
                            key != 'inputCard2' &&
                            key != 'inputCard3' &&
                            key != 'inputCard4' &&
                            key != 'inputCard5' &&
                            key != 'inputLength2' &&
                            key != 'inputLength3' &&
                            key != 'inputLength4' &&
                            key != 'inputLength5' &&
                            key != 'color2' &&
                            key != 'color3' &&
                            key != 'color4' &&
                            key != 'color5' &&
                            key != "notes") {
                            $(inputs[count]).prop('required', true);
                        }
                    }
                    $(inputs[count]).val(assemblyRowData[$(inputs[count]).attr('name')]).prop('title', assemblyRowData[currentInput.attr('name')]);
                    $(inputs[count]).attr('data-time', assemblyRowData[$(inputs[count]).attr('name') + '_time']);
                    count++;
                }

                form.find('button').prop('disabled', false);

                // To Save Data in LocalStorage
                SaveDataOfAssemblyLocalStorage(that, inputs, true, assemblyActual_id);

                //To Hide the DropDown-Alert if you use All of alerts 
                for (let i = 0; i < $('.assembly .dropdownalert').length; i++) {
                    let counter = 0;
                    let counterOfdropdownalert_item = $('.assembly .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
                    for (let j = 0; j <= counterOfdropdownalert_item; j++) {
                        if ($('.assembly .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                            counter++;
                        }

                    }

                    // console.log(counterOfdropdownalert_item, counter);
                    if (counter == counterOfdropdownalert_item) {
                        $('.assembly .dropdownalert').eq(i).addClass('d-none');
                    }

                }


                //To Close searchJopOrderNumber form
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfAssembly').find('.input').eq(1).prop('disabled', 'true');
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfAssembly').find('button').eq(0).prop('disabled', 'true');
                //To make Attantion For form to Know this data for update not create
                form.attr('data-update', true);
                form.attr('data-id-for-update', assemblyActual_id);

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
function clearAssemblySheet(sheetItem) {
    let dataOfAssembly = JSON.parse(localStorage.getItem('dataOfAssembly'));
    let inputs = $(`#Assembly_${sheetItem + 1} .assemblyActual`).find('.input, textarea');
    for (let i = 0; i < inputs.length; i++) {
        let key = $(inputs[i]).attr('name');
        dataOfAssembly[sheetItem][key] = ["", "", (i <= 10) ? true : false, false];
    }
    //To Know if user called data from alerts or not
    dataOfAssembly[sheetItem]['isAlert'] = [false, null];
    localStorage.setItem('dataOfAssembly', JSON.stringify(dataOfAssembly));
    window.location.reload(true);
}

//To Save Data Of Assembly Sheets in LocalStorage for Refreash
let dataOfAssembly = [];

if (localStorage.getItem('dataOfAssembly') == null) {


    for (let i = 0; i <= 2; i++) {

        let dataOfAssembly_1 = {};
        let inputs_1 = $(`#Assembly_${i + 1} .assemblyActual`).find('.input');
        let textarea_1 = $(`#Assembly_${i + 1} .assemblyActual`).find('textarea')[0];
        inputs_1.push(textarea_1);
        // console.log(inputs_1);

        for (let j = 0; j < inputs_1.length; j++) {
            let key = $(inputs_1[j]).attr('name');
            /* 
            dataOfAssembly_1[0] => value of input
            dataOfAssembly_1[1] => data-time of input
            dataOfAssembly_1[2] => required
            dataOfAssembly_1[3] => disabled

            so We Have to make inputs Of Standard is Required
            (j <= 10 || j == 11)
            j <= 10 => For Standard Inputs
            j == 11 => For label

            */
            dataOfAssembly_1[key] = ["", "", (j <= 10 || j == 11) ? true : false, false];
        }
        //To Know if user called data from alerts or not
        dataOfAssembly_1['isAlert'] = [false, null];

        // console.log(dataOfAssembly_1);

        dataOfAssembly.push(dataOfAssembly_1);
    }
    // console.log(dataOfAssembly);
    localStorage.setItem('dataOfAssembly', JSON.stringify(dataOfAssembly));

    deliverDataFromAssemblyLocalStorage();

} else {

    deliverDataFromAssemblyLocalStorage();
    //To Hide the DropDown-Alert if you use All of alerts 
    for (let i = 0; i < $('.assembly .dropdownalert').length; i++) {
        let counter = 0;
        let counterOfdropdownalert_item = $('.assembly .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
        for (let j = 0; j <= counterOfdropdownalert_item; j++) {
            if ($('.assembly .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                counter++;
            }

        }

        // console.log(counterOfdropdownalert_item, counter);
        if (counter == counterOfdropdownalert_item) {
            $('.assembly .dropdownalert').eq(i).addClass('d-none');
        }

    }

}

function deliverDataFromAssemblyLocalStorage() {
    dataOfAssembly = JSON.parse(localStorage.getItem('dataOfAssembly'));

    for (let i = 0; i <= 2; i++) {

        let inputs = $(`#Assembly_${i + 1} .assemblyActual`).find('.input');
        let textarea = $(`#Assembly_${i + 1} .assemblyActual`).find('textarea')[0];
        inputs.push(textarea);



        for (let j = 0; j < inputs.length; j++) {
            let inputFromLocalStorage = dataOfAssembly[i][$(inputs[j]).attr('name')];
            $(inputs[j]).val(inputFromLocalStorage[0]);
            $(inputs[j]).attr('data-time', inputFromLocalStorage[1]);
            $(inputs[j]).prop('required', inputFromLocalStorage[2]);
            $(inputs[j]).prop('disabled', inputFromLocalStorage[3]);
        }

        if (dataOfAssembly[i]['isAlert'][0]) {
            $('.assembly .popUp').eq(i).find('.dataNotComplete').addClass('d-none');
            $('.assembly .popUp').eq(i).find('.searchJopOrderNumberOfAssembly input[name="jopOrderNumber"]').prop('disabled', true);
            $('.assembly .popUp').eq(i).find('.searchJopOrderNumberOfAssembly button').prop('disabled', true);
            /* 
            this Line To
            hide dropdownalert-item if it is called at one of sheet to complete it 
            And add attrebute data-sheet-item to dropdownalert-item after Refresh
            */
            $('.assembly .popUp').find(`.dataNotComplete .dropdownalert-item[data-id=${dataOfAssembly[i]['isAlert'][1]}]`).addClass('d-none').attr('data-sheet-item', i);
            $('.assembly .popUp').eq(i).find('.assemblyActual').attr('data-update', dataOfAssembly[i]['isAlert'][0]);
            $('.assembly .popUp').eq(i).find('.assemblyActual').attr('data-id-for-update', dataOfAssembly[i]['isAlert'][1]);
            $('.assembly .popUp').eq(i).attr('data-isAlert', true);
            $('.assembly .popUp').eq(i).attr('update-data-sheet-of-id', dataOfAssembly[i]['isAlert'][1]);
            //To Show Icon Of Clear Sheet
            $('.assembly .popUp').eq(i).find('.fa-trash-restore').removeClass('d-none');
        }

    }
}

function SaveDataOfAssemblyLocalStorage(element, inputs, isAlert = false, itemOfAlert = null) {
    let dataOfAssembly = JSON.parse(localStorage.getItem('dataOfAssembly'));
    let item = $(element).parents('.popUp').attr('data-item');
    for (let j = 0; j < inputs.length; j++) {
        dataOfAssembly[item][$(inputs[j]).attr('name')] = [$(inputs[j]).val(), $(inputs[j]).attr('data-time'), $(inputs[j]).prop('required'), $(inputs[j]).prop('disabled')];
    }
    dataOfAssembly[item]['isAlert'] = [isAlert, itemOfAlert];
    localStorage.setItem('dataOfAssembly', JSON.stringify(dataOfAssembly));
}









