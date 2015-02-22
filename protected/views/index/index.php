<h1><?php echo $text; ?></h1>
<?php
echo "<pre>";
//print_r($langs);
echo "</pre>";
?>

<?php foreach ($langs["data"] as $lang => $langValue): ?>
    <a href="<?php echo "/".$lang."/".$langValue["url"]; ?>"><?php echo $langValue["name"] ?></a>

<?php endforeach; ?>
