# 📈 Scalable Real-Time Stock Market Trading Platform

A full-stack, real-time trading simulation platform demonstrating order placement, matching engine, and live market data using Laravel, Node.js, Redis, and WebSockets.

---

## 🚀 Features

- 🔄 Real-time buy/sell order book
- ✅ Order placement with Laravel API (Passport-authenticated)
- ⚙️ Matching engine using Node.js
- 📡 Live updates with Redis Pub/Sub & WebSockets
- 💾 Persistent storage via PostgreSQL
- ⚡ Redis caching & RabbitMQ for trade execution
- 📊 React frontend dashboard

---

## 🏗️ Architecture
----------------------
Frontend (React)
↓ WebSocket (port 8081)
Node.js Microservices
├── Redis Subscriber (order_book, trades)
├── Matching Engine
└── WebSocket Broadcaster
↑
Laravel (PHP 8.2, Laravel 12)
├── REST API (Laravel Passport)
├── Publishes to Redis (order_book)
└── Handles user auth, wallet, transactions







---------------------------------------------


---

## 📦 Tech Stack

| Layer      | Technology |
|------------|------------|
| Frontend   | React.js |
| Backend    | Laravel 12 (PHP 8.2) |
| Real-Time  | Node.js, WebSockets |
| Messaging  | Redis Pub/Sub, RabbitMQ |
| DB         | PostgreSQL, Redis |
| Auth       | Laravel Passport |
| Deployment | Docker / AWS / GCP (suggested) |

---

## 🧰 Folder Structure

project-root/
│
├── backend/ # Laravel app (API + Redis publisher)
│
├── microservices/ # Node.js real-time components
│ ├── redis/
│ │ └── subscriber.js # Redis → WebSocket
│ ├── matcher.js # Matching logic
│ └── server.js # WebSocket broadcaster
│
├── trading-dashboard/ # React.js Frontend
│ ├── src/components/OrderBook.js
│ └── ...


--------------------------------------



---

## 📡 WebSocket Events

| Event Type    | Payload Data       |
|---------------|--------------------|
| `order_book`  | `{ buy: [], sell: [] }` |
| `trade_match` | `{ buy_order, sell_order }` |

---

## 🧪 Testing the Flow

1. Start Redis: `redis-server`
2. Run Laravel Backend: `php artisan serve`
3. Run Node Microservices:
   ```bash
   node server.js
   node redis/subscriber.js
--------------------------------------------------


When you place an order via Laravel API, it:

Publishes the updated order book to Redis.

Node.js picks it up, broadcasts via WebSocket.

React dashboard updates in real-time.