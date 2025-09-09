<div class="row">
  <div class="col-lg-10">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo get_phrase('add_new_certification'); ?>
        </div>
      </div>
      <div class="panel-body">

        <form action="<?php echo site_url('admin/certifications/add'); ?>" method="post" enctype="multipart/form-data" role="form" class="form-horizontal form-groups-bordered">

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label"><?php echo get_phrase('certification_title'); ?></label>

            <div class="col-sm-7">
              <input type="text" class="form-control" name="name" id="name" placeholder="<?php echo get_phrase('provide_certification_name'); ?>" required>
            </div>
          </div>

          <div class="form-group" id="icon-picker-area">
            <label for="font_awesome_class" class="col-sm-3 control-label"><?php echo get_phrase('icon_picker'); ?></label>

            <div class="col-sm-7">
              <input type="text" name="icon" class="form-control icon-picker" autocomplete="off" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label"><?= get_phrase('image'); ?> (<?= get_phrase('optional'); ?>)</label>
            <div class="col-sm-7">
              <input type="file" name="image" class="form-control" accept="image/*">
              <small class="text-muted">
                <?= get_phrase('if_you_upload_an_image_the_icon_will_be_ignored'); ?>
              </small>
            </div>
          </div>


          <div class="col-sm-offset-3 col-sm-5" style="padding-top: 10px;">
            <button type="submit" class="btn btn-info"><?php echo get_phrase('add_certification'); ?></button>
          </div>
        </form>

      </div>
    </div>
  </div><!-- end col-->
</div>
