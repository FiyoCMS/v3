<?php

$curl = curl_init();

$isbn = app_param('isbn');
$url = "https://www.goodreads.com/book/isbn/$isbn?key=9TCscxVe5gri5aQ8ifGzA";

if(!$isbn) die();
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "key: your-api-key"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
    
$response = str_replace(["<![CDATA[", "]]>"], "", $response);
$xml = simplexml_load_string($response); // where $xml_string is the XML data you'd like to use (a well-formatted XML string). If retrieving from an external source, you can use file_get_contents to retrieve the data and populate this variable.
$json = json_encode($xml); // convert the XML string to JSON
$array = json_decode($json); // convert the JSON-encoded string to a PHP variable

    if(app_param('type') == 'xml')
    echo $response;

    if(app_param('type') != 'xml') {

        $book = $array->book;
        $author = $array->book->authors->author;
           
        $isbn = $book->isbn;        
        $isbn13 = $book->isbn13;
        $title =  $book->title;     
        
        $img = $book->image_url;
        $imgS = $book->small_image_url;
        
        $desc = "";
        if(!is_array($book->description))
        $desc = $book->description;

        $num = $book->num_pages;
        $publisher = $book->publisher;
        $date = $book->publication_day . "-" .$book->publication_month. "-".$book->publication_year;       
        
        $author_name = $author->name;


        echo $author_name;

        

        
        
        
    }
}
