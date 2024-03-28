<?php
     if(!defined('attached_with_index')){
      header("location: /index.php");
    }
  if(!isset($_SESSION) || !$_SESSION['role']=="hospital"){
    header("location:/BloodBank/index.php?page=login_as_hospital"); 
  }
  include "./database/server.php";
?>

<?php if(count($requests_array)>0){ ?>
  <div class="table-responsive container mt-4" style="min-height: 80vh;">
    <table class="table table-bordered table-light table-striped caption-top table-hover align-middle">
      <caption class="text-center">List of Requests Received</caption>
      <thead class="table-dark">
        <th scope="col">S.No</th>
        <th scope="col">Receiver Name</th>
        <th scope="col">Blood Group</th>
        <th scope="col">Requested Quantity</th>
        <th scope="col">Available Quantity</th>
        <th scope="col">Status</th>
        <th scope="col">Actions</th>
        <th scope="col">Remarks</th>
      </thead>
      <tbody>
              <?php for ($i=0; $i < count($requests_array); $i++) { ?>
                <tr>
                    <td><?php echo $i+1 ?></td>
                    <td><?php echo $users_array[$i]['fullname'] ?></td>
                    <td><?php echo $requests_array[$i]['blood_type'] ?></td>
                    <td><?php echo $requests_array[$i]['quantity'] ?></td>
                    <td><?php echo $available_samples_array[$requests_array[$i]['sample_id']]?></td>
                    <td><?php echo $requests_array[$i]['status'] ?></td>
                    <td class="d-flex flex-wrap gap-2 justify-content-center">
                        <?php if($requests_array[$i]['status']=='pending'){ ?>
                            <a class="text-decoration-none bg-success p-1 rounded text-light me-auto" href="./database/accept.php?request_id=<?php echo $requests_array[$i]['request_id']?>&quantity=<?php echo $requests_array[$i]['quantity']?>">Accept</a>
                            <a class="text-decoration-none bg-danger p-1 rounded text-light" href="./database/reject.php?request_id=<?php echo $requests_array[$i]['request_id']?>">Reject</a>
                        <?php }else { echo "-"; }?>
                    </td>
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