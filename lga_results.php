<?php

include 'backend/database.php';

$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $lga_id = $_POST['lga_id'] ?? "";

    if (empty($lga_id)) {
        echo "LGA ID can't be empty";
        exit();
    }

    $stmt = $conn->prepare("
        SELECT party_abbreviation, SUM(party_score) AS total_score
        FROM announced_pu_results
        JOIN polling_unit
            ON announced_pu_results.polling_unit_uniqueid = polling_unit.uniqueid
        WHERE polling_unit.lga_id = ?
        GROUP BY party_abbreviation
    ");

    $stmt->bind_param("i", $lga_id);

    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LGA Results</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }

        .container {
            width: 90%;
            max-width: 700px;
            margin: 60px auto;
        }

        h1 {
            text-align: center;
        }

        .search-box,
        .results {
            background: white;
            padding: 25px;
            margin-top: 25px;
            border-radius: 8px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        button {
            padding: 12px 20px;
            background: #2b6e4f;
            color: white;
            border: none;
            cursor: pointer;
        }

        .party {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>LGA Results</h1>

    <div class="search-box">

        <form method="POST">

            <label for="lga_id">LGA ID</label>

            <input
                type="number"
                name="lga_id"
                id="lga_id"
                placeholder="Enter LGA ID"
                required
            >

            <button type="submit">
                Search
            </button>

        </form>

    </div>

    <div class="results">

        <h2>Total Results</h2>

        <!-- Results will go here -->
        <?php foreach ($results as $row): ?>

<div class="party">

    <span>
        <?php echo htmlspecialchars($row['party_abbreviation']); ?>
    </span>

    <span>
        <?php echo htmlspecialchars($row['total_score']); ?>
    </span>

</div>

<?php endforeach; ?>

    </div>

</div>

</body>
</html>