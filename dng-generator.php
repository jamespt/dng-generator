<?php
/*
Plugin Name: Pet Name Generator
Description: Simple and light weight generator of pet names.
Version: 1.0.0
Author: Darfys
Author URI: http://www.graphicarea.pro
*/

function dng_scripts() {

    wp_enqueue_script( 'jquery' );
    wp_register_script( 'dng-scripts', plugins_url( '/js/script.js', __FILE__ ) );
    wp_enqueue_script( 'dng-scripts' );
    wp_enqueue_style( 'dng-styles', plugins_url( '/css/styles.css', __FILE__, array(), '1.1.0' ) );
}

function dng_generator( $args ) {

    $html = file_get_contents( plugins_url( '/html.php', __FILE__ ) );
    return $html ;
}

function javascript_variables() {
    $url = plugins_url( '/', __FILE__ );

    ?>

    <script type = 'text/javascript'>
    var templateUrl = "<?php echo $url; ?>";
    var ajax_url = '<?php echo admin_url( "admin-ajax.php" ); ?>';
    </script><?php
}

function dng_clear_names() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'dng_names';
    $sql = "DELETE FROM $table_name WHERE	(date) != CURDATE()";

    $wpdb->query( $sql );

    wp_die();
}

function dng_get_names() {
    global $wpdb;

    $data;

    $table_name = $wpdb->prefix . 'dng_names';
    $sql = "SELECT name, COUNT(name) FROM $table_name WHERE	(date) = CURDATE() GROUP BY name";

    $result = $wpdb->get_results( $sql );

    foreach ( $result as $value ) {
        $aValue = ( array ) $value;
        $data[$aValue['name']] = intval( $aValue['COUNT(name)'] );
    }

    echo json_encode( $data );

    wp_die();
}

function dng_get_data() {
    global $wpdb;

    $data = (object)[];

    $table_name = $wpdb->prefix . 'dng_data';
    $sql = "SELECT * FROM $table_name";

    $result = $wpdb->get_results( $sql );

    foreach ( $result as $value ) {
        $l = $value->letter;
        $data->$l[] = (object)array("name" => $value->name, "gender" => $value->gender);
    }

    echo json_encode( $data );

    wp_die();
}

function dng_post_names() {
    global $wpdb;

    $data = $_POST['data'];

    $table_name = $wpdb->prefix . 'dng_names';
    $sql = "INSERT INTO $table_name	(date, name) VALUES";

    $numItems = count( $data );
    $i = 0;

    if ( $numItems ) {

        foreach ( $data as $key => $value ) {

            if ( ++$i === $numItems ) {
                $sql .= "(CURDATE(), '$key')";
            } else {
                $sql .= "(CURDATE(), '$key'),";
            }
        }
        $wpdb->query( $sql );
    }

    wp_die();
}

function create_plugin_table() {

    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $isFirst = false;
    $sql = '';

    $db_table_names = $wpdb->prefix . 'dng_names';
    $db_table_data = $wpdb->prefix . 'dng_data';

    $charset_collate = $wpdb->get_charset_collate();

    if ( $wpdb->get_var( "SHOW TABLES LIKE '$db_table_names'" ) != $db_table_names ) {
        $sql = "CREATE TABLE $db_table_names (id int(11) NOT NULL auto_increment, date date NOT NULL, name varchar(60) NOT NULL, UNIQUE KEY id (id)) $charset_collate;";
    }

    if ( $wpdb->get_var( "SHOW TABLES LIKE '$db_table_data'" ) != $db_table_data ) {
        $sql .= "CREATE TABLE $db_table_data (id int(11) NOT NULL auto_increment, letter varchar(60) NOT NULL, name varchar(60) NOT NULL UNIQUE, gender varchar(60) NOT NULL, UNIQUE KEY id (id)) $charset_collate;";
        $isFirst = true;
    }

    dbDelta( $sql );

    if ( $isFirst ) {
        $sql = "INSERT INTO $db_table_data	(letter, name, gender) VALUES";

        $file = file_get_contents( plugins_url( '/data/namesTemp.json', __FILE__ ) );
        $data = json_decode( $file, true );

        $numItems = count( $data );
        $i = 0;

        foreach ( $data as $key => $val ) {

            if ( ++$i === $numItems ) {
                $numI = count( $val );
                $z = 0;
                foreach ( $val as $v ) {
                    if ( ++$z === $numI ) {
                        $sql .= "('$key', '".$v['name']."', '".$v['gender']."')";
                    } else {
                        $sql .= "('$key', '".$v['name']."', '".$v['gender']."'),";
                    }
                }
            } else {
                foreach ( $val as $v ) {
                    $sql .= "('$key', '".$v['name']."', '".$v['gender']."'),";
                }
            }
        }

        //error_log($sql);

        $wpdb->query( $sql );

        //trigger_error( $sql, E_USER_ERROR );
    }

}

register_activation_hook( __FILE__, 'create_plugin_table' );

add_shortcode( 'dng-generator', 'dng_generator' );

add_action( 'wp_enqueue_scripts', 'dng_scripts' );
add_action ( 'wp_head', 'javascript_variables' );

add_action( 'wp_ajax_dng_post_names', 'dng_post_names' );
add_action( 'wp_ajax_nopriv_dng_post_names', 'dng_post_names' );

add_action( 'wp_ajax_dng_clear_names', 'dng_clear_names' );
add_action( 'wp_ajax_nopriv_dng_clear_names', 'dng_clear_names' );

add_action( 'wp_ajax_dng_get_names', 'dng_get_names' );
add_action( 'wp_ajax_nopriv_dng_get_names', 'dng_get_names' );

add_action( 'wp_ajax_dng_get_data', 'dng_get_data' );
add_action( 'wp_ajax_nopriv_dng_get_data', 'dng_get_data' );

// DASHBOARD WIDGET

function ch_add_dashboard_widgets() {

    wp_add_dashboard_widget( 'user_email_admin_dashboard_widget', __( 'Pet name generator', 'ch_user_widget' ), 'ch_user_email_admin_dashboard_widget' );

}

add_action( 'wp_dashboard_setup', 'ch_add_dashboard_widgets' );

function ch_user_email_admin_dashboard_widget() {

    $user = wp_get_current_user();
    ?>

    <form id = 'ch_form' action = "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method = 'post' >

    <input type = 'hidden' name = 'dng_action' id = 'dng_action' value = 'dng_user_data'>

    <?php wp_nonce_field( 'dng_nonce', 'dng_nonce_field' );
    ?>

    <p>Please add new names to the database.<br> Each new name must be in a new line</p>

    <p>
        <label for = 'female' style = 'display:block;margin-bottom:5px'><strong>Female</strong></label>
        <textarea style = 'width:100%' type = 'text' name = 'female' id = 'dng_female' class = 'regular-text' /></textarea>
    </p>
    <p>
        <label for = 'male' style = 'display:block;margin-bottom:5px'><strong>Male</strong></label>
        <textarea style = 'width:100%' type = 'text' name = 'male' id = 'dng_male' class = 'regular-text' /></textarea>
    </p>
    <p>
        <table style = 'width:100%'>
            <tbody>
                <tr>
                    <td width = '30%'><input name = 'save-data' id = 'save-data' class = 'button button-primary' value = 'Add' type = 'submit'></td><td><span style = 'color:green;' id="dng-message"></span></td>
                </tr>
            </tbody>
        </table>
    </p>

    </form>

    <?php
}

function dng_save_user_data() {

    global $wpdb;

    if ( array_key_exists( 'nonce', $_POST ) AND  wp_verify_nonce( $_POST['nonce'], 'dng_nonce' ) ) {

        $data = $_POST;

        $table_data = $wpdb->prefix . 'dng_data';

        $sql = "INSERT IGNORE INTO $table_data (letter, name, gender) VALUES";

        if($data["female"]) {
            $female =  preg_split("/\\r\\n|\\r|\\n/", $data["female"]);
        }

        if($data["male"]){
            $male =   preg_split("/\\r\\n|\\r|\\n/", $data["male"]);
        }

        $numFemale = count( $female );
        $numMale = count( $male );
        $i = 0;
        $z = 0;

        if ( $numFemale ) {
    
            foreach ( $female as $key => $value ) {
                $letter = strtolower($value[0]);

                if ( ++$i === $numFemale ) {
                    $sql .= "('$letter', '$value', 'female')";
                } else {
                    $sql .= "('$letter', '$value', 'female'),";
                }
            }

            if ( $numMale ) {
                $sql .= ",";
            }
        }

        if ( $numMale ) {
    
            foreach ( $male as $key => $value ) {
                $letter = strtolower($value[0]);

                if ( ++$z === $numMale ) {
                    $sql .= "('$letter', '$value', 'male')";
                } else {
                    $sql .= "('$letter', '$value', 'male'),";
                }
            }
        }

        //wp_send_json( $sql );

        $wpdb->query( $sql );

        $msg = $wpdb->rows_affected;

    } else {

        $msg = 'Error';
    }

    wp_send_json( $msg );
}

add_action( 'wp_ajax_dng_user_data', 'dng_save_user_data' );

function dng_add_script( $hook ) {

    if ( 'index.php' !== $hook ) {
        return;
    }

    wp_enqueue_script( 'ch_widget_script', plugin_dir_url( __FILE__ ) .'/js/widget-script.js', array(), NULL, true );
}

add_action( 'admin_enqueue_scripts', 'dng_add_script' );

?>
