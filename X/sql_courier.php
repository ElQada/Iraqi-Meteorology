UPDATE `courier` SET `RRR` = '' WHERE `time` NOT IN('06','18');
UPDATE `courier` SET `TR` = '' WHERE `time` NOT IN('06','18');
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `WW` = '' WHERE `WW` = '00';
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `VP` = '' WHERE `VP` = '00.0';
UPDATE `courier` SET `TTT` = '' WHERE `TTT` = '00.0';
UPDATE `courier` SET `TDTDTD` = '' WHERE `TDTDTD` = '00.0';
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `TNTNTN` = '' WHERE `time` NOT IN('06','18');
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `WB` = '' WHERE `WB` = '00.0';
/* --------------------------------------------------------------------------------------------------------------------------------------- */
UPDATE `courier` SET `RH` = '' WHERE `RH` = '00';


UPDATE `courier` SET `P0P0P0P0` = '' WHERE `P0P0P0P0` = '0000.0' OR `P0P0P0P0` LIKE "%/%";
UPDATE `courier` SET `PPPP` = '' WHERE `PPPP` = '0000.0' OR `PPPP` LIKE "%/%";



UPDATE `courier` SET `PPP` = '' WHERE `PPP` LIKE "%/%";
UPDATE `courier` SET `PPPP` = '' WHERE `PPPP` LIKE "%/%";
UPDATE `courier` SET `P0P0P0P0` = '' WHERE `P0P0P0P0` LIKE "%/%";



UPDATE `courier` SET `NS1` = '',`C1` = '',`HSHS1` = '',`NS2` = '',`C2` = '',`HSHS2` = '',`NS3` = '',`C3` = '',`HSHS3` = '' WHERE (`NH` = '0' OR `NH` = '') AND (`CL` = '0' OR `NH` = '') AND (`CM` = '0' OR `NH` = '') AND (`CH` = '0' OR `NH` = '');



UPDATE `courier` SET `max` = '' WHERE `max` = '00.0' OR `max` = '00' OR `max` = '0' OR `max` = '0.0' OR `max` = '000' OR `max` = '000.0';
UPDATE `courier` SET `min` = '' WHERE `min` = '00.0' OR `min` = '00' OR `min` = '0' OR `min` = '0.0' OR `min` = '000' OR `min` = '000.0';