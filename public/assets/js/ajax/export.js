function Token_Check() {
    $.ajax({
        type: "get",
        url: "/api/v1/user/token_check",
        headers: {
            Authorization: "Bearer " + $.cookie("X-Token"),
            "Content-Type": "application/json",
        },
        success: function (res) {
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("로그인 정보가 만료 되었습니다.");
            location.replace('/login')
        },
    });
}
let lang_kor = {
    "decimal" : "",
    "emptyTable" : "데이터가 존재하지 않습니다.",
    "info" : "총 _TOTAL_ 개 의 데이터",
    "infoEmpty" : "0 개의 데이터",
    "infoFiltered" : "(전체 _MAX_ 개 중 검색결과)",
    "infoPostFix" : "",
    "thousands" : ",",
    "lengthMenu" : "_MENU_ 개씩 보기",
    "loadingRecords" : "불러오는중...",
    "processing" : "처리중...",
    "search" : "검색 : ",
    "zeroRecords" : "검색된 데이터가 없습니다.",
    "paginate" : {
        "first" : "첫 페이지",
        "last" : "마지막 페이지",
        "next" : "다음",
        "previous" : "이전"
    },
    "aria" : {
        "sortAscending" : " :  오름차순 정렬",
        "sortDescending" : " :  내림차순 정렬"
    }
};

export {
    Token_Check,lang_kor
};
