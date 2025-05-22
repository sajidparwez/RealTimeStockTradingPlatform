// Simulate some buy/sell orders
const getOrderBook = () => {
    const buy = [
        { price: 101.5, quantity: 40 },
        { price: 101.0, quantity: 70 }
    ];
    const sell = [
        { price: 102.0, quantity: 35 },
        { price: 102.5, quantity: 60 }
    ];

    return { buy, sell };
};

module.exports = { getOrderBook };
