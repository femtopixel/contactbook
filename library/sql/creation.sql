/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  28/07/2008 21:35:02                      */
/*==============================================================*/

CREATE USER 'contactbook'@'%' IDENTIFIED BY 'kI(_mRFp';

GRANT USAGE ON * . * TO 'contactbook'@'%' IDENTIFIED BY 'kI(_mRFp' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

CREATE DATABASE IF NOT EXISTS `contactbook` ;

GRANT ALL PRIVILEGES ON `contactbook` . * TO 'contactbook'@'%';

USE `contactbook`;

--
-- Structure de la table `annuaire_contact`
--

CREATE TABLE IF NOT EXISTS `ANNUAIRE_CONTACT` (
  `CONTACT_ID` bigint(20) NOT NULL auto_increment,
  `SOCIETE_ID` bigint(20) NOT NULL,
  `CONTACT_NOM` varchar(30) default NULL,
  `CONTACT_PRENOM` varchar(30) default NULL,
  `CONTACT_ADRESSE` longtext,
  `CONTACT_MAIL` varchar(50) default NULL,
  `CONTACT_NUMERO` varchar(20) default NULL,
  `CONTACT_PORTABLE` varchar(20) default NULL,
  `CONTACT_COMMENTAIRE` longtext,
  `CONTACT_FAX` varchar(20) default NULL,
  `CONTACT_SITE` varchar(40) default NULL,
  `USER_ID` bigint(20) NOT NULL,
  PRIMARY KEY  (`CONTACT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `annuaire_contact`
--


-- --------------------------------------------------------

--
-- Structure de la table `annuaire_share`
--

CREATE TABLE IF NOT EXISTS `ANNUAIRE_SHARE` (
  `SHARE_ID` bigint(20) NOT NULL auto_increment,
  `USER_ID` bigint(20) NOT NULL,
  `SOCIETE_ID` bigint(20) default NULL,
  `CONTACT_ID` bigint(20) default NULL,
  `WRITEABLE` tinyint(1) NOT NULL,
  `ACCEPTED` tinyint(1) NOT NULL,
  PRIMARY KEY  (`SHARE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `annuaire_share`
--


-- --------------------------------------------------------

--
-- Structure de la table `annuaire_societe`
--

CREATE TABLE IF NOT EXISTS `ANNUAIRE_SOCIETE` (
  `SOCIETE_ID` bigint(20) NOT NULL auto_increment,
  `SOCIETE_NOM` varchar(30) default NULL,
  `SOCIETE_ADRESSE` longtext,
  `SOCIETE_NUMERO` varchar(20) default NULL,
  `SOCIETE_ACTIVITE` mediumtext,
  `SOCIETE_FAX` varchar(20) default NULL,
  `SOCIETE_SITE` varchar(40) default NULL,
  `USER_ID` bigint(20) NOT NULL,
  PRIMARY KEY  (`SOCIETE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `annuaire_societe`
--


-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `ANNUAIRE_USER` (
  `USER_ID` bigint(20) NOT NULL auto_increment,
  `USER_MAIL` varchar(200) NOT NULL,
  `USER_NAME` varchar(200) NOT NULL,
  `USER_FIRSTNAME` varchar(200) NOT NULL,
  `USER_PASSWORD` varchar(50) NOT NULL,
  `USER_IP` varchar(15) NOT NULL,
  `USER_SECRET` varchar(32) NOT NULL,
  `USER_LOGIN` varchar(200) NOT NULL,
  `USER_ACTIVE` varchar(1) NOT NULL,
  `USER_DELETED` bigint(20) default NULL,
  PRIMARY KEY  (`USER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `user`
--
