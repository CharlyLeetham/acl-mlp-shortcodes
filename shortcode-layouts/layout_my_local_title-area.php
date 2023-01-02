<?php  if (!defined('ABSPATH')) { exit; } ?>
<style>
.align-banner-items-center{
	align-items: center;
}
</style>
<?php
if($layout == 'side-by-side' || $layout == 'carousel'){
?>
	<div class ="row align-banner-items-center">
		<div class="col-md-6">
			<img src="<?php echo $banner_url; ?>" alt="" class="banner-img img-responsive"/>
		</div>
		<div class="col-md-6">
			<h1 class="elementor-heading-title elementor-size-default mlp-titlearea">My Local <?php echo $crnt_zipcode; ?> - <?php echo $title_area; ?> Region</h1>
		</div>
	</div>
<?php 
}elseif($layout == 'full'){
?>
	<div class ="row">
		<div class="col-md-12" style="text-align:center;">
			<img src="<?php echo $banner_url; ?>" alt="" class="banner-img img-responsive"/>
		</div>
		<div class="col-md-12">
			<h1 class="elementor-heading-title elementor-size-default mlp-titlearea">My Local <?php echo $crnt_zipcode; ?> - <?php echo $title_area; ?> Region</h1>
		</div>
	</div>
<?php 	
}
