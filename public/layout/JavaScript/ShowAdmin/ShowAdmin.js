
$(".password i.fa-eye").click(function () {
    $("#password").attr('type', 'text');
    $(this).fadeOut();
    $(".password i.fa-eye-slash").fadeIn();
})

$(".password i.fa-eye-slash").click(function () {
    $("#password").attr('type', 'Password');
    $(this).fadeOut();
    $(".password i.fa-eye").fadeIn();
})

// Create FilterArray
let filterOfAdmin = {
    'name': '',
    'limit': 25
};

// Function To Get Data Of Admins
function GetAdmins(that = null, moreData = false) {
    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {};
    dataForm['_token'] = $('meta[name="csrf-token"]').attr('content');
    filterOfAdmin['name'] = $("#FilterValue").val();
    filterOfAdmin['limit'] = parseInt($("#Limit").attr('data-count-rows'));
    dataForm['filter'] = filterOfAdmin;
    // console.log(dataForm);
    $.ajax({
        'url': 'showAdmin/getAdmins',
        'type': 'POST',
        'data': dataForm,
        'success': function (data) {
            $(that).prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            $(that).find('.bug').addClass('d-none');
            // console.log(data);
            let admins = data[0];
            let countOfAdminRows = data[1];
            if (countOfAdminRows > filterOfAdmin['limit']) {
                $("#Limit").removeClass('d-none');
            } else {
                $("#Limit").addClass('d-none');
            }

            /* ================================ */

            if (!moreData) {
                $('#Admin .table tbody').html('');
            }

            for (let i = 0; i < admins.length; i++) {

                $('#Admin .table tbody').append(`<tr data-id="${admins[i].id}">
                                          <th>${admins[i].id}</th>
                                          <td>${admins[i].name}</td>
                                          <td class="option">
                                          <button class="btn btn-primary mr-3" onclick="editAdmin(${admins[i].id}, this)">
                                          <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                          <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                          <span>Edit</span>
                                          </button>
                                          <button class="btn btn-danger" onclick="deleteAdmin(${admins[i].id})">Delete</button>
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
    GetAdmins(this, true);
});

// To Make Filter On Data
$('#Filter').click(function () {
    $("#Limit").attr('data-count-rows', 25);
    GetAdmins(this);
});

// To Show MakeSure Box
function deleteAdmin(id) {

    $('#MakeSure').fadeIn(1000);
    $('#MakeSure').css('display', 'flex');
    $('#MakeSure .box').animate({ 'top': '0' }, 1000);
    $('#MakeSure').attr('data-id', id);

}

// Function To Get Data Of Admin For Edit
function editAdmin(id, that) {
    $(that).prop('disabled', true);
    $(that).find('.spinner').removeClass('d-none');
    let dataForm = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id": id
    }

    // console.log(dataForm);

    $.ajax({

        url: 'showAdmin/getDataOfAdmin',
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

//Function To Update Data Admin Of That Row Who Edited
function updateAdmin(data) {
    $(`#Admin .table tbody tr[data-id="${data.id}"]`).html(`
                <th>${data.id}</th>
                <td>${data.name}</td>
                <td class="option">
                <button class="btn btn-primary mr-3" onclick="editAdmin(${data.id}, this)">
                <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span>Edit</span>
                </button>
                <button class="btn btn-danger" onclick="deleteAdmin(${data.id})">Delete</button>
                </td>
                `);
}

$('#Edit i.fa-times-circle').click(function () {
    $('#Edit').fadeOut(500);
    $("#Edit .box").css('top', '-600px');
    $(`#Edit form p.text-success`).text('').removeClass('d-block');
});

// To Update Data Of Admin
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
        url: 'showAdmin/editAdmin',
        type: 'POST',
        data: dataForm,
        success: function (data) {
            $(that).find('button[type="submit"]').prop('disabled', false);
            $(that).find('.spinner').addClass('d-none');
            // console.log(data);
            $(`#Edit form p.text-danger`).text('');
            $(`#Edit form p.text-danger`).addClass('d-none');
            $(`#Edit`).find('input').val('');
            $('#Edit').fadeOut(500);
            $("#Edit .box").css('top', '-600px');
            updateAdmin(data);
        },
        error: function (data) {
            let errors = data.responseJSON.errors;

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
        "id": $('#MakeSure').attr('data-id')
    };

    console.log(dataForm);
    $.ajax({
        url: 'showAdmin/deleteAdmin',
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



