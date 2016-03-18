$.backstretch("/statics/images/back1.jpg");

// procesos de la demo
var persist_obj = {
	logged: false,
	email: null
}

// deteccion del usuario
$(document).on("ready", function () {

	if (window.name != "") {

		var persist_obj = JSON.parse(window.name);

	}

	if (persist_obj && typeof persist_obj === "object") {

		if (persist_obj.logged) {

			// Agrego el nombre de usuario (demo)
			$("#user-cmd")
				.find(".user-login")
				.find(".label").text("Demo")
				.end().end()
				.find(".user-cart, .user-search")
				.show();

			// le muestro los pedidos
			console.log($("#body"));
			$("#body").fadeIn("fast");

		} else {

			$("#no-logged-message").fadeIn();

		}

	} else {

		$("#no-logged-message").fadeIn();

	}

});

$(".modal")
	.find(".modal-close")
	.on("click", function (e) {

		e.preventDefault();
		$(this).parents(".modal").fadeOut();
		setTimeout(function () {
			document.location.href = "/";
		}, 1000);

	});

$("#user-cmd")
	.find(".user-menu.user-login").on("click", function (e) {

		e.preventDefault();
		if (window.name != "") {

			var persist_obj = JSON.parse(window.name);

		}

		if (persist_obj && typeof persist_obj === "object") {

			if (persist_obj.logged) {

				// algo aca que ya esta logueado
				if ($(this).parent().find(".user-cmd-dropdown.user-info:visible").length) {

					$(this)
						.parent()
						.find(".user-cmd-dropdown.user-info")
						.slideUp("fast");

				} else {

					$(this)
						.parent()
						.find(".user-cmd-dropdown.user-info")
						.slideDown("fast");

				}

				return;

			} else {

				$("#first-time-user").fadeIn();

			}

		} else {

			$("#first-time-user").fadeIn();

		}

	})
	.end()
	.find("#logout").on("click", function () {

		window.name = "";
		document.location.href = "/";

	});