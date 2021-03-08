
<?php

header('Content-Type: application/json');
$target_url = "https://www.google.com/search?client=firefox-b-d&q=".rawurlencode(htmlspecialchars($_GET['search']))."";
$userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';

// make the cURL request to $target_url
$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
curl_setopt($ch, CURLOPT_URL,$target_url);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$html= curl_exec($ch);
if (!$html) {
echo "<br />cURL error number:" .curl_errno($ch);
echo "<br />cURL error:" . curl_error($ch);
exit;
}
//



/*
echo '<img src="'.$imgs[2].'">';*/
//$html=file_get_contents($link);
$imgs = array();
$dom = new domDocument;
@$dom->loadHTML($html);
$dom->preserveWhiteSpace = false;
$images = $dom->getElementsByTagName('div');
foreach ($images as $image) {
$imgs[] = $image->textContent;//atribut qui sort l'image
}


$titles = array();
$num=0;
foreach ($imgs as  $value) {
  if(str_word_count($value)>5)
    {
      $titles[]=$value;
      $num=$num+1;
    };
}




$imgs1 = array();
$dom1 = new domDocument;
@$dom1->loadHTML($html);
$dom1->preserveWhiteSpace = false;
$images1 = $dom1->getElementsByTagName('a');
foreach ($images1 as $image) {

//$imgs1[] = $image->getAttribute('href');//atribut qui sort l'image
$pieces = explode("&", substr($image->getAttribute('href'),7,-1));

  if (filter_var($pieces[0], FILTER_VALIDATE_URL)) {
    $imgs1[]=$pieces[0];
} else {

}
}

echo json_encode($imgs1);



?>
