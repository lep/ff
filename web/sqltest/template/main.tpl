<html>
	<body>
			
		{% for item in news%}
			<h2>{{item.headline}}</h2>
			<a href="remove/{{item.id}}">L&ouml;schen</a>
			<p>{{item.content}}</p>
		{% endfor %}
		
		<form action="add" method="post">
			<input type="text" name="headline"/><br/>
			<textarea rows="24" cols="40" name="content"></textarea><br/>
			<input type="submit" />
			
		</form>
	</body>
</html>
