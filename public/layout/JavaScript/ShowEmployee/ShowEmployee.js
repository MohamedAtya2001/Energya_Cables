
// Create FilterArray
let filterOfEmployee = {
    'name': '',
    'shift': { 'shift_1': true, 'shift_2': true, 'shift_3': true },
    'activation': { 'online': true, 'offline': true },
    'limit': 25
};

//To Get Data From Filter And Save It At FilterArray
$("#FilterValue").blur(function () {
    filterOfEmployee[$("#FilterName").val()] = $(this).val();
    if ($(this).val() != '') {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).addClass('filtered');
    } else {
        $('#FilterName').find(`option[value="${$('#FilterName').val()}"]`).removeClass('filtered');
    }
});

$("#FilterName").change(function () {
    if ($(this).val() == "shift") {
        $('#Shift').css('display', 'flex');
        $("#Activation").css('display', 'none');
        $("#FilterValue").css('display', 'none');
    } else if ($(this).val() == "activation") {
        $('#Shift').css('display', 'none');
        $("#Activation").css('display', 'flex');
        $("#FilterValue").css('display', 'none');
    } else {
        $("#FilterValue").val(filterOfEmployee[$(this).val()]);
        $('#Shift').css('display', 'none');
        $("#Activation").css('display', 'none');
        $("#FilterValue").css('display', 'block');
    }
});

//To Save Data That he Want To
function shiftFilter(that) {
    if (!$('input#Shift_1').prop('checked') && !$('input#Shift_2').prop('checked') && !$('input#Shift_3').prop('checked')) {
        $(that).prop('checked', true);
    }

    filterOfEmployee['shift']['shift_1'] = $('input#Shift_1').prop('checked');
    filterOfEmployee['shift']['shift_2'] = $('input#Shift_2').prop('checked');
    filterOfEmployee['shift']['shift_3'] = $('input#Shift_3').prop('checked');

    if ($('input#Shift_1').prop('checked') && $('input#Shift_2').prop('checked') && $('input#Shift_3').prop('checked')) {
        $('#FilterName').find(`option[value="shift"]`).removeClass('filtered');
    } else {
        $('#FilterName').find(`option[value="shift"]`).addClass('filtered');
    }

}

//To Save Data That he Want To
function activationFilter(that) {
    if (!$('input#Online').prop('checked') && !$('input#Offline').prop('checked')) {
        $(that).prop('checked', false);
        $('#Activation input').not(that).prop('checked', true);
    }

    filterOfEmployee['activation']['online'] = $('input#Online').prop('checked');
    filterOfEmployee['activation']['offline'] = $('input#Offline').prop('checked');
    if ($('input#Online').prop('checked') && $('input#Offline').prop('checked')) {
        $('#FilterName').find(`option[value="activation"]`).removeClass('filtered');
    } else {
        $('#FilterName').find(`option[value="activation"]`).addClass('filtered');
    }
}

$(".password i.fa-eye").click(function () {
    $("#password").attr('type', 'text');
    $(this).fadeOut();
    $(".password i.fa-eye-slash").fadeIn();
});

$(".password i.fa-eye-slash").click(function () {
    $("#password").attr('type', 'Password');
    $(this).fadeOut();
    $(".password i.fa-eye").fadeIn();
});

// Function To Get Data Of Employees
function GetEmployees(that = null, moreData = false) {
    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    filterOfEmployee['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    dataForm['filter'] = filterOfEmployee;
    console.log(filterOfEmployee);
    $.ajax({
        'url': 'showEmployee/getEmployees',
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            console.log(data);
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            let employees = data[0];
            let countOfEmployeeRows = data[1];
            if (countOfEmployeeRows > filterOfEmployee['limit']) {
                $("#Limit").removeClass('d-none');
            } else {
                $("#Limit").addClass('d-none');
            }


            /* ================================ */

            if (!moreData) {
                $('#Employee .table tbody').html('');
            }

            for (let i = 0; i < employees.length; i++) {

                $('#Employee .table tbody').append(`<tr data-id="${employees[i].id}">
                                                   <th>${employees[i].id}</th>
                                                   <td>${employees[i].name}</td>
                                                   <td class="w-25">
                                                   <div class="row">
                                                   <div class="col-lg-6">
                                                   <div class="item">
                                                   <div class="custom-control custom-radio">
                                                   <input type="radio" class="custom-control-input" id="shift1_${i}" name="shift${i}" onclick="changeEmployeeShift('${employees[i].id}' , '1')" required ${(employees[i].shift == '1' ? 'checked' : '')}>
                                                   <label class="custom-control-label" for="shift1_${i}">Shift 1</label>
                                                   </div>
                                                   </div>
                                                   </div>
                                                   <div class="col-lg-6">
                                                   <div class="item">
                                                   <div class="custom-control custom-radio">
                                                   <input type="radio" class="custom-control-input" id="shift2_${i}" name="shift${i}" onclick="changeEmployeeShift('${employees[i].id}' , '2')" required ${(employees[i].shift == '2' ? 'checked' : '')}>
                                                   <label class="custom-control-label" for="shift2_${i}">Shift 2</label>
                                                   </div>
                                                   </div>
                                                   </div>
                                                   <div class="col-lg-6">
                                                   <div class="item">
                                                   <div class="custom-control custom-radio">
                                                   <input type="radio" class="custom-control-input" id="shift3_${i}" name="shift${i}" onclick="changeEmployeeShift('${employees[i].id}' , '3')" required ${(employees[i].shift == '3' ? 'checked' : '')}>
                                                   <label class="custom-control-label" for="shift3_${i}">Shift 3</label>
                                                   </div>
                                                   </div>
                                                   </div>
                                                   </div>
                                                   </td>
                                                   <td class="activation ${ (employees[i].online == true ? 'online' : 'offline')}">
                                                   <div class="form-check">
                                                   <div class="box" data-id="${employees[i].id}">
                                                   <button type="submit" onclick="logoutEmployee('${employees[i].id}', '${employees[i].online}')">${(employees[i].online == true ? 'ON' : 'OFF')}</button>
                                                   </div>
                                                   </div>
                                                   </td>
                                                   <td class="option">
                                                   <button class="btn btn-info" onclick="editEmployee('${employees[i].id}', this)">
                                                   <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                                   <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                   <span>Edit</span>
                                                   </button>
                                                   <a href="${window.location.origin + '/admin/WatchingEmployee/' + employees[i].id}"><button class="btn btn-success">Watching</button></a>
                                                   <button class="btn btn-danger" onclick="deleteEmployee('${ employees[i].id}', '${employees[i].name}')">Delete</button>
                                                   </td>
                                                   </tr>`);

            }

        },
        'error': function (data) {
            $(that).prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data.responseJSON.error);
        },
    });
}

// To Get More Data Reports
$("#Limit").click(function () {
    $(this).attr('data-count-rows', parseInt($(this).attr('data-count-rows')) + 25);
    GetEmployees(this, true);
});

// To Make Filter On Data
$('#Filter').click(function () {
    $("#Limit").attr('data-count-rows', 25);
    GetEmployees(this);
});

// To Show MakeSure Box
function deleteEmployee(id, name) {

    $('#MakeSure').fadeIn(1000);
    $('#MakeSure').css('display', 'flex');
    $('#MakeSure .box').animate({ 'top': '0' }, 1000);
    $('#MakeSure').attr('data-id', id);
    $('#MakeSure').attr('data-name', name);

}

function changeEmployeeShift(id, shift) {

    let dataForm = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id": id,
        "shift": shift
    }

    console.log(dataForm);

    $.ajax({

        url: 'showEmployee/changeEmployeeShift',
        type: 'POST',
        data: dataForm,
        success: function (data) {
            if (data == "employeeLoggedOut") {
                $(`.form-check .box[data-id="${id}"] button`).animate({
                    'left': '1px'
                }, 500);
                $(`.form-check .box[data-id="${id}"]`).animate({ backgroundColor: "#333" }, 500);
                $(`.form-check .box[data-id="${id}"] button`).text('OFF');
                $(`.form-check .box[data-id="${id}"] button`).css('color', '#333');
            }
        },
        error: function (data) {
            console.log(data);
        }

    });



}

function logoutEmployee(id, online) {
    if (online) {

        let dataForm = {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id": id
        }

        // console.log(dataForm);

        $.ajax({

            url: 'showEmployee/logoutEmployee',
            type: 'POST',
            data: dataForm,
            success: function (data) {
                if (data == "employeeLoggedOut") {
                    $(`.form-check .box[data-id="${id}"] button`).animate({
                        'left': '1px'
                    }, 500);
                    $(`.form-check .box[data-id="${id}"]`).animate({ backgroundColor: "#333" }, 500);
                    $(`.form-check .box[data-id="${id}"] button`).text('OFF');
                    $(`.form-check .box[data-id="${id}"] button`).css('color', '#333');
                }
            },
            error: function (data) {
                console.log(data);
            }

        });



    }
}

// Function To Get Data Of Employee For Edit
function editEmployee(id, that) {
    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id": id
    }

    // console.log(dataForm);

    $.ajax({

        url: 'showEmployee/getDataOfEmployee',
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data[0]);
            $('#Edit form input#name').val(data[0].name);
            $('#Edit form input#email').val(data[0].email);

            $("#Edit").fadeIn(500);
            $('#Edit .box').animate({ top: 0 }, 1000);
            $("#Edit form").attr('data-id', id);

        },
        error: function (data) {
            $(that).prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
            // console.log(data);
        }

    });





}

//Function To Update Data Employee Of That Row Who Edited
function updateEmployee(data) {
    let i = $(`#Employee .table tbody tr[data-id="${data.id}"]`).index();
    $(`#Employee .table tbody tr[data-id="${data.id}"]`).html(`
                <th>${data.id}</th>
                <td>${data.name}</td>
                <td class="w-25">
                <div class="row">
                <div class="col-lg-6">
                <div class="item">
                <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="shift1_${i}" name="shift${i}" onclick="changeEmployeeShift('${data.id}' , '1')" required ${(data.shift == 1 ? 'checked' : '')}>
                <label class="custom-control-label" for="shift1_${i}">Shift 1</label>
                </div>
                </div>
                </div>
                <div class="col-lg-6">
                <div class="item">
                <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="shift2_${i}" name="shift${i}" onclick="changeEmployeeShift('${data.id}' , '2')" required ${(data.shift == 2 ? 'checked' : '')}>
                <label class="custom-control-label" for="shift2_${i}">Shift 2</label>
                </div>
                </div>
                </div>
                <div class="col-lg-6">
                <div class="item">
                <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="shift3_${i}" name="shift${i}" onclick="changeEmployeeShift('${data.id}' , '3')" required ${(data.shift == 3 ? 'checked' : '')}>
                <label class="custom-control-label" for="shift3_${i}">Shift 3</label>
                </div>
                </div>
                </div>
                </div>
                </td>
                <td class="activation ${ (data.online == true ? 'online' : 'offline')}">
                <div class="form-check">
                <div class="box" data-id="${data.id}">
                <button type="submit" onclick="logoutEmployee('${data.id}', '${data.online}')">${(data.online == true ? 'ON' : 'OFF')}</button>
                </div>
                </div>
                </td>
                <td class="option">
                <button class="btn btn-info" onclick="editEmployee('${data.id}', this)">
                <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span>Edit</span>
                </button>
                <a href="${window.location.origin + '/admin/WatchingEmployee/' + data.id}"><button class="btn btn-success">Watching</button></a>
                <button class="btn btn-danger" onclick="deleteEmployee('${ data.id}', '${data.name}')">Delete</button>
                </td>
                `);
}

$('#Edit i.fa-times-circle').click(function () {
    $('#Edit').fadeOut(500);
    $("#Edit .box").css('top', '-600px');
    $(`#Edit form p.text-success`).text('').removeClass('d-block');
});

// To Update Data Of Employee
$('#Edit form').submit(function (e) {
    let that = this;
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    e.preventDefault();
    let dataForm = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        'name': $(this).find('#name').val(),
        'email': $(this).find('#email').val(),
        'password': $(this).find('#password').val(),
        "id": $(this).attr('data-id')
    };
    // console.log(dataForm);

    $.ajax({
        url: 'showEmployee/editEmployee',
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            // console.log(data);
            // return 0;
            $(`#Edit form p.text-danger`).text('');
            $(`#Edit form p.text-danger`).addClass('d-none');
            $(`#Edit`).find('input').val('');
            $('#Edit').fadeOut(500);
            $("#Edit .box").css('top', '-600px');
            updateEmployee(data);
        },
        error: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            let errors = data.responseJSON.errors;
            console.log(errors);
            $.each(errors, function (key, value) {
                $(`#Edit form p[data-error-name="${key}"]`).text(value);
                $(`#Edit form p[data-error-name="${key}"]`).removeClass('d-none');
            });



        }
    });

});

$('#MakeSure #Yes').click(function () {

    let that = this;
    $(this).prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    let dataForm = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id": $('#MakeSure').attr('data-id'),
        'name': $('#MakeSure').attr('data-name')
    };

    console.log(dataForm);

    $.ajax({
        url: 'showEmployee/deleteEmployee',
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data);
            $(`.container-lg tbody tr[data-id="${$('#MakeSure').attr('data-id')}"]`).remove();
            $('#MakeSure').fadeOut(500);
            $('#MakeSure .box').css('top', '-600px');
        },
        error: function (data) {
            $(that).prop('disabled', true);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').removeClass('d-none');
        }
    });



});

$('#MakeSure #No, #MakeSure i').click(function () {

    $('#MakeSure').fadeOut(1000);
    $('#MakeSure .box').animate({ 'top': '-600px' }, 1000);
});



