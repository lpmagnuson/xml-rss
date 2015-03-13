<?php
$html = "<table><tr><td><strong>Title/Author</strong></td><td><strong>Call Number</strong></td></tr>";
  
//pull the New Titles Xerxes XML endpoint, get 15 titles and register the default namespace
<<<<<<< HEAD
$url = "http://library.calstate.edu/northridge/solr/new-titles?format=xerxes&max=200";
=======
$url = "http://cowewpaq01.calstate.edu/northridge/solr/new-titles?format=xerxes&max=200";
>>>>>>> 9eae7198990162dab4d51087f5e1b8f54fdfe4e0
$xml = simplexml_load_file($url);
$xml->registerXPathNamespace('default', 'http://www.loc.gov/MARC21/slim');

//Get the date from one month ago
$date = new DateTime();
$date->sub(new DateInterval('P1M'));
$prevmonth = $date->format('m-d-y');

//find the dates all the bib records were created on in the cat date 998|b field
$newtoday = $xml->xpath("//default:record/default:datafield[@tag='998']/default:subfield[@code='b']");
$entry = $xml->xpath("//results/records/record");

//create array of only bib records created in the past month
foreach($newtoday as $new) {
    $link = $new->xpath("../../../xerxes_record/record_id")[0];
	$title = $new->xpath("../../../xerxes_record/title_statement")[0];
	$callnum = $new->xpath("../../../xerxes_record/call_number")[0];
	$bibcreated = strtotime($new)[0];
    if ($bibcreated < $prevmonth) {
	  $html .= "<tr><td><a href='http://suncat.csun.edu/record=$link'><h3>$title</h3></a></td><td>" . $callnum . "</td></tr>";
	  }
	}
$html .= "</table>";
echo $html;
?>