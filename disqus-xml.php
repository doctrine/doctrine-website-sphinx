<?php
// database connection info
$dbInfo = array(
    'host' => 'localhost',
    'name' => 'doctrine_website',
    'user' => 'root',
    'pass' => ''
);


// connect to the database
$db = new PDO('mysql:host=' . $dbInfo['host'] . ';dbname=' . $dbInfo['name'] . ';', $dbInfo['user'], $dbInfo['pass']);
$db->setATtribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sqlQuery = "SELECT
    b.id as blog_id,
    b.name as blog_title,
    b.slug as blog_slug,
    b.body as blog_body,
    b.created_at as blog_date,
    c.poster as comment_poster,
    c.id as comment_id,
    c.created_at as comment_date,
    c.body as comment_body
FROM comment c INNER JOIN blog_post b ON b.id = c.record_id ORDER BY b.id";
$result = $db->query($sqlQuery);
$rawdata = $result->fetchAll(PDO::FETCH_ASSOC);

// Build the comments sql for all the blog posts
$itemXml = '';
$lastId = null;
$first = true;
foreach($rawdata as $data) {
    if($lastId != $data['blog_id']) {
        if($first) $first = false; else {
            $itemXml .= '</item>';
        }

        $itemXml .= '
    <item>
      <!-- title of article -->
      <title>' . $data['blog_title'] . '</title>
      <!-- absolute URI to article -->
      <link>http://www.doctrine-project.org/blog/' . $data['blog_slug'] . '</link>
      <!-- thread body; use cdata; html allowed (though will be formatted to DISQUS specs) -->
      <content:encoded><![CDATA[' . $data['blog_body'] .']]></content:encoded>
      <!-- value used within disqus_identifier; usually internal identifier of article -->
      <dsq:thread_identifier>' . $data['blog_slug'] . '</dsq:thread_identifier>
      <!-- creation date of thread (article), in GMT -->
      <wp:post_date_gmt>' . $data['blog_date'] . '</wp:post_date_gmt>
      <!-- open/closed values are acceptable -->
      <wp:comment_status>open</wp:comment_status>
      ';

        $lastId = $data['blog_id'];
    }

    // add the comment xml
    $itemXml .= '
      <wp:comment>
        <!-- sso only; see docs -->
        <dsq:remote>
          <!-- unique internal identifier; username, user id, etc. -->
          <dsq:id>' . $data['comment_poster'] .'</dsq:id>
          <!-- avatar
          <dsq:avatar>http://url.to/avatar.png</dsq:avatar> -->
        </dsq:remote>
        <!-- internal id of comment -->
        <wp:comment_id>' . $data['comment_id'] . '</wp:comment_id>
        <!-- author display name -->
        <wp:comment_author>' . $data['comment_poster'] .'</wp:comment_author>
        <!-- author email address
        <wp:comment_author_email>foo@bar.com</wp:comment_author_email> -->
        <!-- author url, optional
        <wp:comment_author_url>http://www.foo.bar/</wp:comment_author_url> -->
        <!-- author ip address
        <wp:comment_author_IP>93.48.67.119</wp:comment_author_IP> -->
        <!-- comment datetime, in GMT -->
        <wp:comment_date_gmt>' . $data['comment_date'] . '</wp:comment_date_gmt>
        <!-- comment body; use cdata; html allowed (though will be formatted to DISQUS specs) -->
        <wp:comment_content><![CDATA[' . $data['comment_body'] . ']]></wp:comment_content>
        <!-- is this comment approved? 0/1 -->
        <wp:comment_approved>1</wp:comment_approved>
        <!-- parent id (match up with wp:comment_id) -->
        <wp:comment_parent>0</wp:comment_parent>
      </wp:comment>
      ';

}
echo '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:dsq="http://www.disqus.com/"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:wp="http://wordpress.org/export/1.0/"
>
  <channel>
' . $itemXml . '
  </channel>
</rss>';
