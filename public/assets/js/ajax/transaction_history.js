import { Token_Check,lang_kor } from './export.js';
Token_Check();
var yyyy = new Date().getFullYear();
var mm = new Date().getMonth()+1 > 9 ? new Date().getMonth()+1 : '0' + new Date().getMonth()+1;
var dd = new Date().getDate() > 9 ? new Date().getDate() : '0' + new Date().getDate();


$("input[type=date]").val(yyyy+"-"+mm+"-"+dd);

function transaction_history_data_init() {
    Token_Check();
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
        url: "/api/v1/user/transaction_history_data",
        data: {
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val(),
            company_id : $('#company_id').val()
        },
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token"),
            "Content-Type": "application/json",
        },
        success: function (data) {
            Swal.close()
            if(data.result.resultCd === "0000" || data.result.resultCd === "0001") {
                $('#admin_history').DataTable({
                    language: lang_kor,
                    data: data.data.data,
                    lengthMenu:[10,50,100,1000],
                    destroy: true,
                    order: [[0, 'desc']],
                    columns: [
                        {data: "id"},
                        {data: "transaction_key"},
                        {data: "company_name"},
                        {data: "transaction_money"},
                        {data: "transaction_user_name"},
                        {data: "head_fee"},
                        {data: "branch_fee"},
                        {data: "distributor_fee"},
                        {data: "franchisee_fee"},
                        {data: "franchisee_money"},
                        {data: "company_to_money"},
                        {data: "date_ymd"},
                        {data: "date_time"}
                    ],
                });
            }else if(data.result.resultCd === "0002"){
                $('#admin_history').DataTable({
                    language: lang_kor,
                    data: data.data.data,
                    destroy: true,
                    order: [[0, 'desc']],
                    lengthMenu:[10,50,100,1000],
                    columns: [
                        {data: "id"},
                        {data: "transaction_key"},
                        {data: "company_name"},
                        {data: "transaction_money"},
                        {data: "transaction_user_name"},
                        {data: "branch_fee"},
                        {data: "distributor_fee"},
                        {data: "franchisee_fee"},
                        {data: "franchisee_money"},
                        {data: "company_to_money"},
                        {data: "date_ymd"},
                        {data: "date_time"}
                    ],
                });
            }else if(data.result.resultCd === "0003"){
                $('#admin_history').DataTable({
                    language: lang_kor,
                    data: data.data.data,
                    lengthMenu:[10,50,100,1000],
                    destroy: true,
                    order: [[0, 'desc']],
                    columns: [
                        {data: "id"},
                        {data: "transaction_key"},
                        {data: "company_name"},
                        {data: "transaction_money"},
                        {data: "transaction_user_name"},
                        {data: "distributor_fee"},
                        {data: "franchisee_fee"},
                        {data: "franchisee_money"},
                        {data: "company_to_money"},
                        {data: "date_ymd"},
                        {data: "date_time"}
                    ],
                });
            }else if(data.result.resultCd === "0004"){
                $('#admin_history').DataTable({
                    language: lang_kor,
                    data: data.data.data,
                    lengthMenu:[10,50,100,1000],
                    destroy: true,
                    order: [[0, 'desc']],
                    columns: [
                        {data: "id"},
                        {data: "transaction_key"},
                        {data: "company_name"},
                        {data: "transaction_money"},
                        {data: "transaction_user_name"},
                        {data: "franchisee_fee"},
                        {data: "franchisee_money"},
                        {data: "company_to_money"},
                        {data: "date_ymd"},
                        {data: "date_time"}
                    ],
                });
            }else{
                $('#admin_history').DataTable({
                    language: lang_kor,
                    data: data.data.data,
                    lengthMenu:[10,50,100,1000],
                    destroy: true,
                    columns: null,
                });
            }
            $('#sum').text(data.data.sum)
            $('#count').text(data.data.count)
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


$(document).ready(function() {
    transaction_history_data_init();
    $("#Lookup").on('click', function(event) {
        $('#admin_history').DataTable().clear();
        transaction_history_data_init();
    });
});
