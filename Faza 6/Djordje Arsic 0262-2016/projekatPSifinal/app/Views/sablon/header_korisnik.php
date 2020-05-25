<!DOCTYPE html>
<html lang="sr-RS">
<head>
  <title>Korisnik-Cocktail Lab</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- linkovi za bootstrap 4 -->
  <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,300,400,700,900" rel="stylesheet">
  <link rel="stylesheet" href="http://localhost:8080/fonts/icomoon/style.css">
  <link rel="stylesheet" href="http://localhost:8080/css/bootstrap.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="http://localhost:8080/css/nouislider.min.css">
  <link rel="stylesheet" href="http://localhost:8080/css/bootstrap-datetimepicker.css">
  <link rel="stylesheet" href="http://localhost:8080/css/style.css">
  <link rel="stylesheet" href="http://localhost:8080/css/nasCSS.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  
  <script src="https://kit.fontawesome.com/a81368914c.js"></script>
</head>
<body>
<div style="min-height: 100vh;">
    <!-- pocetak header-a -->
    <header>
      <nav class=" px-4 navbar navbar-expand-lg navbar-dark bg-primary mb-4">
          <?php echo "<a class='navbar-brand' href='".site_url("Pretraga/index")."'><img src='http://localhost:8080/img/logo.png' alt='Logo' class='logo-fotografija'></a>"; ?>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown4" aria-controls="navbarNavDropdown4" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown4">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <?php echo "<a class='nav-link' href='".site_url("Korisnik/index")."' id='pretraga'>"; ?>
                <i class="fas fa-home fa-lg"></i> <span>Početna</span></a>
              </li>
              <li class="nav-item">
                <?php echo "<a class='nav-link' href='".site_url("Korisnik/mojiKokteli")."' id='mojiRecepti'>"; ?>            
                <i class="fas fa-laugh-beam fa-lg"></i> <span>Moji recepti</span></a>
              </li>
              <li class="nav-item">
                <?php echo "<a class='nav-link' href='".site_url("Korisnik/postaviRecept")."' id='postaviRecept'>"; ?>
                <i class="fas fa-upload fa-lg"></i> <span>Objavite recept</span></a>
              </li>
              <li class="nav-item">
                <?php echo "<a class='nav-link' href='".site_url("Nalog/logOut")."'>"; ?>           
                <i class="fas fa-sign-out-alt fa-lg"></i> <span>Odjavite se</span></a>
              </li>
            </ul>
          </div>
        </nav> 
    </header>
<!-- kraj header-a -->