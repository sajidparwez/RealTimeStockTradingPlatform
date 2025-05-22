
const { subscribeToTrades, subscribeToOrderBook } = require('./redis/subscriber');

const { matchTrade } = require("./engine/matcher");
const { broadcastTrade } = require("./ws/server");

console.log("✅ Trade Matching Engine is running...");



subscribeToTrades((trade) => {
    console.log("📥 Received Trade:", trade);
    const results = matchTrade(trade);

      results.forEach(({ buy, sell, matchedQty }) => {
        const matchInfo = {
            stock_symbol: buy.stock_symbol,
            price: sell.price,
            quantity: matchedQty,
            buyer_id: buy.user_id,
            seller_id: sell.user_id,
            timestamp: new Date().toISOString(),
        };

        console.log(`✅ Matched:`, matchInfo);

        // 🔔 Broadcast to clients
         broadcastToClients('trade_match', { data: matchInfo });

    });
});

subscribeToOrderBook((orderBookData) => {
    broadcastToClients('order_book', orderBookData);
});
