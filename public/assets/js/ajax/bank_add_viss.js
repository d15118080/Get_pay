
    let route_id = $('#route_id').val();
    let company_id = $('#company_id').val();

    function Won_shipment() {
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
