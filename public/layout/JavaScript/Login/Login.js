
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
