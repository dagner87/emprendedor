<?php
require_once "/var/www/html/emprendedores/sistema/mercado-pago/lib/mercadopago.php";

$mp = new MP ("7648711035353831", "bOJIZgeynb1zUBjRHEs87b4oeGZz9fBe");

$preference_data = array (
    "items" => array (
        array (
            "title" => "Purificador Dvigi",
            "quantity" => 1,
            "currency_id" => "AR",
            "unit_price" => 100
        )
    )
);

$preference = $mp->create_preference($preference_data);

print_r ($preference);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Pagos mercado pago dvigi</title>
	</head>
	<body>
		<a href="<?php echo $preference['response']['sandbox_init_point']; ?>">Pagar</a>
	</body>
</html>