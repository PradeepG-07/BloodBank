<?php
    include "./database/server.php";
    if(!defined('attached_with_index')){
      header("location: /BloodBank/index.php");
    }

    // TODO: VERIFY ALL THE FILES IN COMPARISON TO BLOOD BANK FOLDER AVAILABLE IN DOWNALOADS
    // MAKE CHANGES HERE AND WRITE UP COMMENTS AND UPLOAD IT TO GITHUB.
    $blood_samples_array=array();
    $hospitals_array=array();

    $bloodsamples_check_query="SELECT * from bloodsamples";
    $bloodsamples_result=mysqli_query($conn,$bloodsamples_check_query);
    while($row = mysqli_fetch_assoc($bloodsamples_result)){
        $curr_sample_id=$row['sample_id'];
        $hospital_name_query="SELECT hospital_name,contact_number from hospitals WHERE hospital_id IN (SELECT hospital_id from bloodsamples WHERE sample_id='$curr_sample_id')";
        $hospital_name_result=mysqli_query($conn,$hospital_name_query);
        while($row1 = mysqli_fetch_assoc($hospital_name_result)){
            $hospitals_array[]=$row1;
        }
        $blood_samples_array[]=$row;
    }


?>

<?php if(count($blood_samples_array)>0){ ?>
  <div class="table-responsive container mt-4" style="min-height: 80vh;">
    <table class="table table-bordered table-light table-striped caption-top table-hover align-middle">
      <caption class="text-center">List of Available Blood Samples Information</caption>
      <thead class="table-dark">
        <th scope="col">S.No</th>
        <th scope="col">Hospital Name</th>
        <th scope="col">Blood Group</th>
        <th scope="col">Available Quantity</th>
        <th scope="col">Contact Number</th>
        <th scope="col">Actions</th>
      </thead>
      <tbody>
              <?php for ($i=0; $i < count($blood_samples_array); $i++) { ?>
                <tr>
                    <td><?php echo $i+1 ?></td>
                    <td><?php echo $hospitals_array[$i]['hospital_name'] ?></td>
                    <td><?php echo $blood_samples_array[$i]['blood_type'] ?></td>
                    <td><?php echo $blood_samples_array[$i]['quantity'] ?></td>
                    <td><?php echo $hospitals_array[$i]['contact_number'] ?></td>
                    <td>
                      <button class="btn btn-success"><a class="text-decoration-none text-light me-auto" href="/BloodBank/components/make_request.php?sample_id=<?php echo $blood_samples_array[$i]['sample_id']?>">Request Sample</a></button>
                    </td>
                </tr>
              <?php } ?>
            </tbody>
        </table>
    </div>
<?php }else{ ?>
  <div class="table-responsive container mt-4" style="min-height: 80vh;">
    <p class="text-center">No Blood Samples available.</p>
  </div>
<?php }?>