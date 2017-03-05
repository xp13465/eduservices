<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <title>学校公共服务体系系统-查看详细</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="acking">

    <!-- Le styles -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/global.css" rel="stylesheet">
    <link href="../css/admin.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../js/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <!-- <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a> -->
          <a class="brand" href="admin_manage.html">北京航空航天大学</a>
          <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> 您好，acking
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="#">个人设置</a></li>
              <li class="divider"></li>
              <li><a href="#">登出</a></li>
            </ul>
          </div>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Acking's admin <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">查看站点</a></li>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
                <li class="nav-header">学员管理</li>
                <li class="divider"></li>
                <li><a href="a_student_list.html"><i class="icon-list"></i> 学员列表</a></li>
                <li><a href="a_student_add.html"><i class="icon-plus-sign"></i> 学员添加</a></li>
                <li><a href="a_student_verify.html"><i class="icon-eye-open"></i> 学员审核(<span class="rcolor">2</span>)</a></li>
                <li class="nav-header">申报管理</li>
                <li class="divider"></li>
                <li><a href="#"><i class="icon-list"></i> 申报列表</a></li>
                <li><a href="a_student_add.html"><i class="icon-plus-sign"></i> 申报申请</a></li>
                <li class="nav-header">学校信息设置</li>
                <li class="divider"></li>
                <li><a href="a_school_institutions.html"><i class="icon-tasks"></i> 院校管理</a></li>
                <li><a href="a_school_specialty.html"><i class="icon-tasks"></i> 专业管理</a></li>
                <li>
                  <a class="t_nav" href="javascript:void(0);"><i class="icon-tasks"></i> 学习中心</a>
                  <ul class="nav sub-nav nav-list">
                      <li><a href="a_school_learning.html"><i class="icon-list"></i> 学习中心管理</a></li>
                      <li><a href="a_school_registration.html"><i class="icon-plus"></i> 报名点管理</a></li>
                      <li><a href="a_school_agency.html"><i class="icon-plus"></i> 机构管理</a></li>
                      <!-- <li><a href="a_school_map.html"><i class="icon-plus"></i> 中心附属列表</a></li> -->
                  </ul>
                </li>
                <li class="nav-header">帐号管理</li>
                <li class="divider"></li>
                <li class="active"><a href="a_account_list.html"><i class="icon-user"></i> 帐号列表</a></li>
                <li><a href="a_account_add.html"><i class="icon-user"></i> 帐号添加</a></li>
                <li class="divider"></li>
                <li class="nav-header">权限管理</li>
                <li class="divider"></li>
                <li><a href="#"><i class="icon-user"></i> 用户管理</a></li>
                <li><a href="#"><i class="icon-star-empty"></i> 权限设置</a></li>
                <li class="divider"></li>
                <li><a href="#"><i class="icon-flag"></i> 帮助</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span10">
          <ul class="breadcrumb ohidden">
            <li class="pull-left"><i class="icon-heart"></i> 帐号管理 > 帐号列表 > 查看详细</li>
            <li class="pull-right"><a href="a_student_list.html">返回列表》</a></li>
          </ul>

<div class="nocolumn column">
	<div>
		<dl class="dl-horizontal">
			<dt>帐号</dt><dd>acking</dd>
			<dt>负责人</dt><dd>刘德华</dd>
			<dt>负责人照片</dt><dd><img src="../img/photo.jpg" /></dd>
			<dt>联系电话</dt><dd>021-12345678</dd>
			<dt>手机号码</dt><dd>13600000000</dd>
			<dt>邮箱</dt><dd>19800101</dd>
			<dt>通讯地址</dt><dd>上海</dd>
			<dt>网址</dt><dd>汉</dd>
			<dt>所属学习中心</dt><dd>上海学习中心</dd>
			<dt>所属报名点</dt><dd>上海南汇报名点</dd>
			<dt>所属机构</dt><dd>华图教育</dd>
			<dt>帐号状态</dt><dd><span class="blcolor1">启用</span></dd>
		</dl>
	</div>
</div>



        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Company 2013</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/jquery.js"></script>
    <script src="../js/admin.js"></script>
    <script src="../js/bootstrap-transition.js"></script>
    <script src="../js/bootstrap-alert.js"></script>
    <script src="../js/bootstrap-modal.js"></script>
    <script src="../js/bootstrap-dropdown.js"></script>
    <script src="../js/bootstrap-scrollspy.js"></script>
    <script src="../js/bootstrap-tab.js"></script>
    <script src="../js/bootstrap-tooltip.js"></script>
    <script src="../js/bootstrap-popover.js"></script>
    <script src="../js/bootstrap-button.js"></script>
    <script src="../js/bootstrap-collapse.js"></script>
    <script src="../js/bootstrap-carousel.js"></script>
    <script src="../js/bootstrap-typeahead.js"></script>

  </body>
</html>