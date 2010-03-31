<html>
	<body>
		<p>
		{% if user %}
			You are logged in as {{user.name}}
		{% else %}
			Not logged in
		{% endif %}
		{{user.name}}
		</p>
			
		<h2>Log in </h2>
		<form action="login" method="post" accept-charset="utf-8">
			<input type="text" name="name"> <br/>
			<input type="password" name="password"><br/>
			<p><input type="submit" value="Continue &rarr;"></p>
		</form>
			
		
		<h2>Create new user</h2>
		<form action="create" method="post">
			<input type="text" name="name"/><br/>
			<input type="password" name="password" /><br/>
			<input type="submit" />
		</form>
	</body>
</html>
