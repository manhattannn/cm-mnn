<?php print '<?xml version="1.0" encoding="utf-8"?>
<rss xmlns:media="http://search.yahoo.com/mrss/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:foaf="http://xmlns.com/foaf/0.1/" xmlns:og="http://ogp.me/ns#" xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#" xmlns:schema="http://schema.org/" xmlns:sioc="http://rdfs.org/sioc/ns#" xmlns:sioct="http://rdfs.org/sioc/types#" xmlns:skos="http://www.w3.org/2004/02/skos/core#" xmlns:xsd="http://www.w3.org/2001/XMLSchema#" version="2.0" xml:base="' . $base_feed_url . '">"' ?>
  <channel>
    <title><?php print $term_name; ?></title>
    <link><?php print $base_feed_url; ?></link>
    <description>Add Description here?</description>
    <language>en</language>

    <?php foreach($data as $item): ?>
      <item>
        <title><?php print $item['title']; ?></title>
        <link><?php print $item['link']; ?></link>
        <description><?php print $item['description']; ?></description>
        <pubDate><?php print $item['pub_date']; ?></pubDate>
        <media:content url="<?php print $item['media_content']; ?>" medium="image"/>
        <dc:creator>Manhattan Neighborhood News</dc:creator>
        <guid isPermaLink="false"><?php print $base_feed_url; ?></guid>
      </item>
    <?php endforeach; ?>

  </channel>
</rss>
