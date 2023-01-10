import { Token_Check,lang_kor } from './export.js';
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
        url: "/api/v1/user/accounts_history_data",
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token")
        },
        success: function (data) {
            Swal.close()
                $('#account_history').DataTable({
                    language: lang_kor,
                    data: data.data,
                    destroy: true,
                    order: [[0, 'desc']],
                    columns: [
                        {data: "id"},
                        {data: "user_name"},
                        {data: "account_number"},
                        {data: "bank_name"},
                        {data: "account_state"},
                        {data: "date_ymd"},
                        {data: "total_count"},
                        {data: "total_money"},
                        {data: "last_update"}
                    ],
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


