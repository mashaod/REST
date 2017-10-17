<?php
define ( 'DB_HOST', 'localhost' );
define ( 'DB_USER', 'user1' );
define ( 'DB_PASSWORD', 'tuser1' );
define ( 'DB_DB', 'user1');
define ( 'FORMAT_RESPONSE', '.json');

/* ERRORs */
define ( 'ERR_000', 'Error conect with DB');
define ( 'ERR_001', 'I don\'t have this method');

/* ERRORs cars */
define ( 'ERR_101', 'Incorrect request SELECT');
define ( 'ERR_102', 'Incorrect params for POST');
define ( 'ERR_103', 'Incorrect request POST');
define ( 'ERR_104', 'Successful request POST');
define ( 'ERR_105', 'Incorrect params for PUT, may be you forgot about id of car?');
define ( 'ERR_106', 'Incorrect request PUT');
define ( 'ERR_107', 'Successful request PUT');
define ( 'ERR_108', 'Incorrect request DELETE');
define ( 'ERR_109', 'Successful request DELETE');
define ( 'ERR_110', 'Incorrect request SELECT BY PARAMS');
define ( 'ERR_111', 'We didn\'t find cars by these params');

/* ERRORs users */
define ( 'ERR_201', 'Incorrect login or password');
define ( 'ERR_202', 'Login reserved');
define ( 'ERR_203', 'Incorrect request POST');
define ( 'ERR_204', 'Successful request POST');
define ( 'ERR_205', 'For operation need login and password');
define ( 'ERR_206', 'Login don\'t exist');
define ( 'ERR_207', 'Wrong password');
define ( 'ERR_208', 'Incorrect request PUT');
define ( 'ERR_209', 'I tried to compare params, but didn\'t get them. Do you have some id or hash?');

/* ERRORs orders */
define ( 'ERR_301', 'Incorrect values id_user or id_car or payment');
define ( 'ERR_302', 'Incorrect request POST order');
define ( 'ERR_303', 'Successful request POST order');
define ( 'ERR_304', 'Incorrect values id_order or status in order');
define ( 'ERR_305', 'Incorrect request PUT order');
define ( 'ERR_306', 'Successful request PUT order');
define ( 'ERR_307', 'Incorrect values id_user for get order');
define ( 'ERR_308', 'Incorrect request for get order');
define ( 'ERR_309', 'We didn\'t find orders by this user');