<h2 class="blue">Jouw gekozen verblijf</h2>
<p>In de vorige stap koos je voor het volgende verblijf, wil je toch nog je verblijf wijzigen? Dat kan, ga dan terug naar <a href="javascript:history.back()" title="Ga terug naar de vorige stap">de vorige stap</a>.</p>
<div class="box turqoise">
    <input type="hidden" id="accommodation_id" name="accommodation_id" value="<?php echo $_GET['accommodation_id']; ?>"/>
    <div class="content-wrapper">
        <?php
        global $post;
        $post = get_post($_GET['accommodation_id']);
        setup_postdata( $post );
        get_template_part('/elements/accommodation-finder/accommodation-preview-simple');
        wp_reset_postdata();
        ?>
    </div>
</div>
