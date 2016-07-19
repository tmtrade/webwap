/**
 * Created by dower on 2016/7/19 0019.
 */
function layer_msg(msg,time){
    if(typeof time == 'undefined') time=2000;
    layer.msg(msg,{
        time:time
    });
}