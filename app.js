$(document).ready(function() {
    $('#togglePassword').click(function() {
        $(this).toggleClass('open');
        $(this).toggleClass('fa-eye-slash fa-eye');
        if ($(this).hasClass('open')) {
            alert('Please type your password');
            $(this).prev().attr('type', 'text');
        } else {
            $(this).prev().attr('type', 'password');
        }
    });
});

