<?php

  /**
    This is the StartBootstrap-Blog-Home theme.

    This file contains the theme class of the StartBootstrap-Blog-Home theme.

    @package urlaube\startbootstrap-blog-home
    @version 0.1a2
    @author  Yahe <hello@yahe.sh>
    @since   0.1a0
  */

  // ===== DO NOT EDIT HERE =====

  // prevent script from getting called directly
  if (!defined("URLAUBE")) { die(""); }

  if (!class_exists("StartBootstrapBlogHome")) {
    class StartBootstrapBlogHome extends Translatable implements Handler, Theme, Translation {

      // INTERFACE FUNCTIONS

      public static function getContent($info) {
        return null;
      }

      public static function getUri($info) {
        return null;
      }

      public static function parseUri($uri) {
        return null;
      }

      // HELPER FUNCTIONS

      protected function configureCSS() {
        Themes::preset("dark_color",  "#666");
        Themes::preset("light_color", "#ccc");
      }

      protected function configureTheme() {
        // static
        Themes::preset(FAVICON,    null);
        Themes::preset(LOGO,       null);
        Themes::preset(MENU,       null);
        Themes::preset(TIMEFORMAT, "d.m.Y");

        // individual static
        Themes::preset("COPYRIGHT_HTML", null);

        // derived
        Themes::preset(AUTHOR,      $this->getDefaultAuthor());
        Themes::preset(CANONICAL,   $this->getDefaultCanonical());
        Themes::preset(CHARSET,     $this->getDefaultCharset());
        Themes::preset(COPYRIGHT,   $this->getDefaultCopyright());
        Themes::preset(DESCRIPTION, $this->getDefaultDescription());
        Themes::preset(KEYWORDS,    $this->getDefaultKeywords());
        Themes::preset(LANGUAGE,    $this->getDefaultLanguage());
        Themes::preset(PAGENAME,    $this->getDefaultPagename());
        Themes::preset(TITLE,       $this->getDefaultTitle());
      }

      protected function doBody() {
        // call the before-body plugins
        Plugins::run(BEFORE_BODY);

        require_once(__DIR__.DS."body.php");

        // call the after-body plugins
        Plugins::run(AFTER_BODY);
      }

      protected function doCSS() {
        require_once(__DIR__.DS."startbootstrap-blog-home.css.php");
      }

      protected function doFooter() {
        // call the before-footer plugins
        Plugins::run(BEFORE_FOOTER);

        require_once(__DIR__.DS."footer.php");

        // call the after-footer plugins
        Plugins::run(AFTER_FOOTER);
      }

      protected function doHead() {
        // call the before-head plugins
        Plugins::run(BEFORE_HEAD);

        require_once(__DIR__.DS."head.php");

        // call the after-head plugins
        Plugins::run(AFTER_HEAD);
      }

      protected function getDefaultAuthor() {
        $result = null;

        // try to retrieve the first author
        foreach (Main::CONTENT() as $content_item) {
          if ($content_item->isset(AUTHOR)) {
            $result = $content_item->get(AUTHOR);
            break;
          }
        }

        return $result;
      }

      protected function getDefaultCanonical() {
        return Main::URI();
      }

      protected function getDefaultCharset() {
        return strtolower(Main::CHARSET());
      }

      protected function getDefaultCopyright() {
        return "Copyright &copy;".SP.Main::SITENAME().SP.date("Y");
      }

      protected function getDefaultDescription() {
        $result = null;

        // get the first entry of the content entries
        if (0 < count(Main::CONTENT())) {
          if (Main::CONTENT()[0]->isset(CONTENT)) {
            // remove all HTML tags and replace line breaks with spaces
            $result = substr(strtr(strip_tags(Main::CONTENT()[0]->get(CONTENT)),
                                   array("\r\n" => SP, "\n" => SP, "\r" => SP)),
                             0, 300);
          }
        }

        return $result;
      }

      protected function getDefaultKeywords() {
        $result = null;

        // retrieve all words from the titles
        $words = array();
        foreach (Main::CONTENT() as $content_item) {
          if ($content_item->isset(TITLE)) {
            $words = array_merge($words, explode(SP, $content_item->get(TITLE)));
          }
        }

        // filter all words that do not fit the scheme
        for ($index = count($words)-1; $index >= 0; $index--) {
          if (1 !== preg_match("@^[0-9A-Za-z\-]+$@", $words[$index])) {
            unset($words[$index]);
          }
        }

        $result = implode(",".SP, $words);

        return $result;
      }

      protected function getDefaultLanguage() {
        $result = strtolower(Translations::LANGUAGE());

        // only take the first part if the language is of the form "ab_xy"
        if (1 === preg_match("@^([a-z]+)\_[a-z]+$@", $result, $matches)) {
          if (2 === count($matches)) {
            $result = $matches[1];
          }
        }

        return $result;
      }

      protected function getDefaultPagename() {
        $result = null;

        // convert the PAGEINFO to a pagename
        if ("ArchiveHandler" === Handlers::ACTIVE()) {
          $result = gl("Archiv").":".SP;
          if (isset(Main::PAGEINFO()[DAY])) {
            $result .= gl("Tag").SP.Main::PAGEINFO()[DAY].",".SP;
          }
          if (isset(Main::PAGEINFO()[MONTH])) {
            $result .= gl("Monat").SP.Main::PAGEINFO()[MONTH].",".SP;
          }
          $result .= gl("Jahr").SP.Main::PAGEINFO()[YEAR];
        }
        if ("AuthorHandler" === Handlers::ACTIVE()) {
          $result = gl("Autor").":".SP.Main::PAGEINFO()[AUTHOR];
        }
        if ("CategoryHandler" === Handlers::ACTIVE()) {
          $result = gl("Kategorie").":".SP.Main::PAGEINFO()[CATEGORY];
        }
        if ("SearchGetHandler" === Handlers::ACTIVE()) {
          $result = gl("Suche").":".SP.implode(SP, Main::PAGEINFO()[SEARCH]);
        }

        return $result;
      }

      protected function getDefaultTitle() {
        $result = Main::SITESLOGAN().SP."|".SP.Main::SITENAME();

        if (null !== Themes::get(PAGENAME)) {
          $result = Themes::get(PAGENAME).SP."|".SP.$result;
        } else {
          // handle errors and pages
          if (("ErrorHandler" === Handlers::ACTIVE()) ||
              ("PageHandler" === Handlers::ACTIVE())) {
            // get the first entry of the content entries
            if (0 < count(Main::CONTENT())) {
              if (Main::CONTENT()[0]->isset(TITLE)) {
                $result = Main::CONTENT()[0]->get(TITLE).SP."|".SP.$result;
              }
            }
          }
        }

        return $result;
      }

      // RUNTIME FUNCTIONS

      public function css() {
        // preset CSS file configuration
        $this->configureCSS();

        // generate the CSS file output
        $this->doCSS();

        return true;
      }

      public function theme() {
        $result = false;

        // we don't handle empty content
        if (null !== Main::CONTENT()) {
          // make sure that we only handle arrays
          if (Main::CONTENT() instanceof Content) {
            Main::CONTENT(array(Main::CONTENT()));
          }

          // preset theme configuration
          $this->configureTheme();

          // generate the output
          $this->doHead();
          $this->doBody();
          $this->doFooter();

          $result = true;
        }

        return $result;
      }

    }

    // instantiate translatable theme
    $theme = new StartbootstrapBlogHome();
    $theme->setTranslationsPath(__DIR__.DS."lang".DS);

    // register handlers
    Handlers::register($theme, "css",
                       "@^\/startbootstrap\-blog\-home\.css$@",
                       [GET], BEFORE_ADDSLASH);

    // register theme
    Themes::register($theme, "theme", "startbootstrap-blog-home");
  }

