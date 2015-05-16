<?php
/**
 * Contains configuration information for connecting to the M2M Service & SQL Database.
 * @author Michael
 */

/* M2M service configurations */
define('M2M_MSISDN', );
define('M2M_USERNAME', '');
define('M2M_PASSWORD', '');
define('WSDL_URI', 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl');

/* SQL database configurations */
define('RDBMS', 'mysql');
define('TEST_DB_NAME', 'circuitboard_test');
define('DB_DATE_FORMAT', 'Y-m-d H:i:s');

/* localhost */
define('DB_HOST', 'localhost');
define('DB_PORT', 8889);
define('DB_USERNAME', 'user');
define('DB_PASSWORD', '');
define('DB_NAME', 'circuitboard_db');

/* misc constants */
define('TIMEZONE', 'UTC'); // Dates and times used by M2MConnect are always in UTC
define('DATE_FORMAT', 'd/m/Y H:i:s');
define('SMS_IDENTIFIER', 'abc123'); // To distinguish our SMS format from others
define('DEBUG_MODE', false); // when enabled will preserve whitespace in html output and add debug nav tab

/* example SMS message */
/*
<id>abc123</id><s1>0</s1><s2>1</s2><s3>0</s3><s4>1</s4><f>0</f><t>38</t><k>5</k>
 */
