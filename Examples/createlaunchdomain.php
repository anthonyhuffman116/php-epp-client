<?php

require('../autoloader.php');


/*
 * This sample script registers a domain name within your account
 * 
 * The nameservers of metaregistrar are used as nameservers
 * In this scrips, the same contact id is used for registrant, admin-contact, tech-contact and billing contact
 * Recommended usage is that you use a tech-contact and billing contact of your own, and set registrant and admin-contact to the domain name owner or reseller.
 */


if ($argc <= 1) {
    echo "Usage: createlaunchdomain.php <domainname>\n";
    echo "Please enter the domain name to be created\n\n";
    die();
}

$domainname = $argv[1];

echo "Registering $domainname\n";
try {
    $conn = new Metaregistrar\EPP\metaregEppConnection();
    $conn->setConnectionDetails('');
    // Connect to the EPP server
    if ($conn->login()) {
        $contactid = 'mrg54b6560e01ddf';
        $techcontact = $contactid;
        $billingcontact = $contactid;
        if ($contactid) {
            createdomain($conn, $domainname, $contactid, $contactid, $techcontact, $billingcontact, array('ns1.metaregistrar.nl', 'ns2.metaregistrar.nl'));
        }
        $conn->logout();
    }
} catch (Metaregistrar\EPP\eppException $e) {
        echo "ERROR: " . $e->getMessage() . "\n\n";
}


/**
 * @param $conn Metaregistrar\EPP\eppConnection
 * @param $domainname string
 * @param $registrant string
 * @param $admincontact string
 * @param $techcontact string
 * @param $billingcontact string
 * @param $nameservers array
 * @return bool
 */
function createdomain($conn, $domainname, $registrant, $admincontact, $techcontact, $billingcontact, $nameservers) {
    $domain = new Metaregistrar\EPP\eppDomain($domainname, $registrant);
    $reg = new Metaregistrar\EPP\eppContactHandle($registrant);
    $domain->setRegistrant($reg);
    $admin = new Metaregistrar\EPP\eppContactHandle($admincontact, Metaregistrar\EPP\eppContactHandle::CONTACT_TYPE_ADMIN);
    $domain->addContact($admin);
    $tech = new Metaregistrar\EPP\eppContactHandle($techcontact, Metaregistrar\EPP\eppContactHandle::CONTACT_TYPE_TECH);
    $domain->addContact($tech);
    $billing = new Metaregistrar\EPP\eppContactHandle($billingcontact, Metaregistrar\EPP\eppContactHandle::CONTACT_TYPE_BILLING);
    $domain->addContact($billing);
    $domain->setAuthorisationCode($domain->generateRandomString(12));
    if (is_array($nameservers)) {
        foreach ($nameservers as $nameserver) {
            $host = new Metaregistrar\EPP\eppHost($nameserver);
            $domain->addHost($host);
        }
    }
    $create = new Metaregistrar\EPP\eppLaunchCreateDomainRequest($domain);
    $create->setLaunchPhase('claims', 'application');
    if ((($response = $conn->writeandread($create)) instanceof Metaregistrar\EPP\eppLaunchCreateDomainResponse) && ($response->Success())) {
        /* @var Metaregistrar\EPP\eppLaunchCreateDomainResponse $response */
        echo "Domain " . $response->getDomainName() . " created on " . $response->getDomainCreateDate() . ", expiration date is " . $response->getDomainExpirationDate() . "\n";
        echo "Registration phase: " . $response->getLaunchPhase() . " and Application ID: " . $response->getLaunchApplicationID() . "\n";
    } else {
        var_dump($response);
    }
return null;
}
