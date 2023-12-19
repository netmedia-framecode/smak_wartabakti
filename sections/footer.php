<div class="footer">
  <p>Copyright © <?= date("Y") ?> <a href="https://netmedia-framecode.com" target="_blank">Netmedia Framecode, Ltd</a>. All Rights Reserved.
    <br>Develop by: Elijeo M. Sesar Sarmento
  </p>
</div>
</section>

<!-- Scripts -->
<!-- Bootstrap core JavaScript -->
<script src="<?= $baseURL ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= $baseURL ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?= $baseURL ?>assets/js/isotope.min.js"></script>
<script src="<?= $baseURL ?>assets/js/owl-carousel.js"></script>
<script src="<?= $baseURL ?>assets/js/lightbox.js"></script>
<script src="<?= $baseURL ?>assets/js/tabs.js"></script>
<script src="<?= $baseURL ?>assets/js/video.js"></script>
<script src="<?= $baseURL ?>assets/js/slick-slider.js"></script>
<script src="<?= $baseURL ?>assets/js/custom.js"></script>
<script src="<?= $baseURL ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Page level custom scripts -->
<script src="<?= $baseURL ?>assets/js/demo/datatables-demo.js"></script>
<script>
  //according to loftblog tut
  $('.nav li:first').addClass('active');

  var showSection = function showSection(section, isAnimate) {
    var
      direction = section.replace(/#/, ''),
      reqSection = $('.section').filter('[data-section="' + direction + '"]'),
      reqSectionPos = reqSection.offset().top - 0;

    if (isAnimate) {
      $('body, html').animate({
          scrollTop: reqSectionPos
        },
        800);
    } else {
      $('body, html').scrollTop(reqSectionPos);
    }

  };

  var checkSection = function checkSection() {
    $('.section').each(function() {
      var
        $this = $(this),
        topEdge = $this.offset().top - 80,
        bottomEdge = topEdge + $this.height(),
        wScroll = $(window).scrollTop();
      if (topEdge < wScroll && bottomEdge > wScroll) {
        var
          currentId = $this.data('section'),
          reqLink = $('a').filter('[href*=\\#' + currentId + ']');
        reqLink.closest('li').addClass('active').
        siblings().removeClass('active');
      }
    });
  };

  $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function(e) {
    e.preventDefault();
    showSection($(this).attr('href'), true);
  });

  $(window).scroll(function() {
    checkSection();
  });
</script>

<script>
  const showMessage = (type, title, message) => {
    if (message) {
      Swal.fire({
        icon: type,
        title: title,
        text: message,
      });
    }
  };

  showMessage("success", "Berhasil Terkirim", $(".message-success").data("message-success"));
  showMessage("info", "For your information", $(".message-info").data("message-info"));
  showMessage("warning", "Peringatan!!", $(".message-warning").data("message-warning"));
  showMessage("error", "Kesalahan", $(".message-danger").data("message-danger"));
</script>