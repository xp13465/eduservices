<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);

$this->breadcrumbs=array(
	'学校信息设置'=>array("professional/index"),
	'院校管理',
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
			<form action="">
				<span>搜索：</span>				
				<?php 
						$isprovince=isset($_GET['s_province'])?$_GET['s_province']:"";
						echo CHtml::DropDownList('s_province',$isprovince, Province::model()->getAllP(), array(
							"name"=>"s_province",
							'empty'=>'请选择省份'));				
				
				?>
				<input class="wauto" type="text" name='s_name' onfocus='checkifocus("院校名称..",this)' onblur='checkiout("院校名称..",this)' value="<?=isset($_GET['s_name'])?$_GET['s_name']:"院校名称.."?>">
				<?php /*<input class="wauto" type="text" name='s_name' onfocus='checkifocus("<?=$show?>代码..",this)' onblur='checkiout("<?=$show?>代码..",this)' value="<?=$show?>代码..">*/?>
				<button type="submit" class="btn btn-inverse serach">搜索</button>
			</form>
		</div>
		<div>
			<table class="table table-bordered specialtylist">
				<?php 
				$get=$_GET;
				if(isset($_GET['order'])&&in_array($_GET['order'],array("ku","kd"))){
					$tmp=$_GET['order']=="ku"?"↑":"↓";
					$get['order']=$_GET['order']=="ku"?"kd":"";
					$tmpUrl=Yii::app()->createUrl("admin/professional/index",$get);
				}else{
					$tmp="↑↓";
					$get['order']="ku";
					$tmpUrl=Yii::app()->createUrl("admin/professional/index",$get);
				} ?>
				<thead>
					<tr>
					<th width="3%"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value=""></th>
					<th width="22%">院校名称 <a class="order" href="">↓</a></th>
					<th width="20%">院校代码</th>
					<th width="14%">院校省份</th>
					<th width="8%">简写</th>
					<th width="8%">全写</th>
					<th width="20%">操作</th>
					</tr>
				</thead>
				<tbody>
				<?php 	if(!$Arrays){?>
							<tr>
							<td colspan='11'>没有找到数据</td>
							</tr>
				<?php 	}else{
							foreach($Arrays as $key=>$data){
                                if($this->beginCache("school_view_{$key}", array('duration'=>5))) {         
								$this->renderPartial('_view',array("data"=>$data,"key"=>$key));
                                $this->endCache(); }
							}
						}?>
				</tbody>
			</table>
		</div>
		<div class="clear ohidden">
			<p class="pull-left">
				<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
				<a class="btn btn-danger" href="javascript:GetCheckbox('school')"><i class="icon-trash icon-white"></i> 删除</a>
                <a class="btn btn-info" href="<?=Yii::app()->createUrl("admin/school/inportupdateschool")?>"><i class="icon-arrow-up icon-white"></i>导入</a>
				<a class="btn" href="javascript:window.location.reload()"><i class="icon-refresh"></i> 刷新</a>
			</p>
			<p class="input-append pull-right">
				<input class="width60" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("s_pagesize",this.value)}' type="text" value="<?=isset($_COOKIE['s_pagesize'])?$_COOKIE['s_pagesize']:"20"?>">
				<button class="btn btn-info" type="button" onclick='setpagesize("s_pagesize",$("#pagesize").val())'>设置每页显示条数</button>
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
		<h2>添加新院校</h2>
		<div class="ohidden well">
			<form class="form-horizontal" id='schoolForm' action="" method="post">
						<p>
							<label class="weight">院校名称</label>
							<input type="text" name='s_name' value="<?=$newmodel->s_name?>">
							<span for="s_name" class="error" style=""><?=isset($newmodel->errors['s_name'])?join('',$newmodel->errors['s_name']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
						<p>
							<label class="weight">院校代码</label>
							<input type="text" name='s_code' value="<?=$newmodel->s_code?>">
							<span for="s_code" class="error" style=""><?=isset($newmodel->errors['s_code'])?join('',$newmodel->errors['s_code']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
						<p>
							<label class="weight">院校省份</label>
							 <?php echo CHtml::DropDownList('s_province',$newmodel->s_province, Province::model()->getAllP(), array(
							"name"=>"s_province",
							'empty'=>'请选择所属省份'
							)); ?>
							<span for="s_province" class="error" style=""><?=isset($newmodel->errors['s_province'])?join('',$newmodel->errors['s_province']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
						</br>
						<p>
							<label class="weight">院校沿革历史</label>
							<input type="text" name='s_history' value="<?=$newmodel->s_history?>">
							<span for="s_history" class="error" style=""><?=isset($newmodel->errors['s_history'])?join('',$newmodel->errors['s_history']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
						<p>
							<label class="weight">院校拼音简写</label>
							<input type="text" name='s_pinyinsuoxie' value="<?=$newmodel->s_pinyinsuoxie?>">
							<span for="s_pinyinsuoxie" class="error" style=""><?=isset($newmodel->errors['s_pinyinsuoxie'])?join('',$newmodel->errors['s_pinyinsuoxie']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
						<p>
							<label class="weight">院校拼音全写</label>
							<input type="text" name='s_pinyinlongname' value="<?=$newmodel->s_pinyinlongname?>">
							<span for="s_pinyinlongname" class="error" style=""><?=isset($newmodel->errors['s_pinyinlongname'])?join('',$newmodel->errors['s_pinyinlongname']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
		
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
			$("#schoolForm").validate({
				// debug: true,
				autoCreateRanges:true	,
				errorClass: "error",
				errorElement: "span",
				rules: {
					s_name: 'required',
					s_province: 'required',
					s_code: 'required'
				},
				messages: {
					s_name: '请输入院校名称',
					s_province: '请选择院校省份',
					s_code: '请输入院校代码'
				}
			});
		
		})
		</script>
	</div>
</div>
			

