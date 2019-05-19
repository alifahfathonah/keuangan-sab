<?php
if($siswa!=null)
{
	// echo $siswa;
	list($idsiswa,$nis,$nama)=explode('__', $siswa);
}
list($lvl,$idlvl,$nmlvl,$kat)=explode('__', $level);
$wh='nis="'.$nis.'" and level="'.$lvl.'" and idlevel="'.$idlvl.'"';
$daftar=$this->db->from('t_pendaftaran')->where($wh)->get()->result();
if(count($daftar)!=0)
	$id_pen=$daftar[0]->id_penerimaan;
else
	$id_pen='';
?>
<select name="investasi[]" id="investasi_<?=$jenis?>" class="chosen-select form-control tag-input-style span4" multiple="multiple" data-placeholder="Data Investasi <?=$kt?>">
	<option value=""></option>
	<?php
		if(count($jenisgroup)!=0)
		{
			foreach ($jenisgroup as $k => $v) 
			{
				if($k!=0)
				{	
					foreach ($v as $kv => $vv) 
					{
						# code...
						if(strpos($id_pen, $vv->id)!==false)
							$sel="selected='selected'";
						else
							$sel='';

						echo '<option '.$sel.' value="'.$vv->id.'__'.$vv->jenis.'__'.$vv->jumlah.'">'.$vv->jenis.' : '.number_format($vv->jumlah,0,',','.').'</option>';
					}
				}
				else
				{
						foreach ($v as $kv => $vv) 
						{
							if(strtolower($vv->jenis)=='spp')
							{
								if(strpos($id_pen, $vv->id)!==false)
									$sel="selected='selected'";
								else
									$sel='';

								echo '<option '.$sel.' value="'.$vv->id.'__'.$vv->jenis.'__'.$vv->jumlah.'">'.$vv->jenis.' : '.number_format($vv->jumlah,0,',','.').'</option>';
							}
						}

					if($jenis=='baru')
					{
						if(count($biayaseleksi)!=0)
						{
							$dv=$biayaseleksi;
							if(strpos($id_pen, $dv->id)!==false)
								$sel="selected='selected'";
							else
								$sel='';

							echo '<option '.$sel.' value="'.$dv->id.'__'.$dv->jenis.'__'.$dv->jumlah.'">'.$dv->jenis.' : '.number_format($dv->jumlah,0,',','.').'</option>';
						}
					}
				}
			}
		}
	?>
</select>
<style type="text/css">
	#investasi_<?=$jenis?>_chosen
	{
		width:50% !important;
	}
</style>