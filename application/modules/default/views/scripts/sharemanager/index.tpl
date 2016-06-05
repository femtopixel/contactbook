<div id='sharemanager'>
  <h1>{$sharemanager}</h1>

  <div id='societesharemanager'>
    <h2>{$whatiamsharing}</h2>
    <h3>{$fullcompany}</h3>
    <div id='globboutcompanies'>
      {foreach from=$globboutcompanies item=curr}
        <div class='blockout'>
          <div class='left'>
            <span class='companyname'>{$curr.SOCIETE_NOM}</span>
          </div>
          <div class='right'>
            <button id='consultshare_{$curr.FIRSTCONTACTID}' class="submitBtn share"><span>{$consult}</span></button>
            <button id='deleteshare_{$curr.SHARE_ID}' class="submitBtn deleteshareresult"><span>{$deleteshare}</span></button>
          </div>
        </div>
      {foreachelse}
        <i>{$nothing}</i>
      {/foreach}
    </div>
    <br/>
    <h3>{$contacts}</h3>
    <div id='globboutcontacts'>
      {foreach from=$globboutcontacts item=curr}
        <div class='blockout'>
          <div class='left'>
            <span class='contactname'>{$curr.CONTACT_NOM} {$curr.CONTACT_PRENOM}</span>
          </div>
          <div class='right'>
            <button id='consultshare_{$curr.CONTACT_ID}' class="submitBtn share"><span>{$consult}</span></button>
            <button id='deleteshare_{$curr.SHARE_ID}' class="submitBtn deleteshareresult"><span>{$deleteshare}</span></button>
          </div>
        </div>
      {foreachelse}
        <i>{$nothing}</i>
      {/foreach}
    </div>
  </div>

  <br/>

  <div id='personnesharemanager'>
    <h2>{$whatissharedwithme}</h2>

    <h3>{$fullcompany}</h3>
    <div id='globbincompanies'>
      {foreach from=$globbincompanies item=curr}
        <div class='blockout'>
          <div class='left'>
            <span class='companyname'>{$curr.SOCIETE_NOM}</span>
            <span class='sharemail'>{$sharedby} : <b>{$curr.USER_MAIL}</b></span>
            <span class='editable'><i>{if $curr.WRITEABLE eq 1}{$editable}{else}{$noteditable}{/if}</i></span>
          </div>
          <div class='right'>
            <button id='deleteshare_{$curr.SHARE_ID}' class="submitBtn deleteshareresult"><span>{$deleteshare}</span></button>
          </div>
        </div>
      {foreachelse}
        <i>{$nothing}</i>
      {/foreach}
    </div>
    <br/>
    <h3>{$contacts}</h3>
    <div id='globbincontacts'>
      {foreach from=$globbincontacts item=curr}
        <div class='blockout'>
          <div class='left'>
            <span class='contactname'>{$curr.CONTACT_NOM} {$curr.CONTACT_PRENOM}</span>
            <span class='sharemail'>{$sharedby} : <b>{$curr.USER_MAIL}</b></span>
            <span class='editable'><i>{if $curr.WRITEABLE eq 1}{$editable}{else}{$noteditable}{/if}</i></span>
          </div>
          <div class='right'>
            <button id='deleteshare_{$curr.SHARE_ID}' class="submitBtn deleteshareresult"><span>{$deleteshare}</span></button>
          </div>
        </div>
      {foreachelse}
        <i>{$nothing}</i>
      {/foreach}
    </div>
  </div>
  
</div>