<?php 
/**
 * My Profile Page with UK-style Registration Number (No Dashes, Year as 2 digits)
 *
 * @package Tutor\Templates
 * @subpackage Dashboard
 */

$uid  = get_current_user_id();
$user = get_userdata( $uid );

// Site info
$site_name = get_bloginfo('name');
$site_code = strtoupper(substr($site_name, 0, 3)); // first 3 letters of site name

// User info
$rdate = $user->user_registered;
$year  = date('y', strtotime($rdate)); // last 2 digits of the year
$fname = $user->first_name;
$lname = $user->last_name;
$uname = $user->user_login;
$email = $user->user_email;
$phone = get_user_meta( $uid, 'phone_number', true );
$job   = nl2br( wp_strip_all_tags( get_user_meta( $uid, '_tutor_profile_job_title', true ) ) );
$bio   = get_user_meta( $uid, '_tutor_profile_bio', true );

// Generate UK-style Registration Number without dashes: ABCYYXXXXX
$reg_number = sprintf('%s%s%05d', $site_code, $year, $uid);

$profile_data = array(
	array( __( 'Registration Number', 'tutor' ), $reg_number ),
	array( __( 'Registration Date', 'tutor' ), ( $rdate ? tutor_i18n_get_formated_date( tutor_utils()->get_local_time_from_unix( $rdate ) ) : '' ) ),
	array( __( 'First Name', 'tutor' ), ( $fname ? $fname : esc_html( '-' ) ) ),
	array( __( 'Last Name', 'tutor' ), ( $lname ? $lname : '-' ) ),
	array( __( 'Username', 'tutor' ), $uname ),
	array( __( 'Email', 'tutor' ), $email ),
	array( __( 'Phone Number', 'tutor' ), ( $phone ? $phone : '-' ) ),
	array( __( 'Skill/Occupation', 'tutor' ), ( $job ? $job : '-' ) ),
	array( __( 'Biography', 'tutor' ), $bio ? $bio : '-' ),
);
?>

<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24"><?php esc_html_e( 'My Profile', 'tutor' ); ?></div>
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
			echo 'Biography' === $data[0] ?
					'<span class="tutor-fs-6 tutor-color-secondary">' . wp_kses_post( wpautop( $data[1] ) ) . '</span>'
					: '<span class="tutor-fs-6 tutor-fw-medium tutor-color-black">' . esc_html( $data[1] ) . '</span>';
			?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
