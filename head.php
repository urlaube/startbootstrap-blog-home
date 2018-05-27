<?php

  // prevent script from getting called directly
  if (!defined("URLAUBE")) { die(""); }

?>
<!DOCTYPE html>
<html lang="<?= html(Themes::get(LANGUAGE)) ?>">
  <head>
    <meta charset="<?= html(Themes::get(CHARSET)) ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<?php
  if (null !== Themes::get(AUTHOR)) {
?>
    <meta name="author" content="<?= html(Themes::get(AUTHOR)) ?>">
<?php
  }
?>
    <meta name="description" content="<?= html(Themes::get(DESCRIPTION)) ?>">
    <meta name="keywords" content="<?= html(Themes::get(KEYWORDS)) ?>">

<?php
  $feeduri = feeduri();
  if (null !== $feeduri) {
?>
    <link rel="alternate" type="application/rss+xml" href="html($feeduri)" />
<?php
  }
?>
    <link rel="canonical" href="<?= html(Themes::get(CANONICAL)) ?>">
<?php
  $next = nextpage();
  if (null !== $next) {
?>
    <link rel="next" href="<?= html($next) ?>">
<?php
  }
  $prev = prevpage();
  if (null !== $prev) {
?>
    <link rel="prev" href="<?= html($prev) ?>">
<?php
  }
  if (null !== Themes::get(FAVICON)) {
?>
    <link rel="shortcut icon" type="image/x-icon" href="<?= html(Themes::get(FAVICON)) ?>">
<?php
  }
?>

    <title><?= html(Themes::get(TITLE)) ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= html(path2uri(__DIR__."/css/bootstrap.min.css")) ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= html(Main::ROOTURI()."startbootstrap-blog-home.css") ?>" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="<?= html(path2uri(__DIR__."/js/html5shiv.js")) ?>"></script>
      <script src="<?= html(path2uri(__DIR__."/js/respond.min.js")) ?>"></script>
    <![endif]-->
  </head>

  <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header page-scroll">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand page-scroll" href="<?= html(Main::ROOTURI()) ?>">
<?php
  if (null !== Themes::get(LOGO)) {
?>
            <img src="<?= html(Themes::get(LOGO)) ?>" alt="<?= html(Main::SITENAME()) ?>">
<?php
  } else {
?>
            <?= html(Main::SITENAME().NL) ?>
<?php
  }
?>
          </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav">
            <!-- Hidden li included to remove active class from first menu link when scrolled up past first section section -->
            <li class="hidden">
              <a class="page-scroll" href="#page-top"></a>
            </li>
<?php
  // iterate through the menu entries to generate the link bar
  $menu = Themes::get(MENU);
  if (is_array($menu)) {
    foreach ($menu as $menu_item) {
      if (is_array($menu_item)) {
        if (isset($menu_item[TITLE]) && isset($menu_item[URI])) {
?>
            <li>
              <a href="<?= html($menu_item[URI]) ?>"><?= html($menu_item[TITLE]) ?></a>
            </li>
<?php
        }
      }
    }
  }
?>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
      </div>
      <!-- /.container -->
    </nav>
