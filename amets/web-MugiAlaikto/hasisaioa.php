<?php
session_start();
include("konexioa.php");

$error = "";
$login_type = $_POST['login_type'] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && $login_type) {
  $korreoa = $_POST['korreoa'] ?? '';
  $pasahitza = $_POST['pasahitza'] ?? '';
  

    if (!empty($korreoa) && !empty($pasahitza)) {
        if ($login_type === "bezeroa") {
            $stmt = $conn->prepare("SELECT * FROM bezeroa WHERE Korreoa = ? AND Pasahitza = ?");
            $stmt->bind_param("ss", $korreoa, $pasahitza);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['usuario'] = $korreoa;
                $_SESSION['usuario_id'] = $row['BezeroID'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Bezeroaren datuak ez dira zuzenak.";
            }
        } elseif ($login_type === "gidaria") {
            $stmt = $conn->prepare("SELECT * FROM langilea WHERE Korreoa = ? AND Pasahitza = ?");
            $stmt->bind_param("ss", $korreoa, $pasahitza);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['Mota'] == 2) {
                    $_SESSION['gidari_id'] = $row['LangileID'];
                    $_SESSION['gidari_korreoa'] = $row['Korreoa'];
                    header("Location: gidari_panela.php");
                    exit;
                } else {
                    $error = "Ez zara gidari baimendua.";
                }
            } else {
                $error = "Gidariaren datuak ez dira zuzenak.";
            }
        }
    } else {
        $error = "Sartu korreoa eta pasahitza.";
    }
}
?>

<!DOCTYPE html>
<html lang="eu">
<head>
  <meta charset="UTF-8" />
  <title>Saioa Hasi | AlaiktoMUGI</title>
  <link rel="stylesheet" href="css/estilos.css">
  <style>
    .login-form { display: none; }
    .login-container select, .login-container form { margin-top: 15px; }
  </style>
<script>
  function mostrarFormulario() {
    const tipo = document.getElementById('login_type').value;
    document.getElementById('gidaria_form').style.display = tipo === 'gidaria' ? 'block' : 'none';
    document.getElementById('bezeroa_form').style.display = tipo === 'bezeroa' ? 'block' : 'none';
  }

  window.onload = mostrarFormulario; // Mostrar el formulario correcto al cargar la página
</script>

</head>
<body>

<header class="main-header">
  <a href="index.php"><div class="logo"><img src="imgs/logo_sin_texto_ampliado.png" alt="Logo"></div></a>
  <nav>
    <a href="index.php" class="button">Menua</a>
    <?php if (isset($_SESSION['usuario']) || isset($_SESSION['gidari_korreoa'])): ?>
      <a href="saioa_itxi.php" class="button">Saioa Itxi</a>
    <?php else: ?>
      <a href="hasisaioa.php" class="button">Saioa Hasi</a>
    <?php endif; ?>
  </nav>
</header>

<main class="login-container">

  <div style="max-width: 350px; margin: 0 auto; padding: 25px; background-color: #f4f4f4; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    
    <h2 style="text-align: center; margin-bottom: 20px;">🔐 Hasi Saioa</h2>
    
    <label for="login_type" style="display: block; margin-bottom: 8px; font-weight: bold;">
      Hautatu erabiltzaile mota:
    </label>
    
    <select id="login_type" onchange="mostrarFormulario()" style="width: 100%; padding: 10px; font-size: 1em; border-radius: 6px; border: 1px solid #ccc; margin-bottom: 20px;">
      <option value="bezeroa">👥 Bezeroa</option>
      <option value="gidaria">🚖 Gidaria</option>
    </select>

    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<!-- Gidaria Form -->
<form id="gidaria_form" class="login-form" method="POST" action="hasisaioa.php">
  <input type="hidden" name="login_type" value="gidaria">

  <label for="korreoa">Erabiltzailea:</label>
  <input type="text" name="korreoa" required>

  <label for="pasahitza">Pasahitza:</label>
  <input type="password" name="pasahitza" required>

  <input type="submit" value="Saioa hasi">
</form>

<!-- Bezeroa Form -->
<form id="bezeroa_form" class="login-form" method="POST" action="hasisaioa.php">
  <input type="hidden" name="login_type" value="bezeroa">

  <label for="korreoa">Erabiltzailea:</label>
  <input type="text" name="korreoa" required>

  <label for="pasahitza">Pasahitza:</label>
  <input type="password" name="pasahitza" required>

  <input type="submit" value="Saioa hasi">
</form>




  </div>

</main>

<footer>
  <div style="max-width: 1200px; margin: auto; padding: 30px; background: #0d0d0d; color: #ccc; text-align: center;">
    <strong>AlaiktoMUGI S.A.</strong><br>
    Tel: <a href="tel:+34900123456" style="color: #ccc;">+34 900 123 456</a><br>
    Email: <a href="mailto:info@alaiktomugi.eus" style="color: #ccc;">info@alaiktomugi.eus</a><br>
    Helbidea: Donostia kalea 7, 20001 Bilbo, Euskal Herria<br><br>
    <a href="https://facebook.com"><img src="imgs/descarga.jpg" width="24" alt="FB"></a>
    <a href="https://twitter.com"><img src="imgs/descarga (1).jpg" width="24" alt="TW"></a>
    <a href="https://instagram.com"><img src="imgs/descarga.png" width="24" alt="IG"></a><br><br>
    &copy; 2025 AlaiktoMUGI S.A. - Eskubide guztiak erreserbatuta.
  </div>
</footer>

</body>
</html>

