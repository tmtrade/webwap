
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
		$("#menu-box").show();
		$(document).on('click',function(){
		    $("#menu-box").hide();
		    tapCount=1;
		});
	}
	if(tapCount==4){
		$("#menu-box").hide();
		tapCount=0;
	}
})



$("#menu,#menu-box").on('click',function(e){
    stopPropagation(e);
});



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
//购买商品--func成功的回调
function buyGoods(data,func){
    ucBuy.buyAdd(data,func);
}
function buyAddCallback(obj,func){
    if(obj.code==0){
        layer_error('商品已添加到系统中');
    }else if(obj.code==-1){
        layer_error('验证失败');
    }else if (obj.code==1){
        if(typeof func=='function') func();
        layer_success('商品添加失败');
    }else{
        layer_error('添加失败');
    }
    layer_close_load();
}