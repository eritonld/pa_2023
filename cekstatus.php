<?php
include("conf/conf.php");
include("tabel_setting.php");

if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa="ind";
}

if($bahasa=='eng'){
	$atasan1="Direct Superior";
	$atasan2="Indirect Superior 1";
	$atasan3="Indirect Superior 2";
}else{
	$atasan1="Atasan 1 (Atasan Langsung)";
	$atasan2="Atasan 2";
	$atasan3="Atasan 3";
}

$idkar=$_GET['nik'];
$cekstatus=mysqli_query($koneksi,"SELECT k.id, ats.id_atasan1, a1.Nama_Lengkap as nama_atasan1, a1.Email as email_atasan1, ats.id_atasan2, a2.Nama_Lengkap  as nama_atasan2, a2.Email as email_atasan2, ats.id_atasan3, a3.Nama_Lengkap  as nama_atasan3, a3.Email as email_atasan3, ats.p1,ats.p2,ats.p3,dg.fortable, dg.Nama_Golongan, (SELECT COUNT(idkar) FROM `atasan` where id_atasan1='$idkar' or id_atasan2='$idkar' or id_atasan3='$idkar') as jumlah_subo FROM $karyawan as k 
left join daftargolongan as dg on dg.Kode_Golongan=k.Kode_Golongan 
left join atasan as ats on ats.idkar=k.id
left join $karyawan as a1 on a1.id=ats.id_atasan1
left join $karyawan as a2 on a2.id=ats.id_atasan2
left join $karyawan as a3 on a3.id=ats.id_atasan3
where k.id='$idkar'");
$scekstatus=mysqli_fetch_array($cekstatus);

$fortable="";

if($scekstatus['fortable']=='staff'){
	if($scekstatus['jumlah_subo']>0){
		$fortable="staffb";
	}else{
		$fortable="staff";
	}
}else{
	$fortable="$scekstatus[fortable]";
}
// echo "<br>$fortable";
?>
<input type="hidden" class="form-control" id ="fortable" name="fortable" value="<?php echo "$fortable"; ?>" readonly>
<div class="form-group">
	<table style="width:100%">
		<tr>
			<td style="width:20%"><label><?php echo "$atasan1"; ?></label></td>
			<td style="width:1%"></td>
			<td style="width:24%"><label>Email</label></td>
			<td style="width:55%"></td>
		</tr>
		<tr>
			<td>
				<input type="hidden" class="form-control" id ="id_atasan1" name="id_atasan1" value="<?php echo "$scekstatus[id_atasan1]"; ?>">
				<input type="text" class="form-control" id ="nama_atasan1" name="nama_atasan1" value="<?php echo "$scekstatus[nama_atasan1]"; ?>" readonly>
			</td>
			<td style="width:1%"></td>
			<td>
				<input type="text" class="form-control" id ="email_atasan1" name="email_atasan1" value="<?php echo "$scekstatus[email_atasan1]"; ?>" readonly>
			</td>
			<td></td>
		</tr>
	</table>
</div>
<div class="form-group">
	<table style="width:100%">
		<tr>
			<td style="width:20%"><label><?php echo "$atasan2"; ?></label></td>
			<td style="width:1%"></td>
			<td style="width:24%"><label>Email</label></td>
			<td style="width:55%"></td>
		</tr>
		<tr>
			<td>
				<input type="hidden" class="form-control" id ="id_atasan2" name="id_atasan2" value="<?php echo "$scekstatus[id_atasan2]"; ?>">
				<input type="text" class="form-control" id ="nama_atasan2" name="nama_atasan2" value="<?php echo "$scekstatus[nama_atasan2]"; ?>" readonly>
			</td>
			<td style="width:1%"></td>
			<td>
				<input type="text" class="form-control" id ="email_atasan2" name="email_atasan2" value="<?php echo "$scekstatus[email_atasan2]"; ?>" readonly>
			</td>
			<td></td>
		</tr>
	</table>
</div>
<div class="form-group">
	<table style="width:100%">
		<tr>
			<td style="width:20%"><label><?php echo "$atasan3"; ?></label></td>
			<td style="width:1%"></td>
			<td style="width:24%"><label>Email</label></td>
			<td style="width:55%"></td>
		</tr>
		<tr>
			<td>
				<input type="hidden" class="form-control" id ="id_atasan3" name="id_atasan3" value="<?php echo "$scekstatus[id_atasan3]"; ?>">
				<input type="text" class="form-control" id ="nama_atasan3" name="nama_atasan3" value="<?php echo "$scekstatus[nama_atasan3]"; ?>" readonly>
			</td>
			<td style="width:1%"></td>
			<td>
				<input type="text" class="form-control" id ="email_atasan3" name="email_atasan3" value="<?php echo "$scekstatus[email_atasan3]"; ?>" readonly>
			</td>
			<td></td>
		</tr>
	</table>
</div>