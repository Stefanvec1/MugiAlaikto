<?php
session_start();
if (!isset($_SESSION['gidari_id'])) {
    header("Location: gidari.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <title>Gidari Panela</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
body {
    background-color:rgb(120, 116, 116); /* Fondo general oscuro */
    color: #ffffff;
    font-family: Arial, sans-serif;
}

.panel-container {
    max-width: 1000px;
    margin: 60px auto;
    
    text-align: center;
    
}

.panel-title {
    font-size: 2.5rem;
    margin-bottom: 40px;
    color: rgb(251, 252, 252); /* Blanco claro */
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
}

.panel-options {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}

.panel-card {
    background-color: #3b3b3b; /* Fondo oscuro para las tarjetas */
    border: 2px solid #00b3b3;
    border-radius: 15px;
    width: 280px;
    padding: 25px;
    text-decoration: none;
    color: #e6f7ff;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
    transition: all 0.3s ease;
}

.panel-card:hover {
    background-color: #505050;
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
}

.card-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

.card-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 10px;
    color: #00e6e6;
}

.card-desc {
    font-size: 0.95rem;
    color: #d0f0f0;
}

    </style>
</head>
<body>
    <header class="main-header">
    <a href="index.php">
  <div class="logo">
    <img src="imgs/logo_sin_texto_ampliado.png" alt="AlaiktoMUGI logo">
  </div>
</a>

        <nav>
            <a href="index.php" class="button">Menua</a>
            <a href="saioa_itixi.php" class="button">Saioa Itxi</a>

        </nav>
    </header>

    <div class="panel-container">
    <div class="panel-options">
        <a href="bidaiak_ikusi.php" class="panel-card">
            <div class="card-icon">🧾</div>
            <div class="card-title">Bidaiak Ikusi</div>
            <div class="card-desc">Ikusi zure esleitutako bidaiak.</div>
        </a>
        <a href="bidaia_egoera.php" class="panel-card">
            <div class="card-icon">🚕</div>
            <div class="card-title">Bidaia Egoera</div>
            <div class="card-desc">Eguneratu bidaien egoera.</div>
        </a>
        <a href="bidaia_historiala.php" class="panel-card">
            <div class="card-icon">📜</div>
            <div class="card-title">Bidaia Historiala</div>
            <div class="card-desc">Kontsultatu zure bidaia historiala.</div>
        </a>
    </div>
</div>


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
  </footer>
</body>
</html>

