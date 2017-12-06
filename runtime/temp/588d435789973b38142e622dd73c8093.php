<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpStudy\PHPTutorial\WWW\Now\P2PApp\public/../application/admin\view\shop\shopList.html";i:1512472342;s:44:"../application/admin/view/common/header.html";i:1512435487;s:41:"../application/admin/view/common/nav.html";i:1512455057;}*/ ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>产品管理</title>
		<!-- basic styles -->
		<base href="__PUBLIC__">
		<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="assets/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- fonts -->

		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

		<!-- ace styles -->

		<link rel="stylesheet" href="assets/css/ace.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->

		<script src="assets/js/ace-extra.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<div class="navbar navbar-default" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-leaf"></i>
							ACE后台管理系统
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-blue">
							<a data-toggle="dropdown" href="javascript:void(0);" class="dropdown-toggle">
								<img class="nav-user-photo" src="assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>欢迎光临,</small>
									Jason
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="icon-cog"></i>
										设置
									</a>
								</li>

								<li>
									<a href="#">
										<i class="icon-user"></i>
										个人资料
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="__URL__/loginOut">
										<i class="icon-off"></i>
										退出
									</a>
								</li>
							</ul>
						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

				<div class="sidebar" id="sidebar">
	<script type="text/javascript">
		try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
	</script>

	<div class="sidebar-shortcuts" id="sidebar-shortcuts">
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<button class="btn btn-success">
				<i class="icon-signal"></i>
			</button>

			<button class="btn btn-info">
				<i class="icon-pencil"></i>
			</button>

			<button class="btn btn-warning">
				<i class="icon-group"></i>
			</button>

			<button class="btn btn-danger">
				<i class="icon-cogs"></i>
			</button>
		</div>

		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<span class="btn btn-success"></span>

			<span class="btn btn-info"></span>

			<span class="btn btn-warning"></span>

			<span class="btn btn-danger"></span>
		</div>
	</div><!-- #sidebar-shortcuts -->

	<ul class="nav nav-list">
		<li>
			<a href="index.html">
				<i class="icon-dashboard"></i>
				<span class="menu-text">首页</span>
			</a>
		</li>

		<li>
			<a href="javascript:void(0);" class="dropdown-toggle">
				<i class="icon-desktop"></i>
				<span class="menu-text"> 前台组件 </span>

				<b class="arrow icon-angle-down"></b>
			</a>

			<ul class="submenu">
				<li>
					<a href="javascript:void(0);" class="dropdown-toggle">
						<i class="icon-double-angle-right"></i>

						轮播图管理
						<b class="arrow icon-angle-down"></b>
					</a>

					<ul class="submenu">
						<li>
							<a href="slideshow/index">
								<i class="icon-plus"></i>
								添加新图片
							</a>
						</li>

						<li>
							<a href="slideshow/slideShow">
								<i class="icon-eye-open"></i>
								查看图片列表
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:void(0);" class="dropdown-toggle">
						<i class="icon-double-angle-right"></i>

						产品管理
						<b class="arrow icon-angle-down"></b>
					</a>

					<ul class="submenu">
						<li>
							<a href="shop/index">
								<i class="icon-plus"></i>
								添加新产品
							</a>
						</li>

						<li>
							<a href="shop/shopList">
								<i class="icon-eye-open"></i>
								查看产品列表
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</li>

		<li>
			<a href="javascript:void(0);" class="dropdown-toggle">
				<i class="icon-list"></i>
				<span class="menu-text"> 表格 </span>

				<b class="arrow icon-angle-down"></b>
			</a>

			<ul class="submenu">
				<li>
					<a href="tables.html">
						<i class="icon-double-angle-right"></i>
						简单 &amp; 动态
					</a>
				</li>

				<li>
					<a href="jqgrid.html">
						<i class="icon-double-angle-right"></i>
						jqGrid plugin
					</a>
				</li>
			</ul>
		</li>

		<li>
			<a href="javascript:void(0);" class="dropdown-toggle">
				<i class="icon-edit"></i>
				<span class="menu-text"> 表单 </span>

				<b class="arrow icon-angle-down"></b>
			</a>

			<ul class="submenu">
				<li>
					<a href="form-elements.html">
						<i class="icon-double-angle-right"></i>
						表单组件
					</a>
				</li>

				<li>
					<a href="form-wizard.html">
						<i class="icon-double-angle-right"></i>
						向导提示 &amp; 验证
					</a>
				</li>

				<li>
					<a href="wysiwyg.html">
						<i class="icon-double-angle-right"></i>
						编辑器
					</a>
				</li>

				<li>
					<a href="dropzone.html">
						<i class="icon-double-angle-right"></i>
						文件上传
					</a>
				</li>
			</ul>
		</li>
	</ul><!-- /.nav-list -->

	<div class="sidebar-collapse" id="sidebar-collapse">
		<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
	</div>

	<script type="text/javascript">
		try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
	</script>
</div>

				<div class="main-content">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="javascript:void(0);">Home</a>
							</li>

							<li>
								<a href="javascript:void(0);">Shop</a>
							</li>
						</ul><!-- .breadcrumb -->

						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
						</div><!-- #nav-search -->
					</div>

					<div class="page-content">
						<div class="page-header">
							<h1>
								商品
								<small>
									<i class="icon-double-angle-right"></i>
									商品 列表
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover" style="text-align:center;vertical-align:middle;">
												<thead>
													<tr>
														<th class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th>
														<!-- <th>ID</th> -->
														<th>名称</th>
														<th class="hidden-480">类型</th>

														<th>
															<i class="icon-time bigger-110 hidden-480"></i>
															年化率
														</th>
														<th class="hidden-480">项目金额</th>
														<th class="hidden-480">状态</th>
														<th>
															<i class="icon-time bigger-110 hidden-480"></i>
															项目期限
														</th>
														<th>
															<i class="icon-time bigger-110 hidden-480"></i>
															锁定期
														</th>
														<th>
															<i class="icon-time bigger-110 hidden-480"></i>
															上线时间
														</th>
														<th>已募集金额</th>
														<td>操作&nbsp;&nbsp;
															<a style="text-decoration:none" href="shop/index"><i title="去添加" class="icon-plus bigger-120"></i></a>
														</th>
													</tr>
												</thead>
						<tbody>
							<?php foreach ($data as $k => $v){?>
							<tr>
								<td class="center" style="vertical-align:middle;">
									<input type="checkbox" value="" class="ace" />
									<span class="lbl"></span>
								</td>
							<td style="vertical-align:middle;">
								<?=$v['sname']?>
							</td>
							<td style="vertical-align:middle;">
								<?php switch ($v['type']){
										case 0:
										  echo "3个月";break;
										case 1:
										  echo "6个月";break;
										case 2:
										  echo "一年";break;
										case 3:
										  echo "一年以上";break;
								}?>
							</td>
							<td style="vertical-align:middle;">
								<?php $res = $v['salary']*100;echo $res.'%';?>
							</td>
							<td style="vertical-align:middle;">
								<?=$v['money']?>
							</td>
							<td style="vertical-align:middle;">
								<?php switch ($v['status']){
										case 1:
										  echo "准备上线";break;
										case 2:
										  echo "正在募集";break;
										case 3:
										  echo "正在回款";break;
										case 4:
										  echo "回款完毕";break;
								}?>
							</td>
							<td style="vertical-align:middle;">
								<?=$v['time']?>
							</td>
							<td><?=$v['locktime']?></td>
							<td class="hidden-480" style="vertical-align:middle;">
								<?=$v['onlinetime']?>
							</td>
							<td style="vertical-align:middle;">
								<?=$v['intermoney']?>
							</td>

							<td style="vertical-align:middle;">
								<button class="btn btn-xs btn-danger killData" d="<?=$v['sid']?>">
									<i class="icon-trash bigger-120"></i>
								</button>
							</td>
							</tr>
							<?php }?>
						</tbody>

											</table>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
								</div><!-- /row -->

								<div id="modal-table" class="modal fade" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header no-padding">
												<div class="table-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
														<span class="white">&times;</span>
													</button>
													Results for "Latest Registered Domains
												</div>
											</div>

											<div class="modal-body no-padding">
												<table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
													<thead>
														<tr>
															<th>Domain</th>
															<th>Price</th>
															<th>Clicks</th>

															<th>
																<i class="icon-time bigger-110"></i>
																Update
															</th>
														</tr>
													</thead>

													<tbody>
														<tr>
															<td>
																<a href="#">ace.com</a>
															</td>
															<td>$45</td>
															<td>3,330</td>
															<td>Feb 12</td>
														</tr>

														<tr>
															<td>
																<a href="#">base.com</a>
															</td>
															<td>$35</td>
															<td>2,595</td>
															<td>Feb 18</td>
														</tr>

														<tr>
															<td>
																<a href="#">max.com</a>
															</td>
															<td>$60</td>
															<td>4,400</td>
															<td>Mar 11</td>
														</tr>

														<tr>
															<td>
																<a href="#">best.com</a>
															</td>
															<td>$75</td>
															<td>6,500</td>
															<td>Apr 03</td>
														</tr>

														<tr>
															<td>
																<a href="#">pro.com</a>
															</td>
															<td>$55</td>
															<td>4,250</td>
															<td>Jan 21</td>
														</tr>
													</tbody>
												</table>
											</div>

											<div class="modal-footer no-margin-top">
												<button class="btn btn-sm btn-danger pull-left" data-dismiss="modal">
													<i class="icon-remove"></i>
													Close
												</button>

												<ul class="pagination pull-right no-margin">
													<li class="prev disabled">
														<a href="#">
															<i class="icon-double-angle-left"></i>
														</a>
													</li>

													<li class="active">
														<a href="#">1</a>
													</li>

													<li>
														<a href="#">2</a>
													</li>

													<li>
														<a href="#">3</a>
													</li>

													<li class="next">
														<a href="#">
															<i class="icon-double-angle-right"></i>
														</a>
													</li>
												</ul>
											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div><!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->

				<div class="ace-settings-container" id="ace-settings-container">
					<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
						<i class="icon-cog bigger-150"></i>
					</div>

					<div class="ace-settings-box" id="ace-settings-box">
						<div>
							<div class="pull-left">
								<select id="skin-colorpicker" class="hide">
									<option data-skin="default" value="#438EB9">#438EB9</option>
									<option data-skin="skin-1" value="#222A2D">#222A2D</option>
									<option data-skin="skin-2" value="#C6487E">#C6487E</option>
									<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
								</select>
							</div>
							<span>&nbsp; Choose Skin</span>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
							<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
							<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
							<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
							<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
							<label class="lbl" for="ace-settings-add-container">
								Inside
								<b>.container</b>
							</label>
						</div>
					</div>
				</div><!-- /#ace-settings-container -->
			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.js"></script>

		<!-- ace scripts -->

		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($) {
				var oTable1 = $('#sample-table-2').dataTable( {
				"aoColumns": [
			      { "bSortable": false },
			      null, null,null, null, null,
				  { "bSortable": false }
				] } );
				
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
			
			
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			})
		</script>
	<div style="display:none"><script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'></script></div>
</body>
</html>
<script>
	$(document).on('click','.killData',function(){
		var d = $(this).attr('d');
		var obj = $(this).parent().parent();
		$.ajax({
			url:"__URL__/killData",
			data:{'d':d},
			type:"post",
			dataType:"json",
			success:function(text){
				if(text.code == 200){
					alert(text.msg);
					obj.remove();
				}else{
					alert(text.msg)
				}
			}
		})
	});
	$(document).on('click','.clickSet',function(){
		var s = $(this).attr('status');
		var d = $(this).parent().next().children().eq(0).attr('d');
		var obj = $(this).children().eq(0);
		$.ajax({
			url:"__URL__/clintSet",
			data:{'s':s,'d':d},
			type:"post",
			dataType:"json",
			success:function(text){
				if(text.code == 200){
					alert(text.msg);
					if(s==1){
					    obj.attr('class','icon-remove bigger-120');
					}else{
						obj.attr('class','icon-ok bigger-120');
					}
				}else{
					alert(text.msg)
				}
			}
		})
	})
</script>