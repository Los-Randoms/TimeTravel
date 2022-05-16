"use strict"

export default {
	init() {
		this.alerts = document.getElementById('site-alerts');
	},

	onsubmit(ev) {
		ev.preventDefault();
		ev.stopPropagation();
		let data = new FormData(this);
		fetch('?e=submit', {
			method: 'POST',
			body: data,
		})
			.then(r => r.json())
			.then(j => {
				if(j.type === 'error')
					return this.alerts.createAlert(j.type, j.message);
				let messages = JSON.parse(sessionStorage.getItem('alerts')) || [];
				messages.push(j);
				sessionStorage.setItem('alerts', JSON.stringify(messages));
				location.href = this.action;
				this.reset();
			});
	}
}
