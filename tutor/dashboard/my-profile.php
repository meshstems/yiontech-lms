<?php
/**
 * My Profile Page with UK-style Registration Number (No Dashes, Year as 2 digits)
 *
 * @package Yiontech_LMS
 */

if (!defined('ABSPATH')) {
    exit;
}

$uid  = get_current_user_id();
$user = get_userdata( $uid );

if (!$user) {
    echo '<div class="tutor-alert tutor-warning">' . esc_html__( 'User not found.', 'yiontech-lms' ) . '</div>';
    return;
}

// Site info
$site_name = get_bloginfo('name');
$site_code = strtoupper( wp_trim_words( preg_replace('/[^A-Za-z]/', '', $site_name), 1, '' ) );
$site_code = substr( str_pad( $site_code, 3, 'X' ), 0, 3 ); // ensure 3 letters

// User info
$rdate = $user->user_registered;
$year  = $rdate ? date_i18n( 'y', strtotime( $rdate ) ) : date_i18n( 'y' ); // last 2 digits of the year
$fname = $user->first_name;
$lname = $user->last_name;
$uname = $user->user_login;
$email = $user->user_email;
$phone = get_user_meta( $uid, 'phone_number', true );
$job   = wp_kses( get_user_meta( $uid, '_tutor_profile_job_title', true ), array( 'br' => array() ) ) ?: '-';
$bio   = get_user_meta( $uid, '_tutor_profile_bio', true );

// Generate UK-style Registration Number without dashes: ABCYYXXXXX
$reg_number = sprintf( '%s%s%05d', esc_html( $site_code ), esc_html( $year ), intval( $uid ) );

$profile_data = array(
    array( __( 'Registration Number', 'yiontech-lms' ), $reg_number ),
    array( __( 'Registration Date', 'yiontech-lms' ), ( $rdate ? esc_html( date_i18n( get_option( 'date_format' ), strtotime( $rdate ) ) ) : '' ) ),
    array( __( 'First Name', 'yiontech-lms' ), ( $fname ? esc_html( $fname ) : esc_html( '-' ) ) ),
    array( __( 'Last Name', 'yiontech-lms' ), ( $lname ? esc_html( $lname ) : esc_html( '-' ) ) ),
    array( __( 'Username', 'yiontech-lms' ), esc_html( $uname ) ),
    array( __( 'Email', 'yiontech-lms' ), esc_html( $email ) ),
    array( __( 'Phone Number', 'yiontech-lms' ), ( $phone ? esc_html( $phone ) : esc_html( '-' ) ) ),
    array( __( 'Skill/Occupation', 'yiontech-lms' ), wp_kses_post( $job ) ),
    array( __( 'Biography', 'yiontech-lms' ), $bio ? wp_kses_post( $bio ) : esc_html( '-' ) ),
);
?>

<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24"><?php esc_html_e( 'My Profile', 'yiontech-lms' ); ?></div>
<div class="tutor-dashboard-content-inner tutor-dashboard-profile-data">
    <?php
    foreach ( $profile_data as $key => $data ) :
        ?>
        <div class="tutor-row tutor-mb-24">
            <div class="tutor-col-12 tutor-col-sm-5 tutor-col-lg-3">
                <span class="tutor-fs-6 tutor-color-secondary"><?php echo esc_html( $data[0] ); ?></span>
            </div>
            <div class="tutor-col-12 tutor-col-sm-7 tutor-col-lg-9">
            <?php
            if ( 'Biography' === $data[0] || __( 'Biography', 'yiontech-lms' ) === $data[0] ) {
                echo '<span class="tutor-fs-6 tutor-color-secondary">' . wp_kses_post( $data[1] ) . '</span>';
            } else {
                echo '<span class="tutor-fs-6 tutor-fw-medium tutor-color-black">' . esc_html( $data[1] ) . '</span>';
            }
            ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
