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
//关闭loading
function layer_close_load(){
    layer.closeAll('loading');
}
//验证手机
function check_mobile(mobile){
    return /^0?1[0-9]{10}$/.test(mobile);
}
//验证价格
function check_price(price){
    return /^\d+$/.test(price);
}
//验证联系人
function check_name(name){
    if(name.length>30){
        return false;
    }
    return /^([\u4E00-\u9FA5]|[A-Za-z])+$/i.test(name);
}