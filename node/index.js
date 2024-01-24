const express = require('express');
const http = require('http');
const socketIO = require('socket.io');
const cors = require('cors');

const app = express();
app.use(cors());
const server = http.createServer(app);

const io = socketIO(server, {
    cors: {
      origin: "*", // Permitir todos los orígenes
      methods: ["GET", "POST"]
    }
  });

io.on('connection', (socket) => {
  console.log('Un cliente se ha conectado');
 
  // Emitir un evento con el ID del socket
  socket.emit('connected', { id: socket.id });
});

server.listen(3002, () => {
    console.log('Servidor corriendo en puerto 3002');
  });
