

//To Insert CCVInsulation
$('form.CCVInsulationActual').submit(function (e) {
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
                $('.searchJopOrderNumberOfCCVInsulation').find('.input');
                $('.searchJopOrderNumberOfCCVInsulation').find('button');
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
                    $('.CCVInsulation').find('.input, textarea, button:not(button.text-warning)').prop('disabled', false).removeClass('error');
                    $('.CCVInsulation .searchJopOrderNumberOfCCVInsulation').find('.input').prop('disabled', false);
                    $('.CCVInsulation .searchJopOrderNumberOfCCVInsulation').find('button').prop('disabled', false);
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
            } else if (data == 'Error-thicknessISCStart') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').addClass('error');
                $('.CCVInsulation').get('0').scrollTop += $($(that).find('input[name="thicknessISCStartMin"]')).offset().top - 20;
            } else if (data == 'Error-thicknessINSStart') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').addClass('error');
                $('.CCVInsulation').get('0').scrollTop += $($(that).find('input[name="thicknessINSStartMin"]')).offset().top - 20;
            } else if (data == 'Error-thicknessOSCStart') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').addClass('error');
                $('.CCVInsulation').get('0').scrollTop += $($(that).find('input[name="thicknessOSCStartMin"]')).offset().top - 20;
            } else if (data == 'Error-thicknessISCEnd') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').addClass('error');
                $('.CCVInsulation').get('0').scrollTop += $($(that).find('input[name="thicknessISCEndMin"]')).offset().top - 20;
            } else if (data == 'Error-thicknessINSEnd') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSEndMin"] , input[name="thicknessINSEndNom"], input[name="thicknessINSEndMax"]').addClass('error');
                $('.CCVInsulation').get('0').scrollTop += $($(that).find('input[name="thicknessINSEndMin"]')).offset().top - 20;
            } else if (data == 'Error-thicknessOSCEnd') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSEndMin"] , input[name="thicknessINSEndNom"], input[name="thicknessINSEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCEndMin"] , input[name="thicknessOSCEndNom"], input[name="thicknessOSCEndMax"]').addClass('error');
                $('.CCVInsulation').get('0').scrollTop += $($(that).find('input[name="thicknessOSCEndMin"]')).offset().top - 20;
            } else if (data == 'Error-dimBefore1') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSEndMin"] , input[name="thicknessINSEndNom"], input[name="thicknessINSEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCEndMin"] , input[name="thicknessOSCEndNom"], input[name="thicknessOSCEndMax"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').addClass('error');
                $('.CCVInsulation').get('0').scrollTop += $($(that).find('input[name="dimBefore1"]')).offset().top - 20;
            } else if (data == 'Error-dimAfterStart') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSEndMin"] , input[name="thicknessINSEndNom"], input[name="thicknessINSEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCEndMin"] , input[name="thicknessOSCEndNom"], input[name="thicknessOSCEndMax"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').addClass('error');
                $('.CCVInsulation').get('0').scrollTop += $($(that).find('input[name="dimAfterStartMin"]')).offset().top - 20;
            } else if (data == 'Error-dimAfterEnd') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSEndMin"] , input[name="thicknessINSEndNom"], input[name="thicknessINSEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCEndMin"] , input[name="thicknessOSCEndNom"], input[name="thicknessOSCEndMax"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').addClass('error');
                $('.CCVInsulation').get('0').scrollTop += $($(that).find('input[name="dimAfterEndMin"]')).offset().top - 20;
            } else if (data == 'Error-notes') {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSEndMin"] , input[name="thicknessINSEndNom"], input[name="thicknessINSEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCEndMin"] , input[name="thicknessOSCEndNom"], input[name="thicknessOSCEndMax"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
                $(that).find('textarea[name="notes"]').addClass('error');
                $('.CCVInsulation').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
            } else {
                $(that).find('input[name="thicknessISCStartMin"] , input[name="thicknessISCStartNom"], input[name="thicknessISCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSStartMin"] , input[name="thicknessINSStartNom"], input[name="thicknessINSStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCStartMin"] , input[name="thicknessOSCStartNom"], input[name="thicknessOSCStartMax"]').removeClass('error');
                $(that).find('input[name="thicknessISCEndMin"] , input[name="thicknessISCEndNom"], input[name="thicknessISCEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessINSEndMin"] , input[name="thicknessINSEndNom"], input[name="thicknessINSEndMax"]').removeClass('error');
                $(that).find('input[name="thicknessOSCEndMin"] , input[name="thicknessOSCEndNom"], input[name="thicknessOSCEndMax"]').removeClass('error');
                $(that).find('input[name="dimBefore1"]').removeClass('error');
                $(that).find('input[name="dimAfterStartMin"] , input[name="dimAfterStartNom"], input[name="dimAfterStartMax"]').removeClass('error');
                $(that).find('input[name="dimAfterEndMin"] , input[name="dimAfterEndNom"], input[name="dimAfterEndMax"]').removeClass('error');
                $(that).find('textarea[name="notes"]').removeClass('error');
                $($(that).find('.input')).val('').prop("disabled", false);
                $($(that).find('textarea')).val('').prop("disabled", false);
            }

            // To Save Data in LocalStorage
            let inputs = $(that).find('.input');
            inputs.push($(that).find('textarea'));
            SaveDataOfCCVInsulationLocalStorage(that, inputs);


        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        },

    });

});

//To  Search jopOrderNumber CCVInsulation
$('form.searchJopOrderNumberOfCCVInsulation').submit(function (e) {
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
                SaveDataOfCCVInsulationLocalStorage(that, inputs);

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
                SaveDataOfCCVInsulationLocalStorage(that, inputs);

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
$('.CCVInsulation .dataNotComplete form').click(function (e) {
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
                let rowDataCCVInsulationStandard = data[0];
                let rowDataCCVInsulationActual = data[1];
                let rowDataCCVInsulationActualTime = data[2];
                let rowDataCCVInsulationStandardTime = data[3];

                // To Preper Data Of CCVInsulationStandard
                delete rowDataCCVInsulationStandard['id'];
                delete rowDataCCVInsulationStandard['added_by'];
                delete rowDataCCVInsulationStandard['shift'];
                delete rowDataCCVInsulationStandard['updated_by'];
                delete rowDataCCVInsulationStandard['created_at'];
                delete rowDataCCVInsulationStandard['updated_at'];

                delete rowDataCCVInsulationStandardTime['id'];
                delete rowDataCCVInsulationStandardTime['CCVInsulationstandards_id'];
                delete rowDataCCVInsulationStandardTime['added_by'];
                delete rowDataCCVInsulationStandardTime['shift'];
                delete rowDataCCVInsulationStandardTime['updated_by'];
                delete rowDataCCVInsulationStandardTime['created_at'];
                delete rowDataCCVInsulationStandardTime['updated_at'];

                // To Preper Data Of CCVInsulationActual

                let CCVInsulationActual_id = rowDataCCVInsulationActual['id'];

                delete rowDataCCVInsulationActual['id'];
                delete rowDataCCVInsulationActual['jopOrderNumber_id'];
                delete rowDataCCVInsulationActual['jopOrderNumber'];
                delete rowDataCCVInsulationActual['added_by'];
                delete rowDataCCVInsulationActual['shift'];
                delete rowDataCCVInsulationActual['updated_by'];
                delete rowDataCCVInsulationActual['created_at'];
                delete rowDataCCVInsulationActual['updated_at'];

                delete rowDataCCVInsulationActualTime['id'];
                delete rowDataCCVInsulationActualTime['CCVInsulationactuals_id'];
                delete rowDataCCVInsulationActualTime['added_by'];
                delete rowDataCCVInsulationActualTime['shift'];
                delete rowDataCCVInsulationActualTime['updated_by'];
                delete rowDataCCVInsulationActualTime['created_at'];
                delete rowDataCCVInsulationActualTime['updated_at'];

                // To Preper Data Of CCVInsulation Row

                CCVInsulationRowData = { ...rowDataCCVInsulationStandard, ...rowDataCCVInsulationActual };
                CCVInsulationRowDataTime = { ...rowDataCCVInsulationStandardTime, ...rowDataCCVInsulationActualTime };

                //   console.log(CCVInsulationRowData);
                //   console.log(CCVInsulationRowDataTime);


                let form = $(that).parents('.box').children('.content').children('.CCVInsulationActual');
                let inputs = form.find('.input, textarea');
                // console.log(inputs);
                let count = 0;

                for (let key in CCVInsulationRowData) {
                    let currentInput = $(inputs).filter(`[name="${key}"]`);
                    if (count < 10 || (CCVInsulationRowData[key] != null && key != "notes" && CCVInsulationRowData[key] != '')) {
                        currentInput.prop('disabled', true);
                    } else {
                        // console.log(key);
                        currentInput.prop('disabled', false);
                        if (key != "dimBefore2" &&
                            key != "notes") {
                            currentInput.prop('required', true);
                        }
                    }
                    currentInput.val(CCVInsulationRowData[currentInput.attr('name')]).prop('title', CCVInsulationRowData[currentInput.attr('name')]);
                    currentInput.attr('data-time', CCVInsulationRowDataTime[currentInput.attr('name') + '_time']);
                    count++;
                }

                form.find('button').prop('disabled', false);

                //To Close searchJopOrderNumber form
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfCCVInsulation').find('.input').eq(1).prop('disabled', 'true');
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfCCVInsulation').find('button').eq(0).prop('disabled', 'true');
                //To make Attantion For form to Know this data for update not create
                form.attr('data-update', true);
                form.attr('data-id-for-update', CCVInsulationActual_id);



                // To Save Data in LocalStorage
                SaveDataOfCCVInsulationLocalStorage(that, inputs, true, CCVInsulationActual_id);


                //To Hide the DropDown-Alert if you use All of alerts 
                for (let i = 0; i < $('.CCVInsulation .dropdownalert').length; i++) {
                    let counter = 0;
                    let counterOfdropdownalert_item = $('.CCVInsulation .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
                    for (let j = 0; j <= counterOfdropdownalert_item; j++) {
                        if ($('.CCVInsulation .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                            counter++;
                        }

                    }

                    // console.log(counterOfdropdownalert_item, counter);
                    if (counter == counterOfdropdownalert_item) {
                        $('.CCVInsulation .dropdownalert').eq(i).addClass('d-none');
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
function clearCCVInsulationSheet(sheetItem) {
    let dataOfCCVInsulation = JSON.parse(localStorage.getItem('dataOfCCVInsulation'));
    let inputs = $(`#CCVInsulation_${sheetItem + 1} .CCVInsulationActual`).find('.input, textarea');
    for (let i = 0; i < inputs.length; i++) {
        let key = $(inputs[i]).attr('name');
        dataOfCCVInsulation[sheetItem][key] = ["", "", (i <= 9) ? true : false, false];
    }
    //To Know if user called data from alerts or not
    dataOfCCVInsulation[sheetItem]['isAlert'] = [false, null];
    localStorage.setItem('dataOfCCVInsulation', JSON.stringify(dataOfCCVInsulation));
    window.location.reload(true);
}

//To Save Data Of CCVInsulation Sheets in LocalStorage for Refreash
let dataOfCCVInsulation = [];

if (localStorage.getItem('dataOfCCVInsulation') == null) {


    for (let i = 0; i <= 2; i++) {

        let dataOfCCVInsulation_1 = {};
        let inputs_1 = $(`#CCVInsulation_${i + 1} .CCVInsulationActual`).find('.input');
        let textarea_1 = $(`#CCVInsulation_${i + 1} .CCVInsulationActual`).find('textarea')[0];
        inputs_1.push(textarea_1);
        // console.log(inputs_1);

        for (let j = 0; j < inputs_1.length; j++) {
            let key = $(inputs_1[j]).attr('name');
            /* 
            dataOfCCVInsulation_1[0] => value of input
            dataOfCCVInsulation_1[1] => data-time of input
            dataOfCCVInsulation_1[2] => required
            dataOfCCVInsulation_1[3] => disabled

            so We Have to make inputs Of Standard is Required
            (j <= 9 || j == 10)
            j <= 9 => For Standard Inputs
            j == 10 => For label
            */
            dataOfCCVInsulation_1[key] = ["", "", (j <= 9 || j == 10) ? true : false, false];
        }
        //To Know if user called data from alerts or not
        dataOfCCVInsulation_1['isAlert'] = [false, null];

        // console.log(dataOfCCVInsulation_1);

        dataOfCCVInsulation.push(dataOfCCVInsulation_1);
    }
    // console.log(dataOfCCVInsulation);
    localStorage.setItem('dataOfCCVInsulation', JSON.stringify(dataOfCCVInsulation));

    deliverDataFromCCVInsulationLocalStorage();

} else {

    deliverDataFromCCVInsulationLocalStorage();
    //To Hide the DropDown-Alert if you use All of alerts 
    for (let i = 0; i < $('.CCVInsulation .dropdownalert').length; i++) {
        let counter = 0;
        let counterOfdropdownalert_item = $('.CCVInsulation .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
        for (let j = 0; j <= counterOfdropdownalert_item; j++) {
            if ($('.CCVInsulation .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                counter++;
            }

        }

        // console.log(counterOfdropdownalert_item, counter);
        if (counter == counterOfdropdownalert_item) {
            $('.CCVInsulation .dropdownalert').eq(i).addClass('d-none');
        }

    }

}

function deliverDataFromCCVInsulationLocalStorage() {
    dataOfCCVInsulation = JSON.parse(localStorage.getItem('dataOfCCVInsulation'));

    for (let i = 0; i <= 2; i++) {

        let inputs = $(`#CCVInsulation_${i + 1} .CCVInsulationActual`).find('.input');
        let textarea = $(`#CCVInsulation_${i + 1} .CCVInsulationActual`).find('textarea')[0];
        inputs.push(textarea);



        for (let j = 0; j < inputs.length; j++) {
            let inputFromLocalStorage = dataOfCCVInsulation[i][$(inputs[j]).attr('name')];
            $(inputs[j]).val(inputFromLocalStorage[0]);
            $(inputs[j]).attr('data-time', inputFromLocalStorage[1]);
            $(inputs[j]).prop('required', inputFromLocalStorage[2]);
            $(inputs[j]).prop('disabled', inputFromLocalStorage[3]);
        }

        if (dataOfCCVInsulation[i]['isAlert'][0]) {
            $('.CCVInsulation .popUp').eq(i).find('.dataNotComplete').addClass('d-none');
            $('.CCVInsulation .popUp').eq(i).find('.searchJopOrderNumberOfCCVInsulation input[name="jopOrderNumber"]').prop('disabled', true);
            $('.CCVInsulation .popUp').eq(i).find('.searchJopOrderNumberOfCCVInsulation button').prop('disabled', true);
            /* 
            this Line To
            hide dropdownalert-item if it is called at one of sheet to complete it 
            And add attrebute data-sheet-item to dropdownalert-item after Refresh
            */
            $('.CCVInsulation .popUp').find(`.dataNotComplete .dropdownalert-item[data-id=${dataOfCCVInsulation[i]['isAlert'][1]}]`).addClass('d-none').attr('data-sheet-item', i);
            $('.CCVInsulation .popUp').eq(i).find('.CCVInsulationActual').attr('data-update', dataOfCCVInsulation[i]['isAlert'][0]);
            $('.CCVInsulation .popUp').eq(i).find('.CCVInsulationActual').attr('data-id-for-update', dataOfCCVInsulation[i]['isAlert'][1]);
            $('.CCVInsulation .popUp').eq(i).attr('data-isAlert', true);
            $('.CCVInsulation .popUp').eq(i).attr('update-data-sheet-of-id', dataOfCCVInsulation[i]['isAlert'][1]);
            //To Show Icon Of Clear Sheet
            $('.CCVInsulation .popUp').eq(i).find('.fa-trash-restore').removeClass('d-none');
        }

    }
}

function SaveDataOfCCVInsulationLocalStorage(element, inputs, isAlert = false, itemOfAlert = null) {
    let dataOfCCVInsulation = JSON.parse(localStorage.getItem('dataOfCCVInsulation'));
    let item = $(element).parents('.popUp').attr('data-item');
    for (let j = 0; j < inputs.length; j++) {
        dataOfCCVInsulation[item][$(inputs[j]).attr('name')] = [$(inputs[j]).val(), $(inputs[j]).attr('data-time'), $(inputs[j]).prop('required'), $(inputs[j]).prop('disabled')];
    }
    dataOfCCVInsulation[item]['isAlert'] = [isAlert, itemOfAlert];
    localStorage.setItem('dataOfCCVInsulation', JSON.stringify(dataOfCCVInsulation));
}

