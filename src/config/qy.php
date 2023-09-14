<?php

return [
    'corp_id'                => env('CORP_ID', ""),
    'corp_secret'            => env('CORP_SECRET', ""),
    // 企微消息推送应用
    'corp_msg_secret'        => env('CORP_MSG_SECRET', ''),
    'agent_id'               => env('AGENT_ID', ""),
    'encoding_aes_key'       => env('ENCODING_AES_KEY', ""),
    'token'                  => env('TOKEN', ""),
    'join_training_group_id' => env('JOIN_TRAINING_GROUP_ID', ""),
];