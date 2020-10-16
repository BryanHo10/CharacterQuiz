const $ = window.jQuery;

let currentQuestionNum = 1;
let globalCharactersList = [];

const addQuestionEntry = () => {
	const $element = $('[id="questions-container"]');
	currentQuestionNum += 1;
	const $newQuestion = $(`<!-- Current Question # Start-->
            <div class="py-4">
                <h4>Question ${currentQuestionNum}</h4>
                <hr />
                <input class="form-control form-control-lg" type="text" placeholder="Enter Question Text">
                <!-- Current Answer Start -->
                <div id="choice-container-${currentQuestionNum}">
                    <div class="row py-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Choice">
                        </div>
                        <div class="col-md-6">
                            <select id="inputCharacter" class="form-control">
                            <option selected value="" disabled>Choose...</option>
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
            </select>
        </div>
        </div><hr/>`);
	updateCharacterList();
	$element.append($newChoice);
};
