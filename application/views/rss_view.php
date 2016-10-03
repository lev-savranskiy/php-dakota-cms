<?=
'<?xml version="1.0" encoding="utf-8"?>'
; ?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">

    <atom:link href="<?= base_url() ?>rss/" rel="self" type="application/rss+xml"/>

    <channel>

        <title><?= $feed_name; ?></title>
        <link><?= $feed_url; ?></link>
        <description><?= $page_description; ?></description>

    <? foreach ($updates as $entry):
        $format = 'DATE_RFC822';
        $unix = human_to_unix($entry['updated_at']);
        $date = standard_date($format, $unix);
    ?>

            <item>
                <title><?= xml_convert($entry['title']); ?></title>
                <link><?= site_url('/articles/title/' . $entry['url']) ?></link>
                <guid><?= site_url('/articles/title/' . $entry['url']) ?></guid>
                <description><![CDATA[       <?=  $entry['text']; ?>      ]]></description>
                <pubDate><?= $date;?></pubDate>

            </item>
        <? endforeach; ?>
    </channel>
</rss>

