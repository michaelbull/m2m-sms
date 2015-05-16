{extends file="layout.tpl"}
{block name="head"}
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		{literal}google.load("visualization", "1", {packages: ["corechart"]});{/literal}
		google.setOnLoadCallback(drawCharts);

		function drawCharts() {
{nocache}{section name=board loop=$boards}
{assign var="board" value=$boards[board]}
{assign var="information" value=$board->getInformation()}
{assign var="msisdn" value=$information->getMSISDN()}
{assign var="status" value=$board->getStatus()}
{if $status !== null}
			var element = document.getElementById("chart_{$msisdn}");

{assign var="celsius" value=$status->getTemperature()}
			new google.visualization.ColumnChart(element).draw(
					google.visualization.arrayToDataTable([
						["", "Temperature", { role: "style" }],
						["Celsius (°C)", {$celsius}, "blue"],
						["Farenheit (°F)", {math equation="((x * 9) / 5) + 32" x=$celsius}, "red"]
					]),
					{
						title: "Temperature of {$information->getName()}",
						legend: "none"
					}
			);
{/if}
{/section}{/nocache}
		}
	</script>
{/block}
{block name="content"}
	{nocache}
		{if count($boards) === 0}
			<p>No boards found.</p>
		{else}
			{section name=board loop=$boards}
				{assign var="board" value=$boards[board]}
				{assign var="information" value=$board->getInformation()}
				{assign var="status" value=$board->getStatus()}
				<h3>{$information->getName()} (+{$information->getMSISDN()})</h3>
				{if $status === null}
					<p>No status found.</p>
				{else}
					<div class="status">
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
						<div id="chart_{$information->getMSISDN()}" class="chart"></div>
					</div>
				{/if}
			{/section}
		{/if}
	{/nocache}
{/block}
