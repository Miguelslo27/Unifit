/* global closeModal */
$(document).on("ready", function () {

	$(".cart-cmds")
		.on("click", ".completar-pedido", function (e) {

			e.preventDefault();
			
			// cuento los items del carrito
			var total_items          = $('#pedido-actual.carrito > tbody > tr').length;
			var total_items_surtidos = $('#pedido-actual.carrito > tbody > tr > td span.valor-surtido:contains(Si)').length;
			var total_items_packs    = $('#pedido-actual.carrito > tbody > tr > td span.valor-surtido:contains(No)').length;
			var compra_minima		 = 0;
			var diferencia_de_compra = 0;
			
			// si todo el carrito tiene solamente compras surtidas
			if(total_items_surtidos == total_items && total_items_packs == 0) {
				compra_minima = 2500;
			}
			// si el carrito tiene compras mixtas
			else {
				compra_minima = 2000;
			}
			
			diferencia_de_compra = compra_minima - parseFloat(userStats['cart']['total']);
			$('#compra-minima').text('$ ' + compra_minima.formatMoney(2, ',', '.'));
			$('#diferencia-de-compra').text('$ ' + diferencia_de_compra.formatMoney(2, ',', '.'));
			
			if(parseFloat(userStats['cart']['total']) >= compra_minima) {
				showModal($("#completar-pedido"));
			} else {
				showModal($("#compra-menor-al-limite"));
			}

		});

	$('#form-confirmar-pedido').find('input[type=radio][name!=forma_de_pago]').on('click', function(e) {
		showTheForm($(this));
	});

	// $("#retira").on("click", function (e) {

	// 	if ($(this).is(":checked")) {

	// 		$("#retira_en_agencia_m").show();
	// 		$("#retira_en_local_m").hide();
	// 		$("#direccion_de_entrega_c").hide();
	// 		$("#retira_en_local_c").hide();
	// 		$("#retira_en_local_m").hide();

	// 	} else {

	// 		$("#retira_en_agencia_m").hide();
	// 		$("#direccion_de_entrega_c").show();
	// 		$("#retira_en_local_c").show();
	// 		$("#retira_en_local_m").hide();

	// 	}

	// });

	// $("#compra_en_local").on("click", function (e) {

	// 	if ($(this).is(":checked")) {

	// 		$("#retira_en_local_m").show();
	// 		$("#retira_en_agencia_c").hide();
	// 		$("#retira_en_agencia_m").hide();
	// 		$("#direccion_de_entrega_c").hide();
	// 		$("#agencia_de_entrega_c").hide();
	// 		$("#forma_de_pago_c").hide();

	// 	} else {

	// 		$("#retira_en_local_m").hide();
	// 		$("#retira_en_agencia_c").show();
	// 		$("#direccion_de_entrega_c").show();
	// 		$("#agencia_de_entrega_c").show();
	// 		$("#forma_de_pago_c").show();

	// 	}

	// });

	$("#completar-pedido")
		.on("click", ".terminar-confirmacion-pedido", function (e) {

			e.preventDefault();
			var hayerrores = false;

			// limpio los mensajes de error
			$("#mensajes-de-error")
				.find(".datos-de-error")
				.html("");

			// Chequeo que haya una forma de entrega seleccionada
			if(!$("#envio_interior").is(":checked") && !$("#envio_montevideo").is(":checked")) {
				$("#mensajes-de-error")
					.find(".datos-de-error")
					.append("<li>Debe especificar la forma de entrega</li>");

				$("#mensajes-de-error").slideDown('normal', function() {
					document.location.hash = ""
					document.location.hash = "mensajes-de-error";
				});
				return false;
			}

			// si la forma de entrega es envio al interior
			if($("#envio_interior").is(":checked")) {
				// chequeo que haya una forma de entrega en el interior seleccionada
				if(!$("#envio_interior_retira_agencia").is(":checked") && !$("#envio_interior_direccion_entrega").is(":checked")) {
					$("#mensajes-de-error")
						.find(".datos-de-error")
						.append("<li>Debe especificar la forma de entrega en el interior</li>");

					$("#mensajes-de-error").slideDown('normal', function() {
						document.location.hash = ""
						document.location.hash = "mensajes-de-error";
					});
					return false;
				}

				if($("#envio_interior_retira_agencia").is(":checked")) {
					if($.trim($("#agencia-entrega-interior-input").val()) == "") {
						$("#mensajes-de-error")
							.find(".datos-de-error")
							.append("<li>Debe especificar por que Agencia desea recibir</li>");

						$("#mensajes-de-error").slideDown('normal', function() {
							document.location.hash = ""
							document.location.hash = "mensajes-de-error";
						});
						return false;
					}
				}

				if($("#envio_interior_direccion_entrega").is(":checked")) {
					var conerrores = false;
					if($.trim($("#agencia-entrega-input").val()) == "") {
						$("#mensajes-de-error")
							.find(".datos-de-error")
							.append("<li>Debe especificar por que Agencia desea recibir</li>");
						conerrores = true;
					}

					if($.trim($("#direccion-entrega-interior-input").val()) == "") {
						$("#mensajes-de-error")
							.find(".datos-de-error")
							.append("<li>Debe especificar la Dirección de entrega</li>");
						conerrores = true;
					}

					if(conerrores) {
						$("#mensajes-de-error").slideDown('normal', function() {
							document.location.hash = ""
							document.location.hash = "mensajes-de-error";
						});
						return false;
					}
				}
			}

			if($("#envio_montevideo").is(":checked")) {
				if(!$("#envio_montevideo_retira_local").is(":checked") && !$("#envio_montevideo_direccion_entrega").is(":checked")) {
					$("#mensajes-de-error")
						.find(".datos-de-error")
						.append("<li>Debe especificar la forma de entreva en Montevideo</li>");

					$("#mensajes-de-error").slideDown('normal', function() {
						document.location.hash = ""
						document.location.hash = "mensajes-de-error";
					});
					return false;
				}

				if($("#envio_montevideo_direccion_entrega").is(":checked")) {
					if($.trim($("#direccion-entrega-montevideo-input").val()) == "") {
						$("#mensajes-de-error")
							.find(".datos-de-error")
							.append("<li>Debe especificar la Dirección de entrega</li>");
						$("#mensajes-de-error").slideDown('normal', function() {
							document.location.hash = ""
							document.location.hash = "mensajes-de-error";
						});
						return false;
					}
				}
			}

			if($("#forma_de_pago_c:visible").length) {
				if(!$("#forma_de_pago_c input[type=radio]:checked").length) {
					$("#mensajes-de-error")
						.find(".datos-de-error")
						.append("<li>Debe especificar una forma de pago</li>");
					$("#mensajes-de-error").slideDown('normal', function() {
						document.location.hash = ""
						document.location.hash = "mensajes-de-error";
					});
					return false;
				}
			}
			
			// cuando ya no hay errores
			$("#mensajes-de-error")
				.slideUp()
				.find(".datos-de-error")
				.html("");

			document.location.hash = "";

			// mostrar mensaje cargando...
			$("#completar-pedido").find(".cargando").fadeIn("fast");

			var formPedido = {
				'lugar_compra': $("#form-confirmar-pedido").find("input[name=envio]:checked").attr("id"),
				'retira_agencia': $("#envio_interior_retira_agencia").is(":checked"),
				'agencia_entrega': $("#envio_interior_retira_agencia").is(":checked") ? $("#agencia-entrega-interior-input").val() : $("#agencia-entrega-input").val(),
				'direccion_entrega': $("#envio_interior").is(":checked") ? $("#direccion-entrega-interior-input").val() : $("#direccion-entrega-montevideo-input").val(),
				'retira_local': $("#envio_montevideo_retira_local").is(":checked"),
				'forma_pago': $("#form-confirmar-pedido").find("input[name=forma_de_pago]:checked").val()
			};

			// envio el pedido a ser procesado
			$.post("/app/pedido/completar/?id=" + $(this).data("id"), formPedido, function (data) {

				// console.log(data);

				$("#completar-pedido").find(".cargando").fadeOut("fast");
				closeModal();
				// refrescar el pedido
				document.location.href = "/pedido/pedido-ingresado/";

			});

		});

		$("#pedido-actual")
			.on("click", ".acciones-carrito.accion-eliminar", function (e) {

				e.preventDefault();
				var $this = $(this);
				// $this.find(".accion-label").text("Eliminando...");
				$this.off("click");

				$.getJSON("/app/pedido/eliminar?id_pedido=" + $(this).data("idpedido") + "&ida=" + $(this).data("itemid") + "&idp=" + $(this).data("pedidoid") + "&precioitem=" + $(this).data("precioitem") + "&cantidaditem=" + $(this).data("cantidaditem") + "&totalpedido=" + $(this).data("totalpedido") + "&totalitems=" + $(this).data("totalitems"), function (e) {

					// document.location.href = document.location.href;
					$this.parents("tr:first").remove();
					// var totalPedido = $(".user-menu.user-cart").find(".link-label").text().replace("Pedido (", "").replace(")", "");

					$(".modal#completar-pedido").find(".modal-content").load(document.location.href + " .modal-col");
					
					$(".user-menu.user-cart").find(".link-label").text("Pedido (" + e.articulos + ")");
					if (e.articulos > 0) {

						$(".total-value:first").text("$ " + e.total + ",00");

					} else {

						// $("#pedido-actual tfoot:first").remove()
						$("#pedido-actual tbody:first").html('<tr><td colspan="6" class="no-items">No hay artículos para mostrar. Comience a comprar yendo a <a href="/categorias">Mis Pedidos Online</a>.</td></tr>');
						// setTimeout(function () {

							document.location.href = document.location.href;

						// }, 2500);
						

					}

					document.location.href = document.location.href;

				});

			});

});

function showTheForm(check) {

	var $radios = $('#form-confirmar-pedido').find('input[type=radio]');
	$radios.each(function() {

		var
		$this = $(this),
		isChecked = $this.is(':checked'),
		$form = $('#' + $this.data('show')),
		$formaPago = $('#forma_de_pago_c');

		if(isChecked && $this.is(':visible')) {
			$form.slideDown('fast', function() {
				var showPayment = !!($this.data('formadepago') == 'show');
				if(showPayment) {
					$formaPago.slideDown('fast');
				} else {
					$formaPago.slideUp('fast');
				}
			});
		} else {
			$form.slideUp('fast');
		}

	});

}

Number.prototype.formatMoney = function(c, d, t) {
	var n = this, 
		c = isNaN(c = Math.abs(c)) ? 2 : c, 
		d = d == undefined ? "." : d, 
		t = t == undefined ? "," : t, 
		s = n < 0 ? "-" : "", 
		i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
		j = (j = i.length) > 3 ? j % 3 : 0;
		
	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};