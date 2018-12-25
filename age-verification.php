<?php
/**
 * Plugin Name: Age check
 * Description: Age verification pop-up.
 * Version: 1.0.0
 * Plugin URI: https://pimclick.com
 * Author: Gaël ROBIN
 * Author URI: https://pimclick.com
 */

function age_verification_popup() {
    if(!isset($_COOKIE['age_verification'])) {
      if (get_locale()== 'fr_FR') {
        ?>
        <div class="age-verification-overlay">
            <div class="age-verification-popup">
              <div class="age-verification-main-container">
                <div class="age-verification-title">
                  <p class="age-verification-q">Avez<br>vous<br>plus de<br>18 ans ?</p>
                </div>
                <div class="age-verification-no">
                    <a class="age-verification-btn age-verification-btn-no" href="#">Non</a>
                </div>
                <div class="age-verification-yes">
                  <a class="age-verification-btn age-verification-btn-yes" href="#">Oui</a>
                </div>
              </div>
            </div>
        </div>
        <?php
      } else {
      ?>

      <div class="age-verification-overlay">
          <div class="age-verification-popup">
            <div class="age-verification-main-container">
              <div class="age-verification-title">
                <p class="age-verification-q">Are<br>you<br>over 18<br>years<br>old ?</p>
              </div>
              <div class="age-verification-no">
                  <a class="age-verification-btn age-verification-btn-no" href="#">No </a>
              </div>
              <div class="age-verification-yes">
                <a class="age-verification-btn age-verification-btn-yes" href="#">Yes</a>
              </div>
            </div>
          </div>
      </div>
    <?php
  }
}
}


add_action('wp_footer', 'age_verification_popup');
// add_action('wp_footer', 'checkPlug');

function age_verification_assets() {
    wp_enqueue_script( 'age-verification', plugins_url( '/age-verification.js', __FILE__ ), array('jquery'));
    wp_enqueue_style( 'age-verification', plugins_url( '/age-verification.css', __FILE__) );

    $nonce = wp_create_nonce( 'age-verification' );
    wp_localize_script( 'age-verification', 'my_ajax_obj', array(
       'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => $nonce,
    ) );
}
add_action('init', 'age_verification_assets');

function set_age_verification_cookie() {
    check_ajax_referer( 'age-verification' );

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        setcookie('age_verification', true, time()+(3600*12), "/", COOKIE_DOMAIN );
        ?> <script> console.log('Test'); </script> <?php
    }
    die();
}
add_action('wp_ajax_set_age_verification_cookie', 'set_age_verification_cookie');
add_action('wp_ajax_nopriv_set_age_verification_cookie', 'set_age_verification_cookie');
?>
