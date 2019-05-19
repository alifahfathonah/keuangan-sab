<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('Main.php');
class Transaksi extends Main {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('login')!='true')
		{
			redirect('login','location');
		}
	}
	public function penerimaan()
	{
		// $data['d']=$this->load->view('index.html');
		$siswa=$this->db->from('t_siswa')->where('status_tampil','t')->get()->result();
		$bank=$this->db->from('t_bank')->where('status_tampil','t')->get()->result();
		$jenis_pen=$d=$this->db->from('t_akun')
				// ->like('akun_alternatif', 'A', 'after')
				->where('status_tampil','t')->order_by('kode_akun')->get()->result();
		// $jenis_pen=$this->db->query('select * from t_akun where (akun_alternatif like "A%" or akun_alternatif like "J%" or akun_alternatif like "C%") and status_tampil="t" order by kode_akun')
		// 			->result();
		$data=array(
			'title' => 'Transaksi',
			'isi' => 'isi/transaksi/penerimaan-index',
			'navbar' => 'layout/navbar',
			'siswa' => $siswa,
			'bank' => $bank,
			'jenis' => $jenis_pen,
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
	}
//----------------------------------------------------------------------
	public function pengeluaran()
	{
		// $data['d']=$this->load->view('index.html');
		$jenis=$this->db->from('t_jenis_pengeluaran')->where('status_tampil','t')->get()->result();
		$bank=$this->db->from('t_bank')->where('status_tampil','t')->get()->result();
		$program=$this->db->from('t_program')->where('flag','1')->get()->result();
		$data=array(
			'title' => 'Transaksi',
			'isi' => 'isi/transaksi/pengeluaran-index',
			'jenis' => $jenis,
			'bank' => $bank,
			'program' => $program,
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);

		$this->load->view('index',$data);
	}
//----------------------------------------------------------------------
	function pengeluaranprocess()
	{
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';

		if(!empty($_POST))
		{
			$d=$_POST;
			list($tgl,$bl,$th)=explode('-', $d['tgltrans']);
			$tr['tanggal_transaksi']=$tglcair=($th.'-'.$bl.'-'.$tgl).' '.date('H:i:s');
			$tr['no_kwitansi']=$d['idt'];
			$tr['total']=str_replace(',', '', $d['total']);
			$tr['penyetor']=$this->session->userdata('namauser');
			$tr['penerima']=$d['peneriman'][0];
			$tr['status_transaksi']='2-Tunai';
			$tr['status_verifikasi']='f';
			$tr['status_tampil']='t';
			$this->db->insert('t_transaksi_pengeluaran',$tr);
			$idtr=$this->db->insert_id();
			// $idtr='';

			foreach ($d['jenis'] as $k => $v)
			{
				# code...
				
				list($idj,$jns,$kdakun)=explode('__', $v);
				$dtr['trans_id']=$idtr;
				$dtr['pengeluaran_id']=$idj;
				$dtr['jumlah']=str_replace(',', '', $d['jlh'][$k]);
				$dtr['keterangan']=$kdakun.'||'.$d['ket'][$k];
				$dtr['status_verifikasi_detail']='f';
				$dtr['bulan_tagihan']=date('n');
				$dtr['tahun_tagihan']=date('Y');
				$dtr['status_tampil_detail']='t';

				if(isset($d['program'][$k]))
				{
					$prg=$d['program'][$k];
					list($id_prg,$n_prg)=explode('__',$prg);
					$pencairan['id_trans']=$idtr;
					$pencairan['id_program']=$id_prg;
					$pencairan['program']=$n_prg;
					$pencairan['id_kegiatan']=$idj;
					$pencairan['kegiatan']=$jns;
					$pencairan['no_kwitansi']=$d['idt'];
					$pencairan['jumlah']=str_replace(',', '', $d['jlh'][$k]);
					$pencairan['tgl_pencairan']=$tglcair;
					$pencairan['created_at']=date('Y-m-d H:i:s');
					$pencairan['updated_at']=date('Y-m-d H:i:s');
					$this->db->insert('t_pencairan_program',$pencairan);
				}
				$this->db->insert('t_transaksi_pengeluaran_detail',$dtr);
			}
			$this->session->set_flashdata('pesan','Data Transaksi Pengeluaran Berhasil Di Simpan');
			// redirect('transaksi/pengeluaran','location');
			$bulan=date('n',strtotime($_POST['tgltrans']));
			$tahun=date('Y',strtotime($_POST['tgltrans']));
			$this->reloadall($bulan,$tahun,-1);
			// echo '<pre>';
			// print_r($_POST);
			// echo '</pre>';
		}
		else
			$this->session->set_flashdata('pesan','Data Transaksi Pengeluaran Gagal Di Simpan');
	}
	function pengeluaranbank()
	{
		if(!empty($_POST))
		{
			echo '<pre>';
			print_r($_POST);
			echo '</pre>';
			list($tgl,$bln,$thn)=explode('-', $_POST['tanggal_transaksi']);
			foreach ($_POST['bankasal'] as $k => $v)
			{
				$tr['tanggal_transaksi']=$thn.'-'.$bln.'-'.$tgl.' '.date('H:i:s');
				if($v!='')
				{
					list($idbank,$namabank)=explode('__', $v);
					list($idj,$jns)=explode('__', $_POST['jenis'][$k]);

					// $tr['tanggal_transaksi']=date('Y-m-d H:i:s');
					// $tr['no_kwitansi']=$d['idt'];
					$tr['total']=str_replace(',', '', $_POST['nominal'][$k]);
					$tr['penyetor']=$this->session->userdata('namauser');
					$tr['penerima']=$_POST['penerima'][$k];
					$tr['status_transaksi']='1-Bank';
					$tr['rek_bank']=$v;
					$tr['ref_bank']=$_POST['banktujuan'][$k];
					$tr['status_verifikasi']='f';
					$tr['ket']='Transfer Tagihan '.$jns.' kepada '.$tr['penerima'].' melalui '.$_POST['banktujuan'][$k].'';
					$tr['status_tampil']='t';
					$this->db->insert('t_transaksi_pengeluaran',$tr);
					$idtr=$this->db->insert_id();

					$dtr['trans_id']=$idtr;
					$dtr['pengeluaran_id']=$idj;
					$dtr['jumlah']=str_replace(',', '', $_POST['nominal'][$k]);
					$dtr['keterangan']=$_POST['keterangan'][$k];
					$dtr['status_verifikasi_detail']='f';
					$dtr['bulan_tagihan']=date('n');
					$dtr['tahun_tagihan']=date('Y');
					$dtr['status_tampil_detail']='t';
					$this->db->insert('t_transaksi_pengeluaran_detail',$dtr);

					$this->db->set('saldo','saldo-'.$dtr['jumlah'],false);
					$this->db->where('id_bank',$idbank);
					$this->db->update('t_bank');

					$rekkoran['id_bank']=$idbank;
					$rekkoran['nama_bank']=$namabank;
					$rekkoran['tanggal']=$tr['tanggal_transaksi'];
					$rekkoran['kat']='keluar';
					$rekkoran['keterangan']=$tr['ket'];
					$rekkoran['jumlah']=$dtr['jumlah'];
					$rekkoran['status_tampil']='t';
					$this->db->insert('t_bank_rekening_koran',$rekkoran);
				}
			}
			$bulan=date('n',strtotime($_POST['tanggal_transaksi']));
			$tahun=date('Y',strtotime($_POST['tanggal_transaksi']));
			$this->reloadall($bulan,$tahun,-1);
			$this->session->set_flashdata('pesan','Data Transaksi Pengeluaran Bank Berhasil Di Simpan');
			redirect('transaksi/pengeluaran','location');
		}
	}
//----------------------------------------------------------------------
	function process($id='2-Tunai')
	{
		//id=2-Tunai
		//id=1-Bank
		
		$bank=$this->config->item('d_bank');
		$j_penerimaan=$this->config->item('tpenerimaan');
		if(!empty($_POST))
		{
			$jnsp=$this->db->from('t_jenis_penerimaan')->get()->result();
			$jenisp=array();
			foreach($jnsp as $k => $v)
			{
				$jenisp[$v->id]=$v;
			}
		// echo '<pre>';
		// // print_r($_POST);
		// // print_r($_POST['siswaa']);
		// print_r($_POST['tagihanbank']);
		// echo '</pre>';
			$j=strtok($id,'-');
			if($j=='1')
			{
				$kd_trans=date('Ymd').'-01-'.abs(crc32(sha1(md5(rand()))));
				$tagihan=$this->config->item('ttagihanbybulan');
				$ttagihanbybulanclub=$this->config->item('ttagihanbybulanclub');
				
				$data['tanggal_transaksi']=$tgl=date('Y-m-d',strtotime($_POST['tanggal_transaksi'])).' '.date('H:i:s');
				foreach($_POST['siswaa'] as $k => $v)
				{
					if($v!='')
					{
						$v=str_replace('%20',' ',$v);
						list($id_siswa,$nis,$nama_sisws)=explode('__',$v);
						$nis=str_replace('.','_',$nis);
						$d_kelas=$_POST['dkelas'][$k];
						list($idajaran,$thn_ajaran)=explode('__',$d_kelas);
						$tagihan_bank=$_POST['tagihanbank'][$nis];

						$data['tahun_ajaran']=$thn_ajaran;
						$data['total']=$total=str_replace(',','',$_POST['nominal'][$k]);
						$data['status_transaksi']='1-Bank';
						$data['status_verifikasi']='f';
						$data['status_tampil']='t';
						$data['no_kwitansi']=$kd_trans;
						$data['nis']=$nis;
						$data['rek_bank']=$bank_tujuan=$_POST['banktujuan'][$k];
						$data['ref_bank']=$_POST['bankasal'][$k];
						$this->db->insert('t_transaksi',$data);
						$id_trans=$this->db->insert_id();

						if(isset($bank[$idbank]))
						{
							$idbank=strtok($bank_tujuan,'__');
							$jurnal_a['tanggal']=$tgl;
							$jurnal_a['kode_akun']=$bank[$idbank]->kode_akun;
							$jurnal_a['ref']=$kd_trans;
							$jurnal_a['keterangan']='Rekening Koran '.$bank[$idbank]->nama_bank.' ('.$bank[$idbank]->no_rekening.')';
							$jurnal_a['debit']=$total;
							$jurnal_a['kredit']=0;
							$jurnal_a['created_at']=date('Y-m-d H:i:s');
							$jurnal_a['updated_at']=date('Y-m-d H:i:s');
							$this->db->insert('t_jurnal',$jurnal_a);
						}
						// $id_trans='';
						// echo '<pre>';
						// print_r($data);
						// print_r($jenisp);
						// echo '</pre>';
						$det=$post_idclub=array();
						foreach($tagihan_bank as $kdet => $vdet)
						{
							list($idtagihan,$idjenis,$bulan,$tahun,$jumlah,$nis,$t_ajaran)=explode('__',$vdet);
							$urutanjenis=urutanjenis($jenisp[$idjenis]->jenis);
							$det[$urutanjenis][$tahun.'_'.$bulan]['trans_id']=$id_trans;
							$det[$urutanjenis][$tahun.'_'.$bulan]['penerimaan_id']=$idjenis;
							$det[$urutanjenis][$tahun.'_'.$bulan]['status_verifikasi_detail']='f';
							$det[$urutanjenis][$tahun.'_'.$bulan]['status_tampil_detail']='t';
							$det[$urutanjenis][$tahun.'_'.$bulan]['jumlah']=$jumlah;
							$det[$urutanjenis][$tahun.'_'.$bulan]['bulan_tagihan']=$bulan;
							$det[$urutanjenis][$tahun.'_'.$bulan]['tahun_tagihan']=$tahun;
							$det[$urutanjenis][$tahun.'_'.$bulan]['idtagihan']=$idtagihan;

							$post_idclub[$idtagihan]=$_POST['idclub'][$idtagihan];
							// if($idjenis==19)
							// {
							// 	$det[$urutanjenis][$tahun.'_'.$bulan]['idclub']=$_POST['idclub'][$idtagihan];
							// }
							// echo  $urutanjenis.'-'.$idjenis.'-'.$jenisp[$idjenis]->jenis.'<br>';					
						}

						$grand_total=$total;
						ksort($det);
						$sisa=$total;
						$sub=0;
						$tagihan_id=-1;
						// echo '<pre>';
						// print_r($det);
						// echo '</pre>';
						//echo '<br>'.$nis.' : '.$total.'<br>';
						foreach($det as $kdt => $vdet)
						{
							// echo $sisa.'-'.$vdt['jumlah'];
							// echo '='.$sisa.'<br>';
							$dt=array();
							foreach($vdet as $kdet => $vdt)
							{
								//echo $kdt.':'.$kdet.'<br>';
								$total=abs($total);
								$jlh=$vdt['jumlah'];
								
								if($total<$jlh)
								{
									$byr=$total;
								}
								else
									$byr=$jlh;
								
								// $sisa-=(int)$vdt['jumlah'];
								
								
								$dt['trans_id']=$vdt['trans_id'];
								$dt['penerimaan_id']=$idjenis_pen=$vdt['penerimaan_id'];
								$dt['status_verifikasi_detail']=$vdt['status_verifikasi_detail'];
								$dt['status_tampil_detail']=$vdt['status_tampil_detail'];
								$dt['jumlah']=$jumlah_jurnal=$vdt['jumlah'];
								$dt['bulan_tagihan']=$vdt['bulan_tagihan'];
								$dt['tahun_tagihan']=$vdt['tahun_tagihan'];
								// if($idjenis_pen==19)
								// {
								// 	$idtagihan=$vdt['idtagihan'];
								// 	$dt['club']=$_POST['idclub'][$idtagihan];
								// }

								//$dt['idtagihan']=$vdt['idtagihan'];
								
								$sisa-=$byr;
								// echo $total.'-'.$byr.' : '.$sisa.'<br>';
								$total-=$jlh;
								
								if($byr!=0)
								{
									if($byr<=$vdt['jumlah'])
									{
										$dt['jumlah']=$byr;
									}
									if($idjenis_pen==19)
									{
										foreach($post_idclub as $idx_club=>$val_club)
										{
											list($club_id,$jumlah_tagihan)=explode('__',$val_club);
											$dt['club']=$club_id;
											$dt['jumlah']=$jumlah_tagihan;
											$this->db->insert('t_transaksi_detail',$dt);

											if(isset($ttagihanbybulanclub[$nis][$thn_ajaran][$vdt['tahun_tagihan']][$vdt['bulan_tagihan']][$idjenis_pen][$club_id]))
											{
												$d_tag_club=$ttagihanbybulanclub[$nis][$thn_ajaran][$vdt['tahun_tagihan']][$vdt['bulan_tagihan']][$idjenis_pen][$club_id];
												$sisa_bayar_club=$d_tag_club->sisa_bayar;
												$id_tagihan_club=$idx_club;
												$dt_tg_club['sisa_bayar']=$sisa_bayar_club-$jumlah_tagihan;
												$this->db->where('id_tagihan',$id_tagihan_club);
												$this->db->update('t_tagihan_siswa',$dt_tg_club);
												// echo '<pre>';
												// print_r($dt);
												// print_r($dt_tg);
												// echo '</pre>';	
											}
										}
									}
									else
									{
										$this->db->insert('t_transaksi_detail',$dt);
									}

									if(isset($bank[$idbank]))
									{
										$kdak=explode('-',$j_penerimaan[$idjenis_pen]->kodeakun);
										$kd_akun_jurnal_b=$kdak[1];
										$jurnal_b['tanggal']=$tgl;
										$jurnal_b['kode_akun']=$kd_akun_jurnal_b;
										$jurnal_b['ref']=$kd_trans;
										$jurnal_b['keterangan']='Penerimaan '.$j_penerimaan[$idjenis_pen]->jenis.' a.n. '.$nama_sisws;
										$jurnal_b['debit']=0;
										$jurnal_b['kredit']=$byr;
										$jurnal_b['created_at']=date('Y-m-d H:i:s');
										$jurnal_b['updated_at']=date('Y-m-d H:i:s');
										$this->db->insert('t_jurnal',$jurnal_b);
									}
								}
								
								if(isset($tagihan[$nis][$thn_ajaran][$vdt['tahun_tagihan']][$vdt['bulan_tagihan']][$vdt['penerimaan_id']]))
								{
									$d_tag=$tagihan[$nis][$thn_ajaran][$vdt['tahun_tagihan']][$vdt['bulan_tagihan']][$vdt['penerimaan_id']];
									$sisa_bayar=$d_tag->sisa_bayar;
									$id_tagihan=$d_tag->id_tagihan;
									$dt_tg['sisa_bayar']=$sisa_bayar-$byr;
									$tagihan_id=$id_tagihan;
									$this->db->where('id_tagihan',$id_tagihan);
									$this->db->update('t_tagihan_siswa',$dt_tg);
									// echo '<pre>';
									// print_r($dt);
									// print_r($dt_tg);
									// echo '</pre>';	
								}
								
								
							}

							
						}
						if($sisa>0)
						{
							$dnl['id_siswa']=$id_siswa;
							$dnl['nis']=$nis;
							$dnl['dana_lebih']=$sisa;
							$dnl['trans_id']=$id_trans;
							$dnl['tagihan_id']=$tagihan_id;
							// echo 'dana lebih : '.$sisa.'<br>';
							// $this->db->insert('t_siswa_dana_lebih',$dnl);
						}
						//echo $nis.'<br>------';
							
					}
				}
				echo 1;
				//echo '<br>'.$data['total'];
			}
			else
			{
				$kd_trans=date('Ymd').'-02-'.abs(crc32(sha1(md5(rand()))));
				$tagihan=$this->config->item('tagihan');
				list($idajaran,$thn_ajaran)=explode('__',$_POST['dkelas']);
				list($idsiswa,$nis)=explode('__',$_POST['siswa']);
				
				// echo '<pre>';
				// print_r($tagihan[$nis][$thn_ajaran]);
				// echo '</pre>';
				$akun_kas=$this->db->from('t_akun')->where('nama_akun','Kas')->get()->row();
				// $data['tanggal_transaksi']=date('Y-m-d',strtotime($_POST['tanggal_transaksi']));
				$data['tanggal_transaksi']=$tgl=date('Y-m-d',strtotime($_POST['tanggal_transaksi'])).' '.date('H:i:s');
				$data['tahun_ajaran']=$thn_ajaran;
				$data['status_transaksi']='2-Tunai';
				$data['status_verifikasi']='f';
				$data['status_tampil']='t';
				$data['nis']=$nis;
				$data['no_kwitansi']=$kd_trans;
				$data['penyetor']=$_POST['penyetor'];
				$this->db->insert('t_transaksi',$data);
				$id_trans=$this->db->insert_id();

				$jurnal_a['tanggal']=$tgl;
				$jurnal_a['kode_akun']=akun_kas;
				$jurnal_a['ref']=$kd_trans;
				$jurnal_a['keterangan']='Kas';
				$jurnal_a['debit']=$total;
				$jurnal_a['kredit']=0;
				$jurnal_a['created_at']=date('Y-m-d H:i:s');
				$jurnal_a['updated_at']=date('Y-m-d H:i:s');
				$this->db->insert('t_jurnal',$jurnal_a);
				// $id_trans='';
				$total=0;
				foreach($_POST['transaksi'] as $k => $v)
				{
					list($idjenis,$jns)=explode('_',$k);
					foreach($v as $idx => $vdx)
					{
						if($vdx!=0)
						{
							// echo '<pre>';
							// print_r($v);
							// echo '</pre>';
							if($jns=='investasi')
							{
								$bulan=7;
								$tahun=$idx;
							}
							else
							{
								list($bulan,$tahun)=explode('_',$idx);
							}
							$nom=str_replace(',','',$vdx);
							$total+=$nom;
							$det['trans_id']=$id_trans;
							$det['penerimaan_id']=$idjenis;
							$det['status_verifikasi_detail']='f';
							$det['status_tampil_detail']='t';
							$det['jumlah']=$nom;
							$det['bulan_tagihan']=$bulan;
							$det['tahun_tagihan']=$tahun;
							$this->db->insert('t_transaksi_detail',$det);

							$kdak=explode('-',$j_penerimaan[$idjenis]->kodeakun);
							$kd_akun_jurnal_b=$kdak[1];
							$jurnal_b['tanggal']=$tgl;
							$jurnal_b['kode_akun']=$kd_akun_jurnal_b;
							$jurnal_b['ref']=$kd_trans;
							$jurnal_b['keterangan']='Penerimaan '.$j_penerimaan[$idjenis]->jenis.' a.n. '.$nama_sisws;
							$jurnal_b['debit']=0;
							$jurnal_b['kredit']=$nom;
							$jurnal_b['created_at']=date('Y-m-d H:i:s');
							$jurnal_b['updated_at']=date('Y-m-d H:i:s');
							$this->db->insert('t_jurnal',$jurnal_b);

							if(isset($tagihan[$nis][$thn_ajaran][$idjenis]))
							{
								$d_tag=$tagihan[$nis][$thn_ajaran][$idjenis][0];
								$sisa_bayar=$d_tag->sisa_bayar;
								$id_tagihan=$d_tag->id_tagihan;
								
								$dt_tg['sisa_bayar']=$sisa_bayar-$nom;
								$this->db->where('id_tagihan',$id_tagihan);
								$this->db->update('t_tagihan_siswa',$dt_tg);
								$tagihan_id=$id_tagihan;
								// echo $id_tagihan;
								// echo '<pre>';
								
								// print_r($det);
								// print_r($dt_tg);
								// echo '</pre>';
							}
						}
					}
					// foreach()
					//echo $id_trans;
					$up['total']=$total;
					$this->db->where('id_trans',$id_trans);
					$this->db->update('t_transaksi',$up);
				}
				// echo $total;
				// $data['total']=$total=str_replace(',','',$_POST['nominal'][$k]);
				echo 2;
			}

			$bulan=date('n',strtotime($_POST['tanggal_transaksi']));
			$tahun=date('Y',strtotime($_POST['tanggal_transaksi']));
			$this->reloadall($bulan,$tahun,-1);

		}
		else {
			echo -1;
		}

		// $jenisp=$this->config->item('tpenerimaan');
		
	}
	function tagihan($nis,$batch_id='null',$tr=-1)
	{
		$batch_id=str_replace('::', '/', $batch_id);
		$batch_id=str_replace('%20', ' ', $batch_id);
		list($idsiswa,$nis)=explode('__', $nis);
		$nis2=str_replace('.','_',$nis);
		$tagihan=$this->config->item('tagihan_jenis');
		$dtjn=$this->config->item('tpenerimaan');
		$nmjn=$this->config->item('jenispenerimaan');
		$datam=$this->config->item('tpendaftaran2');
		$potongan=$this->config->item('tpotongan2');
		$tahun_ajaran='2016 / 2017';
		$dd=['spp','catering','jemputan','jemputan_club','club','investasi'];
		$idajaran='';
		$data=array();
		// echo
		if(strpos($batch_id, '/')!==false)
		{
			list($idajaran,$tahun_ajaran)=explode('__', $batch_id);
			// $batch_id=$idajaran;
			// $tahun_ajaran=$
		}
		if(isset($tagihan[$nis][$tahun_ajaran]))
		{
			$d_tagihan=$tagihan[$nis][$tahun_ajaran];
		}
		else
		{
			$d_tagihan=array();
		}

		$data['jenis']=$dd;
		$data['batch_id']=$batch_id;
		$data['tagihan']=$d_tagihan;
		if($tr==0)
		{
			$ttagihanbybulan=$this->config->item('ttagihanbybulan');
			$ttagihanbybulanclub=$this->config->item('ttagihanbybulanclub');
			$tclub=$this->config->item('tclub');
			// echo '<pre>';
			// print_r($tagihan[$nis][$tahun_ajaran]['program_pembelajaran']);
			// echo '</pre>';

			if(isset($ttagihanbybulan[$nis][$tahun_ajaran]))
			{
				

				$data_tagihan=$ttagihanbybulan[$nis][$tahun_ajaran];
				foreach($data_tagihan as $kthn => $vthn)
				{
					
					foreach($vthn as $kbln => $vbln)
					{
						
					
						$subtotal=0;
						$s_b='';
						$txt='';
						foreach($vbln as $kjns => $vjns)
						{
							if($vjns->sisa_bayar>0)
							{
								$s_b='';
								// if(strtolower($vjns->jenis)!='program pembelajaran')
								// {
									// echo $kjns.'<br>';
									// $txt.='<input type="checkbox" >'.$vjns->jenis.' '.getBulanSingkat($vjns->bulan).' '.$vjns->tahun.'<br>';
									if($kjns==19)
									{
										if(isset($ttagihanbybulanclub[$nis][$tahun_ajaran][$kthn][$kbln][$kjns]))
										{
											// echo '<pre>';
											// print_r($ttagihanbybulanclub[$nis][$tahun_ajaran][$kthn]);
											// echo '</pre>';
											$tag_club=$ttagihanbybulanclub[$nis][$tahun_ajaran][$kthn][$kbln][$kjns];
											foreach($tag_club as $idx_c => $val_c)
											{
												// echo $idx_c.'-';
												if($idx_c!=0)
												{
													$nm_club=ucwords(strtolower($tclub[$idx_c]->nama_club));
												}
												else
												{
													$nm_club='';
												}
												$txt.='<div style="float:left;width:100%;margin-bottom:2px !important"><div style="width:5%;float:left;"><input type="checkbox" name="tagihanbank['.$nis2.'][]" value="'.$val_c->id_tagihan.'__'.$kjns.'__'.$val_c->bulan.'__'.$val_c->tahun.'__'.$val_c->sisa_bayar.'__'.$nis.'__'.$tahun_ajaran.'"></div><div style="width:35%;float:left;">&nbsp;&nbsp;Club '.$nm_club.'</div><div style="width:34%;float:left">'.getBulanSingkat($val_c->bulan).' '.$val_c->tahun.'</div><div style="width:26%;float:right;text-align:right"> '.number_format($val_c->sisa_bayar,0,',','.').'</div></div>';
												$subtotal+=$val_c->sisa_bayar;
												$s_b='1';
												$txt.= '<input type="hidden" name="idclub['.$val_c->id_tagihan.']" value="'.$idx_c.'__'.$val_c->sisa_bayar.'">';
											}
										}
									}
									else
									{

										if(strtolower($vjns->jenis)=='program pembelajaran')
											$t_jd='DU/Investasi';
										else
											$t_jd=$vjns->jenis;
										
										$txt.='<div style="float:left;width:100%;margin-bottom:2px !important"><div style="width:5%;float:left;"><input type="checkbox" name="tagihanbank['.$nis2.'][]" value="'.$vjns->id_tagihan.'__'.$kjns.'__'.$vjns->bulan.'__'.$vjns->tahun.'__'.$vjns->sisa_bayar.'__'.$nis.'__'.$tahun_ajaran.'"></div><div style="width:35%;float:left;">&nbsp;&nbsp;'.$t_jd.'</div><div style="width:34%;float:left">'.getBulanSingkat($vjns->bulan).' '.$vjns->tahun.'</div><div style="width:26%;float:right;text-align:right"> '.number_format($vjns->sisa_bayar,0,',','.').'</div></div>';
										$subtotal+=$vjns->sisa_bayar;
										$s_b='1';
									}
								// }
								// else
								// 	$txt='';
							}
							else
							{
								$txt.='';
							}

						}
						if($subtotal!=0)
						{
							// echo $subtotal.'-';
								$txt.='<div style="margin-bottom:10px;width:73%;float:left;text-align:right;padding-right:3px;font-weight:bold;padding-top:5px;border-bottom:1px solid #aaa;">SUB TOTAL</div><div style="margin-bottom:10px;width:26%;float:right;text-align:right;font-weight:bold;padding-top:5px;;border-bottom:1px solid #aaa;">'.number_format($subtotal,0,',','.').'</div>';
								// }
						}
						echo $txt;
							
					}
				}
			}
			else
			{
				echo 'Data Tagihan Belum Tersedia';
			}
		}
		else
			$this->load->view('isi/transaksi/tagihan-form',$data);


	}

	function rekap($trans,$waktu,$date=-1,$grafik=-1)
	{
		$data['jTrans']=$trans;
		$data['waktu']=$waktu;
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
			$data['penerimaan']='Penerimaan Harian';
			$wh=('tanggal_transaksi like "%'.($tanggal).'%"');
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
			$data['penerimaan']='Penerimaan Bulanan';
			$wh=array('month(tanggal_transaksi)'=>$bln , 'year(tanggal_transaksi)'=>$thn);
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
			$data['penerimaan']='Penerimaan Tahunan';
			$wh=array('year(tanggal_transaksi)'=>$thn);
		}

		if($trans=='penerimaan')
		{
			$siswa=$this->db->from('t_siswa')->where('status_tampil','t')->get()->result();
			$sis=array();
			foreach ($siswa as $ks => $vs)
			{
				$sis[str_replace('.','_',$vs->nis)]=$vs;
			}

			$batch=$this->db->from('v_batch_kelas')->where('status_tampil','t')->get()->result();
			$bt=array();
			foreach ($batch as $kb => $vb)
			{
				$bt[$vb->id_batch]=$vb;
			}
			$data['batch']=$bt;

			$trans=$this->db->from('v_transaksi_penerimaan')->where($wh)->where('(status_transaksi like "%2%" or status_transaksi like "%1%")')->order_by('tanggal_transaksi')->get()->result();
			$tr=$trdet=array();
			$total=$tot=array();
			foreach ($trans as $k => $v)
			{
				$nis=$v->nis.'__'.str_replace(' ', '_', $sis[str_replace('.','_',$v->nis)]->nama_murid).'__'.$v->batch_id;
				$date_tgl=strtok($v->tanggal_transaksi, ' ');
				$tr[$date_tgl][$nis][$v->penerimaan_id]=$v;
				$trdet[$date_tgl][$nis][$v->penerimaan_id][]=$v;

				$jns=$v->penerimaan_id.'__'.str_replace(' ', '_', $v->jenis);
				$total[$jns][]=$v->jumlah;
				// $tot[$jns][]=$v->jlh;
			}
			$data['trans']=$tr;
			$data['total']=$total;
			// $data['tot']=$tot;
			if($grafik==-1)
			{
				$data['trans']=$trdet;
				$this->load->view('isi/transaksi/rekap-data',$data);
			}
			else
			{
				$g=$color='';
				$totalpen=0;
				if(count($total)!=0)
				{
					$totalpen=0;
					foreach ($total as $k => $v)
					{
						// colors: ['red', 'orange', 'green', 'blue', 'purple', 'brown'],
						$color.='"orange",';
						list($idjenis,$jenisp)=explode('__', $k);
						$jenisp=str_replace('_',' ', $jenisp);

						// $dt[$idjenis][]=$v->jumlah_2;
						$jlh=array_sum($total[$k]);
						// $jenis[$k]=$jlh;
						// echo $k.'-'.$jlh.'<br>';
						$totalpen+=$jlh;
						$g.='["'.$jenisp.'", '.$jlh.'],';
					}

					// echo $total;

					// echo '<pre>';
					// print_r($dt);
					// echo '</pre>';
				}
				$data['color']=$color.'"blue"';
				$data['g']=$g.'["Total",'.$totalpen.']';
				$this->load->view('isi/transaksi/rekap-grafik',$data);
			}
		}
		else
		{
			$trans=$this->db->from('v_transaksi_pengeluaran_detail')->where($wh)->order_by('tanggal_transaksi')->get()->result();
			$tr=array();
			$total=array();
			foreach ($trans as $k => $v)
			{
				// $nis=$v->nis.'__'.str_replace(' ', '_', $sis[$v->nis]->nama_murid).'__'.$v->batch_id;
				$date_tgl=strtok($v->tanggal_transaksi, ' ');
				$tr[$date_tgl][$v->pengeluaran_id.'__'.$v->jenis][]=$v;

				$jns=$v->pengeluaran_id.'__'.str_replace(' ', '_', $v->jenis);
				$total[$jns][]=$v->jumlah;
			}
			$data['trans']=$tr;
			$data['total']=$total;

			if($grafik==-1)
				$this->load->view('isi/transaksi/rekap-data',$data);
			else
			{
				$g=$color='';
				$totalpen=0;
				if(count($total)!=0)
				{
					$totalpen=0;
					foreach ($total as $k => $v)
					{
						// colors: ['red', 'orange', 'green', 'blue', 'purple', 'brown'],
						$color.='"orange",';
						list($idjenis,$jenisp)=explode('__', $k);
						$jenisp=str_replace('_',' ', $jenisp);

						// $dt[$idjenis][]=$v->jumlah_2;
						$jlh=array_sum($total[$k]);
						// $jenis[$k]=$jlh;
						// echo $k.'-'.$jlh.'<br>';
						$totalpen+=$jlh;
						$g.='["'.$jenisp.'", '.$jlh.'],';
					}

					// echo $total;

					// echo '<pre>';
					// print_r($dt);
					// echo '</pre>';
				}
				$data['color']=$color.'"blue"';
				$data['g']=$g.'["Total",'.$totalpen.']';
				$this->load->view('isi/transaksi/rekap-grafik',$data);
			}
		}
	}
	function cetakkwitansi($nokwitansi=null)
	{
		// $data['nokwitansi']=$nokwitansi;
		$p=$this->config->item('v_pen');
		$s=$this->config->item('nissiswa');
		// $pen=$p[$nokwitansi];
		// $data['pen']=$pen;
		$data['siswa']=$s;
		$this->load->view('isi/transaksi/kwitansi',$data);
	}

	function penerimaanlainprocess()
	{
		if(!empty($_POST))
		{
			// echo '<pre>';
			// print_r($_POST);
			// echo '</pre>';
			
			$data['tanggal_transaksi']=date('Y-m-d',strtotime($_POST['tgltrans']));
			foreach($_POST['jenis'] as $k => $v)
			{
				$data['total']=str_replace(',','',$_POST['jlh'][$k]);
				$data['ket']=$_POST['ket'][$k];
				$data['status_transaksi']='3-Lainnya';
				$data['status_verifikasi']='f';
				$data['status_tampil']='t';

				$this->db->insert('t_transaksi',$data);
				$id_trans=$this->db->insert_id();

				list($idakun,$kdakun,$kdakunalt,$nmakun)=explode('_',$_POST['jenis'][$k]);

				$det['trans_id']=$id_trans;
				$det['penerimaan_id']=$kdakunalt;
				$det['jumlah']=str_replace(',','',$_POST['jlh'][$k]);
				$det['keterangan']=$_POST['jenis'][$k];
				$det['status_verifikasi_detail']='f';
				$det['status_tampil_detail']='t';

				$this->db->insert('t_transaksi_detail',$det);
			}

			echo 1;
		}
		else
			echo 0;
	}

	function presentase($waktu,$date=-1)
	{
		$vbatch=$this->config->item('vbatchkelas');
		$lv=array(
			'prasekolah'=>array('pg','tk'),
			'sd'=>array('sd'),
			'sm'=>array('sm')
		);
		$durasi=array('1-10','11-20','21-31');
		$kelas=array();
		foreach($vbatch as $k =>$v)
		{
			$kelas[$v->kategori][]=$v;
		}
		$data['kelas']=$kelas;
		$data['durasi']=$durasi;
		$data['lv']=$lv;
		$data['waktu']=$waktu;
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
			$data['judul']='Presentase Pembayaran Harian';
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
			$data['judul']='Presentase Pembayaran Bulanan';
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
			$data['judul']='Presentase Pembayaran Tahunan';
		}
		$this->load->view('isi/transaksi/presentasi-pembayaran',$data);
	}

	function cekpenggunaandana($id,$tgl)
	{
		//2__Reward%20tahunan%20tabungan%20siswa__B303-63300-kesekretariatan
		//1__Pencetakan%20buku%20tabungan%20baru__-30000-Pengeluaran%20Non%20sekolah
		//06-05-2018
		list($tg,$bl,$th)=explode('-',$tgl);
		$id=str_replace('%20',' ',$id);
		$id_val=explode('__',$id);
		$id_kegiatan=$id_val[0];
		$kegiatan=$id_val[1];
		list($ak_alt,$kd_akun,$nm_akun)=explode('-',$id_val[2]);
		
		$kegiatan=$this->db->from('t_kegiatan')->where('id',$id_kegiatan)->get()->result();
		$keg_id=$kegiatan[0]->id.'::'.$kegiatan[0]->kegiatan;
		$rab=$this->db->from('t_rab')
				->like('kegiatan',$keg_id)
				->where('bulan',$bl)
				->where('tahun',$th)
				->get()->result();

		$nominal=(count($rab)!=0 ? $rab[0]->anggaran : 0);

		// $trans=$this->db->from('v_transaksi_pengeluaran_detail')->where($wh)->order_by('tanggal_transaksi')->get()->result();
		// $tr=array();

		$limit=0;

		echo number_format($nominal,0,'.',',').'__'.number_format($limit,0,'.',',');
	}
}
