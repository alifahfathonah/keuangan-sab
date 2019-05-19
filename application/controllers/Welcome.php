<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function index()
	{
		// $data['d']=$this->load->view('index.html','',TRUE);
		$this->load->view('welcome_message');
	}
	function readsiswabaru()
	{
		$file=file_get_contents('assets/files/siswabaru_2018_2019.csv');
		$fl=explode("\n",$file);
		$x=0;
		foreach($fl as $k => $v)
		{
			if($k!=0)
			{
				$d=explode('::',$v);
				// echo ++$k.'-'.count($d).'<br>';
				$data[$x]['nama_murid']=$d[1];
				$data[$x]['nama_panggilan']=$d[2];
				$data[$x]['jenis_kelamin']=$d[3];
				$data[$x]['nis']=$data[$x]['nisn']=$d[4];
				$data[$x]['alamat']=$d[7];
				$data[$x]['nama_ayah']=$d[8];
				$data[$x]['hp_ayah']=$d[9];
				$data[$x]['nama_ibu']=$d[10];
				$data[$x]['hp_ibu']=$d[11];
				$data[$x]['email_ayah']=$data[$x]['email_ibu']=$d[12];
				$ttl=$d[6];
				list($tmp,$tgl)=explode(',',$ttl);
				$data[$x]['tempat_lahir']=$tmp;
				$data[$x]['tanggal_lahir']=date('Y-m-d',strtotime($tgl));
				// echo date('Y-m-d',strtotime($tgl)).' : '.$tgl.'<br>';
				$x++;
			}
		}
		$this->db->insert_batch('t_siswa', $data);
		$data2 = array(
			array(
				'title' => 'My title' ,
				'name' => 'My Name' ,
				'date' => 'My date'
			),
			array(
				'title' => 'Another title' ,
				'name' => 'Another Name' ,
				'date' => 'Another date'
			)
		);
		// echo '<pre>';
		// print_r($data2);
		// print_r($data);
		// echo '</pre>';
	}
	function readjsonsiswa()
	{
		$url="http://akademik.sekolahalambogor.id/view/siswa/json_siswa.php";
		$data=file_get_contents($url);
		$siswa=json_decode($data,true);
		$sis=array();
		//echo count($siswa);
		$namasiswa=$this->config->item('nsiswalower');
		$nisnsiswa=$this->config->item('nisnsiswa');
		foreach($siswa as $k => $v)
		{
			$nama=strtolower($v['nama']);
			if(isset($namasiswa[$nama]))
			{
				$n=$namasiswa[trim($nama)];
				if($n->nisn!=$k)
				{
					echo '<span style="color:green">'.$n->nisn.' - ['.$k.'] : '.$n->nama_murid.'</span><br>';
					// echo 'UPDATE t_siswa SET nisn="'.$k.'" WHERE id='.$n->id.';<br>';
				}
				// 	echo '<span style="color:pink">'.$n->id.' : '.$n->nama_murid.'</span><br>';
				// else
			}
			else
			{
				if(isset($nisnsiswa[trim($k)]))
				{
					//$nn=$nisnsiswa[$k];
					//echo '<span style="color:blue">'.$nn->nisn.' - ['.$k.'] : '.$nn->nama_murid.'</span><br>';
				}
				else
				{
					echo '<span style="color:red">'.$k.' : '.$v['nama'].'</span><br>';
					
				}
			}
		}
	}
	function readExcel()
	{
		// $file = 'assets/files/PG 2016-2017.xlsx';
		$sis=$this->config->item('nsiswalower');
		$ss=array();
		foreach($sis as $idx=>$item)
		{
			$ss[$idx]=$idx;
		}
		$sisnis=$this->config->item('nisnsiswa');
		$file = 'assets/files/Data NIS.xlsx';
		//load the excel library
		$this->load->library('excel');
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		//get only the Cell Collection
		// $i = 2;
    	for($i=0;$i<=2;$i++)
    	{
    		$objPHPExcel->setActiveSheetIndex($i);
			$sheetName=$objPHPExcel->getSheetNames();
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			// echo '<pre>';
			// echo '</pre>';
			foreach ($cell_collection as $cell)
			{
			    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			    // $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getFormattedValue();
			 //    if(strstr($data_value,'=')==true)
				// {
			 //    	$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getCalculatedValue();
				// }
				// $InvDate="";
				// if($data_value!='')
				// {
				// 	if(PHPExcel_Shared_Date::isDateTime($data_value)) {
				// 	     $InvDate = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($InvDate));
				// 	}
				// }
		    //header will/should be in row 1 only. of course this can be modified to suit your need.
			    // if ($row == 1)
			    // {
			    //     $header[$row][$column] = $data_value;
			    // } else {
			        $arr_data[$row][$column] = $data_value;
			        // $tgl_data[$row][$column] = $InvDate;
			    // }
			}
		//send the data in an array format
			// $data['header'] = $header;
			$data[$sheetName[$i]]['values'] = $arr_data;
		}
		$i--;
		// $data['tgl'] = $tgl_data;

		// echo '<pre>';
		// print_r($data['Sheet1']['values']);
		// echo '</pre>';
		$lost=0;
		$siswa=$s_nis=array();
		foreach($data['Sheet1']['values'] as $k => $v)
		{
			$n=trim(strtolower($v['C']));
			$siswa[$n]=$n;
			$s_nis[$v['B']]=$v['B'];
			// if(isset($sis[$n]))
			// {
			// 	echo '<span style="color:blue">ID SISWA : '.$sis[$n]->id.' :: NIS : '.$v['B'].' :: '.$sis[$n]->nama_murid.'</span>';
			// 	echo '<br>';
			// 	// $this->db->set('nisn',$v['B']);
			// 	// $this->db->where('id',$sis[$n]->id);
			// 	// $this->db->update('t_siswa');
			// }
			// else
			// {
			// 	if(isset($sisnis[$v['B']]))
			// 	{
			// 		//echo '<span style="color:blue">'.$v['B'].'-'.ucwords($n).' :: '.$sisnis[$v['B']]->nama_murid.'</span>';
			// 	}
			// 	else{

			// 		echo '<span style="color:red">'.$v['B'].'-'.ucwords($n).' :: --------------------</span>';
			// 		$lost++;
			// 		if(strpos($n,'(')!==false)
			// 		{
			// 			list($nm,$np)=explode('(',$n);
			// 			$np=str_replace(array('(',')'),'',$np);
			// 		}
			// 		else
			// 		{
			// 			$nm=$n;
			// 			$np=$v['D'];
			// 		}
			// 		$inp['nis']=$v['B'];
			// 		$inp['nisn']=$v['B'];
			// 		$inp['nama_murid']=ucwords($nm);
			// 		$inp['nama_panggilan']=$np;
			// 		$inp['jenis_kelamin']=null;
			// 		//$this->db->insert('t_siswa',$inp);
			// 		// echo '<pre>';
			// 		// print_r($inp);
			// 		// echo '</pre>';
			// 	}
			//}
		}
		// $ar=isInArray($ss,$siswa);
		// echo '<pre>';
		// print_r(count($ss));
		// print_r(count($siswa));
		// echo '</pre>';
		foreach($ss as $ks => $vs)
		{
			if(!in_array($vs, $siswa))
			{
				if(!in_array($sis[$vs]->nisn,$s_nis))
					echo ucwords($vs).'<br>';
			}

		}
		//echo 'LOST DATA : '.$lost;
		// file_put_contents('assets/files/SD_'.$sheetName[$i].'_2017.txt', print_r($data,true));
		// file_put_contents('assets/files/SD_'.$sheetName[$i].'_2017_serialize.txt', serialize($data));
		// file_put_contents('assets/files/SD_'.$sheetName[$i].'_2017_json.json', json_encode($data));
	}
	function waktu()
	{
		echo date("Y-m-d", 4259142591);
	}
	function bacaexcel()
	{
		// $a = array('foo' => 'fooMe');
		// $b= serialize($a);

		// $a = unserialize($b);
		// echo gettype($b);
		// echo $a;
		$dttt=$this->config->item('nsiswa');

		$file = 'assets/files/SD_maret_2017_json.json';
		$read=file_get_contents($file);
		$rd=json_decode($read);
		// echo '<table border="1" width="100%">';
		$data=$dd=array();
		$nama='';
		foreach ($rd as $kr => $vr)
		{
			$bulan=getBulanReverse(ucwords($kr));
			// echo $bulan;
			foreach ($vr as $kv => $vv)
			{
				// if($kv==1)
				// {
				foreach ($vv as $ky => $ve) {
					if($ky>3)
					{

						// echo '<tr>';
						$x=0;
						foreach ($ve as $ke => $ve)
						{
							$x++;
							// if()
							if($ke=='B')
							{

							}

							// if($ke>'F')
							// {
							if($ve!='')
							{

								if($x%2!=0)
								{
									// echo '<th>'.str_replace(',', '', $ve).'</th>';
								}

								if($ke=='B')
								{
									if(isset($dttt[$ve]))
									{
										$nama=$dttt[$ve]->id;
										$data[$bulan]['nama'][]=$nama.'__'.$ve;
									}
									// echo '<th>'.$nama.'</th>';
								}
							}
							if($x>=2)
							{
								if($x==3 || $x==4 || $x==5)
									continue;

								if($x%2==0)
								{
									if($ve!='')
									{
										if(strstr($ve, '-')!==false)
										{
											list($tg,$bl)=explode('-', $ve);
											// echo '<th>'.$ve.'</th>';
											$bl=getBulanReverse($bl);
											// echo '<th>2016-'.$bl.'-'.$tg.'</th>';
											$data[$bulan]['tanggal'][$nama][]='2016-'.$bl.'-'.$tg;
										}
										else if(strstr($ve, '/')!==false)
										{
											list($bl,$tg)=explode('/', $ve);
											// $bl=getBulanReverse($bl);
											// echo '<br><th>2016-'.($bl).'-'.$tg.'</th><br>';
											// echo $ve;
											$data[$bulan]['tanggal'][$nama][]='2016-'.$bl.'-'.$tg;
										}
									}
									// else

										// echo
								}
								else if($x%2==1)
									$data[$bulan]['jumlah'][$nama][]=str_replace(',', '', $ve);
							}

							// }
							// }
						}
						// echo '</tr>';
					}
				}
				// }
			}
		}
		// echo '</table>';

		// echo '<pre>';
		// print_r($data[8]['nama']);
		// echo '</pre>';
		foreach ($data as $kd => $vd)
		{
			echo $kd.'<br>------------------<br>';
			foreach ($vd['nama'] as $k => $v)
			{
				list($idsis,$nmsis)=explode('__', $v);
				// echo '<pre>';
				if(isset($vd['tanggal'][$idsis]))
				{
					// echo $idsis.'-'.$nmsis.'<br>';
					$dd['siswa_id']=$idsis;
					$dd['status_tampil']='t';
					$cek=$this->db->from('t_tabungan')->where('siswa_id',$idsis)->get()->result();
					if(count($cek)==0)
					{
						$saldo=0;
						$this->db->insert('t_tabungan',$dd);
						$idtab=$this->db->insert_id();
					}
					else
					{
						$saldo=$cek[0]->saldo;
						$idtab=$cek[0]->id;
						$this->db->where('id',$idtab);
						$this->db->update('t_tabungan',$dd);
					}
					foreach ($vd['tanggal'][$idsis] as $ki => $vi)
					{
						if(isset($vd['jumlah'][$idsis][$ki]))
						{
							$d['siswa_id']=$idsis;
							$jlh=$vd['jumlah'][$idsis][$ki];
							if (DateTime::createFromFormat('Y-m-d', $vi) !== FALSE)
							{
							  // it's a date
								if($jlh!='' && $jlh!=0)
								{

									$det['tabungan_id']=$idtab;
									$det['jumlah']=$jlh;
									$det['jenis']='setor';
									$det['penyetor_penarik']=$nmsis;
									$det['tanggal']=$vi;
									$det['status_tampil_det']='t';
									$this->db->insert('t_tabungan_detail',$det);
									$saldo+=$jlh;
									//echo $vi.':'.$jlh.'<br>';
								}
							}
						}
						$de['saldo']=$saldo;
						$de['last_update']=date('Y-m-d H:i:s');
						$this->db->where('id',$idtab);
						$this->db->update('t_tabungan',$de);
						// echo '<pre>';
						// print_r();
					}
				}
				// print_r($vd['jumlah'][$idsis]);
				// echo '</pre>';
			}
		}
	}
	function saldoawal()
	{
		$d=array(
			"Agha Danish Athif Putra"=>"0",
			"Ahmad Anggara Prayoga "=>"6500200",
			"Ahmad Ghazi Makkasau Muslimin "=>"13996000",
			"Ahmad Haqqi Parombeang Muslimin "=>"13996000",
			"Ahmad Rayesha Zaidanararya "=>"36800",
			"Ahmad Shofwan Isy Kariman"=>"340",
			"Aisya Lubnaa Az-Zahra"=>"10000",
			"Alila Khairunazhifa"=>"200000",
			"Althaf Athaayaa Thufail"=>"402000",
			"Alya Syakira"=>"7000",
			"Anwar Zulfikar Leendertz"=>"3080000",
			"Argya Alif Athillah"=>"0",
			"Arya Nayaka Wicaksana "=>"2421000",
			"Aulia Aisyah Azka"=>"1045500",
			"Aunurrahman Ramy Al-Ghazy"=>"246500",
			"Azizah Mutiara Zahra"=>"75000",
			"Barra Fakhri Adila "=>"0",
			"Brahma Inggil Sadewoto"=>"93000",
			"Chalisya Mahira Ismaulida"=>"3409000",
			"Danish Abrisam "=>"60250",
			"Darrel Diandra Pawasa "=>"15000",
			"Emeraldy Ibel Bramudya"=>"117100",
			"Fadel Muhamad Radhin"=>"91000",
			"Fairuz Athaya Khairunnisa"=>"337000",
			"Faiz Praditya"=>"11310600",
			"Faqih Aryo Seto Handoko"=>"573000",
			"Faris Novandri Ciptono"=>"4700",
			"Fathimah Yasmina Zahra"=>"0",
			"Fauzi Akbar Sinaga"=>"10000",
			"Fayyaza Kayla Aqmarina"=>"18405000",
			"Fedya Chalisa Humaedi"=>"830000",
			"Firas Tajuzaman Ramadhan"=>"202000",
			"Giana Putri Alfajri Haniyah"=>"142000",
			"Hanzhalah Al Farih"=>"12400",
			"Harits Dhiyaurrahman"=>"1118000",
			"Ilma Nurul Fathia"=>"409000",
			"Irgidhia Rizky Octara "=>"21000",
			"Jeanne Diva Ganesya"=>"0",
			"Kayyisa Humaira Aziza"=>"118800",
			"Kezia Neubrina Zara"=>"80000",
			"Khalil Muzakki "=>"444300",
			"Malika Audry Divadriansyah"=>"650000",
			"Manggara Azizan Rabbani Siregar"=>"64000",
			"Mauris Tasyarraqa Gaharu "=>"823000",
			"Muhammad Daffa Baehaqie "=>"52300",
			"Muhammad Faiz Arsyad"=>"16350",
			"Muhammad Hilmi Musyafa"=>"35000",
			"Muhammad Mufid"=>"9000",
			"Muhammad Rafif Razzan Chaidar"=>"54500",
			"Muhammad Rauza Rantissi"=>"0",
			"Muhammad Salman Zhafran"=>"558600",
			"Mutia Salsabila"=>"145000",
			"Nabiel Hafizd Mustopha"=>"13000",
			"Nadyne Valiqa Myshanti "=>"181400",
			"Najma Nadhira "=>"48000",
			"Raden Hadi Arif Rahman "=>"0",
			"Rania Alifa Abrar"=>"0",
			"Raya Ramadhani"=>"340600",
			"Reivan Malik "=>"3596330",
			"Renaya Auliaputri Risdiyanto "=>"177000",
			"Rezyana Assyifa Qalbi Maruli"=>"173800",
			"Rizky Kevin Muhammad"=>"28000",
			"Safira Zwidescha Humaira "=>"408800",
			"Syarifah Jilan Dzikra"=>"126300",
			"Terra Radya Rizqy Angkasa Susanto Putra "=>"48600",
			"Zaakiyah Harsya"=>"819450",
			"Jenar Naura"=>"5415000",
			"Maritza Zachra Gunasenjaya "=>"0",
			"Farrel Maula Alexandria Malik"=>"659000",
			"Yusuf Muzafar"=>"10000",
			"A'ida Hasna Hunafa"=>"759000",
			"Anas Ahsanu Amal"=>"783100",
			"Ibrahim Muhamad"=>"300",
			"Arga Purnomo"=>"160360",
			"Farrel Ahmad Rooseno"=>"7640",
			"Hana Fayyaza Hazimatul Khair"=>"81170",
			"Khairunnisa Qonita Rafifah"=>"71700",
			"M. Arfa Hamizan"=>"0",
			"M.Al-Ahya Syahidin Saputra"=>"1315640",
			"Malisha Zaffarana"=>"3826000",
			"Mifzal Arif Maulana"=>"59040",
			"Muhammad Azka Ziyadatullah"=>"131000",
			"Muhammad Khadafi permana"=>"160330",
			"Muhammad Razan Nugraha"=>"243350",
			"Nasya Geovani Latief"=>"467400",
			"Pradipa Ikhlashul Hilmi"=>"481330",
			"Salma Nayla Hakim"=>"137680",
			"Sheila Fatima Ali"=>"391000",
			"Tengku Muhammad Fathi Yakan"=>"192160",
			"Adnan Khairy Kusuma"=>"41750",
			"Ahmad Affa Assalamy"=>"534850",
			"Alifa Fitri Arni Azizah"=>"1689990",
			"Aqila Qudsi Muthmainnah"=>"85500",
			"Vara Zahrani Zaira"=>"32500",
			"Azmi Fikri Arkana Rizki"=>"458450",
			"Brahman Ahmad Syailendra"=>"435800",
			"Danissa Rizki Indira"=>"7400",
			"Hamid A. Maulana"=>"64340",
			"Hasna Dzakira Kartiadi"=>"317000",
			"Laiqa Afifah Wibowo"=>"421330",
			"M. Fadhli Alfarizi"=>"0",
			"Mahira Hasna Wahyudi"=>"547100",
			"Matahari Deva Ramadhan"=>"20100",
			"Cati Bilang Pandai"=>"7000",
			"Najla Aulia Putri Sandy"=>"70000",
			"Najwan Fauzan Azhima Urasid"=>"0",
			"Natane Almaprilia Saliha"=>"80950",
			"Ravady Adra Kautsar"=>"106250",
			"Rafie Satrio Akmal Wiryawan"=>"286600",
			"Razan Fajar Raspati"=>"23070",
			"Salwa Saniyya Yerrie"=>"850510",
			"Trystan Muhammad Almuzani"=>"0",
			"A.M Rajendra Rabih Perkasa"=>"0",
			"Abdul Aziz Alfaruqi"=>"276000",
			"Affan Salim Yuan Utomo"=>"109150",
			"Ahmad Aufa Hakim"=>"47600",
			"Alexandra Queena Ramadhani Sulistyo"=>"36000",
			"Alika Siti Zahra"=>"216350",
			"Amira Zalfa Muthia"=>"1160000",
			"Anindya Fidelya Ibnaty "=>"225350",
			"Arif Muhammad Iqbal"=>"102630",
			"Azman Nafis Fuaddy"=>"1390100",
			"Erlangga Widharma Chayadi"=>"1138170",
			"Fazly Mawla Rafi"=>"56350",
			"Hadyatin Khairin Leasa"=>"204000",
			"M. Aqila Zulfa Sulaiman"=>"552500",
			"Nafis Hamzah Kautsar"=>"185700",
			"Narda Athaya Ali"=>"30000",
			"Raihan Ramadhan Putra Zifwen"=>"103500",
			"Rasya Nur'aqilla"=>"92550",
			"Siti Fadhilah Setyowati"=>"439240",
			"Izzat"=>"295000",
			"Prajawalita Mutia (Aya)"=>"515000",
			"Muhammad Baihaqi Abdussani"=>"958000",
			"Kalea Dehan Majeeda"=>"820000",
			"Naufal Mumtaz Sudarta"=>"0",
			"Ahmad Fathan Abdurrahman"=>"1800000",
			"Alger Muhammad Ziv"=>"310500",
			"Alyndya Dara Ayu"=>"1275110",
			"Arsya Deanna Tatsbita"=>"276050",
			"Ferdiansyah Hilmi Ciptono"=>"268780",
			"Harits Afif Nuzwardy"=>"1358950",
			"Muhammad Fadly Andraya P"=>"213950",
			"Mohammad Abiyyu Ikhsan"=>"19600",
			"Muhammad Ahsan Fadillah"=>"37000",
			"Muhammad Daffa Grandia Hudaya"=>"44677",
			"Muhammad Fathel Balfas"=>"45980",
			"Muhammad Fauzan Farid"=>"56000",
			"Muhammad Isra Abyan Syah"=>"192150",
			"Muhammad Tamam Muhyidin"=>"138000",
			"Najmah Atikah Mumtazah"=>"0",
			"Nisrina Najwa"=>"462250",
			"Nissa Syauqina Qintani"=>"0",
			"Pelangi Cahya Qur'ani"=>"186900",
			"Raehanita Janur Sasi"=>"133000",
			"Sayyid Fakhri Nurjundi"=>"220000",
			"Shabrina Hafidzati Hirzi (idza/shabrina)"=>"699000",
			"Almira Rida"=>"7000",
			"Alia Rahma"=>"220000",
			"Abiyyuta Ahsan"=>"382000",
			"Ahmad Tsaqif Ikhsan"=>"13400",
			"Akhdan Naufal Rabbani"=>"376700",
			"Alwan Muhammad Zaidan "=>"79000",
			"Abiyu Tsakif"=>"66500",
			"Davin Imanullah"=>"80150",
			"Elang Muhammad Tzar"=>"111150",
			"Fathan Khaizuran"=>"91800",
			"Hafidzan Izzudin Iman"=>"104050",
			"Hudzaifah Al Fadhil"=>"19000",
			"Jourast Buwana"=>"0",
			"Kayla Fathiya Anindita"=>"287000",
			"Khairul Kahfi"=>"549650",
			"Muhammad Abiyya Taufiqurrahman"=>"177220",
			"Muhammad Adzka Mutafannin"=>"246550",
			"Muhammad Zhafir Aufar"=>"500",
			"Nazzala Hanif Aghnati"=>"258500",
			"Nida Qotrunnada"=>"401100",
			"Raden Pandu Rahmadi"=>"0",
			"Siti Anisa"=>"25200",
			"Nabila Nurul"=>"279400",
			"Abbiyan Izzan Muhammad"=>"0",
			"Adnan Maulana Husein"=>"0",
			"Afifah Mufidah Mardhiyah"=>"0",
			"Afifah Rahma Putri"=>"0",
			"Agnia Paradisa Mayla Sandy"=>"0",
			"Ahmad Rafi Ibrahim"=>"0",
			"Ahmad Rey Rasydan"=>"0",
			"Almayra Windya Mulya"=>"0",
			"Althea Kinandita Ardi"=>"0",
			"Alya Alzafira Zaira"=>"0",
			"Alyssa Dinar Raharjo"=>"0",
			"Amira Nadha Nadira"=>"0",
			"Aqila Hamizan Rifti"=>"0",
			"Arisha Fauzia Hamzah"=>"0",
			"Arisha Qurrotu'ayunina (Icha)"=>"0",
			"Arsanta Zikri Danaputra"=>"0",
			"Athiyyah Maryam Al Hamasah"=>"0",
			"Azzam Rizki Fauzan Alim"=>"0",
			"Bentang Inspirasi Prasojo"=>"0",
			"Chezia Inandhira Mirza"=>"0",
			"Damara Ovilia Ardanareswari"=>"0",
			"Deanova Flandrina Sartono"=>"0",
			"Fadhil zharif kautsar"=>"0",
			"Faiz Arkan Muhammad"=>"0",
			"Faiza Danish Nuzwardy"=>"0",
			"Fayyadh Shidqi Hanif"=>"0",
			"Faza Rasyid Muhammad"=>"0",
			"Hasbi Fadhal Abqari"=>"0",
			"Hasna Siti Rahima"=>"0",
			"Inara Maulida Al Aris"=>"0",
			"Kayla Nadhira Adestri"=>"0",
			"Keira Ghaisani Tsabitah"=>"0",
			"Khalisa Husnaa Fauziyah"=>"0",
			"Khayra Mazaya Darmawan"=>"0",
			"Leandrea Aushafa Baehaqie (Rara)"=>"0",
			"Lily Rebilla Azzahra"=>"0",
			"Lintang Arafasena Wibowo"=>"0",
			"Malika Kei Amabel"=>"0",
			"Maritza Nathania Nareswari"=>"0",
			"Maryam Naila Farhana"=>"0",
			"Muhamad Ahsan Ibrahim"=>"0",
			"Muhammad Daanish"=>"0",
			"Muhammad Farras Arsyad"=>"0",
			"Muhammad Farras Fawaid"=>"0",
			"Muhammad Hamdan Muzaki"=>"0",
			"Muhammad Khairan Athaya (Ilan)"=>"0",
			"Muhammad Rayyan Mantasya"=>"0",
			"Nadia Rahmah"=>"0",
			"Namira Mumtaz Rayhanna (Ima)"=>"0",
			"Nasywa Sakhi Alisha Nugroho"=>"0",
			"Nayaka Wening Ratnakanya"=>"0",
			"Nyimas Karen Audrey"=>"0",
			"Qorri Khairunnisa"=>"0",
			"R. Mochamad Kenzie Raditiansah S.P"=>"0",
			"Raditya Kresna"=>"0",
			"Raissa Zahirah Tauliah"=>"0",
			"Raka Sweca Dewantara Agung"=>"0",
			"Rayana Aiman Nitisara"=>"0",
			"Rayyan Prabha Adityawarman"=>"0",
			"Rayyis Lutfan"=>"0",
			"Rifat Abdillah Harsya"=>"0",
			"Rifqi Rabbani Putra Zifwen"=>"0",
			"Salima Naziha Aldjoeffry"=>"0",
			"Samudera Ridzki"=>"0",
			"Siti Nur Kaila Fatimatuzzahra"=>"0",
			"Siti Queenza Khairunnisa"=>"0",
			"Sophia Danishine Ari Sudjono"=>"0",
			"Wildania Ihsan Alimah Nugroho"=>"0",
			"Yasmin Qirani Firdaus"=>"0",
			"Yazid Mytrevin Ariwidagdo (Zizou)"=>"0",
			"Zentristan Vitadi"=>"0",
			"Zoevanya Vitadi"=>"0",
			"Abram Muzhafara Alam"=>"35000",
			"Aisyah Davina Putri"=>"957000",
			"Ajeng Naila Salsabil"=>"2185300",
			"Alden Wajdiraissa Yuzdiputera"=>"0",
			"Ali Hafiz Al Qilbran"=>"0",
			"Alvaro Yusuf"=>"0",
			"Alya Naila Rahmah"=>"589500",
			"Amira Hasna Saajida"=>"218000",
			"Anas Rachmat Julianto"=>"156000",
			"Andisa Zahra Asari"=>"240000",
			"Arfa Diya Athillah"=>"50000",
			"Arsyad Kaisar Hakam"=>"140000",
			"Azka Aida Awathif"=>"717000",
			"Badar Muhammad Al Fath"=>"0",
			"Cirrus Arfaisa Nashr"=>"21000",
			"Daniswara Aghna Andi Baso"=>"534000",
			"Darin Syahgian Haradika"=>"14000",
			"Dennis Satria Annajm"=>"555000",
			"Fahran Alvito"=>"0",
			"Fairy Shofwah Nurwandi"=>"1725000",
			"Fathiriva Aydin Adiguna"=>"2630000",
			"Fatina Azmi Saira N"=>"432700",
			"Fayyadh Pradipta Adityawarman"=>"404500",
			"Galuh Borneasakhi Aisha"=>"726000",
			"Hana Hanifah Anwar"=>"194500",
			"Hashyna Rancag Haqannisa"=>"165000",
			"Ibrahim Hafiz Dereindra"=>"8000",
			"Jinan Khansa"=>"118000",
			"Kameela Safina Puteri"=>"375000",
			"Kanaya Maulida Rahmadianita"=>"3110000",
			"Lativa Bilqis"=>"113000",
			"Luthfi Fadhil Nurghozah"=>"280000",
			"Maharayya callysta Puteri"=>"1005000",
			"Maliq Keandra Juari"=>"1800000",
			"Marco Aydin Hylmi Iskandar"=>"40000",
			"Muhammad Basyir Arroyyan"=>"250000",
			"Muhammad Fadhli Widiansyah"=>"1000000",
			"Muhammad Fahran Dzulfikri"=>"280000",
			"Muhammad Faris Al Fatih"=>"701000",
			"Muhammad Fathan Syathir"=>"325000",
			"Muhammad Iyaz Lazuardi Syah"=>"577000",
			"Muhammad Khalid Hisyam F."=>"62000",
			"Muhammad Raffi Vatian"=>"482000",
			"Muhammad Shafa Ashidqi"=>"2043000",
			"Muhammad Syamil Zulfa Sulaiman"=>"707000",
			"Muhammad Zaidan Ahsan"=>"960000",
			"Nabil Fiqrus Safianski"=>"145000",
			"Nadya Fayza Aulia"=>"190000",
			"Najwan Auf Awwadi"=>"228000",
			"Naylana Khansa Janeeta"=>"1170000",
			"Nievanni Arfitomy Anandyatama D"=>"1706500",
			"Priyarsya Rahhaxel Firman"=>"210000",
			"Qarizha Ainiyah Wardana N"=>"0",
			"Raden Naimah Yasmin Fauziah G"=>"621000",
			"Raditya Aidan Nuha"=>"1050000",
			"Raisha Amalia Syahrazad"=>"0",
			"Rakha Afzaal Shahan P"=>"179000",
			"Rashya Aulia Ahmad"=>"367000",
			"Rifqi Nuh Ratnadi"=>"374000",
			"Samanadra Taqeya Lesmana"=>"160000",
			"Satriyo Adi Abdurrofi"=>"1015000",
			"Shafira Azzahra Jundiya"=>"355000",
			"Syaza Pavarty Acvim"=>"115000",
			"Syifa Bawazier"=>"22000",
			"Thadea Agni Rahutomo"=>"2900000",
			"Wafi Biahdillah"=>"0",
			"Zakiyah Rizqi Aviani"=>"4000",
			"Zetrapatti Egantheon I"=>"375000",
			"Zhevania Sajida Muamar"=>"0",
			"M shafiq Danish"=>"0",
			"anonim"=>"0",
			"Adi Ilmi Faeyza"=>"218500",
			"Agastya Ratih"=>"221000",
			"Agna Shakila Madarum (Anya)"=>"1027000",
			"Ahmad Akhukum Fillah (Fillah)"=>"101000",
			"Aisha Kireina Rahma (Aisha)"=>"256000",
			"Aisyahrani Hendra"=>"326000",
			"Albani Rayfano"=>"1600000",
			"Alia Afida Sulha"=>"140000",
			"Almira Kamilia Fata"=>"792000",
			"Alya Fadillah Ramadhani"=>"640800",
			"Ammar Musyaffa Arkan"=>"2000",
			"Annida Khairani Hirzi"=>"225800",
			"Aqeela Zahia Rahman"=>"635000",
			"Athaya Phiula Azunti"=>"646000",
			"Aulia Hafizh Wahdy"=>"42000",
			"Bhagaskara Rheno Mahardika"=>"0",
			"Dzaki Althaf Imran"=>"859500",
			"Ernesto Dau Naje"=>"141000",
			"Fabiyan Fathan Nazhari"=>"0",
			"Fabyan Muhammad Almuzani"=>"0",
			"Fachry Apriliansyah"=>"804500",
			"Fahri Roiza"=>"757800",
			"Faris Muhammad Izzuddin"=>"260000",
			"Farrel Mohammad Pasha"=>"113000",
			"Gavin Meileka Bachin"=>"40900",
			"Hanafi Akira Tsuzuki"=>"111000",
			"Hanifa Ariana Shafa"=>"566000",
			"Inaya Dzil Izzati"=>"911000",
			"Ismail Hilmi Fathurrahman"=>"0",
			"Kalyandra Endhita (Theta)"=>"4786400",
			"Khadeeja Saifa Hadidharma (Deeja) "=>"107000",
			"Khansa Malika Darmawan"=>"134500",
			"Khansa Shabihah Putri Kusnadi"=>"35000",
			"Laluna Rienyani Muhammad"=>"231800",
			"Luthfi Zaky Faizin"=>"212950",
			"Muhammad Syahmi Firdaus"=>"0",
			"Muhammad Akbar"=>"362000",
			"Muhammad Fatih Ilmi Sandy"=>"0",
			"Muhammad Fauzan Harun P."=>"41800",
			"Maharani Anindya Khansa"=>"782750",
			"Muhammad Firzatullah Setia Putra"=>"94100",
			"Muhammad Rafa Aulia"=>"34000",
			"Mullah Muhammad Umar"=>"63000",
			"Myula Aimee Fathena"=>"36000",
			"Nashirah Rahadatul Aisy"=>"747900",
			"Naura Arasy Izdihar"=>"119200",
			"Nisrina Syifa Rafifah"=>"773000",
			"Nurrasyid Syahmi Abbasy (Syahmi)"=>"0",
			"Nyimas Fathia Kalila Puteri Maharrani"=>"86000",
			"Padma Riansyah Adigana"=>"1100000",
			"Raissa Syahmi Irawan (Esa)"=>"16500",
			"Rama Dehan Mukhtarul Haq"=>"279000",
			"Rana Zahra Nailal Husna"=>"202500",
			"Ranala Radya Danalaga"=>"5300",
			"Raqilla Malka Firdaus"=>"0",
			"Rayan Alfreda Masood"=>"192500",
			"Rizki Anindya Putri"=>"393950",
			"Sachi Myaisha"=>"293200",
			"Safa Tsabitah Zahra"=>"89000",
			"Sasha Camilla"=>"368000",
			"Satya Ghazi Abdillah Nugroho"=>"0",
			"Sayyida Naila Dhia"=>"50500",
			"Sayyidah Tsabita Mir'at Qonita"=>"1347500",
			"Sharen Lathifa Lubis"=>"677000",
			"Shearen Naura Firmansyah"=>"336000",
			"Wajendra Hanif Athoillah Luthfi (Hanhan)"=>"102000",
			"Zahra Tiara Agustina"=>"415000",
			"Zakiyah Hafshah Ramadhani"=>"570000",
			"Nasywa Raisyaf Al Fath"=>"65500",
			"Aghanadhif Ahza"=>"0",
			"fatima putri"=>"0",
			"ARSYA ARRAIHAN MADDUPPA"=>"0",
		);
		$tab=$this->config->item('nsiswa');
		// echo '<pre>';
		// print_r($tab['Aulia Hamzah Ar- Raniry']);
		// echo '</pre>';
		foreach ($d as $k => $v)
		{
			if(isset($tab[trim($k)]))
			{
				$s=$tab[trim($k)];
				// echo $k.':'.$s->id."<br>";
				$data['siswa_id']=$s->id;
				// $this->db->query('delete from t_tabungan_detail where penyetor_penarik="'.$k.'"');
				// $this->db->query('delete from t_tabungan where siswa_id="'.$s->id.'"');
				$data['status_tampil']='t';
				$data['saldo']=$v;
				$data['last_update']=date('Y-m-d H:i:s');
				$this->db->insert('t_tabungan',$data);
				$id=$this->db->insert_id();

				$dd['tabungan_id']=$id;
				$dd['jumlah']=$v;
				$dd['jenis']='setor';
				$dd['tanggal']='2016-08-01';
				$dd['status_tampil_det']='t';
				$dd['keterangan']='Saldo Awal';
				$this->db->insert('t_tabungan_detail',$dd);
				// $jumlah=$v;

			}
			else
			{
				echo $k.'<br>';
			}
			# code...
		}
	}
	function cc()
	{
		$data['siswa_id']=246;
		$data['status_tampil']='t';
		$this->db->insert('t_tabungan',$data);
		$id=$this->db->insert_id();

		$d=array(
			"2016-08-08"=>"100000",
			"2016-08-09"=>"50000",
			"2016-08-10"=>"2000",
			"2016-08-11"=>"3000",
			"2016-08-15"=>"10000",
			"2016-08-18"=>"5000",
			"2016-08-19"=>"10000",
			"2016-08-31"=>"5000",
			"2016-09-01"=>"50000",
			"2016-09-05"=>"50000",
			"2016-10-03"=>"50000"
		);

		$jumlah=0;
		foreach ($d as $k => $v)
		{
			$dd['tabungan_id']=$id;
			$dd['jumlah']=$v;
			$dd['jenis']='setor';
			$dd['tanggal']=$k;
			$dd['status_tampil_det']='t';
			$this->db->insert('t_tabungan_detail',$dd);
			$jumlah+=$v;
		}

		$up['saldo']=$jumlah;
		$up['last_update']=date('Y-m-d H:i:s');
		$this->db->where('id',$id);
		$this->db->update('t_tabungan',$up);
	}

	function updatetabungan($idsiswa=-1)
	{
		$this->mm->updatetabungan($idsiswa);
	}
	function cleansing_siswa()
	{
		$d1=$this->config->item('tsiswa');
		$d2=$this->config->item('vbatchsiswa');
		$sis1=$sis2=array();
		foreach($d1 as $k1=>$v1)
		{
			$sis1[]=$v1->id;
		}
		foreach($d2 as $k2=>$v2)
		{
			$sis2[]=$v2->id;
		}
		
		$inArray=isInArray($sis1,$sis2);
		foreach($inArray as $idx=>$val)
		{
			if($val==0)
			{
				// echo $idx.'-'.$val.'<br>';
				$this->db->set('status_tampil','f');
				$this->db->where('id',$idx);
				$this->db->update('t_siswa');
			}
		}
		// echo '<pre>';
		// print_r($inArray);
		// echo '</pre>';
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

	public function send_mail() {
         $from_email = "noreply@sekolahalambogor.id";
         $to_email = "fachran.nazarullah@gmail.com";

         //Load email library
         $this->load->library('email');

         $this->email->from($from_email, 'Sekolah Alam Bogor');
         $this->email->to($to_email);
         $this->email->subject('Email Test');
         $this->email->message('Testing the email class.');

         //Send mail
         if($this->email->send())
         	echo "Email sent successfully.";
         else
				 {
         	echo "Error in sending Email.";
					$this->email->print_debugger();
				}
        // $this->load->view('email_form');
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
		echo '<pre>';
		print_r($d_sis);
		echo '</pre>';
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
		echo '<pre>';
		print_r($d_sis);
		echo '</pre>';
	}

	function resettagihantransaksi()
	{
		$nama=array(
				"Bimo Anarghyata Munggaran Subowo",
				"khanza nursyifa azzahra",
				"Rayyan Prabha Adityawarman",
				"Muhammad Zaidan Ahsan",
				"Fayyadh Pradipta Adityawarman",
				"Agastya Ratih",
				"Qeyvasyah Ariq Ferresyah",
				"AKHMAD 'ADIL FALLAAH",
				"Aarunashira Harsya Amira",
				"Arsanta Zikri Danaputra",
				"Aiko Rezki Zaira",
				"Kintani Zahra Indaputri",
				"Alya Alzafira Zaira",
				"Raden Naimah Yasmin Fauziah G",
				"Terra Radya Rizqy Angkasa Susanto Putra",
				"Althea Kinandita Ardi",
				"Muhammad Fauzan Harun P.",
				"Fairuz Athaya Khairunnisa",
				"Humaira Rahmalia Hersafitri",
				"INSYIRAH GHAISANI ANANDIFA",
				"RAIHAN FATHAN MUBINA",
				"Adiva Noury Aishwarya",
				"ARSYAD NOOR ELHAKIIM SURYABRATA",
				"Raden Muhammad Nashwan Hamid Gumiwan",
				"Qisya Amanina",
				"Muhammad Raidy Kahfi",
				"Inaya Wibowo",
				"Azkayra Najwa Malayeka",
				"Albani Rayfano",
				"Adi Ilmi Faeyza",
				"Nashirah Rahadatul Aisy",
				"TSABITA ANNAKIYA MADARUM",
				"ghietrief fawwaz kurniawan",
				"FATTAN RAHMANDANI PUJADI",
				"Abiyyuta Ahsan",
				"Agna Shakila Madarum (Anya)",
				"FAEYZA ATHAR",
				"Yasmira Nur Sabrina Paada",
				"Hafuza Athalla Hidayat",
				"IHSAN FARHAN MANSHUR",
				"Alila Khairunazhifa",
				"Amira Hasna Saajida",
				"Kinan Malik Aqila",
				"Raka Sweca Dewantara Agung",
				"Muhammad Daanish",
				"Jinan Khansa",
				"Anas Rachmat Julianto (Arman)",
				"Shakeel Dzaki Abdullah Ramdhani",
				"Rayan Alfreda Masood",
				"Kezia Neubrina Zara",
				"Aryasakti Nundzaky Hakim",
				"Faqih Aryo Seto Handoko",
				"Syarifah Jilan Dzikra",
				"Hana Hanifah Anwar",
				"Safa Tsabitah Zahra",
				"Rama Dehan Mukhtarul Haq",
				"Fachry Apriliansyah",
				"Khanza Mahardika",
				"Raya Nadia Khairunnisa",
				"Kayla Maritza Adyanugraha",
				"Muhammad Farras Arsyad",
				"Nadyne Valiqa Myshanti",
				"Rafif Akhdan Putra Wibowo",
				"NAJMAH MUTHMAINNAH ANWAR",
				"Bima Aji Kusuma",
				"Alger Muhammad Ziv",
				"Padma Riansyah Adigana",
				"AUFA IHRAM PUTRA WAHYUDI",
				"Ahmad Zaki Mu'tashim",
				"Raden Pandu Rahmadi",
				"Amira Nadha Nadira",
				"Firas Tajuzaman Ramadhan",
				"Raden Hadi Arif Rahman"	
			);
		$siswa=$this->config->item('nsiswalower');
		$tsbjenis=$this->config->item('ttagihanbybulanjenis');

		$trans=$this->db->from('t_transaksi')->join('t_transaksi_detail','t_transaksi_detail.trans_id = t_transaksi.id_trans')->get();

		$tr=$tr2=array();
		foreach($trans->result() as $k => $v)
		{
			$tr[str_replace('.','_',$v->nis)][$v->tahun_tagihan][$v->bulan_tagihan][$v->trans_id]=$v;
			$tr2[str_replace('.','_',$v->nis)][$v->trans_id][]=$v;
		}

		echo count($nama).'<br>';
		$x=0;
		$iddet=array();
		foreach($nama as $k=>$v)
		{
			if(isset($siswa[trim(strtolower($v))]))
			{
				$sis=$siswa[trim(strtolower($v))];

				if(isset($tr[str_replace('.','_',$sis->nis)][2018][7]))
				{
					$trn=$tr[str_replace('.','_',$sis->nis)][2018][7];
					foreach($trn as $kt => $vt)
					{
						if(isset($tr2[str_replace('.','_',$sis->nis)][$kt]))
						{
							
							foreach($tr2[str_replace('.','_',$sis->nis)][$kt] as $i => $iv)
							{
								// echo $sis->nis.' ['.$iv->trans_id.'] ['.$iv->penerimaan_id.'] ['.$iv->bulan_tagihan.'] ['.$iv->tahun_tagihan.'] ['.$iv->tahun_ajaran.'] ('.$iv->total.') : '.$iv->jumlah.'<br>';

								if($iv->bulan_tagihan==7 && $iv->tahun_tagihan==2018)
								{
									echo '<u style="color:red">'.$sis->nis.' ['.$iv->id.'] ['.$iv->trans_id.'] ['.$iv->penerimaan_id.'] ['.$iv->bulan_tagihan.'] ['.$iv->tahun_tagihan.'] ['.$iv->tahun_ajaran.'] ('.$iv->total.') : '.$iv->jumlah.'</u><br>';
									$iddet[$iv->trans_id][$iv->id]=$iv->trans_id;
									$this->db->where('id',$iv->id);
									$this->db->delete('t_transaksi_detail');

									// $this->db->where('id_trans',$iv->trans_id);
									// $this->db->delete('t_transaksi');
								}
								else
								{
									if($iv->tahun_ajaran=='2018 / 2019')
									{
										echo '<u style="color:red">'.$sis->nis.' ['.$iv->id.'] ['.$iv->trans_id.'] ['.$iv->penerimaan_id.'] ['.$iv->bulan_tagihan.'] ['.$iv->tahun_tagihan.'] ['.$iv->tahun_ajaran.'] ('.$iv->total.') : '.$iv->jumlah.'</u><br>';
										$iddet[$iv->trans_id][$iv->id]=$iv->trans_id;
										$this->db->where('id',$iv->id);
										$this->db->delete('t_transaksi_detail');

										// $this->db->where('id_trans',$iv->trans_id);
										// $this->db->delete('t_transaksi');

									}
									else
									{
										echo $sis->nis.' ['.$iv->trans_id.'] ['.$iv->penerimaan_id.'] ['.$iv->bulan_tagihan.'] ['.$iv->tahun_tagihan.'] ['.$iv->tahun_ajaran.'] ('.$iv->total.') : '.$iv->jumlah.'<br>';
									}
								}

								
							}
							echo '-----------------------<br>';
						}
					}
				}
				else
				{
					if(isset($tr[str_replace('.','_',$sis->nis)][2018]))
					{
						foreach($tr[str_replace('.','_',$sis->nis)][2018] as $mr => $vm)
						{
							if($mr>2)
							{

								foreach($vm as $kkk => $item)
								{
									echo '<span style="color:blue">'.$v.' : '.$kkk.'</span><br>';
								}
							}
						}
					}
					else
					{
						echo '<span style="color:red">'.$v.'</span><br>';
					}
				}

				if(isset($tsbjenis[str_replace('.','_',$sis->nis)]['2018 / 2019'][2018][7]))
				{
					foreach($tsbjenis[str_replace('.','_',$sis->nis)]['2018 / 2019'][2018][7] as $kk => $vv)
					{
						$tg=$tsbjenis[str_replace('.','_',$sis->nis)]['2018 / 2019'][2018][7];
						// print_r($tg);
						// echo $v.' : '.$kk.' <b>['.$tg[$kk]->wajib_bayar.' : '.$tg[$kk]->sisa_bayar.']</b><br>';
						$this->db->set('sisa_bayar',$tg[$kk]->wajib_bayar);
						$this->db->set('status_tagihan',0);
						$this->db->where('id_tagihan',$tg[$kk]->id_tagihan);
						$this->db->update('t_tagihan_siswa');
					}
				}
				else
				{
					echo '<span style="color:red">'.$v.'</span><br>';
				}
			}
			else
			{
				//echo '<span style="color:red">'.$v.'</span><br>';
				$x++;
			}
		}
		// echo '<pre>';
		// print_r($iddet);
		// echo '</pre>';
		// echo $x.'<br>';
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

	function getjumlahakun($akun)
	{
		$d_akun=$this->config->item('takun');
		$kd_akun=array();
		foreach($d_akun as $k => $v)
		{
			
		}
	}

	function jurnal()
	{
		$j_penerimaan=$this->config->item('tpenerimaan');
		$trans=$this->config->item('v_pen2');
		$bank=$this->config->item('d_bank');
		$siswa=$this->config->item('nissiswa2');
		echo '<pre>';
		foreach($trans as $k=>$v)
		{
			if($v[0]->rek_bank!='')
			{
				$totaldebit=0;
				foreach($v as $kk => $vv)
				{
					$totaldebit+=$vv->jumlah;
				}
				$kd_trans=date('Ymd',strtotime($v[0]->tanggal_transaksi)).'-01-'.abs(crc32(sha1(md5(rand()))));
				list($idbank,$namabank)=explode('__',$v[0]->rek_bank);
				$akun_debit=$bank[$idbank]->kode_akun;
				$jurnal_a['tanggal']=strtok($v[0]->tanggal_transaksi,' ');
				$jurnal_a['kode_akun']=$akun_debit;
				$jurnal_a['ref']=$kd_trans;
				$jurnal_a['keterangan']='Rekening Koran '.$bank[$idbank]->nama_bank.' ('.$bank[$idbank]->no_rekening.')';
				$jurnal_a['debit']=$totaldebit;
				$jurnal_a['kredit']=0;
				$jurnal_a['created_at']=$v[0]->tanggal_transaksi;
				$jurnal_a['updated_at']=$v[0]->tanggal_transaksi;
				$this->db->insert('t_jurnal',$jurnal_a);

				foreach($v as $kk => $vv)
				{
					$nis=str_replace('.','_',$vv->nis);
					$nama_sisws=$siswa[$nis]->nama_murid;
					$kdak=explode('-',$j_penerimaan[$vv->penerimaan_id]->kodeakun);
					$kd_akun_jurnal_b=$kdak[1];
					$jurnal_b['tanggal']=$vv->tanggal_transaksi;;
					$jurnal_b['kode_akun']=$kd_akun_jurnal_b;
					$jurnal_b['ref']=$kd_trans;
					$jurnal_b['keterangan']='Penerimaan '.$j_penerimaan[$vv->penerimaan_id]->jenis.' a.n. '.$nama_sisws;
					$jurnal_b['debit']=0;
					$jurnal_b['kredit']=$vv->jumlah;
					$jurnal_b['updated_at']=$vv->tanggal_transaksi;
					$jurnal_b['created_at']=$vv->tanggal_transaksi;
					$this->db->insert('t_jurnal',$jurnal_b);
				// print_r($jurnal_b);

				}
				// print_r($jurnal_a);
				
			}
			else
			{
				$akun_kas=$this->db->from('t_akun')->where('nama_akun','Kas')->get()->row();
				$akun_debit=$akun_kas->kode_akun;
				$totaldebit=0;
				foreach($v as $kk => $vv)
				{
					$totaldebit+=$vv->jumlah;
				}

				$kd_trans=date('Ymd',strtotime($v[0]->tanggal_transaksi)).'-02-'.abs(crc32(sha1(md5(rand()))));
				$jurnal_a['tanggal']=strtok($v[0]->tanggal_transaksi,' ');
				$jurnal_a['kode_akun']=$akun_debit;
				$jurnal_a['ref']=$kd_trans;
				$jurnal_a['keterangan']='Kas';
				$jurnal_a['debit']=$totaldebit;
				$jurnal_a['kredit']=0;
				$jurnal_a['created_at']=$v[0]->tanggal_transaksi;
				$jurnal_a['updated_at']=$v[0]->tanggal_transaksi;
				$this->db->insert('t_jurnal',$jurnal_a);

				foreach($v as $kk => $vv)
				{
					$nis=str_replace('.','_',$vv->nis);
					$nama_sisws=$siswa[$nis]->nama_murid;
					$kdak=explode('-',$j_penerimaan[$vv->penerimaan_id]->kodeakun);
					$kd_akun_jurnal_b=$kdak[1];
					$jurnal_b['tanggal']=$vv->tanggal_transaksi;;
					$jurnal_b['kode_akun']=$kd_akun_jurnal_b;
					$jurnal_b['ref']=$kd_trans;
					$jurnal_b['keterangan']='Penerimaan '.$j_penerimaan[$vv->penerimaan_id]->jenis.' a.n. '.$nama_sisws;
					$jurnal_b['debit']=0;
					$jurnal_b['kredit']=$vv->jumlah;
					$jurnal_b['updated_at']=$vv->tanggal_transaksi;
					$jurnal_b['created_at']=$vv->tanggal_transaksi;
					$this->db->insert('t_jurnal',$jurnal_b);
				// print_r($jurnal_b);

				}
			}
		}
		// echo '</pre>';
		// echo count($trans);
	}
}
