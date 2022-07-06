<?php 
   if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
	$zipcodes_records = get_option('zipcodes_rec');
	
	if(!empty($zipcodes_records)){
?>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
	<table>
		<tr>
			<th>Title Area</th>
			<th>State</th>
			<th>Postcode</th>
			<th>Section 1</th>
			<th>Section 2</th>
			<th>Section 3</th>
			<th>Section 4</th>
			<th>Section 5</th>
			<th>Section 6</th>
			<th>Section 7</th>
			<th>Section 8</th>
			<th>Section 9</th>
			<th>Section 10 left</th>
			<th>Section 10 middle</th>
			<th>Section 10 right</th>
			<th>Section 11</th>
			<th>Section 12</th>
			<th>Section 13</th>
			<th>Section 14</th>
			<th>Section 15</th>
			<th>Section 16</th>
			<th>Section 17</th>
			<th>Section 18</th>
		</tr>
	<?php foreach($zipcodes_records as $zipcode_record) {
				?>
		<tr>
			<td><?php echo $zipcode_record['Title Area']; ?></td>
			<td><?php echo $zipcode_record['State']; ?></td>
			<td><?php echo $zipcode_record['Postcode']; ?></td>
			<td><?php echo $zipcode_record['Section 1']; ?></td>
			<td><?php echo $zipcode_record['Section 2']; ?></td>
			<td><?php echo $zipcode_record['Section 3']; ?></td>
			<td><?php echo $zipcode_record['Section 4']; ?></td>
			<td><?php echo $zipcode_record['Section 5']; ?></td>
			<td><?php echo $zipcode_record['Section 6']; ?></td>
			<td><?php echo $zipcode_record['Section 7']; ?></td>
			<td><?php echo $zipcode_record['Section 8']; ?></td>
			<td><?php echo $zipcode_record['Section 9']; ?></td>
			<td><?php echo $zipcode_record['Section 10 left']; ?></td>
			<td><?php echo $zipcode_record['Section 10 middle']; ?></td>
			<td><?php echo $zipcode_record['Section 10 right']; ?></td>
			<td><?php echo $zipcode_record['Section 11']; ?></td>
			<td><?php echo $zipcode_record['Section 12']; ?></td>
			<td><?php echo $zipcode_record['Section 13']; ?></td>
			<td><?php echo $zipcode_record['Section 14']; ?></td>
			<td><?php echo $zipcode_record['Section 15']; ?></td>
			<td><?php echo $zipcode_record['Section 16']; ?></td>
			<td><?php echo $zipcode_record['Section 17']; ?></td>
			<td><?php echo $zipcode_record['Section 18']; ?></td>
			
		</tr>
	<?php } ?>
	</table>
<?php } ?>

