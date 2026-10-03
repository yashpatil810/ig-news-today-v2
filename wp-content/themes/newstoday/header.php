<?php
/**
 * The header for the theme
 *
 * @package NewsToday
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>

	
	<!-- Google Subscribe with Google (SWG) -->
	<script async type="application/javascript" src="https://news.google.com/swg/js/v1/swg-basic.js"></script>
	<script>
	  (self.SWG_BASIC = self.SWG_BASIC || []).push( basicSubscriptions => {
		basicSubscriptions.init({
		  type: "NewsArticle",
		  isPartOfType: ["Product"],
		  isPartOfProductId: "CAowrevDDA:openaccess",
		  clientOptions: { theme: "light", lang: "en" },
		});
	  });
	</script>
	<!-- / Pinterest Console for profile claiming -->
	<meta name="p:domain_verify" content="6da502a83e429007c03ae6dbc52959eb"/>
	<!-- / Google Search Console -->
	<meta name="google-site-verification" content="v87VVCOcxEq_V3LUc2O1N0aPCmAoStpan0kmUWWF6fI" />
    <!-- / Bing Search Console -->
    <meta name="msvalidate.01" content="B73F6CF9A609CBF1B99A2E2A5B0946FD" />
	<!-- / Schemas -->
	<script type="application/ld+json">	
	{
	  "@context": "https://schema.org",
	  "@type": "WebSite",
	  "url": "https://wheat-bear-950363.hostingersite.com/",
	  "name": "iGaming News Today"
	}
	</script>
	
	
	<!-- Meta Pixel Code (delayed to avoid blocking main thread) -->
	<script>
	(function() {
		function loadMetaPixel() {
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};
			if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
			n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t,s)}(window, document,'script',
			'https://connect.facebook.net/en_US/fbevents.js');
			fbq('init', '1269233924519755');
			fbq('init', '2281243268977317');
			fbq('track', 'PageView');
		}
		if ('requestIdleCallback' in window) {
			requestIdleCallback(loadMetaPixel, { timeout: 3000 });
		} else {
			setTimeout(loadMetaPixel, 2000);
		}
	})();

    <!-- / Clarity -->
    (function() {
        function loadClarity(c,l,a,r,i,t,y) {
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i+"?ref=bwt";
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        }
        if (window.requestIdleCallback) {
            requestIdleCallback(loadClarity, { timeout: 3000 });
        } else {
            setTimeout(loadClarity, 2000);
        }
    })();
	</script>
	<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1269233924519755&ev=PageView&noscript=1"/></noscript>
	<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=2281243268977317&ev=PageView&noscript=1"/></noscript>
	<!-- End Meta Pixel Code -->
	
	<meta name="facebook-domain-verification" content="0eklej33utrlxnisr5qqffnrj6qcfe" />
	
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'newstoday' ); ?></a>

    <?php get_template_part( 'template-parts/header/site-header' ); ?>

    <div id="content" class="site-content">

