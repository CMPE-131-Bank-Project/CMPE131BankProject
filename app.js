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

// In your app.js file
$(document).ready(function() {
    $('#rememberMe').change(function() {
        if (this.checked) {
            // User wants to be remembered, implement your logic here
            // For example, set a cookie or store the preference in localStorage
        } else {
            // User does not want to be remembered, implement your logic here
            // For example, remove the cookie or clear the preference from localStorage
        }
    });
});
