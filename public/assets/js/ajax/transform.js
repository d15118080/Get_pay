import {Token_Check} from './export.js';

Token_Check();
let charge_data = [];

function uncomma(str) {
    str = String(str);
    return str.replace(/[^\d]+/g, '');
}

const input = document.querySelector('#money');
input.addEventListener('keyup', function (e) {
    let value = e.target.value;
    value = Number(value.replaceAll(',', ''));
    if (isNaN(value)) {         //NaN인지 판별
        input.value = 0;
    } else {                   //NaN이 아닌 경우
        const formatValue = value.toLocaleString('ko-KR');
        input.value = formatValue;
    }
})

$("#calculate_send").click(function () {
    Token_Check()
    Swal.fire({
        title: "잠시만 기다려주세요",
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });

    $.ajax({
        type: "POST",
        url: "/api/v1/user/transform_request",
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token")
        },
        data:{
            money: uncomma($('#money').val()),
        },
        success: function (res) {
            if(res.result.resultCd == "0001"){
                $(".setp1").css("display", "none");
                $(".auth2").css("display", "");
                Swal.close()
            }else{
                alert('처리 되었습니다')
                location.replace('/calculates')
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
