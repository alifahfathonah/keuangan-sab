<?php

function load_config()
{
	$ci =& get_instance();
	$ci->load->dbforge();

	

	$config=$ci->db->from('t_profil')
				->order_by('key','asc')->get();
	foreach($config->result() as $app_config)
	{
		$ci->config->set_item($app_config->key,$app_config->value);
	}


	$t_siswa = [
		'id' => 'int primary key AUTO_INCREMENT',
		'nama_murid' => 'varchar(100)',
		'nama_panggilan' => 'varchar(100)',
		'jenis_kelamin' => 'enum(\'1\',\'0\')',
		'tempat_lahir' => 'varchar(100)',
		'tanggal_lahir' => 'date',
		'NIK' => 'varchar(100)',
		'nis' => 'varchar(100)',
		'nisn' => 'varchar(100)',
		'no_akte_lahir' => 'varchar(100)',
		'kebangsaan' => 'varchar(100)',
		'kewarganegaraan' => 'varchar(100)',
		'agama' => 'varchar(100)',
		'sakit_berat' => 'varchar(100)',
		'alamat' => 'text',
		'provinsi' => 'varchar(100)',
		'kota' => 'varchar(100)',
		'kecamatan' => 'varchar(100)',
		'kelurahan' => 'varchar(100)',
		'kode_pos' => 'varchar(100)',
		'telp_rumah' => 'varchar(100)',
		'fax_rumah' => 'varchar(100)',
		'hp' => 'varchar(100)',
		'email' => 'varchar(255)',
		'nama_ayah' => 'varchar(100)',
		'ktp_ayah' => 'varchar(100)',
		'hp_ayah' => 'varchar(100)',
		'fax_ayah' => 'varchar(100)',
		'email_ayah' => 'varchar(100)',
		'pekerjaan_ayah' => 'varchar(100)',
		'kebangsaaan_ayah' => 'varchar(100)',
		'kewarganeraan_ayah' => 'varchar(100)',
		'gaji_ayah' => 'varchar(100)',
		'hub_ayah_dengan_murid' => 'varchar(100)',
		'kantor_ayah' => 'varchar(100)',
		'alamat_kantor_ayah' => 'varchar(100)',
		'provinsi_kantor_ayah' => 'varchar(100)',
		'pendidikan_ayah' => 'varchar(100)',
		'nama_ibu' => 'varchar(100)',
		'hp_ibu' => 'varchar(100)',
		'fax_ibu' => 'varchar(100)',
		'email_ibu' => 'varchar(100)',
		'pekerjaan_ibu' => 'varchar(100)',
		'gaji_ibu' => 'varchar(100)',
		'hub_ibu_dengan_murid' => 'varchar(100)',
		'kantor_ibu' => 'varchar(100)',
		'alamat_kantor_ibu' => 'varchar(100)',
		'provinsi_kantor_ibu' => 'varchar(100)',
		'kebangsaaan_ibu' => 'varchar(100)',
		'kewarganeraan_ibu' => 'varchar(100)',
		'pendidikan_ibu' => 'varchar(100)',
		'nama_wali' => 'varchar(100)',
		'ktp_wali' => 'varchar(100)',
		'telp_wali' => 'varchar(100)',
		'hp_wali' => 'varchar(100)',
		'fax_wali' => 'varchar(100)',
		'email_wali' => 'varchar(100)',
		'alamat_wali' => 'text',
		'provinsi_wali' => 'varchar(100)',
		'hub_wali_dengan_murid' => 'varchar(100)',
		'no_virtual_account' => 'varchar(50)',
		'alamat_darurat' => 'text',
		'status_tampil' => 'enum("t","f","i") default "t"',
		'`status_baru_lama`' => ' INT'
	];
	if (!$ci->db->table_exists('t_siswa'))
	{
		$t_s='create table t_siswa(';
		foreach ($t_siswa as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

//---------------------------------------------------------------------------------------------------
	$t_siswa_data=[
		'id_data' => 'int primary key AUTO_INCREMENT',
		'id_siswa' => 'int',
		'sponsor_beasiswa' => 'varchar(100)',
		'negara_tempat_lahir' => 'varchar(100)',
		'dikosongkan_saja' => 'varchar(255)',
		'sekolah_sebelumnya1' => 'varchar(100)',
		'STTB' => 'varchar(100)',
		'tanggal_keluar'=> 'date',
		'jumlah_tahun_di_sekolah' => 'char(10)',
		'USSBN' => 'varchar(100)',
		'UAN' => 'varchar(100)',
		'alasan_keluar' => 'varchar(255)',
		'bahasa_yang_di_pakai'=> 'varchar(100)',
		'murid_anak_ke'=> 'char(10)',
		'jumlah_saudara_kandung' => 'char(10)',
		'jumlah_saudara_tiri' => 'char(10)',
		'jumlah_saudara_angkat' => 'char(10)',
		'murid_tinggal_bersama' => 'varchar(100)',
		'yatim' => 'enum("ya","tidak")',
		'jarak_ke_sekolah' => 'varchar(100)',
		'no_buku_induk' => 'varchar(100)',
	];
	if (!$ci->db->table_exists('t_siswa_data'))
	{
		$t_s='create table t_siswa_data(';
		foreach ($t_siswa_data as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}
	if (!$ci->db->table_exists('v_siswa'))
	{
		$d="CREATE VIEW `v_siswa` AS select `ts`.`id` AS `id`,`ts`.`nama_murid` AS `nama_murid`,`ts`.`nama_panggilan` AS `nama_panggilan`,`ts`.`jenis_kelamin` AS `jenis_kelamin`,`ts`.`tempat_lahir` AS `tempat_lahir`,`ts`.`status_baru_lama`,`ts`.`tanggal_lahir` AS `tanggal_lahir`,`ts`.`NIK` AS `NIK`,`ts`.`no_akte_lahir` AS `no_akte_lahir`,`ts`.`kebangsaan` AS `kebangsaan`,`ts`.`kewarganegaraan` AS `kewarganegaraan`,`ts`.`agama` AS `agama`,`ts`.`sakit_berat` AS `sakit_berat`,`ts`.`alamat` AS `alamat`,`ts`.`provinsi` AS `provinsi`,`ts`.`kelurahan` AS `kelurahan`,`ts`.`kecamatan` AS `kecamatan`,`ts`.`kota` AS `kota`,`ts`.`kode_pos` AS `kode_pos`,`ts`.`telp_rumah` AS `telp_rumah`,`ts`.`fax_rumah` AS `fax_rumah`,`ts`.`hp` AS `hp`,`ts`.`email` AS `email`,`ts`.`nama_ayah` AS `nama_ayah`,`ts`.`ktp_ayah` AS `ktp_ayah`,`ts`.`hp_ayah` AS `hp_ayah`,`ts`.`fax_ayah` AS `fax_ayah`,`ts`.`email_ayah` AS `email_ayah`,`ts`.`pekerjaan_ayah` AS `pekerjaan_ayah`,`ts`.`kebangsaaan_ayah` AS `kebangsaaan_ayah`,`ts`.`kewarganeraan_ayah` AS `kewarganeraan_ayah`,`ts`.`gaji_ayah` AS `gaji_ayah`,`ts`.`hub_ayah_dengan_murid` AS `hub_ayah_dengan_murid`,`ts`.`kantor_ayah` AS `kantor_ayah`,`ts`.`alamat_kantor_ayah` AS `alamat_kantor_ayah`,`ts`.`provinsi_kantor_ayah` AS `provinsi_kantor_ayah`,`ts`.`pendidikan_ayah` AS `pendidikan_ayah`,`ts`.`nama_ibu` AS `nama_ibu`,`ts`.`hp_ibu` AS `hp_ibu`,`ts`.`fax_ibu` AS `fax_ibu`,`ts`.`email_ibu` AS `email_ibu`,`ts`.`pekerjaan_ibu` AS `pekerjaan_ibu`,`ts`.`gaji_ibu` AS `gaji_ibu`,`ts`.`hub_ibu_dengan_murid` AS `hub_ibu_dengan_murid`,`ts`.`kantor_ibu` AS `kantor_ibu`,`ts`.`alamat_kantor_ibu` AS `alamat_kantor_ibu`,`ts`.`provinsi_kantor_ibu` AS `provinsi_kantor_ibu`,`ts`.`kebangsaaan_ibu` AS `kebangsaaan_ibu`,`ts`.`kewarganeraan_ibu` AS `kewarganeraan_ibu`,`ts`.`pendidikan_ibu` AS `pendidikan_ibu`,`ts`.`nama_wali` AS `nama_wali`,`ts`.`ktp_wali` AS `ktp_wali`,`ts`.`telp_wali` AS `telp_wali`,`ts`.`hp_wali` AS `hp_wali`,`ts`.`fax_wali` AS `fax_wali`,`ts`.`email_wali` AS `email_wali`,`ts`.`alamat_wali` AS `alamat_wali`,`ts`.`provinsi_wali` AS `provinsi_wali`,`ts`.`hub_wali_dengan_murid` AS `hub_wali_dengan_murid`,`ts`.`no_virtual_account` AS `no_virtual_account`,`ts`.`alamat_darurat` AS `alamat_darurat`,`ts`.`status_tampil` AS `status_tampil`,`ts`.`nis` AS `nis`,`td`.`id_data` AS `id_data`,`td`.`id_siswa` AS `id_siswa`,`td`.`sponsor_beasiswa` AS `sponsor_beasiswa`,`td`.`negara_tempat_lahir` AS `negara_tempat_lahir`,`td`.`dikosongkan_saja` AS `dikosongkan_saja`,`td`.`sekolah_sebelumnya1` AS `sekolah_sebelumnya1`,`td`.`STTB` AS `STTB`,`td`.`tanggal_keluar` AS `tanggal_keluar`,`td`.`jumlah_tahun_di_sekolah` AS `jumlah_tahun_di_sekolah`,`td`.`USSBN` AS `USSBN`,`td`.`UAN` AS `UAN`,`td`.`alasan_keluar` AS `alasan_keluar`,`td`.`bahasa_yang_di_pakai` AS `bahasa_yang_di_pakai`,`td`.`murid_anak_ke` AS `murid_anak_ke`,`td`.`jumlah_saudara_kandung` AS `jumlah_saudara_kandung`,`td`.`jumlah_saudara_tiri` AS `jumlah_saudara_tiri`,`td`.`jumlah_saudara_angkat` AS `jumlah_saudara_angkat`,`td`.`murid_tinggal_bersama` AS `murid_tinggal_bersama`,`td`.`yatim` AS `yatim`,`td`.`jarak_ke_sekolah` AS `jarak_ke_sekolah`,`td`.`no_buku_induk` AS `no_buku_induk` from (`t_siswa` `ts` left join `t_siswa_data` `td` on((`ts`.`id` = `td`.`id_siswa`)))";

		$ci->db->query($d);
	}

	if (!$ci->db->table_exists('v_tagihan_siswa'))
	{
		$d="CREATE VIEW `v_tagihan_siswa` AS select `tgs`.`status_tagihan` AS `status_tagihan`,`tgs`.`id_tagihan` AS `id_tagihan`,`tgs`.`wajib_bayar` AS `wajib_bayar`,`tgs`.`bulan` AS `bulan`,`tgs`.`tahun` AS `tahun`,`tgs`.`id_jenis_penerimaan` AS `id_jenis_penerimaan`,`tgs`.`nis` AS `nis`,`tgs`.`batch_id` AS `batch_id`,`tgs`.`sudah_bayar` AS `sudah_bayar`,`tgs`.`sisa_bayar` AS `sisa_bayar`,`tgs`.`keterangan` AS `keterangan`,`tgs`.`jumlah_diskon` AS `jumlah_diskon`,`tgs`.`transaksi_id` AS `transaksi_id`,`tgs`.`tahun_ajaran` AS `tahun_ajaran`,`tgs`.`id_siswa` AS `id_siswa`,`ts`.`nama_murid` AS `nama_murid`,`ts`.`jenis_kelamin` AS `jenis_kelamin`,`ts`.`nama_panggilan` AS `nama_panggilan`,`ts`.`tanggal_lahir` AS `tanggal_lahir`,`tjp`.`jenis` AS `jenis`,`tjp`.`jumlah` AS `jumlah`,`tjp`.`kodeakun` AS `kodeakun`,`tgs`.`id_club` AS `id_club` from ((`t_tagihan_siswa` `tgs` join `t_jenis_penerimaan` `tjp` on((`tjp`.`id` = `tgs`.`id_jenis_penerimaan`))) join `t_siswa` `ts` on((`ts`.`id` = `tgs`.`id_siswa`)))";
		$ci->db->query($d);
	}
//---------------------------------------------------------------------------------------------------
	$t_siswa_dana_lebih=[
		'id_dana' => 'int primary key AUTO_INCREMENT',
		'id_siswa' => 'int',
		'nis' => 'varchar(100)',
		'dana_lebih' => 'double',
		'trans_id' => 'int',
		'tagihan_id' => 'int'
	];
	if (!$ci->db->table_exists('t_siswa_dana_lebih'))
	{
		$t_s='create table t_siswa_dana_lebih(';
		foreach ($t_siswa_dana_lebih as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}
//---------------------------------------------------------------------------------------------------
	$t_jarak_jemputan=[
		'id_jarak' => 'int primary key AUTO_INCREMENT',
		'jarak' => 'float',
		'jarakpp' => 'float',
		'biaya' => 'double',
		'keterangan' => 'text',
		'status_tampil' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_jarak_jemputan'))
	{
		$t_s='create table t_jarak_jemputan(';
		foreach ($t_jarak_jemputan as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);
	}

	//---------------------------------------------------------------------------------------------------
	$t_guru=[
		'id_guru' => 'int primary key AUTO_INCREMENT',
		'nama_guru' => 'varchar(255)',
		'alamat' => 'text',
		'email' => 'varchar(255)',
		'telp' => 'varchar(255)',
		'status_tampil' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_guru'))
	{
		$t_s='create table t_guru(';
		foreach ($t_guru as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);
	}

//---------------------------------------------------------------------------------------------------
	$t_club=[
		'id_club' => 'int primary key AUTO_INCREMENT',
		'nama_club' => 'varchar(100)',
		'penanggung_jawab' => 'varchar(100)',
		'biaya' => 'double',
		'telp_pj' => 'varchar(100)',
		'email_pj' => 'varchar(100)',
		'hari' => 'char(10)',
		'waktu' => 'varchar(20)',
		'status_tampil' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_club'))
	{
		$t_s='create table t_club(';
		foreach ($t_club as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);
	}

	//---------------------------------------------------------------------------------------------------
	$t_catering=[
		'id_catering' => 'int primary key AUTO_INCREMENT',
		'nama_catering' => 'varchar(100)',
		'penanggung_jawab' => 'varchar(100)',
		'alamat' => 'text',
		'biaya' => 'double',
		'telp_pj' => 'varchar(100)',
		'email_pj' => 'varchar(100)',
		'status_tampil' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_catering'))
	{
		$t_s='create table t_catering(';
		foreach ($t_catering as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);
	}

	$t_catering_menu=[
		'id_menu' => 'int primary key AUTO_INCREMENT',
		'id_catering' => 'int',
		'menu' => 'text',
		'hari' => 'varchar(100)',
		'status_tampil' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_catering_menu'))
	{
		$t_s='create table t_catering_menu(';
		foreach ($t_catering_menu as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);
	}
//---------------------------------------------------------------------------------------------------
	$t_supir=[
		'id_supir' => 'int primary key AUTO_INCREMENT',
		'nama_supir' => 'varchar(100)',
		'alamat' => 'text',
		'telp' => 'varchar(255)',
		'email' => 'varchar(100)',
		'jenis_mobil' => 'varchar(100)',
		'no_plat' => 'varchar(100)',
		'status_tampil' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_supir'))
	{
		$t_s='create table t_supir(';
		foreach ($t_supir as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);
	}
//---------------------------------------------------------------------------------------------------
	$t_akun=[
		'id' => 'int primary key AUTO_INCREMENT',
		'kode_akun' => 'int',
		'nama_akun' => 'varchar(100)',
		'id_parent' => 'int default 0',
		'status_tampil' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_akun'))
	{
		$t_s='create table t_akun(';
		foreach ($t_akun as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);
	}
	if (!$ci->db->field_exists('akun_alt_parent', 't_akun'))
	{
	    $fields = array(
		        'akun_alt_parent' => array(
					'type' => 'VARCHAR',
					'constraint'=>'100'
				)
		);
		$ci->dbforge->add_column('t_akun', $fields);
	}
//---------------------------------------------------------------------------------------------------
	$t_profil=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`key`' => 'varchar(100)',
		'`value`' => 'text'
	];
	if (!$ci->db->table_exists('t_profil'))
	{
		$t_s='create table t_profil(';
		foreach ($t_profil as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

		$nilai=['nama_sistem','nama_perusahaan','alamat','telepon','email','website','logo'];
		foreach ($nilai as $kn => $vn)
		{
			$d['key']=$vn;
			$ci->db->insert('t_profil',$d);
		}
	}

	//---------------------------------------------------------------------------------------------------
	$t_user=[
		'`id_user`' => 'int primary key AUTO_INCREMENT',
		'`nama_user`' => 'varchar(100)',
		'`alamat`' => 'text',
		'`telp`' => 'varchar(100)',
		'`email`' => 'varchar(100)',
		'`username`' => 'varchar(100)',
		'`password`' => 'varchar(255)',
		'`id_level`' => 'int',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_user'))
	{
		$t_s='create table t_user(';
		foreach ($t_user as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}
	//---------------------------------------------------------------------------------------------------
	$t_level=[
		'`id_level`' => 'int primary key AUTO_INCREMENT',
		'`level`' => 'varchar(100)',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_level'))
	{
		$t_s='create table t_level(';
		foreach ($t_level as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

	//---------------------------------------------------------------------------------------------------
	$t_level_kelas=[
		'`id_level`' => 'int primary key AUTO_INCREMENT',
		'`level`' => 'varchar(100)',
		'`nama_level`' => 'varchar(100)',
		'`kategori`' => 'enum("pg","tk","tk-a","tk-b","sd","sm","sm-x")',
		'`kapasitas`' => 'int',
		'`level`' =>  'CHAR( 10 ) NOT NULL',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_level_kelas'))
	{
		$t_s='create table t_level_kelas(';
		foreach ($t_level_kelas as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

	//---------------------------------------------------------------------------------------------------
	$t_batch_kelas=[
		'`id_batch`' => 'int primary key AUTO_INCREMENT',
		'`nama_batch`' => 'varchar(100)',
		'`wali_kelas`' => 'varchar(100)',
		'`tahun_ajaran`' => 'varchar(100)',
		'`id_level`' => 'int',
		'`status_tampil`' => 'enum("t","f","i")'
	];
	if (!$ci->db->table_exists('t_batch_kelas'))
	{
		$t_s='create table t_batch_kelas(';
		foreach ($t_batch_kelas as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}
	if (!$ci->db->table_exists('v_batch_kelas'))
	{
	   $sql="CREATE VIEW `v_batch_kelas` AS select `bk`.*,`lk`.`level`,`lk`.`nama_level`,`lk`.`kategori`,`lk`.`kapasitas`,`bk`.`status_tampil` as `st_batch`,`lk`.`status_tampil` as `st_level` from ((`t_batch_kelas` `bk` join `t_level_kelas` `lk` on((`lk`.`id_level` = `bk`.`id_level`))))";
	   	$ci->db->query($sql);
	}

	//---------------------------------------------------------------------------------------------------
	$t_batch_siswa=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`id_batch`' => 'int',
		'`id_siswa`' => 'int',
		'`active`' => 'enum("1","0")',
		'`status_tampil`' => 'enum("t","f","i")'
	];
	if (!$ci->db->table_exists('t_batch_siswa'))
	{
		$t_s='create table t_batch_siswa(';
		foreach ($t_batch_siswa as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}
	if (!$ci->db->table_exists('v_batch_siswa'))
	{
	   // $sql="CREATE VIEW `v_batch_siswa` AS select `bk`.*,`lk`.`level`,`lk`.`nama_level`,`lk`.`kategori`,`lk`.`kapasitas`,`bk`.`status_tampil` as `st_batch`,`lk`.`status_tampil` as `st_level` from ((`t_batch_kelas` `bk` join `t_level_kelas` `lk` on((`lk`.`id_level` = `bk`.`id_level`))))";
	   // 	$ci->db->query($sql);
	}

	//---------------------------------------------------------------------------------------------------
	$t_jenis_penerimaan=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`jenis`' => 'varchar(100)',
		'`jumlah`' => 'double',
		'`kategori`' => 'varchar(50)',
		'`id_parent`' => 'int default 0',
		'`kodeakun`' => 'varchar(100)',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_jenis_penerimaan'))
	{
		$t_s='create table t_jenis_penerimaan(';
		foreach ($t_jenis_penerimaan as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}
	//---------------------------------------------------------------------------------------------------
	$t_jenis_pengeluaran=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`jenis`' => 'varchar(100)',
		'`jumlah`' => 'double',
		'`kategori`' => 'varchar(50)',
		'`id_parent`' => 'int default 0',
		'`kodeakun`' => 'varchar(100)',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_jenis_pengeluaran'))
	{
		$t_s='create table t_jenis_pengeluaran(';
		foreach ($t_jenis_pengeluaran as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}
	//---------------------------------------------------------------------------------------------------
	$t_tagihan_siswa=[
		'`id_tagihan`' => 'int primary key AUTO_INCREMENT',
		'`wajib_bayar`' => 'double',
		'`bulan`' => 'int',
		'`tahun`' => 'int',
		'`id_jenis_penerimaan`' => 'int',
		'`nis`' => 'varchar(20)',
		'`batch_id`' => 'int',
		'`sudah_bayar`' => 'double',
		'`sisa_bayar`' => 'double',
		'`keterangan`' => 'varchar(255)',
		'`jumlah_diskon`' => 'double',
		'`transaksi_id`' => 'int'
	];
	if (!$ci->db->table_exists('t_tagihan_siswa'))
	{
		$t_s='create table t_tagihan_siswa(';
		foreach ($t_tagihan_siswa as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

	//---------------------------------------------------------------------------------------------------
	$t_hari_efektif=[
		'`id_hari`' => 'int primary key AUTO_INCREMENT',
		'`jumlah_hari`' => 'int',
		'`bulan`' => 'int',
		'`tahun`' => 'int',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_hari_efektif'))
	{
		$t_s='create table t_hari_efektif(';
		foreach ($t_hari_efektif as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

	//---------------------------------------------------------------------------------------------------
	$t_data_jemputan=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`nis`' => 'varchar(100)',
		'`nama_siswa`' => 'varchar(100)',
		'`id_driver`' => 'int',
		'`nama_driver`' => 'varchar(100)',
		'`jarak`' => 'float',
		'`jemputan_club`' => 'enum("t","f") default "f"',
		'`keterangan`' => 'text',
		'`status_tampil`' => 'enum("t","f")',
		'`status`' =>  'ENUM( "pulang","pergi","pulang-pergi" )'
	];
	if (!$ci->db->table_exists('t_data_jemputan'))
	{
		$t_s='create table t_data_jemputan(';
		foreach ($t_data_jemputan as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}
	//---------------------------------------------------------------------------------------------------
	$t_data_pendamping=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`nis`' => 'varchar(100)',
		'`nama_siswa`' => 'varchar(100)',
		'`id_guru`' => 'int',
		'`nama_guru`' => 'varchar(100)',
		'`keterangan`' => 'text',
		'`biaya`' => 'double',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_data_pendamping'))
	{
		$t_s='create table t_data_pendamping(';
		foreach ($t_data_pendamping as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

	//---------------------------------------------------------------------------------------------------
	$t_data_potongan=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`nis`' => 'varchar(100)',
		'`nama_siswa`' => 'varchar(100)',
		'`batch_id`' => 'int',
		'`nama_kelas`' => 'varchar(100)',
		'`tahun_ajaran`' => 'varchar(100)',
		'`jenis_id`' => 'int',
		'`jenis_potongan`' => 'varchar(100)',
		'`biaya`' => 'double',
		'`persen`' => 'float',
		'`keterangan`' => 'text',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_data_potongan'))
	{
		$t_s='create table t_data_potongan(';
		foreach ($t_data_potongan as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

		//---------------------------------------------------------------------------------------------------
	$t_data_club_siswa=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`nis`' => 'varchar(100)',
		'`nama_siswa`' => 'varchar(100)',
		'`id_club`' => 'varchar(100)',
		'`nama_club`' => 'varchar(100)',
		'`keterangan`' => 'text',
		'`status_tampil`' => 'enum("t","f")'

	];
	if (!$ci->db->table_exists('t_data_club_siswa'))
	{
		$t_s='create table t_data_club_siswa(';
		foreach ($t_data_club_siswa as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

	$t_data_catering_siswa=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`nis`' => 'varchar(100)',
		'`nama_siswa`' => 'varchar(100)',
		'`id_catering`' => 'int',
		'`nama_catering`' => 'varchar(100)',
		'`keterangan`' => 'text',
		'`status_tampil`' => 'enum("t","f")'

	];
	if (!$ci->db->table_exists('t_data_catering_siswa'))
	{
		$t_s='create table t_data_catering_siswa(';
		foreach ($t_data_catering_siswa as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}
	//---------------------------------------------------------------------------------------------------
	$t_ajaran=[
		'`id_ajaran`' => 'int primary key AUTO_INCREMENT',
		'`tahun_ajaran`' => 'varchar(100)',
		'`bulan_awal`' => 'char(10)',
		'`bulan_akhir`' => 'char(10)',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_ajaran'))
	{
		$t_s='create table t_ajaran(';
		foreach ($t_ajaran as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}
	//---------------------------------------------------------------------------------------------------
	$t_bank=[
		'`id_bank`' => 'int primary key AUTO_INCREMENT',
		'`nama_bank`' => 'varchar(100)',
		'`no_rekening`' => 'varchar(100)',
		'`nama_rekening`' => 'varchar(100)',
		'`saldo`' => 'double',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_bank'))
	{
		$t_s='create table t_bank(';
		foreach ($t_bank as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

	$t_bank_rekening_koran=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`id_bank`' => 'int',
		'`nama_bank`' => 'varchar(200)',
		'`tanggal`' => 'datetime',
		'`kat`' => 'char(10)',
		'`keterangan`' => 'text',
		'`jumlah`' => 'double',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_bank_rekening_koran'))
	{
		$t_s='create table t_bank_rekening_koran(';
		foreach ($t_bank_rekening_koran as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}


	//---------------------------------------------------------------------------------------------------
	$t_transaksi=[
		'`id_trans`' => 'int primary key AUTO_INCREMENT',
		'`tanggal_transaksi`' => 'datetime',
		'`no_kwitansi`' => 'varchar(100)',
		'`total`' => 'double',
		'`penyetor`' => 'varchar(100)',
		'`penerima`' => 'varchar(100)',

		'`nis`' => 'varchar(100)',
		'`batch_id`' => 'varchar(100)',
		'`ket`' => 'text',
		'`ref_bank`' => 'varchar(100)',
		'`rek_bank`' => 'varchar(100)',
		'`status_transaksi`' => 'enum("1-Bank","2-Tunai","3-Lainnya")',
		'`status_verifikasi`' => 'enum("t","f")',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_transaksi'))
	{
		$t_s='create table t_transaksi(';
		foreach ($t_transaksi as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

	$t_transaksi_detail=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`trans_id`' => 'int',
		'`penerimaan_id`' => 'varchar(100)',
		'`jumlah`' => 'double',
		'`keterangan`' => 'varchar(255)',
		'`club`' => 'varchar(100)',
		'`driver`' => 'varchar(100)',
		'`status_verifikasi_detail`' => 'enum("t","f")',
		'`bulan_tagihan`' => 'int',
		'`tahun_tagihan`' => 'int',
		'`status_tampil_detail`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_transaksi_detail'))
	{
		$t_s='create table t_transaksi_detail(';
		foreach ($t_transaksi_detail as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

	if (!$ci->db->table_exists('v_transaksi'))
	{
		$t_s="CREATE VIEW `v_transaksi` AS select `tr`.`id_trans` AS `id_trans`,`tr`.`tanggal_transaksi` AS `tanggal_transaksi`,`tr`.`no_kwitansi` AS `no_kwitansi`,`tr`.`total` AS `total`,`tr`.`penyetor` AS `penyetor`,`tr`.`penerima` AS `penerima`,`tr`.`batch_id` AS `batch_id`,`tr`.`ket` AS `ket`,`tr`.`status_transaksi` AS `status_transaksi`,`tr`.`status_verifikasi` AS `status_verifikasi`,`tr`.`status_tampil` AS `status_tampil`,`td`.`bulan_tagihan` AS `bulan_tagihan`,`td`.`tahun_tagihan` AS `tahun_tagihan`,`tr`.`nis` AS `nis`,`td`.`id` AS `id`,`td`.`trans_id` AS `trans_id`,`td`.`penerimaan_id` AS `penerimaan_id`,`td`.`jumlah` AS `jumlah`,`td`.`keterangan` AS `keterangan`,`td`.`club` AS `club`,`td`.`driver` AS `driver`,`td`.`status_verifikasi_detail` AS `status_verifikasi_detail`,`td`.`status_tampil_detail` AS `status_tampil_detail` from (`t_transaksi` `tr` join `t_transaksi_detail` `td` on((`tr`.`id_trans` = `td`.`trans_id`)))";
		$ci->db->query($t_s);

	}

	if (!$ci->db->table_exists('v_transaksi_penerimaan'))
	{
		$t_s="CREATE VIEW `v_transaksi_penerimaan` AS select `tr`.`id_trans` AS `id_trans`,`tr`.`tanggal_transaksi` AS `tanggal_transaksi`,`tr`.`no_kwitansi` AS `no_kwitansi`,`tr`.`total` AS `total`,`tr`.`penyetor` AS `penyetor`,`tr`.`penerima` AS `penerima`,`tr`.`batch_id` AS `batch_id`,`tr`.`ket` AS `ket`,`tr`.`status_transaksi` AS `status_transaksi`,`tr`.`status_verifikasi` AS `status_verifikasi`,`tr`.`status_tampil` AS `status_tampil`,`tr`.`nis` AS `nis`,`tr`.`ref_bank` AS `ref_bank`,`tr`.`rek_bank` AS `rek_bank`,`td`.`id` AS `id`,`td`.`trans_id` AS `trans_id`,`td`.`penerimaan_id` AS `penerimaan_id`,`td`.`jumlah` AS `jumlah`,`td`.`keterangan` AS `keterangan`,`td`.`club` AS `club`,`td`.`driver` AS `driver`,`td`.`status_verifikasi_detail` AS `status_verifikasi_detail`,`td`.`status_tampil_detail` AS `status_tampil_detail`,`td`.`bulan_tagihan` AS `bulan_tagihan`,`td`.`tahun_tagihan` AS `tahun_tagihan`,`tp`.`jenis` AS `jenis`,tr.tahun_ajaran from ((`t_transaksi` `tr` join `t_transaksi_detail` `td` on((`tr`.`id_trans` = `td`.`trans_id`))) join `t_jenis_penerimaan` `tp` on((`td`.`penerimaan_id` = `tp`.`id`)))";
		$ci->db->query($t_s);

	}

//------------------------------------------------------------------------------------------------------
	$t_transaksi_pengeluaran=[
		'`id_trans`' => 'int primary key AUTO_INCREMENT',
		'`tanggal_transaksi`' => 'datetime',
		'`no_kwitansi`' => 'varchar(100)',
		'`total`' => 'double',
		'`penyetor`' => 'varchar(100)',
		'`penerima`' => 'varchar(100)',
		'`batch_id`' => 'varchar(100)',
		'`ket`' => 'text',
		'`status_transaksi`' => 'enum("1-Bank","2-Tunai","3-Lainnya")',
		'`status_verifikasi`' => 'enum("t","f")',
		'`status_tampil`' => 'enum("t","f")',
		'`ref_bank`' => 'varchar(100)',
		'`rek_bank`' => 'varchar(100)',
		'`ket`' => 'text'
	];
	if (!$ci->db->table_exists('t_transaksi_pengeluaran'))
	{
		$t_s='create table t_transaksi_pengeluaran(';
		foreach ($t_transaksi_pengeluaran as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

	$t_transaksi_pengeluaran_detail=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`trans_id`' => 'int',
		'`pengeluaran_id`' => 'varchar(100)',
		'`jumlah`' => 'double',
		'`keterangan`' => 'varchar(255)',
		'`status_verifikasi_detail`' => 'enum("t","f")',
		'`bulan_tagihan`' => 'int',
		'`tahun_tagihan`' => 'int',
		'`status_tampil_detail`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_transaksi_pengeluaran_detail'))
	{
		$t_s='create table t_transaksi_pengeluaran_detail(';
		foreach ($t_transaksi_pengeluaran_detail as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

	if (!$ci->db->table_exists('v_transaksi_pengeluaran'))
	{
		$t_s="CREATE VIEW `v_transaksi_pengeluaran` AS select `tr`.`id_trans` AS `id_trans`,`tr`.`tanggal_transaksi` AS `tanggal_transaksi`,`tr`.`no_kwitansi` AS `no_kwitansi`,`tr`.`total` AS `total`,`tr`.`penyetor` AS `penyetor`,`tr`.`penerima` AS `penerima`,`tr`.`batch_id` AS `batch_id`,`tr`.`ket` AS `ket`,`tr`.`status_transaksi` AS `status_transaksi`,`tr`.`status_verifikasi` AS `status_verifikasi`,`tr`.`status_tampil` AS `status_tampil`,`td`.`bulan_tagihan` AS `bulan_tagihan`,`td`.`tahun_tagihan` AS `tahun_tagihan`,`td`.`id` AS `id`,`td`.`trans_id` AS `trans_id`,`td`.`pengeluaran_id` AS `pengeluaran_id`,`td`.`jumlah` AS `jumlah`,`td`.`keterangan` AS `keterangan`,`td`.`status_verifikasi_detail` AS `status_verifikasi_detail`,`td`.`status_tampil_detail` AS `status_tampil_detail` from (`t_transaksi_pengeluaran` `tr` join `t_transaksi_pengeluaran_detail` `td` on((`tr`.`id_trans` = `td`.`trans_id`)))";
		$ci->db->query($t_s);

	}

	if (!$ci->db->table_exists('v_transaksi_pengeluaran_detail'))
	{
		$t_s="CREATE VIEW `v_transaksi_pengeluaran_detail` AS select `tr`.`id_trans` AS `id_trans`,`tr`.`tanggal_transaksi` AS `tanggal_transaksi`,`tr`.`no_kwitansi` AS `no_kwitansi`,`tr`.`total` AS `total`,`tr`.`penyetor` AS `penyetor`,`tr`.`penerima` AS `penerima`,`tr`.`batch_id` AS `batch_id`,`tr`.`ket` AS `ket`,`tr`.`status_transaksi` AS `status_transaksi`,`tr`.`status_verifikasi` AS `status_verifikasi`,`tr`.`status_tampil` AS `status_tampil`,`td`.`id` AS `id`,`td`.`trans_id` AS `trans_id`,`td`.`pengeluaran_id` AS `pengeluaran_id`,`td`.`jumlah` AS `jumlah`,`td`.`keterangan` AS `keterangan`,`td`.`status_verifikasi_detail` AS `status_verifikasi_detail`,`td`.`status_tampil_detail` AS `status_tampil_detail`,`td`.`bulan_tagihan` AS `bulan_tagihan`,`td`.`tahun_tagihan` AS `tahun_tagihan`,`tp`.`jenis` AS `jenis` from ((`t_transaksi_pengeluaran` `tr` join `t_transaksi_pengeluaran_detail` `td` on((`tr`.`id_trans` = `td`.`trans_id`))) join `t_jenis_pengeluaran` `tp` on((`td`.`pengeluaran_id` = `tp`.`id`)))";
		$ci->db->query($t_s);

	}
//------------------------------------------------------------------------------------------------------
	$t_tabungan=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`no_tabungan_rekening`' => 'varchar(50)',
		'`siswa_id`' => 'int',
		'`saldo`' => 'double',
		'`ket`' => 'varchar(255)',
		'`last_update`' => 'datetime',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_tabungan'))
	{
		$t_s='create table t_tabungan(';
		foreach ($t_tabungan as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

	$t_tabungan_detail=[
		'`id_det`' => 'int primary key AUTO_INCREMENT',
		'`tabungan_id`' => 'int',
		'`jumlah`' => 'double',
		'`jenis`' => 'char(10)',
		'`penerima`' => 'varchar(255)',
		'`penyetor_penarik`' => 'varchar(255)',
		'`tanggal`' => 'datetime',
		'`keterangan`' => 'text',
		'`batch_id`' => 'int',
		'`status_tampil_det`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_tabungan_detail'))
	{
		$t_s='create table t_tabungan_detail(';
		foreach ($t_tabungan_detail as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

//----------
	$t_tabungan_sdm=[
		'`id`' => 'int primary key AUTO_INCREMENT',
		'`no_tabungan_rekening`' => 'varchar(50)',
		'`id_sdm`' => 'int',
		'`saldo`' => 'double',
		'`ket`' => 'varchar(255)',
		'`last_update`' => 'datetime',
		'`status_tampil`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_tabungan_sdm'))
	{
		$t_s='create table t_tabungan_sdm(';
		foreach ($t_tabungan_sdm as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}

	$t_tabungan_sdm_detail=[
		'`id_det`' => 'int primary key AUTO_INCREMENT',
		'`tabungan_id`' => 'int',
		'`jumlah`' => 'double',
		'`jenis`' => 'char(10)',
		'`penerima`' => 'varchar(255)',
		'`penyetor_penarik`' => 'varchar(255)',
		'`tanggal`' => 'datetime',
		'`keterangan`' => 'text',
		'`status_tampil_det`' => 'enum("t","f")'
	];
	if (!$ci->db->table_exists('t_tabungan_sdm_detail'))
	{
		$t_s='create table t_tabungan_sdm_detail(';
		foreach ($t_tabungan_sdm_detail as $k => $v)
		{
			$t_s.=$k.' '.$v.',';
		}
		$t_s=substr($t_s, 0, -1);
		$t_s.=');';
		// echo $t_s;
		$ci->db->query($t_s);

	}
//----------
	if (!$ci->db->table_exists('t_pendaftaran'))
	{
		$c="CREATE TABLE `t_pendaftaran` (
		  `id` int(11) NOT NULL,
		  `nama_siswa` varchar(100) NOT NULL,
		  `nis` varchar(50) NOT NULL,
		  `id_siswa` int(11) NOT NULL,
		  `id_penerimaan` varchar(50) NOT NULL,
		  `jenis_penerimaan` varchar(100) NOT NULL,
		  `jumlah` varchar(255) NOT NULL,
		  `tahun_ajaran` varchar(20) NOT NULL,
		  `kategori_daftar` enum('du','baru') NOT NULL,
		  `kelas` varchar(30) NOT NULL,
		  `level` varchar(30) NOT NULL,
		  `idlevel` int(11) NOT NULL,
		  `kategori` varchar(20) NOT NULL,
		  `status_tampil` enum('t','f') NOT NULL DEFAULT 't'
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$ci->db->query($c);
	}
	if (!$ci->db->table_exists('v_batch_siswa'))
	{
		$cc="CREATE VIEW `v_batch_siswa` AS select `tbs`.`id` AS `id_tbs`,`tbs`.`id_batch` AS `id_batch`,`tbs`.`active` AS `active`,`tbs`.`status_tampil` AS `st_tbs`,`tbk`.`nama_batch` AS `nama_batch`,`tbk`.`wali_kelas` AS `wali_kelas`,`tbk`.`tahun_ajaran` AS `tahun_ajaran`,`tbk`.`status_tampil` AS `st_tbk`,`tbk`.`id_level` AS `id_level`,`ts`.`id` AS `id`,`ts`.`nama_murid` AS `nama_murid`,`ts`.`nama_panggilan` AS `nama_panggilan`,`ts`.`jenis_kelamin` AS `jenis_kelamin`,`ts`.`tempat_lahir` AS `tempat_lahir`,`ts`.`tanggal_lahir` AS `tanggal_lahir`,`ts`.`NIK` AS `NIK`,`ts`.`no_akte_lahir` AS `no_akte_lahir`,`ts`.`kebangsaan` AS `kebangsaan`,`ts`.`kewarganegaraan` AS `kewarganegaraan`,`ts`.`agama` AS `agama`,`ts`.`sakit_berat` AS `sakit_berat`,`ts`.`alamat` AS `alamat`,`ts`.`provinsi` AS `provinsi`,`ts`.`kota` AS `kota`,`ts`.`kode_pos` AS `kode_pos`,`ts`.`telp_rumah` AS `telp_rumah`,`ts`.`fax_rumah` AS `fax_rumah`,`ts`.`hp` AS `hp`,`ts`.`email` AS `email`,`ts`.`nama_ayah` AS `nama_ayah`,`ts`.`ktp_ayah` AS `ktp_ayah`,`ts`.`hp_ayah` AS `hp_ayah`,`ts`.`fax_ayah` AS `fax_ayah`,`ts`.`email_ayah` AS `email_ayah`,`ts`.`nisn` AS `nisn`,`ts`.`pekerjaan_ayah` AS `pekerjaan_ayah`,`ts`.`kebangsaaan_ayah` AS `kebangsaaan_ayah`,`ts`.`kewarganeraan_ayah` AS `kewarganeraan_ayah`,`ts`.`gaji_ayah` AS `gaji_ayah`,`ts`.`hub_ayah_dengan_murid` AS `hub_ayah_dengan_murid`,`ts`.`kantor_ayah` AS `kantor_ayah`,`ts`.`alamat_kantor_ayah` AS `alamat_kantor_ayah`,`ts`.`provinsi_kantor_ayah` AS `provinsi_kantor_ayah`,`ts`.`pendidikan_ayah` AS `pendidikan_ayah`,`ts`.`nama_ibu` AS `nama_ibu`,`ts`.`hp_ibu` AS `hp_ibu`,`ts`.`fax_ibu` AS `fax_ibu`,`ts`.`email_ibu` AS `email_ibu`,`ts`.`pekerjaan_ibu` AS `pekerjaan_ibu`,`ts`.`gaji_ibu` AS `gaji_ibu`,`ts`.`hub_ibu_dengan_murid` AS `hub_ibu_dengan_murid`,`ts`.`kantor_ibu` AS `kantor_ibu`,`ts`.`alamat_kantor_ibu` AS `alamat_kantor_ibu`,`ts`.`provinsi_kantor_ibu` AS `provinsi_kantor_ibu`,`ts`.`kebangsaaan_ibu` AS `kebangsaaan_ibu`,`ts`.`kewarganeraan_ibu` AS `kewarganeraan_ibu`,`ts`.`pendidikan_ibu` AS `pendidikan_ibu`,`ts`.`nama_wali` AS `nama_wali`,`ts`.`ktp_wali` AS `ktp_wali`,`ts`.`telp_wali` AS `telp_wali`,`ts`.`hp_wali` AS `hp_wali`,`ts`.`fax_wali` AS `fax_wali`,`ts`.`email_wali` AS `email_wali`,`ts`.`alamat_wali` AS `alamat_wali`,`ts`.`provinsi_wali` AS `provinsi_wali`,`ts`.`hub_wali_dengan_murid` AS `hub_wali_dengan_murid`,`ts`.`no_virtual_account` AS `no_virtual_account`,`ts`.`alamat_darurat` AS `alamat_darurat`,`ts`.`status_tampil` AS `status_tampil`,`ts`.`nis` AS `nis`,`ts`.`kelurahan` AS `kelurahan`,`ts`.`kecamatan` AS `kecamatan` from ((`t_batch_siswa` `tbs` join `t_batch_kelas` `tbk` on((`tbk`.`id_batch` = `tbs`.`id_batch`))) join `t_siswa` `ts` on((`ts`.`id` = `tbs`.`id_siswa`)))";

		$ci->db->query($cc);
	}
//------------------------------------------------------------------------------------------------------

	if (!$ci->db->field_exists('id_club', 't_tagihan_siswa'))
	{
	    $fields = array(
		        'id_club' => array(
					'type' => 'INTEGER',
					'default'=>0
	            )
		);
		$ci->dbforge->add_column('t_tagihan_siswa', $fields);
	}
	if (!$ci->db->field_exists('akun_alternatif', 't_akun'))
	{
	    $fields = array(
		        'akun_alternatif' => array(
		        	'type' => 'VARCHAR',
	                'constraint' => '100'
	            )
		);
		$ci->dbforge->add_column('t_akun', $fields);
	}

	if (!$ci->db->field_exists('level', 't_hari_efektif'))
	{
	    $fields = array(
		        'level' => array(
		        	'type' => 'VARCHAR',
	                'constraint' => '100'
	            ),
						'program' => array(
			        	'type' => 'VARCHAR',
		                'constraint' => '100'
		            )
		);
		$ci->dbforge->add_column('t_hari_efektif', $fields);
	}
	if (!$ci->db->field_exists('jumlah_hari_catering', 't_hari_efektif'))
	{
	    $fields = array(
		        'jumlah_hari_catering' => array(
		        	'type' => 'INTEGER'
				),
		        'jumlah_hari_jemputan' => array(
		        	'type' => 'INTEGER'
	            )
		);
		$ci->dbforge->add_column('t_hari_efektif', $fields);
	}
	if (!$ci->db->field_exists('created_at', 't_siswa_dana_lebih'))
	{
	    $fields = array(
		        'created_at' => array(
		        	'type' => 'DATETIME'
				),
		        'keterangan' => array(
					'type' => 'VARCHAR',
					'constraint'=>255
	            )
		);
		$ci->dbforge->add_column('t_siswa_dana_lebih', $fields);
	}
	if (!$ci->db->field_exists('kategori', 't_saldo_awal_neraca'))
	{
	    $fields = array(
		       
		        'kategori' => array(
					'type' => 'VARCHAR',
					'constraint'=>255
	            )
		);
		$ci->dbforge->add_column('t_saldo_awal_neraca', $fields);
	}
//------------------------------------------------------------------------------------------------------
	if(date('n')>=10)
	{
		$tahun_ajaran=date('Y').' / '.(date('Y')+1);
		$cekta=$ci->db->query('select * from t_ajaran where tahun_ajaran like "%'.$tahun_ajaran.'%"');
		if(count($cekta->result())==0)
		{
			$d=array(
				'tahun_ajaran'=>$tahun_ajaran,
				'bulan_awal'=>'juli',
				'bulan_akhir'=>'juni',
				'status_tampil'=>'t'
			);
			$ci->db->insert('t_ajaran',$d);
		}
	}
	// if()
	// echo implode(',', $t_siswa);
	//---------------------------------------
	$ha=$ci->db->from('t_hari_efektif')->where('status_tampil','t')->get()->result();
	if(count($ha)!=0)
	{
		$he=$helevel=array();
		foreach ($ha as $k => $v) {
			$he[$v->bulan][$v->tahun]=$v;
			$helevel[$v->bulan][$v->tahun][str_replace(' ','_',$v->level)]=$v;
		}

		$ci->config->set_item('hari_efektif',$he);
		$ci->config->set_item('hari_efektif_level',$helevel);
	}
	else{
		$ci->config->set_item('hari_efektif',20);
		$ci->config->set_item('hari_efektif_level',20);
	}
/*
	Table RAB
*/

	if (!$ci->db->table_exists('t_program'))
	{
		$c="CREATE TABLE `t_program` (
		  `id` int(11) NOT NULL primary key auto_increment,
		  `program` varchar(255) NOT NULL,
		  `nama_leader` varchar(255) NOT NULL,
		  `leader_id` int(11) NOT NULL,
		  `flag` enum('1','0') NOT NULL DEFAULT '1',
		  `created_at` datetime NULL DEFAULT NULL,
		  `updated_at` datetime NULL DEFAULT NULL,
		  `deleted_at` datetime NULL DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$ci->db->query($c);
	}
	if (!$ci->db->field_exists('kode_akun', 't_program'))
	{
	    $fields = array(
		        'kode_akun' => array(
		        	'type' => 'VARCHAR',
	                'constraint' => '100'
	            )
		);
		$ci->dbforge->add_column('t_program', $fields);
	}
	if (!$ci->db->table_exists('t_sasaran_mutu'))
	{
		$c="CREATE TABLE `t_sasaran_mutu` (
		  `id` int(11) NOT NULL primary key auto_increment,
		  `sasaran_mutu` varchar(255) NOT NULL,
		  `program_id` int(11) NOT NULL,
		  `flag` enum('1','0') NOT NULL DEFAULT '1',
		  `created_at` datetime NULL DEFAULT NULL,
		  `updated_at` datetime NULL DEFAULT NULL,
		  `deleted_at` datetime NULL DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$ci->db->query($c);
	}
	if (!$ci->db->field_exists('tahun_ajaran', 't_sasaran_mutu'))
	{
	    $fields = array(
		        'tahun_ajaran' => array(
		        	'type' => 'VARCHAR',
	                'constraint' => '100'
	            )
		);
		$ci->dbforge->add_column('t_sasaran_mutu', $fields);
	}
	if (!$ci->db->field_exists('kode_akun', 't_bank'))
	{
	    $fields = array(
		        'kode_akun' => array(
		        	'type' => 'VARCHAR',
	                'constraint' => '100'
	            )
		);
		$ci->dbforge->add_column('t_bank', $fields);
	}
	if (!$ci->db->field_exists('tahun_masuk', 't_siswa'))
	{
	    $fields = array(
		        'tahun_masuk' => array(
		        	'type' => 'INTEGER'
				),
				'foto' => array(
		        	'type' => 'VARCHAR',
	                'constraint' => '255'
	            )
		);
		$ci->dbforge->add_column('t_siswa', $fields);
	}
	if (!$ci->db->table_exists('t_kegiatan'))
	{
		$c="CREATE TABLE `t_kegiatan` (
		  `id` int(11) NOT NULL primary key auto_increment,
		  `kegiatan` varchar(255) NOT NULL,
		  `sasaran_mutu_id` int(11) NOT NULL,
		  `program_id` int(11) NOT NULL,
		  `pic` varchar(255) NOT NULL,
		  `pic_id` int(11) NOT NULL,
		  `kode_akun` varchar(100)  NULL,
		  `flag` enum('1','0') NOT NULL DEFAULT '1',
		  `keterangan` text  NULL DEFAULT NULL,
		  `created_at` datetime NULL DEFAULT NULL,
		  `updated_at` datetime NULL DEFAULT NULL,
		  `deleted_at` datetime NULL DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$ci->db->query($c);
	}
	if (!$ci->db->table_exists('t_rab'))
	{
		$c="CREATE TABLE `t_rab` (
		  `id` int(11) NOT NULL primary key auto_increment,
		  `kegiatan` varchar(255) NOT NULL,
		  `sasaran_mutu_id` int(11) NOT NULL,
		  `program_id` int(11) NOT NULL,
		  `pic` varchar(255)  NULL,
		  `pic_id` int(11)  NULL,
		  `bulan` int(11)  NULL default '0',
		  `tahun` int(11)  NULL default '0',
		  `tahun_ajaran` varchar(100)  NULL,
		  `kode_akun` varchar(100)  NULL,
		  `anggaran` double  NULL default '0',
		  `flag` enum('1','0') NOT NULL DEFAULT '1',
		  `keterangan` text  NULL DEFAULT NULL,
		  `created_at` datetime NULL DEFAULT NULL,
		  `updated_at` datetime NULL DEFAULT NULL,
		  `deleted_at` datetime NULL DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$ci->db->query($c);
	}
	
	if (!$ci->db->table_exists('t_saldo_akun'))
	{
		$c="CREATE TABLE `t_saldo_akun` (
		  `id` int(11) NOT NULL primary key auto_increment,
		  `kode_akun` varchar(50) NOT NULL,
		  `kode_akun_alt` varchar(50) NOT NULL,
		  `bulan` int(11) NOT NULL,
		  `tahun` int(11) NOT NULL,
		  `jumlah` double NOT NULL,
		  `tahun_ajaran` varchar(50) NOT NULL,
		  `created_at` datetime NULL DEFAULT NULL,
		  `updated_at` datetime NULL DEFAULT NULL,
		  `deleted_at` datetime NULL DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$ci->db->query($c);
	}
	if (!$ci->db->table_exists('t_saldo_neraca_lajur'))
	{
		$c="CREATE TABLE `t_saldo_neraca_lajur` (
		  `id` int(11) NOT NULL primary key auto_increment,
		  `kode_akun` varchar(50) NOT NULL,
		  `kode_akun_alt` varchar(50) NOT NULL,
		  `bulan` int(11) NOT NULL,
		  `tahun` int(11) NOT NULL,
		  `jumlah` double NOT NULL,
		  `tahun_ajaran` varchar(50) NOT NULL,
		  `created_at` datetime NULL DEFAULT NULL,
		  `updated_at` datetime NULL DEFAULT NULL,
		  `deleted_at` datetime NULL DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$ci->db->query($c);
	}
	if (!$ci->db->table_exists('t_saldo_awal_neraca'))
	{
		$c="CREATE TABLE `t_saldo_awal_neraca` (
		  `id` int(11) NOT NULL primary key auto_increment,
		  `kode_akun` varchar(50) NOT NULL,
		  `nama_akun` varchar(50) NOT NULL,
		  `kode_akun_alt` varchar(50) NOT NULL,
		  `bulan` int(11) NOT NULL,
		  `tahun` int(11) NOT NULL,
		  `jumlah` double NOT NULL,
		  `tahun_ajaran` varchar(50) NOT NULL,
		  `created_at` datetime NULL DEFAULT NULL,
		  `updated_at` datetime NULL DEFAULT NULL,
		  `deleted_at` datetime NULL DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$ci->db->query($c);
	}
	if (!$ci->db->table_exists('t_pencairan_program'))
	{
		$c="CREATE TABLE `t_pencairan_program` (
		  `id` int(11) NOT NULL primary key auto_increment,
		  `id_trans` double NOT NULL,
		  `id_program` int(11) NOT NULL,
		  `program` varchar(255) NOT NULL,
		  `id_kegiatan` int(11) NOT NULL,
		  `kegiatan` varchar(255) NOT NULL,
		  `no_kwitansi` varchar(255) NOT NULL,
		  `jumlah` double NOT NULL,
		  `tgl_pencairan` datetime NOT NULL,
		  `created_at` datetime NULL DEFAULT NULL,
		  `updated_at` datetime NULL DEFAULT NULL,
		  `deleted_at` datetime NULL DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$ci->db->query($c);
	}
	if (!$ci->db->table_exists('t_lpj_program'))
	{
		$c="CREATE TABLE `t_lpj_program` (
		  `id` int(11) NOT NULL primary key auto_increment,
		  `id_trans` double NOT NULL,
		  `id_pencairan` int(11) NOT NULL,
		  `id_kegiatan` int(11) NOT NULL,
		  `kegiatan` varchar(255) NOT NULL,
		  `no_kwitansi` varchar(255) NOT NULL,
		  `keterangan` varchar(255) NOT NULL,
		  `pic` varchar(255) NOT NULL,
		  `bukti` varchar(255) NOT NULL,
		  `jumlah` double NOT NULL,
		  `tgl_pengeluaran` date NOT NULL,
		  `tgl_lpj` datetime NOT NULL,
		  `created_at` datetime NULL DEFAULT NULL,
		  `updated_at` datetime NULL DEFAULT NULL,
		  `deleted_at` datetime NULL DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$ci->db->query($c);
	}
	if (!$ci->db->table_exists('t_jurnal'))
	{
		$c="CREATE TABLE `t_jurnal` (
		  `id` int(11) NOT NULL primary key auto_increment,
		  `tanggal` date NOT NULL,
		  `kode_akun` varchar(50) NOT NULL,
		  `ref` varchar(255) NOT NULL,
		  `keterangan` varchar(255) NOT NULL,
		  `debit` double NOT NULL,
		  `kredit` double NOT NULL,
		  `created_at` datetime NULL DEFAULT NULL,
		  `updated_at` datetime NULL DEFAULT NULL,
		  `deleted_at` datetime NULL DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$ci->db->query($c);
	}

/*
	END Table RAB
*/

	if ( !$ci->config->item('tajaran')) 
	{
		$tajaran=array();
		$tajaran2=array();
		$ajaran=$ci->db->from('t_ajaran')->where('status_tampil','t')->order_by('tahun_ajaran','desc')->get();
		foreach ($ajaran->result() as $k => $v)
		{
			$tajaran[$v->id_ajaran]=$v;
			$tajaran2[$v->tahun_ajaran]=$v;
		}
		$ajaran->free_result();
		
		$ci->config->set_item('tajaran',$tajaran);
		$ci->config->set_item('tajaran2',$tajaran2);
	}

	if ( !$ci->config->item('tclub')) 
	{
		$tclub=array();
		$club=$ci->db->from('t_club')->where('status_tampil','t')->get();
		foreach ($club->result() as $k => $v)
		{
			$tclub[$v->id_club]=$v;
		}
		$ci->config->set_item('tclub',$tclub);
		$club->free_result();
	}

	if ( !$ci->config->item('tlevelkelas')) 
	{
		$tlevelkelas=array();
		$levelkelas=$ci->db->from('t_level_kelas')->where('status_tampil','t')->get();
		foreach ($levelkelas->result() as $k => $v)
		{
			$tlevelkelas[$v->id_level]=$v;
		}
		$ci->config->set_item('tlevelkelas',$tlevelkelas);
		$levelkelas->free_result();
	}

	if ( !$ci->config->item('t_pendaftaran')) 
	{
		$tpendaftaran=array();
		$tpendaftaran2=array();
		$tpendaftaran3=array();
		$pendaftaran=$ci->db->from('t_pendaftaran')->where('status_tampil','t')->get();
		foreach ($pendaftaran->result() as $k => $v)
		{
			$tpendaftaran[$v->tahun_ajaran][$v->idlevel][$v->id_siswa]=$v;
			$tpendaftaran2[$v->tahun_ajaran][$v->id_siswa]=$v;
			$tpendaftaran3[$v->tahun_ajaran][$v->nis]=$v;
		}
		$ci->config->set_item('tpendaftaran',$tpendaftaran);
		$ci->config->set_item('tpendaftaran2',$tpendaftaran2);
		$ci->config->set_item('tpendaftaran3',$tpendaftaran3);
		$pendaftaran->free_result();
	}

	if ( !$ci->config->item('tguru')) 
	{
		$tguru=array();
		$dguru=$ci->db->from('t_guru')->where('status_tampil','t')->order_by('nama_guru')->get();
		foreach ($dguru->result() as $k => $v)
		{
			$tguru[$v->id_guru]=$v;
		}
		$ci->config->set_item('tguru',$tguru);
		$dguru->free_result();
	}

	if ( !$ci->config->item('tsiswa')) 
	{
		$tsiswa=array();
		$nsiswa=$nsiswalower=array();
		$nissiswa=array();
		$nissiswa2=array();
		$nisnsiswa=array();
		$dsiswa=$ci->db->from('t_siswa')->where('status_tampil','t')->order_by('nama_murid asc')->get();
		foreach ($dsiswa->result() as $k => $v)
		{
			$tsiswa[$v->id]=$v;
			$nissiswa[$v->nis]=$v;
			$nissiswa2[str_replace('.','_',$v->nis)]=$v;
			$nisnsiswa[trim($v->nisn)]=$v;
			$nsiswa[trim($v->nama_murid)]=$v;
			$nsiswalower[strtolower(trim($v->nama_murid))]=$v;
		}
		$ci->config->set_item('tsiswa',$tsiswa);
		$ci->config->set_item('nsiswa',$nsiswa);
		$ci->config->set_item('nissiswa2',$nissiswa2);
		$ci->config->set_item('nsiswalower',$nsiswalower);
		$ci->config->set_item('nissiswa',$nissiswa);
		$ci->config->set_item('nisnsiswa',$nisnsiswa);
		$dsiswa->free_result();
	}

	if ( !$ci->config->item('vbatchsiswa')) 
	{
		$vbatchsiswa=array();
		$vbatchsiswabykelas=array();
		$vbatchsiswabylevel=array();
		$vbs=$ci->db->from('v_batch_siswa')->where('st_tbk','t')->where('active',1)->order_by('nama_murid asc,id_tbs desc')->get();
		foreach ($vbs->result() as $k => $v)
		{
			$vbatchsiswa[$v->nis]=$v;
			$vbatchsiswabykelas[$v->id_batch][]=$v;
			$vbatchsiswabylevel[$v->id_level][]=$v;
		}
		$ci->config->set_item('vbatchsiswa',$vbatchsiswa);
		$ci->config->set_item('vbatchsiswabykelas',$vbatchsiswabykelas);
		$ci->config->set_item('vbatchsiswabylevel',$vbatchsiswabylevel);
		$vbs->free_result();
	}

	if ( !$ci->config->item('vbatchkelas')) 
	{
		$vbatchkelas=$levelkelas=$kelas_ta=array();
		$vbk=$ci->db->from('v_batch_kelas')->where('st_batch','t')->get();
		foreach ($vbk->result() as $k => $v)
		{
			$vbatchkelas[$v->id_batch]=$v;	
			$levelkelas[$v->id_level]=$v;
		}
		$ci->config->set_item('vbatchkelas',$vbatchkelas);
		// ksort($levelkelas);
		$ci->config->set_item('levelkelas',$levelkelas);
		// $ci->config->set_item('kelas_ta',$kelas_ta);
		$vbk->free_result();

		$vbkall=$ci->db->from('v_batch_kelas')->where('st_batch !=','i',true)->order_by('id_level')->get();
		foreach($vbkall->result() as $k => $v)
		{
			$kelas_ta[$v->tahun_ajaran][$v->id_level][$v->id_batch]=$v;
		}
		$ci->config->set_item('kelas_ta',$kelas_ta);
		$vbkall->free_result();
	}

	if ( !$ci->config->item('tabungan')) 
	{
		$tTab=array();
		$tTabSiswa=array();
		$tabungan=$ci->db->from('t_tabungan')->join('t_tabungan_detail','t_tabungan.id=t_tabungan_detail.tabungan_id')->order_by('t_tabungan_detail.tanggal desc')->get();
		foreach ($tabungan->result() as $k => $v)
		{
			$tTab[$v->siswa_id][]=$v;
			$tTabSiswa["$v->penyetor_penarik"]=$v;
		}
		$ci->config->set_item('tabungan',$tTab);
		$ci->config->set_item('tabunganSiswa',$tTabSiswa);
		$tabungan->free_result();
	}

	if ( !$ci->config->item('tpenerimaan')) 
	{
		$tpenerimaan=array();
		$jenispenerimaan=array();
		$jenispenerimaanlevel=array();
		$jenisgroup=array();
		$totaljenisgroup=array();
		$pen=$ci->db->from('t_jenis_penerimaan')->where('status_tampil','t')->where('level!=','nolevel')->get();
		foreach ($pen->result() as $k => $v)
		{
			$tpenerimaan[$v->id]=$v;
			$jenispenerimaan[strtolower($v->jenis)]=$v->jenis;
			if(substr($v->level,0,2)=='sd')
				$jenispenerimaanlevel[strtolower(str_replace(' ','_',$v->jenis))][substr($v->level,0,2)]=$v;
			else
				$jenispenerimaanlevel[strtolower(str_replace(' ','_',$v->jenis))][substr($v->level,0,3)]=$v;
			
			$jenisgroup[$v->level][$v->id_parent][]=$v;
			$totaljenisgroup[$v->level][$v->id_parent][]=$v->jumlah;
		}
		$ci->config->set_item('tpenerimaan',$tpenerimaan);
		$ci->config->set_item('jenispenerimaan',$jenispenerimaan);
		$ci->config->set_item('jenispenerimaanlevel',$jenispenerimaanlevel);
		$ci->config->set_item('jenisgroup',$jenisgroup);
		$ci->config->set_item('totaljenisgroup',$totaljenisgroup);
		// echo 'Test';
		$pen->free_result();
	}

	if ( !$ci->config->item('tpendamping')) 
	{
		$tpendamping=array();
		$pend=$ci->db->from('t_data_pendamping')->where('status_tampil','t')->get();
		foreach ($pend->result() as $k => $v)
		{
			$tpendamping[$v->nis]=$v;
			// $jenispenerimaan[$v->jenis]=$v->jenis;
		}
		$ci->config->set_item('tpendamping',$tpendamping);
		$pend->free_result();
	}

	if ( !$ci->config->item('v_pen')) 
	{
		$v_transaksi=$jurnal=$pen=$pen2=$trans_bayar=$trans_bayar2=$trans_bayar_jenis=array();
		$trans=$ci->db->from('v_transaksi_penerimaan')->where('status_tampil','t')->get();
		foreach ($trans->result() as $k => $v)
		{
			$v_transaksi[$v->nis][$v->penerimaan_id][$v->tahun_ajaran][]=$v;
			$trans_bayar[$v->nis][$v->penerimaan_id][$v->tahun_ajaran][$v->bulan_tagihan][$v->tahun_tagihan]=$v;
			$trans_bayar_jenis[$v->nis][strtolower($v->jenis)][$v->tahun_ajaran][$v->bulan_tagihan][$v->tahun_tagihan]=$v;
			$trans_bayar2[$v->nis][$v->penerimaan_id][$v->tahun_ajaran][$v->bulan_tagihan][$v->tahun_tagihan][]=$v;
			$bulan=date("m",strtotime($v->tanggal_transaksi));
			$tahun=date("Y",strtotime($v->tanggal_transaksi));
			$tanggal=date("d",strtotime($v->tanggal_transaksi));
			$jurnal[$tahun][$bulan][$tanggal][]=$v;
			$pen[$v->no_kwitansi][]=$v;
			$pen2[$v->id_trans][]=$v;
			// $jenispenerimaan[$v->jenis]=$v->jenis;
		}
		$ci->config->set_item('trans_bayar_jenis',$trans_bayar_jenis);
		$ci->config->set_item('trans_bayar',$trans_bayar);
		$ci->config->set_item('trans_bayar2',$trans_bayar2);
		$ci->config->set_item('v_transaksi',$v_transaksi);
		$ci->config->set_item('jurnal',$jurnal);
		$ci->config->set_item('v_pen',$pen);
		$ci->config->set_item('v_pen2',$pen2);
		$trans->free_result();
	}

	if ( !$ci->config->item('tagihan')) 
	{
		$ttagihan=$tagihan_jenis=$tagihan_jenis_pen=array();
		// $tagihan=$ci->db->from('v_tagihan_siswa')->order_by('tahun,bulan,id_jenis_penerimaan')->get();
		$tagihan=$ci->db->from('v_tagihan_siswa')->where('sisa_bayar!=',0)->order_by('tahun,bulan,id_jenis_penerimaan')->get();
		$jn=$ci->config->item('tpenerimaan');
		$t_sebelum=array();
		$t_sebelum_idjenis=array();
		$tsbjenis=array();
		$tsb=$ttagihanbybulan=$ttagihanbybulanjenis=$ttagihanbybulanclub=array();
		$piutang_ta=$piutang_all=$tag_jenis=array();
		foreach ($tagihan->result() as $k => $v)
		{
			$ttagihan[$v->nis][$v->tahun_ajaran][$v->id_jenis_penerimaan][]=$v;
			$ttagihanbybulan[$v->nis][$v->tahun_ajaran][$v->tahun][$v->bulan][$v->id_jenis_penerimaan]=$v;
			$ttagihanbybulanclub[$v->nis][$v->tahun_ajaran][$v->tahun][$v->bulan][$v->id_jenis_penerimaan][$v->id_club]=$v;
			$ttagihanbybulanjenis[str_replace('.','_',$v->nis)][$v->tahun_ajaran][$v->tahun][$v->bulan][strtolower(str_replace(' ','_',$v->jenis))]=$v;
			$tagihan_jenis[$v->nis][$v->tahun_ajaran][strtolower(str_replace(' ','_',$v->jenis))][]=$v;
			if($v->sisa_bayar>0)
			{
				$t_sebelum[$v->nis][$v->tahun_ajaran][$v->bulan][$v->jenis]=$v;
				$tsb[$v->nis][$v->tahun_ajaran][$v->bulan][$v->jenis]=$v->sisa_bayar;
				$tsbidjenis[$v->nis][$v->tahun_ajaran][$v->bulan][$v->tahun][$v->id_jenis_penerimaan]=$v->sisa_bayar;
			}
			$tsbjenis[$v->nis][$v->tahun_ajaran][$v->bulan][$v->tahun][strtolower(str_replace(' ','_',$v->jenis))]=$v->sisa_bayar;

			$piutang_ta[$v->tahun_ajaran][str_replace('.','_',$v->nis)][strtolower(str_replace(' ','_',$v->jenis))][]=$v;
			$piutang_all[str_replace('.','_',$v->nis)][strtolower(str_replace(' ','_',$v->jenis))][]=$v;
			$tag_jenis[strtolower(str_replace(' ','_',$v->jenis))]=$v;
			// $tagihan_jenis_pen[$v->id_jenis_penerimaan]=$v;
		}
		$ci->config->set_item('tsb',$tsb);
		$ci->config->set_item('tsbidjenis',$tsbidjenis);
		$ci->config->set_item('tsbjenis',$tsbjenis);
		$ci->config->set_item('ttagihanbybulan',$ttagihanbybulan);
		$ci->config->set_item('ttagihanbybulanclub',$ttagihanbybulanclub);
		$ci->config->set_item('ttagihanbybulanjenis',$ttagihanbybulanjenis);
		$ci->config->set_item('tagihan_sebelum',$t_sebelum);
		$ci->config->set_item('tagihan',$ttagihan);
		$ci->config->set_item('tagihan_jenis',$tagihan_jenis);
		$ci->config->set_item('piutang_ta',$piutang_ta);
		$ci->config->set_item('piutang_all',$piutang_all);
		$ci->config->set_item('tag_jenis',$tag_jenis);
		$tagihan->free_result();
	}

	if ( !$ci->config->item('tpotongan')) 
	{
		$tpotongan=array();
		$tpotongan2=array();
		$potongan=$ci->db->from('t_data_potongan')->where('status_tampil','t')->get();
		foreach ($potongan->result() as $k => $v)
		{
			$tpotongan[$v->tahun_ajaran]["$v->nama_siswa"]["$v->jenis_potongan"]=$v;
			$tpotongan2[$v->tahun_ajaran][$v->nis]["$v->jenis_potongan"]=$v;
			// $jenispenerimaan[$v->jenis]=$v->jenis;
		}
		$ci->config->set_item('tpotongan',$tpotongan);
		$ci->config->set_item('tpotongan2',$tpotongan2);
		$potongan->free_result();
	}

	if ( !$ci->config->item('takun')) 
	{
		$takun=$takun2=array();
		$tak=$ci->db->from('t_akun')->where('status_tampil','t')->order_by('akun_alternatif')->get();
		foreach ($tak->result() as $k => $v)
		{
			$takun[$v->akun_alternatif]=$v;
			$takun2[$v->kode_akun]=$v;
		}
		$ci->config->set_item('takun',$takun);
		$ci->config->set_item('takun2',$takun2);
		$tak->free_result();
	}

	if ( !$ci->config->item('tsaldoakun')) 
	{
		$tsaldoakun=array();
		$t_sl_ak=$ci->db->from('t_saldo_akun')->get();
		foreach ($t_sl_ak->result() as $k => $v)
		{
			$tsaldoakun[$v->kode_akun_alt][$v->tahun][$v->bulan]=$v->jumlah;
		}
		$ci->config->set_item('tsaldoakun',$tsaldoakun);
		$t_sl_ak->free_result();	
	}

	if ( !$ci->config->item('d_bank')) 
	{
		$d_bank=array();
		$t_bank=$ci->db->from('t_bank')->get();
		foreach ($t_bank->result() as $k => $v)
		{
			$d_bank[$v->id_bank]=$v;
		}
		$ci->config->set_item('d_bank',$d_bank);
		$t_bank->free_result();	
	}

	if ( !$ci->config->item('t_neraca_saldo')) 
	{
		$t_neraca_saldo=$t_neraca_saldo2=$t_neraca_saldo3=$t_neraca_saldo4=array();
		$neraca_saldo=$ci->db->from('t_saldo_awal_neraca')->get();
		foreach ($neraca_saldo->result() as $k => $v)
		{
			$t_neraca_saldo[$v->kode_akun_alt][$v->tahun][$v->bulan]=$v->jumlah;
			$t_neraca_saldo2[$v->kode_akun_alt]=$v;
			$t_neraca_saldo4[$v->kode_akun_alt][$v->tahun_ajaran]=$v->jumlah;
			if($v->tahun_ajaran=='')
				$t_neraca_saldo3[$v->kode_akun_alt]=$v;
		}
		$ci->config->set_item('t_neraca_saldo',$t_neraca_saldo);
		$ci->config->set_item('t_neraca_saldo2',$t_neraca_saldo2);
		$ci->config->set_item('t_neraca_saldo3',$t_neraca_saldo3);
		$ci->config->set_item('t_neraca_saldo4',$t_neraca_saldo4);
		$neraca_saldo->free_result();
	}

	$prioritas=array('program pembelajaran','iuran komite','seragam outbound','asuransi','biaya seleksi','investasi');

	$ci->load->model("Mymodel",'mm');
	$ci->mm->getallsiswasd();
	$ci->mm->getallsiswasm();
}
?>
