<?php
/*
Plugin Name: No Brute Force
Plugin URI: http://github.com/CodeitOut/wp-no-brute-force/
Description: After 10 wrong attempts it forces password reset by failing login to help fight brute force attacks
Author: Piyush
Version: 0.1
Author URI: http://codeitout.com
*/
add_filter('check_password', "nobrute_checkpass");
add_action('password_reset','nobrute_passreset');
function nobrute_checkpass($check) {
    $repeated = get_option('nobrute_repeat_pass',0);
    if(10 <= $repeated) {
        $check = false;
    }elseif(false == $check) {
        update_option('nobrute_repeat_pass',$repeated+1);
    } else {
        update_option('nobrute_repeat_pass',0);
    }
    return $check;
}

function nobrute_passreset($user, $new_pass) {
    update_option('nobrute_repeat_pass',0);
}
