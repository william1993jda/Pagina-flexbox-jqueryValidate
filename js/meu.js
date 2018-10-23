$(document).ready(function() {
    $("#form, #form-cadastro").validate({
        rules: {
            Nome: {
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
            },

            Mensagem: {
                required: true
            },

            cadastre: {
                required: true,
                email: true
            }
        }
    });
});

$("#phone").bind('input propertychange', function() {

    var texto = $(this).val();

    texto = texto.replace(/[^\d]/g, '');

    if (texto.length > 0)
    {
        texto = "(" + texto;

        if (texto.length > 3)
        {
            texto = [texto.slice(0, 3), ") ", texto.slice(3)].join('');
        }
        if (texto.length > 12)
        {
            if (texto.length > 13)
                texto = [texto.slice(0, 10), "-", texto.slice(10)].join('');
            else
                texto = [texto.slice(0, 9), "-", texto.slice(9)].join('');
        }
        if (texto.length > 15)
            texto = texto.substr(0,15);
    }
    $(this).val(texto);
});

/*Função Ajax */
$(function() {
    $('#form').submit(function() {
        var form = $(this).serialize();
        var request = $.ajax({
            method:"POST",
            url:"email.php",
            data:form,
            dataType:"json",
            beforeSend: function () {
                $("#enviar").html("Enviando...").addClass("enviar");
            }
        });

        request.always(function(e) {
            console.log(e);
            $("#enviar").html("enviar").removeClass();

            $('#form').each(function () {
                $('#aviso').html('Enviado com sucesso!').addClass("cor-alerta");
                this.reset();
                $("p").click(function () {
                    $("p").remove("#aviso");
                });
            });
        });
        return false;
    });
});
// função para animar scroll

// var $target = $('.anime'),
//     animationClass = 'anime-start';
//
// function animeScroll() {
//     var documentTop = $(document).scrollTop();
//     console.log(documentTop);
//
//     $target.each(function () {
//         var itemTop = $(this).offset().top;
//         if (documentTop > itemTop) {
//             $(this).addClass(animationClass);
//         } else {
//             $(this).removeClass(animationClass);
//         }
//     })
// }

// animeScroll();

// $(document).scroll(function () {
//     animeScroll();
// });
