import { Token_Check } from './export.js';
Token_Check();

$("#rtpay_setting").click(function () {
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
        url: "/api/v1/user/rtpay_insert_or_update",
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token")
        },
        data:{
            rtpay_key:$('#rtpay_key').val()
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
