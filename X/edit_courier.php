UPDATE `courier` SET `TTT` = '' WHERE `TTT` = '00.0';
UPDATE `courier` SET `TTT` = '' WHERE `TTT` LIKE "%..%";
UPDATE `courier` SET `TTT` = CONCAT(`TTT`,'0') WHERE LENGTH(`TTT`) = 3 AND `TTT` LIKE "%.";
UPDATE `courier` SET `TTT` = CONCAT(SUBSTRING(`TTT`, 1, 2),'.',SUBSTRING(`TTT`, 3, 1)) WHERE LENGTH(`TTT`) = 4 AND `TTT` LIKE "%.";
UPDATE `courier` SET `TTT` = CONCAT('0',`TTT`) WHERE LENGTH(`TTT`) = 3 AND `TTT` LIKE "%.%";
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `VP` = '' WHERE `VP` = '00.0';
UPDATE `courier` SET `VP` = '' WHERE `VP` LIKE "%..%";
UPDATE `courier` SET `VP` = CONCAT(`VP`,'0') WHERE LENGTH(`VP`) = 3 AND `VP` LIKE "%.";
UPDATE `courier` SET `VP` = CONCAT(SUBSTRING(`VP`, 1, 2),'.',SUBSTRING(`VP`, 3, 1)) WHERE LENGTH(`VP`) = 4 AND `VP` LIKE "%.";
UPDATE `courier` SET `VP` = CONCAT('0',`VP`) WHERE LENGTH(`VP`) = 3 AND `VP` LIKE "%.%";
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `TDTDTD` = '' WHERE `TDTDTD` = '00.0';
UPDATE `courier` SET `TDTDTD` = '' WHERE `TDTDTD` LIKE "%..%";
UPDATE `courier` SET `TDTDTD` = CONCAT(`TDTDTD`,'0') WHERE LENGTH(`TDTDTD`) = 3 AND `TDTDTD` LIKE "%.";
UPDATE `courier` SET `TDTDTD` = CONCAT(SUBSTRING(`TDTDTD`, 1, 2),'.',SUBSTRING(`TDTDTD`, 3, 1)) WHERE LENGTH(`TDTDTD`) = 4 AND `TDTDTD` LIKE "%.";
UPDATE `courier` SET `TDTDTD` = CONCAT('0',`TDTDTD`) WHERE LENGTH(`TDTDTD`) = 3 AND `TDTDTD` LIKE "%.%";
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `TNTNTN` = '' WHERE `TNTNTN` = '00.0';
UPDATE `courier` SET `TNTNTN` = '' WHERE `TNTNTN` LIKE "%..%";
UPDATE `courier` SET `TNTNTN` = CONCAT(`TNTNTN`,'0') WHERE LENGTH(`TNTNTN`) = 3 AND `TNTNTN` LIKE "%.";
UPDATE `courier` SET `TNTNTN` = CONCAT(SUBSTRING(`TNTNTN`, 1, 2),'.',SUBSTRING(`TNTNTN`, 3, 1)) WHERE LENGTH(`TNTNTN`) = 4 AND `TNTNTN` LIKE "%.";
UPDATE `courier` SET `TNTNTN` = CONCAT('0',`TNTNTN`) WHERE LENGTH(`TNTNTN`) = 3 AND `TNTNTN` LIKE "%.%";
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `SN1` = '+' WHERE `SN1` = '0';
UPDATE `courier` SET `SN1` = '-' WHERE `SN1` = '1';
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `SN2` = '+' WHERE `SN2` = '0';
UPDATE `courier` SET `SN2` = '-' WHERE `SN2` = '1';
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `SN3` = '+' WHERE `SN3` = '0';
UPDATE `courier` SET `SN3` = '-' WHERE `SN3` = '1';
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `WB` = REPLACE(`WB`, '+', '') WHERE `WB` LIKE "%+%";
UPDATE `courier` SET `WB` = REPLACE(`WB`, '--', '-') WHERE `WB` LIKE "%--%";
UPDATE `courier` SET `WB` = REPLACE(`WB`, '..', '.') WHERE `WB` LIKE "%..%";
UPDATE `courier` SET `WB` = '' WHERE `WB` = '00.0' OR `WB` = '-00.0';
UPDATE `courier` SET `WB` = CONCAT(`WB`,'0') WHERE `WB` NOT LIKE "%-%" AND LENGTH(`WB`) = 3 AND `WB` LIKE "%.";
UPDATE `courier` SET `WB` = CONCAT(SUBSTRING(`WB`, 1, 2),'.',SUBSTRING(`WB`, 3, 1)) WHERE `WB` NOT LIKE "%-%" AND LENGTH(`WB`) = 4 AND `WB` LIKE "%.";
UPDATE `courier` SET `WB` = CONCAT('0',`WB`) WHERE `WB` NOT LIKE "%-%" AND LENGTH(`WB`) = 3 AND `WB` LIKE "%.%";
UPDATE `courier` SET `WB` = CONCAT(SUBSTRING(`WB`, 1, 3),'.',SUBSTRING(`WB`, 4, 1)) WHERE `WB` LIKE "-%" AND LENGTH(`WB`) = 5 AND `WB` LIKE "%.";
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `RH` = REPLACE(`RH`, '+', '');
UPDATE `courier` SET `RH` = REPLACE(`RH`, '.', '');
UPDATE `courier` SET `RH` = REPLACE(`RH`, '-', '');
UPDATE `courier` SET `RH` = CONCAT('0',`RH`) WHERE LENGTH(`RH`) = 1;
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `WW` = REPLACE(`WW`, '+', '');
UPDATE `courier` SET `WW` = REPLACE(`WW`, '.', '');
UPDATE `courier` SET `WW` = REPLACE(`WW`, '-', '');
UPDATE `courier` SET `WW` = CONCAT('0',`WW`) WHERE LENGTH(`WW`) = 1;
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `W1W2` = REPLACE(`W1W2`, '+', '');
UPDATE `courier` SET `W1W2` = REPLACE(`W1W2`, '.', '');
UPDATE `courier` SET `W1W2` = REPLACE(`W1W2`, '-', '');
UPDATE `courier` SET `W1W2` = CONCAT('0',`W1W2`) WHERE LENGTH(`W1W2`) = 1;
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `VV` = REPLACE(`VV`, '+', '');
UPDATE `courier` SET `VV` = REPLACE(`VV`, '.', '');
UPDATE `courier` SET `VV` = REPLACE(`VV`, '-', '');
UPDATE `courier` SET `VV` = CONCAT('0',`VV`) WHERE LENGTH(`VV`) = 1;
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `time` = REPLACE(`time`, '+', '');
UPDATE `courier` SET `time` = REPLACE(`time`, '.', '');
UPDATE `courier` SET `time` = REPLACE(`time`, '-', '');
UPDATE `courier` SET `time` = CONCAT('0',`time`) WHERE LENGTH(`time`) = 1;
DELETE FROM `courier` WHERE LENGTH(`time`) != 2;
/* --------------------------------------------------------------------------------------------------------------------------------------- */
DELETE FROM `courier` WHERE `date` = '0000-00-00';
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `DD` = REPLACE(`DD`, '+', '');
UPDATE `courier` SET `DD` = REPLACE(`DD`, '.', '');
UPDATE `courier` SET `DD` = REPLACE(`DD`, '-', '');
UPDATE `courier` SET `DD` = CONCAT('00',`DD`) WHERE LENGTH(`DD`) = 1;
UPDATE `courier` SET `DD` = CONCAT('0',`DD`) WHERE LENGTH(`DD`) = 2;
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `FF` = REPLACE(`FF`, '+', '');
UPDATE `courier` SET `FF` = REPLACE(`FF`, '.', '');
UPDATE `courier` SET `FF` = REPLACE(`FF`, '-', '');
UPDATE `courier` SET `FF` = CONCAT('0',`FF`) WHERE LENGTH(`FF`) = 1;
UPDATE `courier` SET `FF` = '03' WHERE `FF` = '30';
UPDATE `courier` SET `FF` = '04' WHERE `FF` = '40';
UPDATE `courier` SET `FF` = '05' WHERE `FF` = '50';
UPDATE `courier` SET `FF` = '06' WHERE `FF` = '60';
UPDATE `courier` SET `FF` = '07' WHERE `FF` = '70';
UPDATE `courier` SET `FF` = '08' WHERE `FF` = '80';
UPDATE `courier` SET `FF` = '09' WHERE `FF` = '90';
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `PPP` = REPLACE(`PPP`, '+', '');
UPDATE `courier` SET `PPP` = REPLACE(`PPP`, '.', '');
UPDATE `courier` SET `PPP` = REPLACE(`PPP`, '-', '');
UPDATE `courier` SET `PPP` = CONCAT('00',`PPP`) WHERE LENGTH(`PPP`) = 1;
UPDATE `courier` SET `PPP` = CONCAT('0',`PPP`) WHERE LENGTH(`PPP`) = 2;
UPDATE `courier` SET `PPP` = '' WHERE `PPP` = '///' OR `PPP` = 'Xxx';
UPDATE `courier` SET `PPP` = '000' WHERE `PPP` != '' AND CAST(`PPP` AS SIGNED) > 70;
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `PPPP` = REPLACE(`PPPP`, '+', '') WHERE `PPPP` LIKE "%+%";
UPDATE `courier` SET `PPPP` = REPLACE(`PPPP`, '-', '') WHERE `PPPP` LIKE "%--%";
UPDATE `courier` SET `PPPP` = REPLACE(`PPPP`, '..', '.') WHERE `PPPP` LIKE "%..%";
UPDATE `courier` SET `PPPP` = '' WHERE `PPPP` = '0000.0';
UPDATE `courier` SET `PPPP` = '' WHERE `PPPP` != '' AND CAST(`PPPP` AS FLOAT) < 900.0;
UPDATE `courier` SET `PPPP` = '' WHERE `PPPP` != '' AND CAST(`PPPP` AS FLOAT) > 1050.0;
UPDATE `courier` SET `PPPP` = CONCAT(`PPPP`,'0') WHERE LENGTH(`PPPP`) = 5 AND `PPPP` LIKE "%.";
UPDATE `courier` SET `PPPP` = CONCAT(SUBSTRING(`PPPP`, 1, 4),'.',SUBSTRING(`PPPP`, 5, 1)) WHERE LENGTH(`PPPP`) = 6 AND `PPPP` LIKE "%.";
UPDATE `courier` SET `PPPP` = CONCAT(SUBSTRING(`PPPP`, 1, 4),'.',SUBSTRING(`PPPP`, 5, 1)) WHERE LENGTH(`PPPP`) = 5 AND `PPPP` NOT LIKE "%.%";
UPDATE `courier` SET `PPPP` = CONCAT('0',`PPPP`) WHERE LENGTH(`PPPP`) < 6 AND `PPPP` LIKE "%.%";
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `P0P0P0P0` = REPLACE(`P0P0P0P0`, '+', '') WHERE `P0P0P0P0` LIKE "%+%";
UPDATE `courier` SET `P0P0P0P0` = REPLACE(`P0P0P0P0`, '-', '') WHERE `P0P0P0P0` LIKE "%--%";
UPDATE `courier` SET `P0P0P0P0` = REPLACE(`P0P0P0P0`, '..', '.') WHERE `P0P0P0P0` LIKE "%..%";
UPDATE `courier` SET `P0P0P0P0` = '' WHERE `P0P0P0P0` = '0000.0';
UPDATE `courier` SET `P0P0P0P0` = '' WHERE `P0P0P0P0` = '00.0';
UPDATE `courier` SET `P0P0P0P0` = '' WHERE `P0P0P0P0` = '00.';
UPDATE `courier` SET `P0P0P0P0` = '' WHERE `P0P0P0P0` != '' AND CAST(`P0P0P0P0` AS FLOAT) < 900.0;
UPDATE `courier` SET `P0P0P0P0` = '' WHERE `P0P0P0P0` != '' AND CAST(`P0P0P0P0` AS FLOAT) > 1050.0;
UPDATE `courier` SET `P0P0P0P0` = CONCAT(`P0P0P0P0`,'0') WHERE LENGTH(`P0P0P0P0`) = 5 AND `P0P0P0P0` LIKE "%.";
UPDATE `courier` SET `P0P0P0P0` = CONCAT(SUBSTRING(`P0P0P0P0`, 1, 4),'.',SUBSTRING(`P0P0P0P0`, 5, 1)) WHERE LENGTH(`P0P0P0P0`) = 6 AND `P0P0P0P0` LIKE "%.";
UPDATE `courier` SET `P0P0P0P0` = CONCAT(SUBSTRING(`P0P0P0P0`, 1, 4),'.',SUBSTRING(`P0P0P0P0`, 5, 1)) WHERE LENGTH(`P0P0P0P0`) = 5 AND `P0P0P0P0` NOT LIKE "%.%";
UPDATE `courier` SET `P0P0P0P0` = CONCAT('0',`P0P0P0P0`) WHERE LENGTH(`P0P0P0P0`) < 6 AND `P0P0P0P0` LIKE "%.%";
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `HSHS1` = REPLACE(`HSHS1`, '+', '');
UPDATE `courier` SET `HSHS1` = REPLACE(`HSHS1`, '.', '');
UPDATE `courier` SET `HSHS1` = REPLACE(`HSHS1`, '-', '');
UPDATE `courier` SET `HSHS1` = CONCAT('0',`HSHS1`) WHERE LENGTH(`HSHS1`) = 1;
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `HSHS2` = REPLACE(`HSHS2`, '+', '');
UPDATE `courier` SET `HSHS2` = REPLACE(`HSHS2`, '.', '');
UPDATE `courier` SET `HSHS2` = REPLACE(`HSHS2`, '-', '');
UPDATE `courier` SET `HSHS2` = CONCAT('0',`HSHS2`) WHERE LENGTH(`HSHS2`) = 1;
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `HSHS3` = REPLACE(`HSHS3`, '+', '');
UPDATE `courier` SET `HSHS3` = REPLACE(`HSHS3`, '.', '');
UPDATE `courier` SET `HSHS3` = REPLACE(`HSHS3`, '-', '');
UPDATE `courier` SET `HSHS3` = CONCAT('0',`HSHS3`) WHERE LENGTH(`HSHS3`) = 1;
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `min` = REPLACE(`min`, '+', '') WHERE `min` LIKE "%+%";
UPDATE `courier` SET `min` = REPLACE(`min`, '--', '-') WHERE `min` LIKE "%--%";
UPDATE `courier` SET `min` = REPLACE(`min`, '..', '.') WHERE `min` LIKE "%..%";
UPDATE `courier` SET `min` = '' WHERE `min` = '00.0' OR `min` = '-00.0';
UPDATE `courier` SET `min` = CONCAT(`min`,'0') WHERE `min` NOT LIKE "%-%" AND LENGTH(`min`) = 3 AND `min` LIKE "%.";
UPDATE `courier` SET `min` = CONCAT(SUBSTRING(`min`, 1, 2),'.',SUBSTRING(`min`, 3, 1)) WHERE `min` NOT LIKE "%-%" AND LENGTH(`min`) = 4 AND `min` LIKE "%.";
UPDATE `courier` SET `min` = CONCAT('0',`min`) WHERE `min` NOT LIKE "%-%" AND LENGTH(`min`) = 3 AND `min` LIKE "%.%";
UPDATE `courier` SET `min` = CONCAT(SUBSTRING(`min`, 1, 3),'.',SUBSTRING(`min`, 4, 1)) WHERE `min` LIKE "-%" AND LENGTH(`min`) = 5 AND `min` LIKE "%.";
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `max` = REPLACE(`max`, '+', '') WHERE `max` LIKE "%+%";
UPDATE `courier` SET `max` = REPLACE(`max`, '--', '-') WHERE `max` LIKE "%--%";
UPDATE `courier` SET `max` = REPLACE(`max`, '..', '.') WHERE `max` LIKE "%..%";
UPDATE `courier` SET `max` = '' WHERE `max` = '00.0' OR `max` = '-00.0';
UPDATE `courier` SET `max` = CONCAT(`max`,'0') WHERE `max` NOT LIKE "%-%" AND LENGTH(`max`) = 3 AND `max` LIKE "%.";
UPDATE `courier` SET `max` = CONCAT(SUBSTRING(`max`, 1, 2),'.',SUBSTRING(`max`, 3, 1)) WHERE `max` NOT LIKE "%-%" AND LENGTH(`max`) = 4 AND `max` LIKE "%.";
UPDATE `courier` SET `max` = CONCAT('0',`max`) WHERE `max` NOT LIKE "%-%" AND LENGTH(`max`) = 3 AND `max` LIKE "%.%";
UPDATE `courier` SET `max` = CONCAT(SUBSTRING(`max`, 1, 3),'.',SUBSTRING(`max`, 4, 1)) WHERE `max` LIKE "-%" AND LENGTH(`max`) = 5 AND `max` LIKE "%.";
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `RH` = '100' WHERE REPLACE(CONCAT(`SN1`,`TTT`), '+', '') = `WB`;
---------------------------------------------------------------------------------------------------------------------------------------
UPDATE `courier` SET `TNTNTN` = `TTT` WHERE `TNTNTN` = '';