# TNR New Site Splash

A lightweight, theme-independent WordPress splash screen for newly provisioned TNR Development Studio client sites hosted on TNR Hosting.

## What it does

- Shows a polished, responsive **"We're building something epic"** page only on the public homepage.
- Includes TNR Development Studio and TNR Hosting branding and links.
- **Automatically stops showing the splash** when WordPress has an existing static page assigned as the homepage via **Settings → Reading**.
- Does not alter Reading settings, homepage content, the site's theme, other URLs, WordPress admin, REST API, AJAX, feeds, or the customizer.
- Lets an administrator preview the underlying homepage with `?tnr_preview_site=1` before assigning a static page.
- Uses no external fonts, images, JavaScript, APIs, or database tables.
- Sends no-cache and no-index headers while the splash is live. A separately configured CDN or full-page cache may need to be purged once the homepage is assigned.

## Install

1. Download the **tnr-new-site-splash.zip** installable package, or create a ZIP containing the `tnr-new-site-splash` directory.
2. In the WordPress admin, go to **Plugins → Add New Plugin → Upload Plugin**.
3. Upload the ZIP and select **Install Now**, then **Activate**.
4. Visit the site's homepage. The splash appears if **Settings → Reading → Your latest posts** is currently selected.

## Automatically turn it off

1. Create and publish a regular WordPress page for the real website homepage.
2. Go to **Settings → Reading**.
3. Select **A static page**, choose the page under **Homepage**, then **Save Changes**.
4. The real homepage appears automatically; there is no need to deactivate or remove the plugin.

If you switch back to **Your latest posts**, the splash will appear again while the plugin is active.

## Compatibility and updates

- WordPress 6.0 or newer.
- PHP 7.4 or newer.
- Compatible with common themes and page builders because it intercepts only the unassigned homepage.
- The plugin includes Git Updater-compatible headers pointing to [this repository](https://github.com/tnrdevelopmentstudio/tnr-new-site-splash). Tag releases as `1.0.0`, `1.0.1`, etc. and increase the plugin header version for each update.

## Notes

- An already-assigned static homepage is never overwritten, even if the plugin is activated later.
- Other pages and product pages remain accessible at their normal URLs during development. If the entire site must be password-protected, use a separate staging/password solution.
- Search engines are instructed not to index the temporary splash. Once the real site launches, handle its SEO settings and indexing separately.

Built by [TNR Development Studio](https://www.tnrdevelopment.com/) for [TNR Hosting](https://www.tnrhosting.com/).
