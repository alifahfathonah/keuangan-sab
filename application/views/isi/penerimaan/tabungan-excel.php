<?php
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=Tabungan_".$d->nama_murid.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
<table id="detailtabungan" class="table table-striped table-bordered table-hover" border="1">
	<thead>
		<tr>
			<th class="center">No</th>
			<th>Nama Siswa</th>
			<th>Tanggal</th>
			<th>Jenis</th>
			<th>Jumlah</th>
			<th>Keterangan</th>
			
		</tr>
	</thead>

	<tbody>
	<?php
	$no=1;
	$jumlah=0;
	foreach ($tabungan as $k => $v)
	{
		if(isset($vbs[$d->nis]))
		{
			$dSiswa=$vbs[$d->nis];
			$namabatch=$dSiswa->nama_batch;
		}
		else
			$namabatch='';
	?>
		<tr>
			<td style="text-align:center"><?=$no;?></td>
			<td style="text-align:left"><?=$d->nama_murid;?></td>
			<td style="text-align:center"><?=(strtok($v->tanggal,' '))?></td>
			<!-- <td style="text-align:left"><?=$namabatch?></td> -->
			<td style="text-align:center"><?=$v->jenis;?></td>
			<?php
			if($v->jenis=='Tarik')
			{
			?>
				<td style="text-align:right;"><i><?=(0-$v->jumlah)?></i></td>

			<?php
			}
			else
			{
			?>
				<td style="text-align:right;"><?=$v->jumlah?></td>
			<?php
			}
			?>
			<td style="text-align:center"><?=$v->keterangan;?></td>
			
		</tr>
	<?php
		$jlh=(strtolower($v->jenis)=='tarik' ? (0-$v->jumlah) : $v->jumlah);
		$jumlah+=$jlh;
		$no++;
	}
	?>
	</tbody>
	<thead>
		<tr>

			<th class="center" colspan="4">J U M L A H</th>
			<th style="text-align: right"><?=($jumlah)?></th>
			<th></th>
		</tr>
	</thead>
</table>

