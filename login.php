<?php
/**
 *       4/23/2008
 *         Login
 *           By
 *    MCM Web Solutions, LLC
 *
 *  Released under the GPL (v.2)
 */

$isLogin = 1;

include "include/app_top_admin.php";


$table = "User";

$SECURED_PAGE = 'admin.php';

$username = $_POST['username'];
$password = $_POST['password'];



// If the form was submited check if the username and password match
if($_POST['submitid'] == 1){

        $password = trim($password);


  $valid = 0;
  $admin = 0;


     // check for all numeric passwords

       $qs = "SELECT username, admin
              FROM " . $table . "
              WHERE username=:username
                     AND password=:password";


        $params = array(
          'username'=>$_POST['username'],
          'password'=>sha1($saltVal.$_POST['password'])
        );
        $rows = mcmSelectQuery($qs, $params);
        if ( count($rows) )
           $valid = 1;



	if ($valid) {
  	//Make sessions
  	@session_start();
		$_SESSION['isloged'] = 'yes';
		$row = $rows[0];
    $_SESSION['username'] = $row['username'];
    $_SESSION['admin'] = $row['admin'];

		// Redirect to the page
		header("Location: $SECURED_PAGE");
		exit();
	} else {
		$message = 'Invalid username and/or password!';
	}
}



//Check if we are displaying a message to the user:
if($message != NULL){?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <title>Please Log In</title>

</head>
<body>
<span style="color: red; font-weight: bold; font-size: 16px;"><?=$message;?></span>
<?php } ?>
<form action="" method="post" name="adminlogin" id="adminlogin" style="display:inline;">
 <fieldset style="width: 250px;">
  <table width="30%" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
    <tr>
      <td colspan="2"><div align="left"><strong>Please log in:</strong></div></td>
    </tr>
    <tr>
      <td width="47%"><strong>Username:</strong></td>
      <td width="53%"><input name="username" type="text" id="username" value="<?=htmlentities($_POST['username']);?>" /></td>
    </tr>
    <tr>
      <td><strong>Password:</strong></td>
      <td><input name="password" type="password" id="password" /></td>
    </tr>
    <tr>
      <td colspan="2" align="left">
        <strong>
          <input name="Submit" type="submit" id="Submit" value="Click Here To Login" />
          <input name="submitid" type="hidden" id="submitid" value="1" />
        </strong>
      </td>
    </tr>
  </table>
 </fieldset>
</form>


</body>
</html>