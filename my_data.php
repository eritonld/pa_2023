<?php
if (isset($_COOKIE['id'])) {
	$idmaster_pa = $_COOKIE['id'];
	$pic = $_COOKIE['pic'];
	// Use $id and $pic to maintain the session or personalize content
  } else {
	?>
	  <script>
		  alert('Your session has ended, please Signin');
		  window.location= '<?= "$base_url"; ?>'; -->
	  </script>
	  <?php
  }
include("tabel_setting.php");
$koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Example query: Select all data from a table named 'your_table'
$query = "SELECT b.fortable, (SELECT COUNT(idkar) FROM atasan WHERE id_atasan = :id) as jumlah_subo 
FROM $karyawan AS a 
LEFT JOIN daftargolongan AS b ON b.Kode_Golongan=a.Kode_Golongan
WHERE a.id= :id";
$stmt = $koneksi->prepare($query);
$stmt->bindParam(':id', $scekuser['id'], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);


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
<div id="loader" class="proses" style="display: none"></div>

<input id="idpic" type="hidden" value="<?= $scekuser['id']; ?>">
<div class="row">
<section class="col-lg-12 connectedSortable">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#AllDocument"><?php echo "$mydata1"; ?></a>
			</li>
			<?php if($fortable!='staff' && $result['jumlah_subo'] > 0){
			?>
				<!-- <li>
					<a data-toggle="tab" href="#ActivityLog " ><?php echo "$mydata2"; ?></a>
				</li>
				<li>
					<a data-toggle="tab" href="#ActivityLog2 " ><?php echo "$mydata3"; ?></a>
				</li>
				<li>
					<a data-toggle="tab" href="#ActivityLog3 " ><?php echo "$mydata4"; ?></a>
				</li> -->
			<?php
			} ?>
			<li>
				<a data-toggle="tab" href="#ActivityLogSuperior " ><?php echo "$mydata5"; ?></a>
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
							<th style="background-color: yellow;">Total Score</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
			</div>
			<!-- <div id="ActivityLog" class="tab-pane">
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
							<th style="background-color: yellow;">Total Score</th>
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
							<th style="background-color: yellow;">Total Score</th>
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
							<th style="background-color: yellow;">Total Score</th>
							<th>Review</th>
						</tr>
					</thead>
				</table>
			</div> -->
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
							<th>Status</th>
							<th style="background-color: yellow;">Total Score</th>
							<th>Action</th>
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
	let idpic = $('#idpic').val();

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
			  { 
                data: null,
                render:function(data, type, row)
                {
					let score = data.created_by==idpic ? data.avg_score : data.avg_score;

					return score;

                }
			  },
			  { 
                data: null,
                render:function(data, type, row)
                {

					
					let style;

					if (data.id && data.created_by==idpic && data.approval_review=='Pending' || data.id && data.created_by==idpic && data.approver_review_id==idpic) {
						style = ["formpa_edit", "primary", "Edit"];
					} else if (data.created_by && data.approver_review_id==idpic && !data.rating && data.approval_review=='Pending') {
						style = ["formpa_review", "primary", "Review"];
					} else if (data.nextApprover==idpic && !data.rating && data.approval_review=='Approved') {
						style = ["formpa_review", "warning", "Revise", "text-black"];
					} else if(!data.id && data.idkar==idpic && !data.created_by || !data.id && data.id_L1==idpic && data.Kode_Golongan<'GL013'){
						style = ["formpa", "success", "Create PA"];
					} else if(!data.id && data.id_L1==idpic && data.Kode_Golongan>'GL012'){
						return '<a class="btn btn-sm btn-default">Pending</a>';
					} else {
						return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed\')" class="btn btn-sm btn-default">Reviewed</a>';
					}
					

					// if(data.id && data.approval_status=='Approved' && data.updated_by!=idpic && data.updated_by!=null){
					// 	return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed\')" class="btn btn-sm btn-default">Reviewed</a>';
					// }
						return '<a id="edit" href="home.php?link='+style[0]+'&id='+data.idkar+'" class="btn btn-sm btn-'+style[1]+' '+style[3]+'"><b>'+style[2]+'</b></a>';
                     
                }
			 },
		  ]
	})
	// <!-- atasan & peers -->
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
			  { "data": 'layer' },
			  { "data": 'avg_score' },
			  { 
                data: null,
                render:function(data, type, row)
                {
                 
					let style;
					if (data.created_by && data.approver_id==idpic && data.approval_status=='Pending' && data.updated_by==idpic) {
						style = ["formpa_review_peers", "warning", "Revise"];
						return '<a onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed\')" id="edit" class="btn btn-sm btn-default">Reviewed</a>';
					} else if (data.created_by && data.approver_id==idpic && data.approval_status=='Pending') {
						style = ["formpa_review_peers", "primary", "Review"];
					}else {
						return '<a class="btn btn-sm btn-default">Pending</a>';
					}
					
					if(data.id && data.status_sr=='F'){
						return '<a id="edit" onclick="alert(\'' + data.Nama_Lengkap + ' has been reviewed\')" class="btn btn-sm btn-default">Reviewed</a>';
					}
						return '<a href="home.php?link='+style[0]+'&id='+data.idkar+'&layer='+data.layer+'" class="btn btn-sm btn-'+style[1]+'"><b>'+style[2]+'</b></a>';
                     
                }
			 },
		  ]
	})
	
	
})
</script>