const $ = window.jQuery;

const remoteServer = "http://107.185.99.52/CharacterQuiz-API/v1";
const loginUser = async () => {
	$(`[id="login-error"]`).empty();
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
		response.json().then((data) => {
			for (const error of data.errors) {
				$(`[id="login-error"]`).append(`<p>${error}</p>`);
			}
		});
	} else {
		response.json().then((data) => {
			console.log(data);
			saveUserSession({ id: data.id });
			window.location.href = "/home.html";
		});
	}
};
const signUpUser = async () => {
	$(`[id="signup-error"]`).empty();
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
		response.json().then((data) => {
			for (const error of data.errors) {
				$(`[id="signup-error"]`).append(`<p>${error}</p>`);
			}
		});
		return;
	} else {
		response.json().then((data) => {
			saveUserSession({
				email,
				nick: user,
				password,
				password_confirm: verify,
				id: data.id,
			});
			window.location.href = "/home.html";
		});
	}
};
