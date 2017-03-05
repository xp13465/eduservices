<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jsdate/WdatePicker.js",CClientScript::POS_END);
$this->breadcrumbs=array(
	'入学考试管理',
	'排考管理',
);

?>
<?php $Arrays=$dataProvider->getData();?>
<div class="show-grid">
	<div class="span8">
		<div class="clear">
		</div>
		<div>
			<table class="table table-bordered specialtylist">
				<thead>
					<tr>
						<th width="30px"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value=""></th>
						<th width="60px">序号 [ID]</th>
						<th width="60px">批次名称</th>
                        <th  >试卷名称</th>
                        <th width="210x">考试安排</th>
                        <th width="80px">批次状态 </th>
                        <th width="80px">考试类别 </th>
						<th width="120px">操作 </th>
					</tr>
				</thead>
				<tbody>
				<?php 	if(!$Arrays){?>
							<tr>
							<td colspan='11'>没有找到数据</td>
							</tr>
				<?php 	}else{
							foreach($Arrays as $key=>$data){
								$this->renderPartial("_view",array("data"=>$data,"key"=>$key));
							}
						}?>
				</tbody>
			</table>
		</div>
		<div class="clear ohidden">
			<p class="pull-left">
				<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
                <a class="btn btn-danger" href="javascript:GetCheckbox('examarrangement')"><i class="icon-trash icon-white"></i> 删除</a>
				<?php /*
                <a class="btn btn-danger" href="javascript:StatusAll('pici',1)"><i class="icon-trash icon-white"></i> 禁用</a>
                <a class="btn btn-danger" href="javascript:StatusAll('pici',2)"><i class="icon-trash icon-white"></i> 启用</a>
                */?>
                <a class="btn" href="javascript:window.location.reload()"><i class="icon-refresh"></i> 刷新</a>
                <font size='-3' color='#999'></font>
			</p>
			<p class="input-append pull-right">
				<input class="width60" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("ea_pagesize",this.value)}' type="text" value="<?=isset($_COOKIE['ea_pagesize'])?$_COOKIE['ea_pagesize']:"20"?>">
				<button class="btn btn-info" type="button" onclick='setpagesize("ea_pagesize",$("#pagesize").val())'>设置每页显示条数</button>
			</p>
		</div>
		<div class="clear ohidden">
			<div class="pagination pull-left">
				<?php 	$this->widget('CBootstraplinkPager',array(
							'pages'=>$dataProvider->pagination,
						));?>
			</div>
			<div class="pagination pull-right">
					当前第<span class="blcolor weight"><?=$dataProvider->pagination->currentPage+1?></span>页，
					共<span class="blcolor weight"><?=ceil($dataProvider->pagination->itemCount/$dataProvider->pagination->pageSize)?></span>页，
					共有<span class="blcolor weight"><?=$dataProvider->pagination->itemCount?></span>条数据。
			</div>
		</div>
	</div>
	<div class="span4">
		<h2>添加新排考</h2>
		<div class="ohidden well">
			<form class="form-horizontal" id='paikaoForm' action="" method="post">
                        <p>
							
                            <label class="weight">入学考试试卷</label>
                            <?php
                            echo CHtml::DropDownList('examid','',Exampaper::model()->getAllExam(), array(
							'name'=>'examid',
                            'empty'=>'系统判断层次专业出卷',
							'class'=>"pull-left wauto")); ?>
							<span for="o_pid" class="error" style=""><?=isset($newmodel->errors['o_pid'])?join('',$newmodel->errors['o_pid']):""?></span>
							<span class="help-inline rcolor"></span>
						</p></br>
                        <p>
							<label class="weight">入学考试批次</label>
                            <?php echo CHtml::DropDownList('pcid','', Pici::model()->getAllPC(true,false), array(
							"name"=>"pcid",
							// 'empty'=>'请选择报名点名称',
							'class'=>"pull-left wauto")); ?>
							<span for="o_pid" class="error" style=""><?=isset($newmodel->errors['o_pid'])?join('',$newmodel->errors['o_pid']):""?></span>
							<span class="help-inline rcolor"></span>
						</p></br>
                        <p>
							<label class="weight">入学考试时间</label>
                            
							<?php 
                            $hour=$mintue=array();
                            for($i=0;$i<=60;$i++){
                                  if($i<24){
                                      $hour[str_pad($i,2,0,STR_PAD_LEFT)]=str_pad($i,2,0,STR_PAD_LEFT);
                                  }
                                  $mintue[str_pad($i,2,0,STR_PAD_LEFT)]=str_pad($i,2,0,STR_PAD_LEFT);
                                  
                            }?>
                            <?php echo CHtml::textField('e_btime',"",array('class'=>'span5','maxlength'=>100,'name'=>"e_btime",'onclick'=>"WdatePicker()")); ?>
                         
                            <br/>从
                            <?php echo CHtml::DropDownList('shour','', $hour, array(
							"name"=>"shour",
							'class'=>"wauto")); ?>时
                            <?php echo CHtml::DropDownList('sminute','', $mintue, array(
							"name"=>"sminute",
							'class'=>"wauto")); ?>分
                            <br/>到
                            <?php echo CHtml::DropDownList('ehour',23, $hour, array(
							"name"=>"ehour",
							'class'=>"wauto")); ?>时
                            <?php echo CHtml::DropDownList('eminute','', $mintue, array(
							"name"=>"eminute",
							'class'=>"wauto")); ?>分
							<span for="o_pid" class="error" style=""><?=isset($newmodel->errors['o_pid'])?join('',$newmodel->errors['o_pid']):""?></span>
							<span class="help-inline rcolor"></span>
						</p></br>
                        
                        <p>
							
                            <label class="weight">考试类别</label>
                            <?php
                            echo CHtml::DropDownList('eatype','',Examarrangement::$type, array(
							'name'=>'examid',
							'class'=>"pull-left wauto")); ?>
							<span for="o_pid" class="error" style=""><?=isset($newmodel->errors['o_pid'])?join('',$newmodel->errors['o_pid']):""?></span>
							<span class="help-inline rcolor"></span>
						</p></br>
			
				<p>
				  <br/><button class="btn btn-primary" type="submit">添加数据</button>
				</p>
			</form>
		</div>
		<script>
		$(function(){
		<?php if(Yii::app()->user->hasFlash("message")){?>
		jw.pop.alert('<?=Yii::app()->user->getFlash("message")?>',{autoClose:2000})
		<?php }?>
			$("#paikaoForm").validate({
				// debug: true,
				autoCreateRanges:true	,
				errorClass: "error",
				errorElement: "span",
                rules: {
                    // examid: 'required',
                    pcid: 'required'
                },
                messages: {
                    // examid: '考试试卷为必填',
                    pcid: '批次为必填项'
                }
			});
		
		})
		</script>
	</div>
</div>
			

