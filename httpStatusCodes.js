module.exports = {
    Informational: {
        Continue: {
            code: 100,
            codeText: '100',
            description: 'Continue'
        },
        switchingProtocols: {
            code: 101,
            codeText: '101',
            description: 'Switching Protocols'
        },
        processing: {
            code: 102,
            codeText: '102',
            description: 'Processing'
        },
        earlyHints: {
            code: 103,
            codeText: '103',
            description: 'Early Hints'
        }
    },
    Success: {
        success: {
            code: 200,
            codeText: '200',
            description: 'success'
        },
        ok: {
            code: 200,
            codeText: '200',
            description: 'OK'
        },
        created: {
            code: 201,
            codeText: '201',
            description: 'Created'
        },
        accepted: {
            code: 202,
            codeText: '202',
            description: 'Accepted'
        },
        nonAuthoritativeInformation: {
            code: 203,
            codeText: '203',
            description: 'Non-Authoritative Information'
        },
        noContent: {
            code: 204,
            codeText: '204',
            description: 'No Content'
        },
        resetContent: {
            code: 205,
            codeText: '205',
            description: 'Reset Content'
        },
        partialContent: {
            code: 206,
            codeText: '206',
            description: 'Partial Content'
        },
        multiStatus: {
            code: 207,
            codeText: '207',
            description: 'Multi-Status'
        },
        alreadyReported: {
            code: 208,
            codeText: '208',
            description: 'Already Reported'
        },
        imUsed: {
            code: 226,
            codeText: '226',
            description: ' IM Used'
        }
    },
    Redirection: {
        multipleChoices: {
            code: 300,
            codeText: '300',
            description: 'Multiple Choices'
        },
        movedPermanently: {
            code: 301,
            codeText: '301',
            description: 'Moved Permanently'
        },
        found: {
            code: 302,
            codeText: '302',
            description: 'Found (Previously "Moved temporarily")'
        },
        seeOther: {
            code: 303,
            codeText: '303',
            description: 'See Other (since HTTP/1.1)'
        },
        notModified: {
            code: 304,
            codeText: '304',
            description: 'Not Modified (RFC 7232)'
        },
        useProxy: {
            code: 305,
            codeText: '305',
            description: 'Use Proxy (since HTTP/1.1)'
        },
        switchProxy: {
            code: 306,
            codeText: '306',
            description: 'Switch Proxy'
        },
        temporaryRedirect: {
            code: 307,
            codeText: '307',
            description: 'Temporary Redirect (since HTTP/1.1)'
        },
        permanentRedirect: {
            code: 308,
            codeText: '308',
            description: 'Permanent Redirect (RFC 7538)'
        },
    },
    ClientErrors: {
        badRequest: {
            code: 400,
            codeText: '400',
            description: 'Bad Request'
        },
        unauthorized: {
            code: 401,
            codeText: '401',
            description: 'Unauthorized'
        },
        paymentRequired: {
            code: 402,
            codeText: '402',
            description: 'Payment Required'
        },
        forbidden: {
            code: 403,
            codeText: '403',
            description: 'Forbidden'
        },
        notFound: {
            code: 404,
            codeText: '404',
            description: 'Not Found'
        },
        methodNotAllowed: {
            code: 405,
            codeText: '405',
            description: 'Method Not Allowed'
        },
        notAcceptable: {
            code: 406,
            codeText: '406',
            description: 'Not Acceptable'
        },
        proxyAuthenticationRequired: {
            code: 407,
            codeText: '407',
            description: 'Proxy Authentication Required'
        },
        requestTimeout: {
            code: 408,
            codeText: '408',
            description: 'Request Timeout'
        },
    },
    Fail: {
        err: {
            code: 500,
            codeText: '500',
            description: 'ERROR'
        },
        notImplemented: {
            code: 501,
            codeText: '501',
            description: 'Not Implemented'
        },
        badGateway: {
            code: 502,
            codeText: '502',
            description: 'Bad Gateway'
        },
        serviceUnavailable: {
            code: 503,
            codeText: '503',
            description: 'Service Unavailable'
        },
        gatewayTimeout: {
            code: 504,
            codeText: '504',
            description: 'Gateway Timeout'
        },
        httpVersionNotSupported: {
            code: 505,
            codeText: '505',
            description: 'HTTP Version Not Supported'
        },
        variantAlsoNegotiates: {
            code: 506,
            codeText: '506',
            description: ' Variant Also Negotiates'
        },
        insufficientStorage: {
            code: 507,
            codeText: '507',
            description: 'Insufficient Storage '
        },
        loopDetected: {
            code: 508,
            codeText: '508',
            description: ' Loop Detected'
        },
        notExtended: {
            code: 510,
            codeText: '510',
            description: 'Not Extended'
        },
        networkAuthenticationRequired: {
            code: 511,
            codeText: '511',
            description: 'Network Authentication Required'
        },
        fail: {
            code: 202,
            codeText: '202',
            description: 'Data Not Found'
        },
    }
}