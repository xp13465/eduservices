<div class="copyright png_bg" style=" border:0px solid red;">
Copyright © 2012 <a href="#"><?=Yii::app()->name?>-<?=Config::model()->getConfig('Name');?></a>&nbsp;&nbsp;&nbsp;&nbsp;<?=Config::model()->getConfig('ICP');?><br>
地址：<?=Config::model()->getConfig('ContactAddress');?> 邮编：<?=Config::model()->getConfig('ZipCode');?> 电话：<?=Config::model()->getConfig('TEL');?>
</div>
<!-- end of copyright -->
</div>


<script type="text/javascript">
//<![CDATA[
function nTabs(thisObj, Num) {
if (thisObj.className == 'active') return;
var tabObj = thisObj.parentNode.id;
var tabList = document.getElementById(tabObj).getElementsByTagName('li');
for (i = 0; i < tabList.length; i++) {
if (i == Num) {
thisObj.className = 'active';
document.getElementById(tabObj + '_Content' + i).style.display = 'block';
} else {
tabList[i].className = 'normal';
document.getElementById(tabObj + '_Content' + i).style.display = 'none';
}
}
}//]]>
</script>

<?php /*
<div>
<!--     <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="looyuShare" height="1" width="1">
        <param name="movie" value="/swf/looyu2.swf">
        <param name="allowScriptAccess" value="always">
        <embed src="swf/looyu2.swf" allowscriptaccess="always" name="looyuShare" type="application/x-shockwave-flash" height="1" width="1">
    </object> -->
</div>

<div class="doyoo_pan_icon" style="position: fixed; top: 180px; right: 5px; width: 90px; height: 135px; background:url('images/pic.gif'); display: block;" id="doyoo_panel">
    <div class="doyoo_pan_icon_inner" id="looyu_dom_0"><a href="#" id="looyu_dom_1" style="display:block;width:100%;height:100%;">&nbsp;</a></div>
</div>*/?>