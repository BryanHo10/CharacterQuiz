const remoteURL = "http://107.185.99.52/CharacterQuiz-API/";

const saveQuiz = (id, value) => {
	localStorage.setItem();
};
const getAllQuizzes = () => {};
const removeQuiz = () => {};

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
