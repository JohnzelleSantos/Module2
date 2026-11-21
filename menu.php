<?php
/* Student: Santos, Johnzelle L. */
$currentPage = "menu";
include 'header.html';
include 'footer.php';

$discountRate = 0.10;
$items = array(
    "Enchanted Lavender Fog",
    "Lavender Tea House Special",
    "Matcha Mint Mist",
    "Ube Dream Cheesecake",
    "Blue berry Macaron (3pc)",
    "Elderflower Cookie"
);
$descriptions = array(
    "Earl Grey steeped with hand picked lavender, vanilla bean nectar, and frothed oat milk.",
    "Chive Blossoms and lavender earl grey with cream or milk.",
    "Stone ground ceremonial green tea, fresh mint, coconut cream, and maple elixir.",
    "Rich, creamy, and topped with a berry enchantment.",
    "Rosewater meringue cookies filled with white chocolate cardamon ganache.",
    "Crispy almond crust filled with creamy custard infused with Chive Blossoms."
);
$prices = array(160, 170, 150, 130, 100, 50);
$stock  = array(25, 18, 22, 12, 20, 40);
$totalStock = 0;
$priceSum   = 0;
?>
<div class="page">

  <?php print $navLinks; ?>
  <h1>The Fanteasy Menu</h1>
  <p class="welcome">Every blend and sweet is prepared with hand gathered organic ingredients. Ask your server about allergies.</p>

  <section class="card">
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
    $priceSum   += $prices[$i];
?>
        <tr>
          <td><?php echo $i + 1; ?></td>
          <td><?php echo $items[$i]; ?><br><small><?php echo $descriptions[$i]; ?></small></td>
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
          <td colspan="3">Average price: <?php echo "Php " . ($priceSum / 6); ?></td>
          <td colspan="2"></td>
          <td class="num"><?php echo $totalStock; ?></td>
          <td></td>
        </tr>
      </tfoot>
    </table>
    <div class="btns">
      <a class="btn" href="order.php">Place an Order</a>
    </div>
  </section>

  <footer><?php print $footerText; ?></footer>

</div>
</body>
</html>
