<?php

$number= readline("Enter the phone number:");
$maskingCharacter = '*';
echo substr($number, 0, 2) . str_repeat($maskingCharacter, strlen($number) - 4) . substr($number, -2);
?>
