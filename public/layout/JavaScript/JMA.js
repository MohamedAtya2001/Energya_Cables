/* You Should  Call This Libarary Before Your JavaScript Code*/

function counterOfTextarea(textareaId, counterId) {

    var maxLength = textareaId.getAttribute("maxlength");

    textareaId.addEventListener("input", function () {

        counterId.innerHTML = parseFloat(maxLength) - textareaId.value.length;

        if (counterId.innerHTML <= 0) {
            counterId.style.color = '#f00';
        }
        else {
            counterId.style.color = '#000';
        }

    })

}

$.fn.PassToggle = function(buttonId) {
    $(buttonId).click(function() {
        if($(this).attr('type') == 'password'){
            $(this).attr('type', 'text');
        }
        else{
            $(this).attr('type','Password');
        }
    })
}

$.fn.transform = function(val){
    $(this).css({
        '-webkit-transform': val,
        '-mo-transform': val,
        '-ms-transform': val,
        '-o-transform': val,
        'transform': val
    })
}

function placeholder() {

    'use strict';

    $('[placeholder]').focus(function() {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    });

    $('[placeholder]').blur(function() {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });

};
