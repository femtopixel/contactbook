<div id='partagercontact'>
  {if $societeid neq 0}
    <div id="societe">
      <h1>{$sharesociete}</h1>
      <h2>{$companyname}</h2>
      <div id='listsharecompany_{$societeid}'>
        <span id='listcompany_{$societeid}' class='listsharecompany'></span>
      </div>
      <div id='templateaddcompany'>
        <form method='post' action='javascript:void(0);' id='submitsharecompanyform_{$societeid}' class='submitsharecompanyform'>
          <input type='text' id='addedvaluecompany'/>
        </form>
        <button id='submitsharecompany_{$societeid}' class="submitBtn submitsharecompanybutton"><span>{$send}</span></button><button id='cancelsharecompany' class="submitBtn"><span>{$cancel}</span></button>
      </div>
      {if $admin eq 1}<button id='addsharecompany' class="submitBtn"><span>{$addshare}</span></button>{/if}
    </div>
    <br/>
  {/if}
  	<div id="personne">
      <h1>{$sharecontact}</h1>
      <h2>{$nom} {$prenom}</h2>
      <div id='listsharecontact_{$id}'>
        <span id='list_{$id}' class='listsharecontact'></span>
      </div>
      <div id='templateadd'>
        <form method='post' action='javascript:void(0);' id='submitsharecontactform_{$id}' class='submitsharecontactform'>
          <input type='text' id='addedvalue'/>
        </form>
        <button id='submitsharecontact_{$id}' class="submitBtn submitsharecontactbutton"><span>{$send}</span></button><button id='cancelsharecontact' class="submitBtn"><span>{$cancel}</span></button>
      </div>
      {if $admin eq 1}<button id='addshare' class="submitBtn"><span>{$addshare}</span></button>{/if}
    </div>
</div>