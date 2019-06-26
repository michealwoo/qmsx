define(['core', 'tpl'], function (core, tpl) {
    var modal = {};
    modal.initLogin = function (params) {
        modal.backurl = params.backurl;
        $(".btn-submit").unbind('click').click(function () {
            var _this = $(this);
            if (modal.stop) {
                return
            }
            var obj = {};
            if (modal.backurl) {
                obj.backurl = modal.backurl
            }
            var type = _this.data('type');
            if (!type) {
                var username = $.trim($("#username").val());
                var password = $.trim($("#password").val());
                if (username == '') {
                    FoxUI.toast.show("请输入用户名");
                    return
                }
                if (password == '') {
                    FoxUI.toast.show("请输入密码");
                    return
                }
                obj.username = username;
                obj.password = password;
                modal.loginPost(obj)
            } else {
                obj.password = password;
                var obj = {type: "wechat"};
                FoxUI.confirm("确认使用此微信号绑定的操作员身份登录吗？", function () {
                    modal.loginPost(obj)
                })
            }
        })
    };
    modal.loginPost = function (obj) {
        if (!obj || modal.stop) {
            return
        }
        modal.stop = true;
        FoxUI.loader.show("loading");
        core.json('mmanage/login', obj, function (json) {
            setTimeout(function () {
                if (json.status == 1) {
                    if (json.result.backurl) {
                        location.href = json.result.backurl
                    } else {
                        location.href = core.getUrl('mmanage')
                    }
                } else {
                    FoxUI.loader.hide();
                    FoxUI.toast.show(json.result.message);
                    modal.stop = false
                }
            }, 300)
        }, false, true)
    };
    modal.initHome = function () {
        core.json('mmanage/get_today', {}, function (json) {
            if (json.status == 1) {
                $("#today_count").text(json.result.today_count);
                $("#today_price").text(json.result.today_price);
                $("#today_member").text(json.result.today_member)
            }
        });
        core.json('mmanage/get_order', {}, function (json) {
            if (json.status == 1) {
                $("#status_1").text(json.result.status1);
                $("#status_0").text(json.result.status0);
                $("#status_4").text(json.result.status4)
            }
        });
        core.json('mmanage/get_shop', {}, function (json) {
            if (json.status == 1) {
                $("#goods_count").text(json.result.goods_count);
                $("#member_count").text(json.result.member_count)
            }
        });
        if ($(".index-notice").length > 0) {
            var _this = $(".index-notice");
            var speed = 3000;
            setInterval(function () {
                var length = _this.find("li").length;
                if (length > 1) {
                    _this.find("ul").animate({marginTop: "-1rem"}, 500, function () {
                        $(this).css({marginTop: "0px"}).find("li:first").appendTo(this)
                    })
                }
            }, speed)
        }
    };
    modal.initPerson = function () {
        $("#btn-submit").unbind('click').click(function () {
            if (modal.stop) {
                return
            }
            var realname = $.trim($("#realname").val());
            var mobile = $.trim($("#mobile").val());
            var password = $.trim($("#password").val());
            var password2 = $.trim($("#password2").val());
            if (realname == '') {
                FoxUI.toast.show("请输入真实姓名");
                return
            }
            if (mobile == '') {
                FoxUI.toast.show("请输入手机号");
                return
            }
            if (password != '' || password2 != '') {
                if (password == '') {
                    FoxUI.toast.show("请输入密码");
                    return
                }
                if (password2 == '') {
                    FoxUI.toast.show("请重复输入密码");
                    return
                }
                if (password != password2) {
                    FoxUI.toast.show("两次输入的密码不一致");
                    return
                }
            }
            modal.stop = true;
            var obj = {realname: realname, mobile: mobile, password: password, password2: password2};
            core.json('mmanage/set', obj, function (json) {
                if (json.status == 1) {
                    FoxUI.toast.show("保存成功");
                    if (json.result.changepass) {
                        location.href = core.getUrl('mmanage/login');
                        return
                    }
                } else {
                    FoxUI.toast.show(json.result.message)
                }
                modal.stop = false
            }, true, true)
        });
        $("#btn-logout").unbind('click').click(function () {
            if (modal.stop) {
                return
            }
            FoxUI.confirm("当前已登录，确认要退出吗？", function () {
                core.json('mmanage/login/logout', {}, function () {
                    location.href = core.getUrl('mmanage')
                }, true, true)
            })
        })
    };
    modal.initShop = function () {
        $("#file-shoplogo").change(function () {
            var fileid = $(this).attr('id');
            FoxUI.loader.show('mini');
            $.ajaxFileUpload({
                url: core.getUrl('util/uploader'),
                data: {file: fileid},
                secureuri: false,
                fileElementId: fileid,
                dataType: 'json',
                success: function (res) {
                    if (res.error == 0) {
                        $("#shoplogo").val(res.filename);
                        $("#showlogo").attr('src', res.url)
                    } else {
                        FoxUI.toast.show("上传失败请重试")
                    }
                    FoxUI.loader.hide();
                    return
                }
            })
        });
        $("#btn-submit").unbind('click').click(function () {
            if (modal.stop) {
                return
            }
            var shopname = $.trim($("#shopname").val());
            var shopdesc = $.trim($("#shopdesc").val());
            var shoplogo = $.trim($("#shoplogo").val());
            var shopclose = $("#shopclose").is(':checked') ? 1 : 0;
            if (shopname == '') {
                FoxUI.toast.show("请填写商城名称");
                return
            }
            modal.stop = true;
            var obj = {shoplogo: shoplogo, shopname: shopname, shopdesc: shopdesc, shopclose: shopclose};
            core.json('mmanage/shop', obj, function (json) {
                if (json.status == 1) {
                    FoxUI.toast.show("保存成功")
                } else {
                    FoxUI.toast.show(json.result.message)
                }
                modal.stop = false
            }, true, true)
        })
    };
    return modal
});