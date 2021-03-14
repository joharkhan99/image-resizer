<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon">

  <title>Resize | Compress Images</title>

  <link rel="stylesheet" href="css/styles.css">

</head>

<body>

  <div class="container">
    <form name="form" method="post" enctype="multipart/form-data">
      <h4>Resize Image</h4>
      <hr>

      <input type="file" name="image" id="image" required>
      <input type="number" name="width" id="width" placeholder="width (px)" required>
      <span class="cross"> X </span>

      <input type="number" name="height" id="height" placeholder="height (px)" required>
      <input type="submit" name="submit" value="Click to Resize">
    </form>
  </div>

  <div class="result">
  </div>


  <div class="container">
    <form name="form2" method="post" enctype="multipart/form-data">
      <h4>Compress Image</h4>
      <hr>

      <input type="file" name="image" id="image" required>
      <input type="number" name="quality" id="quality" placeholder="quality (%)" required>
      <input type="submit" name="submit" value="Click to Compress">
    </form>


  </div>

  <div class="result2">
  </div>

  <footer>
    <span>&lt;/&gt;</span> with <span>&hearts;</span> by Johar Khan.
  </footer>


  <script src="js/jquery.js"></script>

</body>

</html>

<script type="text/javascript">
  $("form[name='form']").submit(function(e) {
    e.preventDefault();

    var file_data = $('#image').prop('files')[0];
    var width = $('#width').val();
    var height = $('#height').val();

    var form_data = new FormData();
    form_data.append('image', file_data);
    form_data.append('width', width);
    form_data.append('height', height);

    if (!file_data) {
      $('.result').html("Select Image File First");
    } else {

      $.ajax({
        type: "post",
        url: "resize",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('.result').html(`<img src="assets/loader.gif" alt="" style="opacity: 0.3;">`);
        },
        success: function(response) {
          $('.result').html(response);
        }
      });
    }

  });



  $("form[name='form2']").submit(function(e) {
    e.preventDefault();

    var file_data = $('form[name="form2"] #image').prop('files')[0];
    var quality = $('form[name="form2"] #quality').val();

    var form_data = new FormData();
    form_data.append('image', file_data);
    form_data.append('quality', quality);

    if (!file_data) {
      $('.result2').html("Select Image File First");
    } else {

      $.ajax({
        type: "post",
        url: "compress",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('.result2').html(`<img src="assets/loader.gif" alt="" style="opacity: 0.3;">`);
        },
        success: function(response) {
          $('.result2').html(response);
        }
      });
    }

  });
</script>