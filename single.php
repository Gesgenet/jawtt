
<?php
/**
 * The template for displaying all single posts and attachments
 */




while( have_posts() ){ the_post();

    if( get_post_type() == 'post' ) {

        get_header();

        // print header titletourmaster-tour-rating
        if( get_post_type() == 'post' ){
            get_template_part('header/header', 'title-blog');
        }

        $post_option = traveltour_get_post_option(get_the_ID());

        if (empty($post_option['sidebar']) || $post_option['sidebar'] == 'default') {
            $sidebar_type = traveltour_get_option('general', 'blog-sidebar', 'none');
            $sidebar_left = traveltour_get_option('general', 'blog-sidebar-left');
            $sidebar_right = traveltour_get_option('general', 'blog-sidebar-right');
        } else {
            $sidebar_type = empty($post_option['sidebar']) ? 'none' : $post_option['sidebar'];
            $sidebar_left = empty($post_option['sidebar-left']) ? '' : $post_option['sidebar-left'];
            $sidebar_right = empty($post_option['sidebar-right']) ? '' : $post_option['sidebar-right'];
        }

        echo '<div class="traveltour-content-container traveltour-container">';
        echo '<div class="' . traveltour_get_sidebar_wrap_class($sidebar_type) . '" >';

        // sidebar content
        echo '<div class="' . traveltour_get_sidebar_class(array('sidebar-type' => $sidebar_type, 'section' => 'center')) . '" >';
        echo '<div class="traveltour-content-wrap traveltour-item-pdlr clearfix" >';

        // single content
        if (empty($post_option['show-content']) || $post_option['show-content'] == 'enable') {
            echo '<div class="traveltour-content-area" >';
            if (in_array(get_post_format(), array('aside', 'quote', 'link'))) {
                get_template_part('content/content', get_post_format());
            } else {
                get_template_part('content/content', 'single');
            }
            echo '</div>';
        }

        if (!post_password_required()) {
            if ($sidebar_type != 'none') {
                echo '<div class="traveltour-page-builder-wrap traveltour-item-rvpdlr" >';
                do_action('gdlr_core_print_page_builder');
                echo '</div>';
            } else {
                ob_start();
                do_action('gdlr_core_print_page_builder');
                $pb_content = ob_get_contents();
                ob_end_clean();

                if (!empty($pb_content)) {
                    echo '</div>'; // traveltour-content-area
                    echo '</div>'; // traveltour_get_sidebar_class
                    echo '</div>'; // traveltour_get_sidebar_wrap_class
                    echo '</div>'; // traveltour_content_container
                    echo gdlr_core_escape_content($pb_content);
                    echo '<div class="traveltour-bottom-page-builder-container traveltour-container" >'; // traveltour-content-area
                    echo '<div class="traveltour-bottom-page-builder-sidebar-wrap traveltour-sidebar-style-none" >'; // traveltour_get_sidebar_class
                    echo '<div class="traveltour-bottom-page-builder-sidebar-class" >'; // traveltour_get_sidebar_wrap_class
                    echo '<div class="traveltour-bottom-page-builder-content traveltour-item-pdlr" >'; // traveltour_content_container
                }
            }
        }

        // social share
        if (traveltour_get_option('general', 'blog-social-share', 'enable') == 'enable') {
            if (class_exists('gdlr_core_pb_element_social_share')) {
                $share_count = (traveltour_get_option('general', 'blog-social-share-count', 'enable') == 'enable') ? 'counter' : 'none';

                echo '<div class="traveltour-single-social-share traveltour-item-rvpdlr" >';
                echo gdlr_core_pb_element_social_share::get_content(array(
                    'social-head' => $share_count,
                    'layout' => 'left-text',
                    'text-align' => 'center',
                    'facebook' => traveltour_get_option('general', 'blog-social-facebook', 'enable'),
                    'linkedin' => traveltour_get_option('general', 'blog-social-linkedin', 'enable'),
                    'google-plus' => traveltour_get_option('general', 'blog-social-google-plus', 'enable'),
                    'pinterest' => traveltour_get_option('general', 'blog-social-pinterest', 'enable'),
                    'stumbleupon' => traveltour_get_option('general', 'blog-social-stumbleupon', 'enable'),
                    'twitter' => traveltour_get_option('general', 'blog-social-twitter', 'enable'),
                    'email' => traveltour_get_option('general', 'blog-social-email', 'enable'),
                    'padding-bottom' => '0px'
                ));
                echo '</div>';
            }
        }

        // author section
        $author_desc = get_the_author_meta('description');
        if (!empty($author_desc) && traveltour_get_option('general', 'blog-author', 'enable') == 'enable') {
            echo '<div class="clear"></div>';
            echo '<div class="traveltour-single-author" >';
            echo '<div class="traveltour-single-author-wrap" >';
            echo '<div class="traveltour-single-author-avartar traveltour-media-image">' . get_avatar(get_the_author_meta('ID'), 90) . '</div>';

            echo '<div class="traveltour-single-author-content-wrap" >';
            echo '<div class="traveltour-single-author-caption traveltour-info-font" >' . esc_html__('About the author', 'traveltour') . '</div>';
            echo '<h4 class="traveltour-single-author-title">';
            the_author_posts_link();
            echo '</h4>';

            echo '<div class="traveltour-single-author-description" >' . gdlr_core_text_filter($author_desc) . '</div>';
            echo '</div>'; // traveltour-single-author-content-wrap
            echo '</div>'; // traveltour-single-author-wrap
            echo '</div>'; // traveltour-single-author
        }

        // prev - next post navigation
        if (traveltour_get_option('general', 'blog-navigation', 'enable') == 'enable') {
            $prev_post = get_previous_post_link(
                '<span class="traveltour-single-nav traveltour-single-nav-left">%link</span>',
                '<i class="arrow_left" ></i><span class="traveltour-text" >' . esc_html__('Prev', 'traveltour') . '</span>'
            );
            $next_post = get_next_post_link(
                '<span class="traveltour-single-nav traveltour-single-nav-right">%link</span>',
                '<span class="traveltour-text" >' . esc_html__('Next', 'traveltour') . '</span><i class="arrow_right" ></i>'
            );
            if (!empty($prev_post) || !empty($next_post)) {
                echo '<div class="traveltour-single-nav-area clearfix" >' . $prev_post . $next_post . '</div>';
            }
        }

        // comments template
        if (comments_open() || get_comments_number()) {
            comments_template();
        }

        echo '</div>'; // traveltour-content-area
        echo '</div>'; // traveltour-get-sidebar-class

        // sidebar left
        if ($sidebar_type == 'left' || $sidebar_type == 'both') {
            echo traveltour_get_sidebar($sidebar_type, 'left', $sidebar_left);
        }

        // sidebar right
        if ($sidebar_type == 'right' || $sidebar_type == 'both') {
            echo traveltour_get_sidebar($sidebar_type, 'right', $sidebar_right);
        }

        echo '</div>'; // traveltour-get-sidebar-wrap-class
        echo '</div>'; // traveltour-content-container

        get_footer();
    }
    elseif ( get_post_type() == 'hostal') {

        if ( !is_admin() ){
            add_action('wp_enqueue_scripts', 'tourmaster_enqueue_script');
        }

        if( !empty($_POST['tour_temp']) ){
            $temp_data = tourmaster_process_post_data($_POST['tour_temp']);
            $temp_data = json_decode($temp_data, true);
            unset($temp_data['tour-id']);
        }


        get_header();

        echo '<div class="tourmaster-page-wrapper" id="tourmaster-page-wrapper" >';

        global $current_user;
        $tour_style = new tourmaster_tour_style();
        $tour_option = tourmaster_get_post_meta(get_the_ID(), 'tourmaster-tour-option');
        $tour_option['form-settings'] = empty($tour_option['form-settings'])? 'booking': $tour_option['form-settings'];

        ////////////////////////////////////////////////////////////////////
        // header section
        ////////////////////////////////////////////////////////////////////
        if( empty($tour_option['header-image']) || $tour_option['header-image'] == 'feature-image' ){
            echo '<div class="tourmaster-single-header" ' . tourmaster_esc_style(array('background-image' => get_post_thumbnail_id())) . ' >';
        }else if( $tour_option['header-image'] == 'custom-image' && !empty($tour_option['header-image-custom']) ){
            echo '<div class="tourmaster-single-header" ' . tourmaster_esc_style(array('background-image' => $tour_option['header-image-custom'])) . ' >';
        }else if( $tour_option['header-image'] == 'slider' && !empty($tour_option['header-slider']) ){
            $slides = array();
            $thumbnail_size = empty($tour_option['header-slider-thumbnail'])? 'full': $tour_option['header-slider-thumbnail'];
            foreach( $tour_option['header-slider'] as $slider ){
                $slides[] = '<div class="tourmaster-media-image" >' . tourmaster_get_image($slider['id'], $thumbnail_size) . '</div>';
            }

            echo '<div class="tourmaster-single-header tourmaster-with-slider" >';
            echo gdlr_core_get_flexslider($slides, array('navigation' => 'none'));
        }else if( $tour_option['header-image'] == 'gallery' && !empty($tour_option['header-slider']) ){
            $header_image = $tour_option['header-slider'][0]['id'];
            echo '<div class="tourmaster-single-header" ' . tourmaster_esc_style(array('background-image' => $tour_option['header-slider'][0]['id'])) . ' >';
        }else{
            echo '<div class="tourmaster-single-header" >';
        }

        echo '<div class="tourmaster-single-header-top-overlay" ></div>';
        echo '<div class="tourmaster-single-header-overlay" ></div>';
        echo '<div class="tourmaster-single-header-container tourmaster-container" >';
        echo '<div class="tourmaster-single-header-container-inner" >';
        echo '<div class="tourmaster-single-header-title-wrap tourmaster-item-pdlr" ';
        if( empty($tour_option['header-image']) || in_array($tour_option['header-image'], array('feature-image', 'custom-image')) ){
            echo tourmaster_esc_style(array(
                'padding-top' => empty($tour_option['header-top-padding'])? '': $tour_option['header-top-padding'],
                'padding-bottom' => empty($tour_option['header-bottom-padding'])? '': $tour_option['header-bottom-padding'],
            ));
        }
        echo ' >';
        if( $tour_option['header-image'] == 'gallery' && !empty($tour_option['header-slider']) ){
            $lb_group = 'tourmaster-single-header-gallery';
            $count = 0;

            echo '<div class="tourmaster-single-header-gallery-wrap" >';
            foreach($tour_option['header-slider'] as $slider){ $count++;
                $lightbox_atts = array(
                    'url' => tourmaster_get_image_url($slider['id']),
                    'group' => $lb_group
                );

                if( $count == 1 ){
                    $lightbox_atts['class'] = 'tourmaster-single-header-gallery-button';
                    echo '<a ' . gdlr_core_get_lightbox_atts($lightbox_atts) . ' >';
                    echo '<i class="fa fa-image" ></i>' . esc_html__('Gallery', 'tourmaster');
                    echo '</a>';
                }else{
                    echo '<a ' . gdlr_core_get_lightbox_atts($lightbox_atts) . ' ></a>';
                }
            }
            echo '</div>';
        }
        echo '<h1 class="tourmaster-single-header-title" >' . get_the_title() . '</h1>';
        echo $tour_style->get_rating();

        echo '</div>'; // tourmaster-single-header-title-wrap

        $header_price  = '<div class="tourmaster-header-price tourmaster-item-mglr" >';
        if( $tour_option['form-settings'] == 'enquiry' && !empty($tour_option['show-price']) && $tour_option['show-price'] == 'disable' ){

            $header_price .= '<div class="tourmaster-header-enquiry-ribbon" ></div>';
            $header_price .= '<div class="tourmaster-header-price-wrap" >';
            $header_price .= '<div class="tourmaster-header-price-overlay" ></div>';
            $header_price .= '<span class="tourmaster-header-enquiry" >';
            $header_price .= esc_html__('Send Us An Enquiry', 'tourmaster');
            $header_price .= '</span>';
            $header_price .= '</div>'; // tourmaster-header-price-wrap

        }else{

            $header_price .= '<div class="tourmaster-header-price-ribbon" >';
            if( !empty($tour_option['promo-text']) ){
                $header_price .= $tour_option['promo-text'];
            }else{
                $header_price .= esc_html__('Price', 'tourmaster');
            }
            $header_price .= '</div>';
            $header_price .= '<div class="tourmaster-header-price-wrap" >';
            $header_price .= '<div class="tourmaster-header-price-overlay" ></div>';
            $header_price .= $tour_style->get_price(array('with-info' => true));
            $header_price .= '</div>'; // tourmaster-header-price-wrap
        }
        $header_price .= '</div>'; // touramster-header-price

        echo $header_price;
        echo '</div>'; // tourmaster-single-header-container-inner
        echo '</div>'; // tourmaster-single-header-container
        echo '</div>'; // tourmaster-single-header


        ////////////////////////////////////////////////////////////////////
        // content section
        ////////////////////////////////////////////////////////////////////
        echo '<div class="tourmaster-template-wrapper" >';

        // tourmaster booking bar
        echo '<div class="tourmaster-tour-booking-bar-container tourmaster-container" >';
        echo '<div class="tourmaster-tour-booking-bar-container-inner" >';
        echo '<div class="tourmaster-tour-booking-bar-anchor tourmaster-item-mglr" ></div>';
        echo '<div class="tourmaster-tour-booking-bar-wrap tourmaster-item-mglr" id="tourmaster-tour-booking-bar-wrap" >';
        echo '<div class="tourmaster-tour-booking-bar-outer" >';
        echo $header_price;

        echo '<div class="tourmaster-tour-booking-bar-inner" >';

        if(  $tour_option['form-settings'] == 'both' ){
            echo '<div class="tourmaster-booking-tab-title clearfix" id="tourmaster-booking-tab-title" >';
            echo '<div class="tourmaster-booking-tab-title-item tourmaster-active" data-tourmaster-tab="booking" >' . esc_html__('Booking Form', 'tourmaster') . '</div>';
            echo '<div class="tourmaster-booking-tab-title-item" data-tourmaster-tab="enquiry" >' . esc_html__('Enquiry Form', 'tourmaster') . '</div>';
            echo '</div>';
        }

        // enquiry form
        if( $tour_option['form-settings'] == 'enquiry' || $tour_option['form-settings'] == 'both' ){
            echo ($tour_option['form-settings'] == 'both')? '<div class="tourmaster-booking-tab-content" data-tourmaster-tab="enquiry" >': '';

            echo '<div class="tourmaster-tour-booking-enquiry-wrap" >';
            echo tourmaster_get_enquiry_form();
            echo '</div>';

            echo ($tour_option['form-settings'] == 'both')? '</div>': '';
        }

        // booking form
        if( $tour_option['form-settings'] == 'booking' || $tour_option['form-settings'] == 'both' ){
            echo ($tour_option['form-settings'] == 'both')? '<div class="tourmaster-booking-tab-content tourmaster-active" data-tourmaster-tab="booking" >': '';

            // external url ( referer )
            if( !empty($tour_option['link-proceed-booking-to-external-url']) ){

                echo '<div class="tourmaster-single-tour-booking-referral" >';
                if( !empty($tour_option['external-url-text']) ){
                    echo '<div class="tourmaster-single-tour-booking-referral-text" >';
                    echo tourmaster_content_filter($tour_option['external-url-text']);
                    echo '</div>';
                }
                echo '<a class="tourmaster-button" href="' . esc_html($tour_option['link-proceed-booking-to-external-url']) . '" target="_blank" >' . esc_html__('Proceed Booking', 'tourmaster') . '</a>';
                echo '</div>';

                // normal form
            }else{

                echo '<form class="tourmaster-single-tour-booking-fields tourmaster-form-field tourmaster-with-border" method="post" ';
                echo 'action="' . esc_url(tourmaster_get_template_url('payment')) . '" ';
                echo 'id="tourmaster-single-tour-booking-fields" data-ajax-url="' . esc_url(TOURMASTER_AJAX_URL) . '" >';

                echo '<input type="hidden" name="tour-id" value="' . esc_attr(get_the_ID()) . '" />';
                $available_date = explode(',', get_post_meta(get_the_ID(), 'tourmaster-tour-date-avail', true));
                if( !empty($available_date) ){
                    echo '<div class="tourmaster-tour-booking-date clearfix" data-step="1" >';
                    echo '<i class="fa fa-calendar" ></i>';
                    echo '<div class="tourmaster-tour-booking-date-input" >';

                    $selected_date = $available_date[0];
                    if( !empty($temp_data['tour-date']) ){
                        $selected_date = $temp_data['tour-date'];
                        unset($temp_data['tour-date']);
                    }
                    if( sizeof($available_date) == 1 ){
                        echo '<div class="tourmaster-tour-booking-date-display" >' . tourmaster_date_format($selected_date) . '</div>';
                        echo '<input type="hidden" name="tour-date" value="' . esc_attr($selected_date) . '" />';
                    }else{
                        $date_selection_type = empty($tour_option['date-selection-type'])? 'calendar': $tour_option['date-selection-type'];

                        if( $date_selection_type == 'calendar' ){
                            echo '<div class="tourmaster-datepicker-wrap" >';
                            echo '<input type="text" class="tourmaster-datepicker" readonly ';
                            echo 'value="' . esc_attr($selected_date) . '" ';
                            echo 'data-date-format="' . esc_attr(tourmaster_get_option('general', 'datepicker-date-format', 'd M yy')) . '" ';
                            echo 'data-tour-range="' . (empty($tour_option['multiple-duration'])? 1: intval($tour_option['multiple-duration'])) . '" ';
                            echo 'data-tour-date="' . esc_attr(json_encode($available_date)) . '" />';
                            echo '<input type="hidden" name="tour-date" class="tourmaster-datepicker-alt" />';
                            echo '</div>';

                        }else if( $date_selection_type == 'date-list'){
                            echo '<div class="tourmaster-combobox-wrap tourmaster-tour-date-combobox" >';
                            echo '<select name="tour-date" >';
                            foreach( $available_date as $available_date_single ){
                                echo '<option value="' . esc_attr($available_date_single) . '" ' . ($selected_date == $available_date_single? 'selected': '') . ' >';
                                echo tourmaster_date_format($available_date_single);
                                echo '</option>';
                            }
                            echo '</select>';
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                    echo '</div>'; // tourmaster-tour-booking-date

                    $booking_value = array();
                    if( !empty($temp_data) ){
                        $booking_value = array(
                            'tour-people' => empty($temp_data['tour-people'])? '': $temp_data['tour-people'],
                            'tour-room' => empty($temp_data['tour-room'])? '': $temp_data['tour-room'],
                            'tour-adult' => empty($temp_data['tour-adult'])? '': $temp_data['tour-adult'],
                            'tour-children' => empty($temp_data['tour-children'])? '': $temp_data['tour-children'],
                            'tour-student' => empty($temp_data['tour-student'])? '': $temp_data['tour-student'],
                            'tour-infant' => empty($temp_data['tour-infant'])? '': $temp_data['tour-infant'],
                        );
                        unset($temp_data['tour-people']);
                        unset($temp_data['tour-room']);
                        unset($temp_data['tour-adult']);
                        unset($temp_data['tour-children']);
                        unset($temp_data['tour-student']);
                        unset($temp_data['tour-infant']);
                    }

                    echo tourmaster_get_tour_booking_fields(array(
                        'tour-id' => get_the_ID(),
                        'tour-date' => $selected_date
                    ), $booking_value);
                }else{
                    echo '<div class="tourmaster-tour-booking-bar-error" data-step="999" >';
                    echo esc_html__('The tour is not available yet.', 'tourmaster');
                    echo '</div>';
                }

                // carry over data
                if( !empty($temp_data) ){
                    foreach( $temp_data as $field_name => $field_value ){
                        if( is_array($field_value) ){
                            foreach( $field_value as $field_single_value ){
                                echo '<input type="hidden" name="' . esc_attr($field_name) . '[]" value="' . esc_attr($field_single_value) . '" />';
                            }
                        }else{
                            echo '<input type="hidden" name="' . esc_attr($field_name) . '" value="' . esc_attr($field_value) . '" />';
                        }
                    }
                }

                echo '</form>'; // tourmaster-tour-booking-fields

            } // normal form

            // if not logging in print the login before proceed form
            if( !is_user_logged_in() ){
                echo tourmaster_lightbox_content(array(
                    'id' => 'proceed-without-login',
                    'title' => esc_html__('Proceed Booking', 'tourmaster'),
                    'content' => tourmaster_get_login_form2(false, array(
                        'continue-as-guest'=>true,
                        'redirect'=>'payment'
                    ))
                ));
            }

            echo ($tour_option['form-settings'] == 'both')? '</div>': '';

        } // booking form

        // bottom bar for wish list and view count
        echo '<div class="tourmaster-booking-bottom clearfix" >';

        // wishlist section
        $logged_in = is_user_logged_in();
        if( !$logged_in ){
            echo '<div class="tourmaster-save-wish-list" data-tmlb="wish-list-login" >';
        }else{
            $wish_list = get_user_meta($current_user->ID, 'tourmaster-wish-list', true);
            $wish_list = empty($wish_list)? array(): $wish_list;
            $wish_list_active = in_array(get_the_ID(), $wish_list);

            if( !$wish_list_active ){
                echo '<div class="tourmaster-save-wish-list" ';
                echo 'id="tourmaster-save-wish-list" ';
                echo 'data-ajax-url="' . esc_url(TOURMASTER_AJAX_URL) . '" ';
                echo 'data-tour-id="' . esc_attr(get_the_ID()) . '" ';
                echo '>';
            }else{
                echo '<div class="tourmaster-save-wish-list tourmaster-active" >';
            }
        }
        echo '<span class="tourmaster-save-wish-list-icon-wrap" >';
        echo '<i class="tourmaster-icon-active fa fa-heart" ></i>';
        echo '<i class="tourmaster-icon-inactive fa fa-heart-o" ></i>';
        echo '</span>';
        echo esc_html__('Save To Wish List', 'tourmaster');
        echo '</div>'; // tourmaster-save-wish-list
        if( !$logged_in ){
            echo tourmaster_lightbox_content(array(
                'id' => 'wish-list-login',
                'title' => esc_html__('Adding item to wishlist requires an account', 'tourmaster'),
                'content' => tourmaster_get_login_form2(false)
            ));
        }

        echo '<div class="tourmaster-view-count" >';
        echo '<i class="fa fa-eye" ></i>';
        echo '<span class="tourmaster-view-count-text" >' . $view_count . '</span>';
        echo '</div>'; // tourmaster-view-count
        echo '</div>'; // tourmaster-booking-bottom

        echo '</div>'; // tourmaster-tour-booking-bar-inner
        echo '</div>'; // tourmaster-tour-booking-bar-outer

        // sidebar widget
        if( !empty($tour_option['sidebar-widget']) && $tour_option['sidebar-widget'] != 'none' ){
            $sidebar_class = apply_filters('gdlr_core_sidebar_class', '');

            $mobile_widget = tourmaster_get_option('general', 'enable-single-sidebar-widget-on-mobile', 'enable');
            if( $mobile_widget == 'disable' ){
                $sidebar_class .= ' tourmaster-hide-on-mobile';
            }

            echo '<div class="tourmaster-tour-booking-bar-widget ' . esc_attr($sidebar_class) . '" >';
            if( $tour_option['sidebar-widget'] == 'default' ){
                $sidebar_name = tourmaster_get_option('general', 'single-tour-default-sidebar', 'none');
                if( $sidebar_name != 'none' && is_active_sidebar($sidebar_name) ){
                    dynamic_sidebar($sidebar_name);
                }
            }else{
                if( is_active_sidebar($tour_option['sidebar-widget']) ){
                    dynamic_sidebar($tour_option['sidebar-widget']);
                }
            }
            echo '</div>';
        }
        echo '</div>'; // tourmaster-tour-booking-bar-wrap
        echo '</div>'; // tourmaster-tour-booking-bar-container-inner
        echo '</div>'; // tourmaster-tour-booking-bar-container

        // print tour top info
        echo '<div class="tourmaster-tour-info-outer" >';
        echo '<div class="tourmaster-tour-info-outer-container tourmaster-container" >';
        echo $tour_style->get_info(array( 'duration-text', 'availability', 'departure-location', 'return-location', 'minimum-age', 'maximum-people'), array(
            'info-class' => 'tourmaster-item-pdlr'
        ));
        echo '</div>'; // tourmaster-tour-info-outer-container
        echo '</div>'; // tourmaster-tour-info-outer

        global $post;

            if( empty($tour_option['show-wordpress-editor-content']) || $tour_option['show-wordpress-editor-content'] == 'enable' ){
                ob_start();
                the_content();
                $content = ob_get_contents();
                ob_end_clean();

                if( !empty($content) ){
                    echo '<div class="tourmaster-container" >';
                    echo '<div class="tourmaster-page-content tourmaster-item-pdlr" >';
                    echo '<div class="tourmaster-single-main-content" >' . $content . '</div>'; // tourmaster-single-main-content
                    echo '</div>'; // tourmaster-page-content
                    echo '</div>'; // tourmaster-container
                }
            }


        if( !post_password_required() ){
            do_action('gdlr_core_print_page_builder');
        }

        ////////////////////////////////////////////////////////////////////
        // related tour section
        ////////////////////////////////////////////////////////////////////
        $related_tour = tourmaster_get_option('general', 'enable-single-related-tour', 'enable');

        if( $related_tour == 'enable' ){

            $related_tour_args = apply_filters('tourmaster_single_related_tour_args', array(
                'tour-style' => tourmaster_get_option('general', 'single-related-tour-style', 'grid'),
                'thumbnail-size' => tourmaster_get_option('general', 'single-related-tour-thumbnail-size', 'large'),
                'excerpt' => tourmaster_get_option('general', 'single-related-tour-excerpt', 'none'),
                'excerpt-number' => tourmaster_get_option('general', 'single-related-tour-excerpt-number', '20'),
                'column-size' => tourmaster_get_option('general', 'single-related-tour-column-size', '30'),
                'price-position' => tourmaster_get_option('general', 'single-related-tour-price-position', 'right-title'),
                'tour-rating' => tourmaster_get_option('general', 'single-related-tour-rating', 'enable'),
                'tour-info' => tourmaster_get_option('general', 'single-related-tour-info', ''),
            ));

            // query related portfolio
            $args = array('post_type' => 'tour', 'suppress_filters' => false);
            $args['posts_per_page'] = tourmaster_get_option('general', 'single-related-tour-num-fetch', '2');
            $args['post__not_in'] = array(get_the_ID());

            $related_terms = get_the_terms(get_the_ID(), 'tour_tag');
            $related_tags = array();
            if( !empty($terms) ){
                foreach( $related_terms as $term ){
                    $related_tags[] = $term->term_id;
                }
                $args['tax_query'] = array(array('terms'=>$related_tags, 'taxonomy'=>'tour_tag', 'field'=>'id'));
            }
            $query = new WP_Query($args);

            // print item
            if( $query->have_posts() ){

                $tour_style = new tourmaster_tour_style();

                echo '<div class="tourmaster-single-related-tour tourmaster-tour-item tourmaster-style-' . esc_attr($related_tour_args['tour-style']) . '">';
                echo '<div class="tourmaster-single-related-tour-container tourmaster-container">';
                echo '<h3 class="tourmaster-single-related-tour-title tourmaster-item-pdlr">' . esc_html__('Related Tours', 'tourmaster') . '</h3>';

                $column_sum = 0;
                $no_space = in_array($related_tour_args['tour-style'], array('grid-no-space', 'modern-no-space'))? 'yes': 'no';
                echo '<div class="tourmaster-tour-item-holder clearfix ' . ($no_space == 'yes'? ' tourmaster-item-pdlr': '') . '" >';
                while( $query->have_posts() ){ $query->the_post();

                    $additional_class  = ' tourmaster-column-' . $related_tour_args['column-size'];
                    $additional_class .= ($no_space == 'yes')? '': ' tourmaster-item-pdlr';
                    $additional_class .= in_array($related_tour_args['tour-style'], array('modern'))? ' tourmaster-item-mgb': '';

                    if( $column_sum == 0 || $column_sum + intval($related_tour_args['column-size']) > 60 ){
                        $column_sum = intval($related_tour_args['column-size']);
                        $additional_class .= ' tourmaster-column-first';
                    }else{
                        $column_sum += intval($related_tour_args['column-size']);
                    }
                    echo '<div class="gdlr-core-item-list ' . esc_attr($additional_class) . '" >';
                    echo $tour_style->get_content($related_tour_args);
                    echo '</div>';
                }
                wp_reset_postdata();

                echo '</div>'; // tourmaster-tour-item-holder

                echo '</div>'; // tourmaster-container
                echo '</div>'; // tourmaster-single-related-tour
            }
        }

        ////////////////////////////////////////////////////////////////////
        // review section
        ////////////////////////////////////////////////////////////////////
        $review_num_fetch = 5;
        $review_args = array(
            'tour_id' => get_the_ID(),
            'review_score' => 'IS NOT NULL',
            'order_status' => array(
                'condition' => '!=',
                'value' => 'cancel'
            )
        );
        $results = tourmaster_get_booking_data($review_args, array(
            'num-fetch' => $review_num_fetch,
            'paged' => 1,
            'orderby' => 'review_date',
            'order' => 'desc'
        ), 'user_id, review_score, review_type, review_description, review_date');

        if( !empty($results) ){
            $max_num_page = intval(tourmaster_get_booking_data($review_args, null, 'COUNT(*)')) / $review_num_fetch;

            echo '<div class="tourmaster-single-review-container tourmaster-container" >';
            echo '<div class="tourmaster-single-review-item tourmaster-item-pdlr" >';
            echo '<div class="tourmaster-single-review" id="tourmaster-single-review" >';

            echo '<div class="tourmaster-single-review-head clearfix" >';
            echo '<div class="tourmaster-single-review-head-info clearfix" >';
            echo $tour_style->get_rating('plain');

            echo '<div class="tourmaster-single-review-filter" id="tourmaster-single-review-filter" >';
            echo '<div class="tourmaster-single-review-sort-by" >';
            echo '<span class="tourmaster-head" >' . esc_html__('Sort By:', 'tourmaster') . '</span>';
            echo '<span class="tourmaster-sort-by-field" data-sort-by="rating" >' . esc_html__('Rating', 'tourmaster') . '</span>';
            echo '<span class="tourmaster-sort-by-field tourmaster-active" data-sort-by="date" >' . esc_html__('Date', 'tourmaster') . '</span>';
            echo '</div>'; // tourmaster-single-review-sort-by
            echo '<div class="tourmaster-single-review-filter-by tourmaster-form-field tourmaster-with-border" >';
            echo '<div class="tourmaster-combobox-wrap" >';
            echo '<select id="tourmaster-filter-by" >';
            echo '<option value="" >' . esc_html__('Filter By', 'tourmaster'). '</option>';
            echo '<option value="solo" >' . esc_html__('Solo', 'tourmaster'). '</option>';
            echo '<option value="couple" >' . esc_html__('Couple', 'tourmaster'). '</option>';
            echo '<option value="family" >' . esc_html__('Family', 'tourmaster'). '</option>';
            echo '</select>';
            echo '</div>'; // tourmaster-combobox-wrap
            echo '</div>'; // tourmaster-single-review-filter-by
            echo '</div>'; // tourmaster-single-review-filter
            echo '</div>'; // tourmaster-single-review-head-info
            echo '</div>'; // tourmaster-single-review-head

            echo '<div class="tourmaster-single-review-content" id="tourmaster-single-review-content" ';
            echo 'data-tour-id="' . esc_attr(get_the_ID()) . '" ';
            echo 'data-ajax-url="' . esc_attr(TOURMASTER_AJAX_URL) . '" >';
            echo tourmaster_get_review_content_list($results);

            echo tourmaster_get_review_content_pagination($max_num_page);
            echo '</div>'; // tourmaster-single-review-content
            echo '</div>'; // tourmaster-single-review
            echo '</div>'; // tourmaster-single-review-item
            echo '</div>'; // tourmaster-single-review-container
        }

        echo '</div>'; // tourmaster-template-wrapper

        echo '</div>'; // tourmaster-page-wrapper

        // urgent message
        if( empty($_COOKIE['tourmaster-urgency-message']) && !empty($tour_option['enable-urgency-message']) && $tour_option['enable-urgency-message'] == 'enable' ){
            $urgency_message_number = 0;
            if( !empty($tour_option['real-urgency-message']) && $tour_option['real-urgency-message'] == 'disable' ){
                $urgency_message_number = rand(intval($tour_option['urgency-message-number-from']), intval($tour_option['urgency-message-number-to']));
            }else{
                $ip_list = get_post_meta(get_the_ID(), 'tourmaster-tour-ip-list', true);
                $ip_list = empty($ip_list)? array(): $ip_list;

                $client_ip = tourmaster_get_client_ip();
                $ip_list[$client_ip] = strtotime('now');

                // remove the user which longer than 1 hour
                $current_time = strtotime('now');
                foreach( $ip_list as $client_ip => $ttl ){
                    if( $current_time > $ttl + 3600 ){
                        unset($ip_list[$client_ip]);
                    }
                }

                $urgency_message_number = sizeof($ip_list);
                update_post_meta(get_the_ID(), 'tourmaster-tour-ip-list', $ip_list);
            }

            echo '<div class="tourmaster-urgency-message" id="tourmaster-urgency-message" data-expire="86400" >';
            echo '<i class="tourmaster-urgency-message-icon fa fa-users" ></i>';
            echo '<div class="tourmaster-urgency-message-text" >';
            echo sprintf(esc_html__('%d travellers are considering this tour right now!', 'tourmaster'), $urgency_message_number);
            echo '</div>';
            echo '</div>';
        }

        get_footer();

    }
} // while



?>