<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);

$this->breadcrumbs=array(
	'学校信息设置',
	'批次管理',
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
						<th width="5%"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value=""></th>
						
						<th width="15%">序号 [ID]</th>
						<th width="30%">批次名称</th>
						<th width="20%">批次状态 </th>
						
						<th width="30%">操作 </th>
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
				<a class="btn btn-danger" href="javascript:GetCheckbox('pici')"><i class="icon-trash icon-white"></i> 删除</a>
				<?php /*
                <a class="btn btn-danger" href="javascript:StatusAll('pici',1)"><i class="icon-trash icon-white"></i> 禁用</a>
                <a class="btn btn-danger" href="javascript:StatusAll('pici',2)"><i class="icon-trash icon-white"></i> 启用</a>
                */?>
                <a class="btn" href="javascript:window.location.reload()"><i class="icon-refresh"></i> 刷新</a>
                <font size='-3' color='#999'>(启用代表可录可搜，禁用代表只可搜，删除则无记录)</font>
			</p>
			<p class="input-append pull-right">
				<input class="width60" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("pc_pagesize",this.value)}' type="text" value="<?=isset($_COOKIE['pc_pagesize'])?$_COOKIE['pc_pagesize']:"20"?>">
				<button class="btn btn-info" type="button" onclick='setpagesize("pc_pagesize",$("#pagesize").val())'>设置每页显示条数</button>
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
		<h2>添加新批次</h2>
		<div class="ohidden well">
			<form class="form-horizontal" id='piciForm' action="" method="post">
			
						<p>
						<label class="weight">批次名称</label>
							<input type="text" name='p_value' value="">
							<span for="p_value" class="error" style=""><?=isset($newmodel->errors['p_value'])?join('',$newmodel->errors['p_value']):""?></span>
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
			$("#piciForm").validate({
				// debug: true,
				autoCreateRanges:true	,
				errorClass: "error",
				errorElement: "span",
				rules: {
					p_value:{
                        required:true
                        // number:true
                    }
				},
				messages: {
					p_value:{
                        required:'批次为必填项'
                        // number:'必须为数字'
                    }
				}
			});
		
		})
		</script>
	</div>
</div>
			

