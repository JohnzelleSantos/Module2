
<?php
/* Student: Santos, Johnzelle L. */

include 'header.html';
include 'footer.html';

$storeName = "Fanteasy";                 
$tagline   = "A cup of tea full of Fantasy";
$visitors  = 99;                         
$discountRate = 0.10;                    
$vatRate   = 0.12;                       
$isOpen    = true;                       
$isMember  = false;                      

$items = array(
    "Enchanted Lavender Fog",
    "Lavender Tea House Special",
    "Matcha Mint Mist",
    "Ube Dream Cheesecake",
    "Blue berry Macaron (3pc)",
    "Elderflower Cookie"
);
$prices        = array(160, 170, 150, 130, 100, 50);
$stock         = array(25, 18, 22, 12, 20, 40);
$toppingNames  = array("Lavender Cream Top", "Stardust Sprinkles", "Honey Drizzle");
$toppingPrices = array(30, 20, 25);

$custNames   = array("Juan Dela Cruz", "Maria Santos", "Pedro Reyes", "Ana Lim");
$custTypes   = array(1, 0, 2, 1);        
$orderProduct = array(0, 3, 4, 2);
$orderQty    = array(2, 1, 3, 4);
$orderBudget = array(500, 100, 400, 300);

$contact = array(
    "Phone" => "+63 992 475 6798",
    "Email" => "Johnzellesantos171@gmail.com",
    "Hours" => "Mon - Fri: 10:00 AM - 10:00 PM, Sat - Sun: 9:00 AM - 11:00 PM"
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order = array(
        "customer" => htmlspecialchars($_POST["customer"]),
        "type"     => (int)$_POST["type"],
        "product"  => (int)$_POST["product"],
        "qty"      => (int)$_POST["qty"],
        "budget"   => (float)$_POST["budget"]
    );
    $picked = array(
        isset($_POST["toppings"][0]) ? 1 : 0,
        isset($_POST["toppings"][1]) ? 1 : 0,
        isset($_POST["toppings"][2]) ? 1 : 0
    );
} else {
    $order  = array("customer" => "Juan Dela Cruz", "type" => 1, "product" => 0, "qty" => 2, "budget" => 500);
    $picked = array(1, 0, 1);                
}

$welcome = "Welcome to " . $storeName . "! " . $tagline . ".";
$welcome .= " Today's menu is below.";

$visitors++;
$macaronLeft = $stock[4] % 3;            
$totalStock  = 0;
$totalValue  = 0;
$priceSum    = 0;

?>
<div class="page">

  <h1><?php echo $storeName; ?></h1>
  <?php echo '<p class="welcome">' . $welcome . '</p>'; ?>
  <p class="status">
    <?php echo $isOpen ? "We are open today!" : "We are closed right now."; ?>
    &bull;
    <?php echo $isMember ? "Member prices apply." : "Join us to become a member."; ?>
  </p>

  <section class="card">
    <h2>Our Products</h2>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Item</th>
          <th>Category</th>
          <th class="num">Price</th>
          <th class="num">10% Off</th>
          <th class="num">In Stock</th>
          <th>Level</th>
        </tr>
      </thead>
      <tbody>
<?php
for ($i = 0; $i < 6; $i++) {
    $category = match ($i) {
        0, 1, 2 => "Cup of Potions",
        default => "Spelled Sweets"
    };

    if ($stock[$i] < 15) {
        $level = "Low";
        $badge = "bad";
    } elseif ($stock[$i] < 25) {
        $level = "Good";
        $badge = "low";
    } else {
        $level = "Plenty";
        $badge = "ok";
    }

    $totalStock += $stock[$i];
    $totalValue += $prices[$i] * $stock[$i];
    $priceSum   += $prices[$i];
?>
        <tr>
          <td><?php echo $i + 1; ?></td>
          <td><?php echo $items[$i]; ?></td>
          <td><?php echo $category; ?></td>
          <td class="num"><?php echo "Php " . $prices[$i]; ?></td>
          <td class="num"><?php echo "Php " . ($prices[$i] - ($prices[$i] * $discountRate)); ?></td>
          <td class="num"><?php echo $stock[$i]; ?></td>
          <td><span class="badge <?php echo $badge; ?>"><?php echo $level; ?></span></td>
        </tr>
<?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5">Totals</td>
          <td class="num"><?php echo $totalStock; ?></td>
          <td><?php echo "Php " . $totalValue; ?></td>
        </tr>
      </tfoot>
    </table>
  </section>

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
    <h2>Place Your Order</h2>
    <form method="POST" action="">
      <div style="margin-bottom: 12px;">
        <label style="display:block; margin-bottom: 5px;">Name</label>
        <input type="text" name="customer" value="<?php echo htmlspecialchars($order['customer']); ?>" style="width:100%; padding: 8px;" required>
      </div>

      <div style="margin-bottom: 12px;">
        <label style="display:block; margin-bottom: 5px;">Customer Type</label>
        <select name="type" style="width:100%; padding: 8px;">
          <option value="0" <?php if($order['type'] == 0) echo 'selected'; ?>>Regular</option>
          <option value="1" <?php if($order['type'] == 1) echo 'selected'; ?>>Student</option>
          <option value="2" <?php if($order['type'] == 2) echo 'selected'; ?>>Senior / PWD</option>
        </select>
      </div>

      <div style="margin-bottom: 12px;">
        <label style="display:block; margin-bottom: 5px;">Product</label>
        <select name="product" style="width:100%; padding: 8px;">
          <?php foreach($items as $idx => $itm) { ?>
            <option value="<?php echo $idx; ?>" <?php if($order['product'] == $idx) echo 'selected'; ?>><?php echo $itm; ?></option>
          <?php } ?>
        </select>
      </div>

      <div style="margin-bottom: 12px;">
        <label style="display:block; margin-bottom: 5px;">Quantity</label>
        <input type="number" name="qty" value="<?php echo $order['qty']; ?>" style="width:100%; padding: 8px;" min="1" required>
      </div>

      <div style="margin-bottom: 12px;">
        <label style="display:block; margin-bottom: 5px;">Toppings (optional)</label>
        <?php foreach($toppingNames as $idx => $tName) { ?>
          <div style="margin-bottom: 5px;">
            <label>
              <input type="checkbox" name="toppings[<?php echo $idx; ?>]" value="1" <?php if($picked[$idx] == 1) echo 'checked'; ?>>
              <?php echo $tName . " (Php " . $toppingPrices[$idx] . ".00)"; ?>
            </label>
          </div>
        <?php } ?>
      </div>

      <div style="margin-bottom: 12px;">
        <label style="display:block; margin-bottom: 5px;">Budget (PHP)</label>
        <input type="number" name="budget" value="<?php echo $order['budget']; ?>" style="width:100%; padding: 8px;" step="any" required>
      </div>

      <button type="submit" style="width:100%; padding: 10px; background:#6a1b9a; color:white; border:none; font-weight:bold; cursor:pointer;">Process Order</button>
    </form>
  </section>

  <section class="card">
    <h2>Order Slip</h2>
<?php
$unitPrice    = $prices[$order["product"]];
$subtotal     = $unitPrice * $order["qty"];
$toppingTotal = 0;

if ($order["type"] == 1) {
    $rate  = 0.10;
    $label = "Student";
} elseif ($order["type"] == 2) {
    $rate  = 0.20;
    $label = "Senior / PWD";
} else {
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

  <div class="grid">

    <section class="card">
      <h2>Store Facts</h2>
      <p class="line">Items in stock: <?php echo $totalStock; ?></p>
      <p class="line">Average item price: <?php echo "Php " . ($priceSum / 6); ?></p>
      <p class="line">Macarons left after packing sets of 3: <?php echo $macaronLeft; ?></p>
      <p class="line">Visitor number today: <?php echo $visitors; ?></p>

      <h2 style="margin-top:18px">Restock Soon</h2>
<?php
$i = 0;
while ($i < 6) {
    if ($stock[$i] < 20) {
        echo '<p class="line">' . $items[$i] . ": only " . $stock[$i] . " left</p>";
    }
    $i++;
}
?>
      <h2 style="margin-top:18px">Loyalty Card</h2>
      <p class="stamps">
<?php
$stampsEarned = 5;
$n = 1;
do {
    echo "&#9733; ";
    $n++;
} while ($n <= $stampsEarned);
?>
      </p>
      <p class="hint"><?php echo $stampsEarned . " stamps earned. Collect 10 for a free drink."; ?></p>
    </section>

    <section class="card">
      <h2>Store Checker</h2>
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

  </div>

  <section class="card">
    <h2>Visit Us</h2>
<?php
foreach ($contact as $label => $value) {
    echo '<p class="line">' . $label . ": " . $value . "</p>";
}
?>
  </section>

  <footer><?php print $footerText; ?></footer>

</div>
</body>
</html>
