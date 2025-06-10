module.exports = {
    insertSuccess: {
        code: 200,
        description: 'Insert data success',
        codeText: '200'
    },
    insertError: {
        code: 500,
        description: 'Insert data error',
        codeText: '500'
    },
    updateSuccess: {
        code: 200,
        description: 'Updata data success',
        codeText: '200'
    },
    updateFail: {
        code: 202,
        description: 'Update data failed',
        codeText: '202'
    },
    updateError: {
        code: 500,
        description: 'Updata data error',
        codeText: '500'
    },
    querySuccess: {
        code: 200,
        description: 'Find data success',
        codeText: '200'
    },
    queryFail: {
        code: 202,
        description: 'Find data not found',
        codeText: '202'
    },
    queryError: {
        code: 500,
        description: 'Find data error',
        codeText: '500'
    },
    tokenInvalid: {
        code: 401,
        description: 'Invalid token',
        codeText: '401'
    },
    tokenFail: {
        code: 404,
        description: 'Token not found',
        codeText: '404'
    },
    invalidData: {
        code: 400,
        description: 'Invalid data',
        codeText: '400'
    },
    connect_to_in_wallet_fail: {
        code: 601,
        description: 'Connect to API Insert transection wallet failed',
        codeText: '601'
    },
    connect_to_main_wallet_fail: {
        code: 602,
        description: 'Connect to API Insert/Update main wallet failed',
        codeText: '602'
    },
    connect_to_cancel_wallet_fail: {
        code: 603,
        description: 'Connect to API Cancel transection wallet failed',
        codeText: '603'
    },
    connect_to_query_wallet_fail: {
        code: 604,
        description: 'Connect to API Query transection wallet failed',
        codeText: '604'
    },
    connect_to_update_game_wallet_fail: {
        code: 604,
        description: 'Connect to API  Update game wallet failed',
        codeText: '604'
    },
    connect_to_query_game_wallet_fail: {
        code: 604,
        description: 'Connect to API Query game wallet failed',
        codeText: '604'
    },
    connect_to_aap_fail: {
        code: 604,
        description: 'Connect to API Archive Promotion failed',
        codeText: '604'
    },
    statusPromotionNew: {
        code: 001,
        description: 'New',
        codeText: '001'
    },
    statusPromotionPublish: {
        code: 002,
        description: 'Publish',
        codeText: '002'
    },
    statusPromotionOutofLimits: {
        code: 003,
        description: 'Out of Limits',
        codeText: '003'
    },
    statusPromotionExpired: {
        code: 004,
        description: 'Expired',
        codeText: '004'
    },
    statusPromotionReciveWaiting: {
        code: 000,
        description: 'Waiting Promotion Recieve',
        codeText: '000'
    },
    statusPromotionReciveUse: {
        code: 200,
        description: 'Use Promotion Recieve',
        codeText: '200'
    },
    statusPromotionReciveReject: {
        code: 300,
        description: 'Reject Promotion Recieve',
        codeText: '300'
    },
}
