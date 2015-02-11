=== gq ===
Contributors: vimes1984
Donate link: http://buildawebdoctor.com
Tags: comments, spam
Requires at least: 3.5.1
Tested up to: 3.6
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
URI: http://www.gnu.org/licenses/gpl-2.0.html
WC requires at least: 2.2.11
WC tested up to: 2.3
Custom variable product stock  reduction

== Description ==

This is set out to solve the problem of dealing with woocommerce's variable products only ever deducting one from the total product stock. the use Case I had for it was: Client want's to seel packs of cigars 3/5/10 and wants erach variation to deduct from the main product total. Simple plugin to manage variable product stock, Update product quantities dynamically, using woocommerce. Basically this question http://wordpress.stackexchange.com/questions/72662/woocommerce-fixed-quantity-of-a-product. If a product variation needs to update the total stock quantity say you sell packs of nails or packets of cigars and you want…

== Installation ==

1. Upload `` to the `/wp-content/plugins/` directory
1. Activate the plugin through the "Plugins" menu in WordPress
1. Place `<?php do_action("gq_hook"); ?>` in your templates

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0 =
* Initial Commit