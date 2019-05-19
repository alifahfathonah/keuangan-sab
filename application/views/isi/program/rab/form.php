<form class="form-horizontal" role="form" id="simpanjarak">

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kegiatan </label>

		<div class="col-sm-9">
			<select id="kegiatan" name="kegiatan"  data-rel="chosen" class="col-xs-12 col-sm-8 chosen-select">
                <option value="">--Pilih--</option>
				<?php		
				foreach ($kegiatan as $k => $v) 
				{
					if($id!=-1)
					{
						if($d->row('kegiatan_id')==$v->id)
							echo '<option selected="selected" value="'.$d->row('kegiatan_id').'::'.$v->kegiatan.'">'.ucwords($v->kegiatan).'</option>';
						else
							echo '<option value="'.$v->id.'::'.$v->kegiatan.'">'.ucwords($v->kegiatan).'</option>';
					}
					else
						echo '<option value="'.$v->id.'::'.$v->kegiatan.'">'.ucwords($v->kegiatan).'</option>';
				}
				?>
			</select>
		</div>
	</div>
 
    <div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nominal Anggaran </label>

		<div class="col-sm-9">
			<input type="text" id="saldo" name="anggaran" placeholder="Nominal Anggaran" class="col-xs-12 col-sm-12" value="<?=($id!=-1 ? ($d->row('anggaran')) : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> PIC </label>

		<div class="col-sm-9">
			<select name="pic[]" id="pic" multiple="mutiple" data-rel="chosen" class="col-xs-12 col-sm-8 chosen-select">
                <option value="0::-">--Pilih--</option>
				<?php		
				foreach ($pic as $k => $v) 
				{
					if($id!=-1)
					{
						if($d->row('pic_id')==$v->id_guru)
							echo '<option selected="selected" value="'.$d->row('pic_id').'::'.$v->nama_guru.'">'.ucwords($v->nama_guru).'</option>';
						else
							echo '<option value="'.$v->id_guru.'::'.$v->nama_guru.'">'.ucwords($v->nama_guru).'</option>';
					}
					else
						echo '<option value="'.$v->id_guru.'::'.$v->nama_guru.'">'.ucwords($v->nama_guru).'</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Waktu Pelaksanaan </label>

		<div class="col-sm-9">
			<select name="bulan" id="bulan"  data-rel="chosen" class="col-xs-4 col-sm-4 col-md-4 chosen-select">
                <option value="">--Bulan--</option>
				<?php		
				for ($i=1;$i<=12;$i++) 
				{
                    if(date('n')==$i)
					    echo '<option value="'.$i.'" selected="selected">'.ucwords(getBulan($i)).'</option>';
                    else
                        echo '<option value="'.$i.'">'.ucwords(getBulan($i)).'</option>';
				}
				?>
			</select>
			<select name="tahun" id="tahun"  data-rel="chosen" class="col-xs-4 col-sm-4 col-md-4 chosen-select">
                <option value="">--Tahun--</option>
				<?php		
				for ($j=(date('Y')-4);$j<=date('Y');$j++) 
				{
                    if(date('Y')==$j)
					    echo '<option value="'.$j.'" selected="selected">'.$j.'</option>';
                    else
                        echo '<option value="'.$j.'">'.$j.'</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tahun Ajaran </label>

		<div class="col-sm-9">

			<select name="tahun_ajaran" id="tahun_ajaran"  data-rel="chosen" class="col-xs-4 col-sm-4 col-md-4 chosen-select">
                <option value="">--Tahun Ajaran--</option>
				<?php		
				foreach ($tajaran as $k => $v) 
				{
					if($id!=-1)
					{
						if($d->row('tahun_ajaran')==$v->tahun_ajaran)
							echo '<option selected="selected" value="'.$d->row('tahun_ajaran').'">'.ucwords($v->tahun_ajaran).'</option>';
						else
							echo '<option value="'.$v->tahun_ajaran.'">'.ucwords($v->tahun_ajaran).'</option>';
					}
					else
						echo '<option value="'.$v->tahun_ajaran.'">'.ucwords($v->tahun_ajaran).'</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Keterangan </label>

		<div class="col-sm-9">
			<textarea name="keterangan" class="col-xs-12 col-sm-12"><?=($id!=-1 ? ($d->row('keterangan')) : '')?></textarea>
		</div>
	</div>
</form>
<style type="text/css">
	.form-group label
	{
		font-size:10px !important;
	}
    #kegiatan_chosen,#pic_chosen,#kode_akun_chosen
	{
		width:100% !important;
	}
    #bulan_chosen,#tahun_chosen,#tahun_ajaran_chosen
	{
		width:30% !important;
	}
</style>

<script type="text/javascript">
	$('.chosen-select').chosen({allow_single_deselect:true});
    $('input#saldo').keyup(function(){
				// alert('a');
				$(this).formatCurrency({symbol:''})
			});
</script>
