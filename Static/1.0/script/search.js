/**
 * Created by dower on 2016/7/22 0022.
 */
$('#pt_search').click(function(){
    layer_load();
    var kw = $.trim($('#pt_kw').val());
    //验证空
    if(kw=='请输入您要搜索的专利名或专利号' || kw==''){
        layer.tips('请输入您要搜索的专利名或专利号', $('#pt_kw'), {
            tips: [3, '#fc7d28'],
            time: 2000
        });
        layer_close_load();
        return false;
    }
    //验证特殊字符
    var reg = /^([\u4E00-\u9FA5]|[A-Za-z0-9\.])+$/i;//中文英文数字点
    if(reg.test(kw)==false){
        layer.tips('不要输入特殊字符哦', $('#pt_kw'), {
            tips: [3, '#fc7d28'],
            time: 2000
        });
        layer_close_load();
        return false;
    }
    //验证长度
    if(kw.length >=30){
        layer.tips('只搜索前30个字符哦，请稍等...', $('#pt_kw'), {
            tips: [3, '#fc7d28'],
            time: 2000
        });
        kw = kw.substr(0, 30);
    }
    //提交数据
    window.location.href = '/ptsearch/index/?kw='+kw;
});

//商标搜索
$('#td_search').click(function(){
    layer_load();
    var kw = $.trim($('#td_kw').val());
    //验证空
    if(kw=='请输入您要搜索的商标名或商标号' || kw==''){
        layer.tips('请输入您要搜索的商标名或商标号', $('#td_kw'), {
            tips: [3, '#fc7d28'],
            time: 2000
        });
        layer_close_load();
        return false;
    }
    //验证特殊字符
    var reg = /^([\u4E00-\u9FA5]|[A-Za-z0-9\.])+$/i;//中文英文数字点
    if(reg.test(kw)==false){
        layer.tips('不要输入特殊字符哦', $('#td_kw'), {
            tips: [3, '#fc7d28'],
            time: 2000
        });
        layer_close_load();
        return false;
    }
    //验证长度
    if(kw.length >=30){
        layer.tips('只搜索前30个字符哦，请稍等...', $('#td_kw'), {
            tips: [3, '#fc7d28'],
            time: 2000
        });
        kw = kw.substr(0, 30);
    }
    //提交数据
    $("#trademarkfrom").submit();
});