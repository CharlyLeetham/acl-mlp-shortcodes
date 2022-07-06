<?php 
    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
	
if(isset($_POST['import_zipcodes'])){

  // File extension
  $extension = pathinfo($_FILES['import_file']['name'], PATHINFO_EXTENSION);

  // If file extension is 'csv'
  if(!empty($_FILES['import_file']['name']) && $extension == 'csv'){

    $totalInserted = 0;

    // Open file in read mode
    $csvFile = fopen($_FILES['import_file']['tmp_name'], 'r');

   $header = fgetcsv($csvFile); // Skipping header row
  
	$zipcodeResult = array();
    // Read file
    while(($csvData = fgetcsv($csvFile)) !== FALSE){
		$csvData = array_map("utf8_encode", $csvData);
		// Row column length
		$dataLen = count($csvData);
		$zipcode = $csvData[5];
		$zipcodeResult[$zipcode] = array_combine($header, $csvData);
    }
	$add_zipcodes_rec = update_option('zipcodes_rec',$zipcodeResult);
	if($add_zipcodes_rec){
		echo "<h3 style='color: green;'>Records Updated</h3>";
	}


  }else{
    echo "<h3 style='color: red;'>Invalid Extension</h3>";
  }

}
?>


<h2>Please upload CSV </h2>
<!-- Form -->
<form method='post' action='<?= $_SERVER['REQUEST_URI']; ?>' enctype='multipart/form-data'>
  <input type="file" name="import_file" >
  <input type="submit" name="import_zipcodes" value="Import">
</form>