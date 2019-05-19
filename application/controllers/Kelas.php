<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('Main.php');
class Kelas extends Main {
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('login')!='true')
		{
			redirect('login','location');
		}
	}
	public function index()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Kelas',
			'isi' => 'isi/kelas/index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}

	function leveldata()
	{
		$d=$this->db->from('t_level_kelas')->where('status_tampil','t')->order_by('kategori asc,level asc')->get();
		$data['d']=$d;
		$this->load->view('isi/kelas/level-data',$data);
	}
	function levelform($id=-1)
	{
		if($id!=-1)
		{
			$d=$this->db->from('t_level_kelas')->where('id_level',$id)->get();
			$data['d']=$d;
		}
		$data['id']=$id;
		$this->load->view('isi/kelas/level-form',$data);
	}
	function levelproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			$data=$_POST;
			$data['status_tampil']='t';

			if($id!=-1)
			{
				$this->db->where('id_level',$id);
				$c=$this->db->update('t_level_kelas',$data);

				if($c)
					echo 'Data Level Kelas Berhasil Di Edit';
				else
					echo 'Data Level Kelas Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_level_kelas',$data);

				if($c)
					echo 'Data Level Kelas Berhasil Di Simpan';
				else
					echo 'Data Level Kelas Gagal Di Simpan';
			}
		}
		else
			echo 'Data Level Kelas Gagal Di Simpan';
	}
	function levelhapus($id)
	{
		$this->db->query('update t_level_kelas set status_tampil="f" where id_level="'.$id.'"');
		echo 'Data Level Kelas Berhasil Di Hapus';
	}
////------------------------------------------------

	public function batch()
	{
		// $data['d']=$this->load->view('index.html');
		$ta=$this->config->item('tajaran2');
		$data=array(
			'title' => 'Kelas : Batch',
			'isi' => 'isi/kelas/batch-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer',
			'ta' => $ta
		);
		$this->load->view('index',$data);


	}
	function batchdetail($id=-1)
	{
		if($id!=-1)
		{
			$d=$this->db->from('v_batch_kelas')->where('id_batch',$id)->get();
			$siswa=$this->db->from('v_siswa')->where('status_tampil','t')->order_by('nama_murid')->get();
			$det=$d->result();
			$datasiswa=array();

			foreach ($siswa->result() as $ks => $vs) {
				$datasiswa[$vs->id]=$vs;
			}

			$data=array(
				'title' => 'Kelas : '.$det[0]->nama_batch,
				'isi' => 'isi/kelas/batch-detail',
				'navbar' => 'layout/navbar',
				'footer' => 'layout/footer',
				'id'=>$id,
				'd'=>$det[0],

				'siswa'=>$datasiswa
			);
			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';
			$this->load->view('isi/kelas/batch-detail',$data);
		}
	}
	function batchdatasiswa($id,$menu='',$bulan=null,$tahun=null)
	{
		$data['id']=$id;
		$vbatchkelas=$this->config->item('vbatchkelas');
		$jns_lvl=$this->config->item('jenispenerimaanlevel');
		$batch_kelas=$vbatchkelas[$id];
		// echo '<pre>';
		// print_r($jenispenerimaanlevel['investasi']);
		// echo '</pre>';
		// $data['batch_kelas']=$batch_kelas;
		$inv_data=array();
		if(isset($jns_lvl['investasi']['pg_']))
		{
			$inv_data['pg']=$jns_lvl['investasi']['pg_'];
		}
		if(isset($jns_lvl['investasi']['tk']))
		{
			$inv_data['tk']=$jns_lvl['investasi']['tk'];
		}
		if(isset($jns_lvl['investasi']['sd']))
		{
			$inv_data['sd']=$jns_lvl['investasi']['sd'];
		}
		if(isset($jns_lvl['investasi']['sm']))
		{
			$inv_data['sm']=$jns_lvl['investasi']['sm'];
		}
		$data['inv_data']=$inv_data;

		$bln=$bulan;
		$thn=$tahun;
		if($bulan==null)
			$data['bulan']=$bln=$bulan=date('n');
		else
			$data['bulan']=$bln=$bulan;

		if($tahun==null)
			$data['tahun']=$thn=$tahun=date('Y');
		else
			$data['tahun']=$thn=$tahun;

		// echo $tahun;
		$tpendaftaran=$this->config->item('tpendaftaran');
		$tpotongan=$this->config->item('tpotongan');
		$he=$this->config->item('hari_efektif');
		$helevel=$this->config->item('hari_efektif_level');
		$inv_data=array();
		$hari_efektif_catering=$hari_efektif_jemputan=20;
		if(is_array($he))
		{
			if(isset($he[$bln][$thn]))
			{
				$dhe=$he[$bln][$thn];
				$he_level=$helevel[$bln][$thn];
				$hari_efektif=$dhe->jumlah_hari;
				if($batch_kelas->kategori=='pg')
				{
					if(isset($he_level['PG']))
					{
						$hari_efektif_catering=$he_level['PG']->jumlah_hari_catering;
						$hari_efektif_jemputan=$he_level['PG']->jumlah_hari_jemputan;
					}
				}
				elseif($batch_kelas->kategori=='tk')
				{
					if(strpos(strtolower($batch_kelas->nama_batch),'TKB')!==false)
					{
						if(isset($he_level['TKB']))
						{
							$hari_efektif_catering=$he_level['TKB']->jumlah_hari_catering;
							$hari_efektif_jemputan=$he_level['TKB']->jumlah_hari_jemputan;
						}
					}
					else
					{
						if(isset($he_level['TKA']))
						{
							$hari_efektif_catering=$he_level['TKA']->jumlah_hari_catering;
							$hari_efektif_jemputan=$he_level['TKA']->jumlah_hari_jemputan;
						}
					}
				}
				elseif($batch_kelas->kategori=='sd')
				{
					$l_level=str_replace(' ','_',$batch_kelas->nama_level);
					if(isset($he_level[$l_level]))
					{
						$hari_efektif_catering=$he_level[$l_level]->jumlah_hari_catering;
						$hari_efektif_jemputan=$he_level[$l_level]->jumlah_hari_jemputan;
					}
				}
				elseif($batch_kelas->kategori=='sm')
				{
					if(isset($he_level['Kelas_'.$batch_kelas->level]))
					{
						$hari_efektif_catering=$he_level['Kelas_'.$batch_kelas->level]->jumlah_hari_catering;
						$hari_efektif_jemputan=$he_level['Kelas_'.$batch_kelas->level]->jumlah_hari_jemputan;
				
					}
				}
			}
			else
				$hari_efektif=$hari_efektif_catering=$hari_efektif_jemputan=20;
		}
		else
			$hari_efektif=$hari_efektif_catering=$hari_efektif_jemputan=20;
		// echo $hari_efektif_catering;
		// echo $hari_efektif_jemputan;
		$catering=$this->db->from('t_data_catering_siswa')->where('status_tampil','t')->get()->result();
		$jemputan=$this->db->from('t_data_jemputan')->where('status_tampil','t')->get()->result();
		$club=$this->db->from('t_data_club_siswa')->where('status_tampil','t')->get()->result();
		$tclub=$this->db->from('t_club')->where('status_tampil','t')->get()->result();

		$d_jemp=$d_cat=$d_club=$t_club=[];
		foreach ($tclub as $k => $v)
		{
			$t_club[$v->id_club]=$v;
		}
		foreach ($catering as $k => $v)
		{
			$d_cat[$v->nis]=$v;
		}
		foreach ($jemputan as $k => $v)
		{
			$d_jemp[$v->nis]=$v;
		}
		foreach ($club as $k => $v)
		{
			$d_club[$v->nis][]=$v;
		}
		$data['tpendaftaran']=$tpendaftaran;
		$data['tpotongan']=$tpotongan;
		$data['t_club']=$t_club;
		$data['d_catering']=$d_cat;
		$data['d_jemputan']=$d_jemp;
		$data['d_club']=$d_club;

		$batch=$this->db->from('v_batch_kelas')->where('id_batch',$id)->get()->result();
		$tahun_ajaran=$batch[0]->tahun_ajaran;
		$data['batch']=$batch[0];
		$data['tahun_ajaran']=$tahun_ajaran;
		$d=$this->db->from('v_batch_siswa')->where('active','1')->where('id_batch',$id)->order_by('nama_murid','asc')->get()->result();
		$data['d']=$d;
		$data['menu']=$menu;
		$data['hari_efektif']=$hari_efektif;
		$data['hari_efektif_catering']=$hari_efektif_catering;
		$data['hari_efektif_jemputan']=$hari_efektif_jemputan;

		$thn_inves=trim(strtok($tahun_ajaran,'/'));
		$data['bulan_inves']='7';
		$data['tahun_inves']=$thn_inves;
		if($bln!=null)
		{
			$whinves=array('tahun_ajaran'=>$tahun_ajaran,'tahun'=>$thn_inves,'bulan'=>7);
			$dtinves=$this->db->from('v_tagihan_siswa')->where($whinves)->get()->result();
			// $whinves='bulan=7 and sisa_bayar>0';
			$inves=array();
			foreach ($dtinves as $k => $v)
			{
				if(strpos($v->jenis,'SPP')===false && strpos($v->jenis,'Catering')===false && strpos($v->jenis,'Jemputan')===false)
				{
					$inves[$thn_inves][$v->id_jenis_penerimaan][$v->nis]=$v;
				}
			}
			$data['inves']=$inves;
			
			$whinves2='bulan=7 and sisa_bayar>0 and tahun_ajaran!="'.$tahun_ajaran.'"';
			$dtinves2=$this->db->from('v_tagihan_siswa')->where($whinves2)->get()->result();
			$tahun_ajaran_baru='';
			$inves2=array();
			foreach ($dtinves2 as $k => $v)
			{
				if(strpos($v->jenis,'SPP')===false && strpos($v->jenis,'Catering')===false && strpos($v->jenis,'Jemputan')===false)
				{
					$inves2[$v->nis][]=$v->sisa_bayar;
					$tahun_ajaran_baru=$v->tahun_ajaran;
				}
			}
			$data['inves2']=$inves2;
			$data['tahun_ajaran_baru']=$tahun_ajaran_baru;
		}

		$wh=array('tahun_ajaran'=>$tahun_ajaran,'bulan'=>$bln,'tahun'=>$thn);
		$dt=$this->db->from('v_tagihan_siswa')->where($wh)->get()->result();
		$tagihan=$tagihan2=$tagihannn=array();
		foreach ($dt as $k => $v)
		{
			$tagihan[$v->id_jenis_penerimaan][$v->nis]=$v;
			$tagihannn[strtolower($v->jenis)][$v->nis]=$v;
			$tagihan2[strtolower($v->jenis)][$v->nis][]=$v;
		}
		$data['tagihan']=$tagihan;
		$data['tagihan2']=$tagihan2;
		$data['tagihannn']=$tagihannn;

		$this->load->view('isi/kelas/batch-data-siswa',$data);
	}

	function hapusbatchsiswa($id)
	{
		$d=array('active'=>'0');
		$this->db->where('id',$id);
		$this->db->update('t_batch_siswa',$d);
		echo 'Data Batch Siswa Berhasil Di Hapus';
	}
	function batchform($id=-1)
	{
		if($id!=-1)
		{
			$d=$this->db->from('v_batch_kelas')->where('id_batch',$id)->get();
			$data['d']=$d;
		}
		$data['id']=$id;
		$this->load->view('isi/kelas/batch-form',$data);
	}
	function batchproses($id=-1)
	{
		if(!empty($_POST))
		{
			// print_r($_POST);
			$data=$_POST;
			$data['status_tampil']='t';

			if($id!=-1)
			{
				$this->db->where('id_batch',$id);
				$c=$this->db->update('t_batch_kelas',$data);

				if($c)
					echo 'Data Batch Kelas Berhasil Di Edit';
				else
					echo 'Data Batch Kelas Gagal Di Edit';

			}
			else
			{
				$c=$this->db->insert('t_batch_kelas',$data);

				if($c)
					echo 'Data Batch Kelas Berhasil Di Simpan';
				else
					echo 'Data Batch Kelas Gagal Di Simpan';
			}
		}
		else
			echo 'Data Batch Kelas Gagal Di Simpan';
	}

	function batchdata($status='t')
	{
		$d=$this->db->from('v_batch_kelas')->where('status_tampil',$status)->order_by('tahun_ajaran asc, kategori asc,level asc,nama_batch asc')->get();
		$data['d']=$d;
		$data['status']=$status;
		$this->load->view('isi/kelas/batch-data',$data);
	}
	function batchhapus($id)
	{
		$this->db->query('update t_batch_kelas set status_tampil="i" where id_batch="'.$id.'"');
		echo 'Data Batch Kelas Berhasil Di Hapus';
	}
	function batchubahstatus($id,$status)
	{
		$this->db->query('update t_batch_kelas set status_tampil="'.$status.'" where id_batch="'.$id.'"');
		if($status=='t')
			echo 'Data Batch Kelas Berhasil Di Aktifkan';
		else
			echo 'Data Batch Kelas Berhasil Di Non Aktifkan';
	}

	function simpankebatch($id)
	{
		$siswa=$_POST['idsiswa'];

		$batch=$this->db->from('v_batch_kelas')->where('id_batch',$id)->get();
		// $penerimaan=$this->db->from('t_jenis_penerimaan')->where('status_tampil','t')->like('jenis','investasi')->get();

		// $pen=array();
		// foreach ($penerimaan->result() as $k => $v)
		// {
		// 	$pen[$v->level]=$v;
		// }

		// $kat=$batch->row('kategori');
		// // $sis=explode(',', $siswa);
		// if($kat=='pg')
		// {
		// 	$nominal=$pen['pg']->jumlah;
		// 	$data['wajib_bayar']=$data['sisa_bayar']=$nominal;
		// }
		// else if($kat=='tk')
		// {
		// 	$nominal=$pen['tk']->jumlah;
		// 	$data['wajib_bayar']=$data['sisa_bayar']=$nominal;
		// }
		// else if($kat=='sd')
		// {
		// 	$nominal=$pen['sd-baru']->jumlah;
		// 	$data['wajib_bayar']=$data['sisa_bayar']=$nominal;
		// }
		// else if($kat=='sm')
		// {
		// 	$nominal=$pen['sm']->jumlah;
		// 	$data['wajib_bayar']=$data['sisa_bayar']=$nominal;
		// }

		list($tahunaw,$tahunak)=explode('/', $batch->row('tahun_ajaran'));
		$tahun=trim($tahunaw);

		$data['tahun']=$tahun;
		$data['bulan']=7;
		$data['batch_id']=$d['id_batch']=$id;
		$d['active']='1';
		// print_r($siswa);
		$in=0;
		if(count($siswa)==1)
		{
			list($ids,$nis,$namasiswa)=explode('__', $siswa[0]);
			$d['id_siswa']=$siswa[0];
			// $sis=$this->db->from('v_siswa')->where('id',$ids)->get();
			$cek=$this->db->from('t_batch_siswa')->where('id_siswa',$siswa[0])->where('id_batch',0)->get()->result();
			if(count($cek)!=0)
			{
				$this->db->where('id',$cek[0]->id);
				$in=$this->db->update('t_batch_siswa',$d);
				if(!$in)
				{
					$data['nis']=$nis;
					$in=0;	
				}
			}
			else
			{

				$in=$this->db->insert('t_batch_siswa',$d);
				if(!$in)
				{
					$data['nis']=$nis;
					$in=0;	
				}
			}
		}
		else
		{
			foreach ($siswa as $k => $v)
			{
				list($ids,$nis,$namasiswa)=explode('__', $v);
				$d['id_siswa']=$v;
				// $sis=$this->db->from('v_siswa')->where('id',$ids)->get();

				$cek=$this->db->from('t_batch_siswa')->where('id_siswa',$v)->where('id_batch',0)->get()->result();
				if(count($cek)!=0)
				{
					$this->db->where('id',$cek[0]->id);
					$in=$this->db->update('t_batch_siswa',$d);
					if(!$in)
					{
						$data['nis']=$nis;
						$in=0;	
					}
				}
				else
				{

					$in=$this->db->insert('t_batch_siswa',$d);
					if(!$in)
					{
						$data['nis']=$nis;
						$in=0;
					}
				}
			}
		}

		if($in==0)
		{
			$this->db->where_in('id_siswa',$siswa);
			$this->db->where('id_batch',$id);
			$this->db->delete('t_batch_siswa');
			echo 'Data Siswa Gagal Ditambahkan Ke dalam Kelas';
		}
		else
			echo 'Data Siswa Berhasil Ditambahkan Ke dalam Kelas';
	}


	function getkelasbynis($nis,$tr=-1,$idrow=-1)
	{
		list($idsiswa,$nis)=explode('__', $nis);
		$wh=array('nis'=>$nis,'active'=>1);
		$kelas=$this->db->from('v_batch_siswa')->where($wh)->get()->result();
		$batch=$this->db->from('v_batch_kelas')->where('status_tampil','t')->get()->result();
		foreach ($batch as $kb => $vb)
		{
			$d_batch[$vb->id_batch]=$vb;
		}

		if(count($kelas)!=0)
		{
			$ti='-Pilih-';
			// $fn='';
		}
		else
		{
			$ti='-Pilih Tahun Ajaran-';
		}
		$fn='onchange="lihatdata(this.value,'.$tr.','.$idrow.',\''.($idsiswa.'__'.$nis).'\')"';

		if($tr==0)
		{

			$select= '<select name="dkelas[]" '.$fn.' id="dkelas" class="col-xs-12 col-sm-12 chosen-select" data-rel="chosen">
							<option value="">'.$ti.'</option>';
		}
		else
		{
			$select= '<select name="dkelas" id="dkelas" '.$fn.' class="col-xs-12 col-sm-12 chosen-select" data-rel="chosen">
							<option value="">'.$ti.'</option>';

		}

		if(count($kelas)!=0)
		{

			$dthn=array();
			foreach ($kelas as $k => $v)
			{
				if(isset($d_batch[$v->id_batch]))
					$kat=$d_batch[$v->id_batch]->kategori;
				else
					$kat='';

				if($tr!=-1)
				{
					if($v->st_tbk=='t')
					{
						$dthn[1]=$v->tahun_ajaran;
					}
					else
					{
						$dthn[0]=-1;
					}	
					// $select.= '<option selected="selected" value="'.$v->id_tbs.'__'.$v->id_batch.'__'.str_replace(' ','%20',$v->nama_batch).'__'.$kat.'">['.strtoupper($kat).'] '.$v->nama_batch.'</option>';
						// $select.= '<option value="'.$v->id_tbs.'__'.$v->id_batch.'__'.str_replace(' ','%20',$v->nama_batch).'__'.$kat.'">['.strtoupper($kat).'] '.$v->nama_batch.'</option>';
				}
				else
				{
					$dthn[0]=-1;
				}
				// $select.= '<option value="'.$v->id_tbs.'__'.$v->id_batch.'__'.str_replace(' ','%20',$v->nama_batch).'__'.$kat.'">['.strtoupper($kat).'] '.$v->nama_batch.'</option>';
			}
			// echo '<pre>';
			// print_r($dthn);
			// echo '</pre>';
			$ajaran=$this->config->item('tajaran');
			if(count($ajaran)!=0)
			{
				foreach ($ajaran as $k => $v)
				{
					if(isset($dthn[1]))
					{
						if($v->tahun_ajaran==$dthn[1])
							$select.= '<option selected="selected" value="'.$v->id_ajaran.'__'.$v->tahun_ajaran.'">'.$v->tahun_ajaran.'</option>';
						else
							$select.= '<option value="'.$v->id_ajaran.'__'.$v->tahun_ajaran.'">'.$v->tahun_ajaran.'</option>';
					}
					else
						$select.= '<option value="'.$v->id_ajaran.'__'.$v->tahun_ajaran.'">'.$v->tahun_ajaran.'</option>';
				}
			}
		}
		else
		{
			$ajaran=$this->config->item('tajaran');
			if(count($ajaran)!=0)
			{
				foreach ($ajaran as $k => $v)
				{
					$select.= '<option value="'.$v->id_ajaran.'__'.$v->tahun_ajaran.'">'.$v->tahun_ajaran.'</option>';
				}
			}
		}
		$select.='</select>';
		if($tr!=0)
		{
			echo '<div class="form-group">
					<label class="col-sm-'.($tr==-1 ? '12' : '3').' control-label no-padding-right" for="form-field-1" style="text-align:'.($tr==-1 ? 'left' : 'right').'"> Tahun Ajaran </label>
						<div class="col-sm-'.($tr==-1 ? '12' : '3').'">';
		}
		echo $select;

		if($tr!=0)
		{
			echo '</div>
					</div>';
		}
		echo '<style>#dkelas_chosen
			{
				width:100% !important;
			}</style>';
	}

	function downloadsiswa($idkelas,$tahun,$bulan)
	{
		$jenis=['spp','catering','jemputan','jemputan_club','club','investasi'];
		$vbatch_siswa=$this->config->item('vbatchsiswabykelas');
		$vbatchkelas=$this->config->item('vbatchkelas');
		$ttagihanbybulan=$this->config->item('ttagihanbybulanjenis');
		$batchk=$vbatchkelas[$idkelas];


		$whinves2='bulan=7 and sisa_bayar>0 and tahun_ajaran!="'.$batchk->tahun_ajaran.'"';
		$dtinves2=$this->db->from('v_tagihan_siswa')->where($whinves2)->get()->result();
		$tahun_ajaran_baru='';
		$inves2=array();
		foreach ($dtinves2 as $k => $v)
		{
			$inves2[$v->nis][]=$v->sisa_bayar;
			$tahun_ajaran_baru=$v->tahun_ajaran;
		}
		$data['inves2']=$inves2;
		$data['tahun_ajaran_baru']=$tahun_ajaran_baru;
		$data['data']=$vbatch_siswa[$idkelas];
		$data['jenis']=$jenis;
		$data['batch']=$batchk;
		$data['bulan']=$bulan;
		$data['tahun']=$tahun;
		$data['tagihan']=$ttagihanbybulan;
		$this->load->view('isi/kelas/data-siswa-excel',$data);
	}
	function tagihaninvesdetail($nis,$tahunajaran)
	{
		$data['nis_o']=$nis;
		$data['tahunajaran_o']=$tahunajaran;
		$tahunajaran=str_replace('_','/',$tahunajaran);
		$tahunajaran=str_replace('%20',' ',$tahunajaran);
		$tahun=trim(strtok($tahunajaran,'/'));
		$data['nis']=$nis=str_replace('.','_',$nis);
		$data['tahunajaran']=$tahunajaran;
		$tag=$this->config->item('ttagihanbybulanjenis');
		if(isset($tag[$nis][$tahunajaran][$tahun][7]))
			$data['tagihan']=$tag[$nis][$tahunajaran][$tahun][7];
		else
			$data['tagihan']=array();
		
		$this->load->view('isi/kelas/detail-tagihan-inves',$data);
	}
	function edittagihaninves($idtagihan)
	{
		$nominal=str_replace(array(',','.'),'',$_POST['nilai']);
		$this->db->set('sisa_bayar',$nominal);
		$this->db->where('id_tagihan',$idtagihan);
		$this->db->update('t_tagihan_siswa');
	}
	function hapustagihaninves($idtagihan)
	{
		$this->db->where('id_tagihan',$idtagihan);
		$this->db->delete('t_tagihan_siswa');
	}

	function aktifkantagihan($idbatch,$bulan,$tahun)
	{
		$wh['bulan']=$bulan;
		$wh['tahun']=$tahun;
		$wh['batch_id']=$idbatch;

		$ta=gettahunajaranbybulan($bulan,$tahun);
		$get=$this->db->from('t_tagihan_siswa')->where('bulan',7)->where('tahun_ajaran',$ta)->get();
		foreach($get->result() as $k=>$v)
		{
			if($v->status_tagihan==0)
			{
				$this->db->query('update t_tagihan_siswa set status_tagihan=1 where id_tagihan="'.$v->id_tagihan.'"');
			}
		}
		$get->free_result();
		$this->db->set('status_tagihan',1);
		$this->db->where($wh);
		$this->db->update('t_tagihan_siswa');
	}

	public function atur()
	{
		// $data['d']=$this->load->view('index.html');
		$data=array(
			'title' => 'Atur Kelas',
			'isi' => 'isi/kelas/atur-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}

	public function aturulang($ta)
	{
		$ta=str_replace('%20',' ',$ta);
		$ta=str_replace('_','/',$ta);

		$batch_siswa=$this->config->item('vbatchsiswabykelas');
		$kls=$this->db->from('v_batch_siswa')->where('tahun_ajaran',$ta)->where('st_tbk','t')->get()->result();
		$sis=array();
		foreach($kls as $kk=>$vk)
		{
			$idbatch=$vk->id_batch;
			foreach($batch_siswa[$idbatch] as $ks =>$vs)
			{
				$sis[]=array(
						'id'=>$vs->id_tbs,
						'id_batch'=>0
				);
			}
		}
		$this->db->update_batch('t_batch_siswa',$sis, 'id'); 
		echo 'Reset Data Kelas Berhasil, Silahkan Atur Kembali Data Siswa Kelas';
		// echo '<pre>';
		// print_r($sis);
		// echo '</pre>';
	}

	function hapusbatchsemua()
	{
		// $idbatch=$_POST['id_batch'];
		// echo $_POST['id_batch'];
		$i=explode(',',$_POST['id_batch']);
		foreach($i as $k=>$v)
		{
			if($v!='')
			{
				$this->db->set('status_tampil','f');
				$this->db->where('id_batch',$v);
				$this->db->update('t_batch_kelas');
			}
		}
		echo 1;
	}
}
