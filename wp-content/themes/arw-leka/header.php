<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<![endif]-->
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php do_action('arexworks_action_before_render_body_tag'); ?>

<div class="body-wrapper">
	<div class="body-wrapper-inner inner-wrap">
		<div id="page_wrapper">
<?php
/**
 * Header Template
 */
do_action('arexworks_action_before_render_header_template');

	arexworks_get_header_template();

do_action('arexworks_action_after_render_header_template');
?>

<?php
/**
 * Page Header Template
 */
do_action('arexworks_action_before_render_page_header_template');

	arexworks_get_page_header_template();

do_action('arexworks_action_after_render_page_header_template');
