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
				required: '��������� ������ ����!',
				minlength: '������� ��������: 3'
			},

			theme: {
				required: '��������� ������ ����!'
			},
			email: '����������� ������ e-mail',
			message: {
				required: '��������� ������ ����!'
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