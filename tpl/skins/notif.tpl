<link href="{{ admin_url }}/plugins/news_notif/tpl/skins/css/style.css" type="text/css" rel="stylesheet"/>
<div id="news_notifier_new" class="news-notify">
<div class="news-notify-message news-notify-message-style">
	<a class="news-notify-close" href="#" onclick="this.parentNode.style.display='none';"><span class="news-notify_close" style="float:right"><i class="fa fa-times-circle fa-2x" aria-hidden="true"></i></span></a>
	<h1>{{ news_text }}</h1>
	<div style="color:red;">{{ news_info }}</div>
	<p>{{ news_alert }}</p>
</div>
</div>
<script>
var news_notifier_new = {{ limit }};
setTimeout("document.getElementById('news_notifier_new').style.display='block'", news_notifier_new);
setInterval("document.getElementById('news_notifier_new').style.display='none'", 15000);
</script>