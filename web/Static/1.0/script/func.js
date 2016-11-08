/**
 * Created by dower on 2016/7/19 0019.
 */
//弹窗提醒
function layer_msg(msg,time){
    if(typeof time == 'undefined') time=2000;
    layer.msg(msg,{
        time:time
    });
}
//loading
function layer_load(){
    layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
}
//成功失败弹窗
function layer_success(msg,time){
    if(typeof time == 'undefined') time=1500;
    layer.msg(msg,{
        time:time,
        icon:1
    })
}
function layer_error(msg,time){
    if(typeof time == 'undefined') time=1500;
    layer.msg(msg,{
        time:time,
        icon:2
    })
}
//关闭loading
function layer_close_load(){
    layer.closeAll('loading');
}
//验证手机-- 默认只验证手机
function check_mobile(mobile,type){
    if(typeof type == 'undefined') type=1;
    var reg = '';
    if(type){
        reg = /^(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])\d\d\d\d\d\d\d\d$/i;//电话和手机
    }else{
        reg = /^0?1\d{10}$/;
    }
    return reg.test(mobile);
}
//验证价格
function check_price(price,type){
    return /^[123456789](\d)*$/.test(price);
}
//验证联系人
function check_name(name){
    if(name.length>30){
        return false;
    }
    return /^([\u4E00-\u9FA5]|[A-Za-z])+$/i.test(name);
}
//验证商标
function check_tm(tm){
    return /^[0-9a-zA-Z]+$/.test(tm);
}
//验证专利号
function check_pt(pt){
    return /^([a-zA-Z]{2})?\d+(\.[\dxX])?$/.test(pt);
}