<?php
if(!defined('attached_with_index')){
  header("location: /index.php");
}
  include "./database/server.php";
  if(!isset($_SESSION) || !$_SESSION['role']=="receiver"){
    header("location:/BloodBank/index.php?page=login_as_receiver"); 
}
?>

<?php if(count($requests_array)>0){ ?>
  <div class="table-responsive container mt-4" style="min-height: 80vh;">
    <table class="table table-bordered table-light table-striped caption-top table-hover">
      <caption class="text-center">List of Requests Made</caption>
      <thead class="table-dark">
        <th scope="col">S.No</th>
        <th scope="col">Hospital Name</th>
        <th scope="col">Blood Group</th>
        <th scope="col">Quantity</th>
        <th scope="col">Status</th>
        <th scope="col">Remarks</th>
      </thead>
      <tbody>
              <?php for ($i=0; $i < count($requests_array); $i++) { ?>
                <tr>
                    <!-- <th scope="row">1</th> -->
                    <td><?php echo $i+1 ?></td>
                    <td><?php echo $hospitals_array[$i]['hospital_name'] ?></td>
                    <td><?php echo $requests_array[$i]['blood_type'] ?></td>
                    <td><?php echo $requests_array[$i]['quantity'] ?></td>
                    <td><?php echo $requests_array[$i]['status'] ?></td>
                    <td><?php echo $requests_array[$i]['message'] ?></td>
                </tr>
              <?php } ?>
            </tbody>
        </table>
    </div>
<?php }else{ ?>
  <div class="table-responsive container mt-4" style="min-height: 80vh;">
    <p class="text-center">No Requests made till date.</p>
  </div>
<?php }?>