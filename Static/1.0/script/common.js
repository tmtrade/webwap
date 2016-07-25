
//切换移动端和PC端的点击事件
//function isMobile(){
// var sUserAgent= navigator.userAgent.toLowerCase(),
// bIsIpad= sUserAgent.match(/ipad/i) == "ipad",
// bIsIphoneOs= sUserAgent.match(/iphone os/i) == "iphone os",
// bIsMidp= sUserAgent.match(/midp/i) == "midp",
// bIsUc7= sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4",
// bIsUc= sUserAgent.match(/ucweb/i) == "ucweb",
// bIsAndroid= sUserAgent.match(/android/i) == "android",
// bIsCE= sUserAgent.match(/windows ce/i) == "windows ce",
// bIsWM= sUserAgent.match(/windows mobile/i) == "windows mobile",
// bIsWebview = sUserAgent.match(/webview/i) == "webview";
// return (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM);
//}
//var tap;
//tap = isMobile() ? 'tap' : 'click';
//
//$("body").click(function(){
//    alert("11");
//})
//选项卡函数
function jc(name,curr,n)
    {
        for(i=1;i<=n;i++)
        {
            var menu=document.getElementById(name+i);
            var cont=document.getElementById("con_"+name+"_"+i);
        menu.className=i==curr ? "on" : "";
        if(i==curr){
            cont.style.display="block";    
        }else{
            cont.style.display="none";    
        }
    }
}
//解决zepto的点头事件
window.addEventListener( "load", function() {
     FastClick.attach( document.body );
}, false );

//阻止默认事件执行的函数

 function stopPropagation(e) {
    if (e.stopPropagation) 
        e.stopPropagation();
    else 
        e.cancelBubble = true;
}

//顶部点击菜单出现弹窗；
//顶部点击菜单出现弹窗；
var  tapCount;
tapCount=0;
$("#menu").on('click',function(){
	tapCount++;
	if(tapCount==2){
        $("#menu-box").addClass("slideInDown animated infinite");
		$("#menu-box").css({"display":"block"});
		$(document).on('click',function(){
            $("#menu-box").removeClass("slideInDown animated infinite");
		    $("#menu-box").hide();
		    tapCount=1;
		});
	}
	if(tapCount==4){
        $("#menu-box").removeClass("slideInDown animated infinite");
		$("#menu-box").hide();
		tapCount=0;
	}
})



$("#menu,#menu-box").on('click',function(e){
    stopPropagation(e);
});


//关闭共用谈话框
$("#gb-btn").on('click',function(){
	$(this).parent().hide();
})

//聊天函数
function goChat(){
    window.open("http://p.qiao.baidu.com/im/index?siteid=7918603&ucid=1268165");
}
//购买商品--func成功的回调---- 允许重复
function buyGoods(data,func){
    ucNetwork.submitData(data,func);
}
//提交信息回调
function submitDataCallback(obj,func){
    $.each(obj,function(i,n){
        if(n.code==-1){
            layer.msg('key验证失败',{
                time:1500,
                icon:2
            },function(){
                location.reload();
            })
        }else if(n.code!=0 && n.data.netcode==1){
            if(typeof func=='function') func();
            //弹出成功框
            layer_success('提交成功');
        }else{
            //弹出失败框
            layer_error('提交失败');
        }
        layer_close_load();
    });
}