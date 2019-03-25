<?php
//Добавляем поддержку миниатюр
add_theme_support('post-thumbnails');



//Функции для перевода
add_filter( 'locale', 'my_theme_localized' );
function my_theme_localized( $locale ){
    //для перевода на английский нудно раскоментировать строку
    //return 'en_EN';
}

add_action('after_setup_theme', 'active_endglish_translating');

function active_endglish_translating(){
    load_theme_textdomain( 'tranlating_for_bets_theme', get_template_directory() . '/lang' );
}


//добавляем стили
function enqueue_styles() {
    wp_register_style('my_style', get_stylesheet_uri());
    wp_enqueue_style( 'my_style');
}
add_action('wp_enqueue_scripts', 'enqueue_styles');

//добавляем js
function enqueue_scripts () {
    wp_enqueue_script('jquery');
    wp_register_script('newscript', get_template_directory_uri().'/js/script.js');
    wp_enqueue_script('newscript');
    wp_enqueue_script('script_for_form', get_template_directory_uri().'/js/script_for_form.js',[],null,true);
    wp_localize_script('jquery', 'data_for_ajax', [
        'url' => admin_url('admin-ajax.php')
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');

if (function_exists('add_theme_support')) {
    add_theme_support('menus');
}

//ловим ajax запросы
add_action( 'wp_ajax_add_post_from_ajax', 'add_new_post_from_ajax');
add_action( 'wp_ajax_make_bet_from_ajax', 'make_bet_from_ajax');

//обработчики для ajax запросов
function add_new_post_from_ajax(){
    $post_title = trim(wp_strip_all_tags( $_POST['post_title']));
    $post_content = trim(wp_strip_all_tags($_POST['post_content']));
    $type_of_bets = trim(wp_strip_all_tags($_POST['type_of_bets']));
    $post_data = array(
        'post_title'    => $post_title,
        'post_content'  => $post_content,
        'post_status'   => 'publish',
        'post_type' => 'bets_my_type',
        'tax_input' => [
            'type_of_bets' => $type_of_bets
        ]
    );
    if(!$post_title || !$post_content || !$type_of_bets){
        $response = [
            'error'=> 'Что-то пошло не так'
        ];
        echo json_encode($response);
        return;
    }
    $post_id = wp_insert_post( $post_data );
    if($post_id){
        $response = [
            'ok'=> 'ID записи'.$post_id
        ];
        echo json_encode($response);
        return;
    } else {
        $response = [
            'error'=> 'Что-то пошло не так'
        ];
        echo json_encode($response);
        return;
    }
}

function make_bet_from_ajax(){
    $value = intval($_POST['meta_value']);
    if(!($value >= 100) && !($value <= 1000)){
        $response = [
            'error' => 'Неверное значение'
        ];
        echo json_encode($response);
        return;
    }
    $key = $_POST['meta_key'];
    $post_id = $_POST['post_id'];
    $result = add_post_meta($post_id, $key, $value);
    if($result) {
        $response = [
            'ok' => 'ok'
        ];
        echo json_encode($response);
        return;
    } else {
        $response = [
            'error' => 'error'
        ];
        echo json_encode($response);
        return;
    }



}

//фильтр для отрисовки нужного шаблона
add_filter('template_include', 'is_bets_post');
function is_bets_post($path){
    global $post;
    if($post->post_type === 'bets_my_type'){
        wp_register_style('my_style', get_stylesheet_uri());
        wp_enqueue_style( 'my_style');
        return get_stylesheet_directory().'/single-bets.php';
    }
    return $path;
}


//функции для сайдбаров
function true_register_wp_sidebars() {
    register_sidebar(
        array(
            'id' => 'bets_sidebar_side',
            'name' => 'Боковая колонка',
            'description' => 'Боковая колонка для темы о ставках',
            'before_widget' => '<div id="%1$s" class="side widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        )
    );
    register_sidebar(
        array(
            'id' => 'bets_sidebar_footer',
            'name' => 'Футер',
            'description' => 'Футер для темы о ставках',
            'before_widget' => '<div id="%1$s" class="foot widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        )
    );
}

add_action( 'widgets_init', 'true_register_wp_sidebars' );
