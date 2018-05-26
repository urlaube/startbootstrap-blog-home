<?php

  /**
    This is the StartBootstrap-Blog-Home theme.

    This file contains the theme class of the StartBootstrap-Blog-Home theme.

    @package urlaube\startbootstrap-blog-home
    @version 0.1a0
    @author  Yahe <hello@yahe.sh>
    @since   0.1a0
  */

  // ===== DO NOT EDIT HERE =====

  // prevent script from getting called directly
  if (!defined("URLAUBE")) { die(""); }

  if (!class_exists("StartBootstrapBlogHome")) {
    class StartBootstrapBlogHome implements Handler, Theme {

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

      protected static function configureCSS() {
        Themes::preset("dark_color",  "#666");
        Themes::preset("light_color", "#ccc");
      }

      protected static function configureTheme() {
        // static
        Themes::preset(LOGO,       null);
        Themes::preset(MENU,       array());
        Themes::preset(TIMEFORMAT, "d.m.Y");

        // individual static
        Themes::preset("COPYRIGHT_HTML", null);

        // derived
        Themes::preset(CANONICAL,   Main::URI());
        Themes::preset(CHARSET,     strtolower(Main::CHARSET()));
        Themes::preset(COPYRIGHT,   "Copyright &copy; ".Main::SITENAME()." ".date("Y"));
        Themes::preset(DESCRIPTION, static::getDefaultDescription());
        Themes::preset(KEYWORDS,    static::getDefaultKeywords());
        Themes::preset(LANGUAGE,    static::getDefaultLanguage());
        Themes::preset(PAGENAME,    static::getDefaultPagename());
        Themes::preset(TITLE,       static::getDefaultTitle());
      }

      protected static function doBody() {
        // call the before-body plugins
        Plugins::run(BEFORE_BODY);

        require_once(__DIR__.DS."body.php");

        // call the after-body plugins
        Plugins::run(AFTER_BODY);
      }

      protected static function doCSS() {
        require_once(__DIR__.DS."startbootstrap-blog-home.css.php");
      }

      protected static function doFooter() {
        // call the before-footer plugins
        Plugins::run(BEFORE_FOOTER);

        require_once(__DIR__.DS."footer.php");

        // call the after-footer plugins
        Plugins::run(AFTER_FOOTER);
      }

      protected static function doHead() {
        // call the before-head plugins
        Plugins::run(BEFORE_HEAD);

        require_once(__DIR__.DS."head.php");

        // call the after-head plugins
        Plugins::run(AFTER_HEAD);
      }

      protected static function getDefaultDescription() {
        $result = null;

        // get the first entry of the content entries
        if (0 < count(Main::CONTENT())) {
          if (Main::CONTENT()[0]->isset(CONTENT)) {
            // remove all HTML tags and replace line breaks with spaces
            $result = substr(strtr(strip_tags(Main::CONTENT()[0]->get(CONTENT)),
                                   array("\r\n" => " ", "\n" => " ", "\r" => " ")),
                             0, 300);
          }
        }

        return $result;
      }

      protected static function getDefaultKeywords() {
        $result = null;

        // retrieve all words from the titles
        $words = array();
        foreach (Main::CONTENT() as $content_item) {
          if ($content_item->isset(TITLE)) {
            $words = array_merge($words, explode(" ", $content_item->get(TITLE)));
          }
        }

        // filter all words that do not fit the scheme
        for ($index = count($words)-1; $index >= 0; $index--) {
          if (1 !== preg_match("@^[0-9A-Za-z\-]+$@", $words[$index])) {
            unset($words[$index]);
          }
        }

        $result = implode(", ", $words);

        return $result;
      }

      protected static function getDefaultLanguage() {
        $result = strtolower(Translations::LANGUAGE());

        // only take the first part if the language is of the form "ab_xy"
        if (1 === preg_match("@^([a-z]+)\_[a-z]+$@", $result, $matches)) {
          if (2 === count($matches)) {
            $result = $matches[1];
          }
        }

        return $result;
      }

      protected static function getDefaultPagename() {
        $result = null;

        // convert the PAGEINFO to a pagename
        if ("ArchiveHandler" === Handlers::ACTIVE()) {
          $result = "Archiv: ";
          if (isset(Main::PAGEINFO()[DAY])) {
            $result .= "Tag ".Main::PAGEINFO()[DAY].", ";
          }
          if (isset(Main::PAGEINFO()[MONTH])) {
            $result .= "Monat ".Main::PAGEINFO()[MONTH].", ";
          }
          $result .= "Jahr ".Main::PAGEINFO()[YEAR];
        }
        if ("AuthorHandler" === Handlers::ACTIVE()) {
          $result = "Autor: ".Main::PAGEINFO()[AUTHOR];
        }
        if ("CategoryHandler" === Handlers::ACTIVE()) {
          $result = "Kategorie: ".Main::PAGEINFO()[CATEGORY];
        }
        if ("SearchGetHandler" === Handlers::ACTIVE()) {
          $result = "Suche: ".implode(SP, Main::PAGEINFO()[SEARCH]);
        }

        return $result;
      }

      protected static function getDefaultTitle() {
        $result = Main::SITESLOGAN()." | ".Main::SITENAME();

        if (null !== Themes::get(PAGENAME)) {
          $result = Themes::get(PAGENAME)." | ".$result;
        } else {
          // handle errors and pages
          if (("ErrorHandler" === Handlers::ACTIVE()) ||
              ("PageHandler" === Handlers::ACTIVE())) {
            // get the first entry of the content entries
            if (0 < count(Main::CONTENT())) {
              if (Main::CONTENT()[0]->isset(TITLE)) {
                $result = Main::CONTENT()[0]->get(TITLE)." | ".$result;
              }
            }
          }
        }

        return $result;
      }

      // SOURCECODE HELPER FUNCTION

      public static function get($key, $name) {
        $result = null;

        if (array_key_exists($key, Main::CONTENT())) {
          if (Main::CONTENT()[$key]->isset($name)) {
            $result = Main::CONTENT()[$key]->get($name);
          }
        }

        return $result;
      }

      public static function getLogo() {
        // retrieve site title
        $result = html(Main::SITENAME());

        // use an image as logo
        if (null !== Themes::get(LOGO)) {
          $result = "<img src=\"".html(Themes::get(LOGO))."\" alt=\"".$result."\">";
        }

        return $result;
      }

      public static function isset($key, $name) {
        $result = false;

        if (array_key_exists($key, Main::CONTENT())) {
          $result = Main::CONTENT()[$key]->isset($name);
        }

        return $result;
      }

      // RUNTIME FUNCTIONS

      public static function css() {
        // preset CSS file configuration
        static::configureCSS();

        // generate the CSS file output
        static::doCSS();

        return true;
      }

      public static function theme() {
        $result = false;

        // we don't handle empty content
        if (null !== Main::CONTENT()) {
          // make sure that we only handle arrays
          if (Main::CONTENT() instanceof Content) {
            Main::CONTENT(array(Main::CONTENT()));
          }

          // preset theme configuration
          static::configureTheme();

          // generate the output
          static::doHead();
          static::doBody();
          static::doFooter();

          $result = true;
        }

        return $result;
      }

    }

    // register handlers
    Handlers::register("StartBootstrapBlogHome", "css",
                       "@^\/startbootstrap\-blog\-home\.css$@",
                       [GET], BEFORE_ADDSLASH);

    // register theme
    Themes::register("StartBootstrapBlogHome", "theme", "startbootstrap-blog-home");
  }

