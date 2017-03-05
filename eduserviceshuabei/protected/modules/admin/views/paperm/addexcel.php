<?php
$this->breadcrumbs=array(
	'新建Excel试卷页面'
);
?>
<div class="bs-docs-example">
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a data-toggle="tab" href="#home">基本信息</a></li>
		<li class=""><a data-toggle="tab" href="#profile">高级设置</a></li>
	</ul>
	<div class="tab-content" id="myTabContent">
		<!--基本信息 Begin-->
		<div id="home" class="tab-pane fade active in">
			<label>
				<span>试卷名称：</span><input class="span6" type="text" name="" value="WORD考试">
			</label>
			<label>
				<span>显示方式：</span>
				<select class="span2">
					<option>一屏显示所有题目</option>
					<option>一屏显示一道题目</option>
					<option>一屏显示一种题目</option>
				</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span>最多考试次数：</span>
				<input class="span2" type="text" name="" value="1">
			</label>
			<label>
				<span>试卷名称：</span>
				<div class="input-append">
					<input type="text" value="WORD考试" name="" class="input-xxlarge">
					<button class="btn" type="submit">Search</button>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FF6600">查看模版</font>
			</label>
			<div class="show-grid">
				<div class="span4" style="border: 1px solid #ddd; height:150px;">
					<label><font color="#003399">时间参考：</font></label>
					<label style="padding-top:5px;">
						<span class="tjk-inline">有效开始时间：</span>
						<input class="span5" type="text" name="" value="2013-01-09 15：49：18">
					</label>
					<label style="padding-top:5px;">
						<span class="tjk-inline">有效终止时间：</span>
						<input class="span5" type="text" name="" value="2013-01-09 15：49：18">
					</label>
				</div>
				<div class="span4" style="border: 1px solid #ddd; height:150px;">
					<label><font color="#003399">考试计时选项：</font></label>
					<label class="radio" style="margin-left:5px; padding-top:5px;">
						<input class="" type="radio" checked="" value="option1" name="optionsRadios">&nbsp;考试不计时
					</label>
					<label class="radio" style="margin-left:5px;padding-top:5px;">
						<input class="" type="radio" checked="" value="option1" name="optionsRadios">&nbsp;统一交卷
					</label>
					<label class="radio" style="margin-left:5px;">
						<input style="margin-top:10px;" type="radio" checked="" value="option1" name="optionsRadios">&nbsp;答题时间<input class="span2" type="text" name="" value="60">分钟
					</label>
				</div>
			</div>
			<div class="clear" style="padding-top:5px;">
				<label><font color="#003399">防舞弊：</font></label>
				<div class="show-grid">
					<div class="span4">
						<label style="padding-top:5px;">
							<input type="checkbox" name="" value="">&nbsp;&nbsp;考试分数保密
						</label>
						<label style="padding-top:5px;">
							<input type="checkbox" name="" value="">&nbsp;&nbsp;选择题候选项随机
						</label>
					</div>
					<div class="span4">
						<label class="radio" style="margin-left:5px; padding-top:5px;">
							<input class="" type="radio" checked="" value="option1" name="optionsRadios">&nbsp;不限制移出WEB页
						</label>
						<label class="radio" style="margin-left:5px;">
							<input style="margin-top:10px;" type="radio" checked="" value="option1" name="optionsRadios">&nbsp;移出考试页面达到<input class="span2" type="text" name="" value="5">次判为舞弊自动交卷
						</label>
					</div>
				</div>
			</div>
			<div class="clear" style="padding-top:5px;">
				<label><font color="#003399">考试安全：</font></label>
				<div class="show-grid">
					<div class="span4">
						<label style="padding-top:5px;">
							<input type="checkbox" name="" value="">&nbsp;考试分数保密
						</label>
					</div>
					<div class="span4">
						<label style="padding-top:5px;">
							<input type="checkbox" name="" value="">&nbsp;允许考生交卷后查看答卷和答案
						</label>
					</div>
				</div>
			</div>
			<div class="clear" style="padding-top:5px;">
				<label><font color="#003399">试卷安全：</font></label>
				<label class="radio" style="margin-left:5px;padding-top:5px;">
					<input type="radio" checked="" value="option1" name="optionsRadios">&nbsp;不支持中途保存答卷，不支持恢复考试功能
				</label>
				<label class="radio" style="margin-left:5px;padding-top:5px;">
					<input type="radio" checked="" value="option1" name="optionsRadios">&nbsp;手工保存答卷：考试过程中允许考生手工保存答卷，允许中途退出考试，适合布置不计时的作业
				</label>
				<label class="radio" style="margin-left:5px;padding-top:5px;">
					<input style="margin-top:12px;" type="radio" checked="" value="option1" name="optionsRadios">&nbsp;每隔<input class="span1" type="text" name="" value="5">分钟自动保存答卷（只能输入正整数）
				</label>
				<label class="radio" style="margin-left:5px;padding-top:5px;">
					<input type="radio" checked="" value="option1" name="optionsRadios">&nbsp;启用本地缓存功能：在考试机器中即时保存答卷，出错后可以恢复答卷（推荐）
				</label>
			</div>
			<label>
				试卷说明：<input class="span3" type="text" name="" value="2013-1-9测试账号定义网上考试">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				顺序号：<input class="span1" type="text" name="" value="390">
			</label>
			<div>
				<label><font color="#FF6600">友情提示</font></label>
				<hr style="border:1px dashed #A0A0A0;">
				<ul>
					<li><font color="#A0A0A0">移出考试页面次数限制不宜过低，建议在三次以上，试卷内容包含flash格式附件的，建议不进行移出页面控制。</font></li>
				</ul>
			</div>
		</div>
		<!--基本信息 End-->
		
		<!--高级设置 Begin-->
		<div id="profile" class="tab-pane fade">
			<div class="clear" style="margin-left:10px;">
				<label><font color="#003399">考生及评卷人</font></label>
				<label class="radio">
					<input type="radio" class="" name="optionsRadios" value="option1" checked>&nbsp;允许所有账户参加考试
				</label>
				<label class="radio">
					<input type="radio" class="" name="optionsRadios" value="option1" checked>&nbsp;在考试控制台中安排学生考试
				</label>
				<label>
					<span>阅卷人员：</span>
					<div class="input-append">
						<input type="text" class="span10" name="" value="2013-01-09 15：49：18">
						<button type="submit" class="btn">选&nbsp;&nbsp;择</button>
					</div>
				</label>
			</div>
			<div class="clear" style="margin-left:10px;padding-top:15px;">
				<label><font color="#003399">题型与分数设置</font></label>
				<label class="radio">
					<span>总分：</span><input class="span1" type="text" name="" value="100"/>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span>及格分：</span><input class="span1" type="text" name="" value="60"/>
				</label>
				<div>
					<label><font color="#FF6600">友情提示</font></label>
					<hr style="border:1px dashed #A0A0A0;">
					<ul>
						<li><font color="#A0A0A0">选择“在考试控制台中安排考生考试”的试卷，需要在“考试管理”中指定参加考试的学员。</font></li>
					</ul>
				</div>
			</div>
		</div>
		<!--高级设置 End-->
	</div>
</div>