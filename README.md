# StartBootstrap-Blog-Home theme
The StartBootstrap-Blog-Home theme is a multi-page theme for [Urlaube](https://github.com/urlaube/urlaube) that is based on the [Blog-Home theme](https://github.com/BlackrockDigital/startbootstrap-blog-home/tree/v3.3.7) created by [Start Bootstrap](https://startbootstrap.com/).

## Installation
Place the folder containing the theme into your themes directory located at `./user/themes/`.
Finally, add the following line to your configuration file located at `./user/config/config.php` to select the theme:
```
Config::THEMENAME("startbootstrap-blog-home");
```

## Configuration
To configure the theme you can change the corresponding settings in your configuration file located at `./user/config/config.php`.

### Colors
You can set the following values to change the color scheme of the theme:
```
Config::THEME("dark_color",  "#666");
Config::THEME("light_color", "#ccc");
```

### Logo image file
You can set the following value to choose an image file as a logo:
```
Config::THEME(LOGO, null);
```

### Copyright text
You can set the following values to change the copyright text in the footer area. You can either choose auto-escaped text by setting `COPYRIGHT` or you can choose HTML by setting `"COPYRIGHT_HTML"`:
```
Config::THEME(COPYRIGHT, "Copyright &copy; ".Main::SITENAME()." ".date("Y"));
```
```
Config::THEME("COPYRIGHT_HTML", null);
```

### Canonical URL
You can overwrite the auto-generated canonical URL:
```
Config::THEME(CANONICAL, Main::URI());
```

### Charset
You can overwrite the auto-generated charset:
```
Config::THEME(CHARSET, strtolower(Main::CHARSET()));
```

### Description
You can overwrite the auto-generated description:
```
Config::THEME(DESCRIPTION, static::getDefaultDescription());
```

### Keywords
You can overwrite the auto-generated keywords:
```
Config::THEME(KEYWORDS, static::getDefaultKeywords());
```

### Language
You can overwrite the auto-generated language:
```
Config::THEME(LANGUAGE, static::getDefaultLanguage());
```

### Menu
You can set the content of the site's menu:
```
Config::THEME(MENU, null);
```

The menu content has to be set as an array containing associative arrays for each element:
```
Config::THEME(MENU, array(array(TITLE => "Linktext",   URI => "https://example.com/"),
                          array(TITLE => "Linktext 2", URI => "https://example.net/")));
```

### Pagename
You can set the pagename text shown at the top of the page as the headline:
```
Config::THEME(PAGENAME,    static::getDefaultPagename());
```

### Timeformat
You can set the time format used to display the DATE value of the content:
```
Config::THEME(TIMEFORMAT, "d.m.Y");
```

The value specified here has to be supported by PHP's [date()](http://php.net/manual/en/function.date.php) function.

### Title
You can overwrite the auto-generated title:
```
Config::THEME(TITLE, static::getDefaultTitle());
```

