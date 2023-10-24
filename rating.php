<?php
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

$queryPeers = "SELECT idkar FROM transaksi_2023_peers WHERE peers = '$scekuser[id]'";
$stmtPeer = $koneksi->prepare($queryPeers);
$stmtPeer->execute();
$resultPeers = $stmtPeer->fetchAll(PDO::FETCH_ASSOC);
$cekPeers =  count($resultPeers);
// echo $cekPeers;
// Fetch data as an associative array
$fortable = $result['fortable'] != "staff" ? $result['fortable'] : ($result['jumlah_subo'] > 0 ? "staffb" : "staff");

try {
    $sql = "SELECT
    SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END) AS A,
    SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END) AS B,
    SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END) AS C,
    SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END) AS D,
    SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END) AS E,
    SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END) AS Total,
    (SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_A,
    (SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_B,
    (SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_C,
    (SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_D,
    (SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_E,
    (SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Total_Percent
  FROM (
    SELECT
      CASE
        WHEN b.rating = 5 THEN 'A'
        WHEN b.rating = 4 THEN 'B'
        WHEN b.rating = 3 THEN 'C'
        WHEN b.rating = 2 THEN 'D'
        WHEN b.rating = 1 THEN 'E'
        ELSE 'no rating'
      END AS convertRating
    FROM transaksi_2023_final AS b
    LEFT JOIN atasan AS a1 ON a1.idkar = b.idkar AND a1.layer = 'L1'
    LEFT JOIN atasan AS a2 ON a2.idkar = b.idkar AND a2.layer = 'L2'
    LEFT JOIN atasan AS a3 ON a3.idkar = b.idkar AND a3.layer = 'L3'
    WHERE (a1.id_atasan = '$idmaster_pa' OR a2.id_atasan = '$idmaster_pa' OR a3.id_atasan = '$idmaster_pa')
  ) AS subquery";

    $result = $koneksi->query($sql);

    $rating = $result->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo json_encode(array("error" => $e->getMessage()));
}

try {
   
    $query23 = "SELECT
    COALESCE(SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END), 0) AS A,
    COALESCE(SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END), 0) AS B,
    COALESCE(SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END), 0) AS C,
    COALESCE(SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END), 0) AS D,
    COALESCE(SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END), 0) AS E
    FROM (
        SELECT
            CASE
                WHEN b.rating = 5 THEN 'A'
                WHEN b.rating = 4 THEN 'B'
                WHEN b.rating = 3 THEN 'C'
                WHEN b.rating = 2 THEN 'D'
                WHEN b.rating = 1 THEN 'E'
                ELSE 'no rating'
            END AS convertRating
        FROM transaksi_2023_final AS b
        LEFT JOIN karyawan_2023 AS k ON k.id = b.idkar
        LEFT JOIN atasan AS a1 ON a1.idkar = b.idkar AND a1.layer = 'L1'
        LEFT JOIN atasan AS a2 ON a2.idkar = b.idkar AND a2.layer = 'L2'
        LEFT JOIN atasan AS a3 ON a3.idkar = b.idkar AND a3.layer = 'L3'
        WHERE (a1.id_atasan = '$idmaster_pa' OR a2.id_atasan = '$idmaster_pa' OR a3.id_atasan = '$idmaster_pa')
            AND k.Kode_Golongan IN ('GL004','GL005','GL006','GL007','GL008','GL009')  -- condition
    ) AS subquery";
    $query45 = "SELECT
    COALESCE(SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END), 0) AS A,
    COALESCE(SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END), 0) AS B,
    COALESCE(SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END), 0) AS C,
    COALESCE(SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END), 0) AS D,
    COALESCE(SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END), 0) AS E
    FROM (
        SELECT
            CASE
                WHEN b.rating = 5 THEN 'A'
                WHEN b.rating = 4 THEN 'B'
                WHEN b.rating = 3 THEN 'C'
                WHEN b.rating = 2 THEN 'D'
                WHEN b.rating = 1 THEN 'E'
                ELSE 'no rating'
            END AS convertRating
        FROM transaksi_2023_final AS b
        LEFT JOIN karyawan_2023 AS k ON k.id = b.idkar
        LEFT JOIN atasan AS a1 ON a1.idkar = b.idkar AND a1.layer = 'L1'
        LEFT JOIN atasan AS a2 ON a2.idkar = b.idkar AND a2.layer = 'L2'
        LEFT JOIN atasan AS a3 ON a3.idkar = b.idkar AND a3.layer = 'L3'
        WHERE (a1.id_atasan = '$idmaster_pa' OR a2.id_atasan = '$idmaster_pa' OR a3.id_atasan = '$idmaster_pa')
            AND k.Kode_Golongan IN ('GL013','GL014','GL016','GL017')  -- condition
    ) AS subquery";
    $query67 = "SELECT
    COALESCE(SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END), 0) AS A,
    COALESCE(SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END), 0) AS B,
    COALESCE(SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END), 0) AS C,
    COALESCE(SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END), 0) AS D,
    COALESCE(SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END), 0) AS E
    FROM (
        SELECT
            CASE
                WHEN b.rating = 5 THEN 'A'
                WHEN b.rating = 4 THEN 'B'
                WHEN b.rating = 3 THEN 'C'
                WHEN b.rating = 2 THEN 'D'
                WHEN b.rating = 1 THEN 'E'
                ELSE 'no rating'
            END AS convertRating
        FROM transaksi_2023_final AS b
        LEFT JOIN karyawan_2023 AS k ON k.id = b.idkar
        LEFT JOIN atasan AS a1 ON a1.idkar = b.idkar AND a1.layer = 'L1'
        LEFT JOIN atasan AS a2 ON a2.idkar = b.idkar AND a2.layer = 'L2'
        LEFT JOIN atasan AS a3 ON a3.idkar = b.idkar AND a3.layer = 'L3'
        WHERE (a1.id_atasan = '$idmaster_pa' OR a2.id_atasan = '$idmaster_pa' OR a3.id_atasan = '$idmaster_pa')
            AND k.Kode_Golongan IN ('GL020','GL021','GL024','GL025')  -- condition
    ) AS subquery";
    $query89 = "SELECT
    COALESCE(SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END), 0) AS A,
    COALESCE(SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END), 0) AS B,
    COALESCE(SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END), 0) AS C,
    COALESCE(SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END), 0) AS D,
    COALESCE(SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END), 0) AS E
    FROM (
        SELECT
            CASE
                WHEN b.rating = 5 THEN 'A'
                WHEN b.rating = 4 THEN 'B'
                WHEN b.rating = 3 THEN 'C'
                WHEN b.rating = 2 THEN 'D'
                WHEN b.rating = 1 THEN 'E'
                ELSE 'no rating'
            END AS convertRating
        FROM transaksi_2023_final AS b
        LEFT JOIN karyawan_2023 AS k ON k.id = b.idkar
        LEFT JOIN atasan AS a1 ON a1.idkar = b.idkar AND a1.layer = 'L1'
        LEFT JOIN atasan AS a2 ON a2.idkar = b.idkar AND a2.layer = 'L2'
        LEFT JOIN atasan AS a3 ON a3.idkar = b.idkar AND a3.layer = 'L3'
        WHERE (a1.id_atasan = '$idmaster_pa' OR a2.id_atasan = '$idmaster_pa' OR a3.id_atasan = '$idmaster_pa')
            AND k.Kode_Golongan IN ('GL028','GL029','GL031','GL032')  -- condition
    ) AS subquery";

    $result23 = $koneksi->query($query23);
    $rating23 = $result23->fetch(PDO::FETCH_ASSOC);

    $result45 = $koneksi->query($query45);
    $rating45 = $result45->fetch(PDO::FETCH_ASSOC);

    $result67 = $koneksi->query($query67);
    $rating67 = $result67->fetch(PDO::FETCH_ASSOC);

    $result89 = $koneksi->query($query89);
    $rating89 = $result89->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo json_encode(array("error" => $e->getMessage()));
}

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
    <div class="col-md-8">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th rowspan="2" class="info" style="vertical-align: middle;">KPI</th>
                            <th colspan="2" class="success">Suggested Ratings</th>
                            <th colspan="2" class="warning">Your Ratings</th>
                            <th colspan="4" class="warning">Job Grade</th>
                            
                        </tr>
                        <tr>
                            <th class="success">Employee</th>
                            <th class="success">%</th>
                            <th class="warning">Employee</th>
                            <th class="warning">%</th>
                            <th style="vertical-align: middle;" class="warning">2-3</th>
                            <th style="vertical-align: middle;" class="warning">4-5</th>
                            <th style="vertical-align: middle;" class="warning">6-7</th>
                            <th style="vertical-align: middle;" class="warning">8-9</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A</td>
                            <td><span><?= $rating['A']; ?></span></td>
                            <td><span><?= number_format($rating['Percent_A'], 1); ?>%</span></td>
                            <td><span id="rate_a"><?= $rating['A']; ?></span></td>
                            <td><span id="percent_a"><?= number_format($rating['Percent_A'], 1); ?>%</span></td>
                            <td><span id="23_a"><?= $rating23['A']; ?></span></td>
                            <td><span id="45_a"><?= $rating45['A']; ?></span></td>
                            <td><span id="67_a"><?= $rating67['A']; ?></span></td>
                            <td><span id="89_a"><?= $rating89['A']; ?></span></td>
                        </tr>
                        <tr>
                            <td>B</td>
                            <td><span><?= $rating['B']; ?></span></td>
                            <td><span><?= number_format($rating['Percent_B'], 1); ?>%</span></td>
                            <td><span id="rate_b"><?= $rating['B']; ?></span></td>
                            <td><span id="percent_b"><?= number_format($rating['Percent_B'], 1); ?>%</span></td>
                            <td><span id="23_b"><?= $rating23['B']; ?></span></td>
                            <td><span id="45_b"><?= $rating45['B']; ?></span></td>
                            <td><span id="67_b"><?= $rating67['B']; ?></span></td>
                            <td><span id="89_b"><?= $rating89['B']; ?></span></td>
                        </tr>
                        <tr>
                            <td>C</td>
                            <td><span><?= $rating['C']; ?></span></td>
                            <td><span><?= number_format($rating['Percent_C'], 1); ?>%</span></td>
                            <td><span id="rate_c"><?= $rating['C']; ?></span></td>
                            <td><span id="percent_c"><?= number_format($rating['Percent_C'], 1); ?>%</span></td>
                            <td><span id="23_c"><?= $rating23['C']; ?></span></td>
                            <td><span id="45_c"><?= $rating45['C']; ?></span></td>
                            <td><span id="67_c"><?= $rating67['C']; ?></span></td>
                            <td><span id="89_c"><?= $rating89['C']; ?></span></td>
                        </tr>
                        <tr>
                            <td>D</td>
                            <td><span><?= $rating['D']; ?></span></td>
                            <td><span><?= number_format($rating['Percent_D'], 1); ?>%</span></td>
                            <td><span id="rate_d"><?= $rating['D']; ?></span></td>
                            <td><span id="percent_d"><?= number_format($rating['Percent_D'], 1); ?>%</span></td>
                            <td><span id="23_d"><?= $rating23['D']; ?></span></td>
                            <td><span id="45_d"><?= $rating45['D']; ?></span></td>
                            <td><span id="67_d"><?= $rating67['D']; ?></span></td>
                            <td><span id="89_d"><?= $rating89['D']; ?></span></td>
                        </tr>
                        <tr>
                            <td>E</td>
                            <td><span><?= $rating['E']; ?></span></td>
                            <td><span><?= number_format($rating['Percent_E'], 1); ?>%</span></td>
                            <td><span id="rate_e"><?= $rating['E']; ?></span></td>
                            <td><span id="percent_e"><?= number_format($rating['Percent_E'], 1); ?>%</span></td>
                            <td><span id="23_e"><?= $rating23['E']; ?></span></td>
                            <td><span id="45_e"><?= $rating45['E']; ?></span></td>
                            <td><span id="67_e"><?= $rating67['E']; ?></span></td>
                            <td><span id="89_e"><?= $rating89['E']; ?></span></td>
                        </tr>
                        <tr class="text-bold">
                            <td>Total</td>
                            <td><?= $rating['Total']; ?></td>
                            <td><?= number_format($rating['Total_Percent'], 1); ?>%</td>
                            <td><?= $rating['Total']; ?></td>
                            <td><?= number_format($rating['Total_Percent'], 1); ?>%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <button class="btn btn-success" id="submitRating">Submit Ratings</button>
    </div>
</div>
<div class="row">
<section class="col-lg-12 connectedSortable">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#TabRating1"><?php echo "$myrating1"; ?></a>
			</li>
            <li>
                <a data-toggle="tab" href="#TabRating2" ><?php echo "$myrating2"; ?></a>
            </li>
            <li>
                <a data-toggle="tab" href="#TabRating3" ><?php echo "$myrating3"; ?></a>
            </li>
            <li>
                <a data-toggle="tab" href="#TabRating4" ><?php echo "$myrating4"; ?></a>
            </li>
		</ul>
		<div class="tab-content">
			<div id="TabRating1" class="tab-pane active">
				<table id="tableRating1" class="table table-bordered table-striped table-condensed cf">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Position</th>
							<th>Grade</th>
							<th>Unit</th>
							<th>Division</th>
							<th>Suggested Ratings</th>
							<th style="background-color: yellow;">Your Ratings</th>
						</tr>
					</thead>
				</table>
			</div>
			<div id="TabRating2" class="tab-pane">
				<table id="tableRating2" class="table table-bordered table-striped table-condensed cf">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Position</th>
							<th>Grade</th>
							<th>Unit</th>
							<th>Division</th>
							<th>Suggested Ratings</th>
							<th style="background-color: yellow;">Your Ratings</th>
						</tr>
					</thead>
				</table>
			</div>
			<div id="TabRating3" class="tab-pane">
				<table id="tableRating3" class="table table-bordered table-striped table-condensed cf">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Position</th>
							<th>Grade</th>
							<th>Unit</th>
							<th>Division</th>
							<th>Suggested Ratings</th>
							<th style="background-color: yellow;">Your Ratings</th>
						</tr>
					</thead>
				</table>
			</div>
			<div id="TabRating4" class="tab-pane">
				<table id="tableRating4" class="table table-bordered table-striped table-condensed cf">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Position</th>
							<th>Grade</th>
							<th>Unit</th>
							<th>Division</th>
							<th>Suggested Ratings</th>
							<th style="background-color: yellow;">Your Ratings</th>
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
        let table1 = $("#tableRating1").DataTable({
            "bPaginate": true,
            "bInfo": true,
            "autoWidth": false,
            "processing": true,
            "language": {
                "loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
                                    <i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
                                </span>",
            },
            "ajax": "apiController.php?code=getRating1",
            "type": "GET",
            "columns": [
                { "data": 'no', "name": 'id', render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { "data": 'Nama_Lengkap' },
                { "data": 'Nama_Jabatan' },
                { "data": 'Nama_Golongan' },
                { "data": 'Nama_OU' },
                { "data": 'Nama_Departemen' },
                { "data": 'convertRating' },
                {
                    data: null,
                    render: function (data, type, row) {
                            var selectHtml = '<select style="width: 100%;" class="form-control" name="rating_value" id="rating_value" required>';
                            
                            var options = [
                                { value: '5', label: 'A' },
                                { value: '4', label: 'B' },
                                { value: '3', label: 'C' },
                                { value: '2', label: 'D' },
                                { value: '1', label: 'E' }
                            ];
                            
                            for (var i = 0; i < options.length; i++) {
                                var selectedAttribute = data.rating == options[i].value ? 'selected' : '';
                                selectHtml += '<option value="' + options[i].value + '" ' + selectedAttribute + '>' + options[i].label + '</option>';
                            }
                            
                            selectHtml += '</select>';
                            
                            return selectHtml;
                    }

                },
            ]
        });

        let table2 = $("#tableRating2").DataTable({
            "bPaginate": true,
            "bInfo": true,
            "autoWidth": false,
            "processing": true,
            "language": {
                "loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
                                    <i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
                                </span>",
            },
            "ajax": "apiController.php?code=getRating2",
            "type": "GET",
            "columns": [
                { "data": 'no', "name": 'id', render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { "data": 'Nama_Lengkap' },
                { "data": 'Nama_Jabatan' },
                { "data": 'Nama_Golongan' },
                { "data": 'Nama_OU' },
                { "data": 'Nama_Departemen' },
                { "data": 'convertRating' },
                {
                    data: null,
                    render: function (data, type, row) {
                            var selectHtml = '<select style="width: 100%;" class="form-control" name="rating_value" id="rating_value" required>';
                            
                            var options = [
                                { value: '5', label: 'A' },
                                { value: '4', label: 'B' },
                                { value: '3', label: 'C' },
                                { value: '2', label: 'D' },
                                { value: '1', label: 'E' }
                            ];
                            
                            for (var i = 0; i < options.length; i++) {
                                var selectedAttribute = data.rating == options[i].value ? 'selected' : '';
                                selectHtml += '<option value="' + options[i].value + '" ' + selectedAttribute + '>' + options[i].label + '</option>';
                            }
                            
                            selectHtml += '</select>';
                            
                            return selectHtml;

                    }

                },
            ]
        });
        let table3 = $("#tableRating3").DataTable({
            "bPaginate": true,
            "bInfo": true,
            "autoWidth": false,
            "processing": true,
            "language": {
                "loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
                                    <i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
                                </span>",
            },
            "ajax": "apiController.php?code=getRating3",
            "type": "GET",
            "columns": [
                { "data": 'no', "name": 'id', render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { "data": 'Nama_Lengkap' },
                { "data": 'Nama_Jabatan' },
                { "data": 'Nama_Golongan' },
                { "data": 'Nama_OU' },
                { "data": 'Nama_Departemen' },
                { "data": 'convertRating' },
                {
                    data: null,
                    render: function (data, type, row) {
                            var selectHtml = '<select style="width: 100%;" class="form-control" name="rating_value" id="rating_value" required>';
                            
                            var options = [
                                { value: '5', label: 'A' },
                                { value: '4', label: 'B' },
                                { value: '3', label: 'C' },
                                { value: '2', label: 'D' },
                                { value: '1', label: 'E' }
                            ];
                            
                            for (var i = 0; i < options.length; i++) {
                                var selectedAttribute = data.rating == options[i].value ? 'selected' : '';
                                selectHtml += '<option value="' + options[i].value + '" ' + selectedAttribute + '>' + options[i].label + '</option>';
                            }
                            
                            selectHtml += '</select>';
                            
                            return selectHtml;
                    }

                },
            ]
        });
        let table4 = $("#tableRating4").DataTable({
            "bPaginate": true,
            "bInfo": true,
            "autoWidth": false,
            "processing": true,
            "language": {
                "loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
                                    <i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
                                </span>",
            },
            "ajax": "apiController.php?code=getRating4",
            "type": "GET",
            "columns": [
                { "data": 'no', "name": 'id', render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { "data": 'Nama_Lengkap' },
                { "data": 'Nama_Jabatan' },
                { "data": 'Nama_Golongan' },
                { "data": 'Nama_OU' },
                { "data": 'Nama_Departemen' },
                { "data": 'convertRating' },
                {
                    data: null,
                    render: function (data, type, row) {
                            var selectHtml = '<select style="width: 100%;" class="form-control" name="rating_value" id="rating_value" required>';
                            
                            var options = [
                                { value: '5', label: 'A' },
                                { value: '4', label: 'B' },
                                { value: '3', label: 'C' },
                                { value: '2', label: 'D' },
                                { value: '1', label: 'E' }
                            ];
                            
                            for (var i = 0; i < options.length; i++) {
                                var selectedAttribute = data.rating == options[i].value ? 'selected' : '';
                                selectHtml += '<option value="' + options[i].value + '" ' + selectedAttribute + '>' + options[i].label + '</option>';
                            }
                            
                            selectHtml += '</select>';
                            
                            return selectHtml;
                    }

                },
            ]
        });

        let tables = [table1, table2, table3, table4];
        let ratingCounts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 }; // Initialize counts for all possible ratings
        let resultCalibrate = { 1: { count: 0, percentage: 0 }, 2: { count: 0, percentage: 0 }, 3: { count: 0, percentage: 0 }, 4: { count: 0, percentage: 0 }, 5: { count: 0, percentage: 0 } };
        let ratingElementIds = ["percent_e", "percent_d", "percent_c", "percent_b", "percent_a"];

        for (let i = 0; i < tables.length; i++) {
            tables[i].on('change', 'select[name="rating_value"]', function() {
                ratingCounts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };

                tables.forEach(function(table) {
                    table.rows().every(function () {
                        let selectedValue = $(this.node()).find('select[name="rating_value"]').val();

                        // Increment the count for the selected rating value
                        if (selectedValue in ratingCounts) {
                            ratingCounts[selectedValue]++;
                        } else {
                            // Handle the selected value as needed
                        }
                    });
                });

                // Calculate the total count
                let totalCount = Object.values(ratingCounts).reduce((total, count) => total + count, 0);

                // Calculate the percentage for each rating value and update the corresponding elements
                for (let i = 1; i <= 5; i++) {
                    let ratingKey = i.toString();
                    let count = ratingCounts[ratingKey];
                    let percentage = (count / totalCount) * 100;
                    $("#" + ratingElementIds[i - 1]).text(percentage.toFixed(1) + "%");
                }

                // You can access the combined counts for each rating value in the ratingCounts object
                console.log("Combined Rating Counts:", ratingCounts);

                // Update the HTML of the <span> elements with counts
                $("#rate_a").text(ratingCounts['5']);
                $("#rate_b").text(ratingCounts['4']);
                $("#rate_c").text(ratingCounts['3']);
                $("#rate_d").text(ratingCounts['2']);
                $("#rate_e").text(ratingCounts['1']);
                // You can perform any further actions with the combined counts here.
            });
        }

        $('#submitRating').on('click', function() {
            resultCalibrate = { 1: { count: 0, percentage: 0 }, 2: { count: 0, percentage: 0 }, 3: { count: 0, percentage: 0 }, 4: { count: 0, percentage: 0 }, 5: { count: 0, percentage: 0 } }; // Reset the rating counts 

            tables.forEach(function(table) {
                table.rows().every(function () {
                                let selectedValue = $(this.node()).find('select[name="rating_value"]').val();

                    // Increment the count for the selected rating value
            if (selectedValue in resultCalibrate) {
                resultCalibrate[selectedValue].count++;
            }
        });
    });

    // Calculate the total count
    let totalCount = Object.values(resultCalibrate).reduce((total, rating) => total + rating.count, 0);

    // Calculate the percentage for each rating value and update the corresponding elements
    for (let i = 1; i <= 5; i++) {
        let ratingKey = i.toString();
        let count = resultCalibrate[ratingKey].count;
        let percentage = (count / totalCount) * 100;
        $("#" + ratingElementIds[i - 1]).text(percentage.toFixed(1) + "%");

        // Update the percentage in the resultCalibrate object
        resultCalibrate[ratingKey].percentage = percentage;
    }

    // You can access the combined rating counts and percentages in the resultCalibrate object
    console.log("Combined Rating Counts and Percentages:", resultCalibrate);
});

        table1.on('change', '#rating_value', function() {
            let selectedValues = [];

            let ratingCounts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
            // Iterate through each row in the DataTable
            table1.rows().every(function () {
                let rowData = this.data();
                let selectedValue = $(this.node()).find('select[name="rating_value"]').val();
                selectedValues.push({ id: rowData.id, rating: selectedValue });

                // Increment the count for the selected rating value
                if (selectedValue in ratingCounts) {
                    ratingCounts[selectedValue]++;
                } else {
                    // Handle the selected value as needed
                }
            });

            // Calculate the total count
            let totalCount = Object.values(ratingCounts).reduce((total, count) => total + count, 0);

            // Calculate the percentage for each rating value and update the corresponding elements

            // Now you have an array of objects with id and selected rating values
            console.log(selectedValues);

            // You can access the count for each rating value in the ratingCounts object
            console.log("Rating Counts:", ratingCounts);

            // Update the HTML of the <span> elements with counts
            $("#45_a").text(ratingCounts['5']);
            $("#45_b").text(ratingCounts['4']);
            $("#45_c").text(ratingCounts['3']);
            $("#45_d").text(ratingCounts['2']);
            $("#45_e").text(ratingCounts['1']);
            // You can perform any further actions with the selected values and counts here.
        });

        table2.on('change', '#rating_value', function() {
            let selectedValues = [];

            let ratingCounts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
            // Iterate through each row in the DataTable
            table2.rows().every(function () {
                let rowData = this.data();
                let selectedValue = $(this.node()).find('select[name="rating_value"]').val();
                selectedValues.push({ id: rowData.id, rating: selectedValue });

                // Increment the count for the selected rating value
                if (selectedValue in ratingCounts) {
                    ratingCounts[selectedValue]++;
                } else {
                    // Handle the selected value as needed
                }
            });

            // Calculate the total count
            let totalCount = Object.values(ratingCounts).reduce((total, count) => total + count, 0);

            // Calculate the percentage for each rating value and update the corresponding elements

            // Now you have an array of objects with id and selected rating values
            console.log(selectedValues);

            // You can access the count for each rating value in the ratingCounts object
            console.log("Rating Counts:", ratingCounts);

            // Update the HTML of the <span> elements with counts
            $("#45_a").text(ratingCounts['5']);
            $("#45_b").text(ratingCounts['4']);
            $("#45_c").text(ratingCounts['3']);
            $("#45_d").text(ratingCounts['2']);
            $("#45_e").text(ratingCounts['1']);
            // You can perform any further actions with the selected values and counts here.
        });

        table3.on('change', '#rating_value', function() {
            let selectedValues = [];

            let ratingCounts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
            // Iterate through each row in the DataTable
            table3.rows().every(function () {
                let rowData = this.data();
                let selectedValue = $(this.node()).find('select[name="rating_value"]').val();
                selectedValues.push({ id: rowData.id, rating: selectedValue });

                // Increment the count for the selected rating value
                if (selectedValue in ratingCounts) {
                    ratingCounts[selectedValue]++;
                } else {
                    // Handle the selected value as needed
                }
            });

            // Calculate the total count
            let totalCount = Object.values(ratingCounts).reduce((total, count) => total + count, 0);

            // Calculate the percentage for each rating value and update the corresponding elements

            // Now you have an array of objects with id and selected rating values
            console.log(selectedValues);

            // You can access the count for each rating value in the ratingCounts object
            console.log("Rating Counts:", ratingCounts);

            // Update the HTML of the <span> elements with counts
            $("#67_a").text(ratingCounts['5']);
            $("#67_b").text(ratingCounts['4']);
            $("#67_c").text(ratingCounts['3']);
            $("#67_d").text(ratingCounts['2']);
            $("#67_e").text(ratingCounts['1']);
            // You can perform any further actions with the selected values and counts here.
        });

        table4.on('change', '#rating_value', function() {
            let selectedValues = [];

            let ratingCounts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
            // Iterate through each row in the DataTable
            table4.rows().every(function () {
                let rowData = this.data();
                let selectedValue = $(this.node()).find('select[name="rating_value"]').val();
                selectedValues.push({ id: rowData.id, rating: selectedValue });

                // Increment the count for the selected rating value
                if (selectedValue in ratingCounts) {
                    ratingCounts[selectedValue]++;
                } else {
                    // Handle the selected value as needed
                }
            });

            // Calculate the total count
            let totalCount = Object.values(ratingCounts).reduce((total, count) => total + count, 0);

            // Calculate the percentage for each rating value and update the corresponding elements

            // Now you have an array of objects with id and selected rating values
            console.log(selectedValues);

            // You can access the count for each rating value in the ratingCounts object
            console.log("Rating Counts:", ratingCounts);

            // Update the HTML of the <span> elements with counts
            $("#89_a").text(ratingCounts['5']);
            $("#89_b").text(ratingCounts['4']);
            $("#89_c").text(ratingCounts['3']);
            $("#89_d").text(ratingCounts['2']);
            $("#89_e").text(ratingCounts['1']);
            // You can perform any further actions with the selected values and counts here.
        });

    })
</script>