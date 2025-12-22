<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php
if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && ($_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest")) {
	print_r(json_encode(
		[
			"type" => get_class($exception),
			"message" => $message,
			"file_name" => $exception->getFile(),
			"line_number" => $exception->getLine()
		]
	));
	exit;
}

?>

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

	<h4>An uncaught Exception was encountered</h4>

	<p>Type: <?php echo get_class($exception); ?></p>
	<p>Message: <?php echo $message; ?></p>
	<p>Filename: <?php echo $exception->getFile(); ?></p>
	<p>Line Number: <?php echo $exception->getLine(); ?></p>

	<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

		<p>Backtrace:</p>
		<?php foreach ($exception->getTrace() as $error): ?>

			<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

				<p style="margin-left:10px">
					File: <?php echo $error['file']; ?><br />
					Line: <?php echo $error['line']; ?><br />
					Function: <?php echo $error['function']; ?>
				</p>
			<?php endif ?>

		<?php endforeach ?>

	<?php endif ?>

</div>