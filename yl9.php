<?php
    class Auto {
        var $varv;
        var $tootja;
        var $kiirus = 0;

        function kiirendus() {
            while ($this->kiirus < 100) {
                $this->kiirus += 10;
                echo "kiirus: ".$this->kiirus . "<br>";
            } 
            if ($this->kiirus >=100) {
                echo "kiirus 100";
            }
            }
        function autokirjeldus() {
            echo 'Minu uus '. $this->tootja .' on '. $this->varv. "." . "<br>";
        }
    }

    $auto1 = new Auto;
    $auto1->varv = 'punane';
    $auto1->tootja = 'audi';
    $auto1->autokirjeldus();
    $auto1->kiirendus();
?>
