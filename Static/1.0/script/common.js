
//顶部点击菜单出现弹窗；
var  tapCount;
tapCount=0;
$("#menu").on('click',function(){
    tapCount++;
    if(tapCount==1){
        $("#menu-box").addClass("slideInDown animated infinite");
        $("#menu-box").css({"display":"block"});
        $(document).on('click',function(){
            $("#menu-box").removeClass("slideInDown animated infinite");
            $("#menu-box").hide();
            tapCount=0;
        });
        tapCount=1;
    }
    if(tapCount==2){
        $("#menu-box").removeClass("slideInDown animated infinite");
        $("#menu-box").hide();
        tapCount=0;
    }
})
$("#menu,#menu-box").on('click',function(e){
    stopPropagation(e);
});
//阻止默认事件执行的函数

function stopPropagation(e) {
    if (e.stopPropagation)
        e.stopPropagation();
    else
        e.cancelBubble = true;
}
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
        layer_close_load();
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
    });
}


//公用切换选项卡；
var tabsSwiper = new Swiper('.swiper-container',{
    speed:500,
    onSlideChangeStart: function(){
        $(".tabs .active").removeClass('active')
        $(".tabs b").eq(tabsSwiper.activeIndex).addClass('active')
    }
})
$(".tabs b").on('touchstart mousedown',function(e){
    e.preventDefault()
    $(".tabs .active").removeClass('active')
    $(this).addClass('active')
    tabsSwiper.swipeTo( $(this).index() )
})
$(".tabs b").click(function(e){
    e.preventDefault()
})



//顶部点击菜单出现弹窗；
var  tapCount2;
tapCount2=0;
$("#share").on('click',function(){
    tapCount2++;
    if(tapCount2==1){
        $(".yzc-share").addClass("slideInDown animated infinite");
        $(".yzc-share").css({"display":"block"});
        $(document).on('click',function(){
            $(".yzc-share").removeClass("slideInDown animated infinite");
            $(".yzc-share").hide();
            tapCount2=0;
        });
        tapCount2=1;
    }
    if(tapCount2==2){
        $(".yzc-share").removeClass("slideInDown animated infinite");
        $(".yzc-share").hide();
        tapCount2=0;
    }
})

$("#share,.yzc-share").on('click',function(e){
    stopPropagation(e);
});