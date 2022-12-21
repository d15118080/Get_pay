import {Token_Check} from './export.js';

Token_Check();

let editor;
ClassicEditor.create(document.querySelector('.ckeditor-classic'), {
    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
    language: 'ko'
})
    .then(newEditor => {
        editor = newEditor;
    })
    .catch(error => {
        console.error(error);
    });


$("#noti_add").click(function () {
    Swal.fire({
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
    $.ajax({
        type: "POST",
        url: "/api/v1/user/noti_add",
        data: {
            noti_title: $("#noti_title").val(),
            noti_text:editor.getData(),
        },
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token")
        },
        success: function (res) {
            alert('작성 되었습니다.')
            location.reload()
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
