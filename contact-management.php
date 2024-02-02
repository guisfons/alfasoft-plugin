<?php
/**
 * Plugin Name: Contact Management Plugin
 * Plugin URI: https://github.com/guisfons/alfasoft-plugin
 * Description: Plugin dedicated to the contact management.
 * Version: 1.0
 * Author: Guilherme Silva Fonseca
 * Author URI: https://github.com/guisfons
 */



global $wpdb;
$tablePeople = $wpdb->prefix . 'people';

function cm_init() {
    if(is_admin()) {
        add_action('admin_menu', 'cm_add_menu_pages');

        global $wpdb, $tablePeople;
    
        $charset_collate = $wpdb->get_charset_collate();
    
        $sql = "CREATE TABLE $tablePeople (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL UNIQUE,
            PRIMARY KEY (id)
        ) $charset_collate;";
    
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
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
            <?php
                global $wpdb, $tablePeople;

                $query = "SELECT * FROM $tablePeople";

                $results = $wpdb->get_results($query);

                echo
                '<thead>
                    <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td></td>
                    </tr>
                </thead>
                <tbody>';

                foreach ($results as $result) {
                    echo "<tr><td>{$result->id}</td><td>{$result->name}</td><td>{$result->email}</td></tr>";
                }

                echo '</tbody>';
            ?>
        </table>
    </div>
    <?php
}

function cm_add_new_person_page() {
    global $wpdb;
    

    if (isset($_POST['submit_person'])) {
        // Process form data and add a new person
        $name = sanitize_text_field($_POST['contact_name']);
        $email = sanitize_email($_POST['contact_email']);

        // Validate input before adding to the database
        if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $tablePeople = $wpdb->prefix . 'people';

            insert($tablePeople, ['name' => $name, 'email' => $email]);

            echo '<div class="contact-management__updated"><p>New person added successfully!</p></div>';
        } else {
            echo '<div class="contact-management__error"><p>Please provide valid name and email.</p></div>';
        }
    }
    ?>
    <div class="wrap">
        <section class="contact-management__add">
            <h1>Add New Person</h1>
    
            <form method="post" action="">
                <label for="contact_name">Name: <input type="text" name="contact_name" minlength="5" required></label>
                <label for="contact_email">Email: <input type="email" name="contact_email" required></label>
                <input type="submit" name="submit_person" value="Add Person">
            </form>
        </section>
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

function insert(string $table, array $data) {
    global $wpdb;

    $wpdb->insert(
        $table, $data, array_fill(0, count($data) - 1, '%s')
    );
}