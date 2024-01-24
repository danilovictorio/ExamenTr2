<template>
    <div>
      <p v-if="socketId">Conectado con el ID de socket: {{ socketId }}</p>
      <h1>Registrate</h1>
      <label for="name">Nombre de usuario</label>
      <input type="text" id="name" v-model="name" />
      <label for="name">Email:</label>
      <input type="text" id="email" v-model="email" />
      <label for="password">Contraseña</label>
      <input type="password" id="password" v-model="password" />
      <button @click="registerUser">Registrarse</button>

        <h1>Iniciar sesión</h1>
      <label for="loginEmail">Email:</label>
      <input type="text" id="loginEmail" v-model="loginEmail" />
      <label for="loginPassword">Contraseña:</label>
      <input type="password" id="loginPassword" v-model="loginPassword" />
      <button @click="login">Iniciar sesión</button>
      <p v-if="loginSuccessMessage">{{ loginSuccessMessage }}</p>
    </div>
    
  </template>
  <script>
  import io from "socket.io-client";
  
  export default {
    data() {
      return {
        socket: null,
        socketId: null,
        name: "",
        email: "",
        password: "",
        token: null,
        loginEmail: "",
        loginSuccessMessage: "",
        loginPassword: "",
      };
    },
    methods: {
        async login() {
        try {
          const response = await fetch("http://localhost:8000/login", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              email: this.loginEmail,
              password: this.loginPassword,
            }),
            credentials: "include",
          });
  
          if (!response.ok) {
            throw new Error("Response is not ok");
          }
  
          const data = await response.json();
  
          // Puedes realizar acciones adicionales después de iniciar sesión, si es necesario
  
          this.loginSuccessMessage = "¡Inicio de sesión exitoso!";
        } catch (error) {
          console.error("Error al iniciar sesión:", error);
        }
      },
      async logout() {
    try {
        const response = await fetch("http://localhost:8000/logout", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${this.token}`,
                "X-XSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            credentials: "include",
        });

        if (!response.ok) {
            throw new Error("Response is not ok");
        }

        const data = await response.json();

        // Resto del código para el logout

    } catch (error) {
        console.error("Error al cerrar sesión:", error);
    }
},

      async registerUser() {
        try {
          const response = await fetch("http://localhost:8000/register", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              name: this.name,
              email: this.email,
              password: this.password,
            }),
            credentials: "include",
          });
  
          console.log("Response:", response);
  
          if (!response.ok) {
            throw new Error("Response is not ok");
          }
  
          const data = await response.json();
  
          this.token = data.token;

  
        } catch (error) {
          console.error("Error al registrar el usuario:", error);
        }
      },
      
    },
    created() {
      this.socket = io("http://localhost:3002"); // Asegúrate de reemplazar esto con la URL de tu servidor
  
      this.socket.on("connect", () => {
        console.log("Conectado al servidor de sockets");
      });
  
      this.socket.on("connected", (data) => {
        this.socketId = data.id;
      });
  
      this.socket.on("disconnect", () => {
        console.log("Desconectado del servidor de sockets");
        this.socketId = null;
      });
    },
    beforeDestroy() {
      if (this.socket) {
        this.socket.disconnect();
      }
    },
  };
  </script>
  