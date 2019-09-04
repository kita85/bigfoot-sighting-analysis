<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
	<script type="application/ld+json">
		{
		  "@context": "http://schema.org",
		  "@type": "WebApplication",
		  "name": "Bigfoot Sighting Analysis",
		  "url": "https://kitacranfill.com/bigfoot",
		  "description": "Determine the probability that you will encounter a bigfoot at your location!",
		  "applicationCategory": "Multimedia",
		  "genre": "paranormal",
		  "about": {
			"@type": "Thing",
			"description": "bigfoot, aliens"
		  },
		  "browserRequirements": "Requires JavaScript. Requires HTML5.",
		  "softwareVersion": "1.0.0",
		  "softwareHelp": {
			"@type": "CreativeWork",
			"url": "https://kitacranfill.com/bigfoot"
		  },
		  "operatingSystem": "All"
		}
	</script>
</head>
