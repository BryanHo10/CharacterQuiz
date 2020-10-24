const $ = window.jQuery;
const remoteServer = "http://107.185.99.52/CharacterQuiz-API/v1";

const populateDashboard = async () => {
	//Add fetch to populate questionLength

	const QuestionPreviewContainer = $(`[id="quiz-preview-container"]`);
	const response = getAllQuizzes();

	if (!response) {
		const NoQuestions = $(`<div class="text-muted text-center">
            <h1>No Questions</h1>
            <hr />
        </div>`);
		QuestionPreviewContainer.append(NoQuestions);
		return;
	}
	const questionLength = response.length;

	if (questionLength === 0) {
		const NoQuestions = $(`<div class="text-muted text-center">
            <h1>No Questions</h1>
            <hr />
        </div>`);
		QuestionPreviewContainer.append(NoQuestions);
		return;
	}
	let index = 0;
	for (let quiz of response) {
		const quizPreviewTemplate = $(`<div class="card mb-4 shadow-sm">
            <div class="card-body">
            <h2 class="card-title">${quiz.title}</h2>
            <hr />
            <div class="py-4"></div>
            <div class=" d-flex justify-content-between align-items-center">
                <div class="btn-group">
                <button type="button" class="btn btn-lg btn-outline-secondary" onclick="viewQuiz(${index})">View</button>
                </div>
                <div class="row w-50 justify-content-end">
                <div class="px-5 text-center">
                    <h3>${quiz.characters.length}</h3>
                    Characters
                </div>
                <div class="px-5 text-center">
                    <h3>${quiz.questions.length}</h3>
                    Questions
                </div>
                </div>
            </div>
            </div>
        </div>`);
		QuestionPreviewContainer.append(quizPreviewTemplate);
		index++;
	}
};
const viewQuiz = (id) => {
	dataStorage.setItem("view-quiz", id);
	window.location.href = `/view-quiz.html`;
};
