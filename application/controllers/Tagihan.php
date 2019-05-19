<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once('Main.php');
class Tagihan extends Main {
    function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
    }
    public function index()
	{
		$data=array(
			'title' => 'Tagihan',
			'isi' => 'isi/tagihan/index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
		$this->load->view('index',$data);
    }
    
    public function form($id=-1)
    {
        $data['id']=$id;
        $this->load->view('isi/tagihan/form',$data);
    }
    public function data($id)
    {
        $data['id']=$id;
        $data['values']=$data['kelas']=array();
        $this->load->view('isi/tagihan/data',$data);
    }
    public function proses($id)
    {
        $siswa=$this->config->item('nsiswalower');
        $data['sis']='';
        $data['values']=$data['kelas']=array();
        if(!empty($_FILES['file']))
        {
            $data=$_POST;
            $file=$_FILES['file']['tmp_name'];
            $objPHPExcel = PHPExcel_IOFactory::load($file);
            
            $totalsheet=$objPHPExcel->getAllSheets();
            $sheetNames = $objPHPExcel->getSheetNames();
            $sheetCount = $objPHPExcel->getSheetCount();
            
            $data['sis']=$siswa;
            $max=[];
            for($i = 0;$i<$sheetCount;$i++)
            {
                $cell_collection = $objPHPExcel->setActiveSheetIndex($i)->getCellCollection();
                $arr_data=$data_value=[];
                //echo count($cell_collection);
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $dv = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    $type=PHPExcel_Cell_DataType::dataTypeForValue($dv);
                    if($type=='f')
                    {
                        $data_value=$objPHPExcel->getActiveSheet()->getCell($cell)->getOldCalculatedValue();
                    }
                    else
                    {
                        $data_value=$dv;
                    }
                    $arr_data[$row][$column] = $data_value;
                    // echo $row.'-';
                }

                // echo '<br>'.$i;
                // echo '<br>';
                // $data['header'][$sheetNames[$i]] = $header;
                $data['values'][trim($sheetNames[$i])] = $arr_data;
                $data['kelas'][$i] = trim($sheetNames[$i]);
            }
        }
        // echo '<pre>';
        // print_r($data['values']['sm2 b']);
        // echo '</pre>';
        $this->load->view('isi/tagihan/data',$data);
    }

    function kirim()
    {
       
        $data=$_POST;
        if(!isset($_POST['p_email']))
        {
            $kelas=$_POST['kelas'];
            foreach($kelas as $ik => $iv)
            {
            //  echo 'semua';
                    $data['n']=$n=$iv;
                    $data['v']=$v=$_POST['nama'][$n];
                    $data['Email']=$email=$_POST['email'][$n];
                    $data['Va']=$_POST['va'][$n];
                    $data['Spp']=$_POST['spp'][$n];
                    $data['Catering']=$_POST['catering'][$n];
                    $data['Jemputan']=$_POST['jemputan'][$n];
                    $data['JemputanClub']=$_POST['jemputan_club'][$n];
                    $data['Club']=$_POST['club'][$n];
                    $data['Investasi']=$_POST['investasi'][$n];
                    $data['Total']=$_POST['total'][$n];
                    foreach($v as $nk => $vv)
                    {
                            if($email[$nk]!='')
                            {
                        
                                    $data['vv']=$vv;
                                    $data['nk']=$nk;
                                    $d_email=str_replace(';',',',$email[$nk]);
                                    $d_email=str_replace(array(' ','/'),'',$d_email);
                                    // $to='fachran.nazarullah@gmail.com, widya.wuri.handayani@gmail.com';
                                    $htmlContent =$this->load->view('isi/tagihan/kirimemail',$data,TRUE);
                                    $to=$d_email;
                                    $subject='[Info] Tagihan Bulan '.getBulan($_POST['bulan']).' '.$_POST['tahun'].' Sekolah Alam Bogor';
                                    //$this->kirimemail($htmlContent,$to,$subject);
                            }
                    }
                        
            }
        }
        else
        {
            // echo '<pre>';
            // print_r($_POST);
            // echo '</pre>';
            foreach($_POST['p_email'] as $iv => $ik)
            {
                // echo '<pre>';
                // print_r($_POST['nama'][$iv]);
                // echo '</pre>';
                $data['n']=$n=$iv;
                $data['v']=$v=$_POST['nama'][$n];
                $data['Email']=$email=$_POST['email'][$n];
                $data['Va']=$_POST['va'][$n];
                $data['Spp']=$_POST['spp'][$n];
                $data['Catering']=$_POST['catering'][$n];
                $data['Jemputan']=$_POST['jemputan'][$n];
                $data['JemputanClub']=$_POST['jemputan_club'][$n];
                $data['Club']=$_POST['club'][$n];
                $data['Investasi']=$_POST['investasi'][$n];
                $data['Total']=$_POST['total'][$n];
                foreach($ik as $nk => $val)
                {
                    if($val=='on')
                    {
                        $vv=$v[$nk];
                        // echo $nk.' - '.$email[$nk].'<br>';
                        if($email[$nk]!='')
                        {
                        
                            $data['vv']=$vv;
                            $data['nk']=$nk;
                            // $d_email=str_replace(';',',',$email[$nk]);
                            $em=explode(';',$email[$nk]);
                            $d_em=array();
                            foreach($em as $kem=>$vem)
                            {   
                                $split=explode('/',$vem);
                                foreach($split as $ks => $vs)
                                {
                                    $d_em[trim($vs)]=trim($vs);
                                }
                            }

                            if(count($d_em)!=0)
                            {
                                $d_email='';
                                foreach($d_em as $kd=>$vd)
                                {
                                    $d_email.=$vd.',';
                                }
                                $d_email=substr($d_email,0,-1);
                                // $d_email=str_replace(array(' ','/'),'',$d_email);
                                // $to='fachran.nazarullah@gmail.com, widya.wuri.handayani@gmail.com';
                                // $this->load->view('isi/tagihan/kirimemail',$data);
                                $data2['htmlContent']=$htmlContent =$this->load->view('isi/tagihan/kirimemail',$data,TRUE);
                                $data2['to']=$to=$d_email;
                                $data2['subject']=$subject='[Info] Tagihan '.$vv.' Bulan '.getBulan($_POST['bulan']).' '.$_POST['tahun'].' Sekolah Alam Bogor';
                                $this->kirimemail($htmlContent,$to,$subject);
                            }
                            // echo '<pre>';
                            // print_r($data2);
                            // echo '</pre>';
                        }
                    }
                }
            }
        }
        $this->session->set_flashdata('pesan','Email Tagihan Berhasil Dilakukan');
        // $dd=['spp','catering','jemputan','jemputan_club','club','investasi','total'];
        // $jenis_level=$this->config->item('jenispenerimaanlevel');
        // $siswa=$this->config->item('nsiswalower');
        // $vbatchsiswa=$this->config->item('vbatchsiswa');
        // $ttagihanbybulan=$this->config->item('ttagihanbybulan');
        // // echo '<pre>';
        // // print_r($jenis_level['jemputan']);
        // // print_r($vbatchsiswa);
        // // echo '</pre>';
        // $bln=$_POST['bulan'];
        // $thn=$_POST['tahun'];
        // $tahun_ajaran='2017 / 2018';
        // if($bln >=7 && $bln <=12)
        // {
        //     $tahun_ajaran=$thn.' / '.($thn+1);
        // }
        // else
        // {
        //     $tahun_ajaran=($thn-1).' / '.$thn;
        // }
        // $level=strtolower($data['level']);
        // //echo $data['level'].'<br>';
        // // foreach($dd as $dk => $dv)
        // // {
        // //     echo $dv.'<br>---<br>';
        //     foreach($data['nama'] as $k=>$v)
        //     {
        //         //echo '-----<br>';
        //         // echo $k.'<br>-----<br>';
        //         foreach($v as $kv => $vv)
        //         {
        //             $nama=trim(strtolower($vv));
        //             if(isset($siswa[$nama]))
        //             {
        //                 $sis=$siswa[$nama];
        //                 $nis=$sis->nis;
        //                 $id_siswa=$sis->id;
        //                 if(isset($vbatchsiswa[$nis]))
        //                 {
        //                     $batch=$vbatchsiswa[$nis];
        //                     $id_batch=$batch->id_batch;
        //                 }
        //                 else
        //                     $id_batch=0;
        //             }
        //             else
        //             {
        //                 $nis='';
        //                 $id_siswa=0;
        //                 $id_batch=0;
        //             }
        //             // echo $id_batch.'_'.$nis.':'.$nama.'<br>';
        //             // echo $level;
        //             // echo '<pre>';
        //             // print_r($jenis_level['program_pembelajaran']);
        //             // echo '</pre>';
        //             $level=trim($level);
        //             if($level=='pg')
        //                 $level='pg_';

        //             foreach($dd as $kd => $vd)
        //             {          
                        

        //                 if(substr($level,0,2)=='sd')
        //                 {
        //                     $level='sd';
        //                     if($vd=='investasi')
        //                     {
        //                         // echo $vd.'<br>';
        //                         $bln=7;
        //                         $thn=trim(strtok($tahun_ajaran,'/'));

        //                         $jvd='program_pembelajaran';
        //                         if(isset($jenis_level[$jvd][$level]))
        //                         {
        //                             // echo '<pre>';
        //                             // print_r($jenis_level['program_pembelajaran']);
        //                             // echo '</pre>';
        //                             $jns=$jenis_level[$jvd][$level];
        //                             $n_jenis=$jns->jenis;
        //                             $id_jenis=$jns->id;
        //                         }
        //                         else
        //                         {
        //                             if(isset($jenis_level[$jvd]['all']))
        //                             {
        //                                 $jns=$jenis_level[$jvd]['all'];
        //                                 $n_jenis=$jns->jenis;
        //                                 $id_jenis=$jns->id;
        //                             }
        //                             else
        //                             {
        //                                 $n_jenis='';
        //                                 $id_jenis=0;
        //                             }
        //                         }
        //                     }
        //                     else
        //                     {
        //                         $bln=$_POST['bulan'];
        //                         $thn=$_POST['tahun'];
        //                         if(isset($jenis_level[$vd][$level]))
        //                         {
        //                             $jns=$jenis_level[$vd][$level];
        //                             $n_jenis=$jns->jenis;
        //                             $id_jenis=$jns->id;
        //                         }
        //                         else
        //                         {
        //                             if(isset($jenis_level[$vd]['all']))
        //                             {
        //                                 $jns=$jenis_level[$vd]['all'];
        //                                 $n_jenis=$jns->jenis;
        //                                 $id_jenis=$jns->id;
        //                             }
        //                             else
        //                             {
        //                                 $n_jenis='';
        //                                 $id_jenis=0;
        //                             }
        //                         }
        //                     }
        //                 }
        //                 else
        //                 {
        //                     if($vd=='investasi')
        //                     {
        //                         // echo $vd.'<br>';
        //                         $bln=7;
        //                         $thn=trim(strtok($tahun_ajaran,'/'));
        //                         $jvd='program_pembelajaran';
        //                         if(isset($jenis_level[$jvd][$level]))
        //                         {
        //                             // echo '<pre>';
        //                             // print_r($jenis_level['program_pembelajaran']);
        //                             // echo '</pre>';
        //                             $jns=$jenis_level[$jvd][$level];
        //                             $n_jenis=$jns->jenis;
        //                             $id_jenis=$jns->id;
        //                         }
        //                         else
        //                         {
        //                             if(isset($jenis_level[$jvd]['all']))
        //                             {
        //                                 $jns=$jenis_level[$jvd]['all'];
        //                                 $n_jenis=$jns->jenis;
        //                                 $id_jenis=$jns->id;
        //                             }
        //                             else
        //                             {
        //                                 $n_jenis='';
        //                                 $id_jenis=0;
        //                             }
        //                         }
        //                     }
        //                     else
        //                     {
        //                         $bln=$_POST['bulan'];
        //                         $thn=$_POST['tahun'];
        //                         if(isset($jenis_level[$vd][$level]))
        //                         {
        //                             $jns=$jenis_level[$vd][$level];
        //                             $n_jenis=$jns->jenis;
        //                             $id_jenis=$jns->id;
        //                         }
        //                         else
        //                         {
        //                             if(isset($jenis_level[$vd]['all']))
        //                             {
        //                                 $jns=$jenis_level[$vd]['all'];
        //                                 $n_jenis=$jns->jenis;
        //                                 $id_jenis=$jns->id;
        //                             }
        //                             else
        //                             {
        //                                 $n_jenis='';
        //                                 $id_jenis=0;
        //                             }
        //                         }
        //                     }
        //                 }
        //                 $jlh=str_replace(',','',$data[$vd][$k][$kv]);
        //                 // echo $vd.'-'.$id_jenis.'-'.'-'.$n_jenis.'  :  '.$jlh.'<br>';
        //                 // echo '<pre>';
        //                 // print_r($data[$vd][$k][$kv]);
        //                 // echo '</pre>';
        //                 if($nis!='')
        //                 {
        //                     if($jlh!=0)
        //                     {
        //                         if($id_jenis!=0)
        //                         {
        //                             $inp=array();
        //                             if($n_jenis=='Program Pembelajaran')
        //                             {
        //                                 //echo $tahun_ajaran.'-'.$bln.'-'.$thn;
        //                                 if(!isset($ttagihanbybulan[$nis][$tahun_ajaran][$thn][$bln][$id_jenis]))
        //                                 {
        //                                     $inp['wajib_bayar']=$jlh;
        //                                     $inp['bulan']=$bln;
        //                                     $inp['tahun']=$thn;
        //                                     $inp['id_jenis_penerimaan']=$id_jenis;
        //                                     $inp['nis']=$nis;
        //                                     $inp['batch_id']=$id_batch;
        //                                     $inp['sisa_bayar']=$jlh;
        //                                     $inp['tahun_ajaran']=$tahun_ajaran;
        //                                     $inp['id_siswa']=$id_siswa;
        //                                     $this->db->insert('t_tagihan_siswa',$inp);
        //                                 }
        //                             }
        //                             else
        //                             {
        //                                     $inp['wajib_bayar']=$jlh;
        //                                     $inp['bulan']=$bln;
        //                                     $inp['tahun']=$thn;
        //                                     $inp['id_jenis_penerimaan']=$id_jenis;
        //                                     $inp['nis']=$nis;
        //                                     $inp['batch_id']=$id_batch;
        //                                     $inp['sisa_bayar']=$jlh;
        //                                     $inp['tahun_ajaran']=$tahun_ajaran;
        //                                     $inp['id_siswa']=$id_siswa;
        //                                     $this->db->insert('t_tagihan_siswa',$inp);
        //                             }
                                    
        //                             // echo $n_jenis;
        //                             // echo '<pre>';
        //                             // print_r($inp);
        //                             // echo '</pre>';
                                   
        //                         }
        //                     }
        //                 }
        //             }
        //             echo '<br>';
        //         }
        //     }
            // echo '<pre>';
            // print_r($_POST);
            // echo '</pre>';
            // redirect('tagihan','location');

        //     echo '------<br>';
        // }
        redirect('tagihan','location');
        // $data=array();
        // $htmlContent =$this->load->view('isi/tagihan/kirim',$data,TRUE);
        // $to='fachran.nazarullah@gmail.com, widya.wuri.handayani@gmail.com';
        // $subject='[Info] Tagihan Bulan November 2017 Sekolah Alam Bogor';
        // $this->kirimemail($htmlContent,$to,$subject);
        // $inp['jumlah_bayar']=
        // $inp['bulan']=
        // $inp['tahun']=
        // $inp['id_jenis_penerimaan']=
        // $inp['nis']=
        // $inp['batch_id']=
        // $inp['sisa_bayar']=
        // $inp['tahun_ajaran']='2017 / 2018';
        // $inp['id_siswa']=;
    }
}