<form class="form-horizontal" id="datakeluarga_ayah" role="form" action="<?=site_url()?>siswa/simpandatakeluarga/<?=$jns?>/<?=$id?>" method="POST">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Ayah </label>

		<div class="col-sm-9">
			<input type="text" id="nis" placeholder="Nama Ayah" name="nama_ayah" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->nama_ayah : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> No KTP ayah </label>

		<div class="col-sm-9">
			<input type="text" id="ktp_ayah" placeholder="No KTP" name="ktp_ayah" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->ktp_ayah : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> No HP Ayah </label>

		<div class="col-sm-9">
			<input type="text" id="hp_ayah" placeholder="No HP Ayah" name="hp_ayah" class="col-xs-10 col-sm-7"  value="<?=($id!=-1 ? $dd[0]->hp_ayah : '')?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email Ayah </label>

		<div class="col-sm-9">
			<input type="text" id="email_ayah" name="email_ayah" placeholder="Email Ayah" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->email_ayah : '')?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Pekerjaan Ayah </label>

		<div class="col-sm-9">
			<input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" placeholder="Pekerjaan Ayah" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->pekerjaan_ayah : '')?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kewarganegaraan </label>

		<div class="col-sm-9">
			<input type="text" id="kewarganeraan_ayah" name="kewarganeraan_ayah" placeholder="Kewarganegaraan" class="col-xs-10 col-sm-7" value="<?=($id!=-1 ? $dd[0]->kewarganeraan_ayah : '')?>" />
		</div>
	</div>
	
</form>