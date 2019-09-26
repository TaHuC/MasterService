<head>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>


</head>

<?php

$random = substr( md5(rand()), 0, 7);
$finalRandom = date('Ymd H i s')."".$random;
echo $finalRandom.'<br>';
    echo strtoupper(str_replace(" ", "", $finalRandom));