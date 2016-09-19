<?php if (!defined('IS_SECURITY')) exit(); /*a:3:{s:60:"E:\Workspace\Norma_Code\src\manage/home\view\app\detail.html";i:1474277084;s:63:"E:\Workspace\Norma_Code\src\manage/home\view\Public\header.html";i:1474181261;s:64:"E:\Workspace\Norma_Code\src\manage/home\view\Public\sidebar.html";i:1474275907;}*/ ?>
<!doctype html>
<html class="no-js fixed-layout">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Norma框架构建管理系统</title>
    <meta name="description" content="Norma框架构建管理系统">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="/assets/favicon.png">
    <link rel="icon" type="image/icon" href="/assets/favicon.icon">
    <link rel="apple-touch-icon-precomposed" href="/assets/amazeui/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="stylesheet" href="/assets/amazeui/css/amazeui.min.css" />
    <link rel="stylesheet" href="/assets/amazeui/css/admin.css">
</head>

<body>
    <!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->
    <header class="am-topbar am-topbar-inverse admin-header">
        <div class="am-topbar-brand">
            <strong>Norma</strong> <small>框架构建管理系统</small>
        </div>
        <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>
        <div class="am-collapse am-topbar-collapse" id="topbar-collapse">
            <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
                <!-- <li><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱 <span class="am-badge am-badge-warning">5</span></a></li> -->
                <li class="am-dropdown" data-am-dropdown>
                    <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
                        <span class="am-icon-users"></span> 管理员设置 <span class="am-icon-caret-down"></span>
                    </a>
                    <ul class="am-dropdown-content">
                        <li><a href="#"><span class="am-icon-user"></span> 管理员列表</a></li>
                        <li><a href="#"><span class="am-icon-user"></span> 新增管理员</a></li>
                    </ul>
                </li>
                <li><a href="#"><span class="am-icon-power-off"></span> 退出登陆</a></li>
               <!--  <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li> -->
            </ul>
        </div>
    </header>
    <div class="am-cf admin-main">
        <!-- sidebar start -->
        <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">
        <ul class="am-list admin-sidebar-list">
            <li><a href="#"><span class="am-icon-home"></span> 首页</a></li>
            <li class="admin-parent">
                <a class="am-cf" data-am-collapse="{target: '#model-collapse-nav'}"><span class="am-icon-user-md"></span> 配置管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                <ul class="am-list am-collapse admin-sidebar-sub" id="model-collapse-nav">
                    <!-- <li><a href="<?php echo Url('app/config',array('appid'=>10000)); ?>" class="am-cf"><span class="am-icon-check"></span> 配置设置<span class="am-fr am-margin-right admin-icon-yellow"></span></a></li> -->
                </ul>
            </li>
        </ul>
    </div>
</div>

        <!-- sidebar end -->
        <!-- content start -->
        <div class="admin-content">
            <div class="admin-content-body">
                <div class="am-cf am-padding">
                    <div class="am-fl am-cf"><strong class="am-text-primary">应用设置</strong> </div>
                </div>
                <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list">
                    <li><a href="<?php echo Url('config/detail',array('appid'=>10000,'item'=>'base')); ?>" class="am-text-success"><span class="am-icon-btn am-icon-file-text"></span><br/>基本设置</a></li>
                    <li><a href="<?php echo Url('Config/detail',array('appid'=>10000,'item'=>'module')); ?>" class="am-text-success"><span class="am-icon-btn am-icon-file-text"></span><br/>模块设置</a></li>
                    <li><a href="<?php echo Url('Config/detail',array('appid'=>10000,'item'=>'url')); ?>" class="am-text-success"><span class="am-icon-btn am-icon-file-text"></span><br/>URL设置</a></li>
                    <li><a href="<?php echo Url('Config/detail',array('appid'=>10000,'item'=>'template')); ?>" class="am-text-success"><span class="am-icon-btn am-icon-file-text"></span><br/>模板设置</a></li>
                </ul>
                 <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list">
                    <li><a href="<?php echo Url('Config/detail',array('appid'=>10000,'item'=>'error')); ?>" class="am-text-success"><span class="am-icon-btn am-icon-file-text"></span><br/>异常及错误设置</a></li>
                </ul>
            </div>
            <div class="admin-content-body">
                <div class="am-cf am-padding">
                    <div class="am-fl am-cf"><strong class="am-text-primary">应用模块</strong> </div>
                </div>
                <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list">
                    <li><a href="<?php echo Url('app/detail',array('appid'=>10000)); ?>" class="am-text-success"><span class="am-icon-btn am-icon-file-text"></span><br/>Manage应用</a></li>
                </ul>
            </div>
            <footer class="admin-content-footer">
                <hr>
                <p class="am-padding-left">© 2016 Lunnlew 提供技术支持。</p>
            </footer>
        </div>
        <!-- content end -->
    </div>
    <a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>
    <!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/assets/amazeui/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
    <!--[if (gte IE 9)|!(IE)]><!-->
    <script src="/assets/amazeui/js/jquery.min.js"></script>
    <!--<![endif]-->
    <script src="/assets/amazeui/js/amazeui.min.js"></script>
    <script src="/assets/amazeui/js/app.js"></script>
    <!-- poshytip -->
    <link href="/assets/poshytip-1.2/tip-yellowsimple/tip-yellowsimple.css" rel="stylesheet">
    <script src="/assets/poshytip-1.2/jquery.poshytip.min.js"></script>
    <link href="/assets/jquery-editable/css/jquery-editable.css" rel="stylesheet" />
    <script src="/assets/jquery-editable/js/jquery-editable-poshytip.min.js"></script>
</body>
</html>
