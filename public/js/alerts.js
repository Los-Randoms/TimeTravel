export let element;

export default function(node) {
	node.close_btn = node.querySelector('[element=close]');
	node.close_btn.addEventListener('click', remove);
}

function remove(event) {
	event.stopPropagation();
	let alert = event.target.parentElement;
}

