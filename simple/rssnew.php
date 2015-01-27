<?php  
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
$url = "http://cowewpaq01.calstate.edu/northridge/solr/new-titles?format=xerxes&max=15";
$today = date('m-d-Y');
$xml = simplexml_load_file($url);
$xml->registerXPathNamespace('default', 'http://www.loc.gov/MARC21/slim');
foreach($xml->results->records->record as $entry) {
    $link = $entry->xerxes_record->record_id;
    $title = $entry->xerxes_record->title_statement;
    $rss .= '<item>';
    $rss .= '<title>' . $title . '</title>';
    //$rss .= '<description>' . $today . '</description>';
    $rss .= '<link>' . 'http://suncat.csun.edu/record=' . $link . '</link>';
    //$finddate = $xml->results->records->record[$i]->default:record->default:datafield[@tag="945"]->default:subfield[@code="z"];
    //$namespaces = $entry->getNameSpaces(true);
    $default = $entry->children($namespaces['default']);
    //$nodes = $default->xpath('/record/leader');
    //$xarray = $nodes[0];
    //$finddate = $finddate[0];
    //this works but cannot use attribute
    $finddate = $default->record->leader; 
    //$finddate = $default->record->datafield[@tag='945']->subfield[@code='z'];
    $rss .= '<date>' . $xarray . '</date>';
    $rss .= '</item>';
}
$rss .= '</channel>';
$rss .= '</rss>';
echo $rss;
?>
