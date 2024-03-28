<?php  if (count($errors) > 0) : ?>
<div class="error d-flex justify-content-center gap-2">
  	<?php foreach ($errors as $error) : ?>
  	  <p class="text-danger text-center m-0"><?php echo $error." " ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>