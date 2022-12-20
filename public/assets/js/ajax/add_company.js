import { Token_Check } from './export.js';
Token_Check();
let mode;
$(".company_add").click(function () {
    mode = $(this).data("mode");
    Swal.fire({
        title:"잠시만 기다려주세요",
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
    //본사 추가일 경우
    if(mode == 0) {
        $.ajax({
            type: "POST",
            url: "/api/v1/user/add_company",
            headers: {
                Authorization: "Bearer " + $.cookie("X-Token"),
            },
            data: {
                mode: mode,
                company_name: $('#company_name').val(),
                user_id: $('#user_id').val(),
                user_password: $('#user_password').val(),
                company_margin: $('#company_margin').val(),
            },
            success: function (res) {
                alert('생성 되었습니다')
                location.reload()
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
    }else if(mode == 1 || mode ==2){
        $.ajax({
            type: "POST",
            url: "/api/v1/user/add_company",
            headers: {
                Authorization: "Bearer " + $.cookie("X-Token"),
            },
            data: {
                mode: mode,
                company_name: $('#company_name').val(),
                user_id: $('#user_id').val(),
                user_password: $('#user_password').val(),
                company_margin: $('#company_margin').val(),
                set_key :$('#set_key').val()
            },
            success: function (res) {
                alert('생성 되었습니다')
                location.reload()
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
    }else if(mode  == 3){
        $.ajax({
            type: "POST",
            url: "/api/v1/user/add_company",
            headers: {
                Authorization: "Bearer " + $.cookie("X-Token"),
            },
            data: {
                mode: mode,
                company_name: $('#company_name').val(),
                user_id: $('#user_id').val(),
                user_password: $('#user_password').val(),
                company_margin: $('#company_margin').val(),
                set_key :$('#set_key').val(),
                bank_mode:$('#bank_mode').val(),
                calculate_fee:$('#calculate_fee').val(),
                company_fee:$('#company_fee').val()
            },
            success: function (res) {
                alert('생성 되었습니다')
                location.reload()
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
});
