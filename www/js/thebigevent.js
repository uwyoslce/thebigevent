const Keys = {
	'BACKSPACE' : 8,
	'TAB' : 9,
	'ENTER' : 13,
	'SHIFT' : 16,
	'CTRL' : 17,
	'ALT' : 18,
	'PAUSE' : 19,
	'CAPS_LOCK' : 20,
	'ESCAPE' : 27,
	'PAGE_UP' : 33,
	'PAGE_DOWN' : 34,
	'END' : 35,
	'HOME' : 36,
	'LEFT_ARROW' : 37,
	'UP_ARROW' : 38,
	'RIGHT_ARROW' : 39,
	'DOWN_ARROW' : 40,
	'INSERT' : 45,
	'DELETE' : 46,
	'0' : 48,
	'1' : 49,
	'2' : 50,
	'3' : 51,
	'4' : 52,
	'5' : 53,
	'6' : 54,
	'7' : 55,
	'8' : 56,
	'9' : 57,
	'A' : 65,
	'B' : 66,
	'C' : 67,
	'D' : 68,
	'E' : 69,
	'F' : 70,
	'G' : 71,
	'H' : 72,
	'I' : 73,
	'J' : 74,
	'K' : 75,
	'L' : 76,
	'M' : 77,
	'N' : 78,
	'O' : 79,
	'P' : 80,
	'Q' : 81,
	'R' : 82,
	'S' : 83,
	'T' : 84,
	'U' : 85,
	'V' : 86,
	'W' : 87,
	'X' : 88,
	'Y' : 89,
	'Z' : 90,
	'LEFT_SUPER' : 91,
	'RIGHT_SUPER' : 92,
	'SELECT_KEY' : 93,
	'NUMPAD_0' : 96,
	'NUMPAD_1' : 97,
	'NUMPAD_2' : 98,
	'NUMPAD_3' : 99,
	'NUMPAD_4' : 100,
	'NUMPAD_5' : 101,
	'NUMPAD_6' : 102,
	'NUMPAD_7' : 103,
	'NUMPAD_8' : 104,
	'NUMPAD_9' : 105,
	'MULTIPLY' : 106,
	'ADD' : 107,
	'SUBTRACT' : 109,
	'DECIMAL_POINT' : 110,
	'DIVIDE' : 111,
	'F1' : 112,
	'F2' : 113,
	'F3' : 114,
	'F4' : 115,
	'F5' : 116,
	'F6' : 117,
	'F7' : 118,
	'F8' : 119,
	'F9' : 120,
	'F10' : 121,
	'F11' : 122,
	'F12' : 123,
	'NUM_LOCK' : 144,
	'SCROLL_LOCK' : 145,
	'SEMI_COLON' : 186,
	'EQUAL_SIGN' : 187,
	'COMMA' : 188,
	'DASH' : 189,
	'PERIOD' : 190,
	'FORWARD_SLASH' : 191,
	'GRAVE_ACCENT' : 192,
	'OPEN_BRACKET' : 219,
	'BACK_SLASH' : 220,
	'CLOSE_BRAKET' : 221,
	'SINGLE_QUOTE' : 222
};

var texturize = function(input) {
	return $.map( input.split('\n\n'), function(paragraph){
		return $('<p />').html( paragraph.replace('\n', '<br>') )
	});
}

$(function(){
	console.log('jQuery active');

	$task_warning = $("#task_warning").hide();

	$('body').on('change', '#tasks-ids', function(e){
		var $tasks_ids = $(this);
		
		var indoor_jobs = $tasks_ids.find(":selected").filter(function(idx){
			return $(this).text().indexOf("Indoor") == 0
		}).length;

		if( indoor_jobs < 1 ) {
			$task_warning.slideDown('fast');
		} else {
			$task_warning.slideUp('fast');
		}


	})
	.on('keydown', function(e){
		
		if(Keys.FORWARD_SLASH == e.which && $('input:focus').length == 0 ){
			e.preventDefault();
			console.info(e);
			console.log('the forward slash was caught by body');
			return false;
		}
	});

	$('.tzOffset').val( new Date().getTimezoneOffset() );

	$('.card.card--job').on('keydown', '.card--job__notes__note', function(e){
		if( Keys.ENTER == e.which && !e.shiftKey ) {
			var $note = $(this),
				$job_card = $note.closest('.card');

			const job_id = $job_card.data('job-id'),
				note = $note.val().trim();

			if( '' != note ) {

				$.ajax({
					url: '/jobs/note/' + job_id,
					dataType: 'JSON',
					type: 'POST',
					data: {
						'note': note
					}
				})
				.done(function(response){

					$('.card--job[data-job-id='+job_id+'] .card--job__notes__notes')
						.html( texturize(response.job.notes) );

					$note.val("");
				})
				.fail(function(x,y,z){})
			}
		}
	});

	$('.card.card--todo').on('change', '.card__status-toggle', function(e){
		var $todo_card = $(this).closest('.card');

		const todo_id = $todo_card.data('todo-id'),
			status = this.checked ? 'complete' : 'incomplete';

		$.ajax({
			url: '/todos/status/' + todo_id + '/' + status + '/',
			dataType: 'JSON',
			type: 'POST'
		})
		.done(function(response){
			this.checked = response.todo.completed;
			if( response.todo.completed ) {
				$todo_card.addClass('card--complete').removeClass('card--incomplete')
			} else {
				$todo_card.addClass('card--incomplete').removeClass('card--complete')
			}
		})
		.fail(function(x,y,z){});
	});
});;