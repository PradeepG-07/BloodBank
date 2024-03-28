<?php
    if(!defined('attached_with_index')){
        header("location: /BloodBank/index.php");
    }
?>
<div class="container mt-4">
  <h1 class="text-center text-success">SIGNUP AS RECEIVER</h1>
  <?php
    include './database/errors.php';
    include './database/success.php';
  ?>
  <form class="p-2 needs-validation" action="<?php echo $_SERVER['PHP_SELF'].'?page=signup_as_receiver'; ?>" method="POST" autocomplete="on"  novalidate>
  <div class="mb-3">
    <label for="fullname" class="form-label">FullName</label>
    <input type="text" class="form-control border border-dark" id="fullname" name="fullname" minlength="3" required>
    <div class="valid-feedback">
      Looks good!
    </div>
    <div class="invalid-feedback">
      Please provide full name
    </div>
  </div>
  <div class="mb-3">
    <label for="blood_group" class="form-label">Blood Group</label>
    <select class="form-select border border-dark" aria-label="blood_group" id="blood_group" name="blood_group" required>
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
    <label for="contact_number" class="form-label">Contact Number</label>
    <input type="phone" class="form-control border border-dark" id="contact_number" placeholder="9999999999" minlength="10" maxlength="10" name="contact_number" required>
    <div class="valid-feedback">
      Looks good!
    </div>
    <div class="invalid-feedback">
      Please provide a valid contact number
    </div>
  </div>
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control border border-dark" id="username" name="username" required>
    <div class="valid-feedback">
      Looks good!
    </div>
    <div class="invalid-feedback">
      Please select username
    </div>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control border border-dark" id="email" aria-describedby="emailHelp" placeholder="name@email.com" name="email" required>
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    <div class="valid-feedback">
      Looks good!
    </div>
    <div class="invalid-feedback">
      Please provide valid email address
    </div>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label" >Password</label>
    <input type="password" class="form-control border border-dark" id="password" name="password" required>
    <div class="valid-feedback">
      Looks good!
    </div>
    <div class="invalid-feedback">
      Please choose a password
    </div>
  </div>
  <div class="mb-3">
    <label for="confirm_password" class="form-label">Confirm Password</label>
    <input type="password" class="form-control border border-dark" id="confirm_password" name="confirm_password" required>
    <div class="valid-feedback">
      Looks good!
    </div>
    <div class="invalid-feedback">
      Please recheck the password
    </div>
  </div>
  <div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <textarea class="form-control border border-dark" id="address" name="address" rows="3" required></textarea>
    <div class="valid-feedback">
      Looks good!
    </div>
    <div class="invalid-feedback">
      Please provide address
    </div>
  </div>
  <button type="submit" class="btn btn-primary" id="signup_as_receiver" name="signup_as_receiver">Signup</button>
</form>
</div>