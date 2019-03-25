<aside class="sidebar_rigth">
    <?php
    if(is_active_sidebar('bets_sidebar_side')){
        dynamic_sidebar('bets_sidebar_side');
        echo '<p>'.__('Боковая колонка', 'tranlating_for_bets_theme').'</p>';
    } else {
        echo __('Нет активных виджетов в боковой колонке', 'tranlating_for_bets_theme');
    }
    ?>
</aside>