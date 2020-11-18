
//To Insert Lead
$('form.leadActual').submit(function (e) {
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
                $('.searchJopOrderNumberOfLead').find('.input');
                $('.searchJopOrderNumberOfLead').find('button');
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
                    $('.Lead').find('.input, textarea, button:not(button.text-warning)').prop('disabled', false).removeClass('error');
                    $('.Lead .searchJopOrderNumberOflead').find('.input').prop('disabled', false);
                    $('.Lead .searchJopOrderNumberOflead').find('button').prop('disabled', false);
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
                $('.Lead').get('0').scrollTop += $($(that).find('input[name="thicknessStartMinActual"]')).offset().top - 20;
            } else if (data == 'Error-thicknessEndActual') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').addClass('error');
                $('.Lead').get('0').scrollTop += $($(that).find('input[name="thicknessEndMinActual"]')).offset().top - 20;
            } else if (data == 'Error-dimBefore1') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').addClass('error');
                $('.Lead').get('0').scrollTop += $($(that).find('input[name="dimBefore1"]')).offset().top - 20;
            } else if (data == 'Error-notes') {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('textarea[name="notes"]').addClass('error');
                $('.drowing').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
            } else {
                $(that).find('input[name="thicknessStartMinActual"] , input[name="thicknessStartNomActual"], input[name="thicknessStartMaxActual"]').removeClass('error');
                $(that).find('input[name="thicknessEndMinActual"] , input[name="thicknessEndNomActual"], input[name="thicknessEndMaxActual"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('textarea[name="notes"]').removeClass('error');
                $($(that).find('.input')).val('').prop("disabled", false);
                $($(that).find('textarea')).val('').prop("disabled", false);
            }

            // To Save Data in LocalStorage
            let inputs = $(that).find('.input');
            inputs.push($(that).find('textarea'));
            SaveDataOfLeadLocalStorage(that, inputs);


        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        },

    });

});

//To  Search jopOrderNumber Lead
$('form.searchJopOrderNumberOfLead').submit(function (e) {
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

                for (let i = 0; i <= inputs.length; i++) {
                    $(inputs[i]).val(data[$(inputs[i]).attr('name')]).prop("disabled", true);
                    let date = new Date().toLocaleString();
                    $(inputs[i]).attr('data-time', date);
                }

                // To Save Data in LocalStorage
                SaveDataOfLeadLocalStorage(that, inputs);

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
                SaveDataOfLeadLocalStorage(that, inputs);

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
$('.Lead .dataNotComplete form').click(function (e) {
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
    // console.log(dataForm);
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
                let rowDataLeadStandard = data[0];
                let rowDataLeadActual = data[1];
                let rowDataLeadActualTime = data[2];
                let rowDataLeadStandardTime = data[3];

                // To Preper Data Of LeadStandard
                delete rowDataLeadStandard['id'];
                delete rowDataLeadStandard['added_by'];
                delete rowDataLeadStandard['shift'];
                delete rowDataLeadStandard['updated_by'];
                delete rowDataLeadStandard['created_at'];
                delete rowDataLeadStandard['updated_at'];

                delete rowDataLeadStandardTime['id'];
                delete rowDataLeadStandardTime['leadstandards_id'];
                delete rowDataLeadStandardTime['added_by'];
                delete rowDataLeadStandardTime['shift'];
                delete rowDataLeadStandardTime['updated_by'];
                delete rowDataLeadStandardTime['created_at'];
                delete rowDataLeadStandardTime['updated_at'];

                // To Preper Data Of LeadActual

                let leadActual_id = rowDataLeadActual['id'];

                delete rowDataLeadActual['id'];
                delete rowDataLeadActual['jopOrderNumber_id'];
                delete rowDataLeadActual['jopOrderNumber'];
                delete rowDataLeadActual['added_by'];
                delete rowDataLeadActual['shift'];
                delete rowDataLeadActual['updated_by'];
                delete rowDataLeadActual['created_at'];
                delete rowDataLeadActual['updated_at'];

                delete rowDataLeadActualTime['id'];
                delete rowDataLeadActualTime['leadactuals_id'];
                delete rowDataLeadActualTime['added_by'];
                delete rowDataLeadActualTime['shift'];
                delete rowDataLeadActualTime['updated_by'];
                delete rowDataLeadActualTime['created_at'];
                delete rowDataLeadActualTime['updated_at'];

                // To Preper Data Of Lead Row

                leadRowData = { ...rowDataLeadStandard, ...rowDataLeadActual };
                leadRowDataTime = { ...rowDataLeadStandardTime, ...rowDataLeadActualTime };

                //   console.log(leadRowData);
                //   console.log(leadRowDataTime);


                let form = $(that).parents('.box').children('.content').children('.leadActual');
                let inputs = form.find('.input, textarea');
                //  console.log(inputs);

                let count = 0;

                for (let key in leadRowData) {
                    let currentInput = $(inputs).filter(`[name="${key}"]`);
                    if (count < 6 || (leadRowData[key] != null && key != "notes" && leadRowData[key] != '')) {
                        currentInput.prop('disabled', true);
                    } else {
                        // console.log(key);
                        currentInput.prop('disabled', false);
                        if (key != "dimBefore2" &&
                            key != "notes") {
                            currentInput.prop('required', true);
                        }
                    }
                    currentInput.val(leadRowData[currentInput.attr('name')]);
                    currentInput.attr('data-time', leadRowData[currentInput.attr('name') + '_time']);
                    count++;
                }

                form.find('button').prop('disabled', false);

                //To Close searchJopOrderNumber form
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfLead').find('.input').eq(1).prop('disabled', 'true');
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfLead').find('button').eq(0).prop('disabled', 'true');
                //To make Attantion For form to Know this data for update not create
                form.attr('data-update', true);
                form.attr('data-id-for-update', leadActual_id);

                // To Save Data in LocalStorage
                SaveDataOfLeadLocalStorage(that, inputs, true, leadActual_id);

                //To Hide the DropDown-Alert if you use All of alerts 
                for (let i = 0; i < $('.Lead .dropdownalert').length; i++) {
                    let counter = 0;
                    let counterOfdropdownalert_item = $('.Lead .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
                    for (let j = 0; j <= counterOfdropdownalert_item; j++) {
                        if ($('.Lead .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                            counter++;
                        }

                    }

                    // console.log(counterOfdropdownalert_item, counter);
                    if (counter == counterOfdropdownalert_item) {
                        $('.Lead .dropdownalert').eq(i).addClass('d-none');
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
function clearLeadSheet(sheetItem) {
    let dataOfLead = JSON.parse(localStorage.getItem('dataOfLead'));
    let inputs = $(`#Lead_${sheetItem + 1} .leadActual`).find('.input, textarea');
    for (let i = 0; i < inputs.length; i++) {
        let key = $(inputs[i]).attr('name');
        dataOfLead[sheetItem][key] = ["", "", (i <= 8) ? true : false, false];
    }
    //To Know if user called data from alerts or not
    dataOfLead[sheetItem]['isAlert'] = [false, null];
    localStorage.setItem('dataOfLead', JSON.stringify(dataOfLead));
    window.location.reload(true);
}

//To Save Data Of Lead Sheets in LocalStorage for Refreash
let dataOfLead = [];

if (localStorage.getItem('dataOfLead') == null) {


    for (let i = 0; i <= 2; i++) {

        let dataOfLead_1 = {};
        let inputs_1 = $(`#Lead_${i + 1} .leadActual`).find('.input');
        let textarea_1 = $(`#Lead_${i + 1} .leadActual`).find('textarea')[0];
        inputs_1.push(textarea_1);
        // console.log(inputs_1);

        for (let j = 0; j < inputs_1.length; j++) {
            let key = $(inputs_1[j]).attr('name');
            /* 
            dataOfLead_1[0] => value of input
            dataOfLead_1[1] => data-time of input
            dataOfLead_1[2] => required
            dataOfLead_1[3] => disabled

            so We Have to make inputs Of Standard is Required
            (j <= 8 || j == 9)
            j <= 8 => For Standard Inputs
            j == 9 => For label
            */
            dataOfLead_1[key] = ["", "", (j <= 8 || j == 9) ? true : false, false];
        }
        //To Know if user called data from alerts or not
        dataOfLead_1['isAlert'] = [false, null];

        // console.log(dataOfLead_1);

        dataOfLead.push(dataOfLead_1);
    }
    // console.log(dataOfLead);
    localStorage.setItem('dataOfLead', JSON.stringify(dataOfLead));

    deliverDataFromLeadLocalStorage();

} else {

    deliverDataFromLeadLocalStorage();
    //To Hide the DropDown-Alert if you use All of alerts 
    for (let i = 0; i < $('.Lead .dropdownalert').length; i++) {
        let counter = 0;
        let counterOfdropdownalert_item = $('.Lead .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
        for (let j = 0; j <= counterOfdropdownalert_item; j++) {
            if ($('.Lead .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                counter++;
            }

        }

        // console.log(counterOfdropdownalert_item, counter);
        if (counter == counterOfdropdownalert_item) {
            $('.Lead .dropdownalert').eq(i).addClass('d-none');
        }

    }

}

function deliverDataFromLeadLocalStorage() {
    dataOfLead = JSON.parse(localStorage.getItem('dataOfLead'));

    for (let i = 0; i <= 2; i++) {

        let inputs = $(`#Lead_${i + 1} .leadActual`).find('.input');
        let textarea = $(`#Lead_${i + 1} .leadActual`).find('textarea')[0];
        inputs.push(textarea);


        for (let j = 0; j < inputs.length; j++) {
            let inputFromLocalStorage = dataOfLead[i][$(inputs[j]).attr('name')];
            $(inputs[j]).val(inputFromLocalStorage[0]);
            $(inputs[j]).attr('data-time', inputFromLocalStorage[1]);
            $(inputs[j]).prop('required', inputFromLocalStorage[2]);
            $(inputs[j]).prop('disabled', inputFromLocalStorage[3]);
        }

        if (dataOfLead[i]['isAlert'][0]) {
            $('.Lead .popUp').eq(i).find('.dataNotComplete').addClass('d-none');
            $('.Lead .popUp').eq(i).find('.searchJopOrderNumberOfLead input[name="jopOrderNumber"]').prop('disabled', true);
            $('.Lead .popUp').eq(i).find('.searchJopOrderNumberOfLead button').prop('disabled', true);
            /* 
            this Line To
            hide dropdownalert-item if it is called at one of sheet to complete it 
            And add attrebute data-sheet-item to dropdownalert-item after Refresh
            */
            $('.Lead .popUp').find(`.dataNotComplete .dropdownalert-item[data-id=${dataOfLead[i]['isAlert'][1]}]`).addClass('d-none').attr('data-sheet-item', i);
            $('.Lead .popUp').eq(i).find('.leadActual').attr('data-update', dataOfLead[i]['isAlert'][0]);
            $('.Lead .popUp').eq(i).find('.leadActual').attr('data-id-for-update', dataOfLead[i]['isAlert'][1]);
            $('.Lead .popUp').eq(i).attr('data-isAlert', true);
            $('.Lead .popUp').eq(i).attr('update-data-sheet-of-id', dataOflead[i]['isAlert'][1]);
            //To Show Icon Of Clear Sheet
            $('.Lead .popUp').eq(i).find('.fa-trash-restore').removeClass('d-none');
        }

    }
}

function SaveDataOfLeadLocalStorage(element, inputs, isAlert = false, itemOfAlert = null) {
    let dataOfLead = JSON.parse(localStorage.getItem('dataOfLead'));
    let item = $(element).parents('.popUp').attr('data-item');
    for (let j = 0; j < inputs.length; j++) {
        dataOfLead[item][$(inputs[j]).attr('name')] = [$(inputs[j]).val(), $(inputs[j]).attr('data-time'), $(inputs[j]).prop('required'), $(inputs[j]).prop('disabled')];
    }
    dataOfLead[item]['isAlert'] = [isAlert, itemOfAlert];
    localStorage.setItem('dataOfLead', JSON.stringify(dataOfLead));
}

