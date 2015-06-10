<?php

class dbHosts{

    public $items;

    /**
     *initializes dbHosts
     */
    function Init(){
        if(!file_exists('dbhosts.xml')){
            $xml = new DOMDocument();
            $xml->appendChild($xml->createElement("hosts"));
            $xml->save("dbhosts.xml");
        }

        $this->items = array();

        $xml = new DOMDocument();
        $xml->formatOutput = true;
        $xml->load("dbhosts.xml");

        $hosts = $xml->getElementsByTagName("host");



        for($i = 0;$i < $hosts->length; $i++){

            if($hosts->item($i) == NULL)
                continue;

            $hst = $hosts->item($i);

            $itm = new itemHost();
            $itm->Id = $hst->attributes->getNamedItem("id")->nodeValue;
            $itm->Name = $hst->attributes->getNamedItem("name")->nodeValue;
            $addrss = $hst->childNodes;

            for($j = 0; $j < $addrss->length; $j++){

                $adrs = $addrss->item($j);
                if($adrs == NULL) continue;
                if($adrs->nodeName != "address") continue;

                if(!empty($adrs->nodeValue))
                    $itm->Hosts[] = $adrs->nodeValue;
            }
            $this->items[$itm->Id] = $itm;
        }
    }

    function getEmptyId(){
        for($i = 0; $i < PHP_INT_MAX; $i++){
            if($this->getById($i) == NULL)
                return $i;
        }

        return PHP_INT_MAX;
    }
    function getById($ID){

        foreach($this->items as $itm){
            if($itm->Id == $ID)
                return $itm;
        }

        return NULL;
    }
    function getByName($NAME){

        foreach($this->items as $itm){
            if($itm->Name == $NAME)
                return $itm;
        }

        return NULL;
    }
    function updateItem($itm){

        $itm_id = $this->getById($itm->Id);
        $itm_name = $this->getByName($itm->Name);

        if(empty($itm_id) && !empty($itm_name)){
            return "NAME IN USE! CHOOSE AN EMPTY NAME";
        }

        if(!empty($itm_id) && empty($itm_name)){
            return "INVALID NAME!";
        }

        if(empty($itm_id)){
            $itm->Id = $this->getEmptyId();
        }

        $this->items[$itm->Id] = $itm;
        $this->save();
        return "SUCCESS";
    }
    function removeItem($ID){
        unset($this->items[$ID]);
        $this->save();
    }
    function save(){

        $xml = new DOMDocument();
        $hosts = $xml->createElement("hosts");

        foreach($this->items as $itm){
            $hst = $xml->createElement("host");
            $hst->setAttribute("id", $itm->Id);
            $hst->setAttribute("name", $itm->Name);

            foreach($itm->Hosts as $nAdr){
                if(empty($nAdr))
                    continue;
                $adr = $xml->createElement("address");
                $adr->nodeValue = $nAdr;
                $hst->appendChild($adr);
            }

            $hosts->appendChild($hst);
        }

        $xml->appendChild($hosts);
        $xml->formatOutput = true;
        $xml->save("dbhosts.xml");
    }
}

class itemHost{

    public $Id;
    public $Name;
    public $Hosts = array();

}



































