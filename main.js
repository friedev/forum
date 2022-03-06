// Generate a post element from the given form
function createPost(form) {
	let author = document.createElement("span");
	author.className = "author";
	author.innerHTML = form.author.value;

	let date = document.createElement("span");
	date.className = "date";
	date.innerHTML = new Date().toLocaleString();

	let detail = document.createElement("p");
	detail.className = "detail";
	detail.appendChild(author);
	detail.innerHTML += " on ";
	detail.appendChild(date);
	detail.innerHTML += ":";

	let content = document.createElement("p");
	content.className = "content";
	content.innerHTML = form.content.value;

	let hr = document.createElement("hr");

	let post = document.createElement("div");
	post.className = "post";
	post.appendChild(detail);
	post.appendChild(content);
	post.appendChild(hr);

	return post;
}

// Adds a topic to the thread based on the submitted form
function addTopic() {
	let form = document.getElementById("topicForm");

	let topic = document.createElement("h1");
	topic.className = "topic";
	topic.id = "topic";
	topic.innerHTML = form.topic.value;

	let post = createPost(form);

	let thread = document.getElementById("thread");
	thread.appendChild(topic);
	thread.appendChild(post);

	// Remove the topic form and show the reply form
	let topicFormWrapper = document.getElementById("topicFormWrapper");
	topicFormWrapper.hidden = true;
	let replyFormWrapper = document.getElementById("replyFormWrapper");
	replyFormWrapper.hidden = false;

	return false;
}

// Adds a reply to the thread based on the submitted form
function addReply() {
	let form = document.getElementById("replyForm");

	let post = createPost(form);

	let thread = document.getElementById("thread");
	thread.appendChild(post);

	return false;
}
