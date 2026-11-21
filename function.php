<?php
// Name : Santos Johnzelle L.
declare(strict_types=1);

$currentPage = "functions";
include 'header.html';
include 'footer.php';

$fanteasy_products = [
    "Enchanted Lavender Fog"     => ["price" => 160.00, "stock" => 25],
    "Lavender Tea House Special" => ["price" => 170.00, "stock" => 18],
    "Matcha Mint Mist"           => ["price" => 150.00, "stock" => 22],
    "Ube Dream Cheesecake"       => ["price" => 130.00, "stock" => 12],
    "Blue berry Macaron (3pc)"   => ["price" => 100.00, "stock" => 20],
    "Elderflower Cookie"         => ["price" => 50.00,  "stock" => 40],
    "Moonlit Rose Latte"         => ["price" => 165.00, "stock" => 7],
    "Crystal Mango Cooler"       => ["price" => 140.00, "stock" => 15],
    "Starlight Mochi (2pc)"      => ["price" => 90.00,  "stock" => 9]
];

$tax_rate = 12;

function get_reorder_message(int $stock): string
{
    return ($stock < 10) ? "Yes" : "No";
}

function get_total_value(float $price, int $quantity): float
{
    return $price * $quantity;
}

function get_tax_due(float $price, int $quantity, int $tax_rate = 0): float
{
    return get_total_value($price, $quantity) * ($tax_rate / 100);
}
?>
<style>
body{
  background:#0c0517;
}
</style>
<div class="page">

  <?php print $navLinks; ?>
  <h1>Fanteasy</h1>
  <p class="status" style="text-transform:uppercase;letter-spacing:.15em">Stock Control</p>

  <section class="card">
    <table>
      <thead>
        <tr>
          <th>Product</th>
          <th class="num">Stock</th>
          <th class="num">Re-order</th>
          <th class="num">Total Value</th>
          <th class="num">Tax Due</th>
        </tr>
      </thead>
      <tbody>
<?php foreach ($fanteasy_products as $product_name => $data) { ?>
        <tr>
          <td><?php echo $product_name; ?></td>
          <td class="num"><?php echo $data["stock"]; ?></td>
          <td class="num"><?php echo get_reorder_message($data["stock"]); ?></td>
          <td class="num"><?php echo "Php " . number_format(get_total_value($data["price"], $data["stock"]), 2); ?></td>
          <td class="num"><?php echo "Php " . number_format(get_tax_due($data["price"], $data["stock"], $tax_rate), 2); ?></td>
        </tr>
<?php } ?>
      </tbody>
    </table>
    <p class="hint"><?php echo "Tax rate: " . $tax_rate . "%"; ?></p>
  </section>

  <footer><?php print $footerText; ?></footer>

</div>
</body>
</html>
