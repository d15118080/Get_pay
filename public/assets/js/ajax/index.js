import { Token_Check } from './export.js';
import { chart_init } from '../pages/dashboard-ecommerce.init.js';
Token_Check();
//
Swal.fire({
    title:"잠시만 기다려주세요",
    allowEscapeKey: false,
    allowOutsideClick: false,
    didOpen: () => {
        Swal.showLoading();
    },
});

$.ajax({
    type: "GET",
    url: "/api/v1/user/index_transaction_history_data",
    headers: {
        Authorization: "Bearer " + $.cookie("X-Token"),
    },
    success: function (res) {
        chart_init(res.data.dates,res.data.arr_money,res.data.arr_withdraw)
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


