<?php get_header(); ?>
    <section>

        <?php
        $parametres = array(
            'post_type' => 'bets_my_type',
            'numberposts' => 10
        );
        $betsArray = get_posts($parametres);
        foreach ($betsArray as $bet){
        ?>
            <div class="bets_post">
                <h3><?=$bet->post_title?></h3>
                <p><?=$bet->post_content?></p>
                <a href="<?=get_permalink($bet->ID)?>">Перейти</a>
            </div>
            <?php
        }
        ?>

    </section>
<?php get_footer(); ?>