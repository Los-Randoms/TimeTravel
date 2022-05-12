"use strict"
import { addManager } from '../main.js';

export default {
	alerts: [],

	init() {
		let alerts = sessionStorage.getItem('alerts');
		if(alerts)
			this.alerts = JSON.parse(alerts) || [];
		for(let alert of this.alerts)
			this.createAlert(alert.type, alert.message);
		sessionStorage.setItem('alerts', '[]');
	},

	createAlert(type, message) {
		let div = document.createElement('div');
		div.classList.add('alert');
		div.dataset.type = type;
		div.dataset.message = message;
		addManager('alert', div);
		this.appendChild(div);
	},
}
