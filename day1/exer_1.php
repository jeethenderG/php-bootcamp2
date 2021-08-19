<?php
function flatten($multiArray): array {
  $result = [];
  foreach($multiArray as $row){
    if (is_array($row))
    {
      $recur = flatten($row);
      $result = array_merge($result,$recur);
    } else
    {
      array_push($result,$row);
    }
  }
  return $result;
}

$matrix= [1,2,[3,4],[5,6,7],8];
$result= flatten($matrix);
foreach ($result as $value){
  echo " $value\n";
}
?>