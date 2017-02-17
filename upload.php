<?php
if (isset($_FILES['myFile'])) {
    $newName = random_string(40);
    $origName = $_FILES['myFile']['name'];
    $origName = str_replace('-', '', $origName); // remove dash
    move_uploaded_file($_FILES['myFile']['tmp_name'], "uploads/" . $newName.'-'.$origName);
    exit;
}

function random_string($length = 12, $characters='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
    $token = "";
    for($i=0;$i<$length;$i++){
        $token .= $characters[crypto_rand_secure(0,strlen($characters))];
    }
    return $token;
}

function crypto_rand_secure($min, $max) {
    $range = $max - $min;
    if ($range < 0) return $min; // not so random...
    $log = log($range, 2);
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
}