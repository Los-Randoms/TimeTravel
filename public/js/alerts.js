const alert = {
	close(event) {
		event.stopPropagation();
		event.preventDefault();
		this.classList.add('closing');
		setTimeout(_ => {
			this.container.removeChild(this);
		}, 500);
	},

	init(container) {
		this.container = container;
		this.closeBtn = this.querySelector('[element=close]');
		this.closeBtn.addEventListener('click', e => this.close(e));
	},
}

export default {
	init() {
		this.messages = this.querySelectorAll("[handler=alert]");
		for (let element of this.messages)
			Object.assign(element, alert).init(this);
	}
}

