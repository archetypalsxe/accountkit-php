<?php

require_once("lib/autoloader.php");

$accountKit = new \Controller\AccountKit();
$user = $accountKit->getUserInformation($_POST['code']);

if(empty($user)) {
    die;
}

?>


<head>
  <title>Account Kit PHP App</title>
</head>
<body>
  <div>User ID: <?php echo $user->userId; ?></div>
  <div>Phone Number: <?php echo $user->phone; ?></div>
  <div>Email: <?php echo $user->email; ?></div>
  <div>Access Token: <?php echo $user->accessToken; ?></div>
  <div>Refresh Interval: <?php echo $user->refreshInterval; ?></div>
</body>
