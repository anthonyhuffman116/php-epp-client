<?php
namespace Metaregistrar\EPP;

class verisignEppCreateDomainRequest extends eppCreateDomainRequest {
    use verisignEppExtension;
    /**
     * verisignEppCreateDomainRequest constructor.
     *
     * @param eppDomain $domain
     */
    public function __construct(eppDomain $domain, string $rnvc=null, string $dnvc=null) {
        parent::__construct($domain);
        //add namestore extension
        $this->addNamestore($domain);
        //add verificationCode extension
        if (!empty($rnvc)){
            $this->addVerificationCode($rnvc, $dnvc);
        }
        $this->addSessionId();
    }
}
