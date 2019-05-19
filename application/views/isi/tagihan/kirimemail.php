        <!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                </head>
                <!-- <body onLoad="window.print()"> -->
                <body>
                    <div style="width:1000px !important;padding:10px;" class="body">
                    <h4>Bismillahirrahmaanirraahim<br>
                    Assalamua'alaikum Warrahmatullahi Wabarakatuh<br>
                    Berikut adalah tagihan ananda bulan <?=getBulan($bulan)?> <?=$tahun?></h4>
                    <br>
                    <br>
                <table width="600" align="" border="0" cellspacing="0" cellpadding="0" class="m_8333006706591979715borderPerTab" style="border:1px solid #ededed">
                    <tbody><tr>

                    <td bgcolor="#ffffff">

            <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

                <tbody><tr>
                <td valign="top" class="m_8333006706591979715vspacer15" width="45"></td>
                <td valign="top" style="font-family:Helvetica,'Arial',sans-serif;color:#000000;font-size:11px">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody><tr>
                        <td height="15"></td>
                    </tr>
                    <tr>
                        <td align="left" style="font-family:Helvetica,'Arial',sans-serif;color:#00af41;font-size:20px;line-height:24px;font-weight:bold;line-height:26px;text-align:left">
                        Sekolah Alam Bogor
                        </td>
                    </tr>

                    <tr>
                        <td height="15"></td>
                    </tr>

                        <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                <td width="56%" align="left" valign="top" class="m_8333006706591979715produceTdLast" style="font-size:12px;line-height:21px;font-weight:bold">TANGGAL &nbsp;&nbsp;<br>
                                    <span style="font-size:12px;font-weight:bold;color:#00af41"><?=tgl_indo(date('Y-m-d'))?></span></td>
                                    <td width="44%" align="left" valign="top" class="m_8333006706591979715produceTdLast" style="font-size:12px;line-height:21px;font-weight:bold">&nbsp;</td>
                                </tr>
                            </tbody></table>

                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                <td height="12"></td>
                                </tr>
                            </tbody></table></td>
                        </tr>

            </tbody></table></td>
                    <td valign="top" class="m_8333006706591979715vspacer15" width="45"></td>
                </tr>
            </tbody></table>




            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td height="5"></td>
            </tr>
            </tbody></table>


            <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
                        <tbody><tr>
                            <td valign="top" class="m_8333006706591979715vspacer15" width="45"></td>

                            <td align="center" valign="top">

                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <tbody><tr>
                                <td align="left" height="20"></td>
                                </tr>
                            </tbody></table>

                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <tbody><tr>

                                <td width="55%" align="left" style="font-size:14px;font-weight:bold;color:#00af41">

                                </td>
                                </tr>
                            </tbody></table>

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
            <td valign="top" width="200" class="m_8333006706591979715produceTd">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody><tr>
                    <td align="left" valign="top" class="m_8333006706591979715tdp5" style="font-size:14px;font-weight:bold;color:#00af41">Data Siswa</td>
                    </tr>


            <tr>
                <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                    <td align="left" valign="top" style="padding:0cm 0cm 0cm 0cm">

                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                            <td class="m_8333006706591979715t3_1" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tbody><tr>
                        <td align="left" valign="top" class="m_8333006706591979715tdp5">
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <tbody><tr>
                                <td align="left" class="m_8333006706591979715tdp5">
                                    <span style="font-size:10px;color:#9e9e9e;line-height:13px">Nama Siswa :</span><br>
                                    <span style="font-size:12px;line-height:13px;font-weight:bold"><?=$vv?></span>
                                </td>
                                </tr>
                            </tbody></table>
                        </td>
                        </tr>

                <tr>
                    <td align="left" valign="top" class="m_8333006706591979715tdp5">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tbody><tr>
                            <td align="left" class="m_8333006706591979715tdp5">
                            <span style="font-size:10px;color:#9e9e9e;line-height:14px">Virtual Account : </span><br>
                            <span style="font-size:12px;line-height:13px;font-weight:bold"><?=$Va[$nk]?></span>
                        </td>
                        </tr>
                        </tbody></table></td>
                    </tr>
                <tr>
                    <td align="left" valign="top" class="m_8333006706591979715tdp5">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tbody><tr>
                            <td align="left" class="m_8333006706591979715tdp5">
                            <span style="font-size:10px;color:#9e9e9e;line-height:14px">Kelas : </span><br>
                            <span style="font-size:12px;line-height:13px;font-weight:bold"><?=strtoupper(str_replace('_',' ',$n))?></span>
                        </td>
                        </tr>
                        </tbody></table></td>
                    </tr>


                    </tbody>
                    </table>
                        </td>
                        </tr>
                        </tbody></table></td>
                    </tr>
                </tbody></table></td>
            </tr>
            </tbody></table>
                </td>
                <td valign="top" class="m_8333006706591979715noneMobile" width="9"></td>
                <td valign="top" class="m_8333006706591979715noneMobile" width="10" bgcolor="#f5f5f3"></td>
                <td valign="top" width="270" class="m_8333006706591979715produceTd">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody><tr>
                    <td align="left" valign="top" class="m_8333006706591979715tdp5" style="font-size:14px;font-weight:bold;color:#00af41">Detail Tagihan</td>
                    </tr>
                <tr>
                    <td align="center" valign="middle" height="10" class="m_8333006706591979715img_1"></td>
                    </tr>

            <tr>
                <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="border:1px solid #dddddd">
                    <tbody><tr>
                    <td align="left" valign="top" style="padding:0cm 0cm 0cm 0cm">

                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                            <td class="m_8333006706591979715t3_1" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tbody><tr>
                        <td align="left" valign="top" class="m_8333006706591979715tdp5">
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tbody>
                            <tr>
                                <td align="left" class="m_8333006706591979715tdp5" width="15"></td>
                                <td width="171" align="left" class="m_8333006706591979715tdp5">
                                <span style="font-size:11px;color:#9e9e9e;line-height:21px">Jenis Tagihan</span>
                                </td>
                                <td width="80" align="left" class="m_8333006706591979715tdp5">
                                <span style="font-size:11px;color:#9e9e9e;line-height:28px">&nbsp;&nbsp;Jumlah:</span>
                                </td>
                                <td align="left" class="m_8333006706591979715tdp5" width="15"></td>
                                </tr>

                                <tr>
                                <td align="left" class="m_8333006706591979715tdp5" width="15"></td>
                                <td align="left" class="m_8333006706591979715tdp5">

                                    <span style="font-size:11px;color:#000000;line-height:13px">SPP <?=getBulanSingkat($bulan)?> <?=$tahun?></span>

                                </td>
                                <td align="center" class="m_8333006706591979715tdp5"><span style="font-size:12px;">Rp.</span></td>
                                <td align="right" class="m_8333006706591979715tdp5">
                                <span style="font-size:11px;color:#000000;line-height:13px"><?=str_replace(',','.',$Spp[$nk])?> </span>
                                </td>
                                <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="border-bottom:1px solid #888;"></td>
                                </tr>
                                <tr>
                                <td align="left" class="m_8333006706591979715tdp5" width="15"></td>
                                <td align="left" class="m_8333006706591979715tdp5">
                                <span style="font-size:11px;color:#000000;line-height:13px">Catering <?=getBulanSingkat($bulan)?> <?=$tahun?></span>
                                </td>
                                <td align="center" class="m_8333006706591979715tdp5"><span style="font-size:12px;">Rp.</span></td>
                                <td align="right" class="m_8333006706591979715tdp5">
                                <span style="font-size:11px;color:#000000;line-height:13px"><?=str_replace(',','.',$Catering[$nk])?> </span>
                                </td>
                                <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="border-bottom:1px solid #888;"></td>
                                </tr>
                                <tr>
                                <td align="left" class="m_8333006706591979715tdp5" width="15"></td>
                                <td align="left" class="m_8333006706591979715tdp5">
                                <span style="font-size:11px;color:#000000;line-height:13px">Jemputan <?=getBulanSingkat($bulan)?> <?=$tahun?></span>
                                </td>
                                <td align="center" class="m_8333006706591979715tdp5"><span style="font-size:12px;">Rp.</span></td>
                                <td align="right" class="m_8333006706591979715tdp5">
                                <span style="font-size:11px;color:#000000;line-height:13px"><?=str_replace(',','.',$Jemputan[$nk])?> </span>
                                </td>
                                <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="border-bottom:1px solid #888;"></td>
                                </tr>
                                <tr>
                                <td align="left" class="m_8333006706591979715tdp5" width="15"></td>
                                <td align="left" class="m_8333006706591979715tdp5">
                                <span style="font-size:11px;color:#000000;line-height:13px">Jemputan Club <?=getBulanSingkat($bulan)?> <?=$tahun?></span>
                                </td>
                                <td align="center" class="m_8333006706591979715tdp5"><span style="font-size:12px;">Rp.</span></td>
                                <td align="right" class="m_8333006706591979715tdp5">
                                <span style="font-size:11px;color:#000000;line-height:13px"><?=str_replace(',','.',$JemputanClub[$nk])?> </span>
                                </td>
                                <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="border-bottom:1px solid #888;"></td>
                                </tr>
                                <tr>
                                <td align="left" class="m_8333006706591979715tdp5" width="15"></td>
                                <td align="left" class="m_8333006706591979715tdp5">
                                <span style="font-size:11px;color:#000000;line-height:13px">Club <?=getBulanSingkat($bulan)?> <?=$tahun?></span>
                                </td>
                                <td align="center" class="m_8333006706591979715tdp5"><span style="font-size:12px;">Rp.</span></td>
                                <td align="right" class="m_8333006706591979715tdp5">
                                <span style="font-size:11px;color:#000000;line-height:13px"><?=str_replace(',','.',$Club[$nk])?> </span>
                                </td>
                                <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="border-bottom:1px solid #888;"></td>
                                </tr>
                                <tr>
                                <td align="left" class="m_8333006706591979715tdp5" width="15"></td>
                                <td align="left" class="m_8333006706591979715tdp5">
                                <span style="font-size:11px;color:#000000;line-height:13px">Investasi/Daftar Ulang</span>
                                </td>
                                <td align="center" class="m_8333006706591979715tdp5"><span style="font-size:12px;">Rp.</span></td>
                                <td align="right" class="m_8333006706591979715tdp5">
                                <span style="font-size:11px;color:#000000;line-height:13px"><?=str_replace(',','.',$Investasi[$nk])?> </span>
                                </td>
                                <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="border-bottom:1px solid #888;"></td>
                                </tr>
                                <tr>
                                <td align="left" class="m_8333006706591979715tdp5" width="15"></td>
                                <td align="right" class="m_8333006706591979715tdp5">
                                <span style="font-size:12px;font-weight:bolder;color:#000000;line-height:18px">TOTAL&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                </td>
                                <td align="center" class="m_8333006706591979715tdp5"><span style="font-size:12px;">Rp.</span></td>
                                <td align="right" class="m_8333006706591979715tdp5">
                                <span style="font-size:12px;font-weight:bolder;color:#000000;line-height:18px"><?=str_replace(',','.',$Total[$nk])?></span>
                                </td>
                                <td>&nbsp;</td>
                                </tr>
                                <tr>
                                <td>&nbsp;</td>
                                </tr>

                            </tbody></table>
                        </td>
                        </tr>




                        </tbody>
                    </table>
                </td>
                        </tr>
                        </tbody></table></td>
                    </tr>
                </tbody></table></td>
            </tr>
            </tbody></table>
                </td>

            </tr>
            </tbody></table>

            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                    <td height="20"></td>
                    </tr>
                </tbody></table>

                    </td>
                            <td valign="top" class="m_8333006706591979715vspacer15" width="45"></td>
                        </tr> </tbody></table>





            <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                <tbody><tr>
                <td valign="top" class="m_8333006706591979715vspacer15" width="45"></td>
                <td valign="top" style="font-family:'Helvetica',Arial,sans-serif;color:#000000;font-size:11px">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody><tr>
                        <td align="left" style="font-family:'Helvetica',Arial,sans-serif;text-align:center">

                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="font-family:'Helvetica',Arial,sans-serif;text-align:center">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>
                                <td width="55%" align="left" valign="top" class="m_8333006706591979715produceTdLast" style="font-family:'Helvetica',Arial,sans-serif;color:#666666;padding-right:10%">
                                <span style="color:#666666"> <a href="#" style="font-size:10px;font-weight:bold;color:#666666"> (+62 251) 8662 889</a></span><br><br>
                                <span style="font-size:10px;font-weight:normal;line-height:13px">Alamat: Jl. P. Ash-Shogiri 150, Kel. Tanah Baru Kec. Bogor Utara. Bogor, Jawa Barat, Indonesia<br>
                                <span style="font-size:10px;font-weight:normal;line-height:13px">Copyright © 2017 Sekolah Alam Bogor
                        </span>
                                </td>
                                <td width="35%" align="left" valign="top" class="m_8333006706591979715produceTdLast" style="font-family:'Helvetica',Arial,sans-serif;color:#666666">
                                    <span style="font-size:10px;line-height:12px;font-weight:bold">Ketahui Info terbaru dari Sekolah Alam Bogor</span><br><br>
                                    <a href="https://www.facebook.com/Sekolah-Alam-Bogor-44458771366/?fref=ts" target="_blank"><img width="30px" src="https://ci3.googleusercontent.com/proxy/AA40_v0ZE3EVtW_zNL1uVY17uO67QIBE9wM--ZyJ_hPodC2-KsORjQWVy21Yu5bECt8qADqNOwGHb_G2did_jOHbUQb6kpc0jMGRbL77n6gHy4xdzi7h=s0-d-e1-ft#https://grabtaxi-marketing.s3.amazonaws.com/email/img/icon-fb.png" class="CToWUd"></a>&nbsp;&nbsp;
                                    <a href="https://twitter.com/smsekolahalam" target="_blank"><img width="30px" src="https://ci5.googleusercontent.com/proxy/W5MRG8dwdj793Fudb-YjlyW1QMrJaJew1r7Kla5ibvlYhsNMr6HW2RbXJ3no8Q1j-9tcYvBVLn0P-xiAZpI6xD5pjJM2fnpUaYJfj7uVFd7RxSnhIjzqcwCnG9I=s0-d-e1-ft#https://grabtaxi-marketing.s3.amazonaws.com/email/img/icon-twitter.png" class="CToWUd"></a>&nbsp;&nbsp;
                                    <a href="https://www.instagram.com/salambogor/" target="_blank"><img width="30px" src="https://ci5.googleusercontent.com/proxy/64yDxyUpghZN8W1rLWrRzch8PYi4np37qZi1yIPmAD7XCqAFne9YH6YwSj9A_uWggvSQ5D7992Np8vsaP-CsW1zo-ZBhOgcKKtoQZ9GV2D_3dtPg-0i--q5v88v9zQ=s0-d-e1-ft#https://grabtaxi-marketing.s3.amazonaws.com/email/img/icon-instagram.png" class="CToWUd"></a>&nbsp;&nbsp;

                                    <a href="https://www.youtube.com/channel/UCcCo9_4FONsnG6HCRSaQtDw" target="_blank"><img width="30px" src="https://ci4.googleusercontent.com/proxy/EaG6efvLuYghXtWhvaQSA6uA3wwizQam0WkBCsFN7b4rTsnhzFbfRtP3SHyxeEY6bnAJYh2We1wV7oOMj2pMB0ZFPMhyUySqIRholjRXaGwgfXeV6xC6wZkGpcg=s0-d-e1-ft#https://grabtaxi-marketing.s3.amazonaws.com/email/img/icon-youtube.png" class="CToWUd"></a>
                                    <br><br>
                                </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td height="30"></td>
                    </tr>


            </tbody></table></td>
                    <td valign="top" class="m_8333006706591979715vspacer15" width="45"></td>
                </tr>
            </tbody></table>

            </td>
            </tr>
            </tbody></table>


                    </div>
                    <h4>Jatuh Tempo Pembayaran Tanggal 10 <?=getBulan($bulan)?> <?=($tahun)?>
                    <br>
                    Pembayaran dapat di lakukan dengan cara :
                    <ol>
                        <li>Untuk Siswa TK, SD, dan SM-1 melalui Nomor Virtual Account Siswa</li>
                        <li>Untuk Siswa SM-2 dan SM-3 Pembayaran melaui Nomor Rekening <b>BSM 7030910968</b> (atas nama SM Sekolah Alam Bogor)
                            <br>
                            Tambahkan Nomor virtual siswa di setiap belakang tagihan<br>
                            Contoh : tagihan 100.000  Virtual account  123<br>
                            Maka pada nominal transaksi di cantumkan 100.123
                        </li>
                    </ol> 
                    <br>
                    <br>
                    nb. Mohon konfirmasi apabila pembayaran dilakukan  tanpa virtual account dengan mengirimkan bukti pembayaran melalui :<br>
                    <ul>
                        <li>No whatsapp sekolah 089638024228 ( staff  finance)</li>
                        <li>Email : <a href="mailto:salam.finance150@gmail.com">salam.finance150@gmail.com</a></li>
                    </ul>
                    <br>
                    Salam,</h4>
                    <br>
                    <h2>Spirit, akhlaq, learning, advance, meaning</h2>

                </body>
            </html>
            <style type="text/css" media="print">
            @page {
                size: A4;
            }
            @media print {
            html, body {
                width: 210mm;
                height: 150mm;
            }
            /* ... the rest of the rules ... */
            }
            </style>
            <style type="text/css">
            *
            {
                line-height: 20px;
                font-size : 105%;
            }
            .tabel th,
            .tabel td
            {

                vertical-align: top;
                padding:1px;
            }
            .tabel th
            {
                background: #ddd;
                vertical-align: middle !important;
            }

            h1,h2,h3,h4,h5,h6
            {
                padding: 1px !important;
                margin: 1px !important;
            }
            div
            {
                font-size: 12px !important;
                padding-top:0px;
                padding-bottom:0px;
                margin-top:-1px !important;
                margin-bottom:0px;
            }
            ol li
            {
                margin-top:3px !important;
                margin-bottom:0px !important;
            }
            div.b128{
                border-left: 1px black solid;
                height: 40px !important;
            }

            </style>

