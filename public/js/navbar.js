export default {
	goBack(event) {
		event.preventDefault();
		event.stopPropagation();
		history.back();
	},

	init() {
		this.backBtn = this.querySelector('[element=go-back]');
		this.menuBtn = this.querySelector('[element=items-toggle]');
		this.items = this.querySelector('[element=items]');

		this.backBtn.addEventListener('click', e => this.goBack(e));
		this.menuBtn.addEventListener('click', e => this.toggleItems(e));
	},

	toggleItems(event) {
		event.stopPropagation();
		event.preventDefault();
		this.menuBtn.children[0].classList.toggle('mu-menu');
		this.menuBtn.children[0].classList.toggle('mu-cancel');
		this.items.classList.toggle('active');
	}
}

