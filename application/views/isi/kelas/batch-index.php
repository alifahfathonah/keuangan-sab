<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<?=$this->load->view('layout/top-menu','',TRUE)?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">
						<div class="row">
							<div class="col-xs-12">
								<div class="page-header">
									<h1>
										Kelas
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Data Batch Kelas
										</small>
									</h1>
								</div><!-- /.page-header -->

								<div class="row">
									<div class="col-xs-12">
										<div class="tabbable">
												<ul class="nav nav-tabs navtabs" id="myTab" role="tablist">
													<li class="active">
														<a data-toggle="tab" href="#home">
															Batch Aktif
														</a>
													</li>

													<li>
														<a data-toggle="tab" href="#nonaktif">
															Batch Tidak Aktif
														</a>
													</li>
													<li>
														<a data-toggle="tab" href="#aturulang">
															Atur Ulang Siswa Kelas
														</a>
													</li>
													


												</ul>

												<div class="tab-content kontenutama" id="kontenutama">
													<div id="home" class="tab-pane fade in active">
														<div class="row">
															<div class="col-xs-9">
																<center>
																	<div id="loader-data"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
																</center>
																<div id="data"></div>
															</div>
															<div class="col-xs-3">
																<center>
																	<div id="loader-form"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
																</center>
																<div id="form"></div>
															</div>
														</div>
													</div>

													<div id="aturulang" class="tab-pane fade">
														<div class="row">
															<div class="col-xs-9">
									<form class="form-horizontal" role="form" id="simpanjarak">
										<div class="form-group">
											<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tahun Ajaran </label>

											<div class="col-sm-3">
												<select name="tahun_ajaran_atur" id="tahun_ajaran_atur" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 chosen-select">
													<option value="">Pilih Tahun Ajaran</option>
													<?php
													foreach ($ta as $k => $v)
													{
														
														echo '<option value="'.$v->tahun_ajaran.'">'.$v->tahun_ajaran.'</option>';
														
													}
													?>
												</select>
											</div>
											<div class="col-sm-2">
												<button class="btn btn-sm btn-primary" type="button" id="btnaturulang">Atur Ulang</button>
											</div>
										</div>
									</form>
															</div>
														</div>
													</div>
													<div id="nonaktif" class="tab-pane fade">
														<div class="row">
															<div class="col-xs-9">
																<center>
																	<div id="loader-datanon"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
																</center>
																<div id="datanonaktif"></div>
															</div>
															<div class="col-xs-3">
															</div>
														</div>
													</div>


												</div>
											</div>
										</div>
										<!-- PAGE CONTENT BEGINS -->

										<!-- PAGE CONTENT ENDS -->
									</div><!-- /.col -->
								</div><!-- /.row -->

							</div>

						</div>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?=$this->load->view($footer,'',TRUE)?>

<script type="text/javascript">
		
	jQuery(function($){
		$('#tahun_ajaran_atur').select();
		$('#loader-data').show();
		$('#loader-datanon').show();
		$('#loader-form').show();
		$('#data').load('<?=site_url()?>kelas/batchdata/t',function(){
			$('#loader-data').hide();
		});
		$('#datanonaktif').load('<?=site_url()?>kelas/batchdata/f',function(){
			$('#loader-datanon').hide();
		});
		$('#form').load('<?=site_url()?>kelas/batchform/-1',function(){
			$('#loader-form').hide();
		});

		$('#btnaturulang').on('click',function(){
			var ta=$('#tahun_ajaran_atur').val();
			ta=ta.replace(/\//g,'_');
			ta=ta.replace(/ /g,'%20');
			// alert(ta);
			bootbox.confirm("<h3>Yakin Ingin Mengatur Ulang Data Kelas Pada Tahun Ajaran ini ?? </h3>", function(result) {
				if(result)
				{
					$.ajax({
						url : '<?=site_url()?>kelas/aturulang/'+ta,
						success : function(a)
						{
							// alert(a);
							tampilpesan(a);
						}
					});
				}
			});
		});

		$(".navtabs").on("click", "a", function (e) {
		        e.preventDefault();
		       	$(this).tab('show');

		       	var idd=$(this).attr("href");
		       	// var iddd=$(this).parent().attr("id");
		       	// var text=$(idd).text();
		       	// alert(idd);
		        // $('a[href="'+idd+'"]').tab('show');
		        $('.kontenutama div').removeClass('active').removeClass('in');
		       	$('.kontenutama div'+idd+'').attr('class','tab-pane fade active in');
		       	// $('.tab-content div#home3').attr('class','active');
		       	// alert(idd);
		       	// $('div#kontentab div').first().attr('id','active');
		        // $('.kontentab div').removeClass('active').removeClass('in');
		        // $(".nav-tabs3 li").first().attr('href');
		       	$(idd+' .nav-tabs3 li').removeClass('active').removeClass('in');
		       	$(idd+' .nav-tabs3 li').first().attr('class','tab-pane active in');
		       	// $(idd+' .kontentab div').first().attr('id');

		       	$(idd+' .kontentab div').removeClass('active').removeClass('in');
		       	$(idd+' .kontentab div').first().attr('class','tab-pane active in');
		       	// alert(x);
		    }).on("click", "span", function () {
		        var anchor = $(this).siblings('a');
		        $(anchor.attr('href')).remove();
		        $(this).parent().remove();
		       	$('.kontenutama div'+anchor.attr('href')+'').remove();

		       	// var idd=$(this).attr("href");
		        // alert(anchor.attr('href'));
		        $(".navtabs li").children('a').first().click();
		        $('a[href="#home"]').tab('show');
		        $('.kontenutama div').removeClass('active').removeClass('in');
		       	$('.kontenutama div#home').attr('class','tab-pane fade active in');
		    });
	});

	function nonaktifbatch()
	{
		var c=confirm('Yakin Ingin Menonaktifkan Seluruh Batch ?');
		if(c)
		{
			var id_batch=$('#idbatch_kelas').val();
			// alert('a');
			$.ajax({
				url : '<?=site_url()?>kelas/hapusbatchsemua',
				type : 'POST',
				data : {'id_batch':id_batch},
				success:function(a)
				{
					alert(a);
					// $('#loader-data').show();
					// $('#data').load('<?=site_url()?>kelas/batchdata/t',function(){
					// 	$('#loader-data').hide();
					// });
					// $('#datanonaktif').load('<?=site_url()?>kelas/batchdata/f',function(){
					// 	$('#loader-datanon').hide();
					// });
				}
			});
			
		}
	}
	function edit(id)
	{
		$('#loader-form').show();

		$('#form').load('<?=site_url()?>kelas/batchform/'+id,function(){

			$('#loader-form').hide();
		});
		//$('.nav-tabs a[href="#messages"]').tab('show');
	}
	function hapus(id)
	{
		bootbox.confirm("<h3>Yakin Ingin Menghapus Data ini ?? </h3>", function(result) {
					if(result)
					{
						$.ajax({
							url : '<?=site_url()?>kelas/batchhapus/'+id,
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#loader-data').show();
								$('#loader-datanon').show();
								$('#data').load('<?=site_url()?>kelas/batchdata/t',function(){
									$('#loader-data').hide();
								});
								$('#datanonaktif').load('<?=site_url()?>kelas/batchdata/f',function(){
									$('#loader-datanon').hide();
								});

							}
						});
					}
				});
	}



	function ubahstatus(id,status)
	{
		bootbox.confirm("<h3>Yakin Ingin Menonaktifkan Data ini ?? </h3>", function(result) {
					if(result)
					{
						$.ajax({
							url : '<?=site_url()?>kelas/batchubahstatus/'+id+'/'+status,
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								$('#loader-data').show();
								$('#loader-datanon').show();
								$('#data').load('<?=site_url()?>kelas/batchdata/t',function(){
									$('#loader-data').hide();
								});
								$('#datanonaktif').load('<?=site_url()?>kelas/batchdata/f',function(){
									$('#loader-datanon').hide();
								});
							}
						});
					}
				});
	}

	function detail(id,title)
	{
		$('#myTab').append('<li><a data-toggle="tab" href="#detailId'+id+'">'+ title +'</a><span><i class="red fa fa-remove bigger=120" style="float:right;margin-top:-42px;position:relative;z-index:1000;cursor:pointer"></i></span></li>');
	    // $('.tabs a:last').tab('show');
	    $('#myTab a:last').tab('show');
	    //this remove the active content
	    $('div.active').removeClass('active').removeClass('in');
	    //this add the new content
	    $('.kontenutama').append('<div id="detailId'+id+'" class="tab-pane fade in active" ><center>\
				<div id="loader-detail_'+id+'"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>\
			</center></div>');
	    // $('.nav-tabs a[href="#detailId'+id+'"]').tab('show');

			$('#loader-detail_'+id).show();
	    $('div#detailId'+id).load('<?=site_url()?>kelas/batchdetail/'+id,function(){
				$('#loader-detail_'+id).hide();
			});
	}
</script>

<style>
#tahun_ajaran_atur_chosen{
	width:100% !important;
}
</style>