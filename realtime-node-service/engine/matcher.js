// engine/matcher.js
const buyOrders = [];
const sellOrders = [];

/**
 * Matches a trade order against the existing order book.
 * @param {Object} trade - Trade object (e.g. { user_id, type, stock_symbol, quantity, price })
 * @returns {Array} Array of matched trade details
 */
function matchTrade(trade) {
    const matchedOrders = [];

    if (trade.type === "buy") {
        // Match against lowest priced sell orders
        sellOrders.sort((a, b) => a.price - b.price);

        for (let i = 0; i < sellOrders.length; i++) {
            const sell = sellOrders[i];

            if (sell.price <= trade.price && sell.stock_symbol === trade.stock_symbol) {
                const matchedQty = Math.min(trade.quantity, sell.quantity);
                trade.quantity -= matchedQty;
                sell.quantity -= matchedQty;

                matchedOrders.push({
                    buy: trade,
                    sell: sell,
                    matchedQty,
                });

                if (sell.quantity === 0) sellOrders.splice(i--, 1);
                if (trade.quantity === 0) break;
            }
        }

        if (trade.quantity > 0) buyOrders.push(trade);

    } else if (trade.type === "sell") {
        // Match against highest priced buy orders
        buyOrders.sort((a, b) => b.price - a.price);

        for (let i = 0; i < buyOrders.length; i++) {
            const buy = buyOrders[i];

            if (buy.price >= trade.price && buy.stock_symbol === trade.stock_symbol) {
                const matchedQty = Math.min(trade.quantity, buy.quantity);
                trade.quantity -= matchedQty;
                buy.quantity -= matchedQty;

                matchedOrders.push({
                    buy: buy,
                    sell: trade,
                    matchedQty,
                });

                if (buy.quantity === 0) buyOrders.splice(i--, 1);
                if (trade.quantity === 0) break;
            }
        }

        if (trade.quantity > 0) sellOrders.push(trade);
    }

    return matchedOrders;
}

module.exports = { matchTrade };
