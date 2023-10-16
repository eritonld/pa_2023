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

function statusbawahan(id) {
//alert(nik);
xmlhttp.open("get", "cekstatus.php?id="+id, true);

	xmlhttp.onreadystatechange = function()
	{
		if((xmlhttp.readyState==4)&&(xmlhttp.status==200))
		{
			document.getElementById('detail_superior').innerHTML=xmlhttp.responseText;
			
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
	// alert("cek cek");
	
	if(document.getElementById('fortable').value=='')
	{
		alert('fortable');
		return false
	}
	else
	{	
		let id = document.getElementById('id').value;
		let check_atasan1 = document.getElementById('check_atasan1');
		let check_atasan2 = document.getElementById('check_atasan2');
		let check_atasan3 = document.getElementById('check_atasan3');
		
		xmlhttp.open("GET", "cekvalid.php?id="+id, true);
		
		xmlhttp.onreadystatechange = function() 
		{
			if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
			{
				// alert(xmlhttp.responseText);
				let data = JSON.parse(xmlhttp.responseText);
				let valid	= data.cekvalid;
				let varid	= data.varid;
				let inputby	= data.inputby;

				if(valid == 0)
				{
					alert("invalid Employee !!");
				}
				else if(valid == 2)
				{
					alert("This employee PA already assessed by "+inputby);
				}
				else
				{	
					if (!check_atasan1.checked){
						alert("Please confirm employee L1");
						document.getElementById('nama_atasan1').focus();
						return;
					}
					if (!check_atasan2.checked){
						alert("Please confirm employee L2");
						document.getElementById('nama_atasan2').focus();
						return;
					}
					if (!check_atasan3.checked){
						alert("Please confirm employee L3");
						document.getElementById('nama_atasan3').focus();
						return;
					}
					window.location="home.php?link=formpa&id="+varid;
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
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label><?php echo "$karyawandinilai"; ?></label>
						<select id="id" name="id" class="form-control" onchange="statusbawahan(this.value)" required>
							<option value="" > -- <?php echo "$pilihnama"; ?> -- </option>
							<?php 
							try {
								$stmt = $koneksi->prepare("SELECT ats.idkar, k.nik_baru, k.Nama_Lengkap FROM atasan as ats 
								LEFT JOIN karyawan_2023 as k ON k.id = ats.idkar
								WHERE ats.idkar = :idmaster_pa OR ats.id_atasan1 = :idmaster_pa
								ORDER BY k.Nama_Lengkap ASC");
								$stmt->bindParam(':idmaster_pa', $idmaster_pa, PDO::PARAM_INT);
								$stmt->execute();
							
								while ($scekkar = $stmt->fetch(PDO::FETCH_ASSOC)) {
									echo '<option value="' . $scekkar['idkar'] . '">' . $scekkar['Nama_Lengkap'] . ' (' . $scekkar['nik_baru'] . ')</option>';
								}
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group" id="detail_superior" name="detail_superior"></div>
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