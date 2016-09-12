<?php
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST['submit'])) {
			if (isset($_POST['searchString']) && $_POST['searchString'] != '') {
				$search_string = $_POST['searchString'];
				require_once 'SearchStringInDirectory.php';
				$searchHandle = new SearchStringInDirectory('/jquery-upload-file/server/php/files');
				$files = $searchHandle->search($search_string);
			}
		}
	}
	function getLineNumbers($string, $file)
	{
		return shell_exec('grep -nir "'.$string.'" "'.$file.'"');
	}
?>

<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Search Engine</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="jquery-upload-file/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="jquery-upload-file/css/docs.css">
		<link rel="stylesheet" href="jquery-upload-file/css/style.css">
		<!-- blueimp Gallery styles -->
		<link rel="stylesheet" href="jquery-upload-file/css/blueimp-gallery.min.css">
		<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
		<link rel="stylesheet" href="jquery-upload-file/css/jquery.fileupload.css">
		<link rel="stylesheet" href="jquery-upload-file/css/jquery.fileupload-ui.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script type="text/javascript">
			var APP_URL = "<?php echo $_SERVER['HOST'].$_SERVER['REQUEST_URI'] ?>";
		</script>
		<style type="text/css" media="screen">
			table.framed.light {
			    display: inline-block;
			    margin-right: 15px;
			}
		</style>	
	</head>
	<body>
		<div class="container-fluid" id="content">
			<div class="page-header">
			  <h1 class="text-center"> Search Engine <small> Finding all files containing a text string</small></h1>
			</div>
			<div role="tabpanel">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist" id="myTab">
					<li role="presentation" class="">
						<a href="#read_me" aria-controls="read_me" role="tab" data-toggle="tab">READ ME</a>
					</li>
					<li role="presentation" class="">
						<a href="#search_file" aria-controls="search_file" role="tab" data-toggle="tab">SEARCH TEXT</a>
					</li>
					<li role="presentation">
						<a href="#upload_file" aria-controls="upload_file" role="tab" data-toggle="tab">UPLOAD FILE</a>
					</li>
					<li role="presentation">
						<a href="#voting" aria-controls="voting" role="tab" data-toggle="tab">VOTING MY PACKAGE</a>
					</li>
				</ul>
			
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane" id="read_me">
						<div class="panel panel-default" style="border-top: none;border-radius: 0 0px 4px 4px;">
							<div class="panel-body">
								<div class="bs-callout bs-callout-warning" id="callout-third-party-libs">
									<h4>Upload file</h4>
									<p>
										Upload file in Upload file tab with file types <code>(TXT, DOC, PPT, XLS)</code> less than 10Mib.
									</p>
									<p>
										Execute command <code>chmod 0775 jquery-upload-file/server/php/files</code> OR <code>chmod 2775 jquery-upload-file/server/php/files</code> to allow upload files.
									</p>
								</div>

								<div class="bs-callout bs-callout-warning" id="callout-third-party-libs">
									<h4>Search text</h4>
									<p>
										Go to SEARCH TEXT, input text to search and submit.
									</p>
								</div>

								<div class="bs-callout bs-callout-warning" id="callout-third-party-libs">
									<h4>Notes and feature</h4>
									<p>
										Currently, the search engine apply for the file types <code>(TXT, DOC, PPT, XLS)</code>. In a future, we will improve on all the documents type.
									</p>
									<p>
										With the format of (DOC, PPT, XLS) files only can searching by <code>Single-byte Characters</code>
									</p>
									<p>
										Highlight text only apply with <code>Single-byte Characters</code> and require matches word.
									</p>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="search_file">
						<div class="panel panel-default" style="border-top: none;border-radius: 0 0px 4px 4px;">
							<div class="panel-body">
								<?php
									if ((isset($_POST['searchString']) && $_POST['searchString'] == '') && $_SERVER['REQUEST_METHOD'] == "POST") {
								?>
										<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<strong>Error !</strong> Please enter text search and try again ...
										</div>
								<?php
									}
								?>
								<?php
									if ((isset($_POST['searchString']) && $_POST['searchString'] != '') && $_SERVER['REQUEST_METHOD'] == "POST" && count($files) <= 0) {
								?>
										<div class="alert alert-warning">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<strong>Results !</strong> File not matches string search ...
										</div>
								<?php
									}
								?>
								<form action="" method="POST" class="form-horizontal" role="form">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="form-group col-lg-10">
												<label class="sr-only" for="searchString">Search string</label>
												<input type="text" value="<?php echo @($_POST['searchString']); ?>" class="form-control" name="searchString" id="searchString" placeholder="Input string">
											</div>
											<div class="form-group col-lg-2" style="text-align: center;">
												<button type="submit" name="submit" class="btn btn-primary" style="margin: 0 auto;">Search</button>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<table class="table table-bordered table-hover" id="myTable">
											<thead>
												<tr>
													<th class="text-center">#</th>
													<th class="text-center">File name</th>
													<th class="text-center">File type</th>
													<?php if (isset($_POST['searchString']) && $_POST['searchString'] != '') {
													?>
														<th class="text-center">Matches</th>
													<?php
													} ?>
													<th class="text-center">Modified</th>
												</tr>
											</thead>
											<tbody>
												<?php
													if (isset($files) && count($files)) {
														$index = 0;
														foreach ($files as $key => $file) {
												?>
														<tr>
															<td class="text-center"><?php echo ++$index; ?></td>
															<td><?php echo (str_replace(@$searchHandle->directory.'/', '', @$file->basename)); ?></td>
															<td class="text-center"><?php echo @$file->extension; ?></td>
															<?php if (isset($_POST['searchString']) && $_POST['searchString'] != '') {
																$lines = getLineNumbers($search_string, $file->filepath);
																$lines = explode("\n", $lines);
																$lines = array_filter($lines);
																if (count($lines) > 0) {
															?>
																	<td class="text-left hiliteTag">
																	<?php
																		foreach ($lines as $key => $line) {
																			if ($key != 0) {
																				echo "</br>";
																			}
																			echo '<span class="label label-danger badge">Line: </span> '.htmlentities(@$line).'';
																			echo "</br>";
																		}
																	?>
																	</td>
															<?php
																}
															} ?>
															<td class="text-center"><?php echo @$file->modified; ?></td>
														</tr>
												<?php
														}
													}
												?>
											</tbody>
										</table>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="upload_file">
						<div class="panel panel-default" style="border-top: none;border-radius: 0 0px 4px 4px;">
							<div class="panel-body">
								<form id="fileupload" method="POST" enctype="multipart/form-data">
								    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
								    <div class="row fileupload-buttonbar">
								        <div class="col-lg-7">
								            <!-- The fileinput-button span is used to style the file input field as button -->
								            <span class="btn btn-success fileinput-button">
								                <i class="glyphicon glyphicon-plus"></i>
								                <span>Add files...</span>
								                <input type="file" name="files[]" multiple>
								            </span>
								            <button type="submit" class="btn btn-primary start">
								                <i class="glyphicon glyphicon-upload"></i>
								                <span>Start upload</span>
								            </button>
								            <button type="reset" class="btn btn-warning cancel">
								                <i class="glyphicon glyphicon-ban-circle"></i>
								                <span>Cancel upload</span>
								            </button>
								            <button type="button" class="btn btn-danger delete">
								                <i class="glyphicon glyphicon-trash"></i>
								                <span>Delete</span>
								            </button>
								            <input type="checkbox" class="toggle">
								            <!-- The global file processing state -->
								            <span class="fileupload-process"></span>
								        </div>
								        <!-- The global progress state -->
								        <div class="col-lg-5 fileupload-progress fade">
								            <!-- The global progress bar -->
								            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
								                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
								            </div>
								            <!-- The extended global progress state -->
								            <div class="progress-extended">&nbsp;</div>
								        </div>
								    </div>
								    <div class="panel panel-default">
								        <div class="panel-heading">
								            <h3 class="panel-title">Upload Notes</h3>
								        </div>
								        <div class="panel-body">
								            <ul>
								                <li>The maximum file size for uploads in this demo is <strong><?php echo 10; ?> MiB</strong> (default file size is unlimited).</li>
								                <li>Only file types (<strong>DOC, TXT, PPT, PDF</strong>) are allowed in this demo (by default there is no file type restriction).</li>
								        </div>
								    </div>
								    <!-- The table listing the files available for upload/download -->
								    <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
								</form>
								<!-- The template to display files available for upload -->
								<script id="template-upload" type="text/x-tmpl">
								{% for (var i=0, file; file=o.files[i]; i++) { %}
								    <tr class="template-upload fade">
								        <td>
								            <span class="preview"></span>
								        </td>
								        <td>
								            <p class="name">{%=file.name%}</p>
								            <strong class="error text-danger"></strong>
								        </td>
								        <td>
								            <p class="size">Processing...</p>
								            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
								        </td>
								        <td>
								            {% if (!i && !o.options.autoUpload) { %}
								                <button class="btn btn-primary start" disabled>
								                    <i class="glyphicon glyphicon-upload"></i>
								                    <span>Start</span>
								                </button>
								            {% } %}
								            {% if (!i) { %}
								                <button class="btn btn-warning cancel">
								                    <i class="glyphicon glyphicon-ban-circle"></i>
								                    <span>Cancel</span>
								                </button>
								            {% } %}
								        </td>
								    </tr>
								{% } %}
								</script>
								<!-- The template to display files available for download -->
								<script id="template-download" type="text/x-tmpl">
								{% for (var i=0, file; file=o.files[i]; i++) { %}
								    <tr class="template-download fade">
								        <td>
								            <span class="preview">
								                {% if (file.thumbnailUrl) { %}
								                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
								                {% } %}
								            </span>
								        </td>
								        <td>
								            <p class="name">
								                {% if (file.url) { %}
								                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
								                {% } else { %}
								                    <span>{%=file.name%}</span>
								                {% } %}
								            </p>
								            {% if (file.error) { %}
								                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
								            {% } %}
								        </td>
								        <td>
								            <span class="size">{%=o.formatFileSize(file.size)%}</span>
								        </td>
								        <td>
								            {% if (file.deleteUrl) { %}
								                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
								                    <i class="glyphicon glyphicon-trash"></i>
								                    <span>Delete</span>
								                </button>
								                <input type="checkbox" name="delete" value="1" class="toggle">
								            {% } else { %}
								                <button class="btn btn-warning cancel">
								                    <i class="glyphicon glyphicon-ban-circle"></i>
								                    <span>Cancel</span>
								                </button>
								            {% } %}
								        </td>
								    </tr>
								{% } %}
								</script>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="voting">
						<div class="panel panel-default" style="border-top: none;border-radius: 0 0px 4px 4px;">
							<div class="panel-body">
								<div class="pull-left">
									<script src="http://www.phpclasses.org/browse/package/9895/format/badge.js"> </script>
								</div>
								<div class="pull-left">
									<h3>Thank for voting</h3>
									<p>Please refer page <a href="http://www.phpclasses.org/vote.html" title="http://www.phpclasses.org/vote.html">http://www.phpclasses.org/vote.html</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- jQuery -->
		<script src="jquery-upload-file/js/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="jquery-upload-file/js/bootstrap.min.js"></script>		<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
		<script src="jquery-upload-file/js/vendor/jquery.ui.widget.js"></script>
		<!-- The Templates plugin is included to render the upload/download listings -->
		<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
		<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
		<script src="jquery-upload-file/js/load-image.all.min.js"></script>
		<!-- The Canvas to Blob plugin is included for image resizing functionality -->
		<script src="jquery-upload-file/js/canvas-to-blob.min.js"></script>
		<!-- blueimp Gallery script -->
		<script src="jquery-upload-file/js/jquery.blueimp-gallery.min.js"></script>
		<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
		<script src="jquery-upload-file/js/jquery.iframe-transport.js"></script>
		<!-- The basic File Upload plugin -->
		<script src="jquery-upload-file/js/jquery.fileupload.js"></script>
		<!-- The File Upload processing plugin -->
		<script src="jquery-upload-file/js/jquery.fileupload-process.js"></script>
		<!-- The File Upload image preview & resize plugin -->
		<script src="jquery-upload-file/js/jquery.fileupload-image.js"></script>
		<!-- The File Upload audio preview plugin -->
		<script src="jquery-upload-file/js/jquery.fileupload-audio.js"></script>
		<!-- The File Upload video preview plugin -->
		<script src="jquery-upload-file/js/jquery.fileupload-video.js"></script>
		<!-- The File Upload validation plugin -->
		<script src="jquery-upload-file/js/jquery.fileupload-validate.js"></script>
		<!-- The File Upload user interface plugin -->
		<script src="jquery-upload-file/js/jquery.fileupload-ui.js"></script>
		<!-- The main application script -->
		<script src="jquery-upload-file/js/main.js"></script>

		<script src="jquery-upload-file/js/hilitor.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function () {

				<?php if (isset($search_string) && $search_string != '') {
				?>
					var myHilitor = new Hilitor("myTable");
					myHilitor.setMatchType('open');
  					myHilitor.apply("<?php echo ($search_string) ?>");
  				<?php

				}; ?>

				// Javascript to enable link to tab
				var url = document.location.toString();

				if (url.match('#')) {

				    $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');

				}
				else{

					$('.nav-tabs a[href="#read_me"]').tab('show');

				}

				// Change hash for page-reload
				$('.nav-tabs a').on('shown.bs.tab', function (e) {

				    window.location.hash = e.target.hash;

				});

			});
		</script>
	</body>
</html>