<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('Main.php');
class Laporan extends Main {

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
			'title' => 'Laporan',
			'isi' => 'isi/laporan/index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}

	function tagihan()
	{
		$levelkelas=$this->db->from('t_level_kelas')->where('status_tampil','t')->order_by('nama_level')->get()->result();
		$batch=$this->db->from('t_batch_kelas')->where('status_tampil','t')->get()->result();

		$bt=array();
		foreach ($batch as $kb => $vb)
		{
			$bt[$vb->id_level][]=$vb;
		}
		$data=array(
			'title' => 'Laporan',
			'isi' => 'isi/laporan/tagihan-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer',
			'lk' => $levelkelas,
			'bt' => $bt
		);
		$this->load->view('index',$data);
	}

	function datatagihan($id,$bulan=null,$tahun=null)
	{
		$data['id']=$id;
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

		$he=$this->config->item('hari_efektif');
		if(is_array($he))
		{
			if(isset($he[$bln][$thn]))
			{
				$dhe=$he[$bln][$thn];
				$hari_efektif=$dhe->jumlah_hari;
			}
			else
				$hari_efektif=20;
		}
		else
			$hari_efektif=$he;

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
			$d_club[$v->nis]=$v;
		}
		$data['t_club']=$t_club;
		$data['d_catering']=$d_cat;
		$data['d_jemputan']=$d_jemp;
		$data['d_club']=$d_club;

		$batch=$this->db->from('v_batch_kelas')->where('id_batch',$id)->get()->result();
		// echo $batch[0]->tahun_ajaran;
		if(count($batch)!=0)
		{

			$data['batch']=$db=$batch[0];
			$d=$this->db->from('v_batch_siswa')->where('active','1')->where('id_batch',$id)->order_by('nama_murid','asc')->get()->result();
			$data['d']=$d;
			//$data['menu']=$menu;
			$data['hari_efektif']=$hari_efektif;

			if($bln!=null)
			{
				$whinves=array('batch_id'=>$id,'tahun'=>$thn,'bulan'=>7);
				$dtinves=$this->db->from('t_tagihan_siswa')->where($whinves)->get()->result();
				$inves=array();
					foreach ($dtinves as $k => $v)
					{
						$inves[$thn][$v->id_jenis_penerimaan][$v->nis]=$v;
					}
					$data['inves']=$inves;
			}

			// $wh='(batch_id="'.$id.'" OR tahun_ajaran="'.$db->tahun_ajaran.'") AND bulan="'.$bln.'" AND tahun="'.$thn.'"';
			$wh='(batch_id="'.$id.'" OR tahun_ajaran="'.$db->tahun_ajaran.'")';
			$dt=$this->db->from('v_tagihan_siswa')->where($wh)->get()->result();
			$tagihan=array();
			foreach ($dt as $k => $v)
			{
				// $jenis_p=strtok($v->jenis, ' ');
				// // if($jenis_p)
				// if(strpos($jenis_p, 'Investasi')!==false)
				// 	$jenis_p='Investasi';
				// else
				// 	$jenis_p=$v->jenis;
				// if($bln==7 && $jenis_p=='SPP')
				// 	continue;

				$tagihan[strtolower($v->jenis)][$v->nis][]=$v;
			}
			$data['tagihan']=$tagihan;

			$whh='(batch_id="'.$id.'" OR tahun_ajaran="'.$db->tahun_ajaran.'") AND bulan_tagihan="'.$bln.'" AND tahun_tagihan="'.$thn.'"';
			$transaksi=$this->db->from('v_transaksi_penerimaan')->where($whh)->get()->result();
			$trans=array();
			$transinves=array();
			foreach ($transaksi as $ktr => $vtr)
			{
				$nis=$vtr->nis;
				// list($nis,$nama)=explode('__', $vtr->nis);
				// list($id_jenis,$jenis)=explode('__', $vtr->penerimaan_id);
				$id_jenis=$vtr->penerimaan_id;
				//if(strpos(strtolower($vtr->penerimaan_id),'investasi')!==false)
				//{
				$transinves[$vtr->jenis][$nis][$vtr->tahun_tagihan][$vtr->bulan_tagihan][]=$vtr;
				//}
				if($vtr->club != '')
				{
					list($id_club,$n_club)=explode('__', $vtr->club);
					$trans[$vtr->jenis][$nis][$vtr->tahun_tagihan][$vtr->bulan_tagihan][$id_club]=$vtr;
				}
				else
					$trans[$vtr->jenis][$nis][$vtr->tahun_tagihan][$vtr->bulan_tagihan][]=$vtr;
			}
			$data['trans']=$trans;
			$data['transinves']=$transinves;
			$this->load->view('isi/laporan/tagihan-data',$data);
		}
	}
//=========================================================================

	function tagihanpersiswa()
	{
		$siswa=$this->db->from('t_siswa')->where('status_tampil','t')->get()->result();

		$data=array(
			'title' => 'Laporan',
			'isi' => 'isi/laporan/persiswa-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer',
			'siswa' => $siswa,
		);
		$this->load->view('index',$data);
	}

	function datapersiswa($param)
	{
		//$param=str_replace('%22', '', $param);
		$param=str_replace('%20', ' ', $param);
		$param=str_replace('___', '/', $param);
		//echo $param;
		$data['param']=$param;
		$tahun_ajaran='';
		// echo $param;
		list($p1,$p2,$p3,$p4)=explode('..', $param);
		list($idsiswa,$nis)=explode('__', $p4);

		if(strpos($p1, '/')!==false)
		{
			list($idta,$tahun_ajaran)=explode('__', $p1);

			$pn=$this->config->item('tpendaftaran3');
			if(isset($pn[$tahun_ajaran][$nis]))
			{
				$daftar=$pn[$tahun_ajaran][$nis];
				$kelas=$daftar->kelas;
			}
			else
				$kelas='-';

			$data['kelas']=$kelas;
		}
		else
		{
			list($idtbs,$idbatch,$nama_batch,$kategori)=explode('__', $p1);
			$b=$this->config->item('vbatchkelas');

			if(isset($b[$idbatch]))
			{
				$batch=$b[$idbatch];
				$tahun_ajaran=$batch->tahun_ajaran;
				$kelas=$batch->nama_level.' - '.$batch->nama_batch;
			}
			else
			{
				$tahun_ajaran='';
				$kelas='-';
			}

			$data['kelas']=$kelas;
		}


		$s=$this->config->item('tsiswa');
		$l=$this->config->item('levelkelas');
		$j=$this->config->item('tagihan_jenis');
		$trans=$this->config->item('trans_bayar2');
		// echo '<pre>';
		// print_r($j);
		// echo '</pre>';
		$siswa=$s[$idsiswa];
		if(isset($j[$nis][$tahun_ajaran]))
		{

			$jns=$j[$nis][$tahun_ajaran];
			// $level=$l[$siswa->id_level];

			$data['jenis_p']=$jns;
		// $data['nama_level']=$level->nama_level;
		// $data['kelas']=$siswa->nama_batch;
		}
		else
		{
			$data['jenis_p']=array();
		}
		// $data['nis']=$batc;
		$data['nama']=$siswa->nama_murid;
		$data['tahun_ajaran']=$tahun_ajaran;
		if(isset($trans[$nis]))
			$data['trans']=$trans[$nis];
		else
			$data['trans']=array();
		$this->load->view('isi/laporan/persiswa-data',$data);
	}
//==========================================================================
	function aruskas()
	{		
		$data=array(
			'title' => 'Laporan Arus Kas',
			'isi' => 'isi/laporan/aruskas-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
	function aruskasdata($date=-1,$j_lap=-1)
	{
		if($j_lap==-1)
		{
			$j_lap='sekolah';
		}
		else
			$j_lap=$j_lap;
		// echo $j_lap;
		$ajaran=$this->config->item('tajaran');
		$tsaldoakun=$this->config->item('tsaldoakun');
		$date=str_replace('%20',' ',$date);
		$wh='akun_alternatif!=""';
		$kd=$this->db->from('t_akun')->where($wh)->order_by('akun_alternatif')->get()->result();
		$kodeakun=array();
		// $akun=$this->config->item('takun');
		// $jn_kd_akun=array();
		// foreach($akun as $ka => $va)
		// {
		// 	if($va->akun_alternatif!='')
		// 	{
		// 		$jn_kd_akun[$va->kat][$va->akun_alternatif]=$va;
		// 	}
		// }
		$kat=($j_lap==-1 ? 'all' : ($j_lap=='non' ? 'non-sekolah' : 'sekolah'));
		foreach($kd as $k => $v)
		{
			if($v->akun_alternatif!='')
			{
				$kode_akun[$v->akun_alternatif]=$v;
			}
			if($j_lap==-1)
				$kt='all';
			else
				$kt=$v->kat;

			$kodeakun[$kt][$v->jenis][$v->akun_alternatif]=$v;
		}
		
		if($date==-1)
		{
			if(date('n')>=7 && date('n')<=12)
				$tahunajaran=date('Y').' / '.(date('Y') +1);
			else
				$tahunajaran=(date('Y') -1) .' / '.date('Y');
		}
		else
		{
			$tahunajaran=$ajaran[$date]->tahun_ajaran;
		}
		list($th1,$th2)=explode('/',str_replace(' / ','/',$tahunajaran));

		$semester=array(
				'Semester 1' => array(7,8,9,10,11,12),
				'Semester 2' => array(1,2,3,4,5,6)
		);
		$wh='status_tampil="t"';
		$whpen=$wh.' and (YEAR(`tanggal_transaksi`)='.$th1.' AND MONTH(`tanggal_transaksi`) BETWEEN 7 AND 12) OR 
  							(YEAR(`tanggal_transaksi`)='.$th2.' AND MONTH(`tanggal_transaksi`) BETWEEN 1 AND 6)';
		$t_pen=$this->db->select('*,"terima" as status')->from('v_trans_detail_jenis')->where($whpen)->order_by('tanggal_transaksi asc')->get()->result();

		$whpeng=$wh.' and (YEAR(`tanggal_transaksi`)='.$th1.' AND MONTH(`tanggal_transaksi`) BETWEEN 7 AND 12) OR 
  							(YEAR(`tanggal_transaksi`)='.$th2.' AND MONTH(`tanggal_transaksi`) BETWEEN 1 AND 6)';
		$t_peng=$this->db->select('*,"keluar" as status, "-1" as nis, "-1" as id_jns')->from('v_transaksi_pengeluaran_detail')->where($whpeng)->order_by('tanggal_transaksi asc')->get()->result();


		$trans=$total=array();
		foreach($t_pen as $k => $v)
		{
			if(is_null($v->kodeakun))
			{
				list($idakun,$kdakun,$ak_alt,$nmakun)=explode('_',$v->keterangan);
			}
			else
			{
				$kdd=explode('-',$v->kodeakun);
				$ak_alt=$kdd[0];
				if(isset($kdd[1]))
					$kdakun=$kdd[1];
				else
					$kdakun='';
			}
			$tahun=date('Y',strtotime($v->tanggal_transaksi));
			$bulan=date('n',strtotime($v->tanggal_transaksi));
			$trans[$tahun][$bulan][$ak_alt][]=$v->jumlah;
			if(isset($kode_akun[$ak_alt]))
			{
				
				if($kode_akun[$ak_alt]->akun_alt_parent!='0')
				{
					$total[$tahun][$bulan][$kode_akun[$ak_alt]->akun_alt_parent][]=$v->jumlah;
				}
				else
				{
					$total[$tahun][$bulan][$ak_alt][]=$v->jumlah;
				}
			}
			else
			{
				$total[$tahun][$bulan][$ak_alt][]=0;
			}
		}
		foreach($t_peng as $k => $v)
		{
			$kd=strtok($v->keterangan,'-');
			$tahun=date('Y',strtotime($v->tanggal_transaksi));
			$bulan=date('n',strtotime($v->tanggal_transaksi));
			$trans[$tahun][$bulan][$kd][]=$v->jumlah;

			if(isset($kode_akun[$kd]))
			{
				if($kode_akun[$kd]->akun_alt_parent!='0')
				{
					$total[$tahun][$bulan][$kode_akun[$kd]->akun_alt_parent][]=$v->jumlah;
				}
				else
				{
					$total[$tahun][$bulan][$kd][]=$v->jumlah;
				}
			}
			else
			{
				$total[$tahun][$bulan][$kd][]=0;
			}
		}
		
		// echo '<pre>';
		// print_r($total[2018][1]);
		// echo '</pre>';
		
		//ksort($trans);
		$data=array(
			'semester' => $semester,
			'tahun' => $tahunajaran,
			'trans' => $trans,
			'date' => $date,
			'j_lap' => $j_lap,
			'kat' => $kat,
			'total' => $total,
			'kodeakun'=>$kodeakun
		);
		$this->load->view('isi/laporan/aruskas-data',$data);
	}
	function aruskasexcel($date=-1,$j_lap=-1)
	{
		$ajaran=$this->config->item('tajaran');
		$date=str_replace('%20',' ',$date);
		$wh='akun_alternatif!=""';
		$kd=$this->db->from('t_akun')->where($wh)->order_by('akun_alternatif')->get()->result();
		$kodeakun=array();
		// $akun=$this->config->item('takun');
		// $jn_kd_akun=array();
		// foreach($akun as $ka => $va)
		// {
		// 	if($va->akun_alternatif!='')
		// 	{
		// 		$jn_kd_akun[$va->kat][$va->akun_alternatif]=$va;
		// 	}
		// }
		$kat=($j_lap==-1 ? 'all' : ($j_lap=='non' ? 'non-sekolah' : 'sekolah'));
		foreach($kd as $k => $v)
		{
			if($j_lap==-1)
				$kt='all';
			else
				$kt=$v->kat;

			$kodeakun[$kt][$v->jenis][$v->akun_alternatif]=$v;
		}
		if($date==-1)
		{
			if(date('n')>=7 && date('n')<=12)
				$tahunajaran=date('Y').' / '.(date('Y') +1);
			else
				$tahunajaran=(date('Y') -1) .' / '.date('Y');
		}
		else
		{
			$tahunajaran=$ajaran[$date]->tahun_ajaran;
		}
		$semester=array(
				'Semester 1' => array(7,8,9,10,11,12),
				'Semester 2' => array(1,2,3,4,5,6)
		);
		$wh='status_tampil="t"';
		$t_pen=$this->db->select('*,"terima" as status')->from('v_trans_detail_jenis')->where($wh)->order_by('tanggal_transaksi asc')->get()->result();
		$t_peng=$this->db->select('*,"keluar" as status, "-1" as nis, "-1" as id_jns')->from('v_transaksi_pengeluaran_detail')->where($wh)->order_by('tanggal_transaksi asc')->get()->result();


		$trans=array();
		foreach($t_pen as $k => $v)
		{
			if(is_null($v->kodeakun))
			{
				list($idakun,$kdakun,$ak_alt,$nmakun)=explode('_',$v->keterangan);
			}
			else
			{
				$kdd=explode('-',$v->kodeakun);
				// echo '<pre>';
				// print_r($kdd);
				// echo '</pre>';
				$ak_alt=$kdd[0];
				$kdakun=$kdd[1];
			}
			$tahun=date('Y',strtotime($v->tanggal_transaksi));
			$bulan=date('n',strtotime($v->tanggal_transaksi));
			$trans[$tahun][$bulan][$ak_alt][]=$v->jumlah;
		}
		foreach($t_peng as $k => $v)
		{
			$kd=strtok($v->keterangan,'-');
			$tahun=date('Y',strtotime($v->tanggal_transaksi));
			$bulan=date('n',strtotime($v->tanggal_transaksi));
			$trans[$tahun][$bulan][$kd][]=$v->jumlah;
		}
		
		
		//ksort($trans);
		$data=array(
			'semester' => $semester,
			'tahun' => $tahunajaran,
			'trans' => $trans,
			'date' => $date,
			'j_lap' => $j_lap,
			'kat' => $kat,
			'kodeakun'=>$kodeakun
		);
		$this->load->view('isi/laporan/aruskas-excel',$data);
	}
//==========================================================================
	function bukubesar($date=null,$ak_alt=null)
	{
		$lv=array('Bulanan','Tahunan');
		// $wh='akun_alternatif!=""';
		$wh='status_tampil="t"';
		$kodeakun=$this->db->from('t_akun')->where($wh)->order_by('kode_akun')->get()->result();
		if($date==null)
			$date='';
		else
			$date=$date;
		
		if($ak_alt==null)
			$ak_alt='';
		else
			$ak_alt=$ak_alt;

		$data=array(
			'title' => 'Laporan',
			'isi' => 'isi/laporan/bukubesar-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer',
			'lk'=>$lv,
			'date'=>$date,
			'ak_alt'=>$ak_alt,
			'kodeakun'=>$kodeakun
		);
		$this->load->view('index',$data);
	}

	function bukubesardata2($jenis=null,$date=null,$val=-1)
	{
		$data['jenis']=$jenis;		
		if($jenis=='Bulanan')
		{
			$d=explode('-', $date);
			$data['bulan']=$d[1];
			$data['tahun']=$d[0];
			$wh=$whp='year(tanggal_transaksi)="'.$d[0].'" and month(tanggal_transaksi)="'.$d[1].'" and status_tampil="t"';
			$date=date('Y-n',strtotime($date));
		}
		else if($jenis=='Tahunan')
		{
			$d=explode('-', $date);
			$date=date('Y',strtotime($date));
			$data['tahun']=$date;
			$data['bulan']='';
			$wh=$whp='year(tanggal_transaksi)="'.$date.'" and status_tampil="t"';
		}
		else if($jenis=='Harian')
		{
			$d=explode('-', $date);
			$data['bulan']=$d[1];
			$data['tahun']=$d[2];
			$data['tanggal']=$d[0];
			$wh=$whp='year(tanggal_transaksi)="'.$d[2].'" and month(tanggal_transaksi)="'.$d[1].'" and day(tanggal_transaksi)="'.$d[0].'" and status_tampil="t"';
			$date=$date;
		}
		$data['date']=$date;
		$wh.=' and (keterangan like "%'.$val.'\_%" or kodeakun like "%'.$val.'-%" or penerimaan_id="'.$val.'")';
		$t_pen=$this->db->select('*,"terima" as status')->from('v_trans_detail_jenis')->where($wh)->order_by('tanggal_transaksi asc')->get()->result();
		$trans=array();
		foreach($t_pen as $k => $v)
		{
			$date=strtok($v->tanggal_transaksi,' ');
			$trans[$date][$v->id]=$v;
		}
		$whp=$whp.' and (keterangan like "%'.$val.'\_%" or keterangan like "%'.$val.'-%")';
		$t_peng=$this->db->select('*,"keluar" as status, "-1" as nis, "-1" as id_jns')->from('v_transaksi_pengeluaran_detail')->where($whp)->order_by('tanggal_transaksi asc')->get()->result();
		foreach($t_peng as $k => $v)
		{
			$kd=strtok($v->keterangan,'-');
			$date=strtok($v->tanggal_transaksi,' ');
			$trans[$date][$kd.'_'.$v->id]=$v;
		}
		$sis=$this->config->item('nissiswa2');
		$tpenerimaan=$this->config->item('tpenerimaan');
		$takun=$this->config->item('takun');
		ksort($trans);
		$data['trans']=$trans;
		$data['sis']=$sis;
		$data['val']=$val;
		$data['tpenerimaan']=$tpenerimaan;
		$data['takun']=$takun;
		$this->load->view('isi/laporan/bukubesar-data',$data);
	}
	function bukubesardata($jenis=null,$date=null,$val=-1)
	{
		$data['jenis']=$jenis;		
		if($jenis=='Bulanan')
		{
			$d=explode('-', $date);
			$data['bulan']=$d[1];
			$data['tahun']=$d[0];
			$wh=$whp='year(tanggal)="'.$d[0].'" and month(tanggal)="'.$d[1].'"';
			$date=date('Y-n',strtotime($date));
		}
		else if($jenis=='Tahunan')
		{
			$d=explode('-', $date);
			$date=date('Y',strtotime($date));
			$data['tahun']=$date;
			$data['bulan']='';
			$wh=$whp='year(tanggal)="'.$date.'"';
		}
		else if($jenis=='Harian')
		{
			$d=explode('-', $date);
			$data['bulan']=$d[1];
			$data['tahun']=$d[2];
			$data['tanggal']=$d[0];
			$wh=$whp='year(tanggal)="'.$d[2].'" and month(tanggal)="'.$d[1].'" and day(tanggal)="'.$d[0].'"';
			$date=$date;
		}
		$data['date']=$date;
		$trans=$jur=$trn=$trn2=array();
		$tr=$this->db->from('t_jurnal')->where($wh)->get()->result();
		foreach($tr as $k => $v)
		{
			$trn[$v->kode_akun][]=$v;
			$trn2[$v->ref][]=$v;
		}
		if(isset($trn[$val]))
		{
			foreach($trn[$val] as $kt=>$vt)
			{
				// foreach($trn2[$vt->ref] as $kr => $vr)
				// {
				// 	if($vr->kode_akun==$val)
				// 	{
						// $jur[$vt->ref][]=$vr;	
					$trans[]=$vt;	
				// 	}
				// }
			}
		}
		// foreach($jur as $kj => $vj)
		// {
		// 	if(count($vj)>1)
		// 	{

		// 	}
		// 	else
		// 	{
		// 		$trans[]=$vj;
		// 	}
		// }
		// echo '<pre>';
		// print_r($trans);
		// echo '</pre>';
		$sis=$this->config->item('nissiswa2');
		$tpenerimaan=$this->config->item('tpenerimaan');
		$takun=$this->config->item('takun2');
		//ksort($trans);
		$data['trans']=$trans;
		$data['trn']=$trn;
		$data['sis']=$sis;
		$data['val']=$val;
		$data['tpenerimaan']=$tpenerimaan;
		$data['takun']=$takun;
		$this->load->view('isi/laporan/bukubesar-data-2',$data);
	}
	function bukubesarexcel($jenis=null,$date=null,$val=-1)
	{
		$data['jenis']=$jenis;
		
		if($jenis=='Bulanan')
		{
			$d=explode('-', $date);
			$data['bulan']=$d[1];
			$data['tahun']=$d[0];
			$wh=$whp='year(tanggal_transaksi)="'.$d[0].'" and month(tanggal_transaksi)="'.$d[1].'" and status_tampil="t"';
			$date=date('Y-n',strtotime($date));
		}
		else if($jenis=='Tahunan')
		{
			$d=explode('-', $date);
			$date=date('Y',strtotime($date));
			$data['tahun']=$date;
			$data['bulan']='';
			$wh=$whp='year(tanggal_transaksi)="'.$date.'" and status_tampil="t"';
		}
		else if($jenis=='Harian')
		{
			$d=explode('-', $date);
			$data['bulan']=$d[1];
			$data['tahun']=$d[2];
			$data['tanggal']=$d[0];
			$wh=$whp='year(tanggal_transaksi)="'.$d[2].'" and month(tanggal_transaksi)="'.$d[1].'" and day(tanggal_transaksi)="'.$d[0].'" and status_tampil="t"';
			$date=$date;
		}
		$data['date']=$date;
		$wh.=' and (keterangan like "%'.$val.'%" or kodeakun like "%'.$val.'%")';
		$t_pen=$this->db->select('*,"terima" as status')->from('v_trans_detail_jenis')->where($wh)->order_by('tanggal_transaksi asc')->get()->result();
		$trans=array();
		foreach($t_pen as $k => $v)
		{
			$date=strtok($v->tanggal_transaksi,' ');
			$trans[$date][$v->id]=$v;
		}
		$whp=$whp.' and keterangan like "%'.$val.'%"';
		$t_peng=$this->db->select('*,"keluar" as status, "-1" as nis, "-1" as id_jns')->from('v_transaksi_pengeluaran_detail')->where($whp)->order_by('tanggal_transaksi asc')->get()->result();
		foreach($t_peng as $k => $v)
		{
			$kd=strtok($v->keterangan,'-');
			$date=strtok($v->tanggal_transaksi,' ');
			$trans[$date][$kd]=$v;
		}
		$sis=$this->config->item('nissiswa2');
		$tpenerimaan=$this->config->item('tpenerimaan');
		$takun=$this->config->item('takun');
		ksort($trans);
		$data['trans']=$trans;
		$data['sis']=$sis;
		$data['val']=$val;
		$data['tpenerimaan']=$tpenerimaan;
		$data['takun']=$takun;
		
		$this->load->view('isi/laporan/bukubesar-excel',$data);
	}
//==========================================================================
	function jurnal()
	{
		$lv=array('Harian','Bulanan','Tahunan');
		$data=array(
			'title' => 'Laporan',
			'isi' => 'isi/laporan/jurnal-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer',
			'lk'=>$lv
		);
		$this->load->view('index',$data);
	}
	function jurnaleditproses($id,$idtrans)
	{
		if(!empty($_POST))
		{
			$d=$_POST;
			$newtotal=$d['total'] - $d['jlhlama'] + $d['jumlah'];
			$det=array();
			if($d['status']=='terima')
			{
				$trans=$this->db->from('v_trans_detail_jenis')->where('id',$id)->get()->result();
				$det['jumlah']=$d['jumlah'];
				if($trans[0]->status_transaksi!='3-Lainnya')
				{
					$pen_id=$this->db->from('t_jenis_penerimaan')->like('kodeakun',$d['kodeakun'])->get()->result();
					$det['penerimaan_id']=$pen_id[0]->id;
				}
				else
				{
					list($kd_alt,$kd_akn,$nm_akn)=explode('-',$d['kodeakun']);
					$pen_id=$this->db->from('t_akun')->like('nama_akun',$nm_akn)->where('akun_alternatif',$kd_alt)->get()->result();
					$det['penerimaan_id']=$kd_alt;
					$det['keterangan']=$pen_id[0]->id.'_'.$kd_akn.'_'.$kd_alt.'_'.$nm_akn;
				}
				$this->db->where('id',$id);
				$this->db->update('t_transaksi_detail',$det);

				$tr['tanggal_transaksi']=date('Y-m-d',strtotime($d['tanggal'])).' '.date('H:i:s');
				$tr['total']=$newtotal;
				$this->db->where('id_trans',$idtrans);
				$this->db->update('t_transaksi',$tr);
			}
			else
			{
				$kt=explode('-',$d['keterangan']);
				$det['jumlah']=$d['jumlah'];
				$pen_id=$this->db->from('t_jenis_pengeluaran')->like('kodeakun',$d['kodeakun'])->get()->result();
				$det['pengeluaran_id']=$pen_id[0]->id;
				if(isset($kt[1]))
				{
					$det['keterangan']=$d['kodeakun'].'||'.trim($kt[1]);
				}
				else
					$det['keterangan']=$d['kodeakun'];

				$this->db->where('id',$id);
				$this->db->update('t_transaksi_pengeluaran_detail',$det);

				$tr['tanggal_transaksi']=date('Y-m-d',strtotime($d['tanggal'])).' '.date('H:i:s');
				$tr['total']=$newtotal;
				$this->db->where('id_trans',$idtrans);
				$this->db->update('t_transaksi_pengeluaran',$tr);
			}
			// echo '<pre>';
			// print_r($d);
			// print_r($det);
			// echo '</pre>';
			// echo $newtotal;
		}
	}
	function jurnaledit($kodeakun,$idtrans,$iddet,$status,$jumlah,$idjenis,$total)
	{
		if($status=='terima')
		{
			$trans=$this->db->from('v_trans_detail_jenis')->where('id',$iddet)->get()->result();
			if(!empty($_POST['ket']))
			{
				$ket=$_POST['ket'];
			}
			else
				$ket=$trans[0]->keterangan;
			
			$data['keterangan']=str_replace('<br>',' - ',$ket);
		
		}
		else
		{
			$trans=$this->db->from('v_transaksi_pengeluaran_detail')->where('id',$iddet)->get()->result();
			if(!empty($_POST['ket']))
			{
				$ket=$_POST['ket'];
			}

			if($trans[0]->status_transaksi=='3-Lainnya')
			{
				$data['keterangan']=str_replace('<br>',' - ',$trans[0]->keterangan);
			}
			else
			{
				$data['keterangan']=str_replace('<br>',' - ',$ket);
			}
		}
		$data['tanggal']=date('d-m-Y',strtotime($trans[0]->tanggal_transaksi));
		$ket='';
		$akun=$this->config->item('takun');

		
		$data['idtrans']=$idtrans;
		$data['iddet']=$iddet;
		$data['id']=$iddet;
		
		$data['akun']=$akun;
		$data['jumlah']=$jumlah;
		$data['kodeakun']=$kodeakun;
		$data['status']=$status;
		$data['total']=$total;
		$this->load->view('isi/laporan/jurnal-edit',$data);
	}
	function jurnaldata2($jenis=null,$date=null,$j_lap=-1)
	{
		$data['j_lap']=$j_lap;
		$jn_pen=$this->db->from('v_semua_jenis')->where('status_tampil','t')->get()->result();
		$jn_kd_akun=$jns_terima=$jns_keluar=array();
		$akun=$this->config->item('takun');
		foreach($akun as $ka => $va)
		{
			if($va->akun_alternatif!='')
			{
				$jn_kd_akun[$va->kat][$va->akun_alternatif]=$va;
			}
		}
			// foreach($jn_pen as $kjp => $vjp)
			// {
			// 	if($vjp->status=='penerimaan')
			// 	{
			// 		$jns_terima[$vjp->id]=$vjp;
			// 	}
			// 	else
			// 	{
			// 		$jns_keluar[$vjp->id]=$vjp;
			// 	}

			// 	if($vjp->kodeakun!='')
			// 	{
			// 		$kd_alt=strtok($vjp->kodeakun,'-');
			// 		// $jn_kd_akun[]
			// 		if(isset($akun[$kd_alt]))
			// 		{
			// 			// echo $akun[$kd_alt]->id.':'.$akun[$kd_alt]->akun_alternatif.'<br>';
			// 			$jn_kd_akun[$vjp->kategori][$kd_alt]=$vjp;
			// 			// $this->db->set('kat',$vjp->kategori);
			// 			// $this->db->where('id',$akun[$kd_alt]->id);
			// 			// $this->db->update('t_akun');
			// 		}
			// 	}
			// }
		// echo '<pre>';
		// print_r($jn_kd_akun['sekolah']);
		// echo '</pre>';
		if($jenis==null)
			$jenis='Harian';

		if($date==null)
			$date=date('Y-m-d');

		if($jenis=='nama')
		{
			if($date!='null')
			{
				$date=str_replace('%20',' ',$date);
				$ceksis=$this->db->from('t_siswa')->like('nama_murid',$date)->get()->result();
				$wh='ket like "%'.$date.'%" or';
				foreach($ceksis as $k => $v)
				{
					$wh.=' nis="'.$v->nis.'" or';
				}
				$wh=substr($wh,0,-2);
				$whk='keterangan like "%'.$date.'%" or ket like "%'.$date.'%"';
				// $whk=substr($whk,0,-2);
			}
			else	
				$wh=$whk='';
			// echo $wh;
		}
		else
		{			
			$d=explode('-', $date);
			$data['bulan']='';
			$data['tanggal']='';
			if(count($d)==1)
			{
				$data['tahun']=$date;
				$wh='year(tanggal_transaksi)="'.$date.'" and status_tampil="t"';
			}
			else if(count($d)==2)
			{
				$data['bulan']=$d[1];
				$data['tahun']=$d[0];
				$wh='year(tanggal_transaksi)="'.$d[0].'" and month(tanggal_transaksi)="'.$d[1].'" and status_tampil="t"';
			}
			else
			{
				$data['bulan']=$d[1];
				$data['tahun']=$d[2];
				$data['tanggal']=$d[0];
				$wh='year(tanggal_transaksi)="'.$d[2].'" and month(tanggal_transaksi)="'.$d[1].'" and day(tanggal_transaksi)="'.$d[0].'" and status_tampil="t"';
			}

			$whk=$wh;
		}
		
		if($jenis=='Bulanan')
		{
			$d=explode('-', $date);
			$data['bulan']=$d[1];
			$data['tahun']=$d[0];
			$wh='year(tanggal_transaksi)="'.$d[0].'" and month(tanggal_transaksi)="'.$d[1].'" and status_tampil="t"';
			$date=date('Y-n',strtotime($date));
		}
		else if($jenis=='Tahunan')
		{
			$d=explode('-', $date);
			$date=date('Y',strtotime($date));
			$data['tahun']=$date;
			$wh='year(tanggal_transaksi)="'.$date.'" and status_tampil="t"';
		}
		else if($jenis=='Harian')
		{
			$d=explode('-', $date);
			$data['bulan']=$d[1];
			$data['tahun']=$d[2];
			$data['tanggal']=$d[0];
			$wh='year(tanggal_transaksi)="'.$d[2].'" and month(tanggal_transaksi)="'.$d[1].'" and day(tanggal_transaksi)="'.$d[0].'" and status_tampil="t"';
			$date=$date;
		}
		//echo $wh;
		// if($jenis==)
		// $pen=$p[][][];
		if($wh!='')
			$translain=$this->db->select('*,"terima" as status')->from('v_trans_detail_jenis')->where($wh)->like('status_transaksi','3-Lainnya')->order_by('tanggal_transaksi')->get()->result();
			// $translain=$this->db->select('*,"terima" as status')->from('v_transaksi')->where($wh)->like('status_transaksi','3-Lainnya')->order_by('tanggal_transaksi')->get()->result();
		else
			$translain=$this->db->select('*,"terima" as status')->from('v_trans_detail_jenis')->like('status_transaksi','3-Lainnya')->order_by('tanggal_transaksi')->get()->result();
			// $translain=$this->db->select('*,"terima" as status')->from('v_transaksi')->like('status_transaksi','3-Lainnya')->order_by('tanggal_transaksi')->get()->result();


		$t_lain=array();
		foreach($translain as $tr => $vr)
		{
			$tgl=strtok($vr->tanggal_transaksi,' ');
			$t_lain[$tgl][$vr->status.'_'.$vr->id]=$vr;
		}
		
		if($wh!='')
			$trans=$this->db->select('*,"terima" as status')->from('v_transaksi_penerimaan')->where($wh)->order_by('tanggal_transaksi','nis')->get()->result();
		else
			$trans=$this->db->select('*,"terima" as status')->from('v_transaksi_penerimaan')->order_by('tanggal_transaksi','nis')->get()->result();
		foreach($trans as $k => $v)
		{
			$tgl=strtok($v->tanggal_transaksi,' ');
			$t_lain[$tgl][$v->status.'_'.$v->id]=$v;
		}
		
		if($wh!='')
			$p_keluar=$this->db->select('*,"keluar" as status')->from('v_transaksi_pengeluaran_detail')->where($whk)->order_by('tanggal_transaksi')->get()->result();
		else
			$p_keluar=$this->db->select('*,"keluar" as status')->from('v_transaksi_pengeluaran_detail')->order_by('tanggal_transaksi')->get()->result();
		// $tr_k=array();
		foreach($p_keluar as $tkr => $vkr)
		{
			$tgl=strtok($vkr->tanggal_transaksi,' ');
			$t_lain[$tgl][$vkr->status.'_'.$vkr->id]=$vkr;
		}
		

		$siswa=$this->config->item('nissiswa2');
		$tpenerimaan=$this->config->item('tpenerimaan');
		ksort($t_lain);
		$tr=array();
		foreach($t_lain as $kt => $vt)
		{
			foreach($vt as $i => $vl)
			{
				if($vl->status=='keluar')
				{
					
					list($k1,$k2)=explode('||',$vl->keterangan);
					list($kdakunalt,$kdakun,$nmakun)=explode('-',$k1);
					$kode_akun=$kdakunalt;
				}
				else
				{
					$nis=str_replace('.','_',$vl->nis);
					
					//$date=$v->tanggal_transaksi;
					if(isset($tpenerimaan[$vl->penerimaan_id]))
					{
						if($vl->status_transaksi!='3-Lainnya')
						{
							if(isset($vl->jenis))
							{
								
								$t=$tpenerimaan[$vl->penerimaan_id];
								$kode_akun=$t->kodeakun;
							}
							else
							{
								$kode_akun='--';
							}
						
						}
						else
						{
							$kode_akun='---';
						}
					}
					else
					{
						list($idakun,$kdakun,$kdakunalt,$nmakun)=explode('_',$vl->keterangan);
						$kode_akun=$kdakunalt;
					}
				}
				if($j_lap==-1)
				$tr[]=$vl;
				else
				{
					$kode_akun=strtok($kode_akun,'-');
					if($j_lap=='sekolah')
					{
						// echo $kode_akun.'-'.$vl->status.'<br>';
						if(isset($jn_kd_akun['sekolah'][trim($kode_akun)]))
						{
							$tr[]=$vl;
						}
					}
					else
					{
						if(isset($jn_kd_akun['non-sekolah'][trim($kode_akun)]))
						{
							$tr[]=$vl;
						}
					}
				}
					// else
				
			}
		}
		// echo $date;
		$data['siswa']=$siswa;
		$data['tpenerimaan']=$tpenerimaan;
		$data['date']=$date;
		$data['jenis']=$jenis;
		$data['trans']=$tr;
		// echo '<pre>';
		// print_r($tr);
		// echo '</pre>';
		// $data['trans']=$trans;
		$this->load->view('isi/laporan/jurnal-data',$data);
	}
	function jurnaldata($jenis=null,$date=null,$j_lap=-1)
	{
		$data['j_lap']=$j_lap;
		$data['jenis']=$jenis;
		$data['date']=$date;
		$jn_pen=$this->db->from('v_semua_jenis')->where('status_tampil','t')->get()->result();
		$jn_kd_akun=$jns_terima=$jns_keluar=array();
		$akun=$this->config->item('takun');
		foreach($akun as $ka => $va)
		{
			if($va->akun_alternatif!='')
			{
				$jn_kd_akun[$va->kat][$va->kode_akun]=$va;
			}
		}

		if($jenis==null)
			$jenis='Harian';

		if($date==null)
			$date=date('Y-m-d');

		$whk='';
		if($jenis=='nama')
		{
			if($date!='null')
			{
				
				$whk=' and keterangan like "%'.$date.'%"';
				// $whk=substr($whk,0,-2);
			}
			else	
				$whk='';
			// echo $wh;
		}
		
		
		if($jenis=='Bulanan')
		{
			$d=explode('-', $date);
			$data['bulan']=$d[1];
			$data['tahun']=$d[0];
			$wh=' year(tanggal)="'.$d[0].'" and month(tanggal)="'.$d[1].'"';
			$date=date('Y-n',strtotime($date));
		}
		else if($jenis=='Tahunan')
		{
			$d=explode('-', $date);
			$date=date('Y',strtotime($date));
			$data['tahun']=$date;
			$wh=' year(tanggal)="'.$date.'"';
		}
		else if($jenis=='Harian')
		{
			$d=explode('-', $date);
			$data['bulan']=$d[1];
			$data['tahun']=$d[2];
			$data['tanggal']=$d[0];
			$wh=' year(tanggal)="'.$d[2].'" and month(tanggal)="'.$d[1].'" and day(tanggal)="'.$d[0].'"';
			$date=$date;
		}
		$whr=$wh.$whk;
		$trans=$this->db->from('t_jurnal')->where($whr)->order_by('tanggal,ref,id')->get()->result();
		$tr=array();
		foreach($trans as $k=>$v)
		{
			$tr[$v->ref][]=$v;
		}
		$data['trans']=$tr;
		$this->load->view('isi/laporan/jurnal-data-2',$data);
	}
	function jurnalexcel($jenis,$date)
	{
		/*$data['date']=$date;
		$data['jenis']=$jenis;
		$d=explode('-', $date);
		$data['bulan']='';
		$data['tanggal']='';
		if(count($d)==1)
		{
			$data['tahun']=$date;
			$wh='year(tanggal_transaksi)="'.$date.'" and status_tampil="t"';
		}
		else if(count($d)==2)
		{
			$data['bulan']=$d[1];
			$data['tahun']=$d[0];
			$wh='year(tanggal_transaksi)="'.$d[0].'" and month(tanggal_transaksi)="'.$d[1].'" and status_tampil="t"';
		}
		else
		{
			$data['bulan']=$d[1];
			$data['tahun']=$d[2];
			$data['tanggal']=$d[0];
			$wh='year(tanggal_transaksi)="'.$d[2].'" and month(tanggal_transaksi)="'.$d[1].'" and day(tanggal_transaksi)="'.$d[0].'" and status_tampil="t"';
		}
		// if($jenis==)
		// $pen=$p[][][];
		$trans=$this->db->select('*,"terima" as status')->from('v_transaksi_penerimaan')->order_by('tanggal_transaksi','nis')->where($wh)->get()->result();
		$data['trans']=$trans;*/
		if($jenis==null)
			$jenis='Harian';

		if($date==null)
			$date=date('Y-m-d');

		if($jenis=='nama')
		{
			if($date!='null')
			{

				$date=str_replace('%20',' ',$date);
				$ceksis=$this->db->from('t_siswa')->like('nama_murid',$date)->get()->result();
				$wh=$whk='ket like "%'.$date.'%" or';
				foreach($ceksis as $k => $v)
				{
					$wh.=' nis="'.$v->nis.'" or';
				}
				$wh=substr($wh,0,-2);
				$whk=substr($whk,0,-2);
			}
			else	
				$wh='';
			// echo $wh;
		}
		else
		{			
			$d=explode('-', $date);
			$data['bulan']='';
			$data['tanggal']='';
			if(count($d)==1)
			{
				$data['tahun']=$date;
				$wh='year(tanggal_transaksi)="'.$date.'" and status_tampil="t"';
			}
			else if(count($d)==2)
			{
				$data['bulan']=$d[1];
				$data['tahun']=$d[0];
				$wh='year(tanggal_transaksi)="'.$d[0].'" and month(tanggal_transaksi)="'.$d[1].'" and status_tampil="t"';
			}
			else
			{
				$data['bulan']=$d[1];
				$data['tahun']=$d[2];
				$data['tanggal']=$d[0];
				$wh='year(tanggal_transaksi)="'.$d[2].'" and month(tanggal_transaksi)="'.$d[1].'" and day(tanggal_transaksi)="'.$d[0].'" and status_tampil="t"';
			}

			$whk=$wh;
		}
		
		if($jenis=='Bulanan')
		{
			$d=explode('-', $date);
			$data['bulan']=$d[1];
			$data['tahun']=$d[0];
			$wh='year(tanggal_transaksi)="'.$d[0].'" and month(tanggal_transaksi)="'.$d[1].'" and status_tampil="t"';
			$date=date('Y-n',strtotime($date));
		}
		else if($jenis=='Tahunan')
		{
			$d=explode('-', $date);
			$date=date('Y',strtotime($date));
			$data['tahun']=$date;
			$wh='year(tanggal_transaksi)="'.$date.'" and status_tampil="t"';
		}
		else if($jenis=='Harian')
		{
			$d=explode('-', $date);
			$data['bulan']=$d[1];
			$data['tahun']=$d[2];
			$data['tanggal']=$d[0];
			$wh='year(tanggal_transaksi)="'.$d[2].'" and month(tanggal_transaksi)="'.$d[1].'" and day(tanggal_transaksi)="'.$d[0].'" and status_tampil="t"';
			$date=$date;
		}
		//echo $date;
		// if($jenis==)
		// $pen=$p[][][];
		$translain=$this->db->select('*,"terima" as status')->from('v_transaksi')->where($wh)->like('status_transaksi','3-Lainnya')->order_by('tanggal_transaksi')->get()->result();
		$t_lain=array();
		foreach($translain as $tr => $vr)
		{
			$tgl=strtok($vr->tanggal_transaksi,' ');
			$t_lain[$tgl][$vr->id_trans]=$vr;
		}
		
		
		$trans=$this->db->select('*,"terima" as status')->from('v_transaksi_penerimaan')->where($wh)->order_by('tanggal_transaksi','nis')->get()->result();
		foreach($trans as $k => $v)
		{
			$tgl=strtok($v->tanggal_transaksi,' ');
			$t_lain[$tgl][$v->id]=$v;
		}
		
		$p_keluar=$this->db->select('*,"keluar" as status')->from('v_transaksi_pengeluaran_detail')->where($whk)->order_by('tanggal_transaksi')->get()->result();
		// $tr_k=array();
		foreach($p_keluar as $tkr => $vkr)
		{
			$tgl=strtok($vkr->tanggal_transaksi,' ');
			$t_lain[$tgl][$vkr->id]=$vkr;
		}
		
		ksort($t_lain);
		$tr=array();
		foreach($t_lain as $kt => $vt)
		{
			foreach($vt as $i => $vl)
			{
				$tr[]=$vl;
			}
		}
		// echo $date;
		$data['date']=$date;
		$data['jenis']=$jenis;
		$data['trans']=$tr;
		$this->load->view('isi/laporan/jurnal-excel',$data);
	}
	//==========================================================================
	function tabungan()
	{
		$lv=array('Harian','Bulanan','Mingguan');
		$data=array(
			'title' => 'Laporan Tabungan',
			'isi' => 'isi/laporan/tabungan-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer',
			'lk'=>$lv
		);
		$this->load->view('index',$data);
	}
	function tabungandata($waktu,$date=-1,$grafik=-1)
	{

		$data['waktu']=$waktu;
		$tr=array();
		$total=array();
		$dl=array();
		$totalpen=0;
		if($waktu=='harian')
		{
			if($date==-1)
			{
				list($thn,$bln,$tgl)=explode('-', date('Y-m-d'));
			}
			else
			{
				list($tgl,$bln,$thn)=explode('-', $date);
			}
			$data['tanggal']=$tgl;
			$data['bulan']=$bln;
			$data['tahun']=$thn;
			$tanggal=$thn.'-'.$bln.'-'.$tgl;
			$data['date']=tgl_indo($tanggal);
			$data['penerimaan']='Tabungan Harian';
			$wh=('t_tabungan_detail.tanggal like "%'.($tanggal).'%" and t_tabungan.status_tampil="t" and t_tabungan_detail.status_tampil_det="t"');
		}
		else if($waktu=='bulanan')
		{
			if($date==-1)
			{
				$bln=date('n');
				$thn=date('Y');
			}
			else
			{
				list($bln,$thn)=explode('-', $date);
				// $thn=date('Y');
			}
			$data['bulan']=$bln;
			$data['tahun']=$thn;
			$data['date']=getBulan($bln).' '.$thn;
			$data['penerimaan']='Tabungan Bulanan';
			$wh=array('month(t_tabungan_detail.tanggal)'=>$bln , 'year(t_tabungan_detail.tanggal)'=>$thn,'t_tabungan.status_tampil'=>'t','t_tabungan_detail.status_tampil_det'=>'t');
		}
		else if($waktu=='tahunan')
		{
			if($date==-1)
			{
				$thn=date('Y');
			}
			else
			{
				$thn=$date;
			}
			$data['tahun']=$thn;
			$data['date']=$thn;
			$data['penerimaan']='Tabungan Tahunan';
			$wh=array('year(t_tabungan_detail.tanggal)'=>$thn,'t_tabungan.status_tampil'=>'t','t_tabungan_detail.status_tampil_det'=>'t');
		}
		else if($waktu=='total')
		{
			$date=str_replace('%20', ' ', $date);
			$tabungan=$this->config->item('tabungan');
			$df=$this->config->item('vbatchsiswabylevel');
			$l_kelas=$this->config->item('tlevelkelas');
			$data['tahun']='';
			$data['date']='';
			$wh=array('t_tabungan.status_tampil'=>'t','t_tabungan_detail.status_tampil_det'=>'t');
			if($date!='all')
			{
				list($idl,$nml)=explode('_', $date);
				$dl=$df[$idl];
				$data['penerimaan']='Total Tabungan Kelas : '.$nml;
			}
			else
			{
				$dll=$df;

				$data['penerimaan']='Total Keseluruhan Tabungan ';
				$x=0;
				foreach ($dll as $kdl => $vdl)
				{
					foreach ($vdl as $kl => $vl)
					{
						# code...
						$lkls=$l_kelas[$vl->id_level];
						if(isset($tabungan[$vl->id]))
						{
							$total[$lkls->nama_level][]=$tabungan[$vl->id][0]->saldo;
						}
					}
					$x+=count($vdl);
				}
				ksort($total);
				// echo $x.'<br>';
				// echo count($dl).'<br>';
				// echo '<pre>';
				// print_r($total);
				// echo '</pre>';
			}
		}


			// $siswa=$this
			$siswa=$this->db->from('t_siswa')->where('status_tampil','t')->get()->result();
			$sis=array();
			foreach ($siswa as $ks => $vs)
			{
				$sis[$vs->nis]=$vs;
			}

			// $batch=$this->db->from('v_batch_kelas')->where('status_tampil','t')->get()->result();
			// $bt=array();
			// foreach ($batch as $kb => $vb)
			// {
			// 	$bt[$vb->id_batch]=$vb;
			// }
			$bt=$this->config->item('vbatchkelas');
			$data['batch']=$bt;

			$trans=$this->db->from('t_tabungan')->join('t_tabungan_detail','t_tabungan.id=t_tabungan_detail.tabungan_id')->where($wh)->order_by('t_tabungan_detail.tanggal desc')->get()->result();

			// echo '<pre>';
			// print_r($trans)
			// echo '</pre>';
			if($waktu=='total')
			{


			// 	echo '<pre>';
			// 	print_r($tabungan);
			// 	echo '</pre>';
				foreach ($dl as $kd => $vd)
				{
					if(isset($tabungan[$vd->id]))
					{
						$saldo=$tabungan[$vd->id][0]->saldo;
						$totalpen+=$saldo;
						// echo $kd.'-'.$saldo.'<br>';
					}
					// $total['strtolower($v->jenis)'][]=$v->jumlah;
				}
			}
			else
			{
				foreach ($trans as $k => $v)
				{
					// $nis=$v->nis.'__'.str_replace(' ', '_', $sis[$v->nis]->nama_murid).'__'.$v->batch_id;
					// $date_tgl=strtok($v->tanggal_transaksi, ' ');
					// $tr[$date_tgl][$nis][$v->penerimaan_id]=$v;

					// $jns=$v->penerimaan_id.'__'.str_replace(' ', '_', $v->jenis);
					// if()
					$total[strtolower($v->jenis)][]=$v->jumlah;
				}
			}
			// $data['trans']=$tr;
			$data['total']=$total;
			// if($grafik==-1)
			// 	$this->load->view('isi/transaksi/rekap-data',$data);
			// else
			// {
				$g=$color='';

				if(count($total)!=0)
				{
					$totalpen=0;
					foreach ($total as $k => $v)
					{
						// colors: ['red', 'orange', 'green', 'blue', 'purple', 'brown'],

						// list($idjenis,$jenisp)=explode('__', $k);
						// $jenisp=str_replace('_',' ', $jenisp);

						// $dt[$idjenis][]=$v->jumlah_2;
						$jlh=array_sum($total[$k]);
						// $jenis[$k]=$jlh;
						// echo $k.'-'.$jlh.'<br>';
						if(strtolower($k)=='tarik')
						{
							$totalpen-=$jlh;
							$jj=0-$jlh;
							$color.='"orange",';
						}
						else
						{
							$jj=$jlh;
							$totalpen+=$jlh;
							$color.='"green",';
						}

						$g.='["'.$k.'", '.$jj.'],';
					}

					// echo $total;

				}
				$data['color']=$color.'"blue"';
				$data['g']=$g.'["Total",'.$totalpen.']';
					// echo '<pre>';
					// print_r($data);
					// echo '</pre>';
				$this->load->view('isi/transaksi/rekap-grafik',$data);

			// }


	}

	function hapusjurnal($id,$idtrans,$jenis,$date,$nis,$jumlah,$total,$id_jenis)
	{
		// $siswa=$this->config->item('nissiswa');
		// $sis=$siswa[$nis];
		if($jenis=='keluar')
		{
			$this->db->where('id',$id);
			$this->db->delete('t_transaksi_pengeluaran_detail');
			
			$this->db->set('total',($total-$jumlah));
			$this->db->where('id_trans',$idtrans);
			$this->db->update('t_transaksi_pengeluaran');

			echo 1;
		}
		else if($jenis=='lain')
		{
			$this->db->where('id',$id);
			$this->db->delete('t_transaksi_detail');
			
			$this->db->set('total',($total-$jumlah));
			$this->db->where('id_trans',$idtrans);
			$this->db->update('t_transaksi');

			echo 1;
		}
		else
		{	
			$trans=$this->db->from('v_transaksi')->where('id',$id)->get()->result();
			$tagihan=$this->db->from('t_tagihan_siswa')
						->where('id_jenis_penerimaan',$id_jenis)
						->where('nis',$nis)
						->get()->result();
			
			//
			if(count($tagihan)!=0)
			{
				$edit_total=$total-$jumlah;
				$this->db->set('total',$edit_total);
				$this->db->where('id_trans',$idtrans);
				$this->db->update('t_transaksi');

				$this->db->where('id',$id);
				$this->db->delete('t_transaksi_detail');

				$this->db->set('sisa_bayar',$jumlah);
				$this->db->where('id_tagihan',$tagihan[0]->id_tagihan);
				$this->db->update('t_tagihan_siswa');
				echo 1;
			}
			else
				echo 0;
		}
		// ≈
	}
	//---------------Neraca Lajur---------------
	function neracalajur()
	{
		$data=array(
			'title' => 'Laporan Neraca Lajur',
			'isi' => 'isi/laporan/neracalajur-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}

	function neracalajurdata($date,$jenis=null)
	{
		if($jenis==null)
		{
			$j_lap='Sekolah';
		}
		else
			$j_lap=$jenis;

		$akun=$this->config->item('takun');
		$t_neraca_saldo=$this->config->item('t_neraca_saldo');
		$subakun=array();
		
		$kode_akun=array();
		$akun_kas_pen=$akun_kas_peng=array();
		$piutang_debit=$piutang_kredit=array();
		$perlengkapan_debit=$perlengkapan_kredit=array();
		$bangunan_debit=$bangunan_kredit=array();
		$tanah_debit=$tanah_kredit=array();
		$sewa_debit=$tanah_kredit=array();
		$utang_debit=$utang_kredit=array();
		$sumbangan_fasilitas_debit=$sumbangan_fasilitas_kredit=array();
		$sumbangan_pendidikan_debit=$sumbangan_pendidikan_kredit=array();
		$sumbangan_pendidikan_bulanan_debit=$sumbangan_pendidikan_bulanan_kredit=array();
		$sumbangan_lain_debit=$sumbangan_lain_kredit=array();
		$belanja_gaji_debit=$belanja_gaji_kredit=array();
		$divisi_pendidikan_debit=$divisi_pendidikan_kredit=array();
		$divisi_operasional_debit=$divisi_operasional_kredit=array();
		$biaya_utilitas_debit=$biaya_utilitas_kredit=array();
		$beban_sewa_debit=$beban_sewa_kredit=array();
		$dana_sosial_debit=$dana_sosial_kredit=array();
		foreach($akun as $k => $v)
		{
			$kode_akun[$v->akun_alternatif]=$v;
			if($v->akun_alt_parent=='0')
			{
				$k_akun[$k]=$v;
			}
			if($v->jenis=='penerimaan')
			{
				if($v->kat!='')
				{
					$akun_kas_pen[$v->kat][$v->akun_alternatif]=$v;

					if(strpos(strtolower($v->nama_akun),'piutang')!==false)
					{
						$piutang_debit[$v->akun_alternatif]=$v;
					}
					
					if(strpos(strtolower($v->nama_akun),'perlengkapan')!==false || strpos(strtolower($v->nama_akun),'peralatan')!==false)
					{
						$perlengkapan_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'bangunan')!==false)
					{
						$bangunan_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'tanah')!==false)
					{
						$tanah_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'beban sewa')!==false)
					{
						$sewa_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'utang')!==false && strpos(strtolower($v->nama_akun),'piutang')===false)
					{
						$utang_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'pembiayaan fasilitas')!==false)
					{
						$sumbangan_fasilitas_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'pembiayaan pendidikan tahunan')!==false)
					{
						$sumbangan_pendidikan_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'pembiayaan pendidikan bulanan')!==false)
					{
						$sumbangan_pendidikan_bulanan_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'sumbangan lain')!==false)
					{
						$sumbangan_lain_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'belanja gaji')!==false)
					{
						$belanja_gaji_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'divisi pendidikan')!==false)
					{
						$divisi_pendidikan_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'divisi operasional')!==false)
					{
						$divisi_operasional_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'biaya utilitas')!==false)
					{
						$biaya_utilitas_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'beban sewa')!==false)
					{
						$beban_sewa_debit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'dana sosial')!==false)
					{
						$dana_sosial_debit[$v->akun_alternatif]=$v;
					}
				}
			}
			else if($v->jenis=='pengeluaran')
			{
				if($v->kat!='')
				{
					$akun_kas_peng[$v->kat][$v->akun_alternatif]=$v;
					
					if(strpos(strtolower($v->nama_akun),'piutang')!==false)
					{
						$piutang_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'perlengkapan')!==false || strpos(strtolower($v->nama_akun),'peralatan')!==false)
					{
						$perlengkapan_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'bangunan')!==false)
					{
						$bangunan_kredit[$v->akun_alternatif]=$v;
					}
					if(strtolower($v->nama_akun)=='tanah')
					{
						$tanah_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'beban sewa')!==false)
					{
						$sewa_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'utang')!==false && strpos(strtolower($v->nama_akun),'piutang')===false)
					{
						$utang_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'pembiayaan fasilitas')!==false)
					{
						$sumbangan_fasilitas_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'pembiayaan pendidikan tahunan')!==false)
					{
						$sumbangan_pendidikan_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'pembiayaan pendidikan bulanan')!==false)
					{
						$sumbangan_pendidikan_bulanan_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'sumbangan lain')!==false)
					{
						$sumbangan_lain_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'belanja gaji')!==false)
					{
						$belanja_gaji_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'divisi pendidikan')!==false)
					{
						$divisi_pendidikan_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'divisi operasional')!==false)
					{
						$divisi_operasional_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'biaya utilitas')!==false)
					{
						$biaya_utilitas_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'beban sewa')!==false)
					{
						$beban_sewa_kredit[$v->akun_alternatif]=$v;
					}
					if(strpos(strtolower($v->nama_akun),'dana sosial')!==false)
					{
						$dana_sosial_kredit[$v->akun_alternatif]=$v;
					}
				}
			}
		}

		$ajaran=$this->config->item('tajaran');
		if($date==-1)
		{
			if(date('n')>=7 && date('n')<=12)
				$tahunajaran=date('Y').' / '.(date('Y') +1);
			else
				$tahunajaran=(date('Y') -1) .' / '.date('Y');
		}
		else
		{
			$tahunajaran=$ajaran[$date]->tahun_ajaran;
		}
		list($th1,$th2)=explode('/',str_replace(' / ','/',$tahunajaran));

		$wh='status_tampil="t"';
		$whpen=$wh.' and (YEAR(`tanggal_transaksi`)='.$th1.' AND MONTH(`tanggal_transaksi`) BETWEEN 7 AND 12) OR 
  							(YEAR(`tanggal_transaksi`)='.$th2.' AND MONTH(`tanggal_transaksi`) BETWEEN 1 AND 6)';
		$t_pen=$this->db->select('*,"terima" as status')->from('v_trans_detail_jenis')->where($whpen)->order_by('tanggal_transaksi asc')->get()->result();

		$whpeng=$wh.' and (YEAR(`tanggal_transaksi`)='.$th1.' AND MONTH(`tanggal_transaksi`) BETWEEN 7 AND 12) OR 
  							(YEAR(`tanggal_transaksi`)='.$th2.' AND MONTH(`tanggal_transaksi`) BETWEEN 1 AND 6)';
		$t_peng=$this->db->select('*,"keluar" as status, "-1" as nis, "-1" as id_jns')->from('v_transaksi_pengeluaran_detail')->where($whpeng)->order_by('tanggal_transaksi asc')->get()->result();


		$trans=array();
		foreach($t_pen as $k => $v)
		{
			if(is_null($v->kodeakun))
			{
				list($idakun,$kdakun,$ak_alt,$nmakun)=explode('_',$v->keterangan);
			}
			else
			{
				$kdd=explode('-',$v->kodeakun);
				$ak_alt=$kdd[0];
				$kdakun=$kdd[1];
			}
			$tahun=date('Y',strtotime($v->tanggal_transaksi));
			$bulan=date('n',strtotime($v->tanggal_transaksi));
			
			if($kode_akun[$ak_alt]->akun_alt_parent!='0')
			{
				// if($ak_alt=='A501')
				// 	echo $ak_alt;
				$trans[$kode_akun[$ak_alt]->akun_alt_parent][$tahunajaran][]=$v->jumlah;
			}
			else
			{
				$trans[$ak_alt][$tahunajaran][]=$v->jumlah;
			}
		}
		foreach($t_peng as $k => $v)
		{
			$kd=strtok($v->keterangan,'-');
			$tahun=date('Y',strtotime($v->tanggal_transaksi));
			$bulan=date('n',strtotime($v->tanggal_transaksi));
			
			if($kode_akun[$kd]->akun_alt_parent!='0')
			{
				$trans[$kode_akun[$kd]->akun_alt_parent][$tahunajaran][]=$v->jumlah;
			}
			else
			{
				$trans[$kd][$tahunajaran][]=$v->jumlah;
			}
		}
		
		$data['header']=array(
				'PENUTUPAN '.($th1-1).'/'.($th2-1),
				'TRANSAKSI '.($th1).'/'.($th2),
				'NERACA SALDO '.($th1).'/'.($th2),
				'PENYESUAIAN '.($th1).'/'.($th2),
				'NERACA SETELAH PENYESUAIAN '.($th1).'/'.($th2),
				'LABA RUGI '.($th1).'/'.($th2),
				'PENUTUPAN '.($th1).'/'.($th2)
			);
		
		// echo '<pre>';
		// print_r($piutang_debit);
		// echo '</pre>';
		$kas_pen=$kas_peng=0;
		$piutang_d=$piutang_k=0;
		$perlengkapan_d=$perlengkapan_k=0;
		$bangunan_d=$bangunan_k=0;
		$tanah_d=$tanah_k=0;
		$sewa_d=$sewa_k=0;
		$utang_d=$utang_k=0;
		$pemb_fasilitas_d=$pemb_fasilitas_k=0;
		$pemb_pendidikan_d=$pemb_pendidikan_k=0;
		$pemb_pendidikan_bulanan_d=$pemb_pendidikan_bulanan_k=0;
		$pemb_lain_d=$pemb_lain_k=0;
		$gaji_d=$gaji_k=0;
		$div_pendidikan_d=$div_pendidikan_k=0;
		$div_operasional_d=$div_operasional_k=0;
		$biaya_utilitas_d=$biaya_utilitas_k=0;
		$beban_sewa_d=$beban_sewa_k=0;
		$dana_sosial_d=$dana_sosial_k=0;
		if(strtolower($j_lap)=='sekolah')
		{
			foreach($akun_kas_pen['sekolah'] as $i_ak => $v_ak)
			{
				if(isset($trans[$i_ak]))
					$ks=array_sum($trans[$i_ak][$tahunajaran]);
				else
				{
					$ks=0;
				}

				$kas_pen+=$ks;
			}
			// echo '<pre>';
			// print_r($akun_kas_pen['sekolah']);
			// print_r($trans['A501'][$tahunajaran]);
			// echo '</pre>';

			foreach($akun_kas_peng['sekolah'] as $i_peng => $v_peng)
			{
				if(isset($trans[$i_peng]))
					$ks=array_sum($trans[$i_peng][$tahunajaran]);
				else
					$ks=0;

				$kas_peng+=$ks;
			}

			foreach($piutang_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;

				$piutang_d+=$ks;
			}
			
			foreach($piutang_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
					
				$piutang_k+=$ks;
			}
			// echo '<pre>';
			// echo $piutang_k;
			// print_r($piutang_kredit);
			// print_r($trans['C101'][$tahunajaran]);
			// echo '</pre>';
			foreach($perlengkapan_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$perlengkapan_d+=$ks;
			}
			foreach($perlengkapan_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$perlengkapan_k+=$ks;
			}
			foreach($bangunan_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$bangunan_d+=$ks;
			}
			foreach($bangunan_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$bangunan_k+=$ks;
			}
			foreach($tanah_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$tanah_d+=$ks;
			}
			foreach($tanah_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$tanah_k+=$ks;
			}
			foreach($sewa_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$sewa_d+=$ks;
			}
			foreach($sewa_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$sewa_k+=$ks;
			}
			foreach($utang_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$utang_k+=$ks;
			}
			foreach($utang_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$utang_d+=$ks;
			}
			foreach($sumbangan_fasilitas_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$pemb_fasilitas_k+=$ks;
			}
			foreach($sumbangan_fasilitas_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$pemb_fasilitas_d+=$ks;
			}
			foreach($sumbangan_pendidikan_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$pemb_pendidikan_d+=$ks;
			}
			foreach($sumbangan_pendidikan_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$pemb_pendidikan_k+=$ks;
			}
			foreach($sumbangan_pendidikan_bulanan_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$pemb_pendidikan_bulanan_d+=$ks;
			}
			foreach($sumbangan_pendidikan_bulanan_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$pemb_pendidikan_bulanan_k+=$ks;
			}
			foreach($sumbangan_lain_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$pemb_lain_d+=$ks;
			}
			foreach($sumbangan_lain_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$pemb_lain_k+=$ks;
			}
			foreach($belanja_gaji_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$gaji_d+=$ks;
			}
			foreach($belanja_gaji_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$gaji_k+=$ks;
			}
			foreach($divisi_pendidikan_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$div_pendidikan_d+=$ks;
			}
			foreach($divisi_pendidikan_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$div_pendidikan_k+=$ks;
			}
			foreach($divisi_operasional_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$div_operasional_d+=$ks;
			}
			foreach($divisi_operasional_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$div_operasional_k+=$ks;
			}
			foreach($biaya_utilitas_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$biaya_utilitas_d+=$ks;
			}
			foreach($biaya_utilitas_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$biaya_utilitas_k+=$ks;
			}
			foreach($beban_sewa_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$beban_sewa_d+=$ks;
			}
			foreach($beban_sewa_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$beban_sewa_k+=$ks;
			}
			foreach($dana_sosial_debit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$dana_sosial_d+=$ks;
			}
			foreach($dana_sosial_kredit as $pd => $vpd)
			{
				if(isset($trans[$pd]))
					$ks=array_sum($trans[$pd][$tahunajaran]);
				else
					$ks=0;
				$dana_sosial_k+=$ks;
			}
		}
		// echo '<pre>';
		// // print_r($utang_debit);
		// print_r($kode_akun['A100']);
		// echo '</pre>';
		$data['kas_pen']=$kas_pen;$data['kas_peng']=$kas_peng;
		$data['piutang_d']=$piutang_d;$data['piutang_k']=$piutang_k;
		$data['perlengkapan_d']=$perlengkapan_d;$data['perlengkapan_k']=$perlengkapan_k;
		$data['bangunan_d']=$bangunan_d;$data['bangunan_k']=$bangunan_k;
		$data['tanah_d']=$tanah_d;$data['tanah_k']=$tanah_k;
		$data['sewa_d']=$sewa_d;$data['sewa_k']=$sewa_k;
		$data['utang_d']=$utang_d;$data['utang_k']=$utang_k;	
		$data['pemb_fasilitas_d']=$pemb_fasilitas_d;$data['pemb_fasilitas_k']=$pemb_fasilitas_k;
		$data['pemb_pendidikan_k']=$pemb_pendidikan_k;$data['pemb_pendidikan_d']=$pemb_pendidikan_d;
		$data['pemb_pendidikan_bulanan_k']=$pemb_pendidikan_bulanan_k;$data['pemb_pendidikan_bulanan_d']=$pemb_pendidikan_bulanan_d;
		$data['pemb_lain_k']=$pemb_lain_k;$data['pemb_lain_d']=$pemb_lain_d;
		$data['gaji_k']=$gaji_k;$data['gaji_d']=$gaji_d;
		$data['div_pendidikan_k']=$div_pendidikan_k;$data['div_pendidikan_d']=$div_pendidikan_d;
		$data['div_operasional_k']=$div_operasional_k;$data['div_operasional_d']=$div_operasional_d;
		$data['biaya_utilitas_k']=$biaya_utilitas_k;$data['biaya_utilitas_d']=$biaya_utilitas_d;
		$data['beban_sewa_k']=$beban_sewa_k;$data['beban_sewa_d']=$beban_sewa_d;
		$data['dana_sosial_k']=$dana_sosial_k;$data['dana_sosial_d']=$dana_sosial_d;
		$data['th1']=$th1;
		$data['th2']=$th2;
		$data['date']=$date;
		$data['j_lap']=$j_lap;
		$data['k_akun']=$k_akun;
		$data['jenis']=$jenis;
		$data['akun_kas_pen']=$akun_kas_pen;
		$data['neraca_awal']=$t_neraca_saldo;
		$data['tahunajaran']=$tahunajaran;
		$this->load->view('isi/laporan/neracalajur-data',$data);
	}

	function laporanaktifitas()
	{
		$data=array(
			'title' => 'Laporan Aktifitas Lajur',
			'isi' => 'isi/laporan/laporanaktifitas-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}

	function laporanaktifitasdata($date,$jenis=null)
	{
		if($jenis==null)
		{
			$j_lap='Sekolah';
		}
		else
			$j_lap=$jenis;

		$kode_akun=array();
		$akun=$this->config->item('takun');
		$tsaldoakun=$this->config->item('tsaldoakun');
		$t_neraca_saldo=$this->config->item('t_neraca_saldo2');

		foreach($akun as $k => $v)
		{
			$kode_akun[$v->akun_alternatif]=$v;
		}

		$ajaran=$this->config->item('tajaran');
		if($date==-1)
		{
			if(date('n')>=7 && date('n')<=12)
				$tahunajaran=date('Y').' / '.(date('Y') +1);
			else
				$tahunajaran=(date('Y') -1) .' / '.date('Y');
		}
		else
		{
			$tahunajaran=$ajaran[$date]->tahun_ajaran;
		}
		list($th1,$th2)=explode('/',str_replace(' / ','/',$tahunajaran));
		$th1=trim($th1);
		$th2=trim($th2);
		// echo $th1;
		$wh='status_tampil="t"';
		$whpen=$wh.' and (YEAR(`tanggal_transaksi`)='.$th1.' AND MONTH(`tanggal_transaksi`) BETWEEN 7 AND 12) OR 
  							(YEAR(`tanggal_transaksi`)='.$th2.' AND MONTH(`tanggal_transaksi`) BETWEEN 1 AND 6)';
		$t_pen=$this->db->select('*,"terima" as status')->from('v_trans_detail_jenis')->where($whpen)->order_by('tanggal_transaksi asc')->get()->result();

		$whpeng=$wh.' and (YEAR(`tanggal_transaksi`)='.$th1.' AND MONTH(`tanggal_transaksi`) BETWEEN 7 AND 12) OR 
  							(YEAR(`tanggal_transaksi`)='.$th2.' AND MONTH(`tanggal_transaksi`) BETWEEN 1 AND 6)';
		$t_peng=$this->db->select('*,"keluar" as status, "-1" as nis, "-1" as id_jns')->from('v_transaksi_pengeluaran_detail')->where($whpeng)->order_by('tanggal_transaksi asc')->get()->result();


		$trans=array();
		// echo count($t_pen);
		foreach($t_pen as $k => $v)
		{
			if(is_null($v->kodeakun))
			{
				list($idakun,$kdakun,$ak_alt,$nmakun)=explode('_',$v->keterangan);
			}
			else
			{
				$kdd=explode('-',$v->kodeakun);
				$ak_alt=$kdd[0];
				$kdakun=$kdd[1];
			}
			$tahun=date('Y',strtotime($v->tanggal_transaksi));
			$bulan=date('n',strtotime($v->tanggal_transaksi));
			if(isset($kode_akun[$ak_alt]))
			{
				$kat=$kode_akun[$ak_alt]->kat;
				if($kode_akun[$ak_alt]->akun_alt_parent!='0')
				{
					$trans[$kat][$kode_akun[$ak_alt]->akun_alt_parent][$tahunajaran][]=$v->jumlah;
				}
				else
				{
					$trans[$kat]['sekolah'][$ak_alt][$tahunajaran][]=$v->jumlah;
				}
			}
		}
		foreach($t_peng as $k => $v)
		{
			$kd=strtok($v->keterangan,'-');
			$tahun=date('Y',strtotime($v->tanggal_transaksi));
			$bulan=date('n',strtotime($v->tanggal_transaksi));
			if(isset($kode_akun[$kd]))
			{
				$kat=$kode_akun[$kd]->kat;
				if($kode_akun[$kd]->akun_alt_parent!='0')
				{
					$trans[$kat][$kode_akun[$kd]->akun_alt_parent][$tahunajaran][]=$v->jumlah;
				}
				else
				{
					$trans[$kat][$kd][$tahunajaran][]=$v->jumlah;
				}
			}
			// echo $kd.'<br>';
		}
		// echo '<pre>';
		// print_r($trans);
		// echo '</pre>';
		$data['bulan_ta']=bulantahunajaran($tahunajaran);
		$data['date']=$date;
		$data['th1']=$th1;
		$data['th2']=$th2;
		$data['j_lap']=$j_lap;
		$data['trans']=$trans;
		$data['kode_akun']=$kode_akun;
		$data['tahunajaran']=$tahunajaran;
		$data['t_neraca_saldo']=$t_neraca_saldo;
		$data['tsaldoakun']=$tsaldoakun;
		$this->load->view('isi/laporan/laporanaktifitas-data',$data);
	}
	
	
	function neraca()
	{
		$data=array(
			'title' => 'Laporan Neraca',
			'isi' => 'isi/laporan/neraca-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}

	function neracadata($date,$jenis=null)
	{
		if($jenis==null)
		{
			$j_lap='Sekolah';
		}
		else
			$j_lap=$jenis;
		
		$kode_akun=array();
		$akun=$this->config->item('takun');
		$tsaldoakun=$this->config->item('tsaldoakun');
		$t_n_s=$this->config->item('t_neraca_saldo3');
		$neraca_saldo=$this->config->item('t_neraca_saldo');
		$t_neraca_saldo=$akun_neraca=array();
		{
			foreach($t_n_s as $k=>$v)
			{
				$t_neraca_saldo[$v->kategori][]=$v;
			}
		}
		foreach($akun as $k => $v)
		{
			$kode_akun[$v->akun_alternatif]=$v;
		}

		$ajaran=$this->config->item('tajaran');
		if($date==-1)
		{
			if(date('n')>=7 && date('n')<=12)
				$tahunajaran=date('Y').' / '.(date('Y') +1);
			else
				$tahunajaran=(date('Y') -1) .' / '.date('Y');
		}
		else
		{
			$tahunajaran=$ajaran[$date]->tahun_ajaran;
		}
		list($th1,$th2)=explode('/',str_replace(' / ','/',$tahunajaran));
		$th1=trim($th1);
		$th2=trim($th2);
		// echo $th1;
		
		$data['bulan_ta']=bulantahunajaran($tahunajaran);
		$data['date']=$date;
		$data['th1']=$th1;
		$data['th2']=$th2;
		$data['j_lap']=$j_lap;
		
		$data['kode_akun']=$kode_akun;
		$data['tahunajaran']=$tahunajaran;
		$data['t_neraca_saldo']=$t_neraca_saldo;
		$data['tsaldoakun']=$tsaldoakun;
		$data['neraca_saldo']=$neraca_saldo;
		$this->load->view('isi/laporan/neraca-data',$data);
	}

	function datapiutang()
	{
		$tahunajaran=$this->config->item('tajaran');
		$data=array(
			'title' => 'Data Piutang Siswa',
			'isi' => 'isi/laporan/piutang-index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer',
			'tahunajaran' => $tahunajaran
		);
		$this->load->view('index',$data);
	}

	function datapiutangsiswa($idta)
	{
		$tahunajaran=$this->config->item('tajaran');
		$piutang_all=$this->config->item('piutang_all');
		$piutang_ta=$this->config->item('piutang_ta');
		$tag_jenis=$this->config->item('tag_jenis');
		$nissiswa2=$this->config->item('nissiswa2');
		if($idta==0)
		{
			$ta=$data['ta']=array();
			$data['piutang']=$piutang_all;
		}	
		else
		{
			$ta=$data['ta']=$tahunajaran[$idta];
			$data['piutang']=$piutang_ta[$ta->tahun_ajaran];
		}
		$data['idta']=$idta;
		$data['tag_jenis']=$tag_jenis;
		$data['nissiswa2']=$nissiswa2;
		$this->load->view('isi/laporan/piutang-data',$data);
	}
}
