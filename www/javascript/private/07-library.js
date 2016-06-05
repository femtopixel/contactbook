function test()
{
	alert('Library successfully loaded !');
}

function AjaxLoad(id)
{
	$('#'+id)[0].innerHTML = "<img src='/image/ajaxload.gif' />";
}

function HideContact(id)
{
	if (id != 'user')
	{
		$('#adduser').slideUp("slow").fadeOut("slow");
	}
	else if (id != 'societe')
	{
		$('#addsociete').slideUp("slow").fadeOut("slow");
	}
  /*  new Effect.BlindUp(targetDiv,{duration: 0.5});
  new Effect.Fade(this);*/
}

function ShowContact(id)
{
	if (id == 'user')
	{
		if ($('#adduser')[0].style.display == "none")
		{
			$('#adduser').fadeIn("slow").slideDown("slow");
		}
	}
	else if (id == 'societe')
	{
		if ($('#addsociete')[0].style.display == "none")
		{
			$('#addsociete').fadeIn("slow").slideDown("slow");
		}
	}
	HideContact(id);
}

function Search(term, page)
{
	AjaxLoad('rechercheresult');
	jQuery.post('/ajax/recherche', 'term='+escape(term)+'&page='+page, 
	 function (t)	{
			$('#rechercheresult')[0].innerHTML = t;
			Behaviour.apply(Annuaire_Engine);
		}
	);
}

function Consult(id)
{
	window.location = '/contact/consult/userId/'+id;
}

function Edit(id)
{
	window.location = '/contact/consult/option/edit/userId/'+id;
}

function Delete(id)
{
	window.location = '/contact/consult/option/delete/userId/'+id;
}
function Contactsharelocation(id)
{
	window.location = '/contact/share/userId/'+id;
}

function DeleteSociete(id, type)
{
	jQuery.post('/ajax/deletesociete', 'method='+type+'&id='+id, 
		function (t)
		{
			window.location.reload();
		}
	);
}

function SaveSociete(societeid, id)
{
	jQuery.post('/ajax/modifuser?mode=societe&id='+id, 'societeid='+societeid, 
		function (t)
		{
			window.location.reload();
		}
	);
}

function ShareContact(contactid, myvalue)
{
	jQuery.post('/ajax/addcontactshare', 'value='+escape(myvalue)+"&id="+contactid, 
		function (t) 
		{
      $('#templateadd').fadeOut("slow");
      if (t == 'error')
      {
        alert(getString('errorSharing'));
      }
      else if (t != "ok")
      {
        alert(t);
      }
      else
      {
        UpdateListContact(contactid);
      }
    }
  );
}

function ShareSociete(societeid, myvalue)
{
	jQuery.post('/ajax/addsocieteshare', 'value='+escape(myvalue)+"&id="+societeid, 
		function (t) 
		{
      $('#templateaddcompany').fadeOut("slow");
      if (t == 'error')
      {
        alert(getString('errorSharing'));
      }
      else if (t != "ok")
      {
        alert(t);
      }
      else
      {
        UpdateListSociete(societeid);
      }
    }
  );
}

function UpdateListContact(id)
{
  AjaxLoad('listsharecontact_'+id);
  jQuery.post("/ajax/updatesharecontact", 'id='+id, 
		function (t) 
		{
			$('#listsharecontact_'+id)[0].innerHTML = t;
			crir.init();
			Behaviour.apply(Annuaire_Engine);
    }
  );
}

function UpdateListSociete(id)
{
  AjaxLoad('listsharecompany_'+id);
  jQuery.post("/ajax/updatesharecompany", 'id='+id, 
		function (t) 
		{
			$('#listsharecompany_'+id)[0].innerHTML = t;
			crir.init();
			Behaviour.apply(Annuaire_Engine);
    }
  );
}

function DeleteShare(id, update, idreload)
{
  if (confirm(getString('confirmDeleteShare')))
  {
		jQuery.post('/ajax/deleteshare', 'id='+id, 
			function (t) 
			{
        if (update == "contact")
          UpdateListContact(idreload);
        else if (update == "societe")
          UpdateListSociete(idreload);
        else
          DeleteResultBlock(idreload);
      }
		);
  }
}

function DeleteResultBlock(el)
{
  $(el.parentNode.parentNode).fadeOut("slow", 
      function ()
      {
        el.parentNode.parentNode.parentNode.removeChild(el.parentNode.parentNode);
      }
    );
}

function ModifyShare(id)
{
	jQuery.post('/ajax/modifyshare', 'id='+id);
}

/**
* Get a PHP assigned string
*
* @param	string			Assigned string key
* @return	string			translated text
*/
function					getString(key) {
	if (_gAssignedTexts && _gAssignedTexts[key]) {
		return (_gAssignedTexts[key]);
	}
	return ('');
}

/**
* Sets all Js texts for languages
*
* @param	json			Json stream with all texts translated
*/
function setJsTexts(json)
{
	if (json.length)
	{
		//_gAssignedTexts = new Hash();
		_gAssignedTexts = eval('(' + json + ')');
	}
}