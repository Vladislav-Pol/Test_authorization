//обработка нажатия кнопи=ки "войти"
$('#btn_login').click(function () {
    $('.error').remove();
    $.ajax({
        type: "POST",
        url: "/authorization/login",
        dataType: "json",
        data: $('#authorization').serialize(),
        success: function (data) {
            if(data.auth){
                location.replace('/');
            } else{
                if (data.login_error) {
                    $('#password').after(`<p class="error">${data.login_error}</p>`);
                }
            }
        }
    })
})

//обработка нажатия кнопи=ки "зарегистрироваться"
$('#btn_registration').click(function () {
    $('.error').remove();
    $.ajax({
        type: "POST",
        url: "/registration/new",
        dataType: "json",
        data: $('#registration').serialize(),
        success: function (data) {
            if(data.registr){
                location.replace('/authorization');
            } else{
                for (let key in data) {
                    $(`#${key}`).after(`<p class="error">${data[key]}</p>`);
                }
            }
        }
    })
})

