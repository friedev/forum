// Invert the visibility of all children to toggle collapsing
function collapse(element) {
	for (const child of element.children) {
		child.hidden = !child.hidden;
	}
}
