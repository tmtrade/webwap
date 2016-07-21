/**
 * 蝉窝跨域登录js
 * Created by dower on 2016/7/20 0020.
 */

//-- 配置相关
//var HOST = 'http://my.test.chofn.net';//处理域名 定义到js引用外
var configUrl = '';//配置信息
var uckeystr = 'uc_ukey';//cookie
var ucnamestr = 'uc_nickname';
var ucmobile = 'uc_mobile';
var ucid = 'uc_identify';
var isSendCode = true;//验证码
var ucConfig = {
    //设置配置
    setConfig : function(time,key1,key2){
        configUrl= '&timestamp='+time+'&nonceStr='+key1+'&signature='+key2;
    },
    //获取配置
    getConfigUrl : function(){
        return configUrl;
    },
    //把需要提交的数据设置成URL连接
    setPostUrl : function(data){
        if(typeof data != 'object') data = [];
        var url	 = '';
        for( var k in data ){
            url+='&'+k+'='+data[k];
        }
        return url+configUrl;
    }
};
//-- 检测登录状态,退出
var ucUser = {
    //验证是否登录
    verifyLog : function(){
        var url = ucConfig.setPostUrl();
        var	ObjJsonp = '';
        $.ajax({
            type : "GET",
            url : HOST+"/login/verifyLog/?"+url,
            dataType : "jsonp",
            jsonp : 'callback',
            complete : function(xhr,status){
                verifyLogCallback(ObjJsonp);
            },
            error		: function(msg){},
            success 	: function(json){
                $.each(json,function(i,n){
                    //cookie操作
                    if(n.ukey){
                        addUserCook(n.ukey,n.nickname,n.usermobile,n.id);
                    }else{
                        delteUserCook();
                    }
                });
                ObjJsonp = json;
            }
        });
    },
    //退出
    logexit:function(isload){
        if(typeof isload == 'undefined') isload = 1;//是否刷新页面
        var url = ucConfig.setPostUrl();
        //删除服务器登录认证
        $.ajax({
            type : "GET",
            url : HOST+"/login/logout/?"+url,
            dataType : "jsonp",
            jsonp : 'callback',
            error : function(msg){},
            success : function(json){
                //删除本地cookie设置
                delteUserCook();
                if( isload == 1 ){
                    window.location.reload();
                }
                //是否设置回调
                if(typeof logexitCallback == 'function') logexitCallback();
            }
        });
    }
};
//-- 是否自动检测登录状态
//$(function(){
//    //检测登录   ucUser.verifyLog();
//    //绑定退出事件 ucUser.logexit();
//});
//-- 登录相关
var ucNetwork = {
    //数据提交到分配系统
    submitData : function(data){
        //验证参数
        var remindArray = verifyPost(data);
        if( remindArray['code'] != 1 ){
            return remindArray;
        }
        //提交数据
        var url = ucConfig.setPostUrl(data);
        var	ObjJsonp = '';
        $.ajax({
            type : "post",
            url : HOST+"/login/networkLogin/?"+url,
            dataType : "jsonp",
            async : false,
            data : {},
            complete : function(xhr,status){
                submitDataCallback(ObjJsonp);
            },
            error : function(msg){},
            success	: function(json){
                ObjJsonp = json;
            }
        });
    },
    //用户登录(用密码登录)
    userLog	 : function(account,password,data){
        //验证参数
        if(!account){
            return false;
        }
        if(!password){
            return false;
        }
        //得到账户类型
        var cateId  = getUserType(account);
        if(cateId==0){
            return false;
        }
        //提交数据
        var	ObjJsonp = '';
        var url = ucConfig.setPostUrl();
        $.ajax({
            type : "post",
            url : HOST+"/login/login/?"+url,
            dataType : "jsonp",
            data : { 'account':account, 'password':password, 'cateId':cateId},
            complete : function(xhr,status){
                userLogCallback(ObjJsonp,data);
            },
            error : function(msg){},
            success	: function(json){
                $.each(json,function(i,n){
                    if(n.ukey){
                        //设置用户cookie
                        addUserCook(n.ukey,n.nickname,n.usermobile,n.id);
                    }
                });
                ObjJsonp = json;
            }
        });
    },
    //发送验证码
    sendCode : function(account,obj,title){
        //验证参数
        if(!account){
            return false;
        }
        if(isSendCode == false){
            return false;
        }
        //发送验证码
        var	ObjJsonp = '';
        var url = ucConfig.setPostUrl();
        $.ajax({
            type : "post",
            url : HOST+"/login/sendCode/?"+url,
            dataType : "jsonp",
            data : { 'account':account, 'cateId':2},
            complete : function(xhr,status){
                sendCodeCallback(ObjJsonp,obj,title);
            },
            error		: function(msg){},
            success	: function(json){
                ObjJsonp = json;
            }
        });
    },
    //验证验证码是否合法
    verifyCode : function(account,code){
        var url = ucConfig.setPostUrl();
        var	ObjJsonp = '';
        $.ajax({
            type : "post",
            url : HOST+"/login/verifyCode/?"+url,
            dataType : "jsonp",
            data : { 'account':account, 'password':code, 'cateId':2},
            complete : function(xhr,status){
                verifyCodeCallback(ObjJsonp,account,code);
            },
            error		: function(msg){},
            success	: function(json){
                ObjJsonp = json;
            }
        });
    },
    //用验证码登录
    logCode : function(account,password){
        var cateId = getUserType(account);
        if(cateId==0){
            return false;
        }
        var url = ucConfig.setPostUrl();
        var	ObjJsonp = '';
        $.ajax({
            type : "POST",
            url : HOST+"/login/remoteUser/?"+url,
            dataType : "jsonp",
            data : {"account" : account,"password" : password,"cateId" : cateId},
            jsonp : 'callback',
            complete : function(xhr,status){
                //logCodeCallback(ObjJsonp);
            },
            success : function(json){
                $.each(json,function(i,n){
                    if(n.code==1 && n.ukey){
                        addUserCook(n.ukey,n.nickname,n.usermobile,n.id);
                        window.location.reload();
                    }
                });
                ObjJsonp = json;
            }
        });
    },
    //验证是否登录
    verifyLog : function(){
        var url = ucConfig.setPostUrl();
        var	ObjJsonp = '';
        $.ajax({
            type 		: "GET",
            url 		: HOST+"/login/verifyLog/?"+url,
            dataType 	: "jsonp",
            jsonp		: 'callback',
            complete	: function(xhr,status){
                verifyLogCallback(ObjJsonp);
            },
            error		: function(msg){},
            success 	: function(json){
                $.each(json,function(i,n){
                    if(n.ukey){
                        addUserCook(n.ukey,n.nickname,n.usermobile,n.id);
                    }else{
                        delteUserCook();
                    }
                });
                ObjJsonp = json;
            }
        });
    },
    //验证用户是否存在
    verifyUser : function(account){
        var  url = ucConfig.setPostUrl();
        var	ObjJsonp = '';
        $.ajax({
            type : "post",
            url : HOST+"/login/verifyUser/"+url,
            dataType : "jsonp",
            data : { 'account' : account,'cateId' : 2},
            complete : function(xhr,status){
                verifyUserCallback(ObjJsonp);
            },
            error		: function(msg){},
            success	: function(json){
                ObjJsonp = json;
            }
        });
    },
    //修改密码
    editPassword : function(account){
        var url = ucConfig.setPostUrl();
        $.ajax({
            type : "GET",
            url : HOST+"/login/backPassword/?"+url,
            dataType : "jsonp",
            jsonp : 'callback',
            data : { 'account' : account},
            complete : function(xhr,status){
                editPasswordCallback(ObjJsonp);
            },
            error		: function(msg){},
            success 	: function(json){
                ObjJsonp = json;
            }
        });
    }
};
//--购买商标
var ucBuy = {
    //购买商标
    buyAdd : function(data,fun){
        var	ObjJsonp = '';
        var url = ucConfig.setPostUrl(data);
        $.ajax({
            type : "post",
            url : HOST+"/buybrand/buyBrandAdd/?"+url,
            dataType : "jsonp",
            async : false,
            data : data,
            complete : function(xhr,status){
                buyAddCallback(ObjJsonp,fun);
            },
            error : function(msg){
            },
            success	: function(json){
                ObjJsonp = json;
            }
        });
    },
    /**
     * 是否购买商标
     * @param num 商标号
     * @param strclass 类别
     * @param tel 电话
     * @param datas 数据包
     */
    isexist : function(num,strclass,tel,datas){
        var	ObjJsonp = '';
        var url = ucConfig.setPostUrl();
        $.ajax({
            type : "post",
            url : HOST+"/buybrand/buyExist/?"+url,
            dataType : "jsonp",
            async : false,
            data : {"trademark" : num,"class" :　strclass,"tel" : tel},
            complete : function(xhr,status){
                isexistCallback(ObjJsonp,datas);
            },
            error : function(msg){},
            success	: function(json){
                ObjJsonp = json;
            }
        });
    }
};
//-- 工具函数
//验证提交来的数据是否完整
function verifyPost(data){
    var configArray	= ['tel','name','subject','remarks','trademark','class','tid','pttype','type','ptype'];
    var remindArray	= [];
    for( var k in data ){
        var isKey = $.inArray(k,configArray);
        if( isKey < 0 ){
            remindArray['code'] = 0;
            remindArray['msg'] 	= '缺少关键词'+k;
            break;
        }else{
            remindArray['code'] = 1;
            remindArray['msg'] 	= '验证通过';
        }
    }
    return remindArray;
}
//验证是否手机
function isMobile(mobile){
    return /^1\d{10}$/i.test(mobile);
}
//验证邮箱
function isEmail(email){
    return /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(email);
}
//获取账号类型
function getUserType(string){
    if(isMobile(string)){
        return 2;
    }
    if(isEmail(string)){
        return 1;
    }
    return 0;
}
//获取验证提示
function getError(code){
    var msgJs = '';
    switch(code){
        case 0:
            msgJs = '账号格式不正确';
            break;
        case 1:
            msgJs = '成功';
            break;
        case 2:
            msgJs = '账号不存在';
            break;
        case 3:
            msgJs = '密码错误';
            break;
        case 4:
            msgJs = '验证码错误';
            break;
        default:
            msgJs = '登录失败，请稍后登录';
    }
    return msgJs;
}
//设置用户信息cook
function addUserCook(key,name,utel,uid,times){
    times = times ? times : validTime;
    addCookie(uckeystr,key,times);
    if(name){
        addCookie(ucnamestr,name,times);
    }
    if(utel){
        addCookie(ucmobile,utel,times);
    }
    if(uid){
        addCookie(ucid,uid,times);
    }
}
//删除用户信息cook
function delteUserCook(){
    delCookie(uckeystr);
    delCookie(ucnamestr);
    delCookie(ucmobile);
    delCookie(ucid);
}
//cookie操作
function addCookie(objName,objValue,objHours){
    var str = objName + "=" + escape(objValue);
    if(objHours > 0){
        var date 	= new Date();
        var ms 		= objHours*3600*1000;
        date.setTime(date.getTime() + ms);
        str += "; expires=" + date.toGMTString();
    }
    var cook=str+";path=/";
    document.cookie = cook;
}
function getCookie(name){
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
    if(arr != null) return unescape(arr[2]); return null;
}
function delCookie(name){
    var date = new Date();
    date.setTime(date.getTime() - 10000);
    document.cookie = name + "=a; expires=" + date.toGMTString()+";path=/";
}
//倒计时
function timer(count, obj, title){
    window.setTimeout (function () {
        count --;
        tyep = obj.attr('input');
        obj.text('已发送'+count + "秒后可重新获取");
        obj.val('已发送'+count + "秒后可重新获取");
        if(count > -1){
            isSendCode = false;
            obj.removeClass('mj_wxcodew').addClass('mj_wxcodef');
            timer(count, obj, title);
        }else{
            obj.text(title);
            obj.val(title);
            isSendCode = true;
            obj.removeClass('mj_wxcodef').addClass('mj_wxcodew');
        }
    },1000);
}
