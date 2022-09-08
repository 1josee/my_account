<?php

function readFeaturedProducts() {
  //This function read all the featured store lines by lines
  $fp = '../data/order2.csv';
  $file = fopen($fp, 'r');
  $data = fgetcsv($file);
  $products = [];
  while ($row = fgetcsv($file)) {
    $i = 0;
    $product = [];
    foreach ($data as $colName) {
      $product[$colName] =  $row[$i];
      $i++;
    }
      $products[] = $product;
  }
  return $products;
}




?>