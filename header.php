<?php
session_start();
error_reporting(0);
require_once 'config/config.php';
require_once 'config/koneksi.php';
require_once 'lib/site_title.php';
require_once 'lib/redirect.php';

$sqlHal = 'SELECT * FROM halaman';
$qryHal = $mysqli->query($sqlHal) or die($mysqli->error);

$sqlKat = 'SELECT
kategori.id_kategori,
kategori.kategori
FROM
kategori
INNER JOIN berita ON kategori.id_kategori = berita.id_kategori
GROUP BY
kategori.kategori
ORDER BY
kategori.id_kategori ASC
LIMIT 0, 5';
$qryKat = $mysqli->query($sqlKat) or die($mysqli->error);

$sqlBreaking = 'SELECT berita.id_berita, berita.judul FROM berita ORDER BY berita.tgl_posting DESC LIMIT 0, 5';
$qryBreaking = $mysqli->query($sqlBreaking);

$url = $_SERVER['REQUEST_URI'];
$explode_url = explode("/", $url);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo site_title(); ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/hover-min.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="dist/css/style.css">
  <link rel="stylesheet" href="assets/wow/css/animate.css">
  <script src="<?php echo $base_url; ?>assets/jquery/jquery-1.12.0.min.js"></script>
</head>
<body>
<div class="container-fluid wrapper">
  <div class="row">
      <nav class="navbar navbar-inverse navbar-top" style="height: 83px; background-color: #17c788; border-color: #17c788;">
          <div class="container">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
              </div>

              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav headline-container">
                      <p class="navbar-text headline" style="background-color: #121212;">Breaking News</p>
                      <li>
                          <ul id="headlines" class="headlines">
                              <?php while ($breaking_news = $qryBreaking->fetch_array()) { ?>
                                  <li>
                                      <a href="<?php echo $base_url . "detail.php?id=" . $breaking_news['id_berita'] . "&amp;judul=" . strtolower(str_replace(" ", "-", $breaking_news['judul'])); ?>">
                                          <?php echo $breaking_news['judul']; ?>
                                      </a>
                                  </li>
                              <?php } ?>
                          </ul>
                      </li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li>
                      <a class="d-flex align-items-center" href="../index.php" role="button" style="background-color: #7c788; margin-top:4px; font-size: 18px;">
                        <i class="fa fa-arrow-left" style="margin-left: 5px;"></i> <!-- Icon panah ke bawah -->
                        Kembali
                        </a>
                    </li>
                    <?php if (isset($_SESSION['uemail'])) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #7c788; font-size: 18px;">
                            <img src="../admin/user/<?= htmlspecialchars($_SESSION['uimage']); ?>" alt="User Photo" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 8px;">
                            <?= htmlspecialchars($_SESSION['uname']); ?>
                            <i class="fa fa-chevron-down" style="margin-left: 5px;"></i> <!-- Icon panah ke bawah -->
                          </a>
                        </a>
                        <ul class="dropdown-menu" style="width:182px;">
                            <li class="nav-item"> <a class="nav-link" href="../profile.php">Profile</a> </li>
                            <li class="nav-item"> <a class="nav-link" href="../feature.php">Your Property</a> </li>
                            <li class="nav-item"> <a class="nav-link" href="../logout.php">Logout</a> </li>
                        </ul>
                    </li>
                    <?php } else { ?>
                    <li class="nav-item"> <a class="nav-link" href="login.php" style="font-size: 16px;">Login/Register</a> </li>
                    <?php } ?>
                </ul>
              </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
      </nav>
  </div>

	<div class="row header-wrapper">
		<div class="container">
		<div class="header">
			<h3 class="site-title">
				Berita Kita
			</h3>
			<h4 class="site-description">Sumber informasi terpercaya</h4>
		</div>
		  <nav class="navbar navbar-default navbar-bottom">
  			<div class="container-fluid">
    			<!-- Brand and toggle get grouped for better mobile display -->
    			<div class="navbar-header">
      				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
        				<span class="sr-only">Toggle navigation</span>
        				<span class="icon-bar"></span>
        				<span class="icon-bar"></span>
        				<span class="icon-bar"></span>
      				</button>
    			</div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      				<ul class="nav navbar-nav">

              <?php if ($explode_url[2] == 'index.php' || $explode_url[2] == '') { ?>

        				<li class="active"><a href="index.php" class="hvr-sweep-to-top"><i class="glyphicon glyphicon-home"></i></a></li>

              <?php } else { ?>

                <li><a href="index.php" class="hvr-sweep-to-top"><i class="glyphicon glyphicon-home"></i></a></li>

              <?php } ?>

              <?php while ($kat_menu=$qryKat->fetch_array()) { ?>

              <?php if (isset($_GET['kat']) && $kat_menu['id_kategori'] == $_GET['id']) { ?>

	        			<li class="active">
                  <a class="hvr-sweep-to-top" href="<?php echo $base_url."kategori.php?id=".$kat_menu['id_kategori']."&amp;kat=".strtolower($kat_menu['kategori']); ?>">
                    <?php echo $kat_menu['kategori']; ?>
                    </a>
                </li>

              <?php } else { ?>

	        			<li>
                  <a class="hvr-sweep-to-top" href="<?php echo $base_url."kategori.php?id=".$kat_menu['id_kategori']."&amp;kat=".strtolower($kat_menu['kategori']); ?>">
                    <?php echo $kat_menu['kategori']; ?>
                  </a>
                </li>

              <?php } ?>

              <?php } ?>
    	  			</ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="search">
                    <i class="glyphicon glyphicon-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search">
                  <li>
                    <form action="search.php" class="navbar-form" role="search" method="GET">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Cari" name="q" id="search-form">
                      </div>
                    </form>
                  </li>
                </ul>
                </li>
              </ul>
    			</div><!-- /.navbar-collapse -->
  			</div><!-- /.container-fluid -->
		  </nav>
		</div>
	</div>
</div>
<div class="clear"></div>