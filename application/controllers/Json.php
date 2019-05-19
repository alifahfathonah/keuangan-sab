<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {
	
	private $command;
	private $data;
	private $nama;
	private $alamat;
	private $telp;
	private $apikey;
	private $response;
    function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
    }
    public function json_simpan_transaksi()
    {
        if($this->input->post()==null){
			$arr = array("command"=>404,
						"response"=>"Not Found"
					);

					echo json_encode($arr);
			die;
        }
        $raw = $this->input->post();
		$data = json_decode($raw['json']);
        $datanama = $data->nama;
        list($nama,$kelas)=explode('::',$datanama);
        $nama=trim($nama);
        if($data->flag==1)
        {
            $d_siswa=$this->db->from('t_siswa')->like('nama_murid',$nama)->get()->result();
            if(count($d_siswa)!=0)
            {
                $nis=$d_siswa[0]->nisn;
                $id_muz=$d_siswa[0]->id;
            }
            else
                $nis=$id_muz='';
        }
        else
        {
            $kelas=trim($kelas);
            $d_muzzaki=$this->db->from('muzzaki')->like('nama',$nama)->like('telp',$kelas)->get()->result();
            $id_muz=$d_muzzaki[0]->id;
            $simpan['beras']=$data->beras;
        }
		$simpan['keterangan']=$data->keterangan;
        $simpan['id_penerima']=-1;
        $simpan['id_penyetor']=$id_muz;
        $simpan['penerima']=$data->amilin;
        $simpan['penyetor']=$nama;
		$simpan['created_at']=date('Y-m-d H:i:s');
		$simpan['updated_at']=date('Y-m-d H:i:s');
        $kelas=trim($kelas);

        $kls=trim(strtok($nama,'-'));
        $kls2=trim(str_replace($kls,'',$kelas));

		$command = $data->command;
		$jumlah = $simpan['jumlah_setoran']=str_replace(array(',','.'),'',$data->jumlah);
		$jenis = $simpan['jenis']=$data->jenis;
		$kwitansi= $simpan['no_kwitansi']=$data->kwitansi;
		$flag= $simpan['flag']=$data->flag;
        $tanggal = $simpan['tanggal_transaksi']=date('Y-m-d H:i:s');
        $this->db->insert('transaksi_penerimaan',$simpan);
        $response="-";
        switch($command){

            case "tambah":
                if($data->flag==1)
                {
                    $response="Data Zakat/Infak Siswa Berhasil Di Simpan";
                }
                else
                {
                    $response="Data Zakat/Infak/Sedekah Berhasil Di Simpan";
                }
                break;
        }

        $arr = array("command"=>$command,
					"response"=>$response
				);

		echo json_encode($arr);
    }
	public function from_android()
	{
		if($this->input->post()==null){
			$arr = array("command"=>404,
							"response"=>"Not Found"
					);

					echo json_encode($arr);
			die;
		}

				$raw = $this->input->post();
				$this->data = json_decode($raw['json']);

				$this->apikey = $this->data->apikey;
				$this->command = $this->data->command;
				$this->nama = $this->data->nama;
				$this->alamat = $this->data->alamat;
				$this->telp = $this->data->telp;

				//if($this->apikey=="mykey123"){

					switch($this->command){

						case "tambah":	
								$data['nama']=$this->nama;
								$data['telp']=$this->telp;
								$data['alamat']=$this->alamat;
								$data['flag']=1;
								$data['created_at']=date('Y-m-d H:i:s');
								$this->db->insert('muzzaki',$data);
								$this->response="Data Muzzaki Berhasil Di Simpan";
							break;
						case "multiply":	
								$this->response = $this->a * $this->b;
							break;			
					}//end switch

					$arr = array("command"=>$this->command,
							"response"=>$this->response
					);

					echo json_encode($arr);
				/*}//end if
				else{
					echo "invalid request dear";
				}*/

		}

	public function json_muzzaki()
	{
		$data=$this->db->from('muzzaki')->where('flag',1)->get()->result();
		$d=array();
		$no=0;
		foreach($data as $k => $v)
		{
			$d['result'][$no]['nama']=$v->nama;
			$d['result'][$no]['telp']=$v->telp;
			$d['result'][$no]['alamat']=$v->alamat;
			$no++;
		}
		echo json_encode($d);
	}
	public function json_jenis_setoran()
	{
		$data=$this->db->from('jenis_setoran')->get()->result();
		$d=array();
		$no=0;
		foreach($data as $k => $v)
		{
			$d['result'][$v->kategori][]=$v->jenis;
			$no++;
		}
		echo json_encode($d);
		
	}
    public function json_siswa_nis($cari=null)
    {
        //header('Content-Type: application/json');
        $cari = str_replace('%20',' ',$cari);
		$sis=$this->config->item('vbatchsiswa');
		$batch=$this->config->item('vbatchkelas');
		//vbatchsiswa
		//if($cari==null)
        	//$sis=$this->db->from('v_siswa')->where('status_tampil','t')->get()->result();
		//else
			//$sis=$this->db->from('v_siswa')->like('nama_murid',$cari)->where('status_tampil','t')->get()->result();
        $data=array();
        $n=0;
        foreach($sis as $k => $v)
        {
            $data['results'][$n]['nis']=$v->nisn;
            $data['results'][$n]['nama']=$v->nama_murid;
			if(isset($batch[$v->id_batch]))
			{
				$btc=$batch[$v->id_batch];
				$data['results'][$n]['kelas']=trim($btc->nama_level).'-'.trim($v->nama_batch);
			}
			else
				$data['results'][$n]['kelas']=$v->nama_batch;
//			$data['results'][$n]=$v->nama_murid;

            $n++;
        }
        
        echo json_encode($data);
    }
	public function json_siswa($cari=null)
    {
        //header('Content-Type: application/json');
        $cari = str_replace('%20',' ',$cari);
		if($cari==null)
        	$sis=$this->db->from('v_siswa')->where('status_tampil','t')->get()->result();
		else
			$sis=$this->db->from('v_siswa')->like('nama_murid',$cari)->where('status_tampil','t')->get()->result();
        $data=array();
        $n=0;
        foreach($sis as $k => $v)
        {
           // $data['results'][$n]['nis']=$v->nisn;
            //$data['results'][$n]['nama']=$v->nama_murid;
			$data['results'][$n]=$v->nama_murid;

            $n++;
        }
        
        echo json_encode($data);
    }
    public function json_tagihan($nis='all',$bulan=null,$tgl=null,$tahun=null)
	{
        //echo $nis;
        $tsb=$this->config->item('tsbjenis');
        $siswa=$this->config->item('tsiswa');
        $trans_bayar=$this->config->item('trans_bayar');
        $nisnsiswa=$this->config->item('nisnsiswa');
        $jenis=$this->config->item('tpenerimaan');

        

        if($bulan==null)
            $bln=date('n');
        else
            $bln=$bulan;
 
        if($tgl==null)
            $tgl=date('n');
        else
            $tgl=$tgl;
 
        if($tahun==null)
            $thn=date('Y');
        else
            $thn=$tahun;
            
        $t_a = gettahunajaranbybulan($bln,$thn);
        $t_a_sebelum = gettahunajaranbybulan($bln,($thn-1));

        $blninves=7;
        $min_bln=7;
        
        if($bln>=7 && $bln<=12)
        {
            $thninves=$thn;
            $tahun_ajaran=$tahun.' / '.($tahun+1);
            $max_bln=$bln;
        }
        else
        {
            $thninves=($thn-1);
            $tahun_ajaran=($tahun-1).' / '.($tahun);
            $max_bln=12+$bln;
        }

       

        $whereinvessebelum='v_tagihan_siswa.bulan = 7 and v_tagihan_siswa.sisa_bayar>0 and v_tagihan_siswa.status_tagihan=1 and (v_tagihan_siswa.jenis like "%program%" or v_tagihan_siswa.jenis like "%asuransi%" or v_tagihan_siswa.jenis like "%komite%" or v_tagihan_siswa.jenis like "%Investasi%") and v_tagihan_siswa.tahun_ajaran="'.$t_a_sebelum.'"';
        $invesebelum="";

        $where='v_tagihan_siswa.bulan = 7 and v_tagihan_siswa.sisa_bayar>0 and v_tagihan_siswa.status_tagihan=1 and (v_tagihan_siswa.jenis like "%program%" or v_tagihan_siswa.jenis like "%asuransi%" or v_tagihan_siswa.jenis like "%komite%" or v_tagihan_siswa.jenis like "%Investasi%") and v_tagihan_siswa.tahun_ajaran="'.$t_a.'"';

        // echo $where;

        if($nis=='all')
        {
            // $tagihaninves=$this->db->from('v_tagihan_siswa')
            //             ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
            //             ->where('bulan',$blninves)
            //             ->where('tahun',$thninves)
            //             ->like('jenis','Program Pembelajaran')
            //             ->get()->result();
            $tagihaninvessebelm=$this->db->from('v_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
                        ->where($whereinvessebelum)
                        ->get()->result();

            $tagihaninves=$this->db->from('v_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
                        ->where($where)
                        ->get()->result();


            $tagihan=$this->db->from('t_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=t_tagihan_siswa.id_siswa')
                        ->where('t_tagihan_siswa.bulan',$bln)
                        ->where('t_tagihan_siswa.tahun',$thn)
                        ->where('t_tagihan_siswa.status_tagihan',1)
                        ->get()->result();
            
            $tagihanlama=$this->db->from('t_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=t_tagihan_siswa.id_siswa')
                        ->where('t_tagihan_siswa.status_tagihan',1)
                        ->where('t_tagihan_siswa.tahun_ajaran <', $tahun_ajaran)
                        ->where('t_tagihan_siswa.sisa_bayar >', 0)
                        ->get()->result();
            
            $tagihanclub=$this->db->from('v_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
                        ->where('v_tagihan_siswa.tahun_ajaran',$tahun_ajaran)
                        ->where('v_tagihan_siswa.status_tagihan',1)
                        ->like('v_tagihan_siswa.jenis','club','after')
                        ->get()->result();
            
        }
        else
        {
            // $tagihaninves=$this->db->from('v_tagihan_siswa')
            //             ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
            //             ->where('bulan',$blninves)
            //             ->where('tahun',$thninves)
            //             ->like('t_siswa.nisn',$nis)
            //             ->like('jenis','Program Pembelajaran')
            //             ->get()->result();

            $tagihaninvessebelm=$this->db->from('v_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
                        ->where($whereinvessebelum)
                        ->like('t_siswa.nisn',$nis)
                        ->get()->result();

            $tagihaninves=$this->db->from('v_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
                        ->where($where)
                        ->like('t_siswa.nisn',$nis)
                        ->get()->result();

            $tagihan=$this->db->from('t_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=t_tagihan_siswa.id_siswa')
                        ->like('t_siswa.nisn',$nis)
                        ->where('t_tagihan_siswa.bulan',$bln)
                        ->where('t_tagihan_siswa.tahun',$thn)
                        ->where('t_tagihan_siswa.status_tagihan',1)
                        ->get()->result();
            
             $tagihanlama=$this->db->from('v_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
                        ->like('t_siswa.nisn',$nis)
                        ->where('v_tagihan_siswa.status_tagihan',1)
                        ->where('v_tagihan_siswa.tahun_ajaran <', $tahun_ajaran)
                        ->where('v_tagihan_siswa.sisa_bayar >', 0)
                        ->get()->result();

            $tagihanclub=$this->db->from('v_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
                        ->like('t_siswa.nisn',$nis)
                        ->where('v_tagihan_siswa.tahun_ajaran',$tahun_ajaran)
                        ->where('v_tagihan_siswa.status_tagihan',1)
                        ->like('v_tagihan_siswa.jenis','club','after')
                        ->get()->result();
        }

        $data=array();
        //$
        
        $total=0;
        // echo count($tagihan);
        $gt_nis=$nisnsiswa[trim($nis)]->nis;
        $sebelum=array();
        // echo '<pre>';
        // print_r($tsb);
        // echo '</pre>';
        if(isset($tsb[$gt_nis][$tahun_ajaran]))
        { 
            $get_tsb=$tsb[$gt_nis][$tahun_ajaran];
            for($x=$min_bln;$x<=$max_bln;$x++)
            {
                if($x>12)
                {
                    $xx=$x-12;
                    $thnx=$thn;
                    if($xx>=$bln)
                        continue;
                    
                    if(isset($get_tsb[$xx][$thnx]))
                    {
                        $subtotal=0;
                        foreach($get_tsb[$xx][$thnx] as $idx => $vx)
                        {
                            $subtotal+=$vx;
                            $sebelum[$gt_nis][$tahun_ajaran][$idx][]=$vx;
                        }
                    }
                }
                else
                {
                    $xx=$x;
                    $thnx=$thn-1;
                    if(isset($get_tsb[$xx][$thnx]))
                    {
                        $subtotal=0;
                        foreach($get_tsb[$xx][$thnx] as $idx => $vx)
                        {
                            $subtotal+=$vx;
                            $sebelum[$gt_nis][$tahun_ajaran][$idx][]=$vx;
                        }
                    }
                }
                // echo $xx.' - '.$thnx.' ; ';
                // unset($tsb[$gt_nis][$tahun_ajaran][$bln][$thn]);
            }
        }
        else
        {
            // $data=array('Status'=>'Tagihan Tidak Tersedia');
        }
        // echo '<pre>';
        // print_r($tagihanclub);
        // // print_r($sebelum);
        // echo '</pre>';
        $sblm=array();

        if(isset($sebelum[$gt_nis][$tahun_ajaran]))
        {

            foreach($sebelum[$gt_nis][$tahun_ajaran] as $isb => $vsb)
            {
                $subtotal=0;
                foreach($vsb as $i => $v)
                {
                    $subtotal+=$v;
                }
                $sblm[$isb]=$subtotal;
            }
        }
        // echo '<pre>';
        // print_r($tagihan);
        // // // print_r($sebelum);
        // echo '</pre>';
        $get_nis='';
        // if()
        foreach($tagihan as $k => $v)
        {
            if(isset($siswa[$v->id_siswa]))
            {
                $get_nis=$v->nis;
                
                $sis=$siswa[$v->id_siswa];
                if(isset($jenis[$v->id_jenis_penerimaan]))
                {
                    
                    $jns=$jenis[$v->id_jenis_penerimaan];
                    if(strtolower($jns->jenis)=='club')
                    {
                        continue;
                        // $n_jns=$jns->jenis;
                    }
                    else if($jns->jenis=='Program Pembelajaran')
                    {
                        //$n_jns='DU/Investasi';
                        continue;
                    }
                    else if(strpos($jns->jenis,'asuransi')!==false)
                    {
                        //$n_jns='DU/Investasi';
                        continue;
                    }
                    else if(strpos($jns->jenis,'komite')!==false)
                    {
                        //$n_jns='DU/Investasi';
                        continue;
                    }
                    else
                    {
                        $n_jns=$jns->jenis;
                    }

                    if($v->sisa_bayar==0)
                    {
                        $status='Sudah Bayar';
                        if(isset($trans_bayar[$v->nis][$v->id_jenis_penerimaan][$v->tahun_ajaran][$v->bulan][$v->tahun]))
                        {
                            $trn=$trans_bayar[$v->nis][$v->id_jenis_penerimaan][$v->tahun_ajaran][$v->bulan][$v->tahun];
                            $tgl_bayar=date('d-m-Y',strtotime($trn->tanggal_transaksi));
                        }
                        else
                            $tgl_bayar=date('d-m-Y');
                    }
                    else
                    {
                        $status="Belum Bayar";
                        $tgl_bayar='n/a';
                    }

                    if(isset($sblm[strtolower(str_replace(' ','_',$jns->jenis))]))
                    {
                        $jumlah_sebelum=$sblm[strtolower(str_replace(' ','_',$jns->jenis))];
                    }
                    else
                        $jumlah_sebelum=0;

                    $data[$sis->nisn]['nis']=$sis->nisn;
                    $data[$sis->nisn]['nama']=trim($sis->nama_murid);
                    //$data[$sis->nisn]['virtual_account']=trim($sis->no_virtual_account);
                    // $data[$sis->nisn][$n_jns]=$v->sisa_bayar .'-'. $jumlah_sebelum .':'.($v->sisa_bayar+$jumlah_sebelum);
                    $data[$sis->nisn][$n_jns]=(($v->sisa_bayar+$jumlah_sebelum)==0 ? $v->wajib_bayar : ($v->sisa_bayar+$jumlah_sebelum));
                    $data[$sis->nisn]['status_'.$jns->jenis]=$status;
                    $data[$sis->nisn]['tglbayar_'.$jns->jenis]=$tgl_bayar;
                    // $total+=(int)$v->sisa_bayar;
                    // $data[$sis->nis]['total']=$total;
                }
            }
        }
        
        $datatagihanlama=array();
        $datatglbayar=array();
        $xxx=0;
        foreach($tagihanlama as $k => $v)
        {
            if(isset($siswa[$v->id_siswa]))
            {
                $get_nis=$v->nis;
                
                $sis=$siswa[$v->id_siswa];
                
                    if(strtolower($v->jenis)=='club')
                    {
                        continue;
                        // $n_jns=$jns->jenis;
                    }
                    else if($v->jenis=='Program Pembelajaran')
                    {
                        //$n_jns='DU/Investasi';
                        continue;
                    }
                    else if(strpos($v->jenis,'asuransi')!==false)
                    {
                        //$n_jns='DU/Investasi';
                        continue;
                    }
                    else if(strpos($v->jenis,'komite')!==false)
                    {
                        //$n_jns='DU/Investasi';
                        continue;
                    }
                    else
                    {
                        $n_jns=$v->jenis;
                    }

                    if($v->sisa_bayar==0)
                    {
                        $status='Sudah Bayar';
                        if(isset($trans_bayar[$v->nis][$v->id_jenis_penerimaan][$v->tahun_ajaran][$v->bulan][$v->tahun]))
                        {
                            $trn=$trans_bayar[$v->nis][$v->id_jenis_penerimaan][$v->tahun_ajaran][$v->bulan][$v->tahun];
                            $tgl_bayar=date('d-m-Y',strtotime($trn->tanggal_transaksi));
                            //$datatglbayar[$v->nis][$v->id_jenis_penerimaan][]=
                        }
                        else
                            $tgl_bayar=date('d-m-Y');
                    }
                    else
                    {
                        $status="Belum Bayar";
                        $tgl_bayar='n/a';
                    }

                    //$data[$sis->nisn]['virtual_account']=trim($sis->no_virtual_account);
                    // $data[$sis->nisn][$n_jns]=$v->sisa_bayar .'-'. $jumlah_sebelum .':'.($v->sisa_bayar+$jumlah_sebelum);
                    $datatagihanlama[$sis->nisn][$n_jns.' Sebelumnya'][$xxx]=(($v->sisa_bayar)==0 ? $v->wajib_bayar : ($v->sisa_bayar));
                    // $datatagihanlama[$sis->nisn]['status_'.$jns->jenis.' Sebelumnya']=$status;
                    // $datatagihanlama[$sis->nisn]['tglbayar_'.$jns->jenis.' Sebelumnya']=$tgl_bayar;
                    // $total+=(int)$v->sisa_bayar;
                    // $data[$sis->nis]['total']=$total;
                    $xxx++;
                
            }
        }

        foreach($datatagihanlama as $kta=>$vta)
        {
            foreach($vta as $kj => $vj)
            {
                $jlh_lama=0;
                foreach($vj as $kk => $vvv)
                {
                    $jlh_lama+=$vvv;
                }
                $data[$kta][$kj]=$jlh_lama;
            }
        }
        // echo '<pre>';
        // print_r($tagihaninves);
        // echo '</pre>';
        $jlh=0;
        foreach($tagihaninves as $k => $v)
        {
            if(isset($siswa[$v->id_siswa]))
            {
                    $sis=$siswa[$v->id_siswa];
                
                    if($v->sisa_bayar==0)
                    {
                        $status='Sudah Bayar';
                        $tgl_bayar=date('d-m-Y');
                    }
                    else
                    {
                        $status="Belum Bayar";
                        $tgl_bayar='n/a';
                    }
                    if(isset($data[$sis->nisn][$v->jenis]))
                    {
                        // $jlh+=$v->sisa_bayar;
                        $data[$sis->nisn][$v->jenis]+=$v->sisa_bayar;
                    }
                    else
                    {
                        // $jlh=$v->sisa_bayar;
                        $data[$sis->nisn][$v->jenis]=$v->sisa_bayar;
                    }

                    $data[$sis->nisn]['status_'.$v->jenis]=$status;
                    $data[$sis->nisn]['tglbayar_'.$v->jenis]=$tgl_bayar;
                    // $total+=(int)$v->sisa_bayar;
                    // $data[$sis->nis]['total']=$total;
                
            }
        }

        foreach($tagihaninvessebelm as $k => $v)
        {
            if(isset($siswa[$v->id_siswa]))
            {
                    $sis=$siswa[$v->id_siswa];
                
                    if($v->sisa_bayar==0)
                    {
                        $status='Sudah Bayar';
                        $tgl_bayar=date('d-m-Y');
                    }
                    else
                    {
                        $status="Belum Bayar";
                        $tgl_bayar='n/a';
                    }
                    if(isset($data[$sis->nisn][$v->jenis]))
                    {
                        // $jlh+=$v->sisa_bayar;
                        $data[$sis->nisn][$v->jenis.'_'.$t_a_sebelum]=$v->sisa_bayar;
                    }
                    else
                    {
                        // $jlh=$v->sisa_bayar;
                        $data[$sis->nisn][$v->jenis.'_'.$t_a_sebelum]=$v->sisa_bayar;
                    }

                    $data[$sis->nisn]['status_'.$v->jenis.'_'.$t_a_sebelum]=$status;
                    $data[$sis->nisn]['tglbayar_'.$v->jenis.'_'.$t_a_sebelum]=$tgl_bayar;
                    // $total+=(int)$v->sisa_bayar;
                    // $data[$sis->nis]['total']=$total;
                
            }
        }
        
        foreach($tagihanclub as $k => $v)
        {
            if(isset($siswa[$v->id_siswa]))
            {
                    $sis=$siswa[$v->id_siswa];
                
                    if($v->sisa_bayar==0)
                    {
                        $status='Sudah Bayar';
                        $tgl_bayar=date('d-m-Y');
                    }
                    else
                    {
                        $status="Belum Bayar";
                        $tgl_bayar='n/a';
                    }
                    $data[$sis->nisn][$v->jenis]=$v->sisa_bayar;
                    $data[$sis->nisn]['status_'.$v->jenis]=$status;
                    $data[$sis->nisn]['tglbayar_'.$v->jenis]=$tgl_bayar;
                    // $total+=(int)$v->sisa_bayar;
                    // $data[$sis->nis]['total']=$total;
                
            }
        }

        $ta_baru = (date('Y').' / '.(date('Y')+1));
        $wheretabaru='v_tagihan_siswa.bulan = 7 and v_tagihan_siswa.sisa_bayar>0 and v_tagihan_siswa.status_tagihan=1 and  v_tagihan_siswa.tahun_ajaran="'.$ta_baru.'"';
        $tagihanbaru=array();
        if($bln<7)
        {
            $tagihanbaru=$this->db->from('v_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
                        ->where($wheretabaru)
                        ->like('t_siswa.nisn',$nis)
                        ->get()->result();
            
            foreach($tagihanbaru as $k => $v)
            {
                if(isset($siswa[$v->id_siswa]))
                {
                        $sis=$siswa[$v->id_siswa];
                    
                        if($v->sisa_bayar==0)
                        {
                            $status='Sudah Bayar';
                            $tgl_bayar=date('d-m-Y');
                        }
                        else
                        {
                            $status="Belum Bayar";
                            $tgl_bayar='n/a';
                        }
                        $jns_baru=$v->jenis.' '.trim(str_replace(' ','',$ta_baru));
                        $data[$sis->nisn][$jns_baru]=$v->sisa_bayar;
                        $data[$sis->nisn]['status_'.$jns_baru]=$status;
                        $data[$sis->nisn]['tglbayar_'.$jns_baru]=$tgl_bayar;
                        // $total+=(int)$v->sisa_bayar;
                        // $data[$sis->nis]['total']=$total;
                    
                }
            }
        }

        if(count($data)==0)
            $data=array('Status'=>'Tagihan Belum Tersedia');

        echo json_encode($data);
        
    }
    public function table_tagihan($nis='all',$bulan=null,$tahun=null)
	{
        //echo $nis;
        $tsb=$this->config->item('tsbjenis');
        $siswa=$this->config->item('tsiswa');
        $nisnsiswa=$this->config->item('nisnsiswa');
        $jenis=$this->config->item('tpenerimaan');
        if($bulan==null)
            $bln=date('n');
        else
            $bln=$bulan;
 
        if($tahun==null)
            $thn=date('Y');
        else
            $thn=$tahun;
            
        $blninves=7;
        $min_bln=7;
        
        if($bln>=7 && $bln<=12)
        {
            $thninves=$thn;
            $tahun_ajaran=$tahun.' / '.($tahun+1);
            $max_bln=$bln;
        }
        else
        {
            $thninves=($thn-1);
            $tahun_ajaran=($tahun-1).' / '.($tahun);
            $max_bln=12+$bln;
        }

        

        if($nis=='all')
        {
            $tagihaninves=$this->db->from('v_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
                        ->where('bulan',$blninves)
                        ->where('tahun',$thninves)
                        ->like('jenis','Program Pembelajaran')
                        ->get()->result();


            $tagihan=$this->db->from('t_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=t_tagihan_siswa.id_siswa')
                        ->where('t_tagihan_siswa.bulan',$bln)
                        ->where('t_tagihan_siswa.tahun',$thn)
                        ->where('t_tagihan_siswa.status_tagihan',1)
                        ->get()->result();
            
            $tagihanclub=$this->db->from('v_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
                        ->where('v_tagihan_siswa.tahun_ajaran',$tahun_ajaran)
                        ->where('v_tagihan_siswa.status_tagihan',1)
                        ->like('v_tagihan_siswa.jenis','club','after')
                        ->get()->result();
            
        }
        else
        {
            $tagihaninves=$this->db->from('v_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
                        ->where('bulan',$blninves)
                        ->where('tahun',$thninves)
                        ->like('t_siswa.nisn',$nis)
                        ->like('jenis','Program Pembelajaran')
                        ->get()->result();

            $tagihan=$this->db->from('t_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=t_tagihan_siswa.id_siswa')
                        ->like('t_siswa.nisn',$nis)
                        ->where('t_tagihan_siswa.bulan',$bln)
                        ->where('t_tagihan_siswa.tahun',$thn)
                        ->where('t_tagihan_siswa.status_tagihan',1)
                        ->get()->result();
            
            $tagihanclub=$this->db->from('v_tagihan_siswa')
                        ->join('t_siswa','t_siswa.id=v_tagihan_siswa.id_siswa')
                        ->like('t_siswa.nisn',$nis)
                        ->where('v_tagihan_siswa.tahun_ajaran',$tahun_ajaran)
                        ->where('v_tagihan_siswa.status_tagihan',1)
                        ->like('v_tagihan_siswa.jenis','club','after')
                        ->get()->result();
        }

        $data=array();
        //$
        
        $total=0;
        // echo count($tagihan);
        $gt_nis=$nisnsiswa[trim($nis)]->nis;
        $sebelum=array();

        if(isset($tsb[$gt_nis][$tahun_ajaran]))
        { 
            $get_tsb=$tsb[$gt_nis][$tahun_ajaran];
            for($x=$min_bln;$x<=$max_bln;$x++)
            {
                if($x>12)
                {
                    $xx=$x-12;
                    $thnx=$thn;
                    if($xx>=$bln)
                        continue;
                    
                        if(isset($get_tsb[$xx][$thnx]))
                    {
                        $subtotal=0;
                        foreach($get_tsb[$xx][$thnx] as $idx => $vx)
                        {
                            $subtotal+=$vx;
                            $sebelum[$gt_nis][$tahun_ajaran][$idx][]=$vx;
                        }
                    }
                }
                else
                {
                    $xx=$x;
                    $thnx=$thn-1;
                    if(isset($get_tsb[$xx][$thnx]))
                    {
                        $subtotal=0;
                        foreach($get_tsb[$xx][$thnx] as $idx => $vx)
                        {
                            $subtotal+=$vx;
                            $sebelum[$gt_nis][$tahun_ajaran][$idx][]=$vx;
                        }
                    }
                }
                // echo $xx.' - '.$thnx.' ; ';
                // unset($tsb[$gt_nis][$tahun_ajaran][$bln][$thn]);
            }
        }
        else
        {
            $data=array('Status'=>'Tagihan Tidak Tersedia');
        }
        // echo '<pre>';
        // print_r($tsb[$gt_nis][$tahun_ajaran]);
        // // print_r($sebelum);
        // echo '</pre>';
        $sblm=array();

        if(isset($sebelum[$gt_nis][$tahun_ajaran]))
        {

            foreach($sebelum[$gt_nis][$tahun_ajaran] as $isb => $vsb)
            {
                $subtotal=0;
                foreach($vsb as $i => $v)
                {
                    $subtotal+=$v;
                }
                $sblm[$isb]=$subtotal;
            }
        }
        // echo '<pre>';
        // print_r($sblm);
        // // // print_r($sebelum);
        // echo '</pre>';
        $get_nis='';
        // if()
        $index=0;
        foreach($tagihan as $k => $v)
        {
            if(isset($siswa[$v->id_siswa]))
            {
                $get_nis=$v->nis;
                
                $sis=$siswa[$v->id_siswa];
                if(isset($jenis[$v->id_jenis_penerimaan]))
                {
                    
                    $jns=$jenis[$v->id_jenis_penerimaan];
                    if(strtolower($jns->jenis)==='program pembelajaran')
                    {
                        $n_jns='DU/Investasi';
                        $st_inves=1;
                    }
                    else
                    {
                        $n_jns=$jns->jenis;
                        $st_inves=0;
                    }
                    
                    if($v->sisa_bayar==0)
                    {
                        $status='Sudah Bayar';
                        $tgl_bayar=date('d-m-Y');
                    }
                    else
                    {
                        if($st_inves==1)
                        {
                            $status="Belum Bayar--";
                            $tgl_bayar='n/a--';

                        }
                        else
                        {
                            $status="Belum Bayar";
                            $tgl_bayar='n/a';
                        }
                    }

                    if(isset($sblm[strtolower(str_replace(' ','_',$jns->jenis))]))
                    {
                        $jumlah_sebelum=$sblm[strtolower(str_replace(' ','_',$jns->jenis))];
                    }
                    else
                        $jumlah_sebelum=0;

                    $data[$sis->nisn]['nis']=$sis->nisn;
                    $data[$sis->nisn]['nama']=trim($sis->nama_murid);
                    // $data[$sis->nisn][$n_jns]=$v->sisa_bayar .'-'. $jumlah_sebelum .':'.($v->sisa_bayar+$jumlah_sebelum);
                    $data[$sis->nisn][$index]=$n_jns.'::'.($v->sisa_bayar+$jumlah_sebelum).'|'.$status.'::'.$tgl_bayar;
                    // $data[$sis->nisn][$n_jns]=($v->sisa_bayar+$jumlah_sebelum);
                    // $data[$sis->nisn]['status_'.$jns->jenis]=$status;
                    // $data[$sis->nisn]['tglbayar_'.$jns->jenis]=$tgl_bayar;
                    // $total+=(int)$v->sisa_bayar;
                    // $data[$sis->nis]['total']=$total;
                    $index++;
                }
            }
        }
        
        foreach($tagihaninves as $k => $v)
        {
            if(isset($siswa[$v->id_siswa]))
            {
                    $sis=$siswa[$v->id_siswa];
                
                    if($v->sisa_bayar==0)
                    {
                        $status='Sudah Bayar';
                        $tgl_bayar=date('d-m-Y');
                    }
                    else
                    {
                        $status="Belum Bayar";
                        $tgl_bayar='n/a';
                    }
                    $data[$sis->nisn][$index]=$v->jenis.'::'.($v->sisa_bayar).'|'.$status.'::'.$tgl_bayar;
                    // $data[$sis->nisn][$v->jenis]=$v->sisa_bayar;
                    // $data[$sis->nisn]['status_'.$v->jenis]=$status;
                    // $data[$sis->nisn]['tglbayar_'.$v->jenis]=$tgl_bayar;
                    // $total+=(int)$v->sisa_bayar;
                    // $data[$sis->nis]['total']=$total;
                    $index++;
                
            }
        }
        foreach($tagihanclub as $k => $v)
        {
            if(isset($siswa[$v->id_siswa]))
            {
                    $sis=$siswa[$v->id_siswa];
                
                    if($v->sisa_bayar==0)
                    {
                        $status='Sudah Bayar';
                        $tgl_bayar=date('d-m-Y');
                    }
                    else
                    {
                        $status="Belum Bayar";
                        $tgl_bayar='n/a';
                    }
                    $data[$sis->nisn][$index]=$v->jenis.'::'.($v->sisa_bayar).'|'.$status.'::'.$tgl_bayar;
                    // $data[$sis->nisn][$v->jenis]=$v->sisa_bayar;
                    // $data[$sis->nisn]['status_'.$v->jenis]=$status;
                    // $data[$sis->nisn]['tglbayar_'.$v->jenis]=$tgl_bayar;
                    // $total+=(int)$v->sisa_bayar;
                    // $data[$sis->nis]['total']=$total;
                    $index++;
                
            }
        }
        //echo json_encode($data);
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        echo '<table cellpadding="8" cellspacing="0" width="100%">';
        if(key($data)=='Status')
        {
            echo '<thead>
                <tr>
                    <th >Tagihan Tidak Tersedia</th>    
                </tr>
            </thead>';
        }
        else
        {
            echo '<thead style="background-color: #ddd;">';
                echo '<tr>';
                    echo '<th>No</th>';
                    echo '<th>Jenis Tagihan</th>';
                    echo '<th>Jumlah</th>';
                    echo '<th>Status</th>';
                    echo '<th>Tanggal Bayar</th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            $no=1;
            foreach($data as $k=>$v)
            {
                unset($v['nis']);
                unset($v['nama']);
                // echo '<pre>';
                // print_r($v);
                // echo '</pre>';
                $no=1;
                foreach($v as $ik => $iv)
                {
                    $dt=explode('|',$iv);
                    list($jns,$jlh)=explode('::',$dt[0]);
                    list($sts,$tglbayar)=explode('::',$dt[1]);
                    echo '<tr>';
                    echo '<td style="text-align:center;">'.$no.'</td>';
                    echo '<td>'.$jns.'</td>';
                    echo '<td style="text-align:right">'.number_format($jlh,0,',','.').'</td>';
                    echo '<td style="text-align:center;">'.$sts.'</td>';
                    echo '<td style="text-align:center;">'.$tglbayar.'</td>';
                    echo '</tr>';
                    $no++;
                }
            }
            echo '</tbody>';
        }

        echo '</table>';
        echo '<style>
            table th, table td
            {
                border : 1px solid #111111;
            }
        </style>';
    }

    function json_tabungan_siswa($nis)
    {
        $tab=$this->config->item('tabungan');
        $nisnsiswa=$this->config->item('nisnsiswa');
        $nisn=$nisnsiswa[$nis];
        $data=array();
        
        if(isset($tab[$nisn->id]))
        {
            $t=$tab[$nisn->id];
            $data[$nis]['saldo_tab']=$t[0]->saldo;
            $data[$nis]['id_tab']=$t[0]->id;
            $data[$nis]['nama_siswa']=$nisn->nama_murid;
            foreach($t as $i => $v)
            {
                $data[$nis]['detail'][$i]['tgl_nabung']=date('d-m-Y', strtotime($v->tanggal));
                $data[$nis]['detail'][$i]['jenis']=$v->jenis;
                $data[$nis]['detail'][$i]['jumlah']=$v->jumlah;
            }
        }

        echo json_encode($data);
        // echo '<pre>';
        // print_r($tab[$nisn->id]);
        // echo '</pre>';
    }
	
	public function print($nokwitansi)
    {
        $get=$this->db->from('transaksi_penerimaan')->where('no_kwitansi',$nokwitansi)->get()->result();
        //215
        echo '<table border="0" style="width:215px;font-size:11px;line-height:14px;font-family:tahoma">
        <tr>
            <th align="left"><img src="'.base_url().'/assets/img/logo-baznas.png" style="height:60px;"></th>
            
            <th align="right"><img src="'.base_url().'/assets/img/logosalamaid.png" style="width:120px;"></th>
        </tr>
        <tr>
            <th align="center" colspan="2" style="padding-top:20px;font-size:16px;line-height:normal;">BUKTI PENERIMAAN<BR>ZAKAT, INFAK, SEDEKAH & WAKAF</th>
        </tr>
        <tr>
            <td align="right" colspan="2"><br>Tanggal : '.tgl_indo2(date('Y-m-d H:i:s')).' '.(date('H:i:s')).' WIB</td>
        </tr>
        <tr>
            <td align="right" colspan="2">Amil : Nama Amilin</td>
        </tr>
        <tr>
            <td align="right" colspan="2">No.Bukti : '.$nokwitansi.'</td>
        </tr>
        <tr>
            <td align="right" colspan="2">&nbsp;&nbsp;</td>
        </tr>

        </table>';

        echo '<table style="width:215px;font-size:11px;line-height:20px;font-family:tahoma;border:1px solid #ccc;padding:5px">
    
        <tr>
            <td align="left" style="">Nama</td>
            <td align="left" style="">:</td>
            <td align="left" style="">Nama Muzzaki</td>
        </tr>
        <tr>
            <td align="left" style="">Jenis Setoran</td>
            <td align="left" style="">:</td>
            <td align="left" style="">Zakat</td>
        </tr>
        <tr>
            <td align="left" style="">Jumlah</td>
            <td align="left" style="">&nbsp;</td>
            <td align="left" style="">&nbsp;</td>
        </tr>
        <tr>
            <td align="center" style="" colspan="3">
                <div style="font-size:19px;">Rp. 100.000<br>
                <small style="font-size:10px;">Terbilang : Seratus Ribu Rupiah</small>    
                </div>
            </td>
        </tr>
        </table>';
        echo '<table border="0" style="width:215px;font-size:11px;line-height:12px;font-family:tahoma">
        
        <tr>
            <td align="center" style="padding-top:20px;font-size:10px;line-height:normal;">
            <b>"Ajarakallahu Fiima A\'thaita Wa Baaraka Fima Abqoita Wa Ja\'alallahu Laka Thahuuran"</b>
            <br><br>
            <i>Semoga Allah senantiasa memberimu pahala pada barang yang telah engkau berikan dan mudah-mudahan Allah memberikanmu berkah pada apa saja yang tinggal padamu serta mudah-mudahan dijadikannya kesucian bagi engkau</i>
            </td>
        </tr>
        </table>';

    }

    function json_transaksi($tanggal=null)
    {
        if($tanggal==null)
        {
            $tr=$this->db->from('transaksi_penerimaan')->get()->result();
        }
        else
        {
            $tr=$this->db->from('transaksi_penerimaan')->like('tanggal_transaksi',$tanggal)->get()->result();    
        }
        $trans=array();
        foreach($tr as $k=>$v)
        {
            $trans[$v->tanggal_transaksi][]=$v;
        }   
        echo json_encode($trans);
    }

    function json_kelas()
    {
        $bulan=date('n');
        $tahun=date('Y');
        // echo $bulan.'-'.$tahun;
        $tahun_ajaran=gettahunajaranbybulan($bulan,$tahun);
        // echo $tahun_ajaran;
        $kelas=$this->db->from('v_batch_kelas')->where('st_batch','t')->where('tahun_ajaran',$tahun_ajaran)->order_by('id_level asc, nama_batch asc')->get()->result();
        $data=$d2=array();
        $no=0;
        foreach($kelas as $k => $v)
        {
            $d2[$v->id_batch]=$v;
            $data[]=$v;
            $no++;
        }

        $sis=$s2=array();
        $siswa=$this->db->from('v_batch_siswa')->where('st_tbk','t')->where('tahun_ajaran',$tahun_ajaran)->where('active',1)->order_by('nama_murid asc,id_tbs desc')->get()->result();
        $x=0;
        foreach($siswa as $k => $v)
        {
            $s2[$v->id_batch][]=$v;
            $x++;
        }
        foreach($d2 as $k => $v)
        {
            $i=0;
            foreach($s2[$k] as $kk => $vv)
            {
                $nm=strtoupper($v->kategori).'-'.$v->nama_batch;
                $sis[$nm][$i]['nama']=ucwords(strtolower($vv->nama_murid));
                $sis[$nm][$i]['nisn']=$vv->nisn;
                $i++;
            }
        }
        $json['kelas']=$data;
        $json['siswa']=$sis;
        echo json_encode($json);
    }
    function json_user($username,$password)
    {
        $pass=sha1($password);
        $user=$this->db->from('petugas')->like('email',$username)->where('password',$pass)->get()->result();
        if(count($user)!=0)
        {
            $data['data']=$user[0];
            $data['response']='success';
        }
        else
        {
            $data['data']=array();
            $data['response']='fail';
        }
        echo json_encode($data);
    }

    function json_penerimaan($penerima=-1,$bulan=null,$tahun=null,$tanggal=null,$grafik=null)
    {
        $tgl=date('d');
        $bln=date('n');
        $thn=date('Y');
        $st=1;
        if($tanggal!=null)
        {
            $tgl=$tanggal;
            $wh='DAY(tanggal_transaksi)="'.$tgl.'" and MONTH(tanggal_transaksi)="'.$bln.'" and YEAR(tanggal_transaksi)="'.$thn.'" AND';
        }
        elseif($bulan!=null)
        {
            $bln=$bulan;
            $wh='MONTH(tanggal_transaksi)="'.$bln.'" and YEAR(tanggal_transaksi)="'.$thn.'" AND';
        }
        elseif($tahun!=null)
        {
            $thn=$tahun;
            $wh='YEAR(tanggal_transaksi)="'.$thn.'" AND';
        }
        else
        {
            $wh='';
            $st=0;
        }

        if($penerima!=-1)
        {
            if($penerima=='all')
            {
                $wh=substr($wh,0,-3);
                $d=$this->db->from('transaksi_penerimaan')->where($wh)->get()->result();
                $st=1;
            }
            else{

                $penerima=str_replace('%20',' ',$penerima);
                $wh.='penerima like "%'.$penerima.'%"';
                $d=$this->db->from('transaksi_penerimaan')->where($wh)->get()->result();
            }
        }
        
        else
        {
            $d=$this->db->from('transaksi_penerimaan')->get()->result();
        }

        
        $data=$data2=$data3=array();
        foreach($d as $k => $v)
        {
            if($st==1)
                $data[$v->jenis][strtok($v->tanggal_transaksi,' ')][]=$v->jumlah_setoran;
            else
                $data[$v->jenis][]=$v->jumlah_setoran;
        }
        $jenis_setoran=$this->db->from('jenis_setoran')->get()->result();
        $jumlah_total=0;
        foreach($jenis_setoran as $k => $v)
        {
            if(isset($data[$v->jenis]))
            {
                $data2[$v->jenis]=number_format(array_sum($data[$v->jenis]),0,',','.');
                $jumlah_total+=array_sum($data[$v->jenis]);
            }
            else
            {
                $data2[$v->jenis]=0;
                $jumlah_total+=0;
            }
            if($penerima=='all')
            {

                if(isset($data[$v->jenis]))
                {
                    foreach($data[$v->jenis] as $kk => $vv)
                    {
                        $data3[$v->jenis]=array_sum($vv);
                    }
                }
                else
                {
                    $data3[$v->jenis]=0;
                }
            }

        }
        $data2['jumlah']=number_format($jumlah_total,0,',','.');

        $json['detail']=$data;
        $json['data']=$data2;
        if($grafik!=null)
        {
            
            //echo json_encode($data3);
            $tgll=$tgl.' '.getBulan($bln).' '.$thn;
            // echo $tgll;
            $dd=array(
                    'data'=>$data3,
                    'title'=>"Jumlah Penerimaan Tanggal : ".$tgll
                );
            
            $this->load->view('v_grafik',$dd);
        }
        else
            echo json_encode($json);
    }

    function json_getgrafik($date)
    {
        // $x['data']=$this->m_grafik->get_data_stok();


		$this->load->view('v_grafik',$x);
    }

    function json_update_transaksi($kwitansi)
    {
        $trans=$this->db->from('transaksi_penerimaan')->like('no_kwitansi',$kwitansi)->get()->result();
        if(count($trans)!=0)
        {
            $this->db->set('status',1);
            $this->db->where('no_kwitansi',$kwitansi);
            $this->db->update('transaksi_penerimaan');
            echo "Data Transaksi Berhasil Di Ubah";
        }
        else
        {
            echo "Data Transaksi TIdak Ditemukan";
        }
    }
    function test_printer()
    {

    }
}