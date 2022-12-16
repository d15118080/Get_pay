$("#auth_login").click(function () {
    Swal.fire({
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
    $.ajax({
        type: "POST",
        url: "/api/v1/user/auth-check",
        data: {
            user_id: $("#user_id").val(),
            user_password: $("#user_password").val(),
        },
        success: function (res) {
            if(res.data.code == "0000") {
                $.cookie("X-Token", res.data.XToken);
                $.cookie("H-Token", res.data.HToken);
                location.replace("/");
            }else if(res.data.code == "1000"){
                swal.close()
                $('.auth_from').css('display','none')
                $('.auth2_password_check').css('display','')
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            let data = XMLHttpRequest.responseJSON;
            Swal.fire({
                icon: "error",
                title: `에러(${data.result.resultCd})`,
                text: data.result.advanceMsg,
            });
        },
    });
});


$("#auth2_login").click(function () {
    Swal.fire({
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
    $.ajax({
        type: "POST",
        url: "/api/v1/user/auth2-check",
        data: {
            user_id: $("#user_id").val(),
            user_password: $("#user_password").val(),
            user_auth2_password: $("#user_auth2_password").val(),
        },
        success: function (res) {
                $.cookie("X-Token", res.data.XToken);
                $.cookie("H-Token", res.data.HToken);
                location.replace("/");
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            let data = XMLHttpRequest.responseJSON;
            Swal.fire({
                icon: "error",
                title: `에러(${data.result.resultCd})`,
                text: data.result.advanceMsg,
            });
        },
    });
});
