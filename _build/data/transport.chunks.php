<?php

$chunks = array();

$chunks[1]= $modx->newObject('modChunk');
$chunks[1]->fromArray(array(
    'id' => 1,
    'name' => 'importUsersHelp',
    'description' => 'Help screen for Import Users Page',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/importusershelp.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[2]= $modx->newObject('modChunk');
$chunks[2]->fromArray(array(
    'id' => 2,
    'name' => 'importUsersHelpTableRow',
    'description' => 'Single Row (field and note) in the Import Users Help screen',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/importusershelptablerow.chunk.tpl'),
    'properties' => '',
),'',true,true);

$chunks[3]= $modx->newObject('modChunk');
$chunks[3]->fromArray(array(
    'id' => 3,
    'name' => 'importUsersSettingsTableRow',
    'description' => 'Single Row (setting and value) in the Import Users Help screen',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/importuserssettingstablerow.chunk.tpl'),
    'properties' => '',
),'',true,true);

return $chunks;


