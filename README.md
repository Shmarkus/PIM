Staatus
========================
[![Build Status](https://travis-ci.org/Shmarkus/PIM.png)](https://travis-ci.org/Shmarkus/PIM)

Kasutamine
========================
Lae projekt composeriga külge
Loo oma projekti andmetüüp, mis implementeerib interface, mille leiab \Entities\Invoice 
Loe süsteemist arved, mille tasumist on vaja kontrollida
Lisa iga arve loodud andmetüübina ArrayObject massiivi

Käivita \Mappers\MapperImpl::map() funktsioon, esimese parameetrina anna eelnevalt loodud ArrayObject, teise parameetrina
teekond sisendandmestikuni (failini) ning viimase parameetrina parseri nimi (parser oskab faili tõlgendada).

Laiendamine
-----------------------
Hetkel võimalikud parseri nimetused on: ISO20022 ja TH6. Parsereid võib juurde luua. Iga parser peab laiendama 
\Parsers\AbstractParser klassi ja implementeerima Parser interfeissi. Peale parseri loomist tuleb selle nimi registreerida
\Parsers\ParserFactory::getParser() meetodis.

Põhimõtteliselt on võimalik realiseerida ka Extractoreid, juhul kui sisendandmestik on muul kujul kui fail. Extractori
lisamisel peab loodav klass laiendama \Extractors\AbstractParser ja implementeerima \Extractors\Extractor interfeissi. 

Arhitektuur
========================
Süsteem koosneb järgmistest kihtidest: 
 - Mapper, mille eesmärgiks on andmete lugemine andmeallikast ja nende võrdlemine ette antud arvemassiiviga
 - Extractor, mille eesmärgiks on andmeallikast maksete sisselugemine töötlemata kujul
 - ParserFactory, mille eesmärgiks on tagastada õige parser vastavalt failile
 - Parser, mille eesmärgiks on töötlemata kujul andmete konverteerimine makseteks