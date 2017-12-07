<?php
/**
 * Template Name: EVE Time Zones
 */
\get_header();
?>

<div class="container main template-page-time-zones">
	<?php
	if(\have_posts()) {
		while(\have_posts()) {
			\the_post();
			?>
			<div class="main-content clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12 content-wrapper">
					<div class="content content-inner content-full-width content-page content-page-timezones">
						<header>
							<h1><?php \the_title(); ?></h1>
						</header>
						<article class="post clearfix">
							<?php \the_content(); ?>

							<div class="row">
								<!--
								// Local Time
								-->
								<?php
								$timeZomes = [
									[
										'title' => \__('Local Time', 'eve-online-time-zones'),
										'tzCode' =>'loc',
										'panel' => 'warning'
									],
									[
										'title' => \__('EVE Time', 'eve-online-time-zones'),
										'tzCode' =>'utc',
										'panel' => 'success'
									],
									[
										'title' => \__('US Pacific', 'eve-online-time-zones'),
										'tzCode' =>'usp'
									],
									[
										'title' => \__('US Mountain', 'eve-online-time-zones'),
										'tzCode' =>'usm'
									],
									[
										'title' => \__('US Central', 'eve-online-time-zones'),
										'tzCode' =>'usc'
									],
									[
										'title' => \__('US Eastern', 'eve-online-time-zones'),
										'tzCode' =>'use'
									],
									[
										'title' => \__('EU Western / England', 'eve-online-time-zones'),
										'tzCode' =>'euw'
									],
									[
										'title' => \__('EU Central / Berlin', 'eve-online-time-zones'),
										'tzCode' =>'euc'
									],
									[
										'title' => \__('EU Eastern / Turkey', 'eve-online-time-zones'),
										'tzCode' =>'eue'
									],
									[
										'title' => \__('Russia / Moscow', 'eve-online-time-zones'),
										'tzCode' =>'rus'
									],
									[
										'title' => \__('China / Shanghai', 'eve-online-time-zones'),
										'tzCode' =>'cn'
									],
									[
										'title' => \__('Australia / Sydney', 'eve-online-time-zones'),
										'tzCode' =>'aus'
									]
								];

								foreach($timeZomes as $zone) {
									\WordPress\Plugin\EveOnlineTimeZones\Libs\Helper\TemplateHelper::getInstance()->getTemplate('timezone-panel', $zone);
								} // END foreach($timeZomes as $zone)
								?>
							</div>

							<?php
							\WordPress\Plugin\EveOnlineTimeZones\Libs\Helper\TemplateHelper::getInstance()->getTemplate('adjust-to-eve-time');
							?>

						</article>
					</div> <!-- /.content -->
				</div> <!-- /.col -->
			</div> <!--/.row -->
			<?php
		} // END while(\have_posts())
	} // END if(have_posts())
	?>
</div><!-- /.container -->

<?php \get_footer(); ?>
