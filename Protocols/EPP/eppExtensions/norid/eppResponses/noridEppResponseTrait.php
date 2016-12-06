<?php
namespace Metaregistrar\EPP;

trait noridEppResponseTrait {

    public function getExtConditions($xpath) {
        $result = $xpath->query('/epp:epp/epp:response/epp:extension/no-ext-result:conditions/no-ext-result:condition');
        if (is_object($result) && ($result->length > 0)) {
            return array_map(function($element) {
                return array(
                    'code' => $element->getAttribute('code'),
                    'severity' => $element->getAttribute('severity'),
                    'message' => $element->getElementsByTagName('msg')->item(0)->nodeValue,
                    'details' => $element->getElementsByTagName('details')->item(0)->nodeValue
                );
            }, $result);
        } else {
            return null;
        }
    }

    public function getExtServiceMessages($xpath) {
        $result = $xpath->query('/epp:epp/epp:response/epp:resData/no-ext-result:message');
        if (is_object($result) && ($result->length > 0)) {
            return array_map(function($element) {
                return array(
                    'type' => $element->getAttribute('type'),
                    'description' => $element->getElementsByTagName('desc')->item(0)->nodeValue,
                    'data' => $element->getElementsByTagName('data')->item(0)
                );
            }, $result);
        } else {
            return null;
        }
    }

}