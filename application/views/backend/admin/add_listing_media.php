<div class="form-group">
  <label class="col-sm-3 control-label"><?php echo get_phrase('listing_thumbnail'); ?> <br/> <small>(460 X 306)</small> </label>
  <div class="col-sm-7">
    <div class="fileinput fileinput-new" data-provides="fileinput">
      <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
        <img src="<?php echo base_url('uploads/placeholder.png'); ?>" alt="...">
      </div>
      <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
      <div>
        <span class="btn btn-white btn-file">
          <span class="fileinput-new"><?php echo get_phrase('select_image'); ?></span>
          <span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
          <input type="file" name="listing_thumbnail" accept="image/*">
        </span>
        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
      </div>
    </div>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label"><?php echo get_phrase('listing_cover'); ?> <br/> <small>(1600 X 600)</small> </label>
  <div class="col-sm-7">
    <div class="fileinput fileinput-new" data-provides="fileinput">
      <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
        <img src="<?php echo base_url('uploads/placeholder.png'); ?>" alt="...">
      </div>
      <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
      <div>
        <span class="btn btn-white btn-file">
          <span class="fileinput-new"><?php echo get_phrase('select_image'); ?></span>
          <span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
          <input type="file" name="listing_cover" accept="image/*">
        </span>
        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
      </div>
    </div>
  </div>
</div>

<!-- 🔹 FORMULARIO MULTIPLE DE VIDEOS -->
<div class="form-group">
  <label class="col-sm-3 control-label"><?php echo get_phrase('videos'); ?></label>
  <div class="col-sm-7">

    <div id="video_container">
      <div class="video-group mb-2 d-flex align-items-center gap-2">
        <select name="video_provider[]" class="form-control" style="width: 30%;">
          <option value="youtube">YouTube</option>
          <option value="vimeo">Vimeo</option>
          <option value="html5">HTML5</option>
        </select>
        <input type="text" name="video_url[]" class="form-control" placeholder="<?php echo get_phrase('video_url'); ?>" style="width: 65%;">
        <button type="button" class="btn btn-danger btn-sm remove-video"><i class="fa fa-trash"></i></button>
      </div>
    </div>

    <button type="button" id="add_video" class="btn btn-success btn-sm mt-2">
      <i class="fa fa-plus"></i> <?php echo get_phrase('add_another_video'); ?>
    </button>

  </div>
</div>

<script>
  $(document).ready(function(){
    // Agregar nuevo grupo de video
    $('#add_video').on('click', function(){
      $('#video_container').append(`
        <div class="video-group mb-2 d-flex align-items-center gap-2">
          <select name="video_provider[]" class="form-control" style="width: 30%;">
            <option value="youtube">YouTube</option>
            <option value="vimeo">Vimeo</option>
            <option value="html5">HTML5</option>
          </select>
          <input type="text" name="video_url[]" class="form-control" placeholder="<?php echo get_phrase('video_url'); ?>" style="width: 65%;">
          <button type="button" class="btn btn-danger btn-sm remove-video"><i class="fa fa-trash"></i></button>
        </div>
      `);
    });

    // Eliminar grupo
    $(document).on('click', '.remove-video', function(){
      $(this).closest('.video-group').remove();
    });
  });
</script>


<div class="form-group">
  <label class="col-sm-3 control-label" for="listing_images"><?php echo get_phrase('listing_gallery_images'); ?><br/> <small>(960 X 640)</small> </label>
  <div class="col-sm-7">
    <div id="photos_area">
      <div class="row">
        <div class="col-sm-7">
          <div class="form-group">
            <div class="col-sm-12">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
                  <img src="<?php echo base_url('uploads/placeholder.png'); ?>" alt="...">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                <div>
                  <span class="btn btn-white btn-file">
                    <span class="fileinput-new"><?php echo get_phrase('select_image'); ?></span>
                    <span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
                    <input type="file" name="listing_images[]" accept="image/*">
                  </span>
                  <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <button type="button" class="btn btn-primary btn-sm" style="margin-top: 2px; float: right;" name="button" onclick="appendPhotoUploader()"> <i class="fa fa-plus"></i> </button>
        </div>
      </div>
    </div>
    <div id="blank_photo_uploader">
      <div class="row appendedPhotoUploader">
        <div class="col-sm-7">
          <div class="form-group">
            <div class="col-sm-12">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
                  <img src="<?php echo base_url('uploads/placeholder.png'); ?>" alt="...">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                <div>
                  <span class="btn btn-white btn-file">
                    <span class="fileinput-new"><?php echo get_phrase('select_image'); ?></span>
                    <span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
                    <input type="file" name="listing_images[]" accept="image/*">
                  </span>
                  <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <button type="button" class="btn btn-danger btn-sm" style="margin-top: 2px; float: right;" name="button" onclick="removePhotoUploader(this)"> <i class="fa fa-minus"></i> </button>
        </div>
      </div>
    </div>
  </div>
</div>
