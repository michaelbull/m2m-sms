{extends file="layout.tpl"}
{block name="content"}
	{nocache}
		{if count($updates) === 0}
			<p>No updates found.</p>
		{else}
			{section name=update loop=$updates}
				{assign var="update" value=$updates[update]}
				{assign var="information" value=$update->getInformation()}
				{assign var="status" value=$update->getStatus()}
				<h3>Status update for {$information->getName()} (+{$information->getMSISDN()}) <br /> Received at {$status->getFormattedDate()}</h3>
				<table class="board-details" border="1">
					<tr>
						<th><span class="menu icon-date"></span>Latest update at</th>
						<td>{$status->getFormattedDate()}</td>
					</tr>
					<tr>
						<th><span class="menu icon-switch"></span>Switch #1</th>
						<td>{$status->getSwitchOne()}</td>
					</tr>
					<tr>
						<th><span class="menu icon-switch"></span>Switch #2</th>
						<td>{$status->getSwitchTwo()}</td>
					</tr>
					<tr>
						<th><span class="menu icon-switch"></span>Switch #3</th>
						<td>{$status->getSwitchThree()}</td>
					</tr>
					<tr>
						<th><span class="menu icon-switch"></span>Switch #4</th>
						<td>{$status->getSwitchFour()}</td>
					</tr>
					<tr>
						<th><span class="menu icon-fan"></span>Fan</th>
						<td>{$status->getFan()}</td>
					</tr>
					<tr>
						<th><span class="menu icon-temperature"></span>Temperature</th>
						<td>{$status->getTemperature()} &deg;C</td>
					</tr>
					<tr>
						<th><span class="menu icon-keypad"></span>Keypad</th>
						<td>{$status->getKeypad()}</td>
					</tr>
				</table>
			{/section}
		{/if}
	{/nocache}
{/block}
