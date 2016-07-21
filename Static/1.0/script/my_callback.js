/**
 * 回调函数--模板
 * Created by dower on 2016/7/20 0020.
 */
//通用 code==-1   key验证失败
//数据提交到分配系统
function submitDataCallback(obj){
    //obj.code = 0; //格式错误
    //
    //obj.code = 1; //账户不存在
    //obj.code = 2; //账户存在
    //obj.data.netcode = 1;//写入成功
    //obj.data.netcode = 0;//写入失败
}

//用户登录回调（直接传入用户和密码）
function userLogCallback(obj,data){
    //obj.code = 1;//成功
    //obj.code = 2;//账户不存在
    //obj.code = 3;//密码错误
}

//发送验证码
function sendCodeCallback(obj,htmlobj,title){
    //obj.code = 1;//成功
    //obj.code = 0;//失败
    //obj.code = 3;//账户格式(手机号码)错误
    //if(n.code == 1){//发送成功
    //    timer(60, htmlobj, title);//倒计时
    //}else{
    //    alert(n.msg);
    //}
}

//验证验证码是否合法
function verifyCodeCallback(obj,account,code){
    //obj.code = 2;//失败        obj.mess 提示信息
    //obj.code = 1;//成功
    //if(obj.code==1){
    //    ucNetwork.logCode(account,code);//登录
    //}else{
    //    alert(n.mess);
    //}
}

//验证是否登录
function verifyLogCallback(obj){
    //obj.code = 1;//登录
    //obj.code = 0;//未登录
}

//验证用户是否存在
function verifyUserCallback(obj){
    //obj.code = 1;//用户存在
    //obj.code = 2;//用户不存在
}

//修改密码
function editPasswordCallback(obj){
    //obj.code = 0;//失败
    //obj.code = 3;//账户错误
    //obj.code = 1;//成功
}

//购买商标
function buyAddCallback(obj,func){
    //obj.code = 0;//已添加
    //obj.code = 1;//成功
    //obj.code = 2;//失败
    //func 传过来的函数
}

//验证是否购买过商标
function isexistCallback(obj,data){
    //obj.code = 1;//没添加
    //obj.code = 2;//已添加
}

//退出
function logexitCallback(){
    //自己的业务逻辑, 直接执行
}