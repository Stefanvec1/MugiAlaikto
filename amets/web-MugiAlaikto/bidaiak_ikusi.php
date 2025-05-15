<?php
session_start();
include("konexioa.php");

if (!isset($_SESSION['gidari_id'])) {
    header("Location: gidari.php?alerta=debes_iniciar_sesion");
    exit();
}

$gidari_id = $_SESSION['gidari_id'];

// Consulta para obtener reservas asignadas al conductor
$sql = "SELECT BidaiaID, Abiapuntua, Helmuga, HasieraData, HasieraOrdua, Egoera, PertsonaKop
        FROM bidaia
        WHERE Langilea_LangileID = ? AND Egoera = 0";  // Egoera=0 -> pendiente

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $gidari_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8" />
    <title>Bidaiak Ikusi - Gidariaren Panela</title>
    <link rel="stylesheet" href="css/estilos.css" />
</head>
<body>

<h1>Bidaiak Ikusi</h1>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Abiapuntua</th>
            <th>Helmuga</th>
            <th>Data</th>
            <th>Ordua</th>
            <th>Pasai Kop</th>
            <th>Akzioak</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['BidaiaID'] ?></td>
            <td><?= htmlspecialchars($row['Abiapuntua']) ?></td>
            <td><?= htmlspecialchars($row['Helmuga']) ?></td>
            <td><?= $row['HasieraData'] ?></td>
            <td><?= $row['HasieraOrdua'] ?></td>
            <td><?= $row['PertsonaKop'] ?></td>
            <td>
                <form action="bidaia_egoera.php" method="POST" style="display:inline-block;">
                    <input type="hidden" name="bidaia_id" value="<?= $row['BidaiaID'] ?>">
                    <button type="submit" name="egoera" value="1" style="background:green; color:#fff;">Onartu</button>
                    <button type="submit" name="egoera" value="2" style="background:red; color:#fff;">Ez Onartu</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>

