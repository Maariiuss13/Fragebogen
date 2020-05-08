
const backButton = document.getElementById('back-btn');
const continueButton = document.getElementById('continue-btn');

const questionText = document.getElementById('question');

const questions = [
  '',
  '',
  '',
  '',
  '',
  '',
  ''
]

var currentIndex = 0;

const updateQuestionText = () => {
  const text = questions[currentIndex];
  questionText.innerHTML = text;
}

updateQuestionText();

const isFirstIndex = (index) => index === 0;
const isLastIndex = (index) => index === questions.length - 1;

const setButtonHidden = (btn, hidden) => {
  if (hidden) {
    btn.classList.add('hidden');
  } else {
    btn.classList.remove('hidden');
  }
}

backButton.addEventListener('click', () => {
  currentIndex -= 1;
  updateQuestionText();

  if (isFirstIndex(currentIndex)) {
    setButtonHidden(backButton, true);
  }
})

continueButton.addEventListener('click', () => {
  if (isLastIndex(currentIndex)) {
    alert('All questions confirmed! Upload to database!');
    return;
  }
  currentIndex += 1;
  updateQuestionText();

  setButtonHidden(backButton, false);

  if (isLastIndex(currentIndex)) {
    continueButton.innerHTML = "Fragebogen abschließen"
  }
})