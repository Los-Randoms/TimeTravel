"use strict"

export default {
	init() {
		this.icon = document.createElement('i');
		this.message = document.createElement('p');
		this.btn = document.createElement('button');
		this.btn.innerHTML = '<i class="gg-close"></i>';
		this.btn.onclick = _ => this.delete();
		this.icon.classList.add(`gg-${this.dataset.type}`);
		this.message.innerText = this.dataset.message;
		this.append(this.icon, this.message, this.btn);
	},

	delete() {
		this.parentElement.removeChild(this);
	}
}

