<html>

<head>
  <title>403 Forbidden</title>
</head>

<body>
  <center>
    <h1>403 Forbidden</h1>
  </center>
  <hr>
  <center>Apache2.4 (<?php $userAgent = $_SERVER['HTTP_USER_AGENT'];

                      if (strpos($userAgent, 'Windows') !== false) {
                        echo "Windows";
                      } elseif (strpos($userAgent, 'Linux') !== false) {
                        echo "Linux";
                      } elseif (strpos($userAgent, 'Macintosh') !== false || strpos($userAgent, 'Mac OS') !== false) {
                        echo "macOS";
                      } else {
                        echo "Tidak dapat mendeteksi sistem operasi.";
                      } ?>)</center>
</body>

</html>