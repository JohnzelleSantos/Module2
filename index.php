<?php
/* Student: Santos, Johnzelle L. */
$currentPage = "home";
include 'header.html';
include 'footer.php';

$storeName = "Fanteasy";
$tagline   = "A cup of tea full of Fantasy";
$visitors  = 99;
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
$stock = array(25, 18, 22, 12, 20, 40);

$stats = array("Enchanted blends" => "40+", "Whole leaf tea" => "100%", "Days a week" => "7");
$contact = array(
    "Phone" => "+63 992 475 6798",
    "Email" => "Johnzellesantos171@gmail.com",
    "Hours" => "Mon - Fri: 10:00 AM - 10:00 PM, Sat - Sun: 9:00 AM - 11:00 PM"
);

$welcome = "Welcome to " . $storeName . "! " . $tagline . ".";
$welcome .= " Step into the brew-verse.";
$visitors++;
$stampsEarned = 5;
?>
<div class="page">

  <?php print $navLinks; ?>
  <h1><?php echo $storeName; ?></h1>
  <?php echo '<p class="welcome">' . $welcome . '</p>'; ?>
  <p class="status">
    <?php echo $isOpen ? "We are open today!" : "We are closed right now."; ?>
    &bull;
    <?php echo $isMember ? "Member prices apply." : "Join us to become a member."; ?>
  </p>

  <section class="card">
    <h2>Our Story</h2>
    <p class="text">Fanteasy is a dreamy cafe concept where colorful drinks, sweet treats, and an enchanting atmosphere come together. Every item is inspired by moonlight, stardust, flowers, crystals, and the cozy feeling of finding your favorite drink.</p>
    <p class="text">Every blend is designed, tested, and enchanted. We source only the finest ingredients, real fruit chunks, and mystical spices, so your daily pause feels like a ceremony of pure imagination.</p>
    <div class="btns">
      <a class="btn" href="menu.php">Explore Blends</a>
      <a class="btn ghost" href="order.php">Place an Order</a>
      <a class="btn ghost" href="functions.php">Stock Control</a>
    </div>
  </section>

  <div class="grid">

    <section class="card">
      <h2>Fanteasy in Numbers</h2>
<?php
foreach ($stats as $label => $value) {
    echo '<p class="line">' . $label . ": " . $value . "</p>";
}
?>
      <p class="line">Visitor number today: <?php echo $visitors; ?></p>

      <h2 style="margin-top:18px">Loyalty Card</h2>
      <p class="stamps">
<?php
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
      <h2>Restock Soon</h2>
<?php
$i = 0;
while ($i < 6) {
    if ($stock[$i] < 20) {
        echo '<p class="line">' . $items[$i] . ": only " . $stock[$i] . " left</p>";
    }
    $i++;
}
?>
      <h2 style="margin-top:18px">Visit Us</h2>
<?php
foreach ($contact as $label => $value) {
    echo '<p class="line">' . $label . ": " . $value . "</p>";
}
?>
    </section>

  </div>

  <footer><?php print $footerText; ?></footer>

</div>
</body>
</html> 
