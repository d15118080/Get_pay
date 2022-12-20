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
        url: "/api/v1/user/calculate_request",
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token")
        },
        data:{
            bank_data:$('#bank_data').val(),
            money: uncomma($('#money').val()),
            bank_owner:$('#bank_owner').val(),
            bank_number:$('#bank_number').val()
        },
        success: function (res) {
            alert('처리 되었습니다')
            location.replace('/calculates')
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
