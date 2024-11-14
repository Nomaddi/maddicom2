<!-- start page title -->
<div class="row ">
  <div class="col-lg-12">
    <a href="<?php echo site_url('admin/state_form/add'); ?>" class="btn btn-primary alignToTitle"><i class="entypo-plus"></i><?php echo get_phrase('add_new_state'); ?></a>
  </div><!-- end col-->
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <?php echo get_phrase('states'); ?>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered datatable">
          <thead>
            <tr>
              <th width="80"><div>id</div></th>
              <th><div><?php echo get_phrase('state_name');?></div></th>
              <th><div><?php echo get_phrase('Country');?></div></th>
              <th><div><?php echo get_phrase('options');?></div></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $counter = 0;
            foreach ($states as $state): ?>
            <tr>
            <td><?php echo $state['id']; ?></td>

              <td><?php echo $state['name']; ?></td>
              <td>
                <?php
                $country_details = $this->crud_model->get_countries($state['country_id'])->row_array();
                echo $country_details['name'];
                ?>
              </td>
              <td>
                <div class="bs-example">
                  <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <?php echo get_phrase('action'); ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-blue" role="menu">
                      <li>
                        <a href="<?php echo site_url('admin/state_form/edit/'.$state['id']); ?>" class="">
                          <i class="entypo-pencil"></i>
                          <?php echo get_phrase('edit'); ?>
                        </a>
                      </li>
                      <li class="divider"></li>
                      <li>
                        <a href="#" class="" onclick="confirm_modal('<?php echo site_url('admin/states/delete/'.$state['id']); ?>');">
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
