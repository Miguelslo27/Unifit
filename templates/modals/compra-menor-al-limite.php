<!-- COMPRA MENOR AL LIMITE -->
<?php
$cartItems = $GLOBALS['cartItems'];
$userStats = $GLOBALS['userStats'];
?>
<style>
#compra-menor-al-limite {
	background: none repeat scroll 0 0 #fff;
    border: 1px solid;
    border-radius: 10px;
    margin: auto;
    position: relative;
    text-align: center;
    top: 150px;
    width: 400px;
    box-shadow: 0 0 3px rgba(0,0,0,.75);
}
#compra-menor-al-limite .mensaje-modal-inner {}
#compra-menor-al-limite .mensaje-modal-titulo {
	padding: 20px;
	border-bottom: 1px solid #dedede;
}
#compra-menor-al-limite .mensaje-modal-titulo h3 {
	margin: 0;
}
#compra-menor-al-limite .mensaje-modal-titulo a {}
#compra-menor-al-limite .mensaje-modal-contenido {
	padding: 0 15px;
}
#compra-menor-al-limite .mensaje-modal-contenido p {}
#compra-menor-al-limite .mensaje-modal-pie {
	padding: 10px;
}
#compra-menor-al-limite .mensaje-modal-pie a {}
</style>
<div class="mensaje-modal" id="compra-menor-al-limite">
	<div class="mensaje-modal-inner">
		<div class="mensaje-modal-titulo">
			<h3>No puedes finalizar tu compra!</h3>
			<a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>
		</div>
		<div class="mensaje-modal-contenido">
			<p>Para finalizar tu compra, el monto total de la misma debe ser igual o superior a <strong id="compra-minima">$ 2.000,00</strong>, sólo te faltan <strong id="diferencia-de-compra">$ <?php echo (2000 - (double)$userStats['cart']->total); ?>,00</strong> para llegar al mínimo.</p>
		</div>
		<div class="mensaje-modal-pie">
			<a href="/categorias" class="btn btn-style black">Seguir Comprando</a>
		</div>
	</div>
</div>