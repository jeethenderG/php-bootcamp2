<?php

function GetMaxAge($ages){
    $max =0;
    foreach ( $ages as $age){
        if ($age > $max){
            $max=$age;
        }
    }
    return $max;
}
$json= "{\"players\":[{\"name\":\"Ganguly\",\"age\":45,\"address\":{\"city\":\"Hyderabad\"}},
        {\"name\":\"Dravid\",\"age\":45,\"address\":{\"city\":\"Bangalore\"}},
        {\"name\":\"Dhoni\",\"age\":37,\"address\":{\"city\":\"Mumbai\"}},
        {\"name\":\"Virat\",\"age\":35,\"address\":{\"city\":\"Delhi\"}},
        {\"name\":\"Jadeja\",\"age\":35,\"address\":{\"city\":\"Ranchi\"}},
        {\"name\":\"Jadeja\",\"age\":35,\"address\":{\"city\":\"Punjab\"}}]}";


$multipleArray = json_decode($json,true);

$names =[];
$ages  =[];
$cities =[];
$unique_names =[];
$maxAge_names =[];

foreach ( $multipleArray["players"] as $arr){
    $names[] = $arr["name"];
    $ages[]  =  $arr["age"];
    $cities[]  = $arr["address"]["city"];
}

$unique_names = array_unique($names);

$max = GetmaxAge($ages);

for ($i=0;$i< count($ages);$i++){
    if ($ages[$i]==$max){
        $maxAge_names[]= $names[$i];
    }
}

echo "Names: ";
foreach ( $names as $name){
    echo "$name",",";
}

echo "\nAge: ";
foreach ( $ages as $age){
    echo "$age",",";
}

echo "\nCities: ";
foreach ( $cities as $city){
    echo "$city",",";
}

echo "\nUnique Names: ";
foreach ( $unique_names as $name){
    echo "$name",",";
}

echo "\nmax age Names: ";
foreach ( $maxAge_names as $name){
    echo "$name",",";
}

?>