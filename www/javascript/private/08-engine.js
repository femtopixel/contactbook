Annuaire_Engine = {
  '#ajoutecontact' : function (el) {
    el.onclick = function ()
    {
      ShowContact('user');
    };
    $('#adduser')[0].style.display = 'none';
  }, 
  
  '#ajoutesociete' : function (el) {
    el.onclick = function ()
    {
      ShowContact('societe');
    };
     $('#addsociete')[0].style.display = 'none';
  },
  
  '.societeid' : function (el) {
    el.onchange = function () {
      SaveSociete(el.value, Annuaire_Engine.getIdFromText(el.id));
    };
  },
  
  '.goback' : function (el) {
    el.onclick = function ()
    {
      history.go(-1);
    };
  },
  
  '.listsharecontact' : function (el) {
    UpdateListContact(Annuaire_Engine.getIdFromText(el.id));
  },
  
  '.listsharecompany' : function (el) {
    UpdateListSociete(Annuaire_Engine.getIdFromText(el.id));
  },
  
  '#deleteonlysociety' : function (el) {
    el.onclick = function () {
      DeleteSociete($('#societeid')[0].value, 'only');
    };
  },
  
  '#deleteallsociety' : function (el) {
    el.onclick = function () {
      DeleteSociete($('#societeid')[0].value, 'all');
    };
  }, 
  
  '#searchform' : function (el) {
    el.onsubmit = function () {
      Search($('#term')[0].value, 1);
    };
  },
  
  "#submit_searchform" : function (el) {
    el.onclick = function () {
      Search($('#term')[0].value, 1);
    };
  },
  
  '.consult' : function (el) {
    el.onclick = function () {
      Consult(Annuaire_Engine.getIdFromText(el.id));
    };
  },
  
  '.edit' : function (el) {
    el.onclick = function () {
      Edit(Annuaire_Engine.getIdFromText(el.id));
    };
  },
  
  '.delete' : function (el) {
    el.onclick = function () {
      Delete(Annuaire_Engine.getIdFromText(el.id));
    };
  },
  '.share' : function (el) {
    el.onclick = function () {
      Contactsharelocation(Annuaire_Engine.getIdFromText(el.id));
    };
  },
  
  '#addshare' : function (el) {
    el.onclick = function () {
      $('#addedvalue')[0].value = '';
      $('#templateadd').fadeIn("slow");
    };
  },
  
  '#addsharecompany' : function (el) {
    el.onclick = function () {
      $('#addedvaluecompany')[0].value = '';
      $('#templateaddcompany').fadeIn("slow");
    };
  },
  
  '#cancelsharecontact' : function (el) {
    el.onclick = function () {
      $('#addedvalue')[0].value = '';
      $('#templateadd').fadeOut("slow");
    };
  },
  
  '#cancelsharecompany' : function (el) {
    el.onclick = function () {
      $('#addedvaluecompany')[0].value = '';
      $('#templateaddcompany').fadeOut("slow");
    };
  },
  
  '#templateadd' : function (el) {
    el.style.display = "none";
  },
  
  '#templateaddcompany' : function (el) {
    el.style.display = "none";
  },
  
  '.submitsharecontactbutton' : function (el) {
    el.onclick = function () {
      ShareContact(Annuaire_Engine.getIdFromText(el.id), $('#addedvalue')[0].value);
    };
  },
  
  '.submitsharecompanybutton' : function (el) {
    el.onclick = function () {
      ShareSociete(Annuaire_Engine.getIdFromText(el.id), $('#addedvaluecompany')[0].value);
    };
  },
  
  '.submitsharecontactform' : function (el) {
    el.onsubmit = function () {
      ShareContact(Annuaire_Engine.getIdFromText(el.id), $('#addedvalue')[0].value);
    };
  },
  
  '#personne input' : function (el) {
     if(el.name == "modifyContactShare[]")
     {
      el.onchange = function (t)
      {
        ModifyShare(Annuaire_Engine.getIdFromText(el.id));
      };
     }
  },
  
  '#societe input' : function (el) {
     if(el.name == "modifyCompanyShare[]")
     {
      el.onchange = function (t)
      {
        ModifyShare(Annuaire_Engine.getIdFromText(el.id));
      };
     }
  },
  
  '.deletesharecontact' : function (el) {
    el.onclick = function () {
      if (typeof($('.submitsharecontactform')[0]) != 'undefined')
         DeleteShare(Annuaire_Engine.getIdFromText(el.id), 'contact', Annuaire_Engine.getIdFromText($('.submitsharecontactform')[0].id));
    };
  },
  
  '.deleteshareresult' : function (el) {
    el.onclick = function () {
       DeleteShare(Annuaire_Engine.getIdFromText(el.id), 'result', el);
    };
  },
  
  '#showNewShare' : function (el) {
    el.onclick = function () {
      //Modalbox.show("/ajax/share", {title: 'el.title'});
      el.blur();
      Modalbox.show(el.href, {title: 'ShareBox', width: 600});
      return false;
    };
  },
  
  '.acceptshare' : function (el) {
    el.onclick = function () {
			jQuery.post('/ajax/acceptshare', 'id='+Annuaire_Engine.getIdFromText(el.id)+"&action=accept",
				function (t)
				{
            AjaxLoad('toUpdateLightBox');
            jQuery.post('/ajax/share?ajax', '', 
							function (t)
							{
								$('#TB_ajaxContent')[0].innerHTML = t;
								Behaviour.apply(Annuaire_Engine);
							}
						);
				}
			);
    };
  },
  
  '.refuseshare' : function (el) {
    el.onclick = function () {
				jQuery.post('/ajax/acceptshare', 'id='+Annuaire_Engine.getIdFromText(el.id)+"&action=decline", 
					function (t)
					{
							AjaxLoad('toUpdateLightBox');
							jQuery.post('/ajax/share?ajax', '', 
								function (t)
								{
									$('#TB_ajaxContent')[0].innerHTML = t;
									Behaviour.apply(Annuaire_Engine);
								}
							);
					}
				);
    };
  },
  
  '#reloadall' : function (el) {
    AjaxLoad('toUpdateLightBox');
    window.location.reload();
  },
    
  getIdFromText : function(text) {
    var		regexp = /^\w+_(\d+)$/;

    if (found = regexp.exec(text)) {
      return(Number(found[1]));
    }
    return(false);
  },
  
  getMiddleIdFromText : function(text) {
    var		regexp = /^\w+_(\d+)_\d+$/;

    if (found = regexp.exec(text)) {
      return(Number(found[1]));
    }
    return(false);
  }
};

Behaviour.register(Annuaire_Engine);