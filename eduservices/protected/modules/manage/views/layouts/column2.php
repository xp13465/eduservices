<?php $this->beginContent('/layouts/main'); ?>
<div class="container">
    <div class="span-5">
        <?php   
            $this->widget('Navigation',array(
                'currentMenu'=>$this->currentMenu,
            ));
        ?>
    </div>
    <script type="text/javascript">
        $(document).ready(function($){
            if(parentslist){
            setTimeout(function(){
                var temp = parentslist;
                var i = temp.length;
                while(i--){
                    if(temp[i]=='0') continue;
                    $("#"+temp[i]).removeClass('expandable').addClass('collapsable');
                    $("#"+temp[i]+'>div').removeClass('expandable-hitarea').addClass('collapsable-hitarea');
                    $("#"+temp[i]+'>ul').show();
                }
            },1000);}
        });
    </script>
	<div class="span-19">
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-5 last">
		<div id="sidebar">
		<?php
            if($this->menu){
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title'=>'操作列表',
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