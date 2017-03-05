 <div class="cleaner_h5"></div>
	<?php $this->renderPartial("_leftMenu")?>


<div class="main mainContent">

<div class="infoMain">
        <div class="infolist_title">您的当前位置：<a href='<?=DOMAIN?>'>首页</a> >> <a href='<?=Yii::app()->createUrl("news/index",array('id'=>$model->i_class))?>' ><?=Information::$class[$model->i_class]?></a>>><?=$model->i_title?></div>
        <div id="divContent" class="small">
        	<div class="box-t">
	        	<h1 class="title">
	        		<?php if($model->i_pic&&file_exists(DOCUMENTROOT.$model->i_pic)){?>
		        	<img src="<?=$model->i_pic?>">
		        	<?php }?>
	        		<?=$model->i_title?>

	        	</h1>
	        	<p class="news-info">发布:<?=date("Y-m-d",$model->i_submitdate)?>&nbsp;&nbsp;&nbsp;&nbsp;浏览量：<?=$model->i_click?></p>
	        </div>
        	<div class="text">

        		<?=$model->i_con?>
        	</div>
        </div>

</div>

</div>

<div class="cleaner"></div>
