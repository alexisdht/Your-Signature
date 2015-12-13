<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 25/11/2015
 * Time: 17:16
 */


/*
 * construct html signature structure
 */

function ys_display_profile($userid= '' ) {
    if ( $userid== '' ) {
        global $authordata;
        $author = $authordata;
    } else {
        $author = get_userdata( $userid);
    }


    // Create output in selected post page
    $ys_show_profile = '
	<div class="ys-str-display" id="your_sign-bio-">

		<div class="ys_avatar">';
    $ys_show_profile .= get_avatar( $author->ID, 80 );
    $user_info = get_userdata(1);
    //$post_info  .= get_the_date('l, F j, Y');

    $ys_show_profile .= '</div>
   <ul class="bloc">

   <li class="ys_profile">';

    $ys_get_author_public_name = apply_filters( 'ys_get_author_public_name', 'rel="nofollow"' );

    if( $author->user_url ) {
        $ys_show_profile .= '<h4><a href="' . $author->user_url . '" ' . $ys_get_author_public_name . '>' . $author->display_name . '</a></h4>';
    } else {
        $ys_show_profile .= '<h4>' . $author->display_name . '</h4>';
    }

    $ys_show_profile .= '
		</li>
   			<li class="ys_user_role">' . implode(',',$user_info->roles). '</li>
   			</ul>


        <ul class="bloc-2">

			<li class="ys_post_date">' .date_i18n( get_option( 'date_format' ), get_the_time( 'U' ) ) .'</li>

			<li class="ys_previous_posts"><a href="' . get_author_posts_url( $author->ID ) . '" rel="nofollow">' . __( 'previous posts', 'your_sign' ) . '</a></li>
        </ul>

 			<div class="ys_description bloc-3" >"'. $author->user_description.'"</div>

	</div>';

    return $ys_show_profile;
}
