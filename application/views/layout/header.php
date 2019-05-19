<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?=$title?></title>

		<meta name="description" content="top menu &amp; navigation" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?=base_url()?>assets/font-awesome/4.2.0/css/font-awesome.min.css" />
		<link rel="stylesheet" href="<?=base_url()?>assets/css/chosen.min.css" />
		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="<?=base_url()?>assets/css/datepicker.min.css" />
		<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="<?=base_url()?>assets/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap-datetimepicker.min.css" />
		<!-- text fonts -->
		
		<link rel="stylesheet" href="<?=base_url()?>assets/fonts/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?=base_url()?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?=base_url()?>assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?=base_url()?>assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="<?=base_url()?>assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?=base_url()?>assets/js/html5shiv.min.js"></script>
		<script src="<?=base_url()?>assets/js/respond.min.js"></script>
		<![endif]-->
		<script src="<?=base_url()?>assets/js/jquery.2.1.1.min.js"></script>
		<script src="<?=base_url()?>assets/js/jquery.formatCurrency-1.4.0.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="<?=base_url()?>assets/js/jquery.1.11.1.min.js"></script>
<![endif]-->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?=base_url()?>assets/js/jquery.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?=base_url()?>assets/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?=base_url()?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!-- ace scripts -->
		<script src="<?=base_url()?>assets/js/ace-elements.min.js"></script>
		<script src="<?=base_url()?>assets/js/ace.min.js"></script>
		<script src="<?=base_url()?>assets/js/bootbox.min.js"></script>
		<script src="<?=base_url()?>assets/js/jquery.maskedinput.min.js"></script>
		<script src="<?=base_url()?>assets/js/chosen.jquery.min.js"></script>
		<script src="<?=base_url()?>assets/js/bootstrap-tag.min.js"></script>
		<script src="<?=base_url()?>assets/js/bootstrap-datepicker.min.js"></script>
		<script src="<?=base_url()?>assets/js/bootstrap-timepicker.min.js"></script>
		<script src="<?=base_url()?>assets/js/daterangepicker.min.js"></script>
		<script src="<?=base_url()?>assets/js/jquery.sparkline.min.js"></script>
		<script src="<?=base_url()?>assets/js/jquery.flot.min.js"></script>
		<script src="<?=base_url()?>assets/js/jquery.flot.pie.min.js"></script>
		<script src="<?=base_url()?>assets/js/jquery.flot.resize.min.js"></script>
		<script src="<?=base_url()?>assets/js/fuelux.tree.min.js"></script>
		<script src="<?=base_url()?>assets/js/jquery.nestable.min.js"></script>
		<script src="<?=base_url()?>assets/js/highcharts.js"></script>
		<script src="<?=base_url()?>assets/js/numeral.min.js"></script>
		<script src="<?=base_url()?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?=base_url()?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="<?=base_url()?>assets/js/dataTables.tableTools.min.js"></script>
		<script src="<?=base_url()?>assets/js/dataTables.colVis.min.js"></script>
	</head>

	<body class="no-skin">
		<?=$this->load->view($navbar,'',TRUE)?>
		<?=$this->load->view($isi,'',TRUE)?>

		<!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		

		<!-- inline scripts related to this page -->
		<script type="text/javascript">

			function tampilpesan(pesan)
			{
				bootbox.dialog({
				message: "<span class='bigger-110'><h3>"+pesan+"</h2></span>",
				buttons: 			
						{
							"success" :
							 {
								"label" : "<i class='ace-icon fa fa-check'></i> OK",
								"className" : "btn-sm btn-success",
								"callback": function() {
									//Example.show("great success");
								}
							}
							
						}
					});
			}
			jQuery(function($) {
				//if(!ace.vars['touch']) {
				$('.dd').nestable();
			
				$('.dd-handle a').on('mousedown', function(e){
					e.stopPropagation();
				});
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});
			
			
					$('#chosen-multiple-style .btn').on('click', function(e){
						var target = $(this).find('input[type=radio]');
						var which = parseInt(target.val());
						if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
						 else $('#form-field-select-4').removeClass('tag-input-style');
					});
				//}
			var pesan='<?=$this->session->flashdata('pesan')?>';
			if(pesan!='')
			{
				bootbox.dialog({
				message: "<span class='bigger-110'><h3><?=$this->session->flashdata('pesan')?></h3></span>",
				buttons: 			
						{
							"success" :
							 {
								"label" : "<i class='ace-icon fa fa-check'></i> OK",
								"className" : "btn-sm btn-success",
								"callback": function() {
									//Example.show("great success");
								}
							}
							
						}
					});
			 }

			 // var $sidebar = $('.sidebar').eq(0);
			 // if( !$sidebar.hasClass('h-sidebar') ) return;
			
			 // $(document).on('settings.ace.top_menu' , function(ev, event_name, fixed) {
				// if( event_name !== 'sidebar_fixed' ) return;
			
				// var sidebar = $sidebar.get(0);
				// var $window = $(window);
			
				// //return if sidebar is not fixed or in mobile view mode
				// var sidebar_vars = $sidebar.ace_sidebar('vars');
				// if( !fixed || ( sidebar_vars['mobile_view'] || sidebar_vars['collapsible'] ) ) {
				// 	$sidebar.removeClass('lower-highlight');
				// 	//restore original, default marginTop
				// 	sidebar.style.marginTop = '';
			
				// 	$window.off('scroll.ace.top_menu')
				// 	return;
				// }
			
			
				//  var done = false;
				//  $window.on('scroll.ace.top_menu', function(e) {
			
				// 	var scroll = $window.scrollTop();
				// 	scroll = parseInt(scroll / 4);//move the menu up 1px for every 4px of document scrolling
				// 	if (scroll > 17) scroll = 17;
			
			
				// 	if (scroll > 16) {			
				// 		if(!done) {
				// 			$sidebar.addClass('lower-highlight');
				// 			done = true;
				// 		}
				// 	}
				// 	else {
				// 		if(done) {
				// 			$sidebar.removeClass('lower-highlight');
				// 			done = false;
				// 		}
				// 	}
			
				// 	sidebar.style['marginTop'] = (17-scroll)+'px';
				//  }).triggerHandler('scroll.ace.top_menu');
			
			 // }).triggerHandler('settings.ace.top_menu', ['sidebar_fixed' , $sidebar.hasClass('sidebar-fixed')]);
			
			 // $(window).on('resize.ace.top_menu', function() {
				// $(document).triggerHandler('settings.ace.top_menu', ['sidebar_fixed' , $sidebar.hasClass('sidebar-fixed')]);
			 // });
			
			
			});
		</script>
	</body>
</html>
