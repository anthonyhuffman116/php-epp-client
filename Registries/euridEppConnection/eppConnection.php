<?php
namespace Metaregistrar\EPP;
#
# Load the EURID specific additions
#
include_once(dirname(__FILE__) . '/euridEppInfoDomainRequest.php');
include_once(dirname(__FILE__) . '/euridEppInfoDomainResponse.php');

class euridEppConnection extends eppConnection
{

    public function __construct($logging=false)
    {
        parent::__construct($logging);
        $settings = $this->loadSettings(dirname(__FILE__));
        parent::setHostname($settings['hostname']);
        parent::setPort($settings['port']);
        parent::setUsername($settings['userid']);
        parent::setPassword($settings['password']);
        parent::setTimeout(5);
        parent::setLanguage('en');
        parent::setVersion('1.0');
        //parent::enableDnssec();
        parent::setServices(array('urn:ietf:params:xml:ns:domain-1.0'=>'domain','urn:ietf:params:xml:ns:contact-1.0'=>'contact'));
        //parent::addExtension('nsgroup','http://www.eurid.eu/xml/epp/nsgroup-1.1');
        parent::addService('http://www.eurid.eu/xml/epp/registrar-1.0','registrar');
        //parent::addExtension('authInfo','http://www.eurid.eu/xml/epp/authInfo-1.0');
        #parent::addCommandResponse('euridEppCreateNsgroupRequest', 'euridEppCreateNsgroupResponse');
        #parent::addCommandResponse('euridEppCreateRequest', 'euridEppCreateResponse');
        #parent::addCommandResponse('euridEppAuthcodeRequest', 'eppResponse');
        parent::addCommandResponse('Metaregistrar/EPP/euridEppInfoDomainRequest', 'Metaregistrar/EPP/euridEppInfoDomainResponse');
        #parent::addCommandResponse('euridEppCreateRequest', 'eppCreateResponse');
        #parent::addCommandResponse('eppCheckRequest', 'euridEppCheckResponse');
    }

}
