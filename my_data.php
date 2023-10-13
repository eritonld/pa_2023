<?php
include("tabel_setting.php");
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
			<li>
				<a data-toggle="tab" href="#ActivityLog " ><?php echo "$mydata2"; ?></a>
			</li>
			<li>
				<a data-toggle="tab" href="#ActivityLog2 " ><?php echo "$mydata3"; ?></a>
			</li>
			<li>
				<a data-toggle="tab" href="#ActivityLog3 " ><?php echo "$mydata4"; ?></a>
			</li>
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
							<th>Action</th>
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
							<th>Action</th>
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
							<th>Action</th>
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
                  	let btnClass;
                 
					btnTitle = 'Done';
					form = data.idkar == data.created_by ? "formpa_review" : "formpa_edit";
					if(data.idkar==<?= $scekuser['id']; ?>){
						return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed by ' + data.nama_a1 + '\')" class="btn btn-sm btn-default">Reviewed</a>';
					}
					if(data.rating_a2){
						return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed by ' + data.nama_a2 + '\')" class="btn btn-sm btn-default">Reviewed</a>';
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
                  	let btnClass;
                 
					btnTitle = 'Done';
					form = data.idkar == data.created_by ? "formpa_review" : "formpa_edit";
					if(data.rating_a2){
						return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed by ' + data.nama_a2 + '\')" class="btn btn-sm btn-default">Reviewed</a>';
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
                  	let btnClass;
                 
					btnClass = 'primary';
					btnTitle = 'Done';
					if(data.rating_a3){
						return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed by ' + data.nama_a3 + '\')" class="btn btn-sm btn-default">Reviewed</a>';
					}else{
						return '<a id="edit" href="home.php?link='+form+'&id='+data.idkar+'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
					}
					return '<a id="edit" href="home.php?link=formpa_review2&id='+data.idkar+'" class="btn btn-sm btn-'+btnClass+'"><i class="fa fa-edit"></i></a>';
                     
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
                  	let btnClass;
                 
					btnClass = 'primary';
					btnTitle = 'Done';
					return '<a id="edit" href="home.php?link=formpa_review3&id='+data.idkar+'" class="btn btn-sm btn-'+btnClass+'"><i class="fa fa-edit"></i></a>';
                     
                }
			 },
		  ]
	})
})
</script>