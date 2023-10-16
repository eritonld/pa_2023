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
		</ul>
		<div class="tab-content">
			<div id="AllDocument" class="tab-pane active">
				<table id="table_list" class="table table-bordered table-striped table-condensed cf">
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
			</div>
			<div id="ActivityLog2" class="tab-pane">
			</div>
		</div>
	</div>
</section>
</div>

<script>
	$(document).ready(function () {
	$("#table_list").DataTable({
        
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
                 
					btnClass = 'primary';
					btnTitle = 'Done';
					return '<a id="edit" href="home.php?link=formpa_edit&id='+data.id+'" class="btn btn-sm btn-'+btnClass+'"><i class="fa fa-edit"></i></a>';
                     
                }
			 },
		  ]
	  })
	})
</script>