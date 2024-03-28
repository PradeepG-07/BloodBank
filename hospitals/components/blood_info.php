<?php  
if(!defined('attached_with_index')){
    header("location: /index.php");
}
 if(!isset($_SESSION) || !$_SESSION['role']=="hospital"){
    header("location:/BloodBank/index.php?page=login_as_hospital"); 
}
    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
   if(!preg_match("/hospitals\/index\.php\?page=blood_info/",$actual_link)){
    header("location:/BloodBank/hospitals/index.php/?page=blood_info");
   }
    include "./database/server.php";
?>

<div class="table-responsive container mt-4" style="min-height: 80vh;">
  <div class="d-flex justify-content-between align-items-center mb-3">
      <h5>Details of Available Blood Info</h5>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_blood_info">
      Add Blood Info
      </button>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="add_blood_info" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form class="p-2 needs-validation" action="./database/add_blood_info.php" method="POST" autocomplete="on"  novalidate>
          <div class="modal-content">
          <div class="modal-header">
              <h1 class="modal-title fs-5" id="title">Add Blood Info</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label for="blood_type" class="form-label">Blood Group</label>
                  <select class="form-select border border-dark" aria-label="blood_type" id="blood_type" name="blood_type" required>
                      <option value="A+">A+</option>
                      <option value="B+">B+</option>
                      <option value="AB+">AB+</option>
                      <option value="O+">O+</option>
                      <optBon value="O-">O-</optBon>
                      <option value="A-">A-</option>
                      <option value="B-">B-</option>
                      <option value="AB-">AB-</option>
                  </select>
              </div>
              <div class="mb-3">
                  <label for="quantity" class="form-label">Quantity</label>
                  <input type="number" class="form-control border border-dark" id="quantity" name="quantity" required>
                  <div class="valid-feedback">
                      Looks good!
                  </div>
                  <div class="invalid-feedback">
                      Please provide valid quantity
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="add_blood_info">Add</button>
          </div>
          </div>
      </form>
  </div>
  </div>
<?php if(count($blood_samples_array)>0){ ?>
    <table class="table table-bordered table-light table-striped table-hover align-middle">
      <thead class="table-dark">
        <th scope="col">S.No</th>
        <th scope="col">Blood Group</th>
        <th scope="col">Available Quantity</th>
        <th scope="col">Actions</th>
      </thead>
      <tbody>
              <?php for ($i=0; $i < count($blood_samples_array); $i++) { ?>
                <tr>
                    <td><?php echo $i+1 ?></td>
                    <td><?php echo $blood_samples_array[$i]['blood_type'] ?></td>
                    <td><?php echo $blood_samples_array[$i]['quantity'] ?></td>
                    <td>
                        <a class="text-decoration-none bg-info p-1 rounded text-light p-1" href="./components/edit_blood_info.php?sample_id=<?php echo $blood_samples_array[$i]['sample_id']?>">Update</a>
                    </td>
                </tr>
              <?php } ?>
            </tbody>
        </table>
    </div>
<?php }else{ ?>
  <div class="table-responsive container mt-4" style="min-height: 80vh;">
    <p class="text-center">No Blood Info added till date.</p>
  </div>
<?php }?>
