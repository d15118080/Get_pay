import { Token_Check } from './export.js';
Token_Check();
let ids
$(".head_edit").click(function () {
    ids = $(this).data("id");
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
        url: "/api/v1/user/get_company_data",
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token"),
        },
        data:{
            id:$(this).data("id")
        },
        success: function (res) {
            Swal.close()
            $('#company_name').val(res.data.company_name);
            $('#company_margin').val(res.data.company_margin * 100);
            $('#company_money').val(res.data.money);
            if(res.data.withdraw_state == 0){
                $('#w_state').prop("checked",true)
            }else{
                $('#w_state2').prop("checked",true)
            }
            if(res.data.bank_mode == 0){
                $('#a_state1').prop("checked",true)
            }else if(res.data.bank_mode == 1){
                $('#a_state2').prop("checked",true)
            }else{
                $('#a_state3').prop("checked",true)
            }

            $('#save').data('id', ids); //저장
            $('#head_company_edit').modal('show');
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

$("#head_save").click(function () {
    Swal.fire({
        title:"잠시만 기다려주세요",
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
    let w_state ;
    let a_state ;
    if($('#w_state').is(":checked")){
        w_state = 0;
    }else if($('#w_state2').is(":checked")){
        w_state = 1;
    }
    if($('#a_state1').is(":checked")){
        a_state = 0;
    }else if($('#a_state2').is(":checked")){
        a_state = 1;
    }
    else if($('#a_state3').is(":checked")){
        a_state = 2;
    }
    $.ajax({
        type: "POST",
        url: "/api/v1/user/company_update",
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token"),
        },
        data:{
            mode: "head",
            id:ids,
            w_state : w_state,
            a_state : a_state,
            company_name : $('#company_name').val(),
            company_margin : $('#company_margin').val() / 100,
            company_money : $('#company_money').val(),
        },
        success: function (res) {
            alert('수정이 완료 되었습니다.')
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
});

$(".franchisee_edit").click(function () {
    ids = $(this).data("id");
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
        url: "/api/v1/user/get_company_data",
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token"),
        },
        data:{
            id:$(this).data("id")
        },
        success: function (res) {
            Swal.close()
            $('#franchisee_name').val(res.data.company_name);
            $('#franchisee_margin').val(res.data.company_margin * 100);
            $('#franchisee_money').val(res.data.money);
            if(res.data.withdraw_state == 0){
                $('#franchisee_w_state1').prop("checked",true)
            }else{
                $('#franchisee_w_state2').prop("checked",true)
            }
            if(res.data.bank_mode_int == 0){
                $('#franchisee_bank_mode_int1').prop("checked",true)
            }else if(res.data.bank_mode_int == 1){
                $('#franchisee_bank_mode_int2').prop("checked",true)
            }else{
                $('#franchisee_bank_mode_int3').prop("checked",true)
            }
            $('#save').data('id', ids); //저장
            $('#franchisee_edit').modal('show');
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

$("#franchisee_save").click(function () {
    Swal.fire({
        title:"잠시만 기다려주세요",
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
    let w_state ;
    let bank_mode_int ;
    if($('#franchisee_w_state1').is(":checked")){
        w_state = 0;
    }else if($('#franchisee_w_state2').is(":checked")){
        w_state = 1;
    }
    if($('#franchisee_bank_mode_int1').is(":checked")){
        bank_mode_int = 0;
    }else if($('#franchisee_bank_mode_int2').is(":checked")){
        bank_mode_int = 1;
    }
    else if($('#franchisee_bank_mode_int3').is(":checked")){
        bank_mode_int = 2;
    }
    $.ajax({
        type: "POST",
        url: "/api/v1/user/company_update",
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token"),
        },
        data:{
            mode: "franchisee",
            id:ids,
            w_state : w_state,
            bank_mode_int : bank_mode_int,
            company_name : $('#franchisee_name').val(),
            company_margin : $('#franchisee_margin').val() / 100,
            company_money : $('#franchisee_money').val(),
        },
        success: function (res) {
            alert('수정이 완료 되었습니다.')
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
});


