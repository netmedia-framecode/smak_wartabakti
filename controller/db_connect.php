<?php
$conn = mysqli_connect("localhost", "root", "", "smak_wartabakti");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
