<?php
/* Student: Santos, Johnzelle L. */
$currentPage = "order";
include 'header.html';
include 'footer.php';

$vatRate = 0.12;
$isOpen  = true;
$isMember = false;

$items = array(
    "Enchanted Lavender Fog",
    "Lavender Tea House Special",
    "Matcha Mint Mist",
    "Ube Dream Cheesecake",
    "Blue berry Macaron (3pc)",
    "Elderflower Cookie"
);
$prices        = array(160, 170, 150, 130, 100, 50);
$toppingNames  = array("Lavender Cream Top", "Stardust Sprinkles", "Honey Drizzle");
$toppingPrices = array(30, 20, 25);

$custNames    = array("Juan Dela Cruz", "Maria Santos", "Pedro Reyes", "Ana Lim");
$custTypes    = array(1, 0, 2, 1);
$orderProduct = array(0, 3, 4, 2);
$orderQty     = array(2, 1, 3, 4);
$orderBudget  = array(500, 100, 400, 300);

$order  = array("customer" => "Juan Dela Cruz", "type" => 1, "product" => 0, "qty" => 2, "budget" => 500);
$picked = array(1, 0, 1);
?>
<div class="page">

  <?php print $navLinks; ?>
  <h1>Place Your Order</h1>
  <p class="welcome">Today's orders and your order slip, with discounts and 12% VAT.</p>

  <section class="card">
    <h2>Today's Orders</h2>
    <table>
      <thead>
        <tr>
          <th>Customer</th>
          <th>Type</th>
          <th>Product</th>
          <th class="num">Qty</th>
          <th class="num">Total</th>
          <th class="num">Budget</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
<?php
$revenue   = 0;
$paidCount = 0;

for ($i = 0; $i < 4; $i++) {
    $gross = $prices[$orderProduct[$i]] * $orderQty[$i];

    switch ($custTypes[$i]) {
        case 1:
            $rate  = 0.10;
            $label = "Student";
            break;
        case 2:
            $rate  = 0.20;
            $label = "Senior / PWD";
            break;
        default:
            $rate  = 0;
            $label = "Regular";
    }

    $total = ($gross - ($gross * $rate)) * (1 + $vatRate);

    if ($orderBudget[$i] >= $total) {
        $status = "Paid";
        $badge  = "ok";
        $paidCount++;
        $revenue += $total;
    } elseif ($orderBudget[$i] >= ($total / 2)) {
        $status = "Partial";
        $badge  = "low";
    } else {
        $status = "Short";
        $badge  = "bad";
    }

    $bulk = ($orderQty[$i] >= 3) ? " (Bulk)" : "";
?>
        <tr>
          <td><?php echo $custNames[$i]; ?></td>
          <td><?php echo $label; ?></td>
          <td><?php echo $items[$orderProduct[$i]]; ?></td>
          <td class="num"><?php echo $orderQty[$i] . $bulk; ?></td>
          <td class="num"><?php echo "Php " . $total; ?></td>
          <td class="num"><?php echo "Php " . $orderBudget[$i]; ?></td>
          <td><span class="badge <?php echo $badge; ?>"><?php echo $status; ?></span></td>
        </tr>
<?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4">Paid orders: <?php echo $paidCount; ?></td>
          <td colspan="3" class="num"><?php echo "Revenue: Php " . $revenue; ?></td>
        </tr>
      </tfoot>
    </table>
  </section>

  <section class="card">
    <h2>Order Slip</h2>
<?php
$unitPrice    = $prices[$order["product"]];
$subtotal     = $unitPrice * $order["qty"];
$toppingTotal = 0;

switch ($order["type"]) {
    case 1:
        $rate  = 0.10;
        $label = "Student";
        break;
    case 2:
        $rate  = 0.20;
        $label = "Senior / PWD";
        break;
    default:
        $rate  = 0;
        $label = "Regular";
}
?>
    <table>
      <tr><td>Name</td><td class="num"><?php echo $order["customer"]; ?></td></tr>
      <tr><td>Customer Type</td><td class="num"><?php echo $label; ?></td></tr>
      <tr><td>Product</td><td class="num"><?php echo $items[$order["product"]]; ?></td></tr>
      <tr><td>Price x Quantity</td><td class="num"><?php echo "Php " . $unitPrice . " x " . $order["qty"]; ?></td></tr>
<?php
foreach ($toppingNames as $i => $name) {
    $toppingTotal += $picked[$i] * $toppingPrices[$i] * $order["qty"];
?>
      <tr>
        <td><?php echo $name . " (Php " . $toppingPrices[$i] . ")"; ?></td>
        <td class="num"><?php echo ($picked[$i] == 1) ? "Added" : "None"; ?></td>
      </tr>
<?php
}

$gross      = $subtotal + $toppingTotal;
$discount   = $gross * $rate;
$afterDisc  = $gross - $discount;
$orderVat   = $afterDisc * $vatRate;
$finalTotal = $afterDisc + $orderVat;
$change     = $order["budget"] - $finalTotal;
?>
      <tr><td>Toppings Total</td><td class="num"><?php echo "Php " . $toppingTotal; ?></td></tr>
      <tr><td>Subtotal</td><td class="num"><?php echo "Php " . $gross; ?></td></tr>
      <tr><td>Discount (<?php echo $rate * 100; ?>%)</td><td class="num"><?php echo "- Php " . $discount; ?></td></tr>
      <tr><td>VAT (12%)</td><td class="num"><?php echo "Php " . $orderVat; ?></td></tr>
      <tr><td>Total</td><td class="num"><?php echo "Php " . $finalTotal; ?></td></tr>
      <tr><td>Budget</td><td class="num"><?php echo "Php " . $order["budget"]; ?></td></tr>
    </table>
<?php if ($change > 0) { ?>
    <p class="result ok"><?php echo "Order accepted! Your change is Php " . $change . "."; ?></p>
<?php } elseif ($change == 0) { ?>
    <p class="result ok">Exact payment. Thank you!</p>
<?php } else { ?>
    <p class="result bad"><?php echo "Not enough budget. You need Php " . (0 - $change) . " more."; ?></p>
<?php } ?>
  </section>

  <section class="card">
    <h2>Order Checker</h2>
<?php
$questions = array(
    "Budget is enough for the order?",
    "Is the order total exactly Php 500?",
    "Is the order total not Php 500?",
    "Cheesecake pricier than the macaron?",
    "Cookie cheaper than the macaron?",
    "Open AND a member?",
    "Open OR a member?",
    "NOT a member?"
);
$answers = array(
    $order["budget"] >= $finalTotal,
    $finalTotal == 500,
    $finalTotal != 500,
    $prices[3] > $prices[4],
    $prices[5] < $prices[4],
    $isOpen && $isMember,
    $isOpen || $isMember,
    !$isMember
);

foreach ($questions as $i => $question) {
    echo '<p class="line">' . $question . " <strong>" . ($answers[$i] ? "Yes" : "No") . "</strong></p>";
}
?>
  </section>

  <footer><?php print $footerText; ?></footer>

</div>
</body>
</html>
