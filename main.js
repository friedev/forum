// Invert the visibility of all children to toggle collapsing
function collapse(element) {
	for (const child of element.children) {
		child.hidden = !child.hidden;
	}
}

// Localizes all dates in the DOM
// Dates are found by getting all elements with the "date" class
function localizeDates() {
	for (const element of document.getElementsByClassName("date")) {
		const date = new Date(Date.parse(element.innerHTML));
		element.innerHTML = date.toLocaleString();
	}
}

// Localize dates on script load
// The script should be deferred so that all dates are loaded into the DOM
localizeDates();
