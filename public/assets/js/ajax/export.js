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

export {
    Token_Check,
};
