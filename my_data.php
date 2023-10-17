<?php
include("tabel_setting.php");
$koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Example query: Select all data from a table named 'your_table'
$query = "SELECT b.fortable, (SELECT COUNT(idkar) FROM atasan WHERE id_atasan1 = :id OR id_atasan2 = :id OR id_atasan3 = :id) as jumlah_subo 
FROM $karyawan AS a 
LEFT JOIN daftargolongan AS b ON b.Kode_Golongan=a.Kode_Golongan
WHERE a.id= :id";
$stmt = $koneksi->prepare($query);
$stmt->bindParam(':id', $scekuser['id'], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$queryPeers = "SELECT idkar FROM transaksi_2023_peers WHERE peers = '$scekuser[id]'";
$stmtPeer = $koneksi->prepare($queryPeers);
$stmtPeer->execute();
$resultPeers = $stmtPeer->fetchAll(PDO::FETCH_ASSOC);
$cekPeers =  count($resultPeers);
// echo $cekPeers;
// Fetch data as an associative array
$fortable = $result['fortable'] != "staff" ? $result['fortable'] : ($result['jumlah_subo'] > 0 ? "staffb" : "staff");

?>
<style type="text/css">
.proses {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('dist/img/ellipsis.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .9;
}
</style>
<div id="proses" class="proses" style="display: none"></div>
<div class="row">
<section class="col-lg-12 connectedSortable">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#AllDocument"><?php echo "$mydata1"; ?></a>
			</li>
			<?php if($fortable!='staff' && $result['jumlah_subo'] > 0){
			?>
				<li>
					<a data-toggle="tab" href="#ActivityLog " ><?php echo "$mydata2"; ?></a>
				</li>
				<li>
					<a data-toggle="tab" href="#ActivityLog2 " ><?php echo "$mydata3"; ?></a>
				</li>
				<li>
					<a data-toggle="tab" href="#ActivityLog3 " ><?php echo "$mydata4"; ?></a>
				</li>
			<?php
			} ?>
			<li>
				<a data-toggle="tab" href="#ActivityLogSuperior " ><?php echo "$mydata5"; ?></a>
			</li>
			<?php if($cekPeers>0){
			?>
			<li>
				<a data-toggle="tab" href="#ActivityLogPeers " ><?php echo "$mydata6"; ?></a>
			</li>
			<?php
			} ?>
		</ul>
		<div class="tab-content">
			<div id="AllDocument" class="tab-pane active">
				<table id="tablePenilaian" class="table table-bordered table-striped table-condensed cf">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Position</th>
							<th>Grade</th>
							<th>Unit</th>
							<th>Department</th>
							<th>Input Date</th>
							<th style="background-color: yellow;">Final Total Score</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
			</div>
			<div id="ActivityLog" class="tab-pane">
				<table id="tablePenilaianA1" class="table table-bordered table-striped table-condensed cf">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Position</th>
							<th>Grade</th>
							<th>Unit</th>
							<th>Department</th>
							<th>Input Date</th>
							<th style="background-color: yellow;">Final Total Score</th>
							<th>Review</th>
						</tr>
					</thead>
				</table>
			</div>
			<div id="ActivityLog2" class="tab-pane">
				<table id="tablePenilaianA2" class="table table-bordered table-striped table-condensed cf">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Position</th>
							<th>Grade</th>
							<th>Unit</th>
							<th>Department</th>
							<th>Input Date</th>
							<th style="background-color: yellow;">Final Total Score</th>
							<th>Review</th>
						</tr>
					</thead>
				</table>
			</div>
			<div id="ActivityLog3" class="tab-pane">
				<table id="tablePenilaianA3" class="table table-bordered table-striped table-condensed cf">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Position</th>
							<th>Grade</th>
							<th>Unit</th>
							<th>Department</th>
							<th>Input Date</th>
							<th style="background-color: yellow;">Final Total Score</th>
							<th>Review</th>
						</tr>
					</thead>
				</table>
			</div>
			<div id="ActivityLogSuperior" class="tab-pane">
				<table id="tablePenilaianSuperior" class="table table-bordered table-striped table-condensed cf">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Position</th>
							<th>Grade</th>
							<th>Unit</th>
							<th>Department</th>
							<th>Input Date</th>
							<th style="background-color: yellow;">Final Total Score</th>
							<th>Review</th>
						</tr>
					</thead>
				</table>
			</div>
			<div id="ActivityLogPeers" class="tab-pane">
				<table id="tablePenilaianPeers" class="table table-bordered table-striped table-condensed cf">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Position</th>
							<th>Grade</th>
							<th>Unit</th>
							<th>Department</th>
							<th>Input Date</th>
							<th>Review</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</section>
</div>

<script>
$(document).ready(function () {
	$("#tablePenilaian").DataTable({
        
		"bPaginate": true,
		"bInfo": true,
		"autoWidth": false, 
		"processing": true,
		"language": {
		"loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
							<i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
						</span>",
		},
		"ajax": "apiController.php?code=getPenilaian",
		"type": "GET", // Use POST method
	
		
		  // membuat kolom
		  "columns": [
  
			  //untuk membuat data index / numbering
			  { "data": 'no', "name":'id', render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}},
  
			  { "data": 'Nama_Lengkap' },
			  { "data": 'Nama_Jabatan' },
			  { "data": 'Nama_Golongan' },
			  { "data": 'Nama_OU' },
			  { "data": 'Nama_Departemen' },
			  { "data": 'created_date' },
			  { "data": 'total_score' },
			  { 
                data: null,
                render:function(data, type, row)
                {
                 
					form = data.idkar == data.created_by ? "formpa_review" : "formpa_edit";
					if(data.rating_a1!=0 && data.rating_a2==null){
						return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed by ' + data.nama_a1 + '\')" class="btn btn-sm btn-default">Reviewed by L1</a>';
					}
					if(data.rating_a2!=null && data.rating_a3==null){
						return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed by ' + data.nama_a2 + '\')" class="btn btn-sm btn-default">Reviewed by L2</a>';
					}
					if(data.rating_a3!=null){
						return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed by ' + data.nama_a3 + '\')" class="btn btn-sm btn-default">Reviewed by L3</a>';
					}
						return '<a id="edit" href="home.php?link='+form+'&id='+data.idkar+'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
                     
                }
			 },
		  ]
	})
	$("#tablePenilaianA1").DataTable({
        
		"bPaginate": true,
		"bInfo": true,
		"autoWidth": false, 
		"processing": true,
		"language": {
		"loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
							<i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
						</span>",
		},
		"ajax": "apiController.php?code=getPenilaianA1",
		"type": "GET", // Use POST method
	
		
		  // membuat kolom
		  "columns": [
  
			  //untuk membuat data index / numbering
			  { "data": 'no', "name":'id', render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}},
  
			  { "data": 'Nama_Lengkap' },
			  { "data": 'Nama_Jabatan' },
			  { "data": 'Nama_Golongan' },
			  { "data": 'Nama_OU' },
			  { "data": 'Nama_Departemen' },
			  { "data": 'created_date' },
			  { "data": 'total_score' },
			  { 
                data: null,
                render:function(data, type, row)
                {
                 
					form = data.idkar == data.created_by ? "formpa_review" : "formpa_edit";
					if(data.rating_a1!=0 && data.rating_a2==null){
						return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed by ' + data.nama_a1 + '\')" class="btn btn-sm btn-default">Reviewed by L1</a>';
					}
					if(data.rating_a2!=null && data.rating_a3==null){
						return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed by ' + data.nama_a2 + '\')" class="btn btn-sm btn-default">Reviewed by L2</a>';
					}
					if(data.rating_a3!=null){
						return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed by ' + data.nama_a3 + '\')" class="btn btn-sm btn-default">Reviewed by L3</a>';
					}else{
						return '<a id="edit" href="home.php?link='+form+'&id='+data.idkar+'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
					}
                     
                }
			 },
		  ]
	})
	$("#tablePenilaianA2").DataTable({
        
		"bPaginate": true,
		"bInfo": true,
		"autoWidth": false, 
		"processing": true,
		"language": {
		"loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
							<i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
						</span>",
		},
		"ajax": "apiController.php?code=getPenilaianA2",
		"type": "GET", // Use POST method
	
		
		  // membuat kolom
		  "columns": [
  
			  //untuk membuat data index / numbering
			  { "data": 'no', "name":'id', render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}},
  
			  { "data": 'Nama_Lengkap' },
			  { "data": 'Nama_Jabatan' },
			  { "data": 'Nama_Golongan' },
			  { "data": 'Nama_OU' },
			  { "data": 'Nama_Departemen' },
			  { "data": 'created_date' },
			  { "data": 'total_score' },
			  { 
                data: null,
                render:function(data, type, row)
                {
					
					if(data.rating_a3!=null){
						return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed by ' + data.nama_a3 + '\')" class="btn btn-sm btn-default">Reviewed</a>';
					}
					return '<a id="edit" href="home.php?link=formpa_review2&id='+data.idkar+'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
                     
                }
			 },
		  ]
	})
	$("#tablePenilaianA3").DataTable({
        
		"bPaginate": true,
		"bInfo": true,
		"autoWidth": false, 
		"processing": true,
		"language": {
		"loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
							<i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
						</span>",
		},
		"ajax": "apiController.php?code=getPenilaianA3",
		"type": "GET", // Use POST method
	
		
		  // membuat kolom
		  "columns": [
  
			  //untuk membuat data index / numbering
			  { "data": 'no', "name":'id', render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}},
  
			  { "data": 'Nama_Lengkap' },
			  { "data": 'Nama_Jabatan' },
			  { "data": 'Nama_Golongan' },
			  { "data": 'Nama_OU' },
			  { "data": 'Nama_Departemen' },
			  { "data": 'created_date' },
			  { "data": 'total_score' },
			  { 
                data: null,
                render:function(data, type, row)
                {
                 
					return '<a id="edit" href="home.php?link=formpa_review3&id='+data.idkar+'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
                     
                }
			 },
		  ]
	})
	$("#tablePenilaianSuperior").DataTable({
        
		"bPaginate": true,
		"bInfo": true,
		"autoWidth": false, 
		"processing": true,
		"language": {
		"loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
							<i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
						</span>",
		},
		"ajax": "apiController.php?code=getPenilaianSuperior",
		"type": "GET", // Use POST method
	
		
		  // membuat kolom
		  "columns": [
  
			  //untuk membuat data index / numbering
			  { "data": 'no', "name":'id', render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}},
  
			  { "data": 'Nama_Lengkap' },
			  { "data": 'Nama_Jabatan' },
			  { "data": 'Nama_Golongan' },
			  { "data": 'Nama_OU' },
			  { "data": 'Nama_Departemen' },
			  { "data": 'created_date' },
			  { "data": 'total_score' },
			  { 
                data: null,
                render:function(data, type, row)
                {
                 
					if(data.created_by){
						return '<a id="edit" onclick="alert(\'You have been reviewed this Appraisal, Thank you for your contributions\')" class="btn btn-sm btn-default">Reviewed</a>';
					}
					return '<a id="edit" href="home.php?link=formpa_review_superior&id='+data.idkar+'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
                     
                }
			 },
		  ]
	})
	$("#tablePenilaianPeers").DataTable({
        
		"bPaginate": true,
		"bInfo": true,
		"autoWidth": false, 
		"processing": true,
		"language": {
		"loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
							<i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
						</span>",
		},
		"ajax": "apiController.php?code=getPenilaianPeers",
		"type": "GET", // Use POST method
	
		
		  // membuat kolom
		  "columns": [
  
			  //untuk membuat data index / numbering
			  { "data": 'no', "name":'id', render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}},
  
			  { "data": 'Nama_Lengkap' },
			  { "data": 'Nama_Jabatan' },
			  { "data": 'Nama_Golongan' },
			  { "data": 'Nama_OU' },
			  { "data": 'Nama_Departemen' },
			  { "data": 'created_date' },
			  { 
                data: null,
                render:function(data, type, row)
                {
                 
					if(data.total_culture&&data.total_leadership){
						return '<a id="edit" onclick="alert(\'You have been reviewed this Appraisal, Thank you for your contributions\')" class="btn btn-sm btn-default">Reviewed</a>';
					}
					return '<a id="edit" href="home.php?link=formpa_review_peers&id='+data.idkar+'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
                     
                }
			 },
		  ]
	})
})
</script>