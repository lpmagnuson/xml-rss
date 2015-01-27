<?php
$html = "";
$url = "http://cowewpaq01.calstate.edu/northridge/solr/new-titles?format=xerxes&max=10";
$xml = simplexml_load_file($url);
for($i = 0; $i < 10; $i++){
$link = $xml->results->records->record[$i]->xerxes_record->record_id;
$title = $xml->results->records->record[$i]->xerxes_record->title_statement;
$description = $xml->channel->item[$i]->description;
$pubDate = $xml->channel->item[$i]->pubDate;
$html .= "<a href='http://suncat.csun.edu/record=$link'><h3>$title</h3></a>";
$html .= "$description";
$html .= "<br />$pubDate<hr />";
}
echo $html;
//echo $title;
//echo $link;
?>
