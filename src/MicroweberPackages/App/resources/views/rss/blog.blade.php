<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0"
    xmlns:g="http://base.google.com/ns/1.0">
    <channel>
        <title>{{ $siteTitle }}</title>
        <link>{{ $siteUrl }}</link>
        <description>{{ $siteDescription }}</description>
        @foreach ($rssData as $item)
            <item>
                <id>{{ $item['id'] }}</id>
                <title>{{ $item['title'] }}</title>
                <subtype>{{ $item['subtype'] }}</subtype>
                <parent>{{ $item['parent'] }}</parent>
                <slug>{{ $item['slug'] }}</slug>
                <description>{{ $item['description'] }}</description>
                @if(!empty($item['image']))
                    <image>{{ $item['image'] }}</image>
                @endif
                <category>{{ $item['category'] }}</category>
                <created_at>{{ $item['created_at'] }}</created_at>
                <link>{{ $item['url'] }}</link>
                <linkurl>{{ $item['url'] }}</linkurl>
                <Author>{{ $item['author'] }}</Author>
                
            </item>
        @endforeach
    </channel>
</rss>