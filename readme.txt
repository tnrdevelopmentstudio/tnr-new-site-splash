=== TNR New Site Splash ===
Contributors: tnrdevelopmentstudio
Tags: coming soon, splash page, maintenance, landing page, TNR Hosting
Requires at least: 6.0
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

An automatic, responsive TNR-branded splash page for new client websites.

== Description ==

Displays a TNR Development Studio splash on the homepage while the site is under construction. As soon as an existing static homepage is assigned in Settings > Reading, the splash disappears automatically.

No external services or configuration required. Does not affect secondary pages, wp-admin, REST endpoints, feeds, or AJAX.

== Installation ==

1. Upload tnr-new-site-splash.zip using Plugins > Add New Plugin > Upload Plugin.
2. Activate the plugin.
3. The splash will appear on the homepage while Reading settings use "Your latest posts".
4. To launch the site, assign a static Homepage via Settings > Reading and save.

== Frequently Asked Questions ==

= How do I remove the splash? =

Assign a static page as Homepage in Settings > Reading. The splash disappears immediately for uncached requests.

= Can developers see the site while the splash is running? =

Yes. Site administrators can visit the homepage with ?tnr_preview_site=1 to bypass the splash while logged in.

= Will this hide checkout or other pages? =

No. Only the homepage is replaced. Secondary URLs remain accessible.

== Changelog ==

= 1.0.0 =
* Initial release with automatic static-homepage detection and responsive branding.
