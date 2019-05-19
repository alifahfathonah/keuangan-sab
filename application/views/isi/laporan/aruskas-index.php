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
										Laporan
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											Arus Kas
										</small>
									</h1>
								</div>
							</div>
							<div class="col-xs-12">
							            <div style="float:right;margin-bottom:5px;">
												Tahun Ajaran
												<select name="tahun_ajaran" id="tahunajaran" class="chosen-select form-control tag-input-style col-xs-3" data-placeholder="Tahun Ajaran" onchange="reloadaruskas()">
                                                    <?php
                                                    $ajaran=$this->config->item('tajaran');
                                                    if(count($ajaran)!=0)
                                                    {
                                                        foreach ($ajaran as $k => $v) 
                                                        {
                                                            if($id!=-1)
                                                            {
                                                                if($v->tahun_ajaran==$d[0]->tahun_ajaran)
                                                                    echo '<option selected="selected" value="'.$v->id_ajaran.'__'.str_replace(' ','%20',$d[0]->tahun_ajaran).'">'.$d[0]->tahun_ajaran.'</option>';
                                                                else
                                                                    echo '<option value="'.$v->id_ajaran.'">'.$v->tahun_ajaran.'</option>';
                                                            }
                                                            else
                                                                echo '<option value="'.$v->id_ajaran.'">'.$v->tahun_ajaran.'</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
										</div>	
                                   
                                </div>
                                <div class="col-xs-12">
                                        <center>
											<div id="loader-data"><img src="<?=base_url()?>assets/img/loading-bl-blue.gif"></div>
										</center>	
										<div id="data" style="border:1px solid #ddd;padding:15px;">Silahkan Pilih Tahun Terlebih Dahulu</div>
                                </div>
                            </div>
                           
                        </div>	
                    </div>
                </div>
            </div>
        </div>
<script>
    $('#loader-data').hide();
    reloadaruskas();
    function reloadaruskas()
	{
        var date=$('#tahunajaran').val();
		$('#loader-data').show();
		$('#data').css({'background':'white','opacity':'0.2'});
		$('#data').load('<?=site_url()?>laporan/aruskasdata/'+date,function(){
			$('#loader-data').hide();
			$('#data').css({'background':'transparent','opacity':'1.0'});
			$.ajax({
                url:'<?=site_url()?>laporan/neracalajurdata/'+date,
                success : function(){

                }
            });
		});
	}

	function aruskasnonsekolah(date)
	{
		$('#data').css({'background':'white','opacity':'0.2'});
		$('#loader-data').show();
        $('#data').load('<?=site_url()?>laporan/aruskasdata/'+date+'/non',function(){
			$('#loader-data').hide();
			$('#data').css({'background':'transparent','opacity':'1.0'});
		});
	}
	function aruskassekolah(date)
	{
		$('#data').css({'background':'white','opacity':'0.2'});
		$('#loader-data').show();
        $('#data').load('<?=site_url()?>laporan/aruskasdata/'+date+'/sekolah',function(){
			$('#loader-data').hide();
			$('#data').css({'background':'transparent','opacity':'1.0'});
		});
	}
	function downloadaruskas(jenis,date)
	{
		if(jenis==-1)
		{
			window.open(
				'<?=site_url()?>laporan/aruskasexcel/'+date,
				'_blank'
			);
		}
		else
		{
			window.open(
				'<?=site_url()?>laporan/aruskasexcel/'+date+'/'+jenis,
				'_blank'
			);	
		}
	}
</script>