<?php
if (isset($_FILES["image"])) {
  if (is_array($_FILES)) {

    $file = $_FILES['image']['name'];
    $temp_name = $_FILES['image']['tmp_name'];
    $target_width = $_POST['width'];
    $target_height = $_POST['height'];

    $source_properties = getimagesize($temp_name);
    $image_type = $source_properties[2];

    switch ($image_type) {
      case IMAGETYPE_JPEG:
        $image_resource_id = imagecreatefromjpeg($temp_name);
        $target_layer = resize($image_resource_id, $source_properties[0], $source_properties[1], $target_width, $target_height);
        $converted = imagejpeg($target_layer, "img/" . $file . "_converted.jpg");

        $output = '
              <figure>
                <figcaption>' . $file . '_converted.jpg</figcaption>
                  <img src="' . "img/" . $file . "_converted.jpg" . '" alt="">
              </figure>
          ';
        echo $output;
        break;
      case IMAGETYPE_GIF:
        $image_resource_id = imagecreatefromgif($temp_name);
        $target_layer = resize($image_resource_id, $source_properties[0], $source_properties[1], $target_width, $target_height);
        $converted = imagegif($target_layer, "img/" . $file . "_converted.gif");

        $output = '
            <figure>
              <figcaption>' . $file . '_converted.gif</figcaption>
                <img src="' . "img/" . $file . "_converted.gif" . '" alt="">
            </figure>
        ';
        echo $output;
        break;
      case IMAGETYPE_PNG:
        $image_resource_id = imagecreatefrompng($temp_name);
        $target_layer = resize($image_resource_id, $source_properties[0], $source_properties[1], $target_width, $target_height);
        $converted = imagepng($target_layer, "img/" . $file . "_converted.png");

        $output = '
            <figure>
              <figcaption>' . $file . '_converted.png</figcaption>
                <img src="' . "img/" . $file . "_converted.png" . '" alt="">
            </figure>
        ';
        echo $output;
        break;
    }
  }
}
function resize($image_resource_id, $width, $height, $target_width, $target_height)
{
  $target_layer = imagecreatetruecolor($target_width, $target_height);
  imagecopyresampled($target_layer, $image_resource_id, 0, 0, 0, 0, $target_width, $target_height, $width, $height);
  return $target_layer;
}
?>
<script>

</script>