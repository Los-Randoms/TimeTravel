"use strict"

async function main(ev) {
	let components = document.querySelectorAll("[manager]");
	for(let component of components) {
		console.log(component);
	}
}
document.addEventListener('DOMContentLoaded', main);


/*
async function bindController(element) {
	if(element === null) 
		return;
	await component(element.querySelector("[controller]"));
	let contName = element.getAttribute("controller");
	let cont = await import(`./js/${contName}.js`);
	let elements = element.querySelectorAll("[element]");
	let events = element.querySelectorAll("[trigger]");
	let controller = new cont.default;
	controller.node = element;

	for(let el of elements) {
		let elName = el.getAttribute('element');
		controller[elName] = el;
		el.removeAttribute('element');
	}

	for(let evEl of events) {
		let trigger = evEl.getAttribute("trigger").split('#');
		if(trigger.length < 2)
			continue;
		evEl.removeAttribute('trigger');
		evEl.addEventListener(trigger[0], ev => {
			ev.stopPropagation();
			controller[trigger[1]]();
		});
	}

	element.removeAttribute('controller');
	element.controller = controller;
}
*/
