<?php
session_start();
include("konexioa.php");

if (!isset($_SESSION['gidari_korreoa'])) {

    echo "Saioa hasi behar duzu.";
    exit();
}

$korreoa = $_SESSION['gidari_korreoa'];
$gidari_id = $_SESSION['gidari_id']; // Aquí lo colocas

// Obtener los viajes finalizados del conductor
$sql = "SELECT BidaiaID, Abiapuntua, Helmuga, HasieraData, HasieraOrdua, AmaieraData, AmaieraOrdua, PertsonaKop
        FROM bidaia
        WHERE Langilea_LangileID = ? AND Egoera = 2"; // Finalizados

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $gidari_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8" />
    <title>Bidaia Historiala - Gidaria</title>
    <link rel="stylesheet" href="css/estilos.css" />
    <style>
        h1 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }

        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #fff;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #0d0d0d;
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        body {
            background-color: #f8f8f8;
            font-family: sans-serif;
        }
    </style>
</head>
<body>

<header class="main-header">
    <div class="logo">
        <img src="imgs/logo_sin_texto_ampliado.png" alt="AlaiktoMUGI logo">
    </div>
    <nav>
        <a href="index.php" class="button">Menua</a>
        <a href="gidari_panela.php" class="button">Atzera</a>
        <a href="gidari.php" class="button">Gidaria</a>
    </nav>
</header>

<h1>Bidaia Historiala</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Abiapuntua</th>
            <th>Helmuga</th>
            <th>Hasiera Data</th>
            <th>Hasiera Ordua</th>
            <th>Amaiera Data</th>
            <th>Amaiera Ordua</th>
            <th>Pasai Kop</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['BidaiaID'] ?></td>
                    <td><?= htmlspecialchars($row['Abiapuntua']) ?></td>
                    <td><?= htmlspecialchars($row['Helmuga']) ?></td>
                    <td><?= $row['HasieraData'] ?></td>
                    <td><?= $row['HasieraOrdua'] ?></td>
                    <td><?= $row['AmaieraData'] ?></td>
                    <td><?= $row['AmaieraOrdua'] ?></td>
                    <td><?= $row['PertsonaKop'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">Ez dago amaitutako bidaiarik.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<footer>
    <div style="max-width: 1200px; margin: 0 auto; padding: 30px; background-color: #0d0d0d; color: #ccc; font-size: 0.95em;">
      <div style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 20px;">
        <div>
          <strong>AlaiktoMUGI S.A.</strong><br>
          Tel: <a href="tel:+34900123456" style="color: #ccc; text-decoration: none;">+34 900 123 456</a><br>
          Email: <a href="mailto:info@alaiktomugi.eus" style="color: #ccc; text-decoration: none;">info@alaiktomugi.eus</a><br>
          Helbidea: Donostia kalea 7, 20001 Bilbo, Euskal Herria
        </div>
        <div>
          <a href="https://facebook.com" target="_blank" style="margin-right: 10px;">
            <img src="imgs/descarga.jpg" alt="Facebook" width="24">
          </a>
          <a href="https://twitter.com" target="_blank" style="margin-right: 10px;">
            <img src="imgs/descarga (1).jpg" alt="Twitter" width="24">
          </a>
          <a href="https://instagram.com" target="_blank" style="margin-right: 10px;">
            <img src="imgs/descarga.png" alt="Instagram" width="24">
          </a>
        </div>
        <div style="text-align: center; margin-top: 20px; font-size: 0.85em; color: #888;">
          &copy; 2025 AlaiktoMUGI S.A. - Eskubide guztiak erreserbatuta.
        </div>
      </div>
    </div>
  </footer>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
