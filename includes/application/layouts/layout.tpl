<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
<head>
	<title>{$title}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="en-gb" />
	<meta name="author" content="Michael Bull" />
	<meta name="description" content="M2M Service Application" />
	<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
{block name="head"}{/block}
</head>

<body>
<div id="header">
	<div id="title" class="center">
		<h1><a href="?action=index"><img alt="M2M to SMS" src="media/logo.svg" /></a></h1>
	</div>

	<div id="nav" class="center">
		<ul class="horizontal left">
			{nocache}
				{section name=item loop=$leftNav}
					<li><a href="?action={$leftNav[item].id}"{$leftNav[item].class}><span class="menu icon-{$leftNav[item].icon}"></span>{$leftNav[item].title}</a></li>
				{/section}
			{/nocache}
		</ul>
		<ul class="horizontal right">
			{nocache}
				{$loggedInNav|default:""}
				{section name=item loop=$rightNav}
					<li><a href="?action={$rightNav[item].id}"{$rightNav[item].class}><span class="menu icon-{$rightNav[item].icon}"></span>{$rightNav[item].title}</a></li>
				{/section}
			{/nocache}
		</ul>
	</div>
</div>

<div id="wrapper" class="center">
	<div id="content">
		{block name="content"}{/block}
	</div>

	<div id="footer">
		<p>

			<a href="http://jigsaw.w3.org/css-validator/check/referer">
				<img src="media/css.svg" alt="Valid CSS"  height="31" width="88"/></a>

			<a href="http://validator.w3.org/check?uri=referer">
				<img src="media/xhtml.svg" alt="Valid XHTML 1.0 Strict"  height="31" width="88"/></a>

			<img src="media/retina.svg" alt="All Images Retina Ready" height="31" width="88" />
		</p>
	</div>
</div>
</body>

</html>
