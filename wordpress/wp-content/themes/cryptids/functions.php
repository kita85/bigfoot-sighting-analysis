<?php

add_action( 'wp_enqueue_scripts', 'cryptids_enqueue_styles' );

function cryptids_enqueue_styles() {
    wp_enqueue_style( 'styles', get_template_directory_uri() . '/style.css' );
}