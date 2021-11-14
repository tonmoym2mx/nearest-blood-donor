<?php include 'inc/header.php'; ?>
<?php
		// Define Variable
		$edonor_name         = '';
		$edonor_number       = '';
		$elatitude           = '';
		$elongitude          = '';
		$edonor_blood_group  = '';

	// For New Data Save
	if( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['new_submit'] ) ){
       $donor_name         = mysqli_real_escape_string( $conn , $_POST[ 'donor_name' ] );
       $donor_number       = mysqli_real_escape_string( $conn , $_POST[ 'donor_number' ] );
       $latitude           = mysqli_real_escape_string( $conn , $_POST[ 'latitude' ] );
       $longitude          = mysqli_real_escape_string( $conn , $_POST[ 'longitude' ] );
       $donor_blood_group  = mysqli_real_escape_string( $conn , $_POST[ 'donor_blood_group' ] );

       $sql = "INSERT INTO donor (donor_name,donor_number,donor_blood_group) VALUES ('$donor_name','$donor_number','$donor_blood_group');";
       $insert_row = $conn->query($sql);
       $sql2 = "INSERT INTO location (donor_id,latitude,longitude) VALUES ('$conn->insert_id','$latitude','$longitude');";
       $insert_row2 = $conn->query($sql2);
    }

    // For data update
    if( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['update_id'] ) ){
       $id                 = mysqli_real_escape_string( $conn , $_POST[ 'update_id' ] );
       $donor_name         = mysqli_real_escape_string( $conn , $_POST[ 'donor_name' ] );
       $donor_number       = mysqli_real_escape_string( $conn , $_POST[ 'donor_number' ] );
       $latitude           = mysqli_real_escape_string( $conn , $_POST[ 'latitude' ] );
       $longitude          = mysqli_real_escape_string( $conn , $_POST[ 'longitude' ] );
       $donor_blood_group  = mysqli_real_escape_string( $conn , $_POST[ 'donor_blood_group' ] );

       $update_sql =  "UPDATE donor SET 
       			donor_name        = '$donor_name',
       			donor_number      = '$donor_number',
       			donor_blood_group = '$donor_blood_group'
       			WHERE donor_id    = '$id'";
       $update_row = $conn->query($update_sql);

       $update_sql2 =  "UPDATE location SET 
       			latitude        = '$latitude',
       			longitude       = '$longitude'
       			WHERE donor_id  = '$id'";
       $update_row2 = $conn->query($update_sql2);
       if( $update_row && $update_row2 ){
       		header('Location:donner-list.php');
       }
    }


    // For Data Delete
    if( isset( $_GET['action'] ) && $_GET['action'] === 'delete'  ){
    	$id = mysqli_real_escape_string( $conn , $_GET[ 'id' ] );
    	$delete_sql = "DELETE donor,location FROM donor 
	    			INNER JOIN location 
					ON donor.donor_id = location.donor_id 
					WHERE donor.donor_id = $id";
		$deleted_row = $conn->query($delete_sql);
		if( $deleted_row ){
       		header('Location:donner-list.php');
       }
    }

    // For Data Edit
    if( isset( $_GET['action'] ) && $_GET['action'] === 'edit'  ){
    	$id = mysqli_real_escape_string( $conn , $_GET[ 'eid' ] );
    	$edit_sql = "SELECT * FROM donor 
				INNER JOIN location 
				ON donor.donor_id = location.donor_id 
				WHERE donor.donor_id = '$id'";
		$all_donor = $conn->query( $edit_sql );
		if( $all_donor ){
			foreach ( $all_donor as $donor ){
				$edonor_name         = $donor['donor_name'];
				$edonor_number       = $donor['donor_number'];
				$elatitude           = $donor['latitude'];
				$elongitude          = $donor['longitude'];
				$edonor_blood_group  = $donor['donor_blood_group'];
			}
		}
    }
?>
    	<div class="card">
    		<div class="card-header">
    			<h3 class="text-center">Nearest Blood donor</h3>
    		</div>
    		<div class="card-body">
    		 <?php 
    			if ( isset( $insert_row ) && !empty( $insert_row ) &&  isset( $insert_row2 ) && !empty( $insert_row2 )) { ?>
    				<div class="alert alert-success alert-dismissible fade show" role="alert">
					  Data Save Successfully!
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
    		 <?php } ?>

    			<div class="row">
    				<div class="col-md-4">
    					<div class="card">
	    					<div class="card-header">
				    			<h6 class="text-center">Add New donor</h6>
				    		</div>
				    		<div class="card-body">
				    			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
								  <div class="mb-3">
								    <label class="form-label">Enter your name</label>
								    <input type="text" name="donor_name" value="<?php echo $edonor_name ? $edonor_name : '';  ?>" class="form-control">
								  </div>
								  <div class="mb-3">
								    <label class="form-label">Enter your number</label>
								    <input type="text" name="donor_number" value="<?php echo $edonor_number ? $edonor_number : '';  ?>"  class="form-control">
								  </div>
								  <div class="mb-3">
								    <label class="form-label">Enter your latitude</label>
								    <input type="text" name="latitude" value="<?php echo $elatitude ? $elatitude : '';  ?>" class="form-control">
								  </div>
								  <div class="mb-3">
								    <label class="form-label">Enter your longitude</label>
								    <input type="text" name="longitude" value="<?php echo $elongitude ? $elongitude : '';  ?>"  class="form-control">
								  </div>
								  <div class="mb-3">
								    <label  class="form-label">Select your blood group </label>
								    <select name="donor_blood_group" class="form-control">
								    	<option <?php echo $edonor_blood_group == "A+" ? "selected" : '';  ?> value="A+">A+</option>
								    	<option <?php echo $edonor_blood_group == "A-" ? "selected" : '';  ?> value="A-">A-</option>
								    	<option <?php echo $edonor_blood_group =="B+" ? "selected" : '';  ?> value="B+">B+</option>
								    	<option <?php echo $edonor_blood_group =="B-" ? "selected" : '';  ?> value="B-">B-</option>
								    	<option <?php echo $edonor_blood_group =="O+" ? "selected" : '';  ?> value="O+">O+</option>
								    	<option <?php echo $edonor_blood_group =="O-" ? "selected" : '';  ?> value="O-">O-</option>
								    	<option <?php echo $edonor_blood_group =="AB+" ? "selected" : '';  ?> value="AB+">AB+</option>
								    	<option <?php echo $edonor_blood_group =="AB-" ? "selected" : '';  ?> value="AB-">AB-</option>
								    	option
								    </select>
								  </div>
								  <?php if( isset( $_GET['action'] ) && $_GET['action'] === 'edit'  ){?>
								  	<input type="hidden" name="update_id" value="<?php echo $_GET['eid']; ?>">
								  	<button type="submit" class="btn btn-primary btn-block">Update</button>
								  <?php }else{?>
								  	<input type="hidden" name="new_submit">
								  	<button type="submit" class="btn btn-primary btn-block">Save</button>
								  <?php } ?>
								  
								</form>
								<?php if( isset( $_GET['action'] ) && $_GET['action'] === 'edit'  ){?>
									<a href="donner-list.php" class="btn btn-danger btn-block mt-2" >Back</a>
								<?php }else{?>
									<a href="index.php" class="btn btn-danger btn-block mt-2" >Back</a>
								<?php } ?>
				    		</div>
			    		</div>
    				</div>
    				<div class="col-md-8">
    					<div class="card">
    						<div class="card-header">
    							<h6>All Blood Donor</h6>
    						</div>
    						<div class="card-body">
    							<table class="table table-striped">
								  <thead>
								    <tr>
								      <th scope="col">#</th>
								      <th scope="col">Name</th>
								      <th scope="col">Number</th>
								      <th scope="col">Blood Group</th>
								      <th scope="col">Latitude</th>
									  <th scope="col">Longitude</th>
								      <th scope="col">Action</th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php 
								  		$sql = "SELECT * FROM donor 
								  				INNER JOIN location 
								  				ON donor.donor_id = location.donor_id 
								  				ORDER BY donor.donor_id DESC;";
								  		$all_donor = $conn->query( $sql );
								  		if( $all_donor ){
								  			$i = 0;
								  			foreach ( $all_donor as $donor ){
								  				$i++;
								  	 ?>
									    <tr>
									      <th><?php echo $i; ?></th>
									      <td><?php echo $donor['donor_name'];?></td>
									      <td><?php echo $donor['donor_number'];?></td>
									      <td style="text-align: center;" ><strong class="badge badge-primary"><?php echo $donor['donor_blood_group'];?></strong></td>
									      <td><?php echo $donor['latitude'];?></td>
										  <td><?php echo $donor['longitude'];?></td>
									      <td>
									      	<a href="?action=edit&eid=<?php echo $donor['donor_id'];?>" class="btn btn-info btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
									      	<a href="?action=delete&id=<?php echo $donor['donor_id'];?>" class="btn btn-danger btn-sm" title="Delete"><i class="fas fa-trash-alt"></i></a>
									      </td>
									    </tr>
									<?php } } ?>
								  </tbody>
								</table>
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