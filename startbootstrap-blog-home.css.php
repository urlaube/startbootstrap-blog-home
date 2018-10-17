<?php

  // prevent script from getting called directly
  if (!defined("URLAUBE")) { die(""); }

  // this will be a stylesheet
  header("Content-type: text/css");

?>
/*
 * StartBootstrap-Blog-Home Theme based on:
 *
 * Start Bootstrap - Blog Home (https://github.com/BlackrockDigital/startbootstrap-blog-home/tree/v3.3.7)
 * Copyright (c) 2013-2016 Blackrock Digital LLC.
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap-blog-home/blob/v3.3.7/LICENSE)
*/

body {
  height : 100%;
  width  : 100%;
}

html {
  height : 100%;
  width  : 100%;
}

@media(min-width:767px) {
  .navbar {
    padding            : 20px 0;
    -webkit-transition : background .5s ease-in-out,padding .5s ease-in-out;
    -moz-transition    : background .5s ease-in-out,padding .5s ease-in-out;
    transition         : background .5s ease-in-out,padding .5s ease-in-out;
  }

  .top-nav-collapse {
    padding : 0;
  }
}

.navbar-brand {
  padding     : 5px 15px;
  font-size   : 28px;
  line-height : 38px;
}

.navbar-brand>img {
  height : 40px;
}

.navbar-default {
  background   : <?= html(value(Themes::class, "dark_color")) ?>;
  border-color : <?= html(value(Themes::class, "dark_color")) ?>;
}

.navbar-default .navbar-brand,
.navbar-default .navbar-nav>li>a {
  color : #eeeeee;
}

.navbar-default .navbar-brand:focus,
.navbar-default .navbar-brand:hover,
.navbar-default .navbar-nav>li>a:focus,
.navbar-default .navbar-nav>li>a:hover {
  color : #bbb;
}

.navbar-default .navbar-nav>.active>a,
.navbar-default .navbar-nav>.active>a:focus,
.navbar-default .navbar-nav>.active>a:hover {
  background : <?= html(value(Themes::class, "light_color")) ?>;
  color      : #111111;
}

section h1 a,
section h2 a,
section h3 a,
section h4 a,
section h5 a {
  color       : #000000;
  font-weight : bold;
}

section h1 a:focus,
section h1 a:hover,
section h2 a:focus,
section h2 a:hover,
section h3 a:focus,
section h3 a:hover,
section h4 a:focus,
section h4 a:hover,
section h5 a:focus,
section h5 a:hover {
  color : <?= html(value(Themes::class, "dark_color")) ?>;
}

section img {
  margin : 0 10px 0 10px;
}

section li,
section ol,
section ul {
  margin : 10px 0 10px 0; 
}

section div.panel,
section h1,
section h2,
section h3,
section h4,
section h5,
section p,
section pre,
section ol,
section ul {
  overflow-wrap : break-word;
}

section pre code {
  white-space : pre;
}

section p,
section ol,
section ul {
  display    : block;
  font-size  : 18px;
  text-align : justify;
}

section p a {
  color : <?= html(value(Themes::class, "dark_color")) ?>;
}

section p a:focus,
section p a:hover {
  color : #000000;
}

.content-section {
  padding-bottom : 10px;
  padding-top    : 10px;
}

.empty-section {
  background     : #ffffff;
  padding-bottom : 75px;
  padding-top    : 75px;
}

.float-left {
  float : left;
}

.float-right {
  float : right;
}

.footer-section {
  background     : <?= html(value(Themes::class, "dark_color")) ?> !important;
  color          : #eeeeee !important;
  padding-bottom : 50px !important;
  padding-top    : 50px !important;
}

.footer-section p {
  font-size  : 14px !important;
  text-align : center !important;
}

.footer-section p a {
  color : #337ab7 !important;
}

.hidden-border {
  border-color : transparent;
  box-shadow   : none;
}

.hidden-border div.panel-body {
  padding : 0;
}
