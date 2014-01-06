
<?php
echo "SELECT ((ACOS(SIN(22.7195687 * 3.14 / 180) * SIN(`lat` * 3.14 / 180) + COS(22.7195687 * 3.14 / 180) * COS(`lat` * 3.14 / 180) * COS((75.85772580000003 -`lng`) * 3.14 / 180)) * 180 / 3.14) * 60 * 1.1515) AS distance FROM `wp_userlatlong` HAVING distance<=10 ORDER BY distance ASC";
