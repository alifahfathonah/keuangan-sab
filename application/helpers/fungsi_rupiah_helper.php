<?php
function pembulatan($uang)
{
 	$ratusan = substr($uang, -3);
 	if($ratusan<500)
 		$akhir = $uang - $ratusan;
 	else
 		$akhir = $uang + (1000-$ratusan);

 	return $akhir;
}

	function right($string,$chars)
	{
		$vright = substr($string, strlen($string)-$chars,$chars);
		return $vright;

	}
    function rupiah($uang)
    {
    $rupiah  = "";

	if($uang<0)
	{
		$u=$uang;
		$uang=abs($uang);
	}
	else
	{
		$u=$uang;
	}
	$sep=substr($uang,-3,1);
    $sep2=substr($uang,-4,1);
    $sep3=substr($uang,-5,1);
    $dec1=right($uang,2);
    $dec11=right($uang,3);
    $dec111=right($uang,4);
    $dec2=strtok($uang,'.');
    $panjang = strlen($dec2);

    while ($panjang > 3)
    {

			$rupiah = "." . substr($dec2, -3) . $rupiah;
			$lebar = strlen($dec2) - 3;
			$dec2   = substr($dec2,0,$lebar);
			$panjang= strlen($dec2);

	}

	if($uang==0 || $uang=="")
	{
		$rupiah = "-";
	}
	else
	{


		if($sep=='.' || $sep2=='.' || $sep3=='.')
		{
                        /*if($sep=='.')
                            $rupiah = $dec2.$rupiah.",".$dec1;
                        else if($sep2=='.')
                            $rupiah = $dec2.$rupiah.",".substr($dec11,0,2);
                        else if($sep3=='.')
                            $rupiah = $dec2.$rupiah.",".substr($dec111,0,2);*/
                        if($sep=='.')
                            $rupiah = $dec2.$rupiah.",-";
                        else if($sep2=='.')
                            $rupiah = $dec2.$rupiah.",-";
                        else if($sep3=='.')
                            $rupiah = $dec2.$rupiah.",-";
		}
		else
		{
			$rupiah = $dec2.$rupiah.",-";
		}
	}

	if($u<0)
		return '('.$rupiah.')';
	else
		return $rupiah;
    }


function cleartext($string)
{
    $j=str_replace(array('\\','/','"','\'',':',';','~','`','.',',','(',')','{','}','_','-','=','@','#','$','|','!',' ','*','&'), '-', $string);
    $new_j=str_replace(array('---','--','-'), '-', $j);
    $judul=strtolower($new_j);
    return $judul;
}



function clearisi($string)
{
    $f=substr($string,1,1);
    if($f=='P')
        $x='</P>';
    else if($f=='p')
        $x='</p>';

    list($text1,$text2,$text3,$text4,$text5)=explode(''.$x.'',$string);

    $s=strip_tags($text1);
    if($s==" ")
    {
        $text=$text2;
        $t=explode(" ", $text);
        if(count($t)<=150)
            $output=$text.$text3.$text4.$text5;
        else
            $output=$text;
    }
    else
    {
        $text=$text1;
        $text=$text2;
        $t=explode(" ", $text);
        if(count($t)<=150)
            $output=$text.$text2.$text3.$text4;
        else
            $output=$text;
    }

    return strip_tags($output);
}

function filterid($id)
{
    $ln=strlen($id);
    $newid="";
    for($x=0;$x<$ln;$x++)
    {
        $tx=substr($id, $x,1);
        if(is_numeric($tx))
        {
            $newid.=$tx;
        }
    }
    return $newid;
}
function Terbilang($x)
{
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . "belas";
  elseif ($x < 100)
    return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
}

function persen_jemputan($he,$status)
{
    if($he>=16)
        $persen=100;
    else if($he<16 && $he >=12)
        $persen=85;
    else if($he<12 && $he>=6)
        $persen=70;
    else if($he < 6)
        $persen=60;

    if($status=='pulang-pergi')
        $prsn=1 * $persen;
    else
        $prsn=0.65 * $persen;

    return $prsn;
}

function urutanjenis($jns)
{
    $urutan=0;
       if(strcmp(strtolower($jns),'catering')==0)
       {
            $urutan=0;
       }
       else if(strcmp(strtolower($jns),'jemputan')==0)
       {
            $urutan=1;
       }
       else if(strcmp(strtolower($jns),'jemputan club')==0)
       {
            $urutan=2;
       }
       else if(strcmp(strtolower($jns),'club')==0)
       {
            $urutan=3;
       }
       else if(strcmp(strtolower($jns),'spp')==0)
       {
            $urutan=4;
       }
      else if(strpos(strtolower($jns),'investasi')!==false)
       {
            $urutan=5;
       }
       else if(strcmp(strtolower($jns),'asuransi')==0)
       {
            $urutan=6;
       }
       else if(strcmp(strtolower($jns),'program pembelajaran')==0)
       {
            $urutan=8;
       }
       else if(strcmp(strtolower($jns),'iuran komite')==0)
       {
            $urutan=7;
       }
       else if(strcmp(strtolower($jns),'biaya seleksi')==0)
       {
            $urutan=9;
       }
       else if(strpos(strtolower($jns),'seragam')!==false)
       {
            $urutan=10;
       }
       else
       {
            $urutan=11;
       }
    return $urutan;
}

function generaterekening()
{
  $thn=date('y');
  $bln=date('m');
  $tgl=date('d');
  $id=substr(abs(crc32(md5(sha1(rand())))),0,4);
  $gid=$thn.$bln.$tgl.$id;
  return $gid;
}

function bulantahunajaran($tahunajaran)
{
    list($t1,$t2)=explode('/',$tahunajaran);
    $t1=trim($t1);
    $t2=trim($t2);
    $bulan=array(
        $t1 => array(7,8,9,10,11,12),
        $t2 =>array(1,2,3,4,5,6)
    );
    return $bulan;
}
function gettahunajaranbybulan($bulan,$tahun)
{
    if($bulan>=7)
        $tahunajaran = $tahun.' / '.($tahun+1);
    else
        $tahunajaran = ($tahun-1).' / '.$tahun;

    return $tahunajaran;
}
// function isInArray($array, $searchIn) {
//      $inc = array();
    
//     foreach ($array as $v) {
//         if (is_array($v) && sizeof($v) > 0) {
//             isInArray($v, $searchIn);
//         } else if (!is_array($v) && in_array($v, $searchIn)) {
//             isset($inc[$v]) ? $inc[$v]++ : $inc[$v] = 1;
//         }
//     }
    
//     return $inc;
// }
?>
