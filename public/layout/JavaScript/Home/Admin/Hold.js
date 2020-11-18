



$('.hold form').submit(function (e) {
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    e.preventDefault();

    let that = this;
    let dataForm = {};
    let token = $(this).find('input').eq(0).attr('value');
    dataForm['_token'] = token;

    for (let i = 1; i < $(this).find('input').length; i++) {
        let key = $(this).find('input').eq(i).attr('name');
        // Becuse if didn't  send some of data that mean he didn't make blur for input so he didn't now the time 
        let date = new Date().toLocaleString();
        let value = [$(this).find('input').eq(i).val(), ($(this).find('input').eq(i).attr('data-time') != "") ? $(this).find('input').eq(i).attr('data-time') : date];
        dataForm[key] = value;
    }
    let date = new Date().toLocaleString();
    dataForm['reasonOfHold'] = [$(this).find('textarea').eq(0).val(), ($(this).find('textarea').eq(0).attr('data-time') != "") ? $(this).find('textarea').eq(0).attr('data-time') : date];

    // console.log(dataForm);

    $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: dataForm,
        success: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            //    console.log(data);   

            $($(that).find('input:not(input[name="_token"])')).val('');
            $($(that).find('textarea')).val('');

            // To Save Data in LocalStorage
            let inputs = $(that).find('input:not(input[name="_token"])');
            inputs.push($(that).find('textarea'));
            SaveDataOfHoldLocalStorage(that, inputs);
        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').removeClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        }
    });
});

//To Save Data Of Hold Sheets in LocalStorage for Refreash
let dataOfHold = {};

if (localStorage.getItem('dataOfHold') == null) {

    let inputs = $(`#Hold_1 .holdForm`).find('input:not(input[name="_token"])');
    let textarea = $(`#Hold_1 .holdForm`).find('textarea')[0];
    inputs.push(textarea);
    // console.log(inputs);

    for (let j = 0; j < inputs.length; j++) {
        let key = $(inputs[j]).attr('name');
        /* 
        dataOfHold[0] => value of input
        dataOfHold[1] => data-time of input
        dataOfHold[2] => required
        */
        dataOfHold[key] = ["", "", true];
    }


    // console.log(dataOfHold);

    localStorage.setItem('dataOfHold', JSON.stringify(dataOfHold));

    deliverDataFromHoldLocalStorage();

} else {

    deliverDataFromHoldLocalStorage();


}

function deliverDataFromHoldLocalStorage() {
    dataOfHold = JSON.parse(localStorage.getItem('dataOfHold'));


    let inputs = $(`#Hold_1 .holdForm`).find('input:not(input[name="_token"])');
    let textarea = $(`#Hold_1 .holdForm`).find('textarea')[0];
    inputs.push(textarea);



    for (let j = 0; j < inputs.length; j++) {
        let inputFromLocalStorage = dataOfHold[$(inputs[j]).attr('name')];
        $(inputs[j]).val(inputFromLocalStorage[0]);
        $(inputs[j]).attr('data-time', inputFromLocalStorage[1]);
        $(inputs[j]).prop('required', inputFromLocalStorage[2]);
    }


}

function SaveDataOfHoldLocalStorage(element, inputs) {
    let dataOfHold = JSON.parse(localStorage.getItem('dataOfHold'));
    for (let j = 0; j < inputs.length; j++) {
        dataOfHold[$(inputs[j]).attr('name')] = [$(inputs[j]).val(), $(inputs[j]).attr('data-time'), $(inputs[j]).prop('required')];
    }
    localStorage.setItem('dataOfHold', JSON.stringify(dataOfHold));
}


