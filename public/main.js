import alert from './js/alerts.js';

// Get all the alerts
const alerts = document.querySelectorAll("[handler=alert]");
for(let element of alerts)
	element.handler = alert(element); 

