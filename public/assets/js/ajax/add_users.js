import { Token_Check } from './export.js';
Token_Check();
$("#add_user").click(function () {
    Swal.fire({
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
    $.ajax({
        type: "POST",
        url: "/api/v1/user/add_user",
        data: {
            user_id: $("#user_id").val(),
            user_password: $("#user_password").val(),
            user_name:$("#user_name").val(),
        },
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token")
        },
        success: function (res) {
            alert('생성 되었습니다.')
            location.reload()
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

