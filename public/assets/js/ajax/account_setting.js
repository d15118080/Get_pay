import { Token_Check } from './export.js';
Token_Check();

$("#account_setting").click(function () {
    Swal.fire({
        title: "잠시만 기다려주세요",
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
    Token_Check();
    $.ajax({
        type: "POST",
        url: "/api/v1/user/account_insert_or_update",
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token")
        },
        data:{
            p_id:$('#p_id').val(),
            p_pw:$('#p_pw').val(),
            p_commuid:$('#p_commuid').val(),
            p_auth:"Basic "+btoa($('#p_id').val()+':'+$('#p_pw').val()),
        },
        success: function (res) {
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
