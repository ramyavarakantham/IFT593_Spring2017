<?php
SESSION_START();
?>


<?php
// remove all session variables
SESSION_UNSET(); 

// destroy the session 
SESSION_DESTROY();

echo "All session variables are now removed, and the session is destroyed.";
header("Location: RS_Login.php"); 
exit;
?>

