<?php session_start() ?>
<?php
# End the session and redirect back to the main index page
session_unset();
session_destroy();
header('Location: /');
die();
?>
