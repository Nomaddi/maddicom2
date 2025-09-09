<?php $listing_certifications = json_decode($listing_details['certifications'] ?? '[]', true); ?>
<div class="col-lg-offset-2 col-lg-8">
  <div class="row">
    <?php $certs = $this->crud_model->get_certifications();
    foreach ($certs->result_array() as $cert): 
      $has_image = !empty($cert['image']) && file_exists(FCPATH.'uploads/certifications/'.$cert['image']);
    ?>
      <div class="col-lg-4" style="margin-bottom: 10px;">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input"
                 name="certifications[]" id="cert-<?php echo $cert['id']; ?>"
                 value="<?php echo $cert['id']; ?>"
                 <?php echo in_array($cert['id'], (array)$listing_certifications) ? 'checked' : ''; ?>>
          <label class="custom-control-label" for="cert-<?php echo $cert['id']; ?>">
            <?php if ($has_image): ?>
              <img src="<?= base_url('uploads/certifications/'.$cert['image']); ?>"
                   alt="<?= html_escape($cert['name']); ?>"
                   style="height:25px;width:auto;vertical-align:middle;margin-right:5px;">
            <?php elseif (!empty($cert['icon'])): ?>
              <i class="<?= html_escape($cert['icon']); ?>" style="color:#636363;margin-right:5px;"></i>
            <?php endif; ?>
            <?= html_escape($cert['name']); ?>
          </label>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
