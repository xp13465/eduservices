<?php
//require_once('util.php');
$this->breadcrumbs=array(
	'后台首页',
);
?>
<?php if(!$_POST){?>
<form method='post' action='' >
<input name='submit'  type='submit' value='执行' >
</form>
<?php }?>
<h1><?php echo $return?></h1>
<?php if($error)var_dump($error);?>
