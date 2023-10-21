<?php

// Redirect subscribers accounts out of admin and into the homepage
function redirect_subscribers() {
    $our_current_user = wp_get_current_user();
        if(count($our_current_user->roles) == 1 AND $our_current_user->roles[0] == 'subscriber') {
            wp_redirect(site_url('/'));
            exit;
    }
}