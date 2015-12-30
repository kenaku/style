<?php global $img_dir ?>
<?php global $theme_dir ?>
<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="False">
		<!-- <meta name="MobileOptimized" content="320"> -->
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-touch-icon.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<!-- <meta name="msapplication-TileColor" content="#f01d4f"> -->
		<!-- <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png"> -->
            <meta name="theme-color" content="#121212">

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <link rel="stylesheet" type="text/css" media="screen" href="http://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.css" />
    <style>
      .top-offscreen{
        bottom: 100%;
        left: 0px;
        width: 100%;
        position: absolute;
        z-index: 888888;
        overflow: hidden;
        backface-visibility: hidden;
      }
     /* a.fancybox img {
          border: none;
          -o-transform: scale(1,1); -ms-transform: scale(1,1); -moz-transform: scale(1,1); -webkit-transform: scale(1,1); transform: scale(1,1); -o-transition: all 0.2s ease-in-out; -ms-transition: all 0.2s ease-in-out; -moz-transition: all 0.2s ease-in-out; -webkit-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out;
      }
      a.fancybox:hover img {
          position: relative; z-index: 999; -o-transform: scale(1.03,1.03); -ms-transform: scale(1.03,1.03); -moz-transform: scale(1.03,1.03); -webkit-transform: scale(1.03,1.03); transform: scale(1.03,1.03);
      }*/
    </style>
		<?php wp_head(); ?>
	</head>

	<body id="body" <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
    <div id="feedback" class="feedback">
      <div class="feedback__label">Обратная связь</div>
      <div class="feedback__inner">
          <div class="feedback__form">
            <?php echo do_shortcode('[contact-form-7 title="feedback"]'); ?>
          </div>
        </div>
      </div>
    </div>
    <?php include($theme_dir . '/off-canvas.php'); ?>
		<header class="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
      <div id="inner-header" class="container header__inner cf">
        <a class="header__logo" href="/"><?php include($img_dir . 'common/logo.svg'); ?></a>
        <div class="header__buttons">
          <a href="tel:+78123371427" class="header__phone">(812) 370-82-21</a>
          <a href="#" class="header__catalog">скачать каталог</a>
          <a href="#" id="toggle-phones" class="toggle-offcanvas header__contacts"><?php include($img_dir . 'common/phone.svg'); ?></a>
          <a href="#" id="toggle-addresses" class="toggle-offcanvas header__addresses"><?php include($img_dir . 'common/pin.svg'); ?></a>
        </div>
			</div>
		</header>
    <div class="search-and-nav container cf">
      <div class="row">
        <div class="breadcrumbs col-sm-8">
        <?php if(is_front_page()){ ?>
          Производство и продажа офисных кресел, стульев и диванов
        <?php } else {?>
          <div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
              <?php if(function_exists('bcn_display'))
              {
                  bcn_display();
              } ?>
          </div>
        <?php } ?>
        </div>
        <div class="site-search col-sm-4">
        <form role="search" method="get" class="site-search_form" action="<?php echo home_url( '/' ); ?>">
          <input type="search" class="site-search__field" placeholder="Поиск по каталогу" value="<?php echo get_search_query() ?>" name="s" title="Поиск по сайту" />
          <input type="submit" class="site-search__submit" value="" />
        </form>
</div>
      </div>
    </div>
