<?php
/**
 * Plugin Name: Contact Management Plugin
 * Plugin URI: https://github.com/guisfons/alfasoft-plugin
 * Description: Plugin dedicated to the contact management.
 * Version: 1.0
 * Author: Guilherme Silva Fonseca
 * Author URI: https://github.com/guisfons
 */


function cm_init() {
    if(is_admin()) {
        add_action('admin_menu', 'cm_add_menu_pages');
    }

    // Public part
    add_shortcode('contact_management_people', 'cm_public_people_shortcode');
}

add_action('init', 'cm_init');

function cm_add_menu_pages() {
    // Management part
    add_menu_page(
        'Contact Management',
        'Contact Management',
        'manage_options',
        'contact-management-plugin',
        'cm_admin_page'
    );

    add_submenu_page(
        'contact-management-plugin',
        'Add New Person / Edit Person',
        'Add New Person / Edit Person',
        'manage_options',
        'add-new-person',
        'cm_add_new_person_page'
    );

    add_submenu_page(
        'contact-management-plugin',
        'Add New Contact / Edit Contacts',
        'Add New Contact / Edit Contacts',
        'manage_options',
        'add-new-contact',
        'cm_add_new_contact_page'
    );
}

function cm_admin_page() {
    ?>
    <div class="wrap">
        <h1>Contact Management</h1>
        <p>Welcome to the Contact Management plugin!</p>

        <hr>

        <h2>List People</h2>
        <table class="widefat">
        </table>
    </div>
    <?php
}

function cm_add_new_person_page() {
    ?>
    <div class="wrap">
        <h1>Add New Person</h1>
    </div>
    <?php
}

function cm_add_new_contact_page() {
    ?>
    <div class="wrap">
        <h1>List Contacts</h1>
        <table class="widefat">
        </table>
    </div>
    <?php
}

function cm_public_people_shortcode($atts) {
    ob_start();
?>
    <section class="contact-management">
        <h1>List of people</h1>
        
    </section>    
<?php
return ob_get_clean();
}