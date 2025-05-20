<?php
session_start();
include("konexioa.php");

if (!isset($_SESSION['gidari_korreoa'])) {
    echo "Saioa hasi behar duzu.";
    exit();
}

// Aseguramos que gidari_id sea entero y esté definido
$gidari_id = isset($_SESSION['gidari_id']) ? (int)$_SESSION['gidari_id'] : 0;
if ($gidari_id === 0) {
    echo "Errorea: gidari ID ez dago saioan gordeta.";
    exit();
}

$updated = null; // Para el mensaje

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bidaia_id = isset($_POST['bidaia_id']) ? (int)$_POST['bidaia_id'] : 0;
    $egoera = isset($_POST['egoera']) ? (int)$_POST['egoera'] : 0;

    if ($bidaia_id > 0) {
        // Comprobar que la reserva está asignada a este conductor o sin asignar
        $stmt = $conn->prepare("SELECT * FROM bidaia WHERE BidaiaID = ? AND (Langilea_LangileID IS NULL OR Langilea_LangileID = ?)");
        $stmt->bind_param("ii", $bidaia_id, $gidari_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            // Actualizar estado y asignar conductor
            $update = $conn->prepare("UPDATE bidaia SET Egoera = ?, Langilea_LangileID = ? WHERE BidaiaID = ?");
            $update->bind_param("iii", $egoera, $gidari_id, $bidaia_id);
            $updated = $update->execute();
        } else {
            $updated = false;
        }
    } else {
        $updated = false;
    }
}
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <title>Bidaia Egoera Aldatu</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        main {
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }
        .mezua {
            font-size: 1.3em;
            margin: 20px auto;
            padding: 15px;
            background-color: #f7f7f7;
            border: 1px solid #ccc;
            border-radius: 10px;
            max-width: 600px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        table, th, td {
            border: 1px solid #aaa;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        form select {
            padding: 5px;
        }
        form button {
            padding: 6px 12px;
            margin-left: 8px;
            cursor: pointer;
        }
        .header-buttons a {
            margin: 0 8px;
            text-decoration: none;
            padding: 8px 15px;
            background-color: #333;
            color: white;
            border-radius: 6px;
            font-weight: bold;
        }
        .header-buttons a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<header class="main-header" style="display:flex; align-items:center; justify-content: space-between; padding: 15px 40px; background-color: #222; color: white;">
    <div class="logo">
        <img src="imgs/logo_sin_texto_ampliado.png" alt="AlaiktoMUGI logo" style="height: 50px;">
    </div>
    <nav class="header-buttons">
        <a href="index.php">Menua</a>
        <a href="gidari_panela.php">Atzera</a>
        <a href="gidari.php">Gidaria</a>
    </nav>
</header>

<main>
    <h1>Bidaia Egoera Aldatu</h1>

    <?php if ($updated !== null): ?>
        <div class="mezua" style="color: <?= $updated ? 'green' : 'red' ?>">
            <?= $updated ? 'Bidaia egoera eguneratu da.' : 'Errorea gertatu da edo ez daukazu bidaiarik.' ?>
        </div>
    <?php endif; ?>

    <h2>Zure bidaiak</h2>

    <table>
        <thead>
            <tr>
                <th>ID Bidaia</th>
                <th>Bezeroa</th>
                <th>Data</th>
                <th>Egoera</th>
                <th>Akzioak</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Sacar las reservas asignadas o sin asignar para este conductor
            $stmt2 = $conn->prepare("SELECT BidaiaID, Bezeroa_BezeroID, HasieraData, AmaieraData, Egoera, BezeroIzena, BezeroTelefonoa FROM bidaia WHERE Langilea_LangileID = ? OR Langilea_LangileID IS NULL ORDER BY HasieraData ASC
");

if ($stmt2 === false) {
    die("Errorea SQL prestatzeko: " . $conn->error);
}

$stmt2->bind_param("i", $gidari_id);

if (!$stmt2->execute()) {
    die("Errorea SQL exekutatzen: " . $stmt2->error);
}

$res = $stmt2->get_result();
if ($res === false) {
    die("Errorea emaitza jasotzen: " . $stmt2->error);
}


            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['BidaiaID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['BezeroIzena']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['HasieraData']) . "</td>";
                
                    $egoera_text = match ($row['Egoera']) {
                        0 => 'Hasi gabe',
                        1 => 'Hasita',
                        2 => 'Bukatuta',
                        default => 'Ezezaguna',
                    };
                    echo "<td>$egoera_text</td>";
                
                    echo "<td>
                        <form method='POST' style='margin:0;'>
                            <input type='hidden' name='bidaia_id' value='" . $row['BidaiaID'] . "'>
                            <select name='egoera'>
                                <option value='0'" . ($row['Egoera'] == 0 ? ' selected' : '') . ">Hasi gabe</option>
                                <option value='1'" . ($row['Egoera'] == 1 ? ' selected' : '') . ">Hasita</option>
                                <option value='2'" . ($row['Egoera'] == 2 ? ' selected' : '') . ">Bukatuta</option>
                            </select>
                            <button type='submit'>Eguneratu</button>
                        </form>
                    </td>";
                
                    echo "</tr>";
                }
                
            } else {
                echo "<tr><td colspan='5'>Ez dago bidaiarik.</td></tr>";
            }
            ?>
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

