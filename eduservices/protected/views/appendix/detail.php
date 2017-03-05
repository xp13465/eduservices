 <div class="cleaner_h5"></div>
	<?php $this->renderPartial("/news/_leftMenu")?>


<div class="main mainContent">

<div class="infoMain">
        <div class="infolist_title">您的当前位置：首页 >><b><a class="xa" href="<?php echo Yii::app()->createUrl("appendix/index")?>" target="_self" >资料下载</a></b></div>
       
        <div id="divContent" class="small">
            <h1><?=$model->name?></h1>
            <img src="<?=$model->pic?>"/>
            <br/>
        	<span style="margin-right:50px;"><a href="<?=$model->fileurl?>">点击下载</a></span><span><a href="<?php echo Yii::app()->createUrl("appendix/index")?>" target="_self" >返回列表</a></span>
        </div>    

</div>

</div>

<div class="cleaner"></div>
