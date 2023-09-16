<?php
session_start(); // start the session
session_destroy(); // destroy all session data
header("Location: ../index.html"); // redirect to main index outside of the current folder
exit(); // stop executing the rest of the script
?>
