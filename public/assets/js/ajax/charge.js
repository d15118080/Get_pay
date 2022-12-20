import {Token_Check} from './export.js';

Token_Check();
let charge_data = [];

function uncomma(str) {
    str = String(str);
    return str.replace(/[^\d]+/g, '');
}


const input = document.querySelector('#charge_money');
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


$("#charge_add").click(function () {
    let charge_name = $("#charge_name").val();
    let charge_money = $("#charge_money").val();

    if (charge_money == "" || charge_name == "") {
        Swal.fire("", "빈값이 존재합니다.", "error");
        return;
    }
    Swal.fire({
        html: `입금자명이 <b>${charge_name}</b> 님이 맞습니까? 입금 금액: ${charge_money} 원 <br> 계속 추가를 원하시면 <b>네</b> 를 눌러주세요`,
        icon: "success",
        showCancelButton: true,
        allowEscapeKey: false,
        allowOutsideClick: false,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "네",
        cancelButtonText: "아니요",
    }).then((result) => {
        if (result.isConfirmed) {
            let data = {
                user_name: charge_name,
                money: uncomma(charge_money),
            };
            charge_data.push(data);
            var my_tbody = document.getElementById('money_list');
            var row = my_tbody.insertRow(my_tbody.rows.length); // 하단에 추가
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            cell1.innerHTML = charge_name;
            cell2.innerHTML = `<td><span class="text-success">${charge_money}</span> 원</td>`;
            $("#charge_name").val("");
            $("#charge_money").val("");
        }
    });
});


$("#charge_send").click(function () {
    if (charge_data == null || charge_data.length == 0) {
        Swal.fire("", "값이 없습니다.", "error");
        return;
    }
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
        url: "/api/v1/user/charge_request",
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token")
        },
        data:{
            data:charge_data,
            mode:"Rtpay",
        },
        success: function (res) {
            $( '#money_table > tbody').empty();
            charge_data = [];
            Swal.fire({
                icon: "success",
                title: '정상 처리',
                text: res.result.advanceMsg,
            });
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
