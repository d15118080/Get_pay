let route_id = $('#route_id').val();
let company_id = $('#company_id').val();
let mids = $('#mid').val();

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
        url : "https://sapi.apivac.kr/vacpay/api/acctChk",
        type: "POST",
        data : JSON.stringify({holder : $("#bank_user_name").val(), phoneNo:"01000000000", amt:$('#amt').val(), mid:mids, udf1:company_id, udf2:""}),
        dataType : "json",
        async: false,
        contentType: "application/json; charset=utf-8",
        success : function(data){
            if(data.resCode == "0000"){
                $("#result").val(JSON.stringify(data, null, 4));
                goVacPayPop(data.authUrl);
            }else{
                $("#result").val(JSON.stringify(data, null, 4));
                alert("결제요청에 실패하였습니다.");
                return;
            }
        }
    });
}

//본인인증 팝업 요청
function goVacPayPop(url){
    var pop_title="가상계좌결제시스템";
    //get 방식
    var pop = window.open(url,'player','width=500, height=300, scrollbars=yes, resizable=no, top=1, left=1');
    try{
        pop.focus();
    }catch(e){
        alert("팝업 차단 기능이 설정되어 있습니다.\n\n차단 기능을 해제 한 후 다시 시도해 주십시오.");
    }
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
            Account_everlasting_issuance()
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

function Account_everlasting_issuance() {
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
        url: '/api/v1/user/account_everlasting_issuance/' + route_id+"/"+company_id,
        data: {
            bankCode: $('#bank_code').val(),
            acctNo: $('#bank_number').val(),
            custNm: $('#bank_user_name').val(),
        },
        success: function (res) {
            $("#three").css("display", "none");
            $("#for").css("display", "");
            $("#bankAcctNo").val(res.data.bank_no);
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
