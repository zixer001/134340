const orgLog = console.log;
const logs = [];
const MAX_LINES = 200;

function nowAsString() {
    return new Date()
        .toLocaleString("en-US", {
            timeZoneName: "short",
            timeZone: `Asia/Bangkok`,
            hour12: false,
        })
        .replace(
            /(\d?\d\/\d?\d\/\d{4})\,\s(\d{1,2}\:\d{1,2}\:\d{1,2})\sGMT\+\d/,
            "$2"
        );
}
logs.reverse();

console.log = function(...oths) {
    // logs.reverse();
    oths.unshift(`[${nowAsString()}]`);
    orgLog(...oths);
    logs.unshift(oths.join(" "));



    if (logs.length > MAX_LINES) logs.pop();
};



module.exports = logs