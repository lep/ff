<html>
	<body>
			
		{% for item in news%}
			<h2>{{item.headline}}</h2>
			<p>{{item.content}}</p>
		{% endfor %}
		
		<form action="add" method="post">
			<input type="text" name="headline"/><br/>
			<textarea rows="24" cols="40" name="content"></textarea><br/>
			<input type="submit" />
			
		</form>
	</body>
	
</html>