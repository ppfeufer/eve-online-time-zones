/* global moment */

var clockTarget = 0;
var clockTickId = 0;

function hashchange() {
	var ts = window.location.hash.substring(1);

	clockTarget = 0;

	if(!isNaN(parseFloat(ts)) && isFinite(ts)) {
		clockTarget = ts * 1000;

		var mom = moment.tz(new Date(clockTarget), 'Etc/UTC');

		jQuery('#timestamp').attr('datetime', mom.format('YYYY-MM-DDTHH:mm:00Z0000'));
		jQuery("#timestamp").timeago("update", new Date(clockTarget));
	}
	switchto(clockTarget);
}

function clockTick() {
	updatePanels(new Date());
}

function switchto(mode) {
	if(clockTickId !== 0) {
		clearInterval(clockTickId);
	}

	if(mode === 0) {
		clockTickId = setInterval(clockTick, 1000);

		clockTick();
	} else {
		updatePanels(new Date(clockTarget));
	}
}

function updatePanels(now) {
	updatePanel(moment(now), 'loc');
	updatePanel(moment.tz(now, "Etc/UTC"), 'utc');
	updatePanel(moment.tz(now, "US/Pacific"), 'usp');
	updatePanel(moment.tz(now, "US/Mountain"), 'usm');
	updatePanel(moment.tz(now, "US/Central"), 'usc');
	updatePanel(moment.tz(now, "US/Eastern"), 'use');
	updatePanel(moment.tz(now, "Australia/ACT"), 'aus');
	updatePanel(moment.tz(now, "Europe/London"), 'euw');
	updatePanel(moment.tz(now, "Europe/Berlin"), 'euc');
	updatePanel(moment.tz(now, "Europe/Istanbul"), 'eue');
	updatePanel(moment.tz(now, "Europe/Moscow"), 'rus');
	updatePanel(moment.tz(now, "Asia/Shanghai"), 'cn');
}

function updatePanel(mom, id) {
//	jQuery("#time-" + id).html(mom.format('HH:mm:ss z'));
	jQuery("#time-" + id).html(mom.format('HH:mm:ss'));
	jQuery("#date-" + id).html(mom.format('dddd DD MMM YYYY'));

	// 3 06-09 sunrise
	// 3 09-11 sun
	// 3 11-14 sun
	// 3 14-17 sun
	// 3 17-20 sunset
	// 3 20-23 moonrise
	// 4 23-03 moon
	// 3 03-06 moonset
	jQuery('#icon-' + id).removeClass();

	var h = mom.format("H") * 1;
	var icon = "wi wi-night-clear";

	if(h < 23) {
		icon = "wi wi-moonrise";
	}

	if(h < 20) {
		icon = "wi wi-sunset";
	}

	if(h < 17) {
		icon = "wi wi-day-sunny";
	}

	if(h < 14) {
		icon = "wi wi-day-sunny";
	}

	if(h < 11) {
		icon = "wi wi-day-sunny";
	}

	if(h < 9) {
		icon = "wi wi-sunrise";
	}

	if(h < 6) {
		icon = "wi wi-moonset";
	}

	if(h < 3) {
		icon = "wi wi-night-clear";
	}

	jQuery('#icon-' + id).addClass(icon);
}

jQuery(document).ready(function($) {
	window.addEventListener("hashchange", hashchange, false);

	var mom = moment.tz(new Date(), 'Etc/UTC');
	year = mom.format("YYYY") * 1;

	for(i = year - 4; i < year + 5; i++) {
		$('#tatyear').append($('<option>', {i: i}).text(i));
	}

	jQuery.timeago.settings.allowFuture = true;
	jQuery.timeago.settings.allowPast = true;

	setInterval(function () {
		$("#timestamp").timeago("update", new Date(clockTarget));
	}, 10000);

	hashchange();
});
