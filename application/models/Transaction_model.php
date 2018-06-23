<?php

/**
 * @author trungdn
 * @copyright 2018
 */

class Transaction_model extends CI_Model
{

    // Declaration of a variables
    private $_userID;
    private $_fromAddr;
    private $_toAddr;
    private $_total;
    private $_fee;
    private $_subtotal;
    private $_coin_type;
    private $_buy_by;
    private $_amount_currency_buy;
    private $_bonus;
    private $_status;
    private $_trans_fee;
    private $_trans_id;
    private $_trans_type;
    private $_refund_for_trans;

    public function __construct()
    {
        parent::__construct();
    }

    // get all refs
    public function getAll()
    {
        return $this->mongo_db->get('transactions');
    }

    public function create($data)
    {
        $this->mongo_db->insert('transactions', $data);
        return true;
    }

    public function update($tranId, $data)
    {
        if ($data['status'] == 'pending') $data['status'] = 1;
        if ($data['status'] == 'success') $data['status'] = 2;
        if ($data['status'] == 'failed') $data['status'] = 3;
        if ($data['status'] == 'wait-confirm-refund') $data['status'] = 4;
        
        return $this->mongo_db->set($data)
            ->where('trans_id', $tranId)
            ->update('transactions');
    }

    public function getTokenTransactions($userId)
    {
        return $this->mongo_db->where('user_id', $userId)
            ->where('coin_type', 'token')
            ->get('transactions');
    }

    public function getTransactions($userId, $type)
    {
        return $this->mongo_db->where('user_id', $userId)
            ->where('coin_type', $type)
            ->get('transactions');
    }

    public function getPendingTransactions()
    {
        return $this->mongo_db->where('status', 1)->get('transactions');
    }    

    public function countToken()
    {
        $fromDate = new DateTime('2018-06-13 00:00:00');
        $toDate = new DateTime('2020-06-30 23:59:59');
        $pipeline = [
            [
                '$match' => [
                    'created_at' => [
                        '$gte' => new \MongoDB\BSON\UTCDateTime($fromDate->getTimestamp() * 1000),
                        '$lte' => new \MongoDB\BSON\UTCDateTime($toDate->getTimestamp() * 1000)
                    ]
                ]
            ],
            [
                '$group' => [
                    '_id' => [
                        '$dateToParts' => ['date' => '$created_at']
                    ],
                    'token_buy' => ['$sum' => [
                        '$cond' => [
                            [
                                '$eq' => ['$coin_type', 'token']
                            ],
                            '$total',
                            0
                        ]
                    ]],
                    'btc_deposit' => ['$sum' => [
                        '$cond' => [
                            [
                                '$and' => [
                                    ['$eq' => ['$coin_type', 'btc']],
                                    ['$eq' => ['$trans_type', 2]]
                                ]
                            ],
                            '$total',
                            0
                        ]
                    ]],
                    'btc_withdraw' => ['$sum' => [
                        '$cond' => [
                            [
                                '$and' => [
                                    ['$eq' => ['$coin_type', 'btc']],
                                    ['$eq' => ['$trans_type', 3]]
                                ]
                            ],
                            '$total',
                            0
                        ]
                    ]],
                    'eth_deposit' => ['$sum' => [
                        '$cond' => [
                            [
                                '$and' => [
                                    ['$eq' => ['$coin_type', 'eth']],
                                    ['$eq' => ['$trans_type', 2]]
                                ]
                            ],
                            '$total',
                            0
                        ]
                    ]],
                    'eth_withdraw' => ['$sum' => [
                        '$cond' => [
                            [
                                '$and' => [
                                    ['$eq' => ['$coin_type', 'eth']],
                                    ['$eq' => ['$trans_type', 3]]
                                ]
                            ],
                            '$total',
                            0
                        ]
                    ]],
                    'ltc_deposit' => ['$sum' => [
                        '$cond' => [
                            [
                                '$and' => [
                                    ['$eq' => ['$coin_type', 'ltc']],
                                    ['$eq' => ['$trans_type', 2]]
                                ]
                            ],
                            '$total',
                            0
                        ]
                    ]],
                    'ltc_withdraw' => ['$sum' => [
                        '$cond' => [
                            [
                                '$and' => [
                                    ['$eq' => ['$coin_type', 'ltc']],
                                    ['$eq' => ['$trans_type', 3]]
                                ]
                            ],
                            '$total',
                            0
                        ]
                    ]],
                    'bch_deposit' => ['$sum' => [
                        '$cond' => [
                            [
                                '$and' => [
                                    ['$eq' => ['$coin_type', 'bch']],
                                    ['$eq' => ['$trans_type', 2]]
                                ]
                            ],
                            '$total',
                            0
                        ]
                    ]],
                    'bch_withdraw' => ['$sum' => [
                        '$cond' => [
                            [
                                '$and' => [
                                    ['$eq' => ['$coin_type', 'bch']],
                                    ['$eq' => ['$trans_type', 3]]
                                ]
                            ],
                            '$total',
                            0
                        ]
                    ]]
                ]
            ]
        ];
        $options = [
            'cursor' => [ 'batchSize' => 0 ],
            'allowDiskUse' => true
        ];
        return $this->mongo_db->aggregate('transactions', $pipeline, $options);
    }

}
