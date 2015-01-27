<?php  
header("Content-Type: application/rss+xml; charset=ISO-8859-1");
$rss = '<?xml version="1.0" encoding="ISO-8859-1"?>';
  $rss .= '<rss version="2.0">';
  $rss .= '<channel>';
  $rss .= '<title>New Titles Feed</title>';
  $rss .= '<link>http://library.csun.edu</link>';
  $rss .= '<description>New Titles Available at the Oviatt Library</description>';
  $rss .= '<language>en-us</language>';
  $rss .= '<copyright>Copyright (C) 2015 library.csun.edu</copyright>';
$html = "";
$url = "http://cowewpaq01.calstate.edu/northridge/solr/new-titles?format=xerxes&max=15";
$xml = simplexml_load_file($url);
$result = $xml->xpath('//Column[@Name="billingname"]');
foreach($result as $column){
    echo $column['Value'];
}
for($i = 0; $i < 15; $i++){
  $link = $xml->results->records->record[$i]->xerxes_record->record_id;
  $title = $xml->results->records->record[$i]->xerxes_record->title_statement;
  $description = $xml->channel->item[$i]->description;
  $pubDate = $xml->channel->item[$i]->pubDate;
  $rss .= '<item>';
  $rss .= '<title>' . $title . '</title>';
  $rss .= '<link>' . 'http://suncat.csun.edu/record=' . $link . '</link>';
  $rss .= '</item>';
}
$rss .= '</channel>';
$rss .= '</rss>';
echo $rss;
?>
