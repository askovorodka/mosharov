$(function(){
	
	$("#form").validate({
		rules: {
			name: {
				required: true,
				minlength: 3
			},
			theme: {
				required: true
			},
			email: {
				required: true,
				email: true
			},
			message: {
				required: true
			}
		},
		messages: {
			name: {
				required: 'Заполните данное поле!',
				minlength: 'Минимум символов: 3'
			},

			theme: {
				required: 'Заполните данное поле!'
			},
			email: 'Некорректно введен e-mail',
			message: {
				required: 'Заполните данное поле!'
			}
		},
		success: function(label) {
			label.html('OK').removeClass('error').addClass('ok');
			setTimeout(function(){
				label.fadeOut(500);
			}, 2000)
		}
	});
	
});