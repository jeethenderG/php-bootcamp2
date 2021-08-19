<?php

function Snake_caseToCamelCase($string){

    $chars = explode("_",$string);
    $str = $chars[0];
    foreach($chars as $i => $value){
        if ($i == 0) continue;
        $str = $str . ucfirst($value);
    }
    return $str;
}


$array_limit = readline("Enter the limit of array:");
$strings=[];

for ($i=0;$i<$array_limit;$i++){
    $strings[] = readline();
}
$stringsCamelcase=[];
foreach ( $strings as $string){
    $stringsCamelcase[]= Snake_caseToCamelCase($string);
}

foreach ($stringsCamelcase as $str){
    echo "$str \n";
}

?>
