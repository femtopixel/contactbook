<?php
/**
 * Search Engine Ajax processed
 *
 */
class Ajax_RechercheController extends Zend_Controller_Action {

	protected function _setAnswer($message) {
		$response = $this->getResponse();
		$response->clearBody();
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$response->setBody($message);
	}
	/**
	 * Default action called by AjaxController
	 *
	 * Match the posted ID to the right action to do
	 */
	public function indexAction() {
		$this->view->setLayout ( 'default' );
		$this->view->setCacheLife(0);
		$recherche = new Annuaire_Recherche($_POST['term']);
		$recherche->setLimit(5);
		$result = $recherche->go((int)$_POST['page']);
		$return = Array();
		foreach($result as $info) {
			$contact = new Annuaire_Contact($info['CONTACT_ID']);
			$temp = new Annuaire_User($contact->getUserId());
			$return[$info['CONTACT_ID']][0] = $info['CONTACT_ID'];
			$return[$info['CONTACT_ID']][1] = ($info['SOCIETE_NOM'] == "") ? t_('(none)') : $info['SOCIETE_NOM'];
			$return[$info['CONTACT_ID']][2] = $info['CONTACT_NOM'];
			$return[$info['CONTACT_ID']][3] = $info['CONTACT_PRENOM'];
			$return[$info['CONTACT_ID']][4] = $info['CONTACT_NUMERO'];
			$return[$info['CONTACT_ID']][5] = $info['CONTACT_MAIL'];
			$return[$info['CONTACT_ID']]['share'] = isset($info['WRITEABLE']) ? 1 : 0;
			$return[$info['CONTACT_ID']]['shareid'] = $info['SHARE_ID'];
			$return[$info['CONTACT_ID']]['writeable'] = isset($info['WRITEABLE']) ? $info['WRITEABLE'] : 1;	
			$return[$info['CONTACT_ID']]['sharedby'] = isset($info['WRITEABLE']) ? $temp->getMail() : 0;
		}
		
		$pagine = '<div id="pagination">';
		
		/* pagination */
		$term = addslashes($_POST['term']);
		$_POST['page'] = (int) $_POST['page'];
		if ($_POST['page'] > 1) {
			$pagine .= "<a href=\"javascript:void(0);\" onclick=\"Search('{$term}', ".($_POST['page'] - 1).");\"><</a>";
		}
		for ($i = ($_POST['page'] - 6); $i <= ($_POST['page'] + 6); $i++) {
			if ($i >= 1 && $i <= $recherche->getNbPage()) {
				$pagine .= "<a href=\"javascript:void(0);\" onclick=\"Search('{$term}', $i);\" ";
				$pagine .= ($_POST['page'] == $i) ? 'class="thispage"' : '';
				$pagine .= ">$i</a>";
			}
		}
		if ($_POST['page'] < $recherche->getNbPage()) {
			$pagine .= "<a href=\"javascript:void(0);\" onclick=\"Search('{$term}', ".($_POST['page'] + 1).");\">></a>";
		}

		$pagine .= '</div>';

		if (!count($result)) {
			$pagine = "<div id='pagine'>".t_('No result for this search...')."</div>";
		}

		$this->view->result = $return;
		$this->view->pagine = ($pagine);
		$this->view->companie = t_('Company');
		$this->view->sharedby = t_('Shared by');
		$this->view->name = (t_('Name'));
		$this->view->firstname = t_('Firstname');
		$this->view->phone = t_('Phone Number');
		$this->view->mail = t_('Mail');
		$this->view->consult = t_('Consult');
		$this->view->edit = t_('Edit');
		$this->view->delete = t_('Delete');
		$this->view->share = t_('Share');
		$this->view->deleteshare = t_('Delete share');
		$this->view->useShare = Zend_Registry::getInstance()->config->use_share;
	}
}