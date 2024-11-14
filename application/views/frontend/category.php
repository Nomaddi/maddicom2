<div class="" style="background-color: #f5f8fa;">
	<div class="container margin_80_55">
		<div class="main_title_2">
			<span><em></em></span>
			<h2><?php echo get_phrase('categories'); ?></h2>
		</div>
		<div class="row justify-content-center">
			<?php
			foreach ($categories as $key => $category): ?>
			<div class="col-md-4 mb-3">
				<div class="category-title">
					<a href="<?php echo site_url('home/search?search_string=&selected_city_id=&selected_category_id='.$category['id']); ?>" style="color: unset;"><?php echo $category['name']; ?></a>
				</div>
				<?php
				    $sub_categories = $this->crud_model->get_sub_categories($category['id']);
				    foreach ($sub_categories->result_array() as $key => $sub_category): ?>
					<a href="<?php echo site_url('home/search?search_string=&selected_city_id=&selected_category_id='.$sub_category['id']); ?>" class="sub-category-link">
						<div class="sub-category">
							<span class="sub-category-number"> <i class="<?php echo $sub_category['icon_class']; ?>"></i> </span>
							<span class="sub-category-title"> <?php echo $sub_category['name']; ?></span>
							<span class="sub-category-arrow"><i class="fa fa-arrow-right"></i></span>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</div>
