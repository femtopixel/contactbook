{foreach from=$sharearray item=curr}
<span class="sharemail">{$curr.mail}</span> {if $admin eq 1}<label for="modifycompany_{$curr.shareid}">{$modify}</label> <input name="modifyCompanyShare[]" id="modifycompany_{$curr.shareid}" type="checkbox" value="{$curr.modify}" class="crirHiddenJS" {if $curr.modify eq "true"}checked='checked'{/if}/>{/if} <button id='deletecompany_{$curr.shareid}' class="submitBtn deletesharecompany"><span>{$delete}</span></button><br/>
{/foreach}