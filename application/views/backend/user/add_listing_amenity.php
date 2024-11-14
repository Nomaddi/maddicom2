<div class="col-lg-offset-2 col-lg-8">
  <div class="row">
    <?php $amenities = $this->crud_model->get_amenities();
    foreach ($amenities->result_array() as $amenity):?>
    <div class="col-lg-4" style="margin-bottom: 10px;">
      <div class="custom-control custom-checkbox">
        <input type="checkbox" onchange="check_amenities_limit(this)" class="custom-control-input" name="amenities[]" id="<?php echo $amenity['id']; ?>" value="<?php echo $amenity['id']; ?>">
        <label class="custom-control-label" for="<?php echo $amenity['id']; ?>"><i class="<?php echo $amenity['icon']; ?>" style="color: #636363;"></i> <?php echo $amenity['name']; ?></label>
      </div>
    </div>
  <?php endforeach; ?>
</div>
</div>


<script type="text/javascript">
  function check_amenities_limit(e){
    if($(e).prop('checked')){
      $(e).addClass('is_checked');
    }else{
      $(e).removeClass('is_checked');
    }

    setTimeout(function(){
      if(<?php echo get_feature_limit("number_of_tags"); ?> >= countElements('is_checked')){
        
      }else{
        $(e).prop('checked', false);
        $(e).removeClass('is_checked');
        error_notify('<?php echo get_phrase("amenity_limit"); ?>. <?php echo get_phrase("upgrade_your_package_for_adding_more_amenities"); ?>');
      }
    }, 100);
  }
</script>
