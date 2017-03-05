<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta http-equiv="Page-Enter" content="blendTrans(Duration=2.0)" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="acking">


		<?php 	
        Yii::app()->clientScript->registerCoreScript('jquery');	?>
		<!-- Le styles -->
		<link href="/css/bootstrap.css" rel="stylesheet">
        <link href="/css/admin.css" rel="stylesheet">
		<link href="/css/global.css" rel="stylesheet">
		
		<style type="text/css">
			body {
			padding-top: 60px;
			padding-bottom: 40px;
			}
			.sidebar-nav {
			padding: 9px 0; 
			}
			@media (max-width: 980px) {
				/* Enable use of floated navbar text */
				.navbar-text.pull-right {
				  float: none;
				  padding-left: 5px;
				  padding-right: 5px;
				}
			}
		</style>
		<link href="/css/bootstrap-responsive.css" rel="stylesheet">
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="/js/html5shiv.js"></script>
		<![endif]-->
    </head>
    <body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<!-- <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</a> -->
					<a class="brand logo-a" href="/admin.html"><img src="/img/bhlogo-39.png" width="30px" /><span>北京航空航天大学</span></a>
					<div class="btn-group pull-right">
                        <?php $umodel=User::model()->findByPk(Yii::app()->user->id)?>
						<a class="btn dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
							<i class="icon-user"></i> 您好，<?=$umodel->user_nkname?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?=Yii::app()->createUrl("admin/user/view")?>"><i class="icon-cog"></i>&nbsp;个人设置</a></li>
							<li class="divider"></li>
							<li><a href="<?=Yii::app()->createUrl('admin/manageuser/logout')?>"><i class="icon-off"></i>&nbsp;登出</a></li>
						</ul>
					</div>
					<div class="nav-collapse">
						<ul class="nav">
						  <li class="dropdown">
							<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                            <?=!$umodel->user_rolebz?isset(User::$RoleName[Yii::app()->user->role])?User::$RoleName[Yii::app()->user->role]."权限":"":$umodel->user_rolebz?>
                            <b class="caret"></b></a>
							<ul class="dropdown-menu">
                                <li><a target='_blank' href="<?=DOMAIN?>"><i class="icon-home"></i>&nbsp;查看站点</a></li>
                                <?php if(Yii::app()->user->role=="4"){?>
                                <li class="divider"></li>
                                <li><a target='_blank' href="<?=Yii::app()->createUrl("admin/admin/cleancache")?>"><i class="icon-refresh"></i>&nbsp;清理缓存</a></li>
                                <?php }?>
                              
							</ul>
						  </li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>
	
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span2" id="left_div" style='  position:relative;'>
					<?=$this->renderPartial('/layouts/_leftmenu');?>
				</div><!--/span-->
				<div class="span10" id="right_div">
					<div class="right1">
						<div class="breadcrumb ohidden" style='height:20px;'>
							
								<?php 	$this->widget('zii.widgets.CBreadcrumbs', array(
											"homeLink"=>CHtml::link("<i class='icon-map-marker'></i>&nbsp;首页","/admin"),
											'links'=>$this->breadcrumbs,
											'htmlOptions'=>array('class'=>'pull-left'),
										)); ?>
								<?php 	$this->widget('zii.widgets.CMenu', array(
									'htmlOptions'=>array("class"=>"pull-right right_menu"),
									'items'=>$this->menu,
								));
								?>
								
						</div>
						
					</div>
					<?php echo $content; ?>
				</div><!--/span-->
			</div><!--/row-->
		  <hr>
		  <footer>
			<p>&copy; Company 2013</p>
		  </footer>

		</div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
     <script>

 function checkaaa(){
    if($('#leftmenu').css("display")=="block"){
        $("#btnleftmenu").html("显示")
        $('#leftmenu').hide()
        $('#left_div').animate({ width:'-=10%'},0)
        $('#right_div').animate({ width:'+=10%'},0)
		$('#right_div').css( "margin-left",'0%')
        setshowlisttype("showleftmenu","hide")
    }else{
        $("#btnleftmenu").html("隐藏")
        $('#leftmenu').show()
        $('#left_div').animate({ width:'+=10%'},0)
        $('#right_div').animate({ width:'-=10%'},0)
		$('#right_div').css( "margin-left",'2%')
        setshowlisttype("showleftmenu","show")
        
    }
    // alert($('#leftmenu').css("display"))
    // $('#leftmenu').toggle(function(){$('#leftmenudiv').css('width','1%')},function(){$('#leftmenudiv').css('width','10%')});
 }
 
 </script>
	<script>
	$(function(){
    <?php if(isset($_COOKIE['showleftmenu'])&&$_COOKIE['showleftmenu']=="hide"){?>
        $('#leftmenu').hide()
        $("#btnleftmenu").html("显示")
        $('#left_div').animate({ width:'-=10%'},0)
        $('#right_div').animate({ width:'+=10%'},0)
		$('#right_div').css( "margin-left",'0%')
    <?php }?>
	<?php if(Yii::app()->user->hasFlash("message")){?>
	jw.pop.alert('<?=Yii::app()->user->getFlash("message")?>')
	<?php }?>
	})
	</script>
    <script src="/js/admin.js"></script>
    <?php 
    $controller = Yii::app()->controller->id;  
    $action = $this->getAction()->getId(); 
    $controlleraction = strtolower($controller.$action);
    
    if(!in_array($controlleraction,array("studentschecku","studentsview"))){
    ?>
    <script src="/js/bootstrap-transition.js"></script>
    <script src="/js/bootstrap-alert.js"></script>
    <script src="/js/bootstrap-modal.js"></script>
    <script src="/js/bootstrap-dropdown.js"></script>
    <script src="/js/bootstrap-scrollspy.js"></script>
    <script src="/js/bootstrap-tab.js"></script>
    <script src="/js/bootstrap-tooltip.js"></script>
    <script src="/js/bootstrap-popover.js"></script>
    <script src="/js/bootstrap-button.js"></script>
    <script src="/js/bootstrap-collapse.js"></script>
    <script src="/js/bootstrap-carousel.js"></script>
    <script src="/js/bootstrap-typeahead.js"></script>
    <?php }?>
    <link href="/js/common/common.css" rel="stylesheet">
	<script src="/js/common/common.js" type="text/javascript"></script>
    </body>
	
</html>
