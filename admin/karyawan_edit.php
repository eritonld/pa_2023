<?php
include("../conf/conf.php");
include("../tabel_setting.php");

if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

if(isset($_GET['nik'])){
	$nik=$_GET['nik'];
}else{
	$nik="";
}
if($nik=='')
{?>
	<script language="JavaScript">
		alert('Dilarang Refresh/Masukan NIK');
		document.location='home.php?link=dashboard';
	</script>
<?php	
exit;
}
$sql = "select tp1.approver_id as p1,(tp1.total_culture+tp1.total_leadership) as totalnilai_p1,tp2.approver_id as p2,(tp2.total_culture+tp2.total_leadership) as totalnilai_p2,tp3.approver_id as p3,(tp3.total_culture+tp3.total_leadership) as totalnilai_p3,sub1.approver_id as sub1,(sub1.total_culture+sub1.total_leadership) as totalnilai_sub1,sub2.approver_id as sub2,(sub2.total_culture+sub2.total_leadership) as totalnilai_sub2,sub3.approver_id as sub3,(sub3.total_culture+sub3.total_leadership) as totalnilai_sub3,k.*,dp.Nama_Perusahaan,dep.Nama_Departemen, dg.Nama_Golongan,k.Nama_Jabatan,du.Nama_OU from $karyawan as k 
left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan 
left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen 
left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan 
left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan 
left join daftarou as du on k.Kode_OU=du.Kode_OU 
left join $transaksi_pa as tp1 on tp1.idkar=k.id and tp1.layer='p1'
left join $transaksi_pa as tp2 on tp2.idkar=k.id and tp2.layer='p2'
left join $transaksi_pa as tp3 on tp3.idkar=k.id and tp3.layer='p3'
left join $transaksi_pa as sub1 on sub1.idkar=k.id and sub1.layer='sub1'
left join $transaksi_pa as sub2 on sub2.idkar=k.id and sub2.layer='sub2'
left join $transaksi_pa as sub3 on sub3.idkar=k.id and sub3.layer='sub3'
where k.NIK='$nik'";

$stmt = $koneksi->prepare($sql);
$stmt->execute();
$ckaryawan = $stmt->fetch(PDO::FETCH_ASSOC);

$display_quartal="none";
$display_peers="none";
if($ckaryawan['pltinds']=='Cement'){$display_quartal="";} //echo $ckaryawan['pltinds']." - $display_quartal <br>";
if($ckaryawan['Kode_Golongan']>'GL023'){$display_peers="";} //echo $ckaryawan['Kode_Golongan']." - $display_peers <br>";

$sql = "select * from user_pa where username='$nik'";
$stmt = $koneksi->prepare($sql);
$stmt->execute();
$scekuser1 = $stmt->fetch(PDO::FETCH_ASSOC);

if($bahasa=='eng')
{
	$tabel_prosedure="prosedure_english";
	$a1='Update Employee';
	$a2='Employee Name';
	$a3='Company';
	$a4='Employee No';
	$a5='Division/Department';
	$a6='Designation';
	$a7='Section/SubSection';
	$a8='Work Begin';
	$a9='Period of Assessment';
	$a10='Grade';
	$a11='SP/period';
	$a12='Rating';
	$a13='On Rating';
	$a14='Unit';
}
else
{	
	$tabel_prosedure="prosedure";
	$a1='Edit Karyawan';
	$a2='Nama Karyawan';
	$a3='Nama PT';
	$a4='Nomor Induk';
	$a5='Divisi/Departemen';
	$a6='Jabatan';
	$a7='Seksi/SubSeksi';
	$a8='Mulai bekerja';
	$a9='Periode Penilaian';
	$a10='Golongan';
	$a11='SP/Periode';
	$a12='Bobot';
	$a13='Pembobotan';
	$a14='Lokasi Kerja';
}

if($scekuser['username']=="adminhomaster"){
	$display="";
	$readonly="";
}else if($scekuser['level']=="admin"){
	$display="";
	$readonly="readonly";
}else if($scekuser['level']=="adminhco"){
	$display="none";
	$readonly="readonly";
}else{
	$display="none";
	$readonly="readonly";
}

// pointer-events: none; readonly; 
if($ckaryawan['totalnilai_p1']>0){$pointer_p1="none"; $readonly_p1="readonly";}else{$pointer_p1=""; $readonly_p1="";}
if($ckaryawan['totalnilai_p2']>0){$pointer_p2="none"; $readonly_p2="readonly";}else{$pointer_p2=""; $readonly_p2="";}
if($ckaryawan['totalnilai_p3']>0){$pointer_p3="none"; $readonly_p3="readonly";}else{$pointer_p3=""; $readonly_p3="";}

if($ckaryawan['totalnilai_sub1']>0){$pointer_sub1="none"; $readonly_sub1="readonly";}else{$pointer_sub1=""; $readonly_sub1="";}
if($ckaryawan['totalnilai_sub2']>0){$pointer_sub2="none"; $readonly_sub2="readonly";}else{$pointer_sub2=""; $readonly_sub2="";}
if($ckaryawan['totalnilai_sub3']>0){$pointer_sub3="none"; $readonly_sub3="readonly";}else{$pointer_sub3=""; $readonly_sub3="";}
?>
<div class="row">
<section class="col-lg-12 connectedSortable">
  <div class="nav-tabs-custom">
	<div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo"<b>$a1</b>";?></h3>
        </div>
        <div class="box-body">
<form name="forminputeos" method="post" action="?link=dataemp">
<table class="table table-bordered">
	<tr>
		<td style="width:20%;"><?php echo"NIK";?></td>
		<td><input class="form-control" style="width:50%;" type="hidden" name="idkar" id="idkar" value="<?php echo"$ckaryawan[id]";?>" readonly />
		<input class="form-control" style="width:50%;" type="text" name="nik" id="nik" value="<?php echo"$ckaryawan[NIK]";?>" readonly /></td> 
	</tr>
	<tr>
		<td><?php echo"$a2";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="nama" id="nama" value="<?php echo"$ckaryawan[Nama_Lengkap]";?>" <?php echo $readonly; ?>/></td> 
	</tr>
	<tr>
		<td><?php echo"$a8";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="mulai" id="mulai" value="<?php echo"$ckaryawan[Mulai_Bekerja]";?>" <?php echo $readonly; ?>/></td> 
	</tr>
	<tr style="display:<?php echo $display; ?>">
		<td><?php echo"$a5";?></td>
		<td>
		<select id="dept" name="dept" class="form-control" style="width:50%;">
		  <?php 
		  $sql = "SELECT kode_departemen, Nama_Departemen FROM `daftardepartemen` ORDER BY Nama_Departemen asc;";
		  $stmt = $koneksi->prepare($sql);
		  $stmt->execute();
		  
		  while ($r_dept = $stmt->fetch(PDO::FETCH_ASSOC))
		  {
		  $selected="";
		  if($ckaryawan['Kode_Departemen']==$r_dept['kode_departemen']){$selected="selected";}
		  ?>
			<option value="<?php echo $r_dept['kode_departemen']; ?>" <?php echo $selected; ?>><?php echo $r_dept['Nama_Departemen']; ?></option>
		  <?php
		  }
		  ?>
		</select>
		</td> 
	</tr>
	<tr style="display:<?php echo $display; ?>">
		<td><?php echo"$a6";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="jabatan" id="jabatan" value="<?php echo"$ckaryawan[Nama_Jabatan]";?>" /></td> 
	</tr>
	<tr style="display:<?php echo $display; ?>">
		<td><?php echo"$a10";?></td>
		<td>
		<select id="gol" name="gol" class="form-control" style="width:50%;">
		  <?php 
		  $sql = "SELECT Kode_Golongan, Nama_Golongan FROM `daftargolongan` where active='T' ORDER BY Nama_Golongan asc;";
		  $stmt = $koneksi->prepare($sql);
		  $stmt->execute();
		  
		  while ($r_gol = $stmt->fetch(PDO::FETCH_ASSOC))
		  {
		  $selected="";
		  if($ckaryawan['Kode_Golongan']==$r_gol['Kode_Golongan']){$selected="selected";}
		  ?>
			<option value="<?php echo $r_gol['Kode_Golongan']; ?>" <?php echo $selected; ?>><?php echo $r_gol['Nama_Golongan']; ?></option>
		  <?php
		  }
		  ?>
		</select>
		</td> 
	</tr>
	<tr style="display:<?php echo $display; ?>">
		<td><?php echo"$a3";?></td>
		<td>
		<select id="pt" name="pt" class="form-control" style="width:50%;">
		  <?php 
		  $sql = "SELECT Kode_Perusahaan, Nama_Lkp_Perusahaan FROM `daftarperusahaan` where active='T' ORDER BY Nama_Lkp_Perusahaan asc;";
		  $stmt = $koneksi->prepare($sql);
		  $stmt->execute();
		  
		  while ($r_gol = $stmt->fetch(PDO::FETCH_ASSOC))
		  {
		  $selected="";
		  if($ckaryawan['Kode_Perusahaan']==$r_gol['Kode_Perusahaan']){$selected="selected";}
		  ?>
			<option value="<?php echo $r_gol['Kode_Perusahaan']; ?>" <?php echo $selected; ?>><?php echo $r_gol['Nama_Lkp_Perusahaan']; ?></option>
		  <?php
		  }
		  ?>
		</select>
		</td> 
	</tr>
	<tr style="display:<?php echo $display; ?>">
		<td><?php echo"$a14";?></td>
		<td>
		<select id="unit" name="unit" class="form-control" style="width:50%;">
		  <?php 
		  $sql = "SELECT Kode_OU, Nama_OU FROM `daftarou` where aktif='T' ORDER BY Nama_OU asc;";
		  $stmt = $koneksi->prepare($sql);
		  $stmt->execute();
		  
		  while ($r_gol = $stmt->fetch(PDO::FETCH_ASSOC))
		  {
		  $selected="";
		  if($ckaryawan['Kode_OU']==$r_gol['Kode_OU']){$selected="selected";}
		  ?>
			<option value="<?php echo $r_gol['Kode_OU']; ?>" <?php echo $selected; ?>><?php echo $r_gol['Nama_OU']; ?></option>
		  <?php
		  }
		  ?>
		</select>
		</td> 
	</tr>
	<tr style="display:<?php echo $display; ?>">
		<td><?php echo"Email";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="email" id="email" value="<?php echo"$ckaryawan[Email]";?>" /></td> 
	</tr>
	<?php if($ckaryawan['Kode_Golongan']>='GL012'){?>
	<tr style="display:<?php echo $display; ?>">
		<td><?php echo"Username";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="username" id="username" value="<?php if(isset($ckaryawan['NIK'])){echo"$ckaryawan[NIK]";} ?>" readonly /></td> 
	</tr>
	<tr style="display:<?php echo $display; ?>">
		<td><?php echo"Password";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="password" id="password" value="<?php if(isset($scekuser1['password'])){echo"$scekuser1[password]";} ?>" /> 12345678 = ec028a30c5d949fe8548cf244639584c</td> 
	</tr>
	<?php } ?>
	
	<tr style="display:<?php echo "$display_quartal"; ?>;">
		<td>Penilaian Q1</td>
		<td>
		<select id="pen_q1" name="pen_q1" style="width:10%" class="form-control" >
			<option value="" > - </option>
			<option value="A" <?php if($ckaryawan['pen_q1']=='A'){echo "selected";} ?>> A </option>
			<option value="B" <?php if($ckaryawan['pen_q1']=='B'){echo "selected";} ?>> B </option>
			<option value="C" <?php if($ckaryawan['pen_q1']=='C'){echo "selected";} ?>> C </option>
			<option value="D" <?php if($ckaryawan['pen_q1']=='D'){echo "selected";} ?>> D </option>
			<option value="E" <?php if($ckaryawan['pen_q1']=='E'){echo "selected";} ?>> E </option>
		</select>
		</td> 
	</tr>
	<tr style="display:<?php echo "$display_quartal"; ?>;">
		<td>Penilaian Q2</td>
		<td>
		<select id="pen_q2" name="pen_q2" style="width:10%" class="form-control" >
			<option value="" > - </option>
			<option value="A" <?php if($ckaryawan['pen_q2']=='A'){echo "selected";} ?>> A </option>
			<option value="B" <?php if($ckaryawan['pen_q2']=='B'){echo "selected";} ?>> B </option>
			<option value="C" <?php if($ckaryawan['pen_q2']=='C'){echo "selected";} ?>> C </option>
			<option value="D" <?php if($ckaryawan['pen_q2']=='D'){echo "selected";} ?>> D </option>
			<option value="E" <?php if($ckaryawan['pen_q2']=='E'){echo "selected";} ?>> E </option>
		</select>
		</td> 
	</tr>
	<tr style="display:<?php echo "$display_quartal"; ?>;">
		<td>Penilaian Q3</td>
		<td>
		<select id="pen_q3" name="pen_q3" style="width:10%" class="form-control" >
			<option value="" > - </option>
			<option value="A" <?php if($ckaryawan['pen_q3']=='A'){echo "selected";} ?>> A </option>
			<option value="B" <?php if($ckaryawan['pen_q3']=='B'){echo "selected";} ?>> B </option>
			<option value="C" <?php if($ckaryawan['pen_q3']=='C'){echo "selected";} ?>> C </option>
			<option value="D" <?php if($ckaryawan['pen_q3']=='D'){echo "selected";} ?>> D </option>
			<option value="E" <?php if($ckaryawan['pen_q3']=='E'){echo "selected";} ?>> E </option>
		</select>
		</td> 
	</tr>
	<tr style="display:<?php echo "$display_quartal"; ?>;">
		<td>Penilaian Q4</td>
		<td>
		<select id="pen_q4" name="pen_q4" style="width:10%" class="form-control" >
			<option value="" > - </option>
			<option value="A" <?php if($ckaryawan['pen_q4']=='A'){echo "selected";} ?>> A </option>
			<option value="B" <?php if($ckaryawan['pen_q4']=='B'){echo "selected";} ?>> B </option>
			<option value="C" <?php if($ckaryawan['pen_q4']=='C'){echo "selected";} ?>> C </option>
			<option value="D" <?php if($ckaryawan['pen_q4']=='D'){echo "selected";} ?>> D </option>
			<option value="E" <?php if($ckaryawan['pen_q4']=='E'){echo "selected";} ?>> E </option>
		</select>
		</td>
	</tr>
	<tr style="display:<?php echo "$display_peers"; ?>;">
		<td>Peers 1</td>
		<td>
			<select id="p1" name="p1" style="width:50%; pointer-events: <?php echo $pointer_p1; ?>;" class="form-control" <?php echo $readonly_p1; ?>>
				<option value="" > Pilih </option>
				<?php 
				$cek_sql = "SELECT ats.*, k.Nama_Lengkap FROM `atasan` as ats
				left join $karyawan as k on k.id=ats.idkar
				where ats.id_atasan=(SELECT id_atasan FROM `atasan` where idkar='$ckaryawan[id]' and layer='L1') and idkar<>'$ckaryawan[id]' ORDER BY k.Nama_Lengkap asc";
				
				$scek_sql = $koneksi->prepare($cek_sql);
				$scek_sql->execute();
				
				
				while($scekkar = $scek_sql->fetch(PDO::FETCH_ASSOC)){
					$selected="";
					if($scekkar['idkar']==$ckaryawan['p1']){$selected="selected";}
					?>
					<option value="<?php echo $scekkar['idkar']; ?>" <?php echo $selected; ?>><?php echo $scekkar['Nama_Lengkap']; ?></option>
				<?php } ?>
			</select>
		</td> 
	</tr>
	<tr style="display:<?php echo "$display_peers"; ?>;">
		<td>Peers 2</td>
		<td>
		<select id="p2" name="p2" style="width:50%; pointer-events: <?php echo $pointer_p2; ?>;" class="form-control" <?php echo $readonly_p2; ?>>
			<option value="" > Pilih </option>
			<?php 
			$cek_sql = "SELECT ats.*, k.Nama_Lengkap FROM `atasan` as ats
			left join $karyawan as k on k.id=ats.idkar
			where ats.id_atasan=(SELECT id_atasan FROM `atasan` where idkar='$ckaryawan[id]' and layer='L1') and idkar<>'$ckaryawan[id]' ORDER BY k.Nama_Lengkap asc";
			$scek_sql = $koneksi->prepare($cek_sql);
			$scek_sql->execute();
			
			while($scekkar = $scek_sql->fetch(PDO::FETCH_ASSOC)){
				$selected="";
				if($scekkar['idkar']==$ckaryawan['p2']){$selected="selected";}
				?>
				<option value="<?php echo $scekkar['idkar']; ?>" <?php echo $selected; ?>><?php echo $scekkar['Nama_Lengkap']; ?></option>
			<?php } ?>
		</select>
		</td> 
	</tr>
	<tr style="display:<?php echo "$display_peers"; ?>;">
		<td>Peers 3</td>
		<td>
		<select id="p3" name="p3" style="width:50%; pointer-events: <?php echo $pointer_p3; ?>;" class="form-control" <?php echo $readonly_p3; ?>>
			<option value="" > Pilih </option>
			<?php 
			$cek_sql = "SELECT ats.*, k.Nama_Lengkap FROM `atasan` as ats
			left join $karyawan as k on k.id=ats.idkar
			where ats.id_atasan=(SELECT id_atasan FROM `atasan` where idkar='$ckaryawan[id]' and layer='L1') and idkar<>'$ckaryawan[id]' ORDER BY k.Nama_Lengkap asc";
			$scek_sql = $koneksi->prepare($cek_sql);
			$scek_sql->execute();
			
			while($scekkar = $scek_sql->fetch(PDO::FETCH_ASSOC)){
				$selected="";
				if($scekkar['idkar']==$ckaryawan['p3']){$selected="selected";}
				?>
				<option value="<?php echo $scekkar['idkar']; ?>" <?php echo $selected; ?>><?php echo $scekkar['Nama_Lengkap']; ?></option>
			<?php } ?>
		</select>
		</td> 
	</tr>
	<tr style="display:<?php echo "$display_peers"; ?>;">
		<td>Subordinate 1</td>
		<td>
		<select id="sub1" name="sub1" style="width:50%; pointer-events: <?php echo $pointer_sub1; ?>;" class="form-control" <?php echo $readonly_sub1; ?>>
			<option value="" > Pilih </option>
			<?php 
			$cek_sql = "SELECT ats.*, k.Nama_Lengkap FROM `atasan` as ats
			left join $karyawan as k on k.id=ats.idkar
			where ats.id_atasan='$ckaryawan[id]' ORDER BY k.Nama_Lengkap asc";
			$scek_sql = $koneksi->prepare($cek_sql);
			$scek_sql->execute();
			
			while($scekkar = $scek_sql->fetch(PDO::FETCH_ASSOC)){
				$selected="";
				if($scekkar['idkar']==$ckaryawan['sub1']){$selected="selected";}
				?>
				<option value="<?php echo $scekkar['idkar']; ?>" <?php echo $selected; ?>><?php echo $scekkar['Nama_Lengkap']; ?></option>
			<?php } ?>
		</select>
		</td> 
	</tr>
	<tr style="display:<?php echo "$display_peers"; ?>;">
		<td>Subordinate 2</td>
		<td>
		<select id="sub2" name="sub2" style="width:50%; pointer-events: <?php echo $pointer_sub1; ?>;" class="form-control" <?php echo $readonly_sub1; ?>>
			<option value="" > Pilih </option>
			<?php 
			$cek_sql = "SELECT ats.*, k.Nama_Lengkap FROM `atasan` as ats
			left join $karyawan as k on k.id=ats.idkar
			where ats.id_atasan='$ckaryawan[id]' ORDER BY k.Nama_Lengkap asc";
			$scek_sql = $koneksi->prepare($cek_sql);
			$scek_sql->execute();
			
			while($scekkar = $scek_sql->fetch(PDO::FETCH_ASSOC)){
				$selected="";
				if($scekkar['idkar']==$ckaryawan['sub2']){$selected="selected";}
				?>
				<option value="<?php echo $scekkar['idkar']; ?>" <?php echo $selected; ?>><?php echo $scekkar['Nama_Lengkap']; ?></option>
			<?php } ?>
		</select>
		</td> 
	</tr>
	<tr style="display:<?php echo "$display_peers"; ?>;">
		<td>Subordinate 3</td>
		<td>
		<select id="sub3" name="sub3" style="width:50%; pointer-events: <?php echo $pointer_sub1; ?>;" class="form-control" <?php echo $readonly_sub1; ?>>
			<option value="" > Pilih </option>
			<?php 
			$cek_sql = "SELECT ats.*, k.Nama_Lengkap FROM `atasan` as ats
			left join $karyawan as k on k.id=ats.idkar
			where ats.id_atasan='$ckaryawan[id]' ORDER BY k.Nama_Lengkap asc";
			$scek_sql = $koneksi->prepare($cek_sql);
			$scek_sql->execute();
			
			while($scekkar = $scek_sql->fetch(PDO::FETCH_ASSOC)){
				$selected="";
				if($scekkar['idkar']==$ckaryawan['sub3']){$selected="selected";}
				?>
				<option value="<?php echo $scekkar['idkar']; ?>" <?php echo $selected; ?>><?php echo $scekkar['Nama_Lengkap']; ?></option>
			<?php } ?>
		</select>
		</td> 
	</tr>
	<tr>
		<td><button type="submit" name="btnsave" class="btn btn-success">Submit</button></td>
		<td><input type="hidden" name="generatekar" value="T"></td> 
	</tr>
</table>
</form>
</div>
    </div>
  </div>
</section>
</div>