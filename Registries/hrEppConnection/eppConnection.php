<?php
namespace Metaregistrar\EPP;

class hrEppConnection extends eppConnection {
    public function __construct($logging = false) {
        parent::__construct($logging);
        if ($settings = $this->loadSettings(dirname(__FILE__))) {
            parent::setHostname($settings['hostname']);
            parent::setPort($settings['port']);
            parent::setUsername($settings['userid']);
            parent::setPassword($settings['password']);
        }
        parent::setTimeout(5);
        parent::setLanguage('en');
        parent::setVersion('1.0');
        parent::setServices(array('urn:ietf:params:xml:ns:domain-1.0' => 'domain', 'urn:ietf:params:xml:ns:contact-1.0' => 'contact'));
        parent::addExtension('hr', 'http://www.dns.hr/epp/hr-1.0');
        parent::addCommandResponse('Metaregistrar\EPP\hrEppInfoContactRequest', 'Metaregistrar\EPP\hrEppInfoContactResponse');
//      parent::enableDnssec();
    }
}
