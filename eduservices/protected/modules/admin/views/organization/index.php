<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);

$this->breadcrumbs=array(
	'学习中心'=>array("organization/index"),
	$show,
);

// $this->menu=array(
	// array('label'=>'Create Organization', 'url'=>array('create')),
	// array('label'=>'Manage Organization', 'url'=>array('admin')),
// );
?>
<?php $Arrays=$dataProvider->getData();?>
<div class="show-grid">
	<div class="span8">
		<div class="clear">
        <?php $urlArr=$type?array('type'=>$type):array()?>
			<form action="" onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/organization/index",$urlArr)?>')">
				<span>搜索：</span>
				
				<?php if($show=='报名点'){
						$iszhongxin=isset($_GET['s_zhongxin'])?$_GET['s_zhongxin']:"";
						echo CHtml::DropDownList('s_zhongxin',$iszhongxin,Organization::model()->getOrByPid(0), array(
							"name"=>"s_zhongxin",
							'empty'=>'请选择学习中心'));
						}elseif($show=='机构'){
							$iszhongxin=isset($_GET['s_zhongxin'])?$_GET['s_zhongxin']:"";
							echo CHtml::DropDownList('s_zhongxin',$iszhongxin, Organization::model()->getOrByPid(0), array(
								"name"=>"s_zhongxin",
								'empty'=>'请选择学习中心',
								'ajax'=>array(

										  'type'=>'GET',

										  'url'=>CController::createUrl('admin/getorganization'),

										  'update'=>'#baomingdian',

										  'data'=>array('pid'=>"js:this.value",'typeid'=>1)

								))); 
							$isbaomingdian=isset($_GET['baomingdian'])?$_GET['baomingdian']:"";
							$DataArr=$iszhongxin?Organization::model()->getOrByPid($iszhongxin):array();
							echo CHtml::DropDownList('baomingdian',$isbaomingdian, $DataArr, array(
							"name"=>"baomingdian",
							'empty'=>'请选择报名点名称'));
							
						}
				
				?>
				<input class="wauto" type="text" name='o_name' onfocus='checkifocus("<?=$show?>名称..",this)' onblur='checkiout("<?=$show?>名称..",this)' value="<?=isset($_GET['o_name'])?$_GET['o_name']:$show."名称.."?>">
				<?php /*<input class="wauto" type="text" name='s_name' onfocus='checkifocus("<?=$show?>代码..",this)' onblur='checkiout("<?=$show?>代码..",this)' value="<?=$show?>代码..">*/?>
				<button type="submit" class="btn btn-inverse serach">搜索</button>
			</form>
		</div>
		<div>
			<table class="table table-bordered specialtylist">
				<thead>
					<tr>
						<?php 
						$get=$_GET;
						if(isset($_GET['order'])&&in_array($_GET['order'],array("ku","kd"))){
							$tmp=$_GET['order']=="ku"?"↑":"↓";
							$get['order']=$_GET['order']=="ku"?"kd":"";
							$tmpUrl=Yii::app()->createUrl("admin/organization/index",$get);
						}else{
							$tmp="↑↓";
							$get['order']="ku";
							$tmpUrl=Yii::app()->createUrl("admin/organization/index",$get);
						}?>
						<th width="24px"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value=""></th>
						<?php if($type=="jigou"){?>
						<th width="160px">所属学习中心 </th>
						<th width="120px">所属报名点</th>
						<th width="" style='min-width:120px;' >机构名称<a class="order" href="<?=$tmpUrl?>"><?=$tmp?></a></th>
						<?php }elseif($type=='baomingdian'){?>
						<th width="160px">所属学习中心 </th>
						<th width="120px">报名点代码</th>
						<th width="" style='min-width:120px;'>报名点名称<a class="order" href="<?=$tmpUrl?>"><?=$tmp?></a></th>
                        <th width="100px">报名点区号</th>
						<?php }else{?>
						<th width="120px">学习中心代码</th>
						<th width="" style='min-width:120px;'>学习中心名称 <a class="order" href="<?=$tmpUrl?>"><?=$tmp?></a></th>
						<?php }?>
						<th width="120px">操作</th>
					</tr>
				</thead>
				<tbody>
				<?php 	if(!$Arrays){?>
							<tr>
							<td colspan='11'>没有找到数据</td>
							</tr>
				<?php 	}else{
							foreach($Arrays as $key=>$data){
								$view=$type?"_".$type:"_view";
								$this->renderPartial($view,array("data"=>$data,"key"=>$key));
							}
						}?>
				</tbody>
			</table>
		</div>
		<div class="clear ohidden">
			<p class="pull-left">
				<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
				<!-- <a class="btn btn-primary" href="#"><i class="icon-edit icon-white"></i> 编辑</a> -->
				<a class="btn btn-danger" href="javascript:GetCheckbox('organization')"><i class="icon-trash icon-white"></i> 删除</a>
				<a class="btn" href="javascript:window.location.reload()"><i class="icon-refresh"></i> 刷新</a>
			</p>
			<p class="input-append pull-right">
				<input class="width60" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("o_pagesize",this.value)}' type="text" value="<?=isset($_COOKIE['o_pagesize'])?$_COOKIE['o_pagesize']:"20"?>">
				<button class="btn btn-info" type="button" onclick='setpagesize("o_pagesize",$("#pagesize").val())'>设置每页显示条数</button>
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
		<h2>添加新<?=$show?></h2>
		<div class="ohidden well">
			<form class="form-horizontal" id='organizationForm' action="" method="post">
			<?php 	if($type=="jigou"){?>
						<p>
							<label class="weight">所属学习中心</label>
							<?php echo CHtml::DropDownList('zhongxin','', Organization::model()->getOrByPid(0), array(
							"name"=>"zhongxin",
							'empty'=>'请选择学习中心',
							'class'=>"pull-left",
							'ajax'=>array(

									  'type'=>'GET',

									  'url'=>CController::createUrl('admin/getorganization'),

									  'update'=>'#o_pid',

									  'data'=>array('pid'=>"js:this.value",'typeid'=>1)

							))); ?>
							<span class="help-inline rcolor"></span>
						</p></br>
						<p>
							<label class="weight">所属报名点</label>
							  <?php echo CHtml::DropDownList('o_pid','', array(), array(
							"name"=>"o_pid",
							'empty'=>'请选择报名点名称',
							'class'=>"pull-left")); ?>
							<span for="o_pid" class="error" style=""><?=isset($newmodel->errors['o_pid'])?join('',$newmodel->errors['o_pid']):""?></span>
							<span class="help-inline rcolor"></span>
						</p></br>
						<p>
						<label class="weight">机构名称</label>
							<input type="hidden" name='o_code' value="">
							<input type="text" name='o_name' value="">
							<span for="o_name" class="error" style=""><?=isset($newmodel->errors['o_name'])?join('',$newmodel->errors['o_name']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
			<?php 	}elseif($type=='baomingdian'){?>
						<p>
							<label class="weight">所属学习中心</label>
							 <?php echo CHtml::DropDownList('o_pid','', Organization::model()->getOrByPid(0), array(
							"name"=>"o_pid",
							'empty'=>'请选择学习中心',
							'class'=>"pull-left")); ?>
							<span for="o_pid" class="error" style=""><?=isset($newmodel->errors['o_pid'])?join('',$newmodel->errors['o_pid']):""?></span>
							<span class="help-inline rcolor"></span>
						</p></br>
						<p>
							<label class="weight"><?=$show?>名称</label>
							<input type="text" name='o_name' value="">
							<span for="o_name" class="error" style=""><?=isset($newmodel->errors['o_name'])?join('',$newmodel->errors['o_name']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
						<p>
							<label class="weight"><?=$show?>代码</label>
							<input type="text" name='o_code' value="">
							<span for="o_code" class="error" style=""><?=isset($newmodel->errors['o_code'])?join('',$newmodel->errors['o_code']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
                        <p>
							<label class="weight"><?=$show?>本地区号</label>
							<input type="text" name='o_zone' value="">
							<span for="o_zone" class="error" style=""><?=isset($newmodel->errors['o_zone'])?join('',$newmodel->errors['o_zone']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
			<?php 	}else{?>
						<p>
							<label class="weight"><?=$show?>名称</label>
							<input type="hidden" name='o_pid' value="0">
							<input type="text" name='o_name' value="">
							<span for="o_name" class="error" style=""><?=isset($newmodel->errors['o_name'])?join('',$newmodel->errors['o_name']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
						<p>
							<label class="weight"><?=$show?>代码</label>
							<input type="text" name='o_code' value="">
							<span for="o_code" class="error" style=""><?=isset($newmodel->errors['o_code'])?join('',$newmodel->errors['o_code']):""?></span>
							<span class="	help-inline rcolor"></span>
						</p>
			<?php 	}?>
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
			$("#organizationForm").validate({
				// debug: true,
				autoCreateRanges:true	,
				errorClass: "error",
				errorElement: "span",
				rules: {
					<?php if($show=='机构'){?>
					zhongxin:'required',
					<?php }?>
					o_pid: 'required',
					o_name:'required',
					o_code:'required'
						
				},
				messages: {
					<?php if($show=='机构'){?>
					zhongxin:'请选择学习中心',
					<?php }?>
					o_pid:'请选择<?=$show=='报名点'?"学习中心":"报名点"?>',
					o_name:'请输入<?=$show?>名称',
					o_code:'请输入<?=$show?>代码'
				}
			});
		
		})
		</script>
	</div>
</div>
			

