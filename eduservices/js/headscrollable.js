(function($){
    $.fn.jwPicSlider = function(param){
        param = $.extend({
            speed:800,
            width:960,
            interval:5000
        }, param)
        
        var addBtn = function(obj,fun){
            var picNum = $(obj).find("ul li").length;
            var btnDom = $("<p>",{
                "class":"controller"
            });
            if(picNum<=1){
                return ;
            }
            for(var i=0;i<picNum;i++){
                $("<a>",{
                    hidefocus:"true",
                    href:"javascript:;",
                    text:"\u25cf"
                }).click(fun).appendTo(btnDom)
            }
            this.update=function(k){
                btnDom.find(":eq("+k+")").addClass("jw-slider-on").siblings().removeClass("jw-slider-on")
            };
            this.update(0);
            btnDom.appendTo(obj);
            return ;
        };
        this.each(function(){
            var dom = this;
            var ul=$(dom).find("ul");
            var li=$(ul).find("li");
            var picNum =$(li).size();
            $(dom).width(param.width);
            $(ul).width(param.width*picNum);

            var showIndex = 0;
            var autoObj = null;
            var btn = new addBtn(dom,function(){
                clearInterval(autoObj);
                showIndex = $(this).index();
                changePic(showIndex);
                auto();
            });
            var changePic = function(index){
                ul.stop();
                ul.animate({
                    "margin-left":-index*param.width
                },param.speed)
                btn.update(index);
            }
            /*自动滚动*/
            var auto=function(){
                if(picNum<=1){
                    return ;
                }
                autoObj = setInterval(function(){
                    showIndex++;
                    if(showIndex>=picNum){
                        showIndex=0
                    }
                    changePic(showIndex)
                },param.interval)
            };
            auto();
        });
    };
})(jQuery);