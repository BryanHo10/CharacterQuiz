const $ = window.jQuery;
const myStorage = window.sessionStorage;

const remoteServer = "http://107.185.99.52/CharacterQuiz-API/v1";
const loginUser = async () => {
	const email = $(`[id="login-email"]`).val();
	const password = $(`[id="login-pass"]`).val();
	const response = await fetch(`${remoteServer}/login`, {
		method: "POST",
		body: JSON.stringify({
			email,
			password,
		}),
	});
	if (!response.ok) {
		return;
	}
	response
		.then((response) => response.json())
		.then((data) => {
			saveUserSession({ email, password, id: data.id });
			window.location.href = "/home";
		});
};
const signUpUser = async () => {
	const email = $(`[id="signup-email"]`).val();
	const user = $(`[id="signup-user"]`).val();
	const password = $(`[id="signup-pass"]`).val();
	const verify = $(`[id="signup-verify"]`).val();
	const response = await fetch(`${remoteServer}/user`, {
		method: "POST",
		body: JSON.stringify({
			email,
			nick: user,
			password,
			password_confirm: verify,
		}),
	});
	if (!response.ok) {
		return;
	}
	response
		.then((response) => response.json())
		.then((data) => {
			saveUserSession({
				email,
				nick: user,
				password,
				password_confirm: verify,
				id: data.id,
			});
			window.location.href = "/home";
		});
};

const saveUserSession = (user) => {
	myStorage.setItem("currentUser", JSON.stringify(user));
};
