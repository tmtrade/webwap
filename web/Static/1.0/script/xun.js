document.write('<script type="text/javascript"  data-lxb-uid="1268165" data-lxb-gid="139337" src="http://lxbjs.baidu.com/api/asset/api.js?t=' + new Date().getTime() + '" charset="utf-8"></scr' + 'ipt>' );

//咨询价格弹窗
$(".xun_price").live("click",function(){
    $("#xun_number").val($(this).data("number"));
    $("#xun_type").val($(this).data("type"));
    $("#xun_wz").val($(this).data("wz"));
    layer.open({
	area:["80%","4.86rem"],
	type: 1,
	title: false,
	closeBtn:1,
	shadeClose:false,
	content:$(".refer-cost")

    });
});

//点击咨询价格
$("#xun_submit").on("click",function(){
    var phone = $("#xun_phone").val();
    var number = $("#xun_number").val();
    var wz = $("#xun_wz").val();
    var type = $("#xun_type").val();
    var tip = $("#tips");
    var preg = /^1[3|4|5|7|8][0-9]\d{8}$/;
    if(!preg.test(phone)){
	tip.html("请您输入正确的电话号码!");
	tip.show();
    }else{
	lxb.call(phone); //自动拨打电话
	tip.hide();
	$.ajax({
		type: "post",
		url: "/buy/enquiry/",
		data: {phone:phone,number:number,type:type},
		dataType: "json",
		success: function(data){
			if (data.code == 1){
				layer.closeAll();
				var type_0 = '商标';
				if(type==2) type_0 = '专利';
				var content_0 = type_0+'号:'+number+';电话:'+phone;
				setEvent(type_0+wz,'表单-02-询价:电话-'+phone);
			}else{
			    layer.closeAll();
			    tip.html("数据错误!");
			}
		}
	});
    }
});

//判断咨询弹窗的位置；

$(window).scroll(function(){
    if(($(document).height() - $(window).height())-$(window).scrollTop()<=$(".yzc-btm").height()+10){
        $("#tel-buy").removeClass("refer-xf");
    }
    if(($(document).height()-$(window).height())-$(window).scrollTop()>$(".yzc-btm").height()+($("#tel-buy").outerHeight(true)- $("#tel-buy a").height())){
       $("#tel-buy").addClass("refer-xf");
    }
})