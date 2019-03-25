    </div>
    <footer></footer>
    <?php
    wp_footer();
    if(is_active_sidebar('bets_sidebar_footer')){
        dynamic_sidebar('bets_sidebar_footer');
        echo '<p>'.__('Футер', 'tranlating_for_bets_theme').'</p>';
    } else {
        echo '<p>'.__('Нет активных виджетов в футере', 'tranlating_for_bets_theme').'</p>';
    }

    ?>
    <p>Это footer темы</p>
</body>
</html>