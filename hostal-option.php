<?php

define ( 'HOSTAL_LOCAL_DIR'  , get_stylesheet_directory_uri() );



//Funcion para crear hostal option
if( !function_exists('tourmaster_hostal_option_init') ){
			function tourmaster_hostal_option_init(){

				$usuarios = get_users('orderby=nicename&role=subscriber');
				$listusuarios=array("default"=>"Seleccione");

				foreach ($usuarios as $singleuser){
					$listusuarios[$singleuser->ID]=$singleuser->data->display_name;
				}

				if( class_exists('tourmaster_page_option') ){
					new tourmaster_page_option(array(
						'post_type' => array('hostal'),
						'title' => esc_html__('Hostal Settings', 'tourmaster'),
						'title-icon' => 'fa fa-bed',
						'slug' => 'tourmaster-hostal-option',

						'options' => apply_filters('tourmaster_hostal_options', array(
							'general' => array(
								'title' => esc_html__('General', 'tourmaster'),
								'options' => array(
									'id-hostal' => array(
										'title' => esc_html__('ID. del hostal', 'tourmaster'),
										'type' => 'text',
										'description' => esc_html__('Identificador del hostal', 'tourmaster')
									),
									'nro-cuartos' => array(
										'title' => esc_html__('No. Cuartos', 'tourmaster'),
										'type' => 'text',
										'description' => esc_html__('Cantidad de cuartos del hostal', 'tourmaster')
									),
									'nro-aseos' => array(
										'title' => esc_html__('No. Aseos', 'tourmaster'),
										'type' => 'text',
										'description' => esc_html__('Numeros de aseos del hostal', 'tourmaster')
									),
									'precio-base' => array(
										'title' => esc_html__('Precio base', 'tourmaster'),
										'type' => 'text',
										'description' => esc_html__('Precio base del hostal', 'tourmaster')
									),
									'taxi-aeropuerto' => array(
										'title' => esc_html__('Taxi al aeropuerto', 'tourmaster'),
										'type' => 'checkbox',
										'default' => 'disable',
										'description' => esc_html__('Servicio de taxi para recoger a los huesped al aeropuerto.', 'tourmaster')
									),
									'permitido-fumar' => array(
										'title' => esc_html__('Permitido fumar', 'tourmaster'),
										'type' => 'checkbox',
										'default' => 'disable',
										'description' => esc_html__('Se permite fumar en el hostal.', 'tourmaster')
									),
									'apto-menor' => array(
										'title' => esc_html__('Apto familia niño', 'tourmaster'),
										'type' => 'checkbox',
										'default' => 'disable',
										'description' => esc_html__('Hay condiciones para alojar niños. ', 'tourmaster')
									)
								)
							),
							'gcuartos' => array(
								'title' => esc_html__('Gestionar Cuartos', 'tourmaster'),
								'options' => array(
									'agregar-cuarto' => array(
										'title' => esc_html__('Agregar cuarto', 'tourmaster'),
										'type' => 'custom',
										'item-type' => 'group-discount',
										'options' => array(
											'cantidad' => array(
												'title' => esc_html__('Capacidad', 'tourmaster'),
												'type' => 'text'
											)
										),
										'description' => esc_html__('De esta manera se adiciona la cantidad de personas por cuartos. Debe tener en cuenta que se agrega los cuartos cuando se adiciona la cantidad en la pestaña General Nro. Cuartos.', 'tourmaster')
									)
								)
							),
							'asociarpropietario' => array(
								'title' => esc_html__('Asociar propietario', 'tourmaster'),
								'options' => array(
									'propietarios' => array(
										'title' => esc_html__('Propietarios', 'tourmaster'),
										'type' => 'combobox',
										'options' => $listusuarios,
										'description' => esc_html__('Asociar un usuario del sistema con el hostal, una vez hecho esto, tendra acceso a modificar caracteristicas de dicho hostal.', 'tourmaster')
									),
								)
							)
						)
					),
				)
			);
		}
	}
}





// Adicionar page builder al CPT hostal
if( is_admin() ){ add_filter('gdlr_core_page_builder_post_type', 'tourmaster_gdlr_core_hostal_add_page_builder'); }
if( !function_exists('tourmaster_gdlr_core_hostal_add_page_builder') ){
	function tourmaster_gdlr_core_hostal_add_page_builder( $post_type ){
		$post_type[] = 'hostal';
		return $post_type;
	}
}

// init page builder value


if( is_admin() ){ add_filter('gdlr_core_hostal_page_builder_val_init', 'tourmaster_hostal_page_builder_val_init'); }
if( !function_exists('tourmaster_hostal_page_builder_val_init') ){
    function tourmaster_hostal_page_builder_val_init( $value ){

        $value = '[{"template":"wrapper","type":"background","value":{"id":"","class":"","content-layout":"full","max-width":"","enable-space":"enable","hide-this-wrapper-in":"none","animation":"none","animation-location":"0.8","full-height":"disable","decrease-height":"0px","centering-content":"disable","background-type":"color","background-color":"","background-image":"","background-image-style":"cover","background-image-position":"center","background-video-url":"","background-video-url-mp4":"","background-video-url-webm":"","background-video-url-ogg":"","background-video-image":"","background-pattern":"pattern-1","pattern-opacity":"1","parallax-speed":"0.8","overflow":"visible","border-type":"none","border-pre-spaces":{"top":"20px","right":"20px","bottom":"20px","left":"20px","settings":"link"},"border-width":{"top":"1px","right":"1px","bottom":"1px","left":"1px","settings":"link"},"border-color":"#ffffff","border-style":"solid","padding":{"top":"0px","right":"0px","bottom":"0px","left":"0px","settings":"unlink"},"margin ":{"top":"0px","right":"0px","bottom":"0px","left":"0px","settings":"link"},"skin":""},"items":[{"template":"element","type":"content-navigation","value":{"id":"","class":"","tabs":[{"id":"detail","title":"Descripción"},{"id":"service","title":"Servicios"},{"id":"locate","title":"Ubicación"},{"id":"eval","title":"Evaluaciones"}],"padding-bottom":"0px"}}]},{"template":"wrapper","type":"background","value":{"id":"","class":"","content-layout":"full","max-width":"","enable-space":"enable","hide-this-wrapper-in":"none","animation":"none","animation-location":"0.8","full-height":"disable","decrease-height":"0px","centering-content":"disable","background-type":"color","background-color":"","background-image":"","background-image-style":"cover","background-image-position":"center","background-video-url":"","background-video-url-mp4":"","background-video-url-webm":"","background-video-url-ogg":"","background-video-image":"","background-pattern":"pattern-1","pattern-opacity":"1","parallax-speed":"0.8","overflow":"visible","border-type":"none","border-pre-spaces":{"top":"20px","right":"20px","bottom":"20px","left":"20px","settings":"link"},"border-width":{"top":"1px","right":"1px","bottom":"1px","left":"1px","settings":"link"},"border-color":"#ffffff","border-style":"solid","padding":{"top":"0px","right":"0px","bottom":"0px","left":"0px","settings":"unlink"},"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px","settings":"link"},"skin":""},"items":[{"template":"element","type":"title","value":{"id":"","class":"","title":"Descripción","caption":"","caption-position":"bottom","title-width":"300px","title-link-text":"","title-link":"","title-link-target":"_self","text-align":"left","left-media-type":"icon","left-icon":"fa fa-file-text-o","left-image":"","enable-side-border":"disable","side-border-size":"1px","side-border-spaces":"30px","side-border-style":"solid","side-border-divider-color":"","heading-tag":"h6","icon-font-size":"18px","title-font-size":"24px","title-font-weight":"600","title-font-style":"normal","title-font-letter-spacing":"0px","title-font-uppercase":"disable","caption-font-size":"16px","caption-font-weight":"400","caption-font-style":"italic","caption-font-letter-spacing":"0px","caption-font-uppercase":"disable","left-icon-color":"","title-color":"","title-link-hover-color":"","caption-color":"","caption-spaces":"10px","media-margin":{"top":"0px","right":"15px","bottom":"0px","left":"0px","settings":"unlink"},"padding-bottom":"35px"}},{"template":"element","type":"text-box","value":{"id":"","class":"","content":"","text-align":"left","font-size":"","padding-bottom":"30px"}}]}]';

        return json_decode($value, true);
    }
}
