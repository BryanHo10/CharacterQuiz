const $ = window.jQuery;
const characterTracker = {};
const populateQuiz = () => {
	$(`[id="username"]`).empty();
	$(`[id="username"]`).append(getUserSession().nick);
	//Add fetch to populate quiz
	const QuestionPreviewContainer = $(`[id="quiz-preview-container"]`);
	QuestionPreviewContainer.empty();
	const mockQuestionObject = getAllQuizzes()[
		JSON.parse(dataStorage.getItem("view-quiz"))
	];
	QuestionPreviewContainer.append(
		$(`<h3>${mockQuestionObject.title}</h3><hr/>`)
	);

	for (let question of mockQuestionObject.questions) {
		QuestionPreviewContainer.append(
			$(`<h3>${question.id + 1}. ${question.text}</h3>`)
		);
		const choiceOptions = $(
			`<div id="answers-${question.id}" class="row"></div>`
		);
		let index = 0;
		for (let answer of question.answers) {
			choiceOptions.append(`<div class="col-md-6">
                <div><button id="question-${question.id}-${answer.character}${index}" class="btn btn-outline-info my-2 w-100" onclick="saveChoice(${question.id},'${answer.character}',${index})">
                        <h4>${answer.text}</h4>
                    </button></div>
			</div>`);
			index++;
		}
		QuestionPreviewContainer.append(choiceOptions);
		QuestionPreviewContainer.append(`<div class="my-5"></div>`);
	}
	QuestionPreviewContainer.append(`<div class="text-right"><button class="btn btn-success my-2 w-25" onclick="completeQuiz()">
            <h4>Finish Quiz</h4>
        </button></div>`);
};
const saveChoice = (questionID, characterChoice, answerID) => {
	const $buttonsEl = $(`[id="answers-${questionID}"]`).find("button");
	$buttonsEl.each(function () {
		const id = $(this).attr("id");
		if (id.includes(`${characterChoice}${answerID}`)) {
			$(this).addClass("active");
			characterTracker[questionID] = characterChoice;
		} else {
			$(this).removeClass("active");
		}
	});
};
const completeQuiz = () => {
	const characterTally = {};
	let highestCharacter = "";
	let highestCount = -1;
	for (const character of Object.values(characterTracker)) {
		if (!characterTally[character]) characterTally[character] = 1;
		else characterTally[character] += 1;

		if (characterTally[character] > highestCount) {
			highestCount = characterTally[character]; //set compare to counts[word]
			highestCharacter = character; //set mostFrequent value
		}
	}
	revealCharacter(highestCharacter);
};
const revealCharacter = (chosenCharacter) => {
	const QuestionPreviewContainer = $(`[id="quiz-preview-container"]`);
	// return;
	QuestionPreviewContainer.empty();
	QuestionPreviewContainer.append(`<div class="text-center">
        <h2>Congratulations! You completed the quiz.</h2>
        <h2>Your answers have revealed yourself to be:</h2>
        <div class="py-5 text-success font-italic">
            <h1>${chosenCharacter}</h1>
        </div>

    </div>`);
};
