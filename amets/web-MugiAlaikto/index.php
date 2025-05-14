
<?php
session_start();
include 'konexioa.php';
?>


<!DOCTYPE html>
<html lang="eu">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AlaiktoMUGI</title>
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
      <a href="hasisaioa.php" class="button">Saioa Hasi</a>
    </nav>
    <header>
  <nav>
    <?php if (isset($_SESSION['korreoa'])): ?>
      <span>Kaixo, <?php echo htmlspecialchars($_SESSION['korreoa']); ?></span>
    <?php else: ?>
    <?php endif; ?>
  </nav>
</header>

  </header>

  <main style="position: relative;">

    <section class="main-section">
      <div class="image-box">
        <img src="imgs/oficina_fondo_blanco.jpg" alt="Foto de la oficina">
      </div>
      <div class="map-box">
        <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2795.278460712229!2d-1.9812!3d43.3180!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd51a72e44cd5db7%3A0x47cb2d7f6d3f5be7!2sSan%20Sebasti%C3%A1n%2C%20Donostia%2C%20Guip%C3%BAzcoa%2C%20Espa%C3%B1a!"
        allowfullscreen="" 
        loading="lazy">
        </iframe>
      </div>
    </section>
    <div class="reserva-flecha">
    <?php if (isset($_SESSION['usuario_id'])): ?>
  <a href="erreserba.php">
<?php else: ?>
  <a href="hasisaioa.php?alerta=login">
<?php endif; ?>

    <div class="reserva-contenedor">
    <img src="imgs/ChatGPT Image 13 may 2025, 11_56_04.png" alt="Erreserba egin" />
      <div class="reserva-textua">Erreserba Egin</div>
    </div>
  </a>
</div>
</div>


    <div class="info">
        <h3>AlaiktoMugi - Taxi Zerbitzu Profesionala</h3>
        <p><img src="imgs/concepto-aplicacion-taxi_23-2148484247.jpg" alt="AlaiktoMugi Taxi" />AlaiktoMugi, zure fidagarria eta azkarra den taxi zerbitzua, kalitatezko bidaia esperientzia eskaintzen du. Gure helburua, bezeroei erosotasun, segurtasun eta eraginkortasun handiena ematea da, zure helmugara modu azkar eta erosoan iristeko. Gure gidariak profesionalak dira eta zure beharren arabera zerbitzu pertsonalizatuak eskaintzen dituzte. 
            AlaiktoMugi-rekin bidaiatzeko, konfianza eta tratu onen bila zoaz!
        </p>
    </div>
    
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
  </footer>

</body>
</html>

