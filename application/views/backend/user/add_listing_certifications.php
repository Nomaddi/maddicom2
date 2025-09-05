<div class="col-lg-offset-2 col-lg-8">
  <div class="row">
    <?php $certs = $this->crud_model->get_certifications();
    foreach ($certs->result_array() as $cert): ?>
      <div class="col-lg-4" style="margin-bottom: 10px;">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input"
                 name="certifications[]" id="cert-<?php echo $cert['id']; ?>"
                 value="<?php echo $cert['id']; ?>">
          <label class="custom-control-label" for="cert-<?php echo $cert['id']; ?>">
            <i class="<?php echo $cert['icon']; ?>" style="color:#636363;"></i> <?php echo $cert['name']; ?>
          </label>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
