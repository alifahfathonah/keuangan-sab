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
										Rencana Anggaran Biaya
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Data 
										</small>
									</h1>
								</div><!-- /.page-header -->

								<div class="row">
									<div class="col-xs-12">
                                    <button class="btn btn-xs btn-primary pull-left" onclick="dform(-1)"><i class="fa fa-plus-circle"></i>  Tambah Data</button>
                                        <div style="float:right;">
												Tahun Ajaran
												<select name="tahun_ajaran" id="tahunajaran" class="" data-placeholder="Tahun Ajaran" onchange="data()">
                                                    <?php
                                                    $ajaran=$this->config->item('tajaran');
                                                    if(count($ajaran)!=0)
                                                    {
                                                        foreach ($ajaran as $k => $v) 
                                                        {
                                                            echo '<option value="'.str_replace(' / ','__',$v->tahun_ajaran).'">'.$v->tahun_ajaran.'</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
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
	// function form(id)
	// {
	// 	$('#form').load('<?=site_url()?>rab/form/'+id,function(){
	// 		$('#loader-form').hide();
    //          $('.chosen-select').chosen({allow_single_deselect:true});
	// 	});
	// }
	function data()
	{
        var tahunajaran=$('#tahunajaran').val();
        $('#data').css('opacity','0.2');
		$('#loader-data').show();
		$('#data').load('<?=site_url()?>rab/data/'+tahunajaran,function(){
			$('#loader-data').hide();
            $('#data').css('opacity','1.0');
		});
	}
	function edit(id)
	{
		$('#loader-form').show();
		$('#form').load('<?=site_url()?>rab/form/'+id,function(){
			$('#loader-form').hide();
             $('.chosen-select').chosen({allow_single_deselect:true});
		});
	}
	function dform(id)
	{
		// $('#loader-form').show();
        $.ajax({
            url : '<?=site_url()?>rab/form/'+id,
            success :  function(a){

		        bootbox.confirm(a, function(result) {
					if(result) 
					{
						// $('#simpanjarak').submit();
                        $('#data').css('opacity','0.2');
		                $('#loader-data').show();
                        $.ajax({
                            url : '<?=site_url()?>rab/proses/'+id,
                            type : 'POST',
                            data:$('#simpanjarak').serialize(),
                            success : function(a)
                            {
                                data();
                            }
                        });
					}
				});
            }
        });
	}

	function hapus(id)
	{
		bootbox.confirm("<h3>Yakin Ingin Menghapus Data ini ?? </h3>", function(result) {
					if(result)
					{
						$.ajax({
							url : '<?=site_url()?>rab/hapus/'+id,
							success : function(a)
							{
								// alert(a);
								tampilpesan(a);
								data();
							}
						});
					}
				});
	}
</script>
