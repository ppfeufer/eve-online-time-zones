/* global moment, eveOnlineTimezonesTranslations */

let clockTarget = 0;
let clockTickId = 0;
let countdownIntervalId = 0;

function showAdjust() {
    'use strict';

    jQuery('#btnadjust').addClass('hidden');
    jQuery('#adjust').removeClass('hidden');

    let mom = moment.tz(new Date(), 'Etc/UTC');

    jQuery('#tathour').val(mom.format('HH'));
    jQuery('#tatminute').val(mom.format('mm'));
    jQuery('#tatday').val(mom.format('DD'));
    jQuery('#tatmonth').val(mom.format('MM'));
    jQuery('#tatyear').val(mom.format('YYYY'));
}

function setdate(str, tz) {
    'use strict';

    if (tz !== '') {
        window.location.hash = moment.tz(str, tz).unix();
    } else {
        window.location.hash = moment(str).unix();
    }
}

function updatePanel(mom, id) {
    'use strict';

//    jQuery('#time-' + id).html(mom.format('HH:mm:ss z'));
    jQuery('#time-' + id).html(mom.format('HH:mm:ss'));
    jQuery('#date-' + id).html(mom.format('dddd DD MMM YYYY'));

//    3 06-09 sunrise
//    3 09-11 sun
//    3 11-14 sun
//    3 14-17 sun
//    3 17-20 sunset
//    3 20-23 moonrise
//    4 23-03 moon
//    3 03-06 moonset
    let iconElement = jQuery('#icon-' + id);
    iconElement.removeClass();

    let h = mom.format('H') * 1;
    let icon = 'wi wi-night-clear';

    if (h < 23) {
        icon = 'wi wi-moonrise';
    }

    if (h < 20) {
        icon = 'wi wi-sunset';
    }

    if (h < 17) {
        icon = 'wi wi-day-sunny';
    }

    if (h < 14) {
        icon = 'wi wi-day-sunny';
    }

    if (h < 11) {
        icon = 'wi wi-day-sunny';
    }

    if (h < 9) {
        icon = 'wi wi-sunrise';
    }

    if (h < 6) {
        icon = 'wi wi-moonset';
    }

    if (h < 3) {
        icon = 'wi wi-night-clear';
    }

    iconElement.addClass(icon);
}

function updatePanels(now) {
    'use strict';

    updatePanel(moment(now), 'loc');
    updatePanel(moment.tz(now, 'Etc/UTC'), 'utc');
    updatePanel(moment.tz(now, 'US/Pacific'), 'usp');
    updatePanel(moment.tz(now, 'US/Mountain'), 'usm');
    updatePanel(moment.tz(now, 'US/Central'), 'usc');
    updatePanel(moment.tz(now, 'US/Eastern'), 'use');
    updatePanel(moment.tz(now, 'Australia/ACT'), 'aus');
    updatePanel(moment.tz(now, 'Europe/London'), 'euw');
    updatePanel(moment.tz(now, 'Europe/Berlin'), 'euc');
    updatePanel(moment.tz(now, 'Europe/Istanbul'), 'eue');
    updatePanel(moment.tz(now, 'Europe/Moscow'), 'rus');
    updatePanel(moment.tz(now, 'Asia/Shanghai'), 'cn');
}

function timeUntil(timestamp) {
    'use strict';

    let timestampDifference = timestamp - Date.now();
    let timeDifferenceInSeconds = timestampDifference / 1000; // from ms to seconds

    // set the interval
    countdownIntervalId = setInterval(function () {
        let countdown;

        // execute code each second
        timeDifferenceInSeconds--; // decrement timestamp with one second each second

        if (timeDifferenceInSeconds >= 0) {
            let days = Math.floor(timeDifferenceInSeconds / (24 * 60 * 60)); // calculate days from timestamp
            let hours = Math.floor(timeDifferenceInSeconds / (60 * 60)) % 24; // hours
            let minutes = Math.floor(timeDifferenceInSeconds / 60) % 60; // minutes
            let seconds = Math.floor(timeDifferenceInSeconds) % 60; // seconds

            // leading zero ...
            if (hours < 10) {
                hours = '0' + hours;
            }
            if (minutes < 10) {
                minutes = '0' + minutes;
            }
            if (seconds < 10) {
                seconds = '0' + seconds;
            }

            countdown = days + ' ' + eveOnlineTimezonesTranslations.days + ', ' + hours + ':' + minutes + ':' + seconds;
        } else {
            countdown = eveOnlineTimezonesTranslations.alreadyOver;
        }

        jQuery('.eve-online-timezones-time-until-countdown').html(countdown);
    }, 1000);
}

function clockTick() {
    'use strict';

    updatePanels(new Date());
}

function switchto(mode) {
    'use strict';

    if (clockTickId !== 0) {
        clearInterval(clockTickId);
    }

    if (countdownIntervalId !== 0) {
        clearInterval(countdownIntervalId);
    }

    jQuery('.eve-online-timezones-time-until-countdown').html('');

    if (mode === 0) {
        jQuery('#headlineCurrent').removeClass('hidden');
        jQuery('#headlineFixed').addClass('hidden');
        jQuery('#adjust').addClass('hidden');
        jQuery('#btnadjust').removeClass('hidden');
        jQuery('#btnshowcurrent').addClass('hidden');
        jQuery('.eve-online-timezones-time-until').addClass('hidden');

        if (clockTarget !== 0) {
            jQuery('#btnshowfixed').removeClass('hidden');
        }

        jQuery('#btnclear').addClass('hidden');

        clockTickId = setInterval(clockTick, 1000);

        clockTick();
    } else {
        jQuery('#headlineCurrent').addClass('hidden');
        jQuery('#headlineFixed').removeClass('hidden');
        jQuery('#adjust').addClass('hidden');
        jQuery('#btnadjust').addClass('hidden');
        jQuery('#btnshowcurrent').removeClass('hidden');
        jQuery('#btnshowfixed').addClass('hidden');
        jQuery('#btnclear').removeClass('hidden');
        jQuery('.eve-online-timezones-time-until').removeClass('hidden');

        updatePanels(new Date(clockTarget));
        timeUntil(clockTarget);
    }
}

function hashchange() {
    'use strict';

    let ts = window.location.hash.substring(1);

    clockTarget = 0;

    if (!isNaN(parseFloat(ts)) && isFinite(parseInt(ts))) {
        clockTarget = ts * 1000;

        let mom = moment.tz(new Date(clockTarget), 'Etc/UTC');
        let timestampElement = jQuery('#timestamp');

        timestampElement.attr('datetime', mom.format('YYYY-MM-DDTHH:mm:00Z0000'));
        timestampElement.timeago('update', new Date(clockTarget));
    }

    switchto(clockTarget);
}

jQuery(document).ready(function ($) {
    'use strict';

    window.addEventListener('hashchange', hashchange, false);

    /**
     * Declaring some variables ...
     */
    let mom = moment.tz(new Date(), 'Etc/UTC');
    let year = mom.format('YYYY') * 1;
    let i;

    for (i = year - 4; i < year + 5; i++) {
        $('#tatyear').append($('<option>', {i: i}).text(i));
    }

    $.timeago.settings.allowFuture = true;
    $.timeago.settings.allowPast = true;

    setInterval(function () {
        $('#timestamp').timeago('update', new Date(clockTarget));
    }, 10000);

    hashchange();
});
