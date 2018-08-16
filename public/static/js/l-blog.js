document.body.onload = function () {
    init();
    $('#phone-nav-cat').click(function () {
        $('.layui-nav-tree').toggle(400);
        if ($('.J-qcTopNavMenu').hasClass('toggle-animate')) {
            $('.J-qcTopNavMenu').removeClass('toggle-animate');
            $('.phone-nav-icon').show(400);
        } else {
            $('.J-qcTopNavMenu').addClass('toggle-animate');
            $('.phone-nav-icon').hide(400);
            $('.layui-nav-bar').css('width', '0');
        }
    });
    $('#pc-nav-login').mouseover(function () {
        $('.login_icon').attr('src', '/static/images/login-white.svg');
    });
    $('#pc-nav-login').mouseout(function () {
        $('.login_icon').attr('src', '/static/images/login-gray.svg');
    });
    $('#pc-nav-login').click(function () {
        loginShow();
    });
    $('#pc-nav-register').mouseover(function () {
        $('.register_icon').attr('src', '/static/images/register-white.svg');
    });
    $('#pc-nav-register').mouseout(function () {
        $('.register_icon').attr('src', '/static/images/register-gray.svg');
    });
    $('#pc-nav-register').click(function () {
        registerShow();
    });
    $('.art_thu_img').css('height', $('.art_thu_img').width() * 2 / 3);
    layui.use(['carousel', 'util', 'flow'], function () {
        let carousel = layui.carousel;
        //建造实例
        carousel.render({
            elem: '#repeat_img',
            width: '100%',//设置容器宽度
            arrow: 'always',//始终显示箭头
        });
        let util = layui.util;
        util.fixbar({
            showHeight: 50,
            bgcolor: 'rgba(0, 0, 0, 0.4)',
        });
        let span_objs = document.getElementsByClassName('article-time');
        for (let i = 0, len = span_objs.length; i < len; i++) {
            span_objs[i].innerText = util.timeAgo(new Date(span_objs[i].getAttribute('data')).getTime());
        }

        let flow = layui.flow;
        flow.lazyimg();
    });
    page();
};

window.onresize = function () {
    $('.art_thu_img').css('height', $('.art_thu_img').width() * 2 / 3);
};

function init() {
    $('.art_thu_img').css('height', $('.art_thu_img').width() * 2 / 3);
    layui.use(['flow'], function () {
        let flow = layui.flow;
        flow.lazyimg();
    });
}

function addBookmark(url, title) {
    if (!url) {
        url = window.location
    }
    if (!title) {
        title = document.title
    }
    let browser = navigator.userAgent.toLowerCase();
    if (window.sidebar) { // Mozilla, Firefox, Netscape
        window.sidebar.addPanel(title, url, "");
    } else if (window.external) { // IE or chrome
        if (browser.indexOf('chrome') == -1) { // ie
            window.external.AddFavorite(url, title);
        } else { // chrome
            layer.msg('请使用按键 CTRL+D (MacBook使用 Command+D ) 收藏本站');
        }
    }
    else if (window.opera && window.print) { // Opera - automatically adds to sidebar if rel=sidebar in the tag
        return true;
    }
    else if (browser.indexOf('konqueror') != -1) { // Konqueror
        layer.msg('请使用按键 CTRL+B 收藏本站');
    }
    else if (browser.indexOf('webkit') != -1) { // safari
        layer.msg('请使用按键 CTRL+B (MacBook使用 Command+D ) 收藏本站');
    } else {
        layer.msg('请手动将本站加入书签');
    }
}

function loginShow() {
    try {
        let index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    } catch (e) {

    }
    parent.layer.open({
        type: 2,
        title: '邮箱登录',
        content: '/home/user/loginByEmail',
        resize: false,
        scrollbar: false,
        area: ['315px', '350px'],
    });
}

function loginByPwdShow() {
    try {
        let index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    } catch (e) {

    }
    parent.layer.open({
        type: 2,
        title: '密码登陆',
        content: '/home/user/loginByPwd',
        resize: false,
        scrollbar: false,
        area: ['315px', '350px'],
    });
}

function getMainHtml(obj) {
    let index = layer.load(1);
    let res = ajax(null, typeof obj == 'string' ? obj : obj.getAttribute('data-url'), 'get');
    if (res) {
        document.getElementById('main').innerHTML = res;
        init();
        page();
    }
    layer.close(index);
}

function page() {
    layui.use(['laypage'], function () {
        let count = 0, limit = 10, url = '', curr = 1;
        try {
            count = document.getElementById('count').value;
            curr = document.getElementById('curr').value;
            limit = document.getElementById('limit').value;
            url = document.getElementById('url').value;
        } catch (e) {
        }
        let laypage = layui.laypage;
        laypage.render({
            elem: 'page',
            curr: curr,
            count: count,
            limit: limit,
            layout: ['prev', 'first', 'page', 'last', 'next'],
            jump: function (obj, first) {
                //首次不执行
                if (!first) {
                    getMainHtml(url + '?page=' + obj.curr + '&list_row=' + obj.limit);
                }
            }
        });
    });
}