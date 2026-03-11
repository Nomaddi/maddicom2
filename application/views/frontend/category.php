<div class="" style="background-color: #f5f8fa;">
	<div class="container margin_80_55">
		<div class="main_title_2">
			<span><em></em></span>
			<h2><?php echo get_phrase('categories'); ?></h2>
		</div>
	</div>
	<div class="row">
		<?php foreach ($categories as $category): ?>
		<div class="col-lg-4 col-md-6 mb-4">
			<div class="card shadow-sm border-0">
				<div class="card-header bg-success text-white py-3 trigger-accordion" 
					style="cursor: pointer;">
					<h5 class="mb-0 d-flex justify-content-between align-items-center">
						<span class="w-100 text-center"><?php echo $category['name']; ?></span>
						<i class="fa fa-chevron-down arrow-icon"></i>
					</h5>
				</div>

				<div class="collapse content-panel">
					<div class="list-group list-group-flush">
						<?php 
						$sub_categories = $this->crud_model->get_sub_categories($category['id']);
						$subs = is_array($sub_categories) ? $sub_categories : $sub_categories->result_array();
						foreach ($subs as $sub): ?>
							<a href="<?php echo site_url('home/search?category='.$sub['slug']); ?>" class="list-group-item list-group-item-action">
								<?php echo $sub['name']; ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>


</div>

<script>
$(document).ready(function() {
    $('.trigger-accordion').on('click', function() {
        // Buscamos el panel de contenido que está inmediatamente después del header
        var panel = $(this).next('.content-panel');
        var icon = $(this).find('.arrow-icon');

        // Cerramos los otros paneles abiertos (opcional, para efecto acordeón real)
        $('.content-panel').not(panel).slideUp().removeClass('show');
        $('.arrow-icon').not(icon).css('transform', 'rotate(0deg)');

        // Toggle del panel actual
        panel.slideToggle();
        
        // Rotar icono
        if (panel.is(':visible')) {
            icon.css('transform', 'rotate(180deg)');
        } else {
            icon.css('transform', 'rotate(0deg)');
        }
    });
});
</script>
