<h1><a href='javascript:void(0);' id='ajoutecontact'>{$addcontact}</a></h1><br/>
<div id='adduser'>
  <form action='/post/adduser' method='post' id='adduserform'>
    <div>
      <span>{$name} : </span><input type='text' name='nom' /><br/>
      <span>{$firstname} : </span><input type='text' name='prenom' /><br/>
      <span>{$address} : </span><textarea name='adresse' rows='5' cols="20"></textarea><br/>
      <span>{$mail} : </span><input type='text' name='mail' /><br/>
      <span>{$phone} : </span><input type='text' name='numero' /><br/>
      <span>{$cell} : </span><input type='text' name='portable' /><br/>
      <span>{$fax} : </span><input type='text' name='fax' /><br/>
      <span>{$site} : </span><input type='text' name='site' /><br/>
      <span>{$comment} : </span><textarea name='commentaire' rows='5' cols="20"></textarea><br/>
      <span>{$society} : </span>
      <select name='societe'>
        <option value='0'>{$none}</option>
        {foreach from=$clients item=curr_id}
          <option value='{$curr_id[0]}'>{$curr_id[1]}</option>
        {/foreach}
      </select>
      <br/>
      <br/>
      <input type='submit' value='Envoyer' class="hidden"/>
      <button value="input" id='submit_adduserform' class="submitBtn submitForm"><span>{$send}</span></button>
     </div>
  </form>
</div>
<h1><a href='javascript:void(0);' id='ajoutesociete'>{$addsociety}</a></h1><br/>
<div id='addsociete'>
  <form action='/post/addsociete' method='post' id='addsocieteform'>
    <div>
      <span>{$name} : </span><input type='text' name='nom' /><br/>
      <span>{$address} : </span><textarea name='adresse' rows='5' cols="20"></textarea><br/>
      <span>{$phone} : </span><input type='text' name='numero' /><br/>
      <span>{$fax} : </span><input type='text' name='fax' /><br/>
      <span>{$site} : </span><input type='text' name='site' /><br/>
      <span>{$activity} : </span><textarea name='activite' rows='5' cols="20"></textarea><br/>
      <br/>
      <input type='submit' value='Envoyer' class='hidden'/>
      <button value="input" id='submit_addsocieteform' class="submitBtn submitForm"><span>{$send}</span></button>
    </div>
  </form>
</div>