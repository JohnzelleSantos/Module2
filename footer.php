<?php
// Name : Santos Johnzelle L.
$navLinks = '<nav class="nav">'
    . '<a href="index.php"' . (($currentPage == "home") ? ' class="active"' : '') . '>Home</a>'
    . '<a href="menu.php"' . (($currentPage == "menu") ? ' class="active"' : '') . '>Menu</a>'
    . '<a href="order.php"' . (($currentPage == "order") ? ' class="active"' : '') . '>Order</a>'
    . '<a href="functions.php"' . (($currentPage == "functions") ? ' class="active"' : '') . '>Stock</a>'
    . '</nav>';

$footerText = "&copy; " . date('Y') . " Fanteasy &bull; All rights reserved to Santos, Johnzelle L.";
?>
