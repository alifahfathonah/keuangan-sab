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
										Realisasi Anggaran Biaya
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Data 
										</small>
									</h1>
								</div><!-- /.page-header -->

								<div class="row">
									<div class="col-xs-12">
                                    
                                        <div style="float:right;margin-bottom:5px;">
                                            <div id="bulan_tahun">
												<select class="" id="program" name="program" data-placeholder="program" onchange="data()">
                                                    <option value="-1">--Pilih Program--</option>
                                                    <?php
                                                    foreach($program as $k => $v)
                                                    {
                                                        echo '<option value="'.$v->id.'">'.$v->program.'</option>';
                                                    }
                                                    ?>
                                                </select>
												<select class="" id="bulan" name="bulan" data-placeholder="Bulan" onchange="data()">
												<?php
												// $bulan=array();
												for($i=1;$i<=12;$i++)
												{
													if($i==date('n'))
														echo '<option selected="selected" value="'.$i.'">'.getBulan($i).'</option>';
													else
														echo '<option value="'.$i.'">'.getBulan($i).'</option>';
												}
												?>
												</select>
												<select class="" id="tahun" name="tahun" data-placeholder="Tahun" onchange="data()" style="width:100px !important;">
												<?php
												for($i=(date('Y')-10);$i<=(date('Y')+1);$i++)
												{
													if($i==date('Y'))
														echo '<option selected="selected" value="'.$i.'">'.$i.'</option>';
													else
														echo '<option value="'.$i.'">'.$i.'</option>';
												}
												?>
												</select>
											</div>
											
										</div>
                                        <br>
                                        <br>
                                        <div class="pull-right" style="margin-bottom:5px;">
                                            <button class="btn btn-xs btn-success" onclick="downloadrab('xls')"><i class="fa fa-download"></i> Unduh RAB XLS</button>
                                            <button class="btn btn-xs btn-warning" onclick="downloadrab('pdf')"><i class="fa fa-download"></i> Unduh RAB PDF</button>
                                            <button class="btn btn-xs btn-primary" onclick="data()"><i class="fa fa-refresh"></i> Refresh</button>
                                        </div>
                                    </div>
                                </div>
								<div class="row">
									<div class="col-xs-12">
										<!-- PAGE CONTENT BEGINS -->
										<center>
											<div id="loader-data" style="position:absolute;width:100%"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif" style="margin:0 auto !important"></div>
										</center>
										<div id="data" style="margin-top:20px;width:100%;"></div>
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
		$('#loader-data').show();
		// $('#loader-form').show();
		// $('#data').load('<?=site_url()?>rab/data',function(){
		// 	$('#loader-data').hide();
		// });
		data()
	});
	
	function data()
	{
        var tahun=$('#tahun').val();
        var bulan=$('#bulan').val();
        var program=$('#program').val();
        $('#data').css('opacity','0.2');
		$('#loader-data').show();
		$('#data').load('<?=site_url()?>realisasi/data/'+bulan+'/'+tahun+'/'+program,function(){
			$('#loader-data').hide();
            $('#data').css('opacity','1.0');
		});
	}
	
</script>