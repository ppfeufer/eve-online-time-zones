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
										'title' => 'Local Time',
										'tzCode' =>'loc',
										'panel' => 'warning'
									],
									[
										'title' => 'EVE Time',
										'tzCode' =>'utc',
										'panel' => 'success'
									],
									[
										'title' => 'US Pacific',
										'tzCode' =>'usp'
									],
									[
										'title' => 'US Mountain',
										'tzCode' =>'usm'
									],
									[
										'title' => 'US Central',
										'tzCode' =>'usc'
									],
									[
										'title' => 'US Eastern',
										'tzCode' =>'use'
									],
									[
										'title' => 'EU Western / England',
										'tzCode' =>'euw'
									],
									[
										'title' => 'EU Central / Berlin',
										'tzCode' =>'euc'
									],
									[
										'title' => 'EU Eastern / Turkey',
										'tzCode' =>'eue'
									],
									[
										'title' => 'Russia / Moscow',
										'tzCode' =>'rus'
									],
									[
										'title' => 'China / Shanghai',
										'tzCode' =>'cn'
									],
									[
										'title' => 'Australia / Sydney',
										'tzCode' =>'aus'
									]
								];

								foreach($timeZomes as $zone) {
									\WordPress\Plugin\EveOnlineTimeZones\Libs\Helper\TemplateHelper::getInstance()->getTemplate('timezone-panel', $zone);
								} // END foreach($timeZomes as $zone)
								?>
							</div>
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
