<?php
//create default RSS feed headers  
date_default_timezone_set('UTC');
header("Content-Type: application/rss+xml; charset=ISO-8859-1");
$rss = '<?xml version="1.0" encoding="ISO-8859-1"?>';
  $rss .= '<rss version="2.0">';
  $rss .= '<channel>';
  $rss .= '<title>New Titles Feed</title>';
  $rss .= '<link>http://library.csun.edu</link>';
  $rss .= '<description>New Titles Available at the Oviatt Library</description>';
  $rss .= '<language>en-us</language>';
  $rss .= '<copyright>Copyright (C) 2015 library.csun.edu</copyright>';
  
//pull the New Titles Xerxes XML endpoint, get 15 titles and register the default namespace
$url = "http://library.calstate.edu/northridge/solr/new-titles?format=xerxes&max=100";
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
    //if ($bibcreated < $prevmonth) {
	if ((substr($callnum, 0, 1) === 'J')  && ($bibcreated < $prevmonth)) {
      $rss .= '<date>' . $new . '</date>';
	  $rss .= '<item>';
      $rss .= '<title>' . $title . " " . $callnum . '</title>';
      $rss .= '<link>' . 'http://suncat.csun.edu/record=' . $link . '</link>';
      $rss .= '</item>';
	  }
	}

	//Add some items by default
 $rss .= '<date>03-13-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>American exceptionalism and the remains of race[electronic resource] :multicultural exorcisms / Fong, Edmund, author.</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3314274</link>';
      $rss .= '</item>';
 $rss .= '<date>03-13-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>Blackballed :the Black vote and US democracy / Pinckney, Darryl, 1953-</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3301581</link>';
      $rss .= '</item>';
$rss .= '<date>03-13-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>Branding for the public sector[electronic resource] :creating, building and managing brands people will value / Temporal, Paul, author.</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3320884</link>';
      $rss .= '</item>';
 $rss .= '<date>03-13-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>Communicating politics online[electronic resource] :changing modes, changing information / Rackaway, Chapman, author.</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3314275</link>';
      $rss .= '</item>';
 $rss .= '<date>03-13-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>Constructing democratic governance in Latin America</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3300889</link>';
      $rss .= '</item>';	
//close up the feed
$rss .= '</channel>';
$rss .= '</rss>';

//RSS feeds hate ampersands
$rss = str_replace("&", "and", $rss);
echo $rss;
?>
