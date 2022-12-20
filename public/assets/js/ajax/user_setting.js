import { Token_Check } from './export.js';
Token_Check();
$(".save").click(function () {
    Swal.fire({
        title:"잠시만 기다려주세요",
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
        $.ajax({
            type: "POST",
            url: "/api/v1/user/user_setting_req",
            headers: {
                Authorization: "Bearer " + $.cookie("X-Token"),
            },
            data: {
                auth_state: $('#auth_state').val(),
                auth_password: $('#auth_password').val(),
                user_password: $('#user_password').val(),
            },
            success: function (res) {
                alert('저장 되었습니다.')
                location.reload()
                Swal.close()
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
