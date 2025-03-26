<?php
$host = "";
$user = "";
$pass = "";
$dbname = "";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM cpu_temperature ORDER BY timestamp DESC LIMIT 10";
$result = $conn->query($sql);

$chart_sql = "SELECT temperature, timestamp FROM cpu_temperature ORDER BY timestamp DESC LIMIT 10";
$chart_result = $conn->query($chart_sql);

$temp_data = [];
$timestamps = [];

while ($row = $chart_result->fetch_assoc()) {
    $temp_data[] = $row['temperature'];
    $timestamps[] = $row['timestamp'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPU Temperature Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #121212; color: #fff; }
        .container { max-width: 900px; margin: auto; }
        table { margin-top: 20px; }
        .card { background-color: #1e1e1e; border: none; }
        .table-dark { background-color: #232323; }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">📊 CPU Temperature Dashboard</h2>

    <!-- Temperature Chart -->
    <div class="card p-3 mt-3">
        <canvas id="tempChart"></canvas>
    </div>

    <!-- Latest Readings Table -->
    <div class="card p-3 mt-3">
        <h4>📌 Latest Readings</h4>
        <table class="table table-dark table-bordered text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Temperature (°C)</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['temperature']; ?>°C</td>
                        <td><?php echo $row['timestamp']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Debug: Check if data is coming correctly from PHP
    console.log("PHP Data for Temperature: ", <?php echo json_encode($temp_data); ?>);
    console.log("PHP Data for Timestamps: ", <?php echo json_encode($timestamps); ?>);

    // Refresh page every 30 seconds
    setTimeout(() => { location.reload(); }, 30000);

    // Temperature Chart
    const ctx = document.getElementById('tempChart').getContext('2d');
    const tempChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($timestamps); ?>,
            datasets: [{
                label: 'CPU Temperature (°C)',
                data: <?php echo json_encode($temp_data); ?>,
                borderColor: '#1e90ff',  // Blue color for the line
                backgroundColor: 'rgba(30, 144, 255, 0.2)',  // Light blue gradient fill
                fill: true,  // Fill the area under the line
                tension: 0.4,  // Smoother curve
                borderWidth: 2,
                pointBackgroundColor: '#1e90ff', // Blue points
                pointRadius: 0,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: { display: true, text: 'Timestamp', color: '#fff' },
                    grid: { color: '#444' }
                },
                y: {
                    title: { display: true, text: 'Temperature (°C)', color: '#fff' },
                    grid: { color: '#444' },
                    min: 26,  // Set the minimum value for y-axis
                    max: 35   // Set the maximum value for y-axis
                }
            },
            plugins: {
                legend: {
                    labels: { color: '#fff' }
                },
                tooltip: {
                    backgroundColor: 'rgba(30, 144, 255, 0.8)',  // Tooltip background color
                    bodyColor: '#fff',
                    titleColor: '#fff',
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw + '°C';
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>
