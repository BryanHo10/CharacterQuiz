const $ = window.jQuery;
const characterTracker = {};
const populateQuiz = () => {
	//Add fetch to populate quiz
	const QuestionPreviewContainer = $(`[id="quiz-preview-container"]`);
	QuestionPreviewContainer.empty();
	const mockQuestionObject = {
		title: "Title",
		characters: ["Character1", "Character2", "Character3"],
		questions: [
			{
				text: "Question1",
				id: 0,
				answers: [
					{ text: "Answer1", character: "Character1" },
					{ text: "Answer2", character: "Character2" },
				],
			},
			{
				text: "Question2",
				id: 1,
				answers: [
					{ text: "Answer1", character: "Character1" },
					{ text: "Answer2", character: "Character2" },
				],
			},
		],
	};
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
		for (let answer of question.answers) {
			choiceOptions.append(`<div class="col-md-6">
                <div><button id="question-${question.id}-${answer.character}" class="btn btn-outline-info my-2 w-100" onclick="saveChoice(${question.id},'${answer.character}')">
                        <h4>${answer.text}</h4>
                    </button></div>
            </div>`);
		}
		QuestionPreviewContainer.append(choiceOptions);
		QuestionPreviewContainer.append(`<div class="my-5"></div>`);
	}
	QuestionPreviewContainer.append(`<div class="text-right"><button class="btn btn-success my-2 w-25" onclick="completeQuiz()">
            <h4>Finish Quiz</h4>
        </button></div>`);
};
const saveChoice = (questionID, characterChoice) => {
	const $buttonsEl = $(`[id="answers-${questionID}"]`).find("button");
	$buttonsEl.each(function () {
		const id = $(this).attr("id");
		if (id.includes(characterChoice)) {
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
