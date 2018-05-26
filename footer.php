<?php

  // prevent script from getting called directly
  if (!defined("URLAUBE")) { die(""); }

?>
    <!-- Footer Section -->
    <section id="footer" class="footer-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <p>
<?php
  // output COPYRIGHT_HTML if it is set or COPYRIGHT otherwise
  if (null !== Themes::get("COPYRIGHT_HTML")) {
    print(Themes::get("COPYRIGHT_HTML").NL);
  } else {
    print(html(Themes::get(COPYRIGHT)).NL);
  }
?>
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- jQuery -->
    <script src="<?= html(path2uri(__DIR__."/js/jquery.js")) ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= html(path2uri(__DIR__."/js/bootstrap.min.js")) ?>"></script>

    <!-- Blog Home JavaScript -->
    <script src="<?= html(path2uri(__DIR__."/js/jquery.easing.min.js")) ?>"></script>
    <script src="<?= html(path2uri(__DIR__."/js/blog-home.js")) ?>"></script>
  </body>
</html>
