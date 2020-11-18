
$('.finish form').submit(function (e) {
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
    dataForm['notes'] = [$(this).find('textarea').eq(0).val(), ($(this).find('textarea').eq(0).attr('data-time') != "") ? $(this).find('textarea').eq(0).attr('data-time') : date];

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
            if (data == "Logout") {
                window.location.reload(true);
            } else {

                $($(that).find('input:not(input[name="_token"])')).val('');
                $($(that).find('textarea')).val('');

                // To Save Data in LocalStorage
                let inputs = $(that).find('input:not(input[name="_token"])');
                inputs.push($(that).find('textarea'));
                SaveDataOfFinishLocalStorage(that, inputs);
            }
        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        }
    });
});

//To Save Data Of Finish Sheets in LocalStorage for Refreash
let dataOfFinish = {};

if (localStorage.getItem('dataOfFinish') == null) {

    let inputs = $(`#Finish_1 .finishForm`).find('input:not(input[name="_token"])');
    let textarea = $(`#Finish_1 .finishForm`).find('textarea')[0];
    inputs.push(textarea);
    // console.log(inputs);

    for (let j = 0; j < inputs.length; j++) {
        let key = $(inputs[j]).attr('name');
        /* 
        dataOfFinish_1[0] => value of input
        dataOfFinish_1[1] => data-time of input
        dataOfFinish_1[2] => required
        */
        dataOfFinish[key] = ["", "", (key != "notes") ? true : false];
    }


    // console.log(dataOfFinish);

    localStorage.setItem('dataOfFinish', JSON.stringify(dataOfFinish));

    deliverDataFromFinishLocalStorage();

} else {

    deliverDataFromFinishLocalStorage();


}

function deliverDataFromFinishLocalStorage() {
    dataOfFinish = JSON.parse(localStorage.getItem('dataOfFinish'));


    let inputs = $(`#Finish_1 .finishForm`).find('input:not(input[name="_token"])');
    let textarea = $(`#Finish_1 .finishForm`).find('textarea')[0];
    inputs.push(textarea);



    for (let j = 0; j < inputs.length; j++) {
        let inputFromLocalStorage = dataOfFinish[$(inputs[j]).attr('name')];
        $(inputs[j]).val(inputFromLocalStorage[0]);
        $(inputs[j]).attr('data-time', inputFromLocalStorage[1]);
        $(inputs[j]).prop('required', inputFromLocalStorage[2]);
    }


}

function SaveDataOfFinishLocalStorage(element, inputs) {
    let dataOfFinish = JSON.parse(localStorage.getItem('dataOfFinish'));
    for (let j = 0; j < inputs.length; j++) {
        dataOfFinish[$(inputs[j]).attr('name')] = [$(inputs[j]).val(), $(inputs[j]).attr('data-time'), $(inputs[j]).prop('required')];
    }
    localStorage.setItem('dataOfFinish', JSON.stringify(dataOfFinish));
}


