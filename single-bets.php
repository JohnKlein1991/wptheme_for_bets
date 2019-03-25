<?php
/*
Template Name: Шаблон для ставок
Template Post Type: bets_my_type
*/
get_header();
    //var_dump($post);
    //var_dump(get_the_terms($post->ID, 'type_of_bets'));
    if(is_array(get_the_terms($post->ID, 'type_of_bets'))){
        $bets_type = get_the_terms($post->ID, 'type_of_bets')[0]->name;
    } else {
        $bets_type = __('Отсутствует', 'tranlating_for_bets_theme');
    };
    if(is_array(get_the_terms($post->ID, 'status_of_bets'))){
        $bets_status = get_the_terms($post->ID, 'status_of_bets')[0]->name;
    } else {
        $bets_status = __('Отсутствует', 'tranlating_for_bets_theme');
    };
    ?>
<p><?php echo __('Информация о ставке', 'tranlating_for_bets_theme');?></p>
<div class="bets_post">
    <h3><?=$post->post_title?></h3>
    <p><?=$post->post_content?></p>
    <p><?php echo __('Тип ставки:', 'tranlating_for_bets_theme');?> <span><?=$bets_type?></span></p>
    <p><?php echo __('Статус ставки: ', 'tranlating_for_bets_theme');?><span><?=$bets_status?></span></p>
    <?php
    //var_dump($_COOKIE);
    if(!$_COOKIE['bet_post_'.$post->ID]) {
        ?>
        <input id="sum_of_bet" type="number" min="100" max="1000">
        <input id="post_id" type="hidden" value="<?= $post->ID ?>">
        <button id="button_for_bet"><?php echo __('Ставка пройдет', 'tranlating_for_bets_theme');?></button>
    <?php
    } else {
    ?>
        <input id="sum_of_bet" disabled value="<?=$_COOKIE['bet_post_'.$post->ID]?>">
        <button disabled><?php echo __('Ставка пройдет', 'tranlating_for_bets_theme');?></button>
        <?php
    }
    ?>
</div>
<?php
get_footer();
?>