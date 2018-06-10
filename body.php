<?php

  // prevent script from getting called directly
  if (!defined("URLAUBE")) { die(""); }

?>
    <!-- Empty Section so that no menu entry is active when scrolling to the top -->
    <section id="empty" class="empty-section">
    </section>
<?php
  if (null !== Themes::get(PAGENAME)) {
?>
    <div class="container">
      <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-lg-12">
          <!-- Content Section containing the header text -->
          <section id="header-text" class="header-section">
            <h1 class="page-header">
              <?= html(Themes::get(PAGENAME)) ?>
            </h1>
          </section>
        </div>
      </div>
    </div>
<?php
  }
?>
    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
<?php
  // iterate through the content entries
  $index = 0;
  foreach (Main::CONTENT() as $content_item) {
    $index++;

    $author  = $content_item->get(AUTHOR);
    $content = $content_item->get(CONTENT).NL;
    $title   = $content_item->get(TITLE);

    // get the category string and covert it into an array
    $category = null;
    $catvalue = $content_item->get(CATEGORY);
    if (is_string($catvalue)) {
      $catvalue = explode(SP, $catvalue);
      foreach ($catvalue as $catvalue_item) {
        // make sure that only valid characters are contained
        if (1 === preg_match("@^[0-9A-Za-z\_\-]+$@", $catvalue_item)) {
          if (null === $category) {
            $category = array();
          }

          // add category as lowercase string
          $category[] = strtolower($catvalue_item);
        }
      }

      // remove duplicates
      $category = array_unique($category);

      // sort the categories
      sort($category);
    }

    // get the date and make sure that only parsable dates are displayed
    $date = null;
    $time = $content_item->get(DATE);
    if (is_string($time)) {
      $time = strtotime($time);
      if (false !== $time) {
        $date = date(Themes::get(TIMEFORMAT), $time);
        $time = getdate($time);
      }
    }

    // link the headline only when it's not an error or a single page single page
    $uri = null;
    if ((ERROR_HANDLER !== Handlers::ACTIVE()) &&
        (PAGE_HANDLER !== Handlers::ACTIVE())) {
      $uri = $content_item->get(URI);
    }
?>
          <!-- <?= html($title); ?> Section -->
          <section id="section-<?= html($index) ?>" class="content-section">
            <h2>
<?php
    if (null !== $uri) {
?>
              <a href="<?= html($uri) ?>">
<?php
    }
?>
                <?= html($title.NL) ?>
<?php
    if (null !== $uri) {
?>
              </a>
<?php
    }
?>
            </h2>
<?php
    if ((null !== $author) || (null !== $category) || (null !== $date)) {
?>
            <p>
<?php
      if (null !== $date) {
        $link = ArchiveHandler::getUri(array(DAY   => $time["mday"],
                                             MONTH => $time["mon"],
                                             YEAR  => $time["year"],
                                             PAGE  => 1));
?>
              <span class="glyphicon glyphicon-time"></span>
              <a href="<?= html($link) ?>"><?= html($date) ?></a>
<?php
      }
      if (null !== $author) {
        $link = AuthorHandler::getUri(array(AUTHOR => $author,
                                            PAGE   => 1));
?>
              <span class="glyphicon glyphicon-user"></span>
              <a href="<?= html($link) ?>"><?= html($author) ?></a>
<?php
      }
      if (null !== $category) {
?>
              <span class="glyphicon glyphicon-tag"></span>
<?php
        foreach ($category as $category_item) {
          $link = CategoryHandler::getUri(array(CATEGORY => $category_item,
                                                PAGE     => 1));
?>
              <a href="<?= html($link) ?>"><?= html($category_item) ?></a>
<?php
        }
      }
?>
            </p>
<?php
    }
?>
<?= $content ?>
          </section>
          <hr>
<?php
  }

  // check if pagination is needed
  if (1 < Main::PAGEMAX()) {
    $first = firstpage();
    $last  = lastpage();
    $next  = nextpage();
    $prev  = prevpage();
?>
          <!-- Pager -->
          <nav class="text-center">
            <ul class="pagination pagination-lg">
              <li class="<?= (null === $first) ? "disabled" : "" ?>">
                <a href="<?= html($first) ?>">|&laquo;</a>
              </li>
              <li class="<?= (null === $prev) ? "disabled" : "" ?>">
                <a href="<?= html($prev) ?>">&laquo;</a>
              </li>
              <li class="disabled">
                <a href="<?= html(curpage()) ?>"><?= html(Main::PAGENUMBER()) ?></a>
              </li>
              <li class="<?= (null === $next) ? "disabled" : "" ?>">
                <a href="<?= html($next) ?>">&raquo;</a>
              </li>
              <li class="<?= (null === $last) ? "disabled" : "" ?>">
                <a href="<?= html($last) ?>">&raquo;|</a>
              </li>
            </ul>
          </nav>
<?php
  }
?>
        </div>
<?php
  // execute widget plugins and check that some have returned
  $widgets = widgets();
  if (is_array($widgets) && (0 < count($widgets))) {
?>
        <!-- Sidebar Content -->
        <div class="container">
          <div class="row">
            <div class="col-md-4">
<?php
    // iterate through the content entries
    foreach ($widgets as $widgets_item) {
      if ($widgets_item instanceof Content) {
        $title   = $widgets_item->get(TITLE);
        $content = $widgets_item->get(CONTENT).NL;
?>
              <div class="well">
                <h4><?= html($title) ?></h4>
<?= $content ?>
              </div>
<?php
      }
    }
?>
            </div>
          </div>
        </div>
<?php
  }
?>
      </div>
    </div>
