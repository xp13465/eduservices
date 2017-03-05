<?php $this->beginContent('//layouts/main'); ?>
<div class="container" >
	<div class="span-19"style="width:920px;">
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-5 last" >
		<div id="sidebar">
		<?php
            if($this->menuAction){
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title'=>'菜单目录',
                ));

                $this->widget('zii.widgets.CMenu', array(
                    'items'=>$this->menuAction,
                    'htmlOptions'=>array('class'=>'operations'),
                ));
                $this->endWidget();
            }
            if($this->menu){
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title'=>'操作目录',
                ));
                
                $this->widget('zii.widgets.CMenu', array(
                    'items'=>$this->menu,
                    'htmlOptions'=>array('class'=>'operations'),
                ));
                $this->endWidget();
            }

          
		?>
		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>