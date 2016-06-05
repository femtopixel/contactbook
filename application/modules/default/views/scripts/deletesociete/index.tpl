<div id='deletesociete'>
	<h1>{$deletesociety}</h1>
	<form action='javascript:void(0);' method='post'>
		<select name='id' id='societeid'>
			{foreach from=$result item=curr_id}
				<option value='{$curr_id[0]}'>{$curr_id[1]}</option>
			{/foreach}
		</select>
	</form>
	<br/>
	<button class="submitBtn" id='deleteonlysociety'><span>{$deleteonlysociety}</span></button>
	<button class="submitBtn" id='deleteallsociety'><span>{$deleteallsociety}</span></button>
</div>