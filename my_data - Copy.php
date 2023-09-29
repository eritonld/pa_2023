<?php
include("tabel_setting.php");
function getTotalScorez($nik,$grade,$transpa)
{
	if($grade=='1' || $grade=='2A' || $grade=='2B' || $grade=='2C' || $grade=='2D')
	{
		$fortable='nonstaff';
	}
	else if($grade=='3A' || $grade=='3B' || $grade=='3C' || $grade=='3D' || $grade=='4A' || $grade=='4B' || $grade=='4C' || $grade=='4D')
	{
		$fortable='staff';
	}
	else if($grade=='5A' || $grade=='5B' || $grade=='6A' || $grade=='6B')
	{
		$fortable='firstline';
	}
	else
	{
		$fortable='managerial';	
	}
	
	
	$q_bobot = mysqli_query($koneksi,"Select * from master_soal_$fortable where id  = 2");
	$r_bobot = mysqli_fetch_array($q_bobot);
	
	$qnil 	= mysqli_query($koneksi,"Select * from $transpa where nik = '$nik'");
	$rnil	= mysqli_fetch_array($qnil);
	
	$qproc 	= mysqli_query($koneksi,"Select * from prosedure where fortable = '$fortable' order by komposisi_group ASC");
	
	$totalall = 0;
	while ($rpoc = mysqli_fetch_array($qproc))
	{
		$totalsub = 0;
		for ($i=1;$i<=$rpoc['jml_loop'];$i++)
		{
			$slc 	= $rpoc['komposisi_group'].$i;
			$bot	= ($r_bobot[$slc]/($rpoc['bobot']/100));
			$nil	= $rnil[$slc];
			$nilx	= number_format((($nil*$bot)/100),2);
			$totalsub = $totalsub+$nilx;
		}
		$totalsubx 	= $totalsub/50;
		$totalsuby 	= number_format(($totalsubx*($rpoc['bobot']/100)),2);
		$totalall	= $totalall+$totalsuby;
	}
	$totalallx = $totalall*100;
	$totalallfix=$totalallx;
	//echo $totalallfix;
	return $totalallfix;
}

function getGrade($nilai)
{
	$tahun=date('Y');
	$cekkriteria=mysqli_query($koneksi,"select ranges,grade,kesimpulan,warna,icon,bermasalah from kriteria where tahun='$tahun' order by id asc");
	$ak=0;
	while($ccekkriteria=mysqli_fetch_array($cekkriteria))
	{
		$rngs[$ak]=$ccekkriteria['ranges'];
		$g[$ak]=$ccekkriteria['grade'];
		$ak++;
	}
	$gradenya="E";
	$warna="000000";
	for($aa=0;$aa<$ak;$aa++)
	{		
		if($nilai >= $rngs[$aa])
		{
			$gradenya=$g[$aa];
			break;
		}		
	}
	return $gradenya;
}

//get master nik
$qnik 	= mysqli_query($koneksi,"Select username from user_pa where id = $idmaster_pa");
$getnik	= mysqli_fetch_array($qnik);

$cari=$_POST['cari'];
// if($tahunproses==""){
	// $tahunproses=2017;
// }
?>
<script>
	function excel()
	{
		window.open("reportexcel1.php?idmaster=<?php echo $idmaster_pa ?>&tahunproses=<?php echo $tahunproses ?>");
	}	
	function excelatasan(nikatasan,atasnya)
	{
		window.open("reportexcel1.php?nikatasan="+nikatasan+"&atasan="+atasnya+"&tahunproses=<?php echo $tahunproses ?>");
	}
	function viewdata(nik)
	{
		window.open("papdf.php?nik="+nik+"&tahunproses=<?php echo $tahunproses ?>");
	}	
	function editdata(nik,form)
	{
		window.open("home.php?link=formpa_edit&nik="+nik+"&darimydata=1&iddari="+form);
	}
</script>
<div class="row">
<section class="col-lg-12 connectedSortable">
  <div class="nav-tabs-custom">
	<div class="box box-danger">
			<div class="box-header with-border">
			  <h4><i class="fa fa-angle-right"></i> Appraisal Data</h4>
			</div>
			  <form name="caridata"  method="post" action="" id="formsearch">
					<div class="form-group">
						<div class="col-md-2 col-xs-11">
							<input type="text" class="form-control" name="cari" id="cari" value="<?php echo"$cari";?>" placeholder="Search Employee">
							<input type="hidden" value="1" name="showsearch">
						</div>	
						<div class="col-md-2 col-xs-11">
							<select id="tahunproses" name="tahunproses" class="form-control">
							  <?php
							   if($idmaster=='1' || $idmaster=='2'){$tahunaktif="2019";}else{$tahunaktif=date('Y');}
							  for($t=date('Y');$t>=$tahunaktif;$t--)
							  {?>
								<option value='<?php echo"$t";?>' <?php if($t==$tahunproses) echo"selected";?>><?php echo"$t";?></option>
							<?php
							  }
								?>
							</select>
						</div>
						<div class="col-md-8 col-xs-11">
							<button type="submit" class="btn btn-theme"><i class="fa fa-search"></i> Search</button>
						</div>
				  </div>
			  </form>
			  <br><br><br>
			  <div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active">
						<a data-toggle="tab" href="#AllDocument"><?php echo "$mydata1"; ?></a>
					</li>
					<li>
						<a data-toggle="tab" href="#ActivityLog " class="contact-map"><?php echo "$mydata2"; ?></a>
					</li>
					<li>
						<a data-toggle="tab" href="#ActivityLog2 " class="contact-map"><?php echo "$mydata3"; ?></a>
					</li>
				</ul>
			</div>
			<div class="panel-body">
				<div class="tab-content">	
					<div id="AllDocument" class="tab-pane active">
						<div class="form-group">
							<div class="col-md-12 col-xs-12">
								<?php
								if($bahasa=='eng'){ echo "All the assessment that has been done, either self-assessment or other`s"; }
								else { echo "Seluruh penilaian yang sudah Anda lakukan, baik penilaian terhadap Anda Sendiri maupun terhadap orang lain."; }
								?>
								<br><br>
								<img src="../img/excel2.png" onClick="excel()" style="padding-top:0px;cursor:pointer;width:3%;"title="Recapitulation on Excel"></img>  
							</div>
						</div>
						<div class="clear"><br></div>
						  <section id="no-more-tables">
							
							  <table class="table table-bordered table-striped table-condensed cf">
								  <thead class="cf">
									<tr>
										<th>No</th>
										<th>Name</th> 
										<th>Position</th> 
										<th>Grade</th>  
										<th>Unit</th> 
										<th>Department</th> 
										<th>Input Date</th>
										<!--
										<th>Reviewer 1</th>
										<th>Reviewer 2</th>-->
										<th style="background:#ffffaa;">Final Total Score</th>
										<th>Action</th>
								  </tr>
								  </thead>
								  <tbody>
								  <?php
									//tutup golongan 6 ke atas
									$qgol="";
									if($tahunproses!=Date('Y') && $tahunproses!=''){
										$qgol ="and k.Kode_Golongan<'GL019'";
									}
								  
									$q_data = mysqli_query ($koneksi,"select tp.edit_by,tp.edit_komite,tp.date_edit,tp.date_edit2,  tp.edit_by2,k.NIK,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen,
									dg.Nama_Golongan,dj.Nama_Jabatan, tp.date_input, do.Nama_OU,tp.total,tpa.total as totalawal,tpa1.total as total1,tpa2.total as total2,
									(Select Nama_Lengkap from $karyawan where nik = (select username from user_pa where id = tp.edit_by))as namaedit1,
									(Select Nama_Lengkap from $karyawan where nik = (select username from user_pa where id = tp.edit_by2))as namaedit2 
									from $karyawan as k
									left join daftarou as do on k.Kode_OU = do.Kode_OU
									left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan
									left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen
									left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan
									left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan
									left join $transaksi_pa as tp on k.NIK = tp.NIK
									left join $transaksi_pa_awal as tpa on k.NIK = tpa.NIK
									left join $transaksi_pa_edit1 as tpa1 on k.NIK = tpa1.NIK
									left join $transaksi_pa_edit2 as tpa2 on k.NIK = tpa2.NIK
									where tp.input_by = $idmaster_pa and k.Nama_Lengkap like '%$cari%' $qgol order by k.Nama_Lengkap ASC ");
															  
								  $no=1;
								  while ($r_data = mysqli_fetch_array ($q_data))
								  {	
									$total1="";
									$total2="";
									if($r_data['namaedit1']<>''){$total1="- ".$r_data['total1']."% (".getGrade($r_data['total1']).")";}
									if($r_data['namaedit2']<>''){$total2="- ".$r_data['total2']."% (".getGrade($r_data['total2']).")";}
								  ?>
									  <tr>
										  <td data-title="No"><?php echo $no ?></td>
										  <td data-title="Name"><?php echo $r_data['Nama_Lengkap'] ?></td>
										  <td data-title="Position"><?php echo $r_data['Nama_Jabatan'] ?></td>
										  <td data-title="Grade"><?php echo $r_data['Nama_Golongan'] ?></td>
										  <td data-title="Unit"><?php echo $r_data['Nama_OU'] ?></td> 
										  <td data-title="Department"><?php echo $r_data['Nama_Departemen'] ?></td>
										  <td data-title="Last Update"><?php echo $r_data['date_input'] ?></td>
										  <!--<td data-title="Edit By Superior"><?php //echo"$r_data[namaedit1]"; if($r_data[namaedit1]<>''){echo " ($r_data[date_edit])";}?></td>
										  <td data-title="Edit By H. Superior"><?php //echo"$r_data[namaedit2]"; if($r_data[namaedit2]<>''){echo " ($r_data[date_edit2])";}?></td>-->
										  <td data-title="Total Score"><?php 
												echo "<b>".$r_data['total']."% (".getGrade($r_data['total']).")</b>"; 
										  ?></td>
										  <td data-title="Action">
											<!--<button class="btn btn-info btn-xs" onclick = "viewdata('<?php //echo $r_data[NIK]?>')"><i class="fa fa-search"></i></button>	-->
											<?php 
											if(trim($r_data['edit_komite'])<>'')
											{
												echo "Assessed by Committee";
											}
											else
											{
											
											if (trim($r_data['edit_by'])=='' && trim($r_data['edit_by2'])=='')
											{
												if($tahunproses==date('Y') || $tahunproses=='')
												{
												?>
												<button class="btn btn-danger btn-xs" onclick = "editdata('<?php echo $r_data['NIK']?>','1')"><i class="fa fa-pencil"></i></button>	
												<?php
												}
											}
											
											}
											?>
											
											</td>
									  </tr>
								  <?php
									$no++;
								  }
								  ?>
								  </tbody>
							  </table>
						  </section>
					</div>
					<div id="ActivityLog" class="tab-pane" >
						<div class="form-group">
							<div class="col-md-12 col-xs-12">
								<?php
								if($bahasa=='eng'){ echo "All the appraisal of your direct subordinate."; }
								else { echo "Seluruh penilaian bawahan langsung Anda."; }
								?>
								<br><br>
								<img src="../img/excel2.png" onClick="excelatasan('<?php echo $getnik['username'] ?>','1')" style="padding-top:0px;cursor:pointer;width:3%;"title="Recapitulation on Excel"></img> <br> 
							</div>
						</div>
						<div class="clear"><br></div>
						<section id="no-more-tables">
							  <table class="table table-bordered table-striped table-condensed cf">
								  <thead class="cf">
									<tr>
										<th>No</th>
										<th>Name</th> 
										<th>Position</th> 
										<th>Grade</th>  
										<th>Unit</th> 
										<th>Department</th> 
										<th>Input Date</th>
										<!--<th>Reviewer 1</th>
										<th>Reviewer 2</th>-->
										<th style="background:#ffffaa;">Final Total Score</th>
										<th>Action</th>
								  </tr>
								  </thead>
								  <tbody>
								  <?php
									
									$qcekatasan1 = mysqli_query($koneksi,"select  tp.edit_by, tp.edit_komite,tp.date_edit,tp.date_edit2,tp.edit_by2,k.NIK,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen,dg.Nama_Golongan,dj.Nama_Jabatan, tp.date_input, do.Nama_OU,tp.total,tpa.total as totalawal,tpa1.total as total1,tpa2.total as total2,
									(Select Nama_Lengkap from $karyawan where nik = (select username from user_pa where id = tp.edit_by))as namaedit1,
									(Select Nama_Lengkap from $karyawan where nik = (select username from user_pa where id = tp.edit_by2))as namaedit2
									 from $karyawan as k
									left join daftarou as do on k.Kode_OU = do.Kode_OU
									left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan
									left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen
									left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan
									left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan
									left join $transaksi_pa as tp on k.NIK = tp.NIK
									left join $transaksi_pa_awal as tpa on k.NIK = tpa.NIK
									left join $transaksi_pa_edit1 as tpa1 on k.NIK = tpa1.NIK
									left join $transaksi_pa_edit2 as tpa2 on k.NIK = tpa2.NIK
									left join atasan as a on k.NIK = a.nik
									where a.nik_atasan1 = '$getnik[username]' and k.Nama_Lengkap like '%$cari%' and tp.date_input <> '' order by k.Nama_lengkap ASC");
									
								
								  $no=1;
								  while ($rcekatasan1 = mysqli_fetch_array($qcekatasan1))
								  {								  
									$total1="";
									$total2="";
									if($rcekatasan1['namaedit1']<>''){$total1="- ".$rcekatasan1['total1']."% (".getGrade($rcekatasan1['total1']).")";}
									if($rcekatasan1['namaedit2']<>''){$total2="- ".$rcekatasan1['total2']."% (".getGrade($rcekatasan1['total2']).")";}
								  ?>
									  <tr>
										  <td data-title="No"><?php echo $no ?></td>
										  <td data-title="Name"><?php echo $rcekatasan1['Nama_Lengkap'] ?></td>
										  <td data-title="Position"><?php echo $rcekatasan1['Nama_Jabatan'] ?></td>
										  <td data-title="Grade"><?php echo $rcekatasan1['Nama_Golongan'] ?></td>
										  <td data-title="Unit"><?php echo $rcekatasan1['Nama_OU'] ?></td>
										  <td data-title="Department"><?php echo $rcekatasan1['Nama_Departemen'] ?></td>
										  <td data-title="Input Date"><?php echo $rcekatasan1['date_input'] ?></td>
										  
										  <!--<td data-title="Edit By Superior"><?php //echo"$rcekatasan1[namaedit1]"; if($rcekatasan1[namaedit1]<>''){echo " ($rcekatasan1[date_edit])";}?></td>
										  <td data-title="Edit By H. Superior"><?php //echo"$rcekatasan1[namaedit2]"; if($rcekatasan1[namaedit2]<>''){echo " ($rcekatasan1[date_edit2])";}?></td>-->
										  
										  <td data-title="Final Total Score"><?php
												echo "<b>".$rcekatasan1['total']."% (".getGrade($rcekatasan1['total']).")</b>"; 
										  ?></td>
										  <td data-title="Action">
											<!--<button class="btn btn-info btn-xs" onclick = "viewdata('<?php //echo $rcekatasan1[NIK]?>')"><i class="fa fa-search"></i></button>-->
											<?php
											if(trim($rcekatasan1['edit_komite'])<>'')
											{
												echo "Assessed by Committee";
											}
											else
											{
											$datediff1 = ((strtotime(Date('Y-m-d')))-strtotime($rcekatasan1['date_edit']))/86400;
											if (trim($rcekatasan1['edit_by2'])=='')
											{
												if(trim($rcekatasan1['edit_by'])=='')
												{
													if($tahunproses==date('Y') || $tahunproses=='')
													{
													?>
													<button class="btn btn-danger btn-xs" onclick = "editdata('<?php echo $rcekatasan1['NIK']?>','2')"><i class="fa fa-pencil"></i></button>	
													<?php
													}
												}
												else
												{
													if($datediff1<=30)
													//if($rcekatasan1[date_edit]=='')
													{
														if($tahunproses==date('Y') || $tahunproses=='')
														{
														?>
														<button class="btn btn-danger btn-xs" onclick = "editdata('<?php echo $rcekatasan1['NIK']?>','2')"><i class="fa fa-pencil"></i></button>	
														<?php
														}
													}
													else
													{
														//do nothing
													}
												}
											}
											else
											{	
												//do nothing
											}
											}
											?>
										  </td>
									  </tr>
								  <?php
									$no++;
								  }
								  ?>
								  </tbody>
							  </table>
						  </section>
					</div>
					<div id="ActivityLog2" class="tab-pane" >
						<div class="form-group">
							<div class="col-md-12 col-xs-12">
								 <?php
								 if($bahasa=='eng'){ echo "All the appraisal of your indirect subordinate."; }
								 else { echo "Seluruh penilaian bawahan tidak langsung Anda."; }
								 ?>
								<br><br>
								<img src="../img/excel2.png" onClick="excelatasan('<?php echo $getnik['username'] ?>','2')" style="padding-top:0px;cursor:pointer;width:3%;"title="Recapitulation on Excel"></img>  
							</div>
						</div>
						<div class="clear"><br></div>
							<section id="no-more-tables">
							  <table class="table table-bordered table-striped table-condensed cf">
								  <thead class="cf">
									<tr>
										<th>No</th>
										<th>Name</th> 
										<th>Position</th> 
										<th>Grade</th>  
										<th>Unit</th> 
										<th>Department</th> 
										<th>Input Date</th>
										
										<!--<th>Reviewer 1</th>
										<th>Reviewer 2</th>-->
										<th style="background:#ffffaa;">Final Total Score</th>
										<th>Action</th>
								  </tr>
								  </thead>
								  <tbody>
								  <?php
									$qcekatasan2 = mysqli_query($koneksi,"select  tp.edit_by,tp.edit_komite, tp.date_edit,tp.date_edit2,tp.edit_by2,k.NIK,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen,
									dg.Nama_Golongan,dj.Nama_Jabatan, tp.date_input, do.Nama_OU,tp.total,tpa.total as totalawal,tpa1.total as total1,tpa2.total as total2,
									(Select Nama_Lengkap from $karyawan where nik = (select username from user_pa where id = tp.edit_by))as namaedit1,
									(Select Nama_Lengkap from $karyawan where nik = (select username from user_pa where id = tp.edit_by2))as namaedit2
									 from $karyawan as k
									left join daftarou as do on k.Kode_OU = do.Kode_OU
									left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan
									left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen
									left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan
									left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan
									left join $transaksi_pa as tp on k.NIK = tp.NIK
									left join $transaksi_pa_awal as tpa on k.NIK = tpa.NIK
									left join $transaksi_pa_edit1 as tpa1 on k.NIK = tpa1.NIK
									left join $transaksi_pa_edit2 as tpa2 on k.NIK = tpa2.NIK
									left join atasan as a on k.NIK = a.nik
									where nik_atasan2 = '$getnik[username]' and k.Nama_Lengkap like '%$cari%'
									and  a.nik_atasan1 <> a.nik_atasan2 and tp.date_input <> ''			
									order by k.Nama_lengkap ASC");
								
								  $no=1;
								  while ($rcekatasan2 = mysqli_fetch_array($qcekatasan2))
								  {				
									$total1="";
									$total2="";
									if($rcekatasan2['namaedit1']<>''){$total1="- ".$rcekatasan2['total1']."% (".getGrade($rcekatasan2['total1']).")";}
									if($rcekatasan2['namaedit2']<>''){$total2="- ".$rcekatasan2['total2']."% (".getGrade($rcekatasan2['total2']).")";}
								  ?>
									  <tr>
										  <td data-title="No"><?php echo $no ?></td>
										  <td data-title="Name"><?php echo $rcekatasan2['Nama_Lengkap'] ?></td>
										  <td data-title="Position"><?php echo $rcekatasan2['Nama_Jabatan'] ?></td>
										  <td data-title="Grade"><?php echo $rcekatasan2['Nama_Golongan'] ?></td>
										  <td data-title="Unit"><?php echo $rcekatasan2['Nama_OU'] ?></td>
										  <td data-title="Department"><?php echo $rcekatasan2['Nama_Departemen'] ?></td>
										  <td data-title="Input Date"><?php echo $rcekatasan2['date_input'] ?></td>
										  
										  <!--<td data-title="Edit By Superior"><?php //echo"$rcekatasan2[namaedit1]"; if($rcekatasan2[namaedit1]<>''){echo " ($rcekatasan2[date_edit])";}?></td>
										  <td data-title="Edit By H. Superior"><?php //echo"$rcekatasan2[namaedit2]"; if($rcekatasan2[namaedit2]<>''){echo " ($rcekatasan2[date_edit2])";}?></td>-->
										  <td data-title="Final Total Score"><?php  
												echo "<b>".$rcekatasan2['total']."% (".getGrade($rcekatasan2['total']).")</b>"; 
										  ?></td>
										  <td data-title="Action">
											<!--<button class="btn btn-info btn-xs" onclick = "viewdata('<?php //echo $rcekatasan2[NIK]?>')"><i class="fa fa-search"></i></button>-->
											<?php
											if(trim($rcekatasan2['edit_komite'])<>'')
											{
												echo "Assessed by Committee";
											}
											else
											{
											$datediff2 = ((strtotime(Date('Y-m-d')))-strtotime($rcekatasan2['date_edit2']))/86400;
											
											if(trim($rcekatasan2['edit_by2'])=='')
											{
												if($tahunproses==date('Y') || $tahunproses=='')
												{
												?>
												<button class="btn btn-danger btn-xs" onclick = "editdata('<?php echo $rcekatasan2['NIK']?>','3')"><i class="fa fa-pencil"></i></button>	
												<?php
												}
											}
											else
											{
												if($datediff2<=30)
												//if($rcekatasan2[date_edit2]=='')
												{
													if($tahunproses==date('Y') || $tahunproses=='')
													{
													?>
													<button class="btn btn-danger btn-xs" onclick = "editdata('<?php echo $rcekatasan2['NIK']?>','3')"><i class="fa fa-pencil"></i></button>	
													<?php
													}
												}
												else
												{
														//do nothing
												}
											}
											}
											?>
											
										  </td>
									  </tr>
								  <?php
									$no++;
								  }
								  ?>
								  </tbody>
							  </table>
						  </section>
					</div>
				</div>
			</div>	
    </div>
  </div>
</section>
</div>