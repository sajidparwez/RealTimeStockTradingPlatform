const Redis = require("ioredis");
const { getOrderBook } = require("./orderBookFetcher");

const redis = new Redis(); // default localhost:6379

const publishOrderBook = () => {
    const orderBook = getOrderBook();

    redis.publish("order_book", JSON.stringify({
        type: "order_book",
        ...orderBook
    }));

    console.log("📤 Published order book");
};

// Run every 3 seconds
setInterval(publishOrderBook, 3000);
