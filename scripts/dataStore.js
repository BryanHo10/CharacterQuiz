const remoteURL = "http://107.185.99.52/CharacterQuiz-API/";
const myStorage = window.sessionStorage;
const dataStorage = window.localStorage;

const saveUserSession = (user) => {
	myStorage.setItem("currentUser", JSON.stringify(user));
};
const getUserSession = () => {
	return JSON.parse(myStorage.getItem("currentUser"));
};
const saveQuiz = (value) => {
	const quizzes = dataStorage.getItem("quizzes");
	if (!quizzes) {
		dataStorage.setItem("quizzes", JSON.stringify([value]));
	} else {
		dataStorage.setItem(
			"quizzes",
			JSON.stringify([...JSON.parse(quizzes), value])
		);
	}
};
const getAllQuizzes = () => {
	const quizzes = dataStorage.getItem("quizzes");
	if (!quizzes) {
		return [];
	} else {
		return JSON.parse(quizzes);
	}
};

// Mock Data
const mockGetAllQuizzes = () => {
	return Promise((resolve) => {
		resolve([
			{
				title: "Title",
				characters: ["Character1", "Character2", "Character3"],
				questions: [
					{
						text: "Question1",
						id: 1,
						answers: [
							{ text: "Answer1", character: "Character1" },
							{ text: "Answer2", character: "Character2" },
						],
					},
					{
						text: "Question2",
						id: 2,
						answers: [
							{ text: "Answer1", character: "Character1" },
							{ text: "Answer2", character: "Character2" },
						],
					},
				],
			},
		]);
	});
};
