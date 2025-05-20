<?php
session_start();
include("konexioa.php");

if (!isset($_SESSION['gidari_korreoa'])) {
    echo "Saioa hasi behar duzu.";
    exit();
}

$korreoa = $_SESSION['gidari_korreoa'];
$gidari_id = $_SESSION['gidari_id']; // Aquí lo colocas


$sql = "SELECT BidaiaID, Abiapuntua, Helmuga, HasieraData, HasieraOrdua, Egoera, PertsonaKop, Langilea_LangileID
        FROM bidaia
        WHERE (Langilea_LangileID IS NULL OR Langilea_LangileID = ?)
        AND Egoera = 0";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en prepare: " . $conn->error);
}

$stmt->bind_param("i", $gidari_id);
$stmt->execute();

$result = $stmt->get_result();
if (!$result) {
    die("Errorea emaitzak eskuratzean: " . $stmt->error);
}
?>


<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8" />
    <title>Bidaiak Ikusi - Gidariaren Panela</title>
    <link rel="stylesheet" href="css/estilos.css" />
    <style>
        h1 {
            text-align: center;
            margin-top: 40px;
            color:rgba(246, 247, 249, 0.99);
            font-size: 2.2em;
            background-color: rgb(0, 0, 0)
        }

        main {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background-color: #2c3e50;
            color: #fff;
        }

        th, td {
            padding: 14px 16px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        tbody tr:hover {
            background-color: #f0f0f0;
        }

        form button {
            border: none;
            padding: 8px 14px;
            margin: 2px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        form button[name="egoera"][value="1"] {
            background-color: #27ae60;
        }

        form button[name="egoera"][value="1"]:hover {
            background-color: #1e8449;
        }

        form button[name="egoera"][value="2"] {
            background-color: #e74c3c;
        }

        form button[name="egoera"][value="2"]:hover {
            background-color: #c0392b;
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

<main>
    <h1>Bidaiak Ikusi</h1>

    <table>
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
        <?php if ($result->num_rows > 0): ?>
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
                            <button type="submit" name="egoera" value="1">Onartu</button>
                            <button type="submit" name="egoera" value="2">Ez Onartu</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Ez dago bidaiarik momentu honetan.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</main>

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
