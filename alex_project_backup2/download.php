<?php
$file = $_GET['file'];
$filename = 'upload/'.$_GET['file'];
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="'. $filename.'"');
header('Content-Transfer-Encoding: binary');
header('Content-Length:'.filesize($filename));
header('Accept-Ranges:bytes');
readfile($filename);
exit;
?>



         
