<?PHP

include_once('src/send.php');

use richbarrett\itagg\send;

$send = new send('YOUR_USER','YOUR_PASSWORD');
$send->addTo('00000000000');
$send->setBody('Hello world');
$send->setFrom('Rich');

try {
 
  $response = $send->sendRequest();
  die('Success!');
 
} catch (\Exception $e) {
  
  die('Failed with error: '.$e->getMessage());
  
}


?>