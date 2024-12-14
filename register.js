$(document).ready(function() {
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();

        $('#responseMessage').html('');

        var password = $('#password').val();
        console.log('Паролата е: ' + password);

        if (!/[a-zA-Z]/.test(password) || !/[0-9]/.test(password) || !/[\W_]/.test(password) || password.length < 5) {
            $('#responseMessage').html('<p style="color: red;">Паролата трябва да съдържа поне 5 букви, 1 цифра и 1 специален символ.</p>');
            return;
        }

        var formData = $(this).serialize();
        console.log('Изпращам данни:', formData);

        $.ajax({
            type: 'POST',
            url: 'register.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                console.log('Отговор от сървъра:', response);
                if (response.status == 'success') {
                    $('#responseMessage').html('<p style="color: green;">' + response.message + '</p>');
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 2000);
                } else {
                    $('#responseMessage').html('<p style="color: red;">' + response.message + '</p>');
                }
            },
            error: function() {
                $('#responseMessage').html('<p style="color: red;">Възникна грешка при изпълнение на заявката!</p>');
            }
        });
    });
});
