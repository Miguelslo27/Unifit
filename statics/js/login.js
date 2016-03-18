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
			// $("#user-cmd")
			// 	.find(".user-login")
			// 	.find(".label").text("Demo")
			// 	.end().end()
			// 	.find(".user-cart, .user-search")
			// 	.show();

			// lo envio a la portada
			setTimeout(function () {

				document.location.href = "/";

			}, 2000);

		}

	}

});