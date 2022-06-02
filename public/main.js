import alerts from './js/alerts.js';
import navbar from './js/navbar.js';

const site_alerts = document.getElementById('site-alerts');
const main_navbar = document.getElementById('main-navigation');

function main() {
	Object.assign(site_alerts, alerts).init();
	Object.assign(main_navbar, navbar).init();
}

document.addEventListener('DOMContentLoaded', main);

