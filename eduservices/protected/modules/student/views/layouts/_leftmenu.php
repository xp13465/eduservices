<?php 
$controller = Yii::app()->controller->id;  
$action = $this->getAction()->getId(); 
$controlleraction = strtolower($controller.$action);
$typecontrolleraction=isset($_GET['type'])?$controlleraction.$_GET['type']:$controlleraction;
?>

<!-- start menu -->
<div id="menu" class="class_menu">
	<div id="menu_height" class="menu_sidar">
		<?php /*<ul class="treeview">
			<li class="ico_show">&nbsp;</li>
			<li class="menu_title">个人信息</li>
			<li class="menu_list_show">
				<ul>
					<li><a href="#">信息设置</a></li>
				</ul>
			</li>
		</ul>*/?>
		<ul class="treeview">
			<li class="ico_show">&nbsp;</li>
			<li class="menu_title">入学考试管理</li>
			<li class="menu_list_show">
				<ul>
                    <li><a href="<?=Yii::app()->createUrl("student/exampaper")?>" target="main-frame">试卷列表</a></li>
                    <li><a href="<?=Yii::app()->createUrl("student/exam")?>" target="main-frame">成绩查询</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<!-- end menu -->

<!-- start spliter -->
<div id="spliter01" class="class_spliter01" title="隐藏菜单列表"></div>
<div id="spliter02" class="class_spliter02" title="显示菜单列表"></div>
<!-- end spliter -->
<!-- start main -->
<div id="main" class="class_main">
	<iframe id="main-right" name="main-frame" frameborder="no" scrolling="yes" style="width:100%;*width:80%;" src="<?=Yii::app()->createUrl("student/exampaper")?>"></iframe>
</div>
<!-- end mainl -->