<?php

include 'backend/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $polling_unit_id = $_POST['polling_unit_id'];
    $ward_id = $_POST['ward_id'];
    $lga_id = $_POST['lga_id'];
    $polling_unit_number = $_POST['polling_unit_number'];
    $polling_unit_name = $_POST['polling_unit_name'];

    $apc_score = $_POST['apc_score'];
    $pdp_score = $_POST['pdp_score'];
    $lp_score = $_POST['lp_score'];

    // Insert polling unit
    $stmt = $conn->prepare("
        INSERT INTO polling_unit
        (
            polling_unit_id,
            ward_id,
            lga_id,
            polling_unit_number,
            polling_unit_name
        )
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "iiiss",
        $polling_unit_id,
        $ward_id,
        $lga_id,
        $polling_unit_number,
        $polling_unit_name
    );

    $stmt->execute();

    // Get the uniqueid of the new polling unit
    $polling_unit_uniqueid = $conn->insert_id;

    // Insert party results
    $stmt = $conn->prepare("
        INSERT INTO announced_pu_results
        (
            polling_unit_uniqueid,
            party_abbreviation,
            party_score
        )
        VALUES (?, ?, ?)
    ");

    $party = "APC";
    $stmt->bind_param("isi", $polling_unit_uniqueid, $party, $apc_score);
    $stmt->execute();

    $party = "PDP";
    $stmt->bind_param("isi", $polling_unit_uniqueid, $party, $pdp_score);
    $stmt->execute();

    $party = "LP";
    $stmt->bind_param("isi", $polling_unit_uniqueid, $party, $lp_score);
    $stmt->execute();

    echo "Polling unit and results added successfully";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Polling Unit</title>
</head>

<body>

    <h1>Add Polling Unit</h1>

    <form method="POST">

        <label>Polling Unit ID</label>
        <input type="number" name="polling_unit_id" required>

        <br><br>

        <label>Ward ID</label>
        <input type="number" name="ward_id" required>

        <br><br>

        <label>LGA ID</label>
        <input type="number" name="lga_id" required>

        <br><br>

        <label>Polling Unit Number</label>
        <input type="text" name="polling_unit_number" required>

        <br><br>

        <label>Polling Unit Name</label>
        <input type="text" name="polling_unit_name" required>

        <br><br>

        <h3>Party Results</h3>

        <label>APC</label>
        <input type="number" name="apc_score" min="0" required>

        <br><br>

        <label>PDP</label>
        <input type="number" name="pdp_score" min="0" required>

        <br><br>

        <label>LP</label>
        <input type="number" name="lp_score" min="0" required>

        <br><br>

        <button type="submit">Add Polling Unit</button>

    </form>

</body>
</html>