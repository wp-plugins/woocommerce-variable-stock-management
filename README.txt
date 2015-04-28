=== Woocommerce Variable Stock Management ===
Contributors: vimes1984
Donate link: http://buildawebdoctor.com
Tags: Woocommerce, Variable Stock
Requires at least: 3.5.1
Tested up to: 4.2
Stable tag: 1.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Custom variable product stock reduction for woocommerce

== Description ==
All bugs to be tracked via github please:
https://github.com/vimes1984/woocommerce_variable_stock_management

This is set out to solve the problem of dealing with woocommerce's variable products only ever deducting one from the total product stock.
The use Case I had for it was as follows:
   	Client want's to seel packs of cigars 3/5/10 and wants each variation to deduct from the main product total.
So I built this  simple plugin to manage variable product stock and update product quantities dynamically, using woocommerce.
Basically it solves this question not mine but it ilustrates the point:
http://wordpress.stackexchange.com/questions/72662/woocommerce-fixed-quantity-of-a-product.
=== Woocommerce Variable Stock Management ===
Contributors: vimes1984
Donate link: http://buildawebdoctor.com
Tags: Woocommerce, Variable Stock
Requires at least: 3.5.1
Tested up to: 4.1
Stable tag: 1.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Custom variable product stock reduction for woocommerce

== Description ==
All bugs to be tracked via github please:
https://github.com/vimes1984/woocommerce_variable_stock_management

This is set out to solve the problem of dealing with woocommerce's variable products only ever deducting one from the total product stock.
The use Case I had for it was as follows:
   	Client want's to seel packs of cigars 3/5/10 and wants each variation to deduct from the main product total.
So I built this  simple plugin to manage variable product stock and update product quantities dynamically, using woocommerce.
Basically it solves this question not mine but it ilustrates the point:
http://wordpress.stackexchange.com/questions/72662/woocommerce-fixed-quantity-of-a-product.

<h3>Addiditionals</h3>

This also has a bigcommerce category importer to woocommerce. can be found here includes/class-import-categories.php you'll need to change line 202 and put your old sites url in there if you want images to be pulled from the descriptions...
== Installation ==

1. Upload `` to the `/wp-content/plugins/` directory
2. Activate the plugin through the "Plugins" menu in WordPress
3. Go to your woocommerce store and add a variable product
4. under the variable product you see to new options Deduct or not which should be set to yes if you want this to deduct from your store & amount to deduct..

== Screenshots ==

1. This is what you should see on your wordpress variable product set the "deduct from product stock" to yes and enter the amount in the box below

== Changelog ==
= 1.0.3 =
* fixing errors
= 1.0.2 =
* updating tags
= 1.0.1 =
* fixed this bug: https://github.com/vimes1984/woocommerce_variable_stock_management/issues/1
= 1.0 =
* Initial Commit
== Installation ==

1. Upload `` to the `/wp-content/plugins/` directory
2. Activate the plugin through the "Plugins" menu in WordPress
3. Go to your woocommerce store and add a variable product
4. under the variable product you see to new options Deduct or not which should be set to yes if you want this to deduct from your store & amount to deduct..

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==
= 1.0.2 =
* updating tags
= 1.0.1 =
* fixed this bug: https://github.com/vimes1984/woocommerce_variable_stock_management/issues/1
= 1.0 =
* Initial Commit
