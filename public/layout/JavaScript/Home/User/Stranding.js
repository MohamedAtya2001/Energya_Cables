

//To Insert Stranding
$('form.strandingActual').submit(function (e) {
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
                $('.searchJopOrderNumberOfStranding').find('.input');
                $('.searchJopOrderNumberOfStranding').find('button');
                $($(that).find('.input:not(.input[name="shape"])')).prop('required', false);
                $($(that).find('textarea')).prop("required", false);
                $($(that).find('.input')).val('');
                $($(that).find('textarea')).val('');
                $(that).removeAttr('data-id-for-update');
                $(that).attr('data-update', false);
                $(`.dropdownalert-menu .dropdownalert-item[data-sheet-item="${$(that).parents('.popUp').attr('data-item')}"]`).attr('updated', true);
                //To Open Every Sheet If All of Alert is Done
                if ($(that).parents('.popUp').find(`.dropdownalert-menu .dropdownalert-item:not(.dropdownalert-menu .dropdownalert-item[updated="true"])`).length == 0) {
                    $('.stranding').find('.input, textarea, button:not(button.text-warning)').prop('disabled', false).removeClass('error');
                    $('.stranding .searchJopOrderNumberOfDrowing').find('.input').prop('disabled', false);
                    $('.stranding .searchJopOrderNumberOfDrowing').find('button').prop('disabled', false);
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
                //To say Updating Of Sheet Is Done
                $(that).parents('.popUp').attr('isUpdating', false);
            } else if (data == "Error-angel") {
                $(that).find('input[name="angel"]').addClass('error');
                $('.stranding').get('0').scrollTop += $($(that).find('input[name="angel"]')).offset().top - 20;
            } else if (data == "Error-inputCard1") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').addClass('error');
                $('.stranding').get('0').scrollTop += $($(that).find('input[name="inputCard1"]')).offset().top - 20;
            } else if (data == "Error-cage1") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').addClass('error');
                $('.stranding').get('0').scrollTop += $($(that).find('input[name="cage1"]')).offset().top - 20;
            } else if (data == "Error-conductorDimActual_HS1") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').addClass('error');
                $('.stranding').get('0').scrollTop += $($(that).find('input[name="conductorDimActual_HS1"]')).offset().top - 20;
            } else if (data == "Error-conductorDimActual_HS2") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').addClass('error');
                $('.stranding').get('0').scrollTop += $($(that).find('input[name="conductorDimActual_HS2"]')).offset().top - 20;
            } else if (data == "Error-conductorDimActual_HS3") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').addClass('error');
                $('.stranding').get('0').scrollTop += $($(that).find('input[name="conductorDimActual_HS3"]')).offset().top - 20;
            } else if (data == "Error-conductorDimActual_HS4") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').addClass('error');
                $('.stranding').get('0').scrollTop += $($(that).find('input[name="conductorDimActual_HS4"]')).offset().top - 20;
            } else if (data == "Error-conductorDimActual_FI1") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').addClass('error');
                $('.stranding').get('0').scrollTop += $($(that).find('input[name="conductorDimActual_FI1"]')).offset().top - 20;
            } else if (data == "Error-resistanceAtLength1") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').removeClass('error');
                $(that).find('input[name="resistance1"], input[name="length1"]').addClass('error');
                $('.stranding').get('0').scrollTop += $($(that).find('input[name="resistance1"], input[name="length1"]')).offset().top - 20;
            } else if (data == "Error-resistanceAtLength2") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').removeClass('error');
                $(that).find('input[name="resistance1"], input[name="length1"]').removeClass('error');
                $(that).find('input[name="resistance2"], input[name="length2"]').addClass('error');
                $('.stranding').get('0').scrollTop += $($(that).find('input[name="resistance1"], input[name="length1"]')).offset().top - 20;
            } else if (data == "Error-resistanceAtLength3") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').removeClass('error');
                $(that).find('input[name="resistance1"], input[name="length1"]').removeClass('error');
                $(that).find('input[name="resistance2"], input[name="length2"]').removeClass('error');
                $(that).find('input[name="resistance3"], input[name="length3"]').addClass('error');
                $('.stranding').get('0').scrollTop += $($(that).find('input[name="resistance1"], input[name="length1"]')).offset().top - 20;
            } else if (data == "Error-resistanceAtLength4") {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').removeClass('error');
                $(that).find('input[name="resistance1"], input[name="length1"]').removeClass('error');
                $(that).find('input[name="resistance2"], input[name="length2"]').removeClass('error');
                $(that).find('input[name="resistance3"], input[name="length3"]').removeClass('error');
                $(that).find('input[name="resistance4"], input[name="length4"]').addClass('error');
                $('.stranding').get('0').scrollTop += $($(that).find('input[name="resistance1"], input[name="length1"]')).offset().top - 20;
            } else if (data == 'Error-notes') {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').removeClass('error');
                $(that).find('input[name="resistance1"], input[name="length1"]').removeClass('error');
                $(that).find('input[name="resistance2"], input[name="length2"]').removeClass('error');
                $(that).find('input[name="resistance3"], input[name="length3"]').removeClass('error');
                $(that).find('input[name="resistance4"], input[name="length4"]').removeClass('error');
                $(that).find('textarea[name="notes"]').addClass('error');
                $('.drowing').get('0').scrollTop += $($(that).find('textarea[name="notes"]')).offset().top - 20;
            } else {
                $(that).find('input[name="angel"]').removeClass('error');
                $(that).find('input[name="inputCard1"]').removeClass('error');
                $(that).find('input[name="cage1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS1"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS2"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS3"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_HS4"]').removeClass('error');
                $(that).find('input[name="conductorDimActual_FI1"]').removeClass('error');
                $(that).find('input[name="resistance1"], input[name="length1"]').removeClass('error');
                $(that).find('input[name="resistance2"], input[name="length2"]').removeClass('error');
                $(that).find('input[name="resistance3"], input[name="length3"]').removeClass('error');
                $(that).find('input[name="resistance4"], input[name="length4"]').removeClass('error');
                $(that).find('textarea[name="notes"]').removeClass('error');
                $($(that).find('.input')).val('').prop("disabled", false);
                $($(that).find('textarea')).val('').prop("disabled", false);
            }
            // console.log(data);
            // To Save Data in LocalStorage
            let inputs = $(that).find('.input, textarea');
            SaveDataOfStrandingLocalStorage(that, inputs);

        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.message);
        },


    });


});

//To  Search jopOrderNumber Stranding
$('form.searchJopOrderNumberOfStranding').submit(function (e) {
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
            if (data == "Logout") {
                window.location.reload(true);
            } else if (typeof data === 'object') {
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
                let inputs = $(that).siblings('form').find('.standard .input');
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
                SaveDataOfStrandingLocalStorage(that, inputs);


            } else {
                let inputs = $(that).siblings('form').find('.standard .input');
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
                SaveDataOfStrandingLocalStorage(that, inputs);
            }

            $(that).find('input[name="jopOrderNumber"]').eq(0).val('');

        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.message);

        }
    });

});

//To Get Date For User To Complete It
$('.stranding .dataNotComplete form').click(function (e) {
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    e.preventDefault();
    $(this).addClass('updated');
    $(`.dropdownalert-item[data-id="${$(this).attr('data-id')}"]`).fadeOut(300).attr('data-sheet-item', $(this).parents('.popUp').attr('data-item'));
    $(this).parents('.dropdownalert').fadeOut(300);
    //To say Updating Of Sheet Is Happening
    $(this).parents('.popUp').attr('isUpdating', true);
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
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');

            if (data == "Logout") {
                window.location.reload(true);
            } else if (typeof data === 'object') {

                let rowDataStrandingStandard = data[0];
                let rowDataStrandingActual = data[1];
                let rowDataStrandingActualTime = data[2];
                let rowDataStrandingStandardTime = data[3];
                // console.log(data);

                // To Preper Data Of StrandingStandard
                delete rowDataStrandingStandard['id'];
                delete rowDataStrandingStandard['added_by'];
                delete rowDataStrandingStandard['shift'];
                delete rowDataStrandingStandard['updated_by'];
                delete rowDataStrandingStandard['created_at'];
                delete rowDataStrandingStandard['updated_at'];

                // To Preper Data Of StrindingStandardTime
                delete rowDataStrandingStandardTime['id'];
                delete rowDataStrandingStandardTime['strandingstandards_id'];
                delete rowDataStrandingStandardTime['added_by'];
                delete rowDataStrandingStandardTime['shift'];
                delete rowDataStrandingStandardTime['updated_by'];
                delete rowDataStrandingStandardTime['created_at'];
                delete rowDataStrandingStandardTime['updated_at'];

                // To Preper Data Of StrindingActual
                let strandingActual_id = rowDataStrandingActual['id'];

                delete rowDataStrandingActual['id'];
                delete rowDataStrandingActual['jopOrderNumber_id'];
                delete rowDataStrandingActual['jopOrderNumber'];
                delete rowDataStrandingActual['added_by'];
                delete rowDataStrandingActual['shift'];
                delete rowDataStrandingActual['updated_by'];
                delete rowDataStrandingActual['created_at'];
                delete rowDataStrandingActual['updated_at'];

                // To Preper Data Of StrindingActualTime
                delete rowDataStrandingActualTime['id'];
                delete rowDataStrandingActualTime['strandingactuals_id'];
                delete rowDataStrandingActualTime['added_by'];
                delete rowDataStrandingActualTime['shift'];
                delete rowDataStrandingActualTime['updated_by'];
                delete rowDataStrandingActualTime['created_at'];
                delete rowDataStrandingActualTime['updated_at'];

                strandingRowData = { ...rowDataStrandingStandard, ...rowDataStrandingActual };
                strandingRowDataTime = { ...rowDataStrandingStandardTime, ...rowDataStrandingActualTime };

                // console.log(strandingRowData);
                // console.log(strandingRowDataTime);

                let form = $(that).parents('.box').children('.content').children('.strandingActual');
                let inputs = form.find('.input, textarea');
                // console.log(inputs);
                let count = 0;

                for (let key in strandingRowData) {
                    let currentInput = $(inputs).filter(`[name="${key}"]`);
                    if (count < 13 || (strandingRowData[key] != null && key != "notes" && strandingRowData[key] != '')) {
                        currentInput.prop('disabled', true);
                    } else {
                        // console.log(key);
                        currentInput.prop('disabled', false);
                        if (key != 'angel' &&
                            key != 'shape' &&
                            key != 'inputCard2' &&
                            key != 'inputCard3' &&
                            key != 'inputCard4' &&
                            key != 'cage2' &&
                            key != 'cage3' &&
                            key != 'cage4' &&
                            key != 'conductorDimActual_HS2' &&
                            key != 'conductorDimActual_HS3' &&
                            key != 'conductorDimActual_HS4' &&
                            key != 'conductorDimActual_FI2' &&
                            key != 'conductorDimActual_FI3' &&
                            key != 'conductorDimActual_FI4' &&
                            key != "resistance2" &&
                            key != "length2" &&
                            key != "resistance3" &&
                            key != "length3" &&
                            key != "resistance4" &&
                            key != "length4" &&
                            key != "notes") {
                            currentInput.prop('required', true);
                        }
                        if (key == 'angel' || key == 'shape') {
                            currentInput.prop('disabled', true);
                        }
                    }
                    currentInput.val(strandingRowData[currentInput.attr('name')]).prop('title', strandingRowData[currentInput.attr('name')]);
                    currentInput.attr('data-time', strandingRowDataTime[currentInput.attr('name') + '_time']);
                    count++;
                }

                if ((strandingRowData['conductorDimActual_HS1'] == null || strandingRowData['conductorDimActual_HS1'] == '') &&
                    (strandingRowData['conductorDimActual_FI1'] != null && strandingRowData['conductorDimActual_FI1'] != '')) {
                    $(inputs).filter('input[name="conductorDimActual_FI1"]').prop('required', true);
                    $(inputs).filter('input[name="conductorDimActual_HS1"]').prop('disabled', true).prop('required', false);
                    $(inputs).filter('input[name="conductorDimActual_HS2"]').prop('disabled', true);
                    $(inputs).filter('input[name="conductorDimActual_HS3"]').prop('disabled', true);
                    $(inputs).filter('input[name="conductorDimActual_HS4"]').prop('disabled', true);
                } else if ((strandingRowData['conductorDimActual_HS1'] != null && strandingRowData['conductorDimActual_HS1'] != '') &&
                    (strandingRowData['conductorDimActual_FI1'] == null || strandingRowData['conductorDimActual_FI1'] == '')) {
                    $(inputs).filter('input[name="conductorDimActual_FI1"]').prop('disabled', true).prop('required', false);
                    $(inputs).filter('input[name="conductorDimActual_FI2"]').prop('disabled', true);
                    $(inputs).filter('input[name="conductorDimActual_FI3"]').prop('disabled', true);
                    $(inputs).filter('input[name="conductorDimActual_FI4"]').prop('disabled', true);
                    $(inputs).filter('input[name="conductorDimActual_HS1"]').prop('required', true);
                } else {
                    $(inputs).filter('input[name="conductorDimActual_FI1"]').prop('required', true);
                    $(inputs).filter('input[name="conductorDimActual_HS1"]').prop('required', true);
                }

                form.find('button').prop('disabled', false);

                // To Save Data in LocalStorage
                SaveDataOfStrandingLocalStorage(that, inputs, true, strandingActual_id);

                //To Hide the DropDown-Alert if you use All of alerts 
                for (let i = 0; i < $('.stranding .dropdownalert').length; i++) {
                    let counter = 0;
                    let counterOfdropdownalert_item = $('.stranding .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
                    for (let j = 0; j <= counterOfdropdownalert_item; j++) {
                        if ($('.stranding .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                            counter++;
                        }

                    }

                    // console.log(counterOfdropdownalert_item, counter);
                    if (counter == counterOfdropdownalert_item) {
                        $('.stranding .dropdownalert').eq(i).addClass('d-none');
                    }

                }



                //To Close searchJopOrderNumber form
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfStranding').find('.input').eq(1).prop('disabled', 'true');
                $(that).parents('.box').children('.content').children('.searchJopOrderNumberOfStranding').find('button').eq(0).prop('disabled', 'true');
                //To make Attantion For form to Know this data for update not create
                form.attr('data-update', true);
                form.attr('data-id-for-update', strandingActual_id);

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
$('.stranding .input, .stranding textarea').blur(function () {
    let date = new Date().toLocaleString();
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    dataForm['data_form_item'] = $(this).parents('form').attr('data-form-item');
    dataForm['input'] = { 'name': $(this).attr('name'), 'value': $(this).val(), 'time': date };

    // console.log(dataForm);

    $.ajax({
        url: 'stranding/checkRow',
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

/*
 To Make conductorDimActual_HS1 disabled And conductorDimActual_FI1 abled if conductorDimActual_FI1 is Not Empty And conductorDimActual_HS1 is Empty
 Or
 To Make conductorDimActual_FI1 disabled And conductorDimActual_HS1 abled if conductorDimActual_HS1 is Not Empty And conductorDimActual_FI1 is Empty
*/
function conductorDimActual(element) {
    let idOfAlert = ($(element).parents('.popUp').attr('update-data-sheet-of-id') == undefined) ? null : $(element).parents('.popUp').attr('update-data-sheet-of-id');
    let isAlert = ($(element).parents('.popUp').attr('isUpdating') == 'true') ? true : false;

    if (isAlert) {
        if ($(element).parents('.actual').find('input[name="conductorDimActual_HS1"]').val() != '' &&
            $(element).parents('.actual').find('input[name="conductorDimActual_FI1"]').val() == '') {
            $(element).parents('.actual').find('input[name="conductorDimActual_HS1"]').prop('required', true);
            $(element).parents('.actual').find('input[name="conductorDimActual_FI1"]').prop('required', false);
        } else if ($(element).parents('.actual').find('input[name="conductorDimActual_HS1"]').val() == '' &&
            $(element).parents('.actual').find('input[name="conductorDimActual_FI1"]').val() != '') {
            $(element).parents('.actual').find('input[name="conductorDimActual_HS1"]').prop('required', false);
            $(element).parents('.actual').find('input[name="conductorDimActual_FI1"]').prop('required', true);
        } else {
            $(element).parents('.actual').find('input[name="conductorDimActual_HS1"]').prop('required', true);
            $(element).parents('.actual').find('input[name="conductorDimActual_FI1"]').prop('required', true);
        }

        let inputs = [
            $(element).prop('required', true),
            $(element).parents('.actual').find('input[name="conductorDimActual_FI1"]').prop('required', false)
        ];
        // To Save Data in LocalStorage
        SaveDataOfStrandingLocalStorage(element, inputs, isAlert, idOfAlert);
    }
}

// To Open angel_input if shape is Sector And Close it If Shape is Circular
function shapeIsChanged(element) {
    let inputs = [];
    inputs.push($(element), $(element).siblings('input'));

    if (element.value == "Sector") {
        $(element).parent().children('.angel').prop('disabled', false).prop('required', true);
    } else if (element.value == "Circular") {
        $(element).parent().children('.angel').val('').prop('disabled', true).prop('required', false);
    }

    // To Save Data in LocalStorage
    SaveDataOfStrandingLocalStorage($(element), inputs);
}

// To Clear Sheat From Data That Not Completed
function clearStrandingSheet(sheetItem) {
    let dataOfStranding = JSON.parse(localStorage.getItem('dataOfStranding'));
    let inputs = $(`#Stranding_${sheetItem + 1} .strandingActual`).find('.input, textarea');
    for (let i = 0; i < inputs.length; i++) {
        let key = $(inputs[i]).attr('name');
        dataOfStranding[sheetItem][key] = ["", "", (i <= 12 || i == 15) ? true : false, false];
    }
    //To Know if user called data from alerts or not
    dataOfStranding[sheetItem]['isAlert'] = [false, null];
    localStorage.setItem('dataOfStranding', JSON.stringify(dataOfStranding));
    window.location.reload(true);
}

//To Save Data Of Stranding Sheets in LocalStorage for Refreash
let dataOfStranding = [];

if (localStorage.getItem('dataOfStranding') == null) {


    for (let i = 0; i <= 9; i++) {

        let dataOfStranding_1 = {};
        let inputs_1 = $(`#Stranding_${i + 1} .strandingActual`).find('.input, textarea');
        // console.log(inputs_1);

        for (let j = 0; j < inputs_1.length; j++) {
            let key = $(inputs_1[j]).attr('name');
            /* 
            dataOfStranding_1[0] => value of input
            dataOfStranding_1[1] => data-time of input
            dataOfStranding_1[2] => required
            dataOfStranding_1[3] => disabled
            */
            /* 
            so We Have to make inputs Of Standard is Required
            (j <= 12 || j == 15)
            j <= 12 => For Standard Inputs
            j == 15 => For Shape Actual
            */
            dataOfStranding_1[key] = ["", "", (j <= 12 || j == 15) ? true : false, false];
        }
        //To Know if user called data from alerts or not
        dataOfStranding_1['isAlert'] = [false, null];

        // console.log(dataOfStranding_1);

        dataOfStranding.push(dataOfStranding_1);
    }
    // console.log(dataOfStranding);
    localStorage.setItem('dataOfStranding', JSON.stringify(dataOfStranding));

    deliverDataFromStrandingLocalStorage();

} else {

    deliverDataFromStrandingLocalStorage();
    //To Hide the DropDown-Alert if you use All of alerts 
    for (let i = 0; i < $('.stranding .dropdownalert').length; i++) {
        let counter = 0;
        let counterOfdropdownalert_item = $('.stranding .dropdownalert').eq(i).find('.dropdownalert-menu').children().length;
        for (let j = 0; j <= counterOfdropdownalert_item; j++) {
            if ($('.stranding .dropdownalert').eq(i).find('.dropdownalert-item').eq(j).css('display') == 'none') {
                counter++;
            }

        }

        // console.log(counterOfdropdownalert_item, counter);
        if (counter == counterOfdropdownalert_item) {
            $('.stranding .dropdownalert').eq(i).addClass('d-none');
        }

    }

}

function deliverDataFromStrandingLocalStorage() {
    dataOfStranding = JSON.parse(localStorage.getItem('dataOfStranding'));

    for (let i = 0; i <= 9; i++) {

        let inputs = $(`#Stranding_${i + 1} .strandingActual`).find('.input');
        let textarea = $(`#Stranding_${i + 1} .strandingActual`).find('textarea')[0];
        inputs.push(textarea);



        for (let j = 0; j < inputs.length; j++) {
            let inputFromLocalStorage = dataOfStranding[i][$(inputs[j]).attr('name')];
            $(inputs[j]).val(inputFromLocalStorage[0]);
            $(inputs[j]).attr('data-time', inputFromLocalStorage[1]);
            $(inputs[j]).prop('required', inputFromLocalStorage[2]);
            $(inputs[j]).prop('disabled', inputFromLocalStorage[3]);
        }

        if (dataOfStranding[i]['isAlert'][0]) {
            $('.stranding .popUp').eq(i).find('.dataNotComplete').addClass('d-none');
            $('.stranding .popUp').eq(i).find('.searchJopOrderNumberOfStranding input[name="jopOrderNumber"]').prop('disabled', true);
            $('.stranding .popUp').eq(i).find('.searchJopOrderNumberOfStranding button').prop('disabled', true);
            /* 
            this Line To
            hide dropdownalert-item if it is called at one of sheet to complete it 
            And add attrebute data-sheet-item to dropdownalert-item after Refresh
            */
            $('.stranding .popUp').find(`.dataNotComplete .dropdownalert-item[data-id=${dataOfStranding[i]['isAlert'][1]}]`).addClass('d-none').attr('data-sheet-item', i);
            $('.stranding .popUp').eq(i).find('.strandingActual').attr('data-update', dataOfStranding[i]['isAlert'][0]);
            $('.stranding .popUp').eq(i).find('.strandingActual').attr('data-id-for-update', dataOfStranding[i]['isAlert'][1]);
            $('.stranding .popUp').eq(i).attr('data-isAlert', true);
            $('.stranding .popUp').eq(i).attr('update-data-sheet-of-id', dataOfStranding[i]['isAlert'][1]);
            //To Show Icon Of Clear Sheet
            $('.stranding .popUp').eq(i).find('.fa-trash-restore').removeClass('d-none');
            //To say Updating Of Sheet Is Happening
            $('.stranding .popUp').eq(i).attr('isUpdating', true);
        }

    }
}

function SaveDataOfStrandingLocalStorage(element, inputs, isAlert = false, idOfAlert = null) {
    let dataOfStranding = JSON.parse(localStorage.getItem('dataOfStranding'));
    let item = $(element).parents('.popUp').attr('data-item');
    for (let j = 0; j < inputs.length; j++) {
        dataOfStranding[item][$(inputs[j]).attr('name')] = [$(inputs[j]).val(), $(inputs[j]).attr('data-time'), $(inputs[j]).prop('required'), $(inputs[j]).prop('disabled')];
    }
    dataOfStranding[item]['isAlert'] = [isAlert, idOfAlert];
    localStorage.setItem('dataOfStranding', JSON.stringify(dataOfStranding));
}






