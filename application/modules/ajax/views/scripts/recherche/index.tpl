{foreach from=$result item=curr_id}
	<div class="resultrecherche">
		<div class='left'>
      <span>{$companie} : <b>{$curr_id[1]}</b></span><br/>
			<span>{$name} : <b>{$curr_id[2]}</b></span><br/>
			<span>{$firstname} : <b>{$curr_id[3]}</b></span><br/>
			<span>{$phone} : <b>{$curr_id[4]}</b></span><br/>
			<span>{$mail} : <b>{$curr_id[5]}</b></span><br/>
		</div>
		<div class='right'>
			{if $curr_id.share neq 0}<span>{$sharedby} :<br/><b>{$curr_id.sharedby}</b></span><br/>{/if}
			<button id='consult_{$curr_id[0]}' class="submitBtn consult"><span>{$consult}</span></button><br/>
			{if $curr_id.writeable eq 1}<button id='edit_{$curr_id[0]}' class="submitBtn edit"><span>{$edit}</span></button><br/>{/if}
      {if $curr_id.share eq 0}
        <button id='delete_{$curr_id[0]}' class="submitBtn delete"><span>{$delete}</span></button><br/>
        {if $useShare}<button id='share_{$curr_id[0]}' class="submitBtn share"><span>{$share}</span></button><br/>{/if}
      {else}
        <button id='deleteshare_{$curr_id.shareid}' class="submitBtn deleteshareresult"><span>{$deleteshare}</span></button><br/>
      {/if}
		</div>
	</div>
{/foreach}

{$pagine}