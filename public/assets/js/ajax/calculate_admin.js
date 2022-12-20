import { Token_Check,lang_kor } from './export.js';
Token_Check();

$(document).ready(function() {
    $('#calculate_history').DataTable({language: lang_kor,order: [[0, 'desc']],});
});
let id;
let mode;

$(".calculate_state_change").click(function () {
    id = $(this).data("id")
    mode = $(this).data("mode")

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
        url: "/api/v1/user/calculate_state_change",
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token"),
        },
        data:{
            id:id,
            mode:mode
        },
        success: function (res) {
            alert('처리 되었습니다')
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
