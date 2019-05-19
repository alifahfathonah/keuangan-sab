<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Mymodel','mm');	
	}

	
	public function index()
	{
		// $data['d']=$this->load->view('index.html');
		$login=$this->session->userdata('login');
		
		if($login=='true')
		{
			$data=array(
				'title' => 'Beranda',
				'isi' => 'isi/home',
				'navbar' => 'layout/navbar',
				'footer' => 'layout/footer'
			);
			$this->load->view('index',$data);
		}
		else
			// echo '<pre>'.$login.'</pre>';
			// echo '<pre>';
			// print_r($this->session);
			// echo '</pre>';
			redirect('login','location');
	}
	public function login()
	{
		$login=$this->session->userdata('login');
		if($login=='true')
			redirect('main','location');
		$this->load->view('login');
	}
	public function logout()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('pesan','Anda Sudah Logout');
		redirect('login','location');
	}
	public function loginproses()
	{
		if(!empty($_POST))
		{
			$d['username']=$_POST['username'];
			$d['password']=sha1(md5($_POST['password']));
			$cek=$this->db->from('t_user')->where($d)->get()->result();
			if(count($cek)!=0)
			{
				$this->session->set_userdata('user',$cek);
				$this->session->set_userdata('login','true');
				// echo 'Ok';
				redirect('main','location');
			}
			else
			{
				$this->session->set_flashdata('pesan','Username dan Password Belum tepat');
				// echo $d['password'];
				redirect('login','location');
			}
			// echo $d['password'].'<br>';
			// echo count($cek);
		}
	}
	function kirimemail($htmlContent,$to,$subject)
	{
		//$this->load->library('email');
		// $htmlContent = '<h1>Mengirim email HTML dengan Codeigniter</h1>';
		// $htmlContent .= '<div>Contoh pengiriman email yang memiliki tag HTML dengan menggunakan Codeigniter</div>';

		$config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'sekolahalambogor.id',
            // 'smtp_host' => '103.225.64.46',
            'smtp_port' => 25,
            'smtp_user' => 'noreply@sekolahalambogor.id',
            'smtp_pass' => '!!Sabogor!!',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        // Set to, from, message, etc.

      $result = $this->email->send(); //konfigurasi pengiriman kotak di view ke pengiriman email di gmail
	    $this->email->from('noreply@sekolahalambogor.id');
	    $this->email->to($to);
	    $this->email->subject($subject);
	    $this->email->message($htmlContent);
			if($this->email->send())
	 			echo "Email sent successfully.";
	 		 else
	 		 {
	 			echo "Error in sending Email.";
	 			$this->email->print_debugger();
			}
	}
	function reloadall($bulan,$tahun,$tahunajaran=-1)
	{	
		$t_ajaran=$this->config->item('t_ajaran2');
		if($tahunajaran==-1)
		{
			$ta=gettahunajaranbybulan($bulan,$tahun);
		}
		else
		{
			$ajaran=$this->config->item('tajaran');
			$ta=$ajaran[$date]->tahun_ajaran;
			// $ta=$tahunajaran;
		}
		
		$this->getallsiswasd($ta);
		$this->getallsiswasm($ta);
		$this->hitungakun($tahun,$bulan);
		if(isset($t_ajaran[$ta]))
		{
			$idta=$t_ajaran[$ta]->id_ajaran;		
		}
	}

	function getallsiswasd($ta)
	{
		$trans=$this->config->item('v_transaksi');
		$tpenerimaan=$this->config->item('tpenerimaan');
		$tagihan=$this->config->item('tagihan');
		$sql="select * from v_batch_siswa where tahun_ajaran='".$ta."' and active='1' and id_level in (select id_level from t_level_kelas where kategori like '%sd%')";
		$d=$this->db->query($sql)->result();	
		$jlh=0;

		$tjenis=array();
		foreach($tpenerimaan as $tk => $tv)
		{
			if(strpos($tv->level,'sd')!==false)
			{
				$tjenis[$tv->jenis]=$tv->id;
			}
		}

		$d_sis=array();
		foreach($d as $k => $v)
		{
			if(isset($trans[$v->nis]))
			{
				foreach($trans[$v->nis] as $kk => $vv)
				{
					$jns=$tpenerimaan[$kk];
					$thn_ajaran=key($vv);
					$new_idjns=(isset($tjenis[$jns->jenis]) ? $tjenis[$jns->jenis] : '');
					if($new_idjns!='')
					{
						if($new_idjns!=$kk)
						{
							$d_sis[$v->nis][$kk]=$v->nis.' : '.$v->nama_murid.'__'.$jns->jenis.' || '.$new_idjns;
							$d_sis[$v->nis][$vv[$thn_ajaran][0]->penerimaan_id.'::id_det_trans']=$vv[$thn_ajaran][0]->id .' | '.$vv[$thn_ajaran][0]->tanggal_transaksi;
							$jlh++;
							$up_tr['penerimaan_id']=$new_idjns;
							$this->db->where('id',$vv[$thn_ajaran][0]->id);
							$this->db->update('t_transaksi_detail',$up_tr);

							if(isset($tagihan[$v->nis][$thn_ajaran][$kk]))
							{
								$tag=$tagihan[$v->nis][$thn_ajaran][$kk];
								$d_sis[$v->nis][$tag[0]->id_jenis_penerimaan.'::id_tagihan']=$tag[0]->id_tagihan;

								

								$up_tg['id_jenis_penerimaan']=$new_idjns;
								$this->db->where('id_tagihan',$tag[0]->id_tagihan);
								$this->db->update('t_tagihan_siswa',$up_tg);
							}
						}
					}		
				}
			}
		}
		
	}
	function getallsiswasm($ta)
	{
		$trans=$this->config->item('v_transaksi');
		$tpenerimaan=$this->config->item('tpenerimaan');
		$tagihan=$this->config->item('tagihan');
		$sql="select * from v_batch_siswa where tahun_ajaran='".$ta."' and active='1' and id_level in (select id_level from t_level_kelas where kategori like '%sm%')";
		$d=$this->db->query($sql)->result();	
		$jlh=0;

		$tjenis=array();
		foreach($tpenerimaan as $tk => $tv)
		{
			if(strpos($tv->level,'sm')!==false)
			{
				$tjenis[$tv->jenis]=$tv->id;
			}
		}

		$d_sis=array();
		foreach($d as $k => $v)
		{
			if(isset($trans[$v->nis]))
			{
				foreach($trans[$v->nis] as $kk => $vv)
				{
					$jns=$tpenerimaan[$kk];
					$thn_ajaran=key($vv);
					$new_idjns=(isset($tjenis[$jns->jenis]) ? $tjenis[$jns->jenis] : '');
					if($new_idjns!='')
					{
						if($new_idjns!=$kk)
						{
							$d_sis[$v->nis][$kk]=$v->nis.' : '.$v->nama_murid.'__'.$jns->jenis.' || '.$new_idjns;
							$d_sis[$v->nis][$vv[$thn_ajaran][0]->penerimaan_id.'::id_det_trans']=$vv[$thn_ajaran][0]->id .' | '.$vv[$thn_ajaran][0]->tanggal_transaksi;
							$jlh++;
							$up_tr['penerimaan_id']=$new_idjns;
							$this->db->where('id',$vv[$thn_ajaran][0]->id);
							$this->db->update('t_transaksi_detail',$up_tr);

							if(isset($tagihan[$v->nis][$thn_ajaran][$kk]))
							{
								$tag=$tagihan[$v->nis][$thn_ajaran][$kk];
								$d_sis[$v->nis][$tag[0]->id_jenis_penerimaan.'::id_tagihan']=$tag[0]->id_tagihan;

								

								$up_tg['id_jenis_penerimaan']=$new_idjns;
								$this->db->where('id_tagihan',$tag[0]->id_tagihan);
								$this->db->update('t_tagihan_siswa',$up_tg);
							}
						}
					}		
				}
			}
		}
		
	}
	function hitungakun($tahun=-1,$bulan=-1,$kd_akun=-1)
	{
		$bln=($bulan==-1 ? date('n') : $bulan);
		$thn=($tahun==-1 ? date('Y') : $tahun);
		$akun=$this->config->item('takun');
		$wh='status_tampil="t"';

		// echo $bln.'-'.$thn;

		if($bulan!=-1)
		{
				$whpen=$wh.' and (YEAR(`tanggal_transaksi`)='.$thn.' AND MONTH(`tanggal_transaksi`)='.$bln.' )';
				$t_pen=$this->db->select('*,"terima" as status')->from('v_trans_detail_jenis')->where($whpen)->order_by('tanggal_transaksi asc')->get()->result();
				
				$whpeng=$wh.' and (YEAR(`tanggal_transaksi`)='.$thn.' AND MONTH(`tanggal_transaksi`)='.$bln.')';
				$t_peng=$this->db->select('*,"keluar" as status, "-1" as nis, "-1" as id_jns')->from('v_transaksi_pengeluaran_detail')->where($whpeng)->order_by('tanggal_transaksi asc')->get()->result();
		}
		else
		{
			
			$t_pen=$this->db->select('*,"terima" as status')->from('v_trans_detail_jenis')->where($wh)->order_by('tanggal_transaksi asc')->get()->result();
		
			$t_peng=$this->db->select('*,"keluar" as status, "-1" as nis, "-1" as id_jns')->from('v_transaksi_pengeluaran_detail')->where($wh)->order_by('tanggal_transaksi asc')->get()->result();
		}
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
			$tahunn=date('Y',strtotime($v->tanggal_transaksi));
			$bulann=date('n',strtotime($v->tanggal_transaksi));
			$trans[$ak_alt][$tahunn][$bulann][]=$v->jumlah;
			// $trans[]=$v->jumlah;
		}
		foreach($t_peng as $k => $v)
		{
			$kd=strtok($v->keterangan,'-');
			$tahunn=date('Y',strtotime($v->tanggal_transaksi));
			$bulann=date('n',strtotime($v->tanggal_transaksi));
			$trans[$kd][$tahunn][$bulann][]=$v->jumlah;
			// $trans[]=$v->jumlah;
		}
		// echo '<pre>';
		// print_r($trans['A1'][$thn]);
		// echo '</pre>';
		if($kd_akun!=-1)
			$k_akun[]=$akun[$kd_akun];
		else
			$k_akun=$akun;

		$x=0;
		$idx_ins=$idx_upd=0;
		$insert=$update=array();
		foreach($k_akun as $kd => $vl)
		{
			if($vl->akun_alternatif!='')
			{
				if(isset($trans[$vl->akun_alternatif]))
				{
					if(isset($trans[$vl->akun_alternatif][$thn]))
					{
						if(isset($trans[$vl->akun_alternatif][$thn][$bln]))
						{
							// echo 'Gak Ada '.$vl->akun_alternatif;
							$jlh=array_sum($trans[$vl->akun_alternatif][$thn][$bln]);
						}
						else
						$jlh=0;
					}
					else
					{
						$jlh=0;
					}
				}
				else
					$jlh=0;
			}
			else
				$jlh=0;
			
			// echo $vl->akun_alternatif.' : '.number_format($jlh,0,',','.').'<br>';

			$cek=$this->db->from('t_saldo_akun')
						->where('bulan',$bln)
						->where('tahun',$thn)
						->where('kode_akun_alt',$vl->akun_alternatif)
						->get()->result();

			
			if(count($cek)!=0)
			{
				$update[$idx_upd]['id']=$cek[0]->id;
				$update[$idx_upd]['kode_akun_alt']=$vl->akun_alternatif;
				$update[$idx_upd]['bulan']=$bln;
				$update[$idx_upd]['tahun']=$thn;
				$update[$idx_upd]['jumlah']=$jlh;
				$update[$idx_upd]['updated_at']=date('Y-m-d H:i:s');
				$idx_upd++;
			}
			else
			{
				$insert[$idx_ins]['kode_akun_alt']=$vl->akun_alternatif;
				$insert[$idx_ins]['bulan']=$bln;
				$insert[$idx_ins]['tahun']=$thn;
				$insert[$idx_ins]['jumlah']=$jlh;
				$insert[$idx_ins]['created_at']=date('Y-m-d H:i:s');
				$insert[$idx_ins]['updated_at']=date('Y-m-d H:i:s');
				$idx_ins++;
			}

			$x++;
		}

		if(count($update)!=0)
		{
			// echo '<pre>';
			// print_r($update);
			// echo '</pre>';
			$this->db->update_batch('t_saldo_akun', $update, 'id');
		}
		else if(count($insert)!=0)
		{
			// echo '<pre>';
			// print_r($insert);
			// echo '</pre>';
			$this->db->insert_batch('t_saldo_akun',$insert);
		}
	}
}
