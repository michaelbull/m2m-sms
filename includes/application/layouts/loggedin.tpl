{extends file="layout.tpl"}
{block name="content"}
	<h3>Logged In</h3>
	{nocache}
		<p>Thank you for logging in {$loggedInTo}.</p>
	{/nocache}
{/block}
