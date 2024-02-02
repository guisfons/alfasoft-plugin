<?php
/**
 * Plugin Name: Contact Management Plugin
 * Plugin URI: https://github.com/guisfons/alfasoft-plugin
 * Description: Plugin dedicated to the contact management.
 * Version: 1.0
 * Author: Guilherme Silva Fonseca
 * Author URI: https://github.com/guisfons
 */


add_action('admin_menu', 'cm_plugin_menu');

function cm_plugin_menu() {
    add_menu_page(
        'Contact Management',
        'Contact Management',
        'manage_options',
        'contact-management-plugin',
        'cm_admin_page'
    );

    add_submenu_page(
        'contact-management-plugin',
        'List People',
        'List People',
        'manage_options',
        'list-people',
        'cm_list_people_page'
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
    
}

function cm_list_people_page() {

}

function cm_add_new_person_page() {

}

function cm_add_new_contact_page() {

}