
//To Insert Sheathing
$('form.sheathingActual').submit(function (e) {
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
                $('.searchJopOrderNumberOfSheathing').find('.input');
                $('.searchJopOrderNumberOfSheathing').find('button');
                $($(that).find('.input')).prop('required', false);
                $($(that).find('textarea')).prop("required", false);
                $(that).find('input[name="thicknessStandard"]').removeClass('error');
                $(that).find('input[name="thicknessActual"]').removeClass('error');
                $($(that).find('.input')).val('');
                $($(that).find('textarea')).val('');
                $(that).removeAttr('data-id-for-update');
                $(that).attr('data-update', false);
                $(`.dropdownalert-menu .dropdownalert-item[data-sheet-item="${$(that).parents('.popUp').attr('data-item')}"]`).attr('updated', true);
                //To Open Every Sheet If All of Alert is Done
                if ($(that).parents('.popUp').find(`.dropdownalert-menu .dropdownalert-item:not(.dropdownalert-menu .dropdownalert-item[updated="true"])`).length == 0) {
                    $('.sheathing').find('.input, textarea, button:not(button.text-warning)').prop('disabled', false).removeClass('error');
                    $('.sheathing .searchJopOrderNumberOfSheathing').find('.input').prop('disabled', false);
                    $('.sheathing .searchJopOrderNumberOfSheathing').find('button').prop('disabled', false);
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
            } else if (data == 'Error-thicknessStartActual') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').addClass('error');
                $('.sheathing').get('0').scrollTop += $($(that).find('input[name="thicknessStartMinActual"]')).offset().top - 20;
            } else if (data == 'Error-thicknessEndActual') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').addClass('error');
                $('.sheathing').get('0').scrollTop += $($(that).find('input[name="thicknessEndMinActual"]')).offset().top - 20;
            } else if (data == 'Error-dimBefore1') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').addClass('error');
                $('.sheathing').get('0').scrollTop += $($(that).find('input[name="dimBefore1"]')).offset().top - 20;
            } else if (data == 'Error-dimAfterStart') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').addClass('error');
                $('.sheathing').get('0').scrollTop += $($(that).find('input[name="dimAfterStartMin"]')).offset().top - 20;
            } else if (data == 'Error-dimAfterEnd') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').addClass('error');
                $('.sheathing').get('0').scrollTop += $($(that).find('input[name="dimAfterEndMin"]')).offset().top - 20;
            } else if (data == 'Error-ovalityActual1') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
                $(that).find('input[name="ovalityActual1"]').addClass('error');
                $('.sheathing').get('0').scrollTop += $($(that).find('textarea[name="ovalityActual1"]')).offset().top - 20;
            } else if (data == 'Error-notes') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
                $(that).find('input[name="ovalityActual1"]').removeClass('error');
                $(that).find('textarea[name="notes"]').addClass('error');
                $('.sheathing').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
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
            SaveDataOfSheathingLocalStorage(that, inputs);


        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        },

    });

});

//To  Search jopOrderNumber Sheathing
$('form.searchJopOrderNumberOfSheathing').submit(function (e) {
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

                // console.log(data);
                let inputs = $(that).siblings('form').find('.standard input');
                for (let i = 0; i <= inputs.length; i++) {
                    $(inputs[i]).val(data[$(inputs[i]).attr('name')]).prop("disabled", true);
                    let date = new Date().toLocaleString();
                    $(inputs[i]).attr('data-time', date);
                }


                // To Save Data in LocalStorage
                SaveDataOfSheathingLocalStorage(that, inputs);

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
                SaveDataOfSheathingLocalStorage(that, inputs);

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
$('.sheathing .dataNotComplete form').click(function (e) {
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
                let rowDataSheathingStandard = data[0];
                let rowDataSheathingActual = data[1];
                let rowDataSheathingActualTime = data[2];
                let rowDataSheathingStandardTime = data[3];

                // To Preper Data Of SheathingStandard
                delete rowDataSheathingStandard['id'];
                delete rowDataSheathingStandard['added_by'];
                delete rowDataSheathingStandard['shift'];
                delete rowDataSheathingStandard['updated_by'];
                delete rowDataSheathingStandard['created_at'];
                delete rowDataSheathingStandard['updated_at'];

                delete rowDataSheathingStandardTime['id'];
                delete rowDataSheathingStandardTime['sheathingstandards_id'];
                delete rowDataSheathingStandardTime['added_by'];
                delete rowDataSheathingStandardTime['shift'];
                delete rowDataSheathingStandardTime['updated_by'];
                delete rowDataSheathingStandardTime['created_at'];
                delete rowDataSheathingStandardTime['updated_at'];

                // To Preper Data Of SheathingActual

                let sheathingActual_id = rowDataSheathingActual['id'];

                delete rowDataSheathingActual['id'];
                delete rowDataSheathingActual['jopOrderNumber_id'];
                delete rowDataSheathingActual['jopOrderNumber'];
                delete rowDataSheathingActual['added_by'];
                delete rowDataSheathingActual['shift'];
                delete rowDataSheathingActual['updated_by'];
                delete rowDataSheathingActual['created_at'];
                delete rowDataSheathingActual['updated_at'];

                delete rowDataSheathingActualTime['id'];
                delete rowDataSheathingActualTime['sheathingactuals_id'];
                delete rowDataSheathingActualTime['added_by'];
                delete rowDataSheathingActualTime['shift'];
                delete rowDataSheathingActualTime['updated_by'];
                delete rowDataSheathingActualTime['created_at'];
                delete rowDataSheathingActualTime['updated_at'];

                // To Preper Data Of Sheathing Row

                sheathingRowData = { ...rowDataSheathingStandard, ...rowDataSheathingActual };
                sheathingRowDataTime = { ...rowDataSheathingStandardTime, ...rowDataSheathingActualTime };

                //   console.log(sheathingRowData);
                //   console.log(sheathingRowDataTime);


                let form = $(that).parents('.box').children('.content').children('.sheathingActual');
                let inputs = form.find('.input, textarea');
                //  console.log(inputs);
                let count = 0;

                for (let key in sheathingRowData) {
                    let currentInput = $(inputs).filter(`[name="${key}"]`);
                    if (count < 13 || (sheathingRowData[key] != null && key != "notes" && sheathingRowData[key] != '')) {
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
                    currentInput.val(sheathingRowData[currentInput.attr('name')]).prop('title', sheathingRowData[currentInput.attr('name')]);
                    currentInput.attr('data-time', sheathingRowData[currentInput.attr('name') + '_time']);
                    count++;
                }

                form.find('button').prop('disabled', false);

                //To Close searchJopOrderNumber form
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfSheathing').find('.input').eq(1).prop('disabled', 'true');
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfSheathing').find('button').eq(0).prop('disabled', 'true');
                //To make Attantion For form to Know this data for update not create
                form.attr('data-update', true);
                form.attr('data-id-for-update', sheathingActual_id);



                // To Save Data in LocalStorage
                SaveDataOfSheathingLocalStorage(that, inputs, true, sheathingActual_id);


                //To Hide the DropDown-Alert if you use All of alerts 
                for (let i = 0; i < $('.sheathing .dropdownalert').length; i++) {
                    let counter = 0;
                    let counterOfdropdownalert_item = $('.sheathing .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
                    for (let j = 0; j <= counterOfdropdownalert_item; j++) {
                        if ($('.sheathing .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                            counter++;
                        }

                    }

                    // console.log(counterOfdropdownalert_item, counter);
                    if (counter == counterOfdropdownalert_item) {
                        $('.sheathing .dropdownalert').eq(i).addClass('d-none');
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
            // console.log(data.responseJSON.error);
        },

    });

});

// To Clear Sheat From Data That Not Completed
function clearSheathingSheet(sheetItem) {
    let dataOfSheathing = JSON.parse(localStorage.getItem('dataOfSheathing'));
    let inputs = $(`#Sheathing_${sheetItem + 1} .sheathingActual`).find('.input, textarea');
    for (let i = 0; i < inputs.length; i++) {
        let key = $(inputs[i]).attr('name');
        dataOfSheathing[sheetItem][key] = ["", "", (i <= 13) ? true : false, false];
    }
    //To Know if user called data from alerts or not
    dataOfSheathing[sheetItem]['isAlert'] = [false, null];
    localStorage.setItem('dataOfSheathing', JSON.stringify(dataOfSheathing));
    window.location.reload(true);
}

//To Save Data Of Sheathing Sheets in LocalStorage for Refreash
let dataOfSheathing = [];

if (localStorage.getItem('dataOfSheathing') == null) {


    for (let i = 0; i <= 3; i++) {

        let dataOfSheathing_1 = {};
        let inputs_1 = $(`#Sheathing_${i + 1} .sheathingActual`).find('.input');
        let textarea_1 = $(`#Sheathing_${i + 1} .sheathingActual`).find('textarea')[0];
        inputs_1.push(textarea_1);
        // console.log(inputs_1);

        for (let j = 0; j < inputs_1.length; j++) {
            let key = $(inputs_1[j]).attr('name');
            /* 
            dataOfSheathing_1[0] => value of input
            dataOfSheathing_1[1] => data-time of input
            dataOfSheathing_1[2] => required
            dataOfSheathing_1[3] => disabled

            so We Have to make inputs Of Standard is Required
            (j <= 13 || j == 14)
            j <= 13 => For Standard Inputs
            j == 14 => For label
            */
            dataOfSheathing_1[key] = ["", "", (j <= 13 || j == 14) ? true : false, false];
        }
        //To Know if user called data from alerts or not
        dataOfSheathing_1['isAlert'] = [false, null];

        // console.log(dataOfSheathing_1);

        dataOfSheathing.push(dataOfSheathing_1);
    }
    // console.log(dataOfSheathing);
    localStorage.setItem('dataOfSheathing', JSON.stringify(dataOfSheathing));

    deliverDataFromSheathingLocalStorage();

} else {

    deliverDataFromSheathingLocalStorage();
    //To Hide the DropDown-Alert if you use All of alerts 
    for (let i = 0; i < $('.sheathing .dropdownalert').length; i++) {
        let counter = 0;
        let counterOfdropdownalert_item = $('.sheathing .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
        for (let j = 0; j <= counterOfdropdownalert_item; j++) {
            if ($('.sheathing .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                counter++;
            }

        }

        // console.log(counterOfdropdownalert_item, counter);
        if (counter == counterOfdropdownalert_item) {
            $('.sheathing .dropdownalert').eq(i).addClass('d-none');
        }

    }

}

function deliverDataFromSheathingLocalStorage() {
    dataOfSheathing = JSON.parse(localStorage.getItem('dataOfSheathing'));

    for (let i = 0; i <= 3; i++) {

        let inputs = $(`#Sheathing_${i + 1} .sheathingActual`).find('.input');
        let textarea = $(`#Sheathing_${i + 1} .sheathingActual`).find('textarea')[0];
        inputs.push(textarea);



        for (let j = 0; j < inputs.length; j++) {
            let inputFromLocalStorage = dataOfSheathing[i][$(inputs[j]).attr('name')];
            $(inputs[j]).val(inputFromLocalStorage[0]);
            $(inputs[j]).attr('data-time', inputFromLocalStorage[1]);
            $(inputs[j]).prop('required', inputFromLocalStorage[2]);
            $(inputs[j]).prop('disabled', inputFromLocalStorage[3]);
        }

        if (dataOfSheathing[i]['isAlert'][0]) {
            $('.sheathing .popUp').eq(i).find('.dataNotComplete').addClass('d-none');
            $('.sheathing .popUp').eq(i).find('.searchJopOrderNumberOfSheathing input[name="jopOrderNumber"]').prop('disabled', true);
            $('.sheathing .popUp').eq(i).find('.searchJopOrderNumberOfSheathing button').prop('disabled', true);
            /* 
            this Line To
            hide dropdownalert-item if it is called at one of sheet to complete it 
            And add attrebute data-sheet-item to dropdownalert-item after Refresh
            */
            $('.sheathing .popUp').find(`.dataNotComplete .dropdownalert-item[data-id=${dataOfSheathing[i]['isAlert'][1]}]`).addClass('d-none').attr('data-sheet-item', i);
            $('.sheathing .popUp').eq(i).find('.sheathingActual').attr('data-update', dataOfSheathing[i]['isAlert'][0]);
            $('.sheathing .popUp').eq(i).find('.sheathingActual').attr('data-id-for-update', dataOfSheathing[i]['isAlert'][1]);
            $('.sheathing .popUp').eq(i).attr('data-isAlert', true);
            $('.sheathing .popUp').eq(i).attr('update-data-sheet-of-id', dataOfSheathing[i]['isAlert'][1]);
            //To Show Icon Of Clear Sheet
            $('.sheathing .popUp').eq(i).find('.fa-trash-restore').removeClass('d-none');
        }

    }
}

function SaveDataOfSheathingLocalStorage(element, inputs, isAlert = false, itemOfAlert = null) {
    let dataOfSheathing = JSON.parse(localStorage.getItem('dataOfSheathing'));
    let item = $(element).parents('.popUp').attr('data-item');
    for (let j = 0; j < inputs.length; j++) {
        dataOfSheathing[item][$(inputs[j]).attr('name')] = [$(inputs[j]).val(), $(inputs[j]).attr('data-time'), $(inputs[j]).prop('required'), $(inputs[j]).prop('disabled')];
    }
    dataOfSheathing[item]['isAlert'] = [isAlert, itemOfAlert];
    localStorage.setItem('dataOfSheathing', JSON.stringify(dataOfSheathing));
}

