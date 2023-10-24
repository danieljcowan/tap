<?php 
if(get_site_url() == 'https://www.procompusa.com') {
	if( ! function_exists('ccc_header_scripts') ) {
		function ccc_header_scripts() {
			

			?>
		       	<!-- Google Tag Manager for Pro Comp-->
		        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		        })(window,document,'script','dataLayer','GTM-MGTJB22');</script>
		        <!-- End Google Tag Manager -->


		        <!-- Google Search Console -->
		        <meta name="google-site-verification" content="dh_YMNPtkhvPIhBFsL1oa_Hp4y1iy0_pnxVXfx_wBQ0" />
		        <!-- End Google Search Console -->



		        <!-- CURALATE -->
		        <script>var CRL8_SITENAME = '4wp-akebrq';!function(){var e=window.crl8=window.crl8||{},n=!1,i=[];e.ready=function(e){n?e():i.push(e)},e.pixel=e.pixel||function(){e.pixel.q.push(arguments)},e.pixel.q=e.pixel.q||[];var t=window.document,o=t.createElement("script"),c=e.debug||-1!==t.location.search.indexOf("crl8-debug=true")?"js":"min.js";o.async=!0,o.src=t.location.protocol+"//edge.curalate.com/sites/"+CRL8_SITENAME+"/site/latest/site."+c,o.onload=function(){n=!0,i.forEach(function(e){e()})};var r=t.getElementsByTagName("script")[0];r.parentNode.insertBefore(o,r.nextSibling)}();</script>
		        <!-- End CURALATE -->
		    <?php 
		}
	}
	add_action ( 'wp_head', 'ccc_header_scripts');




	if( ! function_exists('ccc_body_open') ) {
		function ccc_body_open() { ?>

		    <!-- Google Tag Manager (noscript) -->
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MGTJB22"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<!-- End Google Tag Manager (noscript) -->

		<?php
		}
	}
	add_action('wp_body_open', 'ccc_body_open');

} elseif(get_site_url() == 'https://www.smittybilt.com') {
	if( ! function_exists('ccc_header_scripts') ) {
	    function ccc_header_scripts() { ?>
		
	        <!-- Google Tag Manager for Smittybilt-->
	        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	        })(window,document,'script','dataLayer','GTM-57KK8RF');</script>
	        <!-- End Google Tag Manager this is insert header-->

	        <!-- Google Search Console -->
	        <meta name="google-site-verification" content="ZZ58OXNRjskMxUhFbs1hylmyPcxeuwV3qES76Ax_7xk" />
	        <!-- End Google Search Console -->

	        <!-- Global site tag (gtag.js) - Google Analytics -->
	                <script async src="https://www.googletagmanager.com/gtag/js?id=UA-146771417-1"></script>
	                <script>
	                  window.dataLayer = window.dataLayer || [];
	                  function gtag(){dataLayer.push(arguments);}
	                  gtag('js', new Date());

	                  gtag('config', 'UA-146771417-1');
	                </script>
	        <!-- End Google Analytics -->

	        <!-- CURALATE -->
	        <script>var CRL8_SITENAME = '4wp-akebrq';!function(){var e=window.crl8=window.crl8||{},n=!1,i=[];e.ready=function(e){n?e():i.push(e)},e.pixel=e.pixel||function(){e.pixel.q.push(arguments)},e.pixel.q=e.pixel.q||[];var t=window.document,o=t.createElement("script"),c=e.debug||-1!==t.location.search.indexOf("crl8-debug=true")?"js":"min.js";o.async=!0,o.src=t.location.protocol+"//edge.curalate.com/sites/"+CRL8_SITENAME+"/site/latest/site."+c,o.onload=function(){n=!0,i.forEach(function(e){e()})};var r=t.getElementsByTagName("script")[0];r.parentNode.insertBefore(o,r.nextSibling)}();</script>
	        <!-- End CURALATE -->

	    <?php
	    }
	}
	add_action ( 'wp_head', 'ccc_header_scripts');




	if( ! function_exists('ccc_body_open') ) {

	    function ccc_body_open() { ?>

	            <!-- Google Tag Manager (noscript) -->
	            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-57KK8RF"
	            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	            <!-- End Google Tag Manager (noscript) -->

	    <?php
	    }
	}
	add_action('wp_body_open', 'ccc_body_open');
}
