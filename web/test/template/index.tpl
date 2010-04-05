<html>
	<head>
		<title>test</title>
	</head>
	<body>
		<h1>Testing the post-api</h1>
		<h2>Post something</h2>
		<form method="post" action="/ff/test/add">
			<input type="text" name="title" />
			<br />
			<textarea name="content"></textarea>
			<br />
			<input type="submit" />
		</form>

		<h2>Register a user</h2>
		<form method="post" action="/ff/test/register">
			<input type="text" name="name" />
			<br />
			<input type="text" name="email" />
			<br />
			<input type="password" name="password1" />
			<br />
			<input type="password" name="password2" />
			<br />
			<input type="submit" />
		</form>
	</body>
</html>
