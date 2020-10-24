const $ = window.jQuery;

const populateDashboard = () => {
	//Add fetch to populate questionLength
	const questionLength = 4;
	const QuestionPreviewContainer = $(`[id="quiz-preview-container"]`);
	if (questionLength === 0) {
		const NoQuestions = $(`<div class="text-muted text-center">
            <h1>No Questions</h1>
            <hr />
        </div>`);
		QuestionPreviewContainer.append(NoQuestions);
		return;
	}
	// QuestionPreviewContainer.empty();
	for (let i in [...Array(questionLength)]) {
		const quizPreviewTemplate = $(`<div class="card mb-4 shadow-sm">
            <div class="card-body">
            <h2 class="card-title">Sample Title</h2>
            <hr />
            <div class="py-4"></div>
            <div class=" d-flex justify-content-between align-items-center">
                <div class="btn-group">
                <button type="button" class="btn btn-lg btn-outline-secondary" onclick="viewQuiz(${i})">View</button>
                </div>
                <div class="row w-50 justify-content-end">
                <div class="px-5 text-center">
                    <h3>6</h3>
                    Characters
                </div>
                <div class="px-5 text-center">
                    <h3>6</h3>
                    Questions
                </div>
                </div>
            </div>
            </div>
        </div>`);
		QuestionPreviewContainer.append(quizPreviewTemplate);
	}
};
const viewQuiz = (id) => {
	window.location.href = `/view-quiz.html`;
};
