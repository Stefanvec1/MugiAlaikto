<?php
session_start();
include("konexioa.php");

// Si el conductor ya ha iniciado sesión, redirige al index
if (isset($_SESSION['gidari_id'])) {
    header("Location: index.php");
    exit;
}

// Procesar el login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $korreoa = $_POST['korreoa'];
    $pasahitza = $_POST['pasahitza'];

    if (!empty($korreoa) && !empty($pasahitza)) {
        $stmt = $conn->prepare("SELECT * FROM langilea WHERE Korreoa = ? AND Pasahitza = ?");
        $stmt->bind_param("ss", $korreoa, $pasahitza);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row['Mota'] == 2) { // Solo conductores
                $_SESSION['gidari_id'] = $row['LangileID'];
                $_SESSION['gidari_korreoa'] = $row['Korreoa'];
                header("Location: gidari_panela.php");

                exit;
            } else {
                $error = "Ez zara gidari baimendua.";
            }
        } else {
            $error = "Datu okerrak.";
        }

        $stmt->close();
        $conn->close();
    } else {
        $error = "Bete korreoa eta pasahitza.";
    }
}
?>

<!DOCTYPE html>
<html lang="eu">
<head>
  <meta charset="UTF-8" />
  <title>AlaiktoMUGI - Gidaria</title>
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
      <a href="hasisaioa.php" class="button">Saioa Hasi</a>
      <a href="gidari.php" class="button">Gidaria</a>
    </nav>
    <header>
    <nav>
  <?php if (isset($_SESSION['gidari_korreoa'])): ?>
    <span>Conductor: <?php echo htmlspecialchars($_SESSION['gidari_korreoa']); ?></span>
  <?php elseif (isset($_SESSION['korreoa'])): ?>
    <span><?php echo htmlspecialchars($_SESSION['korreoa']); ?></span>
  <?php else: ?>
    <span>Ez zaude saioa hasita</span>
  <?php endif; ?>
</nav>

    </header>
  </header>

  <main class="login-container">
    <h2>Gidariaren Saioa Hasi</h2>
    <form action="gidari.php" method="POST">
      <label for="korreoa">Korreoa:</label>
      <input type="text" name="korreoa" required>

      <label for="pasahitza">Pasahitza:</label>
      <input type="password" name="pasahitza" required>

      <input type="submit" value="Saioa hasi">
    </form>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
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
