<?php
$host="localhost";
$user="sekolahalam";
$pass="Wb!q51c2";
$db="alambogor_akademik";

$kon=mysqli_connect($host,$user,$pass,$db);
if(isset($_GET['nis']))
{
    $nis=$_GET['nis'];
    $qry=mysqli_query($kon,"select * from master_siswa where nomor_induk_siswa='".$nis."'");
}
else
    $qry=mysqli_query($kon,"select * from master_siswa");

if(isset($_GET['nama']))
{
    $nama=str_replace('%20',' ',$_GET['nama']);
    $qry=mysqli_query($kon,"select * from master_siswa where nama like '%".$nama."%'");
}
// $sql=mysqli_fetch_assoc($qry);
$data=array();
while($row=mysqli_fetch_assoc($qry))
{
    $data[$row['nomor_induk_siswa']]=$row;
}
echo json_encode($data);
?>