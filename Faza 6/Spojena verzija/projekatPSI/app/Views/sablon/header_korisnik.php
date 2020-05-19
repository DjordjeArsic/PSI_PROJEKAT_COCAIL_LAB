<!DOCTYPE html>
<html lang="sr-RS">
<head>
  <title>Korisnik-Cocktail Lab</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- linkovi za bootstrap 4 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<!-- pocetak header-a -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary border-bottom pt-3 pb-3">
      <?php echo "<a class='navbar-brand' href='".site_url("Pretraga/index")."'>COCKTAIL LAB</a>"; ?>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <?php echo "<a class='nav-link' href='".site_url("Korisnik/index")."' id='pretraga'>Početna</a>"; ?>
          </li>
          <li class="nav-item">
            <?php echo "<a class='nav-link' href='".site_url("Korisnik/mojiKokteli")."' id='mojiRecepti'>Moji recepti</a>"; ?>            
          </li>
          <li class="nav-item">
            <?php echo "<a class='nav-link' href='".site_url("Korisnik/postaviRecept")."' id='postaviRecept'>Objavite recept</a>"; ?>            
          </li>
          <li>
            <?php echo "<a class='nav-link' href='".site_url("Nalog/logOut")."'>Odjavite se</a>"; ?>
          </li>
        </ul>
      </div>
    </nav>
</header>
<!-- kraj header-a -->
