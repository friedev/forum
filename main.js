// Invert the visibility of all children to toggle collapsing
function collapse(element) {
	for (const child of element.children) {
		child.hidden = !child.hidden;
	}
}

function localizeDates() {
	for (const element of document.getElementsByClassName("date")) {
		const date = new Date(Date.parse(element.innerHTML));
		element.innerHTML = date.toLocaleString();
	}
}

localizeDates();
