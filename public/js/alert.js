"use strict"

export default {
	init() {
		this.icon = document.createElement('object');
		this.message = document.createElement('p');
		this.btn = document.createElement('button');
		this.btn.innerHTML = '<object class="icon" data="/public/icons/x.svg"></object>';
		this.btn.onclick = _ => this.delete();
		this.icon.classList.add('icon');
		this.icon.data = `/public/icons/alert-octagon.svg`;
		this.message.innerText = this.dataset.message;
		this.append(this.icon, this.message, this.btn);
	},

	delete() {
		this.parentElement.removeChild(this);
	}
}

