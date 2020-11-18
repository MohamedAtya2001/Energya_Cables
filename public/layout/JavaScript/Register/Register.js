
// To Register Admin And Employee
$("#Register").submit(function (e) {
    console.log('Done');
    e.preventDefault();
    $(this).find('button[type="submit"]').prop('disabled', true);
    $(this).find('.spinner').removeClass('d-none');
    let that = this;
    if ($("#class").val() == "employee") {

        $.ajax({
            'url': $(this).attr('action-employee'),
            'type': 'POST',
            'data': $(this).serialize(),
            'success': function (data) {
                $(that).find('button[type="submit"]').prop('disabled', false);
                $(that).find('.spinner').addClass('d-none');
                $(that).find('.bug').addClass('d-none');
                $("#Register input").val('');
                $(".text-success").css('display', 'block').text('Created New Employee');
                $(that).find(`p[data-error]`).addClass('d-none');
                setTimeout(function () {
                    $(".text-success").animate({ 'opacity': 0 }, 1000, function () {
                        $(".text-success").slideUp(1000);
                    });
                }, 5000);
            },
            'error': function (data) {
                $(that).find('button[type="submit"]').prop('disabled', false);
                $(that).find('.spinner').addClass('d-none');
                let errors = data.responseJSON.errors;
                // console.log(errors);

                if (errors['name'] != undefined) {
                    $(that).find(`p[data-error="name"]`).html(errors['name']).removeClass('d-none');
                } else {
                    $(that).find(`p[data-error="name"]`).html('').addClass('d-none');
                }

                if (errors['email'] != undefined) {
                    $(that).find(`p[data-error="email"]`).html(errors['email']).removeClass('d-none');
                } else {
                    $(that).find(`p[data-error="email"]`).html('').addClass('d-none');
                }

                if (errors['password'] != undefined) {
                    $(that).find(`p[data-error="password"]`).html(errors['password']).removeClass('d-none');
                } else {
                    $(that).find(`p[data-error="password"]`).html('').addClass('d-none');
                }
            }
        });

    } else if ($("#class").val() == "admin") {

        $.ajax({
            'url': $(this).attr('action-admin'),
            'type': 'POST',
            'data': $(this).serialize(),
            'success': function (data) {
                $(that).find('button[type="submit"]').prop('disabled', true);
                $(that).find('.spinner').addClass('d-none');
                $(that).find('.bug').addClass('d-none');
                $(that).find('input:not(input#code), select').prop('disabled', true);
                $("#SendCode").removeClass('d-none');
                localStorage.setItem('code', data);
                $(that).find(`p[data-error]`).addClass('d-none');
            },
            'error': function (data) {
                $(that).find('button[type="submit"]').prop('disabled', false);
                $(that).find('.spinner').addClass('d-none');
                let errors = data.responseJSON.errors;

                if (errors['name'] != undefined) {
                    $(that).find(`p[data-error="name"]`).html(errors['name']).removeClass('d-none');
                } else {
                    $(that).find(`p[data-error="name"]`).html('').addClass('d-none');
                }

                if (errors['email'] != undefined) {
                    $(that).find(`p[data-error="email"]`).html(errors['email']).removeClass('d-none');
                } else {
                    $(that).find(`p[data-error="email"]`).html('').addClass('d-none');
                }

                if (errors['password'] != undefined) {
                    $(that).find(`p[data-error="password"]`).html(errors['password']).removeClass('d-none');
                } else {
                    $(that).find(`p[data-error="password"]`).html('').addClass('d-none');
                }

            }
        });

    }

});

// To Send Code Of Authintication Email
$("#SendCodeButton").click(function () {

    if ($("#code").val() == JSON.parse(localStorage.getItem('code'))) {
        $("#code").removeClass('error');
        console.log('ok');
        let dataForm = {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'name': $('#Register #name').val(),
            'email': $('#Register #email').val(),
            'password': $('#Register #password').val()
        }

        // console.log(dataForm);

        $.ajax({
            'url': $(this).attr('data-route'),
            'type': 'POST',
            'data': dataForm,
            'success': function (data) {
                // console.log(data);
                // return 0;
                console.log('Done');
                $("#Register").find('button[type="submit"]').prop('disabled', false);
                $(".text-success").css('display', 'block').text('Created New Admin');
                setTimeout(function () {
                    $(".text-success").animate({ 'opacity': 0 }, 1000, function () {
                        $(".text-success").slideUp(1000);
                    });
                }, 5000);
                $("#Register input").val('');
                $("#SendCode").addClass('d-none');
                $("#Register").find('input:not(input#code), select').prop('disabled', false);
            },
            'error': function (data) {

            }
        });
    } else {
        console.log('no');
        $("#code").addClass('error');
    }

});


