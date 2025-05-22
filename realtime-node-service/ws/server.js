const WebSocket = require('ws');

const wss = new WebSocket.Server({ port: 8081 });
const clients = new Set();

wss.on('connection', (ws) => {
    console.log('🔌 WebSocket Client Connected');
    clients.add(ws);

    ws.on('close', () => {
        clients.delete(ws);
        console.log('❌ WebSocket Client Disconnected');
    });
});

// const broadcastTrade = (tradeData) => {
//     const payload = JSON.stringify({ type: 'trade_match', data: tradeData });
//     for (const client of clients) {
//         if (client.readyState === WebSocket.OPEN) {
//             client.send(payload);
//         }
//     }
// };


const broadcastToClients = (type, data) => {
    const payload = JSON.stringify({ type, ...data });
    for (const client of clients) {
        if (client.readyState === WebSocket.OPEN) {
            client.send(payload);
        }
    }
};



module.exports = { broadcastToClients };
