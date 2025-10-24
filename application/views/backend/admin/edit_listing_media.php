<!-- LISTING THUMBNAIL -->
<div class="form-group">
  <label class="col-sm-3 control-label"><?php echo get_phrase('listing_thumbnail'); ?> <br/> <small>(460 X 306)</small> </label>
  <div class="col-sm-7">
    <div class="fileinput fileinput-new" data-provides="fileinput">
      <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
        <?php 
        // Detectar si listing_thumbnail es URL completa o nombre de archivo
        $thumbnail = $listing_details['listing_thumbnail'];
        $is_thumbnail_url = (strpos($thumbnail, 'http://') === 0 || strpos($thumbnail, 'https://') === 0);
        $thumbnail_src = $is_thumbnail_url ? $thumbnail : base_url('uploads/listing_thumbnails/'.$thumbnail);
        ?>
        <img src="<?php echo $thumbnail_src; ?>" alt="...">
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

<!-- LISTING COVER -->
<div class="form-group">
  <label class="col-sm-3 control-label"><?php echo get_phrase('listing_cover'); ?> <br/> <small>(1600 X 600)</small> </label>
  <div class="col-sm-7">
    <div class="fileinput fileinput-new" data-provides="fileinput">
      <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
        <?php 
        // Detectar si listing_cover es URL completa o nombre de archivo
        $cover = $listing_details['listing_cover'];
        $is_cover_url = (strpos($cover, 'http://') === 0 || strpos($cover, 'https://') === 0);
        $cover_src = $is_cover_url ? $cover : base_url('uploads/listing_cover_photo/'.$cover);
        ?>
        <img src="<?php echo $cover_src; ?>" alt="...">
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

<!-- VIDEO PROVIDER Y VIDEO URL (sin cambios) -->
<!-- 🔹 FORMULARIO MULTIPLE DE VIDEOS -->
<?php
// Obtiene los videos almacenados en la tabla (JSON)
$videos = [];
if (!empty($listing_details['videos'])) {
    $videos = json_decode($listing_details['videos'], true);
}

// Compatibilidad con registros antiguos (solo 1 video)
if (empty($videos) && !empty($listing_details['video_url'])) {
    $videos[] = [
        'provider' => $listing_details['video_provider'],
        'url' => $listing_details['video_url']
    ];
}
?>

<div class="form-group">
  <label class="col-sm-3 control-label"><?php echo get_phrase('videos'); ?></label>
  <div class="col-sm-7">

    <div id="video_container">
      <?php if (!empty($videos)): ?>
        <?php foreach ($videos as $video): ?>
          <div class="video-group mb-2 d-flex align-items-center gap-2">
            <select name="video_provider[]" class="form-control" style="width: 30%;">
              <option value="youtube" <?php echo ($video['provider'] == 'youtube') ? 'selected' : ''; ?>>YouTube</option>
              <option value="vimeo" <?php echo ($video['provider'] == 'vimeo') ? 'selected' : ''; ?>>Vimeo</option>
              <option value="html5" <?php echo ($video['provider'] == 'html5') ? 'selected' : ''; ?>>HTML5</option>
            </select>
            <input type="text" name="video_url[]" value="<?php echo htmlspecialchars($video['url']); ?>" class="form-control" placeholder="<?php echo get_phrase('video_url'); ?>" style="width: 65%;">
            <button type="button" class="btn btn-danger btn-sm remove-video"><i class="fa fa-trash"></i></button>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Campo vacío por defecto -->
        <div class="video-group mb-2 d-flex align-items-center gap-2">
          <select name="video_provider[]" class="form-control" style="width: 30%;">
            <option value="youtube">YouTube</option>
            <option value="vimeo">Vimeo</option>
            <option value="html5">HTML5</option>
          </select>
          <input type="text" name="video_url[]" class="form-control" placeholder="<?php echo get_phrase('video_url'); ?>" style="width: 65%;">
          <button type="button" class="btn btn-danger btn-sm remove-video"><i class="fa fa-trash"></i></button>
        </div>
      <?php endif; ?>
    </div>

    <button type="button" id="add_video" class="btn btn-success btn-sm mt-2">
      <i class="fa fa-plus"></i> <?php echo get_phrase('add_another_video'); ?>
    </button>

  </div>
</div>

<script>
  $(document).ready(function(){
    // 🔹 Agregar nuevo grupo de video
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

    // 🔹 Eliminar grupo
    $(document).on('click', '.remove-video', function(){
      $(this).closest('.video-group').remove();
    });
  });
</script>


<!-- LISTING GALLERY IMAGES -->
<div class="form-group">
  <label class="col-sm-3 control-label" for="listing_images"><?php echo get_phrase('listing_gallery_images'); ?><br/> <small>(960 X 640)</small> </label>
  <div class="col-sm-7">
    <div id="photos_area">
      <?php if (count(json_decode($listing_details['photos'])) > 0): ?>
        <?php foreach (json_decode($listing_details['photos']) as $key => $photo): ?>
          <?php 
          // Detectar si la foto es URL completa o nombre de archivo
          $is_photo_url = (strpos($photo, 'http://') === 0 || strpos($photo, 'https://') === 0);
          $photo_src = $is_photo_url ? $photo : base_url('uploads/listing_images/'.$photo);
          ?>
          
          <?php if ($key == 0): ?>
            <div class="row">
              <div class="col-sm-7">
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                      <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
                        <img src="<?php echo $photo_src; ?>" alt="..." onerror="this.src='<?php echo base_url('uploads/placeholder.png'); ?>'">
                        <input type="hidden" class="name_of_previous_image" name="new_listing_images[]" value="<?php echo $photo; ?>">
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
          <?php else: ?>
            <div class="row appendedPhotoUploader">
              <div class="col-sm-7">
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                      <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
                        <img src="<?php echo $photo_src; ?>" alt="..." onerror="this.src='<?php echo base_url('uploads/placeholder.png'); ?>'">
                        <input type="hidden" class="name_of_previous_image" name="new_listing_images[]" value="<?php echo $photo; ?>">
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
          <?php endif; ?>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="row">
          <div class="col-sm-7">
            <div class="form-group">
              <div class="col-sm-12">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                  <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
                    <img src="<?php echo base_url('uploads/placeholder.png'); ?>" alt="...">
                    <input type="hidden" class="name_of_previous_image" name="new_listing_images[]" value="">
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
      <?php endif; ?>
    </div>
    <div id="blank_photo_uploader">
      <div class="row appendedPhotoUploader">
        <div class="col-sm-7">
          <div class="form-group">
            <div class="col-sm-12">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
                  <img src="<?php echo base_url('uploads/placeholder.png'); ?>" alt="...">
                  <input type="hidden" class="name_of_previous_image" name="new_listing_images[]" value="">
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