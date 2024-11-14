<!-- Single Item of popular category starts -->
<?php
$categories = $this->db->get_where('category', array('parent' => 0))->result_array();
foreach ($categories as $key => $category):?>
<div class="col-lg-4 col-md-6">
	<a href="<?php echo site_url('home/filter_listings?category='.$category['slug'].'&&amenity=&&video=0&&status=all'); ?>" class="grid_item">
		<figure>
			<img src="<?php echo base_url('uploads/category_thumbnails/').$category['thumbnail'];?>" alt="">
			<div class="info">
				<h3><?php echo $category['name']; ?></h3>
			</div>
		</figure>
	</a>
</div>
<?php endforeach; ?>
<!-- Single Item of popular category ends -->