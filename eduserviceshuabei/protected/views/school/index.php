<?php $models=Schoolabout::model()->findAll();?>
<div class="cleaner_h5"></div>
	<!--左边列开始-->
	<div class="navLeft navLeftContent">
		<div class="webpart">
			<h1><span class="pillar"></span>快速导航</h1>
			<div class="webpart_nav">
				<ul>
                    <?php foreach($models as $key=>$val){?>
					<li style="li_alternating">
						<span class="pillar"></span>
						<img src="/images/LastPhoto_l1.gif" align="absmiddle">
						<a href="<?=Yii::app()->createUrl("school/index",array('id'=>$val->sa_id))?>"><?=$val->sa_label?></a>
					</li>
                    <?php }?>
				</ul>
			</div>
		</div>
	</div>
	<!--左边列结束-->


<div class="main mainContent">

<div class="infoMain">
        <div class="infolist_title">您的当前位置：<a href='<?=DOMAIN?>'>首页</a> >> <?=$model->sa_title?></div>
       
        <div id="divContent" class="small">
            
        	<?=$model->sa_con?>

        </div>

</div>

</div>

<div class="cleaner"></div>
