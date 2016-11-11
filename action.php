<?php 
echo "<pre>";
print_r($_FILES);
 ?>
 <form action="action.php" method="post" class="dropzone" enctype="multipart/form-data">
            <div class="fallback">
              <input name="file[]" type="file" />
              <input name="file[]" type="file" />
              <input name="file[]" type="file" />
              <input name="file[]" type="file" />
              <input type="submit" name="submit" value="upload">
            </div>
          </form>