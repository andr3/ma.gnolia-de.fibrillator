<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Ma.gnolia de.fibrillator</title>
    <link rel="stylesheet" type="text/css" href="fl.owerpower.css" />
<?php

if (!empty($_GET['username'])) {
?>
<script src="http://js.sapo.pt/Prototype/" type="text/javascript"></script>
<!--
  Copyright (c) 2008 Google Inc.

  You are free to copy and use this sample.
  License can be found here: http://code.google.com/apis/ajaxsearch/faq/#license
-->
<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAPfZld7cS4gwQg7Ca5X0__BSdtJTr1T1CUqHk29BI21zzMBBLaRSO0HjrDR5lLY3IxyxXEi849n3Z-A"></script>
  <script type="text/javascript">
    /* <![CDATA[ */
    /*
    *  How to see historical entries in a feed.  Usually a feed only returns x number
    *  of results, and you want more.  Since the Google Feeds API caches feeds, you can
    *  dig into the history of entries that it has cached.  This, paired with setNumEntries,
    *  allows you to get more entries than normally possible.
    */
    
    google.load("feeds", "1");
    
    // Our callback function, for when a feed is loaded.
    function feedLoaded(result) {
      if (result.error) {
        alert('There was an error processing this feed. Maybe Google missed it.');
      } else {
        // Grab the container we will put the results into
        var container = document.getElementById("content");
        container.innerHTML = '';
    
        // Loop through the feeds, putting the titles onto the page.
        // Check out the result object for a list of properties returned in each entry.
        // http://code.google.com/apis/ajaxfeeds/documentation/reference.html#JSON
        var txt = '';
        var i = 0;
        for (i=0; i < result.feed.entries.length; i++) {
          var entry = result.feed.entries[i];
          var li = document.createElement("div");
          container.appendChild(li);
          li.className = 'hentry xfolkentry';
          li.innerHTML += '<p class="entry-title title"><a href="'+link+'">'+entry.title+'</a></p>';
          li.innerHTML += '<div class="entry-content entry-summary description"><p>'+entry.content+'</p></div>';
          
          var p_tags = Element.select ( li, '.entry-content p' ).last();
          p_tags.className = 'meta';

          var tags = Element.select ( p_tags, 'a' );
          for (var j=0,len=tags.length;j<len;j++) {
            tags[j].setAttribute('rel','tag');
          }
          //var link = entry.content.replace ( /.*<a[^\>]*href=\"/m, 'X' ).replace( /\".*/m, 'Y' );
          var link = Element.select ( li, '.entry-content a' ).first().getAttribute('href');
          li.innerHTML += '<p>link: <a href="'+decodeURIComponent(link)+'" class="taggedlink" rel="bookmark">'+entry.title+'</a></p>';


          var d = new Date (entry.publishedDate);
          var isodate = d.getFullYear()+'-'+(d.getMonth()<9?'0':'')+(d.getMonth()+1)+'-'+d.getDate();
          
          isodate += 'T' + (d.getHours()<10?'0':'')+d.getHours()+':'+(d.getMinutes()<10?'0':'')+d.getMinutes()+':'+(d.getSeconds()<10?'0':'')+d.getSeconds();

          
          li.innerHTML += '<p><abbr class="published" title="'+isodate+'">'+entry.publishedDate+'</span></p>';
         // li.innerHTML = txt;
        }

        var frm = document.createElement ( 'form' );
        frm.setAttribute ( 'action', './saver.php');
        frm.setAttribute ( 'method', 'post');

        if ( i==0 ) {
            frm.innerHTML = '<p>Couldn\'t recover any links. Sorry.</p>';
        } else {
            frm.innerHTML = '<p>Recovered ' + (i+1) + ' links.</p>';
        }
        frm.innerHTML += '<button type="submit"><strong>Next step &rarr;</strong></button> (It might take several minutes, please wait...)';

        var holder = document.createElement ( 'input' );
        holder.type = 'hidden';
        holder.name = 'content';
        holder.value = encodeURIComponent (document.getElementById('content').innerHTML); 
        frm.appendChild(holder);

        document.getElementById('content').parentNode.insertBefore ( frm, document.getElementById('content') ); 
      }
    }
    
    function OnLoad() {
      // Create a feed instance that will grab Digg's feed.
      var feed = new google.feeds.Feed("http://ma.gnolia.com/rss/full/people/<?php echo htmlentities($_GET['username']); ?>");
    
      feed.includeHistoricalEntries(); // tell the API we want to have old entries too
      feed.setNumEntries(5000); // we want a maximum of 250 entries, if they exist
    
      // Calling load sends the request off.  It requires a callback function.
      feed.load(feedLoaded);
    }
    
    google.setOnLoadCallback(OnLoad);
    /* ]]> */
    </script>
<?php
}
?>
  </head>
  <body>
    <h1>Ma.gnolia de.fibrillator</h1>
<?php
if (empty($_GET['username'])) {
?>
<form action="./" method="get">

<p><label for="username">Username on Ma.gnolia</label> <input type="text" id="username" name="username" /></p>
<p><button type="submit">Recover my bookmarks!</button></p>
</form>
<?php
} else {
?>
  <div id="content">Loading...</div>
<?php
}
?>
    <hr />
    <p class="footer">brought to you by <a href="http://andr3.net">andr3.net</a></p>
  </body>
</html>
