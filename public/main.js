"use strict"

async function main() {
	let components = document.querySelectorAll("[manager]");
	for(let comp of components) {
		let name = comp.getAttribute('manager');
		let manager = await import(`/public/js/${name}.js`);
		Object.assign(comp, manager.default);
		comp.init();
	}
}
document.addEventListener('DOMContentLoaded', main);

