{extends file="layout.tpl"}
{block name="content"}
	<h3>Registered</h3>
	{nocache}
		<p>Thank you for registering {$registeredUsername}.</p>
	{/nocache}
	<p>You may now <a href="?action=login">log in to your account</a>.</p>
{/block}
