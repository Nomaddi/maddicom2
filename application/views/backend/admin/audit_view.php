<div class="row">
    <div class="col-lg-12">
        <!-- Panel Principal idéntico al estilo de usuarios -->
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('audit_logs'); ?> 
                </div>
            </div>
            <div class="panel-body">
                
                <form method="GET" action="" class="form-inline mb-4" style="margin-bottom: 20px;">
                    <div class="form-group" style="margin-right: 15px;">
                        <label class="control-label" style="margin-right: 5px;"><?php echo get_phrase('module'); ?>:</label>
                        <select name="module" class="form-control">
                            <option value=""><?php echo get_phrase('all_modules'); ?></option>
                            <option value="auth" <?php echo (isset($filters['module']) && $filters['module']=='auth')?'selected':''; ?>>Auth / Login</option>
                            <option value="comercios" <?php echo (isset($filters['module']) && $filters['module']=='comercios')?'selected':''; ?>>Comercios</option>
                            <option value="categorias" <?php echo (isset($filters['module']) && $filters['module']=='categorias')?'selected':''; ?>>Categorías</option>
                            <option value="usuarios" <?php echo (isset($filters['module']) && $filters['module']=='usuarios')?'selected':''; ?>>Usuarios</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-right: 15px;">
                        <label class="control-label" style="margin-right: 5px;"><?php echo get_phrase('action'); ?>:</label>
                        <select name="action" class="form-control">
                            <option value=""><?php echo get_phrase('all_actions'); ?></option>
                            <option value="LOGIN" <?php echo (isset($filters['action']) && $filters['action']=='LOGIN')?'selected':''; ?>>LOGIN</option>
                            <option value="CREATE" <?php echo (isset($filters['action']) && $filters['action']=='CREATE')?'selected':''; ?>>CREATE</option>
                            <option value="UPDATE" <?php echo (isset($filters['action']) && $filters['action']=='UPDATE')?'selected':''; ?>>UPDATE</option>
                            <option value="DELETE" <?php echo (isset($filters['action']) && $filters['action']=='DELETE')?'selected':''; ?>>DELETE</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-info">
                        <i class="entypo-search"></i> <?php echo get_phrase('filter'); ?>
                    </button>
                </form>

                <table class="table table-bordered datatable">
                    <thead>
                        <tr>
                            <th width="80"><div>#</div></th>
                            <th><div><?php echo get_phrase('date_time'); ?></div></th>
                            <th><div><?php echo get_phrase('user'); ?></div></th>
                            <th><div><?php echo get_phrase('action'); ?></div></th>
                            <th><div><?php echo get_phrase('module'); ?></div></th>
                            <th><div><?php echo get_phrase('description'); ?></div></th>
                            <th><div><?php echo get_phrase('ip_address'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $counter = 0;
                         if (!empty($logs)):
                             foreach ($logs as $log): ?>
                                <tr>
                                    <td><?php echo ++$counter; ?></td>
                                    <td><?php echo $log->created_at; ?></td>
                                    <td><?php echo html_escape($log->user_name); ?></td>
                                    <td class="text-center">
                                        <?php 
                                            $badge_class = 'btn-default';
                                            if($log->action == 'CREATE') $badge_class = 'btn-success';
                                            elseif($log->action == 'UPDATE') $badge_class = 'btn-primary';
                                            elseif($log->action == 'DELETE') $badge_class = 'btn-danger';
                                            elseif($log->action == 'LOGIN') $badge_class = 'btn-info';
                                        ?>
                                        <span class="btn btn-xs <?php echo $badge_class; ?>" style="cursor: default;">
                                            <?php echo $log->action; ?>
                                        </span>
                                    </td>
                                    <td><strong><?php echo ucfirst($log->module); ?></strong></td>
                                    <td><?php echo html_escape($log->description); ?></td>
                                    <td><small class="text-muted"><?php echo $log->ip_address; ?></small></td>
                                </tr>
                            <?php endforeach; 
                         else: ?>
                            <tr>
                                <td colspan="7" class="text-center"><?php echo get_phrase('no_data_found'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>