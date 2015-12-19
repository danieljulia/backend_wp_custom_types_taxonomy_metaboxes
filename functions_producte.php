<?php

/* incloure llibreria cmb2, necessària per definir els metaboxes (camps personalitzats)*/

require "cmb2.php";
/* cal comentar o eliminar a aquest arxiu els camps d'exemple que hi ha ara associats a 'page' i altres continguts */


/* crear tipus de contingut producte */

add_action( 'init', 'create_post_type' );

function create_post_type() {
  register_post_type( 'producte',
    array(
      'labels' => array(
        'name' => __( 'Productes' ),
        'singular_name' => __( 'Producte' )
      ),
      'public' => true,
      'has_archive' => 'llistat_productes',
      'show_in_rest'=>true, //important si volem que es vegi a l'interficie rest
      'supports' => array( 'thumbnail','title', 'editor' ) //volem imatge destacada
    )
  );
}



/*  crear taxonomia tipus de producte */

function custom_taxonomy() {

	$labels = array(
		'name'                       =>  'tipus', //slug taxonomia
		'singular_name'              => 'Tipus de producte',
		'menu_name'                  => 'Tipus de producte',

	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'tipus', array( 'post','producte' ), $args );

}
add_action( 'init', 'custom_taxonomy', 0 );

/* crear camps preu i referència  */

add_action( 'cmb2_admin_init', 'exemple_register_demo_metabox' );
/**
 * és recomanable canviar el prefixe
 */
function exemple_register_demo_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_exemple_demo_';

	/**
	 * Metabox amb 2 camps
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Informació producte', 'cmb2' ),
		'object_types'  => array( 'producte', ), // Post type
	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'Preu', 'cmb2' ),
		'desc'       => __( 'Preu en euros', 'cmb2' ),
		'id'         => $prefix . 'preu',
		'type'       => 'text_small',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Referència', 'cmb2' ),
		'desc' => __( 'Codi de referència del producte', 'cmb2' ),
		'id'   => $prefix . 'ref',
		'type' => 'text',
		// 'repeatable' => true,
	) );

}

