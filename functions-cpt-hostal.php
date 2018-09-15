<?php

/*Incorporando css,js al administrador*/
function hostal_load_admin_scripts(){

	if (get_post_type()=='hostal') {
		wp_register_style( 'alert-css', get_template_directory_uri() . '-child/css/jquery-confirm.min.css', array(), '1.0.0', 'all' );
		wp_enqueue_style( 'alert-css' );
        wp_register_style( 'hostal-css', get_template_directory_uri() . '-child/css/hostal.css', array(), '1.0.0', 'all' );
        wp_enqueue_style( 'hostal-css' );
		wp_register_script( 'alert-admin-script', get_template_directory_uri() . '-child/js/jquery-confirm.min.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'alert-admin-script' );
	}
}

add_filter( 'admin_enqueue_scripts', 'hostal_load_admin_scripts' );

add_action('init', 'RegisterHostal');


if (!function_exists('RegisterHostal')){

	function RegisterHostal() {
		$labelhostal = array(
			'name'               => _x( 'Hostal', 'post type general name' ),
			'singular_name'      => _x( 'hostal', 'post type singular name' ),
			'add_new'            => _x( 'Añadir  hostal', 'book' ),
			'add_new_item'       => __( 'Añadir nuevo hostal' ),
			'edit_item'          => __( 'Editar hostal' ),
			'new_item'           => __( 'Nuevo hostal' ),
			'view_item'          => __( 'Ver hostal' ),
			'search_items'       => __( 'Buscar hostal' ),
			'not_found'          => __( 'No se han encontrado ningun hostal' ),
			'not_found_in_trash' => __( 'No se han encontrado hostales en la papelera' ),
			'menu_icon'          => 'dashicons-admin-users',
			'parent_item_colon'  => '',
		);

		$argshostal = array(
			'labels'             => $labelhostal,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'query_var'          => true,
			'rewrite'            => true,
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor','thumbnail' ),
		);

		register_post_type( 'hostal', $argshostal );
	}

    //add_filter( 'single_template' , 'hostal_template');
}

/*if( !function_exists('hostal_template') ){
    function hostal_template( $template ){
        if( get_post_type() == 'hostal' ){
            $template = HOSTAL_LOCAL_DIR.'/single/hostal.php' ;
        }
        return $template;
    }
}*/


/***
 * AGREGANDO LAS TAXONOMIAS AL CUSTOM POST TYPE HOSTAL
 */

//taxonomia Servicios
add_action('init', 'servicios', 0);

function servicios() {
	$labels = array(
		'name' => _x('Servicios', 'taxonomy general name'),
		'singular_name' => _x('Servicio', 'taxonomy singular name'),
		'search_items' => __('Buscar por Servicios'),
		'all_items' => __('Servicios'),
		'parent_item' => __('Servicio padre'),
		'parent_item_colon' => __('Servicio padre:'),
		'edit_item' => __('Editar Servicio'),
		'update_item' => __('Actualizar Servicio'),
		'add_new_item' => __('Añadir nuevo Servicio'),
		'new_item_name' => __('Nombre del nuevo Servicio'),
	);

	register_taxonomy('servicio', array('hostal'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => false,
		'show_in_quick_edit' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'servicio'),
	));
}


//taxonomia Estructura de camas
add_action('init', 'estructuracama', 0);

function estructuracama() {
	$labels = array(
		'name' => _x('Estructura de camas', 'taxonomy general name'),
		'singular_name' => _x('Estructura de cama', 'taxonomy singular name'),
		'search_items' => __('Buscar por estructura de cama'),
		'all_items' => __('Estructuras de camas'),
		'parent_item' => __('Estructura de cama padre'),
		'parent_item_colon' => __('Estructura de cama padre:'),
		'edit_item' => __('Editar Estructura de cama'),
		'update_item' => __('Actualizar Estructura de cama'),
		'add_new_item' => __('Añadir nueva Estructura de cama'),
		'new_item_name' => __('Nombre de la nueva estructura de cama'),
	);

	register_taxonomy('estructuracama', array('hostal'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => false,
		'show_in_quick_edit' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'estructuracama'),
	));
}


//taxonomia tipo de habitacion
add_action('init', 'tipodehabitacion', 0);

function tipodehabitacion() {
	$labels = array(
		'name' => _x('Tipo de habitacion', 'taxonomy general name'),
		'singular_name' => _x('Tipo de habitacion', 'taxonomy singular name'),
		'search_items' => __('Buscar por tipo de habitacion'),
		'all_items' => __('tipos de habitaciones'),
		'parent_item' => __('Tipo de habitacion padre'),
		'parent_item_colon' => __('Tipo de habitacion padre:'),
		'edit_item' => __('Editar tipo de habitacion'),
		'update_item' => __('Actualizar Tipo de habitacion'),
		'add_new_item' => __('Añadir nuevo tipo de habitacion'),
		'new_item_name' => __('Nombre del nuevo tipo de habitacion'),
	);

	register_taxonomy('tipohabitacion', array('hostal'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_in_quick_edit' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'tipodehabitacion'),
	));
}

//taxonomia tipo de propiedad
add_action('init', 'tipodepropiedad', 0);

function tipodepropiedad() {
	$labels = array(
		'name' => _x('Tipo de propiedad', 'taxonomy general name'),
		'singular_name' => _x('Tipo de propiedad', 'taxonomy singular name'),
		'search_items' => __('Buscar por tipo de propiedad'),
		'all_items' => __('tipos de propiedades'),
		'parent_item' => __('Tipo de propiedad padre'),
		'parent_item_colon' => __('Tipo de propiedad padre:'),
		'edit_item' => __('Editar tipo de propiedad'),
		'update_item' => __('Actualizar Tipo de propiedad'),
		'add_new_item' => __('Añadir nuevo tipo de propiedad'),
		'new_item_name' => __('Nombre del nuevo tipo de propiedad'),
	);

	register_taxonomy('tipopropiedad', array('hostal'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_in_quick_edit' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'tipopropiedad'),
	));
}

//taxonomia lugares de interes
add_action('init', 'lugaresinteres', 0);

function lugaresinteres() {
	$labels = array(
		'name' => _x('Lugares de Interes', 'taxonomy general name'),
		'singular_name' => _x('Lugar de Interes', 'taxonomy singular name'),
		'search_items' => __('Buscar por lugar de interes'),
		'all_items' => __('Lugares de Interes'),
		'parent_item' => __('lugar de interes padre'),
		'parent_item_colon' => __('lugar de interes padre:'),
		'edit_item' => __('Editar lugar de interes'),
		'update_item' => __('Actualizar Lugar de interes'),
		'add_new_item' => __('Añadir nuevo lugar de interes'),
		'new_item_name' => __('Nombre del nuevo lugar de interes'),
	);

	register_taxonomy('lugarinteres', array('hostal'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => false,
		'show_in_quick_edit' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'lugarinteres'),
	));
}

//taxonomia Destinos
add_action('init', 'destinos', 0);

function destinos() {
    $labels = array(
        'name' => _x('Destinos', 'taxonomy general name'),
        'singular_name' => _x('Destino', 'taxonomy singular name'),
        'search_items' => __('Buscar por destinos'),
        'all_items' => __('Destinos'),
        'parent_item' => __('Destino padre'),
        'parent_item_colon' => __('Destino padre:'),
        'edit_item' => __('Editar destino'),
        'update_item' => __('Actualizar destino'),
        'add_new_item' => __('Añadir nuevo destino'),
        'new_item_name' => __('Nombre del nuevo destino'),
    );

    register_taxonomy('destino', array('hostal'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => false,
        'show_in_quick_edit' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'destino'),
    ));
}

//taxonomia Destinos
add_action('init', 'servicios_basicos', 0);

function servicios_basicos() {
    $labels = array(
        'name' => _x('Servicios Basicos', 'taxonomy general name'),
        'singular_name' => _x('Servicios Basicos', 'taxonomy singular name'),
        'search_items' => __('Buscar por servicio basico'),
        'all_items' => __('Servicio basico'),
        'parent_item' => __('Servicio basico padre'),
        'parent_item_colon' => __('Servicio basico padre:'),
        'edit_item' => __('Editar Servicio basico'),
        'update_item' => __('Actualizar Servicio basico'),
        'add_new_item' => __('Añadir nuevo Servicio basico'),
        'new_item_name' => __('Nombre del nuevo Servicio basico'),
    );

    register_taxonomy('servicio_basico', array('hostal'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => false,
        'show_in_quick_edit' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'servicio_basico'),
    ));
}

/**
*    CREANDO ESTRUCTURA DE COLUMNAS EN EL LISTADO DE LOS HOSTALES
 */

function set_hostal_posts_columns($defaults) {
	$defaults = array();
	$defaults['title'] = __('Nombre');
	$defaults['idhostal'] = __('ID del hostal');
	$defaults['propietario'] = __('Propietario');
	$defaults['servicios'] = __('Servicios');
	$defaults['nocuartos'] = __('Nro. cuartos');
	$defaults['estructuracamas'] = __('Estructuras de camas');
	$defaults['tipohabitacion'] = __('Tipo de habitacion');
	$defaults['tipopropiedad'] = __('Tipo de propiedad');
	$defaults['noaseos'] = __('Nro. de aseos');
	$defaults['preciobase'] = __('Precio base');
	$defaults['tipoiluminacion'] = __('Tipo de iluminacion');
	return $defaults;
}

//Hook para adicionar la nueva estructura a los hostales
add_filter('manage_hostal_posts_columns', 'set_hostal_posts_columns');


add_action('manage_hostal_posts_custom_column', 'fill_hostal_posts_columns', 10, 2);

function fill_hostal_posts_columns($column_name, $post_id) {
	$hostal_meta=get_post_meta($post_id,'tourmaster-hostal-option')[0];

	// Recorremos cada columna y asignamos un valor.
	switch ($column_name):
		case 'propietario':
			if (isset($hostal_meta['propietarios'])) {
				if ( $hostal_meta['propietarios'] != 'default' ) {
					$usuario = get_user_by( 'id', $hostal_meta['propietarios'] );
					echo $usuario->display_name;
				} else {
					echo '---';
				}
			} else
				echo '---';
			break;
		case 'idhostal':
			if (isset($hostal_meta['id-hostal']))
				echo $hostal_meta['id-hostal'];
			else
				echo '---';
			break;
		case 'nocuartos':
			if (isset($hostal_meta['nro-cuartos']))
				echo $hostal_meta['nro-cuartos'];
			else
				echo '---';
			break;
		case 'servicios':
			$servicios=get_terms(array(
				'taxonomy'=>'servicio'
			));
			if (count($servicios)>0){
				$show='';
				foreach ($servicios as $name){
					$show.=$name->name.' ,';
				}
				echo substr($show,0,strlen($show)-1);
			} else {
				echo esc_attr__('---','tourmaster');
			}
			break;
		case 'estructuracamas':
			$estcamas=get_terms(array(
				'taxonomy'=>'estructuracama'
			));
			if (count($estcamas)>0){
				$show='';
				foreach ($estcamas as $name){
					$show.=$name->name.' ,';
				}
				echo substr($show,0,strlen($show)-1);
			} else {
				echo esc_attr__('---','tourmaster');
			}
			break;
		case 'tipohabitacion':
			$tipohabitacion=get_terms(array(
				'taxonomy'=>'tipohabitacion'
			));
			if (count($tipohabitacion)>0){
				$show='';
				foreach ($tipohabitacion as $name){
					$show.=$name->name.' ,';
				}
				echo substr($show,0,strlen($show)-1);
			} else {
				echo esc_attr__('---','tourmaster');
			}
			break;
		case 'tipopropiedad':
			$tipopropiedad=get_terms(array(
				'taxonomy'=>'tipopropiedad'
			));
			if (count($tipopropiedad)>0){
				$show='';
				foreach ($tipopropiedad as $name){
					$show.=$name->name.' ,';
				}
				echo substr($show,0,strlen($show)-1);
			} else {
				echo esc_attr__('---','tourmaster');
			}
			break;
		case 'noaseos':
			if (isset($hostal_meta['nro-aseos']))
				echo $hostal_meta['nro-aseos'];
			else
				echo '---';
			break;
		case 'preciobase':
			if (isset($hostal_meta['precio-base']))
				echo $hostal_meta['precio-base'];
			else
				echo '---';
			break;
		case 'tipoiluminacion':
			if (isset($hostal_meta['tipo-iluminacion']))
				echo $hostal_meta['tipo-iluminacion'];
			else
				echo '---';
			break;
	endswitch;

}


//MODIFICANDO EL BACKHEND
add_action( 'add_meta_boxes' , 'agregar_metaboxes');

function agregar_metaboxes() {
    add_meta_box( 'politicas-cancelacion' , 'Política de cancelación', 'politica_cancelacion' , 'hostal' , 'normal' , 'high' );
    add_meta_box( 'norma-casa', 'Normas de la casa', 'normas_casa' ,'hostal', 'normal', 'high' );
}

function politica_cancelacion( $post ) {

    //nonce field for security
    wp_nonce_field( 'meta-box-save', 'politica-cancelacion' );
    $politica = esc_attr(get_post_meta( $post->ID , 'politica_cancelacion', true ));
    ?>
    <table class="politica-cancelacion">
        <tr>
            <input type="radio" name="politica-cancelacion" value="Flexible" <?php checked($politica , "Flexible" );?> ><strong>Flexible</strong><br>
            <p>Reembolso completo hasta un día antes de la fecha de llegada.</p>
        </tr>
        <tr>
            <input type="radio" name="politica-cancelacion" value="Moderada" <?php checked($politica , "Moderada" );?>><strong>Moderada</strong><br>
            <p>Reembolso completo hasta 3 días  antes de la fecha de llegada.</p>
        </tr>
        <tr>
            <input type="radio" name="politica-cancelacion" value="Estricta" <?php checked($politica , "Estricta" );?>><strong>Estricta</strong><br>
            <p>50% de reembolso hasta 1 semana antes de la fecha de llegada.</p>
        </tr>
        <tr>
            <input type="radio" name="politica-cancelacion" value="SuperEstricta" <?php checked($politica , "SuperEstricta" );?>><strong>Super Estricta</strong><br>
            <p>50% de reembolso hasta 30 días antes de la fecha de llegada.</p>
        </tr>
    </table>
     <?php
}

function normas_casa ( $post ) {
    wp_nonce_field( 'meta-box-save', 'normas-casa' );
    $normas_casa = get_post_meta( $post->ID , 'normas_casa', true );
   ?>
    <table>
        <tr>
            <textarea name="normas-casa" id="normas-casa"  rows="5" style="width: 100%">
                <?php echo $normas_casa ;?>
            </textarea>
        </tr>
    </table>

<?php
}


add_action( 'save_post' , 'politica_cancelacion_save_meta_box' );
add_action( 'save_post' , 'normas_casa_save_meta_box' );

add_action ( 'save_post_hostal', 'init_review' );

function init_review ($post_id){
    $review = get_post_meta($post_id,'tourmaster-tour-rating', true );
   if ( $review == "" ){
       update_post_meta($post_id, 'tourmaster-tour-rating', array(
           'score' => 0,
           'reviewer' => 0
       ));
   }
}


function politica_cancelacion_save_meta_box( $post_id ){

    //verificar que no sea un autosalvado
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;


    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;


    if( !isset( $_POST['politica-cancelacion'] ) || !wp_verify_nonce( $_POST['politica-cancelacion'], 'meta-box-save' ) ) return;

    $politica =$_POST['politica-cancelacion'];

    update_post_meta( $post_id, 'politica_cancelacion', $politica );

}

function normas_casa_save_meta_box( $post_id ) {
    //verificar que no sea un autosalvado
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;


    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
    if( !current_user_can( 'edit_post' ) ) return;


    if( !isset( $_POST['normas-casa'] ) || !wp_verify_nonce( $_POST['normas-casa'], 'meta-box-save' ) ) return;

    $normas_casa = $_POST['normas-casa'];

    update_post_meta( $post_id , 'normas-casa', $normas_casa );

}

