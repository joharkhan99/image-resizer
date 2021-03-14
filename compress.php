<?php
function compressImage($source_url, $destination_url, $quality)
{
  $info = getimagesize($source_url);

  if ($info['mime'] == 'image/jpeg')
    $image = imagecreatefromjpeg($source_url);
  if ($info['mime'] == 'image/gif')
    $image = imagecreatefromgif($source_url);
  if ($info['mime'] == 'image/png')
    $image = imagecreatefrompng($source_url);
  else
    $image = imagecreatefromjpeg($source_url);

  //save image
  imagejpeg($image, $destination_url, $quality);

  //return compressed image
  return $destination_url;
}

if (isset($_FILES['image'])) {

  $upload_path = "compressed/";
  $file_name = uniqid() . $_FILES['image']['name'];
  $quality = $_POST['quality'];
  $imageUploadPath = $upload_path . $file_name;
  $file_type = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

  //allow certain file types
  $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];

  if (in_array($file_type, $allowTypes)) {
    $tmp_name = $_FILES['image']['tmp_name'];

    if (file_exists($upload_path . $file_name)) {
      echo "file already exists";
    } else {
      $compressesImage = compressImage($tmp_name, $upload_path . $file_name, $quality);

      if ($compressesImage) {

        $filesize = filesize($compressesImage);

        $output = '
        <figure>
          <figcaption>compressed from ' . filesize($_FILES['image']['tmp_name']) . ' to: ' . round($filesize / 1024, 2) . ' KB</figcaption>
            <img src="' . $compressesImage . '" alt="compressed image">
        </figure>
      ';
        echo $output;
      } else {
        echo "<span class='error'>Image not compressed.</span>";
      }
    }
  } else {
    echo '<span class="error">Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.</span>';
  }
}
