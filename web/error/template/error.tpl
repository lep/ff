
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>{{title}}</title>
	<body>
		<h1>{{title}}</h1>
		<p>{{error}}</p>
		<pre>{{trace}}</pre>
		<p>
			<a href="">Reload this page</a>
		{%if referrer%}
			<a href="{{referrer}}">Go back to previous page</a>
		{%endif%}
		</p>
	</body>
</html>

