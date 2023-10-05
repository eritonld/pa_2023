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
			// alert(xmlhttp.responseText);
			// document.getElementById('fortable').value=xmlhttp.responseText;
			document.getElementById('detail_superior').innerHTML=xmlhttp.responseText;
			
			// if(xmlhttp.responseText == 'staff'){
				// document.getElementById('bawahan').style.display = "";
			// }else if(xmlhttp.responseText == 'Member'){
				// document.getElementById('member').style.display = "";
			// }else{
				// document.getElementById('bawahan').style.display = "none";
				// document.getElementById('member').style.display = "none";
			// }
			
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
	alert("cek cek");
	
	if(document.getElementById('fortable').value=='')
	{
		alert('fortable');
		return false
	}
	else if(document.getElementById('email_atasan1').value=='')
	{
		alert('Email Atasan 1 Kosong');
		return false
	}
	else if (document.getElementById('email_atasan2').value=='')
	{
		alert("Email Atasan 2 Kosong");
		return false
	}
	else if(document.getElementById('email_atasan3').value=='')
	{
		alert('Email Atasan 3 Kosong');
		return false
	}	
	else
	{	
		var nik 					= document.getElementById('nik').value;		
		var fortable 				= document.getElementById('fortable').value;
		var email_atasan1 			= document.getElementById('email_atasan1').value;
		var id_atasan1 				= document.getElementById('id_atasan1').value;
		var email_atasan2 			= document.getElementById('email_atasan2').value;
		var id_atasan2 				= document.getElementById('id_atasan2').value;
		var email_atasan3 			= document.getElementById('email_atasan3').value;
		var id_atasan3 				= document.getElementById('id_atasan3').value;
		
		xmlhttp.open("GET", "cekvalid.php?nik="+nik+"&id_atasan1="+id_atasan1+"&id_atasan2="+id_atasan2+"&id_atasan3="+id_atasan3+"&email_atasan1="+email_atasan1+"&email_atasan2="+email_atasan2+"&email_atasan3="+email_atasan3, true);
		
		xmlhttp.onreadystatechange = function() 
		{
			if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
			{
				// alert(xmlhttp.responseText);
				var cekvalid			= xmlhttp.responseText.split('|');
				var lanjut	 			= cekvalid[0];
				var varnik				= cekvalid[1];

				var namainput			= cekvalid[8];
				
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
					if(fortable=='nonstaff'){
						alert("nonstaff");
						window.location="home.php?link=formpa&nik="+varnik+"&id_atasan1="+id_atasan1+"&email_atasan1="+email_atasan1+"&email_atasan2="+email_atasan2+"&email_atasan3="+email_atasan3;
					}
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
			<!-- <input type="text" name="fortable" id="fortable" /> -->
			<div class="form-group">
			
			  <table>
			  <tr>
				<td style="width:20%"><label><?php echo "$karyawandinilai"; ?></label></td>
				<td style="width:1%"></td>
				<td style="width:24%"><label><?php echo " "; ?></label></td>
				<td style="width:55%"></td>
			</tr>
			  <tr>
			  <td>
				<select id="nik" name="nik" class="form-control" onchange="statusbawahan(this.value)" required>
					<option value="" > -- <?php echo "$pilihnama"; ?> -- </option>
					<?php 
					$cekkar = mysqli_query ($koneksi, "SELECT ats.idkar, k.nik_baru, k.Nama_Lengkap FROM `atasan` as ats 
					left join karyawan_2023 as k on k.id=ats.idkar
					where ats.idkar='$idmaster_pa' or ats.id_atasan1='$idmaster_pa' ORDER BY k.Nama_Lengkap asc;");
					  while ($scekkar	= mysqli_fetch_array ($cekkar))
					  {
					  ?>
						<option value="<?php echo $scekkar['idkar']; ?>"><?php echo "$scekkar[Nama_Lengkap] ($scekkar[nik_baru])"; ?></option>
					  <?php
					  }
					  ?>
				</select>
				</td>
				<td></td>
			    <td>
				</td>
			    <td></td>
			  </tr>
			  </table>
			</div>
			<div class="form-group" id="detail_superior" name="detail_superior">
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