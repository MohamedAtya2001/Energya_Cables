

//To Insert Armouring
$('form.armouringActual').submit(function (e) {
    e.preventDefault();
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
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
                $('.searchJopOrderNumberOfArmouring').find('.input');
                $('.searchJopOrderNumberOfArmouring').find('button');
                $($(that).find('.input')).prop('required', false);
                $($(that).find('textarea')).prop("required", false);
                $($(that).find('.input')).val('');
                $($(that).find('textarea')).val('');
                $(that).removeAttr('data-id-for-update');
                $(that).attr('data-update', false);
                $(`.dropdownalert-menu .dropdownalert-item[data-sheet-item="${$(that).parents('.popUp').attr('data-item')}"]`).attr('updated', true);
                //To Open Every Sheet If All of Alert is Done
                if ($(that).parents('.popUp').find(`.dropdownalert-menu .dropdownalert-item:not(.dropdownalert-menu .dropdownalert-item[updated="true"])`).length == 0) {
                    $('.armouring').find('.input, textarea, button:not(button.text-warning)').prop('disabled', false).removeClass('error');
                    $('.armouring .searchJopOrderNumberOfArmouring').find('.input').prop('disabled', false);
                    $('.armouring .searchJopOrderNumberOfArmouring').find('button').prop('disabled', false);
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
            } else if (data == 'Error-dimAfterStart') {
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').addClass('error');
                $('.armouring').get('0').scrollTop += $($(that).find('input[name="dimAfterStartMin"]')).offset().top - 20;
            } else if (data == 'Error-dimAfterEnd') {
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').addClass('error');
                $('.armouring').get('0').scrollTop += $($(that).find('input[name="dimAfterEndMin"]')).offset().top - 20;
            } else if (data == 'Error-notes') {
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
                $(that).find('textarea[name="notes"]').addClass('error');
                $('.armouring').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
            } else {
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
                $(that).find('textarea[name="notes"]').removeClass('error');
                $($(that).find('.input')).val('').prop("disabled", false);
                $($(that).find('textarea')).val('').prop("disabled", false);
            }

            // To Save Data in LocalStorage
            let inputs = $(that).find('.input');
            inputs.push($(that).find('textarea'));
            SaveDataOfArmouringLocalStorage(that, inputs);

        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        },


    });

});

//To Search jopOrderNumber Armouring
$('form.searchJopOrderNumberOfArmouring').submit(function (e) {
    e.preventDefault();
    let that = this;
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
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
                // console.log(data);
                let inputs = $(that).siblings('form').find('.standard input');

                for (let i = 0; i <= inputs.length; i++) {
                    $(inputs[i]).val(data[$(inputs[i]).attr('name')]).prop("disabled", true);
                    let date = new Date().toLocaleString();
                    $(inputs[i]).attr('data-time', date);
                }

                // To Save Data in LocalStorage
                SaveDataOfArmouringLocalStorage(that, inputs);


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
                SaveDataOfArmouringLocalStorage(that, inputs);
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
$('.armouring .dataNotComplete form').click(function (e) {
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
                let rowDataArmouringStandard = data[0];
                let rowDataArmouringActual = data[1];
                let rowDataArmouringActualTime = data[2];
                let rowDataArmouringStandardTime = data[3];
                // console.log(data);

                // To Preper Data Of ArmouringStandard
                delete rowDataArmouringStandard['id'];
                delete rowDataArmouringStandard['added_by'];
                delete rowDataArmouringStandard['shift'];
                delete rowDataArmouringStandard['updated_by'];
                delete rowDataArmouringStandard['created_at'];
                delete rowDataArmouringStandard['updated_at'];

                // To Preper Data Of ArmouringStandardTime
                delete rowDataArmouringStandardTime['id'];
                delete rowDataArmouringStandardTime['armouringstandards_id'];
                delete rowDataArmouringStandardTime['added_by'];
                delete rowDataArmouringStandardTime['shift'];
                delete rowDataArmouringStandardTime['updated_by'];
                delete rowDataArmouringStandardTime['created_at'];
                delete rowDataArmouringStandardTime['updated_at'];

                // To Preper Data Of StrindingActual
                let armouringActual_id = rowDataArmouringActual['id'];

                delete rowDataArmouringActual['id'];
                delete rowDataArmouringActual['jopOrderNumber_id'];
                delete rowDataArmouringActual['jopOrderNumber'];
                delete rowDataArmouringActual['added_by'];
                delete rowDataArmouringActual['shift'];
                delete rowDataArmouringActual['updated_by'];
                delete rowDataArmouringActual['created_at'];
                delete rowDataArmouringActual['updated_at'];

                // To Preper Data Of ArmouringActualTime
                delete rowDataArmouringActualTime['id'];
                delete rowDataArmouringActualTime['armouringactuals_id'];
                delete rowDataArmouringActualTime['added_by'];
                delete rowDataArmouringActualTime['shift'];
                delete rowDataArmouringActualTime['updated_by'];
                delete rowDataArmouringActualTime['created_at'];
                delete rowDataArmouringActualTime['updated_at'];

                armouringRowData = { ...rowDataArmouringStandard, ...rowDataArmouringActual };
                armouringRowDataTime = { ...rowDataArmouringStandardTime, ...rowDataArmouringActualTime };

                // console.log(armouringRowData);
                // console.log(armouringRowDataTime);

                let form = $(that).parents('.box').children('.content').children('.armouringActual');
                let inputs = form.find('.input, textarea');
                //  console.log(inputs);

                let count = 0;

                for (let key in armouringRowData) {
                    let currentInput = $(inputs).filter(`[name="${key}"]`);
                    if (count < 7 || (armouringRowData[key] != null && key != "notes" && armouringRowData[key] != '')) {
                        currentInput.prop('disabled', true);
                    } else {
                        //    console.log(key);
                        currentInput.prop('disabled', false);
                        if (key != "notes") {
                            currentInput.prop('required', true);
                        }
                    }
                    currentInput.val(armouringRowData[currentInput.attr('name')]).prop('title', armouringRowData[currentInput.attr('name')]);
                    currentInput.attr('data-time', armouringRowData[currentInput.attr('name') + '_time']);
                    count++;
                }

                form.find('button').prop('disabled', false);

                // To Save Data in LocalStorage
                SaveDataOfArmouringLocalStorage(that, inputs, true, armouringActual_id);

                //To Hide the DropDown-Alert if you use All of alerts 
                for (let i = 0; i < $('.armouring .dropdownalert').length; i++) {
                    let counter = 0;
                    let counterOfdropdownalert_item = $('.armouring .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
                    for (let j = 0; j <= counterOfdropdownalert_item; j++) {
                        if ($('.armouring .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                            counter++;
                        }

                    }

                    // console.log(counterOfdropdownalert_item, counter);
                    if (counter == counterOfdropdownalert_item) {
                        $('.armouring .dropdownalert').eq(i).addClass('d-none');
                    }

                }



                //To Close searchJopOrderNumber form
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfArmouring').find('.input').eq(1).prop('disabled', 'true');
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfArmouring').find('button').eq(0).prop('disabled', 'true');
                //To make Attantion For form to Know this data for update not create
                form.attr('data-update', true);
                form.attr('data-id-for-update', armouringActual_id);

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
function clearArmouringSheet(sheetItem) {
    let dataOfArmouring = JSON.parse(localStorage.getItem('dataOfArmouring'));
    let inputs = $(`#Armouring_${sheetItem + 1} .armouringActual`).find('.input, textarea');
    for (let i = 0; i < inputs.length; i++) {
        let key = $(inputs[i]).attr('name');
        dataOfArmouring[sheetItem][key] = ["", "", (i <= 11) ? true : false, false];
    }
    //To Know if user called data from alerts or not
    dataOfArmouring[sheetItem]['isAlert'] = [false, null];
    localStorage.setItem('dataOfArmouring', JSON.stringify(dataOfArmouring));
    window.location.reload(true);
}

//To Save Data Of Armouring Sheets in LocalStorage for Refreash
let dataOfArmouring = [];

if (localStorage.getItem('dataOfArmouring') == null) {


    for (let i = 0; i <= 1; i++) {

        let dataOfArmouring_1 = {};
        let inputs_1 = $(`#Armouring_${i + 1} .armouringActual`).find('.input');
        let textarea_1 = $(`#Armouring_${i + 1} .armouringActual`).find('textarea')[0];
        inputs_1.push(textarea_1);
        // console.log(inputs_1);

        for (let j = 0; j < inputs_1.length; j++) {
            let key = $(inputs_1[j]).attr('name');
            /* 
            dataOfArmouring_1[0] => value of input
            dataOfArmouring_1[1] => data-time of input
            dataOfArmouring_1[2] => required
            dataOfArmouring_1[3] => disabled

            so We Have to make inputs Of Standard is Required
            (j <= 7 || j == 8)
            j <= 7 => For Standard Inputs
            j == 8 => For label
            */
            dataOfArmouring_1[key] = ["", "", (j <= 7 || j == 8) ? true : false, false];
        }
        //To Know if user called data from alerts or not
        dataOfArmouring_1['isAlert'] = [false, null];

        // console.log(dataOfArmouring_1);

        dataOfArmouring.push(dataOfArmouring_1);
    }
    // console.log(dataOfArmouring);
    localStorage.setItem('dataOfArmouring', JSON.stringify(dataOfArmouring));

    deliverDataFromArmouringLocalStorage();

} else {

    deliverDataFromArmouringLocalStorage();

    //To Hide the DropDown-Alert if you use All of alerts 
    for (let i = 0; i < $('.armouring .dropdownalert').length; i++) {
        let counter = 0;
        let counterOfdropdownalert_item = $('.armouring .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
        for (let j = 0; j <= counterOfdropdownalert_item; j++) {
            if ($('.armouring .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                counter++;
            }

        }

        // console.log(counterOfdropdownalert_item, counter);
        if (counter == counterOfdropdownalert_item) {
            $('.armouring .dropdownalert').eq(i).addClass('d-none');
        }

    }

}

function deliverDataFromArmouringLocalStorage() {
    dataOfArmouring = JSON.parse(localStorage.getItem('dataOfArmouring'));

    for (let i = 0; i <= 1; i++) {

        let inputs = $(`#Armouring_${i + 1} .armouringActual`).find('.input');
        let textarea = $(`#Armouring_${i + 1} .armouringActual`).find('textarea')[0];
        inputs.push(textarea);



        for (let j = 0; j < inputs.length; j++) {
            let inputFromLocalStorage = dataOfArmouring[i][$(inputs[j]).attr('name')];
            $(inputs[j]).val(inputFromLocalStorage[0]);
            $(inputs[j]).attr('data-time', inputFromLocalStorage[1]);
            $(inputs[j]).prop('required', inputFromLocalStorage[2]);
            $(inputs[j]).prop('disabled', inputFromLocalStorage[3]);
        }

        if (dataOfArmouring[i]['isAlert'][0]) {
            $('.armouring .popUp').eq(i).find('.dataNotComplete').addClass('d-none');
            $('.armouring .popUp').eq(i).find('.searchJopOrderNumberOfArmouring input[name="jopOrderNumber"]').prop('disabled', true);
            $('.armouring .popUp').eq(i).find('.searchJopOrderNumberOfArmouring button').prop('disabled', true);
            /* 
            this Line To
            hide dropdownalert-item if it is called at one of sheet to complete it 
            And add attrebute data-sheet-item to dropdownalert-item after Refresh
            */
            $('.armouring .popUp').find(`.dataNotComplete .dropdownalert-item[data-id=${dataOfArmouring[i]['isAlert'][1]}]`).addClass('d-none').attr('data-sheet-item', i);
            $('.armouring .popUp').eq(i).find('.armouringActual').attr('data-update', dataOfArmouring[i]['isAlert'][0]);
            $('.armouring .popUp').eq(i).find('.armouringActual').attr('data-id-for-update', dataOfArmouring[i]['isAlert'][1]);
            $('.armouring .popUp').eq(i).attr('data-isAlert', true);
            $('.armouring .popUp').eq(i).attr('update-data-sheet-of-id', dataOfArmouring[i]['isAlert'][1]);
            //To Show Icon Of Clear Sheet
            $('.armouring .popUp').eq(i).find('.fa-trash-restore').removeClass('d-none');
        }

    }
}

function SaveDataOfArmouringLocalStorage(element, inputs, isAlert = false, itemOfAlert = null) {
    let dataOfArmouring = JSON.parse(localStorage.getItem('dataOfArmouring'));
    let item = $(element).parents('.popUp').attr('data-item');
    for (let j = 0; j < inputs.length; j++) {
        dataOfArmouring[item][$(inputs[j]).attr('name')] = [$(inputs[j]).val(), $(inputs[j]).attr('data-time'), $(inputs[j]).prop('required'), $(inputs[j]).prop('disabled')];
    }
    dataOfArmouring[item]['isAlert'] = [isAlert, itemOfAlert];
    localStorage.setItem('dataOfArmouring', JSON.stringify(dataOfArmouring));
}






