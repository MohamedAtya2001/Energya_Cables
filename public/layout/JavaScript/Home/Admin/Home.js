
$('input').attr('autocomplete', 'off');

//To Close SheetForm If There Is Any UnComplete Sheet 
/* $(function () {
    $.ajax({
        url: '',
        type: "POST",
        data: { '_token': $('meta[name="csrf-token"]').attr('content') },
        success: function (data) {
            for (let key in data) {
                if (data[key].length > 0) {
                    for (let i = 0; i < data[key].length; i++) {
                        $(`.${key} .popUp:not(.${key} .popUp[data-isAlert="true"])`).find('.input, textarea, button:not(button.text-warning)').prop('disabled', true);
                    }
                } else {
                    continue;
                }
            }

        },
        error: function (data) { }
    });

}); */


//Sheetes

//To Stop Enter That Send Data Before complite data
$(window).keydown(function (event) {
    if (event.keyCode == 13) {
        event.preventDefault();
        return false;
    }
});

//Function To add Time OF Every input insert
$('.input, textarea').blur(function () {
    let date = new Date().toLocaleString();
    $(this).attr('data-time', date);
});

//For save every data change in localStorage
$('.input:not(input[inputSearch]), textarea').blur(function () {
    let date = new Date().toLocaleString();
    let item = $(this).parents('.popUp').attr('data-item');

    if ($(this).parents('.drowing').length == 1) {
        let dataOfDrowing = JSON.parse(localStorage.getItem('dataOfDrowing'));
        dataOfDrowing[item][$(this).attr('name')] = [$(this).val(), date, $(this).prop('required'), $(this).prop('disabled')];
        localStorage.setItem('dataOfDrowing', JSON.stringify(dataOfDrowing));
    }
    else if ($(this).parents('.stranding').length == 1) {
        let dataOfStranding = JSON.parse(localStorage.getItem('dataOfStranding'));
        dataOfStranding[item][$(this).attr('name')] = [$(this).val(), date, $(this).prop('required'), $(this).prop('disabled')];
        localStorage.setItem('dataOfStranding', JSON.stringify(dataOfStranding));
    }
    else if ($(this).parents('.insulation').length == 1) {
        let dataOfInsulation = JSON.parse(localStorage.getItem('dataOfInsulation'));
        dataOfInsulation[item][$(this).attr('name')] = [$(this).val(), date, $(this).prop('required'), $(this).prop('disabled')];
        localStorage.setItem('dataOfInsulation', JSON.stringify(dataOfInsulation));
    }
    else if ($(this).parents('.CCVInsulation').length == 1) {
        let dataOfCCVInsulation = JSON.parse(localStorage.getItem('dataOfCCVInsulation'));
        dataOfCCVInsulation[item][$(this).attr('name')] = [$(this).val(), date, $(this).prop('required'), $(this).prop('disabled')];
        localStorage.setItem('dataOfCCVInsulation', JSON.stringify(dataOfCCVInsulation));
    }
    else if ($(this).parents('.screen').length == 1) {
        let dataOfScreen = JSON.parse(localStorage.getItem('dataOfScreen'));
        dataOfScreen[item][$(this).attr('name')] = [$(this).val(), date, $(this).prop('required'), $(this).prop('disabled')];
        localStorage.setItem('dataOfScreen', JSON.stringify(dataOfScreen));
    }
    else if ($(this).parents('.assembly').length == 1) {
        let dataOfAssembly = JSON.parse(localStorage.getItem('dataOfAssembly'));
        dataOfAssembly[item][$(this).attr('name')] = [$(this).val(), date, $(this).prop('required'), $(this).prop('disabled')];
        localStorage.setItem('dataOfAssembly', JSON.stringify(dataOfAssembly));
    }
    else if ($(this).parents('.bedding').length == 1) {
        let dataOfBedding = JSON.parse(localStorage.getItem('dataOfBedding'));
        dataOfBedding[item][$(this).attr('name')] = [$(this).val(), date, $(this).prop('required'), $(this).prop('disabled')];
        localStorage.setItem('dataOfBedding', JSON.stringify(dataOfBedding));
    }
    else if ($(this).parents('.armouring').length == 1) {
        let dataOfArmouring = JSON.parse(localStorage.getItem('dataOfArmouring'));
        dataOfArmouring[item][$(this).attr('name')] = [$(this).val(), date, $(this).prop('required'), $(this).prop('disabled')];
        localStorage.setItem('dataOfArmouring', JSON.stringify(dataOfArmouring));
    }
    else if ($(this).parents('.Lead').length == 1) {
        let dataOfLead = JSON.parse(localStorage.getItem('dataOfLead'));
        dataOfLead[item][$(this).attr('name')] = [$(this).val(), date, $(this).prop('required'), $(this).prop('disabled')];
        localStorage.setItem('dataOfLead', JSON.stringify(dataOfLead));
    }
    else if ($(this).parents('.taps').length == 1) {
        let dataOfTaps = JSON.parse(localStorage.getItem('dataOfTaps'));
        dataOfTaps[item][$(this).attr('name')] = [$(this).val(), date, $(this).prop('required'), $(this).prop('disabled')];
        localStorage.setItem('dataOfTaps', JSON.stringify(dataOfTaps));
    }
    else if ($(this).parents('.sheathing').length == 1) {
        let dataOfSheathing = JSON.parse(localStorage.getItem('dataOfSheathing'));
        dataOfSheathing[item][$(this).attr('name')] = [$(this).val(), date, $(this).prop('required'), $(this).prop('disabled')];
        localStorage.setItem('dataOfSheathing', JSON.stringify(dataOfSheathing));
    }
    else if ($(this).parents('.finish').length == 1) {
        let dataOfFinish = JSON.parse(localStorage.getItem('dataOfFinish'));
        dataOfFinish[$(this).attr('name')] = [$(this).val(), date, $(this).prop('required')];
        localStorage.setItem('dataOfFinish', JSON.stringify(dataOfFinish));
    }
    else if ($(this).parents('.hold').length == 1) {
        let dataOfHold = JSON.parse(localStorage.getItem('dataOfHold'));
        dataOfHold[$(this).attr('name')] = [$(this).val(), date, $(this).prop('required')];
        localStorage.setItem('dataOfHold', JSON.stringify(dataOfHold));
    }
    else if ($(this).parents('.rewind').length == 1) {
        let dataOfRewind = JSON.parse(localStorage.getItem('dataOfRewind'));
        dataOfRewind[$(this).attr('name')] = [$(this).val(), date, $(this).prop('required')];
        localStorage.setItem('dataOfRewind', JSON.stringify(dataOfRewind));
    }

});

// For DropDownMenu 
$('.dropdownalert .dropdownalert-button').click(function () {
    if ($(this).siblings('.dropdownalert-menu').css('display') == "none") {
        $(this).siblings('.dropdownalert-menu').fadeIn(200);
    } else {
        $(this).siblings('.dropdownalert-menu').fadeOut(200);
    }
})

//For disappearing the DropDown-Alert if it was not have any alerts
for (let i = 0; i < $('.dropdownalert').length; i++) {

    if ($('.dropdownalert').eq(i).find('.dropdownalert-menu').children().length == 0) {
        $('.dropdownalert').eq(i).addClass('d-none');
    }

}

/* ========================================= */

$(`.option`).click(function () {
    $(`.${$(this).attr('data-sheet')}`).fadeIn(1000).css('display', 'block');
});

$('.sheetes .popUp i.fa-minus-circle:not(.sheetes .finish .popUp i.fa-minus-circle, .sheetes .hold .popUp i.fa-minus-circle, .sheetes .rewind .popUp i.fa-minus-circle)').click(function () {
    $(this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode).fadeOut(1000);
});

$('.sheetes .finish .popUp i.fa-minus-circle, .sheetes .hold .popUp i.fa-minus-circle, .sheetes .rewind .popUp i.fa-minus-circle').click(function () {
    $(this.parentNode.parentNode.parentNode).fadeOut(1000);
});

/* $('.sheetes').children().click(function() {
    $(this).fadeOut(1000);
}); */

$(`.sheetes .drowing`).on('click', '.drowing1 i.fa-minus-circle', function () {
    $('.popUp').fadeOut(1000);
});

$('.sheetes .popUp_data_option1 i.fa-plus-circle').click(function () {

    let options = [];

    let option = ``;
    options.push(option);

    $('.sheetes .drowing').prepend(options[0]);

    $('.sheetes .popUp_data_option1').fadeOut(500, function () {
        $('.drowing1').fadeIn(500);
    });

});


$('.sheetes .popUp .box').click(function (e) {
    e.stopPropagation();
});



