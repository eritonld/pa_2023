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
    WHERE (a1.id_atasan = '51321' OR a2.id_atasan = '51321' OR a3.id_atasan = '51321')
  ) AS subquery";

    $result = $koneksi->query($sql);

    $rating = $result->fetch(PDO::FETCH_ASSOC);

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
    <div class="col-md-5">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th rowspan="2" class="info" style="vertical-align: middle;">KPI</th>
                            <th colspan="2" class="warning">Actual</th>
                            <th colspan="2" class="success">Target</th>
                        </tr>
                        <tr>
                            <th class="warning">Employee</th>
                            <th class="warning">%</th>
                            <th class="success">Employee</th>
                            <th class="success">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A</td>
                            <td><span id="rate_a"><?= $rating['A']; ?></span></td>
                            <td><span id="percent_a"><?= number_format($rating['Percent_A'], 1); ?>%</span></td>
                            <td>1</td>
                            <td>5%</td>
                        </tr>
                        <tr>
                            <td>B</td>
                            <td><span id="rate_b"><?= $rating['B']; ?></span></td>
                            <td><span id="percent_b"><?= number_format($rating['Percent_B'], 1); ?>%</span></td>
                            <td>2</td>
                            <td>10%</td>
                        </tr>
                        <tr>
                            <td>C</td>
                            <td><span id="rate_c"><?= $rating['C']; ?></span></td>
                            <td><span id="percent_c"><?= number_format($rating['Percent_C'], 1); ?>%</span></td>
                            <td>4</td>
                            <td>15%</td>
                        </tr>
                        <tr>
                            <td>D</td>
                            <td><span id="rate_d"><?= $rating['D']; ?></span></td>
                            <td><span id="percent_d"><?= number_format($rating['Percent_D'], 1); ?>%</span></td>
                            <td>10</td>
                            <td>30%</td>
                        </tr>
                        <tr>
                            <td>E</td>
                            <td><span id="rate_e"><?= $rating['E']; ?></span></td>
                            <td><span id="percent_e"><?= number_format($rating['Percent_E'], 1); ?>%</span></td>
                            <td>15</td>
                            <td>40%</td>
                        </tr>
                        <tr class="text-bold">
                            <td>Total</td>
                            <td><?= $rating['Total']; ?></td>
                            <td><?= number_format($rating['Total_Percent'], 1); ?>%</td>
                            <td>30</td>
                            <td>100%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <button class="btn btn-success" id="submitRating">Submit Ratings</button>
    </div>
</div>
<div class="row">
<section class="col-lg-12 connectedSortable">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#AllDocument"><?php echo "$myrating1"; ?></a>
			</li>
            <!-- <li>
                <a data-toggle="tab" href="#ActivityLog " ><?php echo "$myrating2"; ?></a>
            </li> -->
		</ul>
		<div class="tab-content">
			<div id="AllDocument" class="tab-pane active">
				<table id="tableRating" class="table table-bordered table-striped table-condensed cf">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Position</th>
							<th>Grade</th>
							<th>Unit</th>
							<th>Department</th>
							<th>Input Date</th>
							<th>Your Ratings</th>
							<th style="background-color: yellow;">Final Ratings</th>
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
							<th style="background-color: yellow;">Total Score</th>
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
        let table = $("#tableRating").DataTable({
            "bPaginate": true,
            "bInfo": true,
            "autoWidth": false,
            "processing": true,
            "language": {
                "loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
                                    <i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
                                </span>",
            },
            "ajax": "apiController.php?code=getRatingList",
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
                { "data": 'created_date' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var selectHtml = '<select style="width: 100%;" class="form-control" name="rating_value" id="rating_value" required>';
                        
                        var options = [
                            { value: '', label: '-' },
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
                { "data": 'convertRating' }
            ]
        });
        table.on('change', '#rating_value', function() {
    var selectedValues = [];
    var ratingCounts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 }; // Initialize counts for all possible ratings

    // Iterate through each row in the DataTable
    table.rows().every(function () {
        var rowData = this.data();
        var selectedValue = $(this.node()).find('select[name="rating_value"]').val();
        selectedValues.push({ id: rowData.id, rating: selectedValue });

        // Increment the count for the selected rating value
        if (selectedValue in ratingCounts) {
            ratingCounts[selectedValue]++;
        } else {
            // Handle the selected value as needed
        }
    });

    // Calculate the total count
    var totalCount = Object.values(ratingCounts).reduce((total, count) => total + count, 0);

    // Calculate the percentage for each rating value and update the corresponding elements
    for (var i = 1; i <= 5; i++) {
        var ratingKey = i.toString();
        var count = ratingCounts[ratingKey];
        var percentage = (count / totalCount) * 100;
        $("#percent_" + String.fromCharCode(97 + (5 - i))).text(percentage.toFixed(1) + "%");
    }

            // Now you have an array of objects with id and selected rating values
            console.log(selectedValues);

            // You can access the count for each rating value in the ratingCounts object
            console.log("Rating Counts:", ratingCounts);

            // Update the HTML of the <span> elements with counts
            $("#rate_a").text(ratingCounts['5']);
            $("#rate_b").text(ratingCounts['4']);
            $("#rate_c").text(ratingCounts['3']);
            $("#rate_d").text(ratingCounts['2']);
            $("#rate_e").text(ratingCounts['1']);
            // You can perform any further actions with the selected values and counts here.
        });

    })
</script>