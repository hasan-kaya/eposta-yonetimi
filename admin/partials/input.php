<?php
$name = $args['name'];
$value = get_option($name);
?>
<input type="text" style="width: 600px;" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>"/>