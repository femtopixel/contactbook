<div id='consultation'>
	{if $societeid ne 0}
	<div id="societe">
		<h1>{$companie}</h1>
		{$companieName} : <span id='nomsociete' class="editHighliter editLabelSociete">{$nomsociete}</span><br/>
		{$companieAddress} : <span id='adressesociete' class="editHighliter editRichSociete">{$adressesociete}</span><br/>
		{$companiePhone} : <span id='numerosociete' class="editHighliter editLabelSociete">{$numerosociete}</span><br/>
		{$companieActivity} : <span id='activite' class="editHighliter editRichSociete">{$activite}</span><br/>
		{$companieFax} : <span id='faxsociete' class="editHighliter editLabelSociete">{$faxsociete}</span><br/>
		{$companieWebsite} : <span id='sitesociete' class="editHighliter editLabelSociete">{$sitesociete}</span><br/>
	</div><br/><br/>
	{/if}
	<div id="personne">	
		<h1>{$person}</h1>
		{$name} : <span id='nom' class="editHighliter editLabelUser">{$nom}</span><br/>
		{$fistname} : <span id='prenom' class="editHighliter editLabelUser">{$prenom}</span><br/>
		{$address} : <span id='adresse' class="editHighliter editRichUser">{$adresse}</span><br/>
		{$mailText} : <span id='mail' class="editHighliter editLabelUser">{$mail}</span><br/>
		{$phone} : <span id='numero' class="editHighliter editLabelUser">{$numero}</span><br/>
		{$cell} : <span id='portable' class="editHighliter editLabelUser">{$portable}</span><br/>
		{$faxText} : <span id='fax' class="editHighliter editLabelUser">{$fax}</span><br/>
		{$website} : <span id='site' class="editHighliter editLabelUser">{$site}</span><br/>
		{$comment} : <div id='commentaire' class="editHighliter editRichUser">{$commentaire}</div><br/>
		{if $edit eq 1 and $shared eq 0}
			{$companie} : 
			<span>
				<select id='societeid_{$id}' class="societeid">
						<option value='0' {if $societeid eq 0}selected{/if}>{$none}</option>
					{foreach from=$societes item=curr_id}
						<option value='{$curr_id[0]}' {if $curr_id[0] eq $societeid}selected{/if}>{$curr_id[1]}</option>
					{/foreach}
				</select>
			</span><br/>
		{/if}
	</div>
</div>
{if $edit neq 0}
<script type='text/javascript'>
		var id = {$id};
	{literal}
		$(".editHighliter").mouseover(function() { 
        $(this).css('background-color', '#B4D254');
    });
    $(".editHighliter").mouseout(function() { 
        $(this).css('background-color', '#ffffff');
    });
    
    $(".editLabelUser").editable('/ajax/modifuser?cid='+id, { 
        indicator : "<img src='img/indicator.gif'>",
        onblur    : 'cancel',
        tooltip   : 'Click to edit...',
        cancel    : 'Cancel',
        submit    : 'OK'
    });
    
    $(".editRichUser").richeditor('/ajax/modifuser?cid='+id, { 
					indicator : "<img src='img/indicator.gif'>",
					onblur    : 'cancel',
					tooltip   : 'Click to edit...',
					cancel    : 'Cancel',
					submit    : 'OK'
			});
    
		/*new Ajax.InPlaceEditor('nom', 'ajax/modifuser?mode=nom&id='+id, {highlightcolor:'#B4D254'});
		new Ajax.InPlaceEditor('prenom', 'ajax/modifuser?mode=prenom&id='+id, {highlightcolor:'#B4D254'});
		//new Ajax.InPlaceEditor('adresse', 'ajax/modifuser?mode=adresse&id='+id, {highlightcolor:'#B4D254'});
		new Ajax.InPlaceRichEditor($('adresse'), 'ajax/modifuser?mode=adresse&id='+id, {
                ajaxOptions: {method: 'get'}, //override so we can use a static for the result
                highlightcolor:'#B4D254'
                });
		new Ajax.InPlaceEditor('mail', 'ajax/modifuser?mode=mail&id='+id, {highlightcolor:'#B4D254'});
		new Ajax.InPlaceEditor('numero', 'ajax/modifuser?mode=numero&id='+id, {highlightcolor:'#B4D254'});
		new Ajax.InPlaceEditor('portable', 'ajax/modifuser?mode=portable&id='+id, {highlightcolor:'#B4D254'});
		//new Ajax.InPlaceEditor('commentaire', 'ajax/modifuser?mode=commentaire&id='+id, {highlightcolor:'#B4D254'});
		new Ajax.InPlaceRichEditor($('commentaire'), 'ajax/modifuser?mode=commentaire&id='+id, {
                ajaxOptions: {method: 'get'}, //override so we can use a static for the result
                highlightcolor:'#B4D254'
                });
		new Ajax.InPlaceEditor('fax', 'ajax/modifuser?mode=fax&id='+id, {highlightcolor:'#B4D254'});
		new Ajax.InPlaceEditor('site', 'ajax/modifuser?mode=site&id='+id, {highlightcolor:'#B4D254'});*/
	{/literal}
	{if $societeid ne 0 and $edit eq 2}
		var societeid = {$societeid};
		{literal}
			$(".editLabelSociete").editable('/ajax/modifsociete?gid='+id, { 
					indicator : "<img src='img/indicator.gif'>",
					onblur    : 'cancel',
					tooltip   : 'Click to edit...',
					cancel    : 'Cancel',
					submit    : 'OK'
			});
			$(".editRichSociete").richeditor('/ajax/modifsociete?gid='+id, { 
					indicator : "<img src='img/indicator.gif'>",
					onblur    : 'cancel',
					tooltip   : 'Click to edit...',
					cancel    : 'Cancel',
					submit    : 'OK'
			});
			/*new Ajax.InPlaceEditor('nomsociete', 'ajax/modifsociete?mode=nom&id='+societeid, {highlightcolor:'#B4D254'});
			//new Ajax.InPlaceEditor('adressesociete', 'ajax/modifsociete?mode=adresse&id='+societeid, {highlightcolor:'#B4D254'});
			new Ajax.InPlaceRichEditor($('adressesociete'), 'ajax/modifsociete?mode=adresse&id='+societeid, {
                ajaxOptions: {method: 'get'}, //override so we can use a static for the result
                highlightcolor:'#B4D254'
                });
			new Ajax.InPlaceEditor('numerosociete', 'ajax/modifsociete?mode=numero&id='+societeid, {highlightcolor:'#B4D254'});
			//new Ajax.InPlaceEditor('activite', 'ajax/modifsociete?mode=activite&id='+societeid, {highlightcolor:'#B4D254'});
			new Ajax.InPlaceRichEditor($('activite'), 'ajax/modifsociete?mode=activite&id='+societeid, {
                ajaxOptions: {method: 'get'}, //override so we can use a static for the result
                highlightcolor:'#B4D254'
                });
			new Ajax.InPlaceEditor('faxsociete', 'ajax/modifsociete?mode=fax&id='+societeid, {highlightcolor:'#B4D254'});
			new Ajax.InPlaceEditor('sitesociete', 'ajax/modifsociete?mode=societe&id='+societeid, {highlightcolor:'#B4D254'});*/
		{/literal}
	{/if}
</script>
{/if}

{if $delete eq 1}
<div id='deletenav'>
	<div class='left'>{$sureDeleteContact}</div>
	<div class='right'>
		<div class="right">
			<form action='/post/deleteuser' method='post' id='deleteuserform'>
				<input type='submit' value='OUI' class='hidden'/>
				<button value="input" id='submit_deleteuserform' class="submitBtn submitForm"><span>{$yes}</span></button>
				<input type='hidden' name='id' value='{$id}' />
			</form>
		</div>
		<div class='right'>
			<button class="submitBtn goback"><span>{$no}</span></button>
			<!-- <input type='button' value='NON' class='goback' /> -->
		</div>
	</div>
</div>
{/if}