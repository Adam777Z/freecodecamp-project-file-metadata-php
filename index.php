<?php
$path_prefix = '';

if ( isset( $_SERVER['PATH_INFO'] ) ) {
	$path_count = substr_count( $_SERVER['PATH_INFO'], '/' ) - 1;

	for ( $i = 0; $i < $path_count; $i++ ) {
		$path_prefix .= '../';
	}

	if ( strpos( $_SERVER['PATH_INFO'], '/api/fileanalyze' ) !== false ) {
		if ( ! empty( $_FILES['upfile'] ) ) {
			if ( $_FILES['upfile']['error'] === UPLOAD_ERR_OK ) {
				header( 'Content-Type: application/json; charset=utf-8' );
				echo json_encode( [
					'name' => $_FILES['upfile']['name'],
					'type' => $_FILES['upfile']['type'],
					'size' => $_FILES['upfile']['size'],
				] );
				unlink( $_FILES['upfile']['tmp_name'] ); // stored temporarily only
				exit;
			} else {
				header( 'Content-Type: application/json; charset=utf-8' );
				echo json_encode( [
					'error' => 'file is required',
				] );
				exit;
			}
		} else {
			redirect_to_index();
		}
	} else {
		redirect_to_index();
	}
}

function redirect_to_index() {
	global $path_prefix;

	if ( $path_prefix == '' ) {
		$path_prefix = './';
	}

	header( "Location: $path_prefix" );
	exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>File Metadata Microservice</title>
	<meta name="description" content="freeCodeCamp - APIs and Microservices Project: File Metadata Microservice">
	<link rel="icon" type="image/x-icon" href="<?php echo $path_prefix; ?>favicon.ico">
	<link rel="stylesheet" href="<?php echo $path_prefix; ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $path_prefix; ?>assets/css/style.min.css">
</head>
<body>
	<div class="container">
		<div class="p-4 my-4 bg-light rounded-3">
			<div class="row">
				<div class="col">
					<h1 id="title" class="text-center">File Metadata Microservice</h1>

					<h3>User Stories:</h3>
					<ol>
						<li>I can submit a form that includes a file upload.</li>
						<li>The from file input field has the "name" attribute set to "upfile" (required for testing).</li>
						<li>When I submit something, I will receive the file name, type, and size in bytes within the JSON response.</li>
					</ol>

					<h3>Usage:</h3>
					<p>Please upload a file...</p>
					<div class="view text-center">
						<form action="<?php echo $path_prefix; ?>api/fileanalyze" method="post" enctype="multipart/form-data">
							<label for="inputfield" class="form-label">Choose file</label>
							<input type="file" name="upfile" id="inputfield" class="form-control">
							<input type="submit" id="button" class="btn btn-primary" value="Upload">
						</form>
					</div>

					<div class="footer text-center">by <a href="https://www.freecodecamp.org" target="_blank">freeCodeCamp</a> & <a href="https://www.freecodecamp.org/adam777" target="_blank">Adam</a> | <a href="https://github.com/Adam777Z/freecodecamp-project-file-metadata-php" target="_blank">GitHub</a></div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>