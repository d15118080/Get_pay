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
        data : JSON.stringify({holder : $("#bank_user_name").val(), phoneNo:$('#ph_number').val(), amt:"", mid:mids, udf1:company_id, udf2:""}),
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
   window.open(url,'player','width=500, height=300, scrollbars=yes, resizable=no, top=1, left=1');
}

//본인계좌인증후 응답처리
window.addEventListener('message', function(e) {
    console.log(e.data)
    try{
        var resObj = new Object();
        resObj = JSON.stringify(e.data);
        var result = JSON.parse(resObj);
        Swal.close()
        Account_everlasting_issuance(result.data.account_info.holder,result.data.account_info.account)
    }catch{
        alert('에러가 발생하였습니다 다시 시도해주세요.')
    }
});

function Account_everlasting_issuance(holder,bankAcctNo) {
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
        url: '/api/v1/user/account_everlasting_issuance_v2/' + route_id+"/"+company_id,
        data: {
            holder: holder,
            bankAcctNo: bankAcctNo,
        },
        success: function (res) {
            $("#one").css("display", "none");
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
