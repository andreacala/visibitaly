<?php

/*

 * This file belongs to the YIT Framework.

 *

 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)

 * that is bundled with this package in the file LICENSE.txt.

 * It is also available through the world-wide-web at this URL:

 * http://www.gnu.org/licenses/gpl-3.0.txt

 */

if (!defined('ABSPATH')) {

    exit; // Exit if accessed directly

}

$term = get_queried_object();

global $sitepress;
$has_wpml = !empty($sitepress);

if ($has_wpml) {
    $term_slug = yit_wpml_object_id($term->term_id, YITH_Vendors()->get_taxonomy_name(), true, wpml_get_default_language());
    $default_term = get_term($term_slug, YITH_Vendors()->get_taxonomy_name());
} else {
    $term_slug = $term->slug;
}

$vendor = yith_get_vendor($term_slug, 'vendor');

?>



<div class="<?php echo $store_description_class ?>">
    
    <?php echo $vendor_description; ?> <br><br>

    <?php if ( $vendor->yt_video != "" ) { ?>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $vendor->yt_video; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    <?php } ?>

</div>