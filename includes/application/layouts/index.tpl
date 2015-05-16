{extends file="layout.tpl"}
{block name="content"}
	<h3>Welcome</h3>
	<p>
		To begin, simply <a href="?action=register">create an account</a>. Once
		created, you may then <a href="?action=login">log in to it</a> for the
		ability to <a href="?action=statuses">view circuit board statuses</a>.
	</p>

	<p>
		Administrators may poll the service for
		<a href="?action=updates">updates to the circuit boards</a>.
	</p>
{/block}
