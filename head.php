<?php

  // prevent script from getting called directly
  if (!defined("URLAUBE")) { die(""); }

?>
<!DOCTYPE html>
<html lang="<?= html(value(Themes::class, LANGUAGE)) ?>">
  <head>
    <meta charset="<?= html(value(Themes::class, CHARSET)) ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<?php
  if (null !== value(Themes::class, AUTHOR)) {
?>
    <meta name="author" content="<?= html(value(Themes::class, AUTHOR)) ?>">
<?php
  }
?>
    <meta name="description" content="<?= html(value(Themes::class, DESCRIPTION)) ?>">
    <meta name="keywords" content="<?= html(value(Themes::class, KEYWORDS)) ?>">

<?php
  $feeduri = feeduri();
  if (null !== $feeduri) {
?>
    <link rel="alternate" type="application/rss+xml" href="<?= html($feeduri) ?>" />
<?php
  }
  if (null !== value(Themes::class, CANONICAL)) {
?>
    <link rel="canonical" href="<?= html(value(Themes::class, CANONICAL)) ?>">
<?php
  }
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
  if (null !== value(Themes::class, FAVICON)) {
?>
    <link rel="shortcut icon" type="image/x-icon" href="<?= html(value(Themes::class, FAVICON)) ?>">
<?php
  }
?>

    <title><?= html(value(Themes::class, TITLE)) ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= html(path2uri(__DIR__."/css/bootstrap.min.css")) ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= html(static::getUri(new Content())) ?>" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="<?= html(path2uri(__DIR__."/js/html5shiv.min.js")) ?>"></script>
      <script src="<?= html(path2uri(__DIR__."/js/respond.min.js")) ?>"></script>
    <![endif]-->
  </head>

  <body id="page-top" data-target=".navbar-fixed-top">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?= html(value(Main::class, ROOTURI)) ?>">
<?php
  if (null !== value(Themes::class, LOGO)) {
?>
            <img src="<?= html(value(Themes::class, LOGO)) ?>" alt="<?= html(value(Themes::class, SITENAME)) ?>">
<?php
  } else {
?>
            <?= html(value(Themes::class, SITENAME).NL) ?>
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
              <a href="#page-top"></a>
            </li>
<?php
  // iterate through the menu entries to generate the link bar
  $menu = value(Themes::class, MENU);
  if (is_array($menu)) {
    foreach ($menu as $menu_item) {
      if (is_array($menu_item)) {
        if (isset($menu_item[TITLE]) && isset($menu_item[URI])) {
          // set active menu item
          $liclass = "";
          if (0 === strcmp($menu_item[URI], value(Main::class, URI))) {
            $liclass = SP."class=\"active\"";
          }
?>
            <li<?= $liclass ?>>
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
