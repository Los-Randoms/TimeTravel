"use strict"

export default class {
	constructor() { }

	close() {
		let parent = this.node.parentElement;
		parent.removeChild(this.node);
	}
}
