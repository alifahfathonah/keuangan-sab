<table id="simple-table" class="table table-striped table-bordered table-hover" style="width:100%">
	<thead>
		<tr>
		<?php
		// echo '<pre>';
		// print_r($jenis);
		// echo '</pre>';
		$get_jenis=$this->config->item('tpenerimaan');
		if(isset($jenis))
		{
		?>
			<th colspan="<?=count($jenis)?>" class="center">Jenis Penerimaan</th>
			<!-- <th rowspan="2" style="width:120px !important" class="center">Bayar</th> -->
		</tr>
		<tr>
		<?php
			foreach ($jenis as $kj => $vj) 
			{
				if($batch_id=='')
					echo '<th class="center" style="width:'.(100/count($jenis)).'% !important">'.ucwords(str_replace('_',' ',$vj)).'</th>';
				else
				{
					if(isset($vj->jenis))
					{
						echo '<th class="center" style="width:'.(100/count($jenis)).'% !important">'.ucwords(str_replace('_',' ',$vj->jenis)).'</th>';
					}
					else
						echo '<th class="center" style="width:'.(100/count($jenis)).'> !important%">'.ucwords(str_replace('_',' ',$vj)).'</th>';

				}
			}
		}
		?>
		</tr>
	</thead>
	<tbody>
	<?php
	$no=1;
	
	if(isset($jenis))
	{
		// echo '<pre>';
		// print_r($tagihan);
		// echo '</pre>';
		$zz=0;
		echo '<tr>';
		foreach ($jenis as $kt => $vt) 
		{
			if($vt=='investasi')
			{
				$jns_tg='program_pembelajaran';
			}
			else
			{
				$jns_tg=$vt;
			}
				if(isset($tagihan[$jns_tg]))
				{
					$jlh_t='';
					$oo=1;
					foreach($tagihan[$jns_tg] as $k => $v)
					{
						if($v->sisa_bayar!=0)
						{

							if($vt!='investasi')
							{
								$jlh_t.='<div style="width:49%;float:left;text-align:right">'.getBulan($v->bulan).' - '.$v->tahun.'</div>';
								$nameinput='transaksi['.$v->id_jenis_penerimaan.'_'.trim($vt).']['.$v->bulan.'_'.$v->tahun.']';
							}
							else
							{
								$nameinput='transaksi['.$v->id_jenis_penerimaan.'_'.trim($vt).']['.trim(strtok($v->tahun_ajaran,'/')).']';
							}
							
							$jlh_t.='<div style="width:49%;float:right;text-align:right">'.number_format($v->sisa_bayar,0,',','.').'</div>';
							$jlh_t.='<input type="text" style="float:right;text-align:right !important;width:99%;font-size:11px !important;margin-bottom:10px !important" id="transaksiform_'.$oo.'" class="formtr_'.$kt.'" placeholder="0" name="'.$nameinput.'" onkeyup="hitungnominal(\''.$kt.'\',\''.$oo.'\',this.value)">';
							
							$oo++;
						}
					}
				}
				else
				{
					$jlh_t='<div style="text-align:right;">'.number_format(0,0,',','.').'</div>';
				}
			echo '<td style="width:'.(100/count($jenis)).'% !important">'.$jlh_t.'</td>';
		}
		echo '</tr>';
	}
	?>
	<tr>
		<?php
		if(isset($jenis))
		{
			foreach ($jenis as $kt => $vt) 
			{
				echo '<th class="right" style="text-align:right">Sub Total &nbsp;&nbsp;&nbsp;&nbsp;<span class="sub_total" id="total_'.$kt.'">0</span></th>';
			}
		}
		?>
		</tr>
		<tr>
			<th colspan="<?=count($jenis)?>" class="center">Total : <span id="grandtotal"></span></th>
		</tr>
	</tbody>
</table>
<style type="text/css">
	table td
	{
		font-size:11px !important;
	}
</style>