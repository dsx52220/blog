//各种验证

/**
 * 邮箱验证
 * @param email
 * @return {boolean,string} true:验证成功,string:错误信息
 */
function checkEmail(email) {
    let reg = new RegExp("^([a-zA-Z0-9]+[-_.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[-_.]?)*[a-zA-Z0-9]+\\.[a-zA-Z]{2,6}$"); //正则表达式
    if (email == '') { //输入不能为空
        return '邮箱不能为空';
    } else if (!reg.test(email)) { //正则验证不通过，格式不对
        return '邮箱格式不正确';
    } else {
        return true;
    }
}

function checkUsername(username) {
    if (username == '') {
        return '用户名/邮箱不能为空';
    }
    return true;
}

function checkPwd(password) {
    if (password.length < 6) {
        return '密码不少于6位';
    }
    return true;
}

function checkCaptcha(captcha) {
    if (captcha.length != 4) {
        return '验证码为4位';
    }
    return true;
}