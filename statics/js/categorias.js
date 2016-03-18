/* global showModal */
/* global userStats */
$(document).on("ready", function () {

	if (!userStats['user']) {

		// showModal($("#acceso-restringido"));
		$(".user-cmd-dropdown:visible").fadeOut();
		$(".user-cmd-dropdown.user-not-logged-message").fadeIn();

	}

	$(".admin-cmds")
		.find(".add-category")
		.on("click", function (e) {

			e.preventDefault();
			showModal($("#new-category"));

		})
		.end()
		.find(".add-article")
		.on("click", function (e) {

			e.preventDefault();
			showModal($("#new-article"));

		});

	$(".admin-category-cmd.cmd-edit").on("click", function (e) {

		e.preventDefault();
		var $newCategory = $("#new-category");

		$newCategory.find("#id").val($(this).data("id"));
		$newCategory.find("#titulo").val($(this).data("titulo"));
		$newCategory.find("#descripcion_breve").val($(this).data("descripcion_breve"));
		$newCategory.find("#descripcion").val($(this).data("descripcion"));
		$newCategory.find("#categoria_id").val($(this).data("categoria_id"));
		$newCategory.find("#orden").val($(this).data("orden"));

		showModal($newCategory);

	});

	$(".admin-category-cmd.cmd-delete").on("click", function (e) {
		
		e.preventDefault();
		var $deleteCategory = $("#delete-category");

		console.log($deleteCategory.find("#id"));

		$deleteCategory.find("#id").val($(this).data("id"));
		$deleteCategory.find(".category-name").text($(this).data("titulo"));

		showModal($deleteCategory);

	});

	$(".admin-article-cmd.cmd-edit").on("click", function (e) {

		e.preventDefault();
		var $newArticle = $("#new-article");

		$newArticle.find("#id").val($(this).data("id"));
		$newArticle.find("#nombre").val($(this).data("nombre"));
		$newArticle.find("#descripcion_breve").val($(this).data("descripcion_breve"));
		$newArticle.find("#descripcion").val($(this).data("descripcion"));
		$newArticle.find("#categoria_id").val($(this).data("categoria_id"));
		$newArticle.find("#codigo").val($(this).data("codigo"));
		$newArticle.find("#precio").val($(this).data("precio"));
		$newArticle.find("#precio_oferta").val($(this).data("precio_oferta"));
		$newArticle.find("#precio_surtido").val($(this).data("precio_surtido"));
		$newArticle.find("#precio_oferta_surtido").val($(this).data("precio_oferta_surtido"));
		$newArticle.find("#talle").val($(this).data("talle"));
		// $newArticle.find("#adaptable").prop("checked", ($(this).data('adaptable') == 1));
		$newArticle.find("#packs").val($(this).data("packs"));
		$newArticle.find("#categoria_id").val($(this).data("categoria_id"));
		$newArticle.find("#orden").val($(this).data("orden"));
		$newArticle.find("#nuevo").prop("checked", ($(this).data('nuevo') == 1));
		$newArticle.find("#agotado").prop("checked", ($(this).data('agotado') == 1));
		$newArticle.find("#oferta").prop("checked", ($(this).data('oferta') == 1));
		$newArticle.find("#surtido").prop("checked", ($(this).data('surtido') == 1));

		showModal($newArticle);

	});

	$(".admin-article-cmd.cmd-delete").on("click", function (e) {

		e.preventDefault();
		var $deleteArticle = $("#delete-article");

		$deleteArticle.find("#id").val($(this).data("id"));
		$deleteArticle.find(".article-name").text($(this).data("nombre"));

		showModal($deleteArticle);

	});
	
	$('.packs-cantidad').on("keyup blur", function(e) {
		
		var cantidad = $(this).val();
		if(e.type == 'blur' && (isNaN(cantidad) || cantidad == "" || cantidad == "0")) {
			$(this).val(1);
		}
		
		if(parseInt(cantidad) > 9) {
			$(this).val(9);
		}
		
	});

	// if($(".lista-articulos").length && userStats.status == "LOGGED" && userStats.user.email == 'miguelmail2006@gmail.com' && !localStorage.messageViewed) {
	if($(".lista-articulos").length && userStats.status == "LOGGED" && !localStorage.messageViewed) {

		localStorage.messageViewed = true;
		showModal($('#mensaje-nueva-forma-compra'));

	}

	$(".add-to-cart").on("click", function (e) {
		e.preventDefault();

		var $this = $(this);

		if ($this.text() == "Agregando...") return;

		// mostrar alguna especie de Agregando al carrito
		$this
			.removeClass("purple")
			.addClass("agregando")
			.html("Agregando...<span class='fa fa-shopping-cart'></span>");
			
		// limpiar los campos con error antes de chequear de nuevo
		$this.parents('.item-articulo-info').find('.item-articulo-subinfo.item-articulo-info-surtido > .item-articulo-talles').css({border: 'none'});
		$this.parents('.item-articulo-info').find('.item-articulo-subinfo.item-articulo-info-surtido > .item-articulo-colores').css({border: 'none'});
				
		var codigoArticulo = $this.parents(".item-articulo-info").find(".item-articulo-titulo strong").text();
		// valores por defecto
		var esPack = true;
		var talleSeleccionado = '';
		var colorSeleccionado = '';
		
		if($this.parents('.item-articulo-info').find('.item-switch-pack-surtido').length) {
			esPack = $this.parents('.item-articulo-info').find('.item-switch-pack-surtido a.selected').data('tab').replace('item-articulo-info-','') == 'pack' ? true : false;
			talleSeleccionado = !esPack ? '&t=' + $this.parents('.item-articulo-info').find('.item-articulo-subinfo.item-articulo-info-surtido > .item-articulo-talles > .info-value > select.talle-select').val() : '';
			colorSeleccionado = !esPack ? '&color=' + $this.parents('.item-articulo-info').find('.item-articulo-subinfo.item-articulo-info-surtido > .item-articulo-colores > .info-value > ul.lista-colores > li.color > span.selected').attr('id') : '';
		}
		
		if(!esPack && (talleSeleccionado == '&t=0' || colorSeleccionado == '&color=undefined')) {
			if(talleSeleccionado == '&t=0') {
				$this.parents('.item-articulo-info').find('.item-articulo-subinfo.item-articulo-info-surtido > .item-articulo-talles').css({border: '1px solid #f00'});
			}
			if(colorSeleccionado == '&color=undefined') {
				$this.parents('.item-articulo-info').find('.item-articulo-subinfo.item-articulo-info-surtido > .item-articulo-colores').css({border: '1px solid #f00'});
			}
			
			$this
				.removeClass("agregando")
				.addClass("purple")
				.html("Agregar al pedido<span class='fa fa-shopping-cart'></span>");
				
			return false;
		}
		
		// $.getJSON("/app/pedido/agregar?id=" + $(this).data("id") + "&c=" + $(this).siblings("label").find("input").val(), function(e) {
		// console.log("/app/pedido/agregar?id=" + $(this).data("id") + "&c=" + $(this).siblings("label").find("input").val() + '&p=' + esPack + talleSeleccionado + colorSeleccionado);
		if($(this).siblings("label").find("input").val() < 1) $(this).siblings("label").find("input").val(1);
		var cantidad = $(this).siblings("label").find("input").val() ? $(this).siblings("label").find("input").val() : 1;
		$.getJSON("/app/pedido/agregar?id=" + $(this).data("id") + "&c=" + cantidad + '&p=' + esPack + talleSeleccionado + colorSeleccionado, function(e) {

			// eliminar el mensaje de Agregando al carrito
			$this
				.removeClass("agregando")
				.addClass("purple")
				.html("Agregar al pedido<span class='fa fa-shopping-cart'></span>");

			// mostrar el mensaje de articulo agregado
			$(".user-cmd-dropdown.user-cart")
				.find(".cantidad-articulos-pedido")
				.text(e.pedido.cantidad)
				.end()
				.find(".articulo-agregado-al-pedido")
				.text(codigoArticulo)
				.end()
				.fadeIn();

			// actualizar el pedido arriba
			$('.user-menu.user-cart').find('.link-label').text('Pedido (' + e.pedido.cantidad + ')');

		});

	});

	// escuchar a la posicioni de la columna izquierda con respecto al pie de la página
	// $(".lista-categorias-columna-izquierda").data("bottom-absoluto", $(".lista-categorias-columna-izquierda").offset().top);
	$("#body").on("scroll", function (e) {

		ajustarPosicionColumnaIzquierda();

	})
	$(window).on("resize", function(e) {

		ajustarPosicionColumnaIzquierda();

	});

	$("#oferta").on("click", function() {
		if(!$(this).is(":checked") && $("#precio_oferta").val() == "") {
			$("#precio_oferta").val("0");
		}
	});

	$("#precio_oferta").on("blur", function() {
		if($(this).val() == "") {
			$(this).val("0");
		}
	});
	
	// cambiar entre surtido y pack
	$('.item-switch-pack-surtido').off('click');
	$('.item-switch-pack-surtido').on('click', 'a.item-switch-tab', function() {
		var tabSelected = $(this).data('tab');
			
		$(this).parent().find('.selected').removeClass('selected');
		$(this).addClass('selected');
			
		$(this)
			.parents('.item-articulo-info')
			.find('.item-articulo-subinfo.visible')
			.removeClass('visible')
			.end()
			.find('.' + tabSelected)
			.addClass('visible');
	});
	
	// selector de colores
	$('.lista-colores.seleccionable').on('click', 'li.color > span', function() {
		$(this).parents('.lista-colores').find('li.color > span.selected').removeClass('selected');
		$(this).addClass('selected');
	});

	if($(".lista-categorias-columna-izquierda").length) {
		$(".lista-categorias-columna-izquierda").data("bottom-absoluto", parseInt($(".lista-categorias-columna-izquierda").css("top").replace("px","")) + $(".lista-categorias-columna-izquierda").outerHeight());
		$(".lista-categorias-columna-izquierda").data("top-absoluto", parseInt($(".lista-categorias-columna-izquierda").css("top").replace("px","")));
	}

	ajustarPosicionColumnaIzquierda();

});

function ajustarPosicionColumnaIzquierda() {

	var columnaIzqBottom = $(".lista-categorias-columna-izquierda").data("bottom-absoluto");
	var columnaIzqTop = $(".lista-categorias-columna-izquierda").data("top-absoluto");
	var windowHeight = $(window).innerHeight();
	// var footerTop = $("#body").find("footer").offset().top;
	var footerTop = $(window).innerHeight() - $("#body").find("footer").outerHeight();
	var footerHeight = $("#body").find("footer").outerHeight();
	var dif = footerTop - columnaIzqBottom;

	if (columnaIzqBottom > windowHeight) {

		$(".lista-categorias-columna-izquierda").removeAttr("style");

		if (dif < 0) {

			$(".lista-categorias-columna-izquierda").removeAttr("style");
			$(".lista-categorias-columna-izquierda").css("top", "auto");
			$(".lista-categorias-columna-izquierda").css("bottom", ((dif * -1) >= footerHeight ? footerHeight : (dif * -1)) + "px");

		} else {

			$(".lista-categorias-columna-izquierda").css("top", "auto");
			$(".lista-categorias-columna-izquierda").css("bottom", 0);

		}

	} else if (dif < 0) {

		$(".lista-categorias-columna-izquierda").removeAttr("style");
		$(".lista-categorias-columna-izquierda").css("top", (columnaIzqTop - (dif * -1)) + "px");

	} else {

		$(".lista-categorias-columna-izquierda").removeAttr("style");
		$(".lista-categorias-columna-izquierda").css("top", columnaIzqTop + "px");

	}

}