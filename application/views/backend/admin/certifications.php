<!-- start page title -->
<div class="row ">
  <div class="col-lg-12">
    <a href="<?php echo site_url('admin/certification_form/add'); ?>" class="btn btn-primary alignToTitle">
      <i class="entypo-plus"></i><?php echo get_phrase('add_new_certification'); ?>
    </a>
  </div><!-- end col-->
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo get_phrase('certifications'); ?>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered datatable">
          <thead>
            <tr>
              <th width="80"><div>#</div></th>
              <th><div><?php echo get_phrase('icon_or_image'); ?></div></th>
              <th><div><?php echo get_phrase('certification_name'); ?></div></th>
              <th><div><?php echo get_phrase('options'); ?></div></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $counter = 0;
            foreach ($certifications as $cert): 
              $has_image = !empty($cert['image']) && file_exists(FCPATH.'uploads/certifications/'.$cert['image']);
            ?>
              <tr>
                <td><?php echo ++$counter; ?></td>
                <td>
                  <?php if ($has_image): ?>
                    <img src="<?= base_url('uploads/certifications/'.$cert['image']); ?>"
                         alt="<?= html_escape($cert['name']); ?>"
                         style="height:30px;width:auto;">
                  <?php elseif (!empty($cert['icon'])): ?>
                    <i class="<?= html_escape($cert['icon']); ?>"></i>
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>
                <td><?php echo html_escape($cert['name']); ?></td>
                <td>
                  <div class="bs-example">
                    <div class="btn-group">
                      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <?php echo get_phrase('action'); ?> <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-blue" role="menu">
                        <li>
                          <a href="<?php echo site_url('admin/certification_form/edit/'.$cert['id']); ?>" class="">
                            <i class="entypo-pencil"></i>
                            <?php echo get_phrase('edit'); ?>
                          </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                          <a href="#" class="" onclick="confirm_modal('<?php echo site_url('admin/certifications/delete/'.$cert['id']); ?>');">
                            <i class="entypo-trash"></i>
                            <?php echo get_phrase('delete'); ?>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
