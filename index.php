<?php 

define('SITE_URL', 'http://news.moro.es/');
define('SITE_ANALYTICS', 'UA-63335-16');
define('SITE_TITLE', 'News Visualizer');
define('SITE_DESCRIPTION', 'CSS3 and jQuery BBC News Responsive Layout Visualizer (moro.es)');
define('SITE_AUTHOR', 'Jorge Moreno aka Moro (www.moro.es, @alterebro)');
define('SITE_LANGUAGE', 'en');
define('SITE_KEYWORDS', 'News, Visualizer, moro, HTML, HTML5, CSS, CSS3, PHP, jQuery, JavaScript, API');

require_once('lib/php/visualizer.php');

?><!DOCTYPE html>
<!-- @alterebro -->
<html lang="<?php echo SITE_LANGUAGE; ?>" itemscope itemtype="http://schema.org/WebApplication">
<head>
	<meta charset="utf-8" />
	<title><?php echo SITE_TITLE; ?></title>
	<meta name="description" content="<?php echo SITE_DESCRIPTION; ?>" />
	<meta name="keywords" content="<?php echo SITE_KEYWORDS; ?>" />
	<meta name="author" content="<?php echo SITE_AUTHOR; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
	<meta http-equiv="content-language" content="<?php echo SITE_LANGUAGE; ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta itemprop="name" content="<?php echo SITE_TITLE; ?>" />
	<meta itemprop="description" content="<?php echo SITE_DESCRIPTION; ?>" />
	<meta itemprop="image" content="<?php echo SITE_URL; ?>lib/images/visualizer.png" />
	<link rel="shortcut icon" href="http://moro.es/favicon.ico" type="image/x-icon" />
	<link rel="start" title="<?php echo SITE_TITLE; ?>" href="<?php echo SITE_URL; ?>" />
	<link rel="home" title="<?php echo SITE_TITLE; ?>" href="<?php echo SITE_URL; ?>" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" type="text/css" />
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/normalize/2.1.0/normalize.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo SITE_URL; ?>lib/css/visualizer.css" type="text/css" />
<style type="text/css"><?php 
foreach ($topics as $topic) { 
	echo ".header-container header nav ul li a.".$topic['id']." { border-top: solid rgb(".$topic['color'][0].", ".$topic['color'][1].", ".$topic['color'][2].") 3px; }";
} 

$color_add = 100;
for ($i=0; $i<count($data); $i++) { 

	$r1 = ($topics[$current_topic_index]['color'][0]-$color_add < 0) ? 0 : $topics[$current_topic_index]['color'][0]-$color_add;
	$g1 = ($topics[$current_topic_index]['color'][1]-$color_add < 0) ? 0 : $topics[$current_topic_index]['color'][1]-$color_add;
	$b1 = ($topics[$current_topic_index]['color'][2]-$color_add < 0) ? 0 : $topics[$current_topic_index]['color'][2]-$color_add;

	$r2 = ($topics[$current_topic_index]['color'][0]+$color_add > 255) ? 255 : $topics[$current_topic_index]['color'][0]+$color_add;
	$g2 = ($topics[$current_topic_index]['color'][1]+$color_add > 255) ? 255 : $topics[$current_topic_index]['color'][1]+$color_add;
	$b2 = ($topics[$current_topic_index]['color'][2]+$color_add > 255) ? 255 : $topics[$current_topic_index]['color'][2]+$color_add;

	$r = rand($r1, $r2);
	$g = rand($g1, $g2);
	$b = rand($b1, $b2);

	echo ".main-container .main article section.sec-".$i." { background: rgba(".$r.",".$g.",".$b.",.2); } ";
	echo ".main-container .main article section.big-section.sec-".$i." { border-left: solid rgb(".$topics[$current_topic_index]['color'][0].", ".$topics[$current_topic_index]['color'][1].", ".$topics[$current_topic_index]['color'][2].") 10px; } ";
}
?>
</style>
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script>window.html5 || document.write('<script src="<?php echo SITE_URL; ?>lib/js/html5shiv.js"><\/script>')</script>
	<![endif]-->
</head>
<body>
	<!--[if lt IE 7]>
		<p class="chromeframe">
			You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> 
			or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.
		</p>
	<![endif]-->

	<div class="header-container">
		<header>
			<h1><a href="<?php echo SITE_URL; ?>" title="<?php echo SITE_TITLE; ?>"><?php echo SITE_TITLE; ?></a></h1>
			<nav>
				<ul>
				<?php 
					foreach ($topics as $topic) { 
					$selected = ($current_topic == $topic['id']) ? ' class="active"' : '';
				?>
					<li<?php echo $selected; ?>><a href="<?php echo SITE_URL; ?>?topic=<?php echo $topic['id']; ?>" title="<?php echo $topic['title']; ?> News" class="<?php echo $topic['id']; ?>"><?php echo $topic['title']; ?></a></li>
				<?php 
					} 
				?>
				</ul>
			</nav>
			<ul id="about">
				<li><a href="<?php echo SITE_URL; ?>#info">info</a></li>
			</ul>
		</header>
		<hr />
	</div>

	<div id="info">
		<p>
			<strong>News Visualizer</strong>. PHP + HTML5 + CSS3 + jQuery Demo. 
			<br />Data Source: BBC News API: <a href="http://api.bbcnews.appengine.co.uk/" target="_blank">api.bbcnews.appengine.co.uk/</a>
			<br />Made by: Jorge Moreno aka <a href="http://moro.es" title="Moro. Front End Web Developer and UI Designer" target="_blank">Moro</a> ( <a href="https://twitter.com/alterebro" title="Twitter Feed" target="_blank">@alterebro</a> )
			<br />&mdash; <a href="https://github.com/alterebro/NewsVisualizer" title="BBC News Visualizer Source Code" target="_blank">Source Code available on GitHub</a>
		</p>
	</div>

	<div class="main-container">
		<div class="main">
		<?php 
		$counter = 0;
		foreach ($data as $item) {
			echo '<section class="sec-'.$counter.'">';
			echo '<blockquote>';
			echo '<p>'.$item['text'].'</p>';
			echo '<small><a href="'.$item['link'].'" target="_blank">'.$item['date'].' &rarr;</a></small>';
			echo '</blockquote>';
			echo '</section>';
			$counter++;
		}
		?>
		</div>
	</div>

	<div class="footer-container">
		<hr />
		<footer>
			<h3>Development: <a href="http://moro.es" title="Moro. Front End Web Developer and UI Designer" target="_blank">moro</a> ( <a href="https://twitter.com/alterebro" title="Twitter Feed" target="_blank">@alterebro</a> )</h3>
			<div id="social-networks">
				<div class="social-network" id="twitter" data-url="<?php echo SITE_URL; ?>" data-text="<?php echo SITE_DESCRIPTION; ?>" data-title="Tweet"></div>
				<div class="social-network" id="facebook" data-url="<?php echo SITE_URL; ?>" data-text="<?php echo SITE_DESCRIPTION; ?>" data-title="Like"></div>
				<div class="social-network" id="googleplus" data-url="<?php echo SITE_URL; ?>" data-text="<?php echo SITE_DESCRIPTION; ?>" data-title="+1"></div>
				<div class="social-network" id="stumbleupon" data-url="<?php echo SITE_URL; ?>" data-text="<?php echo SITE_DESCRIPTION; ?>" data-title="Stumble!"></div>
			</div>
		</footer>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo SITE_URL; ?>lib/js/jquery-1.9.1.min.js"><\/script>');</script>
	<script src="<?php echo SITE_URL; ?>lib/js/jquery.sharrre-1.3.4.min.js"></script>
	<script src="<?php echo SITE_URL; ?>lib/js/visualizer.js"></script>
	<script type="text/javascript">
		$(function() { 

			$.visualizer.init(); 
			sharer('<?php echo SITE_URL; ?>lib/js/sharrre.php');	
			$('ul#about li a').click(function() {
				$('#info').slideToggle('fast');
				return false;
			});
		});

		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', '<?php echo SITE_ANALYTICS; ?>', 'moro.es');
		ga('send', 'pageview');
	</script>
</body>
</html>