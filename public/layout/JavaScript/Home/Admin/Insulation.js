

//To Insert Insulation
$('form.insulationActual').submit(function (e) {
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
                $('.searchJopOrderNumberOfInsulation').find('.input');
                $('.searchJopOrderNumberOfInsulation').find('button');
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
                    $('.insulation').find('.input, textarea, button:not(button.text-warning)').prop('disabled', false).removeClass('error');
                    $('.insulation .searchJopOrderNumberOfInsulation').find('.input').prop('disabled', false);
                    $('.insulation .searchJopOrderNumberOfInsulation').find('button').prop('disabled', false);
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
                $('.insulation').get('0').scrollTop += $($(that).find('input[name="thicknessStartMinActual"]')).offset().top - 20;
            } else if (data == 'Error-thicknessEndActual') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').addClass('error');
                $('.insulation').get('0').scrollTop += $($(that).find('input[name="thicknessEndMinActual"]')).offset().top - 20;
            } else if (data == 'Error-dimBefore1') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').addClass('error');
                $('.insulation').get('0').scrollTop += $($(that).find('input[name="dimBefore1"]')).offset().top - 20;
            } else if (data == 'Error-dimAfterStart') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').addClass('error');
                $('.insulation').get('0').scrollTop += $($(that).find('input[name="dimAfterStartMin"]')).offset().top - 20;
            } else if (data == 'Error-dimAfterEnd') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').addClass('error');
                $('.insulation').get('0').scrollTop += $($(that).find('input[name="dimAfterEndMin"]')).offset().top - 20;
            } else if (data == 'Error-ovalityActual1') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
                $(that).find('input[name="ovalityActual1"] , input[name="ovalityActual1"], input[name="ovalityActual1"]').addClass('error');
                $('.insulation').get('0').scrollTop += $($(that).find('input[name="ovalityActual1"]')).offset().top - 20;
            } else if (data == 'Error-notes') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
                $(that).find('input[name="ovalityActual1"] , input[name="ovalityActual1"], input[name="ovalityActual1"]').removeClass('error');
                $(that).find('textarea[name="notes"]').addClass('error');
                $('.insulation').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
            } else {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
                $(that).find('input[name="ovalityActual1"] , input[name="ovalityActual1"], input[name="ovalityActual1"]').removeClass('error');
                $(that).find('textarea[name="notes"]').removeClass('error');
                $($(that).find('.input')).val('').prop("disabled", false);
                $($(that).find('textarea')).val('').prop("disabled", false);
            }

            // To Save Data in LocalStorage
            let inputs = $(that).find('.input');
            inputs.push($(that).find('textarea'));
            SaveDataOfInsulationLocalStorage(that, inputs);

        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        },

    });

});

//To  Search jopOrderNumber Insulation
$('form.searchJopOrderNumberOfInsulation').submit(function (e) {
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
                SaveDataOfInsulationLocalStorage(that, inputs);

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
                SaveDataOfInsulationLocalStorage(that, inputs);

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
$('.insulation .dataNotComplete form').click(function (e) {
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
                let rowDataInsulationStandard = data[0];
                let rowDataInsulationActual = data[1];
                let rowDataInsulationActualTime = data[2];
                let rowDataInsulationStandardTime = data[3];

                // To Preper Data Of InsulationStandard
                delete rowDataInsulationStandard['id'];
                delete rowDataInsulationStandard['added_by'];
                delete rowDataInsulationStandard['shift'];
                delete rowDataInsulationStandard['updated_by'];
                delete rowDataInsulationStandard['created_at'];
                delete rowDataInsulationStandard['updated_at'];

                delete rowDataInsulationStandardTime['id'];
                delete rowDataInsulationStandardTime['insulationstandards_id'];
                delete rowDataInsulationStandardTime['added_by'];
                delete rowDataInsulationStandardTime['shift'];
                delete rowDataInsulationStandardTime['updated_by'];
                delete rowDataInsulationStandardTime['created_at'];
                delete rowDataInsulationStandardTime['updated_at'];

                // To Preper Data Of InsulationActual

                let insulationActual_id = rowDataInsulationActual['id'];

                delete rowDataInsulationActual['id'];
                delete rowDataInsulationActual['jopOrderNumber_id'];
                delete rowDataInsulationActual['jopOrderNumber'];
                delete rowDataInsulationActual['added_by'];
                delete rowDataInsulationActual['shift'];
                delete rowDataInsulationActual['updated_by'];
                delete rowDataInsulationActual['created_at'];
                delete rowDataInsulationActual['updated_at'];

                delete rowDataInsulationActualTime['id'];
                delete rowDataInsulationActualTime['insulationactuals_id'];
                delete rowDataInsulationActualTime['added_by'];
                delete rowDataInsulationActualTime['shift'];
                delete rowDataInsulationActualTime['updated_by'];
                delete rowDataInsulationActualTime['created_at'];
                delete rowDataInsulationActualTime['updated_at'];

                // To Preper Data Of Insulation Row

                insulationRowData = { ...rowDataInsulationStandard, ...rowDataInsulationActual };
                insulationRowDataTime = { ...rowDataInsulationStandardTime, ...rowDataInsulationActualTime };

                // console.log(insulationRowData);
                // console.log(insulationRowDataTime);


                let form = $(that).parents('.box').children('.content').children('.insulationActual');
                let inputs = form.find('.input, textarea');
                // console.log(inputs);

                let count = 0;

                for (let key in insulationRowData) {
                    let currentInput = $(inputs).filter(`[name="${key}"]`);
                    if (count < 15 || (insulationRowData[key] != null && key != "notes" && insulationRowData[key] != '')) {
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
                    currentInput.val(insulationRowData[currentInput.attr('name')]).prop('title', insulationRowData[currentInput.attr('name')]);
                    currentInput.attr('data-time', insulationRowDataTime[currentInput.attr('name') + '_time']);
                    count++;
                }

                form.find('button').prop('disabled', false);

                //To Close searchJopOrderNumber form
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfInsulation').find('.input').eq(1).prop('disabled', 'true');
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfInsulation').find('button').eq(0).prop('disabled', 'true');
                //To make Attantion For form to Know this data for update not create
                form.attr('data-update', true);
                form.attr('data-id-for-update', insulationActual_id);

                // To Save Data in LocalStorage
                SaveDataOfInsulationLocalStorage(that, inputs, true, insulationActual_id);

                //To Hide the DropDown-Alert if you use All of alerts 
                for (let i = 0; i < $('.insulation .dropdownalert').length; i++) {
                    let counter = 0;
                    let counterOfdropdownalert_item = $('.insulation .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
                    for (let j = 0; j <= counterOfdropdownalert_item; j++) {
                        if ($('.insulation .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                            counter++;
                        }

                    }

                    // console.log(counterOfdropdownalert_item, counter);
                    if (counter == counterOfdropdownalert_item) {
                        $('.insulation .dropdownalert').eq(i).addClass('d-none');
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
function clearInsulationSheet(sheetItem) {
    let dataOfInsulation = JSON.parse(localStorage.getItem('dataOfInsulation'));
    let inputs = $(`#Insulation_${sheetItem + 1} .insulationActual`).find('.input, textarea');
    for (let i = 0; i < inputs.length; i++) {
        let key = $(inputs[i]).attr('name');
        dataOfInsulation[sheetItem][key] = ["", "", (i <= 13) ? true : false, false];
    }
    //To Know if user called data from alerts or not
    dataOfInsulation[sheetItem]['isAlert'] = [false, null];
    localStorage.setItem('dataOfInsulation', JSON.stringify(dataOfInsulation));
    window.location.reload(true);
}

//To Save Data Of Insulation Sheets in LocalStorage for Refreash
let dataOfInsulation = [];

if (localStorage.getItem('dataOfInsulation') == null) {


    for (let i = 0; i <= 3; i++) {

        let dataOfInsulation_1 = {};
        let inputs_1 = $(`#Insulation_${i + 1} .insulationActual`).find('.input');
        let textarea_1 = $(`#Insulation_${i + 1} .insulationActual`).find('textarea')[0];
        inputs_1.push(textarea_1);
        // console.log(inputs_1);

        for (let j = 0; j < inputs_1.length; j++) {
            let key = $(inputs_1[j]).attr('name');
            /* 
            dataOfInsulation_1[0] => value of input
            dataOfInsulation_1[1] => data-time of input
            dataOfInsulation_1[2] => required
            dataOfInsulation_1[3] => disabled

            so We Have to make inputs Of Standard is Required
            (j <= 13 || j == 14)
            j <= 13 => For Standard Inputs
            j == 14 => For label
            */
            dataOfInsulation_1[key] = ["", "", (j <= 13 || j == 14) ? true : false, false];
        }
        //To Know if user called data from alerts or not
        dataOfInsulation_1['isAlert'] = [false, null];

        // console.log(dataOfInsulation_1);

        dataOfInsulation.push(dataOfInsulation_1);
    }
    // console.log(dataOfInsulation);
    localStorage.setItem('dataOfInsulation', JSON.stringify(dataOfInsulation));

    deliverDataFromInsulationLocalStorage();

} else {

    deliverDataFromInsulationLocalStorage();
    //To Hide the DropDown-Alert if you use All of alerts 
    for (let i = 0; i < $('.insulation .dropdownalert').length; i++) {
        let counter = 0;
        let counterOfdropdownalert_item = $('.insulation .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
        for (let j = 0; j <= counterOfdropdownalert_item; j++) {
            if ($('.insulation .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                counter++;
            }

        }

        // console.log(counterOfdropdownalert_item, counter);
        if (counter == counterOfdropdownalert_item) {
            $('.insulation .dropdownalert').eq(i).addClass('d-none');
        }

    }

}

function deliverDataFromInsulationLocalStorage() {
    dataOfInsulation = JSON.parse(localStorage.getItem('dataOfInsulation'));

    for (let i = 0; i <= 3; i++) {

        let inputs = $(`#Insulation_${i + 1} .insulationActual`).find('.input');
        let textarea = $(`#Insulation_${i + 1} .insulationActual`).find('textarea')[0];
        inputs.push(textarea);



        for (let j = 0; j < inputs.length; j++) {
            let inputFromLocalStorage = dataOfInsulation[i][$(inputs[j]).attr('name')];
            $(inputs[j]).val(inputFromLocalStorage[0]);
            $(inputs[j]).attr('data-time', inputFromLocalStorage[1]);
            $(inputs[j]).prop('required', inputFromLocalStorage[2]);
            $(inputs[j]).prop('disabled', inputFromLocalStorage[3]);
        }

        if (dataOfInsulation[i]['isAlert'][0]) {
            $('.insulation .popUp').eq(i).find('.dataNotComplete').addClass('d-none');
            $('.insulation .popUp').eq(i).find('.searchJopOrderNumberOfInsulation input[name="jopOrderNumber"]').prop('disabled', true);
            $('.insulation .popUp').eq(i).find('.searchJopOrderNumberOfInsulation button').prop('disabled', true);
            /* 
            this Line To
            hide dropdownalert-item if it is called at one of sheet to complete it 
            And add attrebute data-sheet-item to dropdownalert-item after Refresh
            */
            $('.insulation .popUp').find(`.dataNotComplete .dropdownalert-item[data-id=${dataOfInsulation[i]['isAlert'][1]}]`).addClass('d-none').attr('data-sheet-item', i);
            $('.insulation .popUp').eq(i).find('.insulationActual').attr('data-update', dataOfInsulation[i]['isAlert'][0]);
            $('.insulation .popUp').eq(i).find('.insulationActual').attr('data-id-for-update', dataOfInsulation[i]['isAlert'][1]);
            $('.insulation .popUp').eq(i).attr('data-isAlert', true);
            $('.insulation .popUp').eq(i).attr('update-data-sheet-of-id', dataOfInsulation[i]['isAlert'][1]);
            //To Show Icon Of Clear Sheet
            $('.insulation .popUp').eq(i).find('.fa-trash-restore').removeClass('d-none');
        }

    }
}

function SaveDataOfInsulationLocalStorage(element, inputs, isAlert = false, itemOfAlert = null) {
    let dataOfInsulation = JSON.parse(localStorage.getItem('dataOfInsulation'));
    let item = $(element).parents('.popUp').attr('data-item');
    for (let j = 0; j < inputs.length; j++) {
        dataOfInsulation[item][$(inputs[j]).attr('name')] = [$(inputs[j]).val(), $(inputs[j]).attr('data-time'), $(inputs[j]).prop('required'), $(inputs[j]).prop('disabled')];
    }
    dataOfInsulation[item]['isAlert'] = [isAlert, itemOfAlert];
    localStorage.setItem('dataOfInsulation', JSON.stringify(dataOfInsulation));
}

