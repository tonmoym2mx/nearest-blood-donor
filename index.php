<?php include 'inc/header.php'; ?>
<?php
	$search_result = [];
	$error_message = '';

	// For Search 
	if( $_SERVER['REQUEST_METHOD'] === 'POST' ){

	   $latitude           = mysqli_real_escape_string( $conn , $_POST[ 'latitude' ] );
       $longitude          = mysqli_real_escape_string( $conn , $_POST[ 'longitude' ] );
       $blood_group        = mysqli_real_escape_string( $conn , $_POST[ 'blood_group' ] );
       if( empty($latitude) && empty( $longitude ) && empty( $blood_group ) ){
       	$error_message = '<p class="text-danger">Please fill the all input!</p>';
       }else{
	       $search_sql = "SELECT *,distance_between($latitude, $longitude ,location.latitude,location.longitude) as distance FROM donor INNER JOIN location ON donor.donor_id = location.donor_id WHERE donor.donor_blood_group='$blood_group' HAVING distance < 10 ORDER BY distance"; // 10 is Maximum Distance;
	       $search_result = $conn->query( $search_sql );
	  }
	}
?>
<div class="card">
	<div class="card-header">
		<h3 class="text-center">Nearest Blood Donor</h3>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
		    			<h6 class="text-center">Search donor</h6>
		    		</div>
		    		<div class="card-body">
		    			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" >
						  <div class="mb-3">
						    <label  class="form-label">Enter your latitude</label>
						    <input type="text" name="latitude" class="form-control">
						  </div>
						  <div class="mb-3">
						    <label  class="form-label">Enter your longitude </label>
						    <input type="text" name="longitude" class="form-control">
						  </div>
						  <div class="mb-3">
						    <label  class="form-label">Select blood group </label>
						    <select name="blood_group" class="form-control">
						    	<option value="A+">A+</option>
						    	<option value="A-">A-</option>
						    	<option value="B+">B+</option>
						    	<option value="B-">B-</option>
						    	<option value="O+">O+</option>
						    	<option value="O-">O-</option>
						    	<option value="AB+">AB+</option>
						    	<option value="AB-">AB-</option>
						    	option
						    </select>
						  </div>
						  <button type="submit" class="btn btn-primary btn-block">Search</button>
						  <?php echo $error_message ? $error_message : ''; ?>
						</form>
						<div class="mt-3">
							<a href="donner-list.php" class="btn btn-success btn-block" >Donor List</a>
						</div>
		    		</div>
	    		</div>
			</div>
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<h6>Your nearest donor</h6>
					</div>
					<div class="card-body">
						<?php if( !empty($search_result) && $search_result->num_rows > 0){ ?>
						<table class="table table-striped">
						  <thead>
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Name</th>
						      <th scope="col">Blood Group</th>
						      <th scope="col">Distance</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>
						  	<?php
					  			$i=0;
					  			foreach ( $search_result as $value ){
					  				$i++;
						  	?>
						    <tr>
						      <th><?php echo $i; ?></th>
						      <td><?php echo $value['donor_name']; ?></td>
						      <td><strong><?php echo $value['donor_blood_group']; ?></strong></td>
						      <td><?php printf("%.1f", $value['distance'] ) ?> km</td>
						      <td>
						      	<a href="callto:<?php echo $value['donor_number']; ?>" title="Call Now!" class="btn btn-success btn-sm"><i class="fas fa-phone"></i></a>
						      	<a href="SMSTO:<?php echo $value['donor_number']; ?>:Emergency needs your blood!" title="Message" class="btn btn-danger btn-sm"><i class="far fa-envelope"></i></a>
						      </td>
						    </tr>
							<?php }?>
						  </tbody>
						</table>
					<?php }else{ echo '<p class="text-center">Result Not Found!</p>'; }  ?>
					</div>	
				</div>
			</div>
		</div>
	</div>
	<div class="card-footer">
		<p class="text-center" >Design and develop by <strong>Team-3</strong></p>
	</div>
</div>
<?php include 'inc/footer.php'; ?>