<?php
//create default RSS feed headers  
date_default_timezone_set('UTC');
header("Content-Type: application/rss+xml; charset=ISO-8859-1");
$rss = '<?xml version="1.0" encoding="ISO-8859-1"?>';
  $rss .= '<rss version="2.0">';
  $rss .= '<channel>';
  $rss .= '<title>New Titles Feed</title>';
  $rss .= '<link>http://library.csun.edu</link>';
  $rss .= '<description>New Titles Available at the National Center on Deafness</description>';
  $rss .= '<language>en-us</language>';
  $rss .= '<copyright>Copyright (C) 2015 library.csun.edu</copyright>';
  
//pull the New Titles Xerxes XML endpoint, get 100 titles and register the default namespace
$url = "http://library.calstate.edu/northridge/solr/new-titles?format=xerxes&max=50";
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
	$firstloc = substr($location,0,2);
	$bibcreated = strtotime($new)[0];
    if (($firstloc == 'nc') && ($bibcreated < $prevmonth)) {
      $rss .= '<date>' . $new . '</date>';
	  $rss .= '<item>';
      $rss .= '<title>' . $title . " " . $callnum . '</title>';
      $rss .= '<link>' . 'http://suncat.csun.edu/record=' . $link . '</link>';
      $rss .= '</item>';
	  }
	}
//For NCOD, add some items by default
 $rss .= '<date>01-30-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>American Sign Language vocabulary builder. Volume 1 / HV2476.4 .A436 2010 v.1</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3313861</link>';
      $rss .= '</item>';
 $rss .= '<date>01-30-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>Common expressions in American Sign Language. Volume 1 / HV2476.4 .C648 2010 </title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3313863</link>';
      $rss .= '</item>';
$rss .= '<date>01-30-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>ASL extreme makeovers [videorecording] : the art of personification. / HV2476.4 .A844 2009</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3313867</link>';
      $rss .= '</item>';
 $rss .= '<date>01-30-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>Educational interpreting practice DVD. DVD five, Elementary level / HV2402 .E3865 2012</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3313868</link>';
      $rss .= '</item>';
 $rss .= '<date>01-30-2015</date>';
	  $rss .= '<item>';
      $rss .= '<title>Language partners [videorecording] : building a strong foundation / HV2391 .L353 2006</title>';
      $rss .= '<link>http://suncat.csun.edu/record=b3313869</link>';
      $rss .= '</item>';
//close up the feed
$rss .= '</channel>';
$rss .= '</rss>';

//RSS feeds hate ampersands
$rss = str_replace("&", "and", $rss);
echo $rss;
?>
