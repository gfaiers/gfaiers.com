<?php
// function for decrypting
function pkcs7_unpad($data) {
    return substr($data, 0, -ord($data[strlen($data) - 1]));
}

// function for encrypting
function pkcs7_pad($data, $size) {
    $length = $size - strlen($data) % $size;
    return $data . str_repeat(chr($length), $length);
}