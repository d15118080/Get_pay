import { Token_Check,lang_kor } from './export.js';
Token_Check();
var date = new Date();
var yyyy = date.getFullYear();
var mm = date.getMonth()+1 > 9 ? date.getMonth()+1 : '0' + date.getMonth()+1;
var dd = date.getDate() > 9 ? date.getDate() : '0' + date.getDate();


$("input[type=date]").val(yyyy+"-"+mm+"-"+dd);

function calculate_history() {
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
        url: "/api/v1/user/calculate_history_data",
        data: {
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val()
        },
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token"),
            "Content-Type": "application/json",
        },
        success: function (data) {
            Swal.close()
                $('#calculate_history').DataTable({
                    language: lang_kor,
                    data: data.data.data,
                    destroy: true,

                    columns: [
                        {data: "id"},
                        {data: "company_name"},
                        {data: "calculate_money"},
                        {data: "calculate_to_money"},
                        {data: "fee"},
                        {data:"bank_name"},
                        {data:"bank_number"},
                        {data:"bank_owner"},
                        {data: "date_ymd"},
                        {data: "date_time"},
                        {data: "state"}
                    ],
                });
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
    calculate_history();
    $("#Lookup").on('click', function(event) {
        $('#calculate_history').DataTable().clear();
        calculate_history();
    });
});
