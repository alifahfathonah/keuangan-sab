<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mymodel extends CI_Model {

	public function procesTagihan($d,$id=-1)
	{
		if($id==-1)
		{
			$this->db->insert('t_tagihan_siswa',$d);
		}
		else
		{
			$this->db->where('id_tagihan',$id);
			$this->db->update('t_tagihan_siswa',$d);
		}
		// echo '<pre>';
		// print_r($d);
		// echo '</pre>';
	}

	function updatetagihan($up,$jumlah)
	{
		$this->db->set('sudah_bayar','sudah_bayar + '.$jumlah , FALSE);
		$this->db->set('sisa_bayar','sisa_bayar - '.$jumlah , FALSE);
		$this->db->where($up);
		$this->db->update('t_tagihan_siswa');
	}

	function getallsiswasd()
	{
		$trans=$this->config->item('v_transaksi');
		$tpenerimaan=$this->config->item('tpenerimaan');
		$tagihan=$this->config->item('tagihan');
		$sql="select * from v_batch_siswa where tahun_ajaran='2017 / 2018' and active='1' and id_level in (select id_level from t_level_kelas where kategori like '%sd%')";
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
		// echo $jlh;
		// echo '<pre>';
		// print_r($d_sis);
		// echo '</pre>';
	}
	function getallsiswasm()
	{
		$trans=$this->config->item('v_transaksi');
		$tpenerimaan=$this->config->item('tpenerimaan');
		$tagihan=$this->config->item('tagihan');
		$sql="select * from v_batch_siswa where tahun_ajaran='2017 / 2018' and active='1' and id_level in (select id_level from t_level_kelas where kategori like '%sm%')";
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
		// echo $jlh;
		// echo '<pre>';
		// print_r($d_sis);
		// echo '</pre>';
	}

	function updatetabungan($idsiswa=-1)
	{
		$tab=$this->config->item('tabungan');
		$data=array();
		if($idsiswa==-1)
		{
			foreach($tab as $c=>$k)
			{
				$tot=0;
				foreach($k as $kk=>$v)
				{
					if($v->jenis=='Tarik')
						$tot-=$v->jumlah;
					else
						$tot+=$v->jumlah;

						// echo $v->tabungan_id.'- '.$v->jumlah.'<br>';
				}
				echo $k[0]->tabungan_id.'-'.$tot.'<br>-----------<br>';
				$this->db->set('saldo',$tot);
				$this->db->where('id',$k[0]->tabungan_id);
				$this->db->update('t_tabungan');
			}
		}
		else
		{
			// $data=[]
			$tot=0;
			foreach($tab[$idsiswa] as $c=>$v)
			{
				if($v->jenis=='Tarik')
					$tot-=$v->jumlah;
				else
					$tot+=$v->jumlah;
			}
			$this->db->set('saldo',$tot);
			$this->db->where('id',$tab[$idsiswa][0]->tabungan_id);
			$this->db->update('t_tabungan');
			// echo $tab[$idsiswa][0]->tabungan_id.'-'.$tot.'<br>-----------<br>';
		}
	}
}