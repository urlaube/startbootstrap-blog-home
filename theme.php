<?php

  /**
    This is the StartBootstrap-Blog-Home theme.

    This file contains the theme class of the StartBootstrap-Blog-Home theme.

    @package urlaube\startbootstrap-blog-home
    @version 0.5a4
    @author  Yahe <hello@yahe.sh>
    @since   0.1a0
  */

  // ===== DO NOT EDIT HERE =====

  // prevent script from getting called directly
  if (!defined("URLAUBE")) { die(""); }

  class StartBootstrapBlogHome extends BaseSingleton implements Handler, Theme {

    // CONSTANTS

    const REGEX = "~^\/startbootstrap\-blog\-home\.css$~";

    // INTERFACE FUNCTIONS

    public static function getContent($metadata, &$pagecount) {
      return null;
    }

    public static function getUri($metadata) {
      return value(Main::class, ROOTURI)."startbootstrap-blog-home.css";
    }

    public static function parseUri($uri) {
      $result = null;

      $metadata = preparecontent(parseuri($uri, static::REGEX));
      if ($metadata instanceof Content) {
        $result = $metadata;
      }

      return $result;
    }

    // HELPER FUNCTIONS

    protected static function configureHandler() {
      Themes::preset(CSS,           "");
      Themes::preset("dark_color",  "#666");
      Themes::preset("light_color", "#ccc");
    }

    protected static function configureTheme() {
      // individual theme configuration
      Themes::preset("copyright_html", null);

      // recommended theme configuration
      Themes::preset(AUTHOR,      static::getDefaultAuthor());
      Themes::preset(CANONICAL,   static::getDefaultCanonical());
      Themes::preset(CHARSET,     static::getDefaultCharset());
      Themes::preset(COPYRIGHT,   static::getDefaultCopyright());
      Themes::preset(DESCRIPTION, static::getDefaultDescription());
      Themes::preset(FAVICON,     null);
      Themes::preset(KEYWORDS,    static::getDefaultKeywords());
      Themes::preset(LANGUAGE,    static::getDefaultLanguage());
      Themes::preset(LOGO,        null);
      Themes::preset(MENU,        null);
      Themes::preset(PAGENAME,    static::getDefaultPagename());
      Themes::preset(SITENAME,    t("Deine Webseite", static::class));
      Themes::preset(SITESLOGAN,  t("Dein Slogan", static::class));
      Themes::preset(TIMEFORMAT,  "d.m.Y");
      Themes::preset(TITLE,       static::getDefaultTitle());
    }

    protected static function getDefaultAuthor() {
      $result = null;

      // try to retrieve the first author
      foreach (value(Main::class, CONTENT) as $content_item) {
        if ($content_item->isset(AUTHOR)) {
          $result = value($content_item, AUTHOR);
          break;
        }
      }

      return $result;
    }

    protected static function getDefaultCanonical() {
      $result = null;

      // do not set a canonical URI on error
      if (ErrorHandler::class !== Handlers::getActive()) {
        $result = value(Main::class, URI);
      }

      return $result;
    }

    protected static function getDefaultCharset() {
      return strtolower(value(Main::class, CHARSET));
    }

    protected static function getDefaultCopyright() {
      return "Copyright &copy;".SP.value(Themes::class, SITENAME).SP.date("Y");
    }

    protected static function getDefaultDescription() {
      $result = null;

      // get the first entry of the content entries
      if (0 < count(value(Main::class, CONTENT))) {
        if (value(Main::class, CONTENT)[0]->isset(CONTENT)) {
          // remove all HTML tags and replace line breaks with spaces
          $result = substr(strtr(strip_tags(value(value(Main::class, CONTENT)[0], CONTENT)),
                                 ["\r\n" => SP, "\n" => SP, "\r" => SP]),
                           0, 300);
        }
      }

      return $result;
    }

    protected static function getDefaultKeywords() {
      $result = null;

      // retrieve all words from the titles
      $words = [];
      foreach (value(Main::class, CONTENT) as $content_item) {
        if ($content_item->isset(TITLE)) {
          $words = array_merge($words, explode(SP, value($content_item, TITLE)));
        }
      }

      // filter all words that do not fit the scheme
      for ($index = count($words)-1; $index >= 0; $index--) {
        if (1 !== preg_match("~^[0-9A-Za-z\-]+$~", $words[$index])) {
          unset($words[$index]);
        }
      }

      $result = implode(DP.SP, $words);

      return $result;
    }

    protected static function getDefaultLanguage() {
      $result = strtolower(value(Main::class, LANGUAGE));

      // only take the first part if the language is of the form "ab_xy"
      if (1 === preg_match("~^([a-z]+)\_[a-z]+$~", $result, $matches)) {
        if (2 === count($matches)) {
          $result = $matches[1];
        }
      }

      return $result;
    }

    protected static function getDefaultPagename() {
      $result = null;

      // convert the METADATA to a pagename
      $metadata = value(Main::class, METADATA);
      if ($metadata instanceof Content) {
        switch (Handlers::getActive()) {
          case ArchiveHandler::class:
            if ((null !== value($metadata, ArchiveHandler::DAY)) ||
                (null !== value($metadata, ArchiveHandler::MONTH)) ||
                (null !== value($metadata, ArchiveHandler::YEAR))) {
              $result = t("Archiv", StartBootstrapBlogHome::class).COL.SP;

              $parts = [];
              if (null !== value($metadata, ArchiveHandler::DAY)) {
                $parts[] .= t("Tag", StartBootstrapBlogHome::class).SP.value($metadata, ArchiveHandler::DAY);
              }
              if (null !== value($metadata, ArchiveHandler::MONTH)) {
                $parts[] .= t("Monat", StartBootstrapBlogHome::class).SP.value($metadata, ArchiveHandler::MONTH);
              }
              if (null !== value($metadata, ArchiveHandler::YEAR)) {
                $parts[] .= t("Jahr", StartBootstrapBlogHome::class).SP.value($metadata, ArchiveHandler::YEAR);
              }

              $result .= implode(DP.SP, $parts);
            }
            break;

          case AuthorHandler::class:
            $result = t("Autor", StartBootstrapBlogHome::class).COL.SP.value($metadata, AUTHOR);
            break;

          case CategoryHandler::class:
            $result = t("Kategorie", StartBootstrapBlogHome::class).COL.SP.value($metadata, CATEGORY);
            break;

          case SearchHandler::class:
            $result = t("Suche", StartBootstrapBlogHome::class).COL.SP.strtr(value($metadata, SEARCH), DOT, SP);
            break;
        }
      }

      return $result;
    }

    protected static function getDefaultTitle() {
      $result = value(Themes::class, SITENAME).SP."-".SP.value(Themes::class, SITESLOGAN);

      if (null !== value(Themes::class, PAGENAME)) {
        $result = value(Themes::class, PAGENAME).SP."|".SP.$result;
      } else {
        // handle errors and pages
        if ((ErrorHandler::class === Handlers::getActive()) ||
            (PageHandler::class === Handlers::getActive())) {
          // get the first entry of the content entries
          if (0 < count(value(Main::class, CONTENT))) {
            if (value(Main::class, CONTENT)[0]->isset(TITLE)) {
              $result = value(value(Main::class, CONTENT)[0], TITLE).SP."|".SP.$result;
            }
          }
        }
      }

      return $result;
    }

    // RUNTIME FUNCTIONS

    public static function handler() {
     $result = false;

      // only proceed when this is the active theme
      if (0 === strcasecmp(static::class, value(Main::class, THEMENAME))) {
        $metadata = static::parseUri(relativeuri());
        if (null !== $metadata) {
          // check if the URI is correct
          $fixed = static::getUri($metadata);
          if (0 !== strcmp(value(Main::class, URI), $fixed)) {
            relocate($fixed.querystring(), false, true);
          } else {
            // preset handler configuration
            static::configureHandler();

            // generate the CSS file output
            require_once(__DIR__.DS."startbootstrap-blog-home.css.php");
          }

          // we handled this page
          $result = true;
        }
      }

      return $result;
    }

    public static function theme() {
      $result = false;

      // we do not handle empty content
      $content = preparecontent(value(Main::class, CONTENT));
      if (null !== $content) {
        // make sure that we only handle arrays
        if ($content instanceof Content) {
          Main::set(CONTENT, [$content]);
        }

        // preset theme configuration
        static::configureTheme();

        // generate the head output
        Plugins::run(BEFORE_HEAD);
        require_once(__DIR__.DS."head.php");
        Plugins::run(AFTER_HEAD);

        // generate the body output
        Plugins::run(BEFORE_BODY);
        require_once(__DIR__.DS."body.php");
        Plugins::run(AFTER_BODY);

        // generate the footer output
        Plugins::run(BEFORE_FOOTER);
        require_once(__DIR__.DS."footer.php");
        Plugins::run(AFTER_FOOTER);

        // we handled this page
        $result = true;
      }

      return $result;
    }

  }

  // register handler
  Handlers::register(StartBootstrapBlogHome::class, "handler", StartBootstrapBlogHome::REGEX, [GET], ADDSLASH);

  // register theme
  Themes::register(StartBootstrapBlogHome::class, "theme", StartBootstrapBlogHome::class);

  // register translation
  Translate::register(__DIR__.DS."lang".DS, StartBootstrapBlogHome::class);
