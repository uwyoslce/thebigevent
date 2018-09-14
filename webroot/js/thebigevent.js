/*
	jQuery Masked Input Plugin
	Copyright (c) 2007 - 2015 Josh Bush (digitalbush.com)
	Licensed under the MIT license (http://digitalbush.com/projects/masked-input-plugin/#license)
	Version: 1.4.1
*/
!(function(a) {
	"function" == typeof define && define.amd
		? define(["jquery"], a)
		: a("object" == typeof exports ? require("jquery") : jQuery);
})(function(a) {
	var b,
		c = navigator.userAgent,
		d = /iphone/i.test(c),
		e = /chrome/i.test(c),
		f = /android/i.test(c);
	(a.mask = {
		definitions: { 9: "[0-9]", a: "[A-Za-z]", "*": "[A-Za-z0-9]" },
		autoclear: !0,
		dataName: "rawMaskFn",
		placeholder: "_"
	}),
		a.fn.extend({
			caret: function(a, b) {
				var c;
				if (0 !== this.length && !this.is(":hidden"))
					return "number" == typeof a
						? ((b = "number" == typeof b ? b : a),
						  this.each(function() {
								this.setSelectionRange
									? this.setSelectionRange(a, b)
									: this.createTextRange &&
									  ((c = this.createTextRange()),
									  c.collapse(!0),
									  c.moveEnd("character", b),
									  c.moveStart("character", a),
									  c.select());
						  }))
						: (this[0].setSelectionRange
								? ((a = this[0].selectionStart), (b = this[0].selectionEnd))
								: document.selection &&
								  document.selection.createRange &&
								  ((c = document.selection.createRange()),
								  (a = 0 - c.duplicate().moveStart("character", -1e5)),
								  (b = a + c.text.length)),
						  { begin: a, end: b });
			},
			unmask: function() {
				return this.trigger("unmask");
			},
			mask: function(c, g) {
				var h, i, j, k, l, m, n, o;
				if (!c && this.length > 0) {
					h = a(this[0]);
					var p = h.data(a.mask.dataName);
					return p ? p() : void 0;
				}
				return (
					(g = a.extend(
						{
							autoclear: a.mask.autoclear,
							placeholder: a.mask.placeholder,
							completed: null
						},
						g
					)),
					(i = a.mask.definitions),
					(j = []),
					(k = n = c.length),
					(l = null),
					a.each(c.split(""), function(a, b) {
						"?" == b
							? (n--, (k = a))
							: i[b]
								? (j.push(new RegExp(i[b])),
								  null === l && (l = j.length - 1),
								  k > a && (m = j.length - 1))
								: j.push(null);
					}),
					this.trigger("unmask").each(function() {
						function h() {
							if (g.completed) {
								for (var a = l; m >= a; a++) if (j[a] && C[a] === p(a)) return;
								g.completed.call(B);
							}
						}
						function p(a) {
							return g.placeholder.charAt(a < g.placeholder.length ? a : 0);
						}
						function q(a) {
							for (; ++a < n && !j[a]; );
							return a;
						}
						function r(a) {
							for (; --a >= 0 && !j[a]; );
							return a;
						}
						function s(a, b) {
							var c, d;
							if (!(0 > a)) {
								for (c = a, d = q(b); n > c; c++)
									if (j[c]) {
										if (!(n > d && j[c].test(C[d]))) break;
										(C[c] = C[d]), (C[d] = p(d)), (d = q(d));
									}
								z(), B.caret(Math.max(l, a));
							}
						}
						function t(a) {
							var b, c, d, e;
							for (b = a, c = p(a); n > b; b++)
								if (j[b]) {
									if (
										((d = q(b)),
										(e = C[b]),
										(C[b] = c),
										!(n > d && j[d].test(e)))
									)
										break;
									c = e;
								}
						}
						function u() {
							var a = B.val(),
								b = B.caret();
							if (o && o.length && o.length > a.length) {
								for (A(!0); b.begin > 0 && !j[b.begin - 1]; ) b.begin--;
								if (0 === b.begin)
									for (; b.begin < l && !j[b.begin]; ) b.begin++;
								B.caret(b.begin, b.begin);
							} else {
								for (A(!0); b.begin < n && !j[b.begin]; ) b.begin++;
								B.caret(b.begin, b.begin);
							}
							h();
						}
						function v() {
							A(), B.val() != E && B.change();
						}
						function w(a) {
							if (!B.prop("readonly")) {
								var b,
									c,
									e,
									f = a.which || a.keyCode;
								(o = B.val()),
									8 === f || 46 === f || (d && 127 === f)
										? ((b = B.caret()),
										  (c = b.begin),
										  (e = b.end),
										  e - c === 0 &&
												((c = 46 !== f ? r(c) : (e = q(c - 1))),
												(e = 46 === f ? q(e) : e)),
										  y(c, e),
										  s(c, e - 1),
										  a.preventDefault())
										: 13 === f
											? v.call(this, a)
											: 27 === f &&
											  (B.val(E), B.caret(0, A()), a.preventDefault());
							}
						}
						function x(b) {
							if (!B.prop("readonly")) {
								var c,
									d,
									e,
									g = b.which || b.keyCode,
									i = B.caret();
								if (
									!(b.ctrlKey || b.altKey || b.metaKey || 32 > g) &&
									g &&
									13 !== g
								) {
									if (
										(i.end - i.begin !== 0 &&
											(y(i.begin, i.end), s(i.begin, i.end - 1)),
										(c = q(i.begin - 1)),
										n > c && ((d = String.fromCharCode(g)), j[c].test(d)))
									) {
										if ((t(c), (C[c] = d), z(), (e = q(c)), f)) {
											var k = function() {
												a.proxy(a.fn.caret, B, e)();
											};
											setTimeout(k, 0);
										} else B.caret(e);
										i.begin <= m && h();
									}
									b.preventDefault();
								}
							}
						}
						function y(a, b) {
							var c;
							for (c = a; b > c && n > c; c++) j[c] && (C[c] = p(c));
						}
						function z() {
							B.val(C.join(""));
						}
						function A(a) {
							var b,
								c,
								d,
								e = B.val(),
								f = -1;
							for (b = 0, d = 0; n > b; b++)
								if (j[b]) {
									for (C[b] = p(b); d++ < e.length; )
										if (((c = e.charAt(d - 1)), j[b].test(c))) {
											(C[b] = c), (f = b);
											break;
										}
									if (d > e.length) {
										y(b + 1, n);
										break;
									}
								} else C[b] === e.charAt(d) && d++, k > b && (f = b);
							return (
								a
									? z()
									: k > f + 1
										? g.autoclear || C.join("") === D
											? (B.val() && B.val(""), y(0, n))
											: z()
										: (z(), B.val(B.val().substring(0, f + 1))),
								k ? b : l
							);
						}
						var B = a(this),
							C = a.map(c.split(""), function(a, b) {
								return "?" != a ? (i[a] ? p(b) : a) : void 0;
							}),
							D = C.join(""),
							E = B.val();
						B.data(a.mask.dataName, function() {
							return a
								.map(C, function(a, b) {
									return j[b] && a != p(b) ? a : null;
								})
								.join("");
						}),
							B.one("unmask", function() {
								B.off(".mask").removeData(a.mask.dataName);
							})
								.on("focus.mask", function() {
									if (!B.prop("readonly")) {
										clearTimeout(b);
										var a;
										(E = B.val()),
											(a = A()),
											(b = setTimeout(function() {
												B.get(0) === document.activeElement &&
													(z(),
													a == c.replace("?", "").length
														? B.caret(0, a)
														: B.caret(a));
											}, 10));
									}
								})
								.on("blur.mask", v)
								.on("keydown.mask", w)
								.on("keypress.mask", x)
								.on("input.mask paste.mask", function() {
									B.prop("readonly") ||
										setTimeout(function() {
											var a = A(!0);
											B.caret(a), h();
										}, 0);
								}),
							e && f && B.off("input.mask").on("input.mask", u),
							A();
					})
				);
			}
		});
});

const Keys = {
	BACKSPACE: 8,
	TAB: 9,
	ENTER: 13,
	SHIFT: 16,
	CTRL: 17,
	ALT: 18,
	PAUSE: 19,
	CAPS_LOCK: 20,
	ESCAPE: 27,
	PAGE_UP: 33,
	PAGE_DOWN: 34,
	END: 35,
	HOME: 36,
	LEFT_ARROW: 37,
	UP_ARROW: 38,
	RIGHT_ARROW: 39,
	DOWN_ARROW: 40,
	INSERT: 45,
	DELETE: 46,
	"0": 48,
	"1": 49,
	"2": 50,
	"3": 51,
	"4": 52,
	"5": 53,
	"6": 54,
	"7": 55,
	"8": 56,
	"9": 57,
	A: 65,
	B: 66,
	C: 67,
	D: 68,
	E: 69,
	F: 70,
	G: 71,
	H: 72,
	I: 73,
	J: 74,
	K: 75,
	L: 76,
	M: 77,
	N: 78,
	O: 79,
	P: 80,
	Q: 81,
	R: 82,
	S: 83,
	T: 84,
	U: 85,
	V: 86,
	W: 87,
	X: 88,
	Y: 89,
	Z: 90,
	LEFT_SUPER: 91,
	RIGHT_SUPER: 92,
	SELECT_KEY: 93,
	NUMPAD_0: 96,
	NUMPAD_1: 97,
	NUMPAD_2: 98,
	NUMPAD_3: 99,
	NUMPAD_4: 100,
	NUMPAD_5: 101,
	NUMPAD_6: 102,
	NUMPAD_7: 103,
	NUMPAD_8: 104,
	NUMPAD_9: 105,
	MULTIPLY: 106,
	ADD: 107,
	SUBTRACT: 109,
	DECIMAL_POINT: 110,
	DIVIDE: 111,
	F1: 112,
	F2: 113,
	F3: 114,
	F4: 115,
	F5: 116,
	F6: 117,
	F7: 118,
	F8: 119,
	F9: 120,
	F10: 121,
	F11: 122,
	F12: 123,
	NUM_LOCK: 144,
	SCROLL_LOCK: 145,
	SEMI_COLON: 186,
	EQUAL_SIGN: 187,
	COMMA: 188,
	DASH: 189,
	PERIOD: 190,
	FORWARD_SLASH: 191,
	GRAVE_ACCENT: 192,
	OPEN_BRACKET: 219,
	BACK_SLASH: 220,
	CLOSE_BRAKET: 221,
	SINGLE_QUOTE: 222
};

var texturize = function(input) {
	return $.map(input.split("\n\n"), function(paragraph) {
		return $("<p />").html(paragraph.replace("\n", "<br>"));
	});
};

var qualifyUrl = function(pieces) {
	var url = globals.root;
	if (Array.isArray(pieces)) {
		url += pieces.join("/");
	} else {
		throw new Error(
			"the non-array version of this function isn't written yet LOL"
		);
	}
	return url;
};

$(function() {
	console.log("jQuery active");

	var $task_warning = $("#task_warning").hide();

	$(".phone_mask").mask("(999) 999-9999");

	$("body")
		.on("change", "#tasks-ids", function(e) {
			var $tasks_ids = $(this);

			var indoor_jobs = $tasks_ids.find(":selected").filter(function(idx) {
				return (
					$(this)
						.text()
						.indexOf("Indoor") == 0
				);
			}).length;

			if (indoor_jobs < 1) {
				$task_warning.slideDown("fast");
			} else {
				$task_warning.slideUp("fast");
			}
		})
		.on("submit", "form:not(.ng-scope)", function() {
			var $form = $(this);

			$form.find("button[type=submit]").attr("disabled", "disabled");
		});

	$(".tzOffset").val(new Date().getTimezoneOffset());

	$(".card.card--job").on("keydown", ".card--job__notes__note", function(e) {
		if (Keys.ENTER == e.which && !e.shiftKey) {
			var $note = $(this),
				$job_card = $note.closest(".card");

			const job_id = $job_card.data("job-id"),
				note = $note.val().trim();

			if ("" != note) {
				$.ajax({
					url: qualifyUrl(["jobs", "note", job_id]),
					dataType: "JSON",
					type: "POST",
					data: {
						note: note
					}
				})
					.done(function(response) {
						$(
							".card--job[data-job-id=" + job_id + "] .card--job__notes__notes"
						).html(texturize(response.job.notes));

						$note.val("");
					})
					.fail(function(x, y, z) {});
			}
		}
	});

	$(".conditions").on("click", ".conditions__add", function(e) {
		e.preventDefault();
		var $condition_toggle = $(this);

		// TODO: make this prettier than using "prompt"
		var condition = prompt("New Condition");

		$.ajax({
			url: qualifyUrl(["conditions", "quick-add"]),
			dataType: "JSON",
			type: "POST",
			data: {
				title: condition
			}
		})
			.done(function(response) {
				$condition_toggle
					.closest(".conditions")
					.find(".conditions__data")
					.append(response.template);
			})
			.fail(function(x, y, z) {});

		return false;
	});

	$(".tools").on("click", ".tools__add", function(e) {
		e.preventDefault();

		var $tool_toggle = $(this);

		var tool = prompt("New Tool");

		$.ajax({
			url: qualifyUrl(["tools", "quick_add"]),
			dataType: "JSON",
			type: "POST",
			data: {
				title: tool
			}
		})
			.done(function(response) {
				$tool_toggle
					.closest(".tools")
					.find(".tools__data")
					.append(response.template);
			})
			.fail(function(x, y, z) {
				// TODO: fix this failure
			});

		return false;
	});

	$(".card.card--todo").on("change", ".card__status-toggle", function(e) {
		var $todo_card = $(this).closest(".card");

		const todo_id = $todo_card.data("todo-id"),
			status = this.checked ? "complete" : "incomplete";

		$.ajax({
			url: "/todos/status/" + todo_id + "/" + status + "/",
			dataType: "JSON",
			type: "POST"
		})
			.done(function(response) {
				this.checked = response.todo.completed;
				if (response.todo.completed) {
					$todo_card.addClass("card--complete").removeClass("card--incomplete");
				} else {
					$todo_card.addClass("card--incomplete").removeClass("card--complete");
				}
			})
			.fail(function(x, y, z) {});
	});

	// contact-address-1
	var placesAutocomplete = places({
		apiKey: "1e839858cc1230be575046f34bcf6a31",
		appId: "pl0J3KHR6WLE",
		container: document.querySelector("#contact-address-1"),
		aroundLatLng: "41.3149,-105.5666",
		aroundRadius: 16 * 1000,
		type: "address",
		templates: {
			value: function(suggestion) {
				return suggestion.name;
			}
		}
	});

	placesAutocomplete.on("change", function resultSelected(e) {
		// city - suggestion.city
		// #contact-zip 	-	suggestion.postcode
		// lat lng - suggestion.latlng
		// address1 - suggestion.name
		document.querySelector("#contact-zip").value = e.suggestion.postcode;
		console.log({
			meta_key: "latitude",
			meta_value: e.suggestion.latlng.lat
		});
		console.log({
			meta_key: "longitude",
			meta_value: e.suggestion.latlng.lng
		});
	});
});
