<!--

 * This file is part of a JoyGDR project
 *
 * Copyright (c) JoyGDR
 * https://github.com/lincolnjota
 */

-->
<?php

include("Modules/Mercado-Pago/products.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment</title>
</head>
<body>

<!-- This is a button to buy -->
<script
  src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
  data-button-label="Buy VIP" data-preference-id="<?php echo $preferenceItemOne->id; ?>">

</script>
</body>
</html>