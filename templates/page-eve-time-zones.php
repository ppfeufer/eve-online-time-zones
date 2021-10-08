<?php
/**
 * Template Name: EVE Time Zones
 */

/**
 * Copyright (C) 2017 Rounon Dax
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
                                <script type='application/javascript'>
                                    let eveOnlineTimezonesTranslations = {
                                        days: "<?php echo \__('Days', 'eve-online-time-zones'); ?>",
                                        alreadyOver: "<?php echo \__('Already over, you missed it!', 'eve-online-time-zones'); ?>"
                                    };
                                </script>

                                <!--
                                // Local Time
                                -->
                                <?php
                                $timeZones = [
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

                                foreach($timeZones as $zone) {
                                    \WordPress\Plugins\EveOnlineTimeZones\Libs\Helper\TemplateHelper::getInstance()->getTemplate('timezone-panel', $zone);
                                }
                                ?>
                            </div>

                            <?php
                            \WordPress\Plugins\EveOnlineTimeZones\Libs\Helper\TemplateHelper::getInstance()->getTemplate('time-until');
                            \WordPress\Plugins\EveOnlineTimeZones\Libs\Helper\TemplateHelper::getInstance()->getTemplate('adjust-to-eve-time');
                            ?>
                        </article>
                    </div> <!-- /.content -->
                </div> <!-- /.col -->
            </div> <!--/.row -->
            <?php
        }
    }
    ?>
</div><!-- /.container -->

<?php
\get_footer();
