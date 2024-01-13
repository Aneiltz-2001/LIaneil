<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Electricity Bill Calculator</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Electricity Bill Calculator</h2>
        <form method="post">
            <div class="form-group">
                <label for="voltage">Voltage (V):</label>
                <input type="number-format" class="form-control" id="voltage" name="voltage" required>
            </div>
            <div class="form-group">
                <label for="current">Current (A):</label>
                <input type="number-format" class="form-control" id="current" name="current" required>
            </div>
            <div class="form-group">
                <label for="rate">Current Rate (%):</label>
                <input type="number-format" class="form-control" id="currentrate" name="currentrate" required>
            </div>
            <button type="submit" class="btn btn-primary">Calculate</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $voltage = $_POST['voltage'];
            $current = $_POST['current'];
            $currentrate = $_POST['currentrate'];

            // Function to calculate power
            function calculatePower($voltage, $current) {
                return ($voltage * $current) / 1000;
            }

            // Function to calculate electricity rate
            function calculateElectricityRate($voltage, $current, $currentRate, $hours) {
                // Calculate power in kilowatt-hours
                $power = calculatePower($voltage, $current);

                // Calculate energy consumption in kilowatt-hours
                $energy = $power * $hours;

                // Calculate total cost based on the current rate
                $totalCost = $energy * ($currentRate / 100);

                return $totalCost;
            }

            echo "<h3>Result:</h3>";
            echo "<p>Power: " . calculatePower($voltage, $current) . " kWh</p>";
            echo "<p>Rate: $currentrate RM</p>";
            echo "<br>";

            // Display hourly breakdown
            echo "<table class='table'>";
            echo "<thead><tr><th>#</th><th>Hour</th><th>Energy (kWh)</th><th>Total (RM)</th></tr></thead><tbody>";

            for ($hour = 1; $hour <= 24; $hour++) {
                $totalCostPerHour = calculateElectricityRate($voltage, $current, $currentrate, $hour);

                echo "<tr><td>$hour</td><td>$hour</td><td>" . number_format($hour * $voltage * $current / 1000, 5) . "</td><td>" . number_format($totalCostPerHour, 2) . "</td></tr>";
            }

            echo "</tbody></table>";

            echo "<br>";

            // Display daily breakdown
            echo "<table class='table'>";
            echo "<thead><tr><th>#</th><th>Day</th><th>Energy (kWh)</th><th>Total (RM)</th></tr></thead><tbody>";

            for ($day = 1; $day <= 30; $day++) {
                $totalCostPerDay = calculateElectricityRate($voltage, $current, $currentrate, 24 * $day);

                echo "<tr><td>$day</td><td>$day</td><td>" . number_format($day * 30 * $voltage * $current / 1000, 5) . "</td><td>" . number_format($totalCostPerDay, 2) . "</td></tr>";
            }

            echo "</tbody></table>";
        }
        ?>
    </div>
</body>
</html>