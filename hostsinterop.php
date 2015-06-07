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
            for($j = 0; $j < $addrss->length; $addrss++){

                $adrs = $addrss->item($j);
                if($adrs == NULL) return;

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

        if($itm_id != NULL && $itm_name != NULL){
            if($itm_id->Id != $itm_name->Id){
                return;
            }

            $this->items[$itm->Id] = $itm;
            $this->save();
            return;
        }

        $itm->Id = $this->getEmptyId();
        $this->items[$itm->Id] = $itm;
        $this->save();
        return;
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


//TESTES
try{
$test = new dbHosts();
$test->Init();

$testItem = new itemHost();
$testItem->Name = "TESTE";
$testItem->Hosts[] = "192.168.1.1";
$testItem->Hosts[] = "192.168.1.2";
$testItem->Hosts[] = "192.168.1.3";

$test->updateItem($testItem);

print_r($test);
echo "<br/>";


$file = new dbHosts();
$file->Init();

print_r($file);
}
catch(Exception $e){
    print_r($e);
    echo "error";
}



































