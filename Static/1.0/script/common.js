
//顶部点击菜单出现弹窗；
var  tapCount;
tapCount=0;
$("#menu").on('click',function(){
    tapCount++;
    if(tapCount==1){
        $("#menu-box").addClass("slideInDown animated");
        $("#menu-box").css({"display":"block"});
        $(this).addClass("on");
        sendBehavior(203,ptype,0,0);//发送统计数据
        $(document).on('click',function(){
            $("#menu-box").removeClass("slideInDown animated");
            $("#menu-box").hide();
            tapCount=0;
        });
        tapCount=1;
    }
    if(tapCount==2){
        $("#menu-box").removeClass("slideInDown animated");
        $("#menu-box").hide();
        $(this).removeClass("on");
        tapCount=0;
    }
})

$("#menu").on('click',function(e){
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
        menu.className=i==curr ? "active" : "";
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
    var type = _YZC_ONLINE_;
    if ( type=='yzc' )
    {
        window.open("http://p.qiao.baidu.com/cps/chat?siteId=9503594&userId=21149642");
    }else{
        window.open("http://chat.looyu.com/chat/chat/p.do?c=46344&f=123997&g=51817");
    }
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
            layer.msg('请刷新后重试',{
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
$("#share").live("click",function(){
    layer.open({
        area:["80%","5.57rem"],
        type: 1,
        title: false,
        closeBtn:1,
        shadeClose:false,
        content:$(".yzc-share")

    });
});
$("input,textarea").on("touchstart",function(){
     $(this).blur();
})