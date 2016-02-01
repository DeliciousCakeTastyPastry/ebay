<?php

$ApiKey = "$argv[1]";
$DomainName = "$argv[2]";
$FN = "Black";
$LN = "Hat Computers";
$ADDR = "P.O. Box 9000";
$City = "Simi Valley";
$State = "CA";
$Postal = "90210";
$Country = "US";
$Phone = "1.555.555.5555";
$Email = "internetsupervillian@gmail.com";

$url = "https://api.namecheap.com/xml.response?ApiUser=blackhatcomputers&ApiKey=$ApiKey&UserName=blackhatcomputers&Command=namecheap.domains.create&ClientIp=45.33.75.113&Years=1&RegistrantFirstName=$FN&RegistrantLastName=$LN&RegistrantAddress1=$ADDR&RegistrantCity=$City&RegistrantStateProvince=$State&RegistrantPostalCode=$Postal&RegistrantCountry=$Country&RegistrantPhone=$Phone&RegistrantEmailAddress=$Email&TechFirstName=$FN&TechLastName=$LN&TechAddress1=$ADDR&TechCity=$City&TechStateProvince=$State&TechPostalCode=$Postal&TechCountry=$Country&TechPhone=$Phone&TechEmailAddress=$Email&AdminFirstName=$FN&AdminLastName=$LN&AdminAddress1=$ADDR&AdminCity=$City&AdminStateProvince=$State&AdminPostalCode=$Postal&AdminCountry=$Country&AdminPhone=$Phone&AdminEmailAddress=$Email&AuxBillingFirstName=$FN&AuxBillingLastName=$LN&AuxBillingAddress1=$ADDR&AuxBillingCity=$City&AuxBillingStateProvince=$State&AuxBillingPostalCode=$Postal&AuxBillingCountry=$Country&AuxBillingPhone=$Phone&AuxBillingEmailAddress=$Email&Nameservers=ns1.linode.com,ns2.linode.com&AddFreeWhoisguard=yes&WGEnabled=yes&DomainName=$DomainName";

echo $url;
?>
