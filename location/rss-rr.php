<?php
//create default RSS feed headers  
date_default_timezone_set('UTC');
header("Content-Type: application/rss+xml; charset=ISO-8859-1");
$rss = '<?xml version="1.0" encoding="ISO-8859-1"?>';
  $rss .= '<rss version="2.0">';
  $rss .= '<channel>';
  $rss .= '<title>CSU Northridge Oviatt Library - New Leisure Reading Room Titles</title>';
  $rss .= '<link>http://library.csun.edu</link>';
  $rss .= '<description>CSU Northridge Oviatt Library - New Leisure Reading Room Titles</description>';
  $rss .= '<language>en-us</language>';
  $rss .= '<copyright>Copyright (C) 2015 library.csun.edu</copyright>';
  
//pull the New Titles Xerxes XML endpoint, get 100 titles and register the default namespace
$url = "http://cowewpaq01.calstate.edu/northridge/solr/new-titles?format=xerxes&max=50";
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
	$location = $new->xpath("../../default:datafield[@tag='945']/default:subfield[@code='l']")[0];
	$firstloc = substr($location,0,5);
	$bibcreated = strtotime($new)[0];
    if (($firstloc == 'readr') && ($bibcreated < $prevmonth)) {
      $rss .= '<date>' . $new . '</date>';
	  $rss .= '<item>';
      $rss .= '<title>' . $title . " " . $callnum . '</title>';
      $rss .= '<link>' . 'http://suncat.csun.edu/record=' . $link . '</link>';
      $rss .= '</item>';
	  }
	}
//For Reading Room (readr), add some items by default
 $rss .= '<date>02-09-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>The American Mission / Matthew Palmer</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3312829</link>';
      $rss .= '</item>';
 $rss .= '<date>02-03-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>Longbourn : a novel / Jo Baker</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3301464</link>';
      $rss .= '</item>';
$rss .= '<date>01-30-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>American catch : the fight for our local seafood / Paul Greenberg.</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3301463</link>';
      $rss .= '</item>';
 $rss .= '<date>01-30-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>The Queen of the Tearling : a novel / Erika Johansen.</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3301461</link>';
      $rss .= '</item>';
 $rss .= '<date>01-30-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>Fire shut up in my bones : a memoir / Charles M. Blow.</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3301460</link>';
      $rss .= '</item>';
//close up the feed
$rss .= '</channel>';
$rss .= '</rss>';

//RSS feeds hate ampersands
$rss = str_replace("&", "and", $rss);
echo $rss;
?>