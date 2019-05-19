<form class="form-horizontal" id="datakeluarga_ibu" role="form" action="<?=site_url()?>siswa/simpandatakeluarga/<?=$jns?>/<?=$id?>" method="POST">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama ibu </label>

		<div class="col-sm-9">
			<input type="text" id="nis" placeholder="Nama Ibu" name="nama_ibu" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->nama_ibu : '')?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> No HP ibu </label>

		<div class="col-sm-9">
			<input type="text" id="hp_ibu" placeholder="No HP ibu" name="hp_ibu" class="col-xs-10 col-sm-7"  value="<?=($id!=-1 ? $dd[0]->hp_ibu : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email ibu </label>

		<div class="col-sm-9">
			<input type="text" id="email_ibu" name="email_ibu" placeholder="Email ibu" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->email_ibu : '')?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Pekerjaan ibu </label>

		<div class="col-sm-9">
			<input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" placeholder="Pekerjaan ibu" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->pekerjaan_ibu : '')?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kewarganegaraan </label>

		<div class="col-sm-9">
			<input type="text" id="kewarganeraan_ibu" name="kewarganeraan_ibu" placeholder="Kewarganegaraan" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->kewarganeraan_ibu : '')?>" />
		</div>
	</div>
	
</form>