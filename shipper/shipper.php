<?php
    session_start();
    require_once('shipper_function.php');
    // Set Variables for featured products
    $featuredProductsNames = array();
    $featuredProducts = readFeaturedProducts();
    $featuredProductsCount = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="shipper.css">
    <title>Document</title>
</head>
<body>
<form action='' method='post'>
    <table class="orders">
        <tr>
            <th>ID</th>
            <th>Products</th>
            <th>Status
                <input type="hidden" name='status[]' value="status">
            </th>
        </tr>
        <?php

            foreach ($featuredProducts as $featuredProduct) {
                $id = $featuredProduct['id'];
                $products = $featuredProduct['products'];
                $status = $featuredProduct['status'];
            if($status == "Active"){
             echo "
                
                <tr>
                    <th>$id</th>
                    <th>$products</th>
                    <th><select name='status[]'>
                        <option value='Active' selected='selected'>Active</option>
                        <option value='Ordered'>Ordered</option>
                        <option value='Dilivered'>Dilivered</option>
                    </select>
                    </th>
                </tr>
                
                ";
                $featuredProductsCount++;
                if ($featuredProductsCount == 15) {
                    break;
                }         
            }}
            ?>
    
    </table>
    <button class="form_button" type="submit" name="submit" >Submit</button>
</form>
<?php
    if(isset($_POST['submit'])){
    $input = fopen('../data/order2.csv', 'r');  //open for reading
    $output = fopen('../data/temporary.csv', 'a'); //open for writing
    $new_status= $_POST['status'];
    $count = 0;
    while( false !== ( $data = fgetcsv($input) ) ){  //read each line as an array
       //modify data here
       if ($new_status[$count] != $data[6] && $new_status[$count] != 'status'){
          //Replace line here
          $data[6] = $new_status[$count];
       }
       $count++;
       //write modified data to new file
       fputcsv( $output, $data);
    }
    echo "good";
    //close both files
    fclose( $input );
    fclose( $output );
    
    //clean up
    unlink('../data/order2.csv');// Delete obsolete BD
    rename('../data/temporary.csv', '../data/order2.csv'); 
}
?>
</body>
</html>