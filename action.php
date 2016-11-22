<?php 
include('inc/db.php');
if(isset($_POST['submit'])) {
	// print_r($_FILES);
	// die;
	$text = $_POST['text'];
	$file = $_FILES['file'];
	// count if file field empty or not
	$countCaption = 0;
	$countFiles = 0;
	$allowed =  array('gif','png','jpeg','jpg');
	$success = false;
	$data['text'] = [];
	$data['image'] = [];
	for($i=0;$i<count($file['name']);$i++) {
		//count total caption
		if(!empty(trim($text[$i])) && $file['error'][$i] == 0)
			$countFiles++;
		elseif(empty(trim($text[$i])) && $file['error'][$i] == 0)
			$countFiles++;
		elseif(!empty(trim($text[$i])) && $file['error'][$i] == 4)
			$countFiles++;
		//check errors
		if($file['size'][$i] > 2000000) {
			$_SESSION['flash'] = "File Limit exceeded. Maximum file size is 2MB";
			header('Location: action.php');
			die;
		}

		if($file['error'][$i] != 0 && $file['error'][$i] != 4) {
			$_SESSION['flash'] = "Failed to upload file. Server Error.";
			header('Location: action.php');
			die;
		}

		$filename = basename($file['name'][$i]);
		$ext = pathinfo(strtolower($filename), PATHINFO_EXTENSION);
		if($file['error'][$i] == 0) {
		if(!in_array($ext, $allowed) ) {
    		$_SESSION['flash'] = "Invalid file types. Only jpg, gif and png are allowed.";
			header('Location: action.php');
			die;
		}
	}

		if(!empty($text[$i]) || $file['error'][$i] == 0) {
			$data['image'][] = $file['tmp_name'][$i];
			$data['text'][] = $text[$i];
		}

		$success = true;
	}
	if($countFiles < 2) {
			$_SESSION['flash'] = "At least two options are required.";
			header('Location: action.php');
			die;
		}

	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
 ?>
 <html>
 <head>
 <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
 <link rel="stylesheet" type="text/css" href="dist/css/bootstrap-imageupload.min.css">
 <style type="text/css">
 	.imageupload .form-control, .imageupload label {
 		margin: 5px 0;
 	}
 	.remove-field {
 		cursor: pointer;
 		padding:3px 8px;
 		background: #d0d0d0;
 		border-radius: 10px;
 	}
 </style>
 </head>
 <body>
<div class="container col-md-7">
<?=isset($_SESSION['flash'])?$_SESSION['flash']:'';unset($_SESSION['flash']); ?>
<form method="post" enctype="multipart/form-data">
	<div class="inputcontainer">
             <div class="imageupload">
                <span class="file-name"></span>
                <div class="row">
                <div class="col-md-8">
                	<input type="text" name="text[]" class="form-control">
                </div>
                <div class="col-md-4"> or/and
                    <label class="btn btn-danger btn-file">Choose Photo
                        <input type="file" name="file[]">
                    </label>
                </div>
                </div>
            </div>

            <div class="imageupload">
                <span class="file-name"></span>
                <div class="row">
                <div class="col-md-8">
                	<input type="text" name="text[]" class="form-control">
                </div>
                <div class="col-md-4"> or/and
                    <label class="btn btn-danger btn-file">Choose Photo
                        <input type="file" name="file[]">
                    </label>
                </div>
                </div>
            </div>
</div>
            <button type="submit" class="btn btn-primary" name="submit">Upload</button>
</form>

<button id="add" class="btn-xs btn btn-danger">Add</button>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript" src="dist/js/bootstrap-imageupload.min.js"></script>
<script>

            $(document).on("ready", function() {
            	$(document).on("click","#add", function() {
            		$(".inputcontainer").append('\
            			<div class="imageupload">\
            			    <span class="file-name"></span>\
            			    <div class="row">\
            			    <div class="col-md-8">\
            			    	<input type="text" name="text[]" class="form-control">\
            			    </div>\
            			    <div class="col-md-4"> or/and\
            			        <label class="btn btn-danger btn-file">Choose Photo\
            			            <input type="file" name="file[]">\
            			        </label>\
            			        <span class="remove-field">x</span>\
            			    </div>\
            			    </div>\
            			</div>');
            	});

            	$(document).on("click", ".remove-field", function() {
            		$(this).parent().parent().parent().remove();
            	});

            	$(document).on("change", "input:file", function() {
            		$(this).closest('.imageupload').find('.file-name').html('<i class="glyphicon glyphicon-ok-sign text-success"></i> <span class="text-success">'+$(this)[0].files[0].name+"</span>");
            	});
            });
            
            	//$('.imageupload').imageupload();
        </script>
 </body>
</html>