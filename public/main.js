"use strict"

async function main() {
	let components = document.querySelectorAll("[manager]");
	for(let comp of components) {
		let name = comp.getAttribute('manager');
		await addManager(name, comp);
	}
}

export async function addManager(name, element) {
	let manager = await import(`/public/js/${name}.js`);
	Object.assign(element, manager.default);
	element.init();
}

document.addEventListener('DOMContentLoaded', main);

