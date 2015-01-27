    <?php
    $rss = new DOMDocument();
    //$rss->load('http://wordpress.org/news/feed/');
    $rss->load('http://cowewpaq01.calstate.edu/northridge/solr/new-titles?format=xerxes&max=15');
    $feed = array();
    foreach ($rss->getElementsByTagName('record') as $node) {
    $item = array (
    'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
    'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
    'link' => $node->getElementsByTagName('record_id')->item(0)->nodeValue,
    'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
    );
    array_push($feed, $item);
    }
    $limit = 10;
    for($x=0;$x<$limit;$x++) {
    $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
    $link = 'http://suncat.csun.edu/record=' . $feed[$x]['link'];
    //$link = $feed[$x]['link'];
    $description = $feed[$x]['desc'];
    //$date = date('l F d, Y', strtotime($feed[$x]['date']));
    echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
    //echo '<small><em>Posted on '.$date.'</em></small></p>';
    echo '<p>'.$description.'</p>';
    }
    ?>