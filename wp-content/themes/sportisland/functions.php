<?php


$widgets = [
    'widget-text.php',
    'widget-contact.php',
    'widget-social-links.php',
    'widget-iframe.php',
    'widget-info.php'
];

foreach ($widgets as $w) {
    require_once (__DIR__ . '/inc/' . $w);
}



add_action('after_setup_theme', 'si_setup');
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
add_action( 'widgets_init', 'register_my_widgets' );
add_action('init','si_register_types');
add_action('save_post', 'si_save_like_meta');
add_shortcode('si-paste-link', 'si_paste_link');

add_filter('show_admin_bar', '__return_false');
add_filter('si_widget_text', 'do_shortcode');
add_action('add_meta_boxes', 'si_meta_boxes');
//add_post_meta($id, $slug, $value);



function my_scripts_method(){
    wp_enqueue_script( 'newscript', _si_assets_path ('js/js.js'));
    wp_enqueue_style( 'newstyle', get_stylesheet_uri());
    wp_enqueue_style( 'customstyle', _si_assets_path ('css/styles.css'));
}

function si_meta_like_cb( $post_obj ){
    $likes = get_post_meta( $post_obj->ID, 'si-like', true );
    $likes = $likes ? $likes : 0;
    echo "<input type=\"text\" name=\"si-like\" value=\"${likes}\">";
    //echo '<p>' . $likes . '</p>';
}

function si_save_like_meta( $post_id ) {
    if( isset( $_POST['si-like'] ) ) {
        update_post_meta( $post_id, 'si-like', $_POST['si-like'] );
    }
}

function _si_assets_path ( $path ) {
    return get_template_directory_uri() . '/assets/' . $path;
}

function si_setup() {
    register_nav_menu('header-menu', 'Header menu');
    register_nav_menu('footer-menu', 'Footer menu');

    add_theme_support('custom-logo');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    /*add_theme_support('menus');*/
}

function si_register_types() {
    register_post_type( 'services', [
        'label'  => null,
        'labels' => [
            'name'               => 'Services', // основное название для типа записи
            'singular_name'      => 'Service', // название для одной записи этого типа
            'add_new'            => 'Add New Service', // для добавления новой записи
            'add_new_item'       => 'Add New Service', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Edit Service', // для редактирования типа записи
            'new_item'           => 'New Service', // текст новой записи
            'view_item'          => 'View Service', // для просмотра записи этого типа.
            'search_items'       => 'Search Service', // для поиска по этим типам записи
            'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Not found in basket', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Service', // название меню
        ],
        'description'         => '',
        'public'              => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-smiley',
        'hierarchical'        => false,
        'supports'            => [ 'title' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'has_archive'         => true
    ] );
    register_post_type( 'trainers', [
        'label'  => null,
        'labels' => [
            'name'               => 'Trainers', // основное название для типа записи
            'singular_name'      => 'Trainer', // название для одной записи этого типа
            'add_new'            => 'Add New Trainer', // для добавления новой записи
            'add_new_item'       => 'Add New Trainer', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Edit Trainer', // для редактирования типа записи
            'new_item'           => 'New Trainer', // текст новой записи
            'view_item'          => 'View Trainer', // для просмотра записи этого типа.
            'search_items'       => 'Search Trainer', // для поиска по этим типам записи
            'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Not found in basket', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Trainers', // название меню
        ],
        'description'         => '',
        'public'              => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-groups',
        'hierarchical'        => false,
        'supports'            => [ 'title' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'has_archive'         => true
    ] );
    register_post_type( 'schedule', [
        'label'  => null,
        'labels' => [
            'name'               => 'Lessons', // основное название для типа записи
            'singular_name'      => 'Lesson', // название для одной записи этого типа
            'add_new'            => 'Add New Lesson', // для добавления новой записи
            'add_new_item'       => 'Add New Lesson', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Edit Lesson', // для редактирования типа записи
            'new_item'           => 'New Lesson', // текст новой записи
            'view_item'          => 'View Lesson', // для просмотра записи этого типа.
            'search_items'       => 'Search Lesson', // для поиска по этим типам записи
            'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Not found in basket', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Lessons', // название меню
        ],
        'description'         => '',
        'public'              => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-universal-access-alt',
        'hierarchical'        => false,
        'supports'            => [ 'title' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'has_archive'         => true
    ] );
    register_taxonomy( 'schedule_days', [ 'schedule' ], [
        'label'                 => '', // определяется параметром $labels->name
        'labels'                => [
            'name'              => 'Week Days',
            'singular_name'     => 'Week Day',
            'search_items'      => 'Search Week Days',
            'all_items'         => 'All Week Days',
            'view_item '        => 'View Week Day',
            'parent_item'       => 'Parent Week Day',
            'parent_item_colon' => 'Parent Week Day:',
            'edit_item'         => 'Edit Week Day',
            'update_item'       => 'Update Week Day',
            'add_new_item'      => 'Add New Week Day',
            'new_item_name'     => 'New Week Day Name',
            'menu_name'         => 'Week Day',
        ],
        'description'           => '', // описание таксономии
        'public'                => true,
        'hierarchical'          => true,

    ] );
    register_taxonomy( 'places', [ 'schedule' ], [
        'label'                 => '', // определяется параметром $labels->name
        'labels'                => [
            'name'              => 'Places',
            'singular_name'     => 'Place',
            'search_items'      => 'Search Places',
            'all_items'         => 'All Places',
            'view_item '        => 'View Place',
            'parent_item'       => 'Parent Place',
            'parent_item_colon' => 'Parent Place:',
            'edit_item'         => 'Edit Place',
            'update_item'       => 'Update Place',
            'add_new_item'      => 'Add New Place',
            'new_item_name'     => 'New Place Name',
            'menu_name'         => 'Place',
        ],
        'description'           => '', // описание таксономии
        'public'                => true,
        'hierarchical'          => true,

    ] );


    register_post_type( 'prices', [
        'label'  => null,
        'labels' => [
            'name'               => 'Prices', // основное название для типа записи
            'singular_name'      => 'Price', // название для одной записи этого типа
            'add_new'            => 'Add New Price', // для добавления новой записи
            'add_new_item'       => 'Add New Price', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Edit Price', // для редактирования типа записи
            'new_item'           => 'New Price', // текст новой записи
            'view_item'          => 'View Price', // для просмотра записи этого типа.
            'search_items'       => 'Search Price', // для поиска по этим типам записи
            'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Not found in basket', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Prices', // название меню
        ],
        'description'         => '',
        'public'              => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-text-page',
        'hierarchical'        => false,
        'supports'            => [ 'title' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'has_archive'         => true
    ] );
    register_post_type( 'cards', [
        'label'  => null,
        'labels' => [
            'name'               => 'Cards', // основное название для типа записи
            'singular_name'      => 'Card', // название для одной записи этого типа
            'add_new'            => 'Add New Card', // для добавления новой записи
            'add_new_item'       => 'Add New Card', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Edit Card', // для редактирования типа записи
            'new_item'           => 'New Card', // текст новой записи
            'view_item'          => 'View Card', // для просмотра записи этого типа.
            'search_items'       => 'Search Card', // для поиска по этим типам записи
            'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Not found in basket', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Cards', // название меню
        ],
        'description'         => '',
        'public'              => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-tickets-alt',
        'hierarchical'        => false,
        'supports'            => [ 'title' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'has_archive'         => true
    ] );

}

function si_paste_link($attr){
    $params = shortcode_atts([
        'link' => '',
        'text' => '',
        'type' => 'link'
    ], $attr);
    $params['text'] = $params['text'] ? $params['text'] : $params['link'];
    if( $params['link'] ) {
        $protocol = '';
        switch ( $params['type'] ) {
            case 'email':
                $protocol = 'mailto:';
            break;
            case 'phone':
                $protocol = 'tel:';
                $params['link'] = preg_replace('/[^+0-9]/', '', $params['link']);
            break;
            default:
                $protocol = '';
            break;

        }
        $link = $protocol . $params['link'];
        $text = $params['text'];
        return "<a href=\"${link}\">${text}</a>";
    } else {
        return '';
    }

}


function si_meta_boxes() {
    add_meta_box(
        'si-like',
        'Количество лайков: ',
        'si_meta_like_cb',
        'post'
    );
}








function register_my_widgets(){
    register_sidebar( array(
        'name'          => 'Contacts in header',
        'id'            => "si-header",
        'description'   => '',
        'class'         => '',
        'before_widget' => null,
        'after_widget'  => null,

    ) );
    register_sidebar( array(
        'name'          => 'Contacts in footer',
        'id'            => "si-footer",
        'description'   => '',
        'class'         => '',
        'before_widget' => null,
        'after_widget'  => null,

    ) );

    register_sidebar( array(
        'name'          => 'Contacts in footer - Column 1',
        'id'            => "si-footer-column-1",
        'description'   => '',
        'class'         => '',
        'before_widget' => null,
        'after_widget'  => null,

    ) );
    register_sidebar( array(
        'name'          => 'Contacts in footer - Column 2',
        'id'            => "si-footer-column-2",
        'description'   => '',
        'class'         => '',
        'before_widget' => null,
        'after_widget'  => null,

    ) );
    register_sidebar( array(
        'name'          => 'Contacts in footer - Column 3',
        'id'            => "si-footer-column-3",
        'description'   => '',
        'class'         => '',
        'before_widget' => null,
        'after_widget'  => null,

    ) );
    register_sidebar( array(
        'name'          => 'Map',
        'id'            => "si-map",
        'description'   => '',
        'class'         => '',
        'before_widget' => null,
        'after_widget'  => null,

    ) );
    register_sidebar( array(
        'name'          => 'Sidebar under map',
        'id'            => "si-under-map",
        'description'   => '',
        'class'         => '',
        'before_widget' => null,
        'after_widget'  => null,

    ) );


    register_widget('si_widget_text');
    register_widget('si_widget_contacts');
    register_widget('si_widget_social_links');
    register_widget('si_widget_iframe');
    register_widget('si_widget_info');
}

