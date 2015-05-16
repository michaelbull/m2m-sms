{extends file="layout.tpl"}
{block name="content"}
	<h3>Login</h3>
	<div class="login-details">
		<form method="post" action="">
			<table>
				<tr>
					<th><label for="username">Username:</label></th>
					<td><input id="username" type="text" name="username" /></td>
				</tr>
				<tr>
					<th><label for="password">Password:</label></th>
					<td><input id="password" type="password" name="password" /></td>
				</tr>
				<tr>
					<th></th>
					<td><button name="action" type="submit">Login</button></td>
				</tr>
			</table>
		</form>
		<p>Don&rsquo;t have an account? Register one <a href="?action=register">here</a>.</p>
	</div>
{/block}
