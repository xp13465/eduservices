(function($){
    $.fn.autoComplete=function(o){
        if(o.ajax) o.ajax=$.extend({
            url:'',
            dataType:'json',
            async:true
        }, o.ajax||{});
        o=$.extend({
            source:null,/* privide an array for match */
            ajax:{},/* provide an ajax conditions, if source is exist this parameter is invalid */
            input:'input',/* provide the selector of input box */
            popup:'ul',/* provide the selector of popup box, it must be a ul element of html */
            clickFun:null,
            zeroDelFun:null,
            listShow:5
        },o||{});
        var handler=(function(){
            var handler=function(e,o){
                return new handler.prototype.init(e,o);
            };
            handler.prototype={
                e:null,
                o:null,
                timer:null,
                show:0,
                $input:null,
                $popup:null,
                canMatch:true,
                init:function(e,o){
                    this.e=e;
                    this.o=o;
                    this.$input=$(this.o.input,this.e);
                    this.$popup=$(this.o.popup,this.e);
                    this.initEvent();
                },
                match:function(quickExpr,value,source){
                    var count = 0;
                    for(var i in source){
                        if( value.length>0 && quickExpr.exec(source[i])!=null ){
                            if(count<this.o.listShow){
                                count++;
                                this.$popup.append('<li><a href="javascript:;">'+source[i]+'</a></li>');
                            }
                        }
                    }
                    if($('li',this.$popup[0]).length){
                        this.canMatch = true;
                        this.$popup.show();
                    }else{
                        this.canMatch = false;
                        this.$popup.append('<li><span>在您的关注中没有找到匹配的用户，您可以先去关注本用户再来赠送礼物</span></li>');
                        this.$popup.show();
                    }
                },
                fetch:function(ajax,search,quickExpr){
                    var that=this;
                    $.ajax({
                        url: ajax.url+search,
                        dataType: ajax.dataType,
                        async: ajax.async,
                        error: function(data,es,et){
                            alert('error');
                        },
                        success: function(data){
                            that.match(quickExpr,search,data);
                        }
                    });
                },
                click:function(value){
                    var that=this;
                    if(this.canMatch){
                        if(that.o.clickFun){
                            that.$input[0].value="";
                            try{
                                that.o.clickFun(value)
                            }catch(n){}
                            $(this).focus();
                        }else{
                            that.$input[0].value = value;
                        }
                        that.$popup.html('').hide();
                    }
                    
                },
                initEvent:function(){
                    var that=this;
                    this.$input.focus(function(){
                        var value=this.value, quickExpr=RegExp('^'+value,'i'), self=this;
                        that.timer=setInterval(function(){
                            if(value!=self.value){
                                value=self.value;
                                that.$popup.html('');
                                if(value!=''){
                                    quickExpr=RegExp(value);
                                    if(that.o.source) that.match(quickExpr,value,that.o.source);
                                    else if(that.o.ajax) that.fetch(that.o.ajax,value,quickExpr);
                                }
                            }
                        },200);
                    }).blur(function(){
                        clearInterval(that.timer);
                        $("li",that.$popup[0]).click(function(){//点击之后
                            that.click($(this).text())
                        });
                    }).keydown(function(event){
                        var select = -1;
                        var length = that.$popup.find("li").length;

                        that.$popup.find("li").each(function(i){
                            if($(this).hasClass("on")){
                                select = i;
                            }
                        });
                        if(event.keyCode==40){//向下
                            select++;
                            if(select==length){
                                select=0
                            }
                            that.$popup.find("li").each(function(){
                                $(this).removeClass("on");
                            })
                            that.$popup.find("li").eq(select).addClass("on");
                        }else if(event.keyCode==38){//向上
                            select--;
                            if(select<0){
                                select=length-1
                            }
                            that.$popup.find("li").each(function(){
                                $(this).removeClass("on");
                            })
                            that.$popup.find("li").eq(select).addClass("on");
                        }else if(event.keyCode==13){//确定
                            var value = that.$popup.find("li").eq(select).children().html();
                            that.click(value)
                        }else if(event.keyCode==8){
                            var length = that.$input[0].value.length;
                            if(length==0){
                                try{
                                    that.o.zeroDelFun()
                                }catch(n){}
                            }
                        }
                    });
                    that.$popup.find("li").live("mouseover",function(){
                        that.$popup.find("li").each(function(){
                            $(this).removeClass("on");
                        })
                        $(this).addClass("on");
                    })
                    $(this.e).hover(function(){
                        that.show=1;
                    },function(){
                        that.show=0;
                    });
                    $(document).click(function(){
                        if(that.show==0){
                            that.$input[0].value="";
                            that.$popup.hide();
                        }
                    });
                }
            };
            handler.prototype.init.prototype=handler.prototype;/* JQuery style */
            return handler;
        })();
        return this.each(function(){
            handler(this,o);
        });
    };
})(jQuery);