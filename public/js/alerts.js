"use strict"

export default {
	alerts: [],

	init() {
		this.alerts = window.sessionStorage.messages || [];
		for(let alert of this.alerts) {
		}
	},

	onclick(ev) {
		console.log(this);
	}
}
