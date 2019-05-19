<?php
$title=$this->uri->segment(1);
$subtitle=$this->uri->segment(2);
$user=$this->session->userdata('user');
$level=$user[0]->id_level;
// echo '<pre>';
// print_r($user);
// echo '</pre>';
// echo $title;
?>
<div id="sidebar" class="sidebar      h-sidebar                navbar-collapse collapse">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
					</div>
				</div><!-- /.sidebar-shortcuts -->

				<ul class="nav nav-list">
					<li class="<?=(strtolower($title)=='beranda' ? 'active open' : '')?> hover">
						<a href="<?=base_url()?>">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Beranda </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="hover <?=(strtolower($title)=='siswa' ? 'active open' : '')?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text">
								Siswa
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="hover">
								<a href="<?=site_url()?>siswa">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Siswa
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>siswa/form/-1">
									<i class="menu-icon fa fa-caret-right"></i>

									Tambah Data
								</a>
								<b class="arrow"></b>
							</li>


							<li class="hover">
								<a href="<?=site_url()?>siswa/importdata">
									<i class="menu-icon fa fa-caret-right"></i>
									Import Data
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>siswa/importemail">
									<i class="menu-icon fa fa-caret-right"></i>
									Import Data Email
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li class="hover <?=(strtolower($title)=='kelas' ? 'active open' : '')?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-list"></i>
							<span class="menu-text"> Kelas </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="hover">
								<a href="<?=site_url()?>kelas">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Level Kelas
								</a>

								<b class="arrow"></b>
							</li>

							<li class="hover">
								<a href="<?=site_url()?>kelas/batch">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Batch Kelas
								</a>

								<b class="arrow"></b>
							</li>
							<!-- <li class="hover">
								<a href="<?=site_url()?>kelas/atur">
									<i class="menu-icon fa fa-caret-right"></i>
									Atur Kelas
								</a>

								<b class="arrow"></b>
							</li> -->
						</ul>
					</li>
					
					<li class="hover <?=(strtolower($title)=='penerimaan' ? 'active open' : '')?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-exchange"></i>
							<span class="menu-text"> Penerimaan </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
						<?php
						if($level!=4)
						{
						?>
							<li class="hover">
								<a href="<?=site_url()?>transaksi/penerimaan">
									<i class="menu-icon fa fa-caret-right"></i>
									Transaksi
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>transaksi/pengembaliandana">
									<i class="menu-icon fa fa-caret-right"></i>
									Pengembalian Dana
								</a>

								<b class="arrow"></b>
							</li>
						<?php
						}
						?>
							<!-- <li class="hover">
								<a href="<?=site_url()?>penerimaan/tagihan">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Tagihan
								</a>

								<b class="arrow"></b>
							</li> -->

							<li class="active open hover">
								<!-- <a href="<?=site_url()?>penerimaan/tabungan"> -->
								<a href="#" class="dropdown-toggle">
									<i class="menu-icon fa fa-caret-right"></i>
									Tabungan
								</a>

								<b class="arrow"></b>
								<ul class="submenu">
									<li class="active hover">
										<a href="<?=site_url()?>penerimaan/tabungan">
											<i class="menu-icon fa fa-caret-right"></i>
											Data Tabungan
										</a>

										<b class="arrow"></b>
									</li>
									<li class="active hover">
										<a href="<?=site_url()?>penerimaan/tabungansdm">
											<i class="menu-icon fa fa-caret-right"></i>
											Data Tabungan SDM
										</a>

										<b class="arrow"></b>
									</li>

									<li class="hover">
										<a href="<?=site_url()?>penerimaan/tabungan_per_kelas">
											<i class="menu-icon fa fa-caret-right"></i>
											Tabungan Per Kelas
										</a>

										<b class="arrow"></b>
									</li>
									<li class="hover">
										<a href="<?=site_url()?>laporan/tabungan">
											<i class="menu-icon fa fa-caret-right"></i>
											Laporan Tabungan
										</a>

										<b class="arrow"></b>
									</li>
								</ul>
							</li>
							<?php
							if($level!=4)
							{
							?>
							<li class="hover">
								<a href="<?=site_url()?>penerimaan/datajemputan">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Jemputan Siswa
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>penerimaan/dataclub">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Club Siswa
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>penerimaan/datacatering">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Catering Siswa
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>penerimaan/pendamping">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Guru Pendamping Siswa
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>penerimaan/potongan">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Potongan Biaya
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>penerimaan/danalebih">
									<i class="menu-icon fa fa-caret-right"></i>
									Dana Lebih dan Deposit
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>penerimaan/jenis">
									<i class="menu-icon fa fa-caret-right"></i>
									Jenis Penerimaan
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>tagihan">
									<i class="menu-icon fa fa-caret-right"></i>
									Kirim Data Tagihan
								</a>

								<b class="arrow"></b>
							</li>
							<?php
							}
							?>
						</ul>
					</li>
					<?php
					if($level!=4)
					{
					?>
					<li class="hover <?=(strtolower($title)=='pengeluaran' ? 'active open' : '')?>">
						<a href="widgets.html" class="dropdown-toggle">
							<i class="menu-icon fa fa-exchange"></i>
							<span class="menu-text"> Pengeluaran </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>
						<ul class="submenu">
							<li class="hover">
								<a href="<?=site_url()?>transaksi/pengeluaran">
									<i class="menu-icon fa fa-caret-right"></i>
									Transaksi
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>transaksi/pengembaliandanaprogram">
									<i class="menu-icon fa fa-caret-right"></i>
									Pengembalian Dana Program
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>pengeluaran/tagihan">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Tagihan
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>pengeluaran/jenis">
									<i class="menu-icon fa fa-caret-right"></i>
									Jenis Pengeluaran
								</a>

								<b class="arrow"></b>
							</li>


						</ul>
					</li>

					
					
					<li class="hover <?=(strtolower($title)=='laporan' ? 'active open' : '')?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-bar-chart-o"></i>
							<span class="menu-text"> Laporan </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<!-- <li class="hover">
								<a href="profile.html">
									<i class="menu-icon fa fa-caret-right"></i>
									Transaksi
								</a>

								<b class="arrow"></b>
							</li> -->
							<li class="hover">
								<a href="<?=site_url()?>laporan/jurnal">
									<i class="menu-icon fa fa-caret-right"></i>
									Jurnal
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>laporan/bukubesar">
									<i class="menu-icon fa fa-caret-right"></i>
									Buku Besar
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>laporan/aruskas">
									<i class="menu-icon fa fa-caret-right"></i>
									Arus Kas
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>laporan/neracalajur">
									<i class="menu-icon fa fa-caret-right"></i>
									Neraca Lajur
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>laporan/laporanaktifitas">
									<i class="menu-icon fa fa-caret-right"></i>
									Laporan Aktifitas
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>laporan/neraca">
									<i class="menu-icon fa fa-caret-right"></i>
									Neraca
								</a>

								<b class="arrow"></b>
							</li>
							<!-- <li class="hover">
								<a href="<?=site_url()?>laporan/tagihan">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Tagihan Per Kelas
								</a>

								<b class="arrow"></b>
							</li> -->
							<li class="hover">
								<a href="<?=site_url()?>laporan/tagihanpersiswa">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Tagihan Per Siswa
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover">
								<a href="<?=site_url()?>laporan/datapiutang">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Piutang Siswa
								</a>

								<b class="arrow"></b>
							</li>

							
						</ul>
					</li>
					<li class="hover <?=(strtolower($title)=='program' ? 'active open' : '')?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-calendar-o"></i>
							<span class="menu-text"> Program </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="hover <?=(strtolower($subtitle)=='program' ? 'active open' : '')?>">
								<a href="<?=site_url()?>rab">
									<i class="menu-icon fa fa-caret-right"></i>
									Rencana Anggaran Biaya Program
								</a>
							</li>
							<li class="hover <?=(strtolower($subtitle)=='program' ? 'active open' : '')?>">
								<a href="<?=site_url()?>realisasi">
									<i class="menu-icon fa fa-caret-right"></i>
									Realisasi Anggaran Biaya Program
								</a>
							</li>
							<li class="hover <?=(strtolower($subtitle)=='program' ? 'active open' : '')?>">
								<a href="<?=site_url()?>program/index">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Program
								</a>							
							</li>
							<li class="hover <?=(strtolower($subtitle)=='program' ? 'active open' : '')?>">
								<a href="<?=site_url()?>kegiatan/index">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Kegiatan
								</a>							
							</li>
							<li class="hover <?=(strtolower($subtitle)=='program' ? 'active open' : '')?>">
								<a href="<?=site_url()?>sasaranmutu">
									<i class="menu-icon fa fa-caret-right"></i>
									Sasaran Mutu
								</a>							
							</li>
							<li class="hover <?=(strtolower($subtitle)=='lpj' ? 'active open' : '')?>">
								<a href="<?=site_url()?>lpj">
									<i class="menu-icon fa fa-caret-right"></i>
									LPJ Penggunaan Dana
								</a>							
							</li>
						</ul>
					</li>
					<li class="hover <?=(strtolower($title)=='config' ? 'active open' : '')?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-cogs"></i>
							<span class="menu-text"> Config </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="hover <?=(strtolower($subtitle)=='profil' ? 'active open' : '')?>">
								<a href="<?=site_url()?>config/profil">
									<i class="menu-icon fa fa-caret-right"></i>
									Profil
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover <?=(strtolower($subtitle)=='bank' ? 'active open' : '')?>">
								<a href="<?=site_url()?>config/bank">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Bank
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover <?=(strtolower($subtitle)=='guru' ? 'active open' : '')?>">
								<a href="<?=site_url()?>config/guru">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Guru
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover <?=(strtolower($subtitle)=='supir' ? 'active open' : '')?>">
								<a href="<?=site_url()?>config/supir">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Supir
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover <?=(strtolower($subtitle)=='club' ? 'active open' : '')?>">
								<a href="<?=site_url()?>config/club">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Club
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover <?=(strtolower($subtitle)=='catering' ? 'active open' : '')?>">
								<a href="<?=site_url()?>config/catering">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Vendor Catering
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover <?=(strtolower($subtitle)=='jarakjemputan' ? 'active open' : '')?>">
								<a href="<?=site_url()?>config/jarakjemputan">
									<i class="menu-icon fa fa-caret-right"></i>
									Data Jarak Jemputan
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover <?=(strtolower($subtitle)=='user' ? 'active open' : '')?>">
								<a href="<?=site_url()?>config/user">
									<i class="menu-icon fa fa-caret-right"></i>
									Data User
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover <?=(strtolower($subtitle)=='tahunajaran' ? 'active open' : '')?>">
								<a href="<?=site_url()?>config/tahunajaran">
									<i class="menu-icon fa fa-caret-right"></i>
									Tahun Ajaran
								</a>

								<b class="arrow"></b>
							</li>
							<li class="hover <?=(strtolower($subtitle)=='akun' ? 'active open' : '')?>">
								<a href="<?=site_url()?>config/akun">
									<i class="menu-icon fa fa-caret-right"></i>
									Kode Akun
								</a>

								<b class="arrow"></b>
							</li>

						<?php
						}
						?>
						</ul>
					</li>

					
				</ul><!-- /.nav-list -->

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>