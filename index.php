<?php
echo '<h1>Hello World</h1>';
print "<h2>Welcome to my website!</h2>";

$i = 1; // Initialize counter
while ($i < 6) { // Check condition
  echo $i; // Execute code
  $i++; // Increment counter
}

$i = 0;
while ($i < 6) {
  $i++;
  if ($i == 3) continue;
  echo $i;
}

for ($x = 0; $x < 10; $x++) {
  if ($x == 4) {
    break;
  }
  echo "The number is: $x <br>";
}

$i = 1;

do {
  if ($i == 3) break;
  echo $i;
  $i++;
} while ($i < 6);


$colors = array("red", "green", "blue", "yellow");

foreach ($colors as $value) {
  if ($value == "blue") break;
  echo "$value<br>";
}

?>
