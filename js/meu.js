$(document).ready(function() {
    $("#form").validate({
        rules: {
            nome: {
                required: true,
                maxlength: 50,
                minlength: 5,
                minWords: 2
            },

            Email: {
                required: true,
                email: true
            },

            Fone: {
                required: true,
                number: true,
                maxlength: 12,
                minlength: 8
            },

            Mensagem: {
                required: true
            }
        }
    });
});