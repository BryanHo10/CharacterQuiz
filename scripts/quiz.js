const $ = window.jQuery;
const initialView = () => {
	$(`[id="username"]`).empty();
	$(`[id="username"]`).append(getUserSession().nick);
};
const addQuestionEntry = () => {
	const $element = $('[id="questions-container"]');
	currentQuestionNum += 1;
	const $newQuestion = $(`<!-- Current Question # Start-->
            <div class="py-4">
                <h4>Question ${currentQuestionNum}</h4>
                <hr />
                <input id="question-title-${currentQuestionNum}" class="form-control form-control-lg" type="text" placeholder="Enter Question Text">
                <!-- Current Answer Start -->
                <div id="choice-container-${currentQuestionNum}">
                    <div class="row py-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Choice">
                        </div>
                        <div class="col-md-6">
                            <select id="inputCharacter" class="form-control">
                            <option selected value="" disabled>Choose...</option>
                            ${globalCharactersList.map(
															(label) =>
																`<option value="${label}" >${label}</option>`
														)}
                            </select>
                        </div>
                    </div>
                    <hr />
                </div>
                <!-- Current Answer End -->

                <!-- New Answer Start -->
                <div class="row py-3">
                    <div class="col-md text-right">
                        <button class="btn btn-outline-info" onclick="addChoiceEntry(${currentQuestionNum})">
                            Add new Choice
                        </button>
                    </div>
                </div>
                <!-- New Answer End -->


            </div>
            <!-- Current Question # End -->`);
	$element.append($newQuestion);
};
const addCharacterEntry = () => {
	const $element = $('[id="character-container"]');

	const $newCharacter = $(`<div class="col-md-6 py-2">
                <input type="text" class="form-control" placeholder="Choice">
            </div>`);
	$element.append($newCharacter);
};
const updateCharacterList = () => {
	$(`[id="character-container"] input`).each(function () {
		const val = $(this).val();
		if (!globalCharactersList.includes(val) && val !== "") {
			globalCharactersList.push(val);
		}
	});
	$(`[id="inputCharacter"]`)
		.replaceWith(`<select id="inputCharacter" class="form-control">
            <option selected value="" disabled >Choose...</option>
            ${globalCharactersList.map(
							(label) => `<option value="${label}" >${label}</option>`
						)}
        </select>`);
};
const addChoiceEntry = (questionNum) => {
	const $element = $(`[id="choice-container-${questionNum}"]`);
	const $newChoice = $(`<div class="row py-3"><div class="col-md-6">
            <input type="text" class="form-control" placeholder="Choice">
        </div>
        <div class="col-md-6">
            <select id="inputCharacter" class="form-control">
                <option selected value="" disabled>Choose...</option>
                ${globalCharactersList.map(
									(label) => `<option value="${label}" >${label}</option>`
								)}
            </select>
        </div>
        </div><hr/>`);
	$element.append($newChoice);
};
const submitQuiz = () => {
	event.preventDefault();
	saveQuestions();
	window.location.href = `http://127.0.0.1:3000/home.html`;
};
const saveQuestions = () => {
	const characterList = [...globalCharactersList];
	const titleEntry = $(`[id="quiz-title"]`).val();
	const choiceEntries = Array.from(Array(currentQuestionNum)).map(
		(_, index) => {
			let allChoiceTexts = [];
			$(`[id="choice-container-${index + 1}"]`)
				.find("input")
				.each(function () {
					allChoiceTexts.push($(this).val());
				});

			let allCharacterChoices = [];
			$(`[id="choice-container-${index + 1}"]`)
				.find("select")
				.each(function () {
					allCharacterChoices.push($(this).children("option:selected").val());
				});
			return allChoiceTexts.map((val, index) => {
				return {
					text: val,
					character: allCharacterChoices[index],
				};
			});
		}
	);
	const questionEntries = Array.from(Array(currentQuestionNum)).map(
		(_, index) => {
			return {
				text: $(`[id="question-title-${index + 1}"]`).val(),
				id: index,
				answers: choiceEntries[index],
			};
		}
	);
	currentQuiz.characters = characterList;
	currentQuiz.title = titleEntry;
	currentQuiz.questions = questionEntries;
	saveQuiz(currentQuiz);
};
