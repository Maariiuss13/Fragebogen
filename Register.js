var password = document.getElementById('password');
var passwordConfirm = document.getElementById('passwordConfirm');

var checkPasswordValidity = function() {
	if (password.value != passwordConfirm.value) {
		passwordConfirm
				.setCustomValidity('Passwörter müssen miteinander übereinstimmen!');
	} else {
		passwordConfirm.setCustomValidity('');
	}
}
password.addEventListener('change', checkPasswordValidity);
passwordConfirm.addEventListener('change', checkPasswordValidity);