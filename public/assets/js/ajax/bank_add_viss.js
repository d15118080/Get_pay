let route_id = $('#route_id').val();
let company_id = $('#company_id').val();

function Won_shipment() {
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
        url: '/api/v1/user/1won_shipment/' + route_id,
        data: {
            bankCode: $('#bank_code').val(),
            acctNo: $('#bank_number').val(),
            custNm: $('#bank_user_name').val()
        },
        success: function (res) {
            $("#one").css("display", "none");
            $("#two").css("display", "");
            $.cookie("verifyTrDt", res.data.verifyTrDt);
            $.cookie("verifyTrNo", res.data.verifyTrNo);
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
}

function Won_shipment_check() {
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
        url: '/api/v1/user/1won_shipment_check/' + route_id,
        data: {
            verifyTrDt:$.cookie("verifyTrDt"),
            verifyTrNo:$.cookie("verifyTrNo"),
            verifyVal:$('#verifyVal').val()
        },
        success: function (res) {
            $("#two").css("display", "none");
            $("#three").css("display", "");

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
}

function Account_temporary_issuance() {
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
        url: '/api/v1/user/account_temporary_issuance/' + route_id+"/"+company_id,
        data: {
            bankCode: $('#bank_code').val(),
            acctNo: $('#bank_number').val(),
            custNm: $('#bank_user_name').val(),
            amount :$('#money').val()
        },
        success: function (res) {
            $("#three").css("display", "none");
            $("#for").css("display", "");
            $("#bankAcctNo").val(res.data.bank_no);
            $("#amount").val(res.data.money);
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
}
