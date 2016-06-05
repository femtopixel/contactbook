{if $ajax eq 0}
<div id='contentAjax'>
  <div id='toolbar'>
    <a href="#" class="lbAction" rel="deactivate">{$closeBox}</a>
  </div>
  <div id='toUpdateLightBox'>
{/if}
  
  
  {if $iscontact eq 1}
    <h1>{$contact}</h1>
    <h2>{$name} {$firstname}</h2>
  {else}
    <h1>{$company}</h1>
    <h2>{$companyname}</h2>
  {/if}
    <span>{$sharedby} :</span> <b>{$mail}</b><br/><br/>
    <button class="submitBtn acceptshare" id='acceptshare_{$id}'><span>{$accept}</span></button>
    <button class="submitBtn refuseshare" id='refuseshare_{$id}'><span>{$refuse}</span></button>
  
  {if $nothing eq 1}
    <span id='reloadall'>&nbsp;</span>
  {/if}
{if $ajax eq 0}
    </div>
</div>
{/if}