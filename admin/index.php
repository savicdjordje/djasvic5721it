<?php
require_once "../db.php";
require_once "autorizacija/proveri-pristup.php";

$title = "Admin panel";

$query = "SELECT tu.naziv AS tip_usluge, COUNT(r.id) AS broj_rezervacija
            FROM tip_usluge tu
            LEFT JOIN usluga u ON tu.id = u.tip_usluge_id
            LEFT JOIN rezervacije r ON u.id = r.usluga_id
            GROUP BY tu.id";
$stmt = $pdo->query($query);
$rows = $stmt->fetchAll();

$data = [["Tip usluge", "Broj rezervacija"]];
foreach ($rows as $row) {
    $data[] = [$row['tip_usluge'], (int)$row['broj_rezervacija']];
}

include "../admin-modules/header.php"
?>

<div class="container mt-5">
    <div id="chart_div" style="width: 100%; height: 500px;"></div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
const chartData = <?= json_encode($data) ?>;

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(() => {
    const dataTable = google.visualization.arrayToDataTable(chartData);
    const options = {
        title: 'Broj rezervacija po tipu usluge',
        pieHole: 0.4,
    };
    const chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(dataTable, options);
});
</script>


<?php include "../admin-modules/footer.php"; ?>