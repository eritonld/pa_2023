<style type="text/css">
.proses {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('../dist/img/loading7.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .9;
}
</style>

<script>  
function createRequestObject() 
{
	var ro;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer")
	{
		ro = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else
	{
		ro = new XMLHttpRequest();
	}
	 return ro;
}

var xmlhttp = createRequestObject();

function cmdtampildata(data,asal,nik1)
{	
	var nik=document.getElementById(nik1).value;
	//alert(nik);
	xmlhttp.open("get", "cekdata.php?dataunit="+data+"&asal="+asal+"&nik="+nik, true);
	
	xmlhttp.onreadystatechange = function()
	{
		if((xmlhttp.readyState==4)&&(xmlhttp.status==200))
		{
			if(asal=='unit1'){
				document.getElementById('nik').innerHTML=xmlhttp.responseText;
				//status(nik);
			}else if(asal=='unit2'){
				document.getElementById('superior').innerHTML=xmlhttp.responseText;
			}else if(asal=='unit3'){
				document.getElementById('headsuperior').innerHTML=xmlhttp.responseText;
			}
			//alert(xmlhttp.responseText);
		}
		return false;
	}
	xmlhttp.send(null);				
}

function statusbawahan(nik) {
//alert(nik);
xmlhttp.open("get", "cekstatus.php?nik="+nik, true);

	xmlhttp.onreadystatechange = function()
	{
		if((xmlhttp.readyState==4)&&(xmlhttp.status==200))
		{
			//alert(xmlhttp.responseText);
			document.getElementById('fortable').value=xmlhttp.responseText;
			
			if(xmlhttp.responseText == 'staff'){
				document.getElementById('bawahan').style.display = "";
			}else if(xmlhttp.responseText == 'Member'){
				document.getElementById('member').style.display = "";
			}else{
				document.getElementById('bawahan').style.display = "none";
				document.getElementById('member').style.display = "none";
			}
			
		}
		return false;
	}
	xmlhttp.send(null);	
}
function isi_emailatasan(superior,asal){

	xmlhttp.open("get", "cekdata.php?nikpa="+superior+"&asal="+asal, true);
	
	xmlhttp.onreadystatechange = function()
	{
		if((xmlhttp.readyState==4)&&(xmlhttp.status==200))
		{
			if(asal=='emailsuperior'){
				document.getElementById('superioremail').value=xmlhttp.responseText;
			}else if(asal=='heademailsuperior'){
				document.getElementById('headsuperioremail').value=xmlhttp.responseText;
			}
			
		}
		return false;
	}
	xmlhttp.send(null);
}
function cekvalid()
{
	if(document.getElementById('nik').value=='')
	{
		alert('Karyawan yang dinilai kosong');
		return false
	}
	else if(document.getElementById('superior').value=='')
	{
		alert('Atasan 1 Kosong');
		return false
	}
	else if (document.getElementById('superioremail').value=='')
	{
		alert("Email Atasan 1 Kosong");
		return false
	}
	else if(document.getElementById('headsuperior').value=='')
	{
		alert('Atasan 2 Kosong');
		return false
	}	
	else if(document.getElementById('headsuperioremail').value=='')
	{
		alert("Email Atasan 2 Kosong");
		return false
	}
	else
	{	
		if(document.getElementById('fortable').value=='staff')
		{
			if(document.getElementById('statbawah').value=='')
			{
				alert('Empty Status');
				return false
			}
		}else if(document.getElementById('fortable').value=='Member')
		{
			if(document.getElementById('statmember').value=='')
			{
				alert('Empty Status');
				return false
			}
		}
	
		var nik 					= document.getElementById('nik').value;		
		var superiorsend 			= document.getElementById('superior').value;
		var superioremailsend 		= document.getElementById('superioremail').value;
		var headsuperiorsend 		= document.getElementById('headsuperior').value;
		var headsuperioremailsend 	= document.getElementById('headsuperioremail').value;
		var statbawah 				= document.getElementById('statbawah').value;
		var statmember				= document.getElementById('statmember').value;
		
		xmlhttp.open("GET", "cekvalid.php?nik="+nik+"&superior="+superiorsend+"&headsuperior="+headsuperiorsend, true);
		
		xmlhttp.onreadystatechange = function() 
		{
			if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
			{
				// alert(xmlhttp.responseText);
				var cekvalid			= xmlhttp.responseText.split('|');
				var lanjut	 			= cekvalid[0];
				var varnik				= cekvalid[1];
				var varsuperior			= cekvalid[2];				
				var varheadsuperior		= cekvalid[3];
				var namainput			= cekvalid[4];
				
				if(lanjut == 0)
				{
					alert("invalid NIK !!");
				}
				else if(lanjut == 2)
				{
					alert("Data Already Available, PA was Assessed by "+namainput);
				}
				else
				{
					//alert("Berhasil");	
					window.location="home.php?link=formpa&nik="+varnik+"&superior="+varsuperior+"&headsuperior="+varheadsuperior+"&superioremail="+superioremailsend+"&headsuperioremail="+headsuperioremailsend+"&statbawah="+statbawah+"&statmember="+statmember;
				}
			}
        return false;
		}
		xmlhttp.send(null);   
	}
	return true;
}  
</script>
<div class="row">
<section class="col-lg-12 connectedSortable">
  <div class="nav-tabs-custom">
	<div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Search Employee</h3>
        </div>
        <div class="box-body">			
			<!-- -->
			<div class="form-group">
			<input type="hidden" name="fortable" id="fortable" />
			  <table>
			  <tr><td style="width:15%"><label><?php echo "$unitlokasi"; ?></label></td><td style="width:1%"></td><td style="width:24%"><label><?php echo "$karyawandinilai"; ?></label></td><td style="width:60%"></td></tr>
			  <tr><td>
				<select id="unit" name="unit" class="form-control" onchange="cmdtampildata(this.value,'unit1','unit')" required>
					<option value="" > -- <?php echo "$pilihunit"; ?> -- </option>
				  <?php 
				  $cekunit = mysqli_query ($koneksi, "SELECT Kode_OU, Nama_OU FROM `daftarou` where aktif='T' ORDER BY Nama_OU asc");
				  while ($scekunit	= mysqli_fetch_array ($cekunit))
				  {
				  ?>
					<option value="<?php echo $scekunit['Kode_OU']; ?>"><?php echo "$scekunit[Nama_OU]"; ?></option>
				  <?php
				  }
				  ?>
				</select>
				</td>
				<td></td>
			    <td>
				<select id="nik" name="nik" class="form-control" onchange="statusbawahan(this.value)" required>
					<option value="" > -- <?php echo "$pilihnama"; ?> -- </option>
				</select></td>
			    <td></td>
			  </tr>
			  </table>
			</div>
			<div class="form-group">
			  <table>
			  <tr>
			   <td style="width:15%"><label><?php echo "$unitlokasi"; ?></label></td><td style="width:1%"></td>
			   <td style="width:24%"><label><?php echo "$atasan1"; ?></label></td><td style="width:1%"></td>
			   <td style="width:59%"><label>Email</label></td>
			  </tr>
			  <tr>
			  <td>
				<select id="unitsuperior" name="unitsuperior" class="form-control" onchange="cmdtampildata(this.value,'unit2','nik')" required>
					<option value="" > -- <?php echo "$pilihunit"; ?> -- </option>
				  <?php 
				  $cekunit = mysqli_query ($koneksi, "SELECT Kode_OU, Nama_OU FROM `daftarou` where aktif='T' ORDER BY Nama_OU asc");
				  while ($scekunit	= mysqli_fetch_array ($cekunit))
				  {
				  ?>
					<option value="<?php echo $scekunit['Kode_OU']; ?>"><?php echo "$scekunit[Nama_OU]"; ?></option>
				  <?php
				  }
				  ?>
				</select>
			  </td><td style="width:1%"></td>
			  <td>
				<select id="superior" name="superior" class="form-control" onchange="isi_emailatasan(this.value,'emailsuperior')" required>
					<option value="" > -- <?php echo "$pilihatasan"; ?> -- </option>
				</select>
			  </td><td style="width:1%"></td>
			  <td>
				<input type="text" class="form-control" id ="superioremail" name="superioremail" style="width:50%" placeholder="Superior's Email" >
			  </td>
			  </tr></table>
			</div>
			<div class="form-group">
			  <table>
			  <tr>
			   <td style="width:15%"><label><?php echo "$unitlokasi"; ?></label></td><td style="width:1%"></td>
			   <td style="width:24%"><label><?php echo "$atasan2"; ?></label></td><td style="width:1%"></td>
			   <td style="width:59%"><label>Email</label></td>
			  </tr>
			  <tr>
			  <td>
				<select id="unithsuperior" name="unithsuperior" class="form-control" onchange="cmdtampildata(this.value,'unit3','nik')" required>
					<option value="" > -- <?php echo "$pilihunit"; ?> -- </option>
				  <?php 
				  $cekunit = mysqli_query ($koneksi, "SELECT Kode_OU, Nama_OU FROM `daftarou` where aktif='T' ORDER BY Nama_OU asc");
				  while ($scekunit	= mysqli_fetch_array ($cekunit))
				  {
				  ?>
					<option value="<?php echo $scekunit['Kode_OU']; ?>"><?php echo "$scekunit[Nama_OU]"; ?></option>
				  <?php
				  }
				  ?>
				</select>
			  </td><td style="width:1%"></td>
			  <td>
				<select id="headsuperior" name="headsuperior" class="form-control" onchange="isi_emailatasan(this.value,'heademailsuperior')" required>
					<option value="" > -- <?php echo "$pilihatasan"; ?> -- </option>
				</select>
			  </td><td style="width:1%"></td>
			  <td>
				<input type="text" class="form-control" id ="headsuperioremail" name="headsuperioremail" style="width:50%" placeholder="Head Superior's Email" >
			  </td>
			  </tr></table>
			</div>
			
			<div class="form-group" id="bawahan" style="display:none;">
			  <table style="width:20%">
			  <tr>
			   <td><label><?php echo $anggota; ?></label></td>
			  </tr>
			  <tr>
			  <td>
				<select id="statbawah" name="statbawah" class="form-control">
					<option value=""> -- <?php echo $pilih; ?> -- </option>
					<option value="Y"> <?php echo $ya; ?> </option>
					<option value="N"> <?php echo $tidak; ?> </option>
				</select>
			  </td>
			  </tr></table>
			</div>
			
			<div class="form-group" id="member" style="display:none;">
			  <table style="width:20%">
			  <tr>
			   <td><label><?php echo $staffno; ?></label></td>
			  </tr>
			  <tr>
			  <td>
				<select id="statmember" name="statmember" class="form-control">
					<option value=""> -- <?php echo $pilih; ?> -- </option>
					<option value="Y"> Staff </option>
					<option value="N"> Non Staff </option>
				</select>
			  </td>
			  </tr></table>
			</div>
			
			<div class="box-footer">
		      <button type="submit" class="btn btn-success" onclick="cekvalid()" name="btnsave">Submit</button>
			</div>
			<!-- -->
        </div>
    </div>
  </div>
</section>
</div>

<script src="plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

<script type="text/javascript">
	// function isi_emailatasan(){
		// var superior = $("#superior").val();
		// alert(superior);
		// $.ajax({
			// url: 'cekdata.php',
			// data:"nikpa="+superior+"&asal=emailsuperior",
		// }).success(function (data) {
			// var json = data,
			// obj = JSON.parse(json);
			// $('#superioremail').val(obj.superioremail);
		// });
	// };
	// function isi_emailheadatasan(){
		// var headsuperior = $("#headsuperior").val();
		// $.ajax({
			// url: 'cekdata.php',
			// data:"nikpa="+headsuperior+"&asal=emailheadsuperior",
		// }).success(function (data) {
			// var json = data,
			// obj = JSON.parse(json);
			// $('#headsuperioremail').val(obj.headsuperioremail);
		// });
	// };
</script>