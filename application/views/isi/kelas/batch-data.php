<?php
if($status=='t')
{
?>
	<button class="pull-right btn btn-xs btn-primary" onclick="nonaktifbatch()">
		<i class="glyphicon glyphicon-off"></i> Non Aktifkan Semua Batch
	</button>
<?php
}
$idbatch='';
?>
<table id="simple-table" class="table table-striped table-bordered table-hover" style="margin-top:10px;">
	<thead>
		<tr>
			<!-- <th class="center">No</th> -->
			<th>No</th>
			<th>Kelas</th>
			<th>Nama Batch</th>
			<th>Tahun Ajaran</th>
			<th>Wali Kelas</th>
			<th>Jumlah Siswa</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
	<?php
	$no=1;
	foreach ($d->result() as $k => $v)
	{
		$idbatch.=trim($v->id_batch).',';
		$jlhsiswa=$this->db->from('t_batch_siswa')->where('id_siswa!=','0',true)->where('id_batch',$v->id_batch)->where('active','1')->get()->result();
	?>
		<tr>
			<td style="text-align:center"><?=$no?></td>
			<td style="text-align:center;width:100px"><?=$v->nama_level;?></td>
			<td style="text-align:left"><a href="javascript:detail('<?=$v->id_batch?>','<?=addslashes($v->nama_batch)?>')"><?=($v->nama_batch);?></a></td>
			<td style="text-align:left"><?=($v->tahun_ajaran);?></td>
			<td style="text-align:center"><?=(ucwords($v->wali_kelas))?></td>
			<td style="text-align:center"><?=count($jlhsiswa)?></td>
			<td style="text-align:center">
				<button class="btn btn-primary btn-minier" type="button" onclick="edit('<?=$v->id_batch?>')">
					<i class="fa fa-pencil"></i>
				</button>
				<?php
				if($v->st_batch=='f')
				{
				?>
				<button class="btn btn-success btn-minier" type="button" onclick="ubahstatus('<?=$v->id_batch?>','t')">
					<i class="fa fa-check"></i>
				</button>
				<?php
				}
				else
				{
				?>
				<button class="btn btn-danger btn-minier" type="button" onclick="ubahstatus('<?=$v->id_batch?>','f')">
					<i class="glyphicon glyphicon-off"></i>
				</button>
				<?php
				}
				?>
				<button class="btn btn-danger btn-minier" type="button" onclick="hapus('<?=$v->id_batch?>')">
					<i class="fa fa-trash"></i>
				</button>
			</td>
		</tr>
	<?php
		$no++;
	}
	// $idbatch=substr($idbatch,0,-1);
	?>
	</tbody>
</table>
<input type="hidden" name="idbatch" id="idbatch_kelas" value="<?=$idbatch?>">
<div style="width:100%;padding:20px 10px;background:#ddd;float:left">

	<ul class="pagination" style="margin-top:0px !important;margin-bottom:0px !important;float:right;">
		<li class="disabled">
			<a href="#">
				<i class="ace-icon fa fa-angle-double-left"></i>
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

		<li>
			<a href="#">4</a>
		</li>

		<li>
			<a href="#">5</a>
		</li>

		<li>
			<a href="#">
				<i class="ace-icon fa fa-angle-double-right"></i>
			</a>
		</li>
	</ul>
</div>
