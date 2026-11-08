<?php
 /**
  * Title: Archive Header With Background
  * Slug: pixel-personal-portfolio/archive-header-with-background
  */
?>

<!-- wp:group {"align":"full","className":"banner alignfull","style":{"spacing":{"padding":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}},"layout":{"inherit":false}} -->
<div class="wp-block-group alignfull banner" style="padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:cover {"url":"<?php echo esc_url(get_parent_theme_file_uri( '/assets/images/banner-img.png' )); ?>","dimRatio":30,"focalPoint":{"x":0.52,"y":0.23}} -->
<div class="wp-block-cover"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url(get_parent_theme_file_uri( '/assets/images/banner-img.png' )); ?>" style="object-position:52% 23%" data-object-fit="cover" data-object-position="52% 23%"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-30 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"layout":{"inherit":true,"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"className":"alignwide"} -->
<div class="wp-block-group alignwide"><!-- wp:query-title {"type":"archive","textAlign":"center","textColor":"white"} /-->

<!-- wp:term-description {"textAlign":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->