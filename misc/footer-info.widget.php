<?php
    add_action( 'wp_dashboard_setup', 'zhm_add_contacts_widget');

    function zhm_add_contacts_widget() {
        if (!current_user_can('manage_options')) {
            return;
        }

        wp_add_dashboard_widget( 'zhm_contacts_widget', 'Інформація у футері', 'zhm_contacts_html');
    }

    if (!function_exists('zhm_contacts_html')) {
        function zhm_contacts_html() {
            $contacts_html = get_option('zhm_contacts');
?>

            <style>
                .zhm-contacts-section {
                    width: 100%;
                    display: inline-block;
                }
            </style>
            <form action="options.php" method="post">
                <?php wp_nonce_field('update-options'); ?>
                <div class="form-inner">
                    <div class="zhm-contacts-section">
                        <h3>Контактні дані</h3>
                        <?php wp_editor( $contacts_html, 'zhm_contacts', array('textarea_name'=>'zhm_contacts') ); ?>
                    </div>
                    <input type="hidden" name="action" value="update"/>
                    <input type="hidden" name="page_options" value="zhm_contacts" />
                </div>
                <input type="submit" class="button-primary" value="Зберегти">
            </form>
            
            
<?php
            
        }
    }
?>