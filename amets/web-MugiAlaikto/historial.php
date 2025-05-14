<?php
session_start();
?>

<!DOCTYPE html>
<html lang="eu">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bidaiaren Historiala | AlaiktoMUGI</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

  <header class="main-header">
    <div class="logo">
      <img src="imgs/logo_sin_texto_ampliado.png" alt="AlaiktoMUGI logo">
    </div>
    <nav>
      <a href="index.php" class="button">Menua</a>
      <a href="historial.php" class="button">Historiala</a>
      <?php if (isset($_SESSION['usuario'])): ?>
        <a href="saioaitxi.php" class="button">Saioa Itxi</a>
      <?php else: ?>
        <a href="hasisaioa.php" class="button">Saioa Hasi</a>
      <?php endif; ?>
    </nav>
  </header>

  <main>
    <section class="main-section">
      <div class="table-container">
        <h3>Bidaiaren Historiala</h3>

        <table>
          <thead>
            <tr>
              <th>Hasiera Data</th>
              <th>Hasiera Ordua</th>
              <th>Amaiera Data</th>
              <th>Amaiera Ordua</th>
              <th>Traiektua</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!isset($_SESSION['usuario'])) {
              echo "<tr><td colspan='5'>Saioa hasi behar da bidaiak ikusteko.</td></tr>";
            } else {
              include 'konexioa.php';
              $korreoa = $_SESSION['usuario'];

              // Lortu erabiltzailearen BezeroID
              $stmt = $conn->prepare("SELECT BezeroID FROM bezeroa WHERE Korreoa = ?");
              if ($stmt === false) {
                echo "<tr><td colspan='5'>Errorea kontsultan: bezeroa</td></tr>";
              } else {
                $stmt->bind_param("s", $korreoa);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                  $row = $result->fetch_assoc();
                  $bezeroID = $row['BezeroID'];

                  // Lortu erabiltzailearen bidaiak
                  $stmt2 = $conn->prepare("SELECT hasiera_data, hasiera_ordua, amaiera_data, amaiera_ordua, traiektua FROM bidaiak WHERE BezeroID = ? ORDER BY hasiera_data DESC, hasiera_ordua DESC");
                  if ($stmt2 === false) {
                    echo "<tr><td colspan='5'>Errorea kontsultan: bidaiak</td></tr>";
                  } else {
                    $stmt2->bind_param("i", $bezeroID);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();

                    if ($result2->num_rows > 0) {
                      while ($row2 = $result2->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row2['hasiera_data']) . "</td>";
                        echo "<td>" . htmlspecialchars($row2['hasiera_ordua']) . "</td>";
                        echo "<td>" . htmlspecialchars($row2['amaiera_data']) . "</td>";
                        echo "<td>" . htmlspecialchars($row2['amaiera_ordua']) . "</td>";
                        echo "<td>" . htmlspecialchars($row2['traiektua']) . "</td>";
                        echo "</tr>";
                      }
                    } else {
                      echo "<tr><td colspan='5'>Ez da bidaia historikorik aurkitu.</td></tr>";
                    }

                    $stmt2->close();
                  }
                } else {
                  echo "<tr><td colspan='5'>Ez da bezeroa aurkitu.</td></tr>";
                }

                $stmt->close();
              }

              $conn->close();
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>

  <footer>
    <div style="max-width: 1200px; margin: 0 auto; padding: 30px; background-color: #0d0d0d; color: #ccc; font-size: 0.95em;">
      <div style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 20px;">
        <div>
          <strong>AlaiktoMUGI S.A.</strong><br>
          Tel: <a href="tel:+34900123456" style="color: #ccc;">+34 900 123 456</a><br>
          Email: <a href="mailto:info@alaiktomugi.eus" style="color: #ccc;">info@alaiktomugi.eus</a><br>
          Helbidea: Donostia kalea 7, 20001 Bilbo, Euskal Herria
        </div>
        <div>
          <a href="https://facebook.com" target="_blank"><img src="imgs/descarga.jpg" alt="Facebook" width="24"></a>
          <a href="https://twitter.com" target="_blank"><img src="imgs/descarga (1).jpg" alt="Twitter" width="24"></a>
          <a href="https://instagram.com" target="_blank"><img src="imgs/descarga.png" alt="Instagram" width="24"></a>
        </div>
        <div style="margin-top: 20px; font-size: 0.85em; color: #888;">
          &copy; 2025 AlaiktoMUGI S.A. - Eskubide guztiak erreserbatuta.
        </div>
      </div>
    </div>
  </footer>

</body>
</html>
