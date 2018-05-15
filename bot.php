<?php




$botToken = "585408099:AAGsxNfxTfcHE_KfDVyNrJ_T7_52i7R1cdk";
$website = "https://api.telegram.org/bot".$botToken;

//input is used when webhook is enabled!
// $update = file_get_contents($website."/getupdates");
$update = file_get_contents("php://input");

$update = json_decode($update, TRUE);

//print_r($updateArray);

//$text = $updateArray["result"][0]["message"]["text"];
// $mood = true;

$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];
// print_r($text);
// print_r($chatId);

file_get_contents($url);


$file = 'mood.txt';
// Open the file to get existing content
$current = file_get_contents($file);
$mood = ($current === 'true');

// file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=something");
if ($mood){
  $message = preg_replace('/\s+/', '+', $message);
  processEmo($chatId, $message, $mood);
  break;
}

if (preg_match_all("/(best bank)/", $message, $output_array) ) {
  $message = "best bank";
}

if (preg_match_all("/(your name)/", $message, $output_array) ) {
  $message = "your name";
}

switch ($message) {
  case "test":
      sendMessage($chatId, "Wow, such a successful test", $mood);
      break;
  case "hi":
      $mood = true ;
      sendMessage($chatId, "Hey there! How are you?", $mood);
      break;
  case "your name":
      sendMessage($chatId, "I'm very privacy complient, especially with GDPR coming up. So lets just leave it at EA bot!", $mood);
      break;
  case "best bank":
      sendMessage($chatId, "ING ING ING!", $mood);
      break;
  case "yes":
      sendMessage($chatId, "Whoop whoop, great success!", $mood);
      break;
  case "no":
        sendMessage($chatId, "Too bad, better luck next time.", $mood);
      break;
  case "/question":
      getQuestion();
      break;
  default:
      sendMessage($chatId, "I didn't get that, can you rephrase?", $mood);
    break;
}




function processEmo ($chatId, $message, $mood) {
  $mood = false;
  $emoWebsite = "https://api.nulldev.org/emo?text=";
  $emoQuery = file_get_contents($emoWebsite.$message);
  $emoQuery = json_decode($emoQuery, TRUE);
  $emo = $emoQuery["emotion_tone"];
  sendMessage($chatId,"I sense that the emotion you are feeling is ".$emo.". Is this correct?");
}

function sendMessage ($chatId, $message, $mood, $file){
  $url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".urlencode($message);
  file_get_contents($url);


  $file = 'mood.txt';
  // Open the file to get existing content
  $current = file_get_contents($file);

  //convert boolean type mood to string
  $converted_mood = ($mood) ? 'true' : 'false';
  // $current = $converted_mood;
  // Write the contents back to the file
  file_put_contents($file, $converted_mood);
  exit;
}

function getQuestion (){

}


?>
