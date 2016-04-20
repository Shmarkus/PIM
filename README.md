##Status
[![Build Status](https://travis-ci.org/Shmarkus/PIM.png)](https://travis-ci.org/Shmarkus/PIM)
[![GitHub version](https://img.shields.io/github/tag/shmarkus/pim.svg)](https://github.com/Shmarkus/PIM)

##When should I use this library?
If You have some kind of e-commerce system that manages orders and You need to match bank transactions with the orders
to determine whether order has been paid or not, then You'd want to use this library!

##How to use
###Prerequisite
This library is composer friendly, so the most convenient way is to get composer (for more info, see https://getcomposer.org)

    curl -sS https://getcomposer.org/installer | php

Then, include the project

    php composer.phar require codehouse/payment-invoice-mapper
    
By now You are ready to clone the library to Your project with the following command

    php composer.phar update
    
Dont forget to include `vendor/autoload.php` in Your bootstrap script, such as index.php

###Usage
When the library is loaded, create a entity class that will hold Your invoices from the system so that it will implement
\Entities\Invoice interface (You can access PIM classes via namespaces now, since Composer did all the heavy lifting).
When the class is ready, create a function that will retrieve all invoices that have not been paid yet and assign them
to Your Invoice object. Since You probably have more than 1 invoice, You have to create ArrayObject of them e.g.

    ...
    $invoices = new ArrayObject();
    while ($item = $query->fetch(PDO::FETCH_ASSOC)) {
        $invoices->append(new YourInvoiceObject($item['amount'], $item['invoiceNo'], $item['orderNo'], $item['referenceNo']))
    }
    ...
    
By this point Your invoices are ready to be mapped, the next step is to get the payments to map with! In this example,
I assume, that user uploads a file that contains the payments from the bank. The uploaded file is in ISO20022 format.
For other formats and sources see section 'Extending'. 

In this example, user posts file from a web page, the file HTML name is import.

    ...
    $mapper = new \Mappers\MapperImpl();
    try {
        $paidInvoices = $mapper->map($invoices, $_FILE['import']['tmp_name'], 'ISO20022');
        updateInvoices($paidInvoices);
    } catch (Exception $e) { .. }
    ...
    
The mapper function returns Payments (see \Entities\Payments) that matched with invoices. In order to update Your invoice
table, You have to take the return value of map() function and update Your table accordingly

##Extending
###Basics
If You have a special kind of file format, create a new Parser to mapper/src/Parsers. It has to extend the 
\Parsers\AbstractParser class and implement \Parsers\Parser interface (see examples like \Parsers\ISO20022Parser).
When Your parser is ready, create new entry to \Parsers\ParserFactoryImpl::getParser() method to register Your new parser 
(add new case statement).
Now You can use Your new parser by passing Your parser name to map() functions third argument!
###Advanced
If the default extractor doesn't cut it for You, You can create new Extractors. This would happen if You need to read
data from a webservice or other source than a file. In this case You'd need to create a new Extractor that implements 
\Extractors\Extractor interface and then register Your new extractor in \Extractors\ExtractorFactoryImpl::getExtractor()
method (add new case statement).
The same thing goes for comparison logic. To use other than default comparison method, create new Comparator that
extends the \Comparators\Comparator interface and register Your new comparator in \Comparators\ComparatorFactoryImpl::getComparator() method

Now You can use Your new extractor and comparator when invoking Mapper object like this:

    ...
    $mapper = new \Mappers\MapperImpl('YourComparatorName', 'YourExtractorName');
    ...

The default comparator is 'IPRNo' and extractor is 'File'

##Component model
![Component diagram](https://github.com/Shmarkus/PIM/blob/master/doc/Components.png "Component diagram")

##Class diagram
![Class diagram](https://github.com/Shmarkus/PIM/blob/master/doc/System.png "Class diagram")

##Sequence diagram
![Sequence diagram](https://github.com/Shmarkus/PIM/blob/master/doc/Sequence.png "Sequence diagram")