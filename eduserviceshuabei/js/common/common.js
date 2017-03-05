var MT=function(){};
window.jw=new MT;
var windowHeight=$(window).height();
MT.prototype.pop={
    alert:function(a,c){
        var b={
            title:"\u63d0\u793a",
            ok_label:"\u786e\u5b9a",
            ok:null,
            width:380,
            height:"auto",
            icon:1,
            zIndex:10001,
            hasBtn_ok:true,
            hasBtn_cancel:false,
            cancel:null,
            cancel_label:"\u53d6\u6d88",
            autoClose:false,
            btn_float:"right"
        };
        c&&$.extend(b,c);
        var d='<div class="mtAlert_content clearfix" style="width:'+b.width+'px;">\t\t\t<div class="W_layer_l fl">\t\t\t\t<img src="http://img.app.wcdn.cn/ops/photo/style/images_v4/transparent.gif" class="mtAlert_icon iconAlert_0'+b.icon+'" />\t\t\t</div>\t\t\t<div class="fl mtAlert_contentTxt" style="width:'+(b.width-100)+'px;">'+a+"</div>\t\t</div>";
        if(b.hasBtn_ok){
            d+="<div style='padding-top:2px;text-align:"+b.btn_float+"'>";
            d+=b.hasBtn_cancel?'<a class="W_btn_b MT_btn_callBack" href="javascript:void(0)"><span>'+b.ok_label+'</span></a><a class="W_btn_a MT_btn_cancel" href="javascript:void(0)"><span>'+b.cancel_label+"</span></a>":'<a class="W_btn_b MT_btn_callBack" href="javascript:void(0)"><span>'+b.ok_label+"</span></a>";
            d+="</div>";
        }
        d=jw.pop.basicDialog(b.title,d);
        var e=[],h=(new Date).getTime();
        e.push('<div class="W_layer" id="W_'+h+'" style="position: absolute;z-index:'+b.zIndex+';">');
        e.push(d);
        e.push("</div>");
        e=e.join(" ")+" ";
        var g=new jw.mask;g._show();
        if(d=b.autoClose)e='<div class="W_layer" id="W_'+h+'" style="position: absolute;z-index:'+b.zIndex+';">\t\t\t<div class="bg">\t\t\t<table border="0" cellspacing="0" cellpadding="0">\t\t\t\t<tbody>\t\t\t\t\t<tr>\t\t\t\t\t<td>\t\t\t\t\t\t<div class="content" >\t\t\t\t\t\t\t<div class="inner" style="padding:20px 35px;">\t\t\t\t\t\t\t\t<div class="mtAlert_content clearfix" style="width:auto;">\t\t\t\t\t\t\t\t\t\t<span class="miniIcon'+b.icon+'"></span>&nbsp;'+a+"\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t</div>\t\t\t\t\t</td>\t\t\t\t\t</tr>\t\t\t\t</tbody>\t\t\t</table>\t\t\t</div></div>";
        
        $("body").append(e);
        jw.pop.drag($("#W_"+h),$("#W_"+h).find(".title"));
        
        e=($(window).width()-$("#W_"+h).width())/2+"px";
        var k=(parent.window.document.documentElement.scrollTop||$("body",window.parent.document).scrollTop())+(windowHeight-$("#W_"+h).height())/2+"px";
        $("#W_"+h).css({left:e,top:k});
        $("#W_"+h).find(".close").click(function(){$("#W_"+h).remove();g._hide()});
        $("#W_"+h).find(".MT_btn_callBack").click(function(){
            var ok_click = true;
            if(b.ok){
                var l=b.ok;try{ok_click = l()}catch(n){}
            }
            if(ok_click!=false){
                $("#W_"+h).remove();
                g._hide()
            }
        });
        $("#W_"+h).find(".MT_btn_cancel").click(function(){
            $("#W_"+h).remove();g._hide();if(b.cancel){var l=b.cancel;try{l()}catch(n){}}
        });
        d&&setTimeout(function(){
            $("#W_"+h).remove();g._hide()
        },d);
        return false
    },
    tip:function(a,c){
        var scrollPos;
        if (typeof window.pageYOffset != 'undefined') {
           scrollPos = window.pageYOffset;
        }
        else if (typeof document.compatMode != 'undefined' &&
             document.compatMode != 'BackCompat') {
           scrollPos = document.documentElement.scrollTop;
        }
        else if (typeof document.body != 'undefined') {
           scrollPos = document.body.scrollTop;
        }
        var b={
            width:250,
            x:event.x-50,
            y:event.y+scrollPos+10,
            rot:1,
            zIndex:1E4,
            close:true
        };
        c&&$.extend(b,c);
        var d=(new Date).getTime(),e=[];
        e.push('<div class="pop_layer" id="pop'+d+'" style="width:'+b.width+'px"><div  class="bg"><table cellspacing="0" cellpadding="0" border="0"><tbody><tr><td><div class="content"><div class="inner">');
        switch(b.rot){
            case 1:
                e.push('<div class="arrow arrow_t"></div>');
                break;
            case 2:
                e.push('<div class="arrow arrow_r"></div>');
                break;
            case 3:
                e.push('<div class="arrow arrow_b"></div>');
                break;
            case 1:
                e.push('<div class="arrow arrow_l"></div>');
                break;
            default:
                e.push('<div class="arrow arrow_l"></div>');
                break
        }
        b.close&&e.push('<div class="close MT_close"></div>');
        e.push(a);
        e.push("</div></div></td></tr></tbody></table></div></div>");
        e=e.join("")+" ";
        $(".pop_layer").remove();
        $("body").append(e);
        $("#pop"+d).css({
            left:b.x,
            top:b.y,
            "z-index":b.zIndex
        });
        $(".close").click(function(){
            $("#pop"+d).remove()
        });
        this.tip.close=function(){
            $("#pop"+d).remove()
        }
    },
    customtip:function(title,content,parameter){
        var templete ={
            width:380,
            height:"auto",
            zIndex:10001,
            ok_label:"\u786e\u5b9a",
            ok:null,
            hasBtn_ok:true,
            hasBtn_cancel:false,
            cancel:null,
            cancel_label:"\u53d6\u6d88",
            btn_float:"right"
        }
        parameter&&$.extend(templete,parameter);
        if(templete.hasBtn_ok){
            content+="<div style='padding-top:2px;text-align:"+templete.btn_float+"'>";
            content+=templete.hasBtn_cancel?'<a class="W_btn_b MT_btn_callBack" href="javascript:void(0)"><span>'+templete.ok_label+'</span></a><a class="W_btn_a MT_btn_cancel" href="javascript:void(0)"><span>'+templete.cancel_label+"</span></a>":'<a class="W_btn_b MT_btn_callBack" href="javascript:void(0)"><span>'+templete.ok_label+"</span></a>";
            content+="</div>";
        }
        content=jw.pop.basicDialog(title,content);
        var e=[],h=(new Date).getTime();
        e.push('<div class="W_layer" id="W_'+h+'" style="position: absolute;z-index:'+templete.zIndex+';">');
        e.push(content);
        e.push("</div>");
        e=e.join(" ")+" ";
        var mark=new jw.mask;mark._show();

        $("body").append(e);
        jw.pop.drag($("#W_"+h),$("#W_"+h).find(".title"));

        e=($(window).width()-$("#W_"+h).width())/2+"px";
        var k=(parent.window.document.documentElement.scrollTop||$("body",window.parent.document).scrollTop())+(windowHeight-$("#W_"+h).height())/2+"px";
        $("#W_"+h).css({left:e,top:k});
        $("#W_"+h).find(".close").click(function(){$("#W_"+h).remove();mark._hide()});

        $("#W_"+h).find(".MT_btn_callBack").click(function(){
            var ok_click = true;
            if(templete.ok){
                var l=templete.ok;
                try{ok_click = l()}catch(n){}
            }
            if(ok_click!=false){
                $("#W_"+h).remove();
                mark._hide();
            }
        });
        $("#W_"+h).find(".MT_btn_cancel").click(function(){
            $("#W_"+h).remove();mark._hide();if(mark.cancel){var l=mark.cancel;try{l()}catch(n){}}
        });
    },
    basicDialog:function(title,content){
        return'<div class="bg">\t\t\t<table border="0" cellspacing="0" cellpadding="0">\t\t\t\t<tbody>\t\t\t\t\t<tr>\t\t\t\t\t<td>\t\t\t\t\t\t<div class="content" >\t\t\t\t\t\t<div class="title dragConn" style="cursor: move; "><span>'+title+'</span></div>\t\t\t\t\t\t\t<span class="MT_close close" title="\u5173\u95ed"></span>\t\t\t\t\t\t\t<div class="inner">'+content+"</div>\t\t\t\t\t\t</div>\t\t\t\t\t</td>\t\t\t\t\t</tr>\t\t\t\t</tbody>\t\t\t</table>\t\t</div>"
    },
    drag:function(a,c){
        a.jqDrag(c)
    }
};
MT.prototype.mask=function(a,c){
    function b(){
        var h=$(window).height()+"px";
        $(".mask").css("height",h);
        $(".mask").css("top","0");
        $.browser.msie&&$.browser.version=="6.0"&&$(".mask").css("top",$(document).scrollTop()+"px").css("left",$(document).scrollLeft()+"px")
    }
    var d=a?a:15,e=c?c:"#000";
    this._show=function(){
        var h=$(window).height();
        $(document).scrollTop();
        h='<div class="mask"  style="height:'+h+"px;top:0;opacity:"+d/100+";filter:alpha(opacity="+d+");background:"+e+'"></div>';
        $("body").append(h);
        $.browser.msie&&$.browser.version=="6.0"&&$(".mask").css("top",$(document).scrollTop()+"px");
        $(window).bind("scroll resize",b)
    };
    this._hide=function(){
        $(".mask:last").remove();$(window).unbind("scroll resize")
    }
};
$.fn.jqDrag=function(a,c,b){
    return drag(this,a,"d",c,b)
};
$.jqDnR={
    dnr:{},
    e:0,
    ed:function(){},
    drag:function(a){
        if(M.k=="d"){
            var c=M.X+a.pageX-M.pX;
            a=M.Y+a.pageY-M.pY;
            if(c<0){
                c=0;
            }else if(c>=B.W-M.W){
                c=B.W-M.W-10;
            }if(a<0){
                a=0;
            }else if(a>B.H+$(window).scrollTop()-M.H){
                a=B.H+$(window).scrollTop()-M.H;
            }
            E.css({left:c,top:a})
        }else{
            E.css({width:Math.max(a.pageX-M.pX+M.W,0),height:Math.max(a.pageY-M.pY+M.H,0)})
        }
        return false
    },stop:function(){
        ED(dt);
        dt.css({top:E.offset().top,left:E.offset().left});
        E.remove();
        $(document).unbind("mousemove",J.drag).unbind("mouseup",J.stop)
    }
};

f=function(a){return parseInt(E.css(a))||false};

var B={W:$(window).width(),H:$(window).height()},
J=$.jqDnR,
M=J.dnr,E,dt,
ED=J.ed,
drag=function(a,c,b,d,e){

    if(d==undefined)d=function(){};
    if(e==undefined)e=function(){};
    ED=e;
    return a.each(
    function(){
        c=c?$(c,a):a;
        c.bind("mousedown",{e:a,k:b},
        function(h){
            var g=h.data,k={};
            dt=g.e;
            d(dt);
            E&&E.remove();
            E=$('<div id="drag_div" style="cursor:move"></div>').appendTo(document.body).css({position:"absolute",top:dt.offset().top+"px",left:dt.offset().left+"px",width:dt.width()+"px",height:dt.height()+"px",border:"#DDD 3px solid"});
            if(E.css("position")!="relative")try{E.position(k)}catch(l){}M={X:k.left||f("left")||0,Y:k.top||f("top")||0,W:f("width")||E[0].scrollWidth||0,H:f("height")||E[0].scrollHeight||0,pX:h.pageX,pY:h.pageY,k:g.k,o:E.css("opacity")};
            E.css({opacity:1});
            $(document).mousemove($.jqDnR.drag).mouseup($.jqDnR.stop);
                    
            return false;
        }
    )
    }
)
};
var txtNum_func=function(a){
    a=$.trim(a);
    if(typeof a=="undefined")return 0;
    var c=a.match(/[^\x00-\x80]/g);
    return a.length+(!c?0:c.length)
};