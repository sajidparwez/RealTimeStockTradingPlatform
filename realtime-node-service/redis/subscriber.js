// redis/subscriber.js
const Redis = require("ioredis");

// Create Redis subscriber connection
const redis = new Redis(); // defaults to localhost:6379

const subscribeToTrades = (onTradeReceived) => {


    redis.subscribe("trades", (err, count) => {
        if (err) {
            console.error("❌ Redis subscribe error", err);
        } else {
            console.log(`📡 Subscribed to ${count} channel(s): trades`);
        }
    });

    redis.on("message", (channel, message) => {
        if (channel === "trades") {
            try {
                const trade = JSON.parse(message);
                onTradeReceived(trade);
            } catch (e) {
                console.error("❌ Failed to parse trade message:", e);
            }
        }


    });
};


const subscribeToOrderBook = (onOrderBookReceived) => {
    redis.subscribe("order_book", (err, count) => {
        if (err) {
            console.error("❌ Redis subscribe error", err);
        } else {
            console.log(`📡 Subscribed to ${count} channel(s): order_book`);
        }
    });

    redis.on("message", (channel, message) => {
        if (channel === "order_book") {
            try {
                const orderBook = JSON.parse(message);
                onOrderBookReceived(orderBook);
            } catch (e) {
                console.error("❌ Failed to parse order book message:", e);
            }
        }
    });
};


module.exports = {
    subscribeToTrades,
    subscribeToOrderBook, 
};
