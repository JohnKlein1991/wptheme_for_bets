<?php
get_header();
if(is_user_logged_in()) {
    ?>
    <div class="main-heading">
        <h1><?php the_title(); ?></h1>
    </div>
    <section>
        <div class="form">
            <h3><?php echo __('Форма для добавления ставки', 'tranlating_for_bets_theme');?></h3>
            <label><?php echo __('Заголовок', 'tranlating_for_bets_theme');?>
                <br>
                <input type="text" id="input_post_title" name="post_title" required>
            </label>
            <br>
            <br>
            <label><?php echo __('Описание', 'tranlating_for_bets_theme');?>
                <br>
                <textarea name="post_content" id="textarea_post_content" cols="30" rows="10"></textarea>
            </label>
            <br>
            <br>
            <label><?php echo __('Тип ставки', 'tranlating_for_bets_theme');?></label>
                <br>
                <select id="select_type_of_bets">
                <?php
                $args = array(
                    'taxonomy' => 'type_of_bets',
                    'hide_empty' => false,
                );
                $terms = get_terms( $args );
                /*
                echo '<pre>';
                print_r($terms);
                echo '</pre>';
                */
                foreach ($terms as $term){
                    echo '<option value="'.$term->name.'">'.$term->description.'</option>';
                }
                ?>
                </select>
            <br>
            <br>
            <button id="button_for_bet_form"><?php echo __('Добавить', 'tranlating_for_bets_theme');?></button>
        </div>

        <?php get_sidebar(); ?>
    </section>
<?php
    } else {
    echo '<p>'.__('Извините, здесь ничего нет', 'tranlating_for_bets_theme').'</p>';
}
get_footer();
?>