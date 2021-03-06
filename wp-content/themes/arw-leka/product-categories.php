<?php
/**
 * Template Name: Product Categories
 */
?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<?php
add_filter('arexworks_filter_get_options_layout',function($layout){
	return 'col-1c';
});
?>
<?php get_header();?>
	<div class="container text-center">
		<!-- <h3>What We Do</h3> --> <br> 
		<div class="row">
	<?php 
	
		global $wpdb;				 
		//$results = $wpdb->get_results( "SELECT * FROM delstore_postmeta WHERE meta_key = '_crosssell_ids' AND meta_value != ''", OBJECT );
		$results = $wpdb->get_results( "SELECT * FROM delstore_postmeta WHERE meta_key = '_related_ids' AND meta_value != ''", OBJECT );
		//echo '<pre>';
			//print_r($results); 
			foreach($results as $result){
				//print_r($result);
				if(count(maybe_unserialize($result->meta_value))>0){
					//echo $result->post_id.'<br/>';
					$product_names = $wpdb->get_results( "SELECT post_title, post_name FROM delstore_posts WHERE id = ".$result->post_id, OBJECT );
					
					$product_name = $product_names[0]->post_title;	
					$product_url = $product_names[0]->post_name;	
					
					$thumbnail_img_id = $wpdb->get_results( "SELECT meta_value FROM delstore_postmeta WHERE meta_key = '_thumbnail_id' AND post_id = ".$result->post_id, OBJECT );
					//echo $thumbnail_img_id[0]->meta_value; 
					
					
					$thumbnail_img = $wpdb->get_results( "SELECT meta_value FROM delstore_postmeta WHERE meta_key = '_wp_attached_file' AND post_id = ".$thumbnail_img_id[0]->meta_value, OBJECT );
					//print_r($thumbnail_img[0]->meta_value);
					$url = wp_upload_dir();
					//echo $url['baseurl'].'/'.$thumbnail_img[0]->meta_value;
					?>					
						<div class="col-sm-6 col-md-4 col-lg-4" style="padding:10px;">
							<div style="background: url(<?php echo $url['baseurl'].'/'.$thumbnail_img[0]->meta_value;?>); height:232px; background-size:cover; background-repeat:no-repeat;">
								<!-- <img src="<?php echo $url['baseurl'].'/'.$thumbnail_img[0]->meta_value;?>" class="img-responsive" alt="Image"> -->
							</div>	
							<a class="product_url" href="<?php echo site_url().'/product/'.$product_url ;?>"><h3 style="background: #ddd;"><?php echo $product_name; ?></h3> </a>
						</div>	
			<?php	}		
			}
		//echo '</pre>';	
		
	?>							
			<div class="clearfix"></div>
		</div>
	</div>
<?php get_footer();?>