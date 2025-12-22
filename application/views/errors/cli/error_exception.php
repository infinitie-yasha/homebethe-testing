<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<?php
if ($_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest") {
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

An uncaught Exception was encountered

Type: <?php echo get_class($exception), "\n"; ?>
Message: <?php echo $message, "\n"; ?>
Filename: <?php echo $exception->getFile(), "\n"; ?>
Line Number: <?php echo $exception->getLine(); ?>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	Backtrace:
	<?php foreach ($exception->getTrace() as $error): ?>
		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
			File: <?php echo $error['file'], "\n"; ?>
			Line: <?php echo $error['line'], "\n"; ?>
			Function: <?php echo $error['function'], "\n\n"; ?>
		<?php endif ?>
	<?php endforeach ?>

<?php endif ?>