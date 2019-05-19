<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('Main.php');
class Transaksi extends Main {

	public function penerimaan()
	{
		// $data['d']=$this->load->view('index.html');
		$siswa=$this->db->from('t_siswa')->where('status_tampil','t')->get()->result();
		$bank=$this->db->from('t_bank')->where('status_tampil','t')->get()->result();
		$data=array(
			'title' => 'Transaksi',
			'isi' => 'isi/transaksi/penerimaan-index',
			'navbar' => 'layout/navbar',
			'siswa' => $siswa,
			'bank' => $bank,
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
		$data=array(
			'title' => 'Transaksi',
			'isi' => 'isi/transaksi/pengeluaran-index',
			'jenis' => $jenis,
			'bank' => $bank,
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
			$tr['tanggal_transaksi']=($th.'-'.$bl.'-'.$tgl).' '.date('H:i:s');
			$tr['no_kwitansi']=$d['idt'];
			$tr['total']=str_replace(',', '', $d['total']);
			$tr['penyetor']=$this->session->userdata('namauser');
			$tr['penerima']=$d['peneriman'][0];
			$tr['status_transaksi']='2-Tunai';
			$tr['status_verifikasi']='f';
			$tr['status_tampil']='t';
			$this->db->insert('t_transaksi_pengeluaran',$tr);
			$idtr=$this->db->insert_id();

			foreach ($d['jenis'] as $k => $v)
			{
				# code...
				list($idj,$jns)=explode('__', $v);
				$dtr['trans_id']=$idtr;
				$dtr['pengeluaran_id']=$idj;
				$dtr['jumlah']=str_replace(',', '', $d['jlh'][$k]);
				$dtr['keterangan']=$d['ket'][$k];
				$dtr['status_verifikasi_detail']='f';
				$dtr['bulan_tagihan']=date('n');
				$dtr['tahun_tagihan']=date('Y');
				$dtr['status_tampil_detail']='t';
				$this->db->insert('t_transaksi_pengeluaran_detail',$dtr);
			}
			$this->session->set_flashdata('pesan','Data Transaksi Pengeluaran Berhasil Di Simpan');
			// redirect('transaksi/pengeluaran','location');
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
			$this->session->set_flashdata('pesan','Data Transaksi Pengeluaran Bank Berhasil Di Simpan');
			redirect('transaksi/pengeluaran','location');
		}
	}
//----------------------------------------------------------------------
	function process($id=-1)
	{
		//id=2-Tunai
		//id=1-Bank
		$bacthkelas=$this->config->item('vbatchkelas');
		if(!empty($_POST))
		{
			$club=$this->config->item('tclub');
			$jenisp=$this->config->item('tpenerimaan');

			$dt=$_POST;
			$update=array();
			list($tgl,$bln,$thn)=explode('-', $_POST['tanggal_transaksi']);
			if(strtok($id,'-')==1)
			{
				$d['tanggal_transaksi']=$thn.'-'.$bln.'-'.$tgl.' '.date('H:i:s');
				foreach ($_POST['siswaa'] as $k => $v)
				{
					if($v!='')
					{
						$v=str_replace('%20', ' ', $v);
						list($idsiswa,$nis,$nama)=explode('__', $v);
						$dkls=explode('__', $dt['dkelas'][$k]);
						if(count($dkls)<=2)
						{
							$idajaran=$dkls[0];
							$thnajaran=$dkls[1];
							$idkelassiswa='';
							$batch_id='';
							$nama_kelas='';
							$kat='';
						}
						else
						{
							$idkelassiswa=$dkls[0];
							$batch_id=$dkls[1];
							$nama_kelas=$dkls[2];
							$kat=$dkls[3];
							$vbk=$bacthkelas[$batch_id];
							$idajaran='';
							$thnajaran=$vbk->tahun_ajaran;
						}
						$d['no_kwitansi']=$nokwitansi='1-'.date('Ymd').substr(generate_id(),0,4);
						$d['total']=$total=str_replace(',', '', $dt['nominal'][$k]);

						$d['batch_id']=$up['batch_id']=$batch_id;
						$d['nis']=$up['nis']=$nis;
						$d['penerima']=$this->session->userdata('nama');
						$d['status_transaksi']=$id;
						$d['status_verifikasi']='f';
						$d['status_tampil']='t';
						$d['ref_bank']=$dt['banktujuan'][$k];
						$d['rek_bank']=$dt['bankasal'][$k];
						list($idref,$ref)=explode('__', $dt['banktujuan'][$k]);

						$d['tahun_ajaran']=$thnajaran;

						$this->db->set('saldo','saldo+'.$total,false);
						$this->db->where('id_bank',$idref);
						$this->db->update('t_bank');

						$rekkoran['id_bank']=$idref;
						$rekkoran['nama_bank']=$ref;
						$rekkoran['tanggal']=$d['tanggal_transaksi'];
						$rekkoran['kat']='masuk';
						$rekkoran['keterangan']='Pembayaran Tagihan Siswa a.n. '.$nama;
						$rekkoran['jumlah']=$total;
						$rekkoran['status_tampil']='t';
						$this->db->insert('t_bank_rekening_koran',$rekkoran);


						$this->db->insert('t_transaksi',$d);
						$trans_id=$this->db->insert_id();
						$dd['trans_id']=$trans_id;

						$tagihan=$dt['tagihanbank'][$nis];
						foreach ($tagihan as $kt => $vt)
						{
							
								list($idjenis,$bulan_tagihan,$tahun_tagihan,$jumlahbayar,$nnis,$bbatch_id,$ket)=explode('__', $vt);
								$dd['penerimaan_id']=$up['id_jenis_penerimaan']=$idjenis;
								$dd['jumlah']=$jumlahbayar;
								if($ket=='kosong')
									$dd['club']=$keter='';
								else
								{
									$c=str_replace('id_club:', '', $ket);
									$idclub=strtok($c, '_');
									$cl=str_replace($idclub.'_', $idclub.'__', $c);
									$dd['club']=$cl;
									$keter='id_club:'.$cl;
								}
								$dd['bulan_tagihan']=$up['bulan']=$bulan_tagihan;
								$dd['tahun_tagihan']=$up['tahun']=$tahun_tagihan;
								$dd['status_verifikasi_detail']='f';
								$dd['status_tampil_detail']='t';
								$up['keterangan']=$keter;
								$up['jenis']=$jenis=$jenisp[$idjenis]->jenis;
								$up['idjenis']=$idjenis;
								$up['jumlah']=$jumlahbayar;
								$up['tahun_ajaran']=$thnajaran;
								$updt=$up;
								$urutanjenis=urutanjenis($jenisp[$idjenis]->jenis);
								
								$this->db->insert('t_transaksi_detail',$dd);
								$iddet=$this->db->insert_id();
								$update_tr_det[$trans_id][$nis][$jenis][$tahun_tagihan][$bulan_tagihan]=$iddet;
								$update[$nis][$urutanjenis]=$up;
						
						}
						ksort($update[$nis]);
						
						$pendaftaran=$this->config->item('tpendaftaran3');
						

						$sisa=$total;
						$tagihan_id='';
						foreach ($update[$nis] as $ku => $vu)
						{
						
							$jlh=$vu['jumlah'];
							$jen=$vu['jenis'];
							$idjn=$vu['idjenis'];


							// echo $total.'<pre>';
							// print_r($vu);
							// echo  '</pre>';

							$total=abs($total);
							if($total<$jlh)
							{
								$jlhbayar=$jlh-$total;
							}
							else
								$jlhbayar=$jlh;

							$total-=$jlh;
							$sisa-=$jlhbayar;
							unset($vu['jumlah']);
							unset($vu['jenis']);
							unset($vu['idjenis']);

						
						// 	//-----------------------
							$id_tr_det=$update_tr_det[$trans_id][$nis][$jen][$vu['tahun']][$vu['bulan']];
							$this->db->set('jumlah',$jlhbayar);
							$this->db->where('id',$id_tr_det);
							$this->db->update('t_transaksi_detail');
						// 	//-----------------------
							// $wh='nis="'.$nis.'" and (jenis like "'.$jen.'" or id_jenis_penerimaan="'.$idjn.'") and bulan="'.$vu['bulan'].'" and tahun="'.$vu['tahun'].'" and (batch_id="'.$batch_id.'" or tahun_ajaran like "'.$thnajaran.'")';
							$wh='nis="'.$nis.'" and (id_jenis_penerimaan="'.$idjn.'") and bulan="'.$vu['bulan'].'" and tahun="'.$vu['tahun'].'" and (batch_id="'.$batch_id.'" or tahun_ajaran like "'.$thnajaran.'")';
							$idtagihan=$this->db->from('v_tagihan_siswa')->where($wh)->get()->result();
							$tagihan_id=$idtagihan[0]->id_tagihan;
							$this->mm->updatetagihan(array('id_tagihan'=>$tagihan_id),$jlhbayar);
						}
						
						if($sisa>0)
						{
							$dnl['id_siswa']=$idsiswa;
							$dnl['nis']=$nis;
							$dnl['dana_lebih']=$sisa;
							$dnl['trans_id']=$trans_id;
							$dnl['tagihan_id']=$trans_id;
							$this->db->insert('t_siswa_dana_lebih',$dnl);
						}
					}
				}
				// $this->session->set_flashdata('pesan','Data Transaksi Bank Berhasil Di Simpan');
				// redirect('transaksi/penerimaan','location');
			}
			else
			{

				// list($idbatchsiswa,$batch_id,$nama_kelas,$kategori)=explode('__', $_POST['dkelas']);
				$dkls=explode('__', $_POST['dkelas']);
				if(count($dkls)<=2)
				{
					$idajaran=$dkls[0];
					$thnajaran=$dkls[1];
					$idkelassiswa='';
					$batch_id='';
					$nama_kelas='';
					$kat='';
				}
				else
				{
					$idkelassiswa=$dkls[0];
					$batch_id=$dkls[1];
					$nama_kelas=$dkls[2];
					$kat=$dkls[3];
					$vbk=$bacthkelas[$batch_id];
					$idajaran='';
					$thnajaran=$vbk->tahun_ajaran;
				}

				list($idsiswa,$nis)=explode('__', $_POST['siswa']);

				$d['tanggal_transaksi']=$thn.'-'.$bln.'-'.$tgl.' '.date('H:i:s');
				$d['no_kwitansi']=$nokwitansi='2-'.date('Ymd').substr(generate_id(),0,4);
				$d['penyetor']=$_POST['penyetor'];
				$d['penerima']=$this->session->userdata('nama');
				$d['batch_id']=$up['batch_id']=$batch_id;
				$d['nis']=$up['nis']=$nis;
				$d['status_transaksi']=$id;
				$d['tahun_ajaran']=$thnajaran;
				$d['status_verifikasi']='f';
				$d['status_tampil']='t';

				$this->db->insert('t_transaksi',$d);
				$idtrans=$this->db->insert_id();
				$dd['trans_id']=$idtrans;
				echo '<pre>';
				print_r($_POST['transaksi']);
				echo '</pre>';
				foreach ($_POST['transaksi'] as $k => $v)
				{
					$dd['penerimaan_id']=$up['id_jenis_penerimaan']=$k;
					$jenis_pen=$this->config->item('tpenerimaan');
					if(isset($jenis_pen[$k]))
					{
						$jen=$jenis_pen[$k]->jenis;
					}
					else
					{
						$jen='';
					}

					// echo $k.'<pre>';
					// print_r($v);
					// echo '</pre>';
					foreach ($v as $kv => $vv)
					{
						if(strpos($kv,'_')!==false)
						{
							list($bln_tagihan,$thn_tagihan)=explode('_', $kv);

							$dd['bulan_tagihan']=$up['bulan']=$bln_tagihan;
							$dd['tahun_tagihan']=$up['tahun']=$thn_tagihan;
							$dd['status_verifikasi_detail']='f';
							$dd['status_tampil_detail']='t';

							// echo '<pre>';
							// print_r($vv);
							// echo '</pre>';

							if(count($vv)==1)
							{
								$idx=key($vv);
								if($vv[$idx]!='')
								{
									if($idx!=0)
										$dd['club']=$idx;
									else
										$dd['club']='';

									$dd['jumlah']=$jumlah=str_replace(',','',$vv[$idx]);

									$wh='nis="'.$nis.'" and (jenis like "'.$jen.'" or id_jenis_penerimaan="'.$k.'") and bulan="'.$bln_tagihan.'" and tahun="'.$thn_tagihan.'" and (batch_id="'.$batch_id.'" or tahun_ajaran like "'.$thnajaran.'")';
									$idtagihan=$this->db->from('v_tagihan_siswa')->where($wh)->get()->result();
									$tagihan_id=$idtagihan[0]->id_tagihan;
									$this->db->insert('t_transaksi_detail',$dd);
									$this->mm->updatetagihan(array('id_tagihan'=>$tagihan_id),$jumlah);
									// $this->mm->updatetagihan($up,$jumlah);
								}
							}
							else
							{
								foreach ($vv as $kno => $vnom)
								{
									if($vnom!='')
									{
										$dd['club']=$kno;
										$dd['jumlah']=$jumlah=str_replace(',','',$vnom);
										$this->db->insert('t_transaksi_detail',$dd);
										$up['keterangan']='id_club:'.$kno;
										$this->mm->updatetagihan($up,$jumlah);
									}
								}
							}
						}
					}
				}
				// echo 'Data Transaksi berhasil Di Simpan';
				// $this->session->set_flashdata('pesan','Data Transaksi Berhasil Di Simpan');
				// redirect('transaksi/penerimaan','location');
			}
			echo $nokwitansi;
		}
		else {
			echo -1;
		}
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
	}
	function tagihan($nis,$batch_id='null',$tr=-1)
	{
		$batch_id=str_replace('::', '/', $batch_id);
		$batch_id=str_replace('%20', ' ', $batch_id);
		list($idsiswa,$nis)=explode('__', $nis);
		$tagihanjns=$this->config->item('tagihan_jenis');
		$dtjn=$this->config->item('tpenerimaan');
		$nmjn=$this->config->item('jenispenerimaan');
		$datam=$this->config->item('tpendaftaran2');
		$potongan=$this->config->item('tpotongan2');
		$tahun_ajaran='2016 / 2017';
		$idajaran='';
		$data=array();
		// echo
		$d_tagihan=array();
		if(strpos($batch_id, '/')!==false)
		{
			list($idajaran,$tahun_ajaran)=explode('__', $batch_id);
			// $batch_id=$idajaran;
			// $tahun_ajaran=$
		}

		$dpot=array();
		if(isset($potongan[$tahun_ajaran][$nis]))
			$dpot=$potongan[$tahun_ajaran][$nis];

		// if($batch_id=='null' || strpos($batch_id, '/')!==false)
		// {
		// 	// echo $tahun_ajaran;
		// 	$d=$jenis=array();

		// 	if(isset($datam[$tahun_ajaran][$idsiswa]))
		// 	{
		// 		$d=$datam[$tahun_ajaran][$idsiswa];
		// 		$jip=explode(',', $d->id_penerimaan);
		// 		echo '<pre>';
		// 		print_r($d);
		// 		echo '</pre>';
		// 		$jp=explode(',', $d->jenis_penerimaan);
		// 		$jlp=explode(',', $d->jumlah);
		// 		$jenis=array();
		// 		foreach ($jip as $k => $v)
		// 		{
		// 			// if(isset($dpot['Investasi']))
		// 			// {
		// 			if(strpos($jp[$k], 'Investasi')!==false)
		// 				$jenis[$v]=$jp[$k];
		// 			// }
		// 			else
		// 				$jenis[$v]=$jp[$k];
		// 		}
		// 		$d_tagihan=array();
		// 		$dt_tagihan=array();

		// 		$wh=array('id_siswa'=>$idsiswa,'tahun_ajaran'=>$tahun_ajaran,'sisa_bayar!='=>0);
		// 		$tagihan=$this->db->from('t_tagihan_siswa')->where($wh)->order_by('(tahun * 1) asc, (bulan*1) asc')->get()->result();
		// 		foreach ($tagihan as $kt => $vt)
		// 		{
		// 			$d_tagihan[$vt->tahun][$vt->id_jenis_penerimaan][$vt->bulan][]=$vt;
		// 			$dt_tagihan[$vt->tahun.'__'.$vt->bulan][$vt->id_jenis_penerimaan][]=$vt;
		// 		}
		// 		$data=array(
		// 			'nis' => $nis,
		// 			'batch_id' => '',
		// 			'jenis' => $jenis,
		// 			'tagihan' => $d_tagihan,
		// 			'potongan' => $dpot,
		// 			'tahun_ajaran' => $tahun_ajaran
		// 		);
		// 	}

		// }

		// else
		// {
			// echo $batch_id;
			// $tahun_ajaran='2016 / 2017';

			
			$dt_tagihan=array();
			$jenis=array();
			$jlhinves=0;
			$jlhinvesarr=array();
			$jlhinvestxt='';
			$jlhinvesinves=0;
			/*
				bikin $jlhinvesarr baru disini
			*/
			if(isset($datam[$tahun_ajaran][$idsiswa]))
			{
				$d=$datam[$tahun_ajaran][$idsiswa];
				$jip=explode(',', $d->id_penerimaan);
				$jp=explode(',', $d->jenis_penerimaan);
				$jlp=explode(',', $d->jumlah);

				foreach ($jip as $k => $v)
				{
					// if(isset($dpot['Investasi']))
					// {
					// 	if(strpos($jp[$k], 'Investasi')!==false)
					// 		$jenis[$v]=$jp[$k];
					// // }
					// else
					// 	$jenis[$v]=$jp[$k];
						// echo $v.'-';
					$jlhinves+=$jlp[$k];
					$thnn=strtok($tahun_ajaran,'/');
					$jlhinvesarr[$v]=$jlp[$k];
					if($dtjn[$v]->jenis!='SPP')
					{
						if(isset($tagihanjns[$nis][$tahun_ajaran][$v]))
						{
							$tgj=$tagihanjns[$nis][$tahun_ajaran][$v];
							// echo '<pre>';
							// print_r($tgj);
							// echo '</pre>';
							if($tgj->sisa_bayar>0)
							{
								// $jlhinvestxt=$tgj->jenis.'-'.$tgj->sisa_bayar.'<br>';
								$jlhinvestxt.='<div style="float:left;width:100%;margin-bottom:2px !important">
								<div style="width:5%;float:left;"><input type="checkbox" name="tagihanbank['.$nis.'][]" value="'.$v.'__7__'.$thnn.'__'.$tgj->sisa_bayar.'__'.$nis.'__'.strtok($batch_id,'__').'__kosong"></div><div style="width:35%;float:left;">&nbsp;&nbsp;'.$dtjn[$v]->jenis.'</div><div style="width:34%;float:left">'.$thnn.'</div><div style="width:26%;float:right;text-align:right"> '.number_format($tgj->sisa_bayar).'</div></div>';
								$jlhinvesinves+=$tgj->sisa_bayar;
							}
						}
						else
						{

							$jlhinvestxt.='<div style="float:left;width:100%;margin-bottom:2px !important">
							<div style="width:5%;float:left;"><input type="checkbox" name="tagihanbank['.$nis.'][]" value="'.$v.'__7__'.$thnn.'__'.$jlp[$k].'__'.$nis.'__'.strtok($batch_id,'__').'__kosong"></div><div style="width:35%;float:left;">&nbsp;&nbsp;'.$dtjn[$v]->jenis.'</div><div style="width:34%;float:left">'.$thnn.'</div><div style="width:26%;float:right;text-align:right"> '.number_format($jlp[$k]).'</div></div>';
							$jlhinvesinves+=$jlp[$k];
						}
					}
				}
					
				$wh=array('id_siswa'=>$idsiswa,'tahun_ajaran'=>$tahun_ajaran,'sisa_bayar!='=>0);
				$tagihan=$this->db->from('t_tagihan_siswa')->where($wh)->order_by('(tahun * 1) asc, (bulan*1) asc')->get()->result();
				foreach ($tagihan as $kt => $vt)
				{
					$d_tagihan[$vt->tahun][$vt->id_jenis_penerimaan][$vt->bulan][]=$vt;
					$dt_tagihan[$vt->tahun.'__'.$vt->bulan][$vt->id_jenis_penerimaan][]=$vt;
				}
				$dataa=array(
					'nis' => $nis,
					'batch_id' => '',
					'jenis' => $jenis,
					'tagihan' => $d_tagihan,
					'potongan' => $dpot,
					'tahun_ajaran' => $tahun_ajaran
				);
			}

			$batch_id=str_replace('%20', ' ', $batch_id);
			// list($idbatchkelas,$batch_id,$nama_kelas,$kategori)=explode('__', $batch_id);
			list($batch_id,$thn_aj)=explode('__', $batch_id);
			$wh=array('nis'=>$nis,'batch_id'=>$batch_id,'sisa_bayar!='=>0);
			$tagihan=$this->db->from('t_tagihan_siswa')->where($wh)->order_by('(tahun * 1) asc, (bulan*1) asc')->get()->result();

			// $where='(level="'.$kategori.'" OR level="all" OR jenis like "investasi") and id_parent=0 and jenis not like "biaya seleksi"';
			$where='id_parent=0 and jenis not like "biaya seleksi"';
			$jenis_penerimaan=$this->db->from('t_jenis_penerimaan')->where($where)->where('status_tampil','t')->group_by('jenis')->order_by('jenis')->get()->result();

			// $jenis=array();
			foreach ($jenis_penerimaan as $kj => $vj)
			{
				$jenis[$vj->id]=$vj;
			}
			// $d_tagihan=array();
			// $dt_tagihan=array();
			foreach ($tagihan as $kt => $vt)
			{
				$d_tagihan[$vt->tahun][$vt->id_jenis_penerimaan][$vt->bulan][]=$vt;
				$dt_tagihan[$vt->tahun.'__'.$vt->bulan][$vt->id_jenis_penerimaan][]=$vt;
			}

			$data=array(
				'nis' => $nis,
				'batch_id' => $batch_id,
				'jenis' => $jenis,
				'tagihan' => $d_tagihan,
				'potongan' => $dpot,
				'tahun_ajaran' => $tahun_ajaran,
				'jlhinvesarr'=>$jlhinvesarr
			);



		// }
			// echo '<pre>';
			// print_r($potongan[$tahun_ajaran][$nis]);
			// echo '</pre>';
			// $datapot=$potongan[$tahun_ajaran][$nis];
			// echo '<pre>';
			// print_r($datapot);
			// echo '</pre>';
			$subtinves=0;
			if($tr==0)
			{
				$tagih='';
				// echo '<pre>';
				// print_r($tagihan);
				// echo '</pre>';
				if(count($d_tagihan)!=0)
				{

					if(strpos($batch_id, '/')!==false)
					{
						list($idajaran,$tahun_ajaran)=explode('__', $batch_id);
						$batch_id=$idajaran;
						// $tahun_ajaran=$
					}
					foreach ($dt_tagihan as $thn_bulan => $vt)
					{
						list($tahun,$bulan)=explode('__', $thn_bulan);
						asort($vt);
						$subtotal=0;
						$djinves=array();
						$tg='';
						foreach ($vt as $idjenis => $vb)
						{
							if($batch_id=='null' || strpos($batch_id, '/')!==false)
							{
								$jenis_p=$jenis[$idjenis];
								foreach ($vb as $kv => $vv) {
									# code...
									//echo  $vv->bulan;
									if(strpos($vv->keterangan, 'id_club')!==false)
										$ket=str_replace('__', '_', $vv->keterangan);
									else
										$ket='kosong';

									if(strtolower($jenis_p)!='spp')
									{
										$we=' : '.$vv->tahun;
									}
									else
									{
										$we=' : '.getBulanSingkat($vv->bulan).' \''.substr($vv->tahun, 2,2);
									}

									$jns_p=$jenis_p;
									$jenis_p=strtok($jenis_p, ' ');
									$sisa_bayar=0;
									if(isset($datapot[$jenis_p]))
									{
										if($datapot[$jenis_p]->persen==0)
										{
											// $sisa_bayar=$vv->sisa_bayar - ($datapot[$jenis_p]->persen/100 * $vv->sisa_bayar);
											$sisa_bayar=$datapot[$jenis_p]->biaya;
										}
										// else
										// {
										// }
									}
									else
									{
										$sisa_bayar=$vv->sisa_bayar;
									}

									$tagih.='<div style="float:left;width:100%;margin-bottom:2px !important"><div style="width:5%;float:left;"><input type="checkbox" name="tagihanbank['.$nis.'][]" value="'.$idjenis.'__'.$bulan.'__'.$tahun.'__'.$sisa_bayar.'__'.$nis.'__'.$batch_id.'__'.$ket.'"></div><div style="width:35%;float:left;">&nbsp;&nbsp;'.$jns_p.'</div><div style="width:34%;float:left">'.$we.'</div><div style="width:26%;float:right;text-align:right"> '.number_format($sisa_bayar).'</div></div>';
									$subtotal+=$sisa_bayar;
								}
							}
							else
							{
								// echo '<pre>';
								// print_r($jenis);
								// echo '</pre>';
								//echo $vv->bulan.'-';
								$ada=0;
								if(is_object($jenis))
								{
									if(isset($jenis[$idjenis]->jenis))
									{
										$jenis_p=$jenis[$idjenis]->jenis;
										$ada=1;
									}
								}
								else
								{
									if(isset($jenis[$idjenis]))
									{
										
										if(is_object($jenis[$idjenis]))
										{
											$jenis_p=$jenis[$idjenis]->jenis;
											$ada=1;
											// echo '<pre>';
											// print_r($jenis_p);
											// echo '</pre>';
										}
										else
										{
											$jenis_p=$jenis[$idjenis];
											$ada=1;
										}
									}
									else
									{
										
										// echo '<pre>';
										// print_r($jlhinvesarr);
										// echo '</pre>';
										$ada=2;
										//echo '<br>';
									}
								}

								if($ada==1)
								{
									
									// echo '<pre>';
									// print_r($vb);
									// echo '</pre>';
									$idtg=0;
									$subtinves=0;
									foreach ($vb as $kv => $vv) {
										# code...
										
										if(strpos($vv->keterangan, 'id_club')!==false)
											$ket=str_replace('__', '_', $vv->keterangan);
										else
											$ket='kosong';


										$jns_p=$jenis_p;
										$jenis_p=strtok($jenis_p, ' ');
										$sisa_bayar=0;
										if(isset($datapot[$jenis_p]))
										{
											if($datapot[$jenis_p]->persen==0)
											{
												// $sisa_bayar=$vv->sisa_bayar - ($datapot[$jenis_p]->persen/100 * $vv->sisa_bayar);
												$sisa_bayar=$datapot[$jenis_p]->biaya;
											}
											// else
											// {
											// }
										}
										else
										{
											$sisa_bayar=$vv->sisa_bayar;
										}

										
										$tagih.='<div style="float:left;width:100%;margin-bottom:2px !important">
												<div style="width:5%;float:left;"><input type="checkbox" name="tagihanbank['.$nis.'][]" value="'.$idjenis.'__'.$bulan.'__'.$tahun.'__'.$sisa_bayar.'__'.$nis.'__'.$batch_id.'__'.$ket.'"></div><div style="width:35%;float:left;">&nbsp;&nbsp;'.$jns_p.'</div><div style="width:34%;float:left">: '.getBulanSingkat($vv->bulan).' \''.substr($vv->tahun, 2,2).'</div><div style="width:26%;float:right;text-align:right"> '.number_format($sisa_bayar).'</div></div>';
										$subtotal+=$sisa_bayar;
										$idtg++;
									}
								}
								
							}
						}
						
						if($jlhinvesinves!=0)
						{
							$subtotal+=$jlhinvesinves;
							$jlhinvesinves=0;
						}
							
						$tagih.='<div style="width:74%;float:left;text-align:right;padding-right:3px;font-weight:bold;padding-top:5px;">SUB TOTAL</div><div style="width:26%;float:right;text-align:right;font-weight:bold;padding-top:5px;">'.number_format($subtotal).'</div>';
						$tagih.='<hr style="border-bottom:1px solid #ddd;float:left;width:99%;padding:1px 0px !important;margin:2px 0px !important">';
					}
					if($jlhinvestxt!='')
						echo $jlhinvestxt;
					echo $tagih;
				}

				// $this->load->view('isi/transaksi/tagihan-form',$data);
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
				$sis[$vs->nis]=$vs;
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
				$nis=$v->nis.'__'.str_replace(' ', '_', $sis[$v->nis]->nama_murid).'__'.$v->batch_id;
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


}
