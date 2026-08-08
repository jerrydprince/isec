<?php
$conn = ftp_connect("isecltd.ng");
if(!$conn) die("Failed to connect");
if(@ftp_login($conn, "isecltd1_jerry", "Hephzibah2016.")) echo "SUCCESS\n";
else echo "FAIL\n";
ftp_close($conn);
