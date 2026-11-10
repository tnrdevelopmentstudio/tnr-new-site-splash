<?php
/**
 * Plugin Name: TNR New Site Splash
 * Plugin URI: https://github.com/tnrdevelopmentstudio/tnr-new-site-splash
 * Description: Displays a branded TNR Development Studio splash page until a static homepage is assigned.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: TNR Development Studio
 * Author URI: https://www.tnrdevelopment.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: tnr-new-site-splash
 * GitHub Plugin URI: https://github.com/tnrdevelopmentstudio/tnr-new-site-splash
 * Primary Branch: main
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * True once WordPress has a valid static page assigned as the homepage.
 *
 * The splash remains active when Settings > Reading is set to "Your latest
 * posts", including on a freshly installed WordPress site.
 *
 * @return bool
 */
function tnrnss_has_assigned_homepage() {
	if ( 'page' !== get_option( 'show_on_front' ) ) {
		return false;
	}

	$page_id = absint( get_option( 'page_on_front' ) );

	return $page_id > 0 && 'page' === get_post_type( $page_id );
}

/**
 * Replace only the public front page, without changing Reading settings,
 * the theme, other URLs, or the logged-in WordPress admin experience.
 *
 * @return void
 */
function tnrnss_maybe_render_splash() {
	if (
		is_admin() ||
		wp_doing_ajax() ||
		( function_exists( 'wp_is_json_request' ) && wp_is_json_request() ) ||
		is_feed() ||
		is_preview() ||
		( function_exists( 'is_customize_preview' ) && is_customize_preview() ) ||
		! is_front_page() ||
		tnrnss_has_assigned_homepage()
	) {
		return;
	}

	// Allow site administrators to inspect the underlying homepage during setup.
	// This never provides a bypass to unauthenticated visitors.
	if (
		isset( $_GET['tnr_preview_site'] ) &&
		'1' === $_GET['tnr_preview_site'] && // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only preview.
		current_user_can( 'manage_options' )
	) {
		return;
	}

	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}

	status_header( 200 );
	nocache_headers();
	header( 'X-Robots-Tag: noindex, nofollow, noarchive', true );

	$studio_url  = 'https://www.tnrdevelopment.com/';
	$hosting_url = 'https://www.tnrhosting.com/';
	$site_name   = get_bloginfo( 'name' );
	?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#081426">
	<meta name="robots" content="noindex, nofollow, noarchive">
	<title><?php echo esc_html( sprintf( 'Something epic is coming | %s', $site_name ) ); ?></title>
	<?php if ( function_exists( 'wp_site_icon' ) ) { wp_site_icon(); } ?>
	<style>
		:root{color-scheme:dark;--ink:#09192d;--navy:#081426;--white:#f7fbff;--muted:#aabed0;--blue:#5cbaff;--mint:#64efd1}
		*{box-sizing:border-box}
		html{min-height:100%;background:var(--navy)}
		body{min-height:100vh;margin:0;color:var(--white);font-family:system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:radial-gradient(ellipse at 76% 20%,rgba(27,116,175,.25),transparent 40%),radial-gradient(ellipse at 10% 85%,rgba(14,130,119,.17),transparent 42%),#081426;overflow-x:hidden}
		body:before{content:"";position:fixed;inset:0;pointer-events:none;opacity:.3;background-image:linear-gradient(rgba(152,196,227,.045) 1px,transparent 1px),linear-gradient(90deg,rgba(152,196,227,.045) 1px,transparent 1px);background-size:66px 66px;mask-image:linear-gradient(to bottom,black,transparent 90%)}
		a{color:inherit;text-decoration:none}
		a:focus-visible{outline:3px solid var(--mint);outline-offset:5px;border-radius:6px}
		.shell{width:min(1180px,calc(100% - 48px));min-height:100vh;margin:0 auto;display:flex;flex-direction:column;position:relative;z-index:1}
		.header{display:flex;align-items:center;justify-content:space-between;gap:20px;padding:34px 0 24px;border-bottom:1px solid rgba(193,221,241,.11)}
		.brand{display:flex;align-items:center;gap:13px;font-size:13px;font-weight:850;letter-spacing:.12em;text-transform:uppercase;line-height:1.3}
		.brand-mark{height:43px;width:43px;border:1px solid rgba(119,226,223,.4);display:grid;place-items:center;border-radius:13px;background:linear-gradient(135deg,rgba(56,168,220,.25),rgba(56,233,180,.16));box-shadow:0 6px 26px rgba(37,179,206,.12)}
		.brand-mark svg{width:25px;height:25px;fill:none;stroke:#87efdf;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
		.brand small{display:block;color:#90b8c9;font-size:9px;letter-spacing:.29em;font-weight:700;margin-top:3px}
		.header-label{display:flex;align-items:center;gap:9px;color:#afcad9;font-size:11px;font-weight:750;letter-spacing:.19em;text-transform:uppercase}
		.status-dot{width:7px;height:7px;background:var(--mint);border-radius:50%;box-shadow:0 0 0 5px rgba(100,239,209,.1),0 0 18px rgba(100,239,209,.9)}
		.main{flex:1;display:grid;grid-template-columns:1.05fr .95fr;align-items:center;gap:50px;padding:62px 0 76px}
		.eyebrow{display:inline-flex;align-items:center;gap:10px;padding:10px 14px;border:1px solid rgba(113,224,222,.25);border-radius:999px;background:rgba(61,189,191,.075);color:#a6f5e3;font-size:11px;letter-spacing:.16em;font-weight:800;text-transform:uppercase}
		.eyebrow:before{content:"";width:6px;height:6px;background:var(--mint);border-radius:50%}
		h1{font-size:clamp(46px,5.8vw,82px);line-height:1.04;letter-spacing:-.068em;font-weight:850;margin:26px 0 24px;max-width:710px}
		h1 span{background:linear-gradient(100deg,#7aceff 4%,#78f3d6 83%);background-clip:text;-webkit-background-clip:text;color:transparent}
		.lead{max-width:570px;color:#bbcedf;font-size:clamp(17px,1.8vw,20px);line-height:1.75;margin:0}
		.lead strong{color:#f7fdff;font-weight:700}
		.actions{display:flex;align-items:center;flex-wrap:wrap;gap:18px;margin-top:37px}
		.action-main{min-height:49px;display:inline-flex;align-items:center;gap:12px;padding:0 21px;border-radius:10px;background:linear-gradient(105deg,#92e8f7,#73efd2);color:#072237;font-weight:800;font-size:13px;box-shadow:0 13px 45px rgba(66,199,196,.16);transition:transform .2s,box-shadow .2s}
		.action-main:hover{transform:translateY(-2px);box-shadow:0 16px 46px rgba(66,199,196,.25)}
		.action-main svg{width:17px;height:17px;stroke:currentColor;stroke-width:2;fill:none}
		.action-alt{color:#d2e4f0;font-weight:700;font-size:13px;padding:12px 0;transition:color .2s}
		.action-alt:hover{color:var(--mint)}
		.visual{position:relative;min-height:450px;display:grid;place-items:center;isolation:isolate}
		.visual:before{content:"";position:absolute;width:min(460px,100%);aspect-ratio:1;border-radius:50%;background:radial-gradient(circle,rgba(67,190,210,.21),rgba(47,113,169,.055) 52%,transparent 70%);filter:blur(10px);z-index:-2}
		.orbit{position:absolute;border:1px dashed rgba(123,214,224,.15);border-radius:50%;width:97%;max-width:480px;aspect-ratio:1;transform:rotate(-20deg)}
		.orbit.two{width:78%;max-width:375px;transform:rotate(25deg);border-style:solid;border-color:rgba(123,214,224,.1)}
		.site-card{width:min(445px,95%);height:295px;background:linear-gradient(155deg,rgba(28,54,78,.97),rgba(11,29,51,.98));border:1px solid rgba(174,222,244,.25);border-radius:18px;box-shadow:0 35px 90px rgba(1,8,19,.43),0 0 70px rgba(47,165,180,.06);overflow:hidden;transform:perspective(950px) rotateY(-9deg) rotateX(4deg) rotateZ(-2deg);animation:float 7s ease-in-out infinite}
		.browser{height:41px;border-bottom:1px solid rgba(177,209,234,.11);display:flex;align-items:center;gap:7px;padding:0 17px;background:rgba(6,17,33,.35)}
		.browser b{width:7px;height:7px;border-radius:50%;background:#ff947f;opacity:.9}
		.browser b:nth-child(2){background:#f4d278}
		.browser b:nth-child(3){background:#76dfba}
		.address{margin-left:auto;margin-right:auto;width:43%;height:14px;border-radius:5px;background:rgba(163,204,225,.095)}
		.card-inner{padding:29px 33px}
		.card-tag{width:83px;height:9px;background:#73e8d8;border-radius:4px;opacity:.85;margin-bottom:23px}
		.card-title{height:20px;width:77%;background:linear-gradient(90deg,#d4ebff,#9bc9e4);border-radius:6px;margin-bottom:12px}
		.card-title.short{width:54%;opacity:.85}
		.card-line{height:8px;width:85%;background:rgba(164,207,232,.22);border-radius:6px;margin-top:24px}
		.card-line.next{width:67%;margin-top:10px}
		.card-buttons{display:flex;gap:10px;margin-top:27px}
		.card-buttons i{display:block;width:95px;height:30px;background:linear-gradient(90deg,#69cbef,#67e3cc);border-radius:6px}
		.card-buttons i:nth-child(2){width:73px;background:rgba(169,217,238,.13)}
		.float-badge{position:absolute;padding:12px 15px;background:rgba(23,56,75,.95);border:1px solid rgba(141,222,226,.27);border-radius:11px;box-shadow:0 20px 35px rgba(0,0,0,.23);font-size:12px;font-weight:800;color:#e9f9ff;display:flex;align-items:center;gap:9px}
		.float-badge svg{height:17px;width:17px;stroke:#8ef1d7;stroke-width:2;stroke-linecap:round;fill:none}
		.float-badge.top{top:45px;right:-3px;transform:rotate(5deg);animation:float 6s ease-in-out infinite reverse}
		.float-badge.bottom{left:-12px;bottom:52px;transform:rotate(-5deg);animation:float 8s ease-in-out infinite}
		.footer{padding:23px 0 29px;border-top:1px solid rgba(193,221,241,.11);display:flex;align-items:center;justify-content:space-between;gap:18px;flex-wrap:wrap;color:#829bb0;font-size:12px}
		.footer strong{color:#c4e2ec;font-weight:700}
		.footer a{color:#a5d9e8;font-weight:700}
		.footer a:hover{color:var(--mint)}
		@keyframes float{0%,100%{translate:0 0}50%{translate:0 -11px}}
		@media(max-width:900px){.main{grid-template-columns:1fr;gap:20px;padding:68px 0 52px}.copy{text-align:center}.lead{margin-inline:auto}.actions{justify-content:center}.visual{min-height:380px}.float-badge.top{right:6%}.float-badge.bottom{left:5%}h1{margin-inline:auto}}
		@media(max-width:580px){.shell{width:min(100% - 34px,480px)}.header{padding:22px 0}.header-label{font-size:9px;letter-spacing:.05em}.brand{font-size:10px;gap:9px}.brand-mark{height:37px;width:37px}.brand small{font-size:7px}.main{padding:55px 0 34px}.eyebrow{font-size:9px;letter-spacing:.1em}h1{font-size:clamp(42px,12vw,58px);margin:25px 0 20px}.lead{font-size:16px}.actions{margin-top:28px;gap:12px}.visual{min-height:315px}.site-card{height:236px}.browser{height:32px}.card-inner{padding:22px}.card-tag{margin-bottom:16px}.card-title{height:15px}.card-line{margin-top:17px}.card-buttons{margin-top:20px}.float-badge{font-size:10px;padding:10px}.float-badge.top{top:12px;right:0}.float-badge.bottom{bottom:10px;left:0}.footer{justify-content:center;text-align:center;font-size:11px}}
		@media(prefers-reduced-motion:reduce){*,*:before,*:after{animation:none!important;scroll-behavior:auto!important;transition:none!important}}
	</style>
</head>
<body>
	<div class="shell">
		<header class="header">
			<a class="brand" href="<?php echo esc_url( $studio_url ); ?>" aria-label="Visit TNR Development Studio">
				<span class="brand-mark"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 18V6l9 12V6l9 12V6"/></svg></span>
				<span>TNR Development <small>Studio</small></span>
			</a>
			<div class="header-label"><span class="status-dot" aria-hidden="true"></span>Site in progress</div>
		</header>

		<main class="main">
			<div class="copy">
				<div class="eyebrow">Something great is in the works</div>
				<h1>We're building something <span>epic.</span></h1>
				<p class="lead"><strong>TNR Development Studio</strong> is building something epic for a new client, proudly hosted on <strong>TNR Hosting</strong>. A fresh digital experience is on its way. Stay tuned!</p>
				<div class="actions">
					<a class="action-main" href="<?php echo esc_url( $studio_url ); ?>">Meet the studio <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></a>
					<a class="action-alt" href="<?php echo esc_url( $hosting_url ); ?>">Powered by TNR Hosting &rarr;</a>
				</div>
			</div>

			<div class="visual" aria-hidden="true">
				<div class="orbit"></div><div class="orbit two"></div>
				<div class="site-card">
					<div class="browser"><b></b><b></b><b></b><div class="address"></div></div>
					<div class="card-inner"><div class="card-tag"></div><div class="card-title"></div><div class="card-title short"></div><div class="card-line"></div><div class="card-line next"></div><div class="card-buttons"><i></i><i></i></div></div>
				</div>
				<div class="float-badge top"><svg viewBox="0 0 24 24"><path d="m4 12 5 5L20 6"/></svg>Design in progress</div>
				<div class="float-badge bottom"><svg viewBox="0 0 24 24"><path d="m12 2-2 7-7 3 7 2 2 8 3-8 7-2-7-3-3-7Z"/></svg>Something awesome is coming</div>
			</div>
		</main>

		<footer class="footer">
			<div>Crafted with care by <a href="<?php echo esc_url( $studio_url ); ?>">TNR Development Studio</a></div>
			<div>Built for what's next. <strong>Hosted by <a href="<?php echo esc_url( $hosting_url ); ?>">TNR Hosting</a>.</strong></div>
		</footer>
	</div>
</body>
</html>
	<?php
	exit;
}
add_action( 'template_redirect', 'tnrnss_maybe_render_splash', 0 );

/**
 * A small setup hint, visible to site administrators on useful screens only.
 *
 * @return void
 */
function tnrnss_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) || tnrnss_has_assigned_homepage() ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->id, array( 'dashboard', 'plugins', 'options-reading' ), true ) ) {
		return;
	}

	$reading_url = admin_url( 'options-reading.php' );
	$preview_url = add_query_arg( 'tnr_preview_site', '1', home_url( '/' ) );
	?>
	<div class="notice notice-info">
		<p><strong>TNR New Site Splash is active.</strong> Visitors see the TNR-branded splash on your homepage.</p>
		<p>When you're ready, go to <a href="<?php echo esc_url( $reading_url ); ?>">Settings &rarr; Reading</a>, select <strong>A static page</strong>, choose your homepage, and save. The splash will automatically disappear. <a href="<?php echo esc_url( $preview_url ); ?>" target="_blank" rel="noopener noreferrer">Preview the underlying website</a>.</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'tnrnss_admin_notice' );
